<?php

/*
 * Add-on Name: Info Circle for Visual Composer
 */
if (!class_exists('Ultimate_Info_Circle')) {

    class Ultimate_Info_Circle {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = jscomposer::getInstance();
            $this->context = Context::getContext();
            JsComposer::add_shortcode('info_circle', array($this, 'info_circle'));
            JsComposer::add_shortcode('info_circle_item', array($this, 'info_circle_item'));

        }

        function info_circle_scripts() {
//            jscomposer::$front_scripts[] = "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/info-circle.min.js";
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/info-circle.min.js");
//            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/jquery.ui.effect.min.js");
            $this->context->controller->addJqueryUI(array("ui.effect"));
            //	// wp_register_script("info-circle-ui-effect",plugins_url("../assets/min-js/jquery.ui.effect.min.js",__FILE__),array('jquery'),ULTIMATE_VERSION);
        }

        function info_circle_styles() {

            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/info-circle.min.css");
        }

        function info_circle($atts, $content = null) {
            $this->info_circle_scripts();
            $this->info_circle_styles();
            

            $edge_radius = $visible_circle = $start_degree = $eg_padding = $circle_type = $icon_position = $eg_br_width = $eg_br_style = $eg_border_color = $cn_br_style = $highlight_style = $responsive_breakpoint = '';
            $icon_size = $cn_br_width = $cn_border_color = $icon_diversion = $icon_show = $content_bg = $content_color = $el_class = '';
            $icon_launch = $icon_launch_duration = $icon_launch_delay = $clipped_circle = '';
            $title_font = $title_font_style = $title_font_size = $title_line_height = $desc_font = $desc_font_style = $desc_font_size = $desc_line_height = '';
            extract(JsComposer::shortcode_atts(array(
                        'edge_radius' => '',
                        'visible_circle' => '',
                        'start_degree' => '',
                        'circle_type' => '',
                        'icon_position' => '',
                        'focus_on' => '',
                        'eg_br_width' => '',
                        'eg_br_style' => '',
                        'eg_border_color' => '',
                        'cn_br_style' => '',
                        'cn_br_width' => '',
                        'cn_border_color' => '',
                        'highlight_style' => '',
                        'icon_size' => '',
                        'eg_padding' => '',
                        'icon_diversion' => '',
                        'icon_show' => '',
                        'content_icon_size' => '',
                        'content_color' => '',
                        'content_bg' => '',
                        'responsive' => '',
                        'responsive_breakpoint' => '800',
                        'auto_slide' => '',
                        'auto_slide_duration' => '',
                        'icon_launch' => '',
                        'icon_launch_duration' => '',
                        'icon_launch_delay' => '',
                        'el_class' => '',
                        'title_font' => '',
                        'title_font_style' => '',
                        'title_font_size' => '',
                        'title_line_height' => '',
                        'desc_font' => '',
                        'desc_font_style' => '',
                        'desc_font_size' => '',
                        'desc_line_height' => '',
                            ), $atts));

            $uniq = uniqid();

            global $title_style_inline, $desc_style_inline;
            /* ---- main title styles ---- */
            if ($title_font != '') {
                $title_font_family = get_ultimate_font_family($title_font);
                $title_style_inline = 'font-family:\'' . $title_font_family . '\';';
            }
            // main heading font style
            $title_style_inline .= get_ultimate_font_style($title_font_style);
            //attach font size if set
            if ($title_font_size != '')
                $title_style_inline .= 'font-size:' . $title_font_size . 'px;';
            //line height
            if ($title_line_height != '')
                $title_style_inline .= 'line-height:' . $title_line_height . 'px;';

            /* ---- description styles ---- */
            if ($desc_font != '') {
                $desc_font_family = get_ultimate_font_family($desc_font);
                $desc_style_inline = 'font-family:\'' . $desc_font_family . '\';';
            }
            // main heading font style
            $desc_style_inline .= get_ultimate_font_style($desc_font_style);
            //attach font size if set
            if ($desc_font_size != '')
                $desc_style_inline .= 'font-size:' . $desc_font_size . 'px;';
            //line height
            if ($desc_line_height != '')
                $desc_style_inline .= 'line-height:' . $desc_line_height . 'px;';

            // enqueue fonts
            $args = array(
                $title_font, $desc_font
            );
            enquque_ultimate_google_fonts($args);

            $style = $style1 = $style3 = $ex_class = '';
            if ($eg_br_style != 'none' && $eg_br_width != '' && $eg_border_color != '') {
                $style.='border:' . $eg_br_width . 'px ' . $eg_br_style . ' ' . $eg_border_color . ';';
            }
            if ($cn_br_style != 'none' && $cn_br_width != '' && $cn_border_color != '') {
                $style1.='border:' . $cn_br_width . 'px ' . $cn_br_style . ' ' . $cn_border_color . ';';
            }
            //$style .='border-style:'.$eg_br_style.';';
            $style1 .='background-color:' . $content_bg . ';color:' . $content_color . ';';
            $style1 .='width:' . $eg_padding . '%;height:' . $eg_padding . '%;margin:' . ((100 - $eg_padding) / 2) . '%;';
            if ($el_class != '')
                $ex_class = $el_class;
            if ($responsive == 'on')
                $ex_class .= ' info-circle-responsive';
            if ($icon_show == 'show') {
                $content_icon_size = $content_icon_size;
            } else {
                $content_icon_size = '';
            }
            if ($edge_radius != '') {
                $style .= 'width:' . $edge_radius . '%;';
            }
            $style .='opacity:0;';
            if ($circle_type == '')
                $circle_type = 'info-c-full-br';

            if ($icon_position == 'full')
                $circle_type_extended = 'full-circle';
            else {
                if ($icon_position == 90)
                    $circle_type_extended = 'left-circle';
                elseif ($icon_position == 270)
                    $circle_type_extended = 'right-circle';
                elseif ($icon_position == 180)
                    $circle_type_extended = 'top-circle';
                elseif ($icon_position == 0)
                    $circle_type_extended = 'bottom-circle';
                else
                    $circle_type_extended = 'full-circle';
            }


            if ($visible_circle != '' && $visible_circle != 100 && $circle_type_extended != 'full-circle')
                $clipped_circle = 'clipped-info-circle';

            $output = '<div class="info-wrapper"><div id="info-circle-wrapper-' . $uniq . '" data-uniqid="' . $uniq . '" class="info-circle-wrapper ' . $ex_class . ' ' . $clipped_circle . '" data-half-percentage="' . $visible_circle . '" data-circle-type="' . $circle_type_extended . '">';
            $output .= '<div class="' . $circle_type . '" style=\'' . $style . '\' data-start-degree="' . $start_degree . '" data-divert="' . $icon_diversion . '" data-info-circle-angle="' . $icon_position . '" data-responsive-circle="' . $responsive . '" data-responsive-breakpoint="' . $responsive_breakpoint . '" data-launch="' . $icon_launch . '" data-launch-duration="' . $icon_launch_duration . '" data-launch-delay="' . $icon_launch_delay . '" data-slide-true="' . $auto_slide . '" data-slide-duration="' . $auto_slide_duration . '" data-icon-size="' . $icon_size . '" data-icon-show="' . $icon_show . '" data-icon-show-size="' . $content_icon_size . '" data-highlight-style="' . $highlight_style . '" data-focus-on="' . $focus_on . '">';
            $output .= '<div class="icon-circle-list">';
            //$content = str_replace('[info_circle_item', '[info_circle_item  icon_size="'.$icon_size.'"', $content);
            $output .= JsComposer::do_shortcode($content);
            if ($icon_position != 'full') {
                $output .='<div class="info-circle-icons suffix-remove"></div>';
            }
            $output .= '</div>';
            $output .='<div class="info-c-full" style="' . $style1 . '"><div class="info-c-full-wrap"></div>';
            $output .='</div>';
            $output .= '</div>';
            if ($responsive == 'on') {
                $output .='<div class="smile_icon_list_wrap " data-content_bg="' . $content_bg . '" data-content_color="' . $content_color . '">
					<ul class="smile_icon_list left circle with_bg">
						<li class="icon_list_item" style="font-size:' . ($icon_size * 3) . 'px;">
							<div class="icon_list_icon" style="font-size:' . $icon_size . 'px;">
								<i class="smt-pencil"></i>
							</div>
							<div class="icon_description">
								<h3></h3>
								<p></p>
							</div>
							<div class="icon_list_connector" style="border-style:' . $eg_br_style . ';border-color:' . $eg_border_color . '">
							</div>
						</li>
					</ul>
				</div>';
            }
            $output .='</div></div>';
            return $output;
        }

        function info_circle_item($atts, $content = null) {
            global $title_style_inline, $desc_style_inline;
            // Do nothing
            $info_title = $icon_type = $info_icon = $icon_color = $icon_bg_color = $info_img = $icon_type = $contents = $radius = $icon_size = $icon_html = $style = $output = $style = '';
            extract(JsComposer::shortcode_atts(array(
                        'info_title' => '',
                        'icon_type' => '',
                        'info_icon' => '',
                        'icon_color' => '',
                        'icon_bg_color' => '',
                        'info_img' => '',
                        'icon_type' => '',
                        'icon_br_style' => '',
                        'icon_br_width' => '',
                        'icon_border_color' => '',
                        'contents' => '',
                        'el_class' => '',
                            ), $atts));
            $icon_html = $output = '';
            if ($icon_type == "selector") {
                $icon_html .= '<i class="' . $info_icon . '" ></i>';
            } else {
                $img = JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($info_img);
                $icon_html .= '<img class="info-circle-img-icon" alt="icon" src="' . $img . '"/>';
            }
            if ($icon_bg_color != '') {
                $style .='background:' . $icon_bg_color . ';';
            }
            if ($icon_color != '') {
                $style .='color:' . $icon_color . ';';
            }
            if ($icon_br_style != 'none' && $icon_br_width != '' && $icon_border_color != '') {
                $style.='border-style:' . $icon_br_style . ';';
                $style.='border-width:' . $icon_br_width . 'px;';
                $style.='border-color:' . $icon_border_color . ';';
            }
            $output .= '<div class="info-circle-icons ' . $el_class . '" style="' . $style . '">';
            $output .= $icon_html;
            $output .="</div>";
            $output .='<div class="info-details">';
            //$output .=$icon_html;
            $output .='<div class="info-circle-def"><div class="info-circle-sub-def">' . $icon_html . '<h3 class="info-circle-heading" style="' . $title_style_inline . '">' . $info_title . '</h3><div class="info-circle-text" style="' . $desc_style_inline . '">' . JsComposer::do_shortcode($content) . '</div></div></div></div>';
            //$output .= wpb_js_remove_wpautop($content, true);
            return $output;
        }

        function add_info_circle() {
            $vc = vc_manager();
            if (function_exists('vc_map')) {
                $thumbnail_tab = 'Thumbnail';
                $information_tab = 'Information Area';
                $connector_tab = 'Connector';
                $reponsive_tab = 'Responsive';

                vc_map(
                        array(
                            "name" => $vc->l("Info Circle"),
                            "base" => "info_circle",
                            "class" => "vc_info_circle",
                            "icon" => "vc_info_circle",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "as_parent" => array('only' => 'info_circle_item'),
                            "description" => $vc->l("Information Circle"),
                            "content_element" => true,
                            "show_settings_on_create" => true,
                            "params" => array(
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Select area to display thumbnail icons"),
                                    "param_name" => "icon_position",
                                    "value" => array(
                                        'Complete' => 'full',
                                        'Top' => '180',
                                        'Bottom' => '0',
                                        'Left' => '90',
                                        'Right' => '270'
                                    ),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Clipped Circle"),
                                    "param_name" => "visible_circle",
                                    "value" => "70",
                                    "suffix" => "%",
                                    "dependency" => Array("element" => "icon_position", "value" => array("180", "270", "90", "0"))
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Size of Information Circle"),
                                    "param_name" => "edge_radius",
                                    "value" => 80,
                                    "suffix" => "%",
                                    "description" => $vc->l("Size of circle relative to container width."),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Position of First Thumbnail"),
                                    "param_name" => "start_degree",
                                    "value" => 90,
                                    "max" => 360,
                                    "suffix" => "&deg; degree",
                                    "description" => $vc->l("The degree from where Info Circle will be displayed."),
                                    "dependency" => Array("element" => "icon_position", "value" => array("full")),
                                    "group" => $thumbnail_tab
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Distance Between Thumbnails & Information Circle"),
                                    "param_name" => "eg_padding",
                                    "value" => array(
                                        "Extra large" => "50",
                                        "Large" => "60",
                                        "Medium" => "70",
                                        "Small" => "80",
                                    ),
                                //"description" => $vc->l("Distance between Information Cirlce and Thumbnails."),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Thumbnail Icon Size"),
                                    "param_name" => "icon_size",
                                    "value" => 32,
                                    "suffix" => "px",
                                    "group" => $thumbnail_tab
                                //"description" => $vc->l("Size of the thumbnails."),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Display Icon"),
                                    "param_name" => "icon_show",
                                    "value" => array(
                                        'Yes' => 'show',
                                        'No' => 'not-show',
                                    ),
                                    "description" => $vc->l("Select whether you want to show icon in information circle."),
                                    "group" => $information_tab
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Size"),
                                    "param_name" => "content_icon_size",
                                    "value" => "32",
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "icon_show", "value" => array("show")),
                                    "group" => $information_tab
                                //"description" => $vc->l("Select the icon size inside information circle."),	
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Background Color"),
                                    "param_name" => "content_bg",
                                    "value" => "",
                                    "group" => $information_tab
                                //"description" => $vc->l("Select the background color for information circle."),							
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Text Color"),
                                    "param_name" => "content_color",
                                    "value" => "",
                                    "group" => $information_tab
                                //"description" => $vc->l("Select the text color for information circle."),							
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Line Style"),
                                    "param_name" => "eg_br_style",
                                    "value" => array(
                                        "None" => "none",
                                        "Solid" => "solid",
                                        "Dashed" => "dashed",
                                        "Dotted" => "dotted",
                                    /* "Double" => "double",
                                      "Inset" => "inset",
                                      "Outset" => "outset", */
                                    ),
                                    "group" => $connector_tab
                                //"description" => $vc->l("Select the style for Thumbnail Connector."),							
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Line Width"),
                                    "param_name" => "eg_br_width",
                                    "value" => 1,
                                    "min" => 0,
                                    "max" => 10,
                                    "suffix" => "px",
                                    //"description" => $vc->l("Thickness of the Thumbnail Connector line."),
                                    "dependency" => Array("element" => "eg_br_style", "value" => array("solid", "dashed", "dotted")),
                                    "group" => $connector_tab
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Line Color"),
                                    "param_name" => "eg_border_color",
                                    "value" => "",
                                    //"description" => $vc->l("Select the color for thumbnail connector."),
                                    "dependency" => Array("element" => "eg_br_style", "value" => array("solid", "dashed", "dotted")),
                                    "group" => $connector_tab
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Border Style"),
                                    "param_name" => "cn_br_style",
                                    "value" => array(
                                        "None" => "none",
                                        "Solid" => "solid",
                                        "Dashed" => "dashed",
                                        "Dotted" => "dotted",
                                        "Double" => "double",
                                        "Inset" => "inset",
                                        "Outset" => "outset",
                                    ),
                                    "group" => $information_tab
                                //"description" => $vc->l("Select the border style for information circle."),							
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Width"),
                                    "param_name" => "cn_br_width",
                                    "value" => 1,
                                    "min" => 0,
                                    "max" => 10,
                                    "suffix" => "px",
                                    //"description" => $vc->l("Thickness of information Cirlce border."),	
                                    "dependency" => Array("element" => "cn_br_style", "value" => array("solid", "dashed", "dotted", "double", "inset", "outset")),
                                    "group" => $information_tab
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Border color"),
                                    "param_name" => "cn_border_color",
                                    "value" => "",
                                    //"description" => $vc->l("Border color of information circle."),	
                                    "dependency" => Array("element" => "cn_br_style", "value" => array("solid", "dashed", "dotted", "double", "inset", "outset")),
                                    "group" => $information_tab
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Appear Information Circle on"),
                                    "param_name" => "focus_on",
                                    "value" => array(
                                        'Hover' => 'hover',
                                        'Click' => 'click',
                                    //	'None' => '',
                                    ),
                                    "description" => $vc->l("Select on which event information should appear in information circle.")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Autoplay"),
                                    "param_name" => "auto_slide",
                                    "value" => array(
                                        "No" => "off",
                                        "Yes" => "on",
                                    ),
                                //"description" => $vc->l("Select whether information will be shown into circle."),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Autoplay Time"),
                                    "param_name" => "auto_slide_duration",
                                    "value" => 3,
                                    "suffix" => "seconds",
                                    "description" => $vc->l("Duration before info circle should display next information on thumbnails."),
                                    "dependency" => Array("element" => "auto_slide", "value" => array("on")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Animation of Active Thumbnail"),
                                    "param_name" => "highlight_style",
                                    "value" => array(
                                        "None" => 'info-circle-highlight-style',
                                        //"Buzz Out"=>"info-circle-buzz-out",
                                        "Zoom InOut" => "info-circle-pulse",
                                        "Zoom Out" => "info-circle-push",
                                        "Zoom In" => "info-circle-pop",
                                    //"Rotate"=>"info-circle-rotate",								
                                    ),
                                    "description" => $vc->l("Select animation style for active thumbnails."),
                                    "group" => $thumbnail_tab
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Animation of Thumbnails when Page Loads"),
                                    "param_name" => "icon_launch",
                                    "value" => array(
                                        "None" => '',
                                        "Linear" => "linear",
                                        "Elastic" => "easeOutElastic",
                                        "Bounce" => "easeOutBounce",
                                    ),
                                    "description" => $vc->l("Select Animation Style."),
                                    "group" => $thumbnail_tab
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Animation Duration"),
                                    "param_name" => "icon_launch_duration",
                                    "value" => 1,
                                    "suffix" => "seconds",
                                    "description" => $vc->l("Specify animation duration."),
                                    "dependency" => Array("element" => "icon_launch", "not_empty" => true),
                                    "group" => $thumbnail_tab
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Animation Delay"),
                                    "param_name" => "icon_launch_delay",
                                    "value" => .2,
                                    "suffix" => "seconds",
                                    "description" => $vc->l("Delay of animatin start in-between thumbnails."),
                                    "dependency" => Array("element" => "icon_launch", "not_empty" => true),
                                    "group" => $thumbnail_tab
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Responsive Nature"),
                                    "param_name" => "responsive",
                                    "value" => array(
                                        'True' => 'on',
                                        'False' => 'off',
                                    ),
                                    "description" => $vc->l("Select true to change its display style on low resolution."),
                                //"group" => $reponsive_tab			
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Breakpoint"),
                                    "param_name" => "responsive_breakpoint",
                                    "value" => "800",
                                    "suffix" => "px",
                                    //"description" => $vc->l("Select true to change its display style on low resolution."),
                                    "dependency" => Array("element" => "responsive", "value" => array("on")),
                                //"group" => $reponsive_tab			
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                    "description" => $vc->l("Custom class."),
                                ),
                                array(
                                    "type" => "ult_param_heading",
                                    "text" => $vc->l("Title Settings"),
                                    "param_name" => "title_typography",
                                    "group" => "Typography",
                                    "class" => "ult-param-heading",
                                    'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => $vc->l("Font Family"),
                                    "param_name" => "title_font",
                                    "group" => "Typography",
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => $vc->l("Font Style"),
                                    "param_name" => "title_font_style",
                                    "group" => "Typography",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "font-size",
                                    "heading" => $vc->l("Font Size"),
                                    "param_name" => "title_font_size",
                                    "value" => "",
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Line Height"),
                                    "param_name" => "title_line_height",
                                    "value" => "",
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ult_param_heading",
                                    "text" => $vc->l("Description Settings"),
                                    "param_name" => "desc_typography",
                                    "group" => "Typography",
                                    "class" => "ult-param-heading",
                                    'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => $vc->l("Font Family"),
                                    "param_name" => "desc_font",
                                    "group" => "Typography",
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => $vc->l("Font Style"),
                                    "param_name" => "desc_font_style",
                                    "group" => "Typography",
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "font-size",
                                    "heading" => $vc->l("Font Size"),
                                    "param_name" => "desc_font_size",
                                    "suffix" => "px",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Line Height"),
                                    "param_name" => "desc_line_height",
                                    "value" => "",
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "heading",
                                    "param_name" => "notification",
                                    'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
                                ),
                            ),
                            "js_view" => 'VcColumnView',
                ));
                // Add list item
                vc_map(
                        array(
                            "name" => $vc->l("Info Circle Item"),
                            "base" => "info_circle_item",
                            "class" => "vc_info_circle_item",
                            "icon" => "vc_info_circle_item",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "content_element" => true,
                            "as_child" => array('only' => 'info_circle'),
                            "params" => array(
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Title"),
                                    "param_name" => "info_title",
                                    "value" => "",
                                    "admin_label" => true,
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon to display"),
                                    "param_name" => "icon_type",
                                    "value" => array(
                                        "Font Icon Manager" => "selector",
                                        "Custom Image Icon" => "custom",
                                    ),
                                    "description" => $vc->l("Use <a href='admin.php?page=font-icon-Manager' target='_blank'>existing font icon</a> or upload a custom image."),
                                    "group" => $vc->l("Design")
                                ),
                                array(
                                    "type" => "icon_manager",
                                    "class" => "",
                                    "heading" => $vc->l("Select Icon For Information Circle & Thumbnail "),
                                    "param_name" => "info_icon",
                                    "value" => "",
                                    "description" => $vc->l("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=font-icon-Manager' target='_blank'>add new here</a>."),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                    "group" => $vc->l("Design")
                                ),
                                array(
                                    "type" => "attach_image",
                                    "class" => "",
                                    "heading" => $vc->l("Upload Image Icon"),
                                    "param_name" => "info_img",
                                    "admin_label" => true,
                                    "value" => "",
                                    "description" => $vc->l("Upload the custom image icon."),
                                    "dependency" => Array("element" => "icon_type", "value" => array("custom")),
                                    "group" => $vc->l("Design")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Background Color"),
                                    "param_name" => "icon_bg_color",
                                    "value" => "",
                                    "description" => $vc->l("Select the color for icon background."),
                                    "group" => $vc->l("Design")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Color"),
                                    "param_name" => "icon_color",
                                    "value" => "",
                                    "description" => $vc->l("Select the color for icon."),
                                    "group" => $vc->l("Design")
                                ),
                                array(
                                    "type" => "textarea_html",
                                    "class" => "",
                                    "heading" => $vc->l("Description"),
                                    "param_name" => "content",
                                    "value" => "",
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Border Style"),
                                    "param_name" => "icon_br_style",
                                    "value" => array(
                                        "None" => "none",
                                        "Solid" => "solid",
                                        "Dashed" => "dashed",
                                        "Dotted" => "dotted",
                                        "Double" => "double",
                                        "Inset" => "inset",
                                        "Outset" => "outset",
                                    ),
                                    "group" => $vc->l("Design")
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Thickness"),
                                    "param_name" => "icon_br_width",
                                    "value" => 1,
                                    "min" => 0,
                                    "max" => 10,
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "icon_br_style", "value" => array("solid", "dashed", "dotted", "double", "inset", "outset")),
                                    "group" => $vc->l("Design")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Border Color"),
                                    "param_name" => "icon_border_color",
                                    "value" => "",
                                    "dependency" => Array("element" => "icon_br_style", "value" => array("solid", "dashed", "dotted", "double", "inset", "outset")),
                                    "group" => $vc->l("Design")
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                    "description" => $vc->l("Custom class."),
                                ),
                            )
                        )
                );
            }//endif
        }

    }

}
if (class_exists('WPBakeryShortCodesContainer')) {
    
    class WPBakeryShortCode_info_circle extends WPBakeryShortCodesContainer { 
    }

    class WPBakeryShortCode_info_circle_item extends WPBakeryShortCode {
    }

}