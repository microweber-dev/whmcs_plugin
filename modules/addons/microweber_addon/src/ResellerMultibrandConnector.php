<?php


namespace MicroweberAddon;

use \WHMCS\Database\Capsule;
use \WHMCS\Product\Group;
use \Punic\Currency;
use \WHMCS\Domains\Domain;
use \WHMCS\Session;
use \WHMCS\View\Formatter\Price as Price;

class ResellerMultibrandConnector
{

    public $adapter=null;

    public function __construct()
    {

        $setting = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_addon')
            ->where('setting', 'reseller_center_integration')
            ->first();

        if($setting and $setting->value){
            if($setting->value == 'ResellersCenter'){
                if (\WHMCS\Database\Capsule::schema()->hasTable('ResellersCenter_ResellersSettings')) {
                    $this->adapter = new ResellerCenterConnector();
                }
            } else if($setting->value == 'Multibrand'){
                if (\WHMCS\Database\Capsule::schema()->hasTable('Multibrand_Settings')) {
                    $this->adapter = new MultibrandConnector();
                }
            }
        }

    }


    public function isEnabled()
    {
        if(is_object($this->adapter)){
            return $this->adapter->isEnabled();
        }

     }

    public function getSettingsForCurrentDomain($currencyID = false)
    {

        if(is_object($this->adapter)){
            return $this->adapter->getSettingsForCurrentDomain($currencyID);
        }


        return [];
    }

    public function getProductsForCurrentDomain()
    {
        $prods = [];
        if(is_object($this->adapter)){
            return $this->adapter->getProductsForCurrentDomain();
        }

        return $prods;

    }
    public function getPricingForProduct($pid,$billingcycle,$currencyID)
    {
        if(is_object($this->adapter)){
            return $this->adapter->getPricingForProduct($pid,$billingcycle,$currencyID);
        }
    }


}