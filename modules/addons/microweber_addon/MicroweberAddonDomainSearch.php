<?php



require_once(__DIR__ . '/init.php');
require_once (__DIR__ .'/DomainAvailabilityChecksTrait.php');

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

    function domain_available($params)
    {
        if (!is_array($params)) {
            $params = parse_params($params);
        }

        $parseDesiredDomain = $this->parseDesiredDomain($params['domain']);
        if (!$parseDesiredDomain) {
            return array('Error' => 'Please enter valid domain name');
        }

        $status = 'unavailable';
        if ($this->isDomainAvailable($parseDesiredDomain['host'], $parseDesiredDomain['tld'])) {
            $status = 'available';
        }

        $price = $this->getDomainPrice($parseDesiredDomain['domain']);
        $priceFormated = (string)formatCurrency($price);

        return array_merge($parseDesiredDomain, ['status'=>$status, 'price'=>$price,'price_formated'=>$priceFormated]);
    }

    function domain_search($params)
    {

        $json = [];

        if (!is_array($params)) {
            $params = parse_params($params);
        }

        $parseDesiredDomain = $this->parseDesiredDomain($params['domain']);
        if (!$parseDesiredDomain) {
            return array('Error' => 'Please enter valid domain name');
        }

        $domainSearchType = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_addon')
            ->where('setting', 'domain_search_type')
            ->first();

        // Search type with suggested domains
        if ($domainSearchType and $domainSearchType->value == 'Suggested') {

            $suggestForDomain = $parseDesiredDomain['host'] . '.com';
            if (!empty($parseDesiredDomain['domain'])) {
                $suggestForDomain = $parseDesiredDomain['domain'];
            }

            $domainSuggestProvider = \WHMCS\Database\Capsule::table('tbladdonmodules')
                ->where('module', 'microweber_addon')
                ->where('setting', 'domain_suggest_provider')
                ->first();

            if ($domainSuggestProvider and $domainSuggestProvider->value == 'Name Studio') {
                $suggestedDomains = $this->_domainSuggestVerisign($suggestForDomain, getTLDList());
            } else {
                $suggestedDomains = $this->_domainSuggestWHMCS($suggestForDomain, getTLDList());
            }

            $json['results'] = $suggestedDomains;

            $json['available_domain_extensions'] = $this->_getPaidDomains();
            $json['available_subdomain_extensions'] = $this->_getFreeHostingDomains();

            return $json;
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

        $page = (int)(isset($params['page']) ? $params['page'] : 1);
        $limit = (int)(isset($params['limit']) ? $params['limit'] : 20);
        $total = count($tldList); //total items in array

        $totalPages = ceil($total / $limit); //calculate total pages
        $page = max($page, 1); //get 1 page when $params['page'] <= 0
        $page = min($page, $totalPages); //get last page when $params['page'] > $totalPages
        $offset = ($page - 1) * $limit;
        if ($offset < 0) $offset = 0;

        $tldList = array_slice($tldList, $offset, $limit);

        if ($page !== $totalPages) {
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

            if ($isFree) {
                if ($this->isDomainAvailable($parseDesiredDomain['host'], $tld['tld'])) {
                    $status = 'available';
                }
            }

            $priceFormated = (string)formatCurrency($price);

            $tlds[] = array(
                'domain' => $parseDesiredDomain['host'] . $tld['tld'],
                'status' => $status,
                'tld' => $tld['tld'],
                'sld' => $parseDesiredDomain['host'],
                'is_free' => $isFree,
                'subdomain' => $tld['is_subdomain'],
                'from_suggestion' => false,
                'price' => $price,
                'price_formated' => $priceFormated,
                'ajax_status_check'=> ($isFree ? false : true)
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

}