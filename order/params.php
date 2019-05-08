<?php
$name = false;
if (isset($template['name'])) {
    $name = $template['name'];
}

$pid = '';
if (isset($_GET['plan'])) {
    $pid = htmlspecialchars($_GET['plan']);
}

$plan = false;
if (isset($_GET['plan'])) {
    $plan = htmlspecialchars($_GET['plan']);
}

$domain = false;
if (isset($_GET['domain'])) {
    $domain = htmlspecialchars($_GET['domain']);
}

$sld = '';
if (isset($_GET['sld'])) {
    $sld = htmlspecialchars($_GET['sld']);
}

$tld = '';
if (isset($_GET['tld'])) {
    $tld = htmlspecialchars($_GET['tld']);
}

$subdomain = false;
if (isset($_GET['subdomain']) AND $_GET['subdomain'] != 'false') {
    $subdomain = true;
}

$templateID = 1;
if (isset($_GET['template_id'])) {
    $templateID = htmlspecialchars($_GET['template_id']);
}
