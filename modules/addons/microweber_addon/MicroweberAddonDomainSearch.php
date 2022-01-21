<?php

require_once(__DIR__ . '/init.php');
include_once 'DomainAvailabilityChecksTrait.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use WHMCS\Product\Product as Product;

class MicroweberAddonDomainSearch
{

    use DomainAvailabilityChecksTrait;

    function get_hosting_products($params = false)
    {
        $hosting_acc = Capsule::table('tblproducts')
            ->where('hidden', 0)
            ->where('retired', 0)
            ->where('showdomainoptions', 1)
            ->where('type', 'hostingaccount')
            ->orderBy('order', 'ASC')
            ->get();

        // if is reseller, remove other pids
        $resellerPids = [];
        $resellerCenterConnector = new \MicroweberAddon\ResellerMultibrandConnector();
        $resellerCenterEnabled = $resellerCenterConnector->isEnabled();
        if ($resellerCenterEnabled) {
            $resellerProducts = $resellerCenterConnector->getProductsForCurrentDomain();


            if ($resellerProducts) {
                foreach ($resellerProducts as $resellerProduct) {

                    $resellerPids[] = $resellerProduct->id;
                }

            }
        }


        if ($resellerPids) {
            if ($hosting_acc) {
                foreach ($hosting_acc as $k => $acc) {
                    $acc = (array)$acc;

                    $found = false;

                    foreach ($resellerPids as $resellerPid) {
                        if (intval($resellerPid) == intval($acc['id'])) {
                            $found = true;
                        }
                    }


                    if (!$found) {
                        unset($hosting_acc[$k]);
                    }
                }
            }
        }


        return $hosting_acc;

    }

    function domain_search($params) {

        $json = [];

        if (!is_array($params)) {
            $params = parse_params($params);
        }

        $parseDesiredDomain = $this->parseDesiredDomain($params['domain']);
        if (!$parseDesiredDomain) {
            return array('Error' => 'Please enter valid domain name');
        }

        $filter = [];
        if (isset($parseDesiredDomain['tld']) && !empty($parseDesiredDomain['tld'])) {
            $filter['tld'] = $parseDesiredDomain['tld'];
        }

        $tlds = [];
        $tldList = $this->getTldListWithPrices($filter);
        if (empty($tldList)) {
            return array('Error' => 'No domains found.');
        }

        if (isset($params['tld_order'])) {
            $tldList = $this->_orderCustom($tldList, $params['tld_order']);
        }

        $nextResultPage = 0;
        $laodMoreResults = 0;

        $page = (int) (isset($params['page']) ? $params['page'] : 1);
        $limit = (int) (isset($params['limit']) ? $params['limit'] : 15);
        $total = count($tldList); //total items in array

        $totalPages = ceil( $total / $limit); //calculate total pages
        $page = max($page, 1); //get 1 page when $params['page'] <= 0
        $page = min($page, $totalPages); //get last page when $params['page'] > $totalPages
        $offset = ($page - 1) * $limit;
        if ($offset < 0) $offset = 0;

        $tldList = array_slice($tldList, $offset, $limit);

        if($page !== $totalPages) {
            $laodMoreResults = 1;
            $nextResultPage = $page + 1;
        }

        foreach ($tldList as $tld) {

            $price = 0;
            $isFree = true;
            $status = 'unavailable';

            if (!empty($tld['prices'])) {
                $priceList = array_shift($tld['prices']);
                $price = $priceList['register'];
                $isFree = false;
            }

            if ($this->isDomainAvailable($parseDesiredDomain['host'], $tld['tld'])) {
                $status = 'available';
            }

            $price = (string)formatCurrency($price);

            $tlds[] = array(
                'domain' => $parseDesiredDomain['host'] . $tld['tld'],
                'status' => $status,
                'tld' => $tld['tld'],
                'sld' => '',
                'is_free' => $isFree,
                'subdomain' => false,
                'from_suggestion' => true,
                'price' => $price
            );
        }

        $tlds = $this->_orderFirstAvailable($tlds);

        $json['page'] = $page;
        $json['load_more_results'] = $laodMoreResults;
        $json['next_result_page'] = $nextResultPage;
        $json['results'] = $tlds;

        $json['available_domain_extensions'] = $this->_getPaidDomains();
        $json['available_subdomain_extensions'] = $this->_getFreeHostingDomains();

        return $json;
    }

    function domain_suggest_verisign($domain_name, $tlds = [])
    {
        $isEnabled = false;
        $api_key = false;

        $setting = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_addon')
            ->where('setting', 'enable_name_studio_domain_suggest')
            ->first();

        if($setting and $setting->value=='Yes'){
            $isEnabled = true;
        }

        if (!$isEnabled) {
            return;
        }

        $settingApiKey = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_addon')
            ->where('setting', 'studio_domain_suggest_api_key')
            ->first();
        if($settingApiKey and $settingApiKey->value and trim($settingApiKey->value) != ''){
            $api_key = trim($settingApiKey->value);
        }

        $get_tlds = 'com,net';
        if ($tlds) {
            $get_tlds = implode(',', $tlds);
        }

        $url = 'https://sugapi.verisign-grs.com/ns-api/2.0/suggest?name='
            . $domain_name . '&tlds=' . $get_tlds . '&lang=eng&use-numbers=true&use-idns=no&use-dashes=auto&sensitive-content-filter=false&include-registered=false&max-length=63&max-results=15&include-suggestion-type=true';

        $url .='&ip-address='.user_ip();
        $ch = curl_init($url);

        if($api_key){
           // Set authentication details
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'X-NAMESUGGESTION-APIKEY: ' . $api_key
            ]);
        } else {
            curl_setopt($ch, CURLOPT_HEADER, false);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $xml = curl_exec($ch);
        curl_close($ch);


        $xml = @json_decode($xml, 1);
        $avaiable = [];
        $popular = [];

        if ($xml and is_array($xml) and !empty($xml) and !empty($xml['results'])) {
            $res = $xml['results'];
            foreach ($res as $sugg) {

                if (isset($sugg['name']) and isset($sugg['availability']) and $sugg['availability'] == "available") {
                    if (isset($sugg['tldRankingType']) and $sugg['tldRankingType'] == "popular") {
                        $popular[] = $sugg['name'];
                    } else {
                        $avaiable[] = $sugg['name'];
                    }
                }
            }
        }

        if ($popular) {
             $avaiable = array_merge($popular,$avaiable);
        }

        return $avaiable;

    }

    function domain_suggest()
    {
        $query = "SELECT setting,value FROM `tblregistrars` WHERE registrar='enom' AND (setting='Username' OR setting='Password')";
        $result = mysql_query($query) or die(mysql_error());
        while ($row = @mysql_fetch_array($result)) {
            $setting = $row['setting'];
            $enom[$setting] = $row['value'];
        }
        $enomid = decrypt($enom['Username']);
        $enompw = decrypt($enom['Password']);
        $maxspins = 10;

        if (isset($the_request['domain'])) {
            $tld = $the_request['domain'];
        }

        //Do not edit this. We're setting up the URL to retrieve the spins
        $namespinnerurl = "https://reseller.enom.com/interface.asp?command=namespinner&uid=" . $enomid . "&pw=" . $enompw . "&TLD=" . $tld . "&SensitiveContent=true" . "&MaxResults=" . $maxspins . "&ResponseType=XML";
//        var_dump($namespinnerurl);
        // Use cURL to get the XML response
        $ch = curl_init($namespinnerurl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $xml = curl_exec($ch);
        $curlerror = "ErrNo: " . curl_errno($ch) . " ErrMsg: " . curl_error($ch);
        curl_close($ch);

        if ($xml) {
            $spinnerresults = new SimpleXmlElement($xml, LIBXML_NOCDATA);

            if ($spinnerresults->ErrCount == 0) {
                for ($i = 0; $i < $maxspins; $i++) {
                    if ($showdotcom && (string)$spinnerresults->namespin->domains->domain[$i]['com'] == "y")
                        $spinner[] = array(
                            'domain' => (string)$spinnerresults->namespin->domains->domain[$i]['name'] . ".com",
                            'netscore' => (int)$spinnerresults->namespin->domains->domain[$i]['comscore'],
                            'tld' => '.com');
                    if ($showdotnet && (string)$spinnerresults->namespin->domains->domain[$i]['net'] == "y")
                        $spinner[] = array(
                            'domain' => (string)$spinnerresults->namespin->domains->domain[$i]['name'] . ".net",
                            'netscore' => (int)$spinnerresults->namespin->domains->domain[$i]['netscore'],
                            'tld' => '.net');
                    if ($showdotcc && (string)$spinnerresults->namespin->domains->domain[$i]['cc'] == "y")
                        $spinner[] = array(
                            'domain' => (string)$spinnerresults->namespin->domains->domain[$i]['name'] . ".cc",
                            'netscore' => (int)$spinnerresults->namespin->domains->domain[$i]['ccscore'],
                            'tld' => '.cc');
                    if ($showdottv && (string)$spinnerresults->namespin->domains->domain[$i]['tv'] == "y")
                        $spinner[] = array(
                            'domain' => (string)$spinnerresults->namespin->domains->domain[$i]['name'] . ".tv",
                            'netscore' => (int)$spinnerresults->namespin->domains->domain[$i]['tvscore'],
                            'tld' => '.tv');
                }
                $gotnamespinner = true;
            } else {
                if ($debug) echo $spinnerresults->errors->Err1;
                $gotnamespinner = false;
            }
        }
    }


}