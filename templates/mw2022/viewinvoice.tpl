{include file="{$template}/header.tpl"}

    <div class="container-fluid invoice-container">

        <div class="row">
            <div class="d-flex">
                <div class="col-sm-8 invoice-container-printer printer-box">
                    {if $invalidInvoiceIdRequested}

                        {include file="$template/includes/panel.tpl" type="danger" headerTitle=$LANG.error bodyContent=$LANG.invoiceserror bodyTextCenter=true}

                    {else}

                        <div class="row">
                            <div class="col-sm-7" style="display: flex; align-items: center;">


                                    <div class="col-md-12">
                                        <h1>{$pagetitle}</h1>
                                    </div>

                                    <div class="col-md-12 invoice-status" style="margin-top: 15px;">
                                        {if $status eq "Draft"}
                                            <span class="draft">{$LANG.invoicesdraft}</span>
                                        {elseif $status eq "Unpaid"}
                                            <span class="unpaid badge badge-danger">{$LANG.invoicesunpaid}</span>
                                        {elseif $status eq "Paid"}
                                            <span class="paid badge badge-success">{$LANG.invoicespaid}</span>
                                        {elseif $status eq "Refunded badge badge-warning"}
                                            <span class="refunded">{$LANG.invoicesrefunded}</span>
                                        {elseif $status eq "Cancelled badge badge-danger"}
                                            <span class="cancelled">{$LANG.invoicescancelled}</span>
                                        {elseif $status eq "Collections"}
                                            <span class="collections">{$LANG.invoicescollections}</span>
                                        {elseif $status eq "Payment Pending"}
                                            <span class="paid">{$LANG.invoicesPaymentPending}</span>
                                        {/if}
                                    </div>


                            </div>


                            <div class="col-sm-5" style="padding-left: 0; margin-top: 20px; font-size: 15px;">

                                {if $status eq "Unpaid" || $status eq "Draft"}
                                    <div class="small-text" style="margin-bottom: 20px;">
                                       <p class="col-md-6" > {$LANG.invoicesdatedue}:</p>
                                        <p class="col-md-6" style="color: #ACB0B9;">{$datedue}</p>
                                    </div>

                                     <div class="small-text">
                                         <p  class="col-md-6">  {$LANG.invoicesdatecreated}: </p>
                                         <p class="col-md-6" style="color: #ACB0B9;">
                                            {$date}
                                        </p>
                                     </div>
                                {/if}

                            </div>
                        </div>

                        {if $paymentSuccess}
                            {include file="$template/includes/panel.tpl" type="success" headerTitle=$LANG.success bodyContent=$LANG.invoicepaymentsuccessconfirmation bodyTextCenter=true}
                        {elseif $pendingReview}
                            {include file="$template/includes/panel.tpl" type="info" headerTitle=$LANG.success bodyContent=$LANG.invoicepaymentpendingreview bodyTextCenter=true}
                        {elseif $paymentFailed}
                            {include file="$template/includes/panel.tpl" type="danger" headerTitle=$LANG.error bodyContent=$LANG.invoicepaymentfailedconfirmation bodyTextCenter=true}
                        {elseif $offlineReview}
                            {include file="$template/includes/panel.tpl" type="info" headerTitle=$LANG.success bodyContent=$LANG.invoiceofflinepaid bodyTextCenter=true}
                        {/if}

                        <div style="margin-top: 40px; font-size: 15px;">


                            <div class="col-sm-7 pull-sm-right text-right-sm">
                               <p><strong>{$LANG.invoicespayto}:</strong></p>

                                <address class="small-text">
                                    {$payto}
                                </address>
                            </div>
                            <div class="col-sm-5">
                                <p>
                                    <strong>{$LANG.invoicesinvoicedto}:</strong>
                                </p>
                                <address class="small-text">
                                    {if $clientsdetails.companyname}{$clientsdetails.companyname}<br />{/if}
                                    {$clientsdetails.firstname} {$clientsdetails.lastname}<br />
                                    {$clientsdetails.address1}, {$clientsdetails.address2}<br />
                                    {$clientsdetails.city}, {$clientsdetails.state}, {$clientsdetails.postcode}<br />
                                    {$clientsdetails.country}
                                    {if $customfields}
                                        <br /><br />
                                        {foreach from=$customfields item=customfield}
                                            {$customfield.fieldname}: {$customfield.value}<br />
                                        {/foreach}
                                    {/if}
                                </address>
                            </div>
                        </div>



                        <br />

                        {if $manualapplycredit}
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="font-size: 15px;"><strong>{$LANG.invoiceaddcreditapply}</strong></h3>
                                </div>
                                <div class="panel-body">
                                    <form method="post" action="{$smarty.server.PHP_SELF}?id={$invoiceid}">
                                        <input type="hidden" name="applycredit" value="true" />
                                        {$LANG.invoiceaddcreditdesc1} <strong>{$totalcredit}</strong>. {$LANG.invoiceaddcreditdesc2}. {$LANG.invoiceaddcreditamount}:
                                        <div class="row">
                                            <div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4">
                                                <div class="input-group">
                                                    <input type="text" name="creditamount" value="{$creditamount}" class="form-control" />
                                                    <span class="input-group-btn">
                                            <input type="submit" value="{$LANG.invoiceaddcreditapply}" class="btn btn-success" />
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        {/if}

                        {if $notes}
                            {include file="$template/includes/panel.tpl" type="info" headerTitle=$LANG.invoicesnotes bodyContent=$notes}
                        {/if}

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="font-size: 15px;"><strong>{$LANG.invoicelineitems}</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div style=" border: none;">
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <td style="font-size: 12px; font-weight: 300; color: gray;">{$LANG.invoicesdescription}</td>
                                            <td style="font-size: 12px; font-weight: 300; color: gray;" width="20%" class="text-center">{$LANG.invoicesamount}</td>
                                        </tr>
                                        </thead>
                                        <tbody style="font-size: 14px; font-weight: 300;">
                                        {foreach from=$invoiceitems item=item}
                                            <tr>
                                                <td>{$item.description}{if $item.taxed eq "true"} *{/if}</td>
                                                <td class="text-center">{$item.amount}</td>
                                            </tr>
                                        {/foreach}
                                        <tr>
                                            <td class="total-row text-right">{$LANG.invoicessubtotal}</td>
                                            <td class="total-row text-center">{$subtotal}</td>
                                        </tr>
                                        {if $taxrate}
                                            <tr>
                                                <td class="total-row text-right" >{$taxrate}% {$taxname}</td>
                                                <td class="total-row text-center">{$tax}</td>
                                            </tr>
                                        {/if}
                                        {if $taxrate2}
                                            <tr>
                                                <td class="total-row text-right">{$taxrate2}% {$taxname2}</td>
                                                <td class="total-row text-center">{$tax2}</td>
                                            </tr>
                                        {/if}
                                        <tr style="font-size: 13px; color: gray;">
                                            <td class="total-row text-right" >{$LANG.invoicescredit}</td>
                                            <td class="total-row text-center">{$credit}</td>
                                        </tr>
                                        <tr style="background-color: #f8f8f8; font-size: 14px;">
                                            <td class="total-row text-right"><strong>{$LANG.invoicestotal}</strong></td>
                                            <td class="total-row text-center"><strong>{$total}</strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {if $taxrate}
                            <p>* {$LANG.invoicestaxindicator}</p>
                        {/if}

                        <div class="transactions-container small-text" style="font-size: 14px; margin-top: 40px;">
                            <div style=" border: none;">

                               <h5 style="font-size: 16px;">{$LANG.MW_transactions}:</h5>
                                <table class="table table-condensed">
                                    <thead style="margin: 20px;">
                                    <tr style="font-size: 14px; font-weight: 300; color: gray;">
                                        <td style="padding: 20px 0;">{$LANG.invoicestransdate}</td>
                                        <td style="padding: 20px 0;">{$LANG.invoicestransgateway}</td>
                                        <td style="padding: 20px 0;">{$LANG.invoicestransid}</td>
                                        <td style="padding: 20px 0;">{$LANG.invoicestransamount}</td>
                                    </tr>

                                    </thead>

                                    <tbody>
                                    {foreach from=$transactions item=transaction}
                                        <tr>
                                            <td class="text-center"  style="padding: 20px 0;">{$transaction.date}</td>
                                            <td class="text-center"  style="padding: 20px 0;">{$transaction.gateway}</td>
                                            <td class="text-center"  style="padding: 20px 0;">{$transaction.transid}</td>
                                            <td class="text-center"  style="padding: 20px 0;">{$transaction.amount}</td>
                                        </tr>
                                        {foreachelse}
                                        <tr>
                                            <td style="padding: 20px 0;" colspan="4">{$LANG.invoicestransnonefound}</td>
                                        </tr>
                                    {/foreach}
                                    <tr style="background-color: #f8f8f8; font-size: 14px;">
                                        <td class="text-right" style="padding: 20px 0;" colspan="3"><strong>{$LANG.invoicesbalance}</strong></td>
                                        <td class="text-center" style="padding: 20px 0;"><strong>{$balance}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {/if}

                </div>
                <div class="col-sm-3 invoice-container-printer paypal-box">

                   <div class="top-printer-box">
                       <p>Total Due</p>
                       <h3>{$balance}</h3>
                   </div>
                    <hr>

                    {if $status eq "Unpaid" && $allowchangegateway}
                        <label>{$LANG.orderpaymentmethod}:</label>
                        <form method="post" action="{$smarty.server.PHP_SELF}?id={$invoiceid}">
                            <div class="form-group">
                                {$gatewaydropdown}
                            </div>
                        </form>
                    {else}
                        {$paymentmethod}{if $paymethoddisplayname} ({$paymethoddisplayname}){/if}
                    {/if}
                    {if $status eq "Unpaid" || $status eq "Draft"}
                        <span class="small-text"></span>
                        <div class="payment-form payment-btn-container" data-btntext="{$LANG.makepayment}" >
                            {$paymentbutton}
                        </div>
                    {/if}
                </div>

                <div class="col-sm-3 panel-downloads" >

                    <div class="pull-right btn-group btn-group-sm hidden-print">
                        <h4>Actions</h4>
                        <a href="javascript:window.print()" class="whmc-kbtn-2"><i class="fa fa-print"></i> {$LANG.print}</a>
                        <a href="dl.php?type=i&amp;id={$invoiceid}" class="whmc-kbtn-2"><i class="fa fa-download"></i> {$LANG.invoicesdownload}</a>
                    </div>

                </div>
            </div>
        </div>
    </div>


{*    <p class="text-center hidden-print"><a href="clientarea.php">{$LANG.invoicesbacktoclientarea}</a></a></p>*}

{include file="{$template}/footer.tpl"}
