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
    $darkColor = "#2d2d2d";
    $whiteColor = "#ffffff";

    if (!empty($whitelabelSettings['primary_color'])) {
        $primaryColor = $whitelabelSettings['primary_color'];
    }
    if (!empty($whitelabelSettings['dark_color'])) {
        $darkColor = $whitelabelSettings['dark_color'];
    }
    if (!empty($whitelabelSettings['white_color'])) {
        $whiteColor = $whitelabelSettings['white_color'];
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
    border: 2px solid $darkColor !important;
 }
.bxSlider-heading .bx-wrapper .bx-controls-direction a::before {
    color: $darkColor !important;
}
.main-whmcs-content .label-default {
    background-color: $primaryColor !important;
}
.main-whmcs-content .input-group-lg > .form-control, .main-whmcs-content .input-group-lg > .input-group-addon, .main-whmcs-content .input-group-lg > .input-group-btn > .btn {
    height: 60px !important;
}
.bxSlider-heading .bx-wrapper .bx-pager.bx-default-pager a.active, .bxSlider-heading .bx-wrapper .bx-pager.bx-default-pager a:hover {
    background: $primaryColor !important;
}
.section-7 h1, .section-7 h2, .section-7 h3 {
    color: $darkColor;
}
.section-7 p {
    color: $darkColor;
}
.header-inverse .navigation .menu .list > li > a {
    color: $darkColor;
}
footer {
    background-color: $darkColor !important;
}
.btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .show > .dropdown-toggle.btn-default.focus, .show > .dropdown-toggle.btn-default:focus, .show > .dropdown-toggle.btn-default:hover {
    color: #fff !important;
    background: $primaryColor !important;
}
.btn-link.focus, .btn-link:focus, .btn-link:hover {
    color: $darkColor !important;
}
.not-whmcs-content .dropdown-item.active, .not-whmcs-content .dropdown-item:active {
    background-color: $primaryColor;
}
#order-modern .domainoptions .optionselected .radio-inline {
    color: $primaryColor !important;
}
.main-whmcs-content .input-group-addon {
    border-color: #0000001c !important;
}
.accordions .panel-title > .small, .accordions .panel-title > .small > a, .accordions .panel-title > small, .accordions .panel-title > small > a, .panel-title > a {
    color: $primaryColor !important;
}
.page-payments .service-block.plan .price-per .month, .page-payments .service-block.plan .price-per .month span {
    color: $primaryColor !important;
}
.page-payments .service-block.domain .price-per .month, .page-payments .service-block.domain .price-per .month span {
    color: $primaryColor !important;
}
.page-payments .service-block.domain .domain-label {
    color: $primaryColor !important;
}
.page-payments .radio-buttons li:hover, .page-payments .radio-buttons li.active {
    color: $primaryColor !important;
}
.page-payments .radio-buttons li {
    color: $primaryColor !important;
    border: 1px solid $primaryColor !important;
}
.page-payments .radio-buttons li:hover, .page-payments .radio-buttons li.active {
    background: $primaryColor !important;
}
.page-payments .radio-buttons li .check {
    background: $primaryColor !important;
}
.page-payments .radio-buttons li .check {
    border-color: $primaryColor !important;
}
.page-payments .service-block .edit-this:hover {
    background: $primaryColor !important;
    border-color: $primaryColor !important;
}
.page-payments .service-block .edit-this {
    color: $whiteColor !important;
    background: $primaryColor !important;
    border-color: $primaryColor !important;
}
</style>

HTML;

});

