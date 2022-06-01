<?php if ($name): ?>
    <input type="hidden" value="<?php print $name; ?>" name="template"/>
<?php endif; ?>

<?php if ($plan): ?>
    <input type="hidden" value="<?php print $plan; ?>" name="plan"/>
<?php endif; ?>


<?php if ($config_gid): ?>
    <input type="hidden" value="<?php print $config_gid; ?>" name="config_gid"/>
<?php endif; ?>

<?php if ($template_id): ?>
    <input type="hidden" value="<?php print $template_id; ?>" name="template_id"/>
<?php endif; ?>

<?php if ($domain AND $domain != 'true'): ?>
    <input type="hidden" value="<?php print $domain; ?>" name="domain"/>
<?php endif; ?>

<?php if ($sld): ?>
    <input type="hidden" value="<?php print $sld; ?>" name="sld"/>
<?php endif; ?>

<?php if ($tld): ?>
    <input type="hidden" value="<?php print $tld; ?>" name="tld"/>
<?php endif; ?>

<?php if ($subdomain): ?>
    <input type="hidden" value="<?php print $subdomain; ?>" name="subdomain"/>
<?php endif; ?>

<?php if ($target): ?>
    <input type="hidden" value="<?php print $target; ?>" name="target"/>
<?php endif; ?>

<?php if ($style): ?>
    <input type="hidden" value="<?php print $style; ?>" name="style"/>
<?php endif; ?>


<?php
if($_GET){
    foreach ($_GET as $k=>$v){

        ?>

        <!--<input type="hidden" value="<?php /*print $k; */?>" name="<?php /*print $v; */?>"/>-->
   <?php }
}

?>

<?php /*
<?php if ($templates_style): ?>
    <input type="hidden" value="<?php print $templates_style; ?>" name="templates-style"/>
<?php endif; ?>

<?php if ($template_preview_style): ?>
    <input type="hidden" value="<?php print $template_preview_style; ?>" name="template-preview-style"/>
<?php endif; ?>

<?php if ($domain_style): ?>
    <input type="hidden" value="<?php print $domain_style; ?>" name="domain-style"/>
<?php endif; ?>

<?php if ($plan_style): ?>
    <input type="hidden" value="<?php print $plan_style; ?>" name="plan-style"/>
<?php endif; ?>


*/ ?>