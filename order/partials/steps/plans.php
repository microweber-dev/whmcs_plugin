<?php if (isset($_GET['plan-style']) AND $_GET['plan-style'] == 'v2') {
    include('plans-v2.php');
} elseif (isset($_GET['plan-style']) AND $_GET['plan-style'] == 'v3') {
    include('plans-v3.php');
} else {
    include('plans-v1.php');
}
