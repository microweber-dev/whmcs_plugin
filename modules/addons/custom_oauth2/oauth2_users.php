<?php
use Illuminate\Database\Capsule\Manager as DB;

require_once 'oauth2_providers.php';

function get_oauth_access_token($access_token_url, $client_id, $client_secret, $code, $redirect_uri, $state)
{
    $ch = curl_init();

    $fields = array(
        'grant_type' => 'authorization_code',
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'state' => $state,
    );
    
    $curl_opts = array(
        CURLOPT_URL => $access_token_url,
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query($fields),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_VERBOSE => false
    );
    curl_setopt_array($ch, $curl_opts);
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        // logModuleCall('custom_oauth2', __FUNCTION__, sprintf('%s returned code %d', $access_token_url, $http_code), $result, null);
        throw new BusinessException(sprintf('%d Could not authenticate with %s.', $http_code, $access_token_url));
    }
    
    return json_decode($result, true);
}


function get_client_jwt_token($jwt_url, $access_token, $scope)
{
    $ch = curl_init();
    $fields = array(
        'scope' => $scope,
    );
    $headers = array(
        'Accept' => 'application/json',
        'Authorization: Bearer ' . $access_token,
    );
    $curl_opts = array(
        CURLOPT_URL => $jwt_url,
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query($fields),
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_VERBOSE => false,
        CURLOPT_HTTPHEADER => $headers,
    );
    curl_setopt_array($ch, $curl_opts);
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code !== 200) {
        // logModuleCall('custom_oauth2', __FUNCTION__, sprintf('Could not get JWT token from %s, %d', $jwt_url, $http_code), $result, null);
        throw new BusinessException(sprintf('%d Could not get JWT token from %s.', $http_code, $jwt_url));
    }
    
    return $result;
}


function validate_login($client_id, $password, $expires_in, $admin_user)
{
    $values["clientid"] = $client_id;
    $values["responsetype"] = "NVP";
    $results = localAPI('getclientsdetails', $values, $admin_user);
    if ($results['result'] === 'success') {
        $email = $results['email'];
    } else {
        // logModuleCall('custom_oauth2', __FUNCTION__, 'Could not get the user with id ' . $client_id, $results, null);
        throw new BusinessException('An unknown error occured 1');
    }
    
    $values["email"] = $email;
    $values["password2"] = $password;
    $results = localAPI('validatelogin', $values, $admin_user);

    if ($results['result'] === 'success') {
        return true;
    } else {
        // logModuleCall('custom_oauth2', __FUNCTION__, 'Could not validate login', $results, null);
        throw new BusinessException('An unknown error occured 2');
    }
    
    return;
}


function get_identity($username, $access_token, $url, $identity_path)
{
    $identity_url = $url . sprintf($identity_path, $username);
    $ch = curl_init();

    $headers = array(
        'Accept' => 'application/json',
        'Authorization: Bearer ' . $access_token,
    );
    
    $curl_opts = array(
        CURLOPT_URL => $identity_url,
        CURLOPT_RETURNTRANSFER => true,
         CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_FAILONERROR => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_VERBOSE => false,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CUSTOMREQUEST => 'GET',
    );

    curl_setopt_array($ch, $curl_opts);
    $result = curl_exec($ch);
	
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($http_code !== 200) {
        // logModuleCall('custom_oauth2', __FUNCTION__, $identity_url, sprintf('%d Unable to get user info from %s - %s', $http_code, $url, $result));
        return false;
    } else {
        return json_decode($result, true);
    }

}

function get_client_id($username = false, $admin_user)
{
    if (!$username) {
        return false;
    }

    $tokens = DB::table('mod_custom_oauth2_tokens')
        ->where('external_username', $username)
        ->take(1)
        ->get();
    if (count($tokens) === 0) {
        return false;
    }
    
    $values = array(
    	'clientid' => $tokens[0]->client_id,
    );
    
    // Get the WHMCS client. if not found, return false as the user has been deleted via the WHMCS control panel
    $results = localAPI('getclientsdetails', $values, $admin_user);
    if ($results['result'] === 'error') {
        // logModuleCall('custom_oauth2', __FUNCTION__, 'Deleting oauth2 tokens for user ' . $username . ' because the client was not found');
        DB::table('mod_custom_oauth2_tokens')
            ->where('external_username', $username)
            ->delete();
        return false;
    } else {
        return $tokens[0]->client_id;
    }
}

function get_client_id_by_email($email, $admin_user)
{

    $values = array(
        'email' => $email,
    );

    // Get the WHMCS client. if not found, return false as the user has been deleted via the WHMCS control panel
    $results = localAPI('getclientsdetails', $values, $admin_user);
    
    if ($results['result'] === 'error') {
    	
    	// logModuleCall('custom_oauth2', __FUNCTION__, 'Deleting oauth2 tokens for user ' . $email . ' because the client was not found');

    	DB::table('mod_custom_oauth2_tokens')
    	->where('external_username', $email)
    	->delete();
    	
        return false;
    } else {
        return $results['userid'];
    }
}

function set_user_access_token($client_id, $username, $access_token, $refresh_token, $expires_in, $scope, $token_type)
{
    $token = [
        'access_token' => $access_token,
        'refresh_token' => $refresh_token,
        'expires_in' => $expires_in,
        'created' => time(),
        'token_type' => $token_type,
    ];
    $affected_rows = DB::table('mod_custom_oauth2_tokens')
        ->where('external_username', $username)
        ->where('scope', $scope)
        ->update($token);
    if ($affected_rows === 0) {
        $token['client_id'] = $client_id;
        $token['external_username'] = $username;
        $token['scope'] = $scope;
        DB::table('mod_custom_oauth2_tokens')
            ->insert($token);
    }
}

function create_user($password, $vars, OAuthProvider $oauth_provider)
{
    $command = "addclient";
    
    $values["firstname"] = $oauth_provider->getFirstName();
    $values["lastname"] = $oauth_provider->getLastName();
    $values["email"] = $oauth_provider->getEmail();
    $values["address1"] = $oauth_provider->getAddress();
    $values["city"] = $oauth_provider->getCity();
    $values["state"] = $oauth_provider->getState();
    $values["postcode"] = $oauth_provider->getPostcode();
    $values["country"] = $oauth_provider->getCountry();
    $values["phonenumber"] = $oauth_provider->getPhone();
    $values["password2"] = $password;
    $values['skipvalidation'] = true;

    $results = localAPI($command, $values, $vars['admin_user']);
    if ($results['result'] === 'error') {
        // logModuleCall('custom_oauth2', __FUNCTION__, $results, null, null);
        throw new BusinessException($results['message']);
    }
    return $results['clientid'];
}

function update_user_password($client_id, $password, $vars)
{
    $values = array(
        'clientid' => $client_id,
        'password2' => $password,
    );
    $results = localAPI('updateclient', $values, $vars['admin_user']);
    if ($results['result'] === 'error') {
        // logModuleCall('custom_oauth2', __FUNCTION__, $results, null, null);
        throw new BusinessException($results['message']);
    }
    return $results;
}