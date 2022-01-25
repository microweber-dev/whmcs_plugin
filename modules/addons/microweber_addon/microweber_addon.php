<?php

use WHMCS\View\Menu\Item as MenuItem;
use WHMCS\Database\Capsule;


if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

define("CLIENTAREA", true);


include "includes/clientfunctions.php";

include_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'base62_functions.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'MicroweberAddonApiController.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'MicroweberAddonDomainSearch.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'MicroweberAddonOrderController.php';

if (!function_exists('get_whitelabel_settings')) {
    function get_whitelabel_settings()
    {
        if (!\WHMCS\Database\Capsule::schema()->hasTable('tbladdonmodules')) {
            return [];
        }

        $getSettings = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_whitelabel')
            //->where('setting', 'primary_color')
            ->get();
        $whitelabelSettings = [];
        foreach ($getSettings as $setting) {
            $whitelabelSettings[$setting->setting] = $setting->value;
        }
        return $whitelabelSettings;
    }
}

function microweber_addon_config()
{
    $default_redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . '/index.php?m=custom_oauth2';

    $config = array(
        'name' => 'Microweber Addon',
        'description' => 'This module allows connection between WHMCS and Microweber Cpanel plugin',
        'version' => '1.2',
        'author' => 'Microweber',
        'language' => 'english',
        'fields' => [
            'whitelabel_key' => [
                'FriendlyName' => 'Whitelabel Key',
                'Type' => 'text',
            ],
            'package_manager_urls' => [
                'FriendlyName' => 'Package Manager Urls',
                'Type' => 'textarea',
                'Rows' => '3',
                'Cols' => '30',
                'Default' => 'https://packages.microweberapi.com/packages.json,'.PHP_EOL.'https://private-packages.microweberapi.com/packages.json',
                'Description' => 'Type your custom marketplace packages urls seperated by coma.',
            ],

            'reseller_center_integration' => [
                'FriendlyName' => 'Reseller Center integration',
                'Type' => 'dropdown',
                 'Options' =>'No,ResellersCenter,Multibrand',
                'Default' => 'No',
                'Description' => 'Enable integration with Reseller Center or Multibrand addons',
            ],
            'domain_search_type' => [
                'FriendlyName' => 'Domain search type',
                'Type' => 'dropdown',
                'Options' =>'Domains/TLDS,Suggested',
                'Default' => 'Domains/TLDS', 
                'Description' => 'The type of domain search on website build process',
            ],

            'domain_suggest_provider' => [
                'FriendlyName' => 'Domain suggest provider',
                'Type' => 'dropdown',
                'Options' =>'WHMCS,Name Studio',
                'Default' => 'WHMCS',
                'Description' => 'The source of domain suggest',
            ],

            'enable_name_studio_domain_suggest' => [
                'FriendlyName' => 'Name Studio domain suggest integration',
                'Type' => 'dropdown',
                'Options' =>'No,Yes',
                'Default' => 'No',
                'Description' => 'Name Studio domain suggest integration from namestudioapi.com',
            ],
            'studio_domain_suggest_api_key' => [
                'FriendlyName' => 'Name Studio api key',
                'Type' => 'text',
            ],

       ]
    );
    
    return $config;
}



function microweber_addon_clientarea($vars)
{
    $params = array();
    if ($_GET) {
        $params = array_merge($params, $_GET);
    }
    if ($_POST) {
        $params = array_merge($params, $_POST);
    }

    $resp = array();
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $LANG = $vars['_lang'];
    $resp = $vars;

    $controller = new MicroweberAddonApiController();

    $method = false;

    if (isset($_GET['function'])) {
        $method = $_GET['function'];
    }

    if (method_exists($controller, $method)) {
        $resp = $controller->$method($params);
        //dd($params,$resp);
     } else {


        $full_url = ___microweber_helpers_get_current_url();
        if (stristr($full_url, '&amp;')) {
            $full_url = html_entity_decode($full_url);
            $full_url_get = parse_url($full_url);
            if ($full_url_get and isset($full_url_get["query"])) {
                $query_params = ___microweber_helpers_queryToArray($full_url);
                if ($query_params) {

                    $_GET = array_merge($params, $query_params);
                    $_REQUEST = array_merge($params, $query_params);
                    if (isset($_GET['function'])) {
                        $method = $_GET['function'];
                        if (method_exists($controller, $method)) {
                            $resp = $controller->$method($params);

                        }
                    }
                }
            }
        }
    }

    if ($resp) {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        echo json_encode($resp, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        exit;

    }
}

function microweber_addon_output($vars)
{
    $resp = '';
    $params = array();
    if ($_GET) {
        $params = array_merge($params, $_GET);
    }
    if ($_POST) {
        $params = array_merge($params, $_POST);
    }
    if ($vars) {
        $params = array_merge($params, $vars);
    }


    // Admin methods
    $controller = new \MicroweberAddon\AdminController();

    $method = 'index';

    if (isset($params['function'])) {
        $method = $params['function'];
    }
    if (method_exists($controller, $method)) {
        $resp = $controller->$method($params);
    }
    print $resp;

}


function microweber_addon_activate()
{
    try {
        if (!Capsule::schema()->hasTable('mod_microweber_code_login')) {
            Capsule::schema()->create('mod_microweber_code_login', function ($table) {
                    $table->increments('id');
                    $table->integer('user_id');
                    $table->text('domain');
                    $table->text('code');
                    $table->dateTime('created_at');
                }
            );
        }
    }  catch (\Exception $e) {
        echo "Unable to create mod_microweber_code_login: {$e->getMessage()}";
    }

    try {
        if (!Capsule::schema()->hasTable('mod_microweber_templates')) {
            Capsule::schema()->create('mod_microweber_templates', function ($table) {
                    $table->increments('id');
                    $table->string('name');
                    $table->string('git_package_name');
                    $table->string('target_dir');
                    $table->string('preview_name');
                    $table->integer('preview_sort');
                    $table->string('preview_url');
                    $table->string('homepage_url');
                    $table->string('screenshot_url');
                    $table->integer('config_option_id');
                    $table->integer('config_option_group_id');
                    $table->integer('has_custom_settings');
                    $table->integer('is_enabled');
                    $table->timestamps();
                }
            );
        }
    } catch (\Exception $e) {
        echo "Unable to create mod_microweber_templates: {$e->getMessage()}";
    }
}

function microweber_addon_deactivate()
{
    try {
        Capsule::schema()->dropIfExists('mod_microweber_code_login');
    } catch (\Exception $e) {
        echo "Unable to drop table mod_microweber_code_login: {$e->getMessage()}";
    }

    try {
        Capsule::schema()->dropIfExists('mod_microweber_templates');
    } catch (\Exception $e) {
        echo "Unable to drop table mod_microweber_templates: {$e->getMessage()}";
    }
}


//
//
////
//function microweber_addon_AdminServicesTabFields($params){
//    $username = $params["username"];
//    $serviceid = $params["serviceid"];
//
//    dd($params);
//   // $collected = collect_usage($params);
//    $fieldsarray = array(
//        '# of Logins' =>1,
//        'Accumalated Hours Online' =>2,
//        'Total Usage' => 3,
//        'Uploaded' => 4,
//        'Downloaded' => 5,
//        'Usage Limit' => 6,
//        'Status' =>7
//    );
//    return $fieldsarray;
//}
//

