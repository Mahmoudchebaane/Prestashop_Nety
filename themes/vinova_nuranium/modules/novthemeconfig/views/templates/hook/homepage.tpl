<div class="container-homepage">
    {$cmsonhome nofilter}
</div>

{block name='hook_before_body_closing_tag'}
    <script>
      if (window.map_lang == 'ar') {
        document.documentElement.className += ' js_active ';
        document.documentElement.className += 'ontouchstart' in document.documentElement ? ' vc_mobile ' :
          ' vc_desktop ';

        (function() {
          var prefix = ['-webkit-', '-o-', '-moz-', '-ms-', ""];
          for (var i in prefix) {
            if (prefix[i] + 'transform' in document.documentElement.style) document.documentElement.className +=
              " vc_transform ";
          }
        })();
        jQuery(window).load(function() {

        });
        var vc_js = function() {
          vc_twitterBehaviour();
          vc_toggleBehaviour();
          vc_tabsBehaviour();
          vc_accordionBehaviour();
          vc_teaserGrid();
          vc_carouselBehaviour();
          vc_slidersBehaviour();
          vc_prettyPhoto();
          vc_googleplus();
          vc_pinterest();
          vc_progress_bar();
          vc_plugin_flexslider();
          vc_google_fonts();
          //new behaviour for vc_row 30-1-2016
          vc_rowBehaviour();
          window.setTimeout(vc_waypoints, 1500);
        };
        jQuery(document).ready(function($) {
          window.vc_js();
          $('body').addClass('vc_frontoffice');
        });
        window.vcParallaxSkroll = false;
        if ('function' !== typeof(window['vc_rowBehaviour'])) {
          window.vc_rowBehaviour = function() {
            var $ = window.jQuery;

            var localFunction = function() {
              var $elements = $('[data-vc-full-width="true"]');
              $.each($elements, function(key, item) {
                var $el = $(this);
                var $el_full = $el.next('.vc_row-full-width');
                var el_margin_left = parseInt($el.css('margin-left'), 10);
                var el_margin_right = parseInt($el.css('margin-right'), 10);
                var offset = 0 - $el_full.offset().left - el_margin_left;
                var width = $(window).width();
                $el.css({
                  'position': 'relative',
                  'left': offset,
                  'box-sizing': 'border-box',
                  'width': $(window).width()
                });
                if (!$el.data('vcStretchContent')) {
                  var padding = (-1 * offset);
                  if (padding < 0) { padding = 0; }
                  var paddingRight = width - padding - $el_full.width() + el_margin_left +
                    el_margin_right;
                  if (paddingRight < 0) { paddingRight = 0; } $el.css({
                    'padding-left': padding + 'px',
                    'padding-right': paddingRight + 'px'
                  });
                }
                $el.attr("data-vc-full-width-init", "true");
              });
            };

            function fullWidthRow() {
              var $elements = $('[data-vc-full-width="true" ]');
              $.each($elements, function(key, item) {
                var
                  $el = $(this);
                $el.addClass("vc_hidden");
                var $el_full = $el.next(".vc_row-full-width");
                $el_full.length ||
                  ($el_full = $el.parent().next(".vc_row-full-width"));
                var el_margin_left = parseInt($el.css("margin-left"), 10),
                  el_margin_right = parseInt($el.css("margin-right"), 10),
                  offset = $el_full.offset().left - el_margin_left - 30,
                  width = $(window).width();
                console.log('left', $el_full.offset().left + el_margin_left)
                if ($el.css({
                    position: "relative",
                    left: $el_full.offset().left + el_margin_left,
                    //left: $el_full.offset().left,
                    "box-sizing": "border-box",
                    width: $(window).width()
                  }), !$el.data("vcStretchContent")) {
                  var padding = -1 * offset;
                  0 > padding && (padding = 0);
                  var paddingRight = 0;
                  0 > paddingRight && (paddingRight = 0), $el.css({
                    "padding-left": padding + "px",
                    "padding-right": paddingRight + "px"
                  });
                }
                $el.attr("data-vc-full-width-init", "true"), $el.removeClass("vc_hidden");
              });
            }


            function parallaxRow() {
              var vcSkrollrOptions, callSkrollInit = !1;
              return window.vcParallaxSkroll && window.vcParallaxSkroll.destroy(), $(".vc_parallax-inner")
                .remove(), $("[data-5p-top-bottom]").removeAttr("data-5p-top-bottom data-30p-top-bottom"),
                $(
                  "[data-vc-parallax]").each(function() {
                  var skrollrSpeed, skrollrSize, skrollrStart, skrollrEnd, $parallaxElement,
                    parallaxImage, youtubeId;
                  callSkrollInit = !0, "on" === $(this).data("vcParallaxOFade") && $(this).children()
                    .attr("data-5p-top-bottom", "opacity:0;").attr("data-30p-top-bottom",
                      "opacity:1;"),
                    skrollrSize = 100 * $(this).data("vcParallax"), $parallaxElement = $("<div />")
                    .addClass("vc_parallax-inner").appendTo($(this)), $parallaxElement.height(
                      skrollrSize + "%"), parallaxImage = $(this).data("vcParallaxImage"),
                    youtubeId =
                    vcExtractYoutubeId(parallaxImage), youtubeId ? insertYoutubeVideoAsBackground(
                      $parallaxElement, youtubeId) : "undefined" != typeof parallaxImage &&
                    $parallaxElement.css("background-image", "url(" + parallaxImage + ")"),
                    skrollrSpeed = skrollrSize - 100, skrollrStart = -skrollrSpeed, skrollrEnd = 0,
                    $parallaxElement.attr("data-bottom-top", "top: " + skrollrStart + "%;").attr(
                      "data-top-bottom", "top: " + skrollrEnd + "%;")
                }), callSkrollInit && window.skrollr ? (vcSkrollrOptions = {
                  forceHeight: !1,
                  smoothScrolling: !1,
                  mobileCheck: function() {
                    return !1
                  }
                }, window.vcParallaxSkroll = skrollr.init(vcSkrollrOptions), window.vcParallaxSkroll) : !1
            }

            function fullHeightRow() {
              $(".vc_row-o-full-height:first").each(function() {
                var $window, windowHeight, offsetTop, fullHeight;
                $window = $(window), windowHeight = $window.height(), offsetTop = $(this).offset()
                  .top,
                  windowHeight > offsetTop && (fullHeight = 100 - offsetTop / (windowHeight /
                    100), $(
                    this).css("min-height", fullHeight + "vh"))
              });
            }

            function fixIeFlexbox() {
              var ua = window.navigator.userAgent,
                msie = ua.indexOf("MSIE ");
              (msie > 0 || navigator.userAgent.match(/Trident.*rv\:11\./)) && $(".vc_row-o-full-height").each(
                function() {
                  "flex" === $(this).css("display") && $(this).wrap(
                    '<div class="vc_ie-flexbox-fixer"></div>')
                });
            }
            //    $( window ).unbind( 'resize.vcRowBehaviour' ).bind( 'resize.vcRowBehaviour', localFunction );

            $(window).off("resize.vcRowBehaviour").on("resize.vcRowBehaviour", fullWidthRow).on(
                "resize.vcRowBehaviour", fullHeightRow), fullWidthRow(), fullHeightRow(), fixIeFlexbox(),
              vc_initVideoBackgrounds(), parallaxRow();
            //    localFunction();
            //    parallaxRow();
          };
        }
      }
    </script>
  {/block}