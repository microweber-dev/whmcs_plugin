<?php

trait DomainAvailabilityChecksTrait
{

    public function parseDesiredDomain($domain)
    {
        $domain = trim($domain);

        if ($domain != '') {
            $domain = trim($domain);
            $domain = preg_replace("/[^[:alnum:].[:space:]]/u", '', $domain);

            $domain = str_ireplace('www.', '', $domain);
            $domain = str_ireplace('..', '.', $domain);
        }

        if (!is_fqdn($domain)) {
            $domain2 = 'www.' . $domain;
            if (!is_fqdn($domain2)) {
                return false;
            }
        }

        $tld  = pathinfo($domain, PATHINFO_EXTENSION);
        $host = parse_url($domain, PHP_URL_HOST);

        $extract = new LayerShifter\TLDExtract\Extract();

        $result = $extract->parse($domain);
        $host = $result->getHostname(); // will return 'mydomain'
        $suffix = $result->getSuffix(); // will return 'co.uk'
        $full_host = $result->getFullHost(); // will return 'mydomain.co.uk'
        $domain = $result->getRegistrableDomain(); // will return 'mydomain.co.uk'

        return ['host'=>$host,'suffix'=>$suffix,'fullhost'=>$full_host, 'domain'=>$domain, 'tld'=>$tld];
    }

    public function getTldListWithPrices()
    {
        $tldListWithPrices = [];

        $freeDomains = $this->_getFreeHostingDomains();
        if (!empty($freeDomains)) {
            foreach ($freeDomains as $tld) {
                $tldListWithPrices[] = [
                    'tld'=>$tld,
                    'paid'=>false,
                    'prices'=>[]
                ];
            }
        }

        $tldList = getTLDList();
        if (!empty($tldList)) {
            foreach ($tldList as $tld) {
                $tldListWithPrices[] = [
                    'tld'=>$tld,
                    'paid'=>true,
                    'prices'=>getTLDPriceList($tld)
                ];
            }
        }

        return $tldListWithPrices;
    }

    public function isDomainAvailable($sld, $tld)
    {
        $domain = $sld . '.' . $tld;

        $localCheck = Capsule::table('tblhosting')->where('domain', $domain)->count();
        if ($localCheck) {
            return false;
        }

        $whois = new \WHMCS\WHOIS();
        $results = $whois->lookup(['sld' => $sld, 'tld' => $tld]);
    }

    private function _getFreeHostingDomains()
    {
        $domains = array();

        $hostingProducts = $this->get_hosting_products();
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

        return $domains;
    }

    private function _orderFirstFree($domains)
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

    private function _tldOrdering($domains, $order) {

        $order = explode(',', $order);

        $orderedResults = [];
        $otherResults = [];
        if (!empty($order)) {
            foreach ($order as $tld) {
                foreach ($domains as $domain) {
                    if ($domain['tld'] == trim($tld)) {
                        $orderedResults[$domain['domain']] = $domain;
                    } else {
                        $otherResults[$domain['domain']] = $domain;
                    }
                }
            }
        }

        $orderedDomains = array_merge($orderedResults, $otherResults);
        $orderedDomains = array_values(array_filter($orderedDomains));

        return $orderedDomains;

    }

}