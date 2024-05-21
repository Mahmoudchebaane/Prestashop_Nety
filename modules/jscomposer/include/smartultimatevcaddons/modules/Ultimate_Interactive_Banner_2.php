<?php
/*
* Add-on Name: Interactive Banner - 2
*/
if ( ! class_exists( 'Ultimate_Interactive_Banner' ) ) {
	class Ultimate_Interactive_Banner {
		function __construct() {
			// add_action('admin_init',array($this,'banner_init'));
			JsComposer::add_shortcode( 'interactive_banner_2', array( &$this, 'banner_shortcode' ) );
		}
		function banner_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				$json = ultimate_get_banner2_json();
				vc_map(
					array(
						'name'        => $vc->l( 'Interactive Banner 2' ),
						'base'        => 'interactive_banner_2',
						'class'       => 'vc_interactive_icon',
						'icon'        => 'vc_icon_interactive',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Displays the banner image with Information' ),
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
								'type'        => 'attach_image',
								'class'       => '',
								'heading'     => $vc->l( 'Banner Image' ),
								'param_name'  => 'banner_image',
								'value'       => '',
								'description' => $vc->l( 'Upload the image for this banner' ),
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => $vc->l( 'Link ' ),
								'param_name'  => 'banner_link',
								'value'       => '',
								'description' => $vc->l( 'Add link / select existing page to link to this banner' ),
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
								'type'        => 'ult_select2',
								'class'       => '',
								'heading'     => $vc->l( 'Styles ' ),
								'param_name'  => 'banner_style',
								'value'       => '',
								'json'        => '',
								'description' => '',
							),
							/*
							array(
								 "type" => "dropdown",
								 "class" => "",
								 "heading" => $vc->l("Banner Styles"),
								 "param_name" => "banner_style",
								 "value" => array(
									 $vc->l("Style 1") => "style1",
									 $vc->l("Style 2") => "style2",
									 $vc->l("Style 3") => "style3",
									 $vc->l("Style 4") => "style4",
									 $vc->l("Style 5") => "style5",
									 $vc->l("Style 6") => "style6",
									 $vc->l("Style 7") => "style7",
									 $vc->l("Style 8") => "style8",
									 $vc->l("Style 9") => "style9",
									 $vc->l("Style 10") => "style10",
									 $vc->l("Style 11") => "style11",
									 $vc->l("Style 12") => "style12",
									 $vc->l("Style 13") => "style13",
									 $vc->l("Style 14") => "style14",
									 $vc->l("Style 15") => "style15",
									 ),
								 "description" => $vc->l("Select animation effect style for this block.")
							 ),*/
							 array(
								 'type'        => 'colorpicker',
								 'class'       => '',
								 'heading'     => $vc->l( 'Title Background Color' ),
								 'param_name'  => 'banner_title_bg',
								 'value'       => '',
								 'description' => '',
								 'dependency'  => array(
									 'element' => 'banner_style',
									 'value'   => array( 'style5' ),
								 ),
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
								'type'       => 'text',
								'heading'    => $vc->l( '<h2>Title Settings</h2>' ),
								'param_name' => 'banner_title_typograpy',
								'dependency' => array(
									'element'   => 'banner_title',
									'not_empty' => true,
								),
								'group'      => 'Typography',
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
								'dependency' => array(
									'element'   => 'banner_title',
									'not_empty' => true,
								),
								'group'      => 'Typography',
							),
							array(
								'type'       => 'text',
								'heading'    => $vc->l( '<h2>Description Settings</h2>' ),
								'param_name' => 'banner_desc_typograpy',
								'group'      => 'Typography',
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
								'dependency' => array(
									'element'   => 'banner_desc',
									'not_empty' => true,
								),
								'group'      => 'Typography',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Title Color' ),
								'param_name'  => 'banner_color_title',
								'value'       => '',
								'description' => '',
								'group'       => 'Color Settings',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Description Color' ),
								'param_name'  => 'banner_color_desc',
								'value'       => '',
								'description' => '',
								'group'       => 'Color Settings',
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Background Color' ),
								'param_name'  => 'banner_color_bg',
								'value'       => '',
								'description' => '',
								'group'       => 'Color Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Image Opacity' ),
								'param_name'  => 'image_opacity',
								'value'       => 1,
								'min'         => 0.0,
								'max'         => 1.0,
								'step'        => 0.1,
								'suffix'      => '',
								'description' => $vc->l( 'Enter value between 0.0 to 1 (0 is maximum transparency, while 1 is lowest)' ),
								'group'       => 'Color Settings',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Image Opacity on Hover' ),
								'param_name'  => 'image_opacity_on_hover',
								'value'       => 1,
								'min'         => 0.0,
								'max'         => 1.0,
								'step'        => 0.1,
								'suffix'      => '',
								'description' => $vc->l( 'Enter value between 0.0 to 1 (0 is maximum transparency, while 1 is lowest)' ),
								'group'       => 'Color Settings',
							),
							array(
								'type'        => 'checkbox',
								'class'       => '',
								'heading'     => $vc->l( 'Responsive Nature' ),
								'param_name'  => 'enable_responsive',
								'value'       => array( 'Enable Responsive Behaviour' => 'yes' ),
								'description' => $vc->l( 'If the description text is not suiting well on specific screen sizes, you may enable this option - which will hide the description text.' ),
								'group'       => 'Responsive',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Minimum Screen Size' ),
								'param_name'  => 'responsive_min',
								'value'       => 768,
								'min'         => 100,
								'max'         => 1000,
								'suffix'      => 'px',
								'dependency'  => array(
									'element' => 'enable_responsive',
									'value'   => 'yes',
								),
								'description' => $vc->l( 'Provide the range of screen size where you would like to hide the description text.' ),
								'group'       => 'Responsive',
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Maximum Screen Size' ),
								'param_name'  => 'responsive_max',
								'value'       => 900,
								'min'         => 100,
								'max'         => 1000,
								'suffix'      => 'px',
								'dependency'  => array(
									'element' => 'enable_responsive',
									'value'   => 'yes',
								),
								'description' => $vc->l( 'Provide the range of screen size where you would like to hide the description text.' ),
								'group'       => 'Responsive',
							),
							array(
								'type'             => 'heading',
								'sub_heading'      => "<span style='display: block;'><a href='http://bsf.io/n8o33' target='_blank'>Watch Video Tutorial &nbsp; <span class='icon icon-youtube-play' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
								'param_name'       => 'notification',
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							),
						),
					)
				);
			}
		}
		// Shortcode handler function for stats banner
		function banner_shortcode( $atts ) {
						Context::getContext()->controller->addCSS( jscomposer::plugins_url( 'assets/min-css/ib2-style.min.css' ) );
						Context::getContext()->controller->addJS( jscomposer::plugins_url( 'assets/min-js/custom.min.js' ) );

			$banner_title              = $banner_desc = $banner_image = $banner_link = $banner_style = $el_class = '';
			$banner_title_font_family  = $banner_title_style = $banner_title_font_size = $banner_desc_font_family = $banner_desc_style = $banner_desc_font_size = '';
			$banner_title_style_inline = $banner_desc_style_inline = $banner_color_bg = $banner_color_title = $banner_color_desc = $banner_title_bg = '';
			$image_opacity             = $image_opacity_on_hover = $enable_responsive = $responsive_min = $responsive_max = '';
			extract(
				JsComposer::shortcode_atts(
					array(
						'banner_title'             => '',
						'banner_desc'              => '',
						'banner_title_location'    => '',
						'banner_image'             => '',
						'image_opacity'            => '',
						'image_opacity_on_hover'   => '',
						'banner_height'            => '',
						'banner_height_val'        => '',
						'banner_link'              => '',
						/*'banner_link_text' => '',*/
						'banner_style'             => '',
						'banner_title_font_family' => '',
						'banner_title_style'       => '',
						'banner_title_font_size'   => '',
						'banner_desc_font_family'  => '',
						'banner_desc_style'        => '',
						'banner_desc_font_size'    => '',
						'banner_color_bg'          => '',
						'banner_color_title'       => '',
						'banner_color_desc'        => '',
						'banner_title_bg'          => '',
						'enable_responsive'        => '',
						'responsive_min'           => '',
						'responsive_max'           => '',
						'el_class'                 => '',
					),
					$atts
				)
			);
			$output = $style = $target = $link = $banner_style_inline = $title_bg = $img_style = $responsive = $target = '';
			// $banner_style = 'style01';

			if ( $enable_responsive == 'yes' ) {
				$responsive .= 'data-min-width="' . $responsive_min . '" data-max-width="' . $responsive_max . '"';
				$el_class   .= 'ult-ib-resp';
			}

			if ( $banner_title_bg !== '' && $banner_style == 'style5' ) {
				$title_bg .= 'background:' . $banner_title_bg . ';';
			}
			// $img = wp_get_attachment_image_src( $banner_image, 'full');
			$img = JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url( $banner_image );

			if ( $banner_link !== '' ) {
				$href   = vc_build_link( $banner_link );
				$link   = $href['url'];
				$target = ( isset( $href['target'] ) ) ? $href['target'] : '';
			} else {
				$link = '#';
			}

			if ( $banner_title_font_family != '' ) {
				$bfamily = get_ultimate_font_family( $banner_title_font_family );
				if ( $bfamily != '' ) {
					$banner_title_style_inline = 'font-family:\'' . $bfamily . '\';';
				}
			}
			$banner_title_style_inline .= get_ultimate_font_style( $banner_title_style );
			if ( $banner_title_font_size != '' ) {
				$banner_title_style_inline .= 'font-size:' . $banner_title_font_size . 'px;';
			}

			if ( $banner_desc_font_family != '' ) {
				$bdfamily = get_ultimate_font_family( $banner_desc_font_family );
				if ( $bdfamily != '' ) {
					$banner_desc_style_inline = 'font-family:\'' . $bdfamily . '\';';
				}
			}
			$banner_desc_style .= get_ultimate_font_style( $banner_desc_style );
			if ( $banner_desc_font_size != '' ) {
				$banner_desc_style_inline .= 'font-size:' . $banner_desc_font_size . 'px;';
			}

			if ( $banner_color_bg != '' ) {
				$banner_style_inline .= 'background:' . $banner_color_bg . ';';
			}

			if ( $banner_color_title != '' ) {
				$banner_title_style_inline .= 'color:' . $banner_color_title . ';';
			}

			if ( $banner_color_desc != '' ) {
				$banner_desc_style_inline .= 'color:' . $banner_color_desc . ';';
			}

			// enqueue google font
			$args = array(
				$banner_title_font_family,
				$banner_desc_font_family,
			);
			enquque_ultimate_google_fonts( $args );

			if ( $image_opacity !== '' ) {
				$img_style .= 'opacity:' . $image_opacity . ';';
			}

			if ( $link !== '#' ) {
				$href = 'href="' . $link . '"';
			} else {
				$href = '';
			}

			$output .= '<div class="ult-new-ib ult-ib-effect-' . $banner_style . ' ' . $el_class . '" ' . $responsive . ' style="' . $banner_style_inline . '" data-opacity="' . $image_opacity . '" data-hover-opacity="' . $image_opacity_on_hover . '">';

			$output .= '<img class="ult-new-ib-img" style="' . $img_style . '" alt="' . $banner_title . '" src="' . $img . '"/>';

			$output .= '<div class="ult-new-ib-desc" style="' . $title_bg . '">';
			$output .= '<h2 class="ult-new-ib-title" style="' . $banner_title_style_inline . '">' . $banner_title . '</h2>';
			$output .= '<p class="ult-new-ib-content" style="' . $banner_desc_style_inline . '">' . $banner_desc . '</p>';
			$output .= '</div>';
			if ( $target != '' ) {
				$target = 'target="' . $target . '"';
			}
			$output .= '<a class="ult-new-ib-link" ' . $href . ' ' . $target . '></a>';
			$output .= '</div>';

			return $output;
		}
	}
}
// if(class_exists('Ultimate_Interactive_Banner'))
// {
// $Ultimate_Interactive_Banner = new Ultimate_Interactive_Banner;
// }
