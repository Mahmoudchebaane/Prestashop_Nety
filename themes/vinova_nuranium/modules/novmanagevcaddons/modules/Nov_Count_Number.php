
<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Count_Number")) {

    class Nov_Count_Number {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_count_number", array($this, "nov_count_number_shortcode"));
        }


        function nov_Count_Number_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Count_Number'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Count Number"),
                        "base" => "nov_count_number",
                        "class" => "vc_nov_count_number",
                        "icon" => "vc_element-icon http://localhost/prestashop_nuranium/modules/ps_categorytree/logo.png",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a image slider item."),
                        "params" => array(
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => $vc->l('Image'),
                                'param_name' => 'count_image',
                                'value' => '',
                                'description' => $vc->l('Upload the image you want.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'value' => 'Title',
                                'description' => ''
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Number'),
                                'param_name' => 'number',
                                'value' => '',
                                'description' => ''
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

        function nov_count_number_shortcode($atts, $content = null) {
            $output = $title = $count_image = $el_class = '';
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'number' => '',
                'count_image' => '',
                'el_class' => ''
            ), $atts));

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );
            $count_icon = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($count_image) . '" class="count-icon" />';

            $context->smarty->assign(
                array(
                    'title' => $title,
                    'number' => $number,
                    'count_icon' => $count_icon,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Count_Number/default.tpl', 'novmanagevcaddons'));

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
