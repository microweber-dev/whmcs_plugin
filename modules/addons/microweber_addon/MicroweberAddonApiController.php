<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use WHMCS\Product\Product as Product;

include_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers.php';


class MicroweberAddonApiController
{

    public function check_connection($params = false)
    {
        return $params;
    }

    public function get_logged_user_id()
    {
        global $_SESSION;
        if (isset($_SESSION['uid'])) {
            $json = [];
            $json['uid'] = $_SESSION['uid'];

            echo json_encode($json, JSON_PRETTY_PRINT);
            exit;
        }

        exit;
    }

    public function verify_login_code()
    {
        if (!isset($_GET['domain']) || !isset($_GET['code'])) {
            return;
        }

        header('Content-Type: application/json');

        $code = $_GET['code'];
        $domain = $_GET['domain'];

        $check = Capsule::table('mod_microweber_code_login')->where('code', $code)->where('domain', $domain)->first();
        if (empty($check)) {
            die(json_encode(['error'=>true, 'message'=>'Domain and code is not valid.']));
        }
        
        // Delete all codes
        Capsule::table('mod_microweber_code_login')->where('domain', $domain)->delete();
        if ($check) {
            die(json_encode(['success'=>true, 'code'=>$code]));
        }

        return;

    }

    public function show_ads_bar()
    {

        $css = '
        <style>
    @import url("https://fonts.googleapis.com/css?family=Montserrat+Alternates:400,600,700&display=swap&subset=cyrillic");

    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        font-family: "Montserrat Alternates", sans-serif;
    }

    .mw-ads-holder {
        background: #fff;
        z-index: 99999;
        padding: 4px 7px;
        position: absolute;
        min-height: 54px;
        border: 0;
        left: 0;
        right: 0;
        top: 0;
        width: 100%;
        overflow: hidden;
        border-bottom: 1px solid #f1f3f4;
        color: #2d2d2d;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
    }

    .mw-ads-holder p {
        margin: 0;
        margin-top: 2px;
    }

    .mw-ads-holder .row {
        display: block;
    }

    .mw-ads-holder .row:after {
        display: block;
        content: "";
        clear: both;
    }

    .mw-ads-holder .row .col {
        float: left;
    }

    .mw-ads-holder .row .col:nth-child(1) {
        padding: 10px 0 10px 10px;
        width: calc(100% - 210px);
    }

    .mw-ads-holder .row .col:nth-child(2) {
        padding: 13px 10px 13px 0;
        width: 210px;
    }

    .mw-ads-holder .text-right {
        text-align: right;
    }

    .mw-ads-holder img {
        float: left;
        margin-right: 15px;
    }

    .mw-ads-holder a {
        color: #1717ff;
        text-decoration: none !important;
        border: 1px solid #1717ff;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        border-radius: 50px;
        padding: 8px 14px;
    }
    
    .mw-ads-holder:hover a {
        color: #fff;
        background: #1717ff;
    }

    @media screen and (min-width: 451px) and (max-width: 767px) {
        .hidden-sm {
            display: none;
        }
    }

    @media screen and (max-width: 450px) {
        .hidden-xs {
            display: none;
        }
    }
</style>
                ';

        $html = '<div class="mw-ads-holder" onclick="window.open(\''.site_url().'\', \'_blank\');"><div class="row">
    <div class="col"><img src="./modules/addons/microweber_addon/mw_logo.png" alt="" /> <p class="hidden-xs"><span class="hidden-sm">This website is created with </span> <strong>'.$this->branding_get_company_name().'</strong> <span class="hidden-sm">website builder</span></p></div>
    <div class="col text-right"><a href="javascript:;" onclick="window.open(\''.site_url().'\', \'_blank\');">Create a website</a></div>
    </div></div>';

        echo $css . $html;
        exit;
    }

    public function check_domain_is_premium($request)
    {

        $json = array();
        $json['domain'] = false;

        $parse_domain = @parse_url($request['domain']);

        if (isset($parse_domain['host'])) {
            $host = $parse_domain['host'];
        } else {
            $host = $request['domain'];
        }
        $host = str_ireplace('www.', '', $host);

        $hostingProduct = Capsule::table('tblhosting')->where('domain', '=', $host)->first();

        $free = false;

        if ($hostingProduct) {

            if ($hostingProduct->billingcycle == 'Free Account') {
                $free = false;
            }

            $json['domain'] = $host;
            $json['ads_bar_url'] = 'index.php?m=microweber_addon&function=show_ads_bar';

        }

        $json['free'] = $free;

        echo json_encode($json, JSON_PRETTY_PRINT);
        exit;
    }

    public function validate_license($request)
    {
        include_once ROOTDIR . "/modules/servers/licensing/licensing.php";


        $json = [];
        $licenseKey = false;
        if (isset($request['license_key']) && !empty($request['license_key'])) {
            $licenseKey = $request['license_key'];
        }

        if ($licenseKey) {

            $checkLicense = Capsule::table('mod_licensing')->where('licensekey', $licenseKey)->first();
            if ($checkLicense) {

                if ($checkLicense->status == 'Active' || $checkLicense->status == 'Reissued') {
                    $checkHosting = Capsule::table('tblhosting')->where('id', $checkLicense->serviceid)->first();



                    $json['license_id'] = $checkLicense->id;
                    $json['service_id'] = $checkLicense->serviceid;
                    $json['package_id'] = $checkHosting->packageid;
                    $json['valid_domain'] = $checkLicense->validdomain;
                    $json['valid_ip'] = $checkLicense->validip;
                    $json['last_access'] = $checkLicense->lastaccess;
                    $data2 = [];



                    if (function_exists('licensing_ClientArea')) {
                        $data2 = licensing_ClientArea(
                            [
                                'model' => $checkHosting,
                                'serviceid' => $checkLicense->serviceid,
                            ]
                        );
                    }
                    if(isset($data2['templateVariables'])){
                        if(isset($data2['templateVariables']['allowreissues'])){
                          //  $json['allow_reissues'] = $data2['templateVariables']['allowreissues'];
                        }
                        if(isset($data2['templateVariables']['allowDomainConflicts'])){
                        //    $json['allow_domain_conflicts'] = $data2['templateVariables']['allowDomainConflicts'];
                        }
                        if(isset($data2['templateVariables']['allowIpConflicts'])){
                         //   $json['allow_ip_conflicts'] = $data2['templateVariables']['allowIpConflicts'];
                        }
                    }



                     $json['status'] = 'success';
                } else {
                    $json['message'] = 'License not active.';
                    $json['status'] = 'failed';
                }
            } else {
                $json['message'] = 'License not found.';
                $json['status'] = 'failed';
            }
        } else {
            $json['message'] = 'Missing parameter.';
            $json['status'] = 'failed';
        }

        echo json_encode($json, JSON_PRETTY_PRINT);
        exit;
    }

    public function validate_login($request)
    {

        $isOk = false;
        $json = array();

        if (isset($request['username']) && isset($request['password'])) {

            $command = 'ValidateLogin';
            $postData = array(
                'email' => $request['username'],
                'password2' => $request['password'],
            );

            $login = localAPI($command, $postData);

            if (isset($login['result']) && $login['result'] == 'success') {
                $isOk = true;
            }
        }

        if ($isOk) {
            $json['message'] = 'Login success.';
            $json['result'] = 'success';
        } else {
            $json['message'] = 'Username and password is not valid.';
            $json['result'] = 'failed';
        }

        echo json_encode($json, JSON_PRETTY_PRINT);
        die();
    }

    public function login_to_my_website($params)
    {


        $the_request = $params;


        if (!isset($the_request['email']) and isset($the_request['username'])) {
            $the_request['email'] = $the_request['username'];
        }

        if (!isset($the_request['email']) or !isset($the_request['password2']) or !isset($the_request['domain'])) {
            return;
        }


        $parsedom = @parse_url($the_request['domain']);

        if (isset($parsedom['host'])) {
            $host = $parsedom['host'];
        } else {
            $host = $the_request['domain'];
        }
        $host = str_ireplace('www.', '', $host);


        $values = array();
        $values["email"] = $the_request['email'];

        $values["password2"] = $the_request['password2'];
        $validatelogin = localAPI('validatelogin', $values);


        if (!isset($validatelogin['userid'])) {
            $values = array();
            $values["email"] = $the_request['email'];
            $values["password2"] = $the_request['password2'];
            $validatelogin = localAPI('validatelogin', $values);

        }
        if (!isset($validatelogin['userid'])) {
            $hostingProduct = Capsule::table('tblhosting')
                ->where('domain', '=', $host)->first();


            if ($hostingProduct->id and $hostingProduct->password) {

                $command = 'DecryptPassword';
                $postData = array(
                    'password2' => $hostingProduct->password,
                );

                $results_passwd = localAPI($command, $postData);

                if (isset($results_passwd['password']) and $the_request['password2'] == $results_passwd['password']) {

                    $validatelogin['userid'] = $hostingProduct->userid;
                } else if (!isset($results_passwd['password'])) {
                    return;
                } else {
                    // $validatelogin['userid'] = $hostingProduct->userid;
                }


                // print_r($results_passwd);


            }
        }


//        var_dump($validatelogin);
//        exit;

        if (isset($validatelogin['result']) and $validatelogin['result'] == 'error' and !isset($validatelogin['userid'])) {
            return;
        }

        if (!isset($validatelogin['userid'])) {
            return;
        }


        $command = "getclientsproducts";
        $values = array();
        $values["clientid"] = $validatelogin['userid'];
        $values["limitnum"] = 99999;

        $results = localAPI($command, $values);


        if (!empty($results) and isset($results['products'])) {
            $products = $results['products']['product'];
            if (!empty($products)) {
                foreach ($products as $product) {

                    if (!empty($product) and isset($product['domain'])) {

                        if (strtolower($host) == strtolower($product['domain'])) {
                            $values = array();
                            $values["result"] = 'success';
                            $values["userid"] = $validatelogin['userid'];
                            $values["hosting_data"] = $product;

                            return $values;
                        }
                    }


                }


            }

        }

    }

    function get_package_manager_urls()
    {
        $connector = new MicroweberAddon\MarketplaceConnector();

        return $connector->getPackagesUrls();

    }


    function get_domain_template_config($params)
    {
        global $CONFIG;
        global $autoauthkey;
        if (!isset($params['domain'])) {
            return;
        }


        $username = $this->__db_escape_string($params['domain']);
        $username = addslashes($username);

//        $query = "
//select
//  c.id AS userid, h.id AS serviceid, pcos.optionname AS template
//FROM
//  tblhosting h, tblclients c, tblproducts p, tblproductconfigoptionssub pcos, tblproductconfigoptions pco, tblhostingconfigoptions hco
//WHERE
//  pcos.configid = pco.id AND
//  hco.configid = pco.id AND
//  hco.optionid = pcos.id AND
//  hco.relid = h.id AND
//  c.id = h.userid AND
//  p.id = h.packageid AND
//h.domain = '" . $username . "' and
//  pco.optionname = 'Template'  limit 1";



        $query = "
select
  c.id AS userid, h.id AS serviceid, pcos.optionname AS template
FROM
  tblhosting h, tblclients c, tblproducts p, tblproductconfigoptionssub pcos, tblproductconfigoptions pco, tblhostingconfigoptions hco
WHERE
  pcos.configid = pco.id AND
  hco.configid = pco.id AND
  hco.optionid = pcos.id AND
  hco.relid = h.id AND
  c.id = h.userid AND
  p.id = h.packageid AND
h.domain = '" . $username . "' and
  pco.optionname = 'Template'  limit 1";


//        $query = "SELECT
//	c.id AS userid,
//	h.id AS serviceid,
//	pcos.optionname AS template
//FROM
//	tblhosting h,
//	tblclients c,
//	tblproducts p,
//	tblproductconfigoptionssub pcos,
//	tblproductconfigoptions pco,
//	tblhostingconfigoptions hco
//WHERE
//h.domain = '" . $username . "'
//and pco.optionname = 'Template'
//AND pcos.configid = pco.id
//AND hco.configid = pco.id
//AND hco.optionid = pcos.id
//AND c.id = h.userid
//AND p.id = h.packageid
//LIMIT 1" ;
//
//


// brala sa e laikata
        $dom_data = \Illuminate\Database\Capsule\Manager::select($query);

        if ($dom_data) {
            foreach ($dom_data as $dom_item) {
                return (array)$dom_item;
            }
        }

    }

    public function go_to_product($params)
    {

        if (!isset($params['client_product_id'])) {
            return;
        }
        $uid = \WHMCS\Session::get("uid");

        if(!isset($uid) or !$uid){
            return;
        }

        $client_product_id = intval($params['client_product_id']);

        $hosting = Capsule::table('tblhosting')
            ->where('id', $client_product_id)
            ->where('userid', $uid)
            ->first();

        if ($hosting) {
            $generated_code = uniqid() . 2020 . time() . $_SESSION['uid'] . $client_product_id . uniqid();

            Capsule::table('mod_microweber_code_login')->insert([
                'domain' => $hosting->domain,
                'code' => $generated_code,
                'user_id' => $uid,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $http_code = 'http://';
            $support_ssl = $this->check_ssl_verify_domain($hosting->domain);
            if ($support_ssl) {
                $http_code = 'https://';
            }
            $redirectToLiveEdit = $http_code . $hosting->domain . "/?editmode=y";
            $redirectToAdmin = $http_code . $hosting->domain . "/admin/view:content";

            if (isset($params['live_edit'])) {
                $redirectTo =$redirectToLiveEdit;
            } else {
                $redirectTo = $redirectToAdmin;
            }


            if (isset($params['return_links'])) {
                $return = [];
                $return['site'] = $http_code . $hosting->domain ;
                $return['admin'] = $http_code . $hosting->domain . '/api/user_login?code_login=' . $generated_code. '&http_redirect=' . $redirectToAdmin;
                $return['live_edit'] = $http_code . $hosting->domain . '/api/user_login?code_login=' . $generated_code. '&http_redirect=' . $redirectToLiveEdit;

                return $return;
            }



            $url = $http_code . $hosting->domain . '/api/user_login?code_login=' . $generated_code. '&http_redirect=' . $redirectTo;

//var_dump($url);
//exit;

            header('Location: ' .$url);
            exit;
        }
    }

    public function check_domain_http_responce_code($domain)
    {
        $url = 'http://'.$domain;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
    }
    public function check_ssl_verify_domain($domain)
    {
        $log = '';
        if ($fp = tmpfile()) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://" . $domain);
            curl_setopt($ch, CURLOPT_STDERR, $fp);
            curl_setopt($ch, CURLOPT_CERTINFO, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $result = curl_exec($ch);
            if (curl_errno($ch) == 0) {
                return true;
            }
            fseek($fp, 0);//rewind
            $str = '';
            while (strlen($str .= fread($fp, 8192)) == 8192) ;
            $log .= $str;
            fclose($fp);
        }

        if (strpos($log, 'SSL certificate verify ok') !== false) {
            return true;
        }

        return false;
    }


// $params['email']
    public function check_if_user_has_purchased_product($params)
    {
        //var_dump($params);
        if (isset($params['email']) and $userid = $this->_get_user_id_by_email($params['email'])) {
            //  var_dump($userid);
            $pids = $this->_get_user_purchased_products($userid);
            if ($pids) {
                // var_dump($pids);
                if (isset($params['pid'])) {
                    $check_pids = explode(',', $params['pid']);
                    if ($check_pids) {
                        $check_pids = array_map('intval', $check_pids);
                        //  .. var_dump($check_pids);
                        //   var_dump($pids);
                        foreach ($check_pids as $check_pid) {
                            foreach ($pids as $pid) {
                                if ($pid == $check_pid) {
                                    return array('result' => 'success', 'pid' => $pid);
                                }
                            }
                        }
                    }
                }
            }

        }

    }

    function get_templates_for_cart($params)
    {
        $hosting = new \MicroweberAddon\Hosting();

        $enabled_templates = $hosting->get_enabled_market_templates();


        $return = [];
        if ($enabled_templates) {
            foreach ($enabled_templates as $enabled_template) {
                if (isset($enabled_template['configoption']) and isset($enabled_template['configoption']['id'])) {


                    $ready = [
                        'id' => $enabled_template['configoption']['id'],
                        'configid' => $enabled_template['configoption']['configid'],
                        'title' => $enabled_template['description'], 
                        'optionname' => $enabled_template['configoption']['optionname'],
                        'image' => '',
                    ];
                    if (isset($enabled_template["extra"]['_meta']) and isset($enabled_template["extra"]['_meta']['screenshot'])) {
                        $ready['image'] = $enabled_template["extra"]['_meta']['screenshot'];
                    }

                    if (isset($enabled_template["keywords"])) {
                        $ready['keywords'] = $enabled_template["keywords"];
                    }

//image
//title

                    $return[] = $ready;
                    //
                }

                //configoption

            }
        }


        return ($return);
    }

    function service_check($params)
    {

        if (!isset($params['service_id'])) {
            return;
        }

        $client_product_id = (int) $params['service_id'];

        $userId = \WHMCS\Session::get("uid");

        if(!isset($userId) or !$userId){
            return;
        }

        $hosting = Capsule::table('tblhosting')
            ->where('id', $client_product_id)
            ->where('userid', $userId)
            ->first();

        if ($hosting) {

            $http_code = 'http://';
            $support_ssl = $this->check_ssl_verify_domain($hosting->domain);
            if ($support_ssl) {
                $http_code = 'https://';
            }

            $domainLink = $http_code . $hosting->domain;

            if ($support_ssl) {
                $sslStatus = \WHMCS\Domain\Ssl\Status::factory($userId, $hosting->domain);
                $sslStatus->syncAndSave();
                $sslStatus->disableAutoResync();
            }

            $code = $this->check_domain_http_responce_code($hosting->domain);

            return ['domain_link'=>$domainLink,'ssl_active'=>$support_ssl,'http_code'=>$code];
        }

        return false;
    }

    function order_iframe($params)
    {
        $search = new MicroweberAddonOrderController();
        return $search->order_iframe($params);
    }

    function domain_search($params)
    {
        $search = new MicroweberAddonDomainSearch();
        return $search->domain_search($params);
    }

    function domain_available($params)
    {
        $search = new MicroweberAddonDomainSearch();
        return $search->domain_available($params);
    }

    function branding_get_company_name()
    {
        global $CONFIG;
        $name = $CONFIG['CompanyName'];

        $resellerCenterConnector = new \MicroweberAddon\ResellerMultibrandConnector();
        $resellerCenterEnabled = $resellerCenterConnector->isEnabled();
        if ($resellerCenterEnabled) {
            $resellerSettings = $resellerCenterConnector->getSettingsForCurrentDomain();
            if (isset($resellerSettings["companyName"])) {
                $name = $resellerSettings["companyName"];
            }
        }

        return $name;
    }

    function get_hosting_products($params = [])
    {
        $search = new MicroweberAddonDomainSearch();
        $result_q = $search->get_hosting_products($params);

        $lang = false;
        if (isset($params['language']) and function_exists('swapLang')) {
            $lang = ($params['language']);
        }

        if (isset($params['currency'])) {
            $currencyID = ($params['currency']);
        }

        // $query = "SELECT * FROM `tblproducts` WHERE type='hostingaccount' and hidden!=1 and showdomainoptions=1 and retired=0  order by tblproducts.order asc  ";


        //  $result_q = Capsule::select($query);
        // $currencyID = false;
        //todo
        $currency = getCurrency('', $currencyID);

        if (!$currency || !is_array($currency) || !isset($currency['id'])) {
            $currency = getCurrency();
        }
        $currencyID = $currency['id'];


        $products = array();

        $resellerSettings = [];
        $resellerCenterConnector = new \MicroweberAddon\ResellerMultibrandConnector();
        $resellerCenterEnabled = $resellerCenterConnector->isEnabled();
        if ($resellerCenterEnabled) {
            $resellerSettings = $resellerCenterConnector->getSettingsForCurrentDomain();
        }



        if ($result_q) {
            foreach ($result_q as $item) {
                $item = (array)$item;
                $prod = Product::find($item['id']);
                if(method_exists($prod, 'getFormattedProductFeaturesAttribute')) {
                    $description = $prod->getFormattedProductFeaturesAttribute();
                } else {
                    $description = $item['description'];
                }
                $format = $description;

                $item["features"] = $format["features"];


                if ($lang) {
                    $item["name"] = $prod->getProductName($prod->id, $prod->name, $lang);
                }

                $pricing = $prod->pricing($currencyID);

//                $data = Capsule::table('tblpricing')
//                    ->where('type', '=', 'product')
//                    ->where('currency', '=', $currencyID)
//                    ->where('relid', '=', $pid)
//                    ->first();
//                $price = $data->$billingCycle;

                $pricing_data = [];


                $price = $pricing->best();


                if ($price) {
                    $pricing_data['is_free'] = $price->isFree();
                    $pricing_data['billing_cycle'] = $price->cycle();
                    $pricing_data['price'] = $price->price()->format();
                }


                if ($resellerSettings and isset($resellerSettings['reseller_id'])) {
                    $resellerSettingsPricing = $resellerCenterConnector->getPricingForProduct($item['id'], $price->cycle(), $currencyID);

                    if ($resellerSettingsPricing and isset($resellerSettingsPricing["billingcycle"])) {
                        $pricing_data['billing_cycle'] = $resellerSettingsPricing["billingcycle"];
                        $pricing_data['price'] = formatCurrency($resellerSettingsPricing["value"], $currencyID);;
                    }

                }


                $item["pricing_data"] = $pricing_data;

                $products[] = $item;

            }
        }


        if (!empty($products)) {

            foreach ($products as $k => $row) {


                $query = "SELECT * FROM `tblpricing` where
              tblpricing.type = 'product'

            and relid='{$row['id']}'



             limit 1  ";

                $result_pricing = Capsule::select($query);


                $prices = array();


                if ($result_pricing) {
                    foreach ($result_pricing as $item) {
                        $prices[] = (array)$item;

                    }
                }

                $row['pricing'] = $prices;
                $products[$k] = $row;
            }


        }
        $result = $products;
        return $result;
    }

    private function _get_user_purchased_products($client_id)
    {

        $pids = array();
        $uid = $client_id;
        $command = "getclientsproducts";
        $values = array();
        $values["clientid"] = $uid;
        $values["limitnum"] = 999;
        $results = localAPI($command, $values);

        if (!empty($results) and isset($results['products'])) {
            $products = $results['products']['product'];
            if (!empty($products)) {
                foreach ($products as $product) {
                    //   var_dump($products);
                    if (!empty($product) and isset($product['pid'])) {
                        $pids[] = intval($product['pid']);
                    }

                }
            }
        }


        $command = 'GetOrders';
        $postData = array(
            'userid' => $uid,
        );

        $results = localAPI($command, $postData);
        if (isset($results['orders']) and !empty($results['orders'])) {
            $orders = $results['orders'];
            foreach ($orders as $ord_i) {
                foreach ($ord_i as $ord) {

                    if (isset($ord['lineitems'])) {
                        foreach ($ord['lineitems'] as $itm_i) {
                            foreach ($itm_i as $itm) {
                                if (isset($itm['relid'])) {
                                    $pids[] = $itm['relid'];
                                }
                            }
                        }
                    }
                }
            }
        } else {

        }


        if ($pids) {
            $pids_copy = $pids;
            foreach ($pids_copy as $pid) {

                $command = "getclientsproducts";
                $values = array();
                $values["clientid"] = $uid;
                $values["limitnum"] = 99999;
                $values2 = $values;
                $values["pid"] = $pid;
                $results = localAPI($command, $values);
                if (isset($results['numreturned']) and $results['numreturned'] == 0) {
                    $values2["serviceid"] = $pid;
                    $results = localAPI($command, $values2);

                }

                if (!empty($results) and isset($results['products'])) {
                    $products = $results['products']['product'];
                    if (!empty($products)) {
                        foreach ($products as $product) {

                            if (!empty($product) and isset($product['pid'])) {
                                $pids[] = $product['pid'];
                            }

                        }
                    }
                }
            }

        }
        if ($pids and !empty($pids)) {
            $pids = array_unique($pids);
            return $pids;
        }

    }


    private function _get_user_id_by_email($email)
    {


        $email = urldecode($email);

        $command = 'GetClientsDetails';
        $postData = array(
            'email' => $email,

        );


        $results = localAPI($command, $postData);

        if (isset($results['result']) and $results['result'] == 'success') {
            if (isset($results['userid']) and $results['userid']) {
                return intval($results['userid']);
            }
        }


    }

    private function __db_escape_string($value)
    {

        if (!is_string($value)) {
            return $value;
        }


        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
        $new = str_replace($search, $replace, $value);
        $new = addslashes($new);
        return $new;
    }


}
