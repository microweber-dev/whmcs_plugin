<div class="mw-whm cart-products">
    <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css"/>

    <div id="order-modern">

        <div class="title-bar">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <h1>{$groupname}</h1>
                </div>
                <div class="col-md-4">
                    {include file="templates/orderforms/{$carttpl}/category-chooser.tpl"}
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

        <div class="row">
            {foreach from=$products key=num item=product}
            <div class="col-md-6">
                {*<div id="product{$num}" class="panel" onclick="window.location='cart.php?a=add&{if $product.bid}bid={$product.bid}{else}pid={$product.pid}{/if}'">*}
                <div id="product{$num}" class="panel panel-primary">

                    <div class="panel-heading">
                        {$product.name}
                        {if $product.qty}
                            <span class="qty">
                                ({$product.qty} {$LANG.orderavailable})
                            </span>
                        {/if}
                    </div>

                    <div class="panel-body">
                        <div class="pricing text-right">
                            {if $product.bid}
                                {$LANG.bundledeal}
                                /
                                {if $product.displayprice}
                                    <span class="pricing">{$product.displayprice}</span>
                                {/if}
                            {else}
                                <span class="pricing">{$product.pricing.minprice.price}</span>

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


                            {foreach from=$product.features key=feature item=value}
                                <span class="prodfeature"><span class="feature">{$feature}</span>
                                <br/>{$value}</span>
                            {/foreach}

                            <div class="clear"></div>

                            <div class="description">{$product.featuresdesc}</div>

                            <div class="text-center">
                                <a href="cart.php?a=add&{if $product.bid}bid={$product.bid}{else}pid={$product.pid}{/if}" class="btn btn-primary btn-sm"> {$LANG.ordernowbutton}</a>
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