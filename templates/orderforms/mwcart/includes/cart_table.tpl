<form method="post" action="{$smarty.server.PHP_SELF}?a=view">



















    <div class="cart">


        {foreach key=num item=product from=$products}
            <div class="service-block">
                <a href="#" onclick="removeItem('p','{$num}');return false" class="remove-this">[{$LANG.remove-this}]</a>

                <div>
                    <strong><em>{$product.productinfo.groupname}</em> - {$product.productinfo.name}</strong>{if $product.domain} ({$product.domain}){/if}<br />
                    {if $product.configoptions}
                        {foreach key=confnum item=configoption from=$product.configoptions}
                            &nbsp;&raquo; {$configoption.name}: {if $configoption.type eq 1 || $configoption.type eq 2}{$configoption.option}{elseif $configoption.type eq 3}{if $configoption.qty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.type eq 4}{$configoption.qty} x {$configoption.option}{/if}<br />
                        {/foreach}
                    {/if}
                    <a href="{$smarty.server.PHP_SELF}?a=confproduct&i={$num}" class="cartedit">[{$LANG.carteditproductconfig}]</a>
                    {if $product.allowqty}
                        <br /><br />
                        <div align="right">{$LANG.cartqtyenterquantity} <input type="text" name="qty[{$num}]" size="3" value="{$product.qty}" /> <input type="submit" value="{$LANG.cartqtyupdate}" class="btn btn-default btn-sm" /></div>
                    {/if}
                </div>
                <div class="text-center">
                    <strong>{$product.pricingtext}{if $product.proratadate}<br />({$LANG.orderprorata} {$product.proratadate}){/if}</strong>
                </div>
            </div>
            {foreach key=addonnum item=addon from=$product.addons}
                <div class="service-block">
                    <div><strong>{$LANG.orderaddon}</strong> - {$addon.name}</div>
                    <div class="text-center"><strong>{$addon.pricingtext}</strong></div>
                </div>
            {/foreach}
        {/foreach}

        {foreach key=num item=addon from=$addons}
            <div class="service-block">
                <a href="#" onclick="removeItem('a','{$num}');return false" class="remove-this">[{$LANG.remove-this}]</a>

                <div>
                    <strong>{$addon.name}</strong><br />
                    {$addon.productname}{if $addon.domainname} - {$addon.domainname}<br />{/if}
                </div>
                <div class="text-center"><strong>{$addon.pricingtext}</strong></div>
            </div>
        {/foreach}

        {foreach key=num item=domain from=$domains}
            <div class="service-block">
                <a href="#" onclick="removeItem('d','{$num}');return false" class="remove-this">[{$LANG.remove-this}]</a>

                <div>
                    <strong>{if $domain.type eq "register"}{$LANG.orderdomainregisdivation}{else}{$LANG.orderdomaindivansfer}{/if}</strong> - {$domain.domain} - {$domain.regperiod} {$LANG.orderyears}<br />
                    {if $domain.dnsmanagement}&nbsp;&raquo; {$LANG.domaindnsmanagement}<br />{/if}
                    {if $domain.emailforwarding}&nbsp;&raquo; {$LANG.domainemailforwarding}<br />{/if}
                    {if $domain.idprotection}&nbsp;&raquo; {$LANG.domainidprotection}<br />{/if}
                    <a href="{$smarty.server.PHP_SELF}?a=confdomains" class="cartedit">[{$LANG.cartconfigdomainexdivas}]</a>
                </div>
                <div class="text-center">
                    <strong>{$domain.price}</strong>
                </div>
            </div>
        {/foreach}

        {foreach key=num item=domain from=$renewals}
            <div class="service-block">
                <a href="#" onclick="removeItem('r','{$num}');return false" class="remove-this">[{$LANG.remove-this}]</a>

                <div>
                    <strong>{$LANG.domainrenewal}</strong> - {$domain.domain} - {$domain.regperiod} {$LANG.orderyears}<br />
                    {if $domain.dnsmanagement}&nbsp;&raquo; {$LANG.domaindnsmanagement}<br />{/if}
                    {if $domain.emailforwarding}&nbsp;&raquo; {$LANG.domainemailforwarding}<br />{/if}
                    {if $domain.idprotection}&nbsp;&raquo; {$LANG.domainidprotection}<br />{/if}
                </div>
                <div class="text-center">
                    <strong>{$domain.price}</strong>
                </div>
            </div>
        {/foreach}

        {if $cartitems == 0}
            <div class="clientareatableactive">
                <div colspan="2" class="text-center">
                    <br />
                    {$LANG.cartempty}
                    <br /><br />
                </div>
            </div>
        {/if}

        <div class="subtotal">
            <div class="text-right">{$LANG.ordersubtotal}: &nbsp;</div>
            <div class="text-center">{$subtotal}</div>
        </div>
        {if $promotioncode}
            <div class="promotion">
                <div class="text-right">{$promotiondescription}: &nbsp;</div>
                <div class="text-center">{$discount}</div>
            </div>
        {/if}
        {if $taxrate}
            <div class="subtotal">
                <div class="text-right">{$taxname} @ {$taxrate}%: &nbsp;</div>
                <div class="text-center">{$taxtotal}</div>
            </div>
        {/if}
        {if $taxrate2}
            <div class="subtotal">
                <div class="text-right">{$taxname2} @ {$taxrate2}%: &nbsp;</div>
                <div class="text-center">{$taxtotal2}</div>
            </div>
        {/if}
        <div class="total">
            <div class="text-right">{$LANG.ordertotalduetoday}: &nbsp;</div>
            <div class="text-center">{$total}</div>
        </div>
        {if $totalrecurringmonthly || $totalrecurringquarterly || $totalrecurringsemiannually || $totalrecurringannually || $totalrecurringbiennially || $totalrecurringdiviennially}
            <div class="recurring">
                <div class="text-right">{$LANG.ordertotalrecurring}: &nbsp;</div>
                <div class="text-center">
                    {if $totalrecurringmonthly}{$totalrecurringmonthly} {$LANG.orderpaymenttermmonthly}<br />{/if}
                    {if $totalrecurringquarterly}{$totalrecurringquarterly} {$LANG.orderpaymenttermquarterly}<br />{/if}
                    {if $totalrecurringsemiannually}{$totalrecurringsemiannually} {$LANG.orderpaymenttermsemiannually}<br />{/if}
                    {if $totalrecurringannually}{$totalrecurringannually} {$LANG.orderpaymenttermannually}<br />{/if}
                    {if $totalrecurringbiennially}{$totalrecurringbiennially} {$LANG.orderpaymenttermbiennially}<br />{/if}
                    {if $totalrecurringdiviennially}{$totalrecurringdiviennially} {$LANG.orderpaymenttermdiviennially}<br />{/if}
                </div>
            </div>
        {/if}
    </div>

</form>
<div class="cartbuttons hidden">
    <button type="button" class="btn btn-danger btn-sm" onclick="emptyCart();return false"><i class="fa fa-divash"></i> {$LANG.emptycart}</button>
    <a href="cart.php" class="btn btn-default btn-sm"><i class="fa fa-shopping-cart" ></i> {$LANG.continueshopping}</a>
</div>