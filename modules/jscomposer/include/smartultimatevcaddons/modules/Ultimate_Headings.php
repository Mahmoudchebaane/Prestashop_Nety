<?php

/*
 * Add-on Name: Ultimate Headings
 * Add-on URI: http://dev.brainstormforce.com
 */
if ( ! class_exists( 'Ultimate_Headings' ) ) {

	class Ultimate_Headings {

		public $vcaddonsinstance, $context;
		static $add_plugin_script;

		function __construct() {
			$this->vcaddonsinstance = jscomposer::getInstance();
			$this->context          = Context::getContext();
			// add_action("admin_init",array($this,"ultimate_headings_init"));
			jscomposer::add_shortcode( 'ultimate_heading', array( &$this, 'ultimate_headings_shortcode' ) );
			// if(!$this->vcaddonsinstance->is_admin())
			// add_action("wp_enqueue_scripts", array($this, "register_headings_assets"),1);
			// if(function_exists('add_shortcode_param'))
			// {
			jscomposer::add_shortcode_param( 'ultimate_margins', array( $this, 'ultimate_margins_param' ), "{$this->vcaddonsinstance->_url_ultimate}admin/vc_extend/js/vc-headings-param.js" );
			// }
		}

		function register_headings_assets() {

			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/headings.min.css" );
			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/headings.min.js" );
		}

		function ultimate_margins_param( $settings, $value ) {
			$dependency = vc_generate_dependencies_attributes( $settings );
			$positions  = $settings['positions'];
			$html       = '<div class="ultimate-margins">
				<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value ultimate-margin-value ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" value="' . $value . '" ' . $dependency . '/>';
			foreach ( $positions as $key => $position ) {
				$html .= $key . ' <input type="text" style="width:50px;padding:3px" data-hmargin="' . $position . '" class="ultimate-margin-inputs" id="margin-' . $key . '" /> &nbsp;&nbsp;';
			}
			$html .= '</div>';
			return $html;
		}

		function ultimate_headings_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Headings' ),
						'base'        => 'ultimate_heading',
						'class'       => 'vc_ultimate_heading',
						'icon'        => 'vc_ultimate_heading',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Awesome heading styles.' ),
						'params'      => array(
							array(
								'type'       => 'textfield',
								'heading'    => $vc->l( 'Title', 'js_composer' ),
								'param_name' => 'main_heading',
								'holder'     => 'div',
								'value'      => '',
							),
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Heading Settings' ),
								'param_name'       => 'main_heading_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'main_heading_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'main_heading_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'main_heading_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'main_heading_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'main_heading_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'text',
								'heading'    => $vc->l( '<h4>Enter values with respective unites. Example - 10px, 10em, 10%, etc.</h4>' ),
								'param_name' => 'margin_design_tab_text',
								'group'      => 'Design',
							),
							array(
								'type'       => 'ultimate_margins',
								'heading'    => 'Heading Margins',
								'param_name' => 'main_heading_margin',
								'positions'  => array(
									'Top'    => 'top',
									'Bottom' => 'bottom',
								),
								'group'      => 'Design',
							),
							array(
								'type'       => 'textarea_html',
								'class'      => '',
								'heading'    => $vc->l( 'Sub Heading (Optional)' ),
								'param_name' => 'content',
								'value'      => '',
							// "description" => $vc->l("Sub heading text"),
							),
							array(
								'type'        => 'dropdown',
								'heading'     => $vc->l( 'Tag' ),
								'param_name'  => 'heading_tag',
								'value'       => array(
									$vc->l( 'Default' ) => 'h2',
									$vc->l( 'H1' )      => 'h1',
									$vc->l( 'H3' )      => 'h3',
									$vc->l( 'H4' )      => 'h4',
									$vc->l( 'H5' )      => 'h5',
									$vc->l( 'H6' )      => 'h6',
								),
								'description' => $vc->l( 'Default is H2' ),
							),
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Sub Heading Settings' ),
								'param_name'       => 'sub_heading_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'sub_heading_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'sub_heading_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'sub_heading_font_size',
								'min'        => 14,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'sub_heading_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'sub_heading_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'ultimate_margins',
								'heading'    => 'Sub Heading Margins',
								'param_name' => 'sub_heading_margin',
								'positions'  => array(
									'Top'    => 'top',
									'Bottom' => 'bottom',
								),
								'group'      => 'Design',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Alignment' ),
								'param_name' => 'alignment',
								'value'      => array(
									'Center' => 'center',
									'Left'   => 'left',
									'Right'  => 'right',
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Seperator' ),
								'param_name'  => 'spacer',
								'value'       => array(
									'No Seperator'         => 'no_spacer',
									'Line'                 => 'line_only',
									'Icon'                 => 'icon_only',
									'Image'                => 'image_only',
									'Line with icon/image' => 'line_with_icon',
								),
								'description' => $vc->l( 'Horizontal line, icon or image to divide sections' ),
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Seperator Position' ),
								'param_name' => 'spacer_position',
								'value'      => array(
									'Top'    => 'top',
									'Between Heading & Sub-Heading' => 'middle',
									'Bottom' => 'bottom',
								),
								'dependency' => array(
									'element' => 'spacer',
									'value'   => array( 'line_with_icon', 'line_only', 'icon_only', 'image_only' ),
								),
							),
							array(
								'type'       => 'attach_image',
								'heading'    => $vc->l( 'Select Image' ),
								'param_name' => 'spacer_img',
								'dependency' => array(
									'element' => 'spacer',
									'value'   => array( 'image_only' ),
								),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Image Width' ),
								'param_name'  => 'spacer_img_width',
								'value'       => 48,
								'suffix'      => 'px',
								'description' => $vc->l( 'Provide image width (optional)' ),
								'dependency'  => array(
									'element' => 'spacer',
									'value'   => array( 'image_only' ),
								),
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Line Style' ),
								'param_name' => 'line_style',
								'value'      => array(
									'Solid'  => 'solid',
									'Dashed' => 'dashed',
									'Dotted' => 'dotted',
									'Double' => 'double',
									'Inset'  => 'inset',
									'Outset' => 'outset',
								),
								'dependency' => array(
									'element' => 'spacer',
									'value'   => array( 'line_with_icon', 'line_only' ),
								),
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Width (optional)' ),
								'param_name' => 'line_width',
								'suffix'     => 'px',
								'dependency' => array(
									'element' => 'spacer',
									'value'   => array( 'line_with_icon', 'line_only' ),
								),
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'line_height',
								'value'      => 1,
								'min'        => 1,
								'max'        => 500,
								'suffix'     => 'px',
								'dependency' => array(
									'element' => 'spacer',
									'value'   => array( 'line_with_icon', 'line_only' ),
								),
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Line Color' ),
								'param_name' => 'line_color',
								'value'      => '#333333',
								'dependency' => array(
									'element' => 'spacer',
									'value'   => array( 'line_with_icon', 'line_only' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Icon to display:' ),
								'param_name'  => 'icon_type',
								'value'       => array(
									'Font Icon Manager' => 'selector',
									'Custom Image Icon' => 'custom',
								),
								'dependency'  => array(
									'element' => 'spacer',
									'value'   => array( 'line_with_icon', 'icon_only' ),
								),
							),
							array(
								'type'        => 'icon_manager',
								'class'       => '',
								'heading'     => $vc->l( 'Select Icon ' ),
								'param_name'  => 'icon',
								'value'       => '',
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => array( 'selector' ),
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
								'value'       => '',
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
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => array( 'selector' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Background Color' ),
								'param_name'  => 'icon_color_bg',
								'value'       => '',
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
								'type'       => 'ultimate_margins',
								'heading'    => 'Seperator Margins',
								'param_name' => 'spacer_margin',
								'positions'  => array(
									'Top'    => 'top',
									'Bottom' => 'bottom',
								),
								'dependency' => array(
									'element' => 'spacer',
									'value'   => array( 'line_with_icon', 'line_only', 'icon_only', 'image_only' ),
								),
								'group'      => 'Design',
							),
							array(
								'type'       => 'number',
								'heading'    => 'Space between Line & Icon/Image',
								'param_name' => 'line_icon_fixer',
								'value'      => '10',
								'suffix'     => 'px',
								'dependency' => array(
									'element' => 'spacer',
									'value'   => array( 'line_with_icon' ),
								),
							),
							array(
								'type'        => 'textfield',
								'heading'     => $vc->l( 'Extra class name', 'js_composer' ),
								'param_name'  => 'el_class',
								'description' => $vc->l( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
							),
							array(
								'type'             => 'heading',
								'param_name'       => 'notification',
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							),
						),
					)
				);
			}
		}

		function ultimate_headings_shortcode( $atts, $content = null ) {
			$wrapper_style = $main_heading_style_inline = $sub_heading_style_inline = $line_style_inline = $icon_inline = $output = $el_class = '';
			extract(
				JsComposer::shortcode_atts(
					array(
						'main_heading'             => '',
						'main_heading_font_size'   => '',
						'main_heading_font_family' => '',
						'main_heading_style'       => '',
						'main_heading_color'       => '',
						'main_heading_line_height' => '',
						'main_heading_margin'      => '',
						'sub_heading'              => '',
						'sub_heading_font_size'    => '',
						'sub_heading_font_family'  => '',
						'sub_heading_style'        => '',
						'sub_heading_color'        => '',
						'sub_heading_line_height'  => '',
						'sub_heading_margin'       => '',
						'spacer'                   => '',
						'spacer_position'          => '',
						'spacer_img'               => '',
						'spacer_img_width'         => '',
						'line_style'               => 'solid',
						'line_width'               => 'auto',
						'line_height'              => '1',
						'line_color'               => '#ccc',
						'icon_type'                => '',
						'icon'                     => '',
						'icon_color'               => '',
						'icon_style'               => '',
						'icon_color_bg'            => '',
						'icon_border_style'        => '',
						'icon_color_border'        => '',
						'icon_border_size'         => '',
						'icon_border_radius'       => '',
						'icon_border_spacing'      => '',
						'icon_img'                 => '',
						'img_width'                => '60',
						'icon_size'                => '',
						'alignment'                => 'center',
						'spacer_margin'            => '',
						'line_icon_fixer'          => '',
						'heading_tag'              => '',
						'el_class'                 => '',
					),
					$atts
				)
			);
			$wrapper_class = $spacer;
			// load css & js
			$this->register_headings_assets();
			if ( $heading_tag == '' ) {
				$heading_tag = 'h2';
			}

			/* ---- main heading styles ---- */
			if ( $main_heading_font_family != '' ) {
				$mhfont_family = get_ultimate_font_family( $main_heading_font_family );
				if ( ! empty( $mhfont_family ) ) {
					$main_heading_style_inline .= 'font-family:\'' . $mhfont_family . '\';';
				}
			}
			// main heading font style
			$main_heading_style_inline .= get_ultimate_font_style( $main_heading_style );
			// attach font size if set
			if ( $main_heading_font_size != '' ) {
				$main_heading_style_inline .= 'font-size:' . $main_heading_font_size . 'px;';
			}
			// attach font color if set
			if ( $main_heading_color != '' ) {
				$main_heading_style_inline .= 'color:' . $main_heading_color . ';';
			}
			// attach margins for main heading
			if ( $main_heading_margin != '' ) {
				$main_heading_style_inline .= $main_heading_margin;
			}
			// line height
			if ( $main_heading_line_height != '' ) {
				$main_heading_style_inline .= 'line-height:' . $main_heading_line_height . 'px;';
			}

			/* ----- sub heading styles ----- */
			if ( $sub_heading_font_family != '' ) {
				$shfont_family             = get_ultimate_font_family( $sub_heading_font_family );
				$sub_heading_style_inline .= 'font-family:\'' . $shfont_family . '\';';
			}
			// sub heaing font style
			$sub_heading_style_inline .= get_ultimate_font_style( $sub_heading_style );
			// attach font size if set
			if ( $sub_heading_font_size != '' ) {
				$sub_heading_style_inline .= 'font-size:' . $sub_heading_font_size . 'px;';
			}
			// attach font color if set
			if ( $sub_heading_color != '' ) {
				$sub_heading_style_inline .= 'color:' . $sub_heading_color . ';';
			}
			// attach margins for sub heading
			if ( $sub_heading_margin != '' ) {
				$sub_heading_style_inline .= $sub_heading_margin;
			}
			// line height
			if ( $sub_heading_line_height != '' ) {
				$sub_heading_style_inline .= 'line-height:' . $sub_heading_line_height . 'px;';
			}

			if ( $spacer != '' ) {
				$wrapper_style .= $spacer_margin;
			}
			if ( $spacer == 'line_with_icon' ) {
				if ( $line_width < $icon_size ) {
					$wrap_width = $icon_size;
				} else {
					$wrap_width = $line_width;
				}
				if ( $icon_type == 'selector' ) {
					if ( $icon_style == 'advanced' ) {
						// if($icon_border_spacing != '')
						// $wrapper_style .= 'padding:'.$icon_border_spacing.'px 0;';
					} else {
						$wrapper_style .= 'height:' . $icon_size . 'px;';
					}
				}
				$icon_style_inline = 'font-size:' . $icon_size . 'px;';
			} elseif ( $spacer == 'line_only' ) {
				$wrap_width         = $line_width;
				$line_style_inline  = 'border-style:' . $line_style . ';';
				$line_style_inline .= 'border-bottom-width:' . $line_height . 'px;';
				$line_style_inline .= 'border-color:' . $line_color . ';';
				$line_style_inline .= 'width:' . $wrap_width . 'px;';
				$wrapper_style     .= 'height:' . $line_height . 'px;';
				$line               = '<span class="uvc-headings-line" style="' . $line_style_inline . '"></span>';
				$icon_inline        = $line;
			} elseif ( $spacer == 'icon_only' ) {
				$icon_style_inline = 'font-size:' . $icon_size . 'px;';
			} elseif ( $spacer == 'image_only' ) {
				if ( ! empty( $spacer_img_width ) ) {
					$siwidth = array( $spacer_img_width, $spacer_img_width );
				} else {
					$siwidth = 'full';
				}

				// $icon_inline = wp_get_attachment_image( $spacer_img, $siwidth, false, array("class"=>"ultimate-headings-icon-image") );

				$icon_inline = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url( $spacer_img ) . '" class="ultimate-headings-icon-image" />';
			}
			// if spacer type is line with icon or only icon show icon or image respectively
			if ( $spacer == 'line_with_icon' || $spacer == 'icon_only' ) {
				$icon_animation = '';
				$icon_inline    = JsComposer::do_shortcode( '[just_icon icon_align="' . $alignment . '" icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_animation="' . $icon_animation . '"]' );
			}
			if ( $spacer == 'line_with_icon' ) {
				$data = 'data-hline_width="' . $wrap_width . '" data-hicon_type="' . $icon_type . '" data-hborder_style="' . $line_style . '" data-hborder_height="' . $line_height . '" data-hborder_color="' . $line_color . '"';
				if ( $icon_type == 'selector' ) {
					$data .= ' data-icon_width="' . $icon_size . '"';
				} else {
					$data .= ' data-icon_width="' . $img_width . '"';
				}
				if ( $line_icon_fixer != '' ) {
					$data .= ' data-hfixer="' . $line_icon_fixer . '" ';
				}
			} else {
				$data = '';
			}
			$id     = uniqid( 'ultimate-heading' );
			$output = '<div id="' . $id . '" class="uvc-heading ' . $el_class . '" data-hspacer="' . $spacer . '" ' . $data . ' data-halign="' . $alignment . '" style="text-align:' . $alignment . '">';
			if ( $spacer_position == 'top' ) {
				$output .= $this->ultimate_heading_spacer( $wrapper_class, $wrapper_style, $icon_inline );
			}
			if ( $main_heading != '' ) {
				$output .= '<div class="uvc-main-heading"><' . $heading_tag . ' style="' . $main_heading_style_inline . '">' . $main_heading . '</' . $heading_tag . '></div>';
			}
			if ( $spacer_position == 'middle' ) {
				$output .= $this->ultimate_heading_spacer( $wrapper_class, $wrapper_style, $icon_inline );
			}
			if ( $content != '' ) {
				$output .= '<div class="uvc-sub-heading" style="' . $sub_heading_style_inline . '">' . JsComposer::do_shortcode( $content ) . '</div>';
			}
			if ( $spacer_position == 'bottom' ) {
				$output .= $this->ultimate_heading_spacer( $wrapper_class, $wrapper_style, $icon_inline );
			}
			$output .= '</div>';
			// enqueue google font
			$args = array(
				$main_heading_font_family,
				$sub_heading_font_family,
			);
			enquque_ultimate_google_fonts( $args );
			return $output;
		}

		function ultimate_heading_spacer( $wrapper_class, $wrapper_style, $icon_inline ) {
			$spacer = '<div class="uvc-heading-spacer ' . $wrapper_class . '" style="' . $wrapper_style . '">' . $icon_inline . '</div>';
			return $spacer;
		}

	}

	// end class
	// new Ultimate_Headings;
}
