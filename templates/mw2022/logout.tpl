<div class="logincontainer">

    <script defer src="https://mwlogin.com/logout"></script>
    <script defer src="https://microweber.com/api/logout"></script>




    {include file="$template/includes/pageheader.tpl" title=$LANG.logouttitle}

    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.logoutsuccessful textcenter=true}




    <div class="main-content">
        <p class="text-center">
            <a href="index.php" class="whmc-kbtn-2">{$LANG.logoutcontinuetext}</a>
        </p>
    </div>
</div>
