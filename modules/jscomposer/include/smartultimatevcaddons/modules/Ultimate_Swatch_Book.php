<?php

/*
 * Add-on Name: Swatch Book for Visual Composer
 * Add-on URI: http://.brainstormforce.com/demos/ultimate/swatch-book
 */
if ( ! class_exists( 'Ultimate_Swatch_Book' ) ) {

	class Ultimate_Swatch_Book {

		var $swatch_trans_bg_img;
		var $swatch_width;
		var $swatch_height;
		public $vcaddonsinstance, $context;

		function __construct() {
			$this->vcaddonsinstance = jscomposer::getInstance();
			$this->context          = Context::getContext();
			if ( function_exists( 'vc_is_inline' ) ) {
				if ( ! vc_is_inline() ) {
					JsComposer::add_shortcode( 'swatch_container', array( &$this, 'swatch_container' ) );
					JsComposer::add_shortcode( 'swatch_item', array( &$this, 'swatch_item' ) );
				}
			} else {
				JsComposer::add_shortcode( 'swatch_container', array( &$this, 'swatch_container' ) );
				JsComposer::add_shortcode( 'swatch_item', array( &$this, 'swatch_item' ) );
			}
		}

		function register_swatch_assets() {
			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/modernizr.custom.min.js" );
			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/jquery.swatchbook.min.js" );
		}

		function swatch_book_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'                    => $vc->l( 'Swatch Book' ),
						'base'                    => 'swatch_container',
						'class'                   => 'vc_swatch_container',
						'icon'                    => 'vc_swatch_container',
						'category'                => $vc->l( 'Ultimate VC Addons' ),
						'as_parent'               => array( 'only' => 'swatch_item' ),
						'description'             => $vc->l( 'Interactive swatch strips.' ),
						'content_element'         => true,
						'show_settings_on_create' => true,
						'js_view'                 => 'VcColumnView',
						'params'                  => array(
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Swatch Book Style' ),
								'param_name'  => 'swatch_style',
								'value'       => array(
									'Style 1'      => 'style-1',
									'Style 2'      => 'style-2',
									'Style 3'      => 'style-3',
									'Style 4'      => 'style-4',
									'Style 5'      => 'style-5',
									'Custom Style' => 'custom',
								),
								'description' => $vc->l( '' ),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Index of Center Strip' ),
								'param_name'  => 'swatch_index_center',
								'value'       => 1,
								'min'         => 1,
								'max'         => 100,
								'suffix'      => '',
								'dependency'  => array(
									'element' => 'swatch_style',
									'value'   => 'custom',
								),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Space Between Two Swatches' ),
								'param_name'  => 'swatch_space_degree',
								'value'       => 1,
								'min'         => 1,
								'max'         => 1000,
								'suffix'      => '',
								'description' => $vc->l( 'The space between the items (in degrees)' ),
								'dependency'  => array(
									'element' => 'swatch_style',
									'value'   => 'custom',
								),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Transition Speed' ),
								'param_name'  => 'swatch_trans_speed',
								'value'       => 1,
								'min'         => 1,
								'max'         => 10000,
								'suffix'      => '',
								'description' => $vc->l( 'The speed and transition timing functions' ),
								'dependency'  => array(
									'element' => 'swatch_style',
									'value'   => 'custom',
								),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Distance From Open Item To Its Next Sibling' ),
								'param_name'  => 'swatch_distance_sibling',
								'value'       => 1,
								'min'         => 1,
								'max'         => 10000,
								'suffix'      => '',
								'dependency'  => array(
									'element' => 'swatch_style',
									'value'   => 'custom',
								),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'chk-switch',
								'class'       => '',
								'heading'     => $vc->l( 'Swatch book will be initially closed', 'upb_parallax' ),
								'param_name'  => 'swatch_init_closed',
								'value'       => '',
								'options'     => array(
									'closed' => array(
										'label' => '',
										'on'    => 'Yes',
										'off'   => 'No',
									),
								),
								'description' => '',
								'dependency'  => array(
									'element' => 'swatch_style',
									'value'   => 'custom',
								),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Index of the item that will be opened initially' ),
								'param_name'  => 'swatch_open_at',
								'value'       => 1,
								'min'         => 1,
								'max'         => 100,
								'suffix'      => '',
								'description' => $vc->l( '' ),
								'dependency'  => array(
									'element' => 'swatch_style',
									'value'   => 'custom',
								),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Width' ),
								'param_name'  => 'swatch_width',
								'value'       => 130,
								'min'         => 100,
								'max'         => 1000,
								'suffix'      => '',
								'description' => $vc->l( '' ),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Height' ),
								'param_name'  => 'swatch_height',
								'value'       => 400,
								'min'         => 100,
								'max'         => 1000,
								'suffix'      => '',
								'description' => $vc->l( '' ),
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'attach_image',
								'class'       => '',
								'heading'     => $vc->l( 'Background Transparent Pattern' ),
								'param_name'  => 'swatch_trans_bg_img',
								'value'       => '',
								'description' => '',
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Title Text' ),
								'param_name'  => 'swatch_main_strip_text',
								'value'       => '',
								'description' => '',
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Highlight Text' ),
								'param_name'  => 'swatch_main_strip_highlight_text',
								'value'       => '',
								'description' => '',
								'group'       => 'Initial Settings',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'main_strip_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'group'       => 'Advanced Settings',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'main_strip_font_style',
								'group'      => 'Advanced Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Title Font Size' ),
								'param_name'  => 'swatch_main_strip_font_size',
								'value'       => 16,
								'min'         => 1,
								'max'         => 72,
								'suffix'      => 'px',
								'description' => $vc->l( '' ),
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Title Font Style' ),
								'param_name'  => 'swatch_main_strip_font_style',
								'value'       => array(
									'Normal' => 'normal',
									'Bold'   => 'bold',
									'Italic' => 'italic',
								),
								'description' => $vc->l( '' ),
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Title Color:' ),
								'param_name'  => 'swatch_main_strip_color',
								'value'       => '',
								'description' => '',
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Title Background Color:' ),
								'param_name'  => 'swatch_main_strip_bg_color',
								'value'       => '',
								'description' => '',
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Title Highlight Font Size' ),
								'param_name'  => 'swatch_main_strip_highlight_font_size',
								'value'       => 16,
								'min'         => 1,
								'max'         => 72,
								'suffix'      => 'px',
								'description' => $vc->l( '' ),
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Title Highlight Font Weight' ),
								'param_name'  => 'swatch_main_strip_highlight_font_weight',
								'value'       => array(
									'Normal' => 'normal',
									'Bold'   => 'bold',
									'Italic' => 'italic',
								),
								'description' => $vc->l( '' ),
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Main Strip Title Highlight Color' ),
								'param_name'  => 'swatch_main_strip_highlight_color',
								'value'       => '',
								'description' => '',
								'group'       => 'Advanced Settings',
							),
						),
					)
				); // vc_map

				vc_map(
					array(
						'name'            => $vc->l( 'Swatch Book Item', 'js_composer' ),
						'base'            => 'swatch_item',
						'class'           => 'vc_swatch_item',
						'icon'            => 'vc_swatch_item',
						'content_element' => true,
						'as_child'        => array( 'only' => 'swatch_container' ),
						'params'          => array(
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Strip Title Text' ),
								'param_name'  => 'swatch_strip_text',
								'value'       => '',
								'description' => '',
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
								'description' => $vc->l( 'Use an existing font icon</a> or upload a custom image.' ),
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
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Strip Title Font Size' ),
								'param_name'  => 'swatch_strip_font_size',
								'value'       => 16,
								'min'         => 1,
								'max'         => 72,
								'suffix'      => 'px',
								'description' => $vc->l( '' ),
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Strip Title Font Weight' ),
								'param_name'  => 'swatch_strip_font_weight',
								'value'       => array(
									'Normal' => 'normal',
									'Bold'   => 'bold',
									'Italic' => 'italic',
								),
								'description' => $vc->l( '' ),
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Strip Title Color:' ),
								'param_name'  => 'swatch_strip_font_color',
								'value'       => '',
								'description' => '',
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Strip Title Background Color:' ),
								'param_name'  => 'swatch_strip_title_bg_color',
								'value'       => '',
								'description' => '',
								'group'       => 'Advanced Settings',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Strip Background Color:' ),
								'param_name'  => 'swatch_strip_bg_color',
								'value'       => '',
								'description' => '',
								'group'       => 'Advanced Settings',
							),
						),
					)
				); // vc_map
			}
		}

		function swatch_container( $atts, $content = null ) {
			$swatch_style = $swatch_index_center = $swatch_space_degree = $swatch_trans_speed = $swatch_distance_sibling = $swatch_init_closed = $swatch_open_at
					= $swatch_width = $swatch_height = $swatch_trans_bg_img = $swatch_main_strip_text = $swatch_main_strip_highlight_text = $swatch_main_strip_font_size = $swatch_main_strip_font_style = $swatch_main_strip_color = $swatch_main_strip_highlight_font_size = $swatch_main_strip_highlight_font_weight = $swatch_main_strip_highlight_color = $swatch_main_strip_bg_color = $main_strip_font_family = $main_strip_font_style = '';
			$this->register_swatch_assets();
			extract(
				JsComposer::shortcode_atts(
					array(
						'swatch_style'                     => '',
						'swatch_index_center'              => '',
						'swatch_space_degree'              => '',
						'swatch_trans_speed'               => '',
						'swatch_distance_sibling'          => '',
						'swatch_init_closed'               => '',
						'swatch_open_at'                   => '',
						'swatch_width'                     => '',
						'swatch_height'                    => '',
						'swatch_trans_bg_img'              => '',
						'swatch_main_strip_text'           => '',
						'swatch_main_strip_highlight_text' => '',
						'swatch_main_strip_font_size'      => '',
						'swatch_main_strip_font_style'     => '',
						'swatch_main_strip_color'          => '',
						'swatch_main_strip_highlight_font_size' => '',
						'swatch_main_strip_highlight_font_weight' => '',
						'swatch_main_strip_highlight_color' => '',
						'swatch_main_strip_bg_color'       => '',
						'main_strip_font_family'           => '',
						'main_strip_font_style'            => '',
					),
					$atts
				)
			);
			$output = $img = $style = $highlight_style = $main_style = '';
			$uid    = uniqid();
			if ( $swatch_trans_bg_img !== '' ) {
				$img                       = JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url( $swatch_trans_bg_img );
				$this->swatch_trans_bg_img = $swatch_trans_bg_img;
				$style                    .= 'background-image: url(' . $img . ');';
			}
			if ( $swatch_width !== '' ) {
				$style             .= 'width:' . $swatch_width . 'px;';
				$this->swatch_width = $swatch_width;
			}
			if ( $swatch_height !== '' ) {
				$style              .= 'height:' . $swatch_height . 'px;';
				$this->swatch_height = $swatch_height;
			}

			if ( $swatch_main_strip_highlight_font_size !== '' ) {
				$highlight_style .= 'font-size:' . $swatch_main_strip_highlight_font_size . 'px;';
			}
			if ( $swatch_main_strip_highlight_font_weight !== '' ) {
				$highlight_style .= 'font-weight:' . $swatch_main_strip_highlight_font_weight . ';';
			}
			if ( $swatch_main_strip_highlight_color !== '' ) {
				$highlight_style .= 'color:' . $swatch_main_strip_highlight_color . ';';
			}

			if ( $main_strip_font_family != '' ) {
				$mhfont_family = get_ultimate_font_family( $main_strip_font_family );
				$main_style   .= 'font-family:\'' . $mhfont_family . '\';';
			}
			$main_style .= get_ultimate_font_style( $main_strip_font_style );
			if ( $swatch_main_strip_font_size !== '' ) {
				$main_style .= 'font-size:' . $swatch_main_strip_font_size . 'px;';
			}
			if ( $swatch_main_strip_font_style !== '' ) {
				$main_style .= 'font-weight:' . $swatch_main_strip_font_style . ';';
			}
			if ( $swatch_main_strip_color !== '' ) {
				$main_style .= 'color:' . $swatch_main_strip_color . ';';
			}
			if ( $swatch_main_strip_bg_color !== '' ) {
				$main_style .= 'background:' . $swatch_main_strip_bg_color . ';';
			}

			$output .= '<div id="ulsb-container-' . $uid . '" class="ulsb-container ulsb-' . $swatch_style . '" style="width:' . $swatch_width . 'px; height:' . $swatch_height . 'px;">';
			$output .= JsComposer::do_shortcode( $content );
			$output .= '<div class="ulsb-strip highlight-strip" style="' . $style . '">';
			$output .= '<h4 class="strip_main_text" style="' . $main_style . '"><span>' . $swatch_main_strip_text . '</span></h4>';
			$output .= '<h5 class="strip_highlight_text" style="' . $highlight_style . '"><span>' . $swatch_main_strip_highlight_text . '</span></h5>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '<script type="text/javascript">
						jQuery(function() {';
			if ( $swatch_style == 'style-1' ) {
				$output .= 'jQuery( "#ulsb-container-' . $uid . '" ).swatchbook();';
			}
			if ( $swatch_style == 'style-2' ) {
				$output .= 'jQuery( "#ulsb-container-' . $uid . '" ).swatchbook( {
									angleInc : -10,
									proximity : -45,
									neighbor : -4,
									closeIdx : 11
								} );';
			}
			if ( $swatch_style == 'style-3' ) {
				$output .= 'jQuery( "#ulsb-container-' . $uid . '" ).swatchbook( {
									angleInc : 15,
									neighbor : 15,
									initclosed : true,
									closeIdx : 11
								} );';
			}
			if ( $swatch_style == 'style-4' ) {
				$output .= 'jQuery( "#ulsb-container-' . $uid . '" ).swatchbook( {
									speed : 500,
									easing : "ease-out",
									center : 7,
									angleInc : 14,
									proximity : 40,
									neighbor : 2
								} );';
			}
			if ( $swatch_style == 'style-5' ) {
				$output .= 'jQuery( "#ulsb-container-' . $uid . '" ).swatchbook( {	openAt : 0	} );';
			}
			if ( $swatch_style == 'custom' ) {
				$output .= 'jQuery( "#ulsb-container-' . $uid . '" ).swatchbook( {
									speed : ' . $swatch_trans_speed . ',
									easing : "ease-out",
									center : ' . $swatch_index_center . ',
									angleInc : ' . $swatch_space_degree . ',
									proximity : 40,
									neighbor : ' . $swatch_distance_sibling . ',
									openAt : ' . $swatch_open_at . ',
									closeIdx : ' . $swatch_init_closed . '
								} );';
			}
			$output .= '});';
			$output .= 'jQuery(document).ready(function(e) {
						var ult_strip = jQuery(".highlight-strip");
						ult_strip.each(function(index, element) {
							var strip_main_text = jQuery(this).children(".strip_main_text").outerHeight();
							var height = ' . $swatch_height . '-strip_main_text;
							jQuery(this).children(".strip_highlight_text").css("height",height);
						});
					});';
			$output .= '</script>';
			return $output;
		}

		function swatch_item( $atts, $content = null ) {
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $el_class = $icon_animation = $swatch_strip_font_size = $swatch_strip_font_weight = $swatch_strip_font_color = $swatch_strip_bg_color = $swatch_strip_title_bg_color = '';
			extract(
				JsComposer::shortcode_atts(
					array(
						'swatch_strip_text'           => '',
						'icon_type'                   => '',
						'icon'                        => '',
						'icon_img'                    => '',
						'img_width'                   => '',
						'icon_size'                   => '',
						'icon_color'                  => '',
						'icon_style'                  => '',
						'icon_color_bg'               => '',
						'icon_color_border'           => '',
						'icon_border_style'           => '',
						'icon_border_size'            => '',
						'icon_border_radius'          => '',
						'icon_border_spacing'         => '',
						'icon_animation'              => '',
						'swatch_strip_font_size'      => '',
						'swatch_strip_font_weight'    => '',
						'swatch_strip_font_color'     => '',
						'swatch_strip_bg_color'       => '',
						'swatch_strip_title_bg_color' => '',
						'el_class'                    => '',
					),
					$atts
				)
			);
			$output   = '';
			$box_icon = JsComposer::do_shortcode( '[just_icon icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_animation="' . $icon_animation . '"]' );
			$style    = '';
			if ( $this->swatch_trans_bg_img !== '' ) {
				$img    = JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url( $this->swatch_trans_bg_img );
				$style .= 'background-image: url(' . $img . ');';
			}
			if ( $swatch_strip_bg_color !== '' ) {
				$style .= 'background-color: ' . $swatch_strip_bg_color . ';';
			}
			if ( $this->swatch_width !== '' ) {
				$style .= 'width:' . $this->swatch_width . 'px;';
			}
			if ( $this->swatch_height !== '' ) {
				$style .= 'height:' . $this->swatch_height . 'px;';
			}
			$output .= '<div class="ulsb-strip ' . $el_class . '" style="' . $style . '">';
			$output .= '<span class="ulsb-icon">' . $box_icon . '</span>';
			$output .= '<h4 style="color:' . $swatch_strip_font_color . '; background:' . $swatch_strip_title_bg_color . '; font-size:' . $swatch_strip_font_size . 'px; font-style: ' . $swatch_strip_font_weight . ';"><span>' . $swatch_strip_text . '</span></h4>';
			$output .= '</div>';
			return $output;
		}

	}

}


global $Ultimate_Swatch_Book;
$Ultimate_Swatch_Book = new Ultimate_Swatch_Book();
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

	class WPBakeryShortCode_swatch_container extends WPBakeryShortCodesContainer {

		function content( $atts, $content = null ) {
			global $Ultimate_Swatch_Book;
			return $Ultimate_Swatch_Book->swatch_container( $atts, $content );
		}

	}

	class WPBakeryShortCode_swatch_item extends WPBakeryShortCode {

		function content( $atts, $content = null ) {
			global $Ultimate_Swatch_Book;
			return $Ultimate_Swatch_Book->swatch_item( $atts, $content );
		}

	}

}
