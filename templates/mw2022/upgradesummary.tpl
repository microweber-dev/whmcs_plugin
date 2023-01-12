<style>
    .mw-whmc-upgrade-table.table > thead > tr > th, .mw-whmc-upgrade-table.panel-default td  {
        padding: 30px!important;
    }

    .mw-whmc-upgrade-row .form-control {
        height: 53px!important;
    }
</style>

<table class="mw-whmc-upgrade-table panel panel-default table">
    <thead>
        <tr>
            <th width="60%">{$LANG.orderdesc}</th>
            <th width="40%" class="text-center">{$LANG.orderprice}</th>
        </tr>
    </thead>
    <tbody>
        {foreach key=num item=upgrade from=$upgrades}
            {if $type eq "package"}
                <tr>
                    <td><input type="hidden" name="pid" value="{$upgrade.newproductid}" /><input type="hidden" name="billingcycle" value="{$upgrade.newproductbillingcycle}" />{$upgrade.oldproductname} => {$upgrade.newproductname}</td>
                    <td class="text-center">{$upgrade.price}</td>
                </tr>
            {elseif $type eq "configoptions"}
                <tr>
                    <td>{$upgrade.configname}: {$upgrade.originalvalue} => {$upgrade.newvalue}</td>
                    <td class="text-center">{$upgrade.price}</td>
                </tr>
            {/if}
        {/foreach}
        <tr class="masspay-total">
            <td class="text-right">{$LANG.ordersubtotal}:</td>
            <td class="text-center">{$subtotal}</td>
        </tr>
        {if $promodesc}
            <tr class="masspay-total">
                <td class="text-right">{$promodesc}:</td>
                <td class="text-center">{$discount}</td>
            </tr>
        {/if}
        {if $taxrate}
            <tr class="masspay-total">
                <td class="text-right">{$taxname} @ {$taxrate}%:</td>
                <td class="text-center">{$tax}</td>
            </tr>
        {/if}
        {if $taxrate2}
            <tr class="masspay-total">
                <td class="text-right">{$taxname2} @ {$taxrate2}%:</td>
                <td class="text-center">{$tax2}</td>
            </tr>
        {/if}
        <tr class="masspay-total">
            <td class="text-right">{$LANG.ordertotalduetoday}:</td>
            <td class="text-center">{$total}</td>
        </tr>
    </tbody>
</table>

{if $type eq "package"}
    {include file="$template/includes/alert.tpl" type="warning" msg=$LANG.upgradeproductlogic|cat:' ('|cat:$upgrade.daysuntilrenewal|cat:' '|cat:$LANG.days|cat:')' textcenter=true}
{/if}

<div class="row mw-whmc-upgrade-row mt-5">
    <div class="col-lg-6 col-12 mt-5 ">

        <div class="panel panel-default" style="height: 100%;">

            <form method="post" action="{$smarty.server.PHP_SELF}" role="form" id="upgrade-form">
                   <input type="hidden" name="step" value="2" />
                   <input type="hidden" name="type" value="{$type}" />
                   <input type="hidden" name="id" value="{$id}" />
                   {if $type eq "package"}
                       <input type="hidden" name="pid" value="{$upgrades.0.newproductid}" />
                       <input type="hidden" name="billingcycle" value="{$upgrades.0.newproductbillingcycle}" />
                   {/if}
                   {include file="$template/includes/subheader.tpl" title=$LANG.orderpromotioncode}
                   {foreach from=$configoptions key=cid item=value}
                       <input type="hidden" name="configoption[{$cid}]" value="{$value}" />
                   {/foreach}
                   <div class="input-group " style="display: flex; flex-wrap: wrap;">
                       <input class="form-control col-xl-8 col-12 mt-3" type="text" name="promocode" placeholder="{$LANG.orderpromotioncode}" width="40"
                              {if $promocode}value="{$promocode} - {$promodesc}" disabled="disabled"{/if}>
                       {if $promocode}
                           <span class="input-group-btn col-md-2 col-12">
                            <input type="submit" name="removepromo" value="{$LANG.orderdontusepromo}"
                                   class="whmc-kbtn-2" />
                        </span>
                       {else}
                           <span class="input-group-btn col-xl-2 col-12 mt-3">
                            <input type="submit" value="{$LANG.orderpromovalidatebutton}" class="whmc-kbtn-2" />
                        </span>
                       {/if}
                   </div>
               </form>
       </div>

    </div>
    <div class="col-lg-6 col-12 mt-5 ">

        <div class="panel panel-default" style="height: 100%;" >
            <form method="post" action="{$smarty.server.PHP_SELF}" id="upgrade-form-payment">
                <input type="hidden" name="step" value="3" />
                <input type="hidden" name="type" value="{$type}" />
                <input type="hidden" name="id" value="{$id}" />
                {if $type eq "package"}
                    <input type="hidden" name="pid" value="{$upgrades.0.newproductid}" />
                    <input type="hidden" name="billingcycle" value="{$upgrades.0.newproductbillingcycle}" />
                {/if}
                {foreach from=$configoptions key=cid item=value}
                    <input type="hidden" name="configoption[{$cid}]" value="{$value}" />
                {/foreach}
                {if $promocode}<input type="hidden" name="promocode" value="{$promocode}">{/if}

                {include file="$template/includes/subheader.tpl" title=$LANG.orderpaymentmethod}
                <div class="form-group">
                    <select name="paymentmethod" id="inputPaymentMethod" class="form-control">
                        {if $allowgatewayselection}
                            <option value="none">{$LANG.paymentmethoddefault}</option>
                        {/if}
                        {foreach key=num item=gateway from=$gateways}
                            <option value="{$gateway.sysname}"{if $gateway.sysname eq $selectedgateway} selected="selected"{/if}>{$gateway.name}</option>
                        {/foreach}
                    </select>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="form-group text-center mt-5">
    <input type="submit" value="{$LANG.ordercontinuebutton}" class="whmc-kbtn mt-5" form="upgrade-form-payment" />
</div>

