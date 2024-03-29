<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">

        <div class="logincontainer">

            {include file="$template/includes/pageheader.tpl" title=$LANG.pwreset}

            {if $loggedin}
                {include file="$template/includes/alert.tpl" type="error" msg=$LANG.noPasswordResetWhenLoggedIn textcenter=true}
            {else}
                {if $success}

                    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.pwresetvalidationsent textcenter=true}
                    <p>{$LANG.pwresetvalidationcheckemail}</p>
                {else}

                    {if $errormessage}
                        {include file="$template/includes/alert.tpl" type="error" msg=$errormessage textcenter=true}
                    {/if}

                    <br />

                    {if $securityquestion}
                        <p>{$LANG.pwresetsecurityquestionrequired}</p>
                        <form method="post" action="pwreset.php" class="form-stacked">
                            <input type="hidden" name="action" value="reset"/>
                            <input type="hidden" name="email" value="{$email}"/>

                            <div class="subscription-field">
                                <input type="text" name="answer" id="inputAnswer" placeholder="{$securityquestion}" class="material-field subscription"/>
                            </div>
                            <br/>

                            <div class="form-group text-center">
                                <button type="submit" class="cbtn">{$LANG.pwresetsubmit}</button>
                            </div>

                        </form>
                    {else}
                        <p>{$LANG.pwresetemailneeded}</p>
                        <form method="post" action="{$systemsslurl}pwreset.php" role="form">
                            <input type="hidden" name="action" value="reset"/>

                            <div class="subscription-field">
                                <input type="email" name="email" id="inputEmail" placeholder="{$LANG.enteremail}" class="material-field subscription"/>
                            </div>
                            <br/>

                            <div class="form-group text-center">
                                <button type="submit" class="cbtn">{$LANG.pwresetsubmit}</button>
                            </div>

                        </form>
                    {/if}

                {/if}
            {/if}

        </div>

    </div>
</div>