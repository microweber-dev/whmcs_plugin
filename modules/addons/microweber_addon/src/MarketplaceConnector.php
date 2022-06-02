<?php
namespace MicroweberAddon;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MicroweberPackages\ComposerClient\Client;

class MarketplaceConnector extends Client
{
    /*
    $packages = \WHMCS\Database\Capsule::table('tbladdonmodules')
            ->where('module', 'microweber_addon')
            ->where('setting', 'package_manager_urls')
            ->first();*/  

    /**
     * @return array
     */
    public function getTemplates()
    {
        $templates = [];
        $packages = $this->search();
        if (!empty($packages)) {
            foreach ($packages as $packageName=>$packageVersions) {
                foreach ($packageVersions as $version) {
                    if ($version['type'] !== 'microweber-template') {
                        continue;
                    }
                    $templates[$packageName] = $version;
                }
            }
        }

        return $templates;
    }

}
