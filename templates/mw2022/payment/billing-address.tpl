<div{if !$addingNew} class="w-hidden"{/if}>
    <div class="form-group row" id="billingAddressChoice">
        <label class="col-sm-4 text-md-right col-form-label">{lang key='billingAddress'}</label>
        <div class="col-sm-8">
            <label class="billing-contact-0">
                <input
                        type="radio"
                        class="icheck-button"
                        name="billingcontact"
                        value="0"
                        {if !$billingContact} checked{/if}
                >

                <strong class="name">{$client->fullName}</strong>
                <span class="address1">{$client->address1}</span>,
                {if $client->address2}<span class="address2">{$client->address2}</span>,{/if}
                <span class="city">{$client->city}</span>,
                <span class="state">{$client->state}</span>,
                <span class="postcode">{$client->postcode}</span>,
                <span class="country">{$client->country}</span>
            </label>
            <br>
            {foreach $client->contacts()->orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->get() as $contact}
                <label class="billing-contact-{$contact->id}">
                    <input
                            type="radio"
                            class="icheck-button"
                            name="billingcontact"
                            value="{$contact->id}"
                            {if $billingContact == $contact->id} checked{/if}
                    >

                    <strong class="name">{$contact->fullName}</strong>
                    <span class="text-truncate">
                        <span class="address1">{$contact->address1}</span>,
                        {if $contact->address2}<span class="address2">{$contact->address2}</span>,{/if}
                        <span class="city">{$contact->city}</span>,
                        <span class="state">{$contact->state}</span>,
                        <span class="postcode">{$contact->postcode}</span>,
                        <span class="country">{$contact->country}</span>
                    </span>
                </label>
                <br>
            {/foreach}
            <label>
                <input
                        type="radio"
                        class="icheck-button"
                        name="billingcontact"
                        value="new"
                        {if $billingContact === 'new'} checked{/if}
                >
                {lang key='paymentMethodsManage.addNewBillingAddress'}
            </label>
        </div>
    </div>
</div>
<div{if !$userDetailsValidationError && $billingcontact !== 'new'} class="w-hidden"{/if}>
    <div id="newBillingAddress">
        <div class="form-group row cc-billing-address">
            <label for="inputFirstName" class="col-sm-4 text-md-right col-form-label">{lang key='clientareafirstname'}</label>
            <div class="col-sm-6">
                <input type="text" name="firstname" id="inputFirstName" value="{$firstname}" class="form-control" />
            </div>
        </div>
        <div class="form-group row cc-billing-address">
            <label for="inputLastName" class="col-sm-4 text-md-right col-form-label">{lang key='clientarealastname'}</label>
            <div class="col-sm-6">
                <input type="text" name="lastname" id="inputLastName" value="{$lastname}" class="form-control" />
            </div>
        </div>
        <div class="form-group row cc-billing-address">
            <label for="inputAddress1" class="col-sm-4 text-md-right col-form-label">{lang key='clientareaaddress1'}</label>
            <div class="col-sm-6">
                <input type="text" name="address1" id="inputAddress1" value="{$address1}" class="form-control" />
            </div>
        </div>
        <div class="form-group row cc-billing-address">
            <label for="inputAddress2" class="col-sm-4 text-md-right col-form-label">{lang key='clientareaaddress2'}</label>
            <div class="col-sm-6">
                <input type="text" name="address2" id="inputAddress2" value="{$address2}" class="form-control" />
            </div>
        </div>
        <div class="form-group row cc-billing-address">
            <label for="inputCity" class="col-sm-4 text-md-right col-form-label">{lang key='clientareacity'}</label>
            <div class="col-sm-6">
                <input type="text" name="city" id="inputCity" value="{$city}" class="form-control" />
            </div>
        </div>
        <div class="form-group row cc-billing-address">
            <label for="inputState" class="col-sm-4 text-md-right col-form-label">{lang key='clientareastate'}</label>
            <div class="col-sm-6">
                <input type="text" name="state" id="inputState" value="{$state}" class="form-control" data-custom-select/>
            </div>
        </div>
        <div class="form-group row cc-billing-address">
            <label for="inputPostcode" class="col-sm-4 text-md-right col-form-label">{lang key='clientareapostcode'}</label>
            <div class="col-sm-6">
                <input type="text" name="postcode" id="inputPostcode" value="{$postcode}" class="form-control" />
            </div>
        </div>
        <div class="form-group row cc-billing-address">
            <label for="inputCountry" class="col-sm-4 text-md-right col-form-label">{lang key='clientareacountry'}</label>
            <div class="col-sm-6">
                <select id="country" name="country" class="form-control">
                    {foreach $countries as $countryCode => $countryName}
                        <option value="{$countryCode}"{if $countryCode == $country} selected="selected"{/if}>
                            {$countryName}
                        </option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group row cc-billing-address">
            <label for="inputPhone" class="col-sm-4 text-md-right col-form-label">{lang key='clientareaphonenumber'}</label>
            <div class="col-sm-6">
                <input type="text" name="phonenumber" id="inputPhone" value="{$phonenumber}" class="form-control" />
            </div>
        </div>
    </div>
</div>
