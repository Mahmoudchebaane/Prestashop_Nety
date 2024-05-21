<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_CategoryLinks")) {

    class Nov_CategoryLinks {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_categorylinks", array($this, "nov_categorylinks_shortcode"));
        }

        function nov_categorylinks_init() {
            $vc = vc_manager();

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Category Links"),
                        "base" => "nov_categorylinks",
                        "class" => "vc_nov_categorylinks",
                        "icon" => "vc_nov_categorylinks",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a list category links."),
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'autocomplete',
                                'heading' => $vc->l( 'Select category'),
                                'param_name' => 'id_categorys',
                                'description' => $vc->l( 'Enter category name to see suggestions.'),
                                'settings' => array(
                                    'vc_catalog_type' => 'category',
                                    'multiple' => true
                                )
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Style'),
                                'param_name' => 'style',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2'
                                ),
                                'description' => $vc->l('Select style for element.')
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

        function nov_categorylinks_shortcode($atts, $content = null) {
            $output = $title = $el_class = $css_class = '';
            $vc_manager = vc_manager();
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'style' => '',
                'id_categorys' => null,
                'el_class' => ''
            ), $atts));

            $context = Context::getContext();

            $catids = str_replace('-',',',$id_categorys);
            $catids = substr($catids,strlen($catids)-1) == ',' ? substr($catids,0, -1) : $catids;

            $id_categorys = explode(',',$catids);
            
            $categories = array();
            $link = new Link;

            if($id_categorys){ 
                $i = 0;
                foreach($id_categorys as $id_category){
                    $category = new Category((int)$id_category, $context->language->id);
                    if ($category->name != '') {
                        $categories[$i]['id_category'] = $id_category;
                        $categories[$i]['name'] = $category->name;
                        $categories[$i]['link'] = Tools::HtmlEntitiesUTF8($link->getCategoryLink((int)$category->id, $category->link_rewrite, $context->language->id));
                        $i++;
                    }
                }
            }

            //echo"<pre>".print_r($categories);die();

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $context->smarty->assign(
                array(
                    'title' => $title,
                    'categories' => $categories,
                    'style' => $style,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_CategoryLinks/default.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_categorylinks;
}