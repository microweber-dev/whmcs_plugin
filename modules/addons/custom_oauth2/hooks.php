<?php

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

use Illuminate\Database\Capsule\Manager as DB;

function log_configuration_error($message)
{
    logModuleCall('custom_oauth2', __FUNCTION__, $message, null, null);
}

function hook_template_variables_custom_oauth2($vars)
{


    $extraTemplateVariables = array();

    // fetch clients data if available
    $clientsData = isset($vars['clientsdetails']) ? $vars['clientsdetails'] : null;
    $url = $authorize_path = $client_id = $redirect_uri = $scope = $provider = null;

    // Generate login url if client is not logged in or token has expired
    // if (isset($_SESSION['token_expires_on']) && $_SESSION['token_expires_on'] < time()) {
    // Token no longer valid / user not logged in. Clear session variables.
    // todo: when refresh tokens are supported, use those instead to fetch a new access token.
    //        unset($_SESSION['uid']);
    //        unset($_SESSION['upw']);
    //        unset($_SESSION['token_expires_on']);
    //        unset($_SESSION['oauth2_access_token']);
    //        unset($_SESSION['external_username']);
    // Generate a login URL
    if (!isset($_SESSION['state'])) {
        $state = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
        $_SESSION['state'] = $state;
    } else {
        $state = $_SESSION['state'];
    }
    $settings = DB::table('tbladdonmodules')
        ->select('setting', 'value')
        ->where('module', 'custom_oauth2')
        ->get();
    foreach ($settings as $setting) {
        //            if (!$setting->value) {
        //                log_configuration_error(sprintf('Setting "%s" is not filled in. The module will not function properly until you fill in all settings.', $setting));
        //                return $extraTemplateVariables;
        //            }
        switch ($setting->setting) {
            case 'url':
                $url = $setting->value;
                break;
            case 'authorize_path':
                $authorize_path = $setting->value;
                break;
            case 'redirect_uri':
                $redirect_uri = $setting->value;
                break;
            case 'scope':
                $scope = $setting->value;
                break;
            case 'client_id':
                $client_id = $setting->value;
                break;
        }
    }
    $params = array(
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'scope' => $scope,
        'state' => $state,
        'response_type' => 'code',
    );
    $extraTemplateVariables['custom_oauth2_login_url'] = $url . $authorize_path . '?' . http_build_query($params);
    $extraTemplateVariables['custom_oauth2_base_url'] = $url;
    $extraTemplateVariables['custom_oauth2_logout_url'] = $url . '/logout';
    // }

 ///   $extraTemplateVariables['custom_oauth2_login_url'] = 'waw'; //todo

    // return array of template variables to define
    return $extraTemplateVariables;
}

add_hook('ClientAreaPage', 1, 'hook_template_variables_custom_oauth2');
add_hook('ClientAreaPageLogout', 1, function ($var) {

    $settings = DB::table('tbladdonmodules')
        ->select('setting', 'value')
        ->where('module', 'custom_oauth2')
        ->where('setting', 'url')
        ->first();

    $var['custom_oauth2_logout_url'] = $settings->value . '/logout';


    return $var;

});