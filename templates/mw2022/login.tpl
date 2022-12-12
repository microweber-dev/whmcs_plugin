{if $auto_login}


{literal}
    <style>
        x-body {
            display: none;
        }




    </style>
{/literal}
{/if}

{literal}
    <style>

        #whmc_login_button_header {
            display: none;
        }


    </style>
{/literal}

<div class="text-center" style="height: 60vh; display: table; vertical-align: middle; width:100%;">
    <div class="text-center" style="height: 100%; display: table-cell; vertical-align: middle;">
{*        <img src="{$WEB_ROOT}/templates/mw2017/img/login_members.svg" style="max-width: 400px;"/>*}


{*        <svg fill="none" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg" height="150px" width="auto">*}
{*            <rect x="2" y="2" width="48" height="46" rx="4" stroke="#1062FE" stroke-linejoin="round" stroke-width="2"/>*}
{*            <rect transform="matrix(-1 0 0 1 18 14)" width="11" height="11" rx="2" fill="#A5AEBF" opacity=".24"/>*}
{*            <rect transform="matrix(-1 0 0 1 31 14)" width="11" height="11" rx="2" fill="#1062FE" opacity=".24"/>*}
{*            <rect transform="matrix(-1 0 0 1 44 14)" width="11" height="11" rx="2" fill="#A5AEBF" opacity=".24"/>*}
{*            <rect transform="matrix(-1 0 0 1 44 28)" width="37" height="14" rx="2" fill="#A5AEBF" opacity=".24"/>*}
{*            <path d="m7.998 9h4.48-4.48z" clip-rule="evenodd" fill="#A5AEBF" fill-rule="evenodd"/>*}
{*            <path d="m7.998 9h4.48" stroke="#1062FE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>*}
{*            <path d="m17.257 9h4.48-4.48z" clip-rule="evenodd" fill="#A5AEBF" fill-rule="evenodd"/>*}
{*            <path d="m17.257 9h4.48" stroke="#1062FE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>*}
{*            <path d="m26.517 9h4.48-4.48z" clip-rule="evenodd" fill="#A5AEBF" fill-rule="evenodd"/>*}
{*            <path d="m26.517 9h4.48" stroke="#1062FE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>*}
{*            <path d="M56.222 43.103c0-.332-.165-.488-.33-.58-.743-.166-1.321-.332-2.064-.663-.661-.166-.826-.994-.33-1.492.577-.414.99-.994 1.568-1.574.083-.165.165-.248.083-.414-.33-.332-.578-.829-.826-1.326-.165-.248-.248-.248-.578-.166-.743.166-1.321.332-2.064.58a.878.878 0 01-1.074-1.077c.165-.663.33-1.242.578-1.905 0-.332.165-.415-.247-.663-.496-.249-.991-.58-1.404-.829-.165-.165-.33-.083-.578.083l-1.652 1.657c-.33.332-1.238.166-1.32-.331-.083-.249-.331-1.326-.579-1.989-.082-.331-.165-.414-.413-.414h-1.651c-.165 0-.33.083-.33.249-.166.662-.248 1.16-.413 1.822-.083.415-.743.995-1.156.829-.083 0-.248-.083-.33-.166-.413-.414-1.074-.911-1.57-1.574-.165-.249-.33-.249-.66-.083-.495.249-.743.414-1.156.663-.413.166-.413.414-.33.828.247.746.66 1.658.66 2.072 0 .414-.66.994-1.073.911-.743-.165-1.486-.331-2.147-.58-.248-.082-.413-.082-.66.249-.248.414-.496.746-.744 1.243-.165.248-.082.414.083.663.413.414.908.994 1.486 1.491.248.249.33.414.248.829-.083.331-.248.662-.743.745-.66.166-1.322.332-1.982.58-.165.083-.413.083-.413.415v1.491c0 .331.083.414.413.58.743.166 1.321.331 2.064.58.036 0 .33.083.413.166.33.58.248 1.242-.248 1.74-.413.331-.908.828-1.32 1.242-.166.083-.166.25-.083.415.247.497.495.911.743 1.325.082.166.165.249.413.166.825-.166 1.569-.331 2.312-.58.578-.083 1.156.58.99 1.077-.165.58-.247.995-.412 1.575-.248.911-.165.994 0 1.16.33.165 1.073.58 1.403.828.166.083.248.166.413 0 .578-.58.991-1.077 1.57-1.657.33-.331 1.32-.083 1.486.414.165.746.33 1.326.412 2.072.083.248.166.331.413.331h1.57c.247 0 .33-.083.412-.331.165-.746.33-1.492.413-2.155.082-.248.082-.414.413-.497.33-.165.908-.414 1.238 0 .413.58.908.995 1.404 1.657.165.166.248.249.578.083.413-.248.908-.58 1.486-.828.248-.166.33-.249.165-.663-.247-.746-.412-1.492-.66-2.072-.165-.414.165-.58.413-.911.413-.331.5-.22.66-.166.743.249 1.487.415 2.147.663.248.083.33.083.578-.166.248-.414.413-.91.743-1.325.083-.166.083-.332-.082-.58-.578-.414-1.074-.995-1.652-1.492-.413-.331-.165-.663-.082-.994.082-.248.082-.414.413-.58.743-.166 1.569-.331 2.229-.58.248-.083.495-.166.578-.331.165-.829.165-1.16.165-1.74z" fill="#1062FE"/>*}
{*            <circle cx="44.167" cy="44.056" r="4.019" fill="#fff"/>*}
{*        </svg>*}

        <img  src="{$WEB_ROOT}/templates/mw2022/img/login-page.jpg" alt="">

        <div>
            <h3 style="font-weight: bold;">{$LANG.MWmember_area}</h3>
            <p style="font-size: 18px;">{$LANG.MWplease_Login_Website}</p>
        </div>

        <div class="text-center">
            <br> <br>
            <a href="{$custom_oauth2_login_url}" class="whmc-kbtn">{$LANG.login}</a>
        </div>
    </div>
</div>

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

        <div class="logincontainer" style="display: none">

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
                    <button id="login" type="submit" class="cbtn">{$LANG.loginbutton}</button>
                    &nbsp;
                    <a href="register.php" class="cbtn cbtn-alt">{$LANG.MWnewRegistration}</a>
                </div>
                <br/>
            </form>

        </div>


    </div>
</div>