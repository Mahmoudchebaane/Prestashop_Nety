
<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Image_Slider")) {

  class Nov_Image_Slider {

    public $vcaddonsinstance, $context;

    function __construct() {
      $this->vcaddonsinstance = novmanagevcaddons::getInstance();
      $this->context = Context::getContext();

      JsComposer::add_shortcode("nov_image_slider", array($this, "nov_image_slider_shortcode"));
    }


    function nov_Image_Slider_init() {
      $vc = vc_manager();
      $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Image_Slider'), 'Style');
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
            "name" => $vc->l("Nov Image Slider"),
            "base" => "nov_image_slider",
            "class" => "vc_nov_image_slider)",
            "icon" => "vc_element-icon http://localhost/prestashop_nuranium/modules/ps_categorytree/logo.png",
            "category" => $vc->l("Vinova Items"),
            "description" => $vc->l("Add a image slider item."),
            "params" => array(
              array(
                'type' => 'attach_images',
                'class' => '',
                'heading' => $vc->l('Slider Image'),
                'param_name' => 'slider_image',
                'value' => '',
                'description' => $vc->l('Upload the image you want.')
              ),
              array(
                'type' => 'exploded_textarea',
                'heading' => $vc->l('Custom links'),
                'param_name' => 'custom_links',
                'description' => $vc->l('Enter links for each slide here. Divide links with linebreaks or comma (Enter) or (,) . '),
              ),
              array(
                  'type' => 'dropdown',
                  'heading' => $vc->l('Style'),
                  'param_name' => 'image_style',
                  'admin_label' => true,
                  'value' => $style,
                  'description' => $vc->l('Select type of Image Style.')
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
                'heading' => $vc->l('Number row'),
                'param_name' => 'number_row',
                'std' => '1',
                'value' => array(
                  '1' => '1',
                  '2' => '2',
                  '3' => '3'
                )
              ),
              array(
                'type' => 'checkbox',
                'heading' => $vc->l( 'Show Arrows'),
                'param_name' => 'show_arrows',
                'description' => $vc->l( 'If checked row will be set to show arrows slider.'),
                'value' => array( $vc->l( 'Yes') => 'true' ),
              ),
              array(
                'type' => 'checkbox',
                'heading' => $vc->l( 'Show dots'),
                'param_name' => 'show_dots',
                'description' => $vc->l( 'If checked row will be set to show dots slider.'),
                'value' => array( $vc->l( 'Yes') => 'true' ),
              ),
              array(
                'type' => 'checkbox',
                'heading' => $vc->l( 'Autoplay'),
                'param_name' => 'autoplay',
                'description' => $vc->l( 'If checked row will be set to autoplay slider.'),
                'value' => array( $vc->l( 'Yes') => 'true' ),
              ),
              array(
                'type' => 'dropdown',
                'heading' => $vc->l('Desktop: Number image per line'),
                'param_name' => 'xl_number',
                'std' => '4',
                'value' => $screennumber
              ),
              array(
                'type' => 'dropdown',
                'heading' => $vc->l('Tablet: Number image per line'),
                'param_name' => 'md_number',
                'std' => '3',
                'value' => $screennumber
              
              ),
              array(
                'type' => 'dropdown',
                'heading' => $vc->l('Mobile: Number image per line'),
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

    function nov_image_slider_shortcode($atts, $content = null) {
      $output = $slider_image = $el_class = '';
      extract(JsComposer::shortcode_atts(array(
        'slider_image' => '',
        'custom_links' => '',
        'image_style' => '',
        'number_row' => '',
        'spacing' => '',
        'show_arrows' => '',
        'show_dots' => '',
        'autoplay' => '',
        'xl_number' => '',
        'md_number' => '',
        'number' => '',
        'el_class' => ''
      ), $atts));

      $context = Context::getContext();

      $el_class = novmanagevcaddons::getExtraClass( $el_class );

      $slider_image = explode(',', $slider_image);

      if (isset($custom_links) && $custom_links !='') {
        $custom_links = explode( ',', $custom_links );
      }

      $images = array();
      foreach ($slider_image as $key => $item) {
        $images[] = '<a href = "'.$custom_links[$key].'">' . '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($item) . '" class="img-fluid" />' . '</a>';
      }

      $context->smarty->assign(
        array(
          'images' => $images,
          'xl' => $xl_number,
          'image_style' => $image_style,
          'md' => $md_number,
          'xs' => $number,
          'spacing' => $spacing,
          'number_row' => $number_row,
          'show_arrows' => $show_arrows,
          'show_dots' => $show_dots,
          'autoplay' => $autoplay,
          'el_class' => $el_class
        )
      );

      $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Image_Slider/'. $image_style .'.tpl', 'novmanagevcaddons'));

      if(isset($css) && !empty($css)){
        $css_out = '<style>' . $css .'</style>';
        $output .= $css_out;
      }

      return $output;
    }

  }
  // end class
  // new nov_image_slider
}
