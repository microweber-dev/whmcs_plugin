{include file="orderforms/standard_cart/common.tpl"}

<div id="order-standard_cart">

    <div class="row">
{*        <div class="cart-sidebar">*}
{*            {include file="orderforms/standard_cart/sidebar-categories.tpl"}*}
{*        </div>*}
        <div class="cart-body" style="width: 90%; text-align: center;">
            <div class="header-lined page-domains adddomain-title" >
                <h1>
                    Find Your New Domain Name
                </h1>
            </div>
            {include file="orderforms/standard_cart/sidebar-categories-collapsed.tpl"}

{*            <p>{$LANG.orderForm.findNewDomain}</p>*}

            <div class="domain-checker-container">
                <div class="domain-checker-bg clearfix">
                    <form method="post" action="cart.php" id="frmDomainChecker">
                        <input type="hidden" name="a" value="checkDomain">
                        <div class="row" style="justify-content: center; display: flex;">
                            <div class="col-md-8">
                                <div class="input-group input-group-lg input-group-box" style="display: flex;">
                                    <input type="text" name="domain" class="form-control" placeholder="{$LANG.findyourdomain}" value="{$lookupTerm}" id="inputDomain" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="{lang key='orderForm.domainOrKeyword'}" />
                                    <div >
                                        <button type="submit" id="btnCheckAvailability-custom" class="whmc-kbtn input-domain-domains-area-btn {$captcha->getButtonClass($captchaForm)}" style="height: 100%;">{$LANG.search}</button>
                                    </div>
                                </div>
                            </div>

                            {if $captcha->isEnabled() && $captcha->isEnabledForForm($captchaForm) && !$captcha->recaptcha->isInvisible()}
                                <div class="col-md-8 col-md-offset-2 offset-md-2 col-xs-10 col-xs-offset-1 col-10 offset-1">
                                    <div class="captcha-container" id="captchaContainer">
                                        {if $captcha == "recaptcha"}
                                            <br>
                                            <div class="text-center">
                                                <div class="form-group recaptcha-container"></div>
                                            </div>
                                        {elseif $captcha != "recaptcha"}
                                            <div class="default-captcha default-captcha-register-margin">
                                                <p>{lang key="cartSimpleCaptcha"}</p>
                                                <div>
                                                    <img id="inputCaptchaImage" src="{$systemurl}includes/verifyimage.php" align="middle" />
                                                    <input id="inputCaptcha" type="text" name="code" maxlength="6" class="form-control input-sm" data-toggle="tooltip" data-placement="right" data-trigger="manual" title="{lang key='orderForm.required'}" />
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            {/if}
                        </div>
                    </form>
                </div>
            </div>

            <div id="DomainSearchResults" class="w-hidden">
                <div id="searchDomainInfo" class="client-area-boxes-2" style="margin-bottom: 40px;">
                    <p id="primaryLookupSearching" class="domain-lookup-loader domain-lookup-primary-loader domain-searching" style="margin-left: 40px; "><i class="fas fa-spinner fa-spin"></i> {lang key='orderForm.searching'}...</p>



                    <div id="primaryLookupResult" class="domain-lookup-result w-hidden " style="width: 100%; display: flex; justify-content: start; font-size: 30px;">
                        <div class="col-md-10" style="display: grid; justify-content: start;">
                            <p class="domain-invalid domain-checker-invalid">{lang key='orderForm.domainLetterOrNumber'}<span class="domain-length-restrictions">{lang key='orderForm.domainLengthRequirements'}</span></p>

                            <p class="domain-unavailable domain-checker-unavailable" style="float: left;"><span class="domain-register-message domain-message-success"><i class="fa fa-close"></i></span>  {lang key='orderForm.domainIsUnavailable'}</p>


                            <p class="domain-available domain-checker-available" style="float: left;"><span class="domain-register-message domain-message-danger"><i class="fa fa-check"></i></span>  <strong></strong> {$LANG.domainavailable2}</p>

                            <a class="domain-contact-support btn btn-primary">{$LANG.domainContactUs}</a>

                            <div id="idnLanguageSelector" class="form-group idn-language-selector w-hidden">
                                <div class="row">
                                    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2 offset-sm-1 offset-lg-2">
                                        <div class="margin-10 text-center">
                                            {lang key='cart.idnLanguageDescription'}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-8 col-lg-6 col-sm-offset-2 col-lg-offset-3 offset-sm-2 offset-lg-3">
                                        <select name="idnlanguage" class="form-control">
                                            <option value="">{lang key='cart.idnLanguage'}</option>
                                            {foreach $idnLanguages as $idnLanguageKey => $idnLanguage}
                                                <option value="{$idnLanguageKey}">{lang key='idnLanguage.'|cat:$idnLanguageKey}</option>
                                            {/foreach}
                                        </select>
                                        <div class="field-error-msg">
                                            {lang key='cart.selectIdnLanguageForRegister'}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="domain-price" style="margin-left: 80px; width: 50%; float: left;">
                                <span class="price"></span>
                            </div>


                            <p class="domain-error domain-checker-unavailable"></p>
                        </div>


                        <div class="col-md-2" style="margin-right: 40px; align-items: center; align-content: center; display: flex;">
                            <p class="domain-price " style="justify-content: end;">
                                <button class="whmc-kbtn btn-add-to-cart" data-whois="0" data-domain="">
                                    <span class="to-add">{$LANG.addtocart}</span>
                                    <span class="loading">
                                        <i class="fas fa-spinner fa-spin"></i> {lang key='loading'}
                                    </span>
                                    <span class="added"><i class="far fa-shopping-cart"></i> {lang key='checkout'}</span>
                                    <span class="unavailable">{$LANG.domaincheckertaken}</span>
                                </button>
                            </p>
                        </div>

                    </div>


                </div>


                {if $spotlightTlds}

                    <p class="feature-desc" style="text-align: left; padding: 7px 14px;">Most Popular</p>
                    <div id="spotlightTlds" class="spotlight-tlds clearfix">
                        <div class="spotlight-tlds-container">
                            {foreach $spotlightTlds as $key => $data}
                                <div class="spotlight-tld-container spotlight-tld-container-{$spotlightTlds|count}">
                                    <div id="spotlight{$data.tldNoDots}" class="spotlight-tld">
                                        {if $data.group}
                                            <div class="spotlight-tld-{$data.group}">{$data.groupDisplayName}</div>
                                        {/if}
                                        {$data.tld}
                                        <span class="domain-lookup-loader domain-lookup-spotlight-loader">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                        <div class="domain-lookup-result">
                                            <button type="button" class="btn unavailable w-hidden" disabled="disabled">
                                                {lang key='domainunavailable'}
                                            </button>
                                            <button type="button" class="btn invalid w-hidden" disabled="disabled">
                                                {lang key='domainunavailable'}
                                            </button>
                                            <span class="available price w-hidden">{$data.register}</span>
                                            <button type="button" class="btn btn-add-to-cart w-hidden" data-whois="0" data-domain="">
                                                <span class="to-add">{lang key='orderForm.add'}</span>
                                                <span class="loading">
                                                    <i class="fas fa-spinner fa-spin"></i> {lang key='loading'}
                                                </span>
                                                <span class="added"><i class="far fa-shopping-cart"></i> {lang key='checkout'}</span>
                                                <span class="unavailable">{$LANG.domaincheckertaken}</span>
                                            </button>
                                            <button type="button" class="btn btn-primary domain-contact-support w-hidden">
                                                {lang key='domainChecker.contactSupport'}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                {/if}

                <div class="suggested-domains{if !$showSuggestionsContainer} w-hidden{/if}">
                    <div class="panel-heading card-header">
                        {lang key='orderForm.suggestedDomains'}
                    </div>
                    <div id="suggestionsLoader" class="panel-body card-body domain-lookup-loader domain-lookup-suggestions-loader">
                        <i class="fas fa-spinner fa-spin"></i> {lang key='orderForm.generatingSuggestions'}
                    </div>
                    <div id="domainSuggestions" class="domain-lookup-result list-group w-hidden">
                        <div class="domain-suggestion list-group-item w-hidden">
                            <span class="domain"></span><span class="extension"></span>
                            <span class="promo w-hidden">
                                <span class="sales-group-hot w-hidden">{lang key='domainCheckerSalesGroup.hot'}</span>
                                <span class="sales-group-new w-hidden">{lang key='domainCheckerSalesGroup.new'}</span>
                                <span class="sales-group-sale w-hidden">{lang key='domainCheckerSalesGroup.sale'}</span>
                            </span>
                            <div class="actions">
                                <span class="price"></span>
                                <button type="button" class="btn btn-add-to-cart" data-whois="1" data-domain="">
                                    <span class="to-add">{$LANG.addtocart}</span>
                                    <span class="loading">
                                        <i class="fas fa-spinner fa-spin"></i> {lang key='loading'}
                                    </span>
                                    <span class="added"><i class="far fa-shopping-cart"></i> {lang key='checkout'}</span>
                                    <span class="unavailable">{$LANG.domaincheckertaken}</span>
                                </button>
                                <button type="button" class="btn btn-primary domain-contact-support w-hidden">
                                    {lang key='domainChecker.contactSupport'}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer card-footer more-suggestions text-center w-hidden">
                        <a id="moreSuggestions" href="#" onclick="loadMoreSuggestions();return false;">{lang key='domainsmoresuggestions'}</a>
                        <span id="noMoreSuggestions" class="no-more small w-hidden">{lang key='domaincheckernomoresuggestions'}</span>
                    </div>
                    <div class="text-center text-muted domain-suggestions-warning">
                        <p>{lang key='domainssuggestionswarnings'}</p>
                    </div>
                </div>

            </div>

            <br><br><br>

            <div class="domain-pricing">

                {if $featuredTlds}
                    <div class="featured-tlds-container">
                        <div class="row">
                            {foreach $featuredTlds as $num => $tldinfo}
                                {if $num % 3 == 0 && (count($featuredTlds) - $num < 3)}
                                    {if count($featuredTlds) - $num == 2}
                                        <div class="col-sm-2"></div>
                                    {else}
                                        <div class="col-sm-4"></div>
                                    {/if}
                                {/if}
                                <div class="col-lg-4 col-sm-6">
                                    <div class="featured-tld">
                                        <div class="img-container">
                                            <img height="80"  src="{$BASE_PATH_IMG}/tld_logos/{$tldinfo.tldNoDots}.png">
                                        </div>

                                        <hr>
                                        <div class="price {$tldinfo.tldNoDots}" style="padding: 20px 0;">
                                            {if is_object($tldinfo.register)}
                                                {$tldinfo.register->toPrefixed()}{if $tldinfo.period > 1}{lang key="orderForm.shortPerYears" years={$tldinfo.period}}{else}{lang key="orderForm.shortPerYear" years=''}{/if}
                                            {else}
                                                {lang key="domainregnotavailable"}
                                            {/if}


                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                {/if}
                <br><br><br><br>
                <h4 class="font-size-24" style="text-align: left;">{lang key='pricing.browseExtByCategory'}</h4>

                <br>

                <div class="tld-filters" style="justify-content: start; display: flex;">

                   <div class="form-group">
                       <select class="form-control" name="" id="">
                           {foreach $categoriesWithCounts as $category => $count}


                               <option data-category="{$category}" value="{$category}">
                                   {lang key="domainTldCategory.$category" defaultValue=$category} ({$count})
                               </option>


                           {/foreach}

                       </select>
                   </div>

                </div>

                <br><br><br>

                <div class="bg-white domain-register-table" style="padding: 30px; font-size: 15px;">
                    <div class="row no-gutters tld-pricing-header text-center">
                        <div class="col-md-3" style="text-align: left;">{lang key='orderdomain'}</div>
                        <div class="col-md-9">
                            <div class="row no-gutters">
                                <div class="col-xs-4 col-4">{lang key='pricing.register'}</div>
                                <div class="col-xs-4 col-4">{lang key='pricing.transfer'}</div>
                                <div class="col-xs-4 col-4">{lang key='pricing.renewal'}</div>
                            </div>
                        </div>
                    </div>
                    {foreach $pricing['pricing'] as $tld => $price}
                        <div class="row no-gutters tld-row" data-category="{foreach $price.categories as $category}|{$category}|{/foreach}">
                            <div class="col-md-3 two-row-center px-4" style="text-align: left;">
                                <strong style="font-size: 20px;">.{$tld}</strong>
                                {if $price.group}
                                    <span class="tld-sale-group tld-sale-group-{$price.group}">
                                        {lang key='domainCheckerSalesGroup.'|cat:$price.group}
                                    </span>
                                {/if}
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-xs-4 col-4 text-center">
                                        {if isset($price.register) && current($price.register) > 0}
                                            {current($price.register)}<br>
                                            <small>{key($price.register)} {if key($price.register) > 1}{lang key="orderForm.years"}{else}{lang key="orderForm.year"}{/if}</small>
                                        {elseif isset($price.register) && current($price.register) == 0}
                                            <small>{lang key='orderfree'}</small>
                                        {else}
                                            <small>{lang key='na'}</small>
                                        {/if}
                                    </div>
                                    <div class="col-xs-4 col-4 text-center">
                                        {if isset($price.transfer) && current($price.transfer) > 0}
                                            {current($price.transfer)}<br>
                                            <small>{key($price.transfer)} {if key($price.register) > 1}{lang key="orderForm.years"}{else}{lang key="orderForm.year"}{/if}</small>
                                        {elseif isset($price.transfer) && current($price.transfer) == 0}
                                            <small>{lang key='orderfree'}</small>
                                        {else}
                                            <small>{lang key='na'}</small>
                                        {/if}
                                    </div>
                                    <div class="col-xs-4 col-4 text-center">
                                        {if isset($price.renew) && current($price.renew) > 0}
                                            {current($price.renew)}<br>
                                            <small>{key($price.renew)} {if key($price.register) > 1}{lang key="orderForm.years"}{else}{lang key="orderForm.year"}{/if}</small>
                                        {elseif isset($price.renew) && current($price.renew) == 0}
                                            <small>{lang key='orderfree'}</small>
                                        {else}
                                            <small>{lang key='na'}</small>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                    <div class="row tld-row no-tlds">
                        <div class="col-xs-12 col-12 text-center">
                            <br>
                            {lang key='pricing.selectExtCategory'}
                            <br><br>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="{if $domainTransferEnabled}col-md-6{else}col-md-8 col-md-offset-2 offset-md-2{/if}">
                    <div class="domain-promo-box">

                        <div class="clearfix">
                            <i class="fas fa-server fa-4x"></i>
                            <h3 class="font-size-24 no-wrap">{lang key='orderForm.addHosting'}</h3>
                            <p class="font-bold text-warning">{lang key='orderForm.chooseFromRange'}</p>
                        </div>

                        <p>{lang key='orderForm.packagesForBudget'}</p>

                        <a href="cart.php" class="btn btn-warning">
                            {lang key='orderForm.exploreNow'}
                        </a>
                    </div>
                </div>
                {if $domainTransferEnabled}
                    <div class="col-md-6">
                        <div class="domain-promo-box">

                            <div class="clearfix">
                                <i class="fas fa-globe fa-4x"></i>
                                <h3 class="font-size-22">{lang key='orderForm.transferToUs'}</h3>
                                <p class="font-bold text-primary">{lang key='orderForm.transferExtend'}*</p>
                            </div>

                            <a href="cart.php?a=add&domain=transfer" class="btn btn-primary">
                                {lang key='orderForm.transferDomain'}
                            </a>

                            <p class="small">* {lang key='orderForm.extendExclusions'}</p>
                        </div>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>

<script>


jQuery(document).ready(function() {
    jQuery('.tld-filters a:first-child').click();
{if $lookupTerm && !$captchaError && !$invalid}
    jQuery('#btnCheckAvailability').click();
{/if}
{if $invalid}
    jQuery('#primaryLookupSearching').toggle();
    jQuery('#primaryLookupResult').children().toggle();
    jQuery('#primaryLookupResult').toggle();
    jQuery('#DomainSearchResults').toggle();
    jQuery('.domain-invalid').toggle();
{/if}


});


</script>
