<?php

/*
 * Add-on Name: Stats Counter for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if (!class_exists('AIO_Stats_Counter')) {

    class AIO_Stats_Counter {

        public $vcaddonsinstance, $context;

        // constructor
        function __construct() {

            $this->vcaddonsinstance = jscomposer::getInstance();
            $this->context = Context::getContext();

            // 	add_action('admin_init',array($this,'counter_init'));
            // 	add_action("wp_enqueue_scripts", array($this, "register_counter_assets"),1);
            JsComposer::add_shortcode('stat_counter', array(&$this, 'counter_shortcode'));

            
        }

        

        function register_counter_assets() {
            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/animate.min.css");            
            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/stats-counter.min.css");            
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/jquery.appear.min.js");
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/slick.custom.min.js");            
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/countUp.min.js");
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/custom.min.js");
        }

        // initialize the mapping function
        function counter_init() {
            $vc = vc_manager();
            if (function_exists('vc_map')) {
                // map with visual
                vc_map(
                        array(
                            "name" => $vc->l("Counter"),
                            "base" => "stat_counter",
                            "class" => "vc_stats_counter",
                            "icon" => "vc_icon_stats",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "description" => $vc->l("Your milestones, achievements, etc."),
                            "params" => array(
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon to display:"),
                                    "param_name" => "icon_type",
                                    "value" => array(
                                        "Font Icon Manager" => "selector",
                                        "Custom Image Icon" => "custom",
                                    ),
                                    "description" => $vc->l("Use an existing font icon</a> or upload a custom image.")
                                ),
                                array(
                                    "type" => "icon_manager",
                                    "class" => "",
                                    "heading" => $vc->l("Select Icon "),
                                    "param_name" => "icon",
                                    "value" => "",
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "attach_image",
                                    "class" => "",
                                    "heading" => $vc->l("Upload Image Icon:"),
                                    "param_name" => "icon_img",
                                    "value" => "",
                                    "description" => $vc->l("Upload the custom image icon."),
                                    "dependency" => Array("element" => "icon_type", "value" => array("custom")),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Image Width"),
                                    "param_name" => "img_width",
                                    "value" => 48,
                                    "min" => 16,
                                    "max" => 512,
                                    "suffix" => "px",
                                    "description" => $vc->l("Provide image width"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("custom")),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Size of Icon"),
                                    "param_name" => "icon_size",
                                    "value" => 32,
                                    "min" => 12,
                                    "max" => 72,
                                    "suffix" => "px",
                                    "description" => $vc->l("How big would you like it?"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Color"),
                                    "param_name" => "icon_color",
                                    "value" => "#333333",
                                    "description" => $vc->l("Give it a nice paint!"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Style"),
                                    "param_name" => "icon_style",
                                    "value" => array(
                                        "Simple" => "none",
                                        "Circle Background" => "circle",
                                        "Square Background" => "square",
                                        "Design your own" => "advanced",
                                    ),
                                //"dependency" => Array("element" => "icon_type","value" => array("selector")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Background Color"),
                                    "param_name" => "icon_color_bg",
                                    "value" => "#ffffff",
                                    "description" => $vc->l("Select background color for icon."),
                                    "dependency" => Array("element" => "icon_style", "value" => array("circle", "square", "advanced")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Border Style"),
                                    "param_name" => "icon_border_style",
                                    "value" => array(
                                        "None" => "",
                                        "Solid" => "solid",
                                        "Dashed" => "dashed",
                                        "Dotted" => "dotted",
                                        "Double" => "double",
                                        "Inset" => "inset",
                                        "Outset" => "outset",
                                    ),
                                    "description" => $vc->l("Select the border style for icon."),
                                    "dependency" => Array("element" => "icon_style", "value" => array("advanced")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Border Color"),
                                    "param_name" => "icon_color_border",
                                    "value" => "#333333",
                                    "description" => $vc->l("Select border color for icon."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Width"),
                                    "param_name" => "icon_border_size",
                                    "value" => 1,
                                    "min" => 1,
                                    "max" => 10,
                                    "suffix" => "px",
                                    "description" => $vc->l("Thickness of the border."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Radius"),
                                    "param_name" => "icon_border_radius",
                                    "value" => 500,
                                    "min" => 1,
                                    "max" => 500,
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Background Size"),
                                    "param_name" => "icon_border_spacing",
                                    "value" => 50,
                                    "min" => 0,
                                    "max" => 500,
                                    "suffix" => "px",
                                    "description" => $vc->l("Spacing from center of the icon till the boundary of border / background"),
                                    "dependency" => Array("element" => "icon_style", "value" => array("advanced")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Animation"),
                                    "param_name" => "icon_animation",
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
                                    "description" => $vc->l("Like CSS3 Animations? We have several options for you!")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Position", "icon-box"),
                                    "param_name" => "icon_position",
                                    "value" => array(
                                        'Top' => 'top',
                                        'Right' => 'right',
                                        'Left' => 'left',
                                    ),
                                    "description" => $vc->l("Enter Position of Icon", "icon-box")
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Counter Title "),
                                    "param_name" => "counter_title",
                                    "admin_label" => true,
                                    "value" => "",
                                    "description" => $vc->l("Enter title for stats counter block")
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Counter Value"),
                                    "param_name" => "counter_value",
                                    "value" => "1250",
                                    "description" => $vc->l("Enter number for counter without any special character. You may enter a decimal number. Eg 12.76")
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Thousands Separator"),
                                    "param_name" => "counter_sep",
                                    "value" => ",",
                                    "description" => $vc->l("Enter character for thousanda separator. e.g. ',' will separate 125000 into 125,000")
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Replace Decimal Point With"),
                                    "param_name" => "counter_decimal",
                                    "value" => ".",
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Counter Value Prefix"),
                                    "param_name" => "counter_prefix",
                                    "value" => "",
                                    "description" => $vc->l("Enter prefix for counter value")
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Counter Value Suffix"),
                                    "param_name" => "counter_suffix",
                                    "value" => "",
                                    "description" => $vc->l("Enter suffix for counter value")
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Counter rolling time"),
                                    "param_name" => "speed",
                                    "value" => 3,
                                    "min" => 1,
                                    "max" => 10,
                                    "suffix" => "seconds",
                                    "description" => $vc->l("How many seconds the counter should roll?")
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Title Font Size"),
                                    "param_name" => "font_size_title",
                                    "value" => 18,
                                    "min" => 10,
                                    "max" => 72,
                                    "suffix" => "px",
                                    "description" => $vc->l("Enter value in pixels.")
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Counter Font Size"),
                                    "param_name" => "font_size_counter",
                                    "value" => 28,
                                    "min" => 12,
                                    "max" => 72,
                                    "suffix" => "px",
                                    "description" => $vc->l("Enter value in pixels.")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Counter Text Color"),
                                    "param_name" => "counter_color_txt",
                                    "value" => "",
                                    "description" => $vc->l("Select text color for counter title and digits."),
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                ),
                                array(
                                    "type" => "text",
                                    "param_name" => "title_text_typography",
                                    "heading" => $vc->l("<h2>Counter Title settings</h2>"),
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => "Font Family",
                                    "param_name" => "title_font",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => "Font Style",
                                    "param_name" => "title_font_style",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "title_font_size",
                                    "heading" => "Font size",
                                    "value" => "",
                                    "suffix" => "px",
                                    "min" => 10,
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "title_font_line_height",
                                    "heading" => "Font Line Height",
                                    "value" => "",
                                    "suffix" => "px",
                                    "min" => 10,
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "text",
                                    "param_name" => "desc_text_typography",
                                    "heading" => $vc->l("<h2>Counter Value settings</h2>"),
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => "Font Family",
                                    "param_name" => "desc_font",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => "Font Style",
                                    "param_name" => "desc_font_style",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "desc_font_size",
                                    "heading" => "Font size",
                                    "value" => "",
                                    "suffix" => "px",
                                    "min" => 10,
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "desc_font_line_height",
                                    "heading" => "Font Line Height",
                                    "value" => "",
                                    "suffix" => "px",
                                    "min" => 10,
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "param_name" => "desc_font_color",
                                    "heading" => "Color",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "heading",
                                    "param_name" => "notification",
                                    'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
                                ),
                            ),
                        )
                );
            }
        }

        // Shortcode handler function for stats counter
        function counter_shortcode($atts) {
            // enqueue js
            //wp_enqueue_script('ultimate-appear');
            //wp_enqueue_script('ultimate-custom');
            //wp_enqueue_script('front-js',plugins_url('../assets/min-js/countUp.min.js',__FILE__));
            $this->register_counter_assets();
            
            
            $icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $counter_title = $counter_value = $icon_position = $counter_style = $font_size_title = $font_size_counter = $counter_font = $title_font = $speed = $counter_sep = $counter_suffix = $counter_prefix = $counter_decimal = $counter_color_txt = $desc_font_line_height = $title_font_line_height = '';
            $title_font = $title_font_style = $title_font_size = $title_font_color = $desc_font = $desc_font_style = $desc_font_size = $desc_font_color = '';
            extract(JsComposer::shortcode_atts(array(
                        'icon_type' => '',
                        'icon' => '',
                        'icon_img' => '',
                        'img_width' => '',
                        'icon_size' => '',
                        'icon_color' => '',
                        'icon_style' => '',
                        'icon_color_bg' => '',
                        'icon_color_border' => '',
                        'icon_border_style' => '',
                        'icon_border_size' => '',
                        'icon_border_radius' => '',
                        'icon_border_spacing' => '',
                        'icon_link' => '',
                        'icon_animation' => '',
                        'counter_title' => '',
                        'counter_value' => '',
                        'counter_sep' => '',
                        'counter_suffix' => '',
                        'counter_prefix' => '',
                        'counter_decimal' => '',
                        'icon_position' => '',
                        'counter_style' => '',
                        'speed' => '',
                        'font_size_title' => '',
                        'font_size_counter' => '',
                        'counter_color_txt' => '',
                        'title_font' => '',
                        'title_font_style' => '',
                        'title_font_size' => '',
                        'title_font_line_height' => '',
                        'desc_font' => '',
                        'desc_font_style' => '',
                        'desc_font_size' => '',
                        'desc_font_color' => '',
                        'desc_font_line_height' => '',
                        'el_class' => '',
                            ), $atts));
            $class = $style = $title_style = $desc_style = '';
            $font_args = array();
            $stats_icon = JsComposer::do_shortcode('[just_icon icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_link="' . $icon_link . '" icon_animation="' . $icon_animation . '"]');

            /* title */
            if ($title_font != '') {
                $font_family = get_ultimate_font_family($title_font);
                $title_style .= 'font-family:' . $font_family . ';';
                array_push($font_args, $title_font);
            }
            if ($title_font_style != '')
                $title_style .= get_ultimate_font_style($title_font_style);
            if ($title_font_size != '')
                $title_style .= 'font-size:' . $title_font_size . 'px;';
            if ($title_font_line_height != '')
                $title_style .= 'line-height:' . $title_font_line_height . 'px;';

            /* description */
            if ($desc_font != '') {
                $font_family = get_ultimate_font_family($desc_font);
                $desc_style .= 'font-family:' . $font_family . ';';
                array_push($font_args, $desc_font);
            }
            if ($desc_font_style != '')
                $desc_style .= get_ultimate_font_style($desc_font_style);
            if ($desc_font_size != '')
                $desc_style .= 'font-size:' . $desc_font_size . 'px;';
            if ($desc_font_line_height != '')
                $desc_style .= 'line-height:' . $desc_font_line_height . 'px;';
            if ($desc_font_color != '')
                $desc_style .= 'color:' . $desc_font_color . ';';
            enquque_ultimate_google_fonts($font_args);

            if ($counter_color_txt !== '') {
                $counter_color = 'color:' . $counter_color_txt . ';';
            } else {
                $counter_color = '';
            }
            if ($icon_color != '')
                $style.='color:' . $icon_color . ';';
            if ($icon_animation !== 'none') {
                $css_trans = 'data-animation="' . $icon_animation . '" data-animation-delay="03"';
            }
            $counter_font = 'font-size:' . $font_size_counter . 'px;';
            $title_font = 'font-size:' . $font_size_title . 'px;';
            if ($counter_style != '') {
                $class = $counter_style;
                if (strpos($counter_style, 'no_bg')) {
                    $style.= "border:2px solid " . $counter_icon_bg_color . ';';
                } elseif (strpos($counter_style, 'with_bg')) {
                    if ($counter_icon_bg_color != '')
                        $style.='background:' . $counter_icon_bg_color . ';';
                }
            }
            if ($el_class != '')
                $class.= ' ' . $el_class;
            $ic_position = 'stats-' . $icon_position;
            $ic_class = 'aio-icon-' . $icon_position;
            $output = '<div class="stats-block ' . $ic_position . ' ' . $class . '">';
            //$output .= '<div class="stats-icon" style="'.$style.'">
            //				<i class="'.$stats_icon.'"></i>
            //			</div>';
            $id = 'counter_' . uniqid();
            if ($counter_sep == "") {
                $counter_sep = 'none';
            }
            if ($counter_decimal == "") {
                $counter_decimal = 'none';
            }
            if ($icon_position !== "right")
                $output .= '<div class="' . $ic_class . '">' . $stats_icon . '</div>';
            $output .= '<div class="stats-desc">';
            if ($counter_prefix !== '') {
                $output .= '<div class="counter_prefix" style="' . $counter_font . '">' . $counter_prefix . '</div>';
            }
            $output .= '<div id="' . $id . '" data-id="' . $id . '" class="stats-number" style="' . $counter_font . ' ' . $counter_color . ' ' . $desc_style . '" data-speed="' . $speed . '" data-counter-value="' . $counter_value . '" data-separator="' . $counter_sep . '" data-decimal="' . $counter_decimal . '">0</div>';
            if ($counter_suffix !== '') {
                $output .= '<div class="counter_suffix" style="' . $counter_font . ' ' . $counter_color . '">' . $counter_suffix . '</div>';
            }
            $output .= '<div class="stats-text" style="' . $title_font . ' ' . $counter_color . ' ' . $title_style . '">' . $counter_title . '</div>';
            $output .= '</div>';
            if ($icon_position == "right")
                $output .= '<div class="' . $ic_class . '">' . $stats_icon . '</div>';
            $output .= '</div>';
            return $output;
        }

    }

}
//if (class_exists('AIO_Stats_Counter')) {
//    $AIO_Stats_Counter = new AIO_Stats_Counter;
//}