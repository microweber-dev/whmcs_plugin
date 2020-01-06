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
    private $reportUrl = "http://members.microweber.com/";

    public function send()
    {
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

                $this->_makeHttpRequest($post);

            }
        }

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
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->reportUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        var_dump($response);
    }
}