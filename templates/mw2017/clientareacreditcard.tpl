<div class="mw-whm clientcreditcard">

    <div class="header-lined text-center">
        <h1>Manage Credit / Debit Card</h1>
        <br />
    </div>

    {if $remoteupdatecode}
        <div align="center">
            {$remoteupdatecode}
        </div>
    {else}
        <div class="col-sm-6 col-sm-offset-3">
            <div class="credit-card">
                <div class="card-icon pull-right">
                    <b class="fa fa-2x
            {if $cardtype eq "American Express"}
                fa-cc-amex logo-amex
            {elseif $cardtype eq "Visa"}
                fa-cc-visa logo-visa
            {elseif $cardtype eq "MasterCard"}
                fa-cc-mastercard logo-mastercard
            {elseif $cardtype eq "Discover"}
                fa-cc-discover logo-discover
            {else}
                fa-credit-card
            {/if}">&nbsp;</b>
                </div>
                <div class="card-type">
                    {if $cardtype neq "American Express" && $cardtype neq "Visa" && $cardtype neq "MasterCard" && $cardtype neq "Discover"}
                        {$cardtype}
                    {/if}
                </div>
                <div class="card-number">
                    {if $cardlastfour}xxxx xxxx xxxx {$cardlastfour}{else}<span style="padding: 5px; display: block;">{$LANG.creditcardnonestored}</span>{/if}
                </div>
                <div class="card-start">
                    {if $cardstart}Start: {$cardstart}{/if}
                </div>
                <div class="card-expiry">
                    {if $cardexp}Expires: {$cardexp}{/if}
                </div>
                <div class="end"></div>
            </div>
            {if $allowcustomerdelete && $cardtype}
                <br/>
                <form method="post" action="clientarea.php?action=creditcard">
                    <input type="hidden" name="remove" value="1"/>
                    <p class="text-center">
                        <button type="submit" class="btn btn-danger">
                            {$LANG.creditcarddelete}
                        </button>
                    </p>
                </form>
                <br/>
            {/if}
            <h3>{$LANG.creditcardenternewcard}</h3>
            {if $successful}
                {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=true}
            {/if}

            {if $errormessage}
                {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
            {/if}
        </div>
        <form id="frmNewCc" class="form-horizontal" role="form" method="post" action="{$smarty.server.PHP_SELF}?action=creditcard">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="alert alert-danger text-center gateway-errors hidden"></div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <select name="cctype" id="inputCardType" class="selectpicker" title="{$LANG.creditcardcardtype}">
                        {foreach from=$acceptedcctypes item=fieldcardtype}
                            <option {if $fieldcardtype eq $cardtype}selected{/if}>{$fieldcardtype}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <input type="tel" name="ccnumber" id="inputCardNumber" autocomplete="off" class="material-field" placeholder="{$LANG.creditcardcardnumber}"/>
                </div>
            </div>
            {if $showccissuestart}
                <div class="form-group">
                    <label for="inputCardStart" class="col-sm-4 control-label">{$LANG.creditcardcardstart}</label>
                    <div class="col-sm-6">
                        <select name="ccstartmonth" id="inputCardStart" class="form-control select-inline">
                            {foreach from=$months item=month}
                                <option{if $ccstartmonth eq $month} selected{/if}>{$month}</option>
                            {/foreach}
                        </select>
                        <select name="ccstartyear" class="form-control select-inline">
                            {foreach from=$startyears item=year}
                                <option{if $ccstartyear eq $year} selected{/if}>{$year}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            {/if}
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="row">
                        <div class="col-xs-6">
                            <select name="ccexpirymonth" id="inputCardExpiry" class="selectpicker" title="{$LANG.creditcardcardexpires}">
                                {foreach from=$months item=month}
                                    <option{if $ccstartmonth eq $month} selected{/if}>{$month}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <select name="ccexpiryyear" class="selectpicker" title="Expiry Year">
                                {foreach from=$expiryyears item=year}
                                    <option{if $ccstartyear eq $year} selected{/if}>{$year}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            {if $showccissuestart}
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3">
                        <input type="tel" class="material-field" id="inputCardIssue" name="ccissuenum" autocomplete="off" placeholder="{$LANG.creditcardcardissuenum}"/>
                    </div>
                </div>
            {/if}
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <div></div>
                    <input type="tel" class="material-field" id="inputCardCVV" name="cardcvv" autocomplete="off" placeholder="{$LANG.creditcardcvvnumber}"/>
                    <button type="button" class="btn btn-link" data-toggle="popover" data-content="<img src='{$BASE_PATH_IMG}/ccv.gif' width='210' />">
                        {$LANG.creditcardcvvwhere}
                    </button>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <input class="cbtn" id="btnSubmitNewCard" type="submit" name="submit" value="{$LANG.clientareasavechanges}"/> &nbsp;
                    <input class="cbtn cbtn-alt" type="reset" value="{$LANG.cancel}"/>
                </div>
            </div>
        </form>
    {/if}
</div>