<div class="panel-default panel mt-5 pt-5 mw-whm affiliates">

    <div class="header-lined">
        <h1 style="margin: 30px 0; font-size: 36px; font-weight: 700;">Upgrade Hosting</h1>
        <br/>
    </div>

    <div class="panel panel-default text-center">

        {if $overdueinvoice}
            {include file="$template/includes/alert.tpl" type="warning" msg=$LANG.upgradeerroroverdueinvoice}
        {elseif $existingupgradeinvoice}
            {include file="$template/includes/alert.tpl" type="warning" msg=$LANG.upgradeexistingupgradeinvoice}
        {elseif $upgradenotavailable}
            {include file="$template/includes/alert.tpl" type="warning" msg=$LANG.upgradeNotPossible textcenter=true}
        {/if}
    </div>


    {if $overdueinvoice}
        <p class="text-center">

            <a href="clientarea.php?action=productdetails&id={$id}" class="whmc-kbtn-2">{$LANG.clientareabacklink}</a>
            <a href="clientarea.php?action=invoices" class="whmc-kbtn">Pay Invoice</a>
        </p>
    {elseif $existingupgradeinvoice}
        <p class="text-center">
            <a href="clientarea.php?action=productdetails&id={$id}" class="whmc-kbtn-2">{$LANG.clientareabacklink}</a>
            <a href="submitticket.php" class="whmc-kbtn">{$LANG.submitticketdescription}</a>
        </p>
    {elseif $upgradenotavailable}
        <p class="text-center">
            <a href="clientarea.php?action=productdetails&id={$id}" class="whmc-kbtn-2">{$LANG.clientareabacklink}</a>
            <a href="submitticket.php" class="whmc-kbtn">{$LANG.submitticketdescription}</a>
        </p>
    {else}

        {if $type eq "package"}
            <p>{$LANG.upgradechoosepackage}</p>
            <p>{$LANG.upgradecurrentconfig}:<br/><strong>{$groupname} - {$productname}</strong>{if $domain} ({$domain}){/if}</p>
            <p>{$LANG.upgradenewconfig}:</p>
            <hr/>
            <div class="row pricing-list-2 text-center py-5"  style="margin-top: 30px;">
                {foreach key=num item=upgradepackage from=$upgradepackages}
                    <div class="col-lg-6 col-xl-4 plan" >
                        <h1 class="col-md-12" style="font-weight: bold; font-size: 36px; color: #2b2b2b; margin-top: 50px;">
                            {$upgradepackage.groupname} - {$upgradepackage.name}
                        </h1>
                        <br/>
                        {$upgradepackage.description}
                        <form method="post" action="{$smarty.server.PHP_SELF}">
                            <input type="hidden" name="step" value="2">
                            <input type="hidden" name="type" value="{$type}">
                            <input type="hidden" name="id" value="{$id}">
                            <input type="hidden" name="pid" value="{$upgradepackage.pid}">
                            <div class="form-group">
                                {if $upgradepackage.pricing.type eq "free"}
                                    {$LANG.orderfree}
                                    <br/>
                                    <input type="hidden" name="billingcycle" value="free">
                                {elseif $upgradepackage.pricing.type eq "onetime"}
                                    {$upgradepackage.pricing.onetime} {$LANG.orderpaymenttermonetime}
                                    <input type="hidden" name="billingcycle" value="onetime">
                                {elseif $upgradepackage.pricing.type eq "recurring"}
                                    <select name="billingcycle" class="form-control text-center" style="width: 50%; margin: 30px auto;">
                                        {if $upgradepackage.pricing.monthly}
                                            <option value="monthly">{$upgradepackage.pricing.monthly}</option>{/if}
                                        {if $upgradepackage.pricing.quarterly}
                                            <option value="quarterly">{$upgradepackage.pricing.quarterly}</option>{/if}
                                        {if $upgradepackage.pricing.semiannually}
                                            <option value="semiannually">{$upgradepackage.pricing.semiannually}</option>{/if}
                                        {if $upgradepackage.pricing.annually}
                                            <option value="annually">{$upgradepackage.pricing.annually}</option>{/if}
                                        {if $upgradepackage.pricing.biennially}
                                            <option value="biennially">{$upgradepackage.pricing.biennially}</option>{/if}
                                        {if $upgradepackage.pricing.triennially}
                                            <option value="triennially">{$upgradepackage.pricing.triennially}</option>{/if}
                                    </select>
                                {/if}
                            </div>
                            <input type="submit" value="{$LANG.upgradedowngradechooseproduct}" class="whmc-kbtn" style="margin-bottom: 30px; "/>
                        </form>
                    </div>
                {/foreach}
            </div>
        {elseif $type eq "configoptions"}
            <p>{$LANG.upgradechooseconfigoptions}</p>
            {if $errormessage}
                {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
            {/if}
            <form method="post" action="{$smarty.server.PHP_SELF}">
                <input type="hidden" name="step" value="2"/>
                <input type="hidden" name="type" value="{$type}"/>
                <input type="hidden" name="id" value="{$id}"/>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>{$LANG.upgradecurrentconfig}</th>
                        <th></th>
                        <th>{$LANG.upgradenewconfig}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach key=num item=configoption from=$configoptions}
                        <tr>
                            <td>{$configoption.optionname}</td>
                            <td>
                                {if $configoption.optiontype eq 1 || $configoption.optiontype eq 2}
                                    {$configoption.selectedname}
                                {elseif $configoption.optiontype eq 3}
                                    {if $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}
                                {elseif $configoption.optiontype eq 4}
                                    {$configoption.selectedqty} x {$configoption.options.0.name}
                                {/if}
                            </td>
                            <td>=></td>
                            <td>
                                {if $configoption.optiontype eq 1 || $configoption.optiontype eq 2}
                                    <select name="configoption[{$configoption.id}]">
                                        {foreach key=num item=option from=$configoption.options}
                                            {if $option.selected}
                                                <option value="{$option.id}"
                                                        selected>{$LANG.upgradenochange}</option>{else}<option value="{$option.id}">{$option.nameonly} {$option.price}{/if}</option>
                                        {/foreach}
                                    </select>
                                {elseif $configoption.optiontype eq 3}
                                    <input type="checkbox" name="configoption[{$configoption.id}]" value="1"{if $configoption.selectedqty} checked{/if}>
                                    {$configoption.options.0.name}
                                {elseif $configoption.optiontype eq 4}
                                    <input type="text" name="configoption[{$configoption.id}]" value="{$configoption.selectedqty}" size="5">
                                    x {$configoption.options.0.name}
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>

                <p class="text-center">
                    <input type="submit" value="{$LANG.ordercontinuebutton}" class="whmc-kbtn "/>
                </p>

            </form>
        {/if}
    {/if}
</div>