{if $cartitems!=0}
    <form method="post" action="{$smarty.server.PHP_SELF}?a=checkout" id="frmCheckout">
        <input type="hidden" name="submit" value="true"/>
        <input type="hidden" name="custtype" id="custtype" value="{$custtype}"/>

        {if !$loggedin}
            <h1>Choose customer type</h1>
            <div class="radio-buttons-wrapper row">
                <ul class="radio-buttons">
                    <li class="signuptype {if !$loggedin && $custtype neq "existing"}active{/if}" {if !$loggedin}id="newcust"{/if}>
                        <input type="radio" name="whatuser" id="new" value="" {if !$loggedin && $custtype neq "existing"}checked{/if} >
                        <label for="new"><span class="per" style="font-size: 16px;">{$LANG.newcustomer}</span></label>

                        <div class="check"></div>
                    </li>

                    <li class="signuptype {if $custtype eq "existing" && !$loggedin || $loggedin}active{/if}" id="existingcust">
                        <input type="radio" name="whatuser" id="existing" value="" {if $custtype eq "existing" && !$loggedin || $loggedin}checked{/if} >
                        <label for="existing"><span class="per" style="font-size: 16px;">{$LANG.existingcustomer}</span></label>

                        <div class="check"></div>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
        {/if}
        <div class="clear"></div>

        {include file="orderforms/mwcart/includes/forms/new-customer.tpl"}

        {if $securityquestions && !$loggedin}
            <div class="panel panel-default" id="securityQuestion">
                <div class="panel-heading">
                    <h3 class="panel-title">{$LANG.clientareasecurityquestion}:</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group col-sm-12">
                        <select name="securityqid" id="securityqid" class="form-control">
                            {foreach key=num item=question from=$securityquestions}
                                <option value={$question.id}>{$question.question}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="securityqans">{$LANG.clientareasecurityanswer}</label>
                        <div class="col-sm-6">
                            <input type="password" name="securityqans" id="securityqans" class="form-control"/>
                        </div>
                    </div>
                </div>
            </div>
        {/if}

        {if $taxenabled && !$loggedin}
            <div class="carttaxwarning">
                {$LANG.carttaxupdateselections}
                <input type="submit" value="{$LANG.carttaxupdateselectionsupdate}" name="updateonly" id="btnUpdateOnly" class="btn btn-info btn-sm"/>
            </div>
        {/if}

        {include file="orderforms/mwcart/includes/forms/domain-registrant-information.tpl"}
        <br/>


        <div class="row   {if $rawtotal == 0} hidden {/if}">
            <div class="col-md-12">
                {if $shownotesfield}
                    <div class="signupfields padded">
                        <h1>{$LANG.ordernotes}</h1>
                        <textarea name="notes" rows="3" class="form-control" placeholder="{$LANG.ordernotesdescription}">{$orderNotes}</textarea>
                    </div>
                {/if}

                <div class="signupfields padded">
                    <h1>{$LANG.orderpaymentmethod}</h1>

                    <div class="radio-buttons-wrapper row">
                        <ul class="radio-buttons">
                            {foreach key=num item=gateway from=$gateways}
                                <li class="{if $selectedgateway eq $gateway.sysname}active{/if}">
                                    <input type="radio" name="paymentmethod" value="{$gateway.sysname}" id="pgbtn{$num}"
                                           onclick="{if $gateway.type eq "CC"}showCCForm(){else}hideCCForm(){/if}" {if $selectedgateway eq $gateway.sysname}checked{/if} >
                                    <label for="pgbtn{$num}"><span class="per" style="font-size: 16px;">{$gateway.name}</span></label>

                                    <div class="check"></div>
                                </li>
                            {/foreach}
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="alert alert-danger text-center gateway-errors hidden"></div>

                    {include file="orderforms/mwcart/includes/forms/payment-credit-card.tpl"}
                </div>

            </div>
        </div>


        <div class="clearfix"></div>


        <br/>
        {if $accepttos}
            <div align="center">
                <label class="checkbox-inline">
                    <input type="checkbox" name="accepttos" id="accepttos"/>
                    {$LANG.ordertosagreement}
                    <a href="{$tosurl}" target="_blank">{$LANG.ordertos}</a>
                </label>
            </div>
            <br/>
        {/if}
        <br/>

        <button class="btn btn-default" type="submit" id="btnCompleteOrder"{if $cartitems==0} disabled{/if}
                onclick="this.value='{$LANG.pleasewait}'" {if $custtype eq "existing" && !$loggedin}formnovalidate{/if}>{$LANG.checkout}</button>
        <br/><br/>

        {if !$loggedin}
            <div class="text-center">
                <a href="pwreset.php">Forgot your password ?</a>
                <br/><br/>
            </div>
        {/if}
        <p class="text-center">Please review the Terms of Services, Privacy and Return Policy.</p>
    </form>
{else}
    <br/>
{/if}