<?php


namespace MicroweberAddon;


class AdminController
{

    public function index($params)
    {

        $manager = new \MicroweberAddon\Manager;




        $view_file = __DIR__ . '/views/index.php';

        $view = new View($view_file);
        $view->assign('params', $params);
        $view->assign('manager', $manager);


        return $view->display();
    }

}