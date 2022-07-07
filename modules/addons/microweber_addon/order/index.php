<?php


if (!defined("WHMCS")) {
    define("WHMCS", true);
}

$root = dirname(__DIR__);

 require_once $root . DIRECTORY_SEPARATOR . '/init.php';


global $CONFIG;


if(!defined('MW_SITE_URL')){
    define('MW_SITE_URL',$CONFIG['SystemURL'].'/');
}

$controller = new MicroweberAddonApiController();
$hosting = new \MicroweberAddon\Hosting();

$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (strpos($_SERVER['REQUEST_URI'], '?') !== false) {

} else {
    $current_url = $current_url . '?';
}

$getDomain = false;
if (isset($_REQUEST['domain'])) {
    $getDomain = $_REQUEST['domain'];
}

$getTemplate = false;
if (isset($_REQUEST['template'])) {
    $getTemplate = $_REQUEST['template'];
}
if (isset($_REQUEST['template_id'])) {
    $getTemplate =  $_REQUEST['template'] = $_REQUEST['template_id'];
}

$getPlan = false;
if (isset($_REQUEST['plan'])) {
    $getPlan = $_REQUEST['plan'];
}

if (isset($_REQUEST['plan_id'])) {
    $getPlan = $_REQUEST['plan'] = $_REQUEST['plan_id'];
}

$step = 0;

$configoptionGID = $hosting->get_config_option_gid_for_templates();

$templateID = 1;

//if (!$getDomain) {
//    $step = 1;
//} elseif (!$getTemplate) {
//    $step = 2;
//} elseif (!$getPlan) {
//    $step = 3;
//}

if ($step == 0) {
    if (!isset($_GET['step']) and empty($_POST)) {
        if (isset($_GET['from_step']) and empty($_POST)) {
            $step = intval($_GET['from_step']);
            unset($_GET['from_step']);
            unset($_REQUEST['from_step']);
        }
    }
}
if ($step == 0) {
    if (!$getTemplate) {
        $step = 1;
    } elseif (!$getDomain) {
        $step = 2;
    } elseif (!$getPlan) {
        $step = 3;
    }
}

?>

<?php //echo $CONFIG['CompanyName']; ?>
<?php //echo $CONFIG['Email']; ?>
<?php //echo $CONFIG['Domain']; ?>
<?php //echo site_url(); ?>
<?php //echo $CONFIG['LogoURL']; ?>



<?php if (isset($_REQUEST['template_view']) AND $_REQUEST['template_view'] == 'true'): ?>
    <?php include "steps/preview_template.php"; ?>
<?php else: ?>
    <?php if ($step == 2): ?>
        <?php
        include __DIR__ . "/steps/domains.php"; ?>
    <?php elseif ($step == 1): ?>
        <?php
        include __DIR__ . "/steps/templates.php"; ?>
    <?php elseif ($step == 3): ?>
        <?php
        include __DIR__ . "/steps/plans.php"; ?>
    <?php else: ?>
        <?php include(__DIR__ . '/params.php'); ?>

        <?php

        if ($subdomain) {
            $redirect_url = 'cart.php?a=add&pid=' . $pid . '&configoption[' . $config_gid . ']=' . $template_id . '&sld=' . $sld . '&tld=' . $tld . '&target=' . $target . '&domainoption=subdomain&billingcycle=monthly&skipconfig=1';
        } else {
            $redirect_url = 'cart.php?a=add&pid=' . $pid . '&configoption[' . $config_gid . ']=' . $template_id . '&sld=' . $sld . '&tld=' . $tld . '&target=' . $target . '&billingcycle=monthly&skipconfig=1';
        }


        ?>

        <form action="<?php echo site_url(); ?>/cart.php" method="get" id="send-fields" style="display: none" autocomplete="off">
            <input type="text" name="a" value="add">
            <input type="text" name="pid" value="<?php echo $pid; ?>">
            <input type="text" name="configoption[<?php print $config_gid ?>]" value="<?php print $template_id ?>">
            <input type="text" name="sld" value="<?php echo $sld; ?>">
            <input type="text" name="tld" value="<?php echo $tld; ?>">

            <?php if ($subdomain): ?>
                <input type="text" name="domainoption" value="subdomain">
            <?php else: ?>
                <!--<input type="text" name="domainoption" value="domain">-->
                <!--<input type="text" name="type" value="register">-->
            <?php endif; ?>

            <input type="text" name="billingcycle" value="monthly">
            <input type="text" name="skipconfig" value="1">

            <button type="submit">submit</button>
        </form>
        <script>
             window.top.location.href = "<?php echo site_url(); ?>/<?php echo $redirect_url; ?>";
        </script>
    <?php endif; ?>
<?php endif; ?>
