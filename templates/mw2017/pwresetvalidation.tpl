<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">

        <div class="logincontainer">

            {include file="$template/includes/pageheader.tpl" title=$LANG.pwreset}

            {if $invalidlink}

                {include file="$template/includes/alert.tpl" type="danger" msg=$invalidlink textcenter=true}

            {elseif $success}

                {include file="$template/includes/alert.tpl" type="success" msg=$LANG.pwresetvalidationsuccess textcenter=true}
                <p class="text-center">
                    {$LANG.pwresetsuccessdesc|sprintf2:'<a href="clientarea.php">':'</a>'}
                </p>
            {else}

                {if $errormessage}
                    {include file="$template/includes/alert.tpl" type="danger" msg=$errormessage textcenter=true}
                {/if}
                <p>{$LANG.pwresetenternewpw}</p>
                <br/>
                <form class="using-password-strength" method="post" action="{$smarty.server.PHP_SELF}?action=pwreset">
                    <input type="hidden" name="key" id="key" value="{$key}"/>

                    <div class="subscription-field has-feedback">
                        <input type="password" name="newpw" id="inputNewPassword1" placeholder="{$LANG.newpassword}" class="material-field subscription" autocomplete="off"/>
                        <span class="form-control-feedback glyphicon glyphicon-password"></span>
                    </div>
                    <br/>

                    <div class="subscription-field has-feedback">
                        <input type="password" name="confirmpw" id="inputNewPassword2" placeholder="{$LANG.confirmnewpassword}" class="material-field subscription" autocomplete="off"/>
                        <span class="form-control-feedback glyphicon glyphicon-password"></span>
                        <div id="inputNewPassword2Msg"></div>
                        <br/>
                    </div>

                    <div class="subscription-field">
                        <label class="control-label">{$LANG.pwstrength}</label>
                        {include file="$template/includes/pwstrength.tpl"}
                    </div>

                    <div class="subscription-field">
                        <div class="text-center">
                            <button class="cbtn" type="submit" name="submit">{$LANG.clientareasavechanges}</button>
                            &nbsp;
                            <input class="cbtn cbtn-alt" type="reset" value="{$LANG.cancel}"/>
                        </div>
                    </div>
                </form>
            {/if}

        </div>
    </div>
</div>
