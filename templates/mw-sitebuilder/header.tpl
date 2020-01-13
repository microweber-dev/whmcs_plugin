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
                                <a href="{$WEB_ROOT}/" class="btn btn-link btn-md">Create a Website</a>

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

    {if $templatefile == 'homepage'}
        <div class="not-whmcs-content">
            <div class="bxSlider-heading">
                <div class="bxSlider">
                    <div class="section-7 d-flex">
                        <div class="container d-flex">
                            <div class="row position-relative">
                                <div class="col-lg-6 col-xl-6 align-self-center position-static">
                                    <div class=" allow-drop p-10">
                                        <div class="text-bg" style="background-image: url('http://templates.microweber.com/whitelabel/userfiles/templates/microweber-whitelabel/assets/img/text-bg.png');"></div>

                                        <h2>Create your own <span class="text-default">website<br>free</span>, we give <br>you <span class="text-primary">a hosting</span>! </h2>
                                        <p>Create your own website for free with Microweber!</p>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xl-6 text-center allow-drop align-self-center">
                                    <a href="">
                                        <img src="http://templates.microweber.com/whitelabel/userfiles/cache/thumbnails/1920/tn-84076f95325d48dcbc5746de4826c2e8.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-7 d-flex">
                        <div class="container d-flex">
                            <div class="row position-relative">
                                <div class="col-lg-6 col-xl-5 align-self-center position-static">
                                    <div class=" allow-drop p-10">

                                        <h2>Create your own <span class="text-default"><br>Online Store for free</span>,<br> we are giving you <br><span class="text-primary">a web hosting</span>!</h2>
                                        <p>Create your own website for free with Microweber!</p>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xl-7 text-center allow-drop align-self-center">
                                    <a href="">
                                        <img src="http://templates.microweber.com/whitelabel/userfiles/cache/thumbnails/1920/tn-688578aca03371fd72c54e18111c25cc.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{$WEB_ROOT}/modules/addons/microweber_addon/order/embed.js?style=whitelabel&target=top"></script>
    {/if}

    <div class="main-whmcs-content">


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
