
<form method="post" action="{$smarty.server.PHP_SELF}?a=view">
    <div class="cart">
        {foreach key=num item=product from=$products}
            <div class="service-block plan">
                <a href="#" onclick="removeItem('p','{$num}');return false" class="remove-this" title="Remove"></a>
                <a href="{$smarty.server.PHP_SELF}?a=confproduct&i={$num}" class="edit-this" title="{$LANG.carteditproductconfig}">edit</a>
                <h1>
                    {$product.productinfo.groupname} - {$product.productinfo.name}
                    {if $product.domain}
                        <br/>
                        <small>({$product.domain})</small>
                    {/if}
                </h1>
                <p>
                    {if $product.configoptions}
                        {foreach key=confnum item=configoption from=$product.configoptions}
                            {$configoption.name}: {if $configoption.type eq 1 || $configoption.type eq 2}{$configoption.option}{elseif $configoption.type eq 3}{if $configoption.qty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.type eq 4}{$configoption.qty} x {$configoption.option}{/if}
                            <br/>
                        {/foreach}
                    {/if}
                </p>

                <div class="price-per">
                    <div class="month">
                        {*<span class="currency-symbol">$</span>*}
                        <span class="price">{$product.pricingtext}</span>
                        {if $product.proratadate}
                            <span class="per-month">/ {$LANG.orderprorata} {$product.proratadate}</span>
                        {/if}
                    </div>
                    {*<div class="year"><span>or $60.00 / Year</span></div>*}
                </div>


                {if $product.allowqty}
                    <p>
                        {$LANG.cartqtyenterquantity} <br/>
                        <input type="text" name="qty[{$num}]" size="3" value="{$product.qty}"/>
                        <button type="submit" class="">{$LANG.cartqtyupdate}</button>
                    </p>
                {/if}
            </div>
            {foreach key=addonnum item=addon from=$product.addons}
                <h2>{$LANG.orderaddon} - {$addon.name}</h2>
                <div class="price-per">
                    <div class="month">
                        <span class="price">{$addon.pricingtext}</span>
                    </div>
                </div>
            {/foreach}
        {/foreach}

        {foreach key=num item=addon from=$addons}
            <div class="service-block plan addon">
                <a href="#" onclick="removeItem('a','{$num}');return false" class="remove-this" title="[{$LANG.remove-this}]"></a>

                <h1>
                    {$addon.name} {$addon.productname}
                    {if $addon.domainname}
                        <br/>
                        <small>({$addon.domainname})</small>
                    {/if}
                </h1>

                <div class="price-per">
                    <div class="month">
                        <span class="price">{$addon.pricingtext}</span>
                    </div>
                </div>
            </div>
        {/foreach}

        {foreach key=num item=domain from=$domains}
            <div class="service-block domain">

                <a href="#" onclick="removeItem('d','{$num}');return false" class="remove-this" title="Remove"></a>
                <a href="{$smarty.server.PHP_SELF}?a=confdomains" class="edit-this" title="Edit">edit</a>

                <h1>Domain name registration</h1>
                <p class="domain-label">
                    <strong>{if $domain.type eq "register"}{$LANG.orderdomainregisdivation}{else}{$LANG.orderdomaindivansfer}{/if}</strong>
                    {$domain.domain}
                    <br/>
                    {if $domain.dnsmanagement}&nbsp;&raquo; {$LANG.domaindnsmanagement}<br/>{/if}
                    {if $domain.emailforwarding}&nbsp;&raquo; {$LANG.domainemailforwarding}<br/>{/if}
                    {if $domain.idprotection}&nbsp;&raquo; {$LANG.domainidprotection}<br/>{/if}
                </p>

                <div class="price-per">
                    <div class="month">
                        {*<span class="currency-symbol">$</span>*}
                        <span class="price">{$domain.price}</span> <span class="per-month">/ {$domain.regperiod} {$LANG.orderyears}</span>
                    </div>
                </div>
            </div>
        {/foreach}

        {foreach key=num item=domain from=$renewals}
            <div class="service-block domain">
                <a href="#" onclick="removeItem('r','{$num}');return false" class="remove-this" title="Remove"></a>

                <h1>{$LANG.domainrenewal}</h1>
                <p class="domain-label">
                    {$domain.domain}
                    <br/>
                    {if $domain.dnsmanagement}&nbsp;&raquo; {$LANG.domaindnsmanagement}<br/>{/if}
                    {if $domain.emailforwarding}&nbsp;&raquo; {$LANG.domainemailforwarding}<br/>{/if}
                    {if $domain.idprotection}&nbsp;&raquo; {$LANG.domainidprotection}<br/>{/if}
                </p>

                <div class="price-per">
                    <div class="month">
                        <span class="price">{$domain.price}</span> <span class="per-month">/ {$domain.regperiod} {$LANG.orderyears}</span>
                    </div>
                </div>
            </div>
        {/foreach}

    </div>
</form>
