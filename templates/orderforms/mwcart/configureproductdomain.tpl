<div class="mw-whm">

    <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css"/>

    <div id="order-modern">

        <div class="col-sm-12 mb-5 px-0 py-5">
            <h1 class="choose-a-domain-h1">{$LANG.cartproductselection}: {$productinfo.groupname} - {$productinfo.name}</h1>
            <p>{$LANG.cartmakedomainselection}</p>
        </div>

        <form onsubmit="checkdomain();return false">

            <div class="row">
                <div class=" col-sm-12">
                    <div class="row domainoptions">
                       <div class="p-4 m-3">
                           {if $incartdomains}
                               <div class="offset-md-2  p-1 option">
                                   <label class="radio-inline">
                                       <input type="radio" class="input-select-domaintransfer" placeholder="{$LANG.MW_searchDomain}" name="domainoption" value="incart" id="selincart"/><span class="ms-3">{$LANG.cartproductdomainuseincart}</span>
                                   </label>
                               </div>
                           {/if}
                           {if $registerdomainenabled}
                               <div class="offset-md-2  p-1 option">
                                   <label class="radio-inline">
                                       <input type="radio" class="input-select-domaintransfer" name="domainoption" value="register" id="selregister"/><span class="ms-3">{$LANG.cartregisterdomainchoice|sprintf2:$companyname}</span>
                                   </label>
                               </div>
                           {/if}
                           {if $transferdomainenabled}
                               <div class="offset-md-2  p-1 option">
                                   <label class="radio-inline">
                                       <input type="radio" class="input-select-domaintransfer" name="domainoption" value="transfer" id="seltransfer"/><span class="ms-3">{$LANG.carttransferdomainchoice|sprintf2:$companyname}</span>
                                   </label>
                               </div>
                           {/if}
                           {if $owndomainenabled}
                               <div class="offset-md-2  p-1 option">
                                   <label class="radio-inline">
                                       <input type="radio" class="input-select-domaintransfer" name="domainoption" value="owndomain" id="selowndomain"/><span class="ms-3">{$LANG.cartexistingdomainchoice|sprintf2:$companyname}</span>
                                   </label>
                               </div>
                           {/if}
                           {if $subdomains}
                               <div class="offset-md-2  p-1 option">
                                   <label class="radio-inline">
                                       <input type="radio" class="input-select-domaintransfer" name="domainoption" value="subdomain" id="selsubdomain"/><span class="ms-3">{$LANG.cartsubdomainchoice|sprintf2:$companyname}</span>
                                   </label>

                               </div>
                           {/if}
                       </div>





                            <div class="domainreginput hidden clearfix" id="domainincart">
                                <div class="row-blue">
                                    <div class="col-sm-8 col-md-6">
                                        <select id="incartsld" name="incartdomain" class="form-control">
                                            {foreach key=num item=incartdomain from=$incartdomains}
                                                <option value="{$incartdomain}">{$incartdomain}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>



                            <div class="domainreginput hidden clearfix" id="domainregister">
                                <div class="row-blue">
                                    <div class="col-md-6 col-12">
                                        <div class="input-group" style="display: block;">
                                            {*                                                <span class="input-group-addon">www.</span>*}
                                            <input type="text" id="registersld" value="{$sld}" class="form-control" placeholder="{$LANG.MW_searchDomain}" autocapitalize="none"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-2 col-6 padding-on-mobile">
                                        <select id="registertld" class="form-control">
                                            {foreach from=$registertlds item=listtld}
                                                <option value="{$listtld}"{if $listtld eq $tld}  selected="selected"{/if}>{$listtld}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="domainreginput hidden clearfix" id="domaintransfer">
                                <div class="row-blue">
                                    <div class="col-md-6 col-12">
                                        <div class="input-group" style="display: block;">
                                            {*                                                <span class="input-group-addon">www.</span>*}
                                            <input type="text" id="transfersld" value="{$sld}" placeholder="{$LANG.MW_transferDomain}" class="form-control" autocapitalize="none"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-2 col-6 padding-on-mobile">
                                        <select id="transfertld" class="form-control">
                                            {foreach from=$transfertlds item=listtld}
                                                <option value="{$listtld}"{if $listtld eq $tld}  selected="selected"{/if}>{$listtld}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="domainreginput hidden clearfix" id="domainowndomain">
                                <div class="row-blue">
                                    <div class="col-md-6 col-12" >
                                        <div class="input-group" style="display: block;">
                                            {*                                                <span class="input-group-addon">www.</span>*}
                                            <input type="text" id="owndomainsld" value="{$sld}" placeholder="{$LANG.MW_typeYourDomain}" class="form-control" autocapitalize="none"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-2 col-6 padding-on-mobile">
                                        <input type="text" id="owndomaintld" value="{$tld|substr:1}" placeholder="com" class="form-control" autocapitalize="none"/>
                                    </div>
                                </div>

                            </div>


                            <div class="domainreginput hidden" id="domainsubdomain">
                                <div class="row-blue">
                                    <div class="col-md-6 col-12">
                                        <div class="input-group" class="input-select-domaintransfer" style="display: block;">
                                            {*                                                <span class="input-group-addon">http://</span>*}
                                            <input type="text"  id="subdomainsld" size="30" placeholder="{$LANG.MW_typeYourSubDomain}" value="{$sld}" autocapitalize="none" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-2 col-8 padding-on-mobile">
                                        <select id="subdomaintld" class="form-control">
                                            {foreach from=$subdomains key=subid item=subdomain}
                                                <option value="{$subid}">{$subdomain}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>



                    </div>
                </div>
            </div>

            <div class="domain-fade-out">

                <div class="text-center mt-5">
                    <button type="submit" id="btnDomainContinue" class="whmc-kbtn">{$LANG.continue} &nbsp;<i class="fa fa-arrow-circle-right"></i></button>
                </div>

                {if $freedomaintlds}<p>* <em>{$LANG.orderfreedomainregistration} {$LANG.orderfreedomainappliesto}: {$freedomaintlds}</em></p>{/if}

            </div>

        </form>

        <div id="greyout"></div>

        <div id="domainpopupcontainer">
            <form id="domainfrm" onsubmit="completedomain();return false">
                <div class="domainresults" id="domainresults">
                    <img src="assets/img/loading.gif" border="0" alt="Loading..."/>
                </div>
            </form>
        </div>

        <div id="prodconfigcontainer" class="hidden"></div>

        <div class="clearfix"></div>

    </div>

    {literal}
    <script language="javascript">
        jQuery(".domainoptions input:first").attr('checked', 'checked');
        jQuery(".domainoptions input:first").parent().parent().addClass('optionselected');
        jQuery("#domain" + jQuery(".domainoptions input:first").val()).removeClass('hidden').show();
        jQuery(document).ready(function () {
            jQuery(".domainoptions input:radio").click(function () {
                jQuery(".domainoptions .option").removeClass('optionselected');
                jQuery(this).parent().parent().addClass('optionselected');
                jQuery(".domainreginput").hide();
                jQuery("#domain" + jQuery(this).val()).removeClass('hidden').show();
            });
        });
        function checkdomain() {
            jQuery("#greyout").fadeIn();
            jQuery("#domainpopupcontainer").hide().removeClass('hidden').slideDown();
            var domainoption = jQuery(".domainoptions input:checked").val();
            var sld = jQuery("#" + domainoption + "sld").val();
            var tld = '';
            if (domainoption == 'incart') var sld = jQuery("#" + domainoption + "sld option:selected").text();
            if (domainoption == 'subdomain') var tld = jQuery("#" + domainoption + "tld option:selected").text();
            else var tld = jQuery("#" + domainoption + "tld").val();
            jQuery.post("cart.php", {ajax: 1, a: "domainoptions", sld: sld, tld: tld, checktype: domainoption},
                function (data) {
                    jQuery("#domainresults").html(data);
                });
        }
        function cancelcheck() {
            jQuery("#domainpopupcontainer").slideUp('slow', function () {
                jQuery("#greyout").fadeOut();
                jQuery("#domainresults").html('<img src="assets/img/loading.gif" border="0" alt="Loading..." />');
            });
        }
        function completedomain() {
            jQuery("#domainresults").append('<img src="assets/img/loading.gif" border="0" alt="Loading..." />');
            jQuery.post("cart.php", 'ajax=1&a=add&pid={/literal}{$pid}{literal}&domainselect=1&' + jQuery("#domainfrm").serialize(),
                function (data) {
                    if (data == '') {
                        window.location = 'cart.php?a=view';
                    } else if (data == 'nodomains') {
                        jQuery("#domainpopupcontainer").slideUp('slow', function () {
                            jQuery("#greyout").fadeOut();
                        });
                    } else {
                        jQuery("#prodconfigcontainer").html(data);
                        jQuery(".domain-fade-out").fadeOut();
                        jQuery("#domainpopupcontainer").slideUp('slow', function () {
                            jQuery("#greyout").fadeOut();
                        });
                        jQuery("#prodconfigcontainer").hide().removeClass('hidden').slideDown();
                    }
                });
        }
    </script>
    {/literal}
</div>