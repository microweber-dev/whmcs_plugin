<?php
/**
 * Microweber Cloud Connect Module v0.0.1
 * Developed by Bozhidar Slaveykov - bobi@microweber.com
 *
 */

use GuzzleHttp\Client;
use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

/**
 * Module related meta data.
 */
function microweber_cloudconnect_MetaData()
{

    return array(
        'DisplayName' => 'Microweber Cloud Connect',
        'APIVersion' => '1',
        'RequiresServer' => true,
        'DefaultNonSSLPort' => '1111',
        'DefaultSSLPort' => '1112',
        'ServiceSingleSignOnLabel' => 'Login to Panel as User',
    );

}

/**
 * Define product configuration options.
 */
function microweber_cloudconnect_ConfigOptions()
{

    /*return [
        "platformType" => [
            "FriendlyName" => "Platform",
            "Type" => "dropdown",
            "Options" => [
                '9739' => 'Linux',
                '907' => 'WordPress',
                '15809' => 'Windows',
            ],
            "Description" => "Select Linux if unsure, use WordPress only for WordPress sites",
            "Default" => "9739",
        ],
    ];*/
    return [];
}

/**
 * Provision a new instance of a product/service.
 *
 * @param array $params
 *
 * @return string
 */
function microweber_cloudconnect_CreateAccount(array $params)
{
    $get_server = Capsule::table('tblservers')
        ->where('id', $params['serverid'])->first();

    if ($get_server) {
        $template = false;
        if (isset($params['configoptions']['Template'])) {
            $template = $params['configoptions']['Template'];
        }

        $payload = array(
            'm' => 'microweber_server',
            'function' => 'create_account',
            'platform' => $params['configoption1'],
            'template'=> $template,
            'domain' => $params['domain'],
            'username' => $params['username'],
            'password' => $params['password'],
            'api_key' => $get_server->accesshash
        );

        $api_url = $get_server->hostname . '/index.php?' . http_build_query($payload);

        $api_response = microweber_cloudconnect_apicall($api_url);

        if (isset($api_response['error']) && $api_response['error']) {
            return $api_response;
        }

        if (isset($api_response['success']) && $api_response['success']) {
            return 'success';
        }
    }

}

/**
 * Test connection with the given server parameters. Expected response is JSON,
 * if its not an exception will be thrown, failing the test.
 *
 * @param array $params
 *
 * @return array
 */
function microweber_cloudconnect_TestConnection(array $params)
{
    $api_url = $params['serverhostname'] . '/index.php?m=microweber_server&function=validate_api_key&api_key=' . $params['serveraccesshash'];

    return microweber_cloudconnect_apicall($api_url);
}

/**
 * Perform single sign-on for a given instance of a product/service.
 * Called when single sign-on is requested for an instance of a product/service.
 * When successful, returns a URL to which the user should be redirected.
 *
 * @param array $params common module parameters
 *
 * @return array
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 */
function microweber_cloudconnect_ServiceSingleSignOn(array $params)
{
    $get_server = Capsule::table('tblservers')
        ->where('id', $params['serverid'])->first();

    if ($get_server) {

        $payload = array(
            'm' => 'microweber_server',
            'function' => 'single_signon',
            'domain' => $params['domain'],
            'api_key'=> $get_server->accesshash
        );

        $api_url = $get_server->hostname . '/index.php?' . http_build_query($payload);

        return microweber_cloudconnect_apicall($api_url);
    }

}

/**
 * Suspend a customer.
 *
 * @param array $params
 *
 * @return string
 */
function microweber_cloudconnect_SuspendAccount(array $params)
{
    $get_server = Capsule::table('tblservers')
        ->where('id', $params['serverid'])->first();

    if ($get_server) {

        $payload = array(
            'm' => 'microweber_server',
            'function' => 'suspend_account',
            'domain' => $params['domain'],
            'api_key' => $get_server->accesshash
        );

        $api_url = $get_server->hostname . '/index.php?' . http_build_query($payload);

        return microweber_cloudconnect_apicall($api_url);
    }

}

/**
 * Un-suspend a customer.
 *
 * @param array $params
 *
 * @return string
 */
function microweber_cloudconnect_UnsuspendAccount(array $params)
{
    $get_server = Capsule::table('tblservers')
    ->where('id', $params['serverid'])->first();

    if ($get_server) {

        $payload = array(
            'm' => 'microweber_server',
            'function' => 'unsuspend_account',
            'domain' => $params['domain'],
            'api_key' => $get_server->accesshash
        );

        $api_url = $get_server->hostname . '/index.php?' . http_build_query($payload);

        return microweber_cloudconnect_apicall($api_url);
    }
}

/**
 * Terminate a customer.
 *
 * @param array $params
 *
 * @return string
 */
function microweber_cloudconnect_TerminateAccount(array $params)
{
    $get_server = Capsule::table('tblservers')
        ->where('id', $params['serverid'])->first();

    if ($get_server) {

        $payload = array(
            'm' => 'microweber_server',
            'function' => 'terminate_account',
            'domain' => $params['domain'],
            'api_key' => $get_server->accesshash
        );

        $api_url = $get_server->hostname . '/index.php?' . http_build_query($payload);

        return microweber_cloudconnect_apicall($api_url);
    }
}


function microweber_cloudconnect_apicall($url) {

    try {
        $response = array();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => 1
        ));

        $curl_response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            $response['success'] = false;
            $response['error'] = $err;
            return $response;
        }

        curl_close($curl);

        $json = json_decode($curl_response, TRUE);

        if (isset($json['success'])) {
            $response['success'] = $json['success'];
        }

        if (isset($json['redirect_url'])) {
            $response['redirectTo'] = $json['redirect_url'];
        }

        if (isset($json['error'])) {
            $response['error'] = $json['error'];
        }
        
        return $response;

    } catch (Throwable $e) {
        logModuleCall(
            'provisioningmodule',
            __FUNCTION__,
            $url,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return $e->getMessage();
    }

}