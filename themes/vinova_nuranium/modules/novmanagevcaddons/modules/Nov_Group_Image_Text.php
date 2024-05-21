<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Group_Image_Text")) {

    class Nov_Group_Image_Text {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_group_image_text", array($this, "nov_group_image_text_shortcode"));
            JsComposer::add_shortcode('nov_group_image_text_item',array($this,'nov_group_image_text_item_shortcode'));
        }

        function nov_group_image_text_init() {
            $vc = vc_manager();

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Group Image Text"),
                        "base" => "nov_group_image_text",
                        "class" => "vc_nov_group_image_text",
                        "icon" => "vc_nov_group_image_text",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a item"),
                        "as_parent" => array('only' => 'nov_group_image_text_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
                                'type' => 'textfield',
                                'heading' => $vc->l('Text Link'),
                                'param_name' => 'text_link'
                            ),
                            array(
                                'type' => 'href',
                                'heading' => $vc->l('Link'),
                                'param_name' => 'header_link',
                                'description' => $vc->l('Enter URL if you want have a link.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Style'),
                                'param_name' => 'style',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2'
                                )
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Spacing'),
                                'param_name' => 'spacing',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '5px' => '5',
                                    '10px' => '10',
                                    '15px' => '15',
                                    '20px' => '20',
                                    '25px' => '25',
                                    '30px' => '30'
                                )
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
                        "name" => $vc->l("Nov Group Image Text Item"),
                        "base" => "nov_group_image_text_item",
                        "class" => "vc_nov_group_image_text_item",
                        "icon" => "vc_nov_group_image_text_item",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a item"),
                        "as_child" => array('only' => 'nov_group_image_text'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => $vc->l('Image'),
                                'param_name' => 'image',
                                'value' => '',
                                'description' => $vc->l('Upload the image')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Text'),
                                'param_name' => 'text',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'href',
                                'heading' => $vc->l('Link text'),
                                'param_name' => 'link_text',
                                'description' => $vc->l('Enter URL if you want have a link.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Extra class name'),
                                'param_name' => 'nv_class',
                                'description' => $vc->l('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.')
                            ),
                            array(
                              'type' => 'dropdown',
                              'heading' => $vc->l('Col Lager Desktop'),
                              'param_name' => 'col_xl',
                              'std' => 'col-xl-6',
                              'value' => array(
                                '2 column - 1/6' => 'col-xl-2',
                                '3 column - 1/4' => 'col-xl-3',
                                '4 column - 1/3' => 'col-xl-4',
                                '6 column - 1/2' => 'col-xl-6',
                                '12 column - 1/1' => 'col-xl-12'
                              ),
                              'group' => $vc->l('Responsive')
                            ),
                            array(
                              'type' => 'dropdown',
                              'heading' => $vc->l('Col Desktop'),
                              'param_name' => 'col_lg',
                              'std' => 'col-lg-6',
                              'value' => array(
                                '2 column - 1/6' => 'col-lg-2',
                                '3 column - 1/4' => 'col-lg-3',
                                '4 column - 1/3' => 'col-lg-4',
                                '6 column - 1/2' => 'col-lg-6',
                                '12 column - 1/1' => 'col-lg-12'
                              ),
                              'group' => $vc->l('Responsive')
                            ),
                            array(
                              'type' => 'dropdown',
                              'heading' => $vc->l('Col Tablet'),
                              'param_name' => 'col_md',
                              'std' => 'col-md-6',
                              'value' => array(
                                '2 column - 1/6' => 'col-md-2',
                                '3 column - 1/4' => 'col-md-3',
                                '4 column - 1/3' => 'col-md-4',
                                '6 column - 1/2' => 'col-md-6',
                                '12 column - 1/1' => 'col-md-12'
                              ),
                              'group' => $vc->l('Responsive')
                            ),
                            array(
                              'type' => 'dropdown',
                              'heading' => $vc->l('Col Mobile'),
                              'param_name' => 'col_xs',
                              'std' => 'col-xs-12',
                              'value' => array(
                                '3 column - 1/4' => 'col-xs-3',
                                '4 column - 1/3' => 'col-xs-4',
                                '6 column - 1/2' => 'col-xs-6',
                                '12 column - 1/1' => 'col-xs-12'
                              ),
                              'group' => $vc->l('Responsive')
                            ),
                        )
                    )
                );
            }
        }

        function nov_group_image_text_shortcode($atts, $content = null) {
            $output = $content_group_image_text = $title = $text_link = $header_link = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'text_link' => '',
                'spacing' => '',
                'style' => '',
                'header_link' => '',
                'content_group_image_text' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $content_group_image_text = JsComposer::do_shortcode($content);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'text_link' => $text_link,
                    'style' => $style,
                    'header_link' => $header_link,
                    'spacing' => $spacing,
                    'content_group_image_text' => $content_group_image_text,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Group_Image_Text/default.tpl', 'novmanagevcaddons'));

            return $output;
        }
        function nov_group_image_text_item_shortcode($atts, $content = null) {
            $output = $group_image_text_content = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'image' => '',
                'text' => '',
                'link_text' => '',
                'col_xl' => '',
                'col_lg' => '',
                'col_md' => '',
                'col_xs' => '',
                'nv_class' => '',
                'group_image_text_content' => '',
            ), $atts));


            $img = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($image) . '" class="img-fluid" />';

            $element_class = '';
            $element_class .= $col_xl.' '.$col_lg.' '.$col_md.' '.$col_xs;
            if (isset($nv_class) && $nv_class == true) {
                $element_class .= ' '.$nv_class.'';
            }


            $output .='<div class="'.$element_class.'">';
            $output .='<div class="position-relative item">';
            $output .='<a href="'.$link_text.'"><span>'.$img.'</span></a>';
            $output .='<a class="position-absolute" href="'.$link_text.'">'.$text.'</a>';
            $output .='</div>';
            $output .='</div>';

            return $output;
        }
    }
    // end class
    // new nov_our_team;
}

//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nov_group_image_text extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nov_group_image_text_item extends WPBakeryShortCode {
    }
}