<div id="prodconfigcontainer">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
            <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/main.js"></script>
            <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css"/>
            <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/js/jquery-ui-1.12.1/jquery-ui.min.css"/>

            <div id="order-modern">

                <form id="orderfrm" onsubmit="catchEnter(event);">

                    <input type="hidden" name="configure" value="true"/>
                    <input type="hidden" name="i" value="{$i}"/>

                    {if !$firstconfig || $firstconfig && !$domain}
                        <div class="title-bar">
                            <h1>{$LANG.orderconfigure}</h1>
                        </div>
                    {/if}

                    <div id="configproducterror" class="errorbox"></div>

                    <div class="row">
                        <div class="col-md-6">

                            {if $pricing.type eq "recurring"}
                                <h3>{$LANG.cartchoosecycle}</h3>
                                <div class="billingcycle">
                                    <table width="100%" cellspacing="0" cellpadding="0" class="configtable">
                                        {if $pricing.monthly}
                                            <tr>
                                                <td class="radiofield">
                                                    <input type="radio" name="billingcycle" id="cycle1" value="monthly"{if $billingcycle eq "monthly"} checked{/if}
                                                           onclick="{if $configurableoptions}updateConfigurableOptions({$i}, this.value){else}recalctotals(){/if}"/>
                                                </td>
                                                <td class="fieldarea">
                                                    <label for="cycle1" class="radio-inline">{$pricing.monthly}</label>
                                                </td>
                                            </tr>
                                        {/if}
                                        {if $pricing.quarterly}
                                            <tr>
                                                <td class="radiofield">
                                                    <input type="radio" name="billingcycle" id="cycle2" value="quarterly"{if $billingcycle eq "quarterly"} checked{/if}
                                                           onclick="{if $configurableoptions}updateConfigurableOptions({$i}, this.value){else}recalctotals(){/if}"/>
                                                </td>
                                                <td class="fieldarea">
                                                    <label for="cycle2" class="radio-inline">{$pricing.quarterly}</label>
                                                </td>
                                            </tr>
                                        {/if}
                                        {if $pricing.semiannually}
                                            <tr>
                                                <td class="radiofield">
                                                    <input type="radio" name="billingcycle" id="cycle3" value="semiannually"{if $billingcycle eq "semiannually"} checked{/if}
                                                           onclick="{if $configurableoptions}updateConfigurableOptions({$i}, this.value){else}recalctotals(){/if}"/>
                                                </td>
                                                <td class="fieldarea">
                                                    <label for="cycle3" class="radio-inline">{$pricing.semiannually}</label>
                                                </td>
                                            </tr>
                                        {/if}
                                        {if $pricing.annually}
                                            <tr>
                                                <td class="radiofield">
                                                    <input type="radio" name="billingcycle" id="cycle4" value="annually"{if $billingcycle eq "annually"} checked{/if}
                                                           onclick="{if $configurableoptions}updateConfigurableOptions({$i}, this.value){else}recalctotals(){/if}"/>
                                                </td>
                                                <td class="fieldarea">
                                                    <label for="cycle4" class="radio-inline">{$pricing.annually}</label>
                                                </td>
                                            </tr>
                                        {/if}
                                        {if $pricing.biennially}
                                            <tr>
                                                <td class="radiofield">
                                                    <input type="radio" name="billingcycle" id="cycle5" value="biennially"{if $billingcycle eq "biennially"} checked{/if}
                                                           onclick="{if $configurableoptions}updateConfigurableOptions({$i}, this.value){else}recalctotals(){/if}"/>
                                                </td>
                                                <td class="fieldarea">
                                                    <label for="cycle5" class="radio-inline">{$pricing.biennially}</label>
                                                </td>
                                            </tr>
                                        {/if}
                                        {if $pricing.triennially}
                                            <tr>
                                                <td class="radiofield">
                                                    <input type="radio" name="billingcycle" id="cycle6" value="triennially"{if $billingcycle eq "triennially"} checked{/if}
                                                           onclick="{if $configurableoptions}updateConfigurableOptions({$i}, this.value){else}recalctotals(){/if}"/>
                                                </td>
                                                <td class="fieldarea">
                                                    <label for="cycle6" class="radio-inline">{$pricing.triennially}</label>
                                                </td>
                                            </tr>
                                        {/if}
                                    </table>
                                </div>
                            {/if}

                            {if $productinfo.type eq "server"}
                                <h3>{$LANG.cartconfigserver}</h3>
                                <div class="serverconfig">
                                    <table width="100%" cellspacing="0" cellpadding="0" class="configtable">
                                        <tr>
                                            <td class="fieldlabel">{$LANG.serverhostname}:</td>
                                            <td class="fieldarea"><input type="text" name="hostname" size="15" value="{$server.hostname}"/> {$LANG.serverhostnameexample}</td>
                                        </tr>
                                        <tr>
                                            <td class="fieldlabel">{$LANG.serverns1prefix}:</td>
                                            <td class="fieldarea"><input type="text" name="ns1prefix" size="10" value="{$server.ns1prefix}"/> {$LANG.serverns1prefixexample}</td>
                                        </tr>
                                        <tr>
                                            <td class="fieldlabel">{$LANG.serverns2prefix}:</td>
                                            <td class="fieldarea"><input type="text" name="ns2prefix" size="10" value="{$server.ns2prefix}"/> {$LANG.serverns2prefixexample}</td>
                                        </tr>
                                        <tr>
                                            <td class="fieldlabel">{$LANG.serverrootpw}:</td>
                                            <td class="fieldarea"><input type="password" name="rootpw" size="20" value="{$server.rootpw}"/></td>
                                        </tr>
                                    </table>
                                </div>
                            {/if}

                            {if $configurableoptions}
                                {*<h3>{$LANG.orderconfigpackage}</h3>*}
                                <h3>Select template</h3>
                                <div class="">
                                    <table width="100%" cellspacing="0" cellpadding="0" class="configtable">
                                        {foreach from=$configurableoptions item=configoption}
                                            <tr>

                                                {if $configoption.optiontype eq 1}
                                                <select name="configoption[{$configoption.id}]" onchange="recalctotals()" class="form-control">
                                                    {foreach key=num2 item=options from=$configoption.options}
                                                        <option value="{$options.id}"{if $configoption.selectedvalue eq $options.id} selected="selected"{/if}>{$options.name}</option>
                                                    {/foreach}
                                                </select>
                                                {elseif $configoption.optiontype eq 2}

                                                <td class="fieldlabel">{$configoption.optionname}</td>
                                                <td class="fieldarea">
                                                    {foreach key=num2 item=options from=$configoption.options}
                                                        <label class="radio-inline"><input type="radio" name="configoption[{$configoption.id}]"
                                                                                           value="{$options.id}"{if $configoption.selectedvalue eq $options.id} checked="checked"{/if}
                                                                                           onclick="recalctotals()"/> {$options.name}</label>
                                                        <br/>
                                                    {/foreach}
                                                    {elseif $configoption.optiontype eq 3}
                                                    <label class="checkbox-inline"><input type="checkbox" name="configoption[{$configoption.id}]"
                                                                                          value="1"{if $configoption.selectedqty} checked{/if}
                                                                                          onclick="recalctotals()"/> {$configoption.options.0.name}</label>
                                                    {elseif $configoption.optiontype eq 4}
                                                    {if $configoption.qtymaximum}
                                                    {literal}
                                                        <script>
                                                            jQuery(function () {
                                                                {/literal}
                                                                var configid = '{$configoption.id}';
                                                                var configmin = {$configoption.qtyminimum};
                                                                var configmax = {$configoption.qtymaximum};
                                                                var configval = {if $configoption.selectedqty}{$configoption.selectedqty}{else}{$configoption.qtyminimum}{/if};
                                                                {literal}
                                                                jQuery("#slider" + configid).slider({
                                                                    min: configmin,
                                                                    max: configmax,
                                                                    value: configval,
                                                                    range: "min",
                                                                    slide: function (event, ui) {
                                                                        jQuery("#confop" + configid).val(ui.value);
                                                                        jQuery("#confoplabel" + configid).html(ui.value);
                                                                    },
                                                                    stop: function (event, ui) {
                                                                        recalctotals();
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    {/literal}
                                                        <table width="90%">
                                                            <tr>
                                                                <td width="30" id="confoplabel{$configoption.id}"
                                                                    class="configoplabel">{if $configoption.selectedqty}{$configoption.selectedqty}{else}{$configoption.qtyminimum}{/if}</td>
                                                                <td>
                                                                    <div id="slider{$configoption.id}"></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <input type="hidden" name="configoption[{$configoption.id}]" id="confop{$configoption.id}"
                                                               value="{if $configoption.selectedqty}{$configoption.selectedqty}{else}{$configoption.qtyminimum}{/if}"/>
                                                    {else}
                                                        <input type="text" name="configoption[{$configoption.id}]" value="{$configoption.selectedqty}" size="5" onkeyup="recalctotals()"
                                                               class="form-control"/>
                                                        x {$configoption.options.0.name}
                                                    {/if}
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach}
                                    </table>

                                    <div id="microweber-themes">
                                        <div class="row"></div>
                                        <script>
                                            $(document).ready(function () {
                                                $.getJSON("https://members2017.microweber.com/_sync/templates-preview/templates.json", function (data) {
                                                    var items = [];
                                                    $.each(data, function (key, val) {
                                                        if (key == 0) {
                                                            var classHidden = '';
                                                        } else {
                                                            var classHidden = 'hidden';
                                                        }
                                                        items.push('<div class="col-xs-12 ' + classHidden + ' template" id="template-' + val.id + '">' +
                                                            '<div class="image-holder" style="background-image: url(' + val.image + ');"></div>' +
                                                            '<p>' + val.title + '</p>' +
                                                            '</div>');
                                                    });

                                                    $("<div/>", {
                                                        "class": "templates",
                                                        html: items.join("")
                                                    }).appendTo("#microweber-themes .row");
                                                });

                                                $('select[name="configoption[1]"]').bind('change', function () {
                                                    var tempID = '#template-' + $(this).val();
                                                    $('#microweber-themes .template').addClass('hidden');
                                                    $(tempID).removeClass('hidden');
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            {/if}

                            {if $addons}
                                <h3>{$LANG.cartavailableaddons}</h3>
                                <div class="addons">
                                    <table width="100%" cellspacing="0" cellpadding="0" class="configtable">
                                        {foreach from=$addons item=addon}
                                            <tr>
                                                <td class="radiofield"><input type="checkbox" name="addons[{$addon.id}]" id="a{$addon.id}"{if $addon.status} checked{/if} onclick="recalctotals()"/>
                                                </td>
                                                <td class="fieldarea"><label for="a{$addon.id}" class="checkbox-inline"><strong>{$addon.name}</strong> - {$addon.pricing}<br/>{$addon.description}
                                                    </label></td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </div>
                            {/if}

                            {if $customfields}
                                <h3>{$LANG.orderadditionalrequiredinfo}</h3>
                                <div class="customfields">
                                    <table width="100%" cellspacing="0" cellpadding="0" class="configtable">
                                        {foreach key=num item=customfield from=$customfields}
                                            <tr>
                                                <td class="fieldlabel">{$customfield.name}</td>
                                                <td class="fieldarea">{$customfield.input} {$customfield.description}</td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </div>
                            {/if}

                        </div>
                        <div class="col-md-6">
                            <div>
                                <div id="cartLoader" class="pull-right">
                                    <i class="fa fa-fw fa-refresh fa-spin"></i>
                                </div>
                                <h3>{$LANG.ordersummary}</h3>
                            </div>
                            <div class="ordersummary" id="producttotal"></div>
                        </div>

                        <div class="text-center">
                            <button type="button" id="btnCompleteProductConfig" class="cbtn" onclick="addtocart();">{$LANG.continue} &nbsp;<i class="fa fa-arrow-circle-right"></i></button>
                            <a href="cart.php?a=view" class="cbtn cbtn-alt"><i class="fa fa-shopping-cart"></i> {$LANG.viewcart}</a>
                        </div>

                    </div>

                    <script>recalctotals();</script>

                </form>

            </div>
        </div>

    </div>
</div>