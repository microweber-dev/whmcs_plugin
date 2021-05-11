<div class="mw-whm">
    <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css"/>
    <script language="javascript">
        // Define state tab index value
        var statesTab = 10;
        {if in_array('state', $clientsProfileOptionalFields)}
        // Do not enforce state input client side
        var stateNotRequired = true;
        {/if}
    </script>
    <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/main.js"></script>
    <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/jquery.particleground.min.js"></script>
    <script type="text/javascript" src="templates/orderforms/{$carttpl}/js/intl-tel-input/js/intlTelInput.js"></script>
    <link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/js/intl-tel-input/css/intlTelInput.css"/>


    <script type="text/javascript" src="{$BASE_PATH_JS}/StatesDropdown.js"></script>
    <script type="text/javascript" src="{$BASE_PATH_JS}/PasswordStrength.js"></script>
    <script type="text/javascript" src="{$BASE_PATH_JS}/CreditCardValidation.js"></script>

    {literal}
    <script type="text/javascript">
        function removeItem(type, num) {
            var response = confirm("{/literal}{$LANG.cartremoveitemconfirm}{literal}");
            if (response) {
                window.location = 'cart.php?a=remove&r=' + type + '&i=' + num;
            }
        }
        function emptyCart(type, num) {
            var response = confirm("{/literal}{$LANG.cartemptyconfirm}{literal}");
            if (response) {
                window.location = 'cart.php?a=empty';
            }
        }

        jQuery(document).ready(function () {


            var telInput = $("#domaincontactphonenumber"),
                errorMsg = $("#phone-error-msg"),
                validMsg = $("#phone-valid-msg");

            // initialise plugin
            telInput.intlTelInput({
                xxxxinitialCountry: "auto",
                xxxxxxgeoIpLookup: function (callback) {
                    $.get('https://ipinfo.io', function () {
                    }, "jsonp").always(function (resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "";
                        callback(countryCode);
                    });
                },
                autoHideDialCode: true,
                nationalMode: true,
                utilsScript: "templates/orderforms/mwcart/js/intl-tel-input/js/utils.js"
            });

            var reset = function () {
                telInput.removeClass("error");
                errorMsg.addClass("hide");
                validMsg.addClass("hide");

                if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                    } else {
                        telInput.addClass("error");
                        errorMsg.removeClass("hide");
                    }
                }


            };
            var validatephonefield = function () {
                var ntlNumber = $(telInput).intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
                if (ntlNumber) {
                    //     console.log(ntlNumber);
                    //   ntlNumber.replace(/\s+/g, '').replace(/-/g, '').replace(/\(/g, '').replace(/\)/g, '')
                    // telInput.val(ntlNumber)
                }

                reset();
                if ($.trim(telInput.val())) {


                    if (telInput.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                    } else {
                        telInput.addClass("error");
                        errorMsg.removeClass("hide");
                    }
                }
            };


            telInput.blur(function () {
                validatephonefield()
            });

            telInput.on("keyup change", reset);

            telInput.on("countrychange", function (e, countryData) {

                var countryCode = (countryData.iso2).toUpperCase();
                if (document.querySelector('#domaincontactcountry [value="' + countryCode + '"]')) {
                    document.querySelector('#domaincontactcountry [value="' + countryCode + '"]').selected = true;
                }
                $('.selectpicker, .selectpicker-wrapper select').selectpicker('refresh');

            });


            $('#domaincontactcountry').change(function () {
                telInput.intlTelInput("setCountry", $(this).val());

            });


            if ($('#domaincontactfields').is(':visible')) {
                $.get('https://ipinfo.io', function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    if (countryCode) {
                        if (document.querySelector('#domaincontactcountry [value="' + countryCode + '"]')) {
                            document.querySelector('#domaincontactcountry [value="' + countryCode + '"]').selected = true;
                        }
                        $('.selectpicker, .selectpicker-wrapper select').selectpicker('refresh');
                        telInput.intlTelInput("setCountry", countryCode);
                    }
                });

            }


            $("#frmCheckout").submit(function (e) {


                if ($('#domaincontactfields').is(':visible')) {
                    $('#domaincontactphonenumber').val();

                    if ($('#domaincontactphonenumber').hasClass('error')) {
                        alert('Phone number is not valid');
                        $('#domaincontactphonenumber').focus();
                        return false;
                    }

                    var inp = $('input', '#domaincontactfields');

                    for (var i in inp) {
                        if (inp[i].type == 'text') {
                            if (!(inp[i].value)) {
                                alert('Please fill the domain registration information');
                                inp[i].focus();
                                return false;
                                break;
                            }
                        }
                    }
                }


                $('.wrapper', '.page-payments').hide();
                _sLoader()
            })
            //_sLoader();

            var preparePromoCode = function (ctx) {
                jQuery(ctx).parents('form').attr('novalidate', 'novalidate');
                jQuery('#validatepromo').val('1');
            };

            jQuery('#validatePromoCode').click(function () {
                preparePromoCode(this);
                //jQuery('#btnCompleteOrder').click();
            });

            jQuery('#inputPromoCode').keydown(function (evt) {
                if (evt.keyCode == 13) {
                    preparePromoCode(this);
                    // Enter in a form will submit the form
                }
            });
        });


        _sLoader = function () {
            $('body').addClass('mw-site-is-creating');
            $('.particles')
                .show()
                .particleground({
                    dotColor: '#60b0e3',
                    lineColor: '#60b0e3',
                    lineWidth: 1,
                    curvedLines: false,
                    proximity: 150,
                    parallax: true,
                    density: 27000
                });

            //$("#theiframeloader").html('<iframe  src="https://www.youtube.com/embed/1gy-03uv0lE?autoplay=1" frameborder="0" allowfullscreen></iframe>')
            //$("#theiframeloader").html('<iframe  src="https://www.youtube.com/embed/-ius5MMpKY4?autoplay=1" frameborder="0" allowfullscreen></iframe>')

            sitePerccent = 1;
            setInterval(function () {
                sitePerccent++
                $('#creating_site_progress_meter div').width(sitePerccent + '%')

            }, 1000);

            setInterval(function () {
                var el = $("#creating_site_progress_title");
                if (el.height() < $(window).height()) {
                    el.css({
                        top: $(window).height() / 2 - el.height() / 2
                    })
                }
                else {
                    el.css({
                        top: 50
                    })
                }

            }, 333);

            $("#creating_site_progress_title, #creating_site_progress_meter").show()
        }
    </script>

    {/literal}

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


    <div class="page-payments">
        <div class="wrapper">
            <div class="row" style="margin-bottom:30px;">
                <div class="col-xs-12 col-md-5 col-lg-6">
                    {include file="orderforms/mwcart/includes/cart-left-side.tpl"}
                </div>

                <div class="col-xs-12 col-md-7 col-lg-6">
                    <div class="subscription-block">
                        {if $errormessage}
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {$errormessage}
                            </div>
                        {elseif $promotioncode && $rawdiscount eq "0.00"}
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error!</strong> {$LANG.promoappliedbutnodiscount}
                            </div>
                        {/if}

                        {include file="orderforms/mwcart/includes/cart-right-side-review.tpl"}
                        {include file="orderforms/mwcart/includes/cart-right-side.tpl"}
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom:30px;">
                <div class="col-xs-12">
                    {if $bundlewarnings}
                        <div class="cartwarningbox">
                            <strong>{$LANG.bundlereqsnotmet}</strong><br/>
                            {foreach from=$bundlewarnings item=warning}
                                {$warning}
                                <br/>
                            {/foreach}
                        </div>
                    {/if}

                    {if !$loggedin && $currencies}
                        <div class="currencychooser">
                            <div class="btn-group" role="group">
                                {foreach from=$currencies item=curr}
                                    <a href="cart.php?a=view&currency={$curr.id}" class="btn btn-default{if $currency.id eq $curr.id} active{/if}">
                                        <img src="{$BASE_PATH_IMG}/flags/{if $curr.code eq "AUD"}au{elseif $curr.code eq "CAD"}ca{elseif $curr.code eq "EUR"}eu{elseif $curr.code eq "GBP"}gb{elseif $curr.code eq "INR"}in{elseif $curr.code eq "JPY"}jp{elseif $curr.code eq "USD"}us{elseif $curr.code eq "ZAR"}za{else}na{/if}.png"
                                             border="0" alt=""/>
                                        {$curr.code}
                                    </a>
                                {/foreach}
                            </div>
                        </div>
                    {/if}

                    {foreach from=$gatewaysoutput item=gatewayoutput}
                        <div class="clear"></div>
                        <div class="cartbuttons">
                            {$gatewayoutput}
                        </div>
                    {/foreach}


                    <div class="text-center">
                        <p>
                            <img src="assets/img/padlock.gif" align="absmiddle" border="0" alt="Secure Transaction"/>
                            &nbsp;{$LANG.ordersecure} (<strong>{$ipaddress}</strong>) {$LANG.ordersecure2}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="particles"></div>
        <div id="creating_site_progress_title">

            <div id="theiframeloader"></div>
            Creating your website..
            <div id="creating_site_progress_meter">
                <div class="mw-ui-progress-bar"></div>
            </div>
        </div>

    </div>
</div>