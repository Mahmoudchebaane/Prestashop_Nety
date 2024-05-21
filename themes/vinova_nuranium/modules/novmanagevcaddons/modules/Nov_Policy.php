<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Policy")) {

    class Nov_Policy {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_policy", array($this, "nov_policy_shortcode"));
        }


        function nov_policy_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Policy'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Policy"),
                        "base" => "nov_policy",
                        "class" => "vc_nov_policy",
                        "icon" => "vc_element-icon",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a policy item."),
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'value' => 'Policy title',
                                'description' => ''
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Title Style'),
                                'param_name' => 'title_style',
                                'admin_label' => true,
                                'std' => '12 700',
                                'value' => array(
                                    '11 700' => '2',
                                    '12 700' => '1',
                                    '13 700' => '10',
                                    '14 600' => '6',
                                    '14 700' => '3',
                                    '14 900' => '11',
                                    '16 600' => '4',
                                    '16 700' => '9',
                                    '18 600' => '7',
                                    '18 700' => '8',
                                    '20 600' => '5'
                                ),
                                'description' => $vc->l('Select title style.')
                            ),
                            array(
                                'type' => 'textarea',
                                'holder' => 'div',
                                'heading' => $vc->l('Description'),
                                'param_name' => 'content_policy',
                            ),
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => $vc->l('Policy Image'),
                                'param_name' => 'policy_image',
                                'value' => '',
                                'description' => $vc->l('Upload the image you want.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Style'),
                                'param_name' => 'policy_style',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of Policy.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Sub Title'),
                                'param_name' => 'sub_title',
                                'value' => 'Policy sub title',
                                'description' => '',
                                'admin_label' => false,
                                "dependency" => array('element' => 'policy_style', 'value' => array('style-3'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Backgroud Color'),
                                'param_name' => 'bg',
                                'value' => array( $vc->l( 'Yes') => 'true' )
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => $vc->l( 'Custom Color'),
                                'param_name' => 'accent_color',
                                'description' => $vc->l( 'Select background color for your element.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'bg', 'value' => array('true'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Extra class name'),
                                'param_name' => 'el_class',
                                'description' => $vc->l('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.')
                            ),
                            array(
                                'type' => 'css_editor',
                                'heading' => $vc->l('Css'),
                                'param_name' => 'css',
                                'group' => $vc->l('Design options')
                            )
                        )
                    )
                );
            }
        }

        function nov_policy_shortcode($atts, $content = null) {
            $output = $title = $policy_image = $policy_style = $el_class  = $css_class = '';
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'title_style' => '',
                'policy_image' => '',
                'content_policy' => '',
                'policy_style' => 'style-3',
                'bg' => '',
                'accent_color' => '',
                'el_class' => '',
                'css' => ''
            ), $atts));

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );
            
            $policy_icon = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($policy_image) . '" class="policy-icon" />';

            $context->smarty->assign(
                array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'title_style' => $title_style,
                    'policy_icon' => $policy_icon,
                    'bg' => $bg,
                    'accent_color' => $accent_color,
                    'content_policy' => JsComposer::do_shortcode($content_policy),
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Policy/'.$policy_style.'.tpl', 'novmanagevcaddons'));
        
            if(isset($css) && !empty($css)){
                $css_out = '<style>' . $css .'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_policy;
}
