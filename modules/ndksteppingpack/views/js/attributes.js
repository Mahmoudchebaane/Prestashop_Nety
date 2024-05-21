/**
 *  Tous droits réservés NDKDESIGN
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
 */

$(document).ready(function () {
  /*$('.att_list').each(function(index){
		$att_list = $(this);
		var idCombination = $att_list.find('select.attribute_select').val();
		if(idCombination != 'undefined')
			$att_list.next().find('a.ajax_add_to_cart_button').attr("data-id-combination", idCombination);
	});*/
  //console.log('test');
  $(".ndk_att_list .ndk_attribute_select").each(function () {
    $(this).trigger("change");
  });
});

$(document).on("change", ".ndk_att_list .ndk_attribute_select", function () {
  var idCombination = $(this).val();
  var text = $(this).find("option:selected").attr("title");
  var price = $(this).find("option:selected").attr("data-display-price");
  console.log(price);
  //$(this).prev().find('.product-name').append(text);
  if (price != "")
    $(this)
      .closest(".product-miniature")
      .find(".product-price-and-shipping")
      .text(price);
  var ref = $(this).attr("ref");
  if (idCombination != "undefined") {
    $(".ajax_add_to_cart_button[data-id-product='" + ref + "']").attr(
      "data-id-product-attribute",
      idCombination
    );
    $(this)
      .parent()
      .parent()
      .parent()
      .find("#id_product_attribute_" + ref)
      .val(parseInt(idCombination));
  }
});

$(document).on("change", ".ndk_qtty_input", function () {
  setNdkQuantityWanted($(this));
});

$(document).on("keyup", ".ndk_qtty_input", function () {
  setNdkQuantityWanted($(this));
});

$(document).on("blur", ".ndk_qtty_input", function () {
  if ($(this).val() == "") $(this).val(1);
});

function setNdkQuantityWanted(el) {
  var qtty = el.val();
  max = parseInt(el.attr("max"));
  if (max != 0 && el.val() > max) {
    el.val(max);
    qtty = max;
  }
  var ref = el.attr("ref");

  if (qtty != "undefined") {
    $(".ajax_add_to_cart_button[data-id-product='" + ref + "']").attr(
      "data-minimal_quantity",
      qtty
    );
    $("#quantity_wanted_" + ref).val(qtty);
  }
}

$(document).on("click", ".quantity-ndk-minus", function (e) {
  e.preventDefault();
  targetClass = ".ndk_qtty_input";
  input = $(this).parent().find(targetClass);
  step = 1;
  currentVal = parseInt(input.val());
  if (input.attr("min") > 0) quantityMinNdk = parseInt(input.attr("min"));
  else quantityMinNdk = 0;
  if (!isNaN(currentVal) && currentVal - step > quantityMinNdk)
    input
      .val(currentVal - parseFloat(step))
      .trigger("keyup")
      .trigger("change");
  else input.val(quantityMinNdk).trigger("keyup").trigger("change");
});

$(document).on("click", ".quantity-ndk-plus", function (e) {
  e.preventDefault();
  targetClass = ".ndk_qtty_input";
  input = $(this).parent().find(targetClass);
  step = 1;
  currentVal = parseInt(input.val());
  if (input.attr("max") > 0) quantityMaxNdk = parseInt(input.attr("max"));
  else quantityMaxNdk = 0;

  if (!isNaN(currentVal) && currentVal + step <= quantityMaxNdk)
    input
      .val(currentVal + parseFloat(step))
      .trigger("keyup")
      .trigger("change");
  else input.val(quantityMaxNdk).trigger("keyup").trigger("change");
});
