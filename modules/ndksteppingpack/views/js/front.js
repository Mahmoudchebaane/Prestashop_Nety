/**
 *  Tous droits réservés NDKDESIGN
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
 */

var documentBody = document.body;
//var autotimeline = false;
var ndkLoader =
  '<div class="ndk-loader" id="ndkloader"><div class="blasting-ripple loader"></div></div>';

if (typeof ndksp_auto_timeline == "1") autotimeline = true;

$(document).ready(function () {
  if (page_name == "module-ndksteppingpack-default") {
    $(".shopping_cart > a:first-child").attr("href", "#");

    checkCart(true);
    $(document).on("click", ".stepnavButton:not(.disabled)", function () {
      $(".stepnavButton").removeClass("activeStep");
      $(this).addClass("activeStep").removeClass("disabled");
      target = $(this).attr("data-target");
      $(".stepBlock").hide();
      $("#" + target).show();
      if (!$(this).hasClass("productsLoaded"))
        getProductsAjax($(this).attr("data-id-step"));
    });

    var resumeBlock = new HoverWatcher("#timeline");

    $(".stepnavButton.activeStep").first().trigger("click");

    if (autotimeline == 1) {
      $("#timeline").hover(
        function () {
          $("#resume_pack").stop(true, true).slideDown(450);
          $(this).removeClass("active");
        },
        function () {
          setTimeout(function () {
            if (!resumeBlock.isHoveringOver())
              $("#resume_pack").stop(true, true).slideUp(450);
            $(this).addClass("active");
          }, 200);
        }
      );
    } else {
      $(document).on("click", "#timeline .toggler", function () {
        $("#timeline").toggleClass("active");
        $("#resume_pack").slideToggle();
      });
    }

    hidePrices();
  } else if (page_name == "search" && show_packs_category == 1) {
    $.ajax({
      type: "GET",
      url: ndksp_ajax_url,
      data: {
        action: "searchResult",
        search_query: getQueryParam("search_query"),
      },
      dataType: "html",
      cache: true,
      success: function (data) {
        targets = [
          "#js-product-list",
          "#content-wrapper .product_list",
          "#content-wrapper .product_row",
        ];
        for (var i = 0; i < targets.length; i++) {
          if ($(".pack-list").length == 0) $(targets[i]).prepend(data);
        }
        setTimeout(function () {
          equalheight(".image-block");
          equalheight(".pack_desc");
          equalheight(".pack_name");
          equalheight(".pack-infos-block .price");
        }, 1000);
      },
    });
  } else if (page_name == "category" && show_packs_category) {
    $.ajax({
      type: "GET",
      url: ndksp_ajax_url,
      data: { action: "categoryResult", id_category: id_category },
      dataType: "html",
      cache: true,
      success: function (data) {
        targets = [
          "#js-product-list",
          "#content-wrapper .product_list",
          "#content-wrapper .product_row",
        ];
        for (var i = 0; i < targets.length; i++) {
          if ($(".pack-list").length == 0) $(targets[i]).prepend(data);
        }

        setTimeout(function () {
          equalheight(".image-block");
          equalheight(".pack_desc");
          equalheight(".pack_name");
          equalheight(".pack-infos-block .price");
        }, 1000);
      },
    });
  }
});

function getQueryParam(param) {
  location.search
    .substr(1)
    .split("&")
    .some(function (item) {
      // returns first occurence and stops
      return item.split("=")[0] == param && (param = item.split("=")[1]);
    });
  return param;
}

function simulateLinkFromPopup(id) {
  $(".fancybox-close").trigger("click");
  $("#stepNav_" + id).trigger("click");
}

function hidePrices() {
  for (idPrice in hiddenPrices) {
    if (typeof hiddenPrices[idPrice] != "undefined") {
      $("#step_" + hiddenPrices[idPrice])
        .find(".price, .price_container, .content_price, .product-price")
        .hide();
      $("#step_" + hiddenPrices[idPrice])
        .find(".quick-view")
        .attr("hide-price", 1)
        .hide()
        .attr("disabled", "disabled");
      $("#step_" + hiddenPrices[idPrice])
        .find(" .lnk_view, .product-name, .product_img_link")
        .attr("hide-price", 1);
    }
  }
}

$(document).on("click", ".js-search-link", function () {
  id_step = $(".activeStep:eq(0)").attr("data-id-step");
  page = $(this).attr("quick-target");
  getProductsAjax(id_step, page);
});
function getProductsAjax(id_step, page) {
  page = page || 1;
  var counterPossible = 1;
  counterBlock = $("#counter_" + id_step);
  if (counterBlock.attr("data-max") == 0) counterPossible = 99999;
  else counterPossible = counterBlock.attr("data-max");

  $.ajax({
    type: "GET",
    url: ndksp_ajax_url,
    data: { action: "getProducts", id_step: id_step, paginate: page },
    dataType: "html",
    cache: true,
    success: function (data) {
      $("#step_products_" + id_step)
        .hide()
        .html(data);
      $("#stepNav_" + id_step).addClass("productsLoaded");
      $.when(hidePrices()).then(function () {
        $(".ndk_att_list .ndk_attribute_select").each(function () {
          $(this).trigger("change");
        });
        //console.log(counterPossible);
        $("#step_products_" + id_step)
          .find(".ndk_qtty_input")
          .attr("max", counterPossible)
          .trigger("change")
          .trigger("keyup");

        $("#step_products_" + id_step).show();
        setFalseLink();
        equalheight(".ndk_att_list");
        setProductsCarousel();
      });
    },
  });
}

var ndkcp_carousel_pager = true;
var ndkcp_carousel_arrows = false;
function setProductsCarousel() {
  if (typeof ndk_overflows == "undefined") {
    console.log("we don't want carousel");
    return false;
  }
  $("#js-product-list .products").each(function () {
    var it = $(this);
    check_class = [
      "> [itemprop='itemListElement']",
      "> .product",
      "> .product-miniature",
    ];
    for (i = 0; i <= check_class.length; ++i) {
      if (it.find(check_class[i]).length > 0) itemClass = check_class[i];
    }
    it.setOverflow({
      direction: "x",
      item: itemClass,
      moveStep: 2,
      visibleItemsTablet: false,
      visibleItemsMobile: 2,
      auto: false,
      pager: ndkcp_carousel_pager,
      arrows: ndkcp_carousel_arrows,
    });
  });
}
function setFalseLink() {
  $(
    '.view_button, .lnk_view, .product-name, .product_img_link, .product-miniature a:not(".quick-view"), .product-thumbnail, .pagination a'
  ).each(function () {
    url = $(this).attr("href");
    $(this).attr("href", "#").attr("quick-target", url);
  });
}

function checkCart(firstTime) {
  var popupContent = "";
  var continueButton = false;
  var ctnshow = false;
  var titleshow = false;
  var nextButton = false;
  var optionnalButton = true;
  $.ajax({
    type: "GET",
    url: ndksp_ajax_url,
    data: { action: "checkCart", ndk_id_pack: idPack, stepsLite: stepsLite },
    dataType: "json",
    cache: true,
    success: function (data) {
      if (autotimeline == 1) {
        $("#resume_pack").slideDown("slow");
        setTimeout(function () {
          $("#resume_pack").slideUp("slow");
        }, 4000);
      }
      for (var i = 0; i < data.length; i++) {
        counterBlock = $("#counter_" + data[i].id_step);
        counterLeft = counterBlock.attr("data-min") - data[i].count;

        var counterPossible = 1;
        if (counterBlock.attr("data-max") == 0) counterPossible = 99999;
        else counterPossible = counterBlock.attr("data-max") - data[i].count;

        if (counterLeft <= 0) {
          counterLeft = 0;
          counterBlock.hide();
        } else {
          counterBlock.show();
        }

        counterBlock.find(".counterLeft").removeClass("lighted");
        counterBlock.find(".counterLeft").html(counterLeft).addClass("lighted");
        clonedCounter = counterBlock.clone();

        //on met à jour le max quantity de chaque input
        $("#step_" + data[i].id_step)
          .find(".ndk_qtty_input")
          .attr("max", counterPossible)
          .trigger("change")
          .trigger("keyup");

        $("#resume-step-" + data[i].id_step).find(".products").html(data[i].resume);
        //equalheight('.resume-step dl.products');
        $(documentBody).animate({ scrollTop: $(".stepnav").offset().top }, 500);

        //if($(window).width() > 768)
        //equalheight('.resume-step');

        if (data[i].status == 1) {
          $("#stepNav_" + data[i].id)
            .attr("disabled", false)
            .removeClass("disabled");
          $("#stepNav_" + data[i].id_step).addClass("step_done");
          if (data[i].disable_it == 1) {
            $("#stepNav_" + data[i].id_step)
              .attr("disabled", "disabled")
              .addClass("disabled fullStep")
              .attr("onmouseover", "showFullMsg();");
            $("#step_" + data[i].id_step).addClass("denyOrder");
            //$('li#stepNav_'+data[i].id).trigger('click');
          } else {
            $("#stepNav_" + data[i].id_step)
              .attr("disabled", false)
              .removeClass("disabled")
              .removeClass("fullStep");
            $("#step_" + data[i].id_step).removeClass("denyOrder");
          }
          if (!nextButton && !titleshow)
            popupContent += "<h3>" + WhatYouWant + "</h3>";
          titleshow = true;
          //ajout popup
          if (!continueButton && !optionnalButton) {
            if (data[i].disable_it == 0 && !ctnshow) {
              if (counterLeft > 0) popupContent += $(clonedCounter).html();

              popupContent +=
                '<a class="ctn-1 continue btn btn-default button exclusive-medium  btn-1" onclick="simulateLinkFromPopup(' +
                data[0].id_step +
                ');"><span>' +
                continueText +
                "</span></a>";
              continueButton = true;
              ctnshow = true;
            }
          }
          if (!nextButton) {
            if (data[0].step_todo == 0) {
              popupContent +=
                '<a class="createPack btn btn-default button button-medium" href="' +
                orderLink +
                '"><span>' +
                orderText +
                "</span></a>";
              nextButton = true;

              if (data[0].step_cando > 0) {
                popupContent +=
                  '<a class="next-1 nextBtn btn btn-default button button-medium" onclick="simulateLinkFromPopup(' +
                  data[0].step_cando +
                  ');"><span>' +
                  (data[0].optionnal == 1 ? optionnalText : nextText) +
                  "</span></a>";
                nextButton = true;
                if (data[0].optionnal == 1) optionnalButton = true;
              }
            } else {
              popupContent +=
                '<a class="next-2 nextBtn btn btn-default button button-medium" onclick="simulateLinkFromPopup(' +
                data[0].step_todo +
                ');"><span>' +
                nextText +
                "</span></a>";
              nextButton = true;
            }

            if ($("#step_" + data[0].step_todo).css("display") == "block") {
              popupContent = popupContent.replace(
                '<a class="next-3 nextBtn btn btn-default button button-medium" onclick="simulateLinkFromPopup(' +
                  data[0].step_todo +
                  ');"><span>' +
                  nextText +
                  "</span></a>",
                ""
              );

              if (data[i].disable_it == 0) {
                popupContent = popupContent.replace(
                  '<a class="ctn-2 continue btn btn-default button exclusive-medium  btn-2" onclick="simulateLinkFromPopup(' +
                    data[0].id_step +
                    ');"><span>' +
                    continueText +
                    "</span></a>",
                  '<a class="ctn-3 continue btn btn-default button exclusive-medium  btn-3" onclick="simulateLinkFromPopup(' +
                    data[0].step_todo +
                    ');"><span>' +
                    continueText +
                    "</span></a>"
                );
              }
              popupContent = popupContent.replace(WhatYouWant, WhatYouCan);
            }
          }
          //
        } else {
          $("#step_" + data[i].id_step).removeClass("denyOrder");
          $("#stepNav_" + data[i].id)
            .attr("disabled", "disabled")
            .removeClass("activeStep")
            .addClass("disabled");

          $("#stepNav_" + data[i].id_step)
            .removeClass("step_done")
            .attr("disabled", false)
            .removeClass("fullStep");
          if (data[i].id_step == data[i].prev_step && !firstTime) {
            $("#stepNav_" + data[i].id_step)
              .trigger("click")
              .removeClass("fullStep");
          }

          $("#stepNav_999")
            .attr("disabled", "disabled")
            .addClass("disabled")
            .find("span")
            .removeClass("lighted");
          $("#layer_cart .button-container, .cart-buttons").hide();
          if (!continueButton) {
            if (!titleshow) {
              popupContent += "<h3>" + WhatYouCan + "</h3>";
              titleshow = true;
            }

            if (
              data[i].disable_it == 0 &&
              !ctnshow &&
              data[0].disable_it == 0
            ) {
              if (counterLeft > 0) popupContent += $(clonedCounter).html();

              popupContent +=
                '<a class="ctn-4 continue btn btn-default button exclusive-medium  btn-4" onclick="simulateLinkFromPopup(' +
                data[i].prev_step +
                ');"><span>' +
                continueText +
                "</span></a>";

              continueButton = true;
              ctnshow = true;
            }
          }
          if(data[i].disable_it == 0){
            $("#stepNav_" + data[i].id_step).removeClass("disabled");
          }
        }
      }
      if (data[0].step_todo == 0) {
        $("#stepNav_999")
          .attr("disabled", false)
          .removeClass("disabled")
          .find("span")
          .addClass("lighted");
        $("#layer_cart .button-container, .cart-buttons").show();
        $(".stepnavButton").removeClass("disabled");
      } else {
        //$('li#stepNav_'+data[0].step_todo).trigger('click');
        $("#stepNav_999").attr("disabled", "disabled").addClass("disabled");
        $("#layer_cart .button-container, .cart-buttons").hide();
      }
      /*if(parseFloat($('.counter:visible .counterLeft').html()) > 0)
                    popupContent += $('.counter:visible').html();*/

      if (!!$.prototype.fancybox && !firstTime && showPopup) {
        $.fancybox.open(
          [
            {
              type: "inline",
              autoScale: true,
              minHeight: 30,
              showCloseButton: false,
              autoDimensions: false,
              content: '<div class="popupContainer">' + popupContent + "</div>",
            },
          ],
          {
            padding: 0,
          }
        );
      }
    },
    error: function () {
      //alert('error handing here');
    },
  });
}

function createPack(firstTime, link) {
  popupContent = "";
  continueButton = false;
  nextButton = false;
  $("body").append(ndkLoader).addClass("small_loader_container");
  $.ajax({
    type: "GET",
    url: ndksp_ajax_url,
    data: {
      action: "checkCart",
      ndk_id_pack: idPack,
      stepsLite: stepsLite,
      create_pack: 1,
    },
    dataType: "json",
    cache: true,
    success: function (data) {
      //$('#removeAllFromPack').trigger('click');
      setTimeout(function () {
        $("#ndkloader").fadeOut().remove();
        window.location.href = link;
      }, 500);
    },
    error: function () {
      //alert('error handing here');
    },
  });
}

function removeProductFromCart(
  productId,
  productAttributeId,
  qtty,
  customizationId,
  idAddressDelivery
) {
  $.ajax({
    type: "GET",
    url: ndksp_ajax_url,
    data: {
      action: "checkCart",
      productId: productId,
      productAttributeId: productAttributeId,
      qtty: qtty,
      customizationId: customizationId,
      idAddressDelivery: idAddressDelivery,
      remove_product: 1,
    },
    dataType: "json",
    cache: true,
    success: function (data) {
      //$('#removeAllFromPack').trigger('click');
      setTimeout(function () {
        checkCart(false);
      }, 1000);
    },
    error: function () {
      //alert('error handing here');
    },
  });
}

if (page_name == "module-ndksteppingpack-default") {
  $(document).on(
    "click",
    ".ajax_add_to_cart_button, #layer_cart, .cross, .exclusive, .add-to-cart, .ajax-add-to-cart",
    function (e) {
      e.preventDefault();
      setTimeout(function () {
        checkCart(false);
      }, 1000);
    }
  );

  $(document).on("click", ".ndksp-add-to-cart00", function (event) {
    event.preventDefault();
    var $form = $(event.target).closest("form");
    var query = $form.serialize() + "&update=1&action=update";
    var actionURL = $form.attr("action");
    $.post(actionURL, query, null, "json")
      .then(function (resp) {
        prestashop.emit("updateCart", {
          reason: {
            idProduct: resp.id_product,
            idProductAttribute: resp.id_product_attribute,
            idCustomization: resp.id_customization,
            linkAction: "add-to-cart",
            cart: resp.cart,
          },
          resp: resp,
        });
        //$(".ndksp-add-to-cart").removeAttr("disabled");
      })
      .fail(function (resp) {
        prestashop.emit("handleError", {
          eventType: "addProductToCart",
          resp: resp,
        });
      });
  });

  prestashop.on("updateCart", function (e) {
    checkCart(false);
  });

  $(document).on("click", ".ajax_cart_block_remove_link", function (e) {
    /*setTimeout(function(){
      checkCart(true);
    }, 500)*/
  });

  $(document).on(
    "click",
    '.view_button, .lnk_view, .product-name, .product_img_link, .product-miniature a:not(".quick-view"), .product-miniature a:not(".js-quick-view-iqit"), .product-thumbnail',
    function (event) {
      event.preventDefault();
      targets = ["quick-view", "js-quick-view-iqit"];
      for (i = 0; i < targets.length; i++) {
        if ($(event.target).hasClass(targets[i])) return false;
      }

      if (ps_version > 1.6) {
        $(this)
          .parent()
          .find('[data-link-action="quickview"]')
          .trigger("click");
        //$(this).parent().find(".js-quick-view-iqit:eq(0)").trigger("click");
        return true;
      } else {
        ndkQuickView($(this));
      }
      //$(this).parent().parent().parent().find('.quick-view').trigger('click');
    }
  );

  $(document).on("click", "#removeAllFromPack", function (event) {
    $(".ajax-del-resume").trigger("click");
    /*setTimeout(function(){
      checkCart(true);
    }, 500)*/
  });

  $(document).on("click", ".ajax-del-resume", function (e) {
    e.preventDefault();
    // Customized product management
    var customizationId = parseInt($(this).attr("data-id_customization"));
    var productId = parseInt($(this).attr("data-id_product"));
    var qtty = parseInt($(this).attr("data-qtty"));
    var productAttributeId = parseInt(
      $(this).attr("data-id_product_attribute")
    );
    var idAddressDelivery = false;
    // Removing product from the cart
    /*if(ps_version > 1.6)
      removeProductFromCart(productId, productAttributeId, qtty, customizationId,idAddressDelivery);
      else
      ajaxCart.remove(productId, productAttributeId, customizationId, idAddressDelivery);*/
    removeProductFromCart(
      productId,
      productAttributeId,
      qtty,
      customizationId,
      idAddressDelivery
    );

    setTimeout(function () {
      checkCart(true);
    }, 500);
  });

  $(document).on(
    "click",
    "#stepNav_999, .createPack",
    function (e) {
      e.preventDefault();
      if($(this).hasClass("disabled")) return false;
      $("#stepNav_999, .createPack").attr("disabled", "disabled");
      $("ul.stepnav").slideUp();
      $(".fancybox-close").trigger("click");

      //$('.popupContainer, .stepBlock').html('<div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div>');
      createPack(true, $(this).attr("href"));
    }
  );
}

function showFullMsg() {
  console.log("full");
  /*if (!!$.prototype.fancybox)
        {
            $.fancybox.open([
            {
                type: 'inline',
                autoScale: true,
                minHeight: 30,
                showCloseButton: false,
                autoDimensions: false,
                content: '<div class="popupContainer">'+fullText+'</div>'
            }],
          {
                padding: 0
            });
        }*/
}

function removeFromCart(el, event) {
  event.preventDefault();
  idBlock = el.parent().parent().attr("data-id");
  console.log(idBlock);
  $(
    ".shopping_cart [data-id=" + idBlock + "] .ajax_cart_block_remove_link"
  ).trigger("click");

  //return false;
}

function ndkQuickView(el) {
  //var url = el.attr('href');
  url = el.attr("quick-target");
  var anchor = "";

  if (url.indexOf("#") != -1) {
    anchor = url.substring(url.indexOf("#"), url.length);
    url = url.substring(0, url.indexOf("#"));
  }

  if (url.indexOf("?") != -1) url += "&";
  else url += "?";

  if (!!$.prototype.fancybox)
    $.fancybox({
      padding: 0,
      width: "90%",
      height: 610,
      type: "iframe",
      href: url + "content_only=1" + anchor,
      afterLoad: function () {
        fancyBoxChange(el);
      },
      beforeClose: function () {
        setTimeout(function () {
          checkCart(false);
        }, 500);
      },
    });
}

function fancyBoxChange(el) {
  fancyContent = $("body", $(".fancybox-iframe").contents());

  if (el.attr("hide-price") == 1) {
    fancyContent.find(".our_price_display, .content_prices").hide();
  }

  fancyContent.find("#add_to_cart button").on("click", function (e) {
    e.preventDefault();
    ajaxCart.add(
      fancyContent.find("#product_page_product_id").val(),
      fancyContent.find("#idCombination").val(),
      true,
      null,
      fancyContent.find("#quantity_wanted").val(),
      null
    );
    $(".fancybox-close").trigger("click");
    setTimeout(function () {
      checkCart(false);
    }, 500);
  });
}

$(document).on("click", ".product-title", function () {
  $(this).parent().parent().parent().find(".quick-view").trigger("click");
});

equalheight = function (container) {
  var currentTallest = 0,
    currentRowStart = 0,
    rowDivs = new Array(),
    $el,
    topPosition = 0;
  $(container).each(function () {
    $el = $(this);
    //$el.height('auto');
    topPostion = $el.position().top;
    rowDivs.push($el);
    currentTallest =
      currentTallest < $el.height() ? $el.height() : currentTallest;
    for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
      rowDivs[currentDiv].height(currentTallest);
    }
  });
};

function HoverWatcher(selector) {
  this.hovering = false;
  var self = this;

  this.isHoveringOver = function () {
    return self.hovering;
  };

  $(selector).hover(
    function () {
      self.hovering = true;
    },
    function () {
      self.hovering = false;
    }
  );
}
