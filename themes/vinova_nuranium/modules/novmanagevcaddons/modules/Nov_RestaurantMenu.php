<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_RestaurantMenu")) {

    class Nov_RestaurantMenu {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_restaurantmenu", array($this, "nov_restaurantmenu_shortcode"));
            JsComposer::add_shortcode('nov_restaurantmenu_item',array($this,'nov_restaurantmenu_item_shortcode'));

            Jscomposer::add_shortcode_param('nov_textfield_group', array($this, 'nov_textfield_group_param'), "");
        }

        function nov_textfield_group_param($settings, $value) {
            $dependency = vc_generate_dependencies_attributes($settings);
            //$querys = $settings['query'];

            $html = '<div class="input-group">';
              $html .= '<input type="text" name="' . $settings['param_name'] . '" class="wpb_vc_param_value form-control ' . $settings['param_name'] . ' ' . $settings['type'] . '_field">';
              $html .= '<span class="input-group-addon">$</span>';
            $html .= '</div>';
            return $html;
        }

        function nov_restaurantmenu_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_RestaurantMenu'), 'Style');

            $currency = Context::getContext()->currency;

            //echo("<prev>").print_r($currency->sign,1);die();

            $screennumber = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            );

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Restaurant Menu"),
                        "base" => "nov_restaurantmenu",
                        "class" => "vc_nov_restaurantmenu",
                        "icon" => "vc_nov_restaurantmenu",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a menu for restaurant"),
                        "as_parent" => array('only' => 'nov_restaurantmenu_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
                                'heading' => $vc->l('Sub title'),
                                'param_name' => 'sub_title'
                            ),
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => $vc->l('Icon Title'),
                                'param_name' => 'icon_title',
                                'value' => '',
                                'description' => $vc->l('Upload the image you want.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of restaurant menu.')
                            )  ,
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
                        "name" => $vc->l("Restaurant Menu Item"),
                        "base" => "nov_restaurantmenu_item",
                        "class" => "vc_nov_restaurantmenu_item",
                        "icon" => "vc_nov_restaurantmenu_item",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a restaurant menu item"),
                        "as_child" => array('only' => 'nov_restaurantmenu'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Description'),
                                'param_name' => 'desc',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'nov_textfield_group',
                                'heading' => $vc->l('Price'),
                                'param_name' => 'price',
                                'currency' => $currency->sign,
                                'options' => array()
                            )
                        )
                    )
                );
            }
        }

        function nov_restaurantmenu_shortcode($atts, $content = null) {
            $output = $content_restaurantmenu = $title = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'icon_title' => '',
                'display_type' => '',
                'content_restaurantmenu' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $content_restaurantmenu = JsComposer::do_shortcode($content);
            $img_title = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon_title) . '" class="img-fluid" />';

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'img_title' => $img_title,
                    'content_restaurantmenu' => $content_restaurantmenu,
                    'display_type' => $display_type,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_RestaurantMenu/'. $display_type .'.tpl', 'novmanagevcaddons'));

            return $output;
        }
        function nov_restaurantmenu_item_shortcode($atts) {
            $output = $single_tab_title = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'desc' => '',
                'price' => '',
            ), $atts));

            $currency = Context::getContext()->currency;
            $price = Tools::displayPrice(Tools::convertPrice($price, $currency), $currency);


            $output ='<div class="restaurantmenu-item col-md-6 mb-38">';
            $output .='<div class="d-flex align-items-center justify-content-between mb-7 group-top">';
            $output .='<div class="restaurantmenu-name">'.$title.'</div>';
            $output .='<div class="restaurantmenu-price">'.$price.'</div>';
            $output .='</div>';
            $output .='<div class="restaurantmenu-desc">'.$desc.'</div>';
            $output .='</div>';

            return $output;
        }

    }
    // end class
    // new nov_socials;
}

//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nov_restaurantmenu extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nov_restaurantmenu_item extends WPBakeryShortCode {
    }
}