<?php


namespace MicroweberAddon;

use Illuminate\Database\Capsule\Manager as Capsule;


class Hosting
{

    private $config_option_name = 'Templates';

    // private $config_option_name = 'Templates';


    function get_hosting_products($params = false)
    {

        $params = parse_params($params);


        $return_mode = 'all';

        $gid = $this->__get_config_option_gid_for_templates();


        $productconfiglinks = Capsule::table('tblproductconfiglinks')->get();
        if ($productconfiglinks) {
            $productconfiglinks = collect($productconfiglinks)->map(function ($x) {
                return (array)$x;
            })->toArray();
        }


        $host_acc = Capsule::table('tblproducts')
           // ->where('hidden', 0)
            ->where('retired', 0)
            ->where('showdomainoptions', 1)
            ->where('type', 'hostingaccount')
            ->orderBy('order', 'ASC')
            ->get();

        $host_acc = collect($host_acc)->map(function ($x) {
            return (array)$x;
        })->toArray();


        $config_data = $host_acc;


        $return = array();

        if (isset($params['return_mode'])) {
            $return_mode = $params['return_mode'];
        }


        if ($config_data) {
            foreach ($config_data as $config_data_item) {

                if (isset($config_data_item['id'])) {
                    if ($productconfiglinks) {
                        foreach ($productconfiglinks as $productconfiglink) {
                            if (isset($productconfiglink['pid']) and $productconfiglink['pid'] == $config_data_item['id']) {
                                $config_data_item['has_website_builder'] = true;
                            }
                        }
                    }
                }




                if ($return_mode == 'simple') {
                    $return[] = $config_data_item['pid'];

                } else {
                    $return[] = $config_data_item;

                }
            }
        }


        return $return;

    }


    function get_enabled_templates($params = false)
    {

        $return_mode = 'all';

        $params = parse_params($params);


        if (isset($params['return_mode'])) {
            $return_mode = $params['return_mode'];
        }


        $return = array();


        $query = "
        select
          pcos.* ,
          pcos.optionname AS template
        FROM
         
            tblproductconfigoptionssub  pcos, 
            tblproductconfigoptions     pco, 
            tblhostingconfigoptions hco
        WHERE
          pcos.configid = pco.id AND
          hco.configid = pco.id AND
          hco.optionid = pcos.id AND
          
          
          pco.optionname = 'Template' 
          
          group by template
          ";


        $config_data = Capsule::select($query);
        $config_data = collect($config_data)->map(function ($x) {
            return (array)$x;
        })->toArray();


        if ($config_data) {
            foreach ($config_data as $config_data_item) {
                if ($return_mode == 'simple') {
                    $return[] = $config_data_item['template'];

                } else {
                    $return[] = $config_data_item;

                }
            }
        }


        return $return;

    }


    private function __get_config_option_gid_for_templates()
    {

        $data = Capsule::table('tblproductconfiggroups')->where(['name' => $this->config_option_name])->first();
        if (!isset($data->id)) {
            Capsule::table('tblproductconfiggroups')->insert(array("name" => $this->config_option_name));
            $data = Capsule::table('tblproductconfiggroups')->where(['name' => $this->config_option_name])->first();

        }
        if (isset($data->id)) {
            return $data->id;
        }
    }

    private function __get_config_option_id_for_templates()
    {

        $gid = $this->__get_config_option_gid_for_templates();

        $data = Capsule::table('tblproductconfigoptions')->where(['optionname' => $this->config_option_name, 'gid' => $gid])->first();

        if (!isset($data->id)) {
            Capsule::table('tblproductconfigoptions')->insert(array("optionname" => $this->config_option_name, "gid" => $gid));
            $data = Capsule::table('tblproductconfigoptions')->where(['optionname' => $this->config_option_name, 'gid' => $gid])->first();
        }

        if (isset($data->id)) {
            return $data->id;
        }

        return;
    }


}