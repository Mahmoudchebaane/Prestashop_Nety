<?php

/*
 * Add-on Name: Info Tables for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if ( ! class_exists( 'Ultimate_Info_Table' ) ) {

	class Ultimate_Info_Table {

		public $vcaddonsinstance, $context;
		function __construct() {
			$this->context          = Context::getContext();
			$this->vcaddonsinstance = jscomposer::getInstance();
			// add_action("admin_init",array($this,"ultimate_it_init"));
			JsComposer::add_shortcode( 'ultimate_info_table', array( $this, 'ultimate_it_shortcode' ) );
		}

		function ultimate_it_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Info Tables' ),
						'base'        => 'ultimate_info_table',
						'class'       => 'vc_ultimate_info_table',
						'icon'        => 'vc_ultimate_info_table',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Create nice looking info tables.' ),
						'params'      => array(
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Select Design Style' ),
								'param_name'  => 'design_style',
								'value'       => array(
									'Design 01' => 'design01',
									'Design 02' => 'design02',
									'Design 03' => 'design03',
									'Design 04' => 'design04',
									'Design 05' => 'design05',
									'Design 06' => 'design06',
								),
								'description' => $vc->l( 'Select Info table design you would like to use' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Select Color Scheme' ),
								'param_name'  => 'color_scheme',
								'value'       => array(
									'Black'           => 'black',
									'Red'             => 'red',
									'Blue'            => 'blue',
									'Yellow'          => 'yellow',
									'Green'           => 'green',
									'Gray'            => 'gray',
									'Design Your Own' => 'custom',
								),
								'description' => $vc->l( 'Which color scheme would like to use?' ),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Main background Color' ),
								'param_name'  => 'color_bg_main',
								'value'       => '',
								'description' => $vc->l( 'Select normal background color.' ),
								'dependency'  => array(
									'element' => 'color_scheme',
									'value'   => array( 'custom' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Main text Color' ),
								'param_name'  => 'color_txt_main',
								'value'       => '',
								'description' => $vc->l( 'Select normal background color.' ),
								'dependency'  => array(
									'element' => 'color_scheme',
									'value'   => array( 'custom' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Highlight background Color' ),
								'param_name'  => 'color_bg_highlight',
								'value'       => '',
								'description' => $vc->l( 'Select highlight background color.' ),
								'dependency'  => array(
									'element' => 'color_scheme',
									'value'   => array( 'custom' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Highlight text Color' ),
								'param_name'  => 'color_txt_highlight',
								'value'       => '',
								'description' => $vc->l( 'Select highlight background color.' ),
								'dependency'  => array(
									'element' => 'color_scheme',
									'value'   => array( 'custom' ),
								),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Heading' ),
								'param_name'  => 'package_heading',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( 'The title of Info Table' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Sub Heading' ),
								'param_name'  => 'package_sub_heading',
								'value'       => '',
								'description' => $vc->l( ' Describe the info table in one line' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Icon to display:' ),
								'param_name'  => 'icon_type',
								'value'       => array(
									'No Icon'           => 'none',
									'Font Icon Manager' => 'selector',
									'Custom Image Icon' => 'custom',
								),
								'description' => $vc->l( 'Use an existing font icon</a> or upload a custom image.' ),
							),
							array(
								'type'        => 'icon_manager',
								'class'       => '',
								'heading'     => $vc->l( 'Select Icon ' ),
								'param_name'  => 'icon',
								'value'       => '',
								'description' => $vc->l( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=font-icon-Manager' target='_blank'>add new here</a>." ),
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => array( 'selector' ),
								),
							),
							array(
								'type'        => 'attach_image',
								'class'       => '',
								'heading'     => $vc->l( 'Upload Image Icon:' ),
								'param_name'  => 'icon_img',
								'value'       => '',
								'description' => $vc->l( 'Upload the custom image icon.' ),
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => array( 'custom' ),
								),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Image Width' ),
								'param_name'  => 'img_width',
								'value'       => 48,
								'min'         => 16,
								'max'         => 512,
								'suffix'      => 'px',
								'description' => $vc->l( 'Provide image width' ),
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => array( 'custom' ),
								),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Size of Icon' ),
								'param_name'  => 'icon_size',
								'value'       => 32,
								'min'         => 12,
								'max'         => 72,
								'suffix'      => 'px',
								'description' => $vc->l( 'How big would you like it?' ),
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => array( 'selector' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Color' ),
								'param_name'  => 'icon_color',
								'value'       => '#333333',
								'description' => $vc->l( 'Give it a nice paint!' ),
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => array( 'selector' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Icon Style' ),
								'param_name'  => 'icon_style',
								'value'       => array(
									'Simple'            => 'none',
									'Circle Background' => 'circle',
									'Square Background' => 'square',
									'Design your own'   => 'advanced',
								),
								'description' => $vc->l( 'We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.' ),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Background Color' ),
								'param_name'  => 'icon_color_bg',
								'value'       => '#ffffff',
								'description' => $vc->l( 'Select background color for icon.' ),
								'dependency'  => array(
									'element' => 'icon_style',
									'value'   => array( 'circle', 'square', 'advanced' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Icon Border Style' ),
								'param_name'  => 'icon_border_style',
								'value'       => array(
									'None'   => '',
									'Solid'  => 'solid',
									'Dashed' => 'dashed',
									'Dotted' => 'dotted',
									'Double' => 'double',
									'Inset'  => 'inset',
									'Outset' => 'outset',
								),
								'description' => $vc->l( 'Select the border style for icon.' ),
								'dependency'  => array(
									'element' => 'icon_style',
									'value'   => array( 'advanced' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Border Color' ),
								'param_name'  => 'icon_color_border',
								'value'       => '#333333',
								'description' => $vc->l( 'Select border color for icon.' ),
								'dependency'  => array(
									'element'   => 'icon_border_style',
									'not_empty' => true,
								),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Border Width' ),
								'param_name'  => 'icon_border_size',
								'value'       => 1,
								'min'         => 1,
								'max'         => 10,
								'suffix'      => 'px',
								'description' => $vc->l( 'Thickness of the border.' ),
								'dependency'  => array(
									'element'   => 'icon_border_style',
									'not_empty' => true,
								),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Border Radius' ),
								'param_name'  => 'icon_border_radius',
								'value'       => 500,
								'min'         => 1,
								'max'         => 500,
								'suffix'      => 'px',
								'description' => $vc->l( '0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels).' ),
								'dependency'  => array(
									'element'   => 'icon_border_style',
									'not_empty' => true,
								),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Background Size' ),
								'param_name'  => 'icon_border_spacing',
								'value'       => 50,
								'min'         => 30,
								'max'         => 500,
								'suffix'      => 'px',
								'description' => $vc->l( 'Spacing from center of the icon till the boundary of border / background' ),
								'dependency'  => array(
									'element' => 'icon_style',
									'value'   => array( 'advanced' ),
								),
							),
							array(
								'type'        => 'textarea_html',
								'class'       => '',
								'heading'     => $vc->l( 'Features' ),
								'param_name'  => 'content',
								'value'       => '',
								'description' => $vc->l( 'Describe the Info Table in brief.' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Add link' ),
								'param_name'  => 'use_cta_btn',
								'value'       => array(
									'No Link'              => '',
									'Call to Action Button' => 'true',
									'Link to Complete Box' => 'box',
								),
								'description' => $vc->l( 'Do you want to display call to action button?' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Call to action button text' ),
								'param_name'  => 'package_btn_text',
								'value'       => '',
								'description' => $vc->l( 'Enter call to action button text' ),
								'dependency'  => array(
									'element' => 'use_cta_btn',
									'value'   => array( 'true' ),
								),
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => $vc->l( 'Call to action link' ),
								'param_name'  => 'package_link',
								'value'       => '',
								'description' => $vc->l( 'Select / enter the link for call to action button' ),
								'dependency'  => array(
									'element' => 'use_cta_btn',
									'value'   => array( 'true', 'box' ),
								),
							),
							/* typoraphy - heading */
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Heading Settings' ),
								'param_name'       => 'heading_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'heading_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'heading_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'heading_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'heading_font_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'heading_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							/* typoraphy - sub heading */
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Sub-Heading Settings' ),
								'param_name'       => 'subheading_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'subheading_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'subheading_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'subheading_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'subheading_font_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'subheading_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							/* typoraphy - feature */
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Features Settings' ),
								'param_name'       => 'features_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'features_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'features_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'features_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'features_font_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'features_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							/* typoraphy - button */
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Button Settings' ),
								'param_name'       => 'button_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'button_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'button_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'button_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'button_font_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'button_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							// Customize everything
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Extra Class' ),
								'param_name'  => 'el_class',
								'value'       => '',
								'description' => $vc->l( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.' ),
							),
							array(
								'type'             => 'heading',
								'param_name'       => 'notification',
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							),
						), // params
					)
				); // vc_map
			}
		}

		function ultimate_it_shortcode( $atts, $content = null ) {
			$design_style = '';
			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/animate.min.css" );
			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/pricing.min.css" );

			extract(
				JsComposer::shortcode_atts(
					array(
						'design_style' => '',
					),
					$atts
				)
			);
			$output = '';
			include_once jscomposer::get_module_dir( 'include/smartultimatevcaddons/templates/info-tables/info-table-' . $design_style . '.php' );
			$design_func = 'generate_' . $design_style;
			$design_cls  = 'Info_' . ucfirst( $design_style );
			$class       = new $design_cls();
			$output     .= $class->generate_design( $atts, $content );
			return $output;
		}

	}

	// class Ultimate_Info_Table
	// new Ultimate_Info_Table;
}
