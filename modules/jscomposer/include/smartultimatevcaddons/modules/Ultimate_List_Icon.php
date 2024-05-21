<?php

/*
 * Add-on Name: Icons Block for Visual Composer
 */
if (!class_exists('Ultimate_List_Icon')) {

    class Ultimate_List_Icon {

        function __construct() {
            // 	add_action('admin_init',array($this,'list_icon_init'));
            JsComposer::add_shortcode('ultimate_icon_list', array($this, 'ultimate_icon_list_shortcode'));
            JsComposer::add_shortcode('ultimate_icon_list_item', array($this, 'icon_list_item_shortcode'));
        }

        function list_icon_init() {
            $vc = vc_manager();
            if (function_exists('vc_map')) {
                vc_map(
                        array(
                            "name" => $vc->l("List Icon"),
                            "base" => "ultimate_icon_list",
                            "class" => "ultimate_icon_list",
                            "icon" => "ultimate_icon_list",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "description" => $vc->l("Add a set of multiple icons and give some custom style."),
                            "as_parent" => array('only' => 'ultimate_icon_list_item'),
                            "content_element" => true,
                            "show_settings_on_create" => true,
                            "js_view" => 'VcColumnView',
                            "params" => array(
                                // Play with icon selector
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
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Space after Icon"),
                                    "param_name" => "icon_margin",
                                    "value" => 5,
                                    "min" => 0,
                                    "max" => 100,
                                    "suffix" => "px",
                                    "description" => $vc->l("How much distance would you like in two icons?"),
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                    "description" => $vc->l("Write your own CSS and mention the class name here.", "flip-box"),
                                ),
                            )
                        )
                );
                vc_map(
                        array(
                            "name" => $vc->l("List Icon Item"),
                            "base" => "ultimate_icon_list_item",
                            "class" => "icon_list_item",
                            "icon" => "icon_list_item",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "description" => $vc->l("Add a list of icons with some content and give some custom style."),
                            "as_child" => array('only' => 'ultimate_icon_list'),
                            "show_settings_on_create" => true,
                            "params" => array(
                                // Play with icon selector
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
                                    "description" => $vc->l("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=font-icon-Manager' target='_blank'>add new here</a>.", "flip-box"),
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
                                    "description" => $vc->l("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options."),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
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
                                    "description" => $vc->l("0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels)."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Background Size"),
                                    "param_name" => "icon_border_spacing",
                                    "value" => 50,
                                    "min" => 30,
                                    "max" => 500,
                                    "suffix" => "px",
                                    "description" => $vc->l("Spacing from center of the icon till the boundary of border / background"),
                                    "dependency" => Array("element" => "icon_style", "value" => array("advanced")),
                                ),
                                array(
                                    "type" => "textarea_html",
                                    "class" => "",
                                    "heading" => $vc->l("List content"),
                                    "param_name" => "content",
                                    "value" => "",
                                    "description" => $vc->l("Enter the list content here."),
                                    "group" => "List Content"
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Custom CSS Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                    "description" => $vc->l("Ran out of options? Need more styles? Write your own CSS and mention the class name here."),
                                ),
                            ),
                        )
                );
            }
        }

        // Shortcode handler function for list Icon
        function ultimate_icon_list_shortcode($atts, $content = null) {
            global $vc_list_icon_size, $vc_list_icon_margin;
            Context::getContext()->controller->addJS(jscomposer::plugins_url('assets/min-js/custom.min.js'));
            $el_class = '';
            extract(JsComposer::shortcode_atts(array(
                        "icon_size" => "",
                        "icon_margin" => "",
                        "el_class" => ""
                            ), $atts));

            $vc_list_icon_size = $icon_size;
            $vc_list_icon_margin = $icon_margin;
            // enqueue js
            //wp_enqueue_script('aio-tooltip',plugins_url('../assets/min-js/',__FILE__).'tooltip.min.js',array('jquery'));

            $output = '<div class="uavc-list-icon ' . $el_class . '">';
            $output .= '<ul class="uavc-list">';
            $output .= JsComposer::do_shortcode($content);
            $output .= '</ul>';
            $output .= '</div>';

            return $output;
        }

        function icon_list_item_shortcode($atts, $content = null) {

            $icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $tooltip_disp = $tooltip_text = $icon_margin = '';
            extract(JsComposer::shortcode_atts(array(
                        'icon_type' => '',
                        'icon' => '',
                        'icon_img' => '',
                        'icon_color' => '',
                        'icon_style' => '',
                        'icon_color_bg' => '',
                        'icon_color_border' => '',
                        'icon_border_style' => '',
                        'icon_border_size' => '',
                        'icon_border_radius' => '',
                        'icon_border_spacing' => '',
                        "icon_size" => "",
                        "icon_margin" => "",
                        'el_class' => '',
                            ), $atts));

            global $vc_list_icon_size, $vc_list_icon_margin;
            if (empty($icon_size))
                $icon_size = $vc_list_icon_size;

            if (empty($icon_margin))
                $icon_margin = $vc_list_icon_margin;

            if ($icon_animation !== 'none') {
                $css_trans = 'data-animation="' . $icon_animation . '" data-animation-delay="03"';
            }
            $output = $style = $link_sufix = $link_prefix = $target = $href = $icon_align_style = '';

            if ($icon_margin !== '')
                $style .= 'margin-right:' . $icon_margin . 'px;';

            $icon_animation = $icon_link = '';

            $output .= '<div class="uavc-list-content">';

            if ($icon !== "" || $icon_img !== '') {
                if ($icon_type == 'custom') {
                    $icon_style = 'none';
                }
                $main_icon = JsComposer::do_shortcode('[just_icon icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $icon_size . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_link="' . $icon_link . '" icon_animation="' . $icon_animation . '"]');
                $output .= "\n" . '<div class="uavc-list-icon ' . $el_class . '" ' . $css_trans . ' style="' . $style . '">';
                $output .= $main_icon;
                $output .= "\n" . '</div>';
            }
            $output .= '<span class="uavc-list-desc">' . JsComposer::do_shortcode($content) . '</span>';
            $output .= '</div>';

            $output = '<li>' . $output . '</li>';
            return $output;
        }

    }

}
// if(class_exists('Ultimate_List_Icon'))
// {
// 	$Ultimate_List_Icon = new Ultimate_List_Icon;
// }
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_ultimate_icon_list extends WPBakeryShortCodesContainer {
        
    }

}
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_ultimate_icon_list_item extends WPBakeryShortCode {
        
    }

}