<?php

require_once (__DIR__ . '/vendor/autoload.php');


 require_once (__DIR__ . DIRECTORY_SEPARATOR . 'helpers.php');

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
    $whmcsurl =$CONFIG['SystemURL'].'/';

    if ($client_product_id) {
        $domain .= '&client_product_id=' . $client_product_id;
    }

    return $whmcsurl . '/index.php?m=microweber_addon&function=go_to_product&live_edit=1&domain=' . $domain;
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

add_hook('ClientAreaHeadOutput', 1, function($vars) {
    return '<script src="modules/addons/microweber_addon/whmcs_products_checker.js"></script>';
});

add_hook('ClientAreaPage', 23, function ($v) {

    global $smarty;

    $overwriteServices = [];
    foreach ($v['services'] as $service) {

        $configOptionsData = \WHMCS\Database\Capsule::table("tblproductconfigoptions")
            ->join("tblhostingconfigoptions", "tblproductconfigoptions.id", "=", "tblhostingconfigoptions.configid")
            ->join("tblproductconfigoptionssub", "tblproductconfigoptionssub.id", "=", "tblhostingconfigoptions.optionid")
            ->where("tblhostingconfigoptions.relid", "=", $service['id'])
            ->first(array("tblproductconfigoptions.optionname as productConfigOptionName", "tblproductconfigoptions.optiontype", "tblproductconfigoptionssub.optionname", "tblhostingconfigoptions.qty"));

        if (!isset($configOptionsData->productConfigOptionName) && $configOptionsData->productConfigOptionName != 'Template') {
            $overwriteServices[] = $service;
            continue;
        }

        if (isset($service['sslStatus']) && $service['sslStatus'] != null) {

            $mustBeChecked = false;
            if(is_null($service['sslStatus']->lastSyncedDate)) {
                $mustBeChecked = true;
            } else {
                if ($service['sslStatus']->lastSyncedDate instanceof \WHMCS\Carbon && $service['sslStatus']->lastSyncedDate->diffInHours() < 24) {
                    $mustBeChecked = true;
                }
            }

            if (method_exists($service['sslStatus'], 'isActive')) {
                if ($service['sslStatus']->isActive() == false && $mustBeChecked) {
                    $service['product'] = $service['product'] . ' &nbsp;&nbsp; <br /> <span class="small js-domain-check-is-ready" data-service-id="' . $service['id'] . '">' . $service['domain'] . '</span>  &nbsp;&nbsp;<img src="modules/addons/microweber_addon/circle-loading.gif" />';
                    $service['domain'] = false;
                    $service['status'] = 'Pending';
                    $service['statustext'] = 'Building website';  
                }
            }
        }

        $overwriteServices[] = $service;
    }
    
    // Reorder services
    usort($overwriteServices, function ($a, $b){
        $t2 = strtotime($a['regdate']);
        $t1 = strtotime($b['regdate']);
       // return $t1 - $t2;
        return $t1 - $t2;
    });

    $v['services'] = $overwriteServices;

    if (isset($v['template']) and $v['template'] == 'lagom') {

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

    return $v;
});



