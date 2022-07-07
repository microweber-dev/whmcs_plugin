qTheme = {
    isElementInViewport: function (el) {
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.top <= (window.innerHeight || document.documentElement.clientHeight)
        );
    },
    stickyNavBefore: function () {
        $('body.sticky-nav .navigation')
            [$(window).scrollTop() ? 'addClass' : 'removeClass']
        ('not-visible');
    },
    stickyNav: function () {
        $('body.sticky-nav .navigation')
            [$(window).scrollTop() > 100 ? 'addClass' : 'removeClass']
        ('sticky');
    }
}
$(window).on('load', function () {
    qTheme.stickyNavBefore();
    qTheme.stickyNav();

    $(window).on('scroll resize', function () {
        qTheme.stickyNavBefore();
        qTheme.stickyNav();
    });
});

$(document).ready(function () {
    if ($('body').hasClass('sticky-nav')) {
        var navHeight = $('.navigation').outerHeight();
        qTheme.stickyNavBefore();
        qTheme.stickyNav();
    }

    $('.js-menu-toggle').on('click', function () {
        $('html').toggleClass('mobile-menu-active');
    });


    $(document.body).on('click', function (e) {
        var curr = $(e.target)
        if (curr.parents('.menu,.toggle').length === 0) {
            $('html').removeClass('mobile-menu-active');
        }

    });

    $(".navigation .menu li").each(function () {
        if ($(this.children).filter('ul').length > 0) {
            $(this).addClass('has-sub-menu')
        }
    });


    $(".has-sub-menu > a").on("click", function (e) {
        var parent = $(this).parent();
        var ul = parent.children('ul');
        console.log(ul)
        if (ul.length === 1 && matchMedia("(max-width: 1450px)").matches) {
            e.preventDefault();
            ul.slideToggle(function () {
                if (this.style.display == 'none') {
                    this.style.display = '';
                }
            });
        }
    });


});


/* ###################### Top Top ###################### */
$(document).ready(function () {
    $("#to-top").hide();
    $("#to-top").on("click", function () {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
    });
    $(window).scroll(function () {
        if ($(window).scrollTop() === 0) {
            $("#to-top").hide();
        } else {
            $("#to-top").show();
        }
    });
});
/* ###################### To Top ###################### */


/* ###################### Tooltip ###################### */
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
/* ###################### Tooltip ###################### */



//Efekti

window.onload = function () {
    var radius = 8;
    TweenMax.staggerFromTo('.blob', 9, {
        cycle: {
            attr: function (i) {
                var r = i * 90;
                return {
                    transform: 'rotate(' + r + ') translate(' + radius + ',0.1) rotate(' + (-r) + ')'
                }
            }
        }
    }, {
        cycle: {
            attr: function (i) {
                var r = i * 90 + 360;
                return {
                    transform: 'rotate(' + r + ') translate(' + radius + ',0.1) rotate(' + (-r) + ')'
                }
            }
        },
        ease: Linear.easeNone,
        repeat: -1
    });
}
