<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Lookbook")) {

    class Nov_Lookbook {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_lookbook", array($this, "nov_lookbook_shortcode"));
            Jscomposer::add_shortcode_param('nov_checkboxs', array($this, 'nov_checkboxs_param'), "{$this->vcaddonsinstance->_url}admin/js/vc-multicheckbox-param.js");
        }

        function nov_checkboxs_param($settings, $value) {
            $dependency = vc_generate_dependencies_attributes($settings);
            $querys = $settings['query'];
            $html = '<div class="checkbox-lists">
                        <input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value nov-checkboxs-value ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" value="' . $value . '" ' . $dependency . '/>';
            foreach ($querys as $key => $query)
                $html .= '<div class="checkbox"><label><input class="input-checkbox" type="checkbox" name="item_'. $query['val'] .'" value="'. $query['val'] .'">'. $query['name'] .'</label></div>';
            $html .= '</div>';
            return $html;
        }

        function nov_lookbook_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Lookbook'), 'Style');

            $slides = array();
            $array_slides = novmanagevcaddons::getLookbook();
            if($array_slides){
                foreach($array_slides as $array_slide){
                    $slides[] = array(
                        'id' => $array_slide['id_slide'],
                        'name' => $array_slide['title'],
                        'val' => $array_slide['id_slide']
                    );
                }
            }

            //echo"<pre>".print_r($slides);die();

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
                        "name" => $vc->l("Nov LookBook"),
                        "base" => "nov_lookbook",
                        "class" => "vc_nov_lookbook",
                        "icon" => "vc_nov_lookbook",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a lookbook list."),
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
                                'type' => 'textarea',
                                'holder' => 'div',
                                'heading' => $vc->l('Description title'),
                                'param_name' => 'contenttext',
                                'value' => $vc->l('Lorem ipsum dolor sit amet eleifend tincidunt tortor fringilla neque ut quam quis.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Type title'),
                                'param_name' => 'type_title',
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2'
                                )
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Limit'),
                                'param_name' => 'limit',
                                'value' => '12',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'nov_checkboxs',
                                'heading' => $vc->l('Select lookbook items'),
                                'param_name' => 'lookbookitems',
                                'query' => $slides,
                                'options' => array(),
                                'description' => $vc->l('Select LookBook Items.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of LookBook List.')
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
                                'description' => $vc->l('Select Number row for LookBook List type slider.'),
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
                                'heading' => $vc->l('Desktop: Number item per line'),
                                'param_name' => 'xl_number',
                                'std' => '4',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Tablet: Number item per line'),
                                'param_name' => 'md_number',
                                'std' => '3',
                                'value' => $screennumber
                            
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Mobile: Number item per line'),
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

        function nov_lookbook_shortcode($atts, $content = null) {
            $output = $title = $sub_title = $el_class = $css_class = $contenttext ='';
            $link = new Link();
            $manus = array();
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'type_title' => '',
                'limit' => '12',
                'contenttext'=>'',
                'lookbookitems' => '',
                'display_type' => 'grid-type',
                'number_row' => '',
                'show_arrows' => '',
                'show_dots' => '',
                'autoplay' => '',
                'xl_number' => '4',
                'md_number' => '3',
                'number' => '2',
                'el_class' => ''
            ), $atts));


           

            if($lookbookitems){
                $filter = ' AND hs.`id_novlookbook_slides` IN ('. pSQL($lookbookitems).')';
                $lookbooks = array();
                $lookbooks = novmanagevcaddons::getLookbook($filter);
                if (is_array($lookbooks)) {
                    foreach ($lookbooks as &$slide) {
                        $slide['sizes'] = @getimagesize((dirname(__FILE__).DIRECTORY_SEPARATOR.'views/img'.DIRECTORY_SEPARATOR.$slide['image']));
                        if (isset($slide['sizes'][3]) && $slide['sizes'][3]) {
                            $slide['size'] = $slide['sizes'][3];
                        }

                        if ($slide['hotsposts']) {
                            $hotsposts = $slide['hotsposts'];
                            $hotsposts = json_decode($hotsposts);
                            foreach ($hotsposts as &$hotspost) {
                                $hotspost = (array) $hotspost;
                                $style = "";
                                $hotspost['left'] = round(($hotspost['left']/$hotspost['imgW'])*100, 2);
                                $hotspost['top'] = round(($hotspost['top']/$hotspost['imgH'])*100, 2);
                                if ($hotspost['top'] > 50) {
                                    $style .= " bottom:65px;";
                                } else {
                                    $style .= " top:65px;";
                                }

                                $hotspost['style'] = $style;

                                if (!empty($hotspost['sku'])) {
                                    $product = new Product((int)$hotspost['sku'], false, (int)$this->context->language->id);
                                    $price_tax_incl = Product::getPriceStatic((int)$hotspost['sku'], false);
                                    $hotspost['name'] = $product->name;
                                    $hotspost['link_rewrite'] = $product->link_rewrite;
                                    $hotspost['link'] = $this->context->link->getProductLink($product);
                                    $currency = Context::getContext()->currency;
                                    $hotspost['price'] = Tools::displayPrice(Tools::convertPrice($price_tax_incl, $currency), $currency);
                                    $image = Product::getCover((int)$hotspost['sku']);
                                    $image = new Image($image['id_image']);
                                    $hotspost['image'] = _PS_BASE_URL_._THEME_PROD_DIR_.$image->getExistingImgPath().".jpg";
                                    if(Configuration::get('PS_SSL_ENABLED'))
                                        $hotspost['image'] = _PS_BASE_URL_SSL_._THEME_PROD_DIR_.$image->getExistingImgPath().".jpg";
                                    else
                                        $hotspost['image'] = _PS_BASE_URL_._THEME_PROD_DIR_.$image->getExistingImgPath().".jpg";
                                }
                            }
                            $slide['hotsposts'] = $hotsposts;
                        }
                    }
                }               
            }

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );
            $show_arrows = ($show_arrows == 'true') ? 'true' : 'false';
            $show_dots = ($show_dots == 'true') ? 'true' : 'false';
            $autoplay = ($autoplay == 'true') ? 'true' : 'false';


            //echo"<pre>".print_r($lookbookitems);die();

            $column = novmanagevcaddons::get_classnumbercolumn($xl_number, $md_number, $number);


            
            $context->smarty->assign(
                array(
                    'lookbooks' => $lookbooks,
                    'link'      => $link,
                    'nov_dir' => __PS_BASE_URI__,
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'desc_title' => JsComposer::do_shortcode($contenttext),
                    'type_title' => $type_title,
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


            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Lookbook/'. $display_type .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_lookbook;
}