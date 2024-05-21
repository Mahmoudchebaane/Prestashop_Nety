<?php
/*
* Add-on Name: Info Banner
*/
if ( ! class_exists( 'Ultimate_Info_Banner' ) ) {
	class Ultimate_Info_Banner {
		public $vcaddonsinstance, $context;
		function __construct() {
					$this->vcaddonsinstance = jscomposer::getInstance();
					$this->context          = Context::getContext();
			// add_action('admin_init',array($this,'banner_init'));
			JsComposer::add_shortcode( 'ultimate_info_banner', array( $this, 'banner_shortcode' ) );
			// add_action('wp_enqueue_scripts', array($this, 'register_info_banner_assets'),1);
		}
		function register_info_banner_assets() {
			// wp_register_script('utl-info-banner-script',plugins_url('../assets/min-js/info-banner.min.js',__FILE__),array('jquery'), ULTIMATE_VERSION);
			// wp_register_style('utl-info-banner-style',plugins_url('../assets/min-css/info-banner.min.css',__FILE__),array('jquery'), ULTIMATE_VERSION);
			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/info-banner.min.js" );
						$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/info-banner.min.css" );

		}
		function banner_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Info Banner' ),
						'base'        => 'ultimate_info_banner',
						'class'       => 'vc_info_banner_icon',
						'icon'        => 'vc_icon_info_banner',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Displays the banner information' ),
						'params'      => array(
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Title ' ),
								'param_name'  => 'banner_title',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( 'Give a title to this banner' ),
							),
							array(
								'type'        => 'textarea',
								'class'       => '',
								'heading'     => $vc->l( 'Description' ),
								'param_name'  => 'banner_desc',
								'value'       => '',
								'description' => $vc->l( 'Text that comes on mouse hover.' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Button Text' ),
								'param_name'  => 'button_text',
								'admin_label' => true,
								'value'       => '',
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => $vc->l( 'Link ' ),
								'param_name'  => 'button_link',
								'value'       => '',
								'description' => $vc->l( 'Add link / select existing page to link to this banner' ),
							),
							array(
								'type'       => 'dropdown',
								'heading'    => 'Information Alignment',
								'param_name' => 'info_alignment',
								'value'      => array(
									'Center' => 'ib3-info-center',
									'Left'   => 'ib3-info-left',
									'Right'  => 'ib3-info-right',
								),
							),
							array(
								'type'       => 'dropdown',
								'heading'    => 'Animation Effect',
								'param_name' => 'info_effect',
								'value'      => array(
									'No Effect'     => '',
									'Fade-In'       => 'fadeIn',
									'Fade-In Left'  => 'fadeInLeft',
									'Fade-In Right' => 'fadeInRight',
									'Fade-In Up'    => 'fadeInUp',
									'Fade-In Down'  => 'fadeInDown',
									'Flip'          => 'flipInX',
									'Zoom'          => 'zoomIn',
								),
							),
							array(
								'type'        => 'attach_image',
								'class'       => '',
								'heading'     => $vc->l( 'Banner Image' ),
								'param_name'  => 'banner_image',
								'value'       => '',
								'description' => $vc->l( 'Upload the image for this banner' ),
								'group'       => 'Image',
							),
							array(
								'type'       => 'number',
								'param_name' => 'banner_size',
								'heading'    => 'Banner Min Height',
								'value'      => '320',
								'min'        => '50',
								'suffix'     => 'px',
								'group'      => 'Design',
							),

							array(
								'type'       => 'dropdown',
								'heading'    => 'Image Alignment',
								'param_name' => 'ib3_alignment',
								'value'      => array(
									$vc->l( 'Top Left', 'js_composer' ) => 'ultb3-img-top-left',
									$vc->l( 'Top Center', 'js_composer' ) => 'ultb3-img-top-center',
									$vc->l( 'Top Right', 'js_composer' ) => 'ultb3-img-top-right',
									$vc->l( 'Center Left', 'js_composer' ) => 'ultb3-img-center-left',
									$vc->l( 'Center', 'js_composer' ) => 'ultb3-img-center',
									$vc->l( 'Center Right', 'js_composer' ) => 'ultb3-img-center-right',
									$vc->l( 'Bottom Left', 'js_composer' ) => 'ultb3-img-bottom-left',
									$vc->l( 'Bottom Center', 'js_composer' ) => 'ultb3-img-bottom-center',
									$vc->l( 'Bottom Right', 'js_composer' ) => 'ultb3-img-bottom-right',
								),
								'group'      => 'Image',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => 'Effect',
								'param_name' => 'ib3_effect',
								'value'      => array(
									$vc->l( 'No Effect', 'js_composer' ) => '',
									$vc->l( 'Slide Down', 'js_composer' ) => 'ultb3-hover-1',
									$vc->l( 'Slide Up', 'js_composer' ) => 'ultb3-hover-2',
									$vc->l( 'Slide Left', 'js_composer' ) => 'ultb3-hover-3',
									$vc->l( 'Slide Right', 'js_composer' ) => 'ultb3-hover-4',
									$vc->l( 'Pan', 'js_composer' ) => 'ultb3-hover-5',
									$vc->l( 'Zoom Out', 'js_composer' ) => 'ultb3-hover-6',
								),
								'group'      => 'Image',
							),
							array(
								'type'       => 'colorpicker',
								'heading'    => 'Overlay Color on Image',
								'param_name' => 'overlay_color',
								'value'      => '',
								'group'      => 'Image',
								'dependency' => array(
									'element' => 'enable_overlay',
									'value'   => array( 'enable_overlay_value' ),
								),
							),
							array(
								'type'             => 'ult_param_heading',
								'text'             => 'Image Height',
								'param_name'       => 'image_height_typography',
								'class'            => 'ult-param-heading',
								'group'            => 'Image',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'             => 'number',
								'param_name'       => 'banner_img_height_large_screen',
								'heading'          => "<i class='dashicons dashicons-welcome-view-site'></i> Large Screen",
								'min'              => '50',
								'value'            => '',
								'suffix'           => 'px',
								'group'            => 'Image',
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								'type'             => 'number',
								'param_name'       => 'banner_img_height',
								'heading'          => "<i class='dashicons dashicons-desktop'></i> Desktop",
								'min'              => '50',
								'value'            => '',
								'suffix'           => 'px',
								'group'            => 'Image',
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								'type'             => 'number',
								'heading'          => $vc->l( "<i class='dashicons dashicons-tablet' style='transform: rotate(90deg);'></i> Tablet" ),
								'param_name'       => 'banner_img_height_tablet',
								'value'            => '',
								'suffix'           => 'px',
								'group'            => 'Image',
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								'type'             => 'number',
								'heading'          => $vc->l( "<i class='dashicons dashicons-tablet'></i> Tablet Portrait" ),
								'param_name'       => 'banner_img_height_tablet_portrait',
								'value'            => '',
								'suffix'           => 'px',
								'group'            => 'Image',
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								'type'             => 'number',
								'heading'          => $vc->l( "<i class='dashicons dashicons-smartphone' style='transform: rotate(90deg);'></i> Mobile Landscape" ),
								'param_name'       => 'banner_img_height_mobile_landscape',
								'value'            => '',
								'suffix'           => 'px',
								'group'            => 'Image',
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								'type'             => 'number',
								'heading'          => $vc->l( "<i class='dashicons dashicons-smartphone'></i> Mobile" ),
								'param_name'       => 'banner_img_height_mobile',
								'value'            => '',
								'suffix'           => 'px',
								'group'            => 'Image',
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								'type'       => 'colorpicker',
								'heading'    => 'Background Color',
								'param_name' => 'ib3_background',
								'group'      => 'Design',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => 'Border',
								'param_name' => 'ib3_border',
								'value'      => array(
									'No Border' => 'no-border',
									'Solid'     => 'solid',
									'Dashed'    => 'dashed',
									'Dotted'    => 'dotted',
									'Double'    => 'double',
								),
								'group'      => 'Design',
							),
							array(
								'type'       => 'number',
								'heading'    => 'Border Width',
								'param_name' => 'ib3_border_width',
								'suffix'     => 'px',
								'value'      => '1',
								'group'      => 'Design',
								'dependency' => array(
									'element' => 'ib3_border',
									'value'   => array( 'solid', 'dashed', 'dotted', 'double' ),
								),
							),
							array(
								'type'       => 'colorpicker',
								'heading'    => 'Border Color',
								'param_name' => 'ib3_border_color',
								'group'      => 'Design',
								'dependency' => array(
									'element' => 'ib3_border',
									'value'   => array( 'solid', 'dashed', 'dotted', 'double' ),
								),
							),
							array(
								'type'       => 'colorpicker',
								'heading'    => 'Button Color',
								'param_name' => 'button_color',
								'value'      => '#1e73be',
								'group'      => 'Button',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Text Color' ),
								'param_name' => 'button_text_color',
								'value'      => '#898989',
								'group'      => 'Button',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Text Hover Color' ),
								'param_name' => 'button_text_hover_color',
								'value'      => '#ffffff',
								'group'      => 'Button',
							),
							array(
								'type'       => 'number',
								'heading'    => 'Border Width',
								'param_name' => 'button_border_width',
								'value'      => '2',
								'suffix'     => 'px',
								'group'      => 'Button',
							),
							array(
								'type'       => 'number',
								'heading'    => 'Border Radius',
								'param_name' => 'button_border_radius',
								'value'      => '50',
								'suffix'     => 'px',
								'group'      => 'Button',
							),
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Title Settings' ),
								'param_name'       => 'title_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								'type'       => 'ultimate_google_fonts',
								'heading'    => $vc->l( 'Font Family' ),
								'param_name' => 'title_font_family',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'title_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'title_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'title_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'title_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Description Settings' ),
								'param_name'       => 'desc_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'desc_font_family',
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'desc_font_style',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => 'font-size',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'desc_font_size',
								'min'        => 10,
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Font Color' ),
								'param_name' => 'desc_color',
								'value'      => '',
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'desc_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
							),
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Button Settings' ),
								'param_name'       => 'button_typograpy',
								'group'            => 'Typography',
								'class'            => 'ult-param-heading',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'       => 'ultimate_google_fonts',
								'heading'    => $vc->l( 'Font Family' ),
								'param_name' => 'button_font_family',
								'group'      => 'Typography',
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
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Line Height' ),
								'param_name' => 'button_line_height',
								'value'      => '',
								'suffix'     => 'px',
								'group'      => 'Typography',
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
		function banner_shortcode( $atts ) {
			$output = $el_class = $style = $img_style = '';
			$this->register_info_banner_assets();
			extract(
				JsComposer::shortcode_atts(
					array(
						'banner_title'                   => '',
						'banner_desc'                    => '',
						'info_alignment'                 => 'ib3-info-center',
						'banner_image'                   => '',
						'banner_size'                    => '50',
						'ib3_alignment'                  => 'ultb3-img-left',
						'button_text'                    => '',
						'button_link'                    => '',
						'info_effect'                    => '',
						'ib3_effect'                     => '',
						'ib3_background'                 => '',
						'ib3_border'                     => '',
						'ib3_border_width'               => '',
						'ib3_border_color'               => '',
						'title_font_family'              => '',
						'title_font_style'               => '',
						'title_font_size'                => '',
						'title_color'                    => '',
						'title_line_height'              => '',
						'desc_font_family'               => '',
						'desc_font_style'                => '',
						'desc_font_size'                 => '',
						'desc_color'                     => '',
						'desc_line_height'               => '',
						'button_font_family'             => '',
						'button_font_style'              => '',
						'button_font_size'               => '',
						'button_color'                   => '',
						'button_line_height'             => '',
						'button_border_radius'           => '',
						'button_border_width'            => '2',
						'button_text_color'              => '',
						'button_text_hover_color'        => '',
						'banner_img_height_large_screen' => '',
						'banner_img_height'              => '',
						'banner_img_height_tablet'       => '',
						'banner_img_height_tablet_portrait' => '',
						'banner_img_height_mobile'       => '',
						'banner_img_height_mobile_landscape' => '',
						'overlay_color'                  => '',
						'el_class'                       => '',
					),
					$atts
				)
			);

			/* typography */
			$title_style_inline = $desc_style_inline = $button_style_inline = '';
			if ( $title_font_family != '' ) {
				$temp                = get_ultimate_font_family( $title_font_family );
				$title_style_inline .= 'font-family:' . $temp . ';';
			}

			$title_style_inline .= get_ultimate_font_style( $title_font_style );

			if ( $title_font_size != '' ) {
				$title_style_inline .= 'font-size:' . $title_font_size . 'px;';
			}

			if ( $title_color != '' ) {
				$title_style_inline .= 'color:' . $title_color . ';';
			}

			if ( $title_line_height != '' ) {
				$title_style_inline .= 'line-height:' . $title_line_height . 'px;';
			}

			if ( $desc_font_family != '' ) {
				$temp               = get_ultimate_font_family( $desc_font_family );
				$desc_style_inline .= 'font-family:' . $temp . ';';
			}

			$desc_style_inline .= get_ultimate_font_style( $desc_font_style );

			if ( $desc_font_size != '' ) {
				$desc_style_inline .= 'font-size:' . $desc_font_size . 'px;';
			}

			if ( $desc_color != '' ) {
				$desc_style_inline .= 'color:' . $desc_color . ';';
			}

			if ( $desc_line_height != '' ) {
				$desc_style_inline .= 'line-height:' . $desc_line_height . 'px;';
			}

			if ( $button_font_family != '' ) {
				$temp                 = get_ultimate_font_family( $button_font_family );
				$button_style_inline .= 'font-family:' . $temp . ';';
			}

			$button_style_inline .= get_ultimate_font_style( $button_font_style );

			if ( $button_font_size != '' ) {
				$button_style_inline .= 'font-size:' . $button_font_size . 'px;';
			}

			if ( $button_line_height != '' ) {
				$button_style_inline .= 'line-height:' . $button_line_height . 'px;';
			}

			$args = array(
				$title_font_family,
				$desc_font_family,
				$button_font_family,
			);
			enquque_ultimate_google_fonts( $args );
			/*end typography */

			// $banner_src = wp_get_attachment_image_src($banner_image,'full');
			$banner_src = array( JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url( $banner_image ) );
			// $banner_img_meta = wp_get_attachment_metadata($banner_image);
			$banner_img_meta = JsComposer::get_media_thumbnail_url( $banner_image );

			if ( isset( $banner_img_meta['image_meta']['caption'] ) && $banner_img_meta['image_meta']['caption'] != '' ) {
				$caption = $banner_img_meta['image_meta']['caption'];
			} elseif ( isset( $banner_img_meta['image_meta']['title'] ) && $banner_img_meta['image_meta']['title'] != '' ) {
				$caption = $banner_img_meta['image_meta']['title'];
			} else {
				$caption = 'ib3 image';
			}

			if ( $ib3_background != '' ) {
				$style .= 'background-color: ' . $ib3_background . ';';
			}

			if ( $ib3_border != 'no-border' ) {
				$style .= 'border:' . $ib3_border_width . 'px ' . $ib3_border . ' ' . $ib3_border_color . ';';
			}

			$id = uniqid( rand() );

			$button_link_main = $title = $target = '';

			if ( $button_link != '' ) {
				$button_link_temp = vc_build_link( $button_link );
				$button_link_main = $button_link_temp['url'];
				$title            = $button_link_temp['title'];
				$target           = $button_link_temp['target'];
			}
			if ( $button_link_main == '' ) {
				$button_link_main = 'javascript:void(0);';
			}

			$output .= '<div id="ultib3-' . $id . '" class="ultb3-box ' . $el_class . ' ' . $ib3_effect . '" style="' . $style . '">';
			if ( $overlay_color != '' ) {
				$output .= '<div class="ultb3-box-overlay" style="background:' . $overlay_color . ';"></div>';
			}

			if ( isset( $banner_src[0] ) && $banner_src[0] != '' ) {
				$output .= '<img src="' . $banner_src[0] . '" style="' . $img_style . '" class="ultb3-img ' . $ib3_alignment . '" alt="' . $caption . '"/>';
			}

				$output .= '<div class="ultb3-info ' . $info_alignment . '" data-animation="' . $info_effect . '" data-animation-delay="03">';
			if ( $banner_title != '' ) {
				$output .= '<div class="ultb3-title" style="' . $title_style_inline . '">' . $banner_title . '</div>';
			}
			if ( $banner_desc != '' ) {
				$output .= '<div class="ultb3-desc" style="' . $desc_style_inline . '">' . $banner_desc . '</div>';
			}
			if ( $button_text != '' ) {
				if ( $target != '' ) {
					$target = 'target="' . $target . '"';
				}
				$output .= '<a href="' . $button_link_main . '" ' . $target . ' class="ultb3-btn" style="' . $button_style_inline . '">' . $button_text . '<i class="dashicons dashicons-arrow-right-alt2"></i></a>';
			}
				$output .= '</div>';
			$output     .= '</div>';

			$global_button_style = $global_button_hover_style = '';
			$is_css              = false;

			if ( $button_color != '' ) {
				$global_button_style       .= 'border:' . $button_border_width . 'px solid ' . $button_color . ';';
				$global_button_hover_style .= 'background:' . $button_color . ';';
				$is_css                     = true;
			}

			if ( $button_border_radius != '' ) {
				$global_button_style .= 'border-radius:' . $button_border_radius . 'px;';
				$is_css               = true;
			}

			if ( $button_text_color != '' ) {
				$global_button_style .= 'color:' . $button_text_color . ';';
				$is_css               = true;
			}

			if ( $button_text_hover_color != '' ) {
				$global_button_hover_style .= 'color:' . $button_text_hover_color . ';';
				$is_css                     = true;
			}

			if ( $is_css ) {
				$output .= '<style>
					#ultib3-' . $id . ' {
						min-height:' . $banner_size . 'px;
					}
					#ultib3-' . $id . ' img.ultb3-img {
						height: ' . $banner_img_height . 'px;
					}
					#ultib3-' . $id . ' .ultb3-btn {
						' . $global_button_style . '
					}
					#ultib3-' . $id . ' .ultb3-btn:hover {
						' . $global_button_hover_style . '
					}
				</style>';
				if ( $banner_img_height_large_screen != '' ) {
					$output .= '<style>
						@media (min-width: 1824px) {
							 #ultib3-' . $id . ' img.ultb3-img {
								height:' . $banner_img_height_large_screen . 'px;
							}
						}
					</style>';
				}
				if ( $banner_img_height_tablet != '' ) {
					$output .= '<style>
						@media (max-width: 1199px) {
							 #ultib3-' . $id . ' img.ultb3-img {
								height:' . $banner_img_height_tablet . 'px;
							}
						}
					</style>';
				}
				if ( $banner_img_height_tablet_portrait != '' ) {
					$output .= '<style>
						@media (max-width: 991px) {
							 #ultib3-' . $id . ' img.ultb3-img {
								height:' . $banner_img_height_tablet_portrait . 'px;
							}
						}
					</style>';
				}
				if ( $banner_img_height_mobile_landscape != '' ) {
					$output .= '<style>
						@media (max-width: 767px) {
							 #ultib3-' . $id . ' img.ultb3-img {
								height:' . $banner_img_height_mobile_landscape . 'px;
							}
						}
					</style>';
				}
				if ( $banner_img_height_mobile != '' ) {
					$output .= '<style>
						@media (max-width: 479px) {
							 #ultib3-' . $id . ' img.ultb3-img {
								height:' . $banner_img_height_mobile . 'px;
							}
						}
					</style>';
				}
			}

			return $output;
		}
	}
}