<?php
namespace MicroweberAddon;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MicroweberPackages\ComposerClient\Client;

class MarketplaceConnector extends Client
{

    public function getTemplates()
    {
        $packages = $this->search();

        dd($packages);

    }

}
