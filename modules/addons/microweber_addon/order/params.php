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

$target = '';
if (isset($_GET['target'])) {
    $target = htmlspecialchars($_GET['target']);
}

$style = '';
if (isset($_GET['style'])) {
    $style = htmlspecialchars($_GET['style']);
}

$templates_style = '';
if (isset($_GET['templates-style'])) {
    $templates_style = htmlspecialchars($_GET['templates-style']);
}

$template_preview_style = '';
if (isset($_GET['template-preview-style'])) {
    $template_preview_style = htmlspecialchars($_GET['template-preview-style']);
}

$domain_style = '';
if (isset($_GET['domain-style'])) {
    $domain_style = htmlspecialchars($_GET['domain-style']);
}

$plan_style = '';
if (isset($_GET['plan-style'])) {
    $plan_style = htmlspecialchars($_GET['plan-style']);
}

$subdomain = false;
if (isset($_GET['subdomain']) AND $_GET['subdomain'] != 'false') {
    $subdomain = true;
}
if (!isset($template_id)) {
    $template_id = 0;
}

if (isset($_GET['template_id'])) {
    $template_id = intval($_GET['template_id']);
}

if (!isset($config_gid)) {
    $config_gid = 0;
}
if (isset($_GET['config_gid'])) {
    $config_gid = intval($_GET['config_gid']);
}
