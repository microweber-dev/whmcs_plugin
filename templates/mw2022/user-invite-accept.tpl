<script src="{$BASE_PATH_JS}/PasswordStrength.js"></script>
<script>
    window.langPasswordStrength = "{lang key="pwstrength"}";
    window.langPasswordWeak = "{lang key="pwstrengthweak"}";
    window.langPasswordModerate = "{lang key="pwstrengthmoderate"}";
    window.langPasswordStrong = "{lang key="pwstrengthstrong"}";
    jQuery(document).ready(function() {
        jQuery("#inputPassword").keyup(registerFormPasswordStrengthFeedback);
    });
</script>

<div class="card{if $loggedin || !$invite} mw-750{/if} mb-md-4 mt-md-4">
    <div class="card-body px-sm-5 py-5 text-center">
        {if $invite}
            <h2>
                <i class="fas fa-info fa-2x text-primary pb-4"></i>
                <br>
                {lang key="accountInvite.youHaveBeenInvited" clientName=$invite->getClientName()}
            </h2>

            {include file="$template/includes/flashmessage.tpl"}

            <p>{lang key="accountInvite.givenAccess" senderName=$invite->getSenderName() clientName=$invite->getClientName() ot="<strong>" ct="</strong>"}</p>

            {if $loggedin}
                <p>{lang key="accountInvite.inviteAcceptLoggedIn"}</p>
            {else}
                <p>{lang key="accountInvite.inviteAcceptLoggedOut"}</p>
            {/if}

            {if $loggedin}
                <form method="post" action="{routePath('invite-validate', $invite->token)}">
                    <p>
                        <button type="submit" class="whmc-kbtn-2">
                            {lang key="accountInvite.accept"}
                        </button>
                    </p>
                </form>
            {else}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="invite-box">
                            <h2>{lang key="login"}</h2>
                            <form method="post" action="{routePath('login-validate')}" class="text-left">
                                <div class="form-group">
                                    <label for="inputLoginEmail">{lang key="loginemail"}</label>
                                    <input type="email" name="username" class="form-control" id="inputLoginEmail" placeholder="{lang key="loginemail"}" value="{$formdata.email}">
                                </div>
                                <div class="form-group">
                                    <label for="inputLoginPassword">{lang key="loginpassword"}</label>
                                    <input type="password" name="password" class="form-control" id="inputLoginPassword" placeholder="{lang key="loginpassword"}">
                                </div>
                                {include file="$template/includes/captcha.tpl" captchaForm=$captchaForm containerClass="form-group row" nocache}
                                <div class="text-center">
                                    <button type="submit" class="whmc-kbtn-2{$captcha->getButtonClass($captchaForm)}">
                                        {lang key="login"}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="invite-box">
                            <h2>{lang key="register"}</h2>
                            <form method="post" action="{routePath('invite-validate', $invite->token)}" class="text-left">
                                <div class="form-group">
                                    <label for="inputFirstName">{lang key="clientareafirstname"}</label>
                                    <input type="text" class="form-control" name="firstname" id="inputFirstName" placeholder="{lang key="clientareafirstname"}" value="{$formdata.firstname}">
                                </div>
                                <div class="form-group">
                                    <label for="inputLastName">{lang key="clientarealastname"}</label>
                                    <input type="text" class="form-control" name="lastname" id="inputLastName" placeholder="{lang key="clientarealastname"}" value="{$formdata.lastname}">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">{lang key="loginemail"}</label>
                                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="{lang key="loginemail"}" value="{$formdata.email}">
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="inputPassword">{lang key="loginpassword"}</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" id="inputPassword" data-error-threshold="{$pwStrengthErrorThreshold}" data-warning-threshold="{$pwStrengthWarningThreshold}" placeholder="{lang key="loginpassword"}" autocomplete="off" />
                                        <div class="input-group-append">
                                            <button type="button" class="whmc-kbtn-2 generate-password" data-targetfields="inputPassword">
                                                {lang key="generatePassword.btnShort"}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="password-strength-meter">
                                        <div class="progress mt-3" style="height: 10px;">
                                            <div class="progress-bar bg-success bg-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="passwordStrengthMeterBar">
                                            </div>
                                        </div>
                                        <p class="text-center small text-muted" id="passwordStrengthTextLabel">{lang key="pwstrength"}: {lang key="pwstrengthenter"}</p>
                                    </div>
                                </div>
                                {if $accept_tos}
                                    <div class="form-group text-center">
                                        <label class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="accept" id="accept" />
                                            &nbsp;
                                            {lang key='ordertosagreement'}
                                            <a href="{$tos_url}" target="_blank">{lang key='ordertos'}</a>
                                        </label>
                                    </div>
                                {/if}
                                {include file="$template/includes/captcha.tpl" captchaForm=$captchaFormRegister containerClass="form-group row" nocache}
                                <div class="text-center">
                                    <button type="submit" class="whmc-kbtn-2{$captcha->getButtonClass($captchaFormRegister)}">
                                        {lang key="register"}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            {/if}
        {else}
            <h2>
                <i class="fas fa-times fa-2x text-danger pb-4"></i><br>
                {lang key="accountInvite.notFound"}
            </h2>

            <p class="pt-4">{lang key="accountInvite.contactAdministrator"}</p>
        {/if}
    </div>
</div>

<br><br>
