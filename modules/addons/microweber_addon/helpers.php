<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use MicroweberAddon\MarketplaceConnector;


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


if (!function_exists('lang_trans')) {
    function lang_translate_key($key)
    {
        global $_LANG;

        $text = $key;

        $text = \Lang::get($key);


//        if(isset($_LANG[$key])){
//            $text = $_LANG[$key];
//        }

        return $text;

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
    return is_https();
}


if (!function_exists('is_https')) {
    function is_https()
    {
        if (isset($_SERVER['HTTPS']) and (strtolower($_SERVER['HTTPS']) == 'on' or $_SERVER['HTTPS'] == '1')) {
            return true;
        } else if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and (strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https')) {
            return true;
        } else if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) and (strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) == 'on' or $_SERVER['HTTP_X_FORWARDED_SSL'] == '1')) {
            return true;
        } else if (isset($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO']) and (strtolower($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO']) == 'https')) {
            return true;
        } else if (isset($_SERVER['HTTP_X_PROTO']) and (strtolower($_SERVER['HTTP_X_PROTO']) == 'ssl')) {
            return true;
        } else if (isset($_SERVER['HTTP_CF_VISITOR']) and strpos($_SERVER["HTTP_CF_VISITOR"], "https")) {
            return true;
        }
        return false;
    }

}


if (!function_exists('site_url')) {
    function site_url($add_string = false)
    {
        static $site_url;


        if ($site_url == false) {
            $pageURL = 'http';
            if (is_https()) {
                $pageURL .= 's';
            }
            $subdir_append = false;
            if (isset($_SERVER['PATH_INFO'])) {
                // $subdir_append = $_SERVER ['PATH_INFO'];
            } elseif (isset($_SERVER['REDIRECT_URL'])) {
                $subdir_append = $_SERVER['REDIRECT_URL'];
            }

            $pageURL .= '://';

            if (isset($_SERVER['HTTP_HOST'])) {
                $pageURL .= $_SERVER['HTTP_HOST'];
            } elseif (isset($_SERVER['SERVER_NAME']) and isset($_SERVER['SERVER_PORT']) and $_SERVER['SERVER_PORT'] != '80' and $_SERVER['SERVER_PORT'] != '443') {
                $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
            } elseif (isset($_SERVER['SERVER_NAME'])) {
                $pageURL .= $_SERVER['SERVER_NAME'];
            } elseif (isset($_SERVER['HOSTNAME'])) {
                $pageURL .= $_SERVER['HOSTNAME'];
            }
            $pageURL_host = $pageURL;
            $pageURL .= $subdir_append;
            $d = '';
            if (isset($_SERVER['SCRIPT_NAME'])) {
                $d = dirname($_SERVER['SCRIPT_NAME']);
                $d = trim($d, DIRECTORY_SEPARATOR);
            }

            if ($d == '') {
                $pageURL = $pageURL_host;
            } else {
                $pageURL_host = rtrim($pageURL_host, '/') . '/';
                $d = ltrim($d, '/');
                $d = ltrim($d, DIRECTORY_SEPARATOR);
                $pageURL = $pageURL_host . $d;
            }
            if (isset($_SERVER['QUERY_STRING'])) {
                //    $pageURL = str_replace($_SERVER['QUERY_STRING'], '', $pageURL);
            }

            $uz = parse_url($pageURL);
//            if (isset($uz['query'])) {
//                $pageURL = str_replace($uz['query'], '', $pageURL);
//                $pageURL = rtrim($pageURL, '?');
//            }

            $url_segs = explode('/', $pageURL);

            $i = 0;
            $unset = false;
            foreach ($url_segs as $v) {
                if ($unset == true and $d != '') {
                    unset($url_segs[$i]);
                }
                if ($v == $d and $d != '') {
                    $unset = true;
                }

                ++$i;
            }
            $url_segs[] = '';
            $site_url = implode('/', $url_segs);
        }

        if (!$site_url) {
            $site_url = 'http://localhost/';
        }

        return $site_url . $add_string;
    }
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
if (!function_exists('user_ip')) {

    function user_ip()
    {
        $ipaddress = '127.0.0.1';

        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }

        return $ipaddress;
    }

}

function insert_template_by_git_package_name($name)
{
    $insert = Capsule::table('mod_microweber_templates')
        ->insert([
            'git_package_name' => $name,
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

    if ($insert) {
        return get_template_by_git_package_name($name);
    }
}

function get_template_by_git_package_name($name)
{
    return Capsule::table('mod_microweber_templates')
        ->where('git_package_name', $name)
        ->first();
}

function get_enabled_templates()
{
    $templates =  Capsule::table('mod_microweber_templates')
        ->where('is_enabled', 1)
        ->orderBy('preview_sort')
        ->get()->toArray();

    return $templates;

//    $ready = [];
//
//    $marketplace_connector = new MarketplaceConnector();
//
//
//    $marketplace_templates = $marketplace_connector->get_templates();
//
//    var_dump($marketplace_templates);
//    exit;
//
//    //has_custom_settings
//    if($templates){
//        foreach ($templates as $template){
//            $item = $template;
//            if(!$item->has_custom_settings){
//                if($marketplace_templates) {
//                    foreach ($templates as $template) {
//                        $item = $template['latest_version'];
//                        $get_template = get_template_by_git_package_name($item['name']);
//
//                    }
//                }
//
//            }
//
//            $ready[] = $item;
//        }
//    }
//
//    var_dump($ready);
//    exit;
//
//    return collect($ready);









}

