<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */

if (!class_exists("Nov_Product_List")) {

    class Nov_Product_List {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_product_list", array($this, "nov_product_list_shortcode"));
        }

        function nov_product_list_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Product_List'), 'Style');

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
                        "name" => $vc->l("Nov Product List"),
                        "base" => "nov_product_list",
                        "class" => "vc_nov_product_list",
                        "icon" => "vc_nov_product_list",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a product list."),
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title 1'),
                                'param_name' => 'title1',
                                'description' => $vc->l( 'Display Title 1'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-11'))
                                
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Sub title'),
                                'param_name' => 'sub_title'
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Title Align'),
                                'param_name' => 'title_align',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => 'left',
                                    '2' => 'center',
                                    '3' => 'right'
                                ),
                                'description' => $vc->l('Select text alignment.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Title Style'),
                                'param_name' => 'title_style',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4'
                                ),
                                'description' => $vc->l('Select title style.')
                            ),
                            array(
                                'type' => 'autocomplete',
                                'heading' => $vc->l( 'Select category'),
                                'param_name' => 'id_categorys',
                                'description' => $vc->l( 'Enter category name to see suggestions. If blank, will select the all category'),
                                'settings' => array(
                                    'vc_catalog_type' => 'category',
                                    'multiple' => true
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
                                'type' => 'dropdown',
                                'heading' => $vc->l('Order by'),
                                'param_name' => 'orderby',
                                'value' => array(
                                    $vc->l('Product Id') => 'id_product',
                                    $vc->l('Price') => 'price',
                                    $vc->l('Published Date') => 'date_add',
                                    $vc->l('Update Date') => 'date_upd',
                                    $vc->l('Product Name') => 'name',              
                                ),
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Order'),
                                'param_name' => 'order',
                                'value' => array(
                                    $vc->l('DESC') => 'DESC',
                                    $vc->l('ASC') => 'ASC',
                                ),                  
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of Product List.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Style Slider Type 6'),
                                'param_name' => 'style_6',
                                'admin_label' => false,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3'
                                ),
                                'description' => $vc->l('Select Number row for product tabs slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-6'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Style for type slider list'),
                                'param_name' => 'style_type_list',
                                'admin_label' => false,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4'
                                ),
                                'description' => $vc->l('Select style for Product List type slider list.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-list'))
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
                                    '3' => '3',
                                    '4' => '4'
                                ),
                                'description' => $vc->l('Select Number row for Product List type slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-list', 'slider-list-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-9', 'slider-type-10', 'slider-type-11'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Spacing'),
                                'param_name' => 'spacing',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '0' => '0',
                                    '5px' => '5',
                                    '10px' => '10',
                                    '15px' => '15',
                                    '20px' => '20',
                                    '25px' => '25',
                                    '30px' => '30'
                                )
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show Arrows'),
                                'param_name' => 'show_arrows',
                                'description' => $vc->l( 'If checked row will be set to show arrows slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-list', 'slider-list-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-9', 'slider-type-10', 'slider-type-11'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show dots'),
                                'param_name' => 'show_dots',
                                'description' => $vc->l( 'If checked row will be set to show dots slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-list', 'slider-list-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-9', 'slider-type-10', 'slider-type-11'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Autoplay'),
                                'param_name' => 'autoplay',
                                'description' => $vc->l( 'If checked row will be set to autoplay slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-list', 'slider-list-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-9', 'slider-type-10', 'slider-type-11'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Extra Desktop: Number product per line'),
                                'param_name' => 'xl_number',
                                'std' => '4',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Desktop: Number product per line'),
                                'param_name' => 'lg_number',
                                'std' => '4',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Tablet: Number product per line'),
                                'param_name' => 'md_number',
                                'std' => '3',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Mobile: Number product per line'),
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

        function nov_product_list_shortcode($atts, $content = null) {
            $output = $title = $title1 = $el_class = $css_class = '';
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'title1' => '',
                'sub_title' => '',
                'title_align' => '',
                'title_style' => '1',
                'id_categorys' => null,
                'limit' => '12',
                'orderby' => 'id_product',
                'order' => 'DESC',
                'display_type' => 'grid-type-1',
                'style_6' => '',
                'style_type_list' => '1',
                'spacing' => '',
                'number_row' => '',
                'show_arrows' => '',
                'show_dots' => '',
                'autoplay' => '',
                'xl_number' => '',
                'lg_number' => '4',
                'md_number' => '',
                'number' => '',
                'el_class' => ''
            ), $atts));

            $catids = str_replace('-',',',$id_categorys);
            $catids = substr($catids,strlen($catids)-1) == ',' ? substr($catids,0, -1) : $catids;

            $filter = '';
            //echo "<pre>".print_r($id_categorys,1);die();
            if($catids && $catids != ''){
                $filter = 'cp.`id_category` IN (' . pSQL($catids) . ')';
            }

            $context = Context::getContext();

            //echo "<pre>".print_r($filter,1);die();

            $cache_products = novmanagevcaddons::NovgetProducts($filter, (int) Context::getContext()->language->id, 0, 12, false, $orderby, $order);

            if(!$cache_products){
                return false;
            }

            $assembler = new ProductAssembler($context);

            $presenterFactory = new ProductPresenterFactory($context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new PrestaShop\PrestaShop\Core\Product\ProductListingPresenter(
                new PrestaShop\PrestaShop\Adapter\Image\ImageRetriever(
                    $context->link
                ),
                $context->link,
                new PrestaShop\PrestaShop\Adapter\Product\PriceFormatter(),
                new PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever(),
                $context->getTranslator()
            );

            $products_for_template = [];

            foreach ($cache_products as $rawProduct) {
                $products_for_template[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($rawProduct),
                    $context->language
                );
            }

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $show_arrows = ($show_arrows == 'true') ? 'true' : 'false';
            $show_dots = ($show_dots == 'true') ? 'true' : 'false';
            $autoplay = ($autoplay == 'true') ? 'true' : 'false';

            $column = novmanagevcaddons::get_classnumbercolumn($xl_number, $lg_number, $md_number, $number);
            
            $novconfig = novmanagevcaddons::getConfigTheme();
            
            $context->smarty->assign(
                array(
                    'products' => $products_for_template,
                    'title' => $title,
                    'title1' => $title1,
                    'sub_title' => $sub_title,
                    'title_align' => $title_align,
                    'title_style' => $title_style,
                    'nov_dir' => _PS_THEME_DIR_,
                    'style_6' => $style_6,
                    'spacing' => $spacing,
                    'style_type_list' => $style_type_list,
                    'xl' => $xl_number,
                    'lg' => $lg_number,
                    'md' => $md_number,
                    'xs' => $number,
                    'column' => $column,
                    'number_row' => $number_row,
                    'show_arrows' => $show_arrows,
                    'show_dots' => $show_dots,
                    'autoplay' => $autoplay,
                    'el_class' => $el_class,
                    'novconfig' => $novconfig
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Product_List/'. $display_type .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_product_list;
}