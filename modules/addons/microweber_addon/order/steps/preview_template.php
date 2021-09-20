<?php

$style_file = dirname(__DIR__) . '/templates/default/preview_template/index.php';
if (isset($_GET['style'])) {
    $style_file2 = dirname(__DIR__) . '/templates/' . htmlspecialchars(trim($_GET['style'])) . '/preview_template/index.php';
    if(is_file($style_file2)){
        $style_file = $style_file2;
    }
}
if(is_file($style_file)){
    include($style_file);
}



//
//
//
//if (isset($_GET['style'])) {
//    include(dirname(__DIR__) . '/templates/' . htmlspecialchars(trim($_GET['style'])) . '/preview_template/index.php');
//} else {
//    include(dirname(__DIR__) . '/templates/default/preview_template/index.php');
//}
