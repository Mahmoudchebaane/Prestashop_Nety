<?php
/*
* Add-on Name: Highlight Box
*/
if ( ! class_exists( 'Ultimate_Highlight_Box' ) ) {
	class Ultimate_Highlight_Box {

		public $vcaddonsinstance, $context;
		function __construct() {
					$this->vcaddonsinstance = jscomposer::getInstance();
					$this->context          = Context::getContext();

			// add_action('admin_init',array($this,'ctaction_init'));
					  JsComposer::add_shortcode( 'ultimate_ctation', array( $this, 'call_to_action_shortcode' ) );
			// add_action('wp_enqueue_scripts', array($this, 'register_cta_assets'),1);
		}
		function register_cta_assets() {
			
			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/call-to-action.min.css" );
			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/call-to-action.min.js" );

		}
		function ctaction_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'     => $vc->l( 'Hightlight Box' ),
						'base'     => 'ultimate_ctation',
						'class'    => 'vc_ctaction_icon',
						'icon'     => 'vc_icon_ctaction',
						'category' => $vc->l( 'Ultimate VC Addons' ),
						'params'   => array(
							array(
								'type'        => 'textarea_html',
								'class'       => '',
								'heading'     => $vc->l( 'Text ' ),
								'param_name'  => 'content',
								'admin_label' => true,
								'value'       => '',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => $vc->l( 'Alignment', 'js_composer' ),
								'param_name' => 'content_alignment',
								'value'      => array(
									$vc->l( 'Center', 'js_composert' ) => 'ctaction-text-center',
									$vc->l( 'Left', 'js_composert' ) => 'ctaction-left-center',
									$vc->l( 'Right', 'js_composert' ) => 'ctaction-right-center',
								),
							),
							array(
								'type'       => 'colorpicker',
								'heading'    => 'Background',
								'param_name' => 'ctaction_background',
								'value'      => '#e74c3c',
								'group'      => 'Background',
							),
							array(
								'type'       => 'colorpicker',
								'heading'    => 'Background Hover',
								'param_name' => 'ctaction_background_hover',
								'value'      => '#c0392b',
								'group'      => 'Background',
							),
							array(
								'type'       => 'vc_link',
								'param_name' => 'ctaction_link',
								'heading'    => 'Link',
							),
							array(
								'type'       => 'ult_switch',
								'heading'    => 'Enable Icon',
								'param_name' => 'enable_icon',
								'value'      => '',
								'options'    => array(
									'enable_icon_value' => array(
										'label' => '',
										'on'    => 'Yes',
										'off'   => 'No',
									),
								),
								'group'      => 'Icon',
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Effect' ),
								'param_name'  => 'effect',
								'value'       => array(
									'Slide Left'   => 'right-push',
									'Slide Right'  => 'left-push',
									'Slide Top'    => 'bottom-push',
									'Slide Bottom' => 'top-push',
								),
								'description' => $vc->l( 'Use an existing font icon or upload a custom image.' ),
								'dependency'  => array(
									'element' => 'enable_icon',
									'value'   => array( 'enable_icon_value' ),
								),
								'group'       => 'Icon',
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
								'description' => $vc->l( 'Use an existing font icon or upload a custom image.' ),
								'dependency'  => array(
									'element' => 'enable_icon',
									'value'   => array( 'enable_icon_value' ),
								),
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'dependency'  => array(
									'element'   => 'icon_border_style',
									'not_empty' => true,
								),
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
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
								'group'       => 'Icon',
							),

							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'text_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'text_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'text_font_size',
								'value'      => '32',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'text_color',
								'value'      => '#fff',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'text_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Width Override', 'upb_google_map' ),
								'param_name'  => 'ctaction_override',
								'value'       => array(
									'Default Width'      => '0',
									"Apply 1st parent element's width" => '1',
									"Apply 2nd parent element's width" => '2',
									"Apply 3rd parent element's width" => '3',
									"Apply 4th parent element's width" => '4',
									"Apply 5th parent element's width" => '5',
									"Apply 6th parent element's width" => '6',
									"Apply 7th parent element's width" => '7',
									"Apply 8th parent element's width" => '8',
									"Apply 9th parent element's width" => '9',
									'Full Width '        => 'full',
									'Maximum Full Width' => 'ex-full',
								),
							),
							array(
								'type'             => 'number',
								'heading'          => $vc->l( 'Top Padding', 'js_composer' ),
								'param_name'       => 'ctaction_padding_top',
								'edit_field_class' => 'vc_column vc_col-sm-4',
								'value'            => '20',
								'suffix'           => 'px',
								'group'            => 'Background',
							),
							array(
								'type'             => 'number',
								'heading'          => $vc->l( 'Bottom Padding', 'js_composer' ),
								'param_name'       => 'ctaction_padding_bottom',
								'edit_field_class' => 'vc_column vc_col-sm-4',
								'value'            => '20',
								'suffix'           => 'px',
								'group'            => 'Background',
							),
							array(
								'type'        => 'textfield',
								'heading'     => $vc->l( 'Extra class name', 'js_composer' ),
								'param_name'  => 'el_class',
							),
						),
					)
				);
			}
		}
		// Shortcode handler function for stats banner
		function call_to_action_shortcode( $atts, $content ) {
			// wp_enqueue_script('utl-ctaction-script');
			$output = $el_class = $style = $data = $text_style_inline = $ctaction_link_html = $icon_inline = $effect = '';
			$this->register_cta_assets();
			extract(
				JsComposer::shortcode_atts(
					array(
						'content_alignment'         => 'ctaction-text-center',
						'ctaction_background'       => '',
						'ctaction_background_hover' => '',
						'text_font_family'          => '',
						'text_font_style'           => '',
						'text_font_size'            => '',
						'text_color'                => '',
						'text_line_height'          => '',
						'ctaction_link'             => '',
						'ctaction_override'         => '0',
						'ctaction_padding_top'      => '',
						'ctaction_padding_bottom'   => '',
						'enable_icon'               => '',
						'icon_type'                 => '',
						'icon'                      => '',
						'icon_color'                => '',
						'icon_style'                => '',
						'icon_color_bg'             => '',
						'icon_border_style'         => '',
						'icon_color_border'         => '',
						'icon_border_size'          => '',
						'icon_border_radius'        => '',
						'icon_border_spacing'       => '',
						'icon_img'                  => '',
						'img_width'                 => '60',
						'icon_size'                 => '',
						'effect'                    => 'no-effect',
						'el_class'                  => '',
					),
					$atts
				)
			);

			$el_class .= ' ' . $content_alignment;

			/* typography */

			if ( $text_font_family != '' ) {
				$temp = get_ultimate_font_family( $text_font_family );
				if ( ! empty( $temp ) ) {
					$text_style_inline .= 'font-family:' . $temp . ';';
				}
			}

			$text_style_inline .= get_ultimate_font_style( $text_font_style );

			if ( $text_font_size != '' ) {
				$text_style_inline .= 'font-size:' . $text_font_size . 'px;';
			}

			if ( $text_color != '' ) {
				$text_style_inline .= 'color:' . $text_color . ';';
			}

			if ( $text_line_height != '' ) {
				$text_style_inline .= 'line-height:' . $text_line_height . 'px;';
			}

			$args = array(
				$text_font_family,
			);
			enquque_ultimate_google_fonts( $args );
			/*end typography */

			if ( $ctaction_background != '' ) {
				$data              .= ' data-background="' . $ctaction_background . '" ';
				$text_style_inline .= 'background:' . $ctaction_background . ';';
			}
			if ( $ctaction_background_hover != '' ) {
				$data .= ' data-background-hover="' . $ctaction_background_hover . '" ';
			}

			$data .= ' data-override="' . $ctaction_override . '" ';

			if ( $ctaction_padding_top != '' ) {
				$text_style_inline .= 'padding-top:' . $ctaction_padding_top . 'px;';
			}
			if ( $ctaction_padding_bottom != '' ) {
				$text_style_inline .= 'padding-bottom:' . $ctaction_padding_bottom . 'px;';
			}

			if ( $ctaction_link != '' ) {
				$ctaction_link = vc_build_link( $ctaction_link );
				$url           = $ctaction_link['url'];
				$title         = $ctaction_link['title'];
				$target        = $ctaction_link['target'];
				if ( $url != '' ) {
					if ( $target != '' ) {
						$target = 'target="' . $target . '"';
					}
					$ctaction_link_html = '<a href="' . $url . '" class="ulimate-call-to-action-link" ' . $target . '></a>';
				}
			}

			if ( $enable_icon == 'enable_icon_value' ) {
				$icon_inline = JsComposer::do_shortcode( '[just_icon icon_align="center" icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '"]' );
			} else {
				$effect = 'no-effect';
			}

			$output .= '<div class="ultimate-call-to-action ' . $el_class . '" style="' . $text_style_inline . '" ' . $data . '>';
			if ( $icon_inline != '' ) {
				$output .= '<span class="ultimate-ctaction-icon ctaction-icon-' . $effect . '">' . $icon_inline . '</span>';
			}
				$output .= '<span class="uvc-ctaction-data uvc-ctaction-data-' . $effect . '">' . $content . '</span>';
			$output     .= $ctaction_link_html . '</div>';

			return $output;
		}
	}
}
// if(class_exists('Ultimate_Highlight_Box'))
// {
// $Ultimate_Highlight_Box = new Ultimate_Highlight_Box;
// }


