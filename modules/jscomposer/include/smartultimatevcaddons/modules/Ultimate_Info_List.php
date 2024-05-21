<?php

/*
 * Add-on Name: Info List for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if (!class_exists('AIO_Info_list')) {

    class AIO_Info_list {

        var $connector_animate;
        var $connect_color;
        var $icon_font;
        var $border_col;
        var $icon_style;

        function __construct() {
            $this->connector_animate = '';
            $this->connect_color = '';
            $this->icon_style = '';
            $this->icon_style = '';
            $this->context = Context::getContext();
            /* 	add_action('admin_init', array($this, 'add_info_list')); */

            if (function_exists('vc_is_inline')) {
                if (!vc_is_inline()) {
                    JsComposer::add_shortcode('info_list', array(&$this, 'info_list'));
                    JsComposer::add_shortcode('info_list_item', array(&$this, 'info_list_item'));
                }
            } else {
                JsComposer::add_shortcode('info_list', array(&$this, 'info_list'));
                JsComposer::add_shortcode('info_list_item', array(&$this, 'info_list_item'));
            }
        }

        function info_list($atts, $content = null) {
            $position = $style = $icon_color = $icon_bg_color = $connector_animation = $font_size_icon = $icon_border_style = $icon_border_size = $connector_color = $border_color = $el_class = $info_list_link_html = '';
            extract(JsComposer::shortcode_atts(array(
                        'position' => '',
                        'style' => '',
                        'connector_animation' => '',
                        'icon_color' => '',
                        'icon_bg_color' => '',
                        'connector_color' => '',
                        'border_color' => '',
                        'font_size_icon' => '24',
                        'icon_border_style' => '',
                        'icon_border_size' => '',
                        'el_class' => '',
                            ), $atts));

            $this->connect_color = $connector_color;
            $this->border_col = $border_color;
            if ($style == 'square with_bg' || $style == 'circle with_bg' || $style == 'hexagon') {
                $this->icon_font = 'font-size:' . ($font_size_icon * 3) . 'px;';

                if ($icon_border_size !== '') {
                    $this->icon_style .= 'font-size:' . $font_size_icon . 'px;';
                    $this->icon_style .= 'border-width:0px;';
                    $this->icon_style .= 'border-style:none;';
                    $this->icon_style .= 'background:' . $icon_bg_color . ';';
                    $this->icon_style .= 'color:' . $icon_color . ';';
                    if ($style == "hexagon")
                        $this->icon_style .= 'border-color:' . $icon_bg_color . ';';
                    else
                        $this->icon_style .= 'border-color:' . $border_color . ';';
                }
            } else {
                $big_size = ($font_size_icon * 3) + ($icon_border_size * 2);
                if ($icon_border_size !== '') {
                    $this->icon_font = 'font-size:' . $big_size . 'px;';
                    $this->icon_style .= 'font-size:' . $font_size_icon . 'px;';
                    $this->icon_style .= 'border-width:' . $icon_border_size . 'px;';
                    $this->icon_style .= 'border-style:' . $icon_border_style . ';';
                    $this->icon_style .= 'color:' . $icon_color . ';';
                    $this->icon_style .= 'border-color:' . $border_color . ';';
                }
            }
            if ($position == "top")
                $this->connector_animate = "fadeInLeft";
            else
                $this->connector_animate = $connector_animation;
            $output = '<div class="smile_icon_list_wrap ' . $el_class . '">';
            $output .= '<ul class="smile_icon_list ' . $position . ' ' . $style . '">';
            $output .= JsComposer::do_shortcode($content);
            $output .= '</ul>';
            $output .= '</div>';
            return $output;
        }

        function info_list_item($atts, $content = null) {
            // Do nothing
            $list_title = $list_icon = $animation = $icon_color = $icon_bg_color = $icon_img = $icon_type = $desc_font_line_height = $title_font_line_height = '';
            $title_font = $title_font_style = $title_font_size = $title_font_color = $desc_font = $desc_font_style = $desc_font_size = $desc_font_color = '';
            extract(JsComposer::shortcode_atts(array(
                        'list_title' => '',
                        'animation' => '',
                        'list_icon' => '',
                        'icon_img' => '',
                        'icon_type' => '',
                        'title_font' => '',
                        'title_font_style' => '',
                        'title_font_size' => '16',
                        'title_font_line_height' => '24',
                        'title_font_color' => '',
                        'desc_font' => '',
                        'desc_font_style' => '',
                        'desc_font_size' => '13',
                        'desc_font_color' => '',
                        'desc_font_line_height' => '18',
                        'info_list_link' => '',
                        'info_list_link_apply' => '',
                            ), $atts));
            //$content =  wpb_js_remove_wpautop($content);
            $css_trans = $style = $ico_col = $connector_trans = $icon_html = $title_style = $desc_style = $info_list_link_html = '';
            $font_args = array();

            $is_link = false;

            if ($info_list_link != '') {
                $info_list_link_temp = vc_build_link($info_list_link);
                $url = $info_list_link_temp['url'];
                $title = $info_list_link_temp['title'];
                $target = $info_list_link_temp['target'];
                if ($url != '') {
                    if ($target != '')
                        $target = 'target="' . $target . '"';
                    $info_list_link_html = '<a href="' . $url . '" class="ulimate-info-list-link" ' . $target . '></a>';
                }
                $is_link = true;
            }

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
            if ($title_font_color != '')
                $title_style .= 'color:' . $title_font_color . ';';

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

            if ($animation !== 'none') {
                $css_trans = 'data-animation="' . $animation . '" data-animation-delay="03"';
            }
            if ($this->connector_animate) {
                $connector_trans = 'data-animation="' . $this->connector_animate . '" data-animation-delay="02"';
            }
            if ($icon_color != '') {
                $ico_col = 'style="color:' . $icon_color . '";';
            }
            if ($icon_bg_color != '') {
                $style .= 'background:' . $icon_bg_color . ';  color:' . $icon_bg_color . ';';
            }
            if ($icon_bg_color != '') {
                $style .= 'border-color:' . $this->border_col . ';';
            }
            if ($icon_type == "selector") {
                $icon_html .= '<div class="icon_list_icon" ' . $css_trans . ' style="' . $this->icon_style . '">';
                $icon_html .= '<i class="' . $list_icon . '" ' . $ico_col . '></i>';
                if ($is_link && $info_list_link_apply == 'icon')
                    $icon_html .= $info_list_link_html;
                $icon_html .= '</div>';
            } else {

//				$img = wp_get_attachment_image_src( $icon_img, 'large');
                $img = JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon_img);
                $icon_html .= '<div class="icon_list_icon" ' . $css_trans . ' style="' . $this->icon_style . '">';
                $icon_html .= '<img class="list-img-icon" alt="icon" src="' . $img . '"/>';
                if ($is_link && $info_list_link_apply == 'icon')
                    $icon_html .= $info_list_link_html;
                $icon_html .= '</div>';
            }
            $output = '<li class="icon_list_item" style=" ' . $this->icon_font . '">';
            $output .= $icon_html;
            $output .= '<div class="icon_description">';
            if ($list_title != '') {
                $output .= '<h3 style="' . $title_style . '">';
                if ($is_link && $info_list_link_apply == 'title')
                    $output .= '<a href="' . $url . '" target="' . $target . '">' . $list_title . '</a>';
                else
                    $output .= $list_title;
                $output .= '</h3>';
            }
            $output .= '<div class="icon_description_text" style="' . $desc_style . '">' . wpb_js_remove_wpautop($content, true) . '</div>';
            $output .= '</div>';
            $output .= '<div class="icon_list_connector" ' . $connector_trans . ' style="border-color:' . $this->connect_color . ';"></div>';
            if ($is_link && $info_list_link_apply == 'container')
                $output .= $info_list_link_html;
            $output .= '</li>';
            return $output;
        }

        // Shortcode Functions for frontend editor
        function front_info_list($atts, $content = null) {
            // Do nothing
            $position = $style = $icon_color = $icon_bg_color = $connector_animation = $font_size_icon = $icon_border_style = $icon_border_size = $connector_color = $border_color = $el_class = '';
            extract(JsComposer::shortcode_atts(array(
                        'position' => '',
                        'style' => '',
                        'connector_animation' => '',
                        'icon_color' => '',
                        'icon_bg_color' => '',
                        'connector_color' => '',
                        'border_color' => '',
                        'font_size_icon' => '24',
                        'icon_border_style' => '',
                        'icon_border_size' => '',
                        'el_class' => '',
                            ), $atts));
            $this->connect_color = $connector_color;
            $this->border_col = $border_color;
            if ($style == 'square with_bg' || $style == 'circle with_bg' || $style == 'hexagon') {
                $this->icon_font = 'font-size:' . ($font_size_icon * 3) . 'px;';
                if ($icon_border_size !== '') {
                    $this->icon_style = 'font-size:' . $font_size_icon . 'px;';
                    $this->icon_style .= 'border-width:0px;';
                    $this->icon_style .= 'border-style:none;';
                    $this->icon_style .= 'background:' . $icon_bg_color . ';';
                    $this->icon_style .= 'color:' . $icon_color . ';';
                    if ($style == "hexagon")
                        $this->icon_style .= 'border-color:' . $icon_bg_color . ';';
                    else
                        $this->icon_style .= 'border-color:' . $border_color . ';';
                }
            } else {
                $big_size = ($font_size_icon * 3) + ($icon_border_size * 2);
                if ($icon_border_size !== '') {
                    $this->icon_font = 'font-size:' . $big_size . 'px;';
                    $this->icon_style = 'font-size:' . $font_size_icon . 'px;';
                    $this->icon_style .= 'border-width:' . $icon_border_size . 'px;';
                    $this->icon_style .= 'border-style:' . $icon_border_style . ';';
                    $this->icon_style .= 'color:' . $icon_color . ';';
                    $this->icon_style .= 'border-color:' . $border_color . ';';
                }
            }
            if ($position == "top")
                $this->connector_animate = "fadeInLeft";
            else
                $this->connector_animate = $connector_animation;
            $output = '<div class="smile_icon_list_wrap ' . $el_class . '">';
            $output .= '<ul class="smile_icon_list ' . $position . ' ' . $style . '" data-style="' . $this->icon_style . '" data-fonts="' . $this->icon_font . '" data-connector="' . $connector_color . '">';
            $output .= JsComposer::do_shortcode($content);
            $output .= '</ul>';
            $output .= '</div>';
            return $output;
        }

        function front_info_list_item($atts, $content = null) {
            // Do nothing
            $list_title = $list_icon = $animation = $icon_color = $icon_bg_color = $icon_img = $icon_type = '';
            extract(JsComposer::shortcode_atts(array(
                        'list_title' => '',
                        'animation' => '',
                        'list_icon' => '',
                        'icon_img' => '',
                        'icon_type' => '',
                            ), $atts));
            //$content =  wpb_js_remove_wpautop($content);
            $css_trans = $style = $ico_col = $connector_trans = $icon_html = '';
            if ($animation !== 'none') {
                $css_trans = 'data-animation="' . $animation . '" data-animation-delay="03"';
            }
            if ($this->connector_animate) {
                $connector_trans = 'data-animation="' . $this->connector_animate . '" data-animation-delay="02"';
            }
            if ($icon_color != '') {
                $ico_col = 'style="color:' . $icon_color . '";';
            }
            if ($icon_bg_color != '') {
                $style .= 'background:' . $icon_bg_color . ';  color:' . $icon_bg_color . ';';
            }
            if ($icon_bg_color != '') {
                $style .= 'border-color:' . $this->border_col . ';';
            }
            if ($icon_type == "selector") {
                $icon_html .= '<div class="icon_list_icon" ' . $css_trans . '>';
                $icon_html .= '<i class="' . $list_icon . '" ' . $ico_col . '></i>';
                $icon_html .= '</div>';
            } else {
                // $img = wp_get_attachment_image_src( $icon_img, 'large');
                $img = JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon_img);
                $icon_html .= '<div class="icon_list_icon" ' . $css_trans . '>';
                $icon_html .= '<img class="list-img-icon" alt="icon" src="' . $img[0] . '"/>';
                $icon_html .= '</div>';
            }
            $output = '<li class="icon_list_item">';
            $output .= $icon_html;
            $output .= '<div class="icon_description">';
            $output .= '<h3>' . $list_title . '</h3>';
            $output .= wpb_js_remove_wpautop($content, true);
            $output .= '</div>';
            $output .= '<div class="icon_list_connector" ' . $connector_trans . ' style="border-color:' . $this->connect_color . ';"></div>';
            $output .= '</li>';
            return $output;
        }

        function add_info_list() {
            $vc = vc_manager();
            if (function_exists('vc_map')) {
                vc_map(
                        array(
                            "name" => $vc->l("Info List"),
                            "base" => "info_list",
                            "class" => "vc_info_list",
                            "icon" => "vc_icon_list",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "as_parent" => array('only' => 'info_list_item'),
                            "description" => $vc->l("Text blocks connected together in one list."),
                            "content_element" => true,
                            "show_settings_on_create" => true,
                            "params" => array(
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon or Image Position"),
                                    "param_name" => "position",
                                    "value" => array(
                                        'Icon to the Left' => 'left',
                                        'Icon to the Right' => 'right',
                                        'Icon at Top' => 'top',
                                    ),
                                    "description" => $vc->l("Select the icon position for icon list.")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Style of Image or Icon + Color"),
                                    "param_name" => "style",
                                    "value" => array(
                                        'Square With Background' => 'square with_bg',
                                        'Square Without Background' => 'square no_bg',
                                        'Circle With Background' => 'circle with_bg',
                                        'Circle Without Background' => 'circle no_bg',
                                        'Hexagon With Background' => 'hexagon',
                                    ),
                                    "description" => $vc->l("Select the icon style for icon list.")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Border Style"),
                                    "param_name" => "icon_border_style",
                                    "value" => array(
                                        "None" => "none",
                                        "Solid" => "solid",
                                        "Dashed" => "dashed",
                                        "Dotted" => "dotted",
                                        "Double" => "double",
                                        "Inset" => "inset",
                                        "Outset" => "outset",
                                    ),
                                    "description" => $vc->l("Select the border style for icon."),
                                    "dependency" => Array("element" => "style", "value" => array("square no_bg", "circle no_bg")),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Width"),
                                    "param_name" => "icon_border_size",
                                    "value" => 1,
                                    "min" => 0,
                                    "max" => 10,
                                    "suffix" => "px",
                                    "description" => $vc->l("Thickness of the border."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Border Color:"),
                                    "param_name" => "border_color",
                                    "value" => "#333333",
                                    "description" => $vc->l("Select the color border."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Connector Line Color:"),
                                    "param_name" => "connector_color",
                                    "value" => "#333333",
                                    "description" => $vc->l("Select the color for connector line."),
                                    "group" => "Connector"
                                ),
                                array(
                                    "type" => "checkbox",
                                    "class" => "",
                                    "heading" => $vc->l("Connector Line Animation: "),
                                    "param_name" => "connector_animation",
                                    "value" => array(
                                        'Enabled' => 'fadeInUp',
                                    ),
                                    "description" => $vc->l("Select wheather to animate connector or not"),
                                    "group" => "Connector"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Background Color:"),
                                    "param_name" => "icon_bg_color",
                                    "value" => "#ffffff",
                                    "description" => $vc->l("Select the color for icon background."),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Color:"),
                                    "param_name" => "icon_color",
                                    "value" => "#333333",
                                    "description" => $vc->l("Select the color for icon."),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Font Size"),
                                    "param_name" => "font_size_icon",
                                    "value" => 24,
                                    "min" => 12,
                                    "max" => 72,
                                    "suffix" => "px",
                                    "description" => $vc->l("Enter value in pixels.")
                                ),
                                // Customize everything
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                    "description" => $vc->l("Add extra class name that will be applied to the info list, and you can use this class for your customizations."),
                                ),
                                array(
                                    "type" => "heading",
                                    "sub_heading" => "<span style='display: block;'><a href='http://bsf.io/v9k0x' target='_blank'>Watch Video Tutorial &nbsp; <span class='icon icon-youtube-play' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
                                    "param_name" => "notification",
                                    'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
                                )
                            ),
                            "js_view" => 'VcColumnView'
                ));
                // Add list item
                vc_map(
                        array(
                            "name" => $vc->l("Info List Item"),
                            "base" => "info_list_item",
                            "class" => "vc_info_list",
                            "icon" => "vc_icon_list",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "content_element" => true,
                            "as_child" => array('only' => 'info_list'),
                            "params" => array(
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Title"),
                                    "admin_label" => true,
                                    "param_name" => "list_title",
                                    "value" => "",
                                    "description" => $vc->l("Provide a title for this icon list item.")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon to display:"),
                                    "param_name" => "icon_type",
                                    "value" => array(
                                        "Font Icon Manager" => "selector",
                                        "Custom Image Icon" => "custom",
                                    ),
                                    "description" => $vc->l("Use <a href='admin.php?page=font-icon-Manager' target='_blank'>existing font icon</a> or upload a custom image.")
                                ),
                                array(
                                    "type" => "icon_manager",
                                    "class" => "",
                                    "heading" => $vc->l("Select List Icon "),
                                    "param_name" => "list_icon",
                                    "value" => "",
                                    "description" => $vc->l("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=font-icon-Manager' target='_blank'>add new here</a>."),
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
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Animation"),
                                    "param_name" => "animation",
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
                                    "description" => $vc->l("Select the animation style for icon.")
                                ),
                                array(
                                    "type" => "textarea_html",
                                    "class" => "",
                                    "heading" => $vc->l("Description"),
                                    "param_name" => "content",
                                    "value" => "",
                                    "description" => $vc->l("Description about this list item")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "heading" => "Apply link To",
                                    "param_name" => "info_list_link_apply",
                                    "value" => array(
                                        "No Link" => "no-link",
                                        "Complete Container" => "container",
                                        "List Title" => "title",
                                        "Icon" => "icon"
                                    )
                                ),
                                array(
                                    "type" => "vc_link",
                                    "heading" => "Link",
                                    "param_name" => "info_list_link",
                                    "dependency" => array("element" => "info_list_link_apply", "value" => array("container", "title", "icon"))
                                ),
                                array(
                                    "type" => "ult_param_heading",
                                    "param_name" => "title_text_typography",
                                    "text" => $vc->l("Title settings"),
                                    "value" => "",
                                    "group" => "Typography",
                                    "class" => "ult-param-heading",
                                    'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
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
                                    "value" => "16",
                                    "suffix" => "px",
                                    "min" => 10,
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "title_font_line_height",
                                    "heading" => "Font Line Height",
                                    "value" => "24",
                                    "suffix" => "px",
                                    "min" => 10,
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "param_name" => "title_font_color",
                                    "heading" => "Color",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ult_param_heading",
                                    "param_name" => "desc_text_typography",
                                    "text" => $vc->l("Description settings"),
                                    "value" => "",
                                    "group" => "Typography",
                                    "class" => "ult-param-heading",
                                    'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
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
                                    "value" => "13",
                                    "suffix" => "px",
                                    "min" => 10,
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "desc_font_line_height",
                                    "heading" => "Font Line Height",
                                    "value" => "18",
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
                            )
                        )
                );
            }//endif
        }

    }

}
global $AIO_Info_list; // WPB: Beter to create singleton in AIO_Info_list I think, but it also work
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_info_list extends WPBakeryShortCodesContainer {

        function content($atts, $content = null) {
            global $AIO_Info_list;
            return $AIO_Info_list->front_info_list($atts, $content);
        }

    }

    class WPBakeryShortCode_info_list_item extends WPBakeryShortCode {

        function content($atts, $content = null) {
            global $AIO_Info_list;
            return $AIO_Info_list->front_info_list_item($atts, $content);
        }

    }

}
 if(class_exists('AIO_Info_list'))
 {
 	$AIO_Info_list = new AIO_Info_list;
 }