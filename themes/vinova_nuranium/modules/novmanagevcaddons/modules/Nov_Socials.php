<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Socials")) {

    class Nov_Socials {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_socials", array($this, "nov_socials_shortcode"));
            JsComposer::add_shortcode('nov_social_item',array($this,'nov_social_item_shortcode'));
        }

        function nov_socials_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Socials'), 'Style');

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
                        "name" => $vc->l("Nov Socials"),
                        "base" => "nov_socials",
                        "class" => "vc_nov_socials",
                        "icon" => "vc_nov_socials",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a socials list"),
                        "as_parent" => array('only' => 'nov_social_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of social list.')
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
                        "name" => $vc->l("Nov Social Item"),
                        "base" => "nov_social_item",
                        "class" => "vc_nov_social_item",
                        "icon" => "vc_nov_social_item",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a social item"),
                        "as_child" => array('only' => 'nov_socials'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Select Social item'),
                                'param_name' => 'social_content',
                                'description' => $vc->l('Manage socials in module Vinova Theme Config'),
                                'admin_label' => true,
                                'value' => array(
                                    'Facebook' => 'social_facebook',
                                    'Twitter' => 'social_twitter',
                                    'Youtube' => 'social_youtube',
                                    'Google' => 'social_google',
                                    'Dribbble' => 'social_dribbble',
                                    'Instagram' => 'social_instagram',
                                    'Flickr' => 'social_flickr',
                                    'Pinterest' => 'social_pinterest',
                                    'LinkedIn' => 'social_linkedIn',
                                    'Skype' => 'social_skype',
                                    'Vimeo' => 'social_vimeo',
                                )
                            )
                        )
                    )
                );
            }
        }

        function nov_socials_shortcode($atts, $content = null) {
            $output = $content_socials = $title = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'display_type' => '',
                'content_socials' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $content_socials = JsComposer::do_shortcode($content);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'content_socials' => $content_socials,
                    'display_type' => $display_type,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Socials/'. $display_type .'.tpl', 'novmanagevcaddons'));

            return $output;
        }
        function nov_social_item_shortcode($atts) {
            $output = $single_tab_title = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'social_content' => '',
            ), $atts));
            $icon = '';
            $label = '';
            if($social_content == 'social_facebook') {
                $icon = 'fa fa-facebook';
                $label = 'Facebook';
            }
            if($social_content == 'social_twitter') {
                $icon = 'fa fa-twitter';
                $label = 'Twitter';
            }
            if($social_content == 'social_youtube') {
                $icon = 'fa fa-youtube-play';
                $label = 'Youtube';
            }
            if($social_content == 'social_google') {
                $icon = 'fa fa-google-plus';
                $label = 'Google';
            }
            if($social_content == 'social_dribbble') {
                $icon = 'fa fa-dribbble';
                $label = 'Dribbble';
            }
            if($social_content == 'social_instagram') {
                $icon = 'fa fa-instagram';
                $label = 'Instagram';
            }
            if($social_content == 'social_flickr') {
                $icon = 'fa fa-flickr';
                $label = 'Flickr';
            }
            if($social_content == 'social_pinterest') {
                $icon = 'fa fa-pinterest';
                $label = 'Pinterest';
            }
            if($social_content == 'social_linkedIn') {
                $icon = 'fa fa-linkedin';
                $label = 'Linkedin';
            }
            if($social_content == 'social_skype') {
                $icon = 'fa fa-skype';
                $label = 'Skype';
            }
            if($social_content == 'social_vimeo') {
                $icon = 'fa fa-vimeo';
                $label = 'Vimeo';
            }
            $context = Context::getContext();
            
            $link = Configuration::get('novthemeconfig_'.$social_content, $context->language->id);

            $output ='';
            $output .='<li class="'. $social_content .'"><a href="'. $link .'" target="_blank"><i class="'. $icon .'"></i><span>'. $label .'</span></a></li>';

            return $output;
        }

    }
    // end class
    // new nov_socials;
}

//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nov_socials extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nov_social_item extends WPBakeryShortCode {
    }
}