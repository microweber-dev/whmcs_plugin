<link href="modules/servers/cpanel/css/client.css" rel="stylesheet">
<script src="modules/servers/cpanel/js/client.js"></script>

<div class="row col-12" style="justify-content: center;">

    <div class="col-xl-6 col-12 pe-5">

        <div class="product-status product-status-{$rawstatus|strtolower}">
            <div class="product-icon text-center">
                <svg class="svg-icon svg-icon-on-dark" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                    <line style="stroke: #ffffff;" class="svg-icon-outline-s" x1="32" y1="1.5" x2="32" y2="8.4"></line>
                    <polygon  class="svg-icon-prime svg-icon-stroke" points="17,23 32,31.7 47,23 47,16.9 17,16.9"></polygon>
                    <polygon class="svg-icon-prime-l svg-icon-stroke" points="32,25.2 17,16.6 32,7.9 47,16.6"></polygon>
                    <line style="stroke: #ffffff;" class="svg-icon-outline-s" x1="32" y1="32.7" x2="32" y2="62.5"></line>
                    <polyline style="stroke: #ffffff;" class="svg-icon-outline-s" points="58.5,16.9 32,32.2 5.5,16.9"></polyline>
                    <polygon style="stroke: #ffffff;" class="svg-icon-outline-s" points="32,63 5,47.4 5,16.6 32,1 59,16.6 59,47.4"></polygon>
                                </svg>
                <div class="mt-5 pt-3">
                    <h2 style="font-weight: 700; color: #ffffff;">{$product}</h2>
                    <h3 style="font-weight: 700; color: #ffffff;">{$groupname}</h3>
                </div>


                <p class=" mt-5 pt-5">
                    <a href="http://{$domain}" class="whmc-kbtn-2 my-3" target="_blank">{$LANG.visitwebsite}</a>
                    {if $domainId}
                        <a href="clientarea.php?action=domaindetails&id={$domainId}" class="whmc-kbtn my-3" target="_blank">{$LANG.managedomain}</a>
                    {/if}
                </p>

            </div>

        </div>

    </div>
    <div class="col-xl-6 col-12 ps-5" >

        <div class="row panel card panel-default mb-3" id="cPanelUsagePanel"
             style="height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;">
            {*           <div class="panel-heading card-header">*}
            {*               <h3 class="panel-title card-title m-0">{lang key='usageStats'}</h3>*}
            {*           </div>*}
            <div class="panel-body card-body text-center cpanel-usage-stats">

                <div class="row">
                    <div class="col-xl-6 col-12" id="diskUsage">
                        <strong style="color: #acb0b9; font-weight: 500;">{$LANG.MWdiskUsage}</strong>
                        <br /><br />
                        <input type="text" value="{$diskpercent|substr:0:-1}" class="usage-dial" data-fgColor="#444" data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="{if substr($diskpercent, 0, -1) > 100}{$diskpercent|substr:0:-1}{else}100{/if}" data-readOnly="true" data-width="130" data-height="100" />
                        <br /><br />
                        <span style="color: #acb0b9; font-weight: 500;">  {$diskusage} M / {$disklimit} M </span>
                    </div>
                    <div class="col-xl-6 col-12" id="bandwidthUsage">
                        <strong style="color: #acb0b9; font-weight: 500;">{$LANG.MWbandwidthUsage}</strong>
                        <br /><br />
                        <input type="text" value="{$bwpercent|substr:0:-1}" class="usage-dial" data-fgColor="#d9534f" data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="{if substr($bwpercent, 0, -1) > 100}{$bwpercent|substr:0:-1}{else}100{/if}" data-readOnly="true" data-width="130" data-height="100" />
                        <br /><br />
                        <span style="color: #acb0b9; font-weight: 500;"> {$bwusage} M / {$bwlimit} M</span>
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
                    {*                   <div class="text-info limit-near">*}
                    {*                       {lang key='usageLastUpdated'} {$lastupdate}*}
                    {*                   </div>*}
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
                        <button class="whmc-kbtn-2 btn-block" id="btnGoToWordPressHome">
                            <i class="fab fa-wordpress"></i>
                            {lang key='wptk.goToWebsite'}
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="whmc-kbtn-2 btn-block" id="btnGoToWordPressAdmin">
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
                        <button class="whmc-kbtn-2 btn-block" id="btnInstallWordpress">
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
                            <button type="submit" class="whmc-kbtnbtn-block">
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

<div class="row col-12">
    <div class="col-xl-6 col-12 ">
        <div class=" panel-default panel card mb-3" id="cPanelBillingOverviewPanel">
            <div class="panel-heading card-header">
                <h3 class="panel-title card-title m-0"> {$LANG.MWbillindOverview}</h3>
            </div>
            <div class="panel-body card-body">

                <div class="row">
                    <div class="col-md-5">
                        {if $firstpaymentamount neq $recurringamount}
                            <div class="row" id="firstPaymentAmount">
                                <div class="col-xs-6 col-6 text-left" >
                                    {$LANG.firstpaymentamount}
                                </div>
                                <div class="col-xs-6 col-6">
                                    {$firstpaymentamount}
                                </div>
                            </div>
                        {/if}
                        {if $billingcycle != $LANG.orderpaymenttermonetime && $billingcycle != $LANG.orderfree}
                            <div class="row" id="recurringAmount">
                                <div class="col-xs-6 col-6 text-left">
                                    {$LANG.recurringamount}
                                </div>
                                <div class="col-xs-6 col-6">
                                    {$recurringamount}
                                </div>
                            </div>
                        {/if}
                        <div class="row" id="billingCycle">
                            <div class="col-xs-6 col-6 text-left">
                                {$LANG.orderbillingcycle}
                            </div>
                            <div class="col-xs-6 col-6">
                                {$billingcycle}
                            </div>
                        </div>
                        <div class="row" id="paymentMethod">
                            <div class="col-xs-6 col-6 text-left">
                                {$LANG.orderpaymentmethod}
                            </div>
                            <div class="col-xs-6 col-6">
                                {$paymentmethod}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row" id="registrationDate">
                            <div class="col-xs-6 col-6 col-xl-5 text-left">
                                {$LANG.clientareahostingregdate}
                            </div>
                            <div class="col-xs-6 col-6 col-xl-7">
                                {$regdate}
                            </div>
                        </div>
                        <div class="row" id="nextDueDate">
                            <div class="col-xs-6 col-6 col-xl-5 text-left">
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
    </div>

    <div class="col-xl-6 col-12">
        {if $configurableoptions}
            <div class="panel card panel-default mb-3" id="cPanelConfigurableOptionsPanel">
                <div class="panel-heading card-header">
                    <h3 class="panel-title card-title m-0">{$LANG.orderconfigpackage}</h3>
                </div>
                <div class="panel-body card-body">
                    {foreach from=$configurableoptions item=configoption}
                        <div class="row">
                            <div class="col-md-3 col-xs-6 col-6 text-left">
                                <strong>{$configoption.optionname}</strong>
                            </div>
                            <div class="col-md-9 col-xs-6 col-6 text-left">
                                {if $configoption.optiontype eq 3}{if $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.optiontype eq 4}{$configoption.selectedqty} x {$configoption.selectedoption}{else}{$configoption.selectedoption}{/if}
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        {/if}
    </div>
</div>


<div class="col-xl-6 col-12">
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
</div>
<div class="col-xl-6 col-12">
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
</div>
