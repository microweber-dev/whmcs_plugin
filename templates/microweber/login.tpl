<section class="section p-t-200 p-b-200" style="background: #f6fafb;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                {if $logo}
                    <a href="{$WEB_ROOT}/index.php"><img src="{$logo}" alt="{$companyname}" style="max-width: 100%;"/></a>
                {else}
                    <a href="{$WEB_ROOT}/index.php" class="logo logo-text">{$companyname}</a>
                {/if}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="logincontainer{if $linkableProviders} with-social{/if}">

                    {include file="$template/includes/pageheader.tpl" title=$LANG.login desc="{$LANG.restrictedpage}"}

                    {if $incorrect}
                        {include file="$template/includes/alert.tpl" type="error" msg=$LANG.loginincorrect textcenter=true}
                    {elseif $verificationId && empty($transientDataName)}
                        {include file="$template/includes/alert.tpl" type="error" msg=$LANG.verificationKeyExpired textcenter=true}
                    {elseif $ssoredirect}
                        {include file="$template/includes/alert.tpl" type="info" msg=$LANG.sso.redirectafterlogin textcenter=true}
                    {elseif $invalid}
                        {include file="$template/includes/alert.tpl" type="error" msg=$LANG.googleRecaptchaIncorrect textcenter=true}
                    {/if}

                    <div class="providerLinkingFeedback"></div>

                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" action="{$systemurl}dologin.php" class="login-form" role="form">
                                <div class="form-group">
                                    <label for="inputEmail">{$LANG.clientareaemail}</label>
                                    <input type="email" name="username" class="form-control" id="inputEmail" placeholder="{$LANG.enteremail}" autofocus>
                                    <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="password">{$LANG.clientareapassword}</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="{$LANG.clientareapassword}" autocomplete="off">
                                </div>

                                <div class="row m-t-30 m-b-30">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="rememberme" name="rememberme">
                                                <label class="custom-control-label" for="rememberme">{$LANG.loginrememberme}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <a href="{routePath('password-reset-begin')}">{$LANG.forgotpw}</a>
                                    </div>
                                </div>

                                {if $captcha->isEnabled()}
                                    <div class="text-center margin-bottom">
                                        {include file="$template/includes/captcha.tpl"}
                                    </div>
                                {/if}

                                <div class="text-center">
                                    <button id="login" type="submit" class="btn btn-default btn-md">{$LANG.loginbutton}</button>
                                </div>
                            </form>

                        </div>

                        <div class="col-sm-12">
                            {include file="$template/includes/linkedaccounts.tpl" linkContext="login" customFeedback=true}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>