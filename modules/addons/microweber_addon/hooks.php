<?php

use WHMCS\View\Menu\Item as MenuItem;
use WHMCS\Database\Capsule;


/**
 * WHMCS SDK Sample Addon Module Hooks File
 *
 * Hooks allow you to tie into events that occur within the WHMCS application.
 *
 * This allows you to execute your own code in addition to, or sometimes even
 * instead of that which WHMCS executes by default.
 *
 * @see https://developers.whmcs.com/hooks/
 *
 * @copyright Copyright (c) WHMCS Limited 2017
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */

// Require any libraries needed for the module to function.
// require_once __DIR__ . '/path/to/library/loader.php';
//
// Also, perform any initialization required by the service's library.

/**
 * Register a hook with WHMCS.
 *
 * This sample demonstrates triggering a service call when a change is made to
 * a client profile within WHMCS.
 *
 * For more information, please refer to https://developers.whmcs.com/hooks/
 *
 * add_hook(string $hookPointName, int $priority, string|array|Closure $function)
 */


function get_website_login_by_orderid($order_id) {
	
	$getOrder = Capsule::table('tblhosting')->where('orderid','=',$order_id)->first();
	
	return get_website_redirect_url($getOrder->domain);
	
}

function get_website_redirect_url($domain) {
	
	global  $CONFIG;
	$whmcsurl = $CONFIG['SystemURL'];
	
	return $whmcsurl .'/index.php?m=microweber_addon&function=go_to_product&domain='.$domain;
}


add_hook('ClientAreaProductDetailsOutput', 1, function ($service) {
	
	if (is_null($service)) {
		return '';
	}

	$productId = $service['service']->id;
	$orderId = $service['service']->orderId;
	$domain = $service['service']->domain;

	if (! $domain) {
		return;
	}

	$serverId = false;
	if (isset($service['service']->server)) {
	    $serverId = $service['service']->server;
    }

    $get_server = Capsule::table('tblservers')
        ->where('id', $serverId)->first();

    if (isset($get_server->type) && $get_server->type == 'microweber_cloudconnect') {
        $redirect_url = '/clientarea.php?action=productdetails&id='.$productId.'&dosinglesignon=1';
    } else {
        $redirect_url = get_website_redirect_url($domain);
    }

	$panel = '
		<div class="panel panel-default" id="mwPanelConfigurableOptionsPanel">
			   <div class="panel-heading">
				   <h3 class="panel-title">Website</h3>
			   </div>
			   <div class="panel-body">
								   <div class="row">
						   <div class="col-md-5 col-xs-6 text-right">
							   <strong>Domain</strong>
							   <br>
								' . $domain . '
						   </div>
						   <div class="col-md-7 col-xs-6 text-left">

						   <a class="btn btn-success" href="' . $redirect_url . '" target="_blank">Login to website</a>

							</div>
					   </div>
				</div>
		   </div>';

	return $panel; 

});


add_hook('serviceView', 1, function ($secondarySidebar) {

    //dd($secondarySidebar);
    // Add a panel to the end of the secondary sidebar for social media links.
    // Declare it with the name "social-media" so we can easily retrieve it
    // later.
//    $secondarySidebar->addChild('social-media', array(
//        'label' => 'Social Media',
//        'uri' => '#',
//        'icon' => 'fas fa-thumbs-up',
//    ));


});

add_hook('AddonConfigSave', 1, function ($params) {




   // dd($params);

    //dd($secondarySidebar);
    // Add a panel to the end of the secondary sidebar for social media links.
    // Declare it with the name "social-media" so we can easily retrieve it
    // later.
//    $secondarySidebar->addChild('social-media', array(
//        'label' => 'Social Media',
//        'uri' => '#',
//        'icon' => 'fas fa-thumbs-up',
//    ));


});





add_hook('AddonConfig', 1, function ($vars) {

//     return [
//        'Additional Field 1' => '<input type="text" name="additionalFieldOne" class="form-control input-150" />',
//        'Additional Field 2' => '<input type="text" name="additionalFieldTwo" class="form-control input-150" />',
//    ];
});


add_hook('AddonConfigSave', 1, function ($vars) {
    $addonId = $vars['id'];
    $additionalFieldOne = App::getFromRequest('additionalFieldOne');
    $additionalFieldTwo = App::getFromRequest('additionalFieldTwo');

    //Save the data here
});


add_hook('ClientAreaPrimarySidebar', 1, function (MenuItem $primarySidebar) {
//    $getEnabled = Capsule::table( 'mod_disable_registrar_lock' )->first();
//    $enabled = json_decode( $getEnabled->enabled );
//    $current = Menu::context( 'domain' );
//    $domain = $current->domain;
//    $tld = substr( $domain, strrpos( $domain, "." ) + 1 );
//    if ( ! in_array( $tld, $enabled ) ) {
//        if ( ! is_null( $primarySidebar->getChild( 'Domain Details Management' ) ) ) {
//            $primarySidebar->getChild( 'Domain Details Management' )->removeChild( 'Registrar Lock Status' );
//        }
//    }
});



add_hook('DailyCronJob', 1, function($vars) {
    $report = new \MicroweberAddon\UsageReport();
    $report->send();
});