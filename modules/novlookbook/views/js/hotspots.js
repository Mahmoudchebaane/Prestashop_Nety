/**
 * Vinova Themes Framework for Prestashop 1.6.x
 * @author      http://vinovathemes.com/
 * @copyright   Copyright (C) October 2017 vinovathemes.com <@email:vinovathemes@gmail.com>
 * @license   GNU General Public License version 1
 * @version     1.0
 * @package     novlookbook
 * <info@vinovathemes.com>.All rights reserved.
 **/

$.extend({
    setHotspots: function (slide, hotspots) {
        if (!hotspots)
            return;

        var i = 0;

        $(hotspots).each(function () {
            if (!document.getElementById(hotspots[i].id)) {
                var imgwidth = slide.width();
                var scale = imgwidth / hotspots[i].imgW;
                if (typeof hotspots[i].imgW == 'undefined' || hotspots[i].imgW === null) {
                    scale = 1;
                    hotspots[i].imgH = slide.height();
                }
                var offsetH = parseInt((hotspots[i].imgH * scale - slide.height()) / 2);
                var left_pos = hotspots[i].left / (hotspots[i].imgW / 100); //procent
                var top_pos = hotspots[i].top / (hotspots[i].imgH / 100);

                var width_pos = hotspots[i].width / (hotspots[i].imgW / 100) + '%';
                var height_pos = hotspots[i].height / (hotspots[i].imgH / 100) + '%';

                slide.append('<div class="hotspot" id="' + hotspots[i].id + '" style="left:' + left_pos + '%; top:' + top_pos + '%; width:' + width_pos + '; height:' + height_pos + ';">' + hotspots[i].text + '</div>');
                var infoblock = slide.find('#' + hotspots[i].id + ' .product-info');
                var infowidth = parseInt(infoblock.actual('outerWidth'));
                var hspt_width_hf = parseInt(hotspots[i].width * scale / 2);
                var leftposition = hotspots[i].left * scale + hspt_width_hf + 7;
                infoblock.find('.info-icon').css('left', hspt_width_hf + 'px');

                if (((leftposition + infowidth + 10) > imgwidth) && (leftposition > (imgwidth - leftposition)))
                {
                    if ($.browser.msie && $.browser.version == '8.0') {
                        if (leftposition - 5 < infowidth) {
                            infoblock.css('width', leftposition - 20 + 'px');
                            infowidth = infoblock.width();
                        }
                        infoblock.css('left', '50%');
                        infoblock.css('margin-left', '-' + infowidth - 2 * parseInt(infoblock.css('padding-left')) + 'px');
                    }
                    else
                    {
                        infoblock.css('left', '');
                        infoblock.css('right', '50%');
                    }

                    if (leftposition - 5 < infowidth) {
                        infoblock.css('width', leftposition - 20 + 'px');
                        infowidth = infoblock.width();
                    }
                }
                else
                {
                    infoblock.css('left', '50%');
                    if ((imgwidth - leftposition - 5) < infowidth) {
                        infoblock.css('width', imgwidth - leftposition - 20 + 'px');
                        infowidth = infoblock.width();
                    }
                }
                var imgheight = parseInt(slide.height());
                var infoheight = parseInt(infoblock.actual('outerHeight'));
                var hspt_height_hf = parseInt(hotspots[i].height * scale / 2);
                var topposition = hotspots[i].top * scale + hspt_height_hf;

                if (((topposition + infoheight + 5) > imgheight) && (topposition > (imgheight - topposition)))
                {

                    if ($.browser.msie && $.browser.version == '8.0') {
                        if (topposition - 5 < infoheight) {
                            infoblock.css('height', topposition - 10 + 'px');
                            infoheight = infoblock.height();
                        }
                        infoblock.css('top', '50%');
                        infoblock.css('margin-top', '-' + infoheight - 2 * parseInt(infoblock.css('padding-top')) + 'px');
                    }
                    else
                    {
                        infoblock.css('top', '');
                        infoblock.css('bottom', hspt_height_hf + 'px');
                    }

                    if (topposition - 5 < infoheight) {
                        infoblock.css('height', '100%');
                        //infoblock.css('top', '50%');
                        infoblock.css('height', topposition - 10 + 'px');
                        infoheight = infoblock.height();
                    }
                }
                else
                {
                    infoblock.css('top', '50%');
                    if ((imgheight - topposition - 5) < infoheight) {
                        //infoblock.css('height', imgheight - topposition - 10 + 'px');
                        infoheight = infoblock.height();
                    }
                }
                /////// set position for hotspot-icon /////////////
                var icon = slide.find('#' + hotspots[i].id + ' .hotspot-icon');
                //icon.css('left', '50%');
                //icon.css('top', '50%');
                icon.css('margin-left', '-' + hotspots[i].icon_width / 2 + 'px');
                icon.css('margin-top', '-' + hotspots[i].icon_height / 2 + 'px');
                i++;
            }
        });
    },
    updateHotspots: function (slide, hotspots) {
        if (!hotspots)
            return;
        var i = 0;
        hotspots.each(function () {
            if (document.getElementById(hotspots[i].id)) {
                var imgwidth = slide.width();
                var scale = imgwidth / hotspots[i].imgW;
                if (typeof hotspots[i].imgW == 'undefined' || hotspots[i].imgW === null) {
                    scale = 1;
                    hotspots[i].imgH = slide.height();
                }
                var offsetH = parseInt((hotspots[i].imgH * scale - slide.height()) / 2);
                $('#' + hotspots[i].id).css('left', parseInt(hotspots[i].left * scale) + 'px');
                $('#' + hotspots[i].id).css('top', parseInt(hotspots[i].top * scale - offsetH) + 'px');
                i++;
            }
        });
    }
});

$(document).ready(function () {
    var handleClick = 'ontouchstart' in document.documentElement ? 'touchstart' : 'click';
    if ("ontouchstart" in document.documentElement) {
        $(document).on('touchstart', 'body', function (e) {
            $(".hotspot").removeClass('hover');
            e.stopPropagation();
        });
        $(document).on('touchstart', '.hotspot', function (e) {
            $(".hotspot").removeClass('hover');
            $(this).addClass('hover');
        });
        $(document).on('touchstart', '.hotspot .product-info', function (event) {
            event.preventDefault();
            event.stopPropagation();
        });
        $(document).on('touchend click tap', '.hotspot .product-info a', function (event) {
            event.preventDefault();
            event.stopPropagation();
        });
        $(document).on('touchstart', '.hotspot .product-info a', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var el = $(this);
            var link = el.attr('href');
            window.location = link;
        });
    }
});