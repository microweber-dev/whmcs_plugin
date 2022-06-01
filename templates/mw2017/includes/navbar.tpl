{*{foreach $navbar as $item}*}
{*<li menuItemName="{$item->getName()}" class="{if $item->getClass()} {$item->getClass()}{/if}" id="{$item->getId()}">*}
{*<a {if $item->hasChildren()}class="menu-more" href="javascript:;"{else}href="{$item->getUri()}"{/if}{if $item->getAttribute('target')} target="{$item->getAttribute('target')}"{/if}>*}
{*{if $item->hasIcon()}<i class="{$item->getIcon()}"></i>&nbsp;{/if}*}
{*{$item->getLabel()}*}
{*{if $item->hasBadge()}&nbsp;<span class="badge">{$item->getBadge()}</span>{/if}*}
{*{if $item->hasChildren()}&nbsp;<b class="caret"></b>{/if}*}
{*</a>*}
{*{if $item->hasChildren()}*}
{*<ul>*}
{*{foreach $item->getChildren() as $childItem}*}
{*<li menuItemName="{$childItem->getName()}"{if $childItem->getClass()} class="{$childItem->getClass()}"{/if} id="{$childItem->getId()}">*}
{*<a href="{$childItem->getUri()}"{if $childItem->getAttribute('target')} target="{$childItem->getAttribute('target')}"{/if}>*}
{*{if $childItem->hasIcon()}<i class="{$childItem->getIcon()}"></i>&nbsp;{/if}*}
{*{$childItem->getLabel()}*}
{*{if $childItem->hasBadge()}&nbsp;<span class="badge">{$childItem->getBadge()}</span>{/if}*}
{*</a>*}
{*</li>*}
{*{/foreach}*}
{*</ul>*}
{*{/if}*}
{*</li>*}
{*{/foreach}*}

{if $loggedin}
    <li menuitemname="Home" class="" id="Primary_Navbar-Home"><a href="{$WEB_ROOT}/clientarea.php">Home</a></li>
    <li menuitemname="Services" class="" id="Primary_Navbar-Services">
        <a class="menu-more" href="javascript:;">Services &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="My Services" id="Primary_Navbar-Services-My_Services"><a href="{$WEB_ROOT}/clientarea.php?action=services">My Services</a></li>
            <li menuitemname="My Licenses" id="Primary_Navbar-Services-My_Licenses"><a href="{$WEB_ROOT}/clientarea.php?action=products&amp;module=licensing">My Licenses</a></li>
            <li menuitemname="Order New Services" id="Primary_Navbar-Services-Order_New_Services"><a href="{$WEB_ROOT}/cart.php">Order New Services</a></li>
            <li menuitemname="View Available Addons" id="Primary_Navbar-Services-View_Available_Addons"><a href="{$WEB_ROOT}/cart.php?gid=addons">View Available Addons</a></li>
        </ul>
    </li>
    <li menuitemname="Domains" class="" id="Primary_Navbar-Domains">
        <a class="menu-more" href="javascript:;">Domains &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="My Domains" id="Primary_Navbar-Domains-My_Domains"><a href="{$WEB_ROOT}/clientarea.php?action=domains">My Domains</a></li>
            <li menuitemname="Renew Domains" id="Primary_Navbar-Domains-Renew_Domains"><a href="{$WEB_ROOT}/cart.php?gid=renewals">Renew Domains</a></li>
            <li menuitemname="Register a New Domain" id="Primary_Navbar-Domains-Register_a_New_Domain"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=register">Register a New Domain</a></li>
            <li menuitemname="Transfer a Domain to Us" id="Primary_Navbar-Domains-Transfer_a_Domain_to_Us"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=transfer">Transfer Domains to Us</a></li>
            <li menuitemname="Domain Search" id="Primary_Navbar-Domains-Domain_Search"><a href="{$WEB_ROOT}/domainchecker.php">Domain Search</a></li>
        </ul>
    </li>
    <li menuitemname="Billing" class="" id="Primary_Navbar-Billing">
        <a class="menu-more" href="javascript:;">Billing &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="My Invoices" id="Primary_Navbar-Billing-My_Invoices"><a href="{$WEB_ROOT}/clientarea.php?action=invoices">My Invoices</a></li>
            <li menuitemname="My Quotes" id="Primary_Navbar-Billing-My_Quotes"><a href="{$WEB_ROOT}/clientarea.php?action=quotes">My Quotes</a></li>
            <li menuitemname="Mass Payment" id="Primary_Navbar-Billing-Mass_Payment"><a href="{$WEB_ROOT}/clientarea.php?action=masspay&amp;all=true">Mass Payment</a></li>
            <li menuitemname="Manage Credit Card" id="Primary_Navbar-Billing-Manage_Credit_Card"><a href="{$WEB_ROOT}/clientarea.php?action=creditcard">Manage Credit Card</a></li>
            <li menuitemname="Add Funds" id="Primary_Navbar-Billing-Add_Funds"><a href="{$WEB_ROOT}/clientarea.php?action=addfunds">Add Funds</a></li>
        </ul>
    </li>
    <li menuitemname="Support" class="" id="Primary_Navbar-Support">
        <a class="menu-more" href="javascript:;">Support &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="Tickets" id="Primary_Navbar-Support-Tickets"><a href="{$WEB_ROOT}/supporttickets.php">Tickets</a></li>
            <li menuitemname="Announcements" id="Primary_Navbar-Support-Announcements"><a href="{$WEB_ROOT}/index.php?rp=/announcements">Announcements</a></li>
            <li menuitemname="Knowledgebase" id="Primary_Navbar-Support-Knowledgebase"><a href="{$WEB_ROOT}/index.php?rp=/knowledgebase">Knowledgebase</a></li>
            <li menuitemname="Downloads" id="Primary_Navbar-Support-Downloads"><a href="{$WEB_ROOT}/index.php?rp=/download">Downloads</a></li>
            <li menuitemname="Network Status" id="Primary_Navbar-Support-Network_Status"><a href="{$WEB_ROOT}/serverstatus.php">Network Status</a></li>
        </ul>
    </li>
    <li menuitemname="Open Ticket" class="" id="Primary_Navbar-Open_Ticket"><a href="{$WEB_ROOT}/submitticket.php">Open Ticket</a></li>
    <li menuitemname="Affiliates" class="" id="Primary_Navbar-Affiliates"><a href="{$WEB_ROOT}/affiliates.php">Affiliates</a></li>
{else}
    <li menuitemname="Home" class="" id="Primary_Navbar-Home"><a href="{$WEB_ROOT}/index.php">Home</a></li>
    <li menuitemname="Store" class="" id="Primary_Navbar-Store">
        <a class="menu-more" href="javascript:;">Store &nbsp;<b class="caret"></b></a>
        <ul>
            <li menuitemname="Browse Products Services" id="Primary_Navbar-Store-Browse_Products_Services"><a href="{$WEB_ROOT}/cart.php">Browse All</a></li>
            <li menuitemname="Hosting" id="Primary_Navbar-Store-Hosting"><a href="{$WEB_ROOT}/cart.php?gid=1">Hosting</a></li>
            <li menuitemname="Modules" id="Primary_Navbar-Store-Modules"><a href="{$WEB_ROOT}/cart.php?gid=2">Modules</a></li>
            <li menuitemname="Support" id="Primary_Navbar-Store-Support"><a href="{$WEB_ROOT}/cart.php?gid=3">Support</a></li>
            <li menuitemname="License" id="Primary_Navbar-Store-License"><a href="{$WEB_ROOT}/cart.php?gid=4">License</a></li>
            <li menuitemname="Register a New Domain" id="Primary_Navbar-Store-Register_a_New_Domain"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=register">Register a New Domain</a></li>
            <li menuitemname="Transfer a Domain to Us" id="Primary_Navbar-Store-Transfer_a_Domain_to_Us"><a href="{$WEB_ROOT}/cart.php?a=add&amp;domain=transfer">Transfer Domains to Us</a></li>
        </ul>
    </li>
    <li menuitemname="Announcements" class="" id="Primary_Navbar-Announcements"><a href="{$WEB_ROOT}/index.php?rp=/announcements">Announcements</a></li>
    <li menuitemname="Knowledgebase" class="" id="Primary_Navbar-Knowledgebase"><a href="{$WEB_ROOT}/index.php?rp=/knowledgebase">Knowledgebase</a></li>
    <li menuitemname="Network Status" class="" id="Primary_Navbar-Network_Status"><a href="{$WEB_ROOT}/serverstatus.php">Network Status</a></li>
    <li menuitemname="Affiliates" class="" id="Primary_Navbar-Affiliates"><a href="{$WEB_ROOT}/affiliates.php">Affiliates</a></li>
    <li menuitemname="Contact Us" class="" id="Primary_Navbar-Contact_Us"><a href="{$WEB_ROOT}/contact.php">Contact Us</a></li>
{/if}