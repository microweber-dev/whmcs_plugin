{if !$inExpressCheckout}
    <div id="paymentGatewaysContainer" class="form-group">
        <p class="small text-muted">{$LANG.orderForm.preferredPaymentMethod}</p>

        <div class="text-center">
            {foreach $gateways as $gateway}
                <label class="radio-inline">
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
            {/foreach}
        </div>
    </div>

    <div class="alert alert-danger text-center gateway-errors w-hidden"></div>

    <div class="clearfix"></div>

    <div class="cc-input-container{if $selectedgatewaytype neq "CC"} w-hidd1en{/if}" id="creditCardInputFields">
        {if $client}
            <div id="existingCardsContainer" class="existing-cc-grid">
                {include file="orderforms/standard_cart/includes/existing-paymethods.tpl"}
            </div>
        {/if}
        <div class="row cvv-input" id="existingCardInfo">
            <div class="col-lg-3 col-sm-4">
                <div class="form-group prepend-icon">
                    <label for="inputCardCVV2" class="field-icon">
                        <i class="fas fa-barcode"></i>
                    </label>
                    <div class="input-group">
                        <input type="tel" name="cccvv" id="inputCardCVV2" class="field form-control" placeholder="{$LANG.creditcardcvvnumbershort}" autocomplete="cc-cvc">
                        <span class="input-group-btn input-group-append">
                                            <button type="button" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="<img src='{$BASE_PATH_IMG}/ccv.gif' width='210' />">
                                                ?
                                            </button>
                                        </span>
                    </div>
                    <span class="field-error-msg">{lang key="paymentMethodsManage.cvcNumberNotValid"}</span>
                </div>
            </div>
        </div>

        <ul>
            <li>
                <label class="radio-inline">
                    <input type="radio" name="ccinfo" value="new" id="new" {if !$client || $client->payMethods->count() === 0} checked="checked"{/if} />
                    &nbsp;
                    {lang key='creditcardenternewcard'}
                </label>
            </li>
        </ul>

        <div class="row" id="newCardInfo">
            <div id="cardNumberContainer" class="col-sm-6 new-card-container">
                <div class="form-group prepend-icon">
                    <label for="inputCardNumber" class="field-icon">
                        <i class="fas fa-credit-card"></i>
                    </label>
                    <input type="tel" name="ccnumber" id="inputCardNumber" class="field form-control cc-number-field" placeholder="{$LANG.orderForm.cardNumber}" autocomplete="cc-number" data-message-unsupported="{lang key='paymentMethodsManage.unsupportedCardType'}" data-message-invalid="{lang key='paymentMethodsManage.cardNumberNotValid'}" data-supported-cards="{$supportedCardTypes}" />
                    <span class="field-error-msg"></span>
                </div>
            </div>
            <div class="col-sm-3 new-card-container">
                <div class="form-group prepend-icon">
                    <label for="inputCardExpiry" class="field-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </label>
                    <input type="tel" name="ccexpirydate" id="inputCardExpiry" class="field form-control" placeholder="MM / YY{if $showccissuestart} ({$LANG.creditcardcardexpires}){/if}" autocomplete="cc-exp">
                    <span class="field-error-msg">{lang key="paymentMethodsManage.expiryDateNotValid"}</span>
                </div>
            </div>
            <div class="col-sm-3" id="cvv-field-container">
                <div class="form-group prepend-icon">
                    <label for="inputCardCVV" class="field-icon">
                        <i class="fas fa-barcode"></i>
                    </label>
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
                        <label for="inputCardStart" class="field-icon">
                            <i class="far fa-calendar-check"></i>
                        </label>
                        <input type="tel" name="ccstartdate" id="inputCardStart" class="field form-control" placeholder="MM / YY ({$LANG.creditcardcardstart})" autocomplete="cc-exp">
                    </div>
                </div>
                <div class="col-sm-3 new-card-container">
                    <div class="form-group prepend-icon">
                        <label for="inputCardIssue" class="field-icon">
                            <i class="fas fa-asterisk"></i>
                        </label>
                        <input type="tel" name="ccissuenum" id="inputCardIssue" class="field form-control" placeholder="{$LANG.creditcardcardissuenum}">
                    </div>
                </div>
            {/if}
        </div>
        <div id="newCardSaveSettings">
            <div class="row form-group new-card-container">
                <div id="inputDescriptionContainer" class="col-md-6">
                    <div class="prepend-icon">
                        <label for="inputDescription" class="field-icon">
                            <i class="fas fa-pencil"></i>
                        </label>
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