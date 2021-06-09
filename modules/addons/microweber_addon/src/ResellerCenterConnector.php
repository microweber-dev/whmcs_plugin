<?php


namespace MicroweberAddon;

use \WHMCS\Database\Capsule;
use \WHMCS\Product\Group;
use \Punic\Currency;
use \WHMCS\Domains\Domain;
use \WHMCS\Session;
use \WHMCS\View\Formatter\Price as Price;

class ResellerCenterConnector
{

    public function isEnabled()
    {
        $resellerCenterEnabled = Capsule::table('tbladdonmodules')
            ->where('module', 'ResellersCenter')
            ->where('setting', 'hooksEnabled')
            ->where('value', 'on')
            ->first();

        if ($resellerCenterEnabled) {

            return true;
        }

    }

    public function getSettingsForCurrentDomain($currencyID = false)
    {
        $host = false;

        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        } else if (isset($_SERVER['SERVER_NAME'])) {
            $host = $_SERVER['SERVER_NAME'];
        }


        if ($host) {
            $resellerResellersSettings = Capsule::table('ResellersCenter_ResellersSettings')
                ->where('value', 'LIKE', '%' . $host . '%')
                ->where('setting', 'domain')
                ->first();

            if ($resellerResellersSettings and isset($resellerResellersSettings->reseller_id) and $resellerResellersSettings->reseller_id) {
                $resellerResellersSettingsAll = Capsule::table('ResellersCenter_ResellersSettings')
                    ->where('reseller_id', $resellerResellersSettings->reseller_id)
                    ->get();

                if ($resellerResellersSettingsAll) {
                    $return = [];
                    $return['reseller_id'] = $resellerResellersSettings->reseller_id;
                    foreach ($resellerResellersSettingsAll as $resellerResellersSettingItem) {
                        $return[$resellerResellersSettingItem->setting] = $resellerResellersSettingItem->value;
                    }
                    return $return;
                }
            }

        }

        return [];
    }

    public function getProductsForCurrentDomain()
    {
        $prods = [];
        $settings = $this->getSettingsForCurrentDomain();
        if (isset($settings['reseller_id']) and $settings['reseller_id']) {
//            $resellerResellersSettings = Capsule::table('ResellersCenter_ResellersServices')
//                ->where('reseller_id', $settings['reseller_id'])
//                ->get();


            $currencyID = false;
            //todo
            $currency = getCurrency('', $currencyID);

            if (!$currency || !is_array($currency) || !isset($currency['id'])) {
                $currency = getCurrency();
            }
            $currencyID = $currency['id'];



  $resellerResellersSettings = Capsule::table('ResellersCenter_ResellersPricing')
                ->where('reseller_id', $settings['reseller_id'])
                ->where('type', 'product')
                ->where('currency', $currencyID)
                 ->groupBy('relid')
                ->get();


            if ($resellerResellersSettings) {
                foreach ($resellerResellersSettings as $resellerResellersSettingService) {
                    //$pids[] = $resellerResellersSettingService->relid;
                     $product = \WHMCS\Product\Product::find($resellerResellersSettingService->relid) ;

//                    $product = Capsule::table('tblproducts')
//                        ->where('id', $resellerResellersSettingService->relid)
//                        ->first();

                    if($product){

                        $isHidden = $product->isHidden;
                        if(!$isHidden){

                        $prods[] = $product;
                        }
                    }
                }
            }
        }

        return $prods;

    }
    public function getPricingForProduct($pid,$billingcycle,$currencyID)
    {
        $settings = $this->getSettingsForCurrentDomain();
        if (isset($settings['reseller_id']) and $settings['reseller_id']) {


            $resellerGetPricingForProduct = Capsule::table('ResellersCenter_ResellersPricing')
                ->where('relid', $pid)
                ->where('type',  "product")
                ->where('currency', $currencyID)
                ->where('billingcycle', $billingcycle)
                ->where('reseller_id', $settings['reseller_id'])
                ->first();

            if($resellerGetPricingForProduct){
                return (array) $resellerGetPricingForProduct;
            }

        }
    }


}