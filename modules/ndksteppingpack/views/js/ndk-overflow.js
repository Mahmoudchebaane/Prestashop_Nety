/**
 *  Tous droits réservés NDKDESIGN
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2021 Hendrik Masson
 *  @license   Tous droits réservés
 */
var slideTimer;
var ndk_overflows = [];
$.fn.setOverflow = function (options) {
  var defaults = {
      //main
      direction: "x",
      initiated: false,
      groupClass: "",
      scroller: window,
      interval: 250,
      speed: 500,
      //items
      item: ".item",
      margin: 0,
      visibleItems: 4,
      visibleItemsTablet: false,
      visibleItemsMobile: false,
      magnet: true,
      //design
      useFontAwesome: false,
      animateScroll: false,
      //controls
      moveStep: false,
      pager: true,
      arrows: false,
      enableKeybord: false,
      //callbacks
      onLoad: function () {
        return true;
      },
      onSlide: function () {
        return true;
      },
      beforeSlide: function () {
        return true;
      },
      afterSlide: function () {
        return true;
      },
      //auto
      auto: false,
      pause: 8000,
      autoStart: true,
      autoDirection: "next",
      stopAutoOnClick: false,
      autoHover: true,
      autoDelay: 0,
      autoSlideForOnePage: false,
      autoSmooth: false,
      autoSmoothDuration: 6000,
      //debug
      debug: false,
    },
    el = this;
  el.overflow = {};
  var windowFocusHandler = function () {
      el.overflow.mainblock.startAuto();
    },
    windowBlurHandler = function () {
      el.overflow.mainblock.stopAuto();
    },
    myVisibleItems;
  el.overflow.mainblock = $(this);
  el.overflow.settings = $.extend({}, defaults, options);
  el.overflow.settings.items = el.overflow.mainblock.find(
    el.overflow.settings.item
  );
  el.overflow.settings.items.nb_item = el.overflow.settings.items.length;
  el.overflow.settings.item_width = 0;
  el.overflow.mainblock.currentIndex = 0;
  el.overflow.mainblock.oldIndex = -1;

  // if (typeof (window["overflow_pager"] != "undefined")) {
  //   el.overflow.settings.pager = true;
  //   //el.overflow.settings.arrows = false;
  // }

  el.overflow.mainblock.setItemWidth = function () {
    myVisibleItems = el.overflow.settings.visibleItems;
    if ($(window).width() < 991 || el.overflow.mainblock.innerWidth() < 991) {
      if (el.overflow.settings.visibleItemsTablet)
        myVisibleItems = el.overflow.settings.visibleItemsTablet;
      else {
        myVisibleItems = Math.floor(el.overflow.settings.visibleItems / 2);
      }
    }
    if ($(window).width() < 768 || el.overflow.mainblock.innerWidth() < 768) {
      if (el.overflow.settings.visibleItemsMobile)
        myVisibleItems = el.overflow.settings.visibleItemsMobile;
      else {
        myVisibleItems = Math.floor(el.overflow.settings.visibleItems / 2);
      }
    }
    if ($(window).width() < 480 || el.overflow.mainblock.innerWidth() < 480) {
      if (el.overflow.settings.visibleItemsMobile)
        myVisibleItems = el.overflow.settings.visibleItemsMobile;
      else {
        myVisibleItems = 1;
      }
    }
    if (!el.overflow.settings.moveStep) {
      el.overflow.settings.moveStep = myVisibleItems;
    }

    if (el.overflow.settings.moveStep > myVisibleItems) {
      el.overflow.settings.moveStep = myVisibleItems;
    }
    el.overflow.settings.newWidth = Math.ceil(
      el.overflow.mainblock.innerWidth() / myVisibleItems -
        el.overflow.settings.margin
    );
    el.overflow.settings.items.css("width", el.overflow.settings.newWidth);

    el.overflow.mainblock.attr("data-visible_items", myVisibleItems);
  };

  el.overflow.mainblock.getItemWidth = function () {
    var myWidth = parseInt(el.overflow.mainblock.attr("overflow-item_width"));
    return myWidth;
  };

  el.overflow.mainblock.prepareContainer = function () {
    el.overflow.mainblock
      .addClass("overflowed")
      .addClass(el.overflow.settings.groupClass)
      .removeClass("row");
    el.overflow.mainblock
      .css("overflow-" + el.overflow.settings.direction, "scroll")
      .addClass("ndk-overflow-" + el.overflow.settings.direction);
    el.overflow.mainblock.css("max-width", "100%");
    if (!el.overflow.mainblock.hasClass("wrapped-ndk"))
      el.overflow.mainblock
        .wrap(
          `<div class="overflow-container-main clear clearfix ${
            el.overflow.settings.arrows ? "has-arrows " : ""
          }${el.overflow.settings.pager ? "has-pager " : ""}"/>`
        )
        .addClass("wrapped-ndk");
  };

  el.overflow.mainblock.setOverflowX = function () {
    el.overflow.settings.items.addClass("overflow-item");
    //items.css("margin-right", el.overflow.settings.margin);
    if (el.overflow.mainblock.find(".overflow-container").length < 1) {
      el.overflow.settings.items.wrapAll(
        '<div class="overflow-container ' +
          ($(el.overflow.settings.scroller).width() > 768 ? "flex" : "flex") +
          '"/>'
      );
    }
    el.overflow.settings.item_width =
      el.overflow.settings.newWidth * el.overflow.settings.items.nb_item +
      el.overflow.settings.margin * el.overflow.settings.items.nb_item +
      el.overflow.settings.margin *
        (el.overflow.settings.items.nb_item / myVisibleItems);

    el.overflow.mainblock
      .find(".overflow-container")
      .css("width", Math.floor(el.overflow.settings.item_width));
  };
  el.overflow.mainblock.setOverflowY = function () {
    el.overflow.settings.items
      .css("margin-top", margin)
      .addClass("overflow-item");
    el.overflow.settings.items.css("margin-bottom", margin);
    item_height = 0;
    el.overflow.settings.items.each(function () {
      item_height += $(this).outerHeight();
      item_height += margin * 2;
    });
    el.overflow.mainblock.css("height", item_height);
    if (
      item_height > el.overflow.mainblock.outerHeight() &&
      el.overflow.mainblock.outerHeight() > 0
    ) {
      el.overflow.mainblock.addClass("overflow_chevron_y");
    }
  };

  el.overflow.mainblock.setControllableX = function () {
    //console.log(el.overflow.settings.item_width, el.overflow.mainblock.outerWidth())
    if (
      el.overflow.settings.item_width > el.overflow.mainblock.outerWidth() &&
      el.overflow.mainblock.outerWidth() > 0
    ) {
      el.overflow.mainblock.addClass("overflow_chevron_x");
      el.overflow.mainblock.animateOnScroll();
      if (!el.overflow.settings.initiated || 1 > 0) {
        if (el.overflow.settings.arrows) {
          el.overflow.mainblock.parent().find(".ndk-overflow-control").remove();
          if (el.overflow.settings.useFontAwesome)
            el.overflow.mainblock.after(
              '<div class="ndk-overflow-control"><span class="ndk-scroll-left"><i class="fa fa-chevron-left"></i></span><span class="ndk-scroll-right"><i class="fa fa-chevron-right"></i></span></div>'
            );
          else
            el.overflow.mainblock.after(
              '<div class="ndk-overflow-control"><span class="ndk-scroll-left"><i class="material-icons">chevron_left</i></span><span class="ndk-scroll-right"><i class="material-icons">chevron_right</i></span></div>'
            );
        }

        myItemsNumber = el.overflow.settings.items.nb_item;

        ratio = myVisibleItems / el.overflow.settings.moveStep;
        // console.log(
        //   myItemsNumber,
        //   myVisibleItems,
        //   el.overflow.settings.moveStep,
        //   ratio
        // );
        el.overflow.settings.nb_pager = Math.ceil(
          ((myItemsNumber < 2 ? 2 : myItemsNumber) / myVisibleItems) * ratio
        );
        window_balance =
          el.overflow.settings.moveStep > 1 &&
          myVisibleItems > el.overflow.settings.moveStep
            ? el.overflow.settings.moveStep
            : 0;
        steps =
          (myItemsNumber - window_balance) / el.overflow.settings.moveStep;
        el.overflow.settings.nb_pager = Math.ceil(steps);
        if (el.overflow.settings.debug) {
          console.log(el.overflow.settings);
          console.log(myItemsNumber, el.overflow.settings.moveStep, steps);
        }

        el.overflow.mainblock.parent().find(".ndk-overflow-pager").remove();
        el.overflow.mainblock.after(
          '<div class="ndk-overflow-pager"' +
            (!el.overflow.settings.pager ? 'style="display:none"' : "") +
            "></div>"
        );
        for (i = 0; i < el.overflow.settings.nb_pager; i++) {
          el.overflow.mainblock
            .parent()
            .find(".ndk-overflow-pager")
            .append(
              `<span class="ndk-scroll-pager ${
                i == 0 ? "active" : ""
              }" data-pager="${i}"></span>`
            );
        }
      }

      firstItem = el.overflow.mainblock.find(".overflow-item:visible:eq(0)")[0];

      (itemStyle =
        firstItem.currentStyle || window.getComputedStyle(firstItem)),
        (item_width = firstItem.offsetWidth), // or use style.width
        (item_margin =
          parseFloat(itemStyle.marginLeft) + parseFloat(itemStyle.marginRight)),
        (item_padding =
          parseFloat(itemStyle.paddingLeft) +
          parseFloat(itemStyle.paddingRight)),
        (item_border =
          parseFloat(itemStyle.borderLeftWidth) +
          parseFloat(itemStyle.borderRightWidth));

      el.overflow.mainblock.itemWidth =
        item_width +
        item_margin -
        item_padding +
        item_border +
        el.overflow.settings.margin * 1.33;
      el.overflow.mainblock.attr(
        "overflow-item_width",
        el.overflow.mainblock.itemWidth
      );
      if (el.overflow.settings.moveStep > myVisibleItems) {
        el.overflow.settings.moveStep = myVisibleItems;
      }
      el.overflow.mainblock
        .parent()
        .find(".ndk-scroll-right")
        .on("click", function () {
          el.overflow.mainblock.goToNextSlide();
        });
      el.overflow.mainblock
        .parent()
        .find(".ndk-scroll-left")
        .on("click", function () {
          el.overflow.mainblock.goToPrevSlide();
        });
      el.overflow.mainblock
        .parent()
        .find(".ndk-scroll-pager")
        .on("click", function () {
          if (!$(this).hasClass("active")) {
            page_number = $(this).data("pager");
            el.overflow.mainblock.goToSlide(page_number);
          }
        });
      let currentScroll;
      el.overflow.mainblock[0].addEventListener("scroll", (e) => {
        scrollPos = el.overflow.mainblock[0].scrollLeft;

        pager_width = Math.ceil(
          el.overflow.mainblock.itemWidth * el.overflow.settings.moveStep
        );
        if (currentScroll - scrollPos > 0) {
          direction = "left";
          page_number = Math.floor(scrollPos / pager_width);
        } else {
          direction = "rigth";
          page_number = Math.ceil(scrollPos / pager_width);
        }
        currentScroll = scrollPos;
        if (page_number < 0) page_number = 0;
        if (el.overflow.settings.magnet) {
          //console.log(direction);
          return el.overflow.mainblock.goToSlide(page_number);
        } else {
          el.overflow.mainblock.pagerState(page_number);
        }
      });
    }
    el.overflow.mainblock.mouseDragInit();
  };
  el.overflow.mainblock.enableKeybord = function () {
    window.addEventListener("keydown", (e) => {
      if (e.keyCode == 37) {
        // left
        el.overflow.mainblock.goToPrevSlide();
      } else if (e.keyCode == 39) {
        // right
        el.overflow.mainblock.goToNextSlide();
      }
    });
  };

  el.overflow.mainblock.pagerState = function (page_number) {
    el.overflow.mainblock
      .parent()
      .find(".ndk-scroll-pager")
      .removeClass("active");
    el.overflow.mainblock
      .parent()
      .find(".ndk-scroll-pager[data-pager=" + page_number + "]")
      .addClass("active");
  };

  el.overflow.mainblock.mouseDragInit = function () {
    //drag mouse
    let isDown = false;
    let startX;
    let scrollLeft;
    if (typeof el.overflow.mainblock[0] == "undefined") return;
    el.overflow.mainblock[0].addEventListener("mousedown", (e) => {
      isDown = true;
      el.overflow.mainblock[0].classList.add("active-drag");
      startX = e.pageX - el.overflow.mainblock[0].offsetLeft;
      scrollLeft = el.overflow.mainblock[0].scrollLeft;
    });
    el.overflow.mainblock[0].addEventListener("mouseleave", () => {
      isDown = false;
      el.overflow.mainblock[0].classList.remove("active-drag");
    });
    el.overflow.mainblock[0].addEventListener("mouseup", () => {
      isDown = false;
      el.overflow.mainblock[0].classList.remove("active-drag");
    });
    el.overflow.mainblock[0].addEventListener("mousemove", (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - el.overflow.mainblock[0].offsetLeft;
      const walk = (x - startX) * 3; //scroll-fast
      el.overflow.mainblock[0].scrollLeft = scrollLeft - walk;
    });
  };
  el.overflow.mainblock.goToNextSlide = function () {
    //console.log(el.overflow.mainblock.currentIndex, el.overflow.settings.nb_pager);
    // currentPage = el.overflow.mainblock
    //   .parent()
    //   .find(".ndk-scroll-pager.active:eq(0)")
    //   .attr("data-pager");
    currentPage = el.overflow.mainblock.currentIndex;
    targetSlide = (parseInt(currentPage) + 1) * 1;
    //console.log(currentPage, targetSlide);
    el.overflow.mainblock.goToSlide(
      targetSlide >= el.overflow.settings.nb_pager ? 0 : targetSlide
    );
  };
  el.overflow.mainblock.goToPrevSlide = function () {
    scrollPos = el.overflow.mainblock[0].scrollLeft;
    //console.log(el.overflow.mainblock.currentIndex, el.overflow.settings.nb_pager);
    // currentPage = el.overflow.mainblock
    //   .parent()
    //   .find(".ndk-scroll-pager.active:eq(0)")
    //   .attr("data-pager");
    currentPage = el.overflow.mainblock.currentIndex;
    targetSlide = parseInt(currentPage) - 1;
    el.overflow.mainblock.goToSlide(targetSlide > 0 ? 0 : targetSlide);
  };
  el.overflow.mainblock.goToSlide = function (
    page_number,
    speed = el.overflow.settings.speed
  ) {
    if (page_number != el.overflow.mainblock.currentIndex) {
      el.overflow.mainblock.beforeSlideCall();
    }
    el.overflow.mainblock.oldIndex = el.overflow.mainblock.currentIndex;
    el.overflow.mainblock.currentIndex = page_number;
    if (typeof el.overflow.mainblock[0] == "undefined") return;
    scrollPos = el.overflow.mainblock[0].scrollLeft;
    el.overflow.mainblock.itemWidth = el.overflow.mainblock.getItemWidth();
    clearTimeout(slideTimer);

    slideTimer = setTimeout(function () {
      el.overflow.mainblock.animate(
        {
          scrollLeft:
            page_number *
            el.overflow.mainblock.itemWidth *
            el.overflow.settings.moveStep,
        },
        {
          duration: el.overflow.settings.speed,
          iterations: 1,
        }
      );
      // el.overflow.mainblock[0].scroll({
      //   left:
      //     page_number *
      //     el.overflow.mainblock.itemWidth *
      //     el.overflow.settings.moveStep,
      //   top: 0,
      //   behavior: "smooth",
      // });
      el.overflow.mainblock.pagerState(page_number);
      el.overflow.mainblock.afterSlideCall();
    }, el.overflow.settings.interval);
  };

  el.overflow.mainblock.setControllableY = function () {};

  el.overflow.mainblock.beforeSlideCall = function () {
    //el.overflow.mainblock.checkStatus();
    el.overflow.settings.beforeSlide.call(
      el.overflow.mainblock,
      el.overflow.mainblock.currentIndex
    );
  };
  el.overflow.mainblock.afterSlideCall = function () {
    el.overflow.mainblock.checkStatus();
    el.overflow.settings.afterSlide.call(
      el.overflow.mainblock,
      el.overflow.mainblock.currentIndex
    );
  };
  el.overflow.mainblock.informItems = function () {
    i = 0;
    el.overflow.settings.items.each(function () {
      $(this).attr("overflow_index", i);
      i++;
    });
    el.overflow.mainblock.checkStatus();
  };
  el.overflow.mainblock.initAuto = function () {
    if (el.overflow.settings.autoDelay > 0) {
      setTimeout(
        el.overflow.mainblock.startAuto,
        el.overflow.settings.autoDelay
      );
    } else {
      el.overflow.mainblock.startAuto();
      //$(window).focus(windowFocusHandler).blur(windowBlurHandler);
    }
    if (el.overflow.settings.autoHover) {
      el.overflow.mainblock.hover(
        function () {
          if (el.overflow.interval) {
            el.overflow.mainblock.stopAuto(true);
            el.overflow.autoPaused = true;
          }
        },
        function () {
          if (el.overflow.autoPaused) {
            el.overflow.mainblock.startAuto(true);
            el.overflow.autoPaused = null;
          }
        }
      );
    }
  };
  el.overflow.mainblock.startAuto = function (preventControlUpdate) {
    if (el.overflow.interval) {
      return;
    }

    if (el.overflow.settings.autoSmooth) {
      el.overflow.settings.speed = el.overflow.settings.autoSmoothDuration;
      el.overflow.mainblock.fullLeft = el.overflow.mainblock.width();
      el.overflow.interval = setInterval(function () {
        if (el.overflow.mainblock.currentIndex > 0) {
          targetSlide = 0;
        } else {
          targetSlide = el.overflow.settings.nb_pager;
        }
        el.overflow.mainblock.goToSlide(
          targetSlide,
          el.overflow.settings.autoSmoothDuration
        );
        //overflow.mainblock.animate({scrollLeft:overflow.mainblock.fullLeft}, {duration: overflow.settings.autoSmoothDuration, iterations:1});
        //overflow.mainblock.animate({scrollLeft:0}, {duration: overflow.settings.autoSmoothDuration, iterations:1});
        //console.log(overflow.mainblock.currentIndex)
      }, el.overflow.settings.pause);
    } else {
      el.overflow.interval = setInterval(function () {
        if (el.overflow.settings.autoDirection === "next") {
          el.overflow.mainblock.goToNextSlide();
        } else {
          el.overflow.mainblock.goToPrevSlide();
        }
      }, el.overflow.settings.pause);
    }
    if (el.overflow.settings.autoControls && preventControlUpdate !== true) {
      updateAutoControls("stop");
    }
  };
  el.overflow.mainblock.stopAuto = function (preventControlUpdate) {
    if (el.overflow.autoPaused) el.overflow.autoPaused = false;
    if (!el.overflow.interval) {
      return;
    }
    clearInterval(el.overflow.interval);
    el.overflow.interval = null;
    //el.overflow.settings.onAutoChange.call(el.overflow.mainblock, false);
    if (el.overflow.settings.autoControls && preventControlUpdate !== true) {
      updateAutoControls("start");
    }
  };
  el.overflow.mainblock.checkStatus = function () {
    el.overflow.settings.items.attr("overflow_visible", 0);
    el.overflow.settings.items.each(function () {
      if (el.overflow.mainblock.isInViewport(this)) {
        $(this).attr("overflow_visible", 1);
      }
    });
  };
  el.overflow.mainblock.isInViewport = function (el) {
    let rect = el.getBoundingClientRect();
    // get the height of the window
    let viewPortBottom =
      window.innerHeight || document.documentElement.clientHeight;
    // get the width of the window
    let viewPortRight =
      window.innerWidth || document.documentElement.clientWidth;

    let isTopInViewPort = rect.top >= 0,
      isLeftInViewPort = rect.left >= -40,
      isBottomInViewPort = rect.bottom <= viewPortBottom,
      isRightInViewPort = rect.right <= viewPortRight;

    // check if element is completely visible inside the viewport
    return isRightInViewPort && isLeftInViewPort;
  };
  el.overflow.mainblock.initOverFlow = function () {
    if (typeof el.overflow.mainblock[0] == "undefined") return;
    el.overflow.mainblock.prepareContainer();
    el.overflow.mainblock.informItems();

    if (el.overflow.settings.visibleItems) {
      el.overflow.mainblock.setItemWidth();
    }
    if (el.overflow.settings.direction == "x") {
      el.overflow.mainblock.setOverflowX();
      el.overflow.mainblock.setControllableX();
    }
    if (el.overflow.settings.direction == "y") {
      el.overflow.mainblock.setOverflowY();
      el.overflow.mainblock.setControllableY();
    }
    el.overflow.settings.initiated = true;

    el.overflow.settings.onLoad.call(el.overflow.mainblock);
    el.overflow.mainblock.currentIndex = 0;
    el.overflow.mainblock.oldIndex = -1;
    el.overflow.mainblock.beforeSlideCall();
    el.overflow.mainblock.goToSlide(0);
    if (el.overflow.settings.auto && el.overflow.settings.autoStart) {
      el.overflow.mainblock.initAuto();
    }
    if (el.overflow.settings.enableKeyboard) {
      el.overflow.mainblock.enableKeybord();
    }
    el.overflow.mainblock.afterSlideCall();
  };
  el.overflow.mainblock.animateOnScroll = function () {
    if (!el.overflow.settings.animateScroll) {
      return false;
    }
    $(el.overflow.settings.scroller).on("scroll", function () {
      if (
        $(el.overflow.settings.scroller).scrollTop() >=
          el.overflow.mainblock.offset().top -
            el.overflow.mainblock.outerHeight() &&
        !el.overflow.mainblock.hasClass("animatedOnscroll")
      ) {
        el.overflow.mainblock.addClass("animateOnscroll");
        el.overflow.mainblock
          .animate(
            {
              scrollLeft: 200,
            },
            500
          )
          .animate(
            {
              scrollLeft: 0,
            },
            200
          )
          .removeClass("animateOnscroll")
          .addClass("animatedOnscroll");
      } else {
        //el.overflow.mainblock.removeClass("animatedOnscroll");
      }
    });
  };
  el.overflow.mainblock.initOverFlow();
  $(el.overflow.settings.scroller).on("resize", function () {
    el.overflow.settings.item_width = 0;
    el.overflow.mainblock.initOverFlow();
  });
};

function setOverflowCustomBlock(me, options) {
  defaults = {
    containerSelector: ".ndk-slide-item",
    visibleItems: 4,
    visibleItemsTablet: 2,
    visibleItemsMobile: 2,
    pager: true,
    arrows: false,
  };
  var custom_settings = $.extend({}, defaults, options);
  if (me.find(custom_settings.containerSelector).length > 0) {
    wrapping = me
      .find(custom_settings.containerSelector)
      .wrapAll(
        '<div class="ndk-carousel-custom clear clearfix ndk-custom-group-block ">'
      );
    $.when(wrapping).done(function () {
      me.find(".ndk-carousel-custom").setOverflow({
        direction: "x",
        item: custom_settings.containerSelector,
        visibleItems: custom_settings.visibleItems,
        moveStep: custom_settings.visibleItems,
        visibleItemsTablet: custom_settings.visibleItemsTablet,
        visibleItemsMobile: custom_settings.visibleItemsMobile,
        margin: 0,
        //debug: true,
      });
    });
  }
}
