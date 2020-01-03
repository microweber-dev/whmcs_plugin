<?php

namespace MicroweberAddon;


use \WHMCS\Config\Setting;
use Illuminate\Database\Capsule\Manager as Capsule;


class Config
{

    public $module_name = 'microweber_addon';
    public $config_controller = null;


    function __construct()
    {
        $this->config_controller = new ConfigController();
    }

    private $_settings_cache = null;

    public function get_settings()
    {
        if ($this->_settings_cache) {
            return $this->_settings_cache;
        }

        $settings = Capsule::table('tbladdonmodules')
            ->where('module', $this->module_name)
            ->get();
        $this->_settings_cache = $settings;

        return $settings;

    }

    public function get_settings_for_render()
    {
        $settings = $this->get_settings();
        $modulevars = $addonmodulesperms = array();
        if ($settings) {
            foreach ($settings as $data) {
                $data = (array) $data;
                $modulevars[$data["setting"]] = $data;
            }
        }
        return $modulevars;

    }


    public function get_setting_value($key)
    {
        $settings = $this->get_settings();
        if ($settings) {
            foreach ($settings as $setting) {
                if (is_object($setting)) {
                    if ($setting->setting == $key) {
                        return $setting->value;
                    }
                } else {
                    if ($setting['setting'] == $key) {
                        return $setting['value'];
                    }
                }
            }
        }

    }


    public function get_config_options()
    {


    }


}


/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.12.2017
 * Time: 22:16
 */
class ConfigController
{
    private static $Config = null;

    /**
     * @param string $ModuleName
     * @param string $Key ?????????????? ???????? ?????? (laravel)
     * @param mixed $Value
     */
    public static function SetValueModule($ModuleName, $Key, $Value)
    {
        if (empty(self::$Config)) {
            self::$Config = self::LoadData();
        }
        array_set(self::$Config, $ModuleName . '.' . $Key, $Value);
        self::SaveData();
    }

    /**
     * @param string $ModuleName
     * @param string $Key ?????????????? ???????? ?????? (laravel)
     * @param mixed $default
     *
     * @return mixed
     */
    public static function GetValueModule($ModuleName, $Key, $default = null)
    {
        if (empty(self::$Config)) {
            self::$Config = self::LoadData();
        }
        return array_get(self::$Config, $ModuleName . '.' . $Key, $default);
    }

    /**
     * @param int $ClientID
     * @param string $Key ?????????????? ???????? ?????? (laravel)
     * @param mixed $Value
     */
    public static function SetValueClient($ClientID, $Key, $Value)
    {
        if (empty(self::$Config)) {
            self::$Config = self::LoadData();
        }
        array_set(self::$Config, 'ClientConfig.' . $ClientID . '.' . $Key, $Value);
        self::SaveData();
    }

    /**
     * @param int $ClientID
     * @param string $Key ?????????????? ???????? ?????? (laravel)
     * @param mixed $default
     *
     * @return mixed
     */
    public static function GetValueClient($ClientID, $Key, $default = null)
    {
        if (empty(self::$Config)) {
            self::$Config = self::LoadData();
        }
        return array_get(self::$Config, 'ClientConfig.' . $ClientID . '.' . $Key, $default);
    }

    /**
     * @param string $Key ?????????????? ???????? ?????? (laravel)
     * @param mixed $Value
     */
    public static function SetValue($Key, $Value)
    {
        if (empty(self::$Config)) {
            self::$Config = self::LoadData();
        }
        array_set(self::$Config, $Key, $Value);
        self::SaveData();
    }

    /**
     * @param string $Key ?????????????? ???????? ??????
     * @param mixed $default
     *
     * @return mixed
     */
    public static function GetValue($Key, $default = null)
    {
        if (empty(self::$Config)) {
            self::$Config = self::LoadData();
        }
        return array_get(self::$Config, $Key, $default);
    }

    public static function ClearData()
    {
        self::$Config = [];
        self::SaveData();
    }

    public static function GetAll()
    {
        if (empty(self::$Config)) {
            self::$Config = self::LoadData();
        }
        return self::$Config;
    }

    private static function LoadData()
    {
        return Setting::getValue('microweber_addon');
    }

    private static function SaveData()
    {
        Setting::setValue('microweber_addon', self::$Config);
    }
}