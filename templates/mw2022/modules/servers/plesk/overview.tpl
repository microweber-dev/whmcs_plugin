<link href="modules/servers/cpanel/css/client.css" rel="stylesheet">
<script src="modules/servers/cpanel/js/client.js"></script>

<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default card mb-3" id="cPanelPackagePanel">
            <div class="panel-heading card-header">
                <h3 class="panel-title card-title m-0">{lang key='packageDomain'}</h3>
            </div>
            <div class="panel-body card-body text-center">

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
                </p>

            </div>
        </div>

        {if $availableAddonProducts}
            <div class="panel panel-default card mb-3" id="cPanelExtrasPurchasePanel">
                <div class="panel-heading card-header">
                    <h3 class="panel-title card-title m-0">{lang key='addonsExtras'}</h3>
                </div>
                <div class="panel-body card-body text-center mx-auto">

                    <form method="post" action="{$WEB_ROOT}/cart.php?a=add" class="form-inline">
                        <input type="hidden" name="serviceid" value="{$serviceid}" />
                        <select name="aid" class="form-control custom-select w-100 input-sm form-control-sm mr-2">
                            {foreach $availableAddonProducts as $addonId => $addonName}
                                <option value="{$addonId}">{$addonName}</option>
                            {/foreach}
                        </select>
                        <button type="submit" class="btn btn-default btn-sm btn-block mt-1">
                            <i class="fas fa-shopping-cart"></i>
                            {lang key='purchaseActivate'}
                        </button>
                    </form>

                </div>
            </div>
        {/if}

    </div>
    <div class="col-md-6">

        <div class="panel card panel-default mb-3" id="cPanelUsagePanel">
            <div class="panel-heading card-header">
                <h3 class="panel-title card-title m-0">{lang key='usageStats'}</h3>
            </div>
            <div class="panel-body card-body text-center cpanel-usage-stats">

                <div class="row">
                    <div class="col-md-6" id="diskUsage">
                        <strong>{lang key='diskUsage'}</strong>
                        <br /><br />
                        <input type="text" value="{$diskpercent|substr:0:-1}" class="usage-dial" data-fgColor="#444" data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="{if substr($diskpercent, 0, -1) > 100}{$diskpercent|substr:0:-1}{else}100{/if}" data-readOnly="true" data-width="100" data-height="80" />
                        <br /><br />
                        {$diskusage} M / {$disklimit} M
                    </div>
                    <div class="col-md-6" id="bandwidthUsage">
                        <strong>{lang key='bandwidthUsage'}</strong>
                        <br /><br />
                        <input type="text" value="{$bwpercent|substr:0:-1}" class="usage-dial" data-fgColor="#d9534f" data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="{if substr($bwpercent, 0, -1) > 100}{$bwpercent|substr:0:-1}{else}100{/if}" data-readOnly="true" data-width="100" data-height="80" />
                        <br /><br />
                        {$bwusage} M / {$bwlimit} M
                    </div>
                </div>
                {if $bwpercent|substr:0:-1 > 75}
                    <div class="text-danger limit-near">
                        {if $bwpercent|substr:0:-1 > 100}
                            {lang key='usageStatsBwOverLimit'}
                        {else}
                            {lang key='usageStatsBwLimitNear'}
                        {/if}
                        {if $packagesupgrade}
                            <a href="upgrade.php?type=package&id={$serviceid}" class="btn btn-sm btn-danger">
                                <i class="fas fa-arrow-circle-up"></i>
                                {lang key='usageUpgradeNow'}
                            </a>
                        {/if}
                    </div>
                {elseif $diskpercent|substr:0:-1 > 75}
                    <div class="text-danger limit-near">
                        {if $diskpercent|substr:0:-1 > 100}
                            {lang key='usageStatsDiskOverLimit'}
                        {else}
                            {lang key='usageStatsDiskLimitNear'}
                        {/if}
                        {if $packagesupgrade}
                            <a href="upgrade.php?type=package&id={$serviceid}" class="btn btn-sm btn-danger">
                                <i class="fas fa-arrow-circle-up"></i>
                                {lang key='usageUpgradeNow'}
                            </a>
                        {/if}
                    </div>
                {else}
                    <div class="text-info limit-near">
                        {lang key='usageLastUpdated'} {$lastupdate}
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
    {if count($wpInstances) || $allowWpClientInstall}
        <div class="panel card panel-default mb-3" id="cPanelWordPress" data-service-id="{$serviceId}" data-wp-domain="{$wpDomain}">
            <div class="panel-heading card-header">
                <h3 class="panel-title card-title m-0">WordPress®</h3>
            </div>
            <div class="panel-body card-body">
                <div class="row{if !$allowWpClientInstall} no-margin{/if}" id="wordpressInstanceRow" {if !count($wpInstances)}style="display: none" {/if}>
                    <div class="col-md-4">
                        <select class="form-control" id="wordPressInstances">
                            {foreach $wpInstances as $wpInstance}
                                <option value="{$wpInstance.instanceUrl}">
                                    {$wpInstance.blogTitle}
                                    {if $wpInstance.path} ({$wpInstance.path}){/if}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-default btn-block" id="btnGoToWordPressHome">
                            <i class="fab fa-wordpress"></i>
                            {lang key='wptk.goToWebsite'}
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-default btn-block" id="btnGoToWordPressAdmin">
                            <i class="fas fa-users-cog"></i>
                            {lang key='wptk.goToAdmin'}
                        </button>
                    </div>
                </div>
                <div class="row" {if !$allowWpClientInstall}style="display: none"{/if}>
                    <div class="col-md-12">
                        <h5>{lang key='wptk.createNew'}</h5>
                        <p class="small" id="newWordPressFullUrlPreview">https://{$wpDomain}/</p>
                    </div>
                    <div class="col-md-12" id="wordPressInstallResultRow" style="display: none">
                        <div class="alert alert-success" style="display: none">
                            {lang key='wptk.installationSuccess'}
                        </div>
                        <div class="alert alert-danger" style="display: none">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="wpNewBlogTitle" placeholder="New Blog Title" />
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="wpNewPath" placeholder="Path (optional)" />
                    </div>
                    <div class="col-md-3">
                        <input type="password" class="form-control" id="wpAdminPass" placeholder="Admin Password" />
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-default btn-block" id="btnInstallWordpress">
                            <i class="far fa-fw fa-plus"></i>
                            {lang key='wptk.installWordPressShort'}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    {/if}


{*
    <div class="panel card panel-default mb-3" id="cPanelQuickShortcutsPanel">
        <div class="panel-heading card-header">
            <h3 class="panel-title card-title m-0">{lang key='quickShortcuts'}</h3>
        </div>
        <div class="panel-body card-body text-center">

            <div class="row cpanel-feature-row">
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelEmailAccounts">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Email_Accounts" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/email_accounts.png" />
                        {$LANG.cPanel.emailAccounts}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelForwarders">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Email_Forwarders" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/forwarders.png" />
                        {$LANG.cPanel.forwarders}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelAutoResponders">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Email_AutoResponders" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/autoresponders.png" />
                        {$LANG.cPanel.autoresponders}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelFileManager">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=FileManager_Home" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/file_manager.png" />
                        {$LANG.fileManager}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelBackup">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Backups_Home" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/backup.png" />
                        {$LANG.cPanel.backup}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelSubdomains">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Domains_SubDomains" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/subdomains.png" />
                        {$LANG.cPanel.subdomains}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelAddonDomains">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Domains_AddonDomains" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/addon_domains.png" />
                        {$LANG.cPanel.addonDomains}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelCronJobs">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Cron_Home" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/cron_jobs.png" />
                        {$LANG.cPanel.cronJobs}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelMySQLDatabases">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Database_MySQL" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/mysql_databases.png" />
                        {$LANG.mysqlDatabases}
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 col-6" id="cPanelPhpMyAdmin">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Database_phpMyAdmin" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/php_my_admin.png" />
                        {$LANG.cPanel.phpMyAdmin}
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6" id="cPanelAwstats">
                    <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;dosinglesignon=1&amp;app=Stats_AWStats" target="_blank" class="d-block mb-3">
                        <img src="modules/servers/cpanel/img/awstats.png" />
                        {$LANG.cPanel.awstats}
                    </a>
                </div>
                {if $hasWPTDeluxe}
                    <div class="col-sm-3 col-xs-6" id="cPanelWptk">
                        <a href="clientarea.php?action=productdetails&amp;id={$serviceid}&amp;addonId={$wptkDeluxeAddonId}&amp;doaddonsignon=1" target="_blank" class="d-block mb-3">
                            <img src="modules/servers/cpanel/img/wptk.png" />
                            {$LANG.cPanel.wptk}
                        </a>
                    </div>
                {/if}
            </div>

        </div>
    </div>


    <div class="panel card panel-default mb-3" id="cPanelQuickEmailPanel">
        <div class="panel-heading card-header">
            <h3 class="panel-title card-title m-0">{$LANG.cPanel.createEmailAccount}</h3>
        </div>
        <div class="panel-body card-body">

            {include file="$template/includes/alert.tpl" type="success" msg=$LANG.cPanel.emailAccountCreateSuccess textcenter=true hide=true idname="emailCreateSuccess" additionalClasses="email-create-feedback"}

            {include file="$template/includes/alert.tpl" type="danger" msg=$LANG.cPanel.emailAccountCreateFailed|cat:' <span id="emailCreateFailedErrorMsg"></span>' textcenter=true hide=true idname="emailCreateFailed" additionalClasses="email-create-feedback"}

            <form id="frmCreateEmailAccount" onsubmit="doEmailCreate();return false">
                <input type="hidden" name="id" value="{$serviceid}" />
                <input type="hidden" name="email_quota" value="250" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-1">
                            <input type="text" id="cpanel-email-prefix" name="email_prefix" class="form-control" placeholder="{$LANG.cPanel.usernamePlaceholder}">
                            <div class="input-group-addon input-group-append">
                                <span class="input-group-text">
                                    <small>@{$domain}</small>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="password" id="cpanel-email-password" name="email_pw" class="form-control mb-1" placeholder="{$LANG.cPanel.passwordPlaceholder}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-plus" id="btnCreateLoader"></i>
                            {$LANG.cPanel.create}
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
*}
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

<div class="panel card panel-default mb-3" id="cPanelBillingOverviewPanel">
    <div class="panel-heading card-header">
        <h3 class="panel-title card-title m-0">{lang key='billingOverview'}</h3>
    </div>
    <div class="panel-body card-body">

        <div class="row">
            <div class="col-md-5">
                {if $firstpaymentamount neq $recurringamount}
                    <div class="row" id="firstPaymentAmount">
                        <div class="col-xs-6 col-6 text-right" >
                            {$LANG.firstpaymentamount}
                        </div>
                        <div class="col-xs-6 col-6">
                            {$firstpaymentamount}
                        </div>
                    </div>
                {/if}
                {if $billingcycle != $LANG.orderpaymenttermonetime && $billingcycle != $LANG.orderfree}
                    <div class="row" id="recurringAmount">
                        <div class="col-xs-6 col-6 text-right">
                            {$LANG.recurringamount}
                        </div>
                        <div class="col-xs-6 col-6">
                            {$recurringamount}
                        </div>
                    </div>
                {/if}
                <div class="row" id="billingCycle">
                    <div class="col-xs-6 col-6 text-right">
                        {$LANG.orderbillingcycle}
                    </div>
                    <div class="col-xs-6 col-6">
                        {$billingcycle}
                    </div>
                </div>
                <div class="row" id="paymentMethod">
                    <div class="col-xs-6 col-6 text-right">
                        {$LANG.orderpaymentmethod}
                    </div>
                    <div class="col-xs-6 col-6">
                        {$paymentmethod}
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row" id="registrationDate">
                    <div class="col-xs-6 col-6 col-xl-5 text-right">
                        {$LANG.clientareahostingregdate}
                    </div>
                    <div class="col-xs-6 col-6 col-xl-7">
                        {$regdate}
                    </div>
                </div>
                <div class="row" id="nextDueDate">
                    <div class="col-xs-6 col-6 col-xl-5 text-right">
                        {$LANG.clientareahostingnextduedate}
                    </div>
                    <div class="col-xs-6 col-6 col-xl-7">
                        {$nextduedate}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{if $configurableoptions}
    <div class="panel card panel-default mb-3" id="cPanelConfigurableOptionsPanel">
        <div class="panel-heading card-header">
            <h3 class="panel-title card-title m-0">{$LANG.orderconfigpackage}</h3>
        </div>
        <div class="panel-body card-body">
            {foreach from=$configurableoptions item=configoption}
                <div class="row">
                    <div class="col-md-5 col-xs-6 col-6 text-right">
                        <strong>{$configoption.optionname}</strong>
                    </div>
                    <div class="col-md-7 col-xs-6 col-6 text-left">
                        {if $configoption.optiontype eq 3}{if $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.optiontype eq 4}{$configoption.selectedqty} x {$configoption.selectedoption}{else}{$configoption.selectedoption}{/if}
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/if}
{if $metricStats}
    <div class="panel card panel-default mb-3" id="cPanelMetricStatsPanel">
        <div class="panel-heading card-header">
            <h3 class="panel-title card-title m-0">{$LANG.metrics.title}</h3>
        </div>
        <div class="panel-body card-body">
            {include file="$template/clientareaproductusagebilling.tpl"}
        </div>
    </div>
{/if}
{if $customfields}
    <div class="panel card panel-default mb-3" id="cPanelAdditionalInfoPanel">
        <div class="panel-heading card-header">
            <h3 class="panel-title card-title m-0">{$LANG.additionalInfo}</h3>
        </div>
        <div class="panel-body card-body">
            {foreach from=$customfields item=field}
                <div class="row">
                    <div class="col-md-5 col-xs-6 col-6 text-right">
                        <strong>{$field.name}</strong>
                    </div>
                    <div class="col-md-7 col-xs-6 col-6 text-left">
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
