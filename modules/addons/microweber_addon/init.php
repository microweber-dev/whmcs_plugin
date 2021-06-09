<?php

$root = dirname(__DIR__);
$root = dirname($root);
$root = dirname($root);

require_once $root . DIRECTORY_SEPARATOR . '/configuration.php';
require_once $root . DIRECTORY_SEPARATOR . '/init.php';
require_once $root . DIRECTORY_SEPARATOR . '/includes/functions.php';



require_once($root . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'domainfunctions.php');
require_once($root . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'cartfunctions.php');


$root = (__DIR__);

require_once $root . DIRECTORY_SEPARATOR . '/microweber_addon.php';


//
//$arr = get_defined_functions(true);
//
//print_r($arr);