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

            if ($this->isDomainAvailable($parseDesiredDomain['host'], $tld['tld'])) {
                $status = 'available';
            }

            $price = (string)formatCurrency($price);

            $tlds[] = array(
                'domain' => $parseDesiredDomain['host'] . $tld['tld'],
                'status' => $status,
                'tld' => $tld['tld'],
                'sld' => $parseDesiredDomain['host'],
                'is_free' => $isFree,
                'subdomain' => $tld['is_subdomain'],
                'from_suggestion' => false,
                'price' => $price
            );
        }

        $tlds = $this->_orderFirstAvailable($tlds);

        $suggedForDomain = $parseDesiredDomain['host'] . '.com';
        if (!empty($parseDesiredDomain['domain'])) {
            $suggedForDomain = $parseDesiredDomain['domain'];
        }

        $suggestedDomains = $this->_domainSuggestVerisign($suggedForDomain, getTLDList());

        $json['page'] = $page;
        $json['load_more_results'] = $laodMoreResults;
        $json['next_result_page'] = $nextResultPage;
        $json['results'] = $tlds;
        $json['results_suggested'] = $suggestedDomains;

        $json['available_domain_extensions'] = $this->_getPaidDomains();
        $json['available_subdomain_extensions'] = $this->_getFreeHostingDomains();

        return $json;
    }


}