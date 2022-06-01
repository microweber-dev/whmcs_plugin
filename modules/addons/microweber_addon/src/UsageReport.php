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
    private $_reportUrl = "https://members.microweber.com";

    public function send()
    {
        global  $CONFIG;
        $whmcsUrl = site_url();

        $activeClients = $this->getClientProducts();

        $serverIp = '';
        if (isset($_SERVER['SERVER_ADDR'])) {
            $serverIp = $_SERVER['SERVER_ADDR'];
        }

        $config = new \MicroweberAddon\Config();
        $licenseKey = $config->get_setting_value('whitelabel_key');

        $post = array();
        $post['total_clients'] = sizeof($activeClients);
       // $post['clients'] = $activeClients;
        $post['whmcs_domain'] = $whmcsUrl;
        $post['server_ip'] = $serverIp;
        $post['license_key'] = $licenseKey;

        $this->_makeHttpRequest($post);

    }

    public function getClientProducts()
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
                return $activeClients;
            }
        }

        return array();
    }

    public function getTotalClientProducts()
    {
        return sizeof($this->getClientProducts());
    }

    private function _getReportUrl()
    {
        return $this->_reportUrl . '/index.php?m=microweber_server&function=save_usage_report';
    }

    private function _getClientProductsByPlanId($planId)
    {

        $domains = array();
        $results = localAPI("getclientsproducts", array('pid'=>$planId));

        if (!empty($results) and isset($results['products'])) {
            $products = $results['products']['product'];
            if (!empty($products)) {
                foreach ($products as $product) {
                    if (!empty($product) and isset($product['pid'])) {
                        $productStatus = strtolower($product['status']);
                        if ($productStatus == 'active') {
                            $domains[] = array(
                                'id' => $product['id'],
                                'plan_id' => $product['pid'],
                                'status' => $productStatus,
                                'registration_date' => $product['regdate'],
                                'domain' => $product['domain'],
                            );
                        }
                    }
                }
            }
        }

        return $domains;

    }

    private function _makeHttpRequest(array $post)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->_getReportUrl());

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