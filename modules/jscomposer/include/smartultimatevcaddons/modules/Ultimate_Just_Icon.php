<?php

/*
 * Add-on Name: Just Icon for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if ( ! class_exists( 'AIO_Just_Icon' ) ) {

	class AIO_Just_Icon {

		public $vcaddonsinstance, $context;

		function __construct() {
			$this->vcaddonsinstance = jscomposer::getInstance();
			$this->context          = Context::getContext();

			// add_action('admin_init',array($this,'just_icon_init'));
			JsComposer::add_shortcode( 'just_icon', array( $this, 'just_icon_shortcode' ) );
		}

		function just_icon_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Just Icon' ),
						'base'        => 'just_icon',
						'class'       => 'vc_simple_icon',
						'icon'        => 'vc_just_icon',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Add a simple icon and give some custom style.' ),
						'params'      => array(
							// Play with icon selector
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Icon to display 1:' ),
								'param_name'  => 'icon_type',
								'value'       => array(
									'Font Icon Manager' => 'selector',
									'Custom Image Icon' => 'custom',
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
								'type'        => 'attach_image',
								'class'       => '',
								'heading'     => $vc->l( 'Upload Image Icon:' ),
								'param_name'  => 'icon_img',
								'admin_label' => true,
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
								'heading'     => $vc->l( 'Icon or Image Style' ),
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
									'element'   => 'icon_border_style',
									'not_empty' => true,
								),
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => $vc->l( 'Link ' ),
								'param_name'  => 'icon_link',
								'value'       => '',
								'description' => $vc->l( 'Add a custom link or select existing page. You can remove existing link as well.' ),
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
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Tooltip' ),
								'param_name'  => 'tooltip_disp',
								'value'       => array(
									'None'                => '',
									'Tooltip from Left'   => 'left',
									'Tooltip from Right'  => 'right',
									'Tooltip from Top'    => 'top',
									'Tooltip from Bottom' => 'bottom',
								),
								'description' => $vc->l( 'Select the tooltip position' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Tooltip Text' ),
								'param_name'  => 'tooltip_text',
								'value'       => '',
								'description' => $vc->l( 'Enter your tooltip text here.' ),
								'dependency'  => array(
									'element'   => 'tooltip_disp',
									'not_empty' => true,
								),
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Alignment' ),
								'param_name' => 'icon_align',
								'value'      => array(
									'Center' => 'center',
									'Left'   => 'left',
									'Right'  => 'right',
								),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Custom CSS Class' ),
								'param_name'  => 'el_class',
								'value'       => '',
								'description' => $vc->l( 'Ran out of options? Need more styles? Write your own CSS and mention the class name here.' ),
							),
						),
					)
				);
			}
		}

		// Shortcode handler function for stats Icon
		function just_icon_shortcode( $atts ) {

			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $tooltip_disp = $tooltip_text = $icon_align = '';
			extract(
				JsComposer::shortcode_atts(
					array(
						'icon_type'           => '',
						'icon'                => '',
						'icon_img'            => '',
						'img_width'           => '',
						'icon_size'           => '',
						'icon_color'          => '',
						'icon_style'          => '',
						'icon_color_bg'       => '',
						'icon_color_border'   => '',
						'icon_border_style'   => '',
						'icon_border_size'    => '',
						'icon_border_radius'  => '',
						'icon_border_spacing' => '',
						'icon_link'           => '',
						'icon_animation'      => '',
						'tooltip_disp'        => '',
						'tooltip_text'        => '',
						'el_class'            => '',
						'icon_align'          => '',
					),
					$atts
				)
			);

			if ( $tooltip_text != ''
			) {

				$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/tooltip.min.js" );
			}
			if ( $icon_animation !== 'none' ) {
				$css_trans = 'data-animation="' . $icon_animation . '" data-animation-delay="03"';
			}
			$output = $style = $link_sufix = $link_prefix = $target = $href = $icon_align_style = '';
			$uniqid = uniqid();
			if ( $icon_link !== '' ) {
				$href         = vc_build_link( $icon_link );
				$target       = ( isset( $href['target'] ) ) ? "target='" . $href['target'] . "'" : '';
				$link_prefix .= '<a class="aio-tooltip ' . $uniqid . '" href = "' . $href['url'] . '" ' . $target . ' data-toggle="tooltip" data-placement="' . $tooltip_disp . '" title="' . $tooltip_text . '">';
				$link_sufix  .= '</a>';
			} else {
				if ( $tooltip_disp !== '' ) {
					$link_prefix .= '<div class="aio-tooltip ' . $uniqid . '" href = "' . $href . '" ' . $target . ' data-toggle="tooltip" data-placement="' . $tooltip_disp . '" title="' . $tooltip_text . '">';
					$link_sufix  .= '</div>';
				}
			}

			/* position fix */
			if ( $icon_align == 'right' ) {
				$icon_align_style .= 'text-align:right;';
			} elseif ( $icon_align == 'center' ) {
				$icon_align_style .= 'text-align:center;';
			} elseif ( $icon_align == 'left' ) {
				$icon_align_style .= 'text-align:left;';
			}

			if ( $icon_type == 'custom' ) {
				$img = jscomposer::get_media_thumbnail_url( $icon_img );
				$alt = $img;
				$img = jscomposer::$_url . "uploads/{$img}";
				if ( $icon_style !== 'none' ) {
					if ( $icon_color_bg !== '' ) {
						$style .= 'background:' . $icon_color_bg . ';';
					}
				}
				if ( $icon_style == 'circle' ) {
					$el_class .= ' uavc-circle ';
				}
				if ( $icon_style == 'square' ) {
					$el_class .= ' uavc-square ';
				}
				if ( $icon_style == 'advanced' && $icon_border_style !== '' ) {
					$style .= 'border-style:' . $icon_border_style . ';';
					$style .= 'border-color:' . $icon_color_border . ';';
					$style .= 'border-width:' . $icon_border_size . 'px;';
					$style .= 'padding:' . $icon_border_spacing . 'px;';
					$style .= 'border-radius:' . $icon_border_radius . 'px;';
				}
				if ( ! empty( $img ) ) {
					if ( $icon_link == '' || $icon_align == 'center' ) {
						$style .= 'display:inline-block;';
					}
					$output .= "\n" . $link_prefix . '<div class="aio-icon-img ' . $el_class . '" style="font-size:' . $img_width . 'px;' . $style . '" ' . $css_trans . '>';
					$output .= "\n\t" . '<img class="img-icon" alt="' . $alt . '" src="' . $img . '"/>';
					$output .= "\n" . '</div>' . $link_sufix;
				}
				$output = $output;
			} else {
				if ( $icon_color !== '' ) {
					$style .= 'color:' . $icon_color . ';';
				}
				if ( $icon_style !== 'none' ) {
					if ( $icon_color_bg !== '' ) {
						$style .= 'background:' . $icon_color_bg . ';';
					}
				}
				if ( $icon_style == 'advanced' ) {
					$style .= 'border-style:' . $icon_border_style . ';';
					$style .= 'border-color:' . $icon_color_border . ';';
					$style .= 'border-width:' . $icon_border_size . 'px;';
					$style .= 'width:' . $icon_border_spacing . 'px;';
					$style .= 'height:' . $icon_border_spacing . 'px;';
					$style .= 'line-height:' . $icon_border_spacing . 'px;';
					$style .= 'border-radius:' . $icon_border_radius . 'px;';
				}
				if ( $icon_size !== '' ) {
					$style .= 'font-size:' . $icon_size . 'px;';
				}
				if ( $icon_align !== 'left' ) {
					$style .= 'display:inline-block;';
				}
				if ( $icon !== '' ) {
					$output .= "\n" . $link_prefix . '<div class="aio-icon ' . $icon_style . ' ' . $el_class . '" ' . $css_trans . ' style="' . $style . '">';
					$output .= "\n\t" . '<i class="' . $icon . '"></i>';
					$output .= "\n" . '</div>' . $link_sufix;
				}
				$output = $output;
			}
			if ( $tooltip_disp !== '' ) {
				$output .= '<script>
					jQuery(function () {
						 jQuery(".' . $uniqid . '").bsf_tooltip("hide");
					})
				</script>';
			}
			/* alignment fix */
			if ( $icon_align_style !== '' ) {
				$output = '<div class="align-icon" style="' . $icon_align_style . '">' . $output . '</div>';
			}

			return $output;
		}

	}

}
// if(class_exists('AIO_Just_Icon'))
// {
// $AIO_Just_Icon = new AIO_Just_Icon;
// }
