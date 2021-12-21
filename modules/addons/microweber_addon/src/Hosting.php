<?php


namespace MicroweberAddon;

use Illuminate\Database\Capsule\Manager as Capsule;


class Hosting
{

    private $config_option_name = 'Template';
    // private $config_option_name = 'Templates';


    function get_hosting_products($params = false)
    {

        $params = parse_params($params);

        $return_mode = 'all';

        $productconfiglinks = Capsule::table('tblproductconfiglinks')->get();
        if ($productconfiglinks) {
            $productconfiglinks = collect($productconfiglinks)->map(function ($item) {
                return (array)$item;
            })->toArray();
        }

        $host_acc = Capsule::table('tblproducts')
            // ->where('hidden', 0)
            ->where('retired', 0)
            ->where('showdomainoptions', 1)

            ->where(function($query) {

                $query->where(function($query){
                    $query->where('type', 'hostingaccount');
                    $query->orWhere('type', 'reselleraccount');
                 });


            })

         //   ->where('type', 'hostingaccount')

            ->orderBy('order', 'ASC')
            ->get();



        $config_data = collect($host_acc)->map(function ($item) {
            return (array) $item;
        })->toArray();


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


    function get_enabled_market_templates($params = false)
    {
        $params = parse_params($params);
        $only_with_screenshots = false;

        if (isset($params['only_with_screenshots']) and $params['only_with_screenshots']) {
            $only_with_screenshots = true;
        }


        $market_conn = new MarketplaceConnector();


        $templates = $market_conn->get_templates();

        $tpls = array();
       // $enabled_by_users = $this->get_enabled_templates('return_mode=simple');
        $enabled_by_users = $this->get_enabled_templates();
        if (!empty($templates)) {
            foreach ($templates as $tk => $template) {
                if (isset($template['latest_version']) and isset($template['latest_version']["target-dir"])) {
                    $td = $template['latest_version']["target-dir"];
                    $latest_version = $template['latest_version'];
                    $screenshot = '';
                    if (isset($latest_version) AND isset($latest_version['extra']) AND isset($latest_version['extra']['_meta']) AND isset($latest_version['extra']['_meta']['screenshot'])) {
                        $screenshot = $latest_version['extra']['_meta']['screenshot'];
                    }


                    foreach ($enabled_by_users as $enabled_by_user) {
                    //    dd($enabled_by_user);
                       $enabled_template_name = $enabled_by_user['optionname'];
                        if ($td == $enabled_template_name) {



                            $latest_version['configoption']  = $enabled_by_user;

                            if($only_with_screenshots ){
                                if($screenshot){
                                $tpls[$tk] = $latest_version;
                                }
                            } else {
                                $tpls[$tk] = $latest_version;

                            }
                        }
                    }
                }
            }
        }

        return $tpls;


    }

    function get_enabled_templates($params = false)
    {

        $return_mode = 'all';

        $params = parse_params($params);


        if (isset($params['return_mode'])) {
            $return_mode = $params['return_mode'];
        }

        $configoptionid = $this->configoptionid_for_templates();

        $gid_name = $this->config_option_name;


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
          
          
          pco.optionname = '" . $gid_name . "' 
          
          group by template
          ";

        $query = "
        select
          pcos.* ,
          pcos.optionname AS template
        FROM
         
            tblproductconfigoptionssub  as pcos
             
        WHERE
          configid = '" . $configoptionid . "' 
           group by template
           
          ";

        //dd($query);

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


    public function id_for_template($template_name)
    {


    }


    public function configoptionid_for_templates()
    {
        $gid = $this->get_config_option_gid_for_templates();
        $data = Capsule::table('tblproductconfigoptions')->where(['optionname' => $this->config_option_name, 'gid'=>$gid])->first();

        if (!$data) {

            $gid = $this->get_config_option_gid_for_templates();

			Capsule::table('tblproductconfigoptions')->insert(['optionname' => $this->config_option_name, 'gid'=>$gid, 'optiontype'=> 1]);
			$data = Capsule::table('tblproductconfigoptions')->where(['optionname' => $this->config_option_name, 'gid'=>$gid])->first();
		}

		if ($data) {
			return $data->id; 
		}
		
		throw new Exception('Cant find tblproductconfigoptions by option name.');

    }
    public function get_gid_for_templates()
    {
        return $this->get_config_option_gid_for_templates();
    }
    public function get_config_option_gid_for_templates()
    {
        $data = Capsule::table('tblproductconfiggroups')->where(['name' => $this->config_option_name])->first();
        if (!isset($data->id)) {
            Capsule::table('tblproductconfiggroups')->insert(array("name" => $this->config_option_name));
            $data = Capsule::table('tblproductconfiggroups')->where(['name' => $this->config_option_name])->first();
        }

        //dd($data);
        if (isset($data->id)) {
            return $data->id;
        }
    }

    private function __get_config_option_id_for_templates($gid, $template_name)
    {

        $gid = $this->get_config_option_gid_for_templates();

        $data = Capsule::table('tblproductconfigoptionssub')->where(['optionname' => $template_name, 'gid' => $gid])->first();


        if (isset($data->id)) {
            return $data->id;
        }

        return;
    }


}