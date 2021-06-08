{if $homepage->getMarketConnectCount() == 1}
    <style>
        .site.site-index .site-banner {
            padding-bottom: 100px;
        }
    </style>
{/if}









{if $banner_home}
    <div data-promo-slider>
        <div class="site-banner site-slider">
            <div class="slider-background" data-promo-slider-background>
                <div></div>
                <div></div>
            </div>
            <div class="container">
                <div class="d-flex">
                    <div class="slider-wrapper">
                        <div class="slider-slides" data-promo-slider-wrapper>
                            {foreach from=$banner_home item=item}
                                <div class="slider-slide row">
                                    <div class="col-lg-6 col-md-7">
                                        <div class="banner-content" data-animation-content>
                                            <h1 class="banner-title">{$item['headline']}</h1>
                                            <div class="banner-desc">
                                                <p>{$item['tagline']}</p>
                                            </div>
                                            <div class="banner-actions">
                                                <a href="{$systemurl}cart.php?a=add&pid={$item['pid']}"
                                                   class="btn btn-lg btn-primary">{$LANG.getStartedNow}</a>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5">
                                        <div class="banner-graphic" data-animation-icons>
                                            {if file_exists("templates/$template/assets/svg-illustrations/products/{$item['name']}.tpl")}
                                                {include file="$template/assets/svg-illustrations/products/{$item['name']}.tpl"}
                                            {/if}




                                            {if file_exists("modules/addons/microweber_addon/integrations/lagom/tpl/svg/website.tpl")}
                                                {include file="modules/addons/microweber_addon/integrations/lagom/tpl/svg/website.tpl"}
                                            {/if}


                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
{/if}