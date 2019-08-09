<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class MicroweberAddonApiController
{

    public function check_connection($params = false)
    {
        return $params;
    }


    public function login_to_my_website($params)
    {


        $the_request = $params;


        if (!isset($the_request['email']) and isset($the_request['username'])) {
            $the_request['email'] = $the_request['username'];
        }

        if (!isset($the_request['email']) or !isset($the_request['password2']) or !isset($the_request['domain'])) {
            return;
        }


        $parsedom = @parse_url($the_request['domain']);

        if (isset($parsedom['host'])) {
            $host = $parsedom['host'];
        } else {
            $host = $the_request['domain'];
        }


        $values = array();
        $values["email"] = $the_request['email'];

        $values["password2"] = $the_request['password2'];
        $validatelogin = localAPI('validatelogin', $values);


        if (!isset($validatelogin['userid'])) {
            $values = array();
            $values["email"] = $the_request['email'];
            $values["password2"] = $the_request['password2'];
            $validatelogin = localAPI('validatelogin', $values);

        }
        if (!isset($validatelogin['userid'])) {
            $hostingProduct = Capsule::table('tblhosting')
                ->where('domain', '=', $host)->first();


            if ($hostingProduct->id and $hostingProduct->password) {

                $command = 'DecryptPassword';
                $postData = array(
                    'password2' => $hostingProduct->password,
                );

                $results_passwd = localAPI($command, $postData);

                if (isset($results_passwd['password']) and $the_request['password2'] == $results_passwd['password']) {

                    $validatelogin['userid'] = $hostingProduct->userid;
                } else if (!isset($results_passwd['password'])) {
                    return;
                } else {
                   // $validatelogin['userid'] = $hostingProduct->userid;
                }


                // print_r($results_passwd);


            }
        }


//        var_dump($validatelogin);
//        exit;

        if (isset($validatelogin['result']) and $validatelogin['result'] == 'error' and !isset($validatelogin['userid'])) {
             return;
        }

        if (!isset($validatelogin['userid'])) {
            return;
        }




        $command = "getclientsproducts";
        $values = array();
        $values["clientid"] = $validatelogin['userid'];
        $values["limitnum"] = 99999;

        $results = localAPI($command, $values);


        if (!empty($results) and isset($results['products'])) {
            $prodsucts = $results['products']['product'];
            if (!empty($prodsucts)) {
                foreach ($prodsucts as $prodsuct) {

                    if (!empty($prodsuct) and isset($prodsuct['domain'])) {

                        if (strtolower($host) == strtolower($prodsuct['domain'])) {
                            $values = array();
                            $values["result"] = 'success';
                            $values["userid"] = $validatelogin['userid'];
                            $values["hosting_data"] = $prodsuct;

                            return $values;
                        }
                    }


                }


            }

        }

    }


    function get_domain_template_config($params)
    {
        global $CONFIG;
        global $autoauthkey;
        if (!isset($params['domain'])) {
            return;
        }


        $username = $this->__db_escape_string($params['domain']);


        $query = "
select
  c.id AS userid, h.id AS serviceid, pcos.optionname AS template
FROM
  tblhosting h, tblclients c, tblproducts p, tblproductconfigoptionssub pcos, tblproductconfigoptions pco, tblhostingconfigoptions hco
WHERE
  pcos.configid = pco.id AND
  hco.configid = pco.id AND
  hco.optionid = pcos.id AND
  hco.relid = h.id AND
  c.id = h.userid AND
  p.id = h.packageid AND
h.domain = '" . $username . "' and
  pco.optionname = 'Template'  limit 1";


//        $query = "SELECT
//	c.id AS userid,
//	h.id AS serviceid,
//	pcos.optionname AS template
//FROM
//	tblhosting h,
//	tblclients c,
//	tblproducts p,
//	tblproductconfigoptionssub pcos,
//	tblproductconfigoptions pco,
//	tblhostingconfigoptions hco
//WHERE
//h.domain = '" . $username . "'
//and pco.optionname = 'Template'
//AND pcos.configid = pco.id
//AND hco.configid = pco.id
//AND hco.optionid = pcos.id
//AND c.id = h.userid
//AND p.id = h.packageid
//LIMIT 1" ;
//
//


// si ebalo majkata
        $dom_data = Capsule::select($query);
        // dd($dom_data);

        if ($dom_data) {
            foreach ($dom_data as $dom_item) {
                return (array)$dom_item;

            }
        }

    }


    public function go_to_product($params)
    {


        global $CONFIG;
        global $autoauthkey;


        $whmcsurl = $CONFIG['SystemURL'];

        $ajax = false;
        if (isset($_REQUEST['ajax'])) {
            $ajax = true;
        }


        if (!isset($_SESSION['uid'])) {
            // redir("", "index.php");

            $pagetitle = 'Login to website';
            $pageicon = "images/support/clientarea.gif";
            $breadcrumbnav = '<a href="index.php">' . 'Client area' . '</a>';
            $breadcrumbnav .= ' > <a href="#">Login to view product</a>';

            initialiseClientArea($pagetitle, $pageicon, $breadcrumbnav);

            if ($_SESSION['uid']) {
                # User is Logged In - put any code you like here
            }
            $_SESSION['loginurlredirect'] = $_SERVER['REQUEST_URI'];


            //$smartyvalues["login_to_domain"] = $value;


            $templatefile = "login";

            outputClientArea($templatefile);

            return;
        }

        $redir_link = false;
        $is_site_found = false;
        $pids = array();
        if (isset($_REQUEST['id'])) {
            $pids[] = intval($_REQUEST['id']);
        }
        if (isset($_REQUEST['domain'])) {
            $dom = $_REQUEST['domain'];
            if (false === strpos($dom, '://')) {
                $dom = 'http://' . $dom;
            }
            $dom = parse_url($dom);
            if (isset($dom['host'])) {
                $uid = $_SESSION['uid'];
                $command = "getclientsproducts";
                $values = array();
                $values["clientid"] = $uid;
                $values["domain"] = $dom['host'];
                $values["limitnum"] = 199;
                $results = localAPI($command, $values);
                if (!empty($results) and isset($results['products'])) {
                    $prodsucts = $results['products']['product'];
                    if (!empty($prodsucts)) {
                        foreach ($prodsucts as $prodsuct) {
                            if (!empty($prodsuct) and isset($prodsuct['domain'])) {
                                $pids[] = intval($prodsuct['id']);
                            }
                        }
                    }
                }
            }
        }


        if (isset($_REQUEST['username2'])) {
            $username2 = $_REQUEST['username2'];
            $username2 = strip_tags($username2);

            if ($username2) {
                $uid = $_SESSION['uid'];
                $command = "getclientsproducts";
                $values = array();
                $values["clientid"] = $uid;
                $values["username2"] = $username2;
                $values["limitnum"] = 199;
                $results = localAPI($command, $values);

                if (!empty($results) and isset($results['products'])) {
                    $prodsucts = $results['products']['product'];
                    if (!empty($prodsucts)) {
                        foreach ($prodsucts as $prodsuct) {
                            if (!empty($prodsuct) and isset($prodsuct['domain'])) {
                                $pids[] = intval($prodsuct['id']);
                            }
                        }
                    }
                }
            }
        }


        if (isset($_GET['action']) and isset($_SESSION['uid'])) {

            $act = strip_tags($_GET['action']);
            $first_pid_url = 'clientarea.php?action=' . $act;

            $response = whm_hook_get_client_info_by_id($_SESSION['uid']);
            if (isset($response['email'])) {
                $whmcsurl = $whmcsurl . "/dologin.php";


                $timestamp = time(); # Get current timestamp
                $email = $response['email']; # Clients Email Address to Login
                $email = urlencode($email);
                $hash = sha1($email . $timestamp . $autoauthkey); # Generate Hash
                $goto = $first_pid_url;
                $url = $whmcsurl . "?email=$email&timestamp=$timestamp&hash=$hash&goto=" . urlencode($goto);

                header("Location: $url");
                exit;
            }


            exit;


        }

        if (isset($_REQUEST['orderid'])) {
            $command = 'GetOrders';
            $postData = array(
                'id' => intval($_REQUEST['orderid']),
                'userid' => $_SESSION['uid'],
            );

            $results = localAPI($command, $postData);
            if (isset($results['orders']) and !empty($results['orders'])) {
                $orders = $results['orders'];
                foreach ($orders as $ord_i) {
                    foreach ($ord_i as $ord) {

                        if (isset($ord['lineitems'])) {
                            foreach ($ord['lineitems'] as $itm_i) {
                                foreach ($itm_i as $itm) {
                                    if (isset($itm['relid'])) {
                                        $pids[] = $itm['relid'];
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }

        }


        if (!$pids) {
            $pagetitle = "Error";

            return;

            //  exit('not found');
        }


        $found_prods = array();
        if (isset($_SESSION['uid'])) {
            foreach ($pids as $pid) {
                $uid = $_SESSION['uid'];
                $command = "getclientsproducts";
                $values = array();
                $values["clientid"] = $uid;
                $values["limitnum"] = 99999;
                $values2 = $values;
                $values["pid"] = $pid;
                $results = localAPI($command, $values);
                if (isset($results['numreturned']) and $results['numreturned'] == 0) {
                    $values2["serviceid"] = $pid;
                    $results = localAPI($command, $values2);

                }
                if (!empty($results) and isset($results['products'])) {
                    $prodsucts = $results['products']['product'];
                    if (!empty($prodsucts)) {
                        foreach ($prodsucts as $prodsuct) {
                            if (!empty($prodsuct) and isset($prodsuct['domain'])) {
                                $values = array();
                                $values["result"] = 'success';
                                $values["userid"] = $uid;
                                $values["hosting_data"] = $prodsuct;
                                $found_prods[] = $prodsuct;
                            }

                        }
                    }
                }
            }


        }
        $first_pid = false;
        $domain_found = false;
        if ($found_prods) {
            $first_pid = reset($found_prods);
            foreach ($found_prods as $found_prod) {

                if (!$domain_found and isset($found_prod['groupname']) and stristr($found_prod['groupname'], 'hosting')) {
                    if (isset($found_prod['username']) and isset($found_prod['password'])) {
                        $domain_found = $found_prod;


                    }
                }

            }
        }


        if (!$domain_found) {
            if ($ajax) {
                header("Content-type:application/json");
                print json_encode($first_pid);
                exit;
            }
            if ($first_pid and isset($first_pid['id'])) {
                $first_pid_url = 'clientarea.php?action=productdetails&id=' . $first_pid['id'];
                if (isset($first_pid['groupname'])) {
                    if (stristr($first_pid['groupname'], 'template')) {
                        $first_pid_url = 'https://microweber.com/profile/section:templates?id=' . $first_pid['id'];
                    }
                    if (stristr($first_pid['groupname'], 'module')) {
                        $first_pid_url = 'https://microweber.com/profile/section:modules?id=' . $first_pid['id'];
                    }
                }

                header("Location: " . $first_pid_url);
                exit;
            } else {
                redir("", "index.php");
            }

        } else {
            //$domain_found
            $user_prod = $domain_found;
            if ($ajax) {
                header("Content-type:application/json");
                print json_encode($user_prod);
                exit;
            }
            if (isset($user_prod['username'])) {
                if (isset($user_prod['password'])) {
                    $url = "http://" . $user_prod['domain'] . "/api/user_login";
//            $url .= "?username=" . $user_prod['username'];
//            $url .= "&password=" . $user_prod['password'];

                    $url .= "?username_base64=" . base64_encode($user_prod['username']);
                    $url .= "&password_base64=" . base64_encode($user_prod['password']);

                    if (isset($params['live_edit'])) {
                        $url .= "&redirect=" . "http://" . $user_prod['domain'] . "/?editmode=y";
                    } else {
                        $url .= "&redirect=" . "http://" . $user_prod['domain'] . "/admin/view:content";
                    }
                    $url .= "&redirect=" . "http://" . $user_prod['domain'] . "/?editmode=y";

                    header("Location: " . $url);
                    exit;
                }
            }


        }

        return;
    }


// $params['email']
    public function check_if_user_has_purchased_product($params)
    {
        //var_dump($params);
        if (isset($params['email']) and $userid = $this->_get_user_id_by_email($params['email'])) {
            //  var_dump($userid);
            $pids = $this->_get_user_purchased_products($userid);
            if ($pids) {
                // var_dump($pids);
                if (isset($params['pid'])) {
                    $check_pids = explode(',', $params['pid']);
                    if ($check_pids) {
                        $check_pids = array_map('intval', $check_pids);
                        //  .. var_dump($check_pids);
                        //   var_dump($pids);
                        foreach ($check_pids as $check_pid) {
                            foreach ($pids as $pid) {
                                if ($pid == $check_pid) {
                                    return array('result' => 'success', 'pid' => $pid);
                                }
                            }
                        }
                    }
                }
            }

        }

    }


    function domain_search($params)
    {


        /*
         * https://developers.whmcs.com/domain-registrars/availability-checks/
         *
         *  searchTerm	string	The search term provided by the end user
            punyCodeSearchTerm	string	For an IDN domain, the puny code encoded search term
            tldsToInclude	array	An array of TLDs/extensions to perform the availability check for
            isIdnDomain	bool	If IDN Domains are enabled for this WHMCS installation
            premiumEnabled
        */

// registrarmodule_GetDomainSuggestions($params)

        $search_term = '';


        $search = new MicroweberAddonDomainSearch();


        return $search->domain_search($params);


    }


    function get_hosting_products()
    {


        //$query = "SELECT * FROM `tblproducts` WHERE type='hostingaccount' and hidden<>'on' order by tblproducts.order desc  ";
        $query = "SELECT * FROM `tblproducts` WHERE
type='hostingaccount' and hidden!=1 and showdomainoptions=1 and retired=0  order by tblproducts.order asc  ";


        $result_q = Capsule::select($query);


        $products = array();


        if ($result_q) {
            foreach ($result_q as $item) {
                $products[] = (array)$item;

            }
        }


        if (!empty($products)) {

            foreach ($products as $k => $row) {


                $query = "SELECT * FROM `tblpricing` where
              tblpricing.type = 'product'

            and relid='{$row['id']}'



             limit 1  ";

                $result_pricing = Capsule::select($query);


                $prices = array();


                if ($result_pricing) {
                    foreach ($result_pricing as $item) {
                        $prices[] = (array)$item;

                    }
                }

                $row['pricing'] = $prices;
                $products[$k] = $row;
            }


        }
        $result = $products;
        return $result;
    }


    private function _get_user_purchased_products($client_id)
    {

        $pids = array();
        $uid = $client_id;
        $command = "getclientsproducts";
        $values = array();
        $values["clientid"] = $uid;
        $values["limitnum"] = 999;
        $results = localAPI($command, $values);

        if (!empty($results) and isset($results['products'])) {
            $prodsucts = $results['products']['product'];
            if (!empty($prodsucts)) {
                foreach ($prodsucts as $prodsuct) {
                    //   var_dump($prodsucts);
                    if (!empty($prodsuct) and isset($prodsuct['pid'])) {
                        $pids[] = intval($prodsuct['pid']);
                    }

                }
            }
        }


        $command = 'GetOrders';
        $postData = array(
            'userid' => $uid,
        );

        $results = localAPI($command, $postData);
        if (isset($results['orders']) and !empty($results['orders'])) {
            $orders = $results['orders'];
            foreach ($orders as $ord_i) {
                foreach ($ord_i as $ord) {

                    if (isset($ord['lineitems'])) {
                        foreach ($ord['lineitems'] as $itm_i) {
                            foreach ($itm_i as $itm) {
                                if (isset($itm['relid'])) {
                                    $pids[] = $itm['relid'];
                                }
                            }
                        }
                    }
                }
            }
        } else {

        }


        if ($pids) {
            $pids_copy = $pids;
            foreach ($pids_copy as $pid) {

                $command = "getclientsproducts";
                $values = array();
                $values["clientid"] = $uid;
                $values["limitnum"] = 99999;
                $values2 = $values;
                $values["pid"] = $pid;
                $results = localAPI($command, $values);
                if (isset($results['numreturned']) and $results['numreturned'] == 0) {
                    $values2["serviceid"] = $pid;
                    $results = localAPI($command, $values2);

                }

                if (!empty($results) and isset($results['products'])) {
                    $prodsucts = $results['products']['product'];
                    if (!empty($prodsucts)) {
                        foreach ($prodsucts as $prodsuct) {

                            if (!empty($prodsuct) and isset($prodsuct['pid'])) {
                                $pids[] = $prodsuct['pid'];
                            }

                        }
                    }
                }
            }

        }
        if ($pids and !empty($pids)) {
            $pids = array_unique($pids);
            return $pids;
        }

    }

    private function _get_user_id_by_email($email)
    {


        $email = urldecode($email);

        $command = 'GetClientsDetails';
        $postData = array(
            'email' => $email,

        );


        $results = localAPI($command, $postData);

        if (isset($results['result']) and $results['result'] == 'success') {
            if (isset($results['userid']) and $results['userid']) {
                return intval($results['userid']);
            }
        }


    }

    private function __db_escape_string($value)
    {

        if (!is_string($value)) {
            return $value;
        }


        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
        $new = str_replace($search, $replace, $value);
        $new = addslashes($new);
        return $new;
    }


}