/* Login things */

function inIframe() {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
}

function showLogin(login_link) {
    var strWindowFeatures = "menubar=no,location=no,resizable=no,scrollbars=no,status=yes,width=400,height=350";
    // var social_login_url = mw.settings.api_url + 'user_social_login?provider=microweber&redirect=' + mw.settings.site_url + 'after_login';
    //   var social_login_url = mw.settings.api_url + 'user_social_login?provider=microweber&redirect=' + window.location;
    if (!inIframe()) {
        window.location.href = login_link;
    } else {
        SocialLoginWindow = window.open(login_link, 'SocialLoginWindow', strWindowFeatures);
    }

}


/* Petko's things */
$(document).ready(function () {
    $(".page-with-sidebar .sidebar").addClass('closed');

    $(".sidebar-mobile-nav").click(function () {
        if ($('.page-with-sidebar .sidebar').hasClass('closed')) {
            $(".page-with-sidebar .sidebar").fadeIn(500);
            $('.page-with-sidebar .sidebar').removeClass('closed');
        } else {
            $(".page-with-sidebar .sidebar").fadeOut(500);
            $('.page-with-sidebar .sidebar').addClass('closed');
        }
    });

    $(".sidebar-mobile-close").click(function () {
        $(".page-with-sidebar .sidebar").fadeOut(500);
        $('.page-with-sidebar .sidebar').addClass('closed');
    });


    $(".mobile-menu").click(function () {
        if ($('html').hasClass('mobile-active')) {
            $('html').removeClass('mobile-active');
        } else {
            $('html').addClass('mobile-active');
        }
    });

    $(".menu-more").click(function () {
        $('.sidebar .navigation ul.opened').removeClass('opened');
        $('.mobile-nave ul.opened').removeClass('opened');
        $(this).next().toggleClass('opened');
    });
});

$(window).resize(function () {
    if ($(window).width() > 1279) {
        $('.page-with-sidebar .sidebar').removeAttr('style');
    }
});

$(document).ready(function () {
    $('[svg-src]').each(function () {
        (function (el) {
            $.get($(el).attr('svg-src'), function (data, a, b) {
                if (typeof data == 'object') {
                    $(el).replaceWith(data.documentElement);
                }
                else if (typeof data == 'string' && data.indexOf('DOCTYPE HTML') == -1) {
                    $(el).replaceWith(data);
                }
            })
        })(this)
    });
});

$(document).ready(function () {
    $('.page-payments .radio-buttons-wrapper input[type="radio"]').on('change', function () {
        var thisWrapper = $(this).parents('.radio-buttons-wrapper');
        thisWrapper.find('li').removeClass('active');
        $(this).closest('li').addClass('active');
        $(this).closest('input[type="checked"]').prop('ckecked', true);
    });
});

$(document).ready(function () {
    $(".material-field").not('.material-field-ready,#stateselect').each(function () {
        var el = $(this);
        el.addClass('material-field-ready');
        el.wrap('<div class="material-field-holder"></div>')
        var place = document.createElement('span');
        place.className = 'material-field-placeholder';
        place.innerHTML = el.attr('placeholder');
        el.after(place);
        el.removeAttr('placeholder')
        el.on('focus blur', function (e) {
            el.parent()[e.type == 'focus' ? 'addClass' : 'removeClass']('focus');
        })
        $(place).on('touchstart mousedown', function () {
            setTimeout(function () {
                el.focus();
            }, 10);
        });
        if (!!this.value) el.parent().addClass('has-value');
        el.on('input keyup change', function () {
            el.parent()[!!this.value ? 'addClass' : 'removeClass']('has-value');
        })
    });

    $("#stateselect option:first").text('State')
    $("#country").on('change', function(){
        setCountryChange();
    });
    setCountryChange();
});


setCountryChange = function(){
        if($("#country").val()=='US'){
             $("#stateinput,#stateinput+.material-field-placeholder").hide();
            $("#stateselect").show()
        }
        else{
            $("#stateinput,#stateinput+.material-field-placeholder").show()
            $("#stateselect").hide()
        }
}

$(document).ready(function () {
    $('.selectpicker, .selectpicker-wrapper select').selectpicker();

    $('.bootstrap-select').removeClass('form-control');

    $(".bootstrap-select").wrap('<div class="material-field-holder"></div>');
});