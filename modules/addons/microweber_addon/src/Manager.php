<?php


namespace MicroweberAddon;

use Illuminate\Database\Capsule\Manager as Capsule;


class Manager
{

    public $report = null;
    public $marketplace_connector = null;
    public $config = null;
    public $hosting = null;


    function __construct()
    {
        $this->report = new \MicroweberAddon\UsageReport();
        $this->marketplace_connector = new MarketplaceConnector();
        $this->config = new Config();
        $this->hosting = new Hosting();
    }

    function get_total_client_products()
    {
        $this->report->getTotalClients();
    }

    function get_settings()
    {
        return $this->config->get_settings();
    }

    function get_templates()
    {
        return $this->marketplace_connector->get_templates();
    }

    function get_user_id_from_invoice_id($_invoiceid)
    {
        $inv = Capsule::table('tblinvoices')
            ->where('id', $_invoiceid)
            ->get();
        // custom field fieldid for identificacion is 10
//        $identificacion = Capsule::table('tblcustomfieldsvalues')
//            ->where('relid', $inv[0]->userid)
//            ->where('fieldid', 10)
//            ->get();
        if (isset($inv[0]->userid)) {
            return $inv[0]->userid;
        }
        return FALSE;
    }


}