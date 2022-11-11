<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="{$charset}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{if $kbarticle.title}{$kbarticle.title} - {/if}{$pagetitle} - {$companyname}</title>

    {include file="$template/includes/head.tpl"}

    {$headoutput}
</head>
<body>
{$headeroutput}





<div id="container">

    <div class="mobile-overlay"></div>
    <header>
        <div class="header-holder">
            <div class="wrapper">
                <div class="mw-whm-header--block {if !$loggedin}not-logged-user{/if}">
                    <div>
                        {if $logo}
{*                            <a href="{$WEB_ROOT}/" class="logo"><img src="{$logo}" alt="{$companyname}"></a>*}
                            <a href="http://microweber.bg" class="header-link-back-to-site">
{*
                                <svg style="display: none" class="header-svg-back-to-site" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.05 16.94V12.94H18.97L19 10.93H10.05V6.94L5.05 11.94Z" /></svg>
*}
                                <svg class="header-svg-back-to-site" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 256 256" height="256px" id="Layer_1" version="1.1" viewBox="0 0 256 256" width="256px" xml:space="preserve"><path d="M179.199,38.399c0,1.637-0.625,3.274-1.875,4.524l-85.076,85.075l85.076,85.075c2.5,2.5,2.5,6.55,0,9.05s-6.55,2.5-9.05,0  l-89.601-89.6c-2.5-2.5-2.5-6.551,0-9.051l89.601-89.6c2.5-2.5,6.55-2.5,9.05,0C178.574,35.124,179.199,36.762,179.199,38.399z"/></svg>
                            </a>
                                {else}
                            <a href="{$WEB_ROOT}/" class="logo">{$companyname}</a>
                        {/if}

                        <a href="http://microweber.bg" class="back-to-website-button">{$LANG.MW_backToSite}</a>
                    </div>
                    <div>
                        <nav class="main-menu">
                            <ul>
                                {include file="$template/includes/navbar-header.tpl"}
                            </ul>
                        </nav>

                        <div class="mobile-nav-wrapper">
                            <ul role="menu" class="mobile-nav">
                                <li class="mobile-user-col">
                                    <div id="header-meta">
                                        {if $loggedin}
                                            <a class="user-bar" href="{$WEB_ROOT}/clientarea.php?action=details">
                                        <span class="image"
                                              style="background-image: url('https://mwlogin.com/avatar/{$loggedinuser.email|md5}.jpg')"></span>
                                                <span class="name">{if $loggedinuser.firstname neq ''}{$loggedinuser.firstname}{else}{$loggedinuser.email}{/if}</span>
                                                <div class="clearfix"></div>
                                            </a>
                                            <div class="clearfix"></div>
                                            <div class="more-menu">
                                                <ul>
                                                    <li><a href="{$WEB_ROOT}/clientarea.php?action=services">{$LANG.MW_myWebsites}</a></li>
                                                    <li><a href="{$WEB_ROOT}/logout.php">{$LANG.MW_logout}</a></li>
                                                </ul>
                                            </div>
                                        {else}
                                            <div class="more-menu">
                                                <ul>
                                                    <li><a href="{$WEB_ROOT}/clientarea.php?action=services">{$LANG.login}</a></li>
                                                </ul>
                                            </div>
                                        {/if}
                                    </div>
                                </li>
                                {include file="$template/includes/navbar-header.tpl"}

                                {if $loggedin}
                                    <li>
                                        <a href="javascript:;" class="menu-more">{$LANG.MW_Profile} &nbsp;<b class="caret"></b></a>
                                        <ul>
                                            <li><a href="{$WEB_ROOT}/clientarea.php?action=details">{$LANG.MW_editProfile}</a></li>
                                            {if $condlinks.updatecc}
                                                <li><a href="{$WEB_ROOT}/clientarea.php?action=creditcard">{$LANG.navmanagecc}</a></li>
                                            {/if}
                                            <li><a href="{$WEB_ROOT}/clientarea.php?action=contacts">{$LANG.clientareanavcontacts}</a></li>
                                            {if $condlinks.addfunds}
                                                <li><a href="{$WEB_ROOT}/clientarea.php?action=addfunds">{$LANG.addfunds}</a></li>
                                            {/if}
                                            <li><a href="{$WEB_ROOT}/clientarea.php?action=emails">{$LANG.navemailssent}</a></li>
                                            <li><a href="{$WEB_ROOT}/clientarea.php?action=changepw">{$LANG.clientareanavchangepw}</a></li>
                                        </ul>
                                    </li>
                                {/if}
                            </ul>
                        </div>
                    </div>

                    <div class="mw-mwh--header-menu-sign-column">


                        {if $loggedin}
                            <div class="user-menu-dropdown pull-right">
                                <a class="user-bar" href="clientarea.php?action=details">
                                    <span class="image" style="background-image: url('{$WEB_ROOT}/templates/{$template}/img/avatar.jpg')"></span>
                                    <span class="name"></span>
                                </a>
                                <div class="clearfix"></div>
                                <div class="more-menu">
                                    <ul>
                                        <li><a href="{$WEB_ROOT}/clientarea.php?action=services">{$LANG.MW_myWebsites}</a></li>
                                        <li><a href="{$WEB_ROOT}/clientarea.php?action=details">{$LANG.MW_editProfile}</a></li>

                                        {if $condlinks.updatecc}
                                            <li><a href="{$WEB_ROOT}/clientarea.php?action=creditcard">{$LANG.navmanagecc}</a></li>
                                        {/if}

                                        <li><a href="{$WEB_ROOT}/clientarea.php?action=contacts">{$LANG.clientareanavcontacts}</a></li>

                                        {if $condlinks.addfunds}
                                            <li><a href="{$WEB_ROOT}/clientarea.php?action=addfunds">{$LANG.addfunds}</a></li>
                                        {/if}

                                        <li><a href="{$WEB_ROOT}/clientarea.php?action=emails">{$LANG.navemailssent}</a></li>


                                        {if $adminMasqueradingAsClient || $adminLoggedIn}
                                            <li>
                                                <a href="{$WEB_ROOT}/logout.php?returntoadmin=1" class="btn btn-logged-in-admin" data-toggle="tooltip" data-placement="bottom"
                                                   title="{if $adminMasqueradingAsClient}{$LANG.adminmasqueradingasclient} {$LANG.logoutandreturntoadminarea}{else}{$LANG.adminloggedin} {$LANG.returntoadminarea}{/if}">
                                                    {$LANG.clientareanavlogout}
                                                </a>
                                            </li>
                                        {else}
                                            <li><a href="{$WEB_ROOT}/logout.php">{$LANG.clientareanavlogout}</a></li>
                                        {/if}


                                    </ul>
                                </div>
                            </div>
                            <a href="{$WEB_ROOT}/clientarea.php?action=services" class="btn btn-link top-right-button hidden-mobile pull-right" style="margin-top: 6px;">{$LANG.MW_myWebsites}</a>
                            {if $cartitems==0}
                                <a href="cart.php?a=checkout" class="cbtn cbtn-alt top-right-button hidden-mobile pull-right" style="padding: 0 10px;" title="0 Items"><span
                                            class="fa fa-shopping-cart" ></span> &nbsp;0</a>
                            {else}
                                <a href="cart.php?a=checkout" class="cbtn cbtn-alt top-right-button hidden-mobile pull-right" style="padding: 0 10px;" title="{$cartitems} Items"><span
                                            class="fa fa-shopping-cart" ></span> &nbsp;{$cartitems}</a>
                            {/if}
                            <div class="mobile-menu">
                            <span class="hamb">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                                {*<span class="nav-label">Menu</span>*}
                            </div>
                        {else}
{*                            <a href="{$WEB_ROOT}/clientarea.php" id="whmc_login_button_header" class="hidden-mobile">Login</a>*}
                            <a href="{$custom_oauth2_login_url}" class="whmc-kbtn" >{$LANG.login}</a>
                        {/if}

                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="page-wrapper">
        <div class="main">
            <div class="wrapper ">
                <div class="row" style="display: flex; justify-content: center;">
                    <!-- No Sidebar -->
                    {assign var="withSidebar" value="true"}

                    {if $filename eq 'cart' AND {$smarty.get.a eq 'view' OR $smarty.get.a eq 'checkout'}}
                        {assign var="withSidebar" value="false"}
                    {/if}

                    {if $withSidebar eq 'true'}
                        {include file="$template/includes/sidebar.tpl"}
                    {/if}

                    <!-- No BG -->
                    {assign var="withBG" value="true"}

                    {if $filename eq 'cart' AND {$smarty.get.a eq 'view' OR $smarty.get.a eq 'checkout'}}
                        {assign var="withBG" value="false"}
                    {/if}

                    <div class="page-content pt-0 {if $withSidebar eq 'false'}without-sidebar{/if} {if $withBG eq 'false'}no-bg{/if}">
