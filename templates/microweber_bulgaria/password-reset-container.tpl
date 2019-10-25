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
                <div class="logincontainer">
                    {include file="$template/includes/pageheader.tpl" title=$LANG.pwreset}

                    {if $loggedin && $innerTemplate}
                        {include file="$template/includes/alert.tpl" type="error" msg=$LANG.noPasswordResetWhenLoggedIn textcenter=true}
                    {else}
                        {if $successMessage}
                            {include file="$template/includes/alert.tpl" type="success" msg=$successTitle textcenter=true}
                            <p>{$successMessage}</p>
                        {else}
                            {if $errorMessage}
                                {include file="$template/includes/alert.tpl" type="error" msg=$errorMessage textcenter=true}
                            {/if}

                            {if $innerTemplate}
                                {include file="$template/password-reset-$innerTemplate.tpl"}
                            {/if}
                        {/if}
                    {/if}
                </div>
            </div>
        </div>
    </div>
</section>