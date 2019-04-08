<?php


if (!defined("WHMCS")) {
    define("WHMCS", true);
}
$root = dirname( __DIR__ );

require_once $root . DIRECTORY_SEPARATOR . '/init.php';
global $CONFIG;


$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (strpos($_SERVER['REQUEST_URI'], '?') !== false) {

} else {
    $current_url = $current_url . '?';
}

$getDomain = false;
if (isset($_GET['domain'])) {
    $getDomain = $_GET['domain'];
}

$getTemplate = false;
if (isset($_GET['template'])) {
    $getTemplate = $_GET['template'];
}

$getPlan = false;
if (isset($_GET['plan'])) {
    $getPlan = $_GET['plan'];
}

$step = 0;

if (!$getDomain) {
    $step = 1;
} elseif (!$getTemplate) {
    $step = 2;
} elseif (!$getPlan) {
    $step = 3;
}
?>

<?php if (isset($_GET['template_view']) AND $_GET['template_view'] == 'true'): ?>
    <?php include "preview_template/index.php"; ?>
<?php else: ?>
    <?php include "partials/header.php"; ?>
    <?php if ($step == 1): ?>
        <?php include "partials/steps/domain.php"; ?>
    <?php elseif ($step == 2): ?>
        <?php include "partials/steps/template.php"; ?>
    <?php elseif ($step == 3): ?>
        <?php include "partials/steps/plan.php"; ?>
    <?php else: ?>
        ready
    <?php endif; ?>
    <?php include "partials/footer.php"; ?>
<?php endif; ?>