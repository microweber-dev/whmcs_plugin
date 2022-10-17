<div id="ccinputform" class="signupfields {if $selectedgatewaytype neq "CC"}hidden{/if}">
    <table width="100%" cellspacing="0" cellpadding="0" class="configtable textleft">
        {if $clientsdetails.cclastfour}
            <tr>
                <td class="fieldarea">
                    <label class="radio-inline">
                        <input type="radio" name="ccinfo" value="useexisting" id="useexisting"
                               onclick="useExistingCC()" {if $clientsdetails.cclastfour}checked{else}disabled{/if} />
                        {$LANG.creditcarduseexisting}
                        {if $clientsdetails.cclastfour}
                            ({$clientsdetails.cclastfour})
                        {/if}
                    </label><br/>
                    <label class="radio-inline">
                        <input type="radio" name="ccinfo" value="new" id="new" onclick="enterNewCC()" {if !$clientsdetails.cclastfour || $ccinfo eq "new"}checked{/if} />
                        {$LANG.creditcardenternewcard}
                    </label>
                </td>
            </tr>
        {else}
            <input type="hidden" name="ccinfo" value="new"/>
        {/if}

        <tr>
            <td><h2>Card details</h2></td>
        </tr>

        <tr class="newccinfo"{if $clientsdetails.cclastfour && $ccinfo neq "new"} style="display:none;"{/if}>
            <td class="fieldarea">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <select class="selectpicker" name="cctype" id="cctype" title="{$LANG.creditcardcardtype}">
                            {foreach key=num item=cardtype from=$acceptedcctypes}
                                <option{if $cctype eq $cardtype} selected{/if}>{$cardtype}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="newccinfo"{if $clientsdetails.cclastfour && $ccinfo neq "new"} style="display:none;"{/if}>
            <td class="fieldarea">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="subscription-field">
                            <input class="material-field subscription" type="text" name="ccnumber" size="30" value="{$ccnumber}" autocomplete="off"
                                   placeholder="{$LANG.creditcardcardnumber}"/>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="newccinfo"{if $clientsdetails.cclastfour && $ccinfo neq "new"} style="display:none;"{/if}>
            <td class="fieldarea">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <select class="selectpicker" name="ccexpirymonth" id="ccexpirymonth" title="Select month">
                            {foreach from=$months item=month}
                                <option{if $ccexpirymonth eq $month} selected{/if}>{$month}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <select class="selectpicker" name="ccexpiryyear" title="Select year">
                            {foreach from=$expiryyears item=year}
                                <option{if $ccexpiryyear eq $year} selected{/if}>{$year}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        {if $showccissuestart}
            <tr class="newccinfo"{if $clientsdetails.cclastfour && $ccinfo neq "new"} style="display:none;"{/if}>
                <td class="fieldarea">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <select class="selectpicker" name="ccstartmonth" id="ccstartmonth" title="Select month">
                                {foreach from=$months item=month}
                                    <option{if $ccstartmonth eq $month} selected{/if}>{$month}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <select class="selectpicker" name="ccstartyear" title="Select year">
                                {foreach from=$startyears item=year}
                                    <option{if $ccstartyear eq $year} selected{/if}>{$year}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="newccinfo"{if $clientsdetails.cclastfour && $ccinfo neq "new"} style="display:none;"{/if}>
                <td class="fieldarea">
                    <input type="text" name="ccissuenum" value="{$ccissuenum}" placeholder="{$LANG.creditcardcardissuenum}" size="5" maxlength="3"/>
                </td>
            </tr>
        {/if}
        <tr>
            <td class="fieldarea">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="subscription-field">
                            <a href="#" onclick="window.open('{$BASE_PATH_IMG}/ccv.gif','','width=280,height=200,scrollbars=no,top=100,left=100');return false" class="field-helper"
                               title="{$LANG.creditcardcvvwhere}"><span>?</span></a>
                            <input class="material-field subscription" type="text" name="cccvv" id="cccvv" value="{$cccvv}" size="5" autocomplete="off"
                                   placeholder="{$LANG.creditcardcvvnumber}"/>
                        </div>
                    </div>

                    {if $shownostore}
                        <div class="col-xs-12 col-sm-6">
                            <label class="checkbox-inline" for="nostore">
                                <input type="checkbox" name="nostore" id="nostore"/>
                                {$LANG.creditcardnostore}
                            </label>
                        </div>
                    {/if}
                </div>
            </td>
        </tr>
    </table>
</div>