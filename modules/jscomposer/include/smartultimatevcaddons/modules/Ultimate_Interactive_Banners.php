<?php

/*
 * Add-on Name: Interactive Banners for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if ( ! class_exists( 'AIO_Interactive_Banners' ) ) {

	class AIO_Interactive_Banners {

		public $vcaddonsinstance, $context;

		function __construct() {
			$this->context          = Context::getContext();
			$this->vcaddonsinstance = jscomposer::getInstance();

			// add_action('admin_init',array($this,'banner_init'));
			JsComposer::add_shortcode( 'interactive_banner', array( &$this, 'banner_shortcode' ) );

		}

		function interactive_banner_styles() {

			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/interactive-styles.min.css" );
		}

		function banner_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Interactive Banner' ),
						'base'        => 'interactive_banner',
						'class'       => 'vc_interactive_icon',
						'icon'        => 'vc_icon_interactive',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Displays the banner image with Information' ),
						'params'      => array(
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Interactive Banner Title ' ),
								'param_name'  => 'banner_title',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( 'Give a title to this banner' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Banner Title Location ' ),
								'param_name'  => 'banner_title_location',
								'value'       => array(
									$vc->l( 'Title on Center' ) => 'center',
									$vc->l( 'Title on Left' ) => 'left',
								),
								'description' => $vc->l( 'Alignment of the title.' ),
							),
							array(
								'type'        => 'textarea',
								'class'       => '',
								'heading'     => $vc->l( 'Banner Description' ),
								'param_name'  => 'banner_desc',
								'value'       => '',
								'description' => $vc->l( 'Text that comes on mouse hover.' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Use Icon' ),
								'param_name'  => 'icon_disp',
								'value'       => array(
									'None'              => 'none',
									'Icon with Heading' => 'with_heading',
									'Icon with Description' => 'with_description',
									'Both'              => 'both',
								),
								'description' => $vc->l( 'Icon can be displayed with title and description.' ),
							),
							array(
								'type'        => 'icon_manager',
								'class'       => '',
								'heading'     => $vc->l( 'Select Icon' ),
								'param_name'  => 'banner_icon',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=AIO_Icon_Manager' target='_blank'>add new here</a>." ),
								'dependency'  => array(
									'element' => 'icon_disp',
									'value'   => array( 'with_heading', 'with_description', 'both' ),
								),
							),
							array(
								'type'        => 'attach_image',
								'class'       => '',
								'heading'     => $vc->l( 'Banner Image' ),
								'param_name'  => 'banner_image',
								'value'       => '',
								'description' => $vc->l( 'Upload the image for this banner' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Banner height Type' ),
								'param_name'  => 'banner_height',
								'value'       => array(
									'Auto Height'   => '',
									'Custom Height' => 'banner-block-custom-height',
								),
								'description' => $vc->l( 'Selct between Auto or Custom height for Banner.' ),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Banner height Value' ),
								'param_name'  => 'banner_height_val',
								'value'       => '',
								'suffix'      => 'px',
								'description' => $vc->l( 'Give height in pixels for interactive banner.' ),
								'dependency'  => array(
									'element' => 'banner_height',
									'value'   => array( 'banner-block-custom-height' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Apply link to:' ),
								'param_name'  => 'link_opts',
								'value'       => array(
									'No Link'           => 'none',
									'Complete Box'      => 'box',
									'Display Read More' => 'more',
								),
								'description' => $vc->l( 'Select whether to use color for icon or not.' ),
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => $vc->l( 'Banner Link ' ),
								'param_name'  => 'banner_link',
								'value'       => '',
								'description' => $vc->l( 'Add link / select existing page to link to this banner' ),
								'dependency'  => array(
									'element' => 'link_opts',
									'value'   => array( 'box', 'more' ),
								),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Link Text' ),
								'param_name'  => 'banner_link_text',
								'value'       => '',
								'description' => $vc->l( 'Enter text for button' ),
								'dependency'  => array(
									'element' => 'link_opts',
									'value'   => array( 'more' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Box Hover Effects' ),
								'param_name'  => 'banner_style',
								'value'       => array(
									$vc->l( 'Appear From Bottom' ) => 'style01',
									$vc->l( 'Appear From Top' ) => 'style02',
									$vc->l( 'Appear From Left' ) => 'style03',
									$vc->l( 'Appear From Right' ) => 'style04',
									$vc->l( 'Zoom In' )  => 'style11',
									$vc->l( 'Zoom Out' ) => 'style12',
									$vc->l( 'Zoom In-Out' ) => 'style13',
									$vc->l( 'Jump From Left' ) => 'style21',
									$vc->l( 'Jump From Right' ) => 'style22',
									$vc->l( 'Pull From Bottom' ) => 'style31',
									$vc->l( 'Pull From Top' ) => 'style32',
									$vc->l( 'Pull From Left' ) => 'style33',
									$vc->l( 'Pull From Right' ) => 'style34',
								),
								'description' => $vc->l( 'Select animation effect style for this block.' ),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Heading Background Color' ),
								'param_name'  => 'banner_bg_color',
								'value'       => '#242424',
								'description' => $vc->l( 'Select the background color for banner heading' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Background Color Opacity' ),
								'param_name'  => 'banner_opacity',
								'value'       => array(
									'Transparent Background' => 'opaque',
									'Solid Background' => 'solid',
								),
								'description' => $vc->l( 'Select the background opacity for content overlay' ),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Extra Class' ),
								'param_name'  => 'el_class',
								'value'       => '',
								'description' => $vc->l( 'Add extra class name that will be applied to the icon process, and you can use this class for your customizations.' ),
							),
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Banner Title Settings' ),
								'param_name'       => 'banner_title_typograpy',
								'dependency'       => array(
									'element'   => 'banner_title',
									'not_empty' => true,
								),
								'group'            => 'Typography',
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'banner_title_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'dependency'  => array(
									'element'   => 'banner_title',
									'not_empty' => true,
								),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'banner_title_style',
								// "description" =>  $vc->l("Main heading font style"),
								'dependency' => array(
									'element'   => 'banner_title',
									'not_empty' => true,
								),
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'banner_title_font_size',
								'min'        => 12,
								'suffix'     => 'px',
								// "description" => $vc->l("Sub heading font size"),
								'dependency' => array(
									'element'   => 'banner_title',
									'not_empty' => true,
								),
								'group'      => 'Typography',
							),
							array(
								'type'             => 'ult_param_heading',
								'text'             => $vc->l( 'Banner Description Settings' ),
								'param_name'       => 'banner_desc_typograpy',
								'dependency'       => array(
									'element'   => 'banner_desc',
									'not_empty' => true,
								),
								'group'            => 'Typography',
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								'type'        => 'ultimate_google_fonts',
								'heading'     => $vc->l( 'Font Family' ),
								'param_name'  => 'banner_desc_font_family',
								'description' => $vc->l( "Select the font of your choice." ),
								'dependency'  => array(
									'element'   => 'banner_desc',
									'not_empty' => true,
								),
								'group'       => 'Typography',
							),
							array(
								'type'       => 'ultimate_google_fonts_style',
								'heading'    => $vc->l( 'Font Style' ),
								'param_name' => 'banner_desc_style',
								// "description" =>  $vc->l("Main heading font style"),
								'dependency' => array(
									'element'   => 'banner_desc',
									'not_empty' => true,
								),
								'group'      => 'Typography',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Font Size' ),
								'param_name' => 'banner_desc_font_size',
								'min'        => 12,
								'suffix'     => 'px',
								// "description" => $vc->l("Sub heading font size"),
								'dependency' => array(
									'element'   => 'banner_desc',
									'not_empty' => true,
								),
								'group'      => 'Typography',
							),
						),
					)
				);
			}
		}

		// Shortcode handler function for stats banner
		function banner_shortcode( $atts ) {
			$banner_title = $banner_desc = $banner_icon = $banner_image = $banner_link = $banner_link_text = $banner_style = $banner_bg_color = $el_class = $animation = $icon_disp = $link_opts = $banner_title_location = $banner_title_style_inline = $banner_desc_style_inline = '';
			$this->interactive_banner_styles();
			extract(
				JsComposer::shortcode_atts(
					array(
						'banner_title'             => '',
						'banner_desc'              => '',
						'banner_title_location'    => '',
						'icon_disp'                => '',
						'banner_icon'              => '',
						'banner_image'             => '',
						'banner_height'            => '',
						'banner_height_val'        => '',
						'link_opts'                => '',
						'banner_link'              => '',
						'banner_link_text'         => '',
						'banner_style'             => '',
						'banner_bg_color'          => '',
						'banner_opacity'           => '',
						'el_class'                 => '',
						'animation'                => '',
						'banner_title_font_family' => '',
						'banner_title_style'       => '',
						'banner_title_font_size'   => '',
						'banner_desc_font_family'  => '',
						'banner_desc_style'        => '',
						'banner_desc_font_size'    => '',
					),
					$atts
				)
			);
			$output = $icon = $style = $target = '';
			// $banner_style = 'style01';

			if ( $banner_title_font_family != '' ) {
				$bfamily                   = get_ultimate_font_family( $banner_title_font_family );
				$banner_title_style_inline = 'font-family:\'' . $bfamily . '\';';
			}
			$banner_title_style_inline .= get_ultimate_font_style( $banner_title_style );
			if ( $banner_title_font_size != '' ) {
				$banner_title_style_inline .= 'font-size:' . $banner_title_font_size . 'px;';
			}
			if ( $banner_bg_color != '' ) {
				$banner_title_style_inline .= 'background:' . $banner_bg_color . ';';
			}

			if ( $banner_desc_font_family != '' ) {
				$bdfamily                 = get_ultimate_font_family( $banner_desc_font_family );
				$banner_desc_style_inline = 'font-family:\'' . $bdfamily . '\';';
			}
			$banner_desc_style .= get_ultimate_font_style( $banner_desc_style );
			if ( $banner_desc_font_size != '' ) {
				$banner_desc_style_inline .= 'font-size:' . $banner_desc_font_size . 'px;';
			}

			// enqueue google font
			$args = array(
				$banner_title_font_family,
				$banner_desc_font_family,
			);
			enquque_ultimate_google_fonts( $args );

			if ( $animation !== 'none' ) {
				$css_trans = 'data-animation="' . $animation . '" data-animation-delay="03"';
			}

			if ( $banner_icon !== '' ) {
				$icon = '<i class="' . $banner_icon . '"></i>';
			}
			// $img = wp_get_attachment_image_src( $banner_image, 'large');
			$img  = JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url( $banner_image );
			$href = vc_build_link( $banner_link );
			if ( isset( $href['target'] ) && $href['target'] != '' ) {
				$target = 'target="' . $href['target'] . '"';
			}
			$banner_top_style = '';
			if ( $banner_height != '' && $banner_height_val != '' ) {
				$banner_top_style = 'height:' . $banner_height_val . 'px;';
			}
			$output .= "\n" . '<div class="banner-block ' . $banner_height . ' banner-' . $banner_style . ' ' . $el_class . '"  ' . $css_trans . ' style="' . $banner_top_style . '">';
			$output .= "\n\t" . '<img src="' . $img . '" alt="' . $banner_title . '">';
			if ( $banner_title !== '' ) {
				$output .= "\n\t" . '<h3 class="title-' . $banner_title_location . ' bb-top-title" style="' . $banner_title_style_inline . '">' . $banner_title;
				if ( $icon_disp == 'with_heading' || $icon_disp == 'both' ) {
					$output .= $icon;
				}
				$output .= '</h3>';
			}
			$output .= "\n\t" . '<div class="mask ' . $banner_opacity . '-background">';
			if ( $icon_disp == 'with_description' || $icon_disp == 'both' ) {
				if ( $banner_icon !== '' ) {
					$output .= "\n\t\t" . '<div class="bb-back-icon">' . $icon . '</div>';
					$output .= "\n\t\t" . '<p>' . $banner_desc . '</p>';
				}
			} else {
				$output .= "\n\t\t" . '<p class="bb-description" style="' . $banner_desc_style_inline . '">' . $banner_desc . '</p>';
			}
			if ( $link_opts == 'more' ) {
				$output .= "\n\t\t" . '<a class="bb-link" href="' . $href['url'] . '" ' . $target . '>' . $banner_link_text . '</a>';
			}
			$output .= "\n\t" . '</div>';
			$output .= "\n" . '</div>';
			if ( $link_opts == 'box' ) {
				$banner_with_link = '<a class="bb-link" href="' . $href['url'] . '" ' . $target . '>' . $output . '</a>';
				return $banner_with_link;
			} else {
				return $output;
			}
		}

	}

}
if ( class_exists( 'AIO_Interactive_Banners' ) ) {
	$AIO_Interactive_Banners = new AIO_Interactive_Banners();
}
