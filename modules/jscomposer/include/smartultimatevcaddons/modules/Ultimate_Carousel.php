<?php
/*
  Module Name: Ultimate Carousel for Visual Composer
  Module URI: https://www.brainstormforce.com/demos/ultimate-carousel
 */
if (!class_exists("Ultimate_Carousel")) {

    class Ultimate_Carousel {

        public $vcaddonsinstance, $context;
        public static $restore_shortcodes;

        function __construct() {
            $this->context = Context::getContext();
            $this->vcaddonsinstance = jscomposer::getInstance();
            if ($this->vcaddonsinstance->is_admin()) {
                $this->custom_param_styles();
                $this->ultimate_admin_scripts();
            }

            JsComposer::add_shortcode("ultimate_carousel", array(&$this, "ultimate_carousel_shortcode"));
            JsComposer::add_shortcode_param('slick_icon', array(&$this, 'icon_settings_field'));
            JsComposer::add_shortcode_param('ult_switch', array(&$this, 'checkbox_param'));
        }

        function custom_param_styles() {
            jscomposer::$backoffice_inline_styles[] = '<style type="text/css">
					.items_to_show.vc_shortcode-param {
						background: #E6E6E6;
						padding-bottom: 10px;
					}
					.items_to_show.ult_margin_bottom{
						margin-bottom: 15px;
					}
					.items_to_show.ult_margin_top{
						margin-top: 15px;
					}
				</style>';
        }

        function ultimate_front_scripts() {
            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/slick/slick.css");
            $this->context->controller->addCSS($this->vcaddonsinstance->_url_ultimate . 'assets/slick/icons.css');
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/slick.min.js");
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/slick.custom.min.js");
        }

        function ultimate_admin_scripts() {
//            jscomposer::$backoffice_styles[] = "{$this->vcaddonsinstance->_url_ultimate}assets/slick/icons.css";
            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/slick/icons.css");
        }

        
        /* limited to shortcode */

        function init_carousel_addon() {
            $vc = vc_manager();
            if (function_exists("vc_map")) {
                vc_map(
                        array(
                            "name" => $vc->l("Advanced Carousel"),
                            "base" => "ultimate_carousel",
                            "icon" => "ultimate_carousel",
                            "class" => "ultimate_carousel",
                            "as_parent" => array('except' => 'ultimate_carousel'),
                            "content_element" => true,
                            "controls" => "full",
                            "show_settings_on_create" => true,
                            "category" => "Ultimate VC Addons",
                            "description" => "Apply animations everywhere.",
                            "params" => array(
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Slider Type"),
                                    "param_name" => "slider_type",
                                    "value" => array(
                                        "Horizontal" => "horizontal",
                                        "Vertical" => "vertical",
                                        "Horizontal Full Width" => "full_width"
                                    ),
                                    "description" => $vc->l(""),
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Slides to Scroll"),
                                    "param_name" => "slide_to_scroll",
                                    "value" => array("All visible" => "all", "One at a Time" => "single"),
                                    "description" => $vc->l(""),
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "text",
                                    "param_name" => "title_text_typography",
                                    "heading" => $vc->l("<p>Items to Showâ€? - </p>"),
                                    "value" => "",
                                    "edit_field_class" => "vc_col-sm-12 items_to_show ult_margin_top",
                                    "group" => "General"
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "edit_field_class" => "vc_col-sm-4 items_to_show ult_margin_bottom",
                                    "heading" => $vc->l("On Desktop"),
                                    "param_name" => "slides_on_desk",
                                    "value" => "5",
                                    "min" => "1",
                                    "max" => "25",
                                    "step" => "1",
                                    "description" => $vc->l(""),
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "edit_field_class" => "vc_col-sm-4 items_to_show ult_margin_bottom",
                                    "heading" => $vc->l("On Tabs"),
                                    "param_name" => "slides_on_tabs",
                                    "value" => "3",
                                    "min" => "1",
                                    "max" => "25",
                                    "step" => "1",
                                    "description" => $vc->l(""),
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "edit_field_class" => "vc_col-sm-4 items_to_show ult_margin_bottom",
                                    "heading" => $vc->l("On Mobile"),
                                    "param_name" => "slides_on_mob",
                                    "value" => "2",
                                    "min" => "1",
                                    "max" => "25",
                                    "step" => "1",
                                    "description" => $vc->l(""),
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "class" => "",
                                    "heading" => $vc->l("Infinite loop"),
                                    "param_name" => "infinite_loop",
                                    "value" => "on",
                                    "options" => array(
                                        "on" => array(
                                            "label" => "Restart the slider automatically as it passes the last slide.",
                                            "on" => "Yes",
                                            "off" => "No",
                                        ),
                                    ),
                                    "description" => $vc->l(""),
                                    "dependency" => "",
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Transition speed"),
                                    "param_name" => "speed",
                                    "value" => "300",
                                    "min" => "100",
                                    "max" => "10000",
                                    "step" => "100",
                                    "suffix" => "ms",
                                    "description" => $vc->l("Speed at which next slide comes."),
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "class" => "",
                                    "heading" => $vc->l("Autoplay Slidesâ€?"),
                                    "param_name" => "autoplay",
                                    "value" => "on",
                                    "options" => array(
                                        "on" => array(
                                            "label" => "Enable Autoplay",
                                            "on" => "Yes",
                                            "off" => "No",
                                        ),
                                    ),
                                    "description" => $vc->l(""),
                                    "dependency" => "",
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Autoplay Speed"),
                                    "param_name" => "autoplay_speed",
                                    "value" => "5000",
                                    "min" => "100",
                                    "max" => "10000",
                                    "step" => "10",
                                    "suffix" => "ms",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "autoplay", "value" => array("on")),
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                    "description" => $vc->l(""),
                                    "group" => "General",
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "class" => "",
                                    "heading" => $vc->l("Navigation Arrows"),
                                    "param_name" => "arrows",
                                    "value" => "show",
                                    "options" => array(
                                        "show" => array(
                                            "label" => "Display next / previous navigation arrows",
                                            "on" => "Yes",
                                            "off" => "No",
                                        ),
                                    ),
                                    "description" => $vc->l(""),
                                    "dependency" => "",
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Arrow Style"),
                                    "param_name" => "arrow_style",
                                    "value" => array(
                                        "Default" => "default",
                                        "Circle Background" => "circle-bg",
                                        "Square Background" => "square-bg",
                                        "Circle Border" => "circle-border",
                                        "Square Border" => "square-border",
                                    ),
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "arrows", "value" => array("show")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Background Color"),
                                    "param_name" => "arrow_bg_color",
                                    "value" => "",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "arrow_style", "value" => array("circle-bg", "square-bg")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Border Color"),
                                    "param_name" => "arrow_border_color",
                                    "value" => "",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "arrow_style", "value" => array("circle-border", "square-border")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Size"),
                                    "param_name" => "border_size",
                                    "value" => "2",
                                    "min" => "1",
                                    "max" => "100",
                                    "step" => "1",
                                    "suffix" => "px",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "arrow_style", "value" => array("circle-border", "square-border")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Arrow Color"),
                                    "param_name" => "arrow_color",
                                    "value" => "#333333",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "arrows", "value" => array("show")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Arrow Size"),
                                    "param_name" => "arrow_size",
                                    "value" => "24",
                                    "min" => "10",
                                    "max" => "75",
                                    "step" => "1",
                                    "suffix" => "px",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "arrows", "value" => array("show")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "slick_icon",
                                    "class" => "",
                                    "heading" => $vc->l("Select icon for 'Next Arrow'"),
                                    "param_name" => "next_icon",
                                    "value" => "ultsl-arrow-right4",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "arrows", "value" => array("show")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "slick_icon",
                                    "class" => "",
                                    "heading" => $vc->l("Select icon for 'Previous Arrow'"),
                                    "param_name" => "prev_icon",
                                    "value" => "ultsl-arrow-left4",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "arrows", "value" => array("show")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "class" => "",
                                    "heading" => $vc->l("Dots Navigation"),
                                    "param_name" => "dots",
                                    // "admin_label" => true,
                                    "value" => "show",
                                    "options" => array(
                                        "show" => array(
                                            "label" => "Display dot navigation",
                                            "on" => "Yes",
                                            "off" => "No",
                                        ),
                                    ),
                                    "description" => $vc->l(""),
                                    "dependency" => "",
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Color of dots"),
                                    "param_name" => "dots_color",
                                    "value" => "#333333",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "dots", "value" => array("show")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "slick_icon",
                                    "class" => "",
                                    "heading" => $vc->l("Select icon for 'Navigation Dots'"),
                                    "param_name" => "dots_icon",
                                    "value" => "ultsl-record",
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "dots", "value" => array("show")),
                                    "group" => "Navigation",
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Item Animation"),
                                    "param_name" => "item_animation",
                                    "value" => array(
                                        $vc->l("No Animation") => "",
                                        $vc->l("Swing") => "swing",
                                        $vc->l("Pulse") => "pulse",
                                        $vc->l("Fade In") => "fadeIn",
                                        $vc->l("Fade In Up") => "fadeInUp",
                                        $vc->l("Fade In Down") => "fadeInDown",
                                        $vc->l("Fade In Left") => "fadeInLeft",
                                        $vc->l("Fade In Right") => "fadeInRight",
                                        $vc->l("Fade In Up Long") => "fadeInUpBig",
                                        $vc->l("Fade In Down Long") => "fadeInDownBig",
                                        $vc->l("Fade In Left Long") => "fadeInLeftBig",
                                        $vc->l("Fade In Right Long") => "fadeInRightBig",
                                        $vc->l("Slide In Down") => "slideInDown",
                                        $vc->l("Slide In Left") => "slideInLeft",
                                        $vc->l("Slide In Left") => "slideInLeft",
                                        $vc->l("Bounce In") => "bounceIn",
                                        $vc->l("Bounce In Up") => "bounceInUp",
                                        $vc->l("Bounce In Down") => "bounceInDown",
                                        $vc->l("Bounce In Left") => "bounceInLeft",
                                        $vc->l("Bounce In Right") => "bounceInRight",
                                        $vc->l("Rotate In") => "rotateIn",
                                        $vc->l("Light Speed In") => "lightSpeedIn",
                                        $vc->l("Roll In") => "rollIn",
                                    ),
                                    "description" => $vc->l(""),
                                    "group" => "Animation",
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "class" => "",
                                    "heading" => $vc->l("Draggable Effect"),
                                    "param_name" => "draggable",
                                    // "admin_label" => true,
                                    "value" => "on",
                                    "options" => array(
                                        "on" => array(
                                            "label" => "Allow slides to be draggable",
                                            "on" => "Yes",
                                            "off" => "No",
                                        ),
                                    ),
                                    "description" => $vc->l(""),
                                    "dependency" => "",
                                    "group" => "Advanced",
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "class" => "",
                                    "heading" => $vc->l("Touch Move"),
                                    "param_name" => "touch_move",
                                    // "admin_label" => true,
                                    "value" => "on",
                                    "options" => array(
                                        "on" => array(
                                            "label" => "Enable slide moving with touch",
                                            "on" => "Yes",
                                            "off" => "No",
                                        ),
                                    ),
                                    "description" => $vc->l(""),
                                    "dependency" => Array("element" => "draggable", "value" => array("on")),
                                    "group" => "Advanced",
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "class" => "",
                                    "heading" => $vc->l("RTL Mode"),
                                    "param_name" => "rtl",
                                    "value" => "",
                                    "options" => array(
                                        "on" => array(
                                            "label" => "Turn on RTL mode",
                                            "on" => "Yes",
                                            "off" => "No",
                                        ),
                                    ),
                                    "description" => $vc->l(""),
                                    "dependency" => "",
                                    "group" => "Advanced",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Space between two items"),
                                    "param_name" => "item_space",
                                    "value" => "15",
                                    "min" => "0",
                                    "max" => "1000",
                                    "step" => "1",
                                    "suffix" => "px",
                                    "description" => $vc->l(""),
                                    "group" => "Advanced",
                                ),
                                array(
                                    "type" => "heading",
                                    "param_name" => "notification",
                                    'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
                                    "group" => "General"
                                ),
                            ),
                            "js_view" => 'VcColumnView'
                        )
                );
            }
        }

        function ultimate_carousel_shortcode($atts, $content) {
            $slider_type = $slides_on_desk = $slides_on_tabs = $slides_on_mob = $slide_to_scroll = $speed = $infinite_loop = $autoplay = $autoplay_speed = '';
            $lazyload = $arrows = $dots = $dots_icon = $next_icon = $prev_icon = $dots_color = $draggable = $swipe = $touch_move = '';
            $rtl = $arrow_color = $arrow_size = $arrow_style = $arrow_bg_color = $arrow_border_color = $border_size = $item_space = $el_class = '';
            $item_animation = '';
            extract(JsComposer::shortcode_atts(array(
                        "slider_type" => "",
                        "slides_on_desk" => "",
                        "slides_on_tabs" => "",
                        "slides_on_mob" => "",
                        "slide_to_scroll" => "",
                        "speed" => "",
                        "infinite_loop" => "",
                        "autoplay" => "",
                        "autoplay_speed" => "",
                        "lazyload" => "",
                        "arrows" => "show",
                        "dots" => "show",
                        "dots_icon" => "",
                        "next_icon" => "",
                        "prev_icon" => "",
                        "dots_color" => "",
                        "arrow_color" => "",
                        "arrow_size" => "20",
                        "arrow_style" => "",
                        "arrow_bg_color" => "",
                        "arrow_border_color" => "",
                        "border_size" => "1.5",
                        "draggable" => "",
                        "swipe" => "true",
                        "touch_move" => "",
                        "rtl" => "",
                        "item_space" => "",
                        "el_class" => "",
                        "item_animation" => "",
                            ), $atts));


            $uid = uniqid(rand());
            $this->ultimate_front_scripts();
            $settings = $responsive = $infinite = $dot_display = $custom_dots = $arr_style = '';

            if ($slide_to_scroll == "all")
                $slide_to_scroll = $slides_on_desk;
            else
                $slide_to_scroll = 1;

            $arr_style .= 'color:' . $arrow_color . '; font-size:' . $arrow_size . 'px;';
            if ($arrow_style == "circle-bg" || $arrow_style == "square-bg") {
                $arr_style .= "background:" . $arrow_bg_color . ";";
            } elseif ($arrow_style == "circle-border" || $arrow_style == "square-border") {
                $arr_style .= "border:" . $border_size . "px solid " . $arrow_border_color . ";";
            }

            if ($dots !== "off" && $dots !== "")
                $settings .= 'dots: true,';
            else
                $settings .= 'dots: false,';
            if ($autoplay !== 'off' && $autoplay !== '')
                $settings .= 'autoplay: true,';
            if ($autoplay_speed !== '')
                $settings .= 'autoplaySpeed: ' . $autoplay_speed . ',';
            if ($speed !== '')
                $settings .= 'speed: ' . $speed . ',';
            if ($infinite_loop !== 'off' && $infinite_loop !== '')
                $settings .= 'infinite: true,';
            else
                $settings .= 'infinite: false,';
            if ($lazyload !== 'off' && $lazyload !== '')
                $settings .= 'lazyLoad: true,';
            if ($arrows !== 'off' && $arrows !== '') {
                $settings .= 'arrows: true,';
                $settings .= 'nextArrow: \'<button type="button" style="' . $arr_style . '" class="slick-next ' . $arrow_style . '"><i class="' . $next_icon . '"></i></button>\',';
                $settings .= 'prevArrow: \'<button type="button" style="' . $arr_style . '" class="slick-prev ' . $arrow_style . '"><i class="' . $prev_icon . '"></i></button>\',';
            } else {
                $settings .= 'arrows: false,';
            }

            if ($slide_to_scroll !== '')
                $settings .= 'slidesToScroll:' . $slide_to_scroll . ',';
            if ($slides_on_desk !== '')
                $settings .= 'slidesToShow:' . $slides_on_desk . ',';
            if ($slides_on_mob == '')
                $slides_on_mob = $slides_on_desk;
            if ($slides_on_tabs == '')
                $slides_on_tabs = $slides_on_desk;
            if ($draggable !== 'off' && $draggable !== '') {
                $settings .= 'swipe: true,';
                $settings .= 'draggable: true,';
            } else {
                $settings .= 'swipe: false,';
                $settings .= 'draggable: false,';
            }

            if ($touch_move !== "off" && $touch_move !== "")
                $settings .= 'touchMove: true,';
            else
                $settings .= 'touchMove: false,';
            if ($rtl !== "off" && $rtl !== "")
                $settings .= 'rtl: true,';

            if ($slider_type == "vertical") {
                $settings .= 'vertical: true,';
            }

            $settings .= 'responsive: [
							{
							  breakpoint: 1024,
							  settings: {
								slidesToShow: ' . $slides_on_desk . ',
								slidesToScroll: ' . $slide_to_scroll . ',
								' . $infinite . '
								' . $dot_display . '
							  }
							},
							{
							  breakpoint: 768,
							  settings: {
								slidesToShow: ' . $slides_on_tabs . ',
								slidesToScroll: ' . $slides_on_tabs . '
							  }
							},
							{
							  breakpoint: 480,
							  settings: {
								slidesToShow: ' . $slides_on_mob . ',
								slidesToScroll: ' . $slides_on_mob . '
							  }
							}
						],';
            $settings .= 'pauseOnHover: true,
						pauseOnDotsHover: true,';
            if ($dots_icon !== 'off' && $dots_icon !== '') {
                if ($dots_color !== 'off' && $dots_color !== '')
                    $custom_dots = 'style="color:' . $dots_color . ';"';
                $settings .= 'customPaging: function(slider, i) {
                   return \'<i type="button" ' . $custom_dots . ' class="' . $dots_icon . '" data-role="none"></i>\';
                },';
            }

            if ($item_animation == '') {
                $item_animation = 'no-animation';
            }
            ob_start();
            $uniqid = uniqid(rand());
            echo '<div id="ult-carousel-' . $uniqid . '" class="ult-carousel-wrapper ult_' . $slider_type . '" data-gutter="' . $item_space . '">';
            echo '<div class="ult-carousel-' . $uid . ' ' . $el_class . '">';
            ultimate_override_shortcodes($item_space, $item_animation);
            echo JsComposer::do_shortcode($content);
            ultimate_restore_shortcodes();
            echo '</div>';
            echo '</div>';
            ?>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
    jQuery('.ult-carousel-<?php echo $uid; ?>').slick({
        <?php echo $settings; ?>
    });

});
</script>
<?php
            return ob_get_clean();
        }

        // create icon style attribute
        function icon_settings_field($settings, $value) {
            $dependency = vc_generate_dependencies_attributes($settings);
            $uid = uniqid();
            $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
            $type = isset($settings['type']) ? $settings['type'] : '';
            $class = isset($settings['class']) ? $settings['class'] : '';
            if ($param_name == "next_icon" || $param_name == "prev_icon") {
                $icons = array('ultsl-arrow-right', 'ultsl-arrow-right2', 'ultsl-arrow-right3', 'ultsl-arrow-right4', 'ultsl-arrow-right6');
            }
            if ($param_name == "prev_icon") {
                $icons = array('ultsl-arrow-left', 'ultsl-arrow-left2', 'ultsl-arrow-left3', 'ultsl-arrow-left4', 'ultsl-arrow-left6');
            }

            if ($param_name == "dots_icon") {
                $icons = array('ultsl-checkbox-unchecked', 'ultsl-checkbox-partial', 'ultsl-stop', 'ultsl-radio-checked', 'ultsl-radio-unchecked', 'ultsl-record');
            }

            $output = '<input type="hidden" name="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" value="' . $value . '" id="trace-' . $uid . '"/>';
            //$output .= '<div class="ult-icon-preview icon-preview-'.$uid.'"><i class="'.$value.'"></i></div>';
            //$output .='<input class="search" type="text" placeholder="Search" />';
            $output .='<div id="icon-dropdown-' . $uid . '" >';
            $output .= '<ul class="icon-list">';
            $n = 1;
            foreach ($icons as $icon) {
                $selected = ($icon == $value) ? 'class="selected"' : '';
                $id = 'icon-' . $n;
                $output .= '<li ' . $selected . ' data-icon="' . $icon . '"><i class="ult-icon ' . $icon . '"></i><label class="ult-icon">' . $icon . '</label></li>';
                $n++;
            }
            $output .='</ul>';
            $output .='</div>';
            $output .= '<script type="text/javascript">		
					jQuery("#icon-dropdown-' . $uid . ' li").click(function() {
						jQuery(this).attr("class","selected").siblings().removeAttr("class");
						var icon = jQuery(this).attr("data-icon");
						jQuery("#trace-' . $uid . '").val(icon);
						jQuery(".icon-preview-' . $uid . '").html("<i class=\'ult-icon "+icon+"\'></i>");
					});
			</script>';
            $output .= '<style type="text/css">';
            $output .= 'ul.icon-list li {
							display: inline-block;
							float: left;
							padding: 5px;
							border: 1px solid #ddd;
							font-size: 18px;
							width: auto;
							height: auto;
							line-height: normal;
							margin: 0 auto;
                            cursor:pointer;
						}
						ul.icon-list li label.ult-icon {
							display: none;
						}
						.ult-icon-preview {
							padding: 5px;
							font-size: 24px;
							border: 1px solid #ddd;
							display: inline-block;
						}
						ul.icon-list li.selected {
							background: #3486D1;
							padding: 10px;
							margin: -7px -1px 0;
							color: #fff;
							font-size: 24px;
						}';
            $output .= '</style>';
            return $output;
        }

        // ult_switch param
        function checkbox_param($settings, $value) {
            $dependency = vc_generate_dependencies_attributes($settings);
            $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
            $type = isset($settings['type']) ? $settings['type'] : '';
            $options = isset($settings['options']) ? $settings['options'] : '';
            $class = isset($settings['class']) ? $settings['class'] : '';
            $output = $checked = '';
            $un = uniqid('ultswitch-' . rand());
            if (is_array($options) && !empty($options)) {
                foreach ($options as $key => $opts) {
                    if ($value == $key) {
                        $checked = "checked";
                    } else {
                        $checked = "";
                    }
                    $uid = uniqid('ultswitchparam-' . rand());
                    $output .= '<div class="onoffswitch">
							<input type="checkbox" name="' . $param_name . '" value="' . $value . '" ' . $dependency . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' ' . $dependency . ' onoffswitch-checkbox chk-switch-' . $un . '" id="switch' . $uid . '" ' . $checked . '>
							<label class="onoffswitch-label" for="switch' . $uid . '">
								<div class="onoffswitch-inner">
									<div class="onoffswitch-active">
										<div class="onoffswitch-switch">' . $opts['on'] . '</div>
									</div>
									<div class="onoffswitch-inactive">
										<div class="onoffswitch-switch">' . $opts['off'] . '</div>
									</div>
								</div>
							</label>
						</div>';
                    if (isset($opts['label']))
                        $lbl = $opts['label'];
                    else
                        $lbl = '';
                    $output .= '<div class="chk-label">' . $lbl . '</div><br/>';
                }
            }

            //$output .= '<input type="hidden" id="chk-switch-'.$un.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" />';
            $output .= '<script type="text/javascript">
				jQuery("#switch' . $uid . '").change(function(){
					 
					 if(jQuery("#switch' . $uid . '").is(":checked")){
						jQuery("#switch' . $uid . '").val("' . $key . '");
						jQuery("#switch' . $uid . '").attr("checked","checked");
					 } else {
						jQuery("#switch' . $uid . '").val("off");
						jQuery("#switch' . $uid . '").removeAttr("checked");
					 }
					
				});
			</script>';

            return $output;
        }

    }

    // new Ultimate_Carousel;
    if (class_exists('WPBakeryShortCodesContainer')) {

        class WPBakeryShortCode_ultimate_carousel extends WPBakeryShortCodesContainer {
        }

    }
}

function ultimate_override_shortcodes($item_space, $item_animation) {
    
//    global $shortcode_tags, $_shortcode_tags;
    // Let's make a back-up of the shortcodes
    Ultimate_Carousel::$restore_shortcodes = $shortcode_tags = jscomposer::$shortcode_tags;
    // Add any shortcode tags that we shouldn't touch here
    $disabled_tags = array('');
    foreach ($shortcode_tags as $tag => $cb) {
        if (in_array($tag, $disabled_tags)) {
            continue;
        }
        // Overwrite the callback function
        $shortcode_tags[$tag] = 'ultimate_wrap_shortcode_in_div';
        $_shortcode_tags["ult_item_space"] = $item_space;
        $_shortcode_tags["item_animation"] = $item_animation;
    }
    jscomposer::$shortcode_tags = $shortcode_tags;
}

// Wrap the output of a shortcode in a div with class "ult-item-wrap"
// The original callback is called from the $_shortcode_tags array
function ultimate_wrap_shortcode_in_div($attr, $content = null, $tag) {
    
    $_shortcode_tags = Ultimate_Carousel::$restore_shortcodes;

    return '<div class="ult-item-wrap" data-animation="animated ' . $_shortcode_tags["item_animation"] . '">' . call_user_func($_shortcode_tags[$tag], $attr, $content, $tag) . '</div>';
}

function ultimate_restore_shortcodes() {
    

//    global $shortcode_tags, $_shortcode_tags;
    // Restore the original callbacks
    if (!empty(Ultimate_Carousel::$restore_shortcodes)) {
        jscomposer::$shortcode_tags = Ultimate_Carousel::$restore_shortcodes;
    }

//    if ( isset( $_shortcode_tags ) ) {
//        $shortcode_tags = $_shortcode_tags;
//    }
}