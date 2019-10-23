{if $cartitems!=0}

<form method="post" action="{$smarty.server.PHP_SELF}?a=checkout" id="frmCheckout">
    <input type="hidden" name="submit" value="true" />
    <input type="hidden" name="custtype" id="custtype" value="{$custtype}" />


    <div class="signupfields padded">
        <h2>{$LANG.orderpromotioncode}</h2>
        {if $promotioncode}
            {$promotioncode} - {$promotiondescription}<br />
            <a href="{$smarty.server.PHP_SELF}?a=removepromo">{$LANG.orderdontusepromo}</a>
        {else}
            <div class="col-xs-10 col-xs-offset-1">
                <div class="input-group">
                    <input type="text" name="promocode" id="inputPromoCode" class="form-control" placeholder="{lang key="orderPromoCodePlaceholder"}">
                    <span class="input-group-btn">
                                        <input type="hidden" name="validatepromo" id="validatepromo" value="0" />
                                        <button type="button" id="validatePromoCode" class="btn btn-warning">
                                            {$LANG.orderpromovalidatebutton}
                                        </button>
                                    </span>
                </div>
            </div>
            <div class="clearfix"></div>
        {/if}
    </div>
</form>



{/if}