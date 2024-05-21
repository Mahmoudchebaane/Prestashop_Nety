/* global $, prestashop */

/**
 * This module exposes an extension point in the form of the `showModal` function.
 *
 * If you want to override the way the modal window is displayed, simply define:
 *
 * prestashop.blockcart = prestashop.blockcart || {};
 * prestashop.blockcart.showModal = function myOwnShowModal (modalHTML) {
 *   // your own code
 *   // please not that it is your responsibility to handle closing the modal too
 * };
 *
 * Attention: your "override" JS needs to be included **before** this file.
 * The safest way to do so is to place your "override" inside the theme's main JS file.
 *
 */

$(document).ready(function () {
  prestashop.blockcart = prestashop.blockcart || {};
  var showModal = prestashop.blockcart.showModal || function (modal) {
    var $body = $('body');
    $body.append(modal);
    $body.one('click', '#blockcart-modal', function (event) {
      if (event.target.id === 'blockcart-modal') {
        $(event.target).remove();
      }
    });
  };

  $(document).ready(function () {
    $('.add-to-cart.show_popup').click(function(){
      $(this).addClass('cart-loading');
    });

    prestashop.on(
      'updateCart',
      function (event) {
        console.log(event);
        var refreshURL = $('.blockcart').data('refresh-url');
        var requestData = {};
        console.log('testtt request', event.reason.idProductAttribute, event.reason.idProduct, event.reason.linkAction)
        if (event && event.reason) {
          requestData = {
            id_product_attribute: event.reason.idProductAttribute,
            id_product: event.reason.idProduct,
            action: event.reason.linkAction
          };
        
        }

        $.post(refreshURL, requestData).then(function (resp) {
          
          $('.blockcart').replaceWith($(resp.preview).find('.blockcart'));
          if (resp.modal) {
            $('.add-to-cart.show_popup').removeClass('cart-loading');
            showModal(resp.modal);
          }
        }).fail(function (resp) {
          prestashop.emit('handleError', {eventType: 'updateShoppingCart', resp: resp});
        });
      }
    );
  });
});
