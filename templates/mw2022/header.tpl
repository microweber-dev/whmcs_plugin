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
                <div class="div-table {if !$loggedin}not-logged-user{/if}">
                    <div class="div-table-cell">
                        {if $logo}
                            <a href="{$WEB_ROOT}/" class="logo"><img src="{$logo}" alt="{$companyname}"></a>
                        {else}
                            <a href="{$WEB_ROOT}/" class="logo">{$companyname}</a>
                        {/if}

                        <a href="http://microweber.com" class="cbtn cbtn-small cbtn-green back-to-website-button">Back to Site</a>
                    </div>
                    <div class="div-table-cell">
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
                                                    <li><a href="{$WEB_ROOT}/clientarea.php?action=services">My websites</a></li>
                                                    <li><a href="{$WEB_ROOT}/logout.php">Logout</a></li>
                                                </ul>
                                            </div>
                                        {else}
                                            <div class="more-menu">
                                                <ul>
                                                    <li><a href="{$WEB_ROOT}/clientarea.php?action=services">Log in</a></li>
                                                </ul>
                                            </div>
                                        {/if}
                                    </div>
                                </li>
                                {include file="$template/includes/navbar-header.tpl"}

                                {if $loggedin}
                                    <li>
                                        <a href="javascript:;" class="menu-more">Profile &nbsp;<b class="caret"></b></a>
                                        <ul>
                                            <li><a href="{$WEB_ROOT}/clientarea.php?action=details">Edit profile</a></li>
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

                    <div class="div-table-cell">
                        <div class="mobile-menu">
                            <span class="hamb">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            {*<span class="nav-label">Menu</span>*}
                        </div>

                        {if $loggedin}
                            <div class="user-menu-dropdown pull-right">
                                <a class="user-bar" href="clientarea.php?action=details">
                                    <span class="image" style="background-image: url('{$WEB_ROOT}/templates/{$template}/img/avatar.jpg')"></span>
                                    <span class="name">Profile</span>
                                </a>
                                <div class="clearfix"></div>
                                <div class="more-menu">
                                    <ul>
                                        <li><a href="{$WEB_ROOT}/clientarea.php?action=services">My websites</a></li>
                                        <li><a href="{$WEB_ROOT}/clientarea.php?action=details">Edit profile</a></li>

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
                            <a href="{$WEB_ROOT}/clientarea.php?action=services" class="cbtn top-right-button hidden-mobile pull-right">My Websites</a>
                            {if $cartitems==0}
                                <a href="cart.php?a=checkout" class="cbtn cbtn-alt top-right-button hidden-mobile pull-right" style="padding: 0 10px;" title="0 Items"><span
                                            class="fa fa-shopping-cart"></span> &nbsp;0</a>
                            {else}
                                <a href="cart.php?a=checkout" class="cbtn cbtn-alt top-right-button hidden-mobile pull-right" style="padding: 0 10px;" title="{$cartitems} Items"><span
                                            class="fa fa-shopping-cart"></span> &nbsp;{$cartitems}</a>
                            {/if}
                        {else}
                            <a href="{$WEB_ROOT}/clientarea.php" class="hidden-mobile">Log In</a>
                            <a href="{$WEB_ROOT}/index.php" class="cbtn top-right-button">Get Started</a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="page-wrapper">
        <div class="main">
            <div class="wrapper ">
                <div class="row">
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

                    <div class="page-content {if $withSidebar eq 'false'}without-sidebar{/if} {if $withBG eq 'false'}no-bg{/if}">
