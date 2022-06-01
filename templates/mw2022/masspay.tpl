<div class="mw-whm">
    <form method="post" action="clientarea.php?action=masspay" class="form-horizontal">
        <input type="hidden" name="geninvoice" value="true"/>
        <div class="header-lined text-center">
            <h1>Mass Payment</h1><br/>
        </div>

        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{$LANG.invoicesdescription}</th>
                        <th>{$LANG.invoicesamount}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$invoiceitems key=invid item=invoiceitem}
                        <tr>
                            <td colspan="2" class="bg-info">
                                <strong>{$LANG.invoicenumber} {$invid}</strong>
                                <input type="hidden" name="invoiceids[]" value="{$invid}"/>
                            </td>
                        </tr>
                        {foreach from=$invoiceitem item=item}
                            <tr class="masspay-invoice-detail">
                                <td>{$item.description}</td>
                                <td>{$item.amount}</td>
                            </tr>
                        {/foreach}
                        {foreachelse}
                        <tr>
                            <td colspan="6" align="center">{$LANG.norecordsfound}</td>
                        </tr>
                    {/foreach}
                    <tr class="masspay-total">
                        <td class="text-right">{$LANG.invoicessubtotal}:</td>
                        <td>{$subtotal}</td>
                    </tr>
                    {if $tax}
                        <tr class="masspay-total">
                            <td class="text-right">{$taxrate1}% {$taxname1}:</td>
                            <td>{$tax}</td>
                        </tr>
                    {/if}
                    {if $tax2}
                        <tr class="masspay-total">
                            <td class="text-right">{$taxrate2}% {$taxname2}:</td>
                            <td>{$tax2}</td>
                        </tr>
                    {/if}
                    {if $credit}
                        <tr class="masspay-total">
                            <td class="text-right">{$LANG.invoicescredit}:</td>
                            <td>{$credit}</td>
                        </tr>
                    {/if}
                    {if $partialpayments}
                        <tr class="masspay-total">
                            <td class="text-right">{$LANG.invoicespartialpayments}:</td>
                            <td>{$partialpayments}</td>
                        </tr>
                    {/if}
                    <tr class="masspay-total">
                        <td class="text-right">{$LANG.invoicestotaldue}:</td>
                        <td>{$total}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mw-whm">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{$LANG.masspaymentselectgateway}</h3>
                    </div>
                    <div class="panel-body">
                        <fieldset>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="paymentmethod" id="paymentmethod" class="selectpicker" title="{$LANG.orderpaymentmethod}">
                                        {foreach from=$gateways item=gateway}
                                            <option value="{$gateway.sysname}">{$gateway.name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="form-group text-center">
                                    <input type="submit" value="{$LANG.masspaymakepayment}" class="cbtn m-a"/>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>