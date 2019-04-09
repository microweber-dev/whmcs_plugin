<script>

    $(document).ready(function () {
        var __dprev = $("#domain-search-field").val(), __dtime = null;
        $("#domain-search-field").on('input paste keyup change', function () {
            (function (el) {
                clearTimeout(__dtime);
                __dtime = setTimeout(function () {






                    if (!!el.value && el.value != __dprev) {
                        $("#container").addClass('domain-search-field-on')
                    }
                    else {
                        $("#container").removeClass('domain-search-field-on')
                    }
                    __dprev = el.value;












                            var keyword = $("#domain-search-field").val();
                            var URL = encodeURI("<?php print $CONFIG['SystemURL'];?>/index.php?m=microweber_addon&ajax=1&function=domain_search&domain=" + keyword);
                            $.ajax({
                                url: URL,
                                cache: false,
                                type: "POST",
                                success: function(response) {
                                    if(response){
                                    $("#domain-search-field-autocomplete").html(response);
                                    }
                                }
                            });








                }, 2000);
            })(this)


        })
    })

</script>







<script type="text/javascript">
    var delay = (function() {
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();


</script>










<style>
    #domain-search-field {
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
        display: block;
        padding: 15px 30px;
        background: white;
        margin: 0 0 4px 0;
        color: #393939;
        cursor: pointer;
    }

    .domain-item:hover {
        color: #0086db;
        -webkit-box-shadow: 0 0 10px #0086db;
        box-shadow: 0 0 3px #0086db;
    }

    .domain-item .last-div:after {
        display: block;
        float: right;
        content: '\f105';
        font-family: FontAwesome;
        font-size: 34px;
        line-height: 19px;
        color: #969696;
    }

    .domain-item:hover .last-div:after {
        color: #0086db;
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
        margin-top: 22px;
        margin-right: 22px;
        background-image: url('assets/img/domain-search/clear-domain.png');
        width: 18px;
        height: 18px;
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

    .di-price {
        text-align: center;
        width: 60px;
        display: inline-block;
        position: absolute;
        right: 45px;
        top: 2px;
        font-size: 14px;
    }

</style>



<section class="section-60 p-t-30 p-b-30 fx-particles">
    <div class="container">
        <div class="row flexbox-container">
            <div class="col-md-12 fx-deactivate allow-drop">

                <div class="just-text text-center m-b-20">
                    <h1 class="m-b-20">Customize your domain name</h1>
                    <p>Register your domain with Microweber.com</p>
                </div>



                <div id="domain-selector">
                    <form id="user_registration_form" method="get" action="<?php echo $current_url ?>" class="clearfix">
                         <div class="input-holder">
                            <!--                            <button class="clear-domain"></button>-->
                            <button class="btn btn-default search-domain">Search</button>
                            <input type="text" name="domain" placeholder="Type a domain name here" tabindex="1" autocomplete="off" id="domain-search-field" value=""/>
                        </div>

                        <p class="provide-domains">We provide .com .net .org domains.</p>

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

                        <div id="domain-search-field-autocomplete" class="fixed-container m-b-20">
                            <div class="js-autocomplete-placeholder ajax-loading-placeholder" style="display: none;">
                                <div class="domain-item">
                                    <div class="col-xs-12 col-sm-5 text-left"><span class="domainName ">yourdomain.com</span></div>
                                    <div class="col-xs-6 col-sm-3 right hidden-xs"><span class="startWith ">start with plan</span></div>
                                    <div class="col-xs-12 col-sm-4 left last-div"><span class="domain-recommended-tag">Recommended</span><span class="di-price">$ 19.00</span></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="domain-item ">
                                    <div class="col-xs-12 col-sm-5 text-left"><span class="domainName ">yourdomain.com</span></div>
                                    <div class="col-xs-6 col-sm-3 right hidden-xs"><span class="startWith ">start with plan</span></div>
                                    <div class="col-xs-12 col-sm-4 left last-div"><span class="domain-recommended-tag">Recommended</span><span class="di-price">$ 19.00</span></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="domain-item  is_free ">
                                    <div class="col-xs-12 col-sm-5 text-left"><span class="domainName  is_free ">yourdomain.microweber.com</span></div>
                                    <div class="col-xs-6 col-sm-3 right hidden-xs"><span class="startWith  is_free ">start with plan</span></div>
                                    <div class="col-xs-12 col-sm-4 left last-div"><span class="domain-free-tag">Free</span></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="domain-item ">
                                    <div class="col-xs-12 col-sm-5 text-left"><span class="domainName ">yourdomain.com</span></div>
                                    <div class="col-xs-6 col-sm-3 right hidden-xs"><span class="startWith ">start with plan</span></div>
                                    <div class="col-xs-12 col-sm-4 left last-div"><span class="di-price">$ 19.00</span></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="just-text boxes">
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Register a new domain</h6>
                            <p>Register a domain for your site to make it easier to remember and easier to share.</p>
                        </div>

                        <div class="col-md-4">
                            <h6>Connect your own domain</h6>
                            <p>Already have a domain name? Point it to your Microweber.com website in a few easy steps.
                            </p>
                        </div>

                        <div class="col-md-4">
                            <h6>Connect your email</h6>
                            <p>Use your custom domain in your email address by activating email forwarding, G Suite, or other email services.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>