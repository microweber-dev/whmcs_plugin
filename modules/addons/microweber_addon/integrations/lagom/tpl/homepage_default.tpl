{assign var="homepageTemplate" value=$RSThemes.pages.homepage.name}

{* =====================================

 PROMOTED PRODUCT GROUPS

 Enter product group IDs, which you want to promote

 ======================================= *}

{assign var=productGroupId value=[

[
'gid' => 1,
'icon' => 'shared-hosting.tpl',
'featured' => false
],
[
'gid' => 2,
'icon' => 'vps-hosting.tpl',
'featured' => true
],
[
'gid' => 13,
'icon' => 'dedicated-servers.tpl',
'featured' => false
]
]}

{foreach from=$productGroupId key=k item=product}
    {if $homepage->productGroup($product.gid)->product}
        {assign var=showGroup value=true}
    {/if}
{/foreach}

{* =====================================

 TESTIMONIALS

 Add new testimonials simply by adding new array records below

 ======================================= *}

{assign var=testimonials value=[
[
'author'=> 'Sonia Stephens',
'avatar' => 'homepage-avatar-1.png',
'website'=> 'lagom.rsstudio.net',
'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, doloremque doloribus impedit incidunt minus natus officiis omnis perspiciatis ullam.'
],
[
'author'=> 'John Doe',
'avatar' => 'homepage-avatar-2.png',
'website'=> 'rsstudio.net',
'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, doloremque doloribus impedit incidunt minus natus officiis omnis perspiciatis ullam.'
],
[
'author'=> 'Alexandra Chapman',
'avatar' => 'homepage-avatar-3.png',
'website'=> 'rsstudio.net',
'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, doloremque doloribus impedit incidunt minus natus officiis omnis perspiciatis ullam.'
],
[
'author'=> 'James Bond',
'avatar' => 'homepage-avatar-4.png',
'website'=> 'lagom.rsstudio.com',
'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, doloremque doloribus impedit incidunt minus natus officiis omnis perspiciatis ullam.'
],
[
'author'=> 'Alice Smith',
'avatar' => 'homepage-avatar-5.png',
'website'=> 'lagom.rsstudio.com',
'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, doloremque doloribus impedit incidunt minus natus officiis omnis perspiciatis ullam.'
],
[
'author'=> 'Emily Turner',
'avatar' => 'homepage-avatar-6.png',
'website'=> 'lagom.rsstudio.com',
'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, doloremque doloribus impedit incidunt minus natus officiis omnis perspiciatis ullam.'
],
[
'author'=> 'Brandon Quinn',
'avatar' => 'homepage-avatar-7.png',
'website'=> 'lagom.rsstudio.com',
'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, doloremque doloribus impedit incidunt minus natus officiis omnis perspiciatis ullam.'
]
]}

{if $RSThemes.layouts.vars.type != "navbar-left"}
<div class="app-main">
    {/if}
    <div class="site site-index">

        {if $productGroupId || $registerdomainenabled}
            <div class="site-section">
                <div class="container">
                    {if $registerdomainenabled}
                        <h2 class="section-title text-center">{$LANG.findyourdomain}</h2>
                        <div class="section-content">
                            <form method="post" action="domainchecker.php" id="frmDomainHomepage">
                                <div class="search-box input-group input-group-lg has-shadow">
                                    <i class="input-group-icon fas fa-search lm lm-search"></i>
                                    <input type="text" class="form-control" name="domain" placeholder="{$LANG.exampledomain}" autocapitalize="none"/>
                                    {if $registerdomainenabled}
                                        <input type="submit" class="whmc-kbtn search {if in_array($captcha, ['invisible']) && $captcha->isEnabled() && $captcha->isEnabledForForm($captchaForm)}{$captcha->getButtonClass($captchaForm)}{/if}" value="{$LANG.search}" id="btnDomainSearch"/>
                                    {/if}
                                </div>
                            </form>
                            {if $homepage->getSpotlight()}
                                <div class="featured-tlds row">
                                    {foreach $homepage->getSpotlight() as $domain}
                                        <div class="col-sm">
                                            <div class="domains-package">
                                                <div class="domains-icon">
                                                    {$domain.ext|replace:".":"<span>.</span>"}
                                                </div>
                                                <div class="domains-price">
                                                    <span>{$domain.price}</span>
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            {/if}
                        </div>
                    {/if}
                    {if $productGroupId && $showGroup}
                        <div class="section-content">
                            <h2 class="section-title text-center">{$rslang->trans('homepage.products.title')}</h2>
                            <div class="row row-eq-height row-eq-height-sm">
                                {foreach from=$productGroupId key=k item=product}
                                    {if $homepage->productGroup($product.gid)->product}
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="package package-lg{if $product.featured} has-shadow{/if}">
                                                <div class="package-icon">
                                                    {if $product.icon|strstr:".tpl"}
                                                        {if file_exists("templates/$template/assets/svg-icon/{$product.icon}")}
                                                            {include file="$template/assets/svg-icon/{$product.icon}"}
                                                        {/if}
                                                    {else}
                                                        <img class="w-100" src="{$WEB_ROOT}/templates/{$template}/assets/img/products/{$product.icon}">
                                                    {/if}
                                                </div>
                                                <h4 class="package-title">{$homepage->productGroup($product.gid)->product->productGroup->name}</h4>
                                                <p class="package-desc">{$homepage->productGroup($product.gid)->product->productGroup->headline}</p>
                                                <div class="package-price">
                                                    <div class="package-starting-from ">{$LANG.startingat}</div>
                                                    <div class="price">
                                                        {$homepage->productGroup($product.gid)->price}
                                                        {if $homepage->productGroup($product.gid)->billing eq 'free'}
                                                        {else}
                                                            <span class="price-cycle">
                                                            {if $homepage->productGroup($product.gid)->billing eq "monthly"}
                                                                /{$rslang->trans('order.period.short.monthly')}
                                                            {elseif $homepage->productGroup($product.gid)->billing eq "quarterly"}
                                                                /{$rslang->trans('order.period.short.quarterly')}
                                                            {elseif $homepage->productGroup($product.gid)->billing eq "semiannually"}
                                                                /{$rslang->trans('order.period.short.semiannually')}
                                                            {elseif $homepage->productGroup($product.gid)->billing eq "annually"}
                                                                /{$rslang->trans('order.period.short.annually')}
                                                            {elseif $homepage->productGroup($product.gid)->billing eq "biennially"}
                                                                /{$rslang->trans('order.period.short.biennially')}
                                                            {elseif $homepage->productGroup($product.gid)->billing eq "triennially"}
                                                                /{$rslang->trans('order.period.short.triennially')}
                                                            {/if}
                                                            </span>
                                                        {/if}
                                                    </div>
                                                </div>
                                                <div class="package-actions">
                                                    <a href="{$systemurl}cart.php?gid={$homepage->productGroup($product.gid)->product->productGroup->id}" class="whmc-kbtn " data-target="incoming">{$LANG.getStartedNow}</a>
                                                </div>
                                            </div>
                                        </div>
                                    {/if}
                                {/foreach}
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
        {/if}

        <div class="site-section section-dark section-started text-center">
            <div class="container">
                <h2 class="section-title">{$rslang->trans('homepage.get_started.title')}</h2>
                <p class="section-subtitle">{$rslang->trans('homepage.get_started.subtitle')}</p>
                <a href="{$WEB_ROOT}/contact.php" class="whmc-kbtn ">{$LANG.contactus}</a>
            </div>
        </div>
    </div>
    {if $RSThemes.layouts.vars.type != "navbar-left"}
</div>
{/if}
