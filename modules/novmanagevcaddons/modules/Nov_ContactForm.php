<?php
/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */

if (!class_exists("Nov_ContactForm")) {

    class Nov_ContactForm {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_contactform", array($this, "nov_contactform_shortcode"));
        }

        function nov_contactform_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_ContactForm'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Contact Form"),
                        "base" => "nov_contactform",
                        "class" => "vc_nov_contactform",
                        "icon" => "vc_nov_contactform",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a contact form."),
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
                                'heading' => $vc->l('Description title'),
                                'param_name' => 'desc_title'
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of Contact Form.')
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

        function nov_contactform_shortcode($atts, $content = null) {
            $output = $title = $desc_title = $el_class = $css_class = '';
            $link = new Link();
            global $notifications;
            global $contact;
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'desc_title' => '',
                'display_type' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $context = Context::getContext();

            $contacts = Contact::getContacts($this->context->language->id);
            $token = Tools::getAdminToken('[classname]'.intval(Tab::getIdFromClassName('[classname]')));
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'desc_title' => $desc_title,
                    'link' => $link,
                    'notifications' => $notifications,
                    'contact' => $contact,
                    'contacts' => $contacts,
                    'token' => $token,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_ContactForm/'. $display_type .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_contact;
}
