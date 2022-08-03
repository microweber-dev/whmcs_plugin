

<link href="modules/servers/cpanel/css/client.css" rel="stylesheet">
<script src="modules/servers/cpanel/js/client.js"></script>

<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default" id="cPanelPackagePanel">
            <div class="panel-heading">
                <h3 class="panel-title">{$LANG.cPanel.packageDomain}</h3>
            </div>
            <div class="panel-body text-center">

                <div class="cpanel-package-details">
                    <em>{$groupname}</em>
                    <h4 style="margin:0;">{$product}</h4>
                    <a href="http://{$domain}" target="_blank">www.{$domain}</a>
                </div>

                <p>
                    <a href="http://{$domain}" class="btn btn-default btn-sm" target="_blank">{$LANG.visitwebsite}</a>
                    {if $domainId}
                        <a href="clientarea.php?action=domaindetails&id={$domainId}" class="btn btn-success btn-sm" target="_blank">{$LANG.managedomain}</a>
                    {/if}
                    <input type="button" onclick="popupWindow('whois.php?domain={$domain}','whois',650,420);return false;" value="{$LANG.whoisinfo}" class="btn btn-info btn-sm" />
                </p>

            </div>
        </div>

        {if $availableAddonProducts}
            <div class="panel panel-default" id="cPanelExtrasPurchasePanel">
                <div class="panel-heading">
                    <h3 class="panel-title">{$LANG.cPanel.addonsExtras}</h3>
                </div>
                <div class="panel-body text-center">

                    <form method="post" action="cart.php?a=add" class="form-inline">
                        <input type="hidden" name="serviceid" value="{$serviceid}" />
                        <select name="aid" class="form-control input-sm">
                            {foreach $availableAddonProducts as $addonId => $addonName}
                                <option value="{$addonId}">{$addonName}</option>
                            {/foreach}
                        </select>
                        <button type="submit" class="btn btn-default btn-sm">
                            <i class="fas fa-shopping-cart"></i>
                            {$LANG.cPanel.purchaseActivate}
                        </button>
                    </form>

                </div>
            </div>
        {/if}

    </div>
    <div class="col-md-6">

        <div class="panel panel-default" id="cPanelUsagePanel">
            <div class="panel-heading">
                <h3 class="panel-title">{$LANG.cPanel.usageStats}</h3>
            </div>
            <div class="panel-body text-center cpanel-usage-stats">

                <div class="row">
                    <div class="col-sm-5 col-sm-offset-1 col-xs-6" id="diskUsage">
                        <strong>{$LANG.cPanel.diskUsage}</strong>
                        <br /><br />
                        <input type="text" value="{$diskpercent|substr:0:-1}" class="usage-dial" data-fgColor="#444" data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="{if substr($diskpercent, 0, -1) > 100}{$diskpercent|substr:0:-1}{else}100{/if}" data-readOnly="true" data-width="100" data-height="80" />
                        <br /><br />
                        {$diskusage} M / {$disklimit} M
                    </div>
                    <div class="col-sm-5 col-xs-6" id="bandwidthUsage">
                        <strong>{$LANG.cPanel.bandwidthUsage}</strong>
                        <br /><br />
                        <input type="text" value="{$bwpercent|substr:0:-1}" class="usage-dial" data-fgColor="#d9534f" data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="{if substr($bwpercent, 0, -1) > 100}{$bwpercent|substr:0:-1}{else}100{/if}" data-readOnly="true" data-width="100" data-height="80" />
                        <br /><br />
                        {$bwusage} M / {$bwlimit} M
                    </div>
                </div>

                {if $bwpercent|substr:0:-1 > 75}
                    <div class="text-danger limit-near">
                        {if $bwpercent|substr:0:-1 > 100}
                            {$LANG.cPanel.usageStatsBwOverLimit}
                        {else}
                            {$LANG.cPanel.usageStatsBwLimitNear}
                        {/if}
                        {if $packagesupgrade}
                            <a href="upgrade.php?type=package&id={$serviceid}" class="btn btn-xs btn-danger">
                                <i class="fas fa-arrow-circle-up"></i>
                                {$LANG.cPanel.usageUpgradeNow}
                            </a>
                        {/if}
                    </div>
                {elseif $diskpercent|substr:0:-1 > 75}
                    <div class="text-danger limit-near">
                        {if $diskpercent|substr:0:-1 > 100}
                            {$LANG.cPanel.usageStatsDiskOverLimit}
                        {else}
                            {$LANG.cPanel.usageStatsDiskLimitNear}
                        {/if}
                        {if $packagesupgrade}
                            <a href="upgrade.php?type=package&id={$serviceid}" class="btn btn-xs btn-danger">
                                <i class="fas fa-arrow-circle-up"></i>
                                {$LANG.cPanel.usageUpgradeNow}
                            </a>
                        {/if}
                    </div>
                {else}
                    <div class="text-info limit-near">
                        {$LANG.cPanel.usageLastUpdated} {$lastupdate}
                    </div>
                {/if}

                <script src="{$BASE_PATH_JS}/jquery.knob.js"></script>
                <script type="text/javascript">
                    jQuery(function() {
                        jQuery(".usage-dial").knob({
                            'format': function (value) {
                                return value + '%';
                            }
                        });
                    });
                </script>

            </div>
        </div>

    </div>
</div>

{foreach $hookOutput as $output}
    <div>
        {$output}
    </div>
{/foreach}

{if $systemStatus == 'Active'}




{else}

    <div class="alert alert-warning text-center" role="alert" id="cPanelSuspendReasonPanel">
        {if $suspendreason}
            <strong>{$suspendreason}</strong><br />
        {/if}
        {$LANG.cPanel.packageNotActive} {$status}.<br />
        {if $systemStatus eq "Pending"}
            {$LANG.cPanel.statusPendingNotice}
        {elseif $systemStatus eq "Suspended"}
            {$LANG.cPanel.statusSuspendedNotice}
        {/if}
    </div>

{/if}

<div class="panel panel-default" id="cPanelBillingOverviewPanel">
    <div class="panel-heading">
        <h3 class="panel-title">{$LANG.cPanel.billingOverview}</h3>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-5">
                {if $firstpaymentamount neq $recurringamount}
                    <div class="row" id="firstPaymentAmount">
                        <div class="col-xs-6 text-right" >
                            {$LANG.firstpaymentamount}
                        </div>
                        <div class="col-xs-6">
                            {$firstpaymentamount}
                        </div>
                    </div>
                {/if}
                {if $billingcycle != $LANG.orderpaymenttermonetime && $billingcycle != $LANG.orderfree}
                    <div class="row" id="recurringAmount">
                        <div class="col-xs-6 text-right">
                            {$LANG.recurringamount}
                        </div>
                        <div class="col-xs-6">
                            {$recurringamount}
                        </div>
                    </div>
                {/if}
                <div class="row" id="billingCycle">
                    <div class="col-xs-6 text-right">
                        {$LANG.orderbillingcycle}
                    </div>
                    <div class="col-xs-6">
                        {$billingcycle}
                    </div>
                </div>
                <div class="row" id="paymentMethod">
                    <div class="col-xs-6 text-right">
                        {$LANG.orderpaymentmethod}
                    </div>
                    <div class="col-xs-6">
                        {$paymentmethod}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row" id="registrationDate">
                    <div class="col-xs-6 col-md-5 text-right">
                        {$LANG.clientareahostingregdate}
                    </div>
                    <div class="col-xs-6 col-md-7">
                        {$regdate}
                    </div>
                </div>
                <div class="row" id="nextDueDate">
                    <div class="col-xs-6 col-md-5 text-right">
                        {$LANG.clientareahostingnextduedate}
                    </div>
                    <div class="col-xs-6 col-md-7">
                        {$nextduedate}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{if $configurableoptions}
    <div class="panel panel-default" id="cPanelConfigurableOptionsPanel">
        <div class="panel-heading">
            <h3 class="panel-title">{$LANG.orderconfigpackage}</h3>
        </div>
        <div class="panel-body">
            {foreach from=$configurableoptions item=configoption}
                <div class="row">
                    <div class="col-md-5 col-xs-6 text-right">
                        <strong>{$configoption.optionname}</strong>
                    </div>
                    <div class="col-md-7 col-xs-6 text-left">
                        {if $configoption.optiontype eq 3}{if $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.optiontype eq 4}{$configoption.selectedqty} x {$configoption.selectedoption}{else}{$configoption.selectedoption}{/if}
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/if}
{if $customfields}
    <div class="panel panel-default" id="cPanelAdditionalInfoPanel">
        <div class="panel-heading">
            <h3 class="panel-title">{$LANG.additionalInfo}</h3>
        </div>
        <div class="panel-body">
            {foreach from=$customfields item=field}
                <div class="row">
                    <div class="col-md-5 col-xs-6 text-right">
                        <strong>{$field.name}</strong>
                    </div>
                    <div class="col-md-7 col-xs-6 text-left">
                        {if empty($field.value)}
                            {$LANG.blankCustomField}
                        {else}
                            {$field.value}
                        {/if}
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/if}
