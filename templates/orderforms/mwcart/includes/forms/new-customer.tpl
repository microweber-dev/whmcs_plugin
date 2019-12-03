<div class="signupfields signupfields-existing{if $custtype eq "existing" && !$loggedin}{else} hidden{/if}" id="loginfrm">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="subscription-field">
                <input type="text" name="loginemail" class="form-control material-field subscription" id="inputEmail" placeholder="{$LANG.enteremail}"{if $loggedin} disabled{/if} />
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="subscription-field">
                <input type="password" name="loginpw" class="form-control material-field subscription" id="inputPassword" placeholder="{$LANG.clientareapassword}"{if $loggedin} disabled{/if} />
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>

{if !$loggedin}
    <div class="signupfields{if $custtype eq "existing" && !$loggedin} hidden{/if}" id="signupfrm">
        <div class="row">
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="firstname" id="firstname" value="{$clientsdetails.firstname}"
                           class="form-control material-field subscription" placeholder="{$LANG.clientareafirstname}" {if !in_array('firstname', $clientsProfileOptionalFields)} required{/if} />
                </div>

                <div class="subscription-field">
                    <input type="text" name="lastname" id="lastname" value="{$clientsdetails.lastname}"
                           class="form-control material-field subscription" placeholder="{$LANG.clientarealastname}" {if !in_array('lastname', $clientsProfileOptionalFields)} required{/if} />
                </div>

                <div class="subscription-field">
                    <input type="text" name="companyname" id="companyname" value="{$clientsdetails.companyname}" placeholder="{$LANG.clientareacompanyname}"
                           class="form-control material-field subscription"/>
                </div>

                <div class="subscription-field">
                    <input type="email" name="email" id="email" value="{$clientsdetails.email}" placeholder="{$LANG.clientareaemail}" class="form-control material-field subscription" required/>
                </div>

                <div id="newPassword1" class="subscription-field has-feedback">
                    <input type="password" class="form-control material-field subscription" id="inputNewPassword1" name="password" value="{$password}" placeholder="{$LANG.clientareapassword}" required/>
                    <span class="form-control-feedback glyphicon glyphicon-password"></span>
                </div>

                <div id="newPassword2" class="subscription-field has-feedback">
                    <input type="password" class="form-control material-field subscription" id="inputNewPassword2" name="password2" value="{$password2}" placeholder="{$LANG.clientareaconfirmpassword}"
                           required/>
                    <span class="form-control-feedback glyphicon glyphicon-password"></span>
                    <div id="inputNewPassword2Msg">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="address1" id="address1" value="{$clientsdetails.address1}" class="form-control material-field subscription"
                           placeholder="{$LANG.clientareaaddress1}" {if !in_array('address1', $clientsProfileOptionalFields)} required{/if} />
                </div>
                <div class="subscription-field">
                    <input type="text" name="address2" id="address2" value="{$clientsdetails.address2}" class="form-control material-field subscription" placeholder="{$LANG.clientareaaddress2}"/>
                </div>
                <div class="subscription-field">
                    <input type="text" name="city" id="city" value="{$clientsdetails.city}" class="form-control material-field subscription"
                           placeholder="{$LANG.clientareacity}" {if !in_array('city', $clientsProfileOptionalFields)} required{/if} />
                </div>
                <div class="subscription-field">
                    <input type="text" name="state" id="state" value="{$clientsdetails.state}" class="form-control material-field subscription"
                           placeholder="{$LANG.clientareastate}" {if !in_array('state', $clientsProfileOptionalFields)} required{/if} />
                </div>
                <div class="subscription-field">
                    <input type="text" name="postcode" id="postcode" value="{$clientsdetails.postcode}"
                           class="form-control material-field subscription" placeholder="{$LANG.clientareapostcode}" {if !in_array('postcode', $clientsProfileOptionalFields)} required{/if} />
                </div>
                <div class="subscription-field">
                    <select id="country" name="country" class="selectpicker" title="{$LANG.clientareacountry}">
                        {foreach from=$countries key=thisCountryCode item=thisCountryName}
                            <option value="{$thisCountryCode}" {if $thisCountryCode eq $clientsdetails.country}selected="selected"{/if}>{$thisCountryName}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="subscription-field">
                    <input type="text" name="phonenumber" id="phonenumber" value="{$clientsdetails.phonenumber}"
                           class="form-control material-field subscription" placeholder="{$LANG.clientareaphonenumber}" {if !in_array('phonenumber', $clientsProfileOptionalFields)} required{/if} />
                </div>

                {if $customfields}
                    {foreach from=$customfields key=num item=customfield}
                        <div class="subscription-field">
                            <label class="control-label" for="customfield{$customfield.id}">{$customfield.name}</label>
                            <div class="control">
                                {$customfield.input} {$customfield.description}
                            </div>
                        </div>
                    {/foreach}
                {/if}
            </div>
            <div class="col-xs-12">
                {include file="$template/includes/pwstrength.tpl"}
            </div>
        </div>
    </div>
{/if}
