<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Image_Text")) {

    class Nov_Image_Text {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_image_text", array($this, "nov_image_text_shortcode"));
        }


        function nov_image_text_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Image_Text'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Image Text"),
                        "base" => "nov_image_text",
                        "class" => "vc_nov_image_text",
                        "icon" => "vc_element-icon http://localhost/prestashop_nuranium/modules/ps_categorytree/logo.png",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a image slider item."),
                        "params" => array(
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => $vc->l('Image'),
                                'param_name' => 'img',
                                'value' => '',
                                'description' => $vc->l('Upload the image you want.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Text'),
                                'param_name' => 'texttop',
                                'value' => '',
                                'description' => ''
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Text'),
                                'param_name' => 'textbottom',
                                'value' => '',
                                'description' => ''
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

        function nov_image_text_shortcode($atts, $content = null) {
            $output = $img = $el_class = $css_class = '';
            extract(JsComposer::shortcode_atts(array(
                'img' => '',
                'texttop' => '',
                'textbottom' => '',
                'el_class' => ''
            ), $atts));

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );
            $image = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($img) . '" class="image" />';

            $context->smarty->assign(
                array(
                    'image' => $image,
                    'texttop' => $texttop,
                    'textbottom' => $textbottom,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Image_Text/default.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>' . $css .'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_image_text;
}
