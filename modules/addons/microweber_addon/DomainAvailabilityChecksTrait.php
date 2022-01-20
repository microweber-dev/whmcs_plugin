<?php

trait DomainAvailabilityChecksTrait
{

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