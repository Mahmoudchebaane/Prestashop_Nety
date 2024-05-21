<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Blog_List")) {

    class Nov_Blog_List {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_blog_list", array($this, "nov_blog_list_shortcode"));
        }

        function nov_blog_list_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Blog_List'), 'Style');

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
                        "name" => $vc->l("Nov Blog List"),
                        "base" => "nov_blog_list",
                        "class" => "vc_nov_blog_list",
                        "icon" => "vc_nov_blog_list",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a blog list."),
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
                                    '4' => '4',
                                    '5' => '5'
                                ),
                                'description' => $vc->l('Select title style.'),
                                'dependency' => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6', 'slider-type-7', 'slider-type-8', 'slider-type-9', 'slider-type-10'))
                            ),
                            array(
                                'type' => 'loop',
                                'heading' => $vc->l('Data content'),
                                'param_name' => 'loop',
                                'settings' => array(
                                    'size' => array( 'hidden' => false, 'value' => 10 ),
                                    'order_by' => array( 'value' => 'id_post' ),
                                    'order' => array( 'value' => 'DESC' ),
                                ),
                                'description' => $vc->l('Create SmartBlog loop, to populate content from your site.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of Blog List.')
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
                                'description' => $vc->l('Select Number row for Blog List type slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show Arrows'),
                                'param_name' => 'show_arrows',
                                'description' => $vc->l( 'If checked row will be set to show arrows slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show dots'),
                                'param_name' => 'show_dots',
                                'description' => $vc->l( 'If checked row will be set to show dots slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Autoplay'),
                                'param_name' => 'autoplay',
                                'description' => $vc->l( 'If checked row will be set to autoplay slider.'),
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1', 'slider-type-2', 'slider-type-3', 'slider-type-4', 'slider-type-5', 'slider-type-6'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Desktop: Number post per line'),
                                'param_name' => 'xl_number',
                                'std' => '4',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Tablet: Number post per line'),
                                'param_name' => 'md_number',
                                'std' => '3',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Mobile: Number post per line'),
                                'param_name' => 'number',
                                'std' => '2',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Show Read more'),
                                'param_name' => 'readmore',
                                'admin_label' => false,
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'dependency' => array('element' => 'display_type', 'value' => array('slider-type-10'))
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

        function nov_blog_list_shortcode($atts, $content = null) {
            $output = $title = $el_class = $css_class = '';
            $vc_manager = vc_manager();
            $posts = array();
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'title1' => '',
                'sub_title' => '',
                'title_align' => '',
                'title_style' => '1',
                'loop' => '',
                'orderby' => 'id_post',
                'order' => 'DESC',
                'display_type' => 'grid-type',
                'number_row' => '',
                'show_arrows' => '',
                'show_dots' => '',
                'autoplay' => '',
                'xl_number' => '',
                'md_number' => '',
                'number' => '',
                'readmore' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $show_arrows = ($show_arrows == 'true') ? 'true' : 'false';
            $show_dots = ($show_dots == 'true') ? 'true' : 'false';
            $autoplay = ($autoplay == 'true') ? 'true' : 'false';

            if ( empty( $loop ) ) return;

            $loop_args = novmanagevcaddons::parseData($loop);
            $order_by = (isset($loop_args['order_by'])) ? $loop_args['order_by'] : 'id_post';
            $order = (isset($loop_args['order'])) ? $loop_args['order'] : 'DESC';
            $categories = (isset($loop_args['categories'])) ? $loop_args['categories'] : '';
            $tags = (isset($loop_args['tags'])) ? $loop_args['tags'] : '';
            //NovgetBlogs($filter, $limit = 12, $order_by = null, $order_way = null, $category, $tag) {
            $posts = novmanagevcaddons::NovgetBlogs('', $loop_args['size'], $order_by, $order, $categories, $tags);

            $column = novmanagevcaddons::get_classnumbercolumn($xl_number, $md_number, $number);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'posts' => $posts,
                    'nov_modules_dir' => _MODULE_DIR_,
                    'title' => $title,
                    'title1' => $title1,
                    'sub_title' => $sub_title,
                    'title_align' => $title_align,
                    'title_style' => $title_style,
                    'xl' => $xl_number,
                    'md' => $md_number,
                    'xs' => $number,
                    'column' => $column,
                    'number_row' => $number_row,
                    'show_arrows' => $show_arrows,
                    'show_dots' => $show_dots,
                    'autoplay' => $autoplay,
                    'readmore' => $readmore,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Blog_List/'. $display_type .'.tpl', 'novmanagevcaddons'));

            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_blog_list;
}