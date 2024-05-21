<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_List_Link")) {

    class Nov_List_Link {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_list_link", array($this, "nov_list_link_shortcode"));
            JsComposer::add_shortcode('nov_list_link_item',array($this,'nov_list_link_item_shortcode'));

        }

        function nov_list_link_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_List_Link'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov List Link"),
                        "base" => "nov_list_link",
                        "class" => "vc_nov_list_link",
                        "icon" => "vc_nov_list_link",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a menu for List Link"),
                        "as_parent" => array('only' => 'nov_list_link_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "content_element" => true,
                        "show_settings_on_create" => true,
                        "js_view" => 'VcColumnView',
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'href',
                                'heading' => $vc->l('Title link'),
                                'param_name' => 'title_link',
                                'description' => $vc->l('Enter URL if you want this title to have a link.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Description'),
                                'param_name' => 'sub_title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Title Align'),
                                'param_name' => 'title_align',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => 'left',
                                    '2' => 'center',
                                    '3' => 'right'
                                ),
                                'description' => $vc->l('Select text alignment.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of restaurant menu.')
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => $vc->l('Image'),
                                'param_name' => 'icon_title',
                                'admin_label' => false,
                                'description' => $vc->l('Upload the image you want.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('style-1', 'style-2'))
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => $vc->l('Image hover'),
                                'param_name' => 'icon_hover',
                                'admin_label' => false,
                                'description' => $vc->l('Upload the image you want.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('style-1', 'style-2'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Right'),
                                'param_name' => 'border_right',
                                'description' => $vc->l( 'If checked row will be set to show border right.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'admin_label' => false,
                                "dependency" => array('element' => 'display_type', 'value' => array('style-1', 'style-2'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Extra class name'),
                                'param_name' => 'el_class',
                                'description' => $vc->l('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.')
                            ),
                        )
                    )
                );
                vc_map(
                    array(
                        "name" => $vc->l("List Link Item"),
                        "base" => "nov_list_link_item",
                        "class" => "vc_nov_list_link_item",
                        "icon" => "vc_nov_list_link_item",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a list link item"),
                        "as_child" => array('only' => 'nov_list_link'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'href',
                                'heading' => $vc->l('Link'),
                                'param_name' => 'link',
                                'admin_label' => true
                            ),
                        )
                    )
                );
            }
        }

        function nov_list_link_shortcode($atts, $content = null) {
            $output = $content_list_link = $title = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'title_link' => '',
                'title_align' => '',
                'icon_title' => '',
                'icon_hover' => '',
                'border_right' => '',
                'display_type' => '',
                'content_list_link' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $img_title = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon_title) . '" class="img-fluid img_cover" />';
            $img_hover = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon_hover) . '" class="img-fluid img_hover" />';

            $content_list_link = JsComposer::do_shortcode($content);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'title_link' => $title_link,
                    'title_align' => $title_align,
                    'icon_hover' => $icon_hover,
                    'img_title' => $img_title,
                    'img_hover' => $img_hover,
                    'border_right' => $border_right,
                    'content_list_link' => $content_list_link,
                    'display_type' => $display_type,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_List_Link/'. $display_type .'.tpl', 'novmanagevcaddons'));

            return $output;
        }
        function nov_list_link_item_shortcode($atts) {
            $output = $single_tab_title = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'link' => '',
            ), $atts));
            
            $output .='<li class="mb-5">';
            $output .='<a href="'.$link.'">'.$title.'</a>';
            $output .='</li>';

            return $output;
        }

    }
    // end class
    // new nov_list_link;
}

//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nov_list_link extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nov_list_link_item extends WPBakeryShortCode {
    }
}