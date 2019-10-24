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
<body data-phone-cc-input="{$phoneNumberInputStyle}" class=" header-inverse sticky-nav ">
<div class="main">
    {$headeroutput}

    <div class="navigation-holder not-whmcs-content">
        <nav class="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <div class="logo">
                        {if $logo}
                            <a href="{$WEB_ROOT}/index.php"><img src="{$logo}" alt="{$companyname}" style="max-width: 100%;"/></a>
                        {else}
                            <a href="{$WEB_ROOT}/index.php" class="logo logo-text">{$companyname}</a>
                        {/if}
                    </div>

                    <div class="menu" style="max-height: 1002px;">
                        <ul class="list">
                            {include file="$template/includes/navbar.tpl" navbar=$primaryNavbar}
                            {include file="$template/includes/navbar.tpl" navbar=$secondaryNavbar}
                        </ul>
                    </div>

                    <div class="toggle">
                        <a href="javascript:;" class="js-menu-toggle">
                            <span class="mobile-menu-label">
                                <b>Menu</b>
                                <b>Close</b>
                            </span>
                            <span class="mobile-menu-btn">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </a>
                    </div>


                    <ul class="member-nav">
                        <li class="btn-search">
                            <div class="search d-flex">
                                <a href="{$mw_site}/get-started" class="btn btn-link btn-md">Create a Website</a>

                                {if $loggedin}
                                    <div class="nav-item dropdown m-l-10">
                                        <a class="dropdown-toggle btn btn-default-outline btn-md" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">Welcome <strong>{$loggedinuser.firstname}</strong></a>
                                        <div class="dropdown-menu" x-placement="bottom-start">
                                            <a class="dropdown-item" href="/clientarea.php?action=details">Edit Account Details</a>
                                            <a class="dropdown-item" href="/clientarea.php?action=contacts">Contacts/Sub-Accounts</a>
                                            <a class="dropdown-item" href="/clientarea.php?action=changepw">Change Password</a>
                                            <a class="dropdown-item" href="/clientarea.php?action=security">Security Settings</a>
                                            <a class="dropdown-item" href="/clientarea.php?action=emails">Email History</a>
                                            <a class="dropdown-item" href="/logout.php">Logout</a>
                                        </div>
                                    </div>
                                {else}
                                    <div class="nav-item dropdown m-l-10">
                                        <a class="dropdown-toggle btn btn-default-outline btn-md" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">{$LANG.loginbutton}</a>
                                        <div class="dropdown-menu" x-placement="bottom-start">
                                            <a class="dropdown-item" href="/clientarea.php">Login</a>
                                            <a class="dropdown-item" href="/register.php">Register</a>
                                            <a class="dropdown-item" href="/index.php?rp=/password/reset/begin">Forgot Password?</a>
                                        </div>
                                    </div>
                                {/if}
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </div>

    <div class="main-whmcs-content">
        {if $templatefile == 'homepage'}
        {literal}
            <script>window.location.replace(mw_site);</script>
        {/literal}
            <section id="home-banner">
                <div class="container text-center">
                    {if $registerdomainenabled || $transferdomainenabled}
                        <h2>{$LANG.homebegin}</h2>
                        <form method="post" action="domainchecker.php" id="frmDomainHomepage">
                            <input type="hidden" name="transfer"/>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" name="domain" placeholder="{$LANG.exampledomain}" autocapitalize="none" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="{lang key='orderForm.required'}"/>
                                        <span class="input-group-btn">
                                    {if $registerdomainenabled}
                                        <input type="submit" class="btn search{$captcha->getButtonClass($captchaForm)}" value="{$LANG.search}"/>
                                    {/if}
                                            {if $transferdomainenabled}
                                                <input type="submit" id="btnTransfer" class="btn transfer{$captcha->getButtonClass($captchaForm)}" value="{$LANG.domainstransfer}"/>
                                            {/if}
                                </span>
                                    </div>
                                </div>
                            </div>

                            {include file="$template/includes/captcha.tpl"}
                        </form>
                    {else}
                        <h2>{$LANG.doToday}</h2>
                    {/if}
                </div>
            </section>
            <div class="home-shortcuts">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 hidden-sm hidden-xs text-center">
                            <p class="lead">
                                {$LANG.howcanwehelp}
                            </p>
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <ul>
                                {if $registerdomainenabled || $transferdomainenabled}
                                    <li>
                                        <a id="btnBuyADomain" href="domainchecker.php">
                                            <i class="fas fa-globe"></i>
                                            <p>
                                                {$LANG.buyadomain} <span>&raquo;</span>
                                            </p>
                                        </a>
                                    </li>
                                {/if}
                                <li>
                                    <a id="btnOrderHosting" href="cart.php">
                                        <i class="far fa-hdd"></i>
                                        <p>
                                            {$LANG.orderhosting} <span>&raquo;</span>
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a id="btnMakePayment" href="clientarea.php">
                                        <i class="fas fa-credit-card"></i>
                                        <p>
                                            {$LANG.makepayment} <span>&raquo;</span>
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a id="btnGetSupport" href="submitticket.php">
                                        <i class="far fa-envelope"></i>
                                        <p>
                                            {$LANG.getsupport} <span>&raquo;</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        {/if}

        {include file="$template/includes/verifyemail.tpl"}
        {if $templatefile != 'login' AND $templatefile != 'password-reset-container'}
        <section id="main-body">
            <div class="container{if $skipMainBodyContainer}-fluid without-padding{/if}">
                <div class="row">
        {/if}
                    {if !$inShoppingCart && ($primarySidebar->hasChildren() || $secondarySidebar->hasChildren())}
                        {if $primarySidebar->hasChildren() && !$skipMainBodyContainer}
                            <div class="col-md-9 pull-md-right">
                                {include file="$template/includes/pageheader.tpl" title=$displayTitle desc=$tagline showbreadcrumb=true}
                            </div>
                        {/if}
                        <div class="col-md-3 pull-md-left sidebar">
                            {include file="$template/includes/sidebar.tpl" sidebar=$primarySidebar}
                        </div>
                    {/if}
                    <!-- Container for main page display content -->
                    {if $templatefile != 'login' AND $templatefile != 'password-reset-container'}
                    <div class="{if !$inShoppingCart && ($primarySidebar->hasChildren() || $secondarySidebar->hasChildren())}col-md-9 pull-md-right{else}col-xs-12{/if} main-content">
                        {/if}
                        {if !$primarySidebar->hasChildren() && !$showingLoginPage && !$inShoppingCart && $templatefile != 'homepage' && !$skipMainBodyContainer}
                            {include file="$template/includes/pageheader.tpl" title=$displayTitle desc=$tagline showbreadcrumb=true}
                        {/if}
