<?php


namespace MicroweberAddon;


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
        $view->assign('config', $CONFIG );


        return $view->display();
    }

    public function save($params)
    {



        print_r($params);

    }

}