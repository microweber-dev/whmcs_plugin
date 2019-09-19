<?php if (isset($_GET['templates-style']) AND $_GET['templates-style'] == 'v2') {
    include('templates-v2.php');
} elseif (isset($_GET['templates-style']) AND $_GET['templates-style'] == 'v3') {
    include('templates-v3.php');
} else {
    include('templates-v1.php');
}