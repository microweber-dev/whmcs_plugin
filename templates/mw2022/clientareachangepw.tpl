<div class="mw-whm clientareachangepw">

    <div class="header-lined text-center">
        <h1>Change Password</h1>
        <br />
    </div>

    {if $successful}
        {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=true}
    {/if}

    {if $errormessage}
        {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
    {/if}

    <form class="form-horizontal using-password-strength" method="post" action="clientarea.php?action=changepw" role="form">
        <input type="hidden" name="submit" value="true"/>
        <div class="form-group">
            <label for="inputExistingPassword" class="col-sm-4 control-label">{$LANG.existingpassword}</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="existingpw" id="inputExistingPassword" autocomplete="off"/>
            </div>
        </div>
        <div id="newPassword1" class="form-group has-feedback">
            <label for="inputNewPassword1" class="col-sm-4 control-label">{$LANG.newpassword}</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="newpw" id="inputNewPassword1" autocomplete="off"/>
                <span class="form-control-feedback glyphicon"></span>
                {include file="$template/includes/pwstrength.tpl"}
            </div>
        </div>
        <div id="newPassword2" class="form-group has-feedback">
            <label for="inputNewPassword2" class="col-sm-4 control-label">{$LANG.confirmnewpassword}</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="confirmpw" id="inputNewPassword2" autocomplete="off"/>
                <span class="form-control-feedback glyphicon"></span>
                <div id="inputNewPassword2Msg"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <button class="cbtn" type="submit">{$LANG.clientareasavechanges}</button>
                <button class="cbtn cbtn-alt" type="reset">{$LANG.cancel}</button>
            </div>
        </div>
    </form>
</div>