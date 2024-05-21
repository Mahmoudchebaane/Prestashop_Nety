<?php

/*
 * Add-on Name: Flip Box for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if ( ! class_exists( 'AIO_Flip_Box' ) ) {

	class AIO_Flip_Box {


		public $vcaddonsinstance, $context;

		function __construct() {
			$this->context          = Context::getContext();
			$this->vcaddonsinstance = jscomposer::getInstance();
			// add_action('admin_init',array($this,'block_init'));
			JsComposer::add_shortcode( 'icon_counter', array( &$this, 'block_shortcode' ) );

		}

		function flip_box_scripts() {

			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/flip_box.min.js" );
			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/custom.min.js" );
		}

		function flip_box_styles() {
			// jscomposer::$front_styles[] = "{$this->vcaddonsinstance->_url_ultimate}assets/css/flip-box.css";
			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/flip-box.min.css" );
		}

		function block_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Flip Box' ),
						'base'        => 'icon_counter',
						'class'       => 'vc_flip_box',
						'icon'        => 'vc_icon_block',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Icon, some info &amp; CTA. Flips on hover.' ),
						'params'      => array(
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
								'heading'     => $vc->l( 'Flip Box Style' ),
								'param_name'  => 'flip_box_style',
								'value'       => array(
									'Simple'   => 'simple',
									'Advanced' => 'advanced',
								),
								'description' => $vc->l( 'Select the border style for icon.' ),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Size of Box Border' ),
								'param_name'  => 'border_size',
								'value'       => 2,
								'min'         => 1,
								'max'         => 10,
								'suffix'      => 'px',
								'description' => $vc->l( 'Enter value in pixels.' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'simple' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Border Color' ),
								'param_name'  => 'border_color',
								'value'       => '#A4A4A4',
								'description' => $vc->l( 'Select the color for border on front.' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'simple' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Box Border Style' ),
								'param_name'  => 'box_border_style',
								'value'       => array(
									'None'   => 'none',
									'Solid'  => 'solid',
									'Dashed' => 'dashed',
									'Dotted' => 'dotted',
									'Double' => 'double',
									'Inset'  => 'inset',
									'Outset' => 'outset',
								),
								'description' => $vc->l( 'Select the border style for box.' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'advanced' ),
								),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Size of Box Border' ),
								'param_name'  => 'box_border_size',
								'value'       => 2,
								'min'         => 1,
								'max'         => 10,
								'suffix'      => 'px',
								'description' => $vc->l( 'Enter value in pixels.' ),
								'dependency'  => array(
									'element' => 'box_border_style',
									'value'   => array( 'solid', 'dashed', 'dotted', 'double', 'inset', 'outset' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Front Side Border Color' ),
								'param_name'  => 'box_border_color',
								'value'       => '#A4A4A4',
								'description' => $vc->l( 'Select the color for border on front.' ),
								'dependency'  => array(
									'element' => 'box_border_style',
									'value'   => array( 'solid', 'dashed', 'dotted', 'double', 'inset', 'outset' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Back Side Border Color' ),
								'param_name'  => 'box_border_color_back',
								'value'       => '#A4A4A4',
								'description' => $vc->l( 'Select the color for border on back.' ),
								'dependency'  => array(
									'element' => 'box_border_style',
									'value'   => array( 'solid', 'dashed', 'dotted', 'double', 'inset', 'outset' ),
								),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Title on Front' ),
								'param_name'  => 'block_title_front',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( 'Perhaps, this is the most highlighted text.' ),
							),
							array(
								'type'        => 'textarea',
								'class'       => '',
								'heading'     => $vc->l( 'Description on Front ' ),
								'param_name'  => 'block_desc_front',
								'value'       => '',
								'description' => $vc->l( 'Keep it short and simple!' ),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Text Color' ),
								'param_name'  => 'text_color',
								'value'       => '#333333',
								'description' => $vc->l( 'Color of title & description text.' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'simple' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Background Color' ),
								'param_name'  => 'bg_color',
								'value'       => '#efefef',
								'description' => $vc->l( 'Light colors look better for background.' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'simple' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Front Side Text Color' ),
								'param_name'  => 'block_text_color',
								'value'       => '#333333',
								'description' => $vc->l( 'Color of front side title & description text.' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'advanced' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Front Side Background Color' ),
								'param_name'  => 'block_front_color',
								'value'       => '#efefef',
								'description' => $vc->l( 'Light colors look better on front.' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'advanced' ),
								),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Title on Back ' ),
								'param_name'  => 'block_title_back',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( 'Some nice heading for the back side of the flip.' ),
							),
							array(
								'type'        => 'textarea',
								'class'       => '',
								'heading'     => $vc->l( 'Description on Back' ),
								'param_name'  => 'block_desc_back',
								'value'       => '',
								'description' => $vc->l( 'Text here will be followed by a button. So make it catchy!' ),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Back Side Text Color' ),
								'param_name'  => 'block_back_text_color',
								'value'       => '#333333',
								'description' => $vc->l( 'Color of back side title & description text.' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'advanced' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Back Side Background Color' ),
								'param_name'  => 'block_back_color',
								'value'       => '#efefef',
								'description' => $vc->l( 'Select the background color for back .' ),
								'dependency'  => array(
									'element' => 'flip_box_style',
									'value'   => array( 'advanced' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Link' ),
								'param_name'  => 'custom_link',
								'value'       => array(
									'No Link' => '',
									'Add custom link with button' => '1',
								),
								'description' => $vc->l( 'You can add / remove custom link' ),
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => $vc->l( 'Link ' ),
								'param_name'  => 'button_link',
								'value'       => '',
								'description' => $vc->l( 'You can link or remove the existing link on the button from here.' ),
								'dependency'  => array(
									'element'   => 'custom_link',
									'not_empty' => true,
									'value'     => array( '1' ),
								),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Button Text' ),
								'param_name'  => 'button_text',
								'value'       => '',
								'description' => $vc->l( 'The call to action text' ),
								'dependency'  => array(
									'element'   => 'custom_link',
									'not_empty' => true,
									'value'     => array( '1' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Button background color' ),
								'param_name'  => 'button_bg',
								'value'       => '#333333',
								'dependency'  => array(
									'element'   => 'custom_link',
									'not_empty' => true,
									'value'     => array( '1' ),
								),
							),
							array(
								'type'        => 'colorpicker',
								'class'       => '',
								'heading'     => $vc->l( 'Button Text Color' ),
								'param_name'  => 'button_txt',
								'value'       => '#FFFFFF',
								'description' => $vc->l( 'Select the color for button text.' ),
								'dependency'  => array(
									'element'   => 'custom_link',
									'not_empty' => true,
									'value'     => array( '1' ),
								),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Flip Type ' ),
								'param_name'  => 'flip_type',
								'value'       => array(
									'Flip Horizontally From Left' => 'horizontal_flip_left',
									'Flip Horizontally From Right' => 'horizontal_flip_right',
									'Flip Vertically From Top' => 'vertical_flip_top',
									'Flip Vertically From Bottom' => 'vertical_flip_bottom',
									'Vertical Door Flip'   => 'vertical_door_flip',
									'Reverse Vertical Door Flip' => 'reverse_vertical_door_flip',
									'Horizontal Door Flip' => 'horizontal_door_flip',
									'Reverse Horizontal Door Flip' => 'reverse_horizontal_door_flip',
									'Book Flip (Beta)'     => 'style_9',
									'Flip From Left (Beta)' => 'flip_left',
									'Flip From Right (Beta)' => 'flip_right',
									'Flip From Top (Beta)' => 'flip_top',
									'Flip From Bottom (Beta)' => 'flip_bottom',
								),
								'description' => $vc->l( 'Select Flip type for this flip box.' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Set Box Height' ),
								'param_name'  => 'height_type',
								'value'       => array(
									'Display full the content and adjust height of the box accordingly' => 'ifb-jq-height',
									"Hide extra content that doesn't fit in height of the box" => 'ifb-auto-height',
									'Give a custom height of your choice to the box' => 'ifb-custom-height',
								),
								'description' => $vc->l( 'Select height option for this box.' ),
							),
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( 'Box Height' ),
								'param_name'  => 'box_height',
								'value'       => 300,
								'min'         => 200,
								'max'         => 1200,
								'suffix'      => 'px',
								'description' => $vc->l( 'Provide box height' ),
								'dependency'  => array(
									'element' => 'height_type',
									'value'   => array( 'ifb-custom-height' ),
								),
							),
							array(
								'type'        => 'ult_switch',
								'class'       => '',
								'param_name'  => 'cont_align',
								'value'       => 'off',
								'default_set' => true,
								'options'     => array(
									'on' => array(
										'label' => $vc->l( 'Display Content Vertically Center ?' ),
										'on'    => $vc->l( 'Yes' ),
										'off'   => $vc->l( 'No' ),
									),
								),
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Extra Class' ),
								'param_name'  => 'el_class',
								'value'       => '',
							),
							array(
								'type'       => 'text',
								'param_name' => 'title_text_typography',
								'heading'    => $vc->l( '<h2>Title settings</h2>' ),
								'value'      => '',
								'group'      => 'Typography',
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
								'type'       => 'text',
								'param_name' => 'desc_text_typography',
								'heading'    => $vc->l( '<h2>Description settings</h2>' ),
								'value'      => '',
								'group'      => 'Typography',
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
								'type'             => 'heading',
								'param_name'       => 'notification',
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							),
						),
					)
				);
			}
		}

		// Shortcode handler function for  icon block
		function block_shortcode( $atts ) {

			$icon_type             = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $block_title_front = $block_desc_front = $block_title_back = $block_desc_back = $button_text = $button_link = $block_text_color = $block_front_color = $block_back_color = $block_back_text_color = $animation = $font_size_icon = $box_border_style = $box_border_size = $box_border_color = $border_size = $border_color = $box_border_color_back = $custom_link = $button_bg = $button_txt = $height_type = $box_height = $flip_type = $flip_box_style = $text_color = $bg_color = $front_text = $back_text = '';
			$desc_font_line_height = $title_font_line_height = $title_font = $title_font_style = $title_font_size = $desc_font = $desc_font_style = $desc_font_size = '';
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
						'icon_link'              => '',
						'icon_animation'         => '',
						'block_title_front'      => '',
						'block_desc_front'       => '',
						'block_title_back'       => '',
						'block_desc_back'        => '',
						'custom_link'            => '',
						'button_text'            => '',
						'button_link'            => '',
						'button_bg'              => '',
						'button_txt'             => '',
						'flip_type'              => '',
						'text_color'             => '',
						'bg_color'               => '',
						'block_text_color'       => '',
						'block_front_color'      => '',
						'block_back_color'       => '',
						'el_class'               => '',
						'block_back_text_color'  => '',
						'border_size'            => '',
						'border_color'           => '',
						'box_border_style'       => '',
						'box_border_size'        => '',
						'box_border_color'       => '',
						'box_border_color_back'  => '',
						'height_type'            => '',
						'box_height'             => '',
						'flip_box_style'         => '',
						'title_font'             => '',
						'title_font_style'       => '',
						'title_font_size'        => '',
						'title_font_line_height' => '',
						'desc_font'              => '',
						'desc_font_style'        => '',
						'desc_font_size'         => '',
						'desc_font_line_height'  => '',
						'cont_align'             => '',
					),
					$atts
				)
			);
			// load stylesheet and js files
			$this->flip_box_scripts();
			$this->flip_box_styles();

			$output      = $f_style = $b_style = $ico_color = $box_border = $icon_border = $link_style = $height = $link_sufix = $link_prefix = $link_style = '';
			$title_style = $desc_style = '';
			$font_args   = array();
			if ( $icon_type == 'custom' ) {
				$icon_style = 'none';
			}
			$flip_icon = JsComposer::do_shortcode( '[just_icon icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_link="' . $icon_link . '" icon_animation="' . $icon_animation . '"]' );
			$css_trans = $icon_border = $box_border = '';
			$height    = $target = '';

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
			enquque_ultimate_google_fonts( $font_args );

			if ( $icon_border_style !== 'none' ) {
					$icon_border .= 'border-style: ' . $icon_border_style . ';';
					$icon_border .= 'border-width: ' . $icon_border_size . 'px;';
			}
			$box_style_data = '';
			if ( $height_type == 'ifb-custom-height' ) {
					$box_style_data .= " data-min-height='" . $box_height . "px'";
					/*$height = 'height:'.$box_height.'px;';*/
					$flip_type .= ' flip-box-custom-height';
			}
			if ( $flip_box_style !== 'simple' ) {
					$border_front = 'border-color:' . $box_border_color . ';';
					$border_back  = 'border-color:' . $box_border_color_back . ';';
				if ( $box_border_style !== 'none' ) {
						$box_border .= 'border-style: ' . $box_border_style . ';';
						$box_border .= 'border-width: ' . $box_border_size . 'px;';
				}
				if ( $animation !== 'none' ) {
						$css_trans = 'data-animation="' . $animation . '" data-animation-delay="03"';
				}
				if ( $block_text_color != '' ) {
						$f_style    .= 'color:' . $block_text_color . ';';
						$front_text .= 'color:' . $block_text_color . ';';
				}
				if ( $block_front_color != '' ) {
						$f_style .= 'background:' . $block_front_color . ';';
				}
				if ( $block_back_text_color != '' ) {
						$b_style   .= 'color:' . $block_back_text_color . ';';
						$back_text .= 'color:' . $block_back_text_color . ';';
				}
				if ( $block_back_color != '' ) {
						$b_style .= 'background:' . $block_back_color . ';';
				}
			} else {
				if ( $text_color != '' ) {
						$f_style   .= 'color:' . $text_color . ';';
						$b_style   .= 'color:' . $text_color . ';';
						$front_text = $back_text = 'color:' . $text_color . ';';
				}
				if ( $bg_color != '' ) {
						$f_style .= 'background:' . $bg_color . ';';
						$b_style .= 'background:' . $bg_color . ';';
				}
				if ( $border_color != '' ) {
						$border_front = 'border-color:' . $border_color . ';';
						$border_back  = 'border-color:' . $border_color . ';';
						$box_border   = 'border-width: ' . $border_size . 'px;';
						$box_border  .= 'border-style: solid;';
				}
			}

			if ( $cont_align == '' ) {
					$cont_align = 'off';
			}
			$verticalcont = '';
			if ( $cont_align == 'on' ) {
					$verticalcont .= 'ifb-flip-box-section-vertical-middle';
			}
			$output .= '<div class="flip-box-wrap">';
			$output .= '<div class="flip-box ' . $height_type . ' ' . $el_class . ' ' . $flip_type . '" ' . $css_trans . ' style="' . $height . '" ' . $box_style_data . '>';
			$output .= '<div class="ifb-flip-box">';
			$output .= '<div class="ifb-face ifb-front" style="' . $f_style . ' ' . $box_border . ' ' . $border_front . '">
							<div class="ifb-flip-box-section ' . $verticalcont . '">
							';
			if ( $icon !== '' || $icon_img !== '' ) {
				$output .= '<div class="flip-box-icon">' . $flip_icon . '</div>';
			}
			if ( $block_title_front != '' ) {
				$output .= '<h3 style="' . $front_text . ' ' . $title_style . '">' . $block_title_front . '</h3>';
			}
			if ( $block_desc_front != '' ) {
				$output .= '<p style="' . $desc_style . '">' . $block_desc_front . '</p>';
			}
			$output .= '</div></div><!-- END .front -->
						<div class="ifb-face ifb-back" style="' . $b_style . ' ' . $box_border . ' ' . $border_back . '">
							<div class="ifb-flip-box-section ' . $verticalcont . '">';
			if ( $block_title_back != '' ) {
				$output .= '<h3 style="' . $back_text . ' ' . $title_style . '">' . $block_title_back . '</h3>';
			}
			if ( $block_desc_back != '' ) {
				if ( $button_link !== '' ) {
					$output .= '<div class="ifb-desc-back">';
				}
				$output .= '<p style="' . $desc_style . '" >' . $block_desc_back . '</p>';
				if ( $button_link !== '' ) {
					$output .= '</div>';
				}
			}
			if ( $button_text !== '' && $custom_link ) {
				$link_prefix = '<div class="flip_link">';
				if ( $button_bg !== '' && $button_txt !== '' ) {
					$link_style = 'style="background:' . $button_bg . '; color:' . $button_txt . ';"';
				}
				if ( $button_link !== '' ) {
					$href = vc_build_link( $button_link );
					if ( isset( $href['target'] ) && $href['target'] != '' ) {
							$target = 'target="' . $href['target'] . '"';
					}
					$link_prefix .= '<a href = "' . $href['url'] . '" ' . $target . ' ' . $link_style . '>';
					$link_sufix  .= '</a>';
				}
				$link_sufix .= '</div>';
				$output     .= $link_prefix . $button_text . $link_sufix;
			}
			$output .= '</div></div><!-- END .back -->';
			$output .= '</div> <!-- ifb-flip-box -->';
			$output .= '</div> <!-- flip-box -->';
			$output .= '</div><!-- End icon block -->';
			return $output;
		}

	}

	// instantiate the class
	// new AIO_Flip_Box;
}
