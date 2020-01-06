<?php
/**
 * Created by PhpStorm.
 * User: Bojidar
 * Date: 1/6/2020
 * Time: 1:51 PM
 */

namespace MicroweberAddon;


class UsageReport
{
    private $_reportUrl = "https://members.microweber.bg";

    public function send()
    {
        global  $CONFIG;
        $whmcsUrl = $CONFIG['SystemURL'];

        $manager = new \MicroweberAddon\Manager;

        $plans = array();
        $plansIds = array();
        $hosting = $manager->hosting->get_hosting_products();
        foreach ($hosting as $plan) {
            if (isset($plan['has_website_builder']) and $plan['has_website_builder']) {
                $plans[] = $plan;
                $plansIds[] = $plan['id'];
            }
        }

        if (!empty($plansIds)) {

            $activeClients = array();
            foreach ($plansIds as $planId) {
                $clients = $this->_getClientProductsByPlanId($planId);
                $activeClients = array_merge($clients, $activeClients);
            }

            if (is_array($activeClients) && !empty($activeClients)) {

                $post = array();
                $post['total_clients'] = count($activeClients);
                $post['clients'] = $activeClients;
                $post['whmcs_domain'] = $whmcsUrl;

                $this->_makeHttpRequest($post);

            }
        }

    }

    private function _getReportUrl()
    {
        return $this->_reportUrl . '/index.php?m=microweber_server&function=save_usage_report';
    }

    private function _getClientProductsByPlanId($planId)
    {

        $domains = array();
        $results = localAPI("getclientsproducts", array());

        if (!empty($results) and isset($results['products'])) {
            $products = $results['products']['product'];
            if (!empty($products)) {
                foreach ($products as $product) {
                    if (!empty($product) and isset($product['pid'])) {
                        $domains[] = array(
                            'id' => $product['id'],
                            'plan_id' => $product['pid'],
                            'status' => strtolower($product['status']),
                            'registration_date' => $product['regdate'],
                            'domain' => $product['domain'],
                        );
                    }
                }
            }
        }

        return $domains;

    }

    private function _makeHttpRequest(array $post)
    {
        $json = json_encode($post);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->_getReportUrl());

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json', 'Content-Length: ' . strlen($json)
        ));

        $response = curl_exec($ch);

        curl_close($ch);

    }
}