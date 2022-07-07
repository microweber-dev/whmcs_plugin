
{literal}
<script>
    $(document).ready(function () {
        var userAvatar = $('#header-meta .user-bar .image').css('background-image');
        if (userAvatar) {
            userAvatar = userAvatar.replace('url(', '').replace(')', '').replace(/\"/gi, "");
            if (userAvatar) {
                $('#user-avatar-sidebar-default').hide();
                $('#user-avatar-sidebar').css('background-image', 'url(' + userAvatar + ')');
                $('#user-avatar-sidebar').show();
            }
        }
    });

</script>

{/literal}




<div class="sidebar">
    <div class="profile-sidebar-top">
        <div class="profile-sidebar-image">
            <span id="user-avatar-sidebar" class="whm-profile-img img-circle" style="display:none;background-image: url('{$WEB_ROOT}/templates/{$template}/img/avatar.jpg');"></span>

            <svg id="user-avatar-sidebar-default" class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63.9 64" x="0px" y="0px" width="64px" height="64px">
                <path class="svg-icon-outline-s dashed-13 stroke" d="M53.78,53.92a31.2,31.2,0,0,1-44,0A30,30,0,0,1,1,32.21,31,31,0,0,1,9.77,10.08a31.2,31.2,0,0,1,44,0,30.9,30.9,0,0,1,0,43.84Z"></path>
                <path class="svg-icon-prime-l" d="M47.37,11.22,44.15,9.38a.91.91,0,0,0-.65-.07L30.13,12.84a.74.74,0,0,0-.33.17L16.14,24.67a.76.76,0,0,0-.28.59s0,16.1,0,20.79c0,5.39,14.42,8.31,16.12,8.61l.15,0a.87.87,0,0,0,.71-.37c.51-.75,12.58-18.45,12.69-23.61L47.78,12A.78.78,0,0,0,47.37,11.22Z"></path>
                <path class="svg-icon-prime" d="M47.53,11.29a.88.88,0,0,0-.72-.14L34.09,14.7a.88.88,0,0,0-.35.17l-14,11.62a.81.81,0,0,0-.18.65s0,16.18,0,20.87c0,5.45,13.14,6.73,14.68,6.87h.08a.88.88,0,0,0,.65-.29C36.43,52.9,47.85,37.73,47.85,32.7V11.91A.78.78,0,0,0,47.53,11.29Z"></path>
                <path class="svg-icon-i" d="M34.5,26a6.69,6.69,0,0,0-3,5.24c0,1.93,1.35,2.72,3,1.76a6.67,6.67,0,0,0,3-5.24C37.5,25.81,36.16,25,34.5,26Zm-2.28,9.54c-2,1.71-4.17,4.15-4.17,6v2.19L41,36.23V34.05c0-1.85-2.15-1.81-4.18-1.18a6.11,6.11,0,0,1-2.29,2.73,1.79,1.79,0,0,1-2.29-.08Z"></path>
            </svg>
        </div>


        <span class="profile-sidebar-name">
                {if $loggedin}
                    {if $loggedinuser.firstname neq ''}{$loggedinuser.firstname}{else}{$loggedinuser.email}{/if}
                {else}
                    Guest
                {/if}
            </span>
    </div>

    <br>
    <div class="profile-sidebar">


        <div>
            <ul class="navigation">
                {include file="$template/includes/navbar-sidebar.tpl"}
            </ul>
        </div>
    </div>
</div>

