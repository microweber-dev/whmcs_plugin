<?php include 'partials/header.php'; ?>

<style>
    @import url('https://fonts.cdnfonts.com/css/milliard');

    body {
        font-family: 'Milliard', sans-serif;
    }

    #user_registration_form #domain-search-field {
        height: 60px;
        font-size: 18px;
        background: white;
        border-radius: 1px;
        box-shadow: 0 0 7px rgba(0, 0, 0, 0.2);
        outline: none;
        width: 100%;
        padding: 0 30px;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
        font-weight: bold;
        border: 1px solid #cdcdcd;
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
        color: #1279fa;
        -webkit-box-shadow: 0 0 10px #1279fa;
        box-shadow: 0 0 3px #1279fa;
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
        background-image: url('<?php echo site_url(); ?>/modules/addons/microweber_addon/order/templates/default/domains/assets/img/domain-search/cart.png');
        font-size: 34px;
        line-height: 19px;
        color: #969696;
    }

    .domain-item.cant-start .last-div:after {
        visibility: hidden;
    }

    .domain-item:hover .last-div:after {
        color: #1279fa;
    }

    .domain-item > div:nth-child(1) {
        flex: 1;
    }

    .domain-item > div:nth-child(2) {
        flex: 2;
        width: 280px;
    }

    /*    .domain-item > div:nth-child(3) {
            !*flex: 3;*!
            width: 280px;
        }*/

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
        background-image: url('<?php echo site_url(); ?>/modules/addons/microweber_addon/order/templates/default/domains/assets/img/domain-search/domain-warn.png');
        width: 22px;
        height: 27px;
    }

    .user_registration_form_msg .urf.urf_success {
        background: #00cc6e;
    }

    .user_registration_form_msg .urf.urf_success .icon {
        background-image: url('<?php echo site_url(); ?>/modules/addons/microweber_addon/order/templates/default/domains/assets/img/domain-search/domain-success.png');
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
        background-image: url('<?php echo site_url(); ?>/modules/addons/microweber_addon/order/templates/default/domains/assets/img/domain-search/clear-domain.png');
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
        background-image: url('<?php echo site_url(); ?>/modules/addons/microweber_addon/order/templates/default/domains/assets/img/domain-search/712.gif');
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
        background: #1279fa;
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
    .mw-whm--search-box > div{
        flex: 1;
    }
    .mw-whm--search-box{
        display: flex;
        width: 100%;
        max-width: 1000px;
        align-items: center;
        justify-content: center;
        margin: auto;
    }
</style>

<script>
    function render_domain_search_list(results, append = false) {

        if (append == false) {
            $("#domain-search-field-autocomplete").html('');
        }

        var all_res_render = '';

        if (results) {

            $.each(results, function (i, item) {
                all_res_render = all_res_render + getDomainItemTemplate(item);
            });

            function getDomainItemTemplate(item) {

                var ajax_status_check_class = '';
                var can_start_class = 'cant-start';
                var item_status_span = '<i class="availability-domain-checker-icon fa fa-close" ></i> <span class="not-available-tag availability-domain-checker-tag">Unavailable</span>';

                if (item.status == 'available') {
                    item_status_span = '<i class="availability-domain-checker-icon fa fa-check" ></i> <span class="domain-recommended-tag availability-domain-checker-tag">Available</span>';
                    can_start_class = 'can-start';
                }

                if (item.ajax_status_check) {
                    item_status_span = '<span><img src="modules/addons/microweber_addon/order/loading.gif" /></span>';
                    ajax_status_check_class = 'js-domain-ajax-status-check';
                }

                if (item.is_free) {
                    item_status_span = '<i class="availability-domain-checker-icon fa fa-check"></i> <span class="domain-free-tag availability-domain-checker-tag">Free</span>';
                }
                var other_data = '';
                <?php if(isset($_REQUEST['template_id'])): ?>
                other_data = other_data + ' data-template-id="' +<?php print intval($_REQUEST['template_id']) ?> + '"'
                <?php endif; ?>
                <?php if(isset($_REQUEST['config_gid'])): ?>
                other_data = other_data + ' data-config-gid="' +<?php print intval($_REQUEST['config_gid']) ?> + '"'
                <?php endif; ?>



                var template = '<div class="domain-item '+can_start_class+' '+ajax_status_check_class+'" '+other_data+' data-domain="' + item.domain + '" data-sld="' + item.sld + '" data-tld="' + item.tld + '" data-subdomain="' + item.subdomain + '">' +
                    '<div class=" text-left"><span class="domainName ">' + item.domain + '</span></div> ' +
                    '<div class="right last-div"> ' +
                    item_status_span +
                    '<span class="di-price">' + item.price_formated + '</span>' +
                    '</div> ' +
                    '<div class="clearfix"></div> ' +
                    '</div>';

                return template;
            }

            if (append) {
                $("#domain-search-field-autocomplete").append(all_res_render);
            } else {
                $("#domain-search-field-autocomplete").html(all_res_render);
            }

            setTimeout(function () {
                $('.js-domain-ajax-status-check').each(function (e, item) {

                    var URL = "<?php print site_url();?>index.php?m=microweber_addon&ajax=1&function=domain_available&domain=" + encodeURI($(item).data('domain'));

                    $.ajax({
                        contentType: 'application/json',
                        dataType: 'json',
                        url: URL,
                        cache: false,
                        type: "POST",
                        success: function (response) {
                            $(item).replaceWith(getDomainItemTemplate(response));
                        }
                    });

                });
            }, 369);

            $("#domain-search-field-autocomplete").removeClass('ajax-loading');

            if (typeof(resize_iframe_to_parent) != 'undefined') {
                resize_iframe_to_parent()
            }

        }
    }
</script>

<section class="section-60 p-t-30 p-b-30 fx-particles">
    <div>
        <div class="mw-whm--search-box">
            <div>

                <div class="just-text text-center m-t-80 m-b-20">
                    <h1 class="m-b-20">Register Domain and Create Site</h1>
                    <h1 class="m-b-20"><?php // print  lang_translate_key('store.chooseDomain'); ?></h1>
                    <p>Register your domain with <?php echo $controller->branding_get_company_name(); ?></p>
                </div>



                <div id="domain-selector">
                    <form id="user_registration_form" method="post" action="<?php echo $current_url ?>" class="clearfix">
                        <div class="input-holder" style="display: flex;">
                            <input class="input-domain-domains-area" type="text" name="domain" placeholder="Type a domain name here" tabindex="1" autocomplete="off" id="domain-search-field" value=""/>
                            <button class="js-clear-domain clear-domain" type="button"></button>
                            <button class="whmc-kbtn input-domain-domains-area-btn js-search-domains" type="submit">Search</button>
                        </div>

                        <p class="provide-domains">We provide .com .net .org .eu domains.</p>

                        <div class="fixed-container user_registration_form_msg">
                            <div class="urf urf_warn" style="display: none;">
                                <div class="icon"></div>
                                <strong><span class="var-websiteName">DomainName.com</span> is taken.</strong> Try new one!<br/>
                                If this is your domain, <u>you can map it with <?php echo $controller->branding_get_company_name(); ?> Premium.</u>
                            </div>
                            <div class="urf urf_success" style="display: none;">
                                <div class="icon"></div>
                                <strong><span class="var-websiteName">DomainName.com</span> is available!</strong> Get it now!<br/>
                                Purchase this domain name right now <u>with hosting and website.</u>
                            </div>
                        </div>

                        <div id="domain-search-field-autocomplete" class="fixed-container m-b-20 ajax-loading">
                            <div class="js-autocomplete-placeholder ajax-loading-placeholder">

                                <div class="domain-item cant-start">
                                    <div class=" text-left"><span class="domainName "><?php echo $CONFIG['Domain']; ?></span></div>
                                    <div class="right last-div">
                                        <span class="not-available-tag">Unavailable</span>
                                        <span class="di-price">&nbsp;</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="domain-item can-start">
                                    <div class=" text-left"><span class="domainName "><?php echo $CONFIG['Domain']; ?></span></div>
                                    <div class="right last-div">
                                        <span class="domain-free-tag">Free</span>
                                        <span class="di-price">$0.00</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="domain-item can-start">
                                    <div class=" text-left"><span class="domainName "><?php echo $CONFIG['Domain']; ?></span></div>
                                    <div class="right last-div">
                                        <span class="domain-recommended-tag">Available</span>
                                        <span class="di-price">$10.00</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>

                        <!--                        <div id="domain-search-load-more" class="fixed-container text-center m-b-20 ajax-loading" style="display: none">-->
                        <!--                            <button type="button" class="whmc-kbtn js-domain-search-load-more-btn">Load more</button>-->
                        <!--                        </div>-->

                    </form>

                </div>

                <!--                <div class="just-text boxes p-b-50">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-md-4">-->
                <!--                            <h6>Register a new domain</h6>-->
                <!--                            <p>Register a domain for your site to make it easier to remember and easier to share.</p>-->
                <!--                        </div>-->
                <!---->
                <!--                        <div class="col-md-4">-->
                <!--                            <h6>Connect your own domain</h6>-->
                <!--                            <p>Already have a domain name? Point it to your --><?php //echo $controller->branding_get_company_name(); ?><!-- website in a few easy steps.-->
                <!--                            </p>-->
                <!--                        </div>-->
                <!---->
                <!--                        <div class="col-md-4">-->
                <!--                            <h6>Connect your email</h6>-->
                <!--                            <p>Use your custom domain in your email address by using cPanel or other email services.</p>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
        </div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
