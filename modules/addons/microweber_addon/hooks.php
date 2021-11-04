<?php

require_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers.php';

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


function get_website_login_by_orderid($order_id)
{

    $getOrder = Capsule::table('tblhosting')->where('orderid', '=', $order_id)->first();

    return get_website_redirect_url($getOrder->domain, $getOrder->id);

}

function get_website_redirect_url($domain, $client_product_id = false)
{

    global $CONFIG;
    $whmcsurl = site_url();

    if ($client_product_id) {
        $domain .= '&client_product_id=' . $client_product_id;
    }

    return $whmcsurl . '/index.php?m=microweber_addon&function=go_to_product&domain=' . $domain;
}

function mw_get_login_links_by_service($productId, $serverId, $domain)
{
    $redirect_url = false;

    $get_server = Capsule::table('tblservers')
        ->where('id', $serverId)->first();

    if (isset($get_server->type) && $get_server->type == 'microweber_cloudconnect') {
        $redirect_url = '/clientarea.php?action=productdetails&id=' . $productId . '&dosinglesignon=1';
    } else if ($get_server) {
        $redirect_url = get_website_redirect_url($domain, $productId);
    }

    return ['live_edit'=> $redirect_url . '&live_edit=1', 'admin'=>$redirect_url, 'domain'=>$domain];
}


function mw_client_area_output_html($service)
{

    if (is_null($service)) {
        return '';
    }

    $productId = $service['service']->id;
    $domain = $service['service']->domain;

    if (!$domain) {
        return;
    }

    $serverId = false;
    if (isset($service['service']->server)) {
        $serverId = $service['service']->server;
    }

    $output = mw_get_login_links_by_service($productId, $serverId, $domain);

    if ($output['admin']) {
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
								' . $output['domain'] . '
						   </div>
						   <div class="col-md-7 col-xs-6 text-left">

						   <a class="btn btn-default" href="' . $output['admin'] . '" target="_blank"><i class="fa fa-user"></i> Login as [Admin]</a>
						   <a class="btn btn-success" href="' . $output['live_edit'] . '" target="_blank"><i class="fa fa-pencil"></i> Go to website [Live Edit]</a>

							</div>
					   </div>
				</div>
		   </div>';

        return $panel;
    }
}

add_hook('ClientAreaProductDetailsOutput', 1, function ($service) {
    return mw_client_area_output_html($service);
});

add_hook('ClientAreaPrimarySidebar', 1, function(WHMCS\View\Menu\Item $primarySidebar)
{
    GLOBAL $smarty;
    $ServiceActions = $primarySidebar->getChild('Service Details Actions');
    if (empty($ServiceActions)) {
        return;
    }
    $serviceId = (int) $_GET['id'];
    $service = \WHMCS\Service\Service::find($serviceId);
    $output = mw_get_login_links_by_service($service->id, $service->server, $service->domain);

    $ServiceActions->addChild('Cancel')->setLabel('Login as [Admin]')->setURI($output['admin'])->setAttribute('target','_blank')->setIcon('fa fa-key');
    $ServiceActions->addChild('Login as [Admin]')->setLabel('Go to website [Live Edit]')->setURI($output['live_edit'])->setAttribute('target','_blank')->setIcon('fa fa-pencil');
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


add_hook('DailyCronJob', 1, function ($vars) {
    $report = new \MicroweberAddon\UsageReport();
    $report->send();
});


/**
 * Hook sample for defining additional template variables
 *
 * @param array $vars Existing defined template variables
 *
 * @return array
 */
function hook_template_variables_mw_template_config_option($vars)
{
    $show_template_script = false;
    if (isset($vars['SCRIPT_NAME']) and strpos($vars['SCRIPT_NAME'], 'cart.php')) {
        if (isset($vars['configurableoptions']) and !empty($vars['configurableoptions'])) {
            foreach ($vars['configurableoptions'] as $item) {
                if (isset($item['optionname']) and strtolower($item['optionname']) == 'template') {
                    $show_template_script = $item;
                }
            }
        }

    }
    if ($show_template_script) {


        global $CONFIG;
        $html = '';

        $extraTemplateVariables = array();

        $templates_db = \WHMCS\Database\Capsule::table('mod_microweber_templates')
            ->where('is_enabled', 1)
            ->orderBy('preview_sort')
            ->get();


        $html .= "\n\n";
        if ($templates_db) {
            $html .= '<script>
                window.mw_templates = ' . json_encode($templates_db) . ';
                window.mw_templates_config_option_id = ' . $show_template_script['id'] . ';
                 </script>';

            $html .= "\n\n";
        }
        $whmcsurl_script =site_url() . 'modules/addons/microweber_addon/order/cart_configoptions.js';
        $html .= '<script src="' . $whmcsurl_script . '"></script>';
        $extraTemplateVariables['template_config_option_script'] = $html;


        return $extraTemplateVariables;
    }

}

add_hook('ClientAreaPageCart', 1, 'hook_template_variables_mw_template_config_option');
add_hook('ClientAreaPage', 1, function ($vars) {


//    $resellerCenterConnector = new \MicroweberAddon\ResellerCenterConnector();
//
//
//    $resellerCenterEnabled = $resellerCenterConnector->isEnabled();
//
//
//
//    $resellerCenterLang = $resellerCenterConnector->getSettingsForCurrentDomain();
//    var_dump($resellerCenterLang);
//    var_dump(111111111111111);
//    exit;
//    var_dump($resellerCenterLang);
//    var_dump(111111111111111);
//    exit;


    // swapLang('arabic');
//    global $smarty;
//    $whmcs = \App::self();
//    $smarty->assign("template", $whmcs->getClientAreaTemplate()->getName());
//   // $smarty->assign("language", \Lang::getName());
//    $smarty->assign("language",'german');


    // global $smarty;
    // $smarty->assign("activeCurrency", 'EUR');

    //  $whmcs = \WHMCS\Application::getInstance();
    // $activeCurrencyId = $whmcs->getCurrencyID();
    //  var_dump($whmcs);
    //  exit;
//    $currency = getCurrency();
//var_dump($currency);
//exit;

    //
});


//$_SESSION['Language'] = 'german';
add_hook('ClientAreaHeadOutput', 1, function ($vars) {


    $resellerCenterConnector = new \MicroweberAddon\ResellerCenterConnector();


    $resellerCenterEnabled = $resellerCenterConnector->isEnabled();

    if ($resellerCenterEnabled) {

        return <<<HTML
    <link href="/modules/addons/microweber_addon/integrations/resellercenter/site.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/modules/addons/microweber_addon/integrations/resellercenter/site.js"></script>
HTML;
    }


});
add_hook('ClientAreaHeadOutput', 1, function ($vars) {


    $resellerCenterConnector = new \MicroweberAddon\ResellerCenterConnector();


    $resellerCenterEnabled = $resellerCenterConnector->isEnabled();
     $resellerCenterEnabled = 0;
    if ($resellerCenterEnabled) {

        return <<<HTML
   <script type="text/javascript">
  var _jipt = [];
  _jipt.push(['preload_texts', true]);
  _jipt.push(['source_language', 'en']);
  
  

  _jipt.push(['project', 'microweber-cms']);
</script>
<script type="text/javascript" src="//cdn.crowdin.com/jipt/jipt.js"></script>
HTML;
    }


});


add_hook('ClientAreaPage', 23, function ($v) {

    if (isset($v['template']) and $v['template'] == 'lagom') {

        global $smarty;

//        [
//            'headline'=> 'Hosting 1',
//            'tagline' => 'headline',
//            'name' => 'name',
//            'pid'=> '19',
//            'slug' => 'asdasdsa'
//        ]
        if (Capsule::schema()->hasTable("rstheme_themes")) {
            $pageConfig = Capsule::table('rstheme_themes')->select('pages_configuration')->whereName('lagom')->first();
            if ($pageConfig and $v['templatefile'] == 'homepage') {
                $resellerCenterConnector = new \MicroweberAddon\ResellerCenterConnector();


                $resellerCenterEnabled = $resellerCenterConnector->isEnabled();

                if ($resellerCenterEnabled) {
                    $resellerProducts = $resellerCenterConnector->getProductsForCurrentDomain();
                    $banners_data = [];
                    if ($resellerProducts) {
                        foreach ($resellerProducts as $resellerProduct) {
                            $ready = [];
                            $ready['headline'] = $resellerProduct->name;
                        //    $ready['name'] = $resellerProduct->name;
                            $ready['name'] = $resellerProduct->getNameAttribute($resellerProduct->name);
                         //   $ready['tagline'] = $resellerProduct->description;
                            $ready['tagline'] = $resellerProduct->getDescriptionAttribute($resellerProduct->description);
                            $ready['pid'] = $resellerProduct->id;
                            $ready['slug'] = $resellerProduct->id;


                            $banners_data[] = $ready;
                        }
                    }


                    $smarty->assign('banner_home', $banners_data);
                }
            }
        }
    }
});



//
//
//# Translate Specific Language String Hook
//# Written by brian!
//
//function translate_specific_string_hook($vars) {
//
//    global $_LANG;
//    if ($vars['templatefile'] == "configureproductdomain" && $vars['pid'] == 45) {
//        $_LANG['cartexistingdomainchoice'] = "To Be Or Not To Be";
//        return array("LANG" => $_LANG);
//    }
//}
//add_hook("ClientAreaPageCart", 1, "translate_specific_string_hook");