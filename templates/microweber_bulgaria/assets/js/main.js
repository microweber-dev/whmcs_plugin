(function () {
    "use strict"

    var $window = $(window),
        $document = $(document);

    var qTheme = {
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
        stickyNav: function () {
            $('body.sticky-nav .navigation')
                [$window.scrollTop() ? 'addClass' : 'removeClass']
            ('sticky');
        }
    }

    window.qTheme = qTheme;

    $window.on('load', function () {
        qTheme.stickyNav();

        $window.on('scroll resize', function () {
            qTheme.stickyNav();
        });
    });

    $document.ready(function () {
        if ($(document.body).hasClass('sticky-nav')) {
            var navHeight = $('.navigation').outerHeight();
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

        $('.dropdown-toggle').dropdown()
    });


    /* ###################### Tabs ###################### */
    $document.ready(function () {
        var numTabs = $('.tabs .nav-tabs:not(.as-buttons)').find('li').length;
        var tabWidth = 100 / numTabs;
        var tabPercent = tabWidth + "%";
        $('.nav-tabs li').width(tabPercent);
    });
    /* ###################### Tabs ###################### */

    /* ###################### Section 4 and 5 padding ###################### */

    function setPaddingToSections() {
        if ($window.width() > 991) {
            var headerWidth = $('.navigation-holder').width();
            var headerContainerWidth = $('.navigation-holder .navigation .container').width();
            $('.section-x').each(function () {
                var leftSide = $(this).find('.left-side');
                leftSide.css({'padding-left': ((headerWidth - headerContainerWidth ) / 2) + 10 + 'px'});
            })
            $('.section-y').each(function () {
                var leftSide = $(this).find('.right-side');
                leftSide.css({'padding-right': ((headerWidth - headerContainerWidth ) / 2) + 10 + 'px'});
            })
            $('.section-11').each(function () {
                var leftSide = $(this).find('.right-side');
                leftSide.css({'padding-right': ((headerWidth - headerContainerWidth ) / 2) + 10 + 'px'});
            })

        } else {
            $('.section-x').each(function () {
                var leftSide = $(this).find('.left-side');
                leftSide.css({'padding-left': ''});
            })
            $('.section-y').each(function () {
                var leftSide = $(this).find('.right-side');
                leftSide.css({'padding-right': ''});
            })
            $('.section-11').each(function () {
                var leftSide = $(this).find('.right-side');
                leftSide.css({'padding-right': ''});
            })
        }

        if ($window.width() > 1365) {
            var headerWidth = $('.navigation-holder').width();
            var headerContainerWidth = $('.navigation-holder .navigation .container').width();

            $('.section-11').each(function () {
                var leftSide = $(this).find('.right-side');
                leftSide.css({'padding-left': 145 + 'px'});
            })

        } else {
            $('.section-11').each(function () {
                var leftSide = $(this).find('.right-side');
                leftSide.css({'padding-left': ''});
            })
        }
    }

    $document.ready(function () {
        setPaddingToSections();
    });

    $window.on('resize', function () {
        setPaddingToSections();
    });
    /* ###################### Section 4 and 5 padding ###################### */

    /* ###################### Top Top ###################### */
    $document.ready(function () {
        var ttopButton = $("#to-top");
        ttopButton.hide().on("click", function () {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
        });
        $window.scroll(function () {
            if ($window.scrollTop() === 0) {
                ttopButton.hide();
            } else {
                ttopButton.show();
            }
        });
    });
    /* ###################### To Top ###################### */


    /* ###################### Tooltip ###################### */
    $document.ready(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    /* ###################### Tooltip ###################### */

    /* ###################### Project Gallery ###################### */
    function loadPortfolioGallerySettings() {

        return false;

        if ($window.width() > 991) {
            var projectGalleryHeight = $('.portfolio-inner-page .project-gallery').height();
            var projectGalleryWidth = $('.portfolio-inner-page .project-gallery').width();
            var projectInfoHeight = $('.portfolio-inner-page .project-info').height();
            $('.portfolio-inner-page .project-info').css({'max-width': projectGalleryWidth + 'px'});
            $('.portfolio-inner-page .js-in-viewport').css({'margin-top': projectInfoHeight + 'px'});
        } else {
            if ($('.portfolio-inner-page .project-gallery').length > 0) {
                $('.portfolio-inner-page .project-gallery').each(function () {
                    var el = $(this);
                    el.slick({
                        centerMode: true,
                        centerPadding: '0px',
                        slidesToShow: 1,
                        arrows: true,
                        dots: false,
                        adaptiveHeight: true
                    });
                });
            }
        }
    }

    $document.ready(function () {
        loadPortfolioGallerySettings();
    });

    $document.on('resize', function () {
        loadPortfolioGallerySettings();
    });



    /* ###################### Video Section ###################### */
    function setHeightOnVideos() {
        var headerheight = $('.navigation-holder').height();
        var windowheight = $(window).height();
        $('.video-section').css('height', windowheight - headerheight + "px");
        $('.video-section .video').css('height', windowheight - headerheight + "px");
        $('.video-section .container-fluid').css('height', windowheight - headerheight + "px");
        $('#main').css('margin-top', headerheight + "px");
    }

    $document.ready(function () {
        setHeightOnVideos();
    });

    $window.on('resize', function () {
        setHeightOnVideos();
    });
    /* ###################### Video Section ###################### */

    /* ###################### Quantity ###################### */

    $document.ready(function () {
        $(".arrow.minus").on("click", function (m) {
            var i = $(this).parent().parent().find('input[name="quantity"], input[name="qty"], .js-qty');
            if (i.val() <= 1) {
                i.val("1").change();
            } else {
                var l = i.val() - 1;
                i.val(l).change();
            }
        });
        $(".arrow.plus").on("click", function (m) {
            var i = $(this).parent().parent().find('input[name="quantity"], input[name="qty"], .js-qty');
            if (i.val() <= 19) {
                var l = +i.val() + +1;
                i.val(l).change();
            }
        });
    });
    /* ###################### Quantity ###################### */
})();

$(document).ready(function () {
    $('#mw-template-microweber-whitelabel').removeClass('module');
})

/* Ajax Loading */
$(window).on('load', function () {
    setTimeout(function () {
        $('body').addClass('page-loaded');
    }, 900);
})