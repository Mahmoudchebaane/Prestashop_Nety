<?php
/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */

if (!class_exists("Nov_Verticalmenu")) {

    class Nov_Verticalmenu {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("Nov_Verticalmenu", array($this, "Nov_Verticalmenu_shortcode"));
        }

        function Nov_Verticalmenu_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Verticalmenu'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Verticalmenu"),
                        "base" => "Nov_Verticalmenu",
                        "class" => "vc_Nov_Verticalmenu",
                        "icon" => "vc_Nov_Verticalmenu",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add Verticalmenu"),
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
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

        function Nov_Verticalmenu_shortcode($atts, $content = null) {
            $output = $title = $el_class = '';
            $link = new Link();
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );
            $context = Context::getContext();
            $token = Tools::getAdminToken('[classname]'.intval(Tab::getIdFromClassName('[classname]')));
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'link' => $link,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Verticalmenu/style-1.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
}
