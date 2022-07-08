<h1>{$LANG.cartreviewcheckout}</h1>

<div class="review-order">
    {if $cartitems == 0}
        <div class="clientareatableactive">
            <div colspan="2" class="text-center">
                <br/>
                {$LANG.cartempty}
                <br/><br/>
            </div>
        </div>
    {/if}

    <div class="hidden">
        <div class="row">
            <div class="col-xs-6 rev-lable">{$LANG.ordersubtotal}: &nbsp;</div>
            <div class="col-xs-6 rev-value">{$subtotal}</div>
        </div>
        <hr/>
    </div>
    {if $promotioncode}
        <div class="">
            <div class="row">
                <div class="col-xs-6 rev-lable">{$promotiondescription}: &nbsp;</div>
                <div class="col-xs-6 rev-value">{$discount}</div>
            </div>
            <hr/>
        </div>
    {/if}
    {if $taxrate}
        <div class="">
            <div class="row">
                <div class="col-xs-6 rev-lable">{$taxname} @ {$taxrate}%: &nbsp;</div>
                <div class="col-xs-6 rev-value">{$taxtotal}</div>
            </div>
            <hr/>
        </div>
    {/if}
    {if $taxrate2}
        <div class="">
            <div class="row">
                <div class="col-xs-6 rev-lable">{$taxname2} @ {$taxrate2}%: &nbsp;</div>
                <div class="col-xs-6 rev-value">{$taxtotal2}</div>
            </div>
            <hr/>
        </div>
    {/if}
    <div class="">
        <div class="row">
            <div class="col-xs-6 rev-lable">{$LANG.ordertotalduetoday}: &nbsp;</div>
            <div class="col-xs-6 rev-value">{$total}</div>
        </div>
        <hr/>
    </div>
    {if $totalrecurringmonthly || $totalrecurringquarterly || $totalrecurringsemiannually || $totalrecurringannually || $totalrecurringbiennially || $totalrecurringdiviennially}
        <div class="">
            <div class="row">
                <div class="col-xs-6 rev-lable">{$LANG.ordertotalrecurring}: &nbsp;</div>
                <div class="col-xs-6 rev-value">
                    {if $totalrecurringmonthly}{$totalrecurringmonthly} {$LANG.orderpaymenttermmonthly}<br/>{/if}
                    {if $totalrecurringquarterly}{$totalrecurringquarterly} {$LANG.orderpaymenttermquarterly}<br/>{/if}
                    {if $totalrecurringsemiannually}{$totalrecurringsemiannually} {$LANG.orderpaymenttermsemiannually}<br/>{/if}
                    {if $totalrecurringannually}{$totalrecurringannually} {$LANG.orderpaymenttermannually}<br/>{/if}
                    {if $totalrecurringbiennially}{$totalrecurringbiennially} {$LANG.orderpaymenttermbiennially}<br/>{/if}
                    {if $totalrecurringdiviennially}{$totalrecurringdiviennially} {$LANG.orderpaymenttermdiviennially}<br/>{/if}
                </div>
            </div>
            <hr/>
        </div>
    {/if}

    {if $cartitems!=0 &&  $rawtotal != 0}
        <br/>
        <form method="post" action="{$smarty.server.PHP_SELF}?a=checkout" id="frmCheckoutPromo">
            <input type="hidden" name="submit" value="true"/>
            <input type="hidden" name="custtype" id="custtype" value="{$custtype}"/>

            <div class="signupfields padded">
                <h1>{$LANG.orderpromotioncode}</h1>
                {if $promotioncode}
                    <strong>{$promotioncode}</strong>
                    - {$promotiondescription} &nbsp; &nbsp;
                    <a href="{$smarty.server.PHP_SELF}?a=removepromo" class="cbtn cbtn-small">{$LANG.orderdontusepromo}</a>
                {else}
                    <div class="row">
                        <div class="col-xs-10 col-sm-10">
                            <input type="text" name="promocode" id="inputPromoCode" class="form-control input-sm" placeholder="{lang key="orderPromoCodePlaceholder"}">
                            <input type="hidden" name="validatepromo" id="validatepromo" value="0"/>
                        </div>
                        <div class="col-xs-2 col-sm-2">
                            <button type="submit" id="validatePromoCode" class="cbtn cbtn-small">
                                {$LANG.orderpromovalidatebutton}
                            </button>
                        </div>
                    </div>
                {/if}
            </div>
        </form>
        <br/>
    {/if}

</div>