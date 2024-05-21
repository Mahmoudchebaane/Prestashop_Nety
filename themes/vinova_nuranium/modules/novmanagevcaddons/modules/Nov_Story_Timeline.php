<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Story_Timeline")) {

    class Nov_Story_Timeline {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_story_timeline", array($this, "nov_story_timeline_shortcode"));
            JsComposer::add_shortcode('nov_story_timeline_item',array($this,'nov_story_timeline_item_shortcode'));
        }

        function nov_story_timeline_init() {
            $vc = vc_manager();

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Story Timeline"),
                        "base" => "nov_story_timeline",
                        "class" => "vc_nov_story_timeline",
                        "icon" => "vc_nov_story_timeline",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a our team list"),
                        "as_parent" => array('only' => 'nov_story_timeline_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
                        "name" => $vc->l("Nov Story Timeline Item"),
                        "base" => "nov_story_timeline_item",
                        "class" => "vc_nov_story_timeline_item",
                        "icon" => "vc_nov_story_timeline_item",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a story timeline item"),
                        "as_child" => array('only' => 'nov_story_timeline'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Time'),
                                'param_name' => 'time',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Heading'),
                                'param_name' => 'heading',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textarea',
                                'holder' => 'div',
                                'heading' => $vc->l('Description'),
                                'param_name' => 'content_timeline',
                            )
                        )
                    )
                );
            }
        }

        function nov_story_timeline_shortcode($atts, $content = null) {
            $output = $content_story_timeline = $title = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'content_story_timeline' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $content_story_timeline = JsComposer::do_shortcode($content);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'content_story_timeline' => $content_story_timeline,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Story_Timeline/default.tpl', 'novmanagevcaddons'));

            return $output;
        }
        function nov_story_timeline_item_shortcode($atts, $content = null) {
            $output = $content_timeline = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'time' => '',
                'heading' => '',
                'content_timeline' => JsComposer::do_shortcode($content_timeline),
            ), $atts));

            $output ='<li class="story-timeline-item">';
            $output .='<div class="time">'.$time.'</div>';
            $output .='<div class="block_content">';
            $output .='<div class="title">'.$heading.'</div>';
            $output .='<div class="desc">'.$content_timeline.'</div>';
            $output .='</div>';
            $output .='</li>';

            return $output;
        }
    }
    // end class
    // new nov_our_team;
}

//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nov_story_timeline extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nov_story_timeline_item extends WPBakeryShortCode {
    }
}