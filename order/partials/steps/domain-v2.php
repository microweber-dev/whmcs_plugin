<style>
    body {
        background-color: #f5f5f5;
    }

    #domain-search-field {
        font-size: 60px;
        outline: none;
        width: 100%;
        padding: 0 40px 0 0;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
        color: #000;
        background: transparent;
        border: 0;
        line-height: 1;
        margin-bottom: 30px;
    }

    #domain-search-field::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: #d2d2d2;
        opacity: 1; /* Firefox */
    }

    #domain-search-field:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #d2d2d2;
    }

    #domain-search-field::-ms-input-placeholder { /* Microsoft Edge */
        color: #d2d2d2;
    }

    .input-holder,
    .fixed-container,
    .provide-domains {
        margin: 0 auto;
        position: relative;
    }

    .provide-domains {
        font-size: 12px;
        color: #8c8c8c;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .domain-search-field-on #domain-search-field {
        padding-left: 45px;
    }

    .domain-item {
        display: block;
        padding: 17px 15px 17px 15px;
        margin: 0 0 4px 0;
        color: #393939;
        cursor: pointer;
    }

    .domain-item:hover {
        -webkit-box-shadow: 0 0 10px #9e9e9e;
        box-shadow: 0 0 3px #9e9e9e;
        background: white;
    }

    .domain-item .di-price:after {
        display: block;
        float: right;
        width: 20px;
        height: 20px;
        content: '';
        background-image: url('assets/img/domain-search/cart.png');
        font-size: 34px;
        line-height: 19px;
        color: #969696;
    }

    .domain-item .startWith {
        color: #393939;
        font-size: 14px;
    }

    .user_registration_form_msg {
        margin-bottom: 25px;
    }

    .user_registration_form_msg .urf {
        font-size: 16px;
        color: #fff;
        padding: 20px;
    }

    .user_registration_form_msg .urf .icon {
        display: block;
        float: left;
        margin-right: 20px;
        margin-top: 10px;
        margin-top: 15px;
        margin-left: 20px;
    }

    .user_registration_form_msg .urf.urf_warn {
        background: #f7af15;
    }

    .user_registration_form_msg .urf.urf_warn .icon {
        background-image: url('assets/img/domain-search/domain-warn.png');
        width: 22px;
        height: 27px;
    }

    .user_registration_form_msg .urf.urf_success {
        background: #00cc6e;
    }

    .user_registration_form_msg .urf.urf_success .icon {
        background-image: url('assets/img/domain-search/domain-success.png');
        width: 21px;
        height: 21px;
    }

    .clear-domain {
        background: none;
        border: 0;
        position: absolute;
        right: 0;
        margin-top: 37px;
        margin-right: 22px;
        background-image: url('assets/img/domain-search/clear-domain-2.png');
        width: 14px;
        height: 15px;
        outline: none;
        cursor: pointer;
    }

    .search-domain {
        border: 0;
        position: absolute;
        right: 0;
        margin-top: 11px;
        margin-right: 12px;
        width: 120px;
        height: 38px;
        outline: none;
        cursor: pointer;
    }

    .domain-search-field-on .clear-domain {
        background-image: url('assets/img/domain-search/712.gif');
        background-size: contain;
        background-position: center;
        right: auto;
        left: 15px;

    }

    @media screen and (max-width: 480px) {
        #domain-search-field {
            font-size: 16px;
        }
    }

    .domain-recommended-tag {
        background: #0086DB;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        color: #fff;
        text-transform: uppercase;
        font-size: 11px;
        margin-left: 15px;
        padding: 2px 10px;
        letter-spacing: 1px;
    }

    .domain-free-tag {
        background: #00cc6e;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        color: #fff;
        text-transform: uppercase;
        font-size: 11px;
        margin-left: 15px;
        padding: 2px 10px;
        letter-spacing: 1px;
    }

    @media screen and (min-width: 1200px) {
        #domain-selector {
            margin: 0 auto;
        }
    }

    @media screen and (max-width: 767px) {
        .domain-item {
            padding: 15px 5px;
        }

        .domain-recommended-tag,
        .domain-free-tag {
            margin-left: 0px;
        }
    }

    .unavailable,
    .free,
    .di-price {
        width: 120px;
        display: inline-block;
        position: absolute;
        top: 2px;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 2px;
        right: 0;

    }

    .di-price {
        font-weight: 700;
    }

    .free {
        text-transform: uppercase;
    }

    .unavailable {
        color: #999999;
        text-transform: uppercase;
    }

    .unavailable-item .domainName {
        color: #999999;
    }

    .domainName {
        font-size: 16px;
    }

    .right-side-holder:after {
        clear: both;
        content: '';
    }

    .clearfix {
        clear: both;
        content: '';
    }

    @media screen and (max-width: 991px) {
        #domain-search-field {
            font-size: 40px;
            padding-left: 20px;
        }

        .clear-domain {
            margin-top: 25px;
        }
    }

    @media screen and (max-width: 767px) {
        #domain-search-field {
            font-size: 25px;
            padding-left: 20px;
        }

        .clear-domain {
            margin-top: 12px;
        }

    }

    @media screen and (max-width: 767px) {
        .right-side-holder {
            width: 100%;
            text-align: center;
        }

        .domain-item .text-left {
            text-align: center;
            margin-bottom: 10px;
        }

        .unavailable, .free, .di-price {
            position: static;
        }
    }

</style>

<script>
    $(document).ready(function () {

        $('#domain-search-field').focus();

        $('#domain-search-field').keyup(function () {
            if ($(this).val().length > 0) {
                $('.section-61').addClass('blur');
            } else {
                $('.section-61').removeClass('blur');
            }
        })
    })
</script>


<script>
    function render_domain_search_list(results) {
        $("#domain-search-field-autocomplete").html('');

        var all_res_render = '';

        if (results) {
            console.log(results);
            $.each(results, function (i, item) {
                var is_free = false;
                if (item.is_free) {
                    is_free = true;
                }

                var is_available = false;
                if (item.status == 'available') {
                    is_available = true;
                }

                var tmpl_unavailable = '<div class="domain-item unavailable-item" data-domain="' + item.domain + '" data-sld="' + item.sld + '" data-tld="' + item.tld + '" data-subdomain="' + item.subdomain + '"> ' +
                    '<div class="col-xs-12 col-sm-6 text-left"><span class="domainName">' + item.domain + '</span></div> ' +
                    '<div class="col-xs-12 col-sm-6"> <div class="right-side-holder"> <span class="unavailable">Unavailable</span> </div> </div> ' +
                    '<div class="clearfix"></div>' +
                    ' </div>';

                var tmpl_free = '<div class="domain-item can-start is_free" data-domain="' + item.domain + '" data-sld="' + item.sld + '" data-tld="' + item.tld + '" data-subdomain="' + item.subdomain + '"> ' +
                    '<div class="col-xs-12 col-sm-6 text-left"><span class="domainName is_free">' + item.domain + '</span></div> ' +
                    '<div class="col-xs-12 col-sm-6"> <div class="right-side-holder"><span class="free">Free</span> </div> </div> ' +
                    '<div class="clearfix"></div>' +
                    ' </div>';

                var tmpl_paid = '<div class="domain-item can-start" data-domain="' + item.domain + '" data-sld="' + item.sld + '" data-tld="' + item.tld + '" data-subdomain="' + item.subdomain + '"> ' +
                    '<div class="col-xs-12 col-sm-6 text-left"><span class="domainName">' + item.domain + '</span></div> ' +
                    '<div class="col-xs-12 col-sm-6"> <div class="right-side-holder"><span class="di-price">' + item.price + '</span><span class="buy-cart"></span> </div> </div> ' +
                    '<div class="clearfix"></div>' +
                    ' </div>';


                var $tpl;
                if (is_available == false) {
                    $tpl = tmpl_unavailable;
                } else {
                    if (is_free) {
                        $tpl = tmpl_free;
                    } else {
                        $tpl = tmpl_paid;
                    }
                }

                all_res_render = all_res_render + $tpl;
            });

            $("#domain-search-field-autocomplete").html(all_res_render);
            $("#domain-search-field-autocomplete").removeClass('ajax-loading');


            if (typeof(resize_iframe_to_parent) != 'undefined') {
                resize_iframe_to_parent()
            }

        }
    }
</script>

<section class="section-61 fx-particles p-t-70" style="height: calc(100vh - 250px);">
    <div class="section-bg" style="background-image: url('assets/img/domain-search/bg.png');"></div>
    <div class="section-bg-blur" style="background-image: url('assets/img/domain-search/bg-blur.png');"></div>
    <div class="container">
        <div class="row flexbox-container">
            <div class="col-lg-8 col-lg-offset-2 fx-deactivate allow-drop">

                <div class="just-text m-b-20">
                    <h1>Choose the name of your website. It's called domain name.</h1>
                    <p>Search in the field below. Register today the name and be sure the domain is yours.</p>
                </div>

                <div id="domain-selector">
                    <form id="user_registration_form" method="post" action="<?php echo $current_url ?>" class="clearfix">
                        <div class="input-holder">
                            <button class="btn btn-default search-domain search-domain js-search-domains" style="display: none;" type="submit">Search</button>
                            <input type="text" name="domain" placeholder="start typing to search" tabindex="1" autocomplete="off" id="domain-search-field" value=""/>
                        </div>

                        <div class="fixed-container user_registration_form_msg">
                            <div class="urf urf_warn" style="display: none;">
                                <div class="icon"></div>
                                <strong><span class="var-websiteName">DomainName.com</span> is taken.</strong> Try new one!<br/>
                                If this is your domain, <u>you can map it with MicroWeber.com Premium.</u>
                            </div>
                            <div class="urf urf_success" style="display: none;">
                                <div class="icon"></div>
                                <strong><span class="var-websiteName">DomainName.com</span> is available!</strong> Get it now!<br/>
                                Purchase this domain name right now <u>with hosting and website.</u>
                            </div>
                        </div>

                        <div id="domain-search-field-autocomplete" class="fixed-container m-b-20 ajax-loading">
                            <div class="js-autocomplete-placeholder ajax-loading-placeholder">

                               <!-- <div class="domain-item">
                                    <div class="col-xs-12 col-sm-6 text-left"><span class="domainName ">yourdomain.com</span></div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="right-side-holder">
                                            <span class="di-price">$19.00/yr</span><span class="buy-cart"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="domain-item ">
                                    <div class="col-xs-12 col-sm-6 text-left"><span class="domainName ">yourdomain.com</span></div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="right-side-holder">
                                            <span class="di-price">$19.00/yr</span><span class="buy-cart"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="domain-item  is_free ">
                                    <div class="col-xs-12 col-sm-6 text-left"><span class="domainName  is_free ">yourdomain.microweber.com</span></div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="right-side-holder">
                                            <span class="free">Free</span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="domain-item ">
                                    <div class="col-xs-12 col-sm-6 text-left"><span class="domainName ">yourdomain.com</span></div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="right-side-holder">
                                            <span class="di-price">$19.00/yr</span><span class="buy-cart"></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="domain-item unavailable-item">
                                    <div class="col-xs-12 col-sm-6 text-left"><span class="domainName">yourdomain.com</span></div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="right-side-holder">
                                            <span class="unavailable">Unavailable</span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>-->
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</section>