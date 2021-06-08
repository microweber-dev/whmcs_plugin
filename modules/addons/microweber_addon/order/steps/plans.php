<?php


//if (isset($_GET['style'])) {
//    include(dirname(__DIR__) . '/templates/' . htmlspecialchars($_GET['style']) . '/plans/index.php');
//} else {
//    include(dirname(__DIR__) . '/templates/default/plans/index.php');
//}




$style_file = dirname(__DIR__) . '/templates/default/plans/index.php';
if (isset($_GET['style'])) {
    $style_file2 = dirname(__DIR__) . '/templates/' . htmlspecialchars($_GET['style']) . '/plans/index.php';
    if(is_file($style_file2)){
        $style_file = $style_file2;
    }
}
if(is_file($style_file)){
    include($style_file);
}


