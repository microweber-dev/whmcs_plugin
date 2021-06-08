<?php
$name = false;
if (isset($template->git_package_name)) {
    $name = $template->git_package_name;
}

$pid = '';
if (isset($_REQUEST['plan'])) {
    $pid = htmlspecialchars($_REQUEST['plan']);
}

$plan = false;
if (isset($_REQUEST['plan'])) {
    $plan = htmlspecialchars($_REQUEST['plan']);
}

$domain = false;
if (isset($_REQUEST['domain'])) {
    $domain = htmlspecialchars($_REQUEST['domain']);
}

$sld = '';
if (isset($_REQUEST['sld'])) {
    $sld = htmlspecialchars($_REQUEST['sld']);
}

$tld = '';
if (isset($_REQUEST['tld'])) {
    $tld = htmlspecialchars($_REQUEST['tld']);
}

$target = '';
if (isset($_REQUEST['target'])) {
    $target = htmlspecialchars($_REQUEST['target']);
}

$style = '';
if (isset($_REQUEST['style'])) {
    $style = htmlspecialchars($_REQUEST['style']);
}

$templates_style = '';
if (isset($_REQUEST['templates-style'])) {
    $templates_style = htmlspecialchars($_REQUEST['templates-style']);
}

$template_preview_style = '';
if (isset($_REQUEST['template-preview-style'])) {
    $template_preview_style = htmlspecialchars($_REQUEST['template-preview-style']);
}

$domain_style = '';
if (isset($_REQUEST['domain-style'])) {
    $domain_style = htmlspecialchars($_REQUEST['domain-style']);
}

$plan_style = '';
if (isset($_REQUEST['plan-style'])) {
    $plan_style = htmlspecialchars($_REQUEST['plan-style']);
}

$subdomain = false;
if (isset($_REQUEST['subdomain']) AND $_REQUEST['subdomain'] != 'false') {
    $subdomain = true;
}
if (!isset($template_id)) {
    $template_id = 0;
}

if (isset($_REQUEST['template_id'])) {
    $template_id = intval($_REQUEST['template_id']);
}

if (!isset($config_gid)) {
    $config_gid = 0;
}
if (isset($_REQUEST['config_gid'])) {
    $config_gid = intval($_REQUEST['config_gid']);
}


