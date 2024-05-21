/**
 * Vinova Themes Framework for Prestashop 1.6.x
 * @author      http://vinovathemes.com/
 * @copyright   Copyright (C) October 2017 vinovathemes.com <@email:vinovathemes@gmail.com>
 * @license   GNU General Public License version 1
 * @version     1.0
 * @package     novlookbook
 * <info@vinovathemes.com>.All rights reserved.
 **/

jQuery(document).ready(function ($) {
  if($('body').hasClass('lang-rtl'))
      var rtl = true;
  else
      var rtl = false;
  var items = $('.nov-lookbookslider').data('items'),
  items_md = $('.nov-lookbookslider').data('items_md'),
  items_sm = $('.nov-lookbookslider').data('items_sm'),
  items_xs = $('.nov-lookbookslider').data('items_xs'),
  margin = $('.nov-lookbookslider').data('margin'),
  margin = $('.nov-lookbookslider').data('margin'),
  margin = $('.nov-lookbookslider').data('margin');

  $('.nov-lookbookslider').owlCarousel({
    navText: [ '<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>' ],
    lazyLoad         : true,
    lazyContent      : true,
    loop             : true,
    items            : items,
    margin           : 30,
    rtl              : rtl,
    dots             : true,
    nav              : true,
    responsive       : {
      0 : {
          items: items_xs,
      },
      768 : {
          items: items_sm,
      },
      992 : {
          items: items_md,
      },
      1200 : {
          items: items,
      },
    }
  });

});