
<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Image_Gallery")) {

    class Nov_Image_Gallery {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_image_gallery", array($this, "nov_image_gallery_shortcode"));
        }

        function nov_image_gallery_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Image_Gallery'), 'Style');
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
                            "name" => $vc->l("Nov Image Gallery"),
                            "base" => "nov_image_gallery",
                            "class" => "vc_nov_image_gallery)",
                            "icon" => "vc_element-icon http://localhost/prestashop_nuranium/modules/ps_categorytree/logo.png",
                            "category" => $vc->l("Vinova Items"),
                            "description" => $vc->l("Add a image gallery item."),
                            "params" => array(
                                array(
                                    'type' => 'attach_images',
                                    'class' => '',
                                    'heading' => $vc->l('Image'),
                                    'param_name' => 'gallery_image',
                                    'value' => '',
                                    'description' => $vc->l('Upload the image you want.')
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => $vc->l('Display style'),
                                    'param_name' => 'display_type',
                                    'admin_label' => true,
                                    'value' => $style,
                                    'description' => $vc->l('Select type of Gallery.')
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
                                    "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1'))
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => $vc->l('Show Arrows'),
                                    'param_name' => 'show_arrows',
                                    'description' => $vc->l('If checked row will be set to show arrows slider.'),
                                    'value' => array($vc->l('Yes') => 'true'),
                                    "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1'))
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => $vc->l('Show dots'),
                                    'param_name' => 'show_dots',
                                    'description' => $vc->l('If checked row will be set to show dots slider.'),
                                    'value' => array($vc->l('Yes') => 'true'),
                                    "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1'))
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => $vc->l('Autoplay'),
                                    'param_name' => 'autoplay',
                                    'description' => $vc->l('If checked row will be set to autoplay slider.'),
                                    'value' => array($vc->l('Yes') => 'true'),
                                    "dependency" => array('element' => 'display_type', 'value' => array('slider-type-1'))
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => $vc->l('Spacing'),
                                    'param_name' => 'spacing',
                                    'std' => '1',
                                    'value' => array(
                                        '0' => '0',
                                        '5' => '5',
                                        '10' => '10',
                                        '15' => '15',
                                        '20' => '20',
                                        '25' => '25',
                                        '30' => '30',
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

        function nov_image_gallery_shortcode($atts, $content = null) {
            $output = $gallery_image = $el_class = '';
            extract(JsComposer::shortcode_atts(array(
                        'gallery_image' => '',
                        'display_type' => 'style-1',
                        'show_arrows' => '',
                        'show_dots' => '',
                        'autoplay' => '',
                        'spacing' => '',
                        'number_row' => '',
                        'xl_number' => '',
                        'md_number' => '',
                        'number' => '',
                        'el_class' => ''
                            ), $atts));

            $context = Context::getContext();

            $el_class = novmanagevcaddons::getExtraClass($el_class);

            $gallery_image = explode(',', $gallery_image);


            $images = array();
            foreach ($gallery_image as $item) {
                $images[] = '<a class="thumbnail" href = "#" data-image-id="" data-toggle="modal" data-title=""
                   data-image="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($item) . '"
                   data-target="#image-gallery">' . '<img class="img_thumbnail" src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($item) . '" class="img-fluid" />' . '</a>';
            }
            $column = novmanagevcaddons::get_classnumbercolumn($xl_number, $md_number, $number);
            $context->smarty->assign(
                    array(
                        'images' => $images,
                        'number_row' => $number_row,
                        'show_arrows' => $show_arrows,
                        'show_dots' => $show_dots,
                        'autoplay' => $autoplay,
                        'xl' => $xl_number,
                        'md' => $md_number,
                        'xs' => $number,
                        'column' => $column,
                        'spacing' => $spacing,
                        'el_class' => $el_class
                    )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Image_Gallery/' . $display_type . '.tpl', 'novmanagevcaddons'));

            if (isset($css) && !empty($css)) {
                $css_out = '<style>' . $css . '</style>';
                $output .= $css_out;
            }

            return $output;
        }

    }

    // end class
    // new nov_image_gallery
}
