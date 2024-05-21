<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Separator")) {

    class Nov_Separator {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_separator", array($this, "nov_separator_shortcode"));
        }


        function nov_separator_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Separator'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Separator"),
                        "base" => "nov_separator",
                        "class" => "vc_separator_button",
                        "icon" => "vc_element-icon http://localhost/prestashop_nuranium/modules/ps_categorytree/logo.png",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a image slider item."),
                        "params" => array(
                            array(
                                'type' => 'colorpicker',
                                'heading' => $vc->l('Custom Color'),
                                'param_name' => 'accent_color',
                                'description' => $vc->l('Select border color for your element.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Element width (px)'),
                                'param_name' => 'el_width'
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Element height (px)'),
                                'param_name' => 'el_height'
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

        function nov_separator_shortcode($atts, $content = null) {
            $output = $accent_color = $el_width = $el_height = $el_class = $css_class = '';
            extract(JsComposer::shortcode_atts(array(
                'accent_color' => '',
                'el_width' => '',
                'el_height' => '',
                'el_class' => ''
            ), $atts));

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $context->smarty->assign(
                array(
                    'accent_color' => $accent_color,
                    'el_width' => $el_width,
                    'el_height' => $el_height,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Separator/default.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>' . $css .'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_separator;
}
