<div class="mw-whm">

    <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css"/>

    <div id="order-modern">

        <div class="col-sm-12">
            <h1 class="choose-a-domain-h1">{$LANG.cartproductselection}: {$productinfo.groupname} - {$productinfo.name}</h1>
            <p>{$LANG.cartmakedomainselection}</p>
        </div>

        <form onsubmit="checkdomain();return false">

            <div class="row">
                <div class="col-sm-12">
                    <div class="domainoptions">
                        {if $incartdomains}
                            <div class="option">
                                <label class="radio-inline">
                                    <input type="radio" class="input-select-domaintransfer" placeholder="Search domain..." name="domainoption" value="incart" id="selincart"/>{$LANG.cartproductdomainuseincart}
                                </label>
                            </div>
                        {/if}
                        {if $registerdomainenabled}
                            <div class="option">
                                <label class="radio-inline">
                                    <input type="radio" class="input-select-domaintransfer" name="domainoption" value="register" id="selregister"/>{$LANG.cartregisterdomainchoice|sprintf2:$companyname}
                                </label>
                            </div>
                        {/if}
                        {if $transferdomainenabled}
                            <div class="option">
                                <label class="radio-inline">
                                    <input type="radio" class="input-select-domaintransfer" name="domainoption" value="transfer" id="seltransfer"/>{$LANG.carttransferdomainchoice|sprintf2:$companyname}
                                </label>
                            </div>
                        {/if}
                        {if $owndomainenabled}
                            <div class="option">
                                <label class="radio-inline">
                                    <input type="radio" class="input-select-domaintransfer" name="domainoption" value="owndomain" id="selowndomain"/>{$LANG.cartexistingdomainchoice|sprintf2:$companyname}
                                </label>
                            </div>
                        {/if}
                        {if $subdomains}
                            <div class="option">
                                <label class="radio-inline">
                                    <input type="radio" class="input-select-domaintransfer" name="domainoption" value="subdomain" id="selsubdomain"/>{$LANG.cartsubdomainchoice|sprintf2:$companyname}
                                </label>

                            </div>
                        {/if}



                        <div class="row">

                            <div class="domainreginput hidden clearfix" id="domainincart">
                                <div class="row">
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
                                <div class="row">
                                    <div class="col-sm-6 col-xs-8">
                                        <div class="input-group" style="display: block;">
                                            {*                                                <span class="input-group-addon">www.</span>*}
                                            <input type="text" id="registersld" value="{$sld}" class="form-control" placeholder="Search domain..." autocapitalize="none"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-4">
                                        <select id="registertld" class="form-control">
                                            {foreach from=$registertlds item=listtld}
                                                <option value="{$listtld}"{if $listtld eq $tld}  selected="selected"{/if}>{$listtld}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="domainreginput hidden clearfix" id="domaintransfer">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-8">
                                        <div class="input-group" style="display: block;">
                                            {*                                                <span class="input-group-addon">www.</span>*}
                                            <input type="text" id="transfersld" value="{$sld}" placeholder="Search domain..." class="form-control" autocapitalize="none"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-4">
                                        <select id="transfertld" class="form-control">
                                            {foreach from=$transfertlds item=listtld}
                                                <option value="{$listtld}"{if $listtld eq $tld}  selected="selected"{/if}>{$listtld}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="domainreginput hidden clearfix" id="domainowndomain">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-8" >
                                        <div class="input-group" style="display: block;">
                                            {*                                                <span class="input-group-addon">www.</span>*}
                                            <input type="text" id="owndomainsld" value="{$sld}" placeholder="Search domain..." class="form-control" autocapitalize="none"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-4">
                                        <input type="text" id="owndomaintld" value="{$tld|substr:1}" placeholder="com" class="form-control" autocapitalize="none"/>
                                    </div>
                                </div>

                            </div>


                            <div class="domainreginput hidden" id="domainsubdomain">
                                <div class="row">
                                    <div class="col-sm-5 col-xs-7">
                                        <div class="input-group" class="input-select-domaintransfer" style="display: block;">
                                            {*                                                <span class="input-group-addon">http://</span>*}
                                            <input type="text"  id="subdomainsld" size="30" placeholder="Search domain..." value="{$sld}" autocapitalize="none" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-5">
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
            </div>

            <div class="domain-fade-out">

                <div class="text-center">
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