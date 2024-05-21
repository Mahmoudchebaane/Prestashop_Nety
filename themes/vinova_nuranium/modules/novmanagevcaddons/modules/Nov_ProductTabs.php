<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_ProductTabs")) {

    class Nov_ProductTabs {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_producttabs", array($this, "nov_producttabs_shortcode"));
        }

        function nov_producttabs_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_ProductTabs'), 'Style');

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
                        "name" => $vc->l("Nov Product Tabs"),
                        "base" => "nov_producttabs",
                        "class" => "vc_nov_producttabs",
                        "icon" => "vc_nov_producttabs",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a product tabs"),
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
                                'type' => 'nov_checkboxs',
                                'heading' => $vc->l('Select Tabs show'),
                                'param_name' => 'tabs_show',
                                'query' => array(
                                    array(
                                        'name' => 'New products',
                                        'val' => 'newproducts'
                                    ),
                                    array(
                                        'name' => 'Bestseller products',
                                        'val' => 'bestsellers'
                                    ),
                                    array(
                                        'name' => 'Special products',
                                        'val' => 'specialproducts'
                                    ),
                                    array(
                                        'name' => 'Feature products',
                                        'val' => 'featureproducts'
                                    )
                                ),
                                'options' => array()
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Tabs Style'),
                                'param_name' => 'tabs_style',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',
                                    '5' => '5',
                                    '6' => '6',
                                    '7' => '7',
                                    '8' => '8'
                                ),
                                'description' => $vc->l('Select Tabs Style.')
                            ),
                            array(
                                'type' => 'autocomplete',
                                'heading' => $vc->l( 'Filter category'),
                                'param_name' => 'id_categorys',
                                'admin_label' => true,
                                'settings' => array(
                                    'vc_catalog_type' => 'category',
                                    'multiple' => true
                                ),
                                'description' => $vc->l( 'Enter category name to see suggestions. If blank, will select the all category'),
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
                                'admin_label' => true,
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
                                'param_name' => 'orderway',
                                'admin_label' => true,
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
                                'description' => $vc->l('Select type of product tabs.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Style Slider Type 6'),
                                'param_name' => 'style_6',
                                'admin_label' => false,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2'
                                ),
                                'description' => $vc->l('Select Number row for product tabs slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-6'))
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
                                ),
                                'description' => $vc->l('Select Number row for product tabs slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-7', 'slider-type-8','slider-type-9', 'slider-type-list'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show Arrows'),
                                'param_name' => 'show_arrows',
                                'description' => $vc->l( 'If checked row will be set to show arrows slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-7', 'slider-type-8','slider-type-9', 'slider-type-list'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show dots'),
                                'param_name' => 'show_dots',
                                'description' => $vc->l( 'If checked row will be set to show dots slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-7', 'slider-type-8','slider-type-9', 'slider-type-list'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Autoplay'),
                                'param_name' => 'autoplay',
                                'description' => $vc->l( 'If checked row will be set to autoplay slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-7', 'slider-type-8','slider-type-9', 'slider-type-list'))
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
                              'type' => 'dropdown',
                              'heading' => $vc->l('Spacing Product'),
                              'param_name' => 'spacing',
                              'std' => '1',
                              'value' => array(
                                '0' => '0',
                                '5px' => '5',
                                '10px' => '10',
                                '15px' => '15',
                                '20px' => '20',
                                '25px' => '25',
                                '30px' => '30',
                              )
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

        function nov_producttabs_shortcode($atts, $content = null) {
            $output = $title = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'tabs_show' => '',
                'tabs_style' => '',
                'id_categorys' => '',
                'limit' => '12',
                'orderby' => '',
                'orderway' => '',
                'display_type' => 'grid-type',
                'style_6' => '',
                'number_row' => '',
                'show_arrows' => '',
                'show_dots' => '',
                'autoplay' => '',
                'xl_number' => '',
                'lg_number' => '4',
                'md_number' => '',
                'number' => '',
                'spacing' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );
            $show_arrows = ($show_arrows == 'true') ? 'true' : 'false';
            $show_dots = ($show_dots == 'true') ? 'true' : 'false';
            $autoplay = ($autoplay == 'true') ? 'true' : 'false';
            $column = novmanagevcaddons::get_classnumbercolumn($xl_number,$lg_number, $md_number, $number);

            $context = Context::getContext();
            $tabs = explode(',',$tabs_show);
            $catids = str_replace('-',',',$id_categorys);
            $catids = substr($catids,strlen($catids)-1) == ',' ? substr($catids,0, -1) : $catids;

            $filter = '';
            if($catids && $catids != ''){
                $filter = 'cp.`id_category` IN (' . pSQL($catids) . ')';
            }

            $cache_products = novmanagevcaddons::NovgetProducts($filter, (int)$context->language->id, 0, $limit, false);

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



            $newproducts = [];
            if (isset($cache_products) && $cache_products) {
                foreach ($cache_products as $rawProduct) {
                    $newproducts[] = $presenter->present(
                        $presentationSettings,
                        $assembler->assembleProduct($rawProduct),
                        $context->language
                    );
                }
            }

            $bestsellersproducts = [];
            //$bestseller = novmanagevcaddons::getBestSales($filter, (int)$context->language->id, 0, $limit, $orderby, $orderway, $context);
            //$bestseller = ProductSaleCore::getBestSales((int) $context->language->id, 0, $limit, 'date_add', $orderway);
            $bestseller = novmanagevcaddons::getBestSales($filter, (int)$context->language->id, 0, $limit, 'date_add', $orderway);

            if (isset($bestseller) && $bestseller) {
                foreach ($bestseller as &$product)
                {
                    $bestsellersproducts[] = $presenter->present(
                        $presentationSettings,
                        $assembler->assembleProduct($product),
                        $context->language
                    );
                }
            }

            $specialproducts = [];
            $special = novmanagevcaddons::getPricesDrop($filter, (int) Context::getContext()->language->id, 0, $limit, false, $orderby, $orderway);
            if (isset($special) && $special) {
                foreach ($special as &$product)
                {
                    $specialproducts[] = $presenter->present(
                        $presentationSettings,
                        $assembler->assembleProduct($product),
                        $context->language
                    );
                }
            }

            $featureproducts = [];
            $category = new Category($context->shop->getCategory(), (int)$context->language->id);
            $featured = $category->getProducts((int)$context->language->id, 0, $limit, $orderby, $orderway);
            if (isset($featured) && $featured) {
                foreach ($featured as $product)
                {
                    $featureproducts[] = $presenter->present(
                        $presentationSettings,
                        $assembler->assembleProduct($product),
                        $context->language
                    );
                }
            }



            //echo"<pre>".print_r($featureproducts);die();

            $novconfig = novmanagevcaddons::getConfigTheme();

            $context->smarty->assign(
                array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'nov_dir' => _PS_THEME_DIR_,
                    'tab' => rand(),
                    'tabs' => $tabs,
                    'tabs_style' => $tabs_style,
                    'style_6' => $style_6,
                    'newproducts' => $newproducts,
                    'bestsellersproducts' => $bestsellersproducts,
                    'specialproducts' => $specialproducts,
                    'featureproducts' => $featureproducts,
                    'xl' => $xl_number,
                    'lg' => $lg_number,
                    'md' => $md_number,
                    'xs' => $number,
                    'column' => $column,
                    'number_row' => $number_row,
                    'show_arrows' => $show_arrows,
                    'show_dots' => $show_dots,
                    'autoplay' => $autoplay,
                    'spacing' => $spacing,
                    'el_class' => $el_class,
                    'novconfig' => $novconfig
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_ProductTabs/'. $display_type .'.tpl', 'novmanagevcaddons'));

            return $output;
        }

    }
    // end class
    // new nov_producttabs;
}
