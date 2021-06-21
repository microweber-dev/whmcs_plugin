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

    public $module_name = 'ResellersCenter';

    public function isEnabled()
    {
        $resellerCenterEnabled = Capsule::table('tbladdonmodules')
            ->where('module', $this->module_name)
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


            if ($this->module_name == 'Multibrand') {
                $resellerResellersSettings = Capsule::table('Multibrand_Brands')
                    ->where('domain', 'LIKE', '%' . $host . '%')
                    ->first();

                if ($resellerResellersSettings and isset($resellerResellersSettings->id) and $resellerResellersSettings->id) {
                    $resellerResellersSettingsAll = Capsule::table('Multibrand_Settings')
                        ->where('brand_id', $resellerResellersSettings->id)
                        ->get();

                    if ($resellerResellersSettingsAll) {
                        $return = [];
                        $return['reseller_id'] = $resellerResellersSettings->id;
                        foreach ($resellerResellersSettingsAll as $resellerResellersSettingItem) {
                            $return[$resellerResellersSettingItem->setting] = $resellerResellersSettingItem->value;
                        }
                        return $return;
                    }
                }


            } else {
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


            if ($this->module_name == 'Multibrand') {
                $resellerResellersSettings = Capsule::table('Multibrand_Contents')
                    ->where('brand_id', $settings['reseller_id'])
                    ->where('type', 'product')
                    //  ->where('currency', $currencyID)
                    ->groupBy('relid')
                    ->get();
            } else {
                $resellerResellersSettings = Capsule::table('ResellersCenter_ResellersPricing')
                    ->where('reseller_id', $settings['reseller_id'])
                    ->where('type', 'product')
                    ->where('currency', $currencyID)
                    ->groupBy('relid')
                    ->get();
            }


            if ($resellerResellersSettings) {
                foreach ($resellerResellersSettings as $resellerResellersSettingService) {
                    //$pids[] = $resellerResellersSettingService->relid;
                    $product = \WHMCS\Product\Product::find($resellerResellersSettingService->relid);

//                    $product = Capsule::table('tblproducts')
//                        ->where('id', $resellerResellersSettingService->relid)
//                        ->first();

                    if ($product) {

                        $isHidden = $product->isHidden;
                        if (!$isHidden) {

                            $prods[] = $product;
                        }
                    }
                }
            }
        }

        return $prods;

    }

    public function getPricingForProduct($pid, $billingcycle, $currencyID)
    {
        $settings = $this->getSettingsForCurrentDomain();
        if (isset($settings['reseller_id']) and $settings['reseller_id']) {
            if ($this->module_name == 'Multibrand') {
                $resellerGetPricingForProduct = Capsule::table('Multibrand_Pricing')
                    ->leftJoin('Multibrand_Contents as Multibrand_Contents', 'Multibrand_Pricing.content_id', '=', 'Multibrand_Contents.id')
                    ->where('Multibrand_Contents.relid', $pid)
                    ->where('Multibrand_Contents.type', "product")
                    ->where('Multibrand_Pricing.currency_id', $currencyID)
                    ->where('Multibrand_Pricing.billingcycle', $billingcycle)
                    //->where('reseller_id', $settings['reseller_id'])
                    ->first();

            } else {
                $resellerGetPricingForProduct = Capsule::table('ResellersCenter_ResellersPricing')
                    ->where('relid', $pid)
                    ->where('type', "product")
                    ->where('currency', $currencyID)
                    ->where('billingcycle', $billingcycle)
                    ->where('reseller_id', $settings['reseller_id'])
                    ->first();
            }
            if ($resellerGetPricingForProduct) {
                return (array)$resellerGetPricingForProduct;
            }

        }
    }


}