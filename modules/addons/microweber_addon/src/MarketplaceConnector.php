<?php

namespace MicroweberAddon;


class MarketplaceConnector
{
    private $package_manager_urls = array(
        'https://packages.microweberapi.com/packages.json',
        'https://private-packages.microweberapi.com/packages.json',
    );

    public function get_content_from_url($url)
    {
        if (in_array('curl', get_loaded_extensions())) {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return data inplace of echoing on screen
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            $data = curl_exec($ch);

            curl_close($ch);

            return $data;
        } else {
            return @file_get_contents($url);
        }
    }

    public function get_packages_urls()
    {
        $packages = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_addon')
            ->where('setting', 'package_manager_urls')
            ->first();

        if (!empty($packages->value)) {
            if (strpos($packages->value, PHP_EOL)) {
                $packages_exp = explode(PHP_EOL, $packages->value);
            } else {
                $packages_exp = explode(',', $packages->value);
            }
            if (is_array($packages_exp) && !empty($packages_exp)) {
                $new_package_urls = array();

                foreach ($packages_exp as $package_url) {

                    $package_url = trim($package_url);
                    $package_url = str_replace(',', false, $package_url);

                    $package_url = rtrim($package_url, "/") . '/';
                    if (!stristr($package_url, 'packages.json')) {
                        $package_url = ($package_url . "/") . 'packages.json';
                    }

                    if (filter_var($package_url, FILTER_VALIDATE_URL) === FALSE) {
                        continue;
                    }

                    if (empty($package_url)) {
                        continue;
                    }

                    $package_url = str_replace('.json/','.json', $package_url);

                    $new_package_urls[] = $package_url;
                }
                
                if (is_array($new_package_urls) && !empty($new_package_urls)) {
                    $this->package_manager_urls = $new_package_urls;
                }
            }
        }

        return $this->package_manager_urls;
    }


    public function get_packages()
    {
        $this->get_packages_urls();

        $allowed_package_types = array(
            'microweber-template',
            'microweber-module',
        );

        $return = array();
        $packages = array();
        $packages_by_type = array();
        if ($this->package_manager_urls) {
            foreach ($this->package_manager_urls as $url) {
                $package_manager_resp = $this->get_content_from_url($url);
                $package_manager_resp = @json_decode($package_manager_resp, true);
                if ($package_manager_resp and isset($package_manager_resp['packages']) and is_array($package_manager_resp['packages'])) {
                    $packages = array_merge($packages, $package_manager_resp['packages']);
                }
            }

        }

        if ($packages) {
            foreach ($packages as $pk => $package) {

                $version_type = false;
                $package_item = $package;
                $last_item = array_pop($package_item);
                if (isset($last_item['type'])) {
                    $version_type = $last_item['type'];
                    $package['latest_version'] = $last_item;
                }

                if ($version_type and in_array($version_type, $allowed_package_types)) {
                    $package_is_allowed = true;
                    $return[$pk] = $package;
                    if (!isset($packages_by_type[$version_type])) {
                        $packages_by_type[$version_type] = array();
                    }
                    $packages_by_type[$version_type][$pk] = $package;

                }

            }
        }

        return $packages_by_type;
    }


    public function get_templates()
    {
        $templates = $this->get_packages();


//
//        $templates = file_get_contents($this->manifest_url);
//        $templates = @json_decode($templates, true);
        $return = array();
        if ($templates and isset($templates["microweber-template"])) {
            foreach ($templates["microweber-template"] as $pk => $template) {

                $package_item = $template;

                $package_item_version = $package_item;

                $package_item_version = array_reverse($package_item_version);

                $last_item = false;

                foreach ($package_item_version as $package_item_version_key => $package_item_version_data) {

                    $package_item_version_data['version'] = str_replace('v',false, $package_item_version_data['version']);

                    if (!$last_item
                        and $package_item_version_data
                        and isset($package_item_version_data['version'])
                        and $package_item_version_data['version'] != 'dev-master'
                        and is_numeric($package_item_version_data['version'])) {
                        $last_item2 = $package_item_version_data;
                        $last_item = $last_item2;

                    }
                }

                if ($last_item) {

                    $template['latest_version'] = $last_item;
                    $screenshot = '';
                    $readme = '';
                    if (isset($template['latest_version']) and isset($template['latest_version']['extra']) and isset($template['latest_version']['extra']['_meta']) and isset($template['latest_version']['extra']['_meta']['screenshot'])) {
                        $screenshot = $template['latest_version']['extra']['_meta']['screenshot'];
                    }
                    if (isset($template['latest_version']) and isset($template['latest_version']['extra']) and isset($template['latest_version']['extra']['_meta']) and isset($template['latest_version']['extra']['_meta']['readme'])) {
                        $readme = $template['latest_version']['extra']['_meta']['readme'];
                    }

                    //$template['screenshot'] = $screenshot;
                    $return[$pk] = $template;
                }
            }
        }

        return $return;

    }


}
