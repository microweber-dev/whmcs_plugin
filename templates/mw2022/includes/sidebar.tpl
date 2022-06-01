<div class="sidebar">
    <div class="profile-sidebar">
        <div class="profile-sidebar-top">
            <div class="profile-sidebar-image">
                <span class="pst-img" style="background-image: url('{$WEB_ROOT}/templates/{$template}/img/avatar.jpg');"></span>
            </div>
            <span class="profile-sidebar-name">
                {if $loggedin}
                    {if $loggedinuser.firstname neq ''}{$loggedinuser.firstname}{else}{$loggedinuser.email}{/if}
                {else}
                    Guest
                {/if}
            </span>
        </div>

        <div>
            <ul class="navigation">
                {include file="$template/includes/navbar-sidebar.tpl"}
            </ul>
        </div>
    </div>
</div>

