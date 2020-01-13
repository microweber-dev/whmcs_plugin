<p>{$LANG.pwresetemailneeded}</p>

<form method="post" action="{routePath('password-reset-validate-email')}" role="form">
    <input type="hidden" name="action" value="reset" />

    <div class="form-group m-t-30">
        <label for="inputEmail">{$LANG.loginemail}</label>
        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="{$LANG.enteremail}" autofocus>
    </div>

    {if $captcha->isEnabled()}
        <div class="text-center margin-bottom">
            {include file="$template/includes/captcha.tpl"}
        </div>
    {/if}

    <div class="form-group text-center m-t-30">
        <button type="submit" class="btn btn-default btn-md{$captcha->getButtonClass($captchaForm)}">
            {$LANG.pwresetsubmit}
        </button>
    </div>

</form>
