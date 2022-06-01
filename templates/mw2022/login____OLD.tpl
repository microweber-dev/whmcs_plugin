{if $auto_login}
    <style>
        x-body {
            display: none;
        }
    </style>
{/if}
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">


        {if $auto_login}
        {literal}
            <noscript>
                $( document ).ready(function() {
                    window.location.href = {/literal}"{$custom_oauth2_login_url}"{literal};
                });

            </noscript>
        {/literal}
        {/if}

        <br>
        <div style="display: none">
        <a href="{$custom_oauth2_login_url}" class="cbtn cbtn-alt">Login to continue</a>

        <br>  <br>
</div>
        <div class="logincontainer" style="display: block">

            {include file="$template/includes/pageheader.tpl" title=$LANG.login desc="{$LANG.restrictedpage}"}
            <br/>
            {if $incorrect}
                {include file="$template/includes/alert.tpl" type="error" msg=$LANG.loginincorrect textcenter=true}
            {elseif $verificationId && empty($transientDataName)}
                {include file="$template/includes/alert.tpl" type="error" msg=$LANG.verificationKeyExpired textcenter=true}
            {elseif $ssoredirect}
                {include file="$template/includes/alert.tpl" type="info" msg=$LANG.sso.redirectafterlogin textcenter=true}
            {/if}

            <form method="post" action="{$systemurl}dologin.php" role="form">
                <div class="subscription-field">
                    <input type="email" name="username" id="inputEmail" placeholder="{$LANG.enteremail}" class="material-field subscription"/>
                </div>
                <br/>
                <div class="subscription-field">
                    <input type="password" name="password" id="inputPassword" placeholder="{$LANG.clientareapassword}" class="material-field subscription" autocomplete="off"/>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="rememberme"/> {$LANG.loginrememberme}
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-6 text-right">
                        <a href="pwreset.php" class="link" style="margin-top: 10px; display: block;">{$LANG.forgotpw}</a>
                    </div>
                </div>
                <br/>

                <div align="center">
                    <button id="login" type="submit" class="cbtn">{$LANG.loginbutton}</button> &nbsp;
                    <a href="register.php" class="cbtn cbtn-alt">New registration</a>
                </div>
                <br/>
            </form>

        </div>


    </div>
</div>