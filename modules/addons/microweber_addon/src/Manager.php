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
        $readyTemplates = array();
        $templates = $this->marketplace_connector->get_templates();

        foreach ($templates as $template) {
            $item = $template['latest_version'];
            $get_template = get_template_by_git_package_name($item['name']);
            $template['preview_sort'] = 0;
            if ($get_template) {
                $template['preview_sort'] = $get_template->preview_sort;
            }
            $readyTemplates[] = $template;
        }

        usort($readyTemplates, function($a, $b) {
            return $a['preview_sort'] - $b['preview_sort'];
        });

        return $readyTemplates;
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