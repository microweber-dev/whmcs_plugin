<?php include 'partials/header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat+Alternates:300,400,600,700,800&display=swap');

    * {
        font-family: 'Montserrat Alternates', sans-serif;
        outline: none !important;
    }

    body {
        background: transparent !important;
    }

    #user_registration_form #domain-search-field {
        height: 70px;
        font-size: 18px;
        background: #fff;
        border-radius: 1px;
        /*box-shadow: 0 0 7px rgba(0, 0, 0, 0.2);*/
        outline: none;
        width: 100%;
        padding: 0 30px;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
        font-weight: bold;
        border: 1px solid #b8b8b8;
    }

    .input-holder,
    .fixed-container,
    .provide-domains {
        /*max-width: 820px;*/
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
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;

        padding: 15px 30px;
        background: white;
        margin: 0 0 4px 0;
        color: #393939;
    }

    .domain-item .startWith {
        color: #393939;
        font-size: 14px;
    }

    .domain-item .di-price {
        text-align: center;
        width: 100px;
        display: inline-block;
        right: 45px;
        top: 2px;
        font-size: 14px;
        margin: 0 10px;
    }

    .domain-item.can-start {
        cursor: pointer;
    }

    .domain-item.can-start:hover {
        color: #0086db;
        -webkit-box-shadow: 0 0 10px #0086db;
        box-shadow: 0 0 3px #0086db;
    }

    .domain-item.cant-start:hover {
        color: #393939;
        -webkit-box-shadow: 0 0 10px #393939;
        box-shadow: 0 0 3px #393939;
    }

    .domain-item .last-div:after {
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

    .domain-item.cant-start .last-div:after {
        visibility: hidden;
    }

    .domain-item:hover .last-div:after {
        color: #0086db;
    }

    .domain-item > div:nth-child(1) {
        flex: 1;
    }

    .domain-item > div:nth-child(2) {
        flex: 2;
        width: 280px;
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
        margin-top: 23px;
        margin-right: 145px;
        background-image: url('assets/img/domain-search/clear-domain.png');
        width: 18px;
        height: 18px;
        outline: none;
        cursor: pointer;
        visibility: hidden;
    }

    .clear-domain.visible {
        visibility: visible;
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

    .not-available-tag {
        background: #999999;
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
            width: 70%;
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

    .ajax-loading .domainName,
    .ajax-loading .di-price {
        background-color: #dcdcdc;
        color: #dcdcdc;
        border-radius: 3px;
    }

    .ajax-loading-placeholder {
        display: none;
    }

    .just-text {
        color: #2d2d2d;
        font-size: 50px;
    }

    .just-text small {
        color: #ff4200;
        font-size: 18px;
    }

    @media screen and (max-width: 1199px) {
        .just-text {
            font-size: 42px;
        }

        .just-text small {
            font-size: 16px;
        }
    }

    @media screen and (max-width: 991px) {
        .just-text {
            font-size: 30px;
        }

        .just-text small {
            font-size: 14px;
        }
    }

    .subdomain-holder {
        border: 0;
        position: absolute;
        right: 0;
        margin-top: 11px;
        margin-right: 12px;
        height: 50px;
        outline: none;
        cursor: pointer;
        background-color: #f6fafb;
        font-size: 30px;
        color: #2d2d2d;
        font-weight: 600;
        padding: 5px 20px;
    }

    .subdomain-holder .text-blue {
        color: #2626ff;
    }

    .subdomain-holder .text-red {
        color: #ff4200;
    }

    h1 {
        font-size: 50px;
        font-weight: bold;
    }

    /*    @media screen and (max-width: 1365px) {
            h1 {
                font-size: 42px;
            }
        }

        @media screen and (max-width: 1199px) {
            h1 {
                font-size: 36px;
            }
        }

        @media screen and (max-width: 991px) {
            h1 {
                font-size: 32px;
            }
        }*/

    @media screen and (max-width: 767px) {
        h1 {
            font-size: 26px;
        }

        .subdomain-holder{
            display: none;
        }
    }
</style>

<script>
    $(document).ready(function () {
        $(document).on('mouseover', '.domain-item:not(.placeholder)', function () {
            var sld = '';
            var tld = $(this).data('tld');
            var buttonText = sld + '<span class="text-blue">' + tld + '</span>';
            $('.js-search-domains').html(buttonText);
        });
        $(document).on('mouseleave', '.domain-item:not(.placeholder)', function () {
            var buttonText = '<span class="text-blue">.</span>microweber<span class="text-blue">.me</span>';
            $('.js-search-domains').html(buttonText);
        });
    })

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

                var tmpl_unavailable = '   <div class="domain-item cant-start" data-domain="' + item.domain + '" data-sld="' + item.sld + '" data-tld="' + item.tld + '" data-subdomain="' + item.subdomain + '">' +
                    '<div class=" text-left"><span class="domainName ">' + item.domain + '</span></div> ' +
                    '<div class="right last-div"> ' +
                    '<span class="not-available-tag">Unavailable</span> ' +
                    '<span class="di-price">&nbsp;</span> ' +
                    '</div> ' +
                    '<div class="clearfix"></div> ' +
                    '</div>';

                var tmpl_free = '   <div class="domain-item can-start" data-domain="' + item.domain + '" data-sld="' + item.sld + '" data-tld="' + item.tld + '" data-subdomain="' + item.subdomain + '" data-target="top">' +
                    '<div class=" text-left"><span class="domainName ">' + item.domain + '</span></div> ' +
                    '<div class="right last-div"> ' +
                    '<span class="domain-free-tag">Free</span> ' +
                    '<span class="di-price">' + item.price + '</span> ' +
                    '</div> ' +
                    '<div class="clearfix"></div> ' +
                    '</div>';

                var tmpl_paid = '   <div class="domain-item can-start" data-domain="' + item.domain + '" data-sld="' + item.sld + '" data-tld="' + item.tld + '" data-subdomain="' + item.subdomain + '" data-target="top">' +
                    '<div class=" text-left"><span class="domainName ">' + item.domain + '</span></div> ' +
                    '<div class="right last-div"> ' +
                    '<span class="domain-recommended-tag">Available</span> ' +
                    '<span class="di-price">' + item.price + '</span> ' +
                    '</div> ' +
                    '<div class="clearfix"></div> ' +
                    '</div>';


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



<section class="section-60 p-t-30 p-b-30 fx-particles">
    <div class="container">
        <div class="row flexbox-container">
            <div class="col-md-12 fx-deactivate allow-drop">
                <div class="just-text m-b-40">
                    <div class="row" style="display: flex;">
                        <div class="col-sm-7">
                            <h1 class="m-b-10">Choose a name
                                <small>(domain)</small>
                                <br/>for your site
                            </h1>
                        </div>
                        <div class="col-sm-5">
                            <div style="height: 100%; display: flex; flex-flow: column; justify-content: flex-end; text-align: right;">
                                <p>Connect your domain anytime.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="domain-selector">
                    <form id="user_registration_form" method="post" action="<?php echo $current_url ?>" class="clearfix">

                        <?php
                        $whitelabelSettings = get_whitelabel_settings();
                        ?>

                        <div class="input-holder">
                            <?php
                            if (isset($whitelabelSettings['free_subdomains'])):
                                $freeDomains = explode(',', $whitelabelSettings['free_subdomains']);
                            ?>
                            <button class="subdomain-holder js-search-domains" type="submit">
                                <span class="text-primary">.</span>virtua<span class="text-primary"><?php echo $freeDomains[0]; ?></span>
                            </button>
                            <?php
                            endif;
                            ?>
                            <input type="text" name="domain" placeholder="Type the name here" tabindex="1" autocomplete="off" id="domain-search-field" value=""/>
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
                                <div class="domain-item cant-start placeholder">
                                    <div class=" text-left"><span class="domainName ">microweber.com</span></div>
                                    <div class="right last-div">
                                        <span class="not-available-tag">Unavailable</span>
                                        <span class="di-price">&nbsp;</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="domain-item can-start placeholder">
                                    <div class=" text-left"><span class="domainName ">microweber.com</span></div>
                                    <div class="right last-div">
                                        <span class="domain-free-tag">Free</span>
                                        <span class="di-price">$0.00</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="domain-item can-start placeholder">
                                    <div class=" text-left"><span class="domainName ">microweber.com</span></div>
                                    <div class="right last-div">
                                        <span class="domain-recommended-tag">Available</span>
                                        <span class="di-price">$10.00</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</section>


<?php include 'partials/footer.php'; ?>
