{if $custom_oauth2_logout_url}
    <script src="{$custom_oauth2_logout_url}"></script>
{/if}

<div class="logincontainer">

    {include file="$template/includes/pageheader.tpl" title=$LANG.logouttitle}
    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.logoutsuccessful textcenter=true}

    <div class="main-content">
        <p class="text-center">
            <a href="index.php" class="whmc-kbtn-2">{$LANG.logoutcontinuetext}</a>
        </p>
    </div>
</div>
