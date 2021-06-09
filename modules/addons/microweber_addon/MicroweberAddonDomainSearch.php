 <?php

use Illuminate\Database\Capsule\Manager as Capsule;
use WHMCS\Product\Product as Product;

class MicroweberAddonDomainSearch
{

    function get_hosting_products($params = false)
    {

        $hosting_acc = Capsule::table('tblproducts')
            ->where('hidden', 0)
            ->where('retired', 0)
            ->where('showdomainoptions', 1)
            ->where('type', 'hostingaccount')
            ->orderBy('order', 'ASC')
            ->get();


//        $hosting_acc = Product::query()->where('hidden', 0)
//            ->where('retired', 0)
//            ->where('showdomainoptions', 1)
//            ->where('type', 'hostingaccount')
//            ->orderBy('order', 'ASC')
//            ->get();



        // if is reseller, remove other pids
        $resellerPids = [];
        $resellerCenterConnector = new \MicroweberAddon\ResellerCenterConnector();
        $resellerCenterEnabled = $resellerCenterConnector->isEnabled();
        if ($resellerCenterEnabled) {
            $resellerProducts = $resellerCenterConnector->getProductsForCurrentDomain();


            if ($resellerProducts) {
                foreach ($resellerProducts as $resellerProduct) {

                    $resellerPids[] = $resellerProduct->id;
                }

            }
        }


        if($resellerPids){
            if ($hosting_acc) {
                foreach ($hosting_acc as $k=>$acc) {
                    $acc = (array)$acc;

                    $found = false;

                    foreach ($resellerPids as $resellerPid){
                        if(intval($resellerPid) ==intval( $acc['id'])){
                            $found = true;
                        }
                    }



                    if(!$found){
                       unset($hosting_acc[$k]);
                    }
                }
            }
        }




        return $hosting_acc;

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


        $return_combined = array();

        $available_domains = array();
        $available_domain_extensions = array();
        $available_hosting_acc = array();
        $available_subdomains = array();


        $hosting_acc = $this->get_hosting_products();




        if ($hosting_acc) {
            foreach ($hosting_acc as $acc) {
                $acc = (array)$acc;
                $available_hosting_acc[] = $acc;
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

        $extension = pathinfo($domain, PATHINFO_EXTENSION);
        if (!$extension) {
            $domain = $domain . '.com';
        }

        if (!is_fqdn($domain)) {
            $domain2 = 'www.' . $domain;
            if (!is_fqdn($domain2)) {
                return array('Error' => 'Please enter valid domain name');
            }
        }

        $tld = pathinfo($domain, PATHINFO_EXTENSION);
        $host = parse_url($domain, PHP_URL_HOST);


        $extract = new LayerShifter\TLDExtract\Extract();

        $result = $extract->parse($domain);
        $host = $result->getHostname(); // will return 'mydomain'
        $suffix = $result->getSuffix(); // will return 'co.uk'
        $full_host = $result->getFullHost(); // will return 'mydomain.co.uk'
        $domain = $reg_domain = $result->getRegistrableDomain(); // will return 'mydomain.co.uk'

        $command = 'GetTLDPricing';
        $postData = array();

        $results = localAPI($command, $postData);

        if (isset($results['result']) and $results['result'] == 'success') {
            if (isset($results['pricing']) and $results['pricing']) {
                foreach ($results['pricing'] as $tld_key => $tld_data) {
                    if (isset($tld_data['register']) and $tld_data['register']) {
                        //s $available_domain_extensions[$tld_key] = (string) formatCurrency(array_shift($tld_data['register']));
                        $available_domain_extensions[$tld_key] = $tld_data['register'];
                    }
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
                $available_domain_extension1 = ltrim($available_domain_extension, '.');
                $search_dom = $host . '.' . $available_domain_extension1;
                $is_already_local_registered = Capsule::table('tblhosting')->where('domain', $search_dom)->count();
                if (!$is_already_local_registered) {
                    if (in_array($available_domain_extension, $available_subdomains)) {
                        $price = (string)formatCurrency(0);

                        $domain_results[$search_dom] = array('domain' => $search_dom, 'status' => 'available', 'tld' => $available_domain_extension, 'sld' => $host, 'is_free' => true, 'subdomain' => true, 'price' => $price);
                    } else {
                        $command = 'DomainWhois';
                        $postData = array(
                            'domain' => $search_dom,
                        );
                        $results = localAPI($command, $postData);

                        if (isset($results['result']) and $results['result'] == 'success') {
                            $tld_data = $available_domain_extensions[$available_domain_extension];

                            $price = (string)formatCurrency(array_shift($tld_data));

                            if (isset($results['status']) and $results['status'] == 'available') {
                                $domain_results[$search_dom] = array('domain' => $search_dom, 'status' => 'available', 'tld' => '.' . $available_domain_extension, 'sld' => $host, 'is_free' => false, 'subdomain' => false, 'price' => $price);
                            } else {
                                $domain_results[$search_dom] = array('domain' => $search_dom, 'status' => 'unavailable', 'tld' => '.' . $available_domain_extension, 'sld' => $host, 'is_free' => false, 'subdomain' => false, 'price' => $price);
                            }
                        }
                    }

                } else {
                    $price = (string)formatCurrency(0);
                    $domain_results[$search_dom] = array('domain' => $search_dom, 'status' => 'unavailable', 'tld' => $available_domain_extension, 'sld' => $host, 'is_free' => true, 'subdomain' => true, 'price' => $price);
                }
            }
        }


        $return_combined['results'] = [];
        if ($domain_results) {
            // show first free domains
            foreach ($domain_results as $domain_result) {
                if ($domain_result['status'] == 'available' and $domain_result['is_free'] == true) {
                    $return_combined['results'][] = $domain_result;
                }
                if ($domain_result['status'] == 'unavailable' and $domain_result['is_free'] == true) {
                    $return_combined['results'][] = $domain_result;
                }
            }
            // show paid domains
            foreach ($domain_results as $domain_result) {
                if ($domain_result['status'] == 'available' and $domain_result['is_free'] == false) {
                    $return_combined['results'][] = $domain_result;
                }
                if ($domain_result['status'] == 'unavailable' and $domain_result['is_free'] == false) {
                    $return_combined['results'][] = $domain_result;
                }
            }
        }

        if(count($return_combined['results']) > 3){
            $return_combined['results'] = array_slice($return_combined['results'], 0,5);    // limit to 5 exts
        }

        $return_combined['available_domain_extensions'] = $available_domain_extensions;
        $return_combined['available_subdomain_extensions'] = $available_subdomains;

        return $return_combined;
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