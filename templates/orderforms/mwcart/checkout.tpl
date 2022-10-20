<script>
    // Define state tab index value
    var statesTab = 10;
    // Do not enforce state input client side
    var stateNotRequired = true;
</script>
{include file="orderforms/standard_cart/common.tpl"}
<script type="text/javascript" src="{$BASE_PATH_JS}/StatesDropdown.js"></script>
<script type="text/javascript" src="{$BASE_PATH_JS}/PasswordStrength.js"></script>
<script>
    window.langPasswordStrength = "{$LANG.pwstrength}";
    window.langPasswordWeak = "{$LANG.pwstrengthweak}";
    window.langPasswordModerate = "{$LANG.pwstrengthmoderate}";
    window.langPasswordStrong = "{$LANG.pwstrengthstrong}";
</script>

{if !$loggedin && $custom_oauth2_login_url}
    <script>
        window.location.href = "{$custom_oauth2_login_url}";
    </script>
{/if}

<div id="order-standard_cart">

    <div class="row col-xl-8 mx-auto">

        <div class="cart-body">
            <div class="header-lined">
                <h1 class="font-size-36">{$LANG.orderForm.checkout}</h1>
            </div>

            <div class="already-registered clearfix">
                <div class="pull-right float-right">
                    <button type="button" class="btn btn-info{if $loggedin || !$loggedin && $custtype eq "existing"} w-hidden{/if}" id="btnAlreadyRegistered">
                        {$LANG.orderForm.alreadyRegistered}
                    </button>
                    <button type="button" class="btn btn-warning{if $loggedin || $custtype neq "existing"} w-hidden{/if}" id="btnNewUserSignup">
                        {$LANG.orderForm.createAccount}
                    </button>
                </div>

                <p class="text-sm-left overflow-hidden">{lang key='orderForm.enterPersonalDetails'}</p>
            </div>

            {if $errormessage}
                <div class="alert alert-danger checkout-error-feedback" role="alert">
                    <p>{$LANG.orderForm.correctErrors}:</p>
                    <ul>
                        {$errormessage}
                    </ul>
                </div>
                <div class="clearfix"></div>
            {/if}

            <form method="post" action="{$smarty.server.PHP_SELF}?a=checkout" name="orderfrm" id="frmCheckout">
                <input type="hidden" name="submit" value="true" />
                <input type="hidden" name="custtype" id="inputCustType" value="{$custtype}" />

                {if $custtype neq "new" && $loggedin}
                    <div class="sub-heading">
                        <span class="primary-bg-color">
                            {lang key='switchAccount.title'}
                        </span>
                    </div>
                    <div id="containerExistingAccountSelect" class="row account-select-container">
                        {foreach $accounts as $account}
                            <div class="col-sm-{if $accounts->count() == 1}12{else}6{/if}">
                                <div class="account{if $selectedAccountId == $account->id} active{/if}">
                                    <label class="radio-inline col-12 text-left" for="account{$account->id}">
                                        <input id="account{$account->id}" class="account-select{if $account->isClosed || $account->noPermission || $inExpressCheckout} disabled{/if}" type="radio" name="account_id" value="{$account->id}"{if $account->isClosed || $account->noPermission || $inExpressCheckout} disabled="disabled"{/if}{if $selectedAccountId == $account->id} checked="checked"{/if}>
                                        <span class="address">
                                            <span class=" pe-3">
                                                {if $account->company}{$account->company}{else}{$account->fullName}{/if}
                                            </span>
                                            {if $account->isClosed || $account->noPermission}
                                                <span class="label label-default">
                                                    {if $account->isClosed}
                                                        {lang key='closed'}
                                                    {else}
                                                        {lang key='noPermission'}
                                                    {/if}
                                                </span>
                                            {elseif $account->currencyCode}
                                                <span class="label label-info">
                                                    {$account->currencyCode}
                                                </span>
                                            {/if}
                                            <br>
                                            <span class="small">
                                                {$account->address1}{if $account->address2}, {$account->address2}{/if}<br>
                                                {if $account->city}{$account->city},{/if}
                                                {if $account->state} {$account->state},{/if}
                                                {if $account->postcode} {$account->postcode},{/if}
                                                {$account->countryName}
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        {/foreach}
                        <div class="col-sm-12">
                            <div class="account border-bottom{if !$selectedAccountId || !is_numeric($selectedAccountId)} active{/if}">
                                <label class="radio-inline col-12 text-left">
                                    <input class="account-select" type="radio" name="account_id" value="new"{if !$selectedAccountId || !is_numeric($selectedAccountId)} checked="checked"{/if}{if $inExpressCheckout} disabled="disabled" class="disabled"{/if}>
                                    {lang key='orderForm.createAccount'}
                                </label>
                            </div>
                        </div>
                    </div>
                {/if}

                <div id="containerExistingUserSignin"{if $loggedin || $custtype neq "existing"} class="w-hidden{/if}">
                    <div class="sub-heading">
                        <span class="primary-bg-color">{$LANG.orderForm.existingCustomerLogin}</span>
                    </div>

                    <div class="alert alert-danger w-hidden" id="existingLoginMessage">
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group prepend-icon">

                                <input type="text" name="loginemail" id="inputLoginEmail" class="field form-control" placeholder="" value="{$loginemail}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group prepend-icon">

                                <input type="password" name="loginpassword" id="inputLoginPassword" class="field form-control" placeholder="{$LANG.clientareapassword}">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" id="btnExistingLogin" class="btn btn-primary btn-md">
                            <span id="existingLoginButton">{lang key='login'}</span>
                            <span id="existingLoginPleaseWait" class="w-hidden">{lang key='pleasewait'}</span>
                        </button>
                    </div>

                    {include file="orderforms/standard_cart/linkedaccounts.tpl" linkContext="checkout-existing"}
                </div>

                <div id="containerNewUserSignup"{if $custtype === 'existing' || (is_numeric($selectedAccountId) && $selectedAccountId > 0) || ($loggedin && $accounts->count() > 0 && $selectedAccountId !== 'new')} class="w-hidden"{/if}>

                    <div{if $loggedin} class="w-hidden"{/if}>
                        {include file="orderforms/standard_cart/linkedaccounts.tpl" linkContext="checkout-new"}
                    </div>

                    <div class="sub-heading ms-4">
                        <span class="primary-bg-color">{$LANG.orderForm.personalInformation}</span>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group prepend-icon">
                                <label for="order-form-first-name" class="control-label order-form-labels">{$LANG.orderForm.firstName}</label>
                                <input type="text" name="firstname" id="inputFirstName" class="field form-control" placeholder="" value="{$clientsdetails.firstname}" autofocus>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group prepend-icon">
                                <label for="order-form-last-name" class="control-label order-form-labels">{$LANG.orderForm.lastName}</label>
                                <input type="text" name="lastname" id="inputLastName" class="field form-control" placeholder="" value="{$clientsdetails.lastname}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group prepend-icon">
                                <label for="order-form-email" class="control-label order-form-labels">{$LANG.orderForm.emailAddress}</label>
                                <input type="email" name="email" id="inputEmail" class="field form-control" placeholder="" value="{$clientsdetails.email}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group prepend-icon">
                                <label for="order-form-phone" class="control-label order-form-labels">{$LANG.orderForm.phoneNumber}</label>
                                <input type="tel" name="phonenumber" id="inputPhone" class="field form-control" placeholder="" value="{$clientsdetails.phonenumber}">
                            </div>
                        </div>
                    </div>

                    <div class="sub-heading">
                        <span class="primary-bg-color ms-4">{$LANG.orderForm.billingAddress}</span>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group prepend-icon">
                                <label for="order-form-company-name" class="control-label order-form-labels">{$LANG.orderForm.companyName} ({$LANG.orderForm.optional})</label>
                                <input type="text" name="companyname" id="inputCompanyName" class="field form-control" placeholder="" value="{$clientsdetails.companyname}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group prepend-icon">
                                <label for="order-form-address" class="control-label order-form-labels">{$LANG.orderForm.streetAddress}</label>
                                <input type="text" name="address1" id="inputAddress1" class="field form-control" placeholder="" value="{$clientsdetails.address1}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group prepend-icon">
                                <label for="order-form-address2" class="control-label order-form-labels">{$LANG.orderForm.streetAddress2}</label>
                                <input type="text" name="address2" id="inputAddress2" class="field form-control" placeholder="" value="{$clientsdetails.address2}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group prepend-icon">
                                <label for="order-form-city" class="control-label order-form-labels">{$LANG.orderForm.city}</label>
                                <input type="text" name="city" id="inputCity" class="field form-control" placeholder="" value="{$clientsdetails.city}">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group prepend-icon">
                                <label for="order-form-state" class="control-label order-form-labels">{$LANG.orderForm.state}</label>
                                <input type="text" name="state" id="inputState" class="field form-control" placeholder="" value="{$clientsdetails.state}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group prepend-icon">
                                <label for="order-form-postcode" class="control-label order-form-labels">{$LANG.orderForm.postcode}</label>
                                <input type="text" name="postcode" id="inputPostcode" class="field form-control" placeholder="" value="{$clientsdetails.postcode}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group prepend-icon">
                                <label for="order-form-country" class="control-label order-form-labels">Country</label>

                                <select name="country" id="inputCountry" class="field form-control">
                                    {foreach $countries as $countrycode => $countrylabel}
                                        <option value="{$countrycode}"{if (!$country && $countrycode == $defaultcountry) || $countrycode eq $country} selected{/if}>
                                            {$countrylabel}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        {if $showTaxIdField}
                            <div class="col-sm-12">
                                <div class="form-group prepend-icon">
                                    <label for="order-form-client-details" class="control-label order-form-labels">{$taxLabel} ({$LANG.orderForm.optional})</label>
                                    <input type="text" name="tax_id" id="inputTaxId" class="field form-control" placeholder="" value="{$clientsdetails.tax_id}">
                                </div>
                            </div>
                        {/if}
                    </div>

                    {if $customfields}
                        <div class="sub-heading">
                            <span class="primary-bg-color">{$LANG.orderadditionalrequiredinfo}<br><i><small>{lang key='orderForm.requiredField'}</small></i></span>
                        </div>
                        <div class="field-container">
                            <div class="row">
                                {foreach $customfields as $customfield}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="customfield{$customfield.id}">{$customfield.name} {$customfield.required}</label>
                                            {$customfield.input}
                                            {if $customfield.description}
                                                <span class="field-help-text">
                                                    {$customfield.description}
                                                </span>
                                            {/if}
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    {/if}

                </div>

                {if $domainsinorder}

                    <div class="sub-heading">
                        <span class="primary-bg-color">{$LANG.domainregistrantinfo}</span>
                    </div>

                    <p class="small text-muted">{$LANG.orderForm.domainAlternativeContact}</p>

                    <div class="row margin-bottom">
                        <div class="col-sm-6 col-sm-offset-3 offset-sm-3">
                            <select name="contact" id="inputDomainContact" class="field form-control">
                                <option value="">{$LANG.usedefaultcontact}</option>
                                {foreach $domaincontacts as $domcontact}
                                    <option value="{$domcontact.id}"{if $contact == $domcontact.id} selected{/if}>
                                        {$domcontact.name}
                                    </option>
                                {/foreach}
                                <option value="addingnew"{if $contact == "addingnew"} selected{/if}>
                                    {$LANG.clientareanavaddcontact}...
                                </option>
                            </select>
                        </div>
                    </div>

                    <div{if $contact neq "addingnew"} class="w-hidden"{/if}>
                        <div class="row" id="domainRegistrantInputFields">
                            <div class="col-sm-6">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontactfirstname" id="inputDCFirstName" class="field form-control" placeholder="{$LANG.orderForm.firstName}" value="{$domaincontact.firstname}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontactlastname" id="inputDCLastName" class="field form-control" placeholder="{$LANG.orderForm.lastName}" value="{$domaincontact.lastname}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group prepend-icon">

                                    <input type="email" name="domaincontactemail" id="inputDCEmail" class="field form-control" placeholder="{$LANG.orderForm.emailAddress}" value="{$domaincontact.email}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group prepend-icon">

                                    <input type="tel" name="domaincontactphonenumber" id="inputDCPhone" class="field form-control" placeholder="{$LANG.orderForm.phoneNumber}" value="{$domaincontact.phonenumber}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontactcompanyname" id="inputDCCompanyName" class="field form-control" placeholder="{$LANG.orderForm.companyName} ({$LANG.orderForm.optional})" value="{$domaincontact.companyname}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontactaddress1" id="inputDCAddress1" class="field form-control" placeholder="{$LANG.orderForm.streetAddress}" value="{$domaincontact.address1}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontactaddress2" id="inputDCAddress2" class="field form-control" placeholder="{$LANG.orderForm.streetAddress2}" value="{$domaincontact.address2}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontactcity" id="inputDCCity" class="field form-control" placeholder="{$LANG.orderForm.city}" value="{$domaincontact.city}">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontactstate" id="inputDCState" class="field form-control" placeholder="{$LANG.orderForm.state}" value="{$domaincontact.state}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontactpostcode" id="inputDCPostcode" class="field form-control" placeholder="{$LANG.orderForm.postcode}" value="{$domaincontact.postcode}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group prepend-icon">

                                    <select name="domaincontactcountry" id="inputDCCountry" class="field form-control">
                                        {foreach $countries as $countrycode => $countrylabel}
                                            <option value="{$countrycode}"{if (!$domaincontact.country && $countrycode == $defaultcountry) || $countrycode eq $domaincontact.country} selected{/if}>
                                                {$countrylabel}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group prepend-icon">

                                    <input type="text" name="domaincontacttax_id" id="inputDCTaxId" class="field form-control" placeholder="{$taxLabel} ({$LANG.orderForm.optional})" value="{$domaincontact.tax_id}">
                                </div>
                            </div>
                        </div>
                    </div>

                {/if}

                {if !$loggedin}

                    <div id="containerNewUserSecurity"{if (!$loggedin && $custtype eq "existing") || ($remote_auth_prelinked && !$securityquestions)} class="w-hidden"{/if}>

                        <div class="sub-heading">
                            <span class="primary-bg-color">{$LANG.orderForm.accountSecurity}</span>
                        </div>

                        <div id="containerPassword" class="row{if $remote_auth_prelinked && $securityquestions} w-hidden{/if}">
                            <div id="passwdFeedback" class="alert alert-info text-center col-sm-12 w-hidden"></div>
                            <div class="col-sm-6">
                                <div class="form-group prepend-icon">

                                    <input type="password" name="password" id="inputNewPassword1" data-error-threshold="{$pwStrengthErrorThreshold}" data-warning-threshold="{$pwStrengthWarningThreshold}" class="field form-control" placeholder="{$LANG.clientareapassword}"{if $remote_auth_prelinked} value="{$password}"{/if}>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group prepend-icon">

                                    <input type="password" name="password2" id="inputNewPassword2" class="field form-control" placeholder="{$LANG.clientareaconfirmpassword}"{if $remote_auth_prelinked} value="{$password}"{/if}>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-default btn-sm generate-password" data-targetfields="inputNewPassword1,inputNewPassword2">
                                    {$LANG.generatePassword.btnLabel}
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <div class="password-strength-meter">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="passwordStrengthMeterBar">
                                        </div>
                                    </div>
                                    <p class="text-center small text-muted" id="passwordStrengthTextLabel">{$LANG.pwstrength}: {$LANG.pwstrengthenter}</p>
                                </div>
                            </div>
                        </div>
                        {if $securityquestions}
                            <div class="row">
                                <div class="col-sm-6">
                                    <select name="securityqid" id="inputSecurityQId" class="field form-control">
                                        <option value="">{$LANG.clientareasecurityquestion}</option>
                                        {foreach $securityquestions as $question}
                                            <option value="{$question.id}"{if $question.id eq $securityqid} selected{/if}>
                                                {$question.question}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group prepend-icon">

                                        <input type="password" name="securityqans" id="inputSecurityQAns" class="field form-control" placeholder="{$LANG.clientareasecurityanswer}">
                                    </div>
                                </div>
                            </div>
                        {/if}

                    </div>

                {/if}

                {foreach $hookOutput as $output}
                    <div>
                        {$output}
                    </div>
                {/foreach}

                <div class="sub-heading">
                    <span class="primary-bg-color">{$LANG.orderForm.paymentDetails}</span>
                </div>

                <div class="alert alert-success text-center large-text" role="alert" id="totalDueToday">
                    {$LANG.ordertotalduetoday}: &nbsp; <strong id="totalCartPrice">{$total}</strong>
                </div>

                <div id="applyCreditContainer" class="apply-credit-container{if !$canUseCreditOnCheckout} w-hidden{/if}" data-apply-credit="{$applyCredit}">
                    <p>{lang key='cart.availableCreditBalance' amount=$creditBalance}</p>

                    <label class="radio">
                        <input id="useCreditOnCheckout" type="radio" name="applycredit" value="1"{if $applyCredit} checked{/if}>
                        <span id="spanFullCredit"{if !($creditBalance->toNumeric() >= $total->toNumeric())} class="w-hidden"{/if}>
                            {lang key='cart.applyCreditAmountNoFurtherPayment' amount=$total}
                        </span>
                        <span id="spanUseCredit"{if $creditBalance->toNumeric() >= $total->toNumeric()} class="w-hidden"{/if}>
                            {lang key='cart.applyCreditAmount' amount=$creditBalance}
                        </span>
                    </label>
                    <label class="radio">
                        <input id="skipCreditOnCheckout" type="radio" name="applycredit" value="0"{if !$applyCredit} checked{/if}>
                        {lang key='cart.applyCreditSkip' amount=$creditBalance}
                    </label>
                </div>

                {if !$inExpressCheckout}
                    <div id="paymentGatewaysContainer" class="form-group">
                        <p class="small text-muted">{$LANG.orderForm.preferredPaymentMethod}</p>

                        <div class="text-center">
                            {foreach $gateways as $gateway}
                                <div class="gateway-border-bottom">
                                    <label class="radio-inline col-12 text-left">
                                        <input type="radio"
                                               name="paymentmethod"
                                               value="{$gateway.sysname}"
                                               data-payment-type="{$gateway.payment_type}"
                                               data-show-local="{$gateway.show_local_cards}"
                                               data-remote-inputs="{$gateway.uses_remote_inputs}"
                                               class="payment-methods{if $gateway.type eq "CC"} is-credit-card{/if}"
                                                {if $selectedgateway eq $gateway.sysname} checked{/if}
                                        />
                                        {$gateway.name}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="alert alert-danger text-center gateway-errors w-hidden"></div>

                    <div class="clearfix"></div>

                    <div class="cc-input-container{if $selectedgatewaytype neq "CC"} w-hidden{/if}" id="creditCardInputFields">
                       <div class="d-flex" style="display: flex; align-items: center;">
                           {if $client}
                              <div class="col-lg-9 col-sm-12 px-0">
                                  <div id="existingCardsContainer" class="existing-cc-grid">
                                      {include file="orderforms/mwcart/includes/existing-paymethods.tpl"}
                                  </div>
                              </div>
                           {/if}

                           {if count($client->payMethods->validateGateways()->sortByExpiryDate()) gt 0 }
                               <div class="row cvv-input col-lg-3 col-sm-12"  id="existingCardInfo">
                                   <div class="form-group prepend-icon">

                                       <div class="input-group">
                                           <input type="tel" name="cccvv" id="inputCardCVV2" class="field form-control" placeholder="{$LANG.creditcardcvvnumbershort}" autocomplete="cc-cvc">
                                           <span class="input-group-btn input-group-append">
                                        <button type="button" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="<img src='{$BASE_PATH_IMG}/ccv.gif' width='210' />">
                                            ?
                                        </button>
                                    </span>
                                       </div>

{*                                        <span class="field-error-msg">{lang key="paymentMethodsManage.cvcNumberNotValid"}</span>*}

                                   </div>
                               </div>
                           {/if}
                       </div>


                        <ul>
                            <li>
                                <label class="radio-inline col-12 text-left">
                                    <input type="radio" name="ccinfo" value="new" id="new" {if !$client || $client->payMethods->count() === 0} checked="checked"{/if} />
                                    &nbsp;
                                    {lang key='creditcardenternewcard'}
                                </label>
                            </li>
                        </ul>

                        <div class="row" id="newCardInfo" style="display: none!important;">
                            <div id="cardNumberContainer" class="col-sm-6 new-card-container">
                                <div class="form-group prepend-icon">

                                    <input type="tel" name="ccnumber" id="inputCardNumber" class="field form-control cc-number-field" placeholder="{$LANG.orderForm.cardNumber}" autocomplete="cc-number" data-message-unsupported="{lang key='paymentMethodsManage.unsupportedCardType'}" data-message-invalid="{lang key='paymentMethodsManage.cardNumberNotValid'}" data-supported-cards="{$supportedCardTypes}" />
                                    <span class="field-error-msg"></span>
                                </div>
                            </div>
                            <div class="col-sm-3 new-card-container">
                                <div class="form-group prepend-icon">

                                    <input type="tel" name="ccexpirydate" id="inputCardExpiry" class="field form-control" placeholder="MM / YY{if $showccissuestart} ({$LANG.creditcardcardexpires}){/if}" autocomplete="cc-exp">
                                    <span class="field-error-msg">{lang key="paymentMethodsManage.expiryDateNotValid"}</span>
                                </div>
                            </div>
                            <div class="col-sm-3" id="cvv-field-container">
                                <div class="form-group prepend-icon">

                                    <div class="input-group">
                                        <input type="tel" name="cccvv" id="inputCardCVV" class="field form-control" placeholder="{$LANG.creditcardcvvnumbershort}" autocomplete="cc-cvc">
                                        <span class="input-group-btn input-group-append">
                                            <button type="button" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="<img src='{$BASE_PATH_IMG}/ccv.gif' width='210' />">
                                                ?
                                            </button>
                                        </span><br>
                                    </div>
                                    <span class="field-error-msg">{lang key="paymentMethodsManage.cvcNumberNotValid"}</span>
                                </div>
                            </div>
                            {if $showccissuestart}
                                <div class="col-sm-3 col-sm-offset-6 new-card-container offset-sm-6">
                                    <div class="form-group prepend-icon">

                                        <input type="tel" name="ccstartdate" id="inputCardStart" class="field form-control" placeholder="MM / YY ({$LANG.creditcardcardstart})" autocomplete="cc-exp">
                                    </div>
                                </div>
                                <div class="col-sm-3 new-card-container">
                                    <div class="form-group prepend-icon">

                                        <input type="tel" name="ccissuenum" id="inputCardIssue" class="field form-control" placeholder="{$LANG.creditcardcardissuenum}">
                                    </div>
                                </div>
                            {/if}
                        </div>
                        <div id="newCardSaveSettings">
                            <div class="row form-group new-card-container">
                                <div id="inputDescriptionContainer" class="col-md-6">
                                    <div class="prepend-icon">

                                        <input type="text" class="field form-control" id="inputDescription" name="ccdescription" autocomplete="off" value="" placeholder="{$LANG.paymentMethods.descriptionInput} {$LANG.paymentMethodsManage.optional}" />
                                    </div>
                                </div>
                                {if $allowClientsToRemoveCards}
                                    <div id="inputNoStoreContainer" class="col-md-6" style="line-height: 32px;">
                                        <input type="hidden" name="nostore" value="1">
                                        <input type="checkbox" class="toggle-switch-success no-icheck" data-size="mini" checked="checked" name="nostore" id="inputNoStore" value="0" data-on-text="{lang key='yes'}" data-off-text="{lang key='no'}">
                                        <label for="inputNoStore" class="checkbox-inline no-padding">
                                            &nbsp;&nbsp;
                                            {$LANG.creditCardStore}
                                        </label>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                {else}
                    {if $expressCheckoutOutput}
                        {$expressCheckoutOutput}
                    {else}
                        <p align="center">
                            {lang key='paymentPreApproved' gateway=$expressCheckoutGateway}
                        </p>
                    {/if}
                {/if}

                {if $shownotesfield}

                    <div class="sub-heading">
                        <span class="primary-bg-color">{$LANG.orderForm.additionalNotes}</span>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea name="notes" class="field form-control" rows="4" placeholder="{$LANG.ordernotesdescription}">{$orderNotes}</textarea>
                            </div>
                        </div>
                    </div>

                {/if}

                {if $showMarketingEmailOptIn}
                    <div class="marketing-email-optin">
                        <h4 class="font-size-18">{lang key='emailMarketing.joinOurMailingList'}</h4>
                        <p>{$marketingEmailOptInMessage}</p>
                        <input type="checkbox" name="marketingoptin" value="1"{if $marketingEmailOptIn} checked{/if} class="no-icheck toggle-switch-success" data-size="small" data-on-text="{lang key='yes'}" data-off-text="{lang key='no'}">
                    </div>
                {/if}

                <div class="text-center">
                    {if $accepttos}
                        <p>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="accepttos" id="accepttos" />
                                &nbsp;
                                {$LANG.ordertosagreement}
                                <a href="{$tosurl}" target="_blank">{$LANG.ordertos}</a>
                            </label>
                        </p>
                    {/if}


                    <button type="submit"
                            id="btnCompleteOrder"
                            class="whmc-kbtn my-4 disable-on-click spinner-on-click{if $captcha}{$captcha->getButtonClass($captchaForm)}{/if}"
                            {if $cartitems==0}disabled="disabled"{/if}
                    >
                        {if $inExpressCheckout}{$LANG.confirmAndPay}{else}{$LANG.completeorder}{/if}
                        &nbsp;<i class="fas fa-arrow-circle-right"></i>
                    </button>
                </div>
            </form>

            {if $servedOverSsl}
                <div class="alert alert-warning checkout-security-msg">
                    <i class="fas fa-lock"></i>
                    {$LANG.ordersecure} (<strong>{$ipaddress}</strong>) {$LANG.ordersecure2}
                    <div class="clearfix"></div>
                </div>
            {/if}
        </div>
    </div>
</div>

<script type="text/javascript" src="{$BASE_PATH_JS}/jquery.payment.js"></script>
<script>
    var hideCvcOnCheckoutForExistingCard = '{if $canUseCreditOnCheckout && $applyCredit && ($creditBalance->toNumeric() >= $total->toNumeric())}1{else}0{/if}';
</script>
