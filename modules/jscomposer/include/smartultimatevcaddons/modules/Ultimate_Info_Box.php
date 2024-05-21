<?php
/*
 * Add-on Name: Info Box
 * Add-on URI: https://www.brainstormforce.com
 */
if ( ! class_exists( 'AIO_Icons_Box' ) ) {

	class AIO_Icons_Box {



		public $vcaddonsinstance, $context;

		function __construct() {
			$this->context          = Context::getContext();
			$this->vcaddonsinstance = jscomposer::getInstance();
			JsComposer::add_shortcode( 'bsf-info-box', array( &$this, 'icon_boxes' ) );
		}

		function bsf_info_box_styles() {
			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/info-box.min.css" );
		}

		// Add shortcode for icon-box
		function icon_boxes( $atts, $content = null ) {

			$icon_type  = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $el_class = $icon_animation = $title = $link = $hover_effect = $pos = $read_more = $read_text = $box_border_style = $box_border_width = $box_border_color = $box_bg_color = $pos = $css_class = $desc_font_line_height = $title_font_line_height = '';
			$title_font = $title_font_style = $title_font_size = $title_font_color = $desc_font = $desc_font_style = $desc_font_size = $desc_font_color = '';
			$this->bsf_info_box_styles();

			extract(
				JsComposer::shortcode_atts(
					array(
						'icon_type'              => '',
						'icon'                   => '',
						'icon_img'               => '',
						'img_width'              => '',
						'icon_size'              => '',
						'icon_color'             => '',
						'icon_style'             => '',
						'icon_color_bg'          => '',
						'icon_color_border'      => '',
						'icon_border_style'      => '',
						'icon_border_size'       => '',
						'icon_border_radius'     => '',
						'icon_border_spacing'    => '',
						'icon_animation'         => '',
						'title'                  => '',
						'link'                   => '',
						'hover_effect'           => '',
						'pos'                    => '',
						'box_border_style'       => '',
						'box_border_width'       => '',
						'box_border_color'       => '',
						'box_bg_color'           => '',
						'read_more'              => '',
						'read_text'              => '',
						'title_font'             => '',
						'title_font_style'       => '',
						'title_font_size'        => '',
						'title_font_line_height' => '',
						'title_font_color'       => '',
						'desc_font'              => '',
						'desc_font_style'        => '',
						'desc_font_size'         => '',
						'desc_font_color'        => '',
						'desc_font_line_height'  => '',
						'el_class'               => '',
					),
					$atts
				)
			);
			$html      = $target = $suffix = $prefix = $title_style = $desc_style = '';
			$font_args = array();
			$box_icon  = JsComposer::do_shortcode( '[just_icon icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_animation="' . $icon_animation . '"]' );

			$prefix  .= '<div class="aio-icon-component ' . $css_class . ' ' . $el_class . ' ' . $hover_effect . '">';
			$suffix  .= '</div> <!-- aio-icon-component -->';
			$ex_class = $ic_class = '';
			if ( $pos != '' ) {
				$ex_class .= $pos . '-icon';
				$ic_class  = 'aio-icon-' . $pos;
			}

			/* title */
			if ( $title_font != '' ) {
				$font_family  = get_ultimate_font_family( $title_font );
				$title_style .= 'font-family:' . $font_family . ';';
				array_push( $font_args, $title_font );
			}
			if ( $title_font_style != '' ) {
				$title_style .= get_ultimate_font_style( $title_font_style );
			}
			if ( $title_font_size != '' ) {
				$title_style .= 'font-size:' . $title_font_size . 'px;';
			}
			if ( $title_font_line_height != '' ) {
				$title_style .= 'line-height:' . $title_font_line_height . 'px;';
			}
			if ( $title_font_color != '' ) {
				$title_style .= 'color:' . $title_font_color . ';';
			}

			/* description */
			if ( $desc_font != '' ) {
				$font_family = get_ultimate_font_family( $desc_font );
				$desc_style .= 'font-family:' . $font_family . ';';
				array_push( $font_args, $desc_font );
			}
			if ( $desc_font_style != '' ) {
				$desc_style .= get_ultimate_font_style( $desc_font_style );
			}
			if ( $desc_font_size != '' ) {
				$desc_style .= 'font-size:' . $desc_font_size . 'px;';
			}
			if ( $desc_font_line_height != '' ) {
				$desc_style .= 'line-height:' . $desc_font_line_height . 'px;';
			}
			if ( $desc_font_color != '' ) {
				$desc_style .= 'color:' . $desc_font_color . ';';
			}
			enquque_ultimate_google_fonts( $font_args );

			$box_style = '';
			if ( $pos == 'square_box' ) {
				if ( $box_border_color != '' ) {
					$box_style .= 'border-color:' . $box_border_color . ';';
				}
				if ( $box_border_style != '' ) {
					$box_style .= 'border-style:' . $box_border_style . ';';
				}
				if ( $box_border_width != '' ) {
					$box_style .= 'border-width:' . $box_border_width . 'px;';
				}
				if ( $box_bg_color != '' ) {
					$box_style .= 'background-color:' . $box_bg_color . ';';
				}
			}
			$html .= '<div class="aio-icon-box ' . $ex_class . '" style="' . $box_style . '">';

			if ( $pos == 'heading-right' || $pos == 'right' ) {
				if ( $pos == 'right' ) {
					$html .= '<div class="aio-ibd-block">';
				}
				if ( $title !== '' ) {
					$html       .= '<div class="aio-icon-header">';
					$link_prefix = $link_sufix = '';
					if ( $link !== 'none' ) {
						if ( $read_more == 'title' ) {
							$href = vc_build_link( $link );
							if ( isset( $href['target'] ) ) {
								$target = 'target="' . $href['target'] . '"';
							}
							$link_prefix = '<a class="aio-icon-box-link" href="' . $href['url'] . '" ' . $target . '>';
							$link_sufix  = '</a>';
						}
					}
					$html .= $link_prefix . '<h3 class="aio-icon-title" style="' . $title_style . '">' . $title . '</h3>' . $link_sufix;
					$html .= '</div> <!-- header -->';
				}
				if ( $pos !== 'right' ) {
					if ( $icon !== 'none' ) {
						$html .= '<div class="' . $ic_class . '">' . $box_icon . '</div>';
					}
				}
				if ( $content !== '' ) {
					$html .= '<div class="aio-icon-description" style="' . $desc_style . '">';
					$html .= JsComposer::do_shortcode( $content );
					if ( $link !== 'none' ) {
						if ( $read_more == 'more' ) {
							$href = vc_build_link( $link );
							if ( isset( $href['target'] ) ) {
								$target = 'target="' . $href['target'] . '"';
							}
							$more_link  = '<a class="aio-icon-read" href="' . $href['url'] . '" ' . $target . '>';
							$more_link .= $read_text;
							$more_link .= '&nbsp;&raquo;';
							$more_link .= '</a>';
							$html      .= $more_link;
						}
					}
					$html .= '</div> <!-- description -->';
				}
				if ( $pos == 'right' ) {
					$html .= '</div> <!-- aio-ibd-block -->';
					if ( $icon !== 'none' ) {
						$html .= '<div class="' . $ic_class . '">' . $box_icon . '</div>';
					}
				}
			} else {
				if ( $icon !== 'none' ) {
					$html .= '<div class="' . $ic_class . '">' . $box_icon . '</div>';
				}
				if ( $pos == 'left' ) {
					$html .= '<div class="aio-ibd-block">';
				}
				if ( $title !== '' ) {
					$html       .= '<div class="aio-icon-header">';
					$link_prefix = $link_sufix = '';
					if ( $link !== 'none' ) {
						if ( $read_more == 'title' ) {
							$href = vc_build_link( $link );
							if ( isset( $href['target'] ) ) {
								$target = 'target="' . $href['target'] . '"';
							}
							$link_prefix = '<a class="aio-icon-box-link" href="' . $href['url'] . '" ' . $target . '>';
							$link_sufix  = '</a>';
						}
					}
					$html .= $link_prefix . '<h3 class="aio-icon-title" style="' . $title_style . '">' . $title . '</h3>' . $link_sufix;
					$html .= '</div> <!-- header -->';
				}
				if ( $content !== '' ) {
					$html .= '<div class="aio-icon-description" style="' . $desc_style . '">';
					$html .= JsComposer::do_shortcode( $content );
					if ( $link !== 'none' ) {
						if ( $read_more == 'more' ) {
							$href = vc_build_link( $link );
							if ( isset( $href['target'] ) ) {
								$target = 'target="' . $href['target'] . '"';
							}
							$more_link  = '<a class="aio-icon-read" href="' . $href['url'] . '" ' . $target . '>';
							$more_link .= $read_text;
							$more_link .= '&nbsp;&raquo;';
							$more_link .= '</a>';
							$html      .= $more_link;
						}
					}
					$html .= '</div> <!-- description -->';
				}
				if ( $pos == 'left' ) {
					$html .= '</div> <!-- aio-ibd-block -->';
				}
			}

			$html .= '</div> <!-- aio-icon-box -->';
			if ( $link !== 'none' ) {
				if ( $read_more == 'box' ) {
					$href = vc_build_link( $link );
					if ( isset( $href['target'] ) ) {
						$target = 'target="' . $href['target'] . '"';
					}
					$output = $prefix . '<a class="aio-icon-box-link" href="' . $href['url'] . '" ' . $target . '>' . $html . '</a>' . $suffix;
				} else {
					$output = $prefix . $html . $suffix;
				}
			} else {
				$output = $prefix . $html . $suffix;
			}
			return $output;
		}

		// Function generate param type "number"
		function number_settings_field( $settings, $value ) {
			$dependency = vc_generate_dependencies_attributes( $settings );
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;
			return $output;
		}

		/* Add icon box Component */

		function icon_box_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Info Box' ),
						'base'        => 'bsf-info-box',
						'icon'        => 'vc_info_box',
						'class'       => 'info_box',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => 'Adds icon box with custom font icon',
						'params'      => array(
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Icon to display 2:' ),
								'param_name'  => 'icon_type',
								'value'       => array(
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
								'description' => $vc->l( "Click and select icon of your choice. If you can't find the one that suits for your." ),
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
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Animation' ),
								'param_name'  => 'icon_animation',
								'value'       => array(
									$vc->l( 'No Animation' ) => '',
									$vc->l( 'Swing' )      => 'swing',
									$vc->l( 'Pulse' )      => 'pulse',
									$vc->l( 'Fade In' )    => 'fadeIn',
									$vc->l( 'Fade In Up' ) => 'fadeInUp',
									$vc->l( 'Fade In Down' ) => 'fadeInDown',
									$vc->l( 'Fade In Left' ) => 'fadeInLeft',
									$vc->l( 'Fade In Right' ) => 'fadeInRight',
									$vc->l( 'Fade In Up Long' ) => 'fadeInUpBig',
									$vc->l( 'Fade In Down Long' ) => 'fadeInDownBig',
									$vc->l( 'Fade In Left Long' ) => 'fadeInLeftBig',
									$vc->l( 'Fade In Right Long' ) => 'fadeInRightBig',
									$vc->l( 'Slide In Down' ) => 'slideInDown',
									$vc->l( 'Slide In Left' ) => 'slideInLeft',
									$vc->l( 'Slide In Left' ) => 'slideInLeft',
									$vc->l( 'Bounce In' )  => 'bounceIn',
									$vc->l( 'Bounce In Up' ) => 'bounceInUp',
									$vc->l( 'Bounce In Down' ) => 'bounceInDown',
									$vc->l( 'Bounce In Left' ) => 'bounceInLeft',
									$vc->l( 'Bounce In Right' ) => 'bounceInRight',
									$vc->l( 'Rotate In' )  => 'rotateIn',
									$vc->l( 'Light Speed In' ) => 'lightSpeedIn',
									$vc->l( 'Roll In' )    => 'rollIn',
								),
								'description' => $vc->l( 'Like CSS3 Animations? We have several options for you!' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Title' ),
								'param_name'  => 'title',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( 'Provide the title for this icon box.' ),
							),
							array(
								'type'        => 'textarea_html',
								'class'       => '',
								'heading'     => $vc->l( 'Description' ),
								'param_name'  => 'content',
								'value'       => '',
								'description' => $vc->l( 'Provide the description for this icon box.' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Apply link to:' ),
								'param_name'  => 'read_more',
								'value'       => array(
									'No Link'           => 'none',
									'Complete Box'      => 'box',
									'Box Title'         => 'title',
									'Display Read More' => 'more',
								),
								'description' => $vc->l( 'Select whether to use color for icon or not.' ),
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => $vc->l( 'Add Link' ),
								'param_name'  => 'link',
								'value'       => '',
								'description' => $vc->l( 'Add a custom link or select existing page. You can remove existing link as well.' ),
								'dependency'  => array(
									'element' => 'read_more',
									'value'   => array( 'box', 'title', 'more' ),
								),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Read More Text' ),
								'param_name'  => 'read_text',
								'value'       => 'Read More',
								'description' => $vc->l( 'Customize the read more text.' ),
								'dependency'  => array(
									'element' => 'read_more',
									'value'   => array( 'more' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Select Hover Effect type' ),
								'param_name'  => 'hover_effect',
								'value'       => array(
									'No Effect'      => 'style_1',
									'Icon Zoom'      => 'style_2',
									'Icon Bounce Up' => 'style_3',
								),
								'description' => $vc->l( 'Select the type of effct you want on hover' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Box Style' ),
								'param_name'  => 'pos',
								'value'       => array(
									'Icon at Left with heading' => 'default',
									'Icon at Right with heading' => 'heading-right',
									'Icon at Left'  => 'left',
									'Icon at Right' => 'right',
									'Icon at Top'   => 'top',
									'Boxed Style'   => 'square_box',
								),
								'description' => $vc->l( 'Select icon position. Icon box style will be changed according to the icon position.' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Box Border Style' ),
								'param_name'  => 'box_border_style',
								'value'       => array(
									'None'   => '',
									'Solid'  => 'solid',
									'Dashed' => 'dashed',
									'Dotted' => 'dotted',
									'Double' => 'double',
									'Inset'  => 'inset',
									'Outset' => 'outset',
								),
								'dependency'  => array(
									'element' => 'pos',
									'value'   => array( 'square_box' ),
								),
								'description' => $vc->l( 'Select Border Style for box border.' ),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Box Border Width' ),
								'param_name'  => 'box_border_width',
								'value'       => '',
								'suffix'      => '',
								'dependency'  => array(
									'element' => 'pos',
									'value'   => array( 'square_box' ),
								),
								'description' => $vc->l( 'Select Width for Box Border.' ),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Box Border Color' ),
								'param_name'  => 'box_border_color',
								'value'       => '',
								'dependency'  => array(
									'element' => 'pos',
									'value'   => array( 'square_box' ),
								),
								'description' => $vc->l( 'Select Border color for border box.' ),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Box Background Color' ),
								'param_name'  => 'box_bg_color',
								'value'       => '',
								'dependency'  => array(
									'element' => 'pos',
									'value'   => array( 'square_box' ),
								),
								'description' => $vc->l( 'Select Box background color.' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Extra Class' ),
								'param_name'  => 'el_class',
								'value'       => '',
								'description' => $vc->l( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.' ),
							),
							array(
								'type'             => 'ult_param_heading',
								'param_name'       => 'title_text_typography',
								'heading'          => $vc->l( 'Title settings' ),
								'value'            => '',
								'group'            => 'Typography',
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								'type'       => 'ultimate_google_fonts',
								'heading'    => 'Font Family',
								'param_name' => 'title_font',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => 'Font Style',
								'param_name' => 'title_font_style',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'param_name' => 'title_font_size',
								'heading'    => 'Font size',
								'value'      => '',
								'suffix'     => 'px',
								'min'        => 10,
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'param_name' => 'title_font_line_height',
								'heading'    => 'Font Line Height',
								'value'      => '',
								'suffix'     => 'px',
								'min'        => 10,
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'title_font_color',
								'heading'    => 'Color',
								'group'      => 'Typography',
							),
							array(
								'type'             => 'ult_param_heading',
								'param_name'       => 'desc_text_typography',
								'heading'          => $vc->l( 'Description settings' ),
								'value'            => '',
								'group'            => 'Typography',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'       => 'ultimate_google_fonts',
								'heading'    => 'Font Family',
								'param_name' => 'desc_font',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => 'Font Style',
								'param_name' => 'desc_font_style',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'param_name' => 'desc_font_size',
								'heading'    => 'Font size',
								'value'      => '',
								'suffix'     => 'px',
								'min'        => 10,
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'param_name' => 'desc_font_line_height',
								'heading'    => 'Font Line Height',
								'value'      => '',
								'suffix'     => 'px',
								'min'        => 10,
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'desc_font_color',
								'heading'    => 'Color',
								'group'      => 'Typography',
							),
							array(
								'type'             => 'heading',
								'param_name'       => 'notification',
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							),
						), // end params array
					) // end vc_map array
				); // end vc_map
			} // end function check 'vc_map'
		}

		// end function icon_box_init
	}

	// Class end
}

// if(class_exists('AIO_Icons_Box'))
// {
// $AIO_Icons_Box = new AIO_Icons_Box;
// }
