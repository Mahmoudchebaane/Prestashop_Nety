
<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Coming_Soon")) {

    class Nov_Coming_Soon {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_coming_soon", array($this, "nov_coming_soon_shortcode"));
        }


        function nov_coming_soon_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Coming_Soon'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Coming Soon"),
                        "base" => "nov_coming_soon",
                        "class" => "vc_nov_coming_soon",
                        "icon" => "vc_element-icon http://localhost/prestashop_nuranium/modules/ps_categorytree/logo.png",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a image slider item."),
                        "params" => array(
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => $vc->l('Image'),
                                'param_name' => 'logo',
                                'value' => '',
                                'description' => $vc->l('Upload your logo.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title 1'),
                                'param_name' => 'title_1',
                                'value' => '',
                                'description' => ''
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title 2'),
                                'param_name' => 'title_2',
                                'value' => '',
                                'description' => ''
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Description'),
                                'param_name' => 'description',
                                'value' => '',
                                'description' => ''
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Coming Date'),
                                'param_name' => 'date',
                                'value' => '2019/07/16',
                                'description' => 'Example: 2019/07/16'
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Style'),
                                'param_name' => 'coming_style',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type')
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
            }
        }

        function nov_coming_soon_shortcode($atts, $content = null) {
            $output = $title = $logo = $description = $el_class = '';
            $link = new Link();
            
            extract(JsComposer::shortcode_atts(array(
                'title_1' => '',
                'title_2' => '',
                'description' => '',
                'date' => '',
                'logo' => '',
                'coming_style' => '',
                'el_class' => ''
            ), $atts));

            $novconfigtheme = novmanagevcaddons::getNovthemeconfig();
            

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $img = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($logo) . '" class="img-fluid" />';

            if(Module::isInstalled('ps_emailsubscription') && Module::isEnabled('ps_emailsubscription')) {
              $ps_emailsubscription = Module::getInstanceByName('ps_emailsubscription');
              $context->smarty->assign('nov_emailsubscription',$ps_emailsubscription->getWidgetVariables('displayHome', array()));
            } else {
                $context->smarty->assign('nov_emailsubscription', '');
            }

            $context->smarty->assign(
                array(
                    'title_1' => $title_1,
                    'title_2' => $title_2,
                    'img' => $img,
                    'novconfigtheme' => $novconfigtheme,
                    'nov_dir' => _PS_THEME_DIR_,
                    'link' => $link,
                    'description' => $description,
                    'date' => $date,
                    'coming_style' => $coming_style,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Coming_Soon/'. $coming_style .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>' . $css .'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_coming_soon
}
