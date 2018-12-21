<?php

use WHMCS\View\Menu\Item as MenuItem;



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


add_hook('ClientAreaProductDetailsOutput', 1, function($service) {
//    if (!is_null($service)) {
//        dd($service);
//        $orderID = $service['service']->orderId;
//        return 'OrderID: ' . $orderID;
//    }
//    return '';
});






add_hook('serviceView', 1, function ($secondarySidebar)
{

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


