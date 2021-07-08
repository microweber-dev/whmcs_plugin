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

        $html = '<div class="mw-ads-holder" onclick="window.open(\'https://microweber.bg\', \'_blank\');"><div class="row">
    <div class="col"><img src="./modules/addons/microweber_addon/mw_logo.png" alt="" /> <p class="hidden-xs"><span class="hidden-sm">Този уеб сайт е направен с</span> <strong>Microweber.bg</strong> <span class="hidden-sm">сайт билдър</span></p></div>
    <div class="col text-right"><a href="javascript:;" onclick="window.open(\'https://microweber.bg\', \'_blank\');">Направи си сайт</a></div>
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
                    $json['service_id'] = $checkHosting->id;
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

        return $connector->get_packages_urls();

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


        global $CONFIG;
        global $autoauthkey;


        $whmcsurl = site_url();

        $ajax = false;
        if (isset($_REQUEST['ajax'])) {
            $ajax = true;
        }


        if (!isset($_SESSION['uid'])) {
            // redir("", "index.php");

            $pagetitle = 'Login to website';
            $pageicon = "images/support/clientarea.gif";
            $breadcrumbnav = '<a href="index.php">' . 'Client area' . '</a>';
            $breadcrumbnav .= ' > <a href="#">Login to view product</a>';

            initialiseClientArea($pagetitle, $pageicon, $breadcrumbnav);

            if ($_SESSION['uid']) {
                # User is Logged In - put any code you like here
            }
            $_SESSION['loginurlredirect'] = $_SERVER['REQUEST_URI'];


            //$smartyvalues["login_to_domain"] = $value;


            $templatefile = "login";

            outputClientArea($templatefile);

            die();
        }

        $redir_link = false;
        $is_site_found = false;
        $pids = array();
        if (isset($_REQUEST['id'])) {
            $pids[] = intval($_REQUEST['id']);
        }
        if (isset($_REQUEST['domain'])) {
            $dom = $_REQUEST['domain'];
            if (false === strpos($dom, '://')) {
                $dom = 'http://' . $dom;
            }
            $dom = parse_url($dom);
            if (isset($dom['host'])) {
                $uid = $_SESSION['uid'];
                $command = "getclientsproducts";
                $values = array();
                $values["clientid"] = $uid;
                $values["domain"] = $dom['host'];
                $values["limitnum"] = 199;
                $results = localAPI($command, $values);
                if (!empty($results) and isset($results['products'])) {
                    $products = $results['products']['product'];
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            if (!empty($product) and isset($product['domain'])) {
                                $pids[] = intval($product['id']);
                            }
                        }
                    }
                }
            }
        }


        if (isset($_REQUEST['username2'])) {
            $username2 = $_REQUEST['username2'];
            $username2 = strip_tags($username2);

            if ($username2) {
                $uid = $_SESSION['uid'];
                $command = "getclientsproducts";
                $values = array();
                $values["clientid"] = $uid;
                $values["username2"] = $username2;
                $values["limitnum"] = 199;
                $results = localAPI($command, $values);

                if (!empty($results) and isset($results['products'])) {
                    $products = $results['products']['product'];
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            if (!empty($product) and isset($product['domain'])) {
                                $pids[] = intval($product['id']);
                            }
                        }
                    }
                }
            }
        }


        if (isset($_GET['action']) and isset($_SESSION['uid'])) {

            $act = strip_tags($_GET['action']);
            $first_pid_url = 'clientarea.php?action=' . $act;

            $response = whm_hook_get_client_info_by_id($_SESSION['uid']);
            if (isset($response['email'])) {
                $whmcsurl = $whmcsurl . "/dologin.php";


                $timestamp = time(); # Get current timestamp
                $email = $response['email']; # Clients Email Address to Login
                $email = urlencode($email);
                $hash = sha1($email . $timestamp . $autoauthkey); # Generate Hash
                $goto = $first_pid_url;
                $url = $whmcsurl . "?email=$email&timestamp=$timestamp&hash=$hash&goto=" . urlencode($goto);

                header("Location: $url");
                exit;
            }


            exit;


        }

        if (isset($_REQUEST['orderid'])) {
            $command = 'GetOrders';
            $postData = array(
                'id' => intval($_REQUEST['orderid']),
                'userid' => $_SESSION['uid'],
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

        }


        if (!$pids) {
            $pagetitle = "Error";

            return;

            //  exit('not found');
        }


        $found_prods = array();
        if (isset($_SESSION['uid'])) {
            foreach ($pids as $pid) {
                $uid = $_SESSION['uid'];
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
                            if (!empty($product) and isset($product['domain'])) {
                                $values = array();
                                $values["result"] = 'success';
                                $values["userid"] = $uid;
                                $values["hosting_data"] = $product;
                                $found_prods[] = $product;
                            }

                        }
                    }
                }
            }


        }
        $first_pid = false;
        $domain_found = false;
        if ($found_prods) {
            $first_pid = reset($found_prods);
            foreach ($found_prods as $found_prod) {

                if (!$domain_found && $found_prod['groupname'] !== 'license') {
                    if (isset($found_prod['username']) and isset($found_prod['password'])) {
                        $domain_found = $found_prod;
                    }
                }

            }
        }


        if (!$domain_found) {
            if ($ajax) {
                header("Content-type:application/json");
                print json_encode($first_pid);
                exit;
            }
            if ($first_pid and isset($first_pid['id'])) {
                $first_pid_url = 'clientarea.php?action=productdetails&id=' . $first_pid['id'];
                if (isset($first_pid['groupname'])) {
                    if (stristr($first_pid['groupname'], 'template')) {
                        $first_pid_url = 'https://microweber.com/profile/section:templates?id=' . $first_pid['id'];
                    }
                    if (stristr($first_pid['groupname'], 'module')) {
                        $first_pid_url = 'https://microweber.com/profile/section:modules?id=' . $first_pid['id'];
                    }
                }

                header("Location: " . $first_pid_url);
                exit;
            } else {
                redir("", "index.php");
            }

        } else {
            //$domain_found
            $user_prod = $domain_found;
            if ($ajax) {
                header("Content-type:application/json");
                print json_encode($user_prod);
                exit;
            }
            if (isset($user_prod['username'])) {
                if (isset($user_prod['password'])) {

                    $http_code = 'http://';
                    $support_ssl = $this->check_ssl_verify_domain($user_prod['domain']);
                    if ($support_ssl) {
                        $http_code = 'https://';
                    }

                    if (isset($params['live_edit'])) {
                        $redirectTo = $http_code . $user_prod['domain'] . "/?editmode=y";
                    } else {
                        $redirectTo = $http_code . $user_prod['domain'] . "/admin/view:content";
                    }

                    header('Location: ' . $http_code . $user_prod['domain'] . '/api/user_login?username_encoded=' . urlencode(base64_encode($user_prod['username'])). '&password_encoded=' . urlencode(base64_encode($user_prod['password']) ). '&http_redirect=' . $redirectTo);

                    /*
                    echo '<form id="loginToMicroweber" method="post" action="'. $http_code . $user_prod['domain'].'/api/user_login?http_redirect=1&where_to=admin_content">';

                    echo '<input type="hidden" value="'.$user_prod['username'].'" name="username" />';
                    echo '<input type="hidden" value="'.$user_prod['password'].'" name="password" />';
                    echo '<input type="hidden" value="'.$redirectTo.'" name="http_redirect" />';

                    echo '<input type="submit" value="Login to Microweber Admin...">';

                    echo '
                        <script type="text/javascript"> 
                        document.forms["loginToMicroweber"].submit();
                      </script>
                    ';

                    echo '</form>';*/
                    exit;
                }
            }


        }

        return;
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
                return false;
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
                        'title' => $enabled_template['configoption']['optionname'],
                        'image' => '',
                    ];
                    if (isset($enabled_template["extra"]['_meta']) and isset($enabled_template["extra"]['_meta']['screenshot'])) {
                        $ready['image'] = $enabled_template["extra"]['_meta']['screenshot'];
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

    function order_iframe($params)
    {

        $search = new MicroweberAddonOrderController();


        return $search->order_iframe($params);
    }

    function domain_search($params)
    {


        /*
         * https://developers.whmcs.com/domain-registrars/availability-checks/
         *
         *  searchTerm	string	The search term provided by the end user
            punyCodeSearchTerm	string	For an IDN domain, the puny code encoded search term
            tldsToInclude	array	An array of TLDs/extensions to perform the availability check for
            isIdnDomain	bool	If IDN Domains are enabled for this WHMCS installation
            premiumEnabled
        */

// registrarmodule_GetDomainSuggestions($params)

        $search_term = '';


        $search = new MicroweberAddonDomainSearch();


        return $search->domain_search($params);


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


        //   $description =  $item->getFormattedProductFeaturesAttribute();


        if ($result_q) {
            foreach ($result_q as $item) {
                $item = (array)$item;
                $prod = Product::find($item['id']);
                $format = $prod->getFormattedProductFeaturesAttribute();

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
