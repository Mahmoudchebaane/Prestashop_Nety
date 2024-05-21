/******************
 * Vinova Themes  Framework for Prestashop 1.7.x
 * @package    Nova - PrestaShop 1.7 Theme For Fashion Templates
 * @version    1.0
 * @author    http://vinovathemes.com/
 * @copyright  Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/
(function ($) {
    $.cookie = function (key, value, options) {
        if (arguments.length > 1 && (!/Object/.test(Object.prototype.toString.call(value)) || value === null || value === undefined)) {
            options = $.extend({}, options);
            if (value === null || value === undefined) {
                options.expires = -1
            }
            if (typeof options.expires === 'number') {
                var days = options.expires,
                    t = options.expires = new Date();
                t.setDate(t.getDate() + days)
            }
            value = String(value);
            return (document.cookie = [encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value), options.expires ? '; expires=' + options.expires.toUTCString() : '', options.path ? '; path=' + options.path : '', options.domain ? '; domain=' + options.domain : '', options.secure ? '; secure' : ''].join(''))
        }
        options = value || {};
        var decode = options.raw ? function (s) {
            return s
        } : decodeURIComponent;
        var pairs = document.cookie.split('; ');
        for (var i = 0, pair; pair = pairs[i] && pairs[i].split('='); i++) {
            if (decode(pair[0]) === key)
                return decode(pair[1] || '')
        }
        return null
    }

})(jQuery);

//Var global Vinovathemes
if ((typeof novtheme) === 'undefined') {
    novtheme = {};
}
var novtheme_current_width = $(window).innerWidth();
var novtheme_min_width = 768;
var novtheme_min_width_ipad = 992;
var novtheme_responsive_mobile = novtheme_current_width < novtheme_min_width;
var novtheme_responsive_ipad = novtheme_current_width < novtheme_min_width_ipad;

//Owl-carousel 2
function Nov_Owlcarousel() {
    $(".owl-carousel").each(function (index) {
        if ($('body').hasClass('lang-rtl'))
            rtl = true;
        else
            rtl = false;
        var autoplay = $(this).data('autoplay');
        var autoplayTimeout = $(this).data('autoplayTimeout');
        var items = $(this).data('items') ? $(this).data('items') : 3;
        var margin = $(this).data('margin');
        var nav = $(this).data('nav');
        var dots = $(this).data('dots');
        var loop = $(this).data('loop') ? $(this).data('loop') : false;
        var items_large = $(this).data('items_large') ? $(this).data('items_large') : 2;
        var items_tablet = $(this).data('items_tablet') ? $(this).data('items_tablet') : 2;
        var items_mobile = $(this).data('items_mobile') ? $(this).data('items_mobile') : 1;
        var center = $(this).data('center') ? $(this).data('center') : false;
        var start = $(this).data('startslide') ? $(this).data('start') : 1;
        $(this).owlCarousel({
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            lazyLoad: true,
            lazyContent: true,
            loop: loop,
            autoplay: autoplay,
            autoplayTimeout: autoplayTimeout,
            items: items,
            margin: margin,
            rtl: rtl,
            dots: dots,
            nav: nav,
            responsive: {
                0: {
                    items: 1,
                    center: false,
                    margin: 0,
                    loop: false,
                },
                576: {
                    items: items_mobile,
                    center: false,
                    margin: margin,
                    loop: false,
                },
                768: {
                    items: items_tablet,
                    center: false,
                    margin: margin,
                    loop: false,
                },
                992: {
                    items: items_large,
                    center: false,
                    margin: margin,
                    loop: loop
                },
                1200: {
                    items: items,
                    center: center,
                    startPosition: start,
                    margin: margin,
                    loop: loop
                },
            }
        });
    });
}
function Category_Html_Owlcarousel() {
    $(".category-html").each(function (index) {
        if ($('body').hasClass('lang-rtl'))
            rtl = true;
        else
            rtl = false;
        var autoplay = $(this).data('autoplay');
        var autoplayTimeout = $(this).data('autoplayTimeout');
        var items = $(this).data('items') ? $(this).data('items') : 1;
        var margin = $(this).data('margin');
        var nav = $(this).data('nav');
        var dots = $(this).data('dots');
        var loop = $(this).data('loop') ? $(this).data('loop') : false;
        var items_large = $(this).data('items_large') ? $(this).data('items_large') : 3;
        var items_tablet = $(this).data('items_tablet') ? $(this).data('items_tablet') : 2;
        var items_mobile = $(this).data('items_mobile') ? $(this).data('items_mobile') : 2;
        var center = $(this).data('center') ? $(this).data('center') : false;
        var start = $(this).data('start') ? $(this).data('start') : 0;
        $(this).owlCarousel({
            navText: ['<span>Next</span><i class="fa fa-chevron-right" aria-hidden="true"></i>', '<i class="fa fa-chevron-left" aria-hidden="true"></i><span>Prev</span>'],
            lazyLoad: true,
            lazyContent: true,
            loop: loop,
            autoplay: autoplay,
            autoplayTimeout: autoplayTimeout,
            items: items,
            margin: margin,
            rtl: rtl,
            dots: dots,
            nav: nav,
            responsive: {
                0: {
                    items: 1,
                    center: false,
                    margin: 0,
                    loop: false,
                },
                320: {
                    items: 2,
                    center: false,
                    margin: 15,
                    loop: false,
                },
                425: {
                    items: items_mobile,
                    center: false,
                    margin: margin,
                    loop: false,
                },
                768: {
                    items: items_tablet,
                    center: false,
                    margin: margin,
                    loop: false,
                },
                992: {
                    items: items_large,
                    center: false,
                    margin: margin,
                    loop: loop
                },
                1200: {
                    items: items,
                    center: center,
                    startPosition: start,
                    margin: margin,
                    loop: loop
                }
            }
        });
    });
}
//Tab in ProductTab
function nov_producttab() {
    $('.nov-nav-link').click(function () {
        $(".nov-tab-pane").removeClass('nov-tab-active');
        $($('.nov-tab-pane').attr('href').addClass("nov-tab-active"));
        $(".nov-nav-link").removeClass('active');
        $(this).parent().find(".nov-nav-link").addClass('active');
    });
    $('.block_nav .nav-tabs li:first-child').find('.nav-link').addClass('active');
    $('.block_content .tab-content .tab-pane:first-child').addClass('active in');
}
//Tab in CategoryTab
function nov_categorytab() {
    $('.tab').on('click', function (e) {
        e.preventDefault();
        $('.tab, .panel').removeClass('active');
        $(this).add('#' + $(this).attr('id').replace(/\s*tab\s*/, 'panel')).addClass('active');
        $(this).focus();
    });
}

//When hover Cat in desktop
$('#_desktop_cart').hover(function () {
    $('.cart_block').addClass('hover-active');
}, function () {
    $('.cart_block').removeClass('hover-active');
});


//Toggle menu left
function resetCanvas() {
    $('body').removeClass('open_nov_mobile_menu');
    $('body').removeClass('open_nov_vertical_menu');
    $('body').removeClass('canvasmenu-left');
    $('.canvas-menu').removeClass('canvas-active');
    $('.nov-menu .toggle-nav').removeClass('act');
    $('#mobile_top_menu_wrapper').removeClass('active');
    return false;
}
;
var l = $('.canvas-menu'),
    c = $('.nov-menu .toggle-nav'),
    u = $('.canvas-overlay'),
    b = $('body');

c.click(function () {
    l.hasClass('canvas-active') ? (l.removeClass('canvas-active'), u.removeClass('act'), c.removeClass('act'), b.removeClass('canvasmenu-left')) : (l.addClass('canvas-active'), u.addClass('act'), c.addClass('act'), b.addClass('canvasmenu-left'));
});
u.on("click", function () {
    resetCanvas();//return false;
});

//Megamenu
if ($("body").attr("id") == "index")
    this_hompage = 1;
else
    this_hompage = 0;


var showpanel = false;
var hidepanel = false;

var this_url = window.location;
this_url = String(this_url);
this_url = this_url.replace("https://", "").replace("http://", "").replace("www.", "").replace(/#\w*/, "");

var this_link = "{/literal}{$current_link}{literal}";
this_link = this_link.replace("https://", "").replace("http://", "").replace("www.", "").replace(/#\w*/, "");

$('#_mobile_mainmenu').click(function () {
    $('body').hasClass('open_nov_mobile_menu') ? ($('body').removeClass('open_nov_mobile_menu')) : ($('body').addClass('open_nov_mobile_menu'));
    $('#mobile_top_menu_wrapper').hasClass('active') ? ($('#mobile_top_menu_wrapper').removeClass('active')) : ($('#mobile_top_menu_wrapper').addClass('active'))
});

$(".nov-megamenu > ul > li > a").each(function () {


    url_menu = $(this).attr("href").replace("https://", "").replace("http://", "").replace("www.", "").replace(/#\w*/, "");
    if ((this_url == url_menu) || (this_url.replace(this_link, "") == url_menu) || this_hompage) {
        $(this).parent().addClass("active");
        return false;
    }

});

function NovToggleAction() {
    $(document).on('click', '.nov-toggle-btn', function (e) {
        var toggle = $(this).data('toggle');
        $(this).toggleClass('act');
        $('.canvas-overlay').addClass('act');
        e.stopPropagation();
    });

    $('.show-header-vertical').click(function (c) {
        $('.header-vertical').addClass('active');
    })
    $('.hidden-header-vertical').click(function (a) {
        $('.header-vertical').removeClass('active');
    })
}

function NovTogglePage() {
    if ($(window).width() < 768) {
        $('.nov-toggle-page').on('click', function (e) {
            var target = $(this).data('target');
            $('body').hasClass('show-boxpage') ? ($('body').removeClass('show-boxpage')) : ($('body').addClass('show-boxpage'));
            $(target).hasClass('active') ? ($(target).removeClass('active')) : ($(target).addClass('active'));
            e.stopPropagation();
        });
    }
    $('.box-header .close-box').on('click', function (e) {
        $('body').removeClass('show-boxpage');
        $(this).parents('.mobile-boxpage').removeClass('active');
        $('#mobile-pageaccount').find('.box-content').removeClass('active');
        e.stopPropagation();
    });
    $('.links-currency, .links-language').on('click', function (e) {
        var target_link = $(this).data('target'),
            title_box = $(this).data('titlebox');

        $('#mobile-pageaccount').find('.box-content').removeClass('active');
        $('.title-box', '#mobile-pageaccount').html(title_box);
        $('.back-box', '#mobile-pageaccount').addClass('active');
        $(target_link).hasClass('active') ? ($(target_link).removeClass('active')) : ($(target_link).addClass('active'));
        e.stopPropagation();
    });
    $('.back-box', '#mobile-pageaccount').on('click', function (e) {
        var titlebox_parent = $('#mobile-pageaccount').data('titlebox-parent');
        $('#mobile-pageaccount').find('.box-content').removeClass('active');
        $('.title-box', '#mobile-pageaccount').html(titlebox_parent);
        $(this).removeClass('active');
    });
}

//MoreverticalMenu
function _moreverticalMenu() {
    if ($('.verticalmenu-content').hasClass('has-showmore') && $(window).width() > 768) {
        var textshowmore = $('.verticalmenu-content').data('textshowmore'),
            textless = $('.verticalmenu-content').data('textless'),
            count_showmore = $('.nov-verticalmenu').data('count_showmore'),
            count_showmore_lg = $('.nov-verticalmenu').data('count_showmore_lg');

        $('ul.menu').each(function () {
            var LiN = $(this).find('>li').length;
            if (LiN > count_showmore) {
                if ($(window).width() > 1199) {
                    var hide_count = count_showmore - 1;
                } else {
                    var hide_count = count_showmore_lg - 1;
                }
                $('>li', this).eq(hide_count).nextAll().hide().addClass('toggleable');
                $(this).append('<li class="more item">' + '<span>' + textshowmore + '</span>' + '</li>');
            }
        });


        $('ul.menu').on('click', '.more', function () {

            if ($(this).hasClass('less')) {
                $(this).removeClass('less').children().text(textshowmore);
            } else {
                $(this).addClass('less').children().text(textless);
            }

            $(this).siblings('li.toggleable').slideToggle();

        });
    }
}

//Vertical-Canvas
function NovVertical_Canvas() {
    if ($(window).width() < 992 && $(window).width() > 767) {
        $('.verticalmenu-main .toggle-nav').click(function (e) {
            $('body').hasClass('open_nov_vertical_menu') ? ($('body').removeClass('open_nov_vertical_menu'), $('.canvas-vertical').removeClass('act')) : ($('body').addClass('open_nov_vertical_menu'), $('.canvas-vertical').addClass('act'));
            e.stopPropagation();
        });
        $(document).on('click', function (e) {
            if ($(e.target).is('.verticalmenu-content') == false) {
                $('body').removeClass('open_nov_vertical_menu');
                $('.canvas-vertical').removeClass('act');
            }
        });
    }
}

//Vertical menu
function NovVerticalToggle() {

    if ($(window).width() < 1200 && $(window).width() > 991) {
        $('.header-style-3 .toggle-vertical, .header-style-7 .toggle-vertical, .header-style-20 .toggle-vertical, .header-style-24 .toggle-vertical, .header-style-27 .toggle-vertical').removeClass('act')
    }
    if ($(window).width() < 991) {
        $('#header .verticalmenu-content .toggle-vertical').on('click', function (e) {
            $(this).hasClass('act') ? ($('.verticalmenu-content .menu.level1').removeClass('active').slideUp(300), $(this).removeClass('act')) : ($('.verticalmenu-content .menu.level1').slideDown(300).addClass('active'), $(this).addClass('act'));
            e.stopPropagation();
        });
    }
}
$('#header .verticalmenu-content .toggle-vertical').on('click', function (e) {
    $('#mobile_top_menu_wrapper').removeClass('active');
    $('body').removeClass('open_nov_mobile_menu');
});


// Filter onecolumn Toggle
function NovFilterOneColumnToggle() {
    $('#filter_onecolumn .facet-title').click(function (e) {
        $('#filter_onecolumn .collapse').removeClass('active').slideUp(300);
        $('#filter_onecolumn .facet-title').not(this).removeClass('active');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).parent().children('.collapse').slideUp(300);
        } else {
            $(this).addClass('active');
            $(this).parent().children('.collapse').slideDown(300);
        }
    });
}

//NovStickySidebar
function NovStickySidebar() {
    $('#header .toggle-verticalmenu').on('click', function (e) {
        $('#header').find('.header-bottom').hasClass('active') ? ($('#header').find('.header-bottom').removeClass('active'), $(this).removeClass('act')) : ($('#header').find('.header-bottom').addClass('active'), $(this).addClass('act'));
        e.stopPropagation();
    });
    $(document).on('click', function (vl) {
        if ($(vl.target).is('.verticalmenu-content') == false) {
            $('#header').find('.header-bottom').removeClass('active');
            $('#header .toggle-verticalmenu').removeClass('act');
        }
    });
    if ($(window).width() < 1920) {
        $('#header .toggle-verticalmenu').click(function () {
            $('body').hasClass('open_nov_header_vertical_menu') ? ($('body').removeClass('open_nov_header_vertical_menu')) : ($('body').addClass('open_nov_header_vertical_menu'));
        });
        $(document).on('click', function (vl) {
            if ($(vl.target).is('.toggle-verticalmenu') == false) {
                $('body').removeClass('open_nov_header_vertical_menu');
                $('#header .header-bottom').removeClass('active');
            }
        });
    }
}

function NovSearchToggle() {
    $('.toggle-search').on("click", function (e) {
        if ($(this).parent().hasClass("active-search")) {
            $(this).parent().removeClass("active-search")
        } else {
            $(this).parent().addClass("active-search")
        }
        e.stopPropagation();
    });
    $('#_mobile_search .nav-search').on("click", function (f) {
        $(this).parent("#_mobile_search").addClass("active-search");
        f.stopPropagation();
    });
    $(document).on('click', function (event) {
        if ($(event.target).is('#searchbox input') == false) {
            $('#_mobile_search').removeClass("active-search");
            $('#searchbox').parent().removeClass("active-search");
        }
    });
}

function NovMegamenuToggle() {
    $('.toggle-megamenu').on("click", function (e) {
        if ($('#_desktop_top_menu').hasClass("active")) {
            $(this).removeClass("active");
            $('#_desktop_top_menu').removeClass("active");
            $('.canvas-overlay').removeClass('act');
        } else {
            $(this).addClass("active");
            $('#_desktop_top_menu').addClass("active");
            $('.canvas-overlay').addClass('act');
        }
        e.stopPropagation();
        $('.canvas-overlay').on('click', function (event) {
            $('#_desktop_top_menu').removeClass("active");
            $('.toggle-megamenu').removeClass("active");
            $(this).removeClass('act');
        });
    });
    $('.menu_close').on("click", function (l) {
        $('.toggle-megamenu').removeClass("active");
        $('#_desktop_top_menu').removeClass("active");
        $('.canvas-overlay').removeClass('act');
    });
}

function NovMyaccountToggle() {
    $('#block_myaccount_infos .toggle-group-account, #_mobile_user_info .toggle-group-account').on("click", function (e) {
        $(this).parent("#block_myaccount_infos").toggleClass("active");
        $(this).parent("#_mobile_user_info").toggleClass("active");
        e.stopPropagation();
    });
    $(document).on('click', function (f) {
        if ($(f.target).is('#footer_account_list') == false) {
            $('#block_myaccount_infos.links').removeClass("active");
        }
        if ($(f.target).is('#_mobile_user_info .toggle-group-account') == false) {
            $('#_mobile_user_info').removeClass("active");
        }
    });
}

function NovSliderSyncing() {
    $(".slider-for").each(function (index) {
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            rtl: rtl,
            asNavFor: '.slider-nav'
        });
    });

    $(".slider-nav").each(function (index) {
        $(this).slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        arrows: false,
                        slidesToShow: 3,
                    }
                }
            ]
        });
    });

    $('.slider-nav a').click(function (e) {
        e.preventDefault();
    });

    $(".nov-slider-for-deal").each(function (index) {
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        $(this).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            rtl: rtl,
            asNavFor: '.nov-slider-nav-deal'
        });
    });

    $(".nov-slider-nav-deal").each(function (index) {
        $(this).slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.nov-slider-for-deal',
            focusOnSelect: true,
            vertical: true,
            infinite: true,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        arrows: false,
                        slidesToShow: 4,
                        vertical: false
                    }
                }
            ]

        });
    });
}

if ($(document).width() < 768) {
    megamenu_rep();
}
$(window).resize(function () {
    if ($(window).width() < 768) {
        megamenu_rep();
    }
});
$(document).ready(function () {
    $('#megamenu .menu li.has-sub > a').bind('click', false);
    $('#verticalmenu .menu li.parent > a').bind('click', false);
});



function megamenu_rep() {
    $("#megamenu .menu li").each(function () {

        if ($(this).hasClass("has-sub") || $(this).hasClass("group")) {
            if ($(this).children("a").length > 0 || $(this).children(".menu-title").length > 0) {
                if ($(this).children(".nov-menu-toggle").length == 0) {
                    $(this).children(".dropdown-menu").css("display", "none");
                }
            } else {
                $(this).children(".dropdown-menu").css("display", "block");
            }
        }
    });
}

//Sticky Menu
function Sticky_Menu() {
    var time;

    var height = $('#nov-megamenu').height();
    var a = 90;
    $(window).scroll(function () {
        if (time)
            clearTimeout(time);
        time = setTimeout(function () {
            var current_position = $(window).scrollTop();
            if (current_position > a) {
                a = current_position;
                $('#nov-megamenu').removeClass('nov-megamenu--fixed');
            } else {
                $('#nov-megamenu').addClass('nov-megamenu--fixed');
                a = current_position;
            }
            if (current_position <= 90) {
                $('#nov-megamenu').removeClass('nov-megamenu--fixed');
            }
        }, 50);
    });
}

//Change Display Type category
function setDefaultGrid() {
    if ($.cookie('nov_grid_list') == 'grid') {
        $('.change-type .grid-type').trigger('click');
    }
    if ($.cookie('nov_grid_list') == 'list') {
        $('.change-type .list-type').trigger('click');
    }
}

$(document).on('click', '.change-type .grid-type', function (e) {
    e.preventDefault();
    $('#categories-product .products').removeClass('list').addClass('grid');
    $('.change-type').find('.grid-type').addClass('active');
    $('.change-type').find('.list-type').removeClass('active');
    $.cookie('nov_grid_list', 'grid', {
        expires: 1,
        path: '/'
    })
});

$(document).on('click', '.change-type .list-type', function (e) {
    e.preventDefault();
    $('#categories-product .products').removeClass('grid').addClass('list');
    $('.change-type').find('.grid-type').removeClass('active');
    $('.change-type').find('.list-type').addClass('active');
    $.cookie('nov_grid_list', 'list', {
        expires: 1,
        path: '/'
    })
});
//Thumnail Slick Product Deal
function Thumnailslider_Deal() {
    $('.productlist_deal .thumbnail').each(function (index) {
        var asNavFor_nav = $('.thumnailslider-for', this).data('asnavfornav');
        var autoplay = $('.thumnailslider-nav', this).data('autoplay');
        var autoplayTimeout = $('.thumnailslider-nav', this).data('autoplayTimeout');
        var items = $('.thumnailslider-nav', this).data('items');
        var items_mobile = $('.thumnailslider-nav', this).data('items_mobile');
        var margin = $('.thumnailslider-nav', this).data('margin');
        var nav = $('.thumnailslider-nav', this).data('nav');
        var dots = $('.thumnailslider-nav', this).data('dots');
        var loop = $('.thumnailslider-nav', this).data('loop');
        var vertical = $('.thumnailslider-nav', this).data('vertical');
        var position = $('.thumnailslider-nav', this).find('.selected').data('position-image');
        var asNavFor_for = $('.thumnailslider-nav', this).data('asnavforfor');
        if ($('body').hasClass('lang-rtl')) {
            var rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            var rtl = false;
        }
        $(asNavFor_for, this).slick({
            rtl: rtl,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            fade: true,
            loop: false,
            arrows: false,
            asNavFor: asNavFor_nav
        });
        $(asNavFor_nav, this).slick({
            rtl: rtl,
            slidesToShow: items,
            slidesToScroll: 1,
            asNavFor: asNavFor_for,
            centerMode: false,
            loop: false,
            focusOnSelect: true,
            dots: false,
            arrows: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: items_mobile,
                        vertical: false,

                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: items_mobile,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: items_mobile,
                    }
                }
            ]
        });

    })
}

//Image With Slick
function Slick_Image_Slider() {
    $('.slick-images-slider').each(function (index) {
        var autoplay = $(this).data('autoplay');
        var autoplayTimeout = $(this).data('autoplayTimeout');
        var items = $(this).data('items');
        var items_mobile = $(this).data('items_mobile');
        var margin = $(this).data('margin');
        var nav = $(this).data('nav');
        var dots = $(this).data('dots');
        var loop = $(this).data('loop');
        var vertical = $(this).data('vertical');
        var position = $(this).find('.selected').data('position-image');
        $(this).slick({
            vertical: vertical,
            //initialSlide: position,
            slidesToShow: items,
            slidesToScroll: 1,
            dots: dots,
            //centerMode: true,
            //centerPadding: '365px',
            initialSlide: 1,
            responsive: [
                {
                    breakpoint: 1441,
                    settings: {
                        dots: dots,
                        //centerMode: true,
                        //centerPadding: '150px',
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        dots: dots,
                        //centerMode: true,
                        //centerPadding: '150px',
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        dots: dots,
                        //centerMode: true,
                        //centerPadding: '0',
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        //centerMode: true,
                        //centerPadding: '0'
                    }
                }
            ]
        });
    })
}
//Thumnail Product
function Thumnail_Product() {
    if ($('body').hasClass('lang-rtl')) {
        rtl = true;
        $(this).attr('dir', 'rtl');
    } else {
        rtl = false;
    }
    var autoplay = $('.slick-images').data('autoplay');
    var autoplayTimeout = $('.slick-images').data('autoplayTimeout');
    var items = $('.slick-images').data('items');
    var items_mobile = $('.slick-images').data('items_mobile');
    var margin = $('.slick-images').data('margin');
    var nav = $('.slick-images').data('nav');
    var dots = $('.slick-images').data('dots');
    var loop = $('.slick-images').data('loop');
    var vertical = $('.slick-images').data('vertical');
    if (vertical == 'true')
        var arrows = 'true';
    else
        var arrows = 'false';
    var position = $('.slick-images').find('.selected').data('position-image');
    $('.slick-images').not('.slick-initialized').slick({
        rtl: rtl,
        slidesToShow: items,
        slidesToScroll: 1,
        nav: nav,
        dot: dots,
        vertical: vertical,
        verticalSwiping: true,
        initialSlide: 0,
        focusOnSelect: true,
        infinite: true,
        prevArrow: '<button class="slide-arrow prev-arrow"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>',
        nextArrow: '<button class="slide-arrow next-arrow"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>',
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    vertical: vertical,
                    infinite: true,
                    nav: false
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    vertical: vertical,
                    infinite: true,
                    nav: false
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    nav: false,
                    vertical: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    nav: false,
                    vertical: false,
                    slidesToScroll: 1
                }
            }
        ]
    });
}

//Related Product Slick
function Related_Product() {
    $(".related-slick-carousel").each(function (index) {
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var autoplay = $('.related-slick-carousel').data('autoplay');
        var autoplayTimeout = $('.related-slick-carousel').data('autoplayTimeout');
        var items = $('.related-slick-carousel').data('items');
        var items_mobile = $('.related-slick-carousel').data('items_mobile');
        var dots = $('.related-slick-carousel').data('dots');
        var arrows = $('.related-slick-carousel').data('arrows');
        var infinite = $('.related-slick-carousel').data('loop');
        var rows = $('.related-slick-carousel').data('rows');
        $('.related-slick-carousel').slick({
            rtl: rtl,
            slidesToShow: items,
            slidesToScroll: items,
            dots: dots,
            arrows: arrows,
            rows: rows,
            infinite: infinite,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: items,
                        slidesToScroll: items,
                        vertical: false,
                        infinite: true,
                        nav: false
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        vertical: false,
                        infinite: true,
                        nav: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        nav: false,
                        vertical: false,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        nav: false,
                        vertical: false,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    })
    $(".related-slick-carousel-column").each(function (index) {
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var autoplay = $('.related-slick-carousel-column').data('autoplay');
        var autoplayTimeout = $('.related-slick-carousel-column').data('autoplayTimeout');
        var items = $('.related-slick-carousel-column').data('items');
        var items_mobile = $('.related-slick-carousel-column').data('items_mobile');
        var dots = $('.related-slick-carousel-column').data('dots');
        var arrows = $('.related-slick-carousel-column').data('arrows');
        var infinite = $('.related-slick-carousel-column').data('loop');
        var rows = $('.related-slick-carousel-column').data('rows');
        $('.related-slick-carousel-column').slick({
            rtl: rtl,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: dots,
            arrows: arrows,
            rows: rows,
            infinite: infinite,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: items,
                        slidesToScroll: items,
                        vertical: false,
                        infinite: true,
                        nav: false
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        vertical: false,
                        infinite: true,
                        nav: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        nav: false,
                        vertical: false,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        nav: false,
                        vertical: false,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    })
}

//Bestseller Product Slick
function Bestseller_Product() {
    $(".bestseller-slick-carousel").each(function (index) {
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var autoplay = $('.bestseller-slick-carousel').data('autoplay');
        var autoplayTimeout = $('.bestseller-slick-carousel').data('autoplayTimeout');
        var items = $('.bestseller-slick-carousel').data('items');
        var items_mobile = $('.bestseller-slick-carousel').data('items_mobile');
        var dots = $('.bestseller-slick-carousel').data('dots');
        var arrows = $('.bestseller-slick-carousel').data('arrows');
        var infinite = $('.bestseller-slick-carousel').data('loop');
        var rows = $('.bestseller-slick-carousel').data('rows');
        $('.bestseller-slick-carousel').slick({
            rtl: rtl,
            slidesToShow: items,
            slidesToScroll: items,
            dots: dots,
            arrows: arrows,
            rows: rows,
            infinite: infinite,
        });
    })
}

//Sticky-menu
novtheme.swapChildren = function (obj1, obj2) {
    var temp = obj2.children().detach();
    obj2.empty().append(obj1.children().detach());
    obj1.append(temp);
}

novtheme.toggleMobileStyles = function () {
    if (novtheme_responsive_mobile) {
        $("*[id^='_desktop_']").each(function (idx, el) {
            var target = $('#' + el.id.replace('_desktop_', '_mobile_'));
            if (target.length) {
                novtheme.swapChildren($(el), target);
            }
        });
    } else {
        $("*[id^='_mobile_']").each(function (idx, el) {
            var target = $('#' + el.id.replace('_mobile_', '_desktop_'));
            if (target.length) {
                novtheme.swapChildren($(el), target);
            }
        });
    }
}

novtheme.toggleSticky = function (action) {
    if (action == true) {
        $("*[class^='contentsticky_']").each(function (idx, el) {
            var target = $('.' + el.classList['0'].replace('contentsticky_', 'contentstickynew_'));
            if (target.length) {
                novtheme.swapChildren($(el), target);
            }
        });
    } else {
        $("*[class^='contentstickynew_']").each(function (idx, el) {
            var target = $('.' + el.classList['0'].replace('contentstickynew_', 'contentsticky_'));
            if (target.length) {
                novtheme.swapChildren($(el), target);
            }
        });
    }
}

novtheme.NovatoggleMobileStylesCart = function () {
    var current_width = $(window).width();
    var min_width = 768;
    var responsive_mobile = current_width < min_width;
    if (responsive_mobile) {
        $("#_mobile_cart").each(function (idx, el) {
            var target = $('#_mobile_cart_bottom');
            if (target) {
                target.append($('#_mobile_cart').html());
            }
        });
    } else {
        $("#_mobile_cart_bottom").each(function (idx, el) {
            var target = $('#_mobile_cart');
            if (target) {
                $("#_mobile_cart_bottom").children().detach();
            }
        });
    }
}

function StickyHeader(flag_sticky) {
    if ($('#header').hasClass('sticky-menu')) {
        if (flag_sticky == true) {
            var time;
            var height = $('#header').height();
            var flag = true;
            $(window).scroll(function () {
                if (time)
                    clearTimeout(time);
                time = setTimeout(function () {
                    if ($(window).scrollTop() >= height) {
                        if (flag == true) {
                            $('#header-sticky').addClass('sticky-menu-active');
                            $('#header').css('height', height);
                            novtheme.toggleSticky(true);
                            flag = false;
                        }
                    } else {
                        if (flag == false) {
                            $('#header-sticky').removeClass('sticky-menu-active');
                            $('#header').css('height', 'auto');
                            novtheme.toggleSticky(false);
                            flag = true;
                        }
                    }
                }, 100);
            });
        }
    }
}

//Go to top
function goToTop() {
    var timer;
    $(window).scroll(function () {
        if (timer)
            clearTimeout(timer)
        timer = setTimeout(function () {
            if ($(window).scrollTop() >= 200) {
                $('#_desktop_back_top #back-top').fadeIn();
            } else {
                $('#_desktop_back_top #back-top').fadeOut();
            }
        }, 300);
    });
    $("#back-top").click(function () {
        $("body,html").animate({ scrollTop: 0 }, "normal");
        return !1
    });
}

function NovRunNumber() {
    $('.count_number').each(function () {
        $(this).prop('number', 0).animate({
            number: $(this).text()
        }, {
            duration: 2000,
            easing: 'swing',
            step: function (e) {
                $(this).text(Math.ceil(e));
            }
        });
    });
}


//Popup newsletter
function PopupNewletter() {
    var date = new Date();
    var minutes = 60;
    date.setTime(date.getTime() + (minutes * 60 * 1000));

    if ($.cookie('popupNewLetterStatus') != 'closed' && $('body').outerWidth() > 768) {
        $("#popup-subscribe").modal({
            show: !0
        });
    }
    $.cookie("popupNewLetterStatus", "closed", {
        'expires': date,
        'path': '/'
    })
    $('input.no-view').change(function () {
        if ($('input.no-view').prop("checked") == 1) {
            $.cookie("popupNewLetterStatus", "closed", {
                'expires': date,
                'path': '/'
            })
        } else {
            $.cookie("popupNewLetterStatus", "", {
                'expires': date,
                'path': '/'
            })
        }
    })
}
if ($("#popup-subscribe").length) {
    $(window).load(function () {
        var timer = window.setTimeout(PopupNewletter, 8000);
    });
}

function NovProductSlider() {
    $('.nov-productslick').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var lg = $(this).data('lg') ? $(this).data('lg') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: lg,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1,
                            arrows: false,
                            dots: false
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                            dots: false
                        }
                    }
                ]
            });
        }
        $(this).on('afterChange', function () {
            $(window).trigger('scroll');
        });
    });
}
function NovDealsSix() {
    $('.nov-deals-6').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1,
                            arrows: false,
                            dots: false
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                            dots: false
                        }
                    }
                ]
            });
        }
        $(this).on('afterChange', function () {
            $(window).trigger('scroll');
        });
    });
}
function NovProductListTwo() {
    $('.nov-product-list-2').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1,
                            arrows: false,
                            dots: false
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                            dots: false
                        }
                    }
                ]
            });
        }
        $(this).on('afterChange', function () {
            $(window).trigger('scroll');
        });
    });
}
function NovBlogSlider() {
    $('.nov-blogslick').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                        }
                    }
                ]

            });
        }
        $(this).on('afterChange', function () {
            $(window).trigger('scroll');
        });
    });
}
function NovManufactureSlider() {
    $('.nov-manufactureslick').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                        }
                    }
                ]
            });
        }
        $(this).on('afterChange', function () {
            $(window).trigger('scroll');
        });
    });
}
function NovLookBookSlider() {
    $('.nov-lookbookslick').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1,
                            dots: false,
                            arrows: false
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                            dots: false
                        }
                    }
                ]
            });
        }
        $(this).on('afterChange', function () {
            $(window).trigger('scroll');
        });
    });
}
function NovInstagramSlider() {
    $('.nov-instagramslick').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1,
                            dots: false
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                            dots: false
                        }
                    }
                ]
            });
        }
    });
}
function NovTestimonialSlider() {
    $('.nov-testimonialslick').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1,
                            dots: false
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                            dots: false
                        }
                    }
                ]
            });
        }
    });
}
function NovImageSlider() {
    $('.nov-imageslick').each(function (index) {
        var width = window.innerWidth || document.body.clientWidth;
        if ($('body').hasClass('lang-rtl')) {
            rtl = true;
            $(this).attr('dir', 'rtl');
        } else {
            rtl = false;
        }
        var arrows = $(this).data('arrows') ? $(this).data('arrows') : false;
        var dots = $(this).data('dots') ? $(this).data('dots') : false;
        var autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
        var xl = $(this).data('xl') ? $(this).data('xl') : 4;
        var md = $(this).data('md') ? $(this).data('md') : 3;
        var xs = $(this).data('xs') ? $(this).data('xs') : 2;
        var rows = $(this).data('rows') ? $(this).data('rows') : 1;
        if (rows == 1) {
            $(this).slick({
                slidesToShow: xl,
                slidesToScroll: 1,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: md,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: xs,
                            slidesToScroll: 1,
                            dots: false
                        }
                    }
                ]
            });
        } else {
            $(this).slick({
                rows: rows,
                slidesPerRow: xl,
                arrows: arrows,
                dots: dots,
                infinite: false,
                autoplay: autoplay,
                autoplaySpeed: 7000,
                adaptiveHeight: true,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesPerRow: md,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesPerRow: xs,
                            dots: false
                        }
                    }
                ]
            });
        }
    });
}
function NovCustomArrowSliderHeading() {
    $('.nov-heading-group .prev_custom').click(function () {
        $(this).parents('.vc_row').find('.slick-slider').first().slick('slickPrev');
    });
    $('.nov-heading-group .next_custom').click(function () {
        $(this).parents('.vc_row').find('.slick-slider').first().slick('slickNext');
    });
}
function ScrollFacet() {
    $('.facet').each(function (i) {
        if ($(this).find('li').length > 5) {
            $(this).addClass('facet-hasscroll');
        }
        ;
        if ($(this).children().children().hasClass('facet_color')) {
            $(this).removeClass('facet-hasscroll').addClass('facet-color');
        }
    })
}
function SocialPopup(url) {
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
    var left = ((width / 2) - (600 / 2)) + dualScreenLeft;
    var top = ((height / 2) - (600 / 2)) + dualScreenTop;
    var newWindow = window.open(url, '_blank', 'scrollbars=yes,top=' + top + ',left=' + left + ',width=500,height=500');
    if (window.focus) {
        newWindow.focus();
    }
}
function NovToggleSearch() {
    $('.js-btn-search').on('click', function (e) {
        var target = $(this).data('target');
        $('body').hasClass('show-boxpage') ? ($('body').removeClass('show-boxpage')) : ($('body').addClass('show-boxpage'));
        $('#nov-searchBox').hasClass('active') ? ($('#nov-searchBox').removeClass('active')) : ($('#nov-searchBox').addClass('active'), $('#nov-searchBox').find('input[type="text"]').focus());
        e.stopPropagation();
    });
    $('.nov-seachBoxClose').on('click', function (e) {
        $('body').removeClass('show-boxpage');
        $('#nov-searchBox').removeClass('active');
        e.stopPropagation();
    });
}

$(window).on('resize load', function () {
    Thumnail_Product();
});
$(document).ready(function () {
    novtheme.NovatoggleMobileStylesCart();
    Nov_Owlcarousel();
    nov_producttab();
    nov_categorytab();
    NovProductSlider();
    NovBlogSlider();
    NovManufactureSlider();
    NovLookBookSlider();
    NovInstagramSlider();
    NovTestimonialSlider();
    NovDealsSix();
    NovProductListTwo();
    NovImageSlider();
    Category_Html_Owlcarousel();
    Thumnailslider_Deal();
    NovVertical_Canvas();
    NovVerticalToggle();
    NovStickySidebar();
    NovToggleAction();
    NovFilterOneColumnToggle();
    Related_Product();
    Bestseller_Product();
    _moreverticalMenu();
    NovTogglePage();
    setDefaultGrid();
    NovCustomArrowSliderHeading();
    ScrollFacet();
    NovToggleSearch();
    NovMegamenuToggle();
    NovSliderSyncing();
    NovMyaccountToggle();
    NovSearchToggle();
    goToTop();
    if (novtheme_current_width > 767) {
        StickyHeader(true);
        flag_sticky = true;
    }


    //enable tooltip everywhere
    $('[data-toggle="tooltip"]').tooltip();
    if ($('body').hasClass('page-index')) {
    } else {
        //$(".category-sub-menu li .collapse").first().collapse("show");
    }

    if ($(window).width() > 767) {
        $("#product .col-right .block_content").stick_in_parent({
            offset_top: 10
        });
    }

    $("#nov-verticalmenu li").first().children('.dropdown-menu').slideDown(300);
    $("#nov-verticalmenu li").first().children('.block_content').slideDown(300);
    $("#nov-verticalmenu li").first().addClass('menu-active');

    $(".show-sub").click(function () {
        var $this = $(this);
        if ($this.parent().hasClass('menu-active')) {
            $this.parent().removeClass('menu-active');
            $this.parent().find('>.dropdown-menu').slideUp(300);
        } else {
            $this.parent().parent().find('li').removeClass('menu-active');
            $this.parent().parent().find('li >.dropdown-menu, li .block_content').slideUp(300);
            $this.parent().addClass('menu-active');
            $this.parent().find('>.dropdown-menu').slideDown(300);
        }
        return false;
    });

    $('.opener').click(function () {
        if ($(this).parent('li').hasClass('menu-active')) {
            $(this).parent('li').children('.dropdown-menu').slideUp(300);
            $(this).parent('li').removeClass('menu-active');
        } else {
            $(this).parent('li').children('.dropdown-menu').slideDown(300);
            $(this).parent('li').addClass('menu-active');
        }
    });

    $('.countdownfree').each(function (e) {
        var time_count = $(this).data('date');
        var days = $(this).data('days');
        var hours = $(this).data('hours');
        var min = $(this).data('min');
        var seconds = $(this).data('seconds');
        $(this).countdown(time_count, function (event) {
            var $this = $(this).html(event.strftime(''
                + '<div class="item-time"><div><span class="data-time">%D</span><span class="name-time">' + days + '</span></div></div>'
                + '<div class="item-time"><div><span class="data-time">%H</span><span class="name-time">' + hours + '</span></div></div>'
                + '<div class="item-time"><div><span class="data-time">%M</span><span class="name-time">' + min + '</span></div></div>'
                + '<div class="item-time"><div><span class="data-time">%S</span><span class="name-time">' + seconds + '</span></div></div>'
            ));
        });
    });

    $('.comingsoon').each(function (e) {
        var time_count = $(this).data('date');
        var days = $(this).data('days');
        var hours = $(this).data('hours');
        var min = $(this).data('min');
        var seconds = $(this).data('seconds');
        $(this).countdown(time_count, function (event) {
            var $this = $(this).html(event.strftime(''
                + '<div class="item-time"><div><span class="data-time">%D</span><span class="name-time">' + days + '</span></div></div>'
                + '<div class="item-time"><div><span class="data-time">%H</span><span class="name-time">' + hours + '</span></div></div>'
                + '<div class="item-time"><div><span class="data-time">%M</span><span class="name-time">' + min + '</span></div></div>'
                + '<div class="item-time"><div><span class="data-time">%S</span><span class="name-time">' + seconds + '</span></div></div>'
            ));
        });
    });

    $('#products').on('click', '.js-search-link', function (event) {
        var target = $("#header");
        if (target.length) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top + 100
            }, 1000);
        }
    });

    if ($('#verticalmenu').length === 0) {
        $('.header-mobile').addClass('not-vertical');
    }
    if ($(window).width() < 992 && $(window).width() > 767) {
        if ($('#verticalmenu').length > 0) {
            $('.verticalmenu-main').css('display', 'block');
        }
    }
    // Header cart canvas

    $(document).on('click', '.open_header_cart_canvas', function (e) {
        $('.header-cart-canvas').addClass('active');
    })
    $(document).on('click', '.close_canvas.cart', function (e) {
        $('.header-cart-canvas').removeClass('active');
    })
    // Account list canvas
    $('.settings-canvas .show_settings_canvas').click(function () {
        $('.settings-canvas').addClass('active');
    })
    $('.close_canvas.settings').click(function () {
        $('.settings-canvas').removeClass('active');
    })

    // Facet search
    if ($('#search_filters').children().length == 0) {
        $('#search_filters_wrapper').addClass('hidden');
    }
    $('.onecol #search_filter_toggler').click(function () {
        $('#filter_onecolumn').removeClass('hidden-sm-down');
    })

    // NovRunNumber
    var winHeight = $(window).height();
    if ($('.count_number').length) {
        var Event = false,
            offset_top = $('.count_number').offset().top,
            distance = offset_top - winHeight;
        $(window).on('scroll', function () {
            var currentPosition = $(document).scrollTop();
            if (currentPosition > distance && Event === false) {
                Event = true;
                NovRunNumber();
            }
        });
    }

});

var flag_sticky = false;
$(window).on('resize', function () {
    var _cw = $(window).innerWidth();
    var _mw = 768;
    var _w = novtheme_current_width;
    var novtheme_responsive_mobile = _cw < _mw;
    if (_cw <= 992) {
        if (flag_sticky == true) {
            novtheme.toggleSticky(false);
            $('#header-sticky').removeClass('sticky-menu-active');
        }
    } else {
        //novtheme.toggleSticky(true);
    }
    NovVertical_Canvas();
});


let modalId = $('#image-gallery');

$(document)
    .ready(function () {

        loadGallery(true, 'a.thumbnail');

        function disableButtons(counter_max, counter_current) {
            $('#show-previous-image, #show-next-image')
                .show();
            if (counter_max === counter_current) {
                $('#show-next-image')
                    .hide();
            } else if (counter_current === 1) {
                $('#show-previous-image')
                    .hide();
            }
        }


        function loadGallery(setIDs, setClickAttr) {
            let current_image,
                selector,
                counter = 0;

            $('#show-next-image, #show-previous-image')
                .click(function () {
                    if ($(this)
                        .attr('id') === 'show-previous-image') {
                        current_image--;
                    } else {
                        current_image++;
                    }

                    selector = $('[data-image-id="' + current_image + '"]');
                    updateGallery(selector);
                });

            function updateGallery(selector) {
                let $sel = selector;
                current_image = $sel.data('image-id');
                $('#image-gallery-title')
                    .text($sel.data('title'));
                $('#image-gallery-image')
                    .attr('src', $sel.data('image'));
                disableButtons(counter, $sel.data('image-id'));
            }

            if (setIDs == true) {
                $('[data-image-id]')
                    .each(function () {
                        counter++;
                        $(this)
                            .attr('data-image-id', counter);
                    });
            }
            $(setClickAttr)
                .on('click', function () {
                    updateGallery($(this));
                });
        }
    });

$(document).keydown(function (e) {
    switch (e.which) {
        case 37: // left
            if ((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
                $('#show-previous-image')
                    .click();
            }
            break;

        case 39: // right
            if ((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
                $('#show-next-image')
                    .click();
            }
            break;

        default:
            return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
});


$(window).on('load', function () {
    var timeout = setTimeout(function () {
        $('.nov-lazyload').lazy({
            effect: 'fadeIn',
            effectTime: 'slow',
            threshold: 0
        });
    }, 2000);
});


function desktopClick() {
    $('.cart_block').addClass('hover-active');
}
function desktopout() {
    $('.cart_block').removeClass('hover-active');
}

$(document).ready(function () {
    if (window.screen.width <= 767) {
        $('#_desktop_cart').innerHTML = ''
        document.getElementById('_mobile_cart').style.visibility = 'hidden'
        $("*[id^='_desktop_']").each(function (idx, el) {
            var target = $('#' + el.id.replace('_desktop_', '_mobile_'));
            if (target.length) {
                novtheme.swapChildren($(el), target);
            }
        });

    }
    else {
        $('#_mobile_cart').innerHTML = ''
    }
})
