<?php

/*
 * Add-on Name: Ultimate Fancy Text
 * Add-on URI: http://dev.brainstormforce.com
 */
if (!class_exists('Ultimate_FancyText')) {

    class Ultimate_FancyText {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->context = Context::getContext();
            JsComposer::add_shortcode('ultimate_fancytext', array(&$this, 'ultimate_fancytext_shortcode'));
            $this->vcaddonsinstance = jscomposer::getInstance();
        }

        function register_fancytext_assets() {
            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/fancytext.min.css");
        }

        function ultimate_fancytext_init() {
            $vc = vc_manager();
            if (function_exists("vc_map")) {
                vc_map(
                        array(
                            "name" => $vc->l("Fancy Text"),
                            "base" => "ultimate_fancytext",
                            "class" => "vc_ultimate_fancytext",
                            "icon" => "vc_ultimate_fancytext",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "description" => $vc->l("Fancy lines with animation effects.", "js_composer"),
                            "params" => array(
                                array(
                                    "type" => "textfield",
                                    "param_name" => "fancytext_prefix",
                                    "heading" => "Prefix",
                                    "value" => "",
                                ),
                                array(
                                    'type' => 'textarea',
                                    'heading' => $vc->l('Fancy Text', 'js_composer'),
                                    'param_name' => 'fancytext_strings',
                                    'description' => $vc->l('Enter each string on a new line'),
                                    'admin_label' => true
                                ),
                                array(
                                    "type" => "textfield",
                                    "param_name" => "fancytext_suffix",
                                    "heading" => "Suffix",
                                    "value" => "",
                                ),
                                array(
                                    "type" => "dropdown",
                                    "heading" => $vc->l("Effect", "js_composer"),
                                    "param_name" => 'fancytext_effect',
                                    "value" => array(
                                        $vc->l("Type", "js_composer") => "typewriter",
                                        $vc->l("Slide Up", "js_composer") => "ticker",
                                        $vc->l("Slide Down", "js_composer") => "ticker-down"
                                    ),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "heading" => $vc->l("Alignment", "js_composer"),
                                    "param_name" => "fancytext_align",
                                    "value" => array(
                                        $vc->l("Center", "js_composer") => "center",
                                        $vc->l("Left", "js_composer") => "left",
                                        $vc->l("Right", "js_composer") => "right"
                                    )
                                ),
                                array(
                                    "type" => "number",
                                    "heading" => $vc->l("Type Speed"),
                                    "param_name" => "strings_textspeed",
                                    "min" => 0,
                                    "value" => 35,
                                    "suffix" => "In Miliseconds",
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter")),
                                ),
                                array(
                                    "type" => "number",
                                    "heading" => $vc->l("Backspeed"),
                                    "param_name" => "strings_backspeed",
                                    "min" => 0,
                                    "value" => 0,
                                    "suffix" => "In Miliseconds",
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter")),
                                ),
                                array(
                                    "type" => "number",
                                    "heading" => $vc->l("Start Delay"),
                                    "param_name" => "strings_startdelay",
                                    "min" => 0,
                                    "value" => 200,
                                    "suffix" => "In Miliseconds",
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter")),
                                ),
                                array(
                                    "type" => "number",
                                    "heading" => $vc->l("Back Delay"),
                                    "param_name" => "strings_backdelay",
                                    "min" => 0,
                                    "value" => 1500,
                                    "suffix" => "In Miliseconds",
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter")),
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "heading" => "Enable Loop",
                                    "param_name" => "typewriter_loop",
                                    "value" => "true",
                                    "options" => array(
                                        "true" => array(
                                            "label" => "",
                                            "on" => "Yes",
                                            "off" => "No"
                                        )
                                    ),
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter"))
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "heading" => $vc->l("Show Cursor"),
                                    "param_name" => "typewriter_cursor",
                                    "value" => "true",
                                    "options" => array(
                                        "true" => array(
                                            "label" => "",
                                            "on" => "Yes",
                                            "off" => "No",
                                        )
                                    ),
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter"))
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => "Cursor Text",
                                    "param_name" => "typewriter_cursor_text",
                                    "value" => "|",
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "typewriter_cursor", "value" => array("true"))
                                ),
                                array(
                                    "type" => "number",
                                    "heading" => $vc->l("Animation Speed"),
                                    "param_name" => "strings_tickerspeed",
                                    "min" => 0,
                                    "value" => 200,
                                    "suffix" => "In Miliseconds",
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("ticker", "ticker-down")),
                                ),
                                array(
                                    "type" => "number",
                                    "heading" => $vc->l("Pause Time"),
                                    "param_name" => "ticker_wait_time",
                                    "min" => 0,
                                    "value" => "3000",
                                    "suffix" => "In Miliseconds",
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("ticker", "ticker-down")),
                                ),
                                array(
                                    "type" => "number",
                                    "heading" => $vc->l("Show Items"),
                                    "param_name" => "ticker_show_items",
                                    "min" => 1,
                                    "value" => 1,
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("ticker", "ticker-down")),
                                    "description" => $vc->l("How many items should be visible at a time?", "js_composer")
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "heading" => $vc->l("Pause on Hover"),
                                    "param_name" => "ticker_hover_pause",
                                    "value" => "",
                                    "options" => array(
                                        "true" => array(
                                            "label" => "",
                                            "on" => "Yes",
                                            "off" => "No",
                                        )
                                    ),
                                    "group" => "Advanced Settings",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("ticker", "ticker-down"))
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "ex_class"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => $vc->l("Font Family"),
                                    "param_name" => "strings_font_family",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => $vc->l("Font Style"),
                                    "param_name" => "strings_font_style",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "font-size",
                                    "heading" => $vc->l("Font Size"),
                                    "param_name" => "strings_font_size",
                                    "min" => 10,
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Line Height"),
                                    "param_name" => "strings_line_height",
                                    "value" => "",
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "heading" => "Fancy Text Color",
                                    "param_name" => "fancytext_color",
                                    "group" => "Advanced Settings",
                                    "group" => "Typography",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter", "ticker", "ticker-down"))
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "heading" => "Fancy Text Background",
                                    "param_name" => "ticker_background",
                                    "group" => "Advanced Settings",
                                    "group" => "Typography",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter", "ticker", "ticker-down"))
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l(" Prefix & Suffix Text Color"),
                                    "param_name" => "strings_color",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "heading" => "Cursor Color",
                                    "param_name" => "typewriter_cursor_color",
                                    "group" => "Advanced Settings",
                                    "group" => "Typography",
                                    "dependency" => array("element" => "fancytext_effect", "value" => array("typewriter"))
                                ),
                                array(
                                    "type" => "dropdown",
                                    "heading" => $vc->l("Markup"),
                                    "param_name" => "fancytext_tag",
                                    "value" => array(
                                        $vc->l("div") => "div",
                                        $vc->l("H1") => "h1",
                                        $vc->l("H2") => "h2",
                                        $vc->l("H3") => "h3",
                                        $vc->l("H4") => "h4",
                                        $vc->l("H5") => "h5",
                                        $vc->l("H6") => "h6",
                                    ),
                                    "group" => "Typography",
                                ),
                                array(
                                    "type" => "heading",
                                    "param_name" => "notification",
                                    'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
                                ),
                            )
                        )
                );
            }
        }

        function ultimate_fancytext_shortcode($atts, $content = null) {
            

            $output = $fancytext_strings = $fancytext_prefix = $fancytext_suffix = $fancytext_effect = $strings_textspeed = $strings_tickerspeed = $typewriter_cursor = $typewriter_cursor_text = $typewriter_loop = $fancytext_align = $strings_font_family = $strings_font_style = $strings_font_size = $strings_color = $strings_line_height = $strings_startdelay = $strings_backspeed = $strings_backdelay = $ticker_wait_time = $ticker_show_items = $ticker_hover_pause = $ex_class = '';

            $id = uniqid(rand());
            $vc = vc_manager();

            extract(JsComposer::shortcode_atts(array(
                        'fancytext_strings' => '',
                        'fancytext_prefix' => '',
                        'fancytext_suffix' => '',
                        'fancytext_effect' => '',
                        'strings_textspeed' => '35',
                        'strings_tickerspeed' => '200',
                        'typewriter_loop' => 'false',
                        'typewriter_cursor_color' => '',
                        'fancytext_tag' => 'div',
                        'fancytext_align' => 'center',
                        'strings_font_family' => '',
                        'strings_font_style' => '',
                        'strings_font_size' => '',
                        'strings_color' => '',
                        'strings_line_height' => '',
                        'strings_startdelay' => '200',
                        'strings_backspeed' => '0',
                        'strings_backdelay' => '1500',
                        'typewriter_cursor' => 'true',
                        'typewriter_cursor_text' => '|',
                        'ticker_wait_time' => '3000',
                        'ticker_show_items' => '1',
                        'ticker_hover_pause' => 'true',
                        'ticker_background' => '',
                        'fancytext_color' => '',
                        'ex_class' => ''
                            ), $atts));

            $this->register_fancytext_assets();
            $string_inline_style = $vticker_inline = $valign = '';

            if ($strings_font_family != '') {
                $font_family = get_ultimate_font_family($strings_font_family);
                $string_inline_style .= 'font-family:\'' . $font_family . '\';';
            }

            $string_inline_style .= get_ultimate_font_style($strings_font_style);

            if ($strings_font_size != '')
                $string_inline_style .= 'font-size:' . $strings_font_size . 'px;';

            if ($strings_color != '')
                $string_inline_style .= 'color:' . $strings_color . ';';

            if ($strings_line_height != '')
                $string_inline_style .= 'line-height:' . $strings_line_height . 'px;';

            if ($fancytext_align != '')
                $string_inline_style .= 'text-align:' . $fancytext_align . ';';

            // Order of replacement
            $order = array("\r\n", "\n", "\r", "<br/>", "<br>");
            $replace = ',';

            // Processes \r\n's first so they aren't converted twice.
            $str = str_replace($order, $replace, $fancytext_strings);

            $lines = explode(",", $str);

            $count_lines = count($lines);

            $ex_class .= ' uvc-type-align-' . $fancytext_align . ' ';
            if ($fancytext_prefix == '')
                $ex_class .= 'uvc-type-no-prefix';

            if ($fancytext_color != '')
                $vticker_inline .= 'color:' . $fancytext_color . ';';
            if ($ticker_background != '') {
                $vticker_inline .= 'background:' . $ticker_background . ';';
                if ($fancytext_effect == 'typewriter')
                    $valign = 'fancytext-typewriter-background-enabled';
                else
                    $valign = 'fancytext-background-enabled';
            }

            $output = '<' . $fancytext_tag . ' class="uvc-type-wrap ' . $ex_class . ' uvc-wrap-' . $id . '" style="' . $string_inline_style . '">';
            if (trim($fancytext_prefix) != '') {
                $output .= '<span class="ultimate-' . $fancytext_effect . '-prefix">' . ltrim($fancytext_prefix) . '</span>';
            }
            if ($fancytext_effect == 'ticker' || $fancytext_effect == 'ticker-down') {
                                       
                


                if ($strings_font_size != '')
                    $inherit_font_size = 'ultimate-fancy-text-inherit';
                else
                    $inherit_font_size = '';
                if ($ticker_hover_pause != 'true')
                    $ticker_hover_pause = 'false';
                if ($fancytext_effect == 'ticker-down')
                    $direction = "down";
                else
                    $direction = "up";
                $output .= '<div id="vticker-' . $id . '" class="ultimate-vticker ' . $fancytext_effect . ' ' . $valign . ' ' . $inherit_font_size . '" style="' . $vticker_inline . '"><ul>';
                foreach ($lines as $line) {
                    $output .= '<li>' . strip_tags($line) . '</li>';
                }
                $output .= '</ul></div>';
            } else {

                if ($typewriter_loop != 'true')
                    $typewriter_loop = 'false';
                if ($typewriter_cursor != 'true')
                    $typewriter_cursor = 'false';
                $strings = '[';
                foreach ($lines as $key => $line) {
                    $strings .= '"' . $vc->l(trim(strip_tags($line)), 'js_composer') . '"';
                    if ($key != ($count_lines - 1))
                        $strings .= ',';
                }
                $strings .= ']';
                $output .= '<span id="typed-' . $id . '" class="ultimate-typed-main ' . $valign . '" style="' . $vticker_inline . '"></span>';
            }
            if (trim($fancytext_suffix) != '') {
                $output .= '<span class="ultimate-' . $fancytext_effect . '-suffix">' . rtrim($fancytext_suffix) . '</span>';
            }

            if ($fancytext_effect == 'ticker' || $fancytext_effect == 'ticker-down') {
                $output .= '
                <script src="'.$this->vcaddonsinstance->_url_ultimate.'assets/min-js/vticker.min.js"></script>
                <script type="text/javascript">
						jQuery(function($){
							$("#vticker-' . $id . '")
									.vTicker(
									{
										speed: ' . $strings_tickerspeed . ',
										showItems: ' . $ticker_show_items . ',
										pause: ' . $ticker_wait_time . ',
										mousePause : ' . $ticker_hover_pause . ',
										direction: "' . $direction . '",
									}
								);
						});
					</script>';
            } else {
                // $this->context->controller->addJS("{}");
                $output .= '
                
                <script src="'.$this->vcaddonsinstance->_url_ultimate.'assets/min-js/typed.min.js"></script>
                <script type="text/javascript"> jQuery(function($){ $("#typed-' . $id . '").typed({ 
								strings: ' . $strings . ',
								typeSpeed: ' . $strings_textspeed . ',
								backSpeed: ' . $strings_backspeed . ',
								startDelay: ' . $strings_startdelay . ',
								backDelay: ' . $strings_backdelay . ',
								loop: ' . $typewriter_loop . ',
								loopCount: false,
								showCursor: ' . $typewriter_cursor . ',
								cursorChar: "' . $typewriter_cursor_text . '",
								attr: null
							});
						});
					</script>';
                if ($typewriter_cursor_color != '') {
                    $output .= '<style>
							.uvc-wrap-' . $id . ' .typed-cursor {
								color:' . $typewriter_cursor_color . ';
							}
						</style>';
                }
            }
            $output .= '</' . $fancytext_tag . '>';

            $args = array(
                $strings_font_family
            );
            enquque_ultimate_google_fonts($args);

            return $output;
        }

    }

    // end class
    // new Ultimate_FancyText;
}