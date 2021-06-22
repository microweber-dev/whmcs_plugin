<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use WHMCS\Product\Product as Product;

include_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers.php';


class MicroweberAddonOrderController
{

    function order_iframe($params)
    {


        if (isset($params['language']) and function_exists('swapLang')) {
            swapLang($params['language']);
        }

        if (isset($params['start_with_plan']) and isset($params['plan_id'])) {

            global $CONFIG;
            $whmcsurl = site_url();
            $domain = false;
            $redir_url = site_url() . 'cart.php?a=add';
            $redir_url = site_url() . 'cart.php?a=add';

            if (isset($params['sld']) and $params['sld']) {
                $redir_url .= '&sld=' . $params['sld'];
                $domain = $params['sld'];
            }

            if (isset($params['tld']) and $params['tld']) {
                $redir_url .= '&tld=' . $params['tld'];
                $domain = $domain . $params['tld'];
            }

            if (isset($params['domain']) and $params['domain']) {
                // $redir_url .= '&tld=' . $params['tld'];
                $domain = $params['domain'];
            }


            if (isset($params['plan_id']) and $params['plan_id']) {
                $redir_url .= '&pid=' . $params['plan_id'];
            }
            if (isset($params['subdomain']) and ($params['subdomain'] == 'true' or $params['subdomain'] == '1')) {
                $redir_url .= '&domainoption=subdomain';
            }


            //

            if (isset($params['template_id']) and $params['template_id']) {
                if (isset($params['config_gid']) and $params['config_gid']) {
                    $redir_url .= '&configoption[' . $params['config_gid'] . ']=' . $params['template_id'];
                }
                if (isset($params['subdomain']) and $params['subdomain'] == 'false') {
                    $redir_url .= '&skipconfig=1';
                    $redir_url .= '&showdomainoptions=0';
                    $redir_url .= '&domainselect=1';
                    $redir_url .= '&domainoption=register';
                    $redir_url .= '&regperiod=1';
                    // $redir_url .= '&regperiod=1';
                    //$redir_url .= '&domainoption=incart';
                    if ($domain) {
                            $redir_url .= '&domain=' . $domain;
                    }
                } else {
                    $redir_url .= '&skipconfig=1';

                }

            }

            if (isset($params['language']) and $params['language']) {
                $redir_url .= '&language=' . $params['language'];
            }

            if (isset($params['currency']) and $params['currency']) {
                $redir_url .= '&currency=' . $params['currency'];
            }



            if ($redir_url) {

                print '
                <script type="text/javascript">
                 if (window.top != window.self){
                    window.top.location.href = "' . $redir_url . '"
                } else {
                    window.location.href = "' . $redir_url . '"
                }
                </script>';
                exit;
            }


        }


        include __DIR__ . "/order/index.php";
        exit;
    }


}
