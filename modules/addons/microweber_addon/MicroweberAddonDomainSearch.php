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

        $tlds = [];
        $getTlds = $this->getTldListWithPrices();
        if (!empty( $getTlds)) {
            foreach ($getTlds as $tld) {

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
        }


        $page = (isset($params['page']) ? $params['page'] : 0);
        $laodMoreResults = 0;
        $nextResultPage = $page + 1;
        $offset = (($page == 0) ? 0 : ceil(count($tlds) / $nextResultPage));

        $laodMoreResults = 1;

        $json['results'] = $tlds;
        $json['page'] = $page;
        $json['load_more_results'] = $laodMoreResults;
        $json['next_result_page'] = $nextResultPage;

        $json['available_domain_extensions'] = $this->_getPaidDomains();
        $json['available_subdomain_extensions'] = $this->_getFreeHostingDomains();

        return $json;
    }

    function ____domain_search($params)
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


        $return_combined = array();

        $available_domains = array();
        $available_domain_extensions = array();
        $available_subdomains = array();

        $hosting_acc = $this->get_hosting_products();
        if ($hosting_acc) {
            foreach ($hosting_acc as $acc) {
                $acc = (array)$acc;
                if ($acc['subdomain']) {
                    $explode = explode(',', $acc['subdomain']);
                    $explode = array_filter($explode);
                    $available_subdomains = array_merge($available_subdomains, $explode);
                }

            }
        }
        $available_subdomains = array_unique($available_subdomains);

        $domain_results = array();

        if (!is_array($params)) {
            $params = parse_params($params);
        }
        $domain = false;
        if (isset($params['domain'])) {
            $domain = $params['domain'];
            $domain = trim($domain);
        }
        $domain_req = $domain;

        if (isset($params['tld'])) {
            $domain = $domain . '.' . $params['tld'];
        }

        if ($domain != '') {
            $domain = trim($domain);
            $domain = preg_replace("/[^[:alnum:].[:space:]]/u", '', $domain);

            $domain = str_ireplace('www.', '', $domain);
            $domain = str_ireplace('..', '.', $domain);
        }

        $extension = $domain_tld_request = pathinfo($domain, PATHINFO_EXTENSION);
        if (!$extension) {
            $domain = $domain . '.com';
        }

        if (!is_fqdn($domain)) {
            $domain2 = 'www.' . $domain;
            if (!is_fqdn($domain2)) {
                return array('Error' => 'Please enter valid domain name');
            }
        }

        $tld  = pathinfo($domain, PATHINFO_EXTENSION);
        $host = parse_url($domain, PHP_URL_HOST);


        $extract = new LayerShifter\TLDExtract\Extract();

        $result = $extract->parse($domain);
        $host = $result->getHostname(); // will return 'mydomain'
        $suffix = $result->getSuffix(); // will return 'co.uk'
        $full_host = $result->getFullHost(); // will return 'mydomain.co.uk'
        $domain = $reg_domain = $result->getRegistrableDomain(); // will return 'mydomain.co.uk'

        $suffix_with_dot = '.' . $domain_tld_request;

        $command = 'GetTLDPricing';
        $postData = array();
        require_once(__DIR__ . '/init.php');

        $tlds = getTLDList();

        $page = (isset($params['page']) ? $params['page'] : 0);
        $load_more_results = 0;
        $next_result_page = $page + 1;
        $offset = (($page == 0) ? 0 : ceil(count($tlds) / $next_result_page));

        if ($tlds) {
            foreach ($tlds as $tld) {
                $results_tlds[$tld] = getTLDPriceList($tld);
            }

            // only when we serach many results
            if (empty($domain_tld_request)) {
                $results_tlds = array_slice($results_tlds, $offset, 5);
            }

        }

        if (!empty($results_tlds) && empty($domain_tld_request)) {
            $load_more_results = 1;
        }

        if ($results_tlds) {
            foreach ($results_tlds as $tld_key => $tld_data) {
                $tld_data = $tld_data[1];

                if (isset($tld_data['register']) and $tld_data['register']) {
                    //s $available_domain_extensions[$tld_key] = (string) formatCurrency(array_shift($tld_data['register']));
                    $available_domain_extensions[$tld_key] = $tld_data['register'];
                }
            }
        }


        $try_exts = array();
        if ($available_domain_extensions) {
            $try_exts = array_merge($try_exts, array_keys($available_domain_extensions));
        }
        if ($available_subdomains) {
            $try_exts = array_merge($try_exts, $available_subdomains);
        }

        if ($try_exts) {
            foreach ($try_exts as $available_domain_extension) {

                if (!empty($domain_tld_request)) {
                    if ($suffix_with_dot != $available_domain_extension) {
                        continue;
                    }
                }

                $available_domain_extension1 = ltrim($available_domain_extension, '.');
                $search_dom = $host . '.' . $available_domain_extension1;
                $is_already_local_registered = Capsule::table('tblhosting')->where('domain', $search_dom)->count();
                if (!$is_already_local_registered) {
                    if (in_array($available_domain_extension, $available_subdomains)) {

                        $price = (string)formatCurrency(array_shift($tld_data));

                        $domain_results[$search_dom] = array('domain' => $search_dom, 'status' => 'available', 'tld' => $available_domain_extension, 'sld' => $host, 'is_free' => true, 'subdomain' => true, 'price' => $price);
                    } else {

                        $whois = new \WHMCS\WHOIS();
                        $results = $whois->lookup(['sld' => $host, 'tld' => $available_domain_extension]);

                        $tld_data = $available_domain_extensions[$available_domain_extension];

                        $price =  (string)formatCurrency($tld_data);

                        if ($results and isset($results["result"]) and ($results["result"]) == 'available') {
                            $domain_results[$search_dom] = array('domain' => $search_dom, 'status' => 'available', 'tld' => '.' . $available_domain_extension1, 'sld' => $host, 'is_free' => false, 'subdomain' => false, 'price' => $price);
                        } else {
                            $domain_results[$search_dom] = array('domain' => $search_dom, 'status' => 'unavailable', 'tld' => '.' . $available_domain_extension1, 'sld' => $host, 'is_free' => false, 'subdomain' => false, 'price' => $price);
                        }
                    }

                } else {
                    $price = (string)formatCurrency(0);
                    $domain_results[$search_dom] = array('domain' => $search_dom, 'status' => 'unavailable', 'tld' => $available_domain_extension, 'sld' => $host, 'is_free' => true, 'subdomain' => true, 'price' => $price);
                }
            }

            foreach ($try_exts as $available_domain_extension) {
                //suggest
                $suggest_query = $this->domain_suggest_verisign($host, [$available_domain_extension]);
                if ($suggest_query) {

                    foreach ($suggest_query as $sugg) {

                        $available_domain_extension1 = ltrim($available_domain_extension, '.');

                        $search_dom = $sugg;

                        $tld_data = $available_domain_extensions[$available_domain_extension];

                        $extract = new LayerShifter\TLDExtract\Extract();

                        $result = $extract->parse($search_dom);
                        $host = $result->getHostname(); // will return 'mydomain'
                        $suffix = $result->getSuffix(); // will return 'co.uk'
                        $full_host = $result->getFullHost(); // will return 'mydomain.co.uk'
                        $domain = $reg_domain = $result->getRegistrableDomain(); // will return 'mydomain.co.uk'

                        $price = (string)formatCurrency(array_shift($tld_data));
                        $domain_results[$search_dom] = array(
                            'domain' => $search_dom, 'status' => 'available',
                            'tld' => $suffix,
                            'sld' => $host,
                            'is_free' => false,
                            'subdomain' => false,
                            'from_suggestion' => true,
                            'price' => $price);
                    }
                }
            }
        }


        $return_combined['available_domain_extensions'] = $available_domain_extensions;
        $return_combined['available_subdomain_extensions'] = $available_subdomains;

        $return_combined['page'] = $page;
        $return_combined['load_more_results'] = $load_more_results;
        $return_combined['next_result_page'] = $next_result_page;

        return $return_combined;
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


        if(!$isEnabled){
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

            //ip-address
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




        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $xml = curl_exec($ch);
        $curlerror = "ErrNo: " . curl_errno($ch) . " ErrMsg: " . curl_error($ch);
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

        if($popular){
            // $avaiable = array_merge($avaiable,$popular);

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