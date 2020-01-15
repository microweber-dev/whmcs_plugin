<?php

use WHMCS\View\Menu\Item as MenuItem;
use WHMCS\Database\Capsule;


if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

define("CLIENTAREA", true);


include "includes/clientfunctions.php";


include_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'MicroweberAddonApiController.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'MicroweberAddonDomainSearch.php';


function microweber_addon_config()
{
    $default_redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . '/index.php?m=custom_oauth2';

    $config = array(
        'name' => 'Microweber Addon',
        'description' => 'This module allows connection between WHMCS and Microweber Cpanel plugin',
        'version' => '1.1',
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
            ]
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

   //

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
        echo json_encode($resp, JSON_PRETTY_PRINT);
        exit;


    }

//    return array(
//         'vars' => array(
//            'ADDONLANG' => microweber_addon_load_language($vars)
//         ));

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
        if (!Capsule::schema()->hasTable('mod_microweber_templates')) {
            Capsule::schema()->create('mod_microweber_templates', function ($table) {
                    $table->increments('id');
                    $table->string('name');
                    $table->string('demo_url');
                    $table->string('screenshot_url');
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


if (!function_exists('parse_params')) {
    function parse_params($params)
    {
        $params2 = array();
        if (is_string($params)) {
            $params = parse_str($params, $params2);
            $params = $params2;
            unset($params2);
        }

        return $params;
    }
}


function ___microweber_helpers_get_current_url($skip_ajax = false, $no_get = false)
{

    $u = false;
    if ($skip_ajax == true) {
        $is_ajax = ___microweber_helpers_is_ajax();
        if ($is_ajax == true) {
            if ($_SERVER['HTTP_REFERER'] != false) {
                $u = $_SERVER['HTTP_REFERER'];
            }
        }
    }


    if ($u == false) {
        if (!isset($_SERVER['REQUEST_URI'])) {
            $serverrequri = $_SERVER['PHP_SELF'];
        } else {
            $serverrequri = $_SERVER['REQUEST_URI'];
        }
        $s = '';
        if (___microweber_helpers_is_https()) {
            $s = 's';
        }

        $protocol = 'http';
        $port = 80;
        if (isset($_SERVER['SERVER_PROTOCOL'])) {
            $protocol = ___microweber_helpers_strleft(strtolower($_SERVER['SERVER_PROTOCOL']), '/') . $s;
        }
        if (isset($_SERVER['SERVER_PORT'])) {
            $port = ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] == '443') ? '' : (':' . $_SERVER['SERVER_PORT']);
        }

        if (isset($_SERVER['SERVER_PORT']) and isset($_SERVER['HTTP_HOST'])) {
            if (strstr($_SERVER['HTTP_HOST'], ':')) {
                // port is contained in HTTP_HOST
                $u = $protocol . '://' . $_SERVER['HTTP_HOST'] . $serverrequri;
            } else {
                $u = $protocol . '://' . $_SERVER['HTTP_HOST'] . $port . $serverrequri;
            }
        } elseif (isset($_SERVER['HOSTNAME'])) {
            $u = $protocol . '://' . $_SERVER['HOSTNAME'] . $port . $serverrequri;
        }


    }

    if ($no_get == true) {
        $u = strtok($u, '?');
    }
    if (is_string($u)) {
        $u = str_replace(' ', '%20', $u);
    }

    return $u;


}

function ___microweber_helpers_is_ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
}

function ___microweber_helpers_is_https()
{
    if (isset($_SERVER['HTTPS']) and (strtolower($_SERVER['HTTPS']) == 'on')) {
        return true;
    } else if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and (strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https')) {
        return true;
    }
    return false;
}


function ___microweber_helpers_strleft($s1, $s2)
{
    return substr($s1, 0, strpos($s1, $s2));
}


function ___microweber_helpers_queryToArray($qry)
{
    $result = array();
    //string must contain at least one = and cannot be in first position
    if (strpos($qry, '=')) {

        if (strpos($qry, '?') !== false) {
            $q = parse_url($qry);
            $qry = $q['query'];
        }
    } else {
        return false;
    }
    if (stristr($qry, '&amp;')) {
        $qry = html_entity_decode($qry);
    }
    foreach (explode('&', $qry) as $couple) {
        list ($key, $val) = explode('=', $couple);
        $result[$key] = $val;
    }

    return empty($result) ? false : $result;
}


if (!function_exists('parse_params')) {
    function parse_params($params)
    {
        $params2 = array();
        if (is_string($params)) {
            $params = parse_str($params, $params2);
            $params = $params2;
            unset($params2);
        }

        return $params;
    }
}

if (!function_exists('is_fqdn')) {
    function is_fqdn($FQDN)
    {

        return (!empty($FQDN) && preg_match('/(?=^.{1,254}$)(^(?:(?!\d+\.)[a-zA-Z0-9_\-]{1,63}\.?)+(?:[a-zA-Z]{2,})$)/i', $FQDN) > 0);
    }
}




