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
</style>

HTML;

});

