<?php include 'partials/header.php'; ?>
<div id="templates-page-bg">
    <div></div>
    <div></div>
</div>
<style>
    .js-autocomplete-placeholder .domain-free-tag,
    .js-autocomplete-placeholder .not-available-tag,
    .js-autocomplete-placeholder .domain-recommended-tag{
        background-color: transparent;
        border-color: transparent;
    }
    #templates-page-bg {
        height: 400px;
        top: 0;
        left: 0;
        width: 100%;
        position: absolute;
    }
    #templates-page-bg div {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    #templates-page-bg div:first-child {
        background: linear-gradient(129deg, rgba(189,52,127,1) 0%, rgba(254,195,137,1) 33%, rgba(219,252,255,0.28335084033613445) 72%, rgba(31,200,218,1) 100%);
        opacity: .7;
    }
    #templates-page-bg div:last-child {
        background: linear-gradient(0deg, rgba(255,255,255,1) 30%, rgba(255,255,255,0) 100%);
    }
    #domain-search-box{
        transition: all 0.3s;
    }
    #domain-search-box.focus{
        transform: scale(1.005);
    }

    #user_registration_form #domain-search-field:focus {
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;


    }
    #user_registration_form #domain-search-field {
        height: 70px;
        font-size: 24px;
        background: white;
        border-radius: 0px;
        outline: none;
        width: 100%;
        padding: 0 190px 0 20px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        transition: all 0.3s;
        font-weight: bold;
        border: 1px solid #000;
    }

    @media (max-width: 600px){
        .search-domain,
        #user_registration_form #domain-search-field{
            font-size: 17px !important;
        }
        #user_registration_form #domain-search-field{
            height: 50px;

        }
    }

    .input-holder{
        z-index: 2;
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

    .domain-item:hover{
        box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
    }
    .domain-item .domainName{
        display: inline-block;
        line-height: 50px;
        padding-left: 20px;
        font-size: 17px;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
        text-align: right;
        direction: rtl;

    }
    .domain-item {
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;
        align-items: center;
        padding: 0;
        background: white;
        color: #393939;
        line-height: 50px;
        margin: 10px 0 0;
        transition: .3s;
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

    }

    .domain-item.cant-start:hover {
        color: #393939;

    }



    .domain-item.cant-start .last-div:after {
        visibility: hidden;
    }

    .domain-item:hover .last-div:after {
        color: #1279fa;
    }

    .domain-item .domain-item-domainName + div{
        width: 170px;
    }
    .domain-item .domain-item-domainName{
        width: calc(100% - 170px);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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

        border: 0;
        position: absolute;
        right: 160px;
        top: 50%;
        background-image: url('<?php echo site_url(); ?>/modules/addons/microweber_addon/order/templates/default/domains/assets/img/domain-search/clear-domain.png');
        width: 20px;
        height: 20px;
        outline: none;
        cursor: pointer;
        visibility: hidden;
        background-color: transparent;
        background-repeat: no-repeat;
        margin-top: -10px;
    }

    .clear-domain.visible {
        visibility: visible;
    }

    .search-domain {
        border: 0;
        position: absolute;
        top: 0;
        right: 0;
        text-align: center;
        min-width: 150px;
        height: 100%;

        cursor: pointer;

        padding: 0 20px;
        border-radius: 0;
        font-weight: normal;
        font-size: 22px;
        text-transform: uppercase;
        z-index: 1;
    }


    .search-domain,
    .search-domain:hover,
    .search-domain:focus,
    .search-domain:active{
        background-color: #000 !important;
        color: #fff !important;
        outline: none;
        border: none;
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

    .loading-preloader-item,
    .domain-free-tag,
    .domain-recommended-tag,
    .not-available-tag {
        text-transform: uppercase;
        font-size: 17px;
        padding: 2px 10px;
        letter-spacing: 1px;
        min-width: 150px;
        text-align: center;
        line-height: 50px;
        display: inline-block;
        border: 1px solid transparent;
    }

    .domain-recommended-tag {
        background: #0030ff;

        color: #fff;

    }

    .domain-free-tag {
        background: #2fa700;

        color: #fff;

    }

    .not-available-tag {
        background: rgba(153, 153, 153, 0);
        border-color: #111;
        color: #111;

    }

    @media screen and (min-width: 1200px) {
        #domain-selector {
            width: 70%;
            margin: 0 auto;
        }
    }

    @media screen and (max-width: 767px) {


        .domain-recommended-tag,
        .domain-free-tag {
            margin-left: 0px;
        }
    }

    .ajax-loading .domainName,
    .ajax-loading .di-price {

        color: #dcdcdc;
        border-radius: 3px;
        animation: blinker 1s linear infinite;
    }



    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }


    .ajax-loading-placeholder {
        display: none;
    }

    .domain-top h3{
        font-size: 24px;
        font-weight: 300;
    }
    .domain-top h4{
        font-size: 16px;
        font-weight: normal;
    }
    .domain-top h2{
        font-size: 24px;
        font-weight: bold;
    }
    .domain-top small{
        font-size: 15px;
    }
    .domain-top{
        text-align: center;
        padding: 50px 0;
        color: #000;
    }

    #domains-main-block{
        max-width: 96%;
        width: 100%;
        margin: auto;
    }

    @media (max-width: 660px) {
        .domain-item,
        .domain-item .domainName,
        .loading-preloader-item, .domain-free-tag, .domain-recommended-tag, .not-available-tag{
            line-height: 36px;
            font-size: 14px;
        }
    }
    .domain-item-domainName-suffix{
        font-weight: bold;
        font-size: 17px;
    }

</style>

<script>

    addEventListener('load', function (){
        document.getElementById('user_registration_form').addEventListener('submit', function (e){
            var val = document.querySelector('#domain-search-field').value.trim();
            if(!val) {
                e.preventDefault();
                return false;
            }
        })
    })
    addEventListener('DOMContentLoaded', function (){
        var fld = document.querySelector('#domain-search-field')
        fld.addEventListener('focus', function () {
            this.parentNode.classList.toggle('focus')
        })
        fld.addEventListener('blur', function () {
            this.parentNode.classList.toggle('focus')
        })
        /*        var hash = null;
                fld.addEventListener('input', function () {
                    hash = encodeURIComponent(this.value.trim())
                    location.hash = hash;
                })
                addEventListener('hashchange', function () {
                    var h = decodeURIComponent(location.hash).replace('#', '').replace('%23', '')
                    if(h !== hash) {
                        hash = h;
                        fld.value = hash;
                    }
                })
                if(location.hash && location.hash !== hash) {
                    hash =  decodeURIComponent(location.hash).replace('#', '').replace('%23', '');
                    fld.value = hash;
                }*/

    })
    function render_domain_search_list(results, append) {
        if(typeof append === 'undefined') {
            append = false;
        }
        if (append === false) {
            $("#domain-search-field-autocomplete").html('');
        }

        var all_res_render = '';

        if (results) {

            $.each(results, function (i, item) {
                all_res_render = all_res_render + getDomainItemTemplate(item);
            });
            if(!all_res_render.trim().length) return;


            function getDomainItemTemplate(item) {
                if(!item.domain) {
                    $("#domain-search-field-autocomplete").removeClass('ajax-loading');

                    if (typeof(resize_iframe_to_parent) != 'undefined') {
                        resize_iframe_to_parent()
                    }
                    return ''
                }
                var nm = item.domain.split('.')[0];
                if(!nm) {
                    $("#domain-search-field-autocomplete").removeClass('ajax-loading');

                    if (typeof(resize_iframe_to_parent) != 'undefined') {
                        resize_iframe_to_parent()
                    }
                    return ''
                }

                var ajax_status_check_class = '';
                var can_start_class = 'cant-start';
                var item_status_span = '<span class="not-available-tag">N/A</span>';

                if (item.status == 'available') {
                    item_status_span = '<span class="domain-recommended-tag">'+item.price_formated+'</span>';
                    can_start_class = 'can-start';
                }

                if (item.ajax_status_check) {
                    item_status_span = '<span class="loading-preloader-item"><img src="modules/addons/microweber_addon/order/loading.gif" /></span>';
                    ajax_status_check_class = 'js-domain-ajax-status-check';
                }

                if (item.is_free) {
                    item_status_span = '<span class="domain-free-tag">Free</span>';
                }
                var other_data = '';
                <?php if(isset($_REQUEST['template_id'])): ?>
                other_data = other_data + ' data-template-id="' +<?php print intval($_REQUEST['template_id']) ?> + '"'
                <?php endif; ?>
                <?php if(isset($_REQUEST['config_gid'])): ?>
                other_data = other_data + ' data-config-gid="' +<?php print intval($_REQUEST['config_gid']) ?> + '"'
                <?php endif; ?>


                var formatDomain = function (domain) {
                    var arr = domain.split('.');
                    var suffix = arr.pop();
                    return '<span class="domain-item-domainName-name">' + arr.join('.') + '</span><span class="domain-item-domainName-suffix">.' + suffix + '</span>';
                }

                var template = '<div class="domain-item '+can_start_class+' '+ajax_status_check_class+'" '+other_data+' data-domain="' + item.domain + '" data-sld="' + item.sld + '" data-tld="' + item.tld + '" data-subdomain="' + item.subdomain + '">' +
                    '<div class=" domain-item-domainName"><span class="domainName ">' + formatDomain(item.domain) + '</span></div> ' +
                    '<div class="right last-div"> ' +
                    item_status_span +
                    //'<span class="di-price">' + item.price_formated + '</span>' +
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
    <div class="container">
        <div class="row flexbox-container">
            <div class="col-12" id="domains-main-block">

                <div class="domain-top">
                    <h2>Domain Search</h2>
                    <small><strong>.com   .net   .org   .biz   .info </strong></small>
                    <h3>Discover the name that fits and help visitors find your site faster.</h3>
                    <h4>Get a free one-year domain name voucher with select website Premium plans.</h4>
                </div>




                <div id="domain-selector">
                    <form id="user_registration_form" method="post" action="<?php echo $current_url ?>" class="clearfix">
                        <div class="input-holder" id="domain-search-box">
                            <input
                                    type="text"
                                    name="domain"
                                    placeholder="Type a domain name here"
                                    tabindex="1"
                                    autocomplete="off"
                                    id="domain-search-field"
                                    value=""
                                    autofocus
                            />

                            <button class="js-clear-domain clear-domain" type="button"></button>
                            <button class="whmc-kbtn-2 search-domain js-search-domains" type="submit">Search</button>
                        </div>

                        <p class="provide-domains">We provide .com .net .org .biz .info domains.</p>

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
                                    <div class=" domain-item-domainName"><span class="domainName "><?php echo $CONFIG['Domain']; ?></span></div>
                                    <div class="right last-div">
                                        <span class="not-available-tag"><img src="modules/addons/microweber_addon/order/loading.gif" /></span>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="domain-item can-start">
                                    <div class=" domain-item-domainName"><span class="domainName "><?php echo $CONFIG['Domain']; ?></span></div>
                                    <div class="right last-div">
                                        <span class="domain-free-tag"><img src="modules/addons/microweber_addon/order/loading.gif" /></span>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="domain-item can-start">
                                    <div class=" domain-item-domainName"><span class="domainName "><?php echo $CONFIG['Domain']; ?></span></div>
                                    <div class="right last-div">
                                        <span class="domain-recommended-tag"><img src="modules/addons/microweber_addon/order/loading.gif" /></span>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>

                        <?php
                        /*

                        <div id="domain-search-load-more" class="fixed-container text-center m-b-20 ajax-loading" style="display: none">
                           <button type="button" class="whmc-kbtn js-domain-search-load-more-btn">Load more</button>
                       </div>

                         * */

                        ?>

                    </form>

                </div>

                <div class="just-text boxes p-b-50">

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
