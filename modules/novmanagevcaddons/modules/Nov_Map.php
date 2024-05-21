<?php
/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */

if (!class_exists("Nov_Map")) {

    class Nov_Map {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_map", array($this, "nov_map_shortcode"));
        }

        function nov_map_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Map'), 'Style');

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Google Map"),
                        "base" => "nov_map",
                        "class" => "vc_nov_map",
                        "icon" => "vc_nov_map",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a google map."),
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type'        => 'textarea_safe',
                                'heading'     => $vc->l('Map embed iframe'),
                                'param_name'  => 'link',
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => $vc->l('Map height'),
                                'param_name'  => 'size',
                                'admin_label' => true,
                                'description' => $vc->l('Enter map height in pixels. Example: 200 or leave it empty to make map responsive.'),
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => $vc->l('Map Width'),
                                'param_name'  => 'novmapwidth',
                                'admin_label' => true,
                                'description' => $vc->l('Enter the map height in pixels or %. Example: 100%, 200px or leave it blank to make the map responsive'),
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of map.')
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

        function nov_map_shortcode($atts, $content = null) {
            $output = $title = $link = $size = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'link' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7125.249170941621!2d-2.2452478494842634!3d53.479561369319754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487a4d4c5226f5db%3A0xd9be143804fe6baa!2zTWFuY2hlc3RlciwgVsawxqFuZyBRdeG7kWMgQW5o!5e1!3m2!1svi!2s!4v1649406181827!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'size' => '',
                'novmapwidth' => '100%',
                'display_type' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );
            
            $link = vc_value_from_safe( $link);

            $size = str_replace( array( 'px', ' ' ), array( '', '' ), $size );

            if ( is_numeric( $size ) ){ 
                $link = preg_replace( '/height="[0-9]*"/', 'height="' . $size . '"', $link );
            }
            
            $novmapwidth = str_replace( array( 'px', ' ' ), array( '', '' ), $novmapwidth );
            $novmapwidth = str_replace( array( '%', ' ' ), array( '%', '%' ), $novmapwidth );
            
            if ( is_numeric( $novmapwidth ) ) {
                $link = preg_replace( '/width="[0-9]*"/', 'width="' . $novmapwidth . '"', $link );
            }
            else{
                $link = preg_replace( '/width="[0-9]*"/', 'width="' . $novmapwidth . '"', $link );
            }
            
            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'link' => $link,
                    'size' => $size,
                    'novmapwidth' => $novmapwidth,
                    'el_class' => $el_class,
                )
            );


            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Map/'. $display_type .'.tpl', 'novmanagevcaddons'));



            if(isset($css) && !empty($css)){
                $css_out = '<style>'.$css.'</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }
    // end class
    // new nov_contact;
}
