<?php

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

use WHMCS\Database\Capsule;
use Illuminate\Database\Capsule\Manager as DB;
use WHMCS\Session;

define("CLIENTAREA", true);

include "includes/clientfunctions.php";
require_once 'oauth2_users.php';
require_once 'exceptions.php';


function custom_oauth2_config()
{
    $default_redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . '/index.php?m=custom_oauth2';
    $config_array = array(
        'name' => 'Microweber OAuth 2.0',
        'description' => 'This addon allows your users to login using an OAuth2 service.',
        'version' => '1.0',
        'author' => 'Microweber',
        'language' => 'english',
        'fields' => array(
            'url' => array(
                'FriendlyName' => 'OAuth service base URL',
                'Type' => 'text',
                'Size' => '75',
                'Description' => 'The base URL for all OAuth2 requests. Example: https://example.com',
            ), 'authorize_path' => array(
                'FriendlyName' => 'Authorize path',
                'Type' => 'text',
                'Size' => '75',
                'Description' => 'The path used to authorize a user. Example: /oauth/ask-to-authorize',
            ), 'token_path' => array(
                'FriendlyName' => 'Token path',
                'Type' => 'text',
                'Size' => '75',
                'Description' => 'The path used to get the access token. Example: /oauth/token',
            ), 'identity_path' => array(
                'FriendlyName' => 'Identity path',
                'Type' => 'text',
                'Size' => '75',
                'Description' => 'The path used to get user information (email, address, phone, etc). Example: /api/user',
            ), 'jwt_path' => array(
                'FriendlyName' => 'JSON Web Token path',
                'Type' => 'text',
                'Size' => '75',
                'Description' => '(optional) Path to JSON Web Token. Example: /oauth/jwt. When set, a JWT will be
				 fetched after logging in and will be set in the session with key "jwt"',
            ), 'scope' => array(
                'FriendlyName' => 'Scope',
                'Type' => 'text',
                'Size' => '75',
                'Description' => 'OAUth2 scope . Example: read,write',
            ), 'client_id' => array(
                'FriendlyName' => 'Client id',
                'Type' => 'text',
                'Size' => '75',
                'Description' => 'OAuth2 client id.',
            ), 'client_secret' => array(
                'FriendlyName' => 'Client Secret',
                'Type' => 'password',
                'Size' => '75',
                'Description' => 'OAuth2 client secret',
            ), 'redirect_uri' => array(
                'FriendlyName' => 'Redirect URI',
                'Type' => 'text',
                'Size' => '75',
                'Description' => 'Set your OAuth2 Redirect URI to this in your OAuth2 application. You may modify this
				 if it doesn\'t match your WHMCS base url (e.g. if your base url is http://example.com/whmcs instead of
				 just https://example.com). Default: ' . $default_redirect_url,
                'Default' => $default_redirect_url,
            ),
            'provider' => array(
                'FriendlyName' => 'OAuth provider name',
                'Type' => 'radio',
                'Options' => get_oauth_providers(),
                'Description' => 'The OAuth2 provider. This will be used to parse the identity of the user.',
                'Default' => PROVIDER_MICROWEBER,
            ),
            'admin_user' => array(
                'FriendlyName' => 'Admin user',
                'Type' => 'text',
                'Size' => '75',
                'Description' => 'The admin user which will be used to create new users',
            ),
        )
    );
    return $config_array;
}

function custom_oauth2_activate()
{
    try {
        DB::statement("CREATE TABLE `mod_custom_oauth2_tokens`
		(`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `access_token` VARCHAR(200),
		 `refresh_token` VARCHAR(200),
		 `token_type` VARCHAR(50),
		 `expires_in` INT,
		 `scope` VARCHAR(200),
		 `created` INT,
		 `client_id` INT, 
		 `external_username` VARCHAR(50),
		  INDEX idx_mod_custom_oauth2_tokens_external_username(external_username),
		  INDEX idx_mod_custom_oauth2_tokens_client_id_scope(client_id, scope),
		  INDEX idx_mod_custom_oauth2_tokens_external_username_scope(external_username, scope)
		  )"
        );
        return array('status' => 'success', 'description' => 'OAuth 2.0 Activated');
    } catch (Exception $e) {
        logModuleCall('custom_oauth2', __FUNCTION__, null, $e->getMessage(), $e->getTraceAsString());
        return array('status' => 'error', 'description' => "Could not activate Custom OAuth2: " . $e->getMessage());
    }

}

function custom_oauth2_deactivate()
{
    // Remove Custom DB table
    try {
        DB::statement("DROP TABLE `mod_custom_oauth2_tokens`");
        return array('status' => 'success', 'description' => 'OAuth 2.0 Deactivated.');
    } catch (Exception $e) {
        logModuleCall('custom_oauth2', __FUNCTION__, null, $e->getMessage(), $e->getTraceAsString());
        return array('status' => 'error', 'description' => 'Could not deactivate Custom OAuth2: ' . $e->getMessage());
    }

}


function custom_oauth2_clientarea($vars)
{
    $error = null;
    if (!session_id()) {
    	session_start();
    }

    try {

        if(isset($_GET['state'])){
            $state = $_GET['state'];
        } else {
            $state = $_SESSION['state'];
        }

        if(isset($_GET['code'])){
            $code = $_GET['code'];
        } else {
            $code = $_SESSION['code'];
        }

        $access_token_url = $vars['url'] . $vars['token_path'];

        $token = get_oauth_access_token($access_token_url, $vars['client_id'], $vars['client_secret'],$code, $vars['redirect_uri'], $state);

        $identity = null;
        $username = isset($token['info']) && isset($token['info']['username']) ? $token['info']['username'] : null;

        if (!$username) {
            $identity = get_identity($username, $token['access_token'], $vars['url'], $vars['identity_path']);
        }
        
        $email = isset($token['email']) ? $token['email'] : null;
        if (!$email) {
            $email = isset($identity['email']) ? $identity['email'] : null;
        }

        $oauth_provider = get_oauth_provider($vars['provider']);
        $authorized = $oauth_provider->isAuthorized($vars['scope'], $token);
        $oauth_provider->getEmail();

        if (!$authorized) {
            throw new BusinessException('You do not have permission to login.');
        }

        $client_id = get_client_id_by_email($email, $vars['admin_user']);
		
        $new_user = false;
        if ($client_id === false) {
        	
            $new_user = true;
            
            if ($identity === null) {
                $identity = get_identity($username, $token['access_token'], $vars['url'], $vars['identity_path']);
            }
            
            if($identity){
           		$oauth_provider->setIdentity($identity);
            }
            
         	$client_id = create_user($token['access_token'], $vars, $oauth_provider);
        }

        if (!$username) {
            $username = $email;
        }
        
        
        if ($client_id) {
        	
        	$client_details = get_user_details_by_id($client_id);
        	if ($client_details['status'] !== 'Active') {
        		
	        	$command = 'UpdateClient';
	        	$postData = array(
	        		'clientid' => $client_id,
	        		'status' => 'Active'
	        		
	        	);
	        	$results = localAPI($command, $postData);
        	}
        }
        
        // Read USER IP
        $user_ip_address = get_client_ip();
        
        // Login user
        if (login_userid($client_id, $user_ip_address))
        {
        	$redirect_to = rtrim($CONFIG['SystemURL'], ' /') . '/clientarea.php';

        	if (isset($_GET['return_url']) && !empty($_GET['return_url']) && strpos($_GET['return_url'], $CONFIG['SystemURL']) == 0) {
				$redirect_to = $_GET['return_url'];
			} else if (isset($_SESSION['loginurlredirect']) && !empty($_SESSION['loginurlredirect'])) {
				$redirect_to = $_SESSION['loginurlredirect'];
			}
			
			header("Location: $redirect_to");
			exit;
        }
        
     	// set_user_access_token($client_id, $username, $token['access_token'], $token['refresh_token'],  $token['expires_in'], $token['scope'], $token['token_type']);
       
    } catch (BusinessException $e) {
        $error = $e->getMessage();
        //logModuleCall('custom_oauth2', __FUNCTION__, $e, null, null);
    }
    
    return array(
        'pagetitle' => 'Login - error',
        'breadcrumb' => array(
            'index.php?m=custom_oauth2' => 'error',
        ),
        'templatefile' => 'authorize.tpl',
        'requirelogin' => false,
        'vars' => array(
            'error' => $error,
        ),
    );
}

// Get the userid for a given email
function get_user_details_by_id($client_id)
{
	// Read user
	$entry = Capsule::table('tblclients')->where('id', '=', trim(strval($client_id)))->first();
	if (is_object($entry) && isset($entry->id))
	{
		return (array) $entry;
	}
	
	return false;
}


// Return the client IP used in $_SERVER
function get_client_ip()
{
	if (isset($_SERVER) && is_array($_SERVER)) {
		$keys = array();
		$keys[] = 'HTTP_X_REAL_IP';
		$keys[] = 'HTTP_X_FORWARDED_FOR';
		$keys[] = 'HTTP_CLIENT_IP';
		$keys[] = 'REMOTE_ADDR';
		$keys[] = 'HTTP_CF_CONNECTING_IP';
		foreach ($keys as $key) {
			if (isset($_SERVER[$key])) {
				if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $_SERVER[$key]) === 1) {
					return $_SERVER[$key];
				}
			}
		}
	}
	return '';
}

// Login the user
function login_userid($userid, $ip_address)
{
    // Read user
    $entry = Capsule::table('tblclients')->select('id', 'password', 'email')->where('id', '=', $userid)->first();
    if (is_object($entry) && isset($entry->id))
    {
        $token = create_sso_token($entry);
        if(isset($token["result"]) && $token["result"] == "error"){
            global $autoauthkey;
            global $CONFIG;
//var_dump($_SERVER);
//exit;
             $cart_data = (Session::get("cart"));

         //   $clientQuery = \WHMCS\User\Client::where("id", $entry->id)->first();
      //      $clientQuery->finalizeLogin();
             // Define WHMCS URL & AutoAuth Key
            $whmcsurl = $CONFIG['SystemURL']."/dologin.php";

            $timestamp = time(); // Get current timestamp
            $email = $entry->email; // Clients Email Address to Login
            $goto = 'clientarea.php?action=products';

            if(isset($cart_data["products"]) and !empty($cart_data["products"])){
                $goto = 'cart.php?a=checkout';

            }

            $hash = sha1($email . $timestamp . $autoauthkey); // Generate Hash

// Generate AutoAuth URL & Redirect
            $url = $whmcsurl . "?email=$email&timestamp=$timestamp&hash=$hash&goto=" . urlencode($goto);
            header("Location: $url");
            exit;

        }
        header('Location: '. $token['redirect_url']);
        exit;

    }

    // Error
    return false;
}

function create_sso_token($user)
{
    $clientQuery = \WHMCS\User\Client::where("email", $user->email)->first();

    $postData= array(
        'action' => 'CreateSsoToken',
        'client_id' => $clientQuery->id
    );

    if (isset($_SESSION['cart']['products'])) {
        $products = $_SESSION['cart']['products'];
        if (!empty($products)) {
            $postData['destination'] = 'sso:custom_redirect';
            $postData['sso_redirect_path'] = 'cart.php?a=view';
        }
    }

    $results = localAPI('CreateSsoToken', $postData);

    return $results;
}

function custom_oauth2_output($vars)
{
    echo '<p>The OAuth2 redirect URI for this module is: ' . $vars['redirect_uri'] . '</p>';
    echo '<p>More information about this module can be found on <a href="https://github.com/gig-projects/whmcs-oauth2">GitHub</a></p>';
}
