<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class MicroweberAddonDomainSearch
{

    function domain_search($params)
    {
var_dump($params);

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


    }

    function domain_suggest()
    {
        $query = "SELECT setting,value FROM `tblregistrars` WHERE registrar='enom' AND (setting='Username' OR setting='Password')";
        $result = mysql_query($query) or die(mysql_error());
        while ($row = @mysql_fetch_array($result)) {
            $setting = $row['setting'];
            $enom[$setting] = $row['value'];
        }
        $enomid = decrypt($enom['Username']);
        $enompw = decrypt($enom['Password']);
        $maxspins = 10;

        if (isset($the_request['domain'])) {
            $tld = $the_request['domain'];
        }

        //Do not edit this. We're setting up the URL to retrieve the spins
        $namespinnerurl = "https://reseller.enom.com/interface.asp?command=namespinner&uid=" . $enomid . "&pw=" . $enompw . "&TLD=" . $tld . "&SensitiveContent=true" . "&MaxResults=" . $maxspins . "&ResponseType=XML";
//        var_dump($namespinnerurl);
        // Use cURL to get the XML response
        $ch = curl_init($namespinnerurl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $xml = curl_exec($ch);
        $curlerror = "ErrNo: " . curl_errno($ch) . " ErrMsg: " . curl_error($ch);
        curl_close($ch);

        if ($xml) {
            $spinnerresults = new SimpleXmlElement($xml, LIBXML_NOCDATA);

            if ($spinnerresults->ErrCount == 0) {
                for ($i = 0; $i < $maxspins; $i++) {
                    if ($showdotcom && (string)$spinnerresults->namespin->domains->domain[$i]['com'] == "y")
                        $spinner[] = array(
                            'domain' => (string)$spinnerresults->namespin->domains->domain[$i]['name'] . ".com",
                            'netscore' => (int)$spinnerresults->namespin->domains->domain[$i]['comscore'],
                            'tld' => '.com');
                    if ($showdotnet && (string)$spinnerresults->namespin->domains->domain[$i]['net'] == "y")
                        $spinner[] = array(
                            'domain' => (string)$spinnerresults->namespin->domains->domain[$i]['name'] . ".net",
                            'netscore' => (int)$spinnerresults->namespin->domains->domain[$i]['netscore'],
                            'tld' => '.net');
                    if ($showdotcc && (string)$spinnerresults->namespin->domains->domain[$i]['cc'] == "y")
                        $spinner[] = array(
                            'domain' => (string)$spinnerresults->namespin->domains->domain[$i]['name'] . ".cc",
                            'netscore' => (int)$spinnerresults->namespin->domains->domain[$i]['ccscore'],
                            'tld' => '.cc');
                    if ($showdottv && (string)$spinnerresults->namespin->domains->domain[$i]['tv'] == "y")
                        $spinner[] = array(
                            'domain' => (string)$spinnerresults->namespin->domains->domain[$i]['name'] . ".tv",
                            'netscore' => (int)$spinnerresults->namespin->domains->domain[$i]['tvscore'],
                            'tld' => '.tv');
                }
                $gotnamespinner = true;
            } else {
                if ($debug) echo $spinnerresults->errors->Err1;
                $gotnamespinner = false;
            }
        }
    }


}