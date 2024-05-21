<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Testimonials")) {

    class Nov_Testimonials {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_testimonials", array($this, "nov_testimonials_shortcode"));
        }

        function nov_testimonials_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Testimonials'), 'Style');

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
                        "name" => $vc->l("Nov Testimonials"),
                        "base" => "nov_testimonials",
                        "class" => "vc_nov_testimonials",
                        "icon" => "vc_nov_testimonials",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a testimonials list."),
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
                                'heading' => $vc->l('Title Style'),
                                'param_name' => 'title_style',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3'
                                ),
                                'description' => $vc->l('Select title style.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Limit'),
                                'param_name' => 'limit',
                                'value' => '12',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display type'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of testimonials List.'),
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Number row'),
                                'param_name' => 'number_row',
                                'admin_label' => false,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3'
                                ),
                                'description' => $vc->l('Select Number row for testimonials List type slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l('Show Arrows'),
                                'param_name' => 'show_arrows',
                                'description' => $vc->l('If checked row will be set to show arrows slider.'),
                                'value' => array( $vc->l('Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2', 'slider-type-3'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l('Show dots'),
                                'param_name' => 'show_dots',
                                'description' => $vc->l('If checked row will be set to show dots slider.'),
                                'value' => array( $vc->l('Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2', 'slider-type-3'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l('Autoplay'),
                                'param_name' => 'autoplay',
                                'description' => $vc->l('If checked row will be set to autoplay slider.'),
                                'value' => array( $vc->l('Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2', 'slider-type-3'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Desktop: Number testimonial per line'),
                                'param_name' => 'xl_number',
                                'std' => '4',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Tablet: Number testimonial per line'),
                                'param_name' => 'md_number',
                                'std' => '3',
                                'value' => $screennumber
                            
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Mobile: Number testimonial per line'),
                                'param_name' => 'number',
                                'std' => '2',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Extra class name'),
                                'param_name' => 'el_class',
                                'description' => $vc->l('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.')
                            )
                        )
                    )
                );
            }
        }

        function nov_testimonials_shortcode($atts, $content = null) {
            $output = $title = $el_class = $css_class = '';
            $manus = array();
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'title_align' => '',
                'title_style' => '1',
                'limit' => '12',
                'display_type' => 'grid-type',
                'display_style' => '',
                'number_row' => '',
                'show_arrows' => '',
                'show_dots' => '',
                'autoplay' => '',
                'xl_number' => '',
                'md_number' => '',
                'number' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $show_arrows = ($show_arrows == 'true') ? 'true' : 'false';
            $show_dots = ($show_dots == 'true') ? 'true' : 'false';
            $autoplay = ($autoplay == 'true') ? 'true' : 'false';

            $testimonials = novmanagevcaddons::getTestimonialss(true, $limit);

            // echo"<pre>".print_r($testimonials,1);die();

            $column = novmanagevcaddons::get_classnumbercolumn($xl_number, $md_number, $number);
            if(Configuration::get('PS_SSL_ENABLED'))
                $image_path = _PS_BASE_URL_SSL_._MODULE_DIR_."novtestimonials/images/";
            else
                $image_path = _PS_BASE_URL_._MODULE_DIR_."novtestimonials/images/";

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'testimonials' => $testimonials,
                    'image_path' => $image_path,
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'title_align' => $title_align,
                    'title_style' => $title_style,
                    'display_style' => $display_style,
                    'xl' => $xl_number,
                    'md' => $md_number,
                    'xs' => $number,
                    'column' => $column,
                    'number_row' => $number_row,
                    'show_arrows' => $show_arrows,
                    'show_dots' => $show_dots,
                    'autoplay' => $autoplay,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Testimonials/'. $display_type .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_manufacture;
}