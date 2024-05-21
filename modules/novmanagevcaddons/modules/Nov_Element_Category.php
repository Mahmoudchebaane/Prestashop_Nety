<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Element_Category")) {

    class Nov_Element_Category {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_element_category", array($this, "nov_element_category_shortcode"));
            JsComposer::add_shortcode('nov_element_category_item',array($this,'nov_element_category_item_shortcode'));

        }

        function nov_element_category_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Element_Category'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Element Category"),
                        "base" => "nov_element_category",
                        "class" => "vc_nov_element_category",
                        "icon" => "vc_nov_element_category",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a link for Category"),
                        "as_parent" => array('only' => 'nov_element_category_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "content_element" => true,
                        "show_settings_on_create" => true,
                        "js_view" => 'VcColumnView',
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
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
                vc_map(
                    array(
                        "name" => $vc->l("Category Item"),
                        "base" => "nov_element_category_item",
                        "class" => "vc_nov_element_category_item",
                        "icon" => "vc_nov_clement_category_item",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a category item"),
                        "as_child" => array('only' => 'nov_element_category'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => $vc->l('Icon'),
                                'param_name' => 'icon',
                                'value' => '',
                                'description' => $vc->l('Upload the image you want.')
                            ),
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => $vc->l('Icon Hover'),
                                'param_name' => 'icon_hover',
                                'value' => '',
                                'description' => $vc->l('Upload the hover image you want.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Link'),
                                'param_name' => 'link',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Left'),
                                'param_name' => 'border_left',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Settings')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Right'),
                                'param_name' => 'border_right',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Settings')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Top'),
                                'param_name' => 'border_top',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Settings')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Bottom'),
                                'param_name' => 'border_bottom',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Settings')
                            ),
                            array(
                              'type' => 'dropdown',
                              'heading' => $vc->l('Col Lager Desktop'),
                              'param_name' => 'col_xl',
                              'std' => 'col-xl-3',
                              'value' => array(
                                '1 column - 1/12' => 'col-xl-1',
                                '2 column - 1/6' => 'col-xl-2',
                                '3 column - 1/4' => 'col-xl-3',
                                '4 column - 1/3' => 'col-xl-4',
                                '5 column - 5/12' => 'col-xl-5',
                                '6 column - 1/2' => 'col-xl-6'
                              ),
                              'group' => $vc->l('Responsive')
                            ),
                            array(
                              'type' => 'dropdown',
                              'heading' => $vc->l('Col Desktop'),
                              'param_name' => 'col_lg',
                              'std' => 'col-lg-3',
                              'value' => array(
                                '1 column - 1/12' => 'col-lg-1',
                                '2 column - 1/6' => 'col-lg-2',
                                '3 column - 1/4' => 'col-lg-3',
                                '4 column - 1/3' => 'col-lg-4',
                                '5 column - 5/12' => 'col-lg-5',
                                '6 column - 1/2' => 'col-lg-6'
                              ),
                              'group' => $vc->l('Responsive')
                            ),
                            array(
                              'type' => 'dropdown',
                              'heading' => $vc->l('Col Tablet'),
                              'param_name' => 'col_md',
                              'std' => 'col-md-3',
                              'value' => array(
                                '1 column - 1/12' => 'col-md-1',
                                '2 column - 1/6' => 'col-md-2',
                                '3 column - 1/4' => 'col-md-3',
                                '4 column - 1/3' => 'col-md-4',
                                '5 column - 5/12' => 'col-md-5',
                                '6 column - 1/2' => 'col-md-6'
                              ),
                              'group' => $vc->l('Responsive')
                            ),
                            array(
                              'type' => 'dropdown',
                              'heading' => $vc->l('Col Mobile'),
                              'param_name' => 'col_xs',
                              'std' => 'col-xs-1',
                              'value' => array(
                                '3 column - 1/4' => 'col-xs-3',
                                '4 column - 1/3' => 'col-xs-4',
                                '5 column - 5/12' => 'col-xs-5',
                                '6 column - 1/2' => 'col-xs-6'
                              ),
                              'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Left Desktop'),
                                'param_name' => 'border_left_lg',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Left Tablet'),
                                'param_name' => 'border_left_md',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Left Mobile'),
                                'param_name' => 'border_left_xs',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Right Desktop'),
                                'param_name' => 'border_right_lg',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Right Tablet'),
                                'param_name' => 'border_right_md',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Right Mobile'),
                                'param_name' => 'border_right_xs',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Top Desktop'),
                                'param_name' => 'border_top_lg',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Top Tablet'),
                                'param_name' => 'border_top_md',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Top Mobile'),
                                'param_name' => 'border_top_xs',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Bottom Desktop'),
                                'param_name' => 'border_bottom_lg',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Bottom Tablet'),
                                'param_name' => 'border_bottom_md',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l( 'Border Bottom Mobile'),
                                'param_name' => 'border_bottom_xs',
                                'value' => array( $vc->l( 'Yes') => 'true' ),
                                'group' => $vc->l('Responsive')
                            ),
                        )
                    )
                );
            }
        }

        function nov_element_category_shortcode($atts, $content = null) {
            $output = $content_element_category = $title = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'content_element_category' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $content_element_category = JsComposer::do_shortcode($content);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'content_element_category' => $content_element_category,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Element_Category/default.tpl', 'novmanagevcaddons'));
            return $output;
        }
        function nov_element_category_item_shortcode($atts) {
            $output = $single_tab_title = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'icon' => '',
                'icon_hover' => '',
                'col_xl' => '',
                'col_lg' => '',
                'col_md' => '',
                'col_xs' => '',
                'border_left' => '',
                'border_right' => '',
                'border_top' => '',
                'border_bottom' => '',
                'border_left_lg' => '',
                'border_right_lg' => '',
                'border_top_lg' => '',
                'border_bottom_lg' => '',
                'border_left_md' => '',
                'border_right_md' => '',
                'border_top_md' => '',
                'border_bottom_md' => '',
                'border_left_xs' => '',
                'border_right_xs' => '',
                'border_top_xs' => '',
                'border_bottom_xs' => '',
                'link' => '',
            ), $atts));

            $class_catitem = '';
            $class_catitem .= $col_xl.' '.$col_lg.' '.$col_md.' '.$col_xs;
            if(isset($border_left) && $border_left == true){
                $class_catitem .= ' border_left';
            }
            if(isset($border_right) && $border_right == true){
                $class_catitem .= ' border_right';
            }
            if(isset($border_top) && $border_top == true){
                $class_catitem .= ' border_top';
            }
            if(isset($border_bottom) && $border_bottom == true){
                $class_catitem .= ' border_bottom';
            }
            if(isset($border_left) && $border_left == true){
                $class_catitem .= ' border_left';
            }
            if(isset($border_right_lg) && $border_right_lg == true){
                $class_catitem .= ' border_right_lg';
            }
            if(isset($border_top_lg) && $border_top_lg == true){
                $class_catitem .= ' border_top_lg';
            }
            if(isset($border_bottom_lg) && $border_bottom_lg == true){
                $class_catitem .= ' border_bottom_lg';
            }
            if(isset($border_left_lg) && $border_left_lg == true){
                $class_catitem .= ' border_left_lg';
            }
            if(isset($border_right_md) && $border_right_md == true){
                $class_catitem .= ' border_right_md';
            }
            if(isset($border_top_md) && $border_top_md == true){
                $class_catitem .= ' border_top_md';
            }
            if(isset($border_bottom_md) && $border_bottom_md == true){
                $class_catitem .= ' border_bottom_md';
            }
            if(isset($border_left_md) && $border_left_md == true){
                $class_catitem .= ' border_left_md';
            }
            if(isset($border_right_xs) && $border_right_xs == true){
                $class_catitem .= ' border_right_xs';
            }
            if(isset($border_top_xs) && $border_top_xs == true){
                $class_catitem .= ' border_top_xs';
            }
            if(isset($border_bottom_xs) && $border_bottom_xs == true){
                $class_catitem .= ' border_bottom_xs';
            }
            if(isset($icon_hover) && $icon_hover){
                $class_catitem .= ' hover_img';
            }

            $i_hover = '';
            if(isset($icon_hover) && $icon_hover){
                $i_hover = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon_hover) . '" class="img-fluid icon_hover" />';
            }


            $output .='<li class="'.$class_catitem.'">';
            $output .='<a href="'.$link.'">';
            $output .='<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon) . '" class="img-fluid" /> '.$i_hover.'';
            $output .='<span class="d-block title">'.$title.'</span>';
            $output .='</a>';
            $output .='</li>';

            return $output;
        }

    }
    // end class
    // new nov_element_category;
}

//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nov_element_category extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nov_element_category_item extends WPBakeryShortCode {
    }
}