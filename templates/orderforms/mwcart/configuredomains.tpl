<div class="mw-whm">
    <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css"/>

    <div id="order-modern">

        <div class="text-start mb-5 py-5">


            <h1>{$LANG.cartdomainsconfig}</h1>
            <p>{$LANG.cartdomainsconfiginfo}</p>
        </div>

        {if $errormessage}
            <div class="errorbox" style="display:block;">
                {$errormessage|replace:'<li>':' &nbsp;#&nbsp; '} &nbsp;#&nbsp;
            </div>
            <br/>
        {/if}

        <form method="post" action="{$smarty.server.PHP_SELF}?a=confdomains">
            <input type="hidden" name="update" value="true"/>

            {foreach key=num item=domain from=$domains}
                <div class="row panel panel-default whmc-domain-configure-panel mb-5 pb-3" style="display: flex;">

                   <div class="mt-2 col-md-1">
                       <div class="m-3">
                           <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" x="0px" y="0px" width="64px" height="64px">
                               <ellipse class="svg-icon-prime svg-icon-stroke" cx="31.45" cy="32.38" rx="7.48" ry="7.48"></ellipse>
                               <path class="svg-icon-outline-s" d="M54.14,54.29A30.57,30.57,0,0,1,32.2,63a30.34,30.34,0,0,1-21.85-8.71A31.18,31.18,0,0,1,1,32.38a31.18,31.18,0,0,1,9.35-21.91A31.18,31.18,0,0,1,32.2,1a31.37,31.37,0,0,1,21.94,9.47A30.67,30.67,0,0,1,63,32.38,30.67,30.67,0,0,1,54.14,54.29Z"></path>
                               <path class="svg-icon-outline-s" d="M1,32.89a15.35,15.35,0,0,1,.09-2"></path>
                               <path class="svg-icon-outline-s dashed-21" d="M5.79,23.9a24.23,24.23,0,0,1,4.57-3.36C16,17.3,23.7,15.3,32.24,15.3s16.28,2,21.88,5.24a21.48,21.48,0,0,1,6.51,5.51"></path>
                               <path class="svg-icon-outline-s" d="M62.7,29.74a8,8,0,0,1,.2,2"></path>
                               <path class="svg-icon-outline-s" d="M63,31.08C63,36,59.72,41,54.12,44.23a45,45,0,0,1-22,5.65,44.17,44.17,0,0,1-21.78-5.65C4.76,41,1,36.52,1,31.59"></path>
                               <path class="svg-icon-outline-s" d="M32.87,63a16.42,16.42,0,0,1-2-.11"></path>
                               <path class="svg-icon-outline-s dashed-22" d="M24.38,59.6a23.31,23.31,0,0,1-4.11-5.32C17,48.67,15,40.93,15,32.38s2-16.29,5.23-21.89a20.92,20.92,0,0,1,6.23-7l1-.65"></path>
                               <path class="svg-icon-outline-s" d="M30.89,1.3a7.81,7.81,0,0,1,2-.27"></path>
                               <path class="svg-icon-outline-s" d="M31.41,1c4.93,0,9.44,3.86,12.67,9.46a44.62,44.62,0,0,1,5.81,21.89,44.69,44.69,0,0,1-5.81,21.9C40.85,59.88,36.34,63,31.41,63"></path>
                           </svg>
                       </div>
                   </div>
                    <div class="row col-md-11">
                        <div class="panel-heading">
                            <div class="row panel-title">

                                <div class="row" style=" align-items: center;">
                                    <div class="col-lg-6 col-12">
                                        <div>
                                            <h2 class="mb-5" style="color: #000000;">{$domain.domain}</h2>
                                        </div>
                                        {if $domain.hosting}
                                            <span class="badge-has-hosting"><i class="fas fa-check mx-2" style="#2d9f46;"></i> {$LANG.cartdomainshashosting}</span>
                                        {else}
                                            <a href="cart.php" style="color:#cc0000;">[{$LANG.cartdomainsnohosting}]</a>
                                        {/if}
                                    </div>

                                    <div class="col-lg col-12" style="text-align: right; color: #acb0b9;">
                                        <div>{$LANG.orderregperiod}: {$domain.regperiod} {$LANG.orderyears}</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row panel-body" style="display: flex; align-items: center; justify-content: center; margin: 0 40px;">

                            <div class="" style="display: none;">
                                <div class="col-sm-4">{$LANG.hosting}:</div>
                                <div class="col-sm-8">{if $domain.hosting}<span style="color:#009900;">[{$LANG.cartdomainshashosting}]</span>{else}<a href="cart.php" style="color:#cc0000;">
                                        [{$LANG.cartdomainsnohosting}]</a>{/if}</div>
                            </div>


                            {if $domain.dnsmanagement || $domain.emailforwarding || $domain.idprotection}
                                {if $domain.dnsmanagement}
                                    <div class="col-xl-3 col-12 m-4 whmc-panel-services-configure-domain p-4">

                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="me-4" name="dnsmanagement[{$num}]"{if $domain.dnsmanagementselected} checked{/if} />
                                            <label class="ms-5 mb-3" style="display: block;">
                                                {$LANG.domaindnsmanagement}
                                            </label>

                                            <span class="ms-5" style="color: #5e636e;">
                                           {$domain.dnsmanagementprice} / {$domain.regperiod} {$LANG.orderyears}
                                       </span>
                                        </label>
                                    </div>
                                {/if}

                                {if $domain.emailforwarding}
                                    <div class="col-xl-3 col-12 m-4 whmc-panel-services-configure-domain p-4">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="emailforwarding[{$num}]"{if $domain.emailforwardingselected} checked{/if} />
                                            <label class="ms-5 mb-3" style="display: block;">
                                                {$LANG.domainemailforwarding}
                                            </label>
                                            <span class="ms-5" style="color: #5e636e;">
                                            {$domain.emailforwardingprice} / {$domain.regperiod} {$LANG.orderyears}
                                        </span>
                                        </label>
                                    </div>
                                {/if}

                                {if $domain.idprotection}
                                    <div class="col-xl-3 col-12 m-4 whmc-panel-services-configure-domain p-4">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="idprotection[{$num}]"{if $domain.idprotectionselected} checked{/if} />
                                            <label class="ms-5 mb-3" style="display: block;">
                                                {$LANG.domainidprotection}
                                            </label>

                                            <span class="ms-5" style="color: #5e636e;">
                                           {$domain.idprotectionprice} / {$domain.regperiod} {$LANG.orderyears}
                                        </span>
                                        </label>
                                    </div>
                                {/if}

                                {if $domain.eppenabled}
                                   <div class="row whmc-epp-code-box mt-5 px-0" >
                                       <div class="col-12 m-md-4 pt-5 mt-5 px-0">

                                          <div class="form-group">
                                              <label class="col-md-3 col-lg-1 px-0 my-4" style="color: #5e636e; font-weight: 400;">
                                                  {$LANG.domaineppcode}:
                                              </label>
                                              <div class="col-md-9 col-lg-11 px-0">
                                                  <input type="text" name="epp[{$num}]" size="20" value="{$domain.eppvalue}" class="form-control mb-3"/>
                                                  <span style="color: #5e636e; margin-top: 10px;">{$LANG.domaineppcodedesc}</span>
                                              </div>
                                          </div>
                                       </div>
                                   </div>
                                {/if}
                            {/if}
                            {foreach from=$domain.fields key=domainfieldname item=domainfield}
                                <div class="">
                                    <div class="col-sm-4">{$domainfieldname}:</div>
                                    <div class="col-sm-8">{$domainfield}</div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            {/foreach}

            {if $atleastonenohosting}
                <h2>{$LANG.domainnameservers}</h2>
                <p>{$LANG.cartnameserversdesc}</p>
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="inputNs1" class="col-sm-3 col-sm-offset-1 control-label">{$LANG.domainnameserver1}</label>
                        <div class="col-sm-7 col-md-5">
                            <input type="text" class="form-control" id="inputNs1" name="domainns1" value="{$domainns1}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputNs2" class="col-sm-3 col-sm-offset-1 control-label">{$LANG.domainnameserver2}</label>
                        <div class="col-sm-7 col-md-5">
                            <input type="text" class="form-control" id="inputNs2" name="domainns2" value="{$domainns2}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputNs3" class="col-sm-3 col-sm-offset-1 control-label">{$LANG.domainnameserver3}</label>
                        <div class="col-sm-7 col-md-5">
                            <input type="text" class="form-control" id="inputNs3" name="domainns3" value="{$domainns3}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputNs1" class="col-sm-3 col-sm-offset-1 control-label">{$LANG.domainnameserver4}</label>
                        <div class="col-sm-7 col-md-5">
                            <input type="text" class="form-control" id="inputNs4" name="domainns4" value="{$domainns4}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputNs5" class="col-sm-3 col-sm-offset-1 control-label">{$LANG.domainnameserver5}</label>
                        <div class="col-sm-7 col-md-5">
                            <input type="text" class="form-control" id="inputNs5" name="domainns5" value="{$domainns5}"/>
                        </div>
                    </div>
                </div>
            {/if}

            <div class="text-center">
                <a href="cart.php?a=view" class="whmc-kbtn-2 mx-2"><i class="fa fa-shopping-cart" ></i> {$LANG.viewcart}</a>

                <button type="submit" class="whmc-kbtn">{$LANG.continue} &nbsp;<i class="fa fa-arrow-circle-right"></i></button>
            </div>

        </form>


    </div>
</div>
