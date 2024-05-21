
<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Contact")) {

    class Nov_Contact {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_contact", array($this, "nov_contact_shortcode"));
        }


        function nov_Contact_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Contact'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Contact"),
                        "base" => "nov_contact",
                        "class" => "vc_nov_contact",
                        "icon" => "vc_element-icon http://localhost/prestashop_nuranium/modules/ps_categorytree/logo.png",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a image slider item."),
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Phone Number'),
                                'param_name' => 'nov_phone',
                                'value' => '',
                                'description' => ''
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Email'),
                                'param_name' => 'nov_email',
                                'value' => '',
                                'description' => ''
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Address'),
                                'param_name' => 'nov_address',
                                'value' => '',
                                'description' => ''
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Open Hours'),
                                'param_name' => 'nov_open',
                                'value' => '',
                                'description' => ''
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of Contact.')
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

        function nov_contact_shortcode($atts, $content = null) {
            $output = $nov_phone = $nov_email = $nov_address = $nov_open = $el_class = '';
            extract(JsComposer::shortcode_atts(array(
                'nov_phone' => '',
                'nov_email' => '',
                'nov_address' => '',
                'nov_open' => '',
                'display_type' => 'style-1',
                'el_class' => ''
            ), $atts));

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $context->smarty->assign(
                array(
                    'nov_phone' => $nov_phone,
                    'nov_email' => $nov_email,
                    'nov_address' => $nov_address,
                    'nov_open' => $nov_open,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Contact/'. $display_type .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>' . $css .'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_contact
}
