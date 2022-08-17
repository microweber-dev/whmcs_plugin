<div class="mw-whm cart-products">
    <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/main.js"></script>

    <div id="order-modern">
        <div class="title-bar">
            <div class="row" >
                <div class="col-md-12 ">
                    <h1 style="font-size: 48px; font-weight: 700; text-align: center; margin-bottom: 80px; margin-top: 80px;">{$groupname}</h1>
                </div>
                <div class="col-md-4">
{*                    {include file="templates/orderforms/{$carttpl}/category-chooser.tpl"}*}
                </div>
            </div>
        </div>

        {if !$loggedin && $currencies}
            <div class="currencychooser">
                <div class="btn-group" role="group">
                    {foreach from=$currencies item=curr}
                        <a href="cart.php?gid={$gid}&currency={$curr.id}" class="btn btn-default{if $currency.id eq $curr.id} active{/if}">
                            <img src="{$BASE_PATH_IMG}/flags/{if $curr.code eq "AUD"}au{elseif $curr.code eq "CAD"}ca{elseif $curr.code eq "EUR"}eu{elseif $curr.code eq "GBP"}gb{elseif $curr.code eq "INR"}in{elseif $curr.code eq "JPY"}jp{elseif $curr.code eq "USD"}us{elseif $curr.code eq "ZAR"}za{else}na{/if}.png"
                                 border="0" alt=""/>
                            {$curr.code}
                        </a>
                    {/foreach}
                </div>
            </div>
        {/if}

        {*here is a first plan*}
        {foreach from=$products key=num item=product}
            {if $num == 0}

                <div class="col-xs-12 product-plans-free-wrapper">
                    <div class="product-plans-free col-xs-6">
                        <div id="product{$num}" style="display: flex; align-items: center; justify-content: center;">
                            <div class="col-xs-2" style=" border-right: 1px solid #1279fa;">
                                <h1 class="product-plans-free-h1">{$product.name}</h1>
                                {if $product.qty}
                                    <span class="qty">
                            ({$product.qty} {$LANG.orderavailable})
                        </span>
                                {/if}
                            </div>


                            <div class="col-xs-5 description desc-holder" style="margin-top: 20px;">
                                {$product.description|unescape}
                            </div>

                            <div class="col-xs-5">
                                <a href="cart.php?a=add&{if $product.bid}bid={$product.bid}{else}pid={$product.pid}{/if}" class="whmc-kbtn"> Start with Free</a>
                            </div>

                        </div>
                    </div>
                </div>

                {break}
            {/if}
        {/foreach}

        <div class="row pricing-list-2">


            {foreach from=$products key=num item=product}

            {if $num == 0}
                {* skip first plan *}
                {continue}
            {/if}

            <div class="col-md-6 col-lg-4 ">
                {*<div id="product{$num}" class="panel" onclick="window.location='cart.php?a=add&{if $product.bid}bid={$product.bid}{else}pid={$product.pid}{/if}'">*}
                <div id="product{$num}" class="panel panel-title plan">
                    <div class="row " style="text-align: center;">

                        <h1 style="margin-top:50px; margin-bottom:10px; font-size: 24px; font-weight: 300; color: #2b2b2b;">{$product.name}</h1>
                            {if $product.qty}
                                <span class="qty">
                                ({$product.qty} {$LANG.orderavailable})
                            </span>
                            {/if}


                            {if $product.bid}
                                {$LANG.bundledeal}
                                /
                                {if $product.displayprice}
                                    <p style="font-weight: bold; font-size: 36px; color: #2b2b2b;">{$product.displayprice}</p>
                                {/if}
                            {else}
                                <p style="font-weight: bold; font-size: 36px; color: #2b2b2b;">{$product.pricing.minprice.price}</p>
                                <span class="price-per-what">
                                {if $product.pricing.minprice.cycle eq "monthly"}
                                    /
                                    {$LANG.orderpaymenttermmonthly}
                                {elseif $product.pricing.minprice.cycle eq "quarterly"}
                                    /
                                    {$LANG.orderpaymenttermquarterly}
                                {elseif $product.pricing.minprice.cycle eq "semiannually"}
                                    /
                                    {$LANG.orderpaymenttermsemiannually}
                                {elseif $product.pricing.minprice.cycle eq "annually"}
                                    /
                                    {$LANG.orderpaymenttermannually}
                                {elseif $product.pricing.minprice.cycle eq "biennially"}
                                    /
                                    {$LANG.orderpaymenttermbiennially}
                                {elseif $product.pricing.minprice.cycle eq "triennially"}
                                    /
                                    {$LANG.orderpaymenttermtriennially}
                                {/if}
                                    <br>
                                    {if $product.pricing.minprice.setupFee}
                                        <small>{$product.pricing.minprice.setupFee->toPrefixed()} {$LANG.ordersetupfee}</small>
                                    {/if}
                                </span>
                            {/if}

                    </div>

                    <div class="row ">
                        <div class="col-xs-12 " style="text-align: center;">

                            <div class="clear"></div>

                            <div class="description desc-holder">


                                {$product.description|unescape}

                            </div>

                            <div class="text-center">
                                <a href="cart.php?a=add&{if $product.bid}bid={$product.bid}{else}pid={$product.pid}{/if}" class="whmc-kbtn" style="width: 80%; margin: 20px 0;"> {$LANG.ordernowbutton}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/foreach}
        </div>

        {if !$loggedin && $currencies}
            <div class="currencychooser">
                <div class="btn-group" role="group">
                    {foreach from=$currencies item=curr}
                        <a href="cart.php?gid={$gid}&currency={$curr.id}" class="btn btn-default{if $currency.id eq $curr.id} active{/if}">
                            <img src="{$BASE_PATH_IMG}/flags/{if $curr.code eq "AUD"}au{elseif $curr.code eq "CAD"}ca{elseif $curr.code eq "EUR"}eu{elseif $curr.code eq "GBP"}gb{elseif $curr.code eq "INR"}in{elseif $curr.code eq "JPY"}jp{elseif $curr.code eq "USD"}us{elseif $curr.code eq "ZAR"}za{else}na{/if}.png"
                                 border="0" alt=""/>
                            {$curr.code}
                        </a>
                    {/foreach}
                </div>
            </div>
        {/if}

    </div>

</div>