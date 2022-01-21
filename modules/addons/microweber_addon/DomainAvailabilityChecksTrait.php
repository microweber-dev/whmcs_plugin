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
            $domain = htmlentities($domain);
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

    public function isDomainAvailable($sld, $tld)
    {
        $requestDomain = $sld . '.' . $tld;

        $localCheck = Capsule::table('tblhosting')->where('domain', $requestDomain)->count();
        if ($localCheck) {
            return false;
        }

        $isFreeDomainRequest = false;
        $freeDomains = $this->_getFreeHostingDomains();
        if(!empty($freeDomains)) {
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

        // The user wants premium domain, lets check
        $whois = new \WHMCS\WHOIS();
        $results = $whois->lookup(['sld' => $sld, 'tld' => $tld]);
        if (isset($results['result']) && $results['result'] == 'available') {
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
                'tld'=>$tld,
                'paid'=>true,
                'prices'=>getTLDPriceList($tld)
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
                'tld'=>$tld,
                'paid'=>false,
                'prices'=>[]
            ];
        }

        return $tldListWithPrices;
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

    protected function _orderCustom($domains, $order) {

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