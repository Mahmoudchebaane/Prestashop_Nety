<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_SingleProduct")) {

    class Nov_SingleProduct {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_singleproduct", array($this, "nov_singleproduct_shortcode"));
        }

        function nov_singleproduct_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_SingleProduct'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Single Product"),
                        "base" => "nov_singleproduct",
                        "class" => "vc_nov_singleproduct",
                        "icon" => "vc_nov_singleproduct",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a product single."),
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
                                'type' => 'autocomplete',
                                'heading' => $vc->l( 'Select product'),
                                'param_name' => 'id_product',
                                'description' => $vc->l( 'Enter product title to see suggestions'),
                                'settings' => array(
                                    'vc_catalog_type' => 'product',
                                    'multiple' => false
                                )
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

        function nov_singleproduct_shortcode($atts, $content = null) {
            $output = $title = $el_class = $css_class = '';
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'title_align' => '',
                'id_product' => null,
                'display_type' => 'stype-1',
                'el_class' => ''
            ), $atts));

            if(empty($id_product)) return ;

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $exid = str_replace('-', ',', $id_product);
            $exid = substr($exid,strlen($exid)-1) == ',' ? substr($exid,0,-1) : $exid;

            $product = vccontentanywhere::getSelectedProducts($exid);

            if(!$product){
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

            foreach ($product as $rawProduct) {
                $products_for_template[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($rawProduct),
                    $context->language
                );
            }

            $context->smarty->assign(
                array(
                    'products' => $products_for_template,
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'title_align' => $title_align,
                    'display_type' => $display_type,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_SingleProduct/'. $display_type .'.tpl', 'novmanagevcaddons'));

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