{assign var="navcat" value="false"}

{if $smarty.get.action eq 'services' OR {$filename eq 'clientarea' AND $smarty.get.action eq 'productdetails'}}
    {assign var="navcat" value="websites"}
{/if}

{if {$smarty.get.action eq 'products' AND $smarty.get.module eq 'licensing' AND $filename eq 'clientarea'}}
    {assign var="navcat" value="addons"}
{/if}

{if $filename eq 'cart'}
    {assign var="navcat" value="ordernewservices"}
{/if}

{if {$filename eq 'clientarea' AND $smarty.get.action eq 'domains'} OR {$filename eq 'cart' AND $smarty.get.gid eq 'renewals'} OR {$filename eq 'cart' AND $smarty.get.domain eq 'register'} OR {$filename eq 'cart' AND $smarty.get.domain eq 'transfer'} OR {$filename eq 'clientarea' AND $smarty.get.action eq 'domaindetails'}}
    {assign var="navcat" value="domains"}
{/if}

{if $smarty.get.action eq 'invoices' OR $smarty.get.action eq 'quotes' OR $smarty.get.action eq 'masspay' OR $smarty.get.action eq 'creditcard' OR $smarty.get.action eq 'addfunds'}
    {assign var="navcat" value="billing"}
{/if}

{if $filename eq 'supporttickets' OR $smarty.get.rp eq '/knowledgebase' OR $smarty.get.rp eq '/download' OR $filename eq 'serverstatus' OR $filename eq 'submitticket' OR $filename eq 'viewticket'}
    {assign var="navcat" value="support"}
{/if}

{if $filename eq 'affiliates'}
    {assign var="navcat" value="affiliates"}
{/if}

{if $filename eq 'clientarea' AND $navcat eq 'false'}
    {assign var="navcat" value="home"}
{/if}

{if $loggedin}
    <li menuitemname="Home" class="{if $navcat eq 'home'}active{/if}" id="Primary_Navbar-Home">
        <a href="{$WEB_ROOT}/clientarea.php">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/3.svg"/></span>
            </div>
            Dashboard
        </a>
    </li>
    <li class="{if $navcat eq 'websites'}active{/if}" menuitemname="My Services" id="Primary_Navbar-Services-My_Services">
        <a href="{$WEB_ROOT}/clientarea.php?action=services">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/1.svg"/></span>
            </div>
            My Websites
        </a>
    </li>
    <li class="{if $navcat eq 'addons'}active{/if}" menuitemname="My Licenses" id="Primary_Navbar-Services-My_Licenses">
        <a href="{$WEB_ROOT}/clientarea.php?action=products&amp;module=licensing">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/12.svg"/></span>
            </div>
            Add-ons
        </a>
    </li>

    <li menuitemname="Store" class="{if $navcat eq 'ordernewservices'}active{/if}" id="Primary_Navbar-Store">
        <a class="menu-more" href="#">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/15.svg"/></span>
            </div>
            Store &nbsp;<b class="caret"></b>
        </a>
        <ul>
            <li menuitemname="License" id="Primary_Navbar-Store-License"><a href="{$WEB_ROOT}/">Templates</a></li>
            <li menuitemname="Hosting" id="Primary_Navbar-Store-Hosting"><a href="{$WEB_ROOT}/">Hosting</a></li>
            <li menuitemname="Modules" id="Primary_Navbar-Store-Modules"><a href="{$WEB_ROOT}/">Modules</a></li>
            <li menuitemname="License" id="Primary_Navbar-Store-License"><a href="{$WEB_ROOT}/">License</a></li>
            <li menuitemname="Support" id="Primary_Navbar-Store-Support"><a href="{$WEB_ROOT}/">Support</a></li>
        </ul>
    </li>

    <li menuitemname="Domains" class="{if $navcat eq 'domains'}active{/if}" id="Primary_Navbar-Domains">
        <a class="menu-more" href="javascript:;">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/14.svg"/></span>
            </div>
            Domains &nbsp;{if $navcat neq 'domains'}<b class="caret"></b>{/if}
        </a>
        <ul>
            <li menuitemname="My Domains" id="Primary_Navbar-Domains-My_Domains" class="{if $filename eq 'clientarea' AND $smarty.get.action eq 'domains'}current{/if}">
                <a href="{$WEB_ROOT}/clientarea.php?action=domains">
                    My Domains
                </a>
            </li>
            <li menuitemname="Renew Domains" id="Primary_Navbar-Domains-Renew_Domains" class="{if $filename eq 'cart' AND $smarty.get.gid eq 'renewals'}current{/if}">
                <a href="{$WEB_ROOT}/cart.php?gid=renewals">
                    Renew Domains
                </a>
            </li>
            <li menuitemname="Register a New Domain" id="Primary_Navbar-Domains-Register_a_New_Domain" class="{if $filename eq 'cart' AND $smarty.get.a eq 'add' AND $smarty.get.domain eq 'register'}current{/if}">
                <a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=register">
                    Register a New Domain
                </a>
            </li>
            <li menuitemname="Transfer a Domain to Us" id="Primary_Navbar-Domains-Transfer_a_Domain_to_Us" class="{if $filename eq 'cart' AND $smarty.get.a eq 'add' AND $smarty.get.domain eq 'transfer'}current{/if}">
                <a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=transfer">
                    Transfer Domains to Us
                </a>
            </li>
        </ul>
    </li>
    <li menuitemname="Billing" class="{if $navcat eq 'billing'}active{/if}" id="Primary_Navbar-Billing">
        <a class="menu-more" href="javascript:;">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/2.svg"/></span>
            </div>
            Billing &nbsp;{if $navcat neq 'billing'}<b class="caret"></b>{/if}
        </a>
        <ul>
            <li menuitemname="My Invoices" id="Primary_Navbar-Billing-My_Invoices"  class="{if $filename eq 'clientarea' AND $smarty.get.action eq 'invoices'}current{/if}">
                <a href="{$WEB_ROOT}/clientarea.php?action=invoices">
                    My Invoices
                </a>
            </li>
            <li menuitemname="Mass Payment" id="Primary_Navbar-Billing-Mass_Payment" class="{if $filename eq 'clientarea' AND $smarty.get.action eq 'masspay' AND $smarty.get.all eq 'true'}current{/if}">
                <a href="{$WEB_ROOT}/clientarea.php?action=masspay&amp;all=true">
                    Mass Payment
                </a>
            </li>
            <li menuitemname="Manage Credit Card" id="Primary_Navbar-Billing-Manage_Credit_Card" class="{if $filename eq 'clientarea' AND $smarty.get.action eq 'creditcard'}current{/if}">
                <a href="{$WEB_ROOT}/clientarea.php?action=creditcard">
                    Manage Credit Card
                </a>
            </li>
            <li menuitemname="Add Funds" id="Primary_Navbar-Billing-Add_Funds" class="{if $filename eq 'clientarea' AND $smarty.get.action eq 'addfunds'}current{/if}">
                <a href="{$WEB_ROOT}/clientarea.php?action=addfunds">
                    Add Funds
                </a>
            </li>
        </ul>
    </li>
    <li menuitemname="Support" class="{if $navcat eq 'support'}active{/if}" id="Primary_Navbar-Support">
        <a class="menu-more" href="javascript:;">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/9.svg"/></span>
            </div>
            Support &nbsp;{if $navcat neq 'support'}<b class="caret"></b>{/if}
        </a>
        <ul>
            <li menuitemname="Open Ticket" id="Primary_Navbar-Open_Ticket" class="{if $filename eq 'submitticket' AND $smarty.get eq false}current{/if}">
                <a href="{$WEB_ROOT}/submitticket.php">
                    Open Ticket
                </a>
            </li>
            <li menuitemname="Tickets" id="Primary_Navbar-Support-Tickets" class="{if $filename eq 'supporttickets' AND $smarty.get eq false}current{/if}">
                <a href="{$WEB_ROOT}/supporttickets.php">
                    Tickets
                </a>
            </li>
        </ul>
    </li>
    <li menuitemname="Affiliates" class="{if $navcat eq 'affiliates'}active{/if}" id="Primary_Navbar-Affiliates">
        <a href="{$WEB_ROOT}/affiliates.php">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/8.svg"/></span>
            </div>
            Affiliate program
        </a>
    </li>
{else}
    <li menuitemname="Home" class="" id="Primary_Navbar-Home">
        <a href="{$WEB_ROOT}/index.php">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/11.svg"/></span>
            </div>
            Dashboard
        </a>
    </li>
    <li menuitemname="Store" class="" id="Primary_Navbar-Store">
        <a class="menu-more" href="javascript:;">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/1.svg"/></span>
            </div>
            Store &nbsp;<b class="caret"></b>
        </a>
        <ul>
            <li menuitemname="License" id="Primary_Navbar-Store-License"><a href="{$WEB_ROOT}/">Templates</a></li>
            <li menuitemname="Hosting" id="Primary_Navbar-Store-Hosting"><a href="{$WEB_ROOT}/">Hosting</a></li>
            <li menuitemname="Modules" id="Primary_Navbar-Store-Modules"><a href="{$WEB_ROOT}/">Modules</a></li>
            <li menuitemname="License" id="Primary_Navbar-Store-License"><a href="{$WEB_ROOT}/">License</a></li>
            <li menuitemname="Support" id="Primary_Navbar-Store-Support"><a href="{$WEB_ROOT}/">Support</a></li>
            <li menuitemname="Register a New Domain" id="Primary_Navbar-Store-Register_a_New_Domain"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=register">Register a New Domain</a></li>
            <li menuitemname="Transfer a Domain to Us" id="Primary_Navbar-Store-Transfer_a_Domain_to_Us"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=transfer">Transfer Domains to Us</a></li>
        </ul>
    </li>
    <li menuitemname="Affiliates" class="" id="Primary_Navbar-Affiliates">
        <a href="{$WEB_ROOT}/affiliates.php">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/8.svg"/></span>
            </div>
            Affiliate program
        </a>
    </li>
    <li menuitemname="Contact Us" class="" id="Primary_Navbar-Contact_Us">
        <a href="{$WEB_ROOT}/contact.php">
            <div class="svg-icon">
                <span class="ct-svg"><img svg-src="{$WEB_ROOT}/templates/{$template}/img/im/profile/1.svg"/></span>
            </div>
            Contact Us
        </a>
    </li>
{/if}