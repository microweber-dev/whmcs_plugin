{if $domainsinorder}
    <h1>{$LANG.domainregistrantinfo}</h1>
    <select name="contact" id="inputDomainContact" class="form-control">
        {if $domaincontacts}
            <option value="">{$LANG.usedefaultcontact}</option>
            {foreach from=$domaincontacts item=domcontact}
                <option value="{$domcontact.id}"{if $contact==$domcontact.id} selected{/if}>{$domcontact.name}</option>
            {/foreach}
        {/if}
        <option value="addingnew"{if $contact eq "addingnew"} selected{/if}>{$LANG.clientareanavaddcontact}...</option>
    </select>
    <br/>
    <div class="signupfields{if $contact neq "addingnew" && $domaincontacts} hidden{/if}" id="domaincontactfields">
        <div class="row">
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="domaincontactfirstname" id="domaincontactfirstname" placeholder="{$LANG.clientareafirstname}" value="{$domaincontact.firstname}"
                           class="form-control subscription"/> 
                </div>
            </div>
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="domaincontactlastname" id="domaincontactlastname" placeholder="{$LANG.clientarealastname}" value="{$domaincontact.lastname}"
                           class="form-control subscription"/>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="email" name="domaincontactemail" id="domaincontactemail" placeholder="{$LANG.clientareaemail}" value="{$domaincontact.email}" class="form-control subscription"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="domaincontactcompanyname" id="domaincontactcompanyname" placeholder="{$LANG.clientareacompanyname}" value="{$domaincontact.companyname}"
                           class="form-control subscription"/>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="subscription-field">
                    <select id="domaincontactcountry" name="domaincontactcountry" class="form-control" title="{$LANG.clientareacountry}">
                        {foreach from=$countries key=thisCountryCode item=thisCountryName}
                            <option value="{$thisCountryCode}"
                                    {if ($domaincontact.country && $thisCountryCode eq $domaincontact.country) || $thisCountryCode eq $clientsdetails.country}selected="selected"{/if}>{$thisCountryName}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="domaincontactcity" id="domaincontactcity" placeholder="{$LANG.clientareacity}" value="{$domaincontact.city}" class="form-control subscription"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="domaincontactstate" id="domaincontactstate" placeholder="{$LANG.clientareastate}" value="{$domaincontact.state}" class="form-control subscription"/>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="domaincontactpostcode" id="domaincontactpostcode" placeholder="{$LANG.clientareapostcode}" value="{$domaincontact.postcode}"
                           class="form-control subscription"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="domaincontactaddress1" id="domaincontactaddress1" placeholder="{$LANG.clientareaaddress1}" value="{$domaincontact.address1}"
                           class="form-control subscription"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="subscription-field">
                    <input type="text" name="domaincontactaddress2" id="domaincontactaddress2" placeholder="{$LANG.clientareaaddress2}" value="{$domaincontact.address2}"
                           class="form-control subscription"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="subscription-field">
                    <input type="tel" name="domaincontactphonenumber" id="domaincontactphonenumber" placeholder="{$LANG.clientareaphonenumber}" value="{$domaincontact.phonenumber}"
                           class="form-control subscription"/>
                    <span id="phone-valid-msg" class="hide">✓ Valid</span>
                    <span id="phone-error-msg" class="hide">Invalid number</span>
                </div>
            </div>
        </div>
    </div>
{/if}