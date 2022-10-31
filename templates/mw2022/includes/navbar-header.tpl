{if $loggedin}
    <li menuitemname="Home" class="" id="Primary_Navbar-Home"><a href="{$WEB_ROOT}/clientarea.php">{$LANG.MW_dashboard}</a></li>
    <li menuitemname="Services" class="" id="Primary_Navbar-Services">
        <a class="menu-more" href="javascript:;">{$LANG.MW_services} &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="My Services" id="Primary_Navbar-Services-My_Services"><a href="{$WEB_ROOT}/clientarea.php?action=services">{$LANG.MW_services} </a></li>
            <li menuitemname="My Licenses" id="Primary_Navbar-Services-My_Licenses"><a href="{$WEB_ROOT}/clientarea.php?action=products&amp;module=licensing">{$LANG.MW_myServices}</a></li>
            <li menuitemname="Order New Services" id="Primary_Navbar-Services-Order_New_Services"><a href="{$WEB_ROOT}/cart.php">{$LANG.MW_orderNewServices}</a></li>
            <li menuitemname="View Available Addons" id="Primary_Navbar-Services-View_Available_Addons"><a href="{$WEB_ROOT}/cart.php?gid=addons">{$LANG.MW_viewAvailableAddons}</a></li>
        </ul>
    </li>
    <li menuitemname="Domains" class="" id="Primary_Navbar-Domains">
        <a class="menu-more" href="javascript:;">{$LANG.MW_domains} &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="My Domains" id="Primary_Navbar-Domains-My_Domains"><a href="{$WEB_ROOT}/clientarea.php?action=domains">{$LANG.MW_myDomains}</a></li>
            <li menuitemname="Renew Domains" id="Primary_Navbar-Domains-Renew_Domains"><a href="{$WEB_ROOT}/cart.php?gid=renewals">{$LANG.MW_renewDomains}</a></li>
            <li menuitemname="Register a New Domain" id="Primary_Navbar-Domains-Register_a_New_Domain"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=register">{$LANG.MW_registerANewDomain}</a></li>
            <li menuitemname="Transfer a Domain to Us" id="Primary_Navbar-Domains-Transfer_a_Domain_to_Us"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=transfer">{$LANG.MW_transferDomainToUs}</a></li>
        </ul>
    </li>
    <li menuitemname="Billing" class="" id="Primary_Navbar-Billing">
        <a class="menu-more" href="javascript:;">{$LANG.MW_billing} &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="My Invoices" id="Primary_Navbar-Billing-My_Invoices"><a href="{$WEB_ROOT}/clientarea.php?action=invoices">{$LANG.MW_myInvoinces}</a></li>
            <li menuitemname="My Quotes" id="Primary_Navbar-Billing-My_Quotes"><a href="{$WEB_ROOT}/clientarea.php?action=quotes">{$LANG.MW_myQuotes}</a></li>
            <li menuitemname="Mass Payment" id="Primary_Navbar-Billing-Mass_Payment"><a href="{$WEB_ROOT}/clientarea.php?action=masspay&amp;all=true">{$LANG.MW_massPayment}</a></li>
            <li menuitemname="Manage Credit Card" id="Primary_Navbar-Billing-Manage_Credit_Card"><a href="{$WEB_ROOT}/clientarea.php?action=creditcard">{$LANG.MW_manageCC}</a></li>
            <li menuitemname="Add Funds" id="Primary_Navbar-Billing-Add_Funds"><a href="{$WEB_ROOT}/clientarea.php?action=addfunds">{$LANG.MW_addFunds}</a></li>
        </ul>
    </li>
    <li menuitemname="Support" class="" id="Primary_Navbar-Support">
        <a class="menu-more" href="javascript:;">{$LANG.MW_support} &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="Tickets" id="Primary_Navbar-Support-Tickets"><a href="{$WEB_ROOT}/supporttickets.php">{$LANG.MW_tickets}</a></li>
            <li menuitemname="Open Ticket" id="Primary_Navbar-Open_Ticket" class="{if $filename eq 'submitticket' AND $smarty.get eq false}current{/if}">
                <a href="{$WEB_ROOT}/submitticket.php">
                    {$LANG.MW_openTicket}
                </a>
            </li>
{*            <li menuitemname="Announcements" id="Primary_Navbar-Support-Announcements"><a href="{$WEB_ROOT}/index.php?rp=/announcements">Announcements</a></li>*}
{*            <li menuitemname="Knowledgebase" id="Primary_Navbar-Support-Knowledgebase"><a href="{$WEB_ROOT}/index.php?rp=/knowledgebase">Knowledgebase</a></li>*}
{*            <li menuitemname="Downloads" id="Primary_Navbar-Support-Downloads"><a href="{$WEB_ROOT}/index.php?rp=/download">Downloads</a></li>*}
{*            <li menuitemname="Network Status" id="Primary_Navbar-Support-Network_Status"><a href="{$WEB_ROOT}/serverstatus.php">Network Status</a></li>*}
        </ul>
    </li>
{else}
    <li menuitemname="Home" class="" id="Primary_Navbar-Home"><a href="{$WEB_ROOT}/index.php">{$LANG.MW_home}</a></li>
    <li menuitemname="Store" class="" id="Primary_Navbar-Store">
        <a class="menu-more" href="javascript:;">{$LANG.MW_store} &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="Browse Products Services" id="Primary_Navbar-Store-Browse_Products_Services"><a href="{$WEB_ROOT}/cart.php">{$LANG.MW_browseAll}</a></li>
            <li menuitemname="Hosting" id="Primary_Navbar-Store-Hosting"><a href="{$WEB_ROOT}/cart.php?gid=1">{$LANG.MW_hosting}</a></li>
            <li menuitemname="Modules" id="Primary_Navbar-Store-Modules"><a href="{$WEB_ROOT}/cart.php?gid=2">{$LANG.MW_Modules}</a></li>
            <li menuitemname="Support" id="Primary_Navbar-Store-Support"><a href="{$WEB_ROOT}/cart.php?gid=3">{$LANG.MW_support}</a></li>
            <li menuitemname="License" id="Primary_Navbar-Store-License"><a href="{$WEB_ROOT}/cart.php?gid=4">{$LANG.MW_license}</a></li>
            <li menuitemname="Register a New Domain" id="Primary_Navbar-Store-Register_a_New_Domain"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=register">{$LANG.MW_registeraNewDomain}</a></li>
            <li menuitemname="Transfer a Domain to Us" id="Primary_Navbar-Store-Transfer_a_Domain_to_Us"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=transfer">{$LANG.MW_transferDomainToUs}</a></li>
        </ul>
    </li>
    <li menuitemname="Contact Us" class="" id="Primary_Navbar-Contact_Us"><a href="https://microweber.com/contact-us">{$LANG.MW_contactUs}</a></li>
{/if}