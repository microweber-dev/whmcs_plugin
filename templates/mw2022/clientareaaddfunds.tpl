<div class="panel panel-default mt-5 pt-5 mw-whm affiliates">

    <div class="header-lined text-left">
        <h1>Add Funds</h1><br/>
    </div>

    {if $addfundsdisabled}
        {include file="$template/includes/alert.tpl" type="error" msg=$LANG.clientareaaddfundsdisabled textcenter=true}
    {elseif $notallowed}
        {include file="$template/includes/alert.tpl" type="error" msg=$LANG.clientareaaddfundsnotallowed textcenter=true}
    {elseif $errormessage}
        {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage textcenter=true}
    {/if}

    {if !$addfundsdisabled}
        <div class="row">

            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td class="textright"><strong>{$LANG.addfundsminimum}</strong></td>
                            <td>{$minimumamount}</td>
                        </tr>
                        <tr>
                            <td class="textright"><strong>{$LANG.addfundsmaximum}</strong></td>
                            <td>{$maximumamount}</td>
                        </tr>
                        <tr>
                            <td class="textright"><strong>{$LANG.addfundsmaximumbalance}</strong></td>
                            <td>{$maximumbalance}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="{$smarty.server.PHP_SELF}?action=addfunds">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="amount" id="amount"
                                           value="{$amount}" class="material-field" required placeholder="{$LANG.addfundsamount}"/>
                                </div>
                                <div class="form-group">
                                    <select name="paymentmethod" id="paymentmethod" class="selectpicker" title="{$LANG.orderpaymentmethod}">
                                        {foreach from=$gateways item=gateway}
                                            <option value="{$gateway.sysname}">{$gateway.name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group text-center">
                                    <input type="submit" value="{$LANG.addfunds}" class="cbtn"/>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="panel-footer">
                        {$LANG.addfundsnonrefundable}
                    </div>
                </div>
            </div>

        </div>
    {/if}

</div>