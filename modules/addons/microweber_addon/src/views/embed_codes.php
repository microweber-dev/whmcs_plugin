
<a href="javascript: void(0)" onclick="$('#mwembedcodepreholder').toggle();">Show embed code</a>

<div id="mwembedcodepreholder" style="display: none">

    You can use this embed code on any website to show domain search field.

    Target top
<pre><?php echo htmlentities('<script crossorigin="anonymous" src="'.$config['SystemURL'].'/modules/addons/microweber_addon/order/embed.js?style=default&target=top&tld_order=.com,.net,.org" id="domain-search-iframe-js"></script>'); ?></pre>


    Without target top

<pre><?php echo htmlentities('<script crossorigin="anonymous" src="'.$config['SystemURL'].'/modules/addons/microweber_addon/order/embed.js?tld_order=.com,.net,.org" id="domain-search-iframe-js"></script>'); ?></pre>

Iframe
    <pre >
<?php print $config['SystemURL']; ?>/index.php?m=microweber_addon&function=order_iframe

</pre>

</div>









