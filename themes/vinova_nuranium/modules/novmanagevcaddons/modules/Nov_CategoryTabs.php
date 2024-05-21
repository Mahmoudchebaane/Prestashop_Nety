<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */

if (!class_exists("Nov_CategoryTabs")) {

    class Nov_CategoryTabs {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();
            JsComposer::add_shortcode("nov_categorytabs", array($this, "nov_categorytabs_shortcode"));
        }

        function nov_categorytabs_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_CategoryTabs'), 'Style');

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
                        "name" => $vc->l("Nov Category Tabs"),
                        "base" => "nov_categorytabs",
                        "class" => "vc_nov_categorytabs",
                        "icon" => "vc_nov_categorytabs",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a product category tabs."),
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
                                'description' => $vc->l('Select Number row for Product List type slider.')
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
                                'type' => 'dropdown',
                                'heading' => $vc->l('Desktop: Number product per line'),
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

        function nov_categorytabs_shortcode($atts, $content = null) {
            $output = $title = $el_class = $css_class = '';
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'title_align' => '',
                'title_style' => '1',
                'id_categorys' => '4-5-2',
                'limit' => '12',
                'orderby' => 'id_product',
                'order' => 'DESC',
                'display_type' => 'category-default',
                'number_row' => '',
                'spacing' => '',
                'xl_number' => '',
                'lg_number' => '4',
                'md_number' => '',
                'number' => '',
                'el_class' => ''
            ), $atts));


            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $column = novmanagevcaddons::get_classnumbercolumn($xl_number, $lg_number, $md_number, $number);
            
            $novconfig = novmanagevcaddons::getConfigTheme();

            $catids = str_replace('-',',',$id_categorys);
            $catids = substr($catids,strlen($catids)-1) == ',' ? substr($catids,0, -1) : $catids;
            
            $arraycatids = explode(',', $catids);
            
            
            $categoryarray= array();
            if($arraycatids){
                foreach($arraycatids as $id_category){
                    $category = new Category((int)$id_category,Context::getContext()->language->id);

                    $filter = '';
                        if($id_category && $id_category != ''){
                            $filter = 'cp.`id_category` IN (' . pSQL($id_category) . ')';
                            // echo "<pre>".print_r($filter,1);die();
                        }
                    $category_products = novmanagevcaddons::NovgetProducts($filter, (int) Context::getContext()->language->id, 0, $limit, false, $orderby, $order);
                    
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
                    
                    if ($category_products) {
                        foreach ($category_products as &$product) {
                            $product= $presenter->present(
                                $presentationSettings,
                                $assembler->assembleProduct($product),
                                Context::getContext()->language
                            );
                        }
                    }
                    $categoryarray[$category->id_category]['name']             = $category->name;
                    $categoryarray[$category->id_category]['products']         = $category_products;
                    $categoryarray[$category->id_category]['image_urls'] = [];

                    $files = scandir(_PS_CAT_IMG_DIR_);

                    if (count(preg_grep('/^'.$id_category.'-([0-9])?_thumb.jpg/i', $files)) > 0) {
                        foreach ($files as $file) {
                            if (preg_match('/^'.$id_category.'-([0-9])?_thumb.jpg/i', $file) === 1) {
                                $image_url = Context::getContext()->link->getMediaLink(_THEME_CAT_DIR_.$file);
                                $categoryarray[$category->id_category]['image_urls']['value'] = $image_url;
                            }
                        }

                    }
                    

                }
            }
            
            
            $context->smarty->assign(
                array(
                    'products' => $categoryarray,
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'title_align' => $title_align,
                    'title_style' => $title_style,
                    'nov_dir' => _PS_THEME_DIR_,
                    'spacing' => $spacing,
                    'xl' => $xl_number,
                    'md' => $md_number,
                    'lg' => $lg_number,
                    'xs' => $number,
                    'column' => $column,
                    'tab'   => rand(10,rand()),
                    'number_row' => $number_row,
                    'el_class' => $el_class,
                    'novconfig' => $novconfig
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_CategoryTabs/'. $display_type .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_categorytabs;
}