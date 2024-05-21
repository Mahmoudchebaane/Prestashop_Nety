<?php

/*
 * Add-on Name: Pricing Tables for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if ( ! class_exists( 'Ultimate_Pricing_Table' ) ) {

	class Ultimate_Pricing_Table {

		public $vcaddonsinstance, $context;

		function __construct() {
			$this->context          = Context::getContext();
			$this->vcaddonsinstance = jscomposer::getInstance();

			// add_action("admin_init",array($this,"ultimate_pricing_init"));
			JsComposer::add_shortcode( 'ultimate_pricing', array( &$this, 'ultimate_pricing_shortcode' ) );

		}

		function ultimate_pricing_styles() {

			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/pricing.min.css" );
		}

		function ultimate_pricing_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Price Box' ),
						'base'        => 'ultimate_pricing',
						'class'       => 'vc_ultimate_pricing',
						'icon'        => 'vc_ultimate_pricing',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Create nice looking pricing tables.' ),
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
								'description' => $vc->l( 'Select Pricing table design you would like to use' ),
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
								'heading'     => $vc->l( 'Package Name / Title' ),
								'param_name'  => 'package_heading',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( 'Enter the package name or table heading' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Sub Heading' ),
								'param_name'  => 'package_sub_heading',
								'value'       => '',
								'description' => $vc->l( 'Enter short description for this package' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Package Price' ),
								'param_name'  => 'package_price',
								'value'       => '',
								'description' => $vc->l( 'Enter the price for this package. e.g. $157' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Price Unit' ),
								'param_name'  => 'package_unit',
								'value'       => '',
								'description' => $vc->l( 'Enter the price unit for this package. e.g. per month' ),
							),
							array(
								'type'        => 'textarea_html',
								'class'       => '',
								'heading'     => $vc->l( 'Features' ),
								'param_name'  => 'content',
								'value'       => '',
								'description' => $vc->l( 'Create the features list using un-ordered list elements.' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Button Text' ),
								'param_name'  => 'package_btn_text',
								'value'       => '',
								'description' => $vc->l( 'Enter call to action button text' ),
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => $vc->l( 'Button Link' ),
								'param_name'  => 'package_link',
								'value'       => '',
								'description' => $vc->l( 'Select / enter the link for call to action button' ),
							),
							array(
								'type'       => 'checkbox',
								'class'      => '',
								'heading'    => $vc->l( '' ),
								'param_name' => 'package_featured',
								'value'      => array( 'Make this pricing box as featured' => 'enable' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => $vc->l( 'Extra class name', 'js_composer' ),
								'param_name'  => 'el_class',
								'description' => $vc->l( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
							),
							/* typoraphy - package */
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Package Name/Title Settings' ),
								'param_name'       => 'package_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'package_name_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'package_name_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'package_name_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'package_name_font_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'package_name_line_height',
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
							/* typoraphy - price */
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Price Settings' ),
								'param_name'       => 'price_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'price_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'price_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'price_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'price_font_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'price_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							/* typoraphy - price unit */
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Price Unit Settings' ),
								'param_name'       => 'price_unit_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'price_unit_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'price_unit_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'price_unit_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'price_unit_font_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'price_unit_line_height',
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
						), // params
					)
				); // vc_map
			}
		}

		function ultimate_pricing_shortcode( $atts, $content = null ) {
			$design_style = '';
			$this->ultimate_pricing_styles();
			extract(
				JsComposer::shortcode_atts(
					array(
						'design_style' => '',
					),
					$atts
				)
			);
			$output = '';
			require_once jscomposer::get_module_dir( 'include/smartultimatevcaddons/templates/pricing/pricing-' . $design_style . '.php' );
			$design_func = 'generate_' . $design_style;
			$design_cls  = 'Pricing_' . ucfirst( $design_style );
			$class       = new $design_cls();
			$output     .= $class->generate_design( $atts, $content );
			return $output;
		}

	}

	// class Ultimate_Pricing_Table
	// new Ultimate_Pricing_Table;
}
