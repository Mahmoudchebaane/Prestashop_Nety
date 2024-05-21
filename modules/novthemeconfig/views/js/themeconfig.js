
/*! jquery.cookie v1.4.1 | MIT */
/*jshint eqnull:true */
/*!
 * jQuery Cookie Plugin v1.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2011, Klaus Hartl
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/GPL-2.0
 */
(function($, document) {

    var pluses = /\+/g;
    function raw(s) {
        return s;
    }
    function decoded(s) {
        return decodeURIComponent(s.replace(pluses, ' '));
    }

    $.cookie = function(key, value, options) {

        // key and at least value given, set cookie...
        if (arguments.length > 1 && (!/Object/.test(Object.prototype.toString.call(value)) || value == null)) {
            options = $.extend({}, $.cookie.defaults, options);

            if (value == null) {
                options.expires = -1;
            }

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }

            value = String(value);

            return (document.cookie = [
                encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // key and possibly options given, get cookie...
        options = value || $.cookie.defaults || {};
        var decode = options.raw ? raw : decoded;
        var cookies = document.cookie.split('; ');
        for (var i = 0, parts; (parts = cookies[i] && cookies[i].split('=')); i++) {
            if (decode(parts.shift()) === key) {
                return decode(parts.join('='));
            }
        }
        return null;
    };

    $.cookie.defaults = {};

})(jQuery, document);
$(document).ready(function(){

    // Make the first tab active
    var $_firstTab = $('#nov-config-tabs .tab').first();
    $_firstTab.addClass('active');

    var firstTabContentID = '#' + $_firstTab.attr('data-tab');
    $('#configuration_form .panel').first().show();

    // On tab click
    $('#nov-config-tabs .tab').on('click', function()
    {
        var tabContentID =  $(this).data('tab');
        $('#configuration_form .panel').animate({ opacity: 0 }, 0).css("display","none");
        $('[id^="'+tabContentID+'"]').css("display","block").animate({ opacity: 1 }, 200);

        $('#nov-config-tabs .tab').removeClass('active');
        $(this).addClass('active');
    });
	
	$('.fontOptions').trigger('change');

    var cookieshowhide = $.cookie('SOME-COOKIE');
    if(cookieshowhide == 1) {
        $(".nov-importdata").hide();
    }

    $('.nov-importdata').click(function(){
        $.cookie("SOME-COOKIE", 1, { expires : 100000000 });
        $(".nov-importdata").hide();
    })
});


var handle_font_change = function(that,systemFonts){
    var systemFontsArr = systemFonts.split(',');
    var selected_font = $(that).val();
    var identi = $(that).attr('id');
	
    if(!$('#'+identi+'_link').size())
        $('head').append('<link id="'+identi+'_link" rel="stylesheet" type="text/css" href="" />');
    if($.inArray(selected_font, systemFontsArr)<0)
        $('link#'+identi+'_link').attr({href:'http://fonts.googleapis.com/css?family=' + selected_font.replace(' ', '+')});
    $('#'+identi+'_example').css('font-family',selected_font);
    
};