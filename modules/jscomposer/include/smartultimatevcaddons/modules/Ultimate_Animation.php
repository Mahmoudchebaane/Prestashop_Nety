<?php

/*
 * Module - Animation Block
 */
if (!class_exists('Ultimate_Animation')) {

    class Ultimate_Animation {

        public $vcaddonsinstance, $context;

        function __construct() {

            JsComposer::add_shortcode('ult_animation_block', array(&$this, 'animate_shortcode'));
            $this->vcaddonsinstance = jscomposer::getInstance();
            $this->context = Context::getContext();
        }

        function animate_shortcode($atts, $content = null) {
            
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/jquery.appear.min.js");
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/custom.min.js");

            $output = $animation = $opacity = $opacity_start_effect = $animation_duration = $animation_delay = $animation_iteration_count = $inline_disp = $el_class = '';
            $opacity_start_effect_data = '';
            extract(JsComposer::shortcode_atts(array(
                        "animation" => "",
                        "opacity" => "",
                        "opacity_start_effect" => "",
                        "animation_duration" => "",
                        "animation_delay" => "",
                        "animation_iteration_count" => "",
                        "inline_disp" => "",
                        "el_class" => "",
                            ), $atts));
            $style = $infi = $mobile_opt = '';
            $ultimate_animation = Configuration::get('ultimate_animation');
            if ($ultimate_animation == "disable") {
                $mobile_opt = 'ult-no-mobile';
            }
            if ($inline_disp !== '') {
                $style .= 'display:inline-block;';
            }
            if ($opacity == "set") {
                $style .= 'opacity:0;';
                $el_class .= ' ult-animate-viewport ';
                $opacity_start_effect_data = 'data-opacity_start_effect="' . $opacity_start_effect . '"';
            }
            $inifinite_arr = array("InfiniteRotate", "InfiniteDangle", "InfiniteSwing", "InfinitePulse", "InfiniteHorizontalShake", "InfiniteBounce", "InfiniteFlash", "InfiniteTADA");
            if ($animation_iteration_count == 0 || in_array($animation, $inifinite_arr)) {
                $animation_iteration_count = 'infinite';
                $animation = 'infinite ' . $animation;
            }
            $output .= '<div class="ult-animation ' . $el_class . ' ' . $mobile_opt . '" data-animate="' . $animation . '" data-animation-delay="' . $animation_delay . '" data-animation-duration="' . $animation_duration . '" data-animation-iteration="' . $animation_iteration_count . '" style="' . $style . '" ' . $opacity_start_effect_data . '>';
            $output .= JsComposer::do_shortcode($content);
            $output .= '</div>';
            return $output;
        }

/* end animate_shortcode() */

        function animate_shortcode_mapper() {

            $vc = vc_manager();
            if (function_exists('vc_map')) {
                vc_map(
                        array(
                            "name" => $vc->l("Animation Block"),
                            "base" => "ult_animation_block",
                            "icon" => "animation_block",
                            "class" => "animation_block",
                            "as_parent" => array('except' => 'ult_animation_block'),
                            "content_element" => true,
                            "controls" => "full",
                            "show_settings_on_create" => true,
                            "category" => "Ultimate VC Addons",
                            "description" => "Apply animations everywhere.",
                            "params" => array(
                                array(
                                    "type" => "animator",
                                    "class" => "",
                                    "heading" => $vc->l("Animation"),
                                    "param_name" => "animation",
                                    "value" => "",
                                    "description" => $vc->l(""),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Animation Duration"),
                                    "param_name" => "animation_duration",
                                    "value" => 3,
                                    "min" => 1,
                                    "max" => 100,
                                    "suffix" => "s",
                                    "description" => $vc->l("How long the animation effect should last. Decides the speed of effect."),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Animation Delay"),
                                    "param_name" => "animation_delay",
                                    "value" => 0,
                                    "min" => 1,
                                    "max" => 100,
                                    "suffix" => "s",
                                    "description" => $vc->l("Delays the animation effect for seconds you enter above."),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Animation Repeat Count"),
                                    "param_name" => "animation_iteration_count",
                                    "value" => 1,
                                    "min" => 0,
                                    "max" => 100,
                                    "suffix" => "",
                                    "description" => $vc->l("The animation effect will repeat to the count you enter above. Enter 0 if you want to repeat it infinitely."),
                                ),
                                array(
                                    "type" => "ult_switch",
                                    "class" => "",
                                    "heading" => $vc->l("Hide Elements Until Delay"),
                                    "param_name" => "opacity",
                                    "admin_label" => true,
                                    "value" => "set",
                                    "options" => array(
                                        "set" => array(
                                            "label" => "If set to yes, the elements inside block will stay hidden until animation starts (depends on delay settings above).",
                                            "on" => "Yes",
                                            "off" => "No",
                                        ),
                                    ),
                                    "description" => $vc->l(""),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Viewport Position"),
                                    "param_name" => "opacity_start_effect",
                                    "suffix" => "%",
                                    "value" => "90",
                                    "description" => $vc->l("The area of screen from top where animation effects will start working.", "upb_parallax"),
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => $vc->l("Extra class name"),
                                    "param_name" => "el_class",
                                    "description" => $vc->l("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.")
                                ),
                                array(
                                    "type" => "heading",
                                    "param_name" => "notification",
                                    'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
                                ),
                            ),
                            "js_view" => 'VcColumnView'
                        )
                );
            }
        }
    }
    if (class_exists('WPBakeryShortCodesContainer')) {

        class WPBakeryShortCode_ult_animation_block extends WPBakeryShortCodesContainer {
            
        }

    }
}