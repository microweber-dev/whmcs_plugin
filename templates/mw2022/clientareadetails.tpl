{if $successful}
    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=true}
{/if}

{if $errormessage}
    {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
{/if}

<script type="text/javascript" src="{$BASE_PATH_JS}/StatesDropdown.js"></script>

<form method="post" action="?action=details" role="form">



    <div class="row panel panel-default mt-5">
        <div style="font-weight: 700!important;" class="px-4 ms-2 py-3">
            <h1>Personal Information</h1>
            <br />
        </div>

        <div class="col-md-6 col-12">

            <div class="form-group m-4 ">
                <label for="inputFirstName" class="control-label">{$LANG.clientareafirstname}</label>
                <input type="text" name="firstname" id="inputFirstName" value="{$clientfirstname}"{if in_array('firstname', $uneditablefields)} disabled="disabled"{/if} class="form-control" />
            </div>

            <div class="form-group m-4 ">
                <label for="inputLastName" class="control-label">{$LANG.clientarealastname}</label>
                <input type="text" name="lastname" id="inputLastName" value="{$clientlastname}"{if in_array('lastname', $uneditablefields)} disabled="disabled"{/if} class="form-control" />
            </div>

            <div class="form-group m-4 ">
                <label for="inputCompanyName" class="control-label">{$LANG.clientareacompanyname}</label>
                <input type="text" name="companyname" id="inputCompanyName" value="{$clientcompanyname}"{if in_array('companyname', $uneditablefields)} disabled="disabled"{/if} class="form-control" />
            </div>

            <div class="form-group m-4 ">
                <label for="inputEmail" class="control-label">{$LANG.clientareaemail}</label>
                <input type="email" name="email" id="inputEmail" value="{$clientemail}"{if in_array('email', $uneditablefields)} disabled="disabled"{/if} class="form-control" />
            </div>

        </div>
        <div class="col-md-6 col-12 pull-right">

            <div class="form-group m-4 ">
                <label for="inputAddress1" class="control-label">{$LANG.clientareaaddress1}</label>
                <input type="text" name="address1" id="inputAddress1" value="{$clientaddress1}"{if in_array('address1', $uneditablefields)} disabled="disabled"{/if} class="form-control" />
            </div>

{*            <div class="form-group m-4 ">*}
{*                <label for="inputAddress2" class="control-label">{$LANG.clientareaaddress2}</label>*}
{*                <input type="text" name="address2" id="inputAddress2" value="{$clientaddress2}"{if in_array('address2', $uneditablefields)} disabled="disabled"{/if} class="form-control" />*}
{*            </div>*}

            <div class="form-group m-4 ">
                <label for="inputCity" class="control-label">{$LANG.clientareacity}</label>
                <input type="text" name="city" id="inputCity" value="{$clientcity}"{if in_array('city', $uneditablefields)} disabled="disabled"{/if} class="form-control" />
            </div>

            <div class="form-group m-4 ">
                <label for="inputState" class="control-label">{$LANG.clientareastate}</label>
                <input type="text" name="state" id="inputState" value="{$clientstate}"{if in_array('state', $uneditablefields)} disabled="disabled"{/if} class="form-control" />
            </div>

            <div class="form-group m-4 ">
                <label for="inputPostcode" class="control-label">{$LANG.clientareapostcode}</label>
                <input type="text" name="postcode" id="inputPostcode" value="{$clientpostcode}"{if in_array('postcode', $uneditablefields)} disabled="disabled"{/if} class="form-control" />
            </div>



        </div>
        <div class="col-md-6 col-12 pull-left">

            <div class="form-group m-4 ">
                <label for="inputPaymentMethod" class="control-label">{$LANG.paymentmethod}</label>
                <select name="paymentmethod" id="inputPaymentMethod" class="form-control">
                    <option value="none">{$LANG.paymentmethoddefault}</option>
                    {foreach from=$paymentmethods item=method}
                        <option value="{$method.sysname}"{if $method.sysname eq $defaultpaymentmethod} selected="selected"{/if}>{$method.name}</option>
                    {/foreach}
                </select>
            </div>

            <div class="form-group m-4 ">
                <label for="inputBillingContact" class="control-label">{$LANG.defaultbillingcontact}</label>
                <select name="billingcid" id="inputBillingContact" class="form-control">
                    <option value="0">{$LANG.usedefaultcontact}</option>
                    {foreach from=$contacts item=contact}
                        <option value="{$contact.id}"{if $contact.id eq $billingcid} selected="selected"{/if}>{$contact.name}</option>
                    {/foreach}
                </select>
            </div>

            <div class="form-group m-4 ">
                <label for="inputBillingContact" class="control-label">{$LANG.defaultbillingcontact}</label>
                <select name="billingcid" id="inputBillingContact" class="form-control">
                    <option value="0">{$LANG.usedefaultcontact}</option>
                    {foreach from=$contacts item=contact}
                        <option value="{$contact.id}"{if $contact.id eq $billingcid} selected="selected"{/if}>{$contact.name}</option>
                    {/foreach}
                </select>
            </div>

            {if $customfields}
                {foreach from=$customfields key=num item=customfield}
                    <div class="form-group m-4 ">
                        <label class="control-label" for="customfield{$customfield.id}">{$customfield.name}</label>
                        <div class="control">
                            {$customfield.input} {$customfield.description}
                        </div>
                    </div>
                {/foreach}
            {/if}

            {if $emailoptoutenabled}
                <div class="form-group m-4 ">
                    <label class="control-label" for="inputEmailOptOut">{$LANG.emailoptout}</label>
                    <div class="controls checkbox">
                        <label>
                            <input type="checkbox" value="1" name="emailoptout" id="inputEmailOptOut" {if $emailoptout} checked{/if} /> {$LANG.emailoptoutdesc}
                        </label>
                    </div>
                </div>
            {/if}

            <div class="form-group m-4 ">
                <label class="control-label" for="country">{$LANG.clientareacountry}</label>
                {$clientcountriesdropdown}
            </div>


        </div>

       <div class="col-md-6 col-12">
           <div class="form-group m-4 ">
               <label for="inputPhone" class="control-label">Change Password</label><br>
               <button class="whmc-kbtn-2">Change password</button>
           </div>
       </div>


        <div class="form-group mt-5 pt-5  text-center">
            <input class="whmc-kbtn-2" type="reset" value="{$LANG.cancel}" />
            <input class="whmc-kbtn" type="submit" name="save" value="{$LANG.clientareasavechanges}" />
        </div>
    </div>


</form>
