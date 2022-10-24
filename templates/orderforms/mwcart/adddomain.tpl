<script type="text/javascript" src="templates/orderforms/{$carttpl}/js/main.js"></script>
<link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css" />

<div id="order-modern">

    <div class="title-bar">
        <h1>
            {if $domain eq "register"}
                {$LANG.registerdomain}
            {elseif $domain eq "transfer"}
                {$LANG.transferdomain}
            {/if}
        </h1>
        {include file="templates/orderforms/{$carttpl}/category-chooser.tpl"}
    </div>

    {if !$loggedin && $currencies}
        <div class="currencychooser col-md-12 text-center mx-auto my-5">
            <h5 class="mb-3">Choose your Currency</h5>
            <div class="btn-group" role="group">
                {foreach from=$currencies item=curr}
                    <a href="cart.php?gid={$gid}&currency={$curr.id}" class="whmc-kbtn-2{if $currency.id eq $curr.id} active{/if}">
{*                        <img src="{$BASE_PATH_IMG}/flags/{if $curr.code eq "AUD"}au{elseif $curr.code eq "CAD"}ca{elseif $curr.code eq "EUR"}eu{elseif $curr.code eq "GBP"}gb{elseif $curr.code eq "INR"}in{elseif $curr.code eq "JPY"}jp{elseif $curr.code eq "USD"}us{elseif $curr.code eq "ZAR"}za{else}na{/if}.png"*}
{*                             border="0" alt=""/>*}
                        {$curr.code}
                    </a>
                {/foreach}
            </div>
        </div>
    {/if}

    {if $errormessage}<div class="errorbox">{$errormessage|replace:'<li>':' &nbsp;#&nbsp; '} &nbsp;#&nbsp; </div><br />{/if}

    <div class="domain-checker-container">
        <div class="domain-checker-bg clearfix">
            <form onsubmit="checkAvailability();return false">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-xs-10 col-xs-offset-1">
                        <div class="domain-checker-fieldcontainer">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="subscription-field">
                                        <input type="text" id="inputDomain" placeholder="{if $domain eq "register"}{$LANG.findyourdomain}{else}{$LANG.exampledomain}{/if}"
                                               value="{$sld}" class="material-field subscription" autocapitalize="none"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select name="tld" id="inputTld" class="selectpicker">
                                        {foreach from=$tlds item=listtld}
                                            <option value="{$listtld}"{if $listtld eq $tld} selected="selected"{/if}>
                                                {$listtld}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" id="btnCheckAvailability" class="cbtn cbtn-big">
                                        {if $domain eq "register"}
                                            {$LANG.search}
                                        {else}
                                            {$LANG.domainstransfer}
                                        {/if}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form method="post" action="cart.php?a=add&domain={$domain}">
        <div id="domainresults" class="domainresults hidden"></div>
    </form>

    <script language="javascript">
        var regType = '{$domain}';
        function checkAvailability() {
            var btnLookupText = jQuery("#btnCheckAvailability").html();
            jQuery("#btnCheckAvailability").html('<i class="fa fa-spinner fa-spin"></i>');
            jQuery.post("cart.php", { ajax: 1, a: "domainoptions", sld: jQuery("#inputDomain").val(), tld: jQuery("#inputTld").val(), checktype: regType },
                function(data) {
                    jQuery("#domainresults").html(data);
                    if (!jQuery("#domainresults").is(":visible")) {
                        jQuery("#domainresults").hide().removeClass('hidden').slideDown();
                    }
                    jQuery("#btnCheckAvailability").html(btnLookupText);
                }
            );
        }
        function cancelcheck() {
            jQuery("#inputDomain").focus();
            jQuery("#domainresults").fadeOut();
        }
        {if $sld}
            jQuery(document).ready(function() {
                checkAvailability();
            });
        {/if}
    </script>

</div>
