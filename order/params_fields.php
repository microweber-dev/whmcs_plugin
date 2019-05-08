<?php if ($name): ?>
    <input type="hidden" value="<?php print $name; ?>" name="template"/>
<?php endif; ?>

<?php if ($plan): ?>
    <input type="hidden" value="<?php print $plan; ?>" name="plan"/>
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