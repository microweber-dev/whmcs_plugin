<?php


namespace MicroweberAddon;


use WHMCS\Database\Capsule;

class AdminController
{

    public function index($params)
    {

        global $CONFIG;

        $manager = new \MicroweberAddon\Manager;


        $view_file = __DIR__ . '/views/index.php';

        $view = new View($view_file);
        $view->assign('params', $params);
        $view->assign('manager', $manager);
        $view->assign('config', $CONFIG);


        return $view->display();
    }

    public function save($params)
    {


        if (isset($params['templates_settings'])) {
            foreach ($params['templates_settings'] as $template_id=>$templates_setting) {

                $template_enabled = 0;
                if (isset($params['selected_templates']) and is_array($params['selected_templates'])) {
                    if (in_array($templates_setting['target_dir'], $params['selected_templates'])) {
                        $template_enabled = 1;
                    }
                }

                Capsule::table('mod_microweber_templates')
                    ->where('id', $template_id)
                    ->update([
                        'is_enabled'=> $template_enabled,
                        'updated_at'=>date('Y-m-d H:i:s'),
                        'name'=>$templates_setting['name'],
                        'target_dir'=> $templates_setting['target_dir'],
                        'git_package_name'=> $templates_setting['git_package_name'],
                        'screenshot_url'=>$templates_setting['screenshot_url'],
                        'preview_url'=>$templates_setting['preview_url'],
                        'homepage_url'=>$templates_setting['homepage_url'],
                        'preview_name'=>$templates_setting['preview_name'],
                        'preview_sort'=>$templates_setting['preview_sort']
                    ]);
            }
        }

        $hosting = new \MicroweberAddon\Hosting();

        $configoptionid = $hosting->configoptionid_for_templates();
        //dd($configoptionid);

        Capsule::table('tblproductconfiglinks')->where('gid', $configoptionid)->delete();
        if (isset($params['selected_hosting_plans'])) {
            foreach ($params['selected_hosting_plans'] as $selected_hosting_plan) {
                Capsule::table('tblproductconfiglinks')
                    ->insert(['gid' => $configoptionid, 'pid' => $selected_hosting_plan]);
            }
        }

        if (isset($params['selected_templates']) and is_array($params['selected_templates'])) {
            $to_save = array_filter($params['selected_templates']);

            $saved_config_ids = array();
            $to_remove_config_ids = array();
            //   dd($to_save);
            if ($to_save) {
                foreach ($to_save as $item) {
                    $data = Capsule::table('tblproductconfigoptionssub')->where(['optionname' => $item, 'configid' => $configoptionid])->first();

                    if (!$data->id) {
                        Capsule::table('tblproductconfigoptionssub')->insert(array("optionname" => $item, 'configid' => $configoptionid, 'sortorder' => 0, 'hidden' => 0));
                        $config_option_id = Capsule::getPdo()->lastInsertId();
                    } else {
                        $config_option_id = $data->id;
                    }

                    Capsule::table('mod_microweber_templates')
                        ->where('target_dir', $item)
                        ->update([
                            'config_option_id'=> $config_option_id,
                            'config_option_group_id'=> $configoptionid,
                        ]);

                    $saved_config_ids[] = $config_option_id;
                }

                $to_remove_items = Capsule::table('tblproductconfigoptionssub')->select('*')->where(['configid' => $configoptionid])->whereNotIn('optionname', $to_save)->get();
                if ($to_remove_items) {
                    foreach ($to_remove_items as $to_remove_item) {
                        if ($to_remove_item->id) {
                            $to_remove_config_ids[] = $to_remove_item->id;
                        }
                    }
                }
            }

            if ($to_remove_config_ids) {
                Capsule::table('tblproductconfigoptionssub')->select('*')->where(['configid' => $configoptionid])->whereIn('id', $to_remove_config_ids)->delete();
                Capsule::table('tblpricing')->select('*')->where(['type' => 'configoptions'])->whereIn('relid', $to_remove_config_ids)->delete();
            }

            if ($saved_config_ids) {
                foreach ($saved_config_ids as $saved_config_id) {
                    $pricing_data = Capsule::table('tblpricing')->select('*')->where(['type' => 'configoptions', 'relid' => $saved_config_id])->first();
                    if (!$pricing_data) {

                        Capsule::table('tblpricing')->insert([
                            'type' => 'configoptions',
                            'currency' => '1',
                            'msetupfee' => '0',
                            'qsetupfee' => '0',
                            'ssetupfee' => '0',
                            'asetupfee' => '0',
                            'bsetupfee' => '0',
                            'tsetupfee' => '0',
                            'monthly' => '0',
                            'quarterly' => '0',
                            'semiannually' => '0',
                            'annually' => '0',
                            'biennially' => '0',
                            'triennially' => '0',
                            'relid' => $saved_config_id]);
                    }
                }
            }

        }

        print 'Settings are saved';
        // print_r($params);

        header('Location: addonmodules.php?module=microweber_addon');
    }

}