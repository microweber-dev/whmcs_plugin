<?php

use Illuminate\Database\Capsule\Manager as Capsule;

trait DomainAvailabilityChecksTrait
{

    public function parseDesiredDomain($domain)
    {
        $domain = trim($domain);

        if ($domain != '') {
            $domain = trim($domain);
            $domain = str_ireplace('www.', '', $domain);
            $domain = str_ireplace('..', '.', $domain);

            $domain = str_replace(' ', '-', $domain); // Replaces all spaces with hyphens.
            $domain = preg_replace('/[^A-Za-z0-9\-.]/', '', $domain); // Removes special chars.
        }

        if (strpos($domain, '.') !== false) {
            if (!is_fqdn($domain)) {
                $domain2 = 'www.' . $domain;
                if (!is_fqdn($domain2)) {
                    return false;
                }
            }
        }

        $tld = pathinfo($domain, PATHINFO_EXTENSION);

        $extract = new LayerShifter\TLDExtract\Extract();

        $result = $extract->parse($domain);
        $host = $result->getHostname(); // will return 'mydomain'
        $suffix = $result->getSuffix(); // will return 'co.uk'
        $full_host = $result->getFullHost(); // will return 'mydomain.co.uk'
        $domain = $result->getRegistrableDomain(); // will return 'mydomain.co.uk'

        return ['host' => $host, 'suffix' => $suffix, 'fullhost' => $full_host, 'domain' => $domain, 'tld' => $tld];
    }

    public function getTldListWithPrices($filter)
    {
        $freeDomains = $this->_getFreeHostingDomains();
        $paidDomains = $this->_getPaidDomains();

        $allDomains = array_merge($freeDomains, $paidDomains);

        if (isset($filter['tld'])) {
            $domains = [];
            foreach ($allDomains as $domain) {
                $filterTld = '.' . $filter['tld'];
                if ($filterTld == $domain['tld']) {
                    $domains[] = $domain;
                    break;
                }
            }
        } else {
            $domains = $allDomains;
        }

        return $domains;
    }

    public function getDomainPrice($domain)
    {

        $tld = '.' . explode('.', $domain)[1];
        $tldPrices = getTLDPriceList($tld);

        $priceList = array_shift($tldPrices);
        $price = $priceList['register'];

        return $price;
    }

    public function isDomainAvailable($sld, $tld)
    {
        $requestDomain = $sld . '.' . $tld;

        $localCheck = Capsule::table('tblhosting')->where('domain', $requestDomain)->count();
        if ($localCheck) {
            return false;
        }

        $isFreeDomainRequest = false;
        $freeDomains = $this->_getFreeHostingDomains();
        if (!empty($freeDomains)) {
            foreach ($freeDomains as $domain) {
                if ($tld == $domain['tld']) {
                    $isFreeDomainRequest = true;
                    break;
                }
            }
        }

        // The user request free domain and is available
        if ($isFreeDomainRequest) {
            return true;
        }

        $domainObject = new WHMCS\Domains\Domain($sld, $tld);

        $check = new WHMCS\Domain\Checker();
        $check->cartDomainCheck($domainObject, array($domainObject->getDotTopLevel()));
        $searchResult = $check->getSearchResult()->offsetGet(0);

        if ($searchResult->getStatus() == WHMCS\Domains\DomainLookup\SearchResult::STATUS_NOT_REGISTERED) {
            return true;
        }

        return false;
    }

    protected function _getPaidDomains()
    {
        $domains = getTLDList();
        if (empty($domains)) {
            return [];
        }

        $tldListWithPrices = [];
        foreach ($domains as $tld) {
            $tldListWithPrices[] = [
                'tld' => $tld,
                'paid' => true,
                'is_subdomain' => false,
                'prices' => getTLDPriceList($tld)
            ];
        }

        return $tldListWithPrices;
    }

    protected function _getFreeHostingDomains()
    {
        $domains = array();

        $hostingProducts = $this->get_hosting_products();
        if (empty($hostingProducts)) {
            return [];
        }

        if ($hostingProducts) {
            foreach ($hostingProducts as $product) {
                $product = (array)$product;
                if ($product['subdomain']) {
                    $explode = explode(',', $product['subdomain']);
                    $explode = array_filter($explode);
                    $domains = array_merge($domains, $explode);
                }

            }
        }
        $domains = array_unique($domains);

        $tldListWithPrices = [];
        foreach ($domains as $tld) {
            $tldListWithPrices[] = [
                'tld' => $tld,
                'is_subdomain' => true,
                'paid' => false,
                'prices' => []
            ];
        }

        return $tldListWithPrices;
    }

    protected function _domainSuggestVerisign($domain_name, $tlds = [])
    {
        $isEnabled = false;
        $api_key = false;

        $setting = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_addon')
            ->where('setting', 'enable_name_studio_domain_suggest')
            ->first();

        if ($setting and $setting->value == 'Yes') {
            $isEnabled = true;
        }

        if (!$isEnabled) {
            return;
        }

        $settingApiKey = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_addon')
            ->where('setting', 'studio_domain_suggest_api_key')
            ->first();
        if ($settingApiKey and $settingApiKey->value and trim($settingApiKey->value) != '') {
            $api_key = trim($settingApiKey->value);
        }

        $get_tlds = 'com,net';
        if ($tlds) {
            $get_tlds = implode(',', $tlds);
        }

        $url = 'https://sugapi.verisign-grs.com/ns-api/2.0/suggest?name='
            . $domain_name . '&tlds=' . $get_tlds . '&lang=eng&use-numbers=true&use-idns=no&use-dashes=auto&sensitive-content-filter=false&include-registered=false&max-length=63&max-results=15&include-suggestion-type=true';

        $url .= '&ip-address=' . user_ip();
        $ch = curl_init($url);

        if ($api_key) {
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

                    $tld = '.' . explode('.', $sugg['name'])[1];
                    $price = $this->getDomainPrice($sugg['name']);
                    $priceFormated = (string)formatCurrency($price);

                    $suggDetails = array(
                        'domain' => $sugg['name'],
                        'status' => 'available',
                        'tld' => $tld,
                        'sld' => '',
                        'is_free' => false,
                        'subdomain' => false,
                        'from_suggestion' => true,
                        'price' => $price,
                        'price_formated' => $priceFormated,
                        'ajax_status_check'=>false
                    );

                    if (isset($sugg['tldRankingType']) and $sugg['tldRankingType'] == "popular") {
                        $popular[] = $suggDetails;

                    } else {
                        $avaiable[] = $suggDetails;

                    }
                }
            }
        }

        if ($popular) {
            $avaiable = array_merge($popular, $avaiable);
        }

        return $avaiable;

    }

    protected function _orderFirstAvailable($domains)
    {
        $orderedDomains = [];

        // show first free domains
        foreach ($domains as $domain) {
            if ($domain['status'] == 'available' and $domain['is_free'] == true) {
                $orderedDomains[] = $domain;
            }
            if ($domain['status'] == 'unavailable' and $domain['is_free'] == true) {
                $orderedDomains[] = $domain;
            }
        }

        // show paid domains
        foreach ($domains as $domain) {
            if ($domain['status'] == 'available' and $domain['is_free'] == false) {
                $orderedDomains[] = $domain;
            }
            if ($domain['status'] == 'unavailable' and $domain['is_free'] == false) {
                $orderedDomains[] = $domain;
            }
        }

        return $orderedDomains;
    }

    protected function _orderCustom($domains, $order)
    {

        $order = explode(',', $order);

        $orderedResults = [];
        $otherResults = [];
        if (!empty($order)) {
            foreach ($order as $tld) {
                foreach ($domains as $domain) {
                    if ($domain['tld'] == trim($tld)) {
                        $orderedResults[$domain['tld']] = $domain;
                    } else {
                        $otherResults[$domain['tld']] = $domain;
                    }
                }
            }
        }

        $orderedDomains = array_merge($orderedResults, $otherResults);
        $orderedDomains = array_values(array_filter($orderedDomains));

        return $orderedDomains;

    }

}