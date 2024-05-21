<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Heading_Group")) {

    class Nov_Heading_Group {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_heading_group", array($this, "nov_heading_group_shortcode"));
        }

        function nov_heading_group_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Heading_Group'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Heading Group"),
                        "base" => "nov_heading_group",
                        "class" => "vc_nov_heading_group",
                        "icon" => "vc_nov_heading_group",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a heading group."),
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
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
                                    '4' => '4',
                                    '5' => '5'
                                ),
                                'description' => $vc->l('Select title style.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of instagram list.')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show view all'),
                                'param_name' => 'view_all',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title view all'),
                                'param_name' => 'view_all_text',
                                'dependency' => array('element' => 'view_all', 'value' => array('true'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Link view all'),
                                'param_name' => 'view_all_link',
                                'dependency' => array('element' => 'view_all', 'value' => array('true'))
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
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show Custom Arrow Slider'),
                                'param_name' => 'show_arrow_custom',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'description' => $vc->l('Only show when bellow have product slider')
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

        function nov_heading_group_shortcode($atts, $content = null) {
            $output = $title = $el_class = $css_class = '';
            $vc_manager = vc_manager();
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'title_align' => '',
                'title_style' => '1',
                'display_type' => 'default',
                'view_all' => '',
                'view_all_text' => '',
                'view_all_link' => '',
                'id_categorys' => null,
                'show_arrow_custom' => '',
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
                    'title_align' => $title_align,
                    'title_style' => $title_style,
                    'view_all' => $view_all,
                    'view_all_text' => $view_all_text,
                    'view_all_link' => $view_all_link,
                    'categories' => $categories,
                    'show_arrow_custom' => $show_arrow_custom,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Heading_Group/'. $display_type .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_heading_group;
}