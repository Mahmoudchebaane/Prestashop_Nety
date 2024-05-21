<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Manufacture")) {

    class Nov_Manufacture {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_manufacture", array($this, "nov_manufacture_shortcode"));
        }

        function nov_manufacture_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Manufacture'), 'Style');

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
                        "name" => $vc->l("Nov Manufacture"),
                        "base" => "nov_manufacture",
                        "class" => "vc_nov_manufacture",
                        "icon" => "vc_nov_manufacture",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a manufacture list."),
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
                                'heading' => $vc->l('Limit'),
                                'param_name' => 'limit',
                                'value' => '12',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of Manufacture List.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Type'),
                                'param_name' => 'mn_style',
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3'
                                )
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
                                'description' => $vc->l('Select Number row for Manufacture List type slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show Arrows'),
                                'param_name' => 'show_arrows',
                                'description' => $vc->l( 'If checked row will be set to show arrows slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show dots'),
                                'param_name' => 'show_dots',
                                'description' => $vc->l( 'If checked row will be set to show dots slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Autoplay'),
                                'param_name' => 'autoplay',
                                'description' => $vc->l( 'If checked row will be set to autoplay slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Desktop: Number manu per line'),
                                'param_name' => 'xl_number',
                                'std' => '4',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Tablet: Number manu per line'),
                                'param_name' => 'md_number',
                                'std' => '3',
                                'value' => $screennumber
                            
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Mobile: Number manu per line'),
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

        function nov_manufacture_shortcode($atts, $content = null) {
            $output = $title = $el_class = $css_class = '';
            $manus = array();
            $link = new Link();
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'limit' => '12',
                'display_type' => 'grid-type',
                'mn_style' => '',
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

            //getManufacturers($getNbProducts = false, $idLang = 0, $active = true, $p = false, $n = false, $allGroup = false, $group_by = false, $withProduct = false)
            $manus = Manufacturer::getManufacturers(true, $this->context->language->id, true, false ,$limit, false, true, true);
            foreach ($manus as &$item) {
                $id_images = (!file_exists(_PS_MANU_IMG_DIR_.'/'.$item['id_manufacturer'].'.jpg')) ? Language::getIsoById($this->context->language->id): $item['id_manufacturer'];
                $item['image'] = _THEME_MANU_DIR_.$id_images.'.jpg';
            }

            //echo"<pre>".print_r($manus);die();

            $column = novmanagevcaddons::get_classnumbercolumn($xl_number, $md_number, $number);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'manus' => $manus,
                    'title' => $title,
                    'link'  => $link,
                    'mn_style' => $mn_style,
                    'sub_title' => $sub_title,
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

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Manufacture/'. $display_type .'.tpl', 'novmanagevcaddons'));

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