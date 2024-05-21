<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Button")) {

    class Nov_Button {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_button", array($this, "nov_button_shortcode"));
        }


        function nov_Button_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Button'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Button"),
                        "base" => "nov_button",
                        "class" => "vc_nov_button",
                        "icon" => "vc_element-icon http://localhost/nuranium_origin/modules/novmanagevcaddons/logo.png",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a image slider item."),
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Button Text'),
                                'param_name' => 'nov_button_text',
                                'value' => 'Button text',
                                'description' => ''
                            ),
                            array(
                                'type' => 'href',
                                'heading' => $vc->l('Button link'),
                                'param_name' => 'nov_button_link',
                                'description' => $vc->l('Enter URL if you want this button to have a link.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Button Type'),
                                'param_name' => 'button_type',
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',
                                    '5' => '5',
                                    '6' => '6',
                                    '7' => '7',
                                    '8' => '8',
                                    '9' => '9'
                                )
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => $vc->l( 'Icon'),
                                'param_name' => 'icon',
                                'admin_label' => false,
                                'description' => $vc->l( 'Select icon for your element.'),
                                "dependency" => array('element' => 'button_type', 'value' => array('8', '9'))
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => $vc->l( 'Custom Background'),
                                'param_name' => 'accent_color',
                                'admin_label' => false,
                                'description' => $vc->l( 'Select background color for your element.'),
                                "dependency" => array('element' => 'button_type', 'value' => array('7'))
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

        function nov_button_shortcode($atts, $content = null) {
            $output = $nov_button_text = $el_class = $css_class = '';
            extract(JsComposer::shortcode_atts(array(
                'nov_button_text' => '',
                'button_type' => '',
                'icon' => '',
                'accent_color' => '',
                'nov_button_link' => '',
                'el_class' => ''
            ), $atts));

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $btn_icon = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon) . '" class="icon"  alt="icon"/>';

            $context->smarty->assign(
                array(
                    'nov_button_text' => $nov_button_text,
                    'nov_button_link' => $nov_button_link,
                    'accent_color' => $accent_color,
                    'btn_icon' => $btn_icon,
                    'icon' => $icon,
                    'button_type' => $button_type,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Button/default.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>' . $css .'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_button;
}
