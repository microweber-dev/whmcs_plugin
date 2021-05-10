<?php
if (!function_exists('get_whitelabel_settings')) {
    function get_whitelabel_settings()
    {
        $getSettings = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_whitelabel')
            //->where('setting', 'primary_color')
            ->get();
        $whitelabelSettings = [];
        foreach ($getSettings as $setting) {
            $whitelabelSettings[$setting->setting] = $setting->value;
        }
        return $whitelabelSettings;
    }
}

add_hook('ClientAreaHeadOutput', 1, function($vars) {

    $template = $vars['template'];
    $whitelabelSettings = get_whitelabel_settings();

    $primaryColor = "#0303ff";

    if (!empty($whitelabelSettings['primary_color'])) {
        $primaryColor = $whitelabelSettings['primary_color'];
    }

    return <<<HTML

<style>
.btn-link {
    color: $primaryColor !important;
}
.text-default {
    color: $primaryColor !important;
}
.text-primary {
    color: $primaryColor !important;
}
.main-whmcs-content .dataTables_wrapper .dataTables_info {
    background-color: $primaryColor;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.main-whmcs-content .dataTables_wrapper {
    border: 0px !important;
}
.table th {
    background: $primaryColor !important;
}
.main-whmcs-content .panel-sidebar > .panel-heading {
    background-color: $primaryColor;
    border-color: #0000001c;
}
.main-whmcs-content .panel-sidebar {
    border-color: #0000001c;
}
.main-whmcs-content a.list-group-item:focus, .main-whmcs-content a.list-group-item:hover, .main-whmcs-content button.list-group-item:focus, .main-whmcs-content button.list-group-item:hover {
    color: #0000001c !important;
    border-color: #0000001c !important;
}
.main-whmcs-content .list-group-item {
    border-color: #0000001c !important;
}
.btn-default,.btn-success {
    background: $primaryColor !important;
    border: 1px solid $primaryColor !important;
}
.main-whmcs-content a.list-group-item:focus, .main-whmcs-content a.list-group-item:hover, .main-whmcs-content button.list-group-item:focus, .main-whmcs-content button.list-group-item:hover {
    color: #000 !important;
 }
.btn-default-outline, .btn-default.focus, .btn-default:focus, .btn-default:hover {
    color: $primaryColor !important;
    border: 1px solid $primaryColor !important;
}
.header-inverse .navigation .menu .list > li > ul a:hover {
    background: $primaryColor;
}
.header-inverse .navigation .menu .list > li:hover > a, .header-inverse .navigation .menu .list > li > a:hover {
    color: $primaryColor !important;
}
.main-whmcs-content .domain-checker-container {
    background: $primaryColor !important;
}
.page-payments .subscription-block .review-order .rev-value {
    color: $primaryColor !important;
}
.page-payments .subscription-block:hover {
    -webkit-box-shadow: 0 0 10px $primaryColor !important;
    box-shadow: 0 0 10px $primaryColor !important;
}
.btn-default-outline.focus, .btn-default-outline:focus, .btn-default-outline:hover {
    background: $primaryColor !important;
    border: 1px solid $primaryColor !important;
}
.main-whmcs-content #registration .field, .main-whmcs-content #registration .form-control {
    color: $primaryColor !important;
}
.main-whmcs-content .panel.panel-accent-emerald {
    border-top: 3px solid $primaryColor !important;
}
.main-whmcs-content .label-success {
    background-color: $primaryColor !important;
}
.main-whmcs-content .bg-color-green {
    background-color: $primaryColor;
}
.not-whmcs-content .text-primary {
    color: $primaryColor !important;
}
.bxSlider-heading .bx-wrapper .bx-controls-direction a {
    border: 2px solid #575757 !important;
 }
.bxSlider-heading .bx-wrapper .bx-controls-direction a::before {
    color: #575757 !important;
}
.main-whmcs-content .label-default {
    background-color: $primaryColor !important;
}
</style>

HTML;

});

