
<div class="mw-whm clientareaproductdetails">
    <div class="text-left">
        <h1 class="py-4 mt-5" style="font-weight: 700!important; font-size: 40px!important;">{$LANG.MW_productDetails}</h1><br />
    </div>
    {if $modulecustombuttonresult}
        {if $modulecustombuttonresult == "success"}
            {include file="$template/includes/alert.tpl" type="success" msg=$LANG.moduleactionsuccess textcenter=true idname="alertModuleCustomButtonSuccess"}
        {else}
            {include file="$template/includes/alert.tpl" type="error" msg=$LANG.moduleactionfailed|cat:' ':$modulecustombuttonresult textcenter=true idname="alertModuleCustomButtonFailed"}
        {/if}
    {/if}

    {if $pendingcancellation}
        {include file="$template/includes/alert.tpl" type="error" msg=$LANG.cancellationrequestedexplanation textcenter=true idname="alertPendingCancellation"}
    {/if}


    <div class="tab-content margin-bottom my-5">
        <div class="tab-pane fade in active" id="tabOverview">

            {if $tplOverviewTabOutput}
            {$tplOverviewTabOutput}
            {else}
            <div class="product-details clearfix">

                <div class="row justify-content-center mx-auto" style="justify-content: center;">
                    <div class="row col-sm-12 " style="justify-content: center;">
                        <div class="col-lg-5 mx-3">
                            <div class="row product-status product-status-{$rawstatus|strtolower}">
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
                                </div>

                                <div class="product-footer text-center">
                                    {if $packagesupgrade}

                                        {if $packagesupgrade}

                                            <a href="upgrade.php?type=package&amp;id={$id}" class="whmc-kbtn-2" style="border-radius: 0px;">{$LANG.upgrade}</a>

                                        {/if}
                                        {if $showcancelbutton}

                                            <a href="clientarea.php?action=cancel&amp;id={$id}"
                                               class="btn btn-block btn-danger {if $pendingcancellation}disabled{/if}">{if $pendingcancellation}{$LANG.cancellationrequested}{else}{$LANG.clientareacancelrequestbutton}{/if}</a>

                                        {/if}
                                    {/if}
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-5 mx-3" style="margin-top: 50px;">
                            <div class=" panel panel-default" style="height:100%;">


                                <div class=" py-3">
                                    <h4 style="font-size: 15px; color: #acb0b9;">{$LANG.MW_status}</h4>
                                    <h3 style="font-size: 18px; margin: 0;"> {$status}</h3>
                                </div>


                                <div class=" py-3">
                                    <h4  style="font-size: 15px; color: #acb0b9;">{$LANG.clientareahostingregdate}</h4>
                                    <h3 style="font-size: 18px; margin: 0;">{$regdate}</h3>
                                </div>

                                {if $firstpaymentamount neq $recurringamount}
                                    <div class=" py-3">
                                        <h4  style="color: #acb0b9;">{$LANG.firstpaymentamount}</h4 >
                                        <h3 style="font-size: 18px; margin: 0;"> {$firstpaymentamount}</h3>
                                    </div>
                                {/if}

                                {if $billingcycle != $LANG.orderpaymenttermonetime && $billingcycle != $LANG.orderfree}
                                    <div class=" py-3">
                                        <h4  style="font-size: 15px; color: #acb0b9;">{$LANG.recurringamount}</h4 >
                                        <h3 style="font-size: 18px; margin: 0;"> {$recurringamount}</h3>
                                    </div>
                                {/if}

                                <div class=" py-3">
                                    <h4  style="font-size: 15px; color: #acb0b9;">{$LANG.orderbillingcycle}</h4 >
                                    <h3 style="font-size: 18px; margin: 0;"> {$billingcycle}</h3>
                                </div>

                                <div class=" py-3">
                                    <h4  style="font-size: 15px; color: #acb0b9;">{$LANG.clientareahostingnextduedate}</h4 >
                                    <h3 style="font-size: 18px; margin: 0;"> {$nextduedate}</h3>
                                </div>

                                <div class=" py-3">
                                    <h4  style="font-size: 15px; color: #acb0b9;">{$LANG.orderpaymentmethod}</h4 >
                                    <h3 style="font-size: 18px; margin: 0;"> {$paymentmethod}</h3>
                                </div>

                                {if $suspendreason}
                                    <div class=" py-3">
                                        <h4  style="font-size: 15px; color: #acb0b9;">{$LANG.suspendreason}</h4 >
                                        <h3 style="font-size: 18px; margin: 0;"> {$suspendreason}</h3>
                                    </div>
                                {/if}

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-5 padding-x-0 px-0">
                        {foreach $hookOutput as $output}
                            <div>
                                {$output}
                            </div>
                        {/foreach}
                    </div>


                    {if $domain || $moduleclientarea || $configurableoptions || $customfields || $lastupdate}
                        <div class="row col-md-10 col-12 client-area-details-tabs-box">
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <ul class="nav nav-tabs nav-tabs-overflow">
                                        {if $domain}
                                            <li class="">
                                                <a href="#domain"  data-toggle="tab">

                                                    <i class="fa-solid fa-location-dot"></i> {if $type eq "server"}<span class="texts-hide-on-mobile">{$LANG.sslserverinfo}</span> {elseif ($type eq "hostingaccount" || $type eq "reselleraccount") && $serverdata}<span class="texts-hide-on-mobile">{$LANG.hostingInfo} </span> {else}<span class="texts-hide-on-mobile">{$LANG.clientareahostingdomain} </span> {/if}
                                                </a>
                                            </li>
                                        {elseif $moduleclientarea}
                                            <li class="">
                                                <a href="#manage"  data-toggle="tab"><i class="fa-solid fa-location-dot"></i> <span class="texts-hide-on-mobile"> {$LANG.manage}</span></a>
                                            </li>
                                        {/if}
                                        {if $configurableoptions}
                                            <li{if !$domain && !$moduleclientarea} class="active"{/if}>
                                                <a href="#configoptions"  data-toggle="tab"><i class="fas fa-wrench"></i> <span class="texts-hide-on-mobile"> {$LANG.orderconfigpackage}</span></a>
                                            </li>
                                        {/if}
                                        {if $customfields}
                                            <li{if !$domain && !$moduleclientarea && !$configurableoptions} class="active"{/if}>
                                                <a href="#additionalinfo"  data-toggle="tab"><i class="fas fa-info-circle"></i> <span class="texts-hide-on-mobile"> {$LANG.additionalInfo}</span></a>
                                            </li>
                                        {/if}
                                        {if $lastupdate}
                                            <li{if !$domain && !$moduleclientarea && !$configurableoptions && !$customfields} class="active"{/if}>
                                                <a href="#resourceusage"  data-toggle="tab"><i class="fas fa-info-circle"></i><span class="texts-hide-on-mobile"> {$LANG.resourceUsage}</span></a>
                                            </li>
                                        {/if}
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content product-details-tab-container">
                                {if $domain}
                                    <div class="tab-pane fade in active text-center hosting-domain-panel" id="domain">
                                        {if $type eq "server"}
                                            <div class="row">
                                                <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                    <p>{$LANG.serverhostname}</p>
                                                </div>
                                                <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                    {$domain}
                                                </div>
                                            </div>
                                            {if $dedicatedip}
                                                <div class="row">
                                                    <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                        <p>{$LANG.primaryIP}</p>
                                                    </div>
                                                    <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                        {$dedicatedip}
                                                    </div>
                                                </div>
                                            {/if}
                                            {if $assignedips}
                                                <div class="row">
                                                    <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                        <p>{$LANG.assignedIPs}</p>
                                                    </div>
                                                    <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                        {$assignedips|nl2br}
                                                    </div>
                                                </div>
                                            {/if}
                                            {if $ns1 || $ns2}
                                                <div class="row">
                                                    <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                        <p>{$LANG.domainnameservers}</p>
                                                    </div>
                                                    <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                        {$ns1}<br/>{$ns2}
                                                    </div>
                                                </div>
                                            {/if}
                                        {elseif ($type eq "hostingaccount" || $type eq "reselleraccount") && $serverdata}
                                            {if $domain}
                                                <div class="row">
                                                    <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                        <p>{$LANG.orderdomain}</p>
                                                    </div>
                                                    <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                        {$domain}&nbsp;<a href="http://{$domain}" target="_blank" class="whmc-kbtnbtn-xs">{$LANG.visitwebsite}</a>
                                                    </div>
                                                </div>
                                            {/if}
                                            {if $username}
                                                <div class="row">
                                                    <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                        <p>{$LANG.serverusername}</p>
                                                    </div>
                                                    <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                        {$username}
                                                    </div>
                                                </div>
                                            {/if}
                                            <div class="row">
                                                <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                    <p>{$LANG.servername}</p>
                                                </div>
                                                <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                    {$serverdata.hostname}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                    <p>{$LANG.domainregisternsip}</p>
                                                </div>
                                                <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                    {$serverdata.ipaddress}
                                                </div>
                                            </div>
                                            {if $serverdata.nameserver1 || $serverdata.nameserver2 || $serverdata.nameserver3 || $serverdata.nameserver4 || $serverdata.nameserver5}
                                                <div class="row">
                                                    <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0">
                                                        <p>{$LANG.domainnameservers}</p>
                                                    </div>
                                                    <div class="col-md-10 text-left hosting-information-titles left-padding-domain " style="color: #000000;">
                                                        {if $serverdata.nameserver1}{$serverdata.nameserver1} ({$serverdata.nameserver1ip})<br/>{/if}
                                                        {if $serverdata.nameserver2}{$serverdata.nameserver2} ({$serverdata.nameserver2ip})<br/>{/if}
                                                        {if $serverdata.nameserver3}{$serverdata.nameserver3} ({$serverdata.nameserver3ip})<br/>{/if}
                                                        {if $serverdata.nameserver4}{$serverdata.nameserver4} ({$serverdata.nameserver4ip})<br/>{/if}
                                                        {if $serverdata.nameserver5}{$serverdata.nameserver5} ({$serverdata.nameserver5ip})<br/>{/if}
                                                    </div>
                                                </div>
                                            {/if}
                                        {else}
                                            <p>
                                                {$domain}
                                            </p>
                                            <p>
                                                <a href="http://{$domain}" class="whmc-kbtn-2" target="_blank">{$LANG.visitwebsite}</a>
                                                {if $domainId}
                                                    <a href="clientarea.php?action=domaindetails&id={$domainId}" class="whmc-kbtn-2" target="_blank">{$LANG.managedomain}</a>
                                                {/if}
                                                <input type="button" onclick="popupWindow('whois.php?domain={$domain}','whois',650,420);return false;" value="{$LANG.whoisinfo}" class="whmc-kbtn-2"/>
                                            </p>
                                        {/if}
                                        {if $moduleclientarea}
                                            <div class="text-center module-client-area mt-5">
                                                {$moduleclientarea}
                                            </div>
                                        {/if}
                                    </div>
                                {elseif $moduleclientarea}
                                    <div class="tab-pane fade{if !$domain} in active{/if} text-center" id="manage">
                                        {if $moduleclientarea}
                                            <div class="text-center module-client-area">
                                                {$moduleclientarea}
                                            </div>
                                        {/if}
                                    </div>
                                {/if}
                                {if $configurableoptions}
                                    <div class="tab-pane fade{if !$domain && !$moduleclientarea} in active{/if} text-center" id="configoptions">
                                        {foreach from=$configurableoptions item=configoption}
                                            <div class="row hosting-domain-panel">
                                                <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0" style="padding-left: 0px;">
                                                    <strong>{$configoption.optionname}</strong>
                                                </div>
                                                <div class="col-md-10 hosting-information-titles left-padding-domain text-left" style="padding-left: 0px;">
                                                    {if $configoption.optiontype eq 3}
                                                        {if $configoption.selectedqty}
                                                            {$LANG.yes}
                                                        {else}
                                                            {$LANG.no}
                                                        {/if}
                                                    {elseif $configoption.optiontype eq 4}
                                                        {$configoption.selectedqty} x {$configoption.selectedoption}
                                                    {else}
                                                        {$configoption.selectedoption}
                                                    {/if}
                                                </div>

                                                <div class="pending-screenshot" style="background-image: url({$WEB_ROOT}/templates/mw2022/img/screenshot-test-templates.jpg)">

                                                </div>
                                            </div>
                                        {/foreach}
                                    </div>
                                {/if}
                                {if $customfields}
                                    <div class="tab-pane fade{if !$domain && !$moduleclientarea && !$configurableoptions} in active{/if} text-center" id="additionalinfo">
                                        {foreach from=$customfields item=field}
                                            <div class="row hosting-domain-panel">
                                                <div class="col-md-2 text-left hosting-information-titles left-padding-domain px-0" style="padding-left: 0px;">
                                                    <strong>{$field.name}</strong>
                                                </div>
                                                <div class="col-md-10 hosting-information-titles left-padding-domain text-left" style="padding-left: 0px;">
                                                    {$field.value}
                                                </div>
                                            </div>
                                        {/foreach}
                                    </div>
                                {/if}
                                {if $lastupdate}
                                    <div class="tab-pane fade text-center" id="resourceusage">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="col-sm-6">
                                                <h4>{$LANG.diskSpace}</h4>
                                                <input type="text" value="{$diskpercent|substr:0:-1}" class="dial-usage" data-width="100" data-height="100" data-min="0" data-readOnly="true"/>
                                                <p>{$diskusage}MB / {$disklimit}MB</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <h4>{$LANG.bandwidth}</h4>
                                                <input type="text" value="{$bwpercent|substr:0:-1}" class="dial-usage" data-width="100" data-height="100" data-min="0" data-readOnly="true"/>
                                                <p>{$bwusage}MB / {$bwlimit}MB</p>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                        </div>
                                        <p class="text-muted">{$LANG.clientarealastupdated}: {$lastupdate}</p>

                                        <script src="{$BASE_PATH_JS}/jquery.knob.js"></script>
                                        <script type="text/javascript">
                                            jQuery(function () {ldelim}
                                                jQuery(".dial-usage").knob({ldelim}'format': function (v) {ldelim} alert(v); {rdelim}{rdelim});
                                                {rdelim});
                                        </script>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    {/if}
                    <script src="{$BASE_PATH_JS}/bootstrap-tabdrop.js"></script>
                    <script type="text/javascript">
                        jQuery('.nav-tabs-overflow').tabdrop();
                    </script>
                    {/if}
                </div>

            </div>



        </div>
        <div class="tab-pane fade in" id="tabDownloads">

            <h3>{$LANG.downloadstitle}</h3>

            {include file="$template/includes/alert.tpl" type="info" msg="{lang key="clientAreaProductDownloadsAvailable"}" textcenter=true}

            <div class="row">
                {foreach from=$downloads item=download}
                    <div class="col-xs-10 col-xs-offset-1">
                        <h4>{$download.title}</h4>
                        <p>
                            {$download.description}
                        </p>
                        <p>
                            <a href="{$download.link}" class="whmc-kbtn-2"><i class="fa fa-download"></i> {$LANG.downloadname}</a>
                        </p>
                    </div>
                {/foreach}
            </div>

        </div>
        <div class="tab-pane fade in" id="tabAddons">

            <h3>{$LANG.clientareahostingaddons}</h3>

            {if $addonsavailable}
                {include file="$template/includes/alert.tpl" type="info" msg="{lang key="clientAreaProductAddonsAvailable"}" textcenter=true}
            {/if}

            <div class="row">
                {foreach from=$addons item=addon}
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default panel-accent-blue ">
                            <div class="panel-heading">
                                {$addon.name}
                                <div class="pull-right status-{$addon.rawstatus|strtolower}">{$addon.status}</div>
                            </div>
                            <div class="row panel-body">
                                <div class="col-md-6">
                                    <p>
                                        {$addon.pricing}
                                    </p>
                                    <p>
                                        {$LANG.registered}: {$addon.regdate}
                                    </p>
                                    <p>
                                        {$LANG.clientareahostingnextduedate}: {$addon.nextduedate}
                                    </p>
                                </div>
                            </div>
                            <div class="panel-footer">
                                {$addon.managementActions}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>

        </div>
        <div class="tab-pane fade in" id="tabChangepw">

            <h3>{$LANG.serverchangepassword}</h3>

            {if $modulechangepwresult}
                {if $modulechangepwresult == "success"}
                    {include file="$template/includes/alert.tpl" type="success" msg=$modulechangepasswordmessage textcenter=true}
                {elseif $modulechangepwresult == "error"}
                    {include file="$template/includes/alert.tpl" type="error" msg=$modulechangepasswordmessage|strip_tags textcenter=true}
                {/if}
            {/if}

            <form class="form-horizontal using-password-strength" method="post" action="{$smarty.server.PHP_SELF}?action=productdetails#tabChangepw" role="form">
                <input type="hidden" name="id" value="{$id}"/>
                <input type="hidden" name="modulechangepassword" value="true"/>

                <div id="newPassword1" class="form-group has-feedback">
                    <label for="inputNewPassword1" class="col-sm-5 control-label">{$LANG.newpassword}</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="inputNewPassword1" name="newpw" autocomplete="off"/>
                        <span class="form-control-feedback glyphicon"></span>
                        {include file="$template/includes/pwstrength.tpl"}
                    </div>
                </div>
                <div id="newPassword2" class="form-group has-feedback">
                    <label for="inputNewPassword2" class="col-sm-5 control-label">{$LANG.confirmnewpassword}</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="inputNewPassword2" name="confirmpw" autocomplete="off"/>
                        <span class="form-control-feedback glyphicon"></span>
                        <div id="inputNewPassword2Msg">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-6">
                        <input class="whmc-kbtn " type="submit" value="{$LANG.clientareasavechanges}"/>
                        <input class="btn" type="reset" value="{$LANG.cancel}"/>
                    </div>
                </div>

            </form>

        </div>
    </div>

</div>