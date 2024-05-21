<?php
/*
* Module - Buttons
*/
if(!class_exists("Ultimate_Buttons")){
	class Ultimate_Buttons{
                public $vcaddonsinstance, $context;
		 function __construct(){
//		 	add_action( 'admin_init', array($this, 'init_buttons') );
		 	JsComposer::add_shortcode( 'ult_buttons',array($this,'ult_buttons_shortcode'));
//		 	add_action( 'admin_enqueue_scripts', array( $this, 'button_admin_scripts') );
                     $this->vcaddonsinstance = jscomposer::getInstance();
                     $this->context = Context::getContext();
                     if($this->vcaddonsinstance->is_admin()){
                            $this->button_admin_scripts();
                     }
		 }

		
		function button_admin_scripts(){
//			if($hook == "post.php" || $hook == "post-new.php"){
//				wp_enqueue_style( 'ult-button', plugins_url('../assets/css/btn-min.css', __FILE__) );
				jscomposer::$backoffice_styles[] = $this->vcaddonsinstance->_url_ultimate.'assets/css/btn-min.css';
//			}
		}
		function ult_buttons_shortcode($atts){
			
			$output = $btn_title = $btn_link = $btn_size = $btn_width = $btn_height = $btn_hover = $btn_bg_color = $btn_radius = $btn_shadow = '';
			$btn_shadow_color = $btn_bg_color_hover = $btn_border_style = $btn_color_border = $btn_border_size = $btn_shadow_size = $el_class = '';
			$btn_font_family = $btn_font_style = $btn_title_color = $btn_font_size = $icon = $icon_size = $icon_color = $btn_icon_pos = $btn_anim_effect = '';
			$btn_padding_left = $btn_padding_top = $button_bg_img = $btn_title_color_hover = $btn_align = $btn_color_border_hover = $btn_shadow_color_hover = '';
			$btn_shadow_click = $enable_tooltip = $tooltip_text = $tooltip_pos = '';
			extract(JsComposer::shortcode_atts(array(
				'btn_title' => '',
				'btn_link' => '',
				'btn_size' => '',
				'btn_width' => '',
				'btn_height' => '',
				'btn_padding_left' => '',
				'btn_padding_top' => '',
				'btn_hover' => '',
				'btn_bg_color' => '',
				'btn_radius' => '',
				'btn_shadow' => '',
				'btn_shadow_color' => '',
				'btn_shadow_size' => '',
				'btn_bg_color_hover' => '',
				'btn_title_color_hover' => '',
				'btn_border_style' => '',
				'btn_color_border' => '',
				'btn_color_border_hover' => '',
				'btn_border_size' => '',
				'btn_font_family' => '',
				'btn_font_style' => '',
				'btn_title_color' => '',
				'btn_font_size' => '',
				'icon' => '',
				'icon_size' => '',
				'icon_color' => '',
				'btn_icon_pos' => '',
				'btn_anim_effect' => '',
				'button_bg_img' => '',
				'btn_align' => '',
				'btn_shadow_color_hover' => '',
				'btn_shadow_click' => '',
				'enable_tooltip' => '',
				'tooltip_text' => '',
				'tooltip_pos' => '',
				'el_class' => '',
			),$atts));
			
			$style = $hover_style = $btn_style_inline = $link_sufix = $link_prefix = $img = $shadow_hover = $shadow_click = $shadow_color = $box_shadow = '';
			$tooltip = $tooltip_class = '';
			$el_class .= ' '.$btn_anim_effect.' ';
			$uniqid = uniqid();
			$tooltip_class = 'tooltip-'.$uniqid;
                        
			$this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/ultimate.min.css");
                        $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/custom.min.js");
                        
			if($enable_tooltip == "yes"){
//				wp_enqueue_script('aio-tooltip',plugins_url('../assets/min-js/',__FILE__).'tooltip.min.js',array('jquery'));
//				wp_enqueue_style('aio-tooltip',plugins_url('../assets/min-css/',__FILE__).'tooltip.min.css');
                                
                                $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/tooltip.min.css");
                                $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/tooltip.min.js");
                                
				$tooltip .= 'data-toggle="tooltip" data-placement="'.$tooltip_pos.'" title="'.$tooltip_text.'"';
				$tooltip_class .= " ubtn-tooltip ".$tooltip_pos;
			}
			
			if($btn_shadow_click !== "enable"){
				$shadow_click = 'none';
			}
			if($btn_shadow_color_hover == "")
				$shadow_color = $btn_shadow_color;
			else
				$shadow_color = $btn_shadow_color_hover;
			
			if($button_bg_img !== ''){
//				$img = wp_get_attachment_image_src( $button_bg_img, 'large');
				$img = JsComposer::$_url.'uploads/'.JsComposer::get_media_thumbnail_url( $button_bg_img );
			}
			if($btn_link !== ''){
				$href = vc_build_link($btn_link);
				if($href['url'] !== ""){
					$target = (isset($href['target'])) ? "target='".$href['target']."'" : '';
					if($btn_size == "ubtn-block"){
						$tooltip_class .= ' ubtn-block';
					}
					$link_prefix .= '<a class="ubtn-link '.$btn_align.' '.$tooltip_class.'" '.$tooltip.' href = "'.$href['url'].'" '.$target.'>';
					$link_sufix .= '</a>';
				}
			} else {
				if($enable_tooltip !== ""){
					$link_prefix .= '<span class="'.$btn_align.' '.$tooltip_class.'" '.$tooltip.'>';
					$link_sufix .= '</span>';
				}
			}
			if($btn_icon_pos !== '' && $icon !== 'none' && $icon !== '')
				$el_class .= ' ubtn-sep-icon '.$btn_icon_pos.' ';
			
			if($btn_font_family != '')
			{
				$mhfont_family = get_ultimate_font_family($btn_font_family);
				$btn_style_inline .= 'font-family:\''.$mhfont_family.'\';';
				
				//enqueue google font
				$args = array(
					$mhfont_family
				);
				enquque_ultimate_google_fonts($args);
			}
			$btn_style_inline .= get_ultimate_font_style($btn_font_style);
			if($btn_font_size !== ''){
				$btn_style_inline .= 'font-size:'.$btn_font_size.'px;';
			}
			$style .= $btn_style_inline;
			if($btn_size == 'ubtn-custom'){
				$style .= 'width:'.$btn_width.'px;';
				$style .= 'min-height:'.$btn_height.'px;';
				$style .= 'padding:'.$btn_padding_top.'px '.$btn_padding_left.'px;';
			}
			if($btn_border_style !== ''){
				$style .= 'border-radius:'.$btn_radius.'px;';
				$style .= 'border-width:'.$btn_border_size.'px;';
				$style .= 'border-color:'.$btn_color_border.';';
				$style .= 'border-style:'.$btn_border_style.';';
			} else {
				$style .= 'border:none;';
			}
			if($btn_shadow !== ''){
				switch($btn_shadow){
					case 'shd-top':
						$style .= 'box-shadow: 0 -'.$btn_shadow_size.'px '.$btn_shadow_color.';';
						// $style .= 'bottom: '.($btn_shadow_size-3).'px;';
						$box_shadow .= '0 -'.$btn_shadow_size.'px '.$btn_shadow_color.';';
						if($shadow_click !== "none")
							$shadow_hover .= '0 -3px '.$shadow_color.';';
						else
							$shadow_hover .= '0 -'.$btn_shadow_size.'px '.$shadow_color.';';
						break;
					case 'shd-bottom':
						$style .= 'box-shadow: 0 '.$btn_shadow_size.'px '.$btn_shadow_color.';';
						// $style .= 'top: '.($btn_shadow_size-3).'px;';
						$box_shadow .= '0 '.$btn_shadow_size.'px '.$btn_shadow_color.';';
						if($shadow_click !== "none")
							$shadow_hover .= '0 3px '.$shadow_color.';';	
						else
							$shadow_hover .= '0 '.$btn_shadow_size.'px '.$shadow_color.';';
						break;
					case 'shd-left':
						$style .= 'box-shadow: -'.$btn_shadow_size.'px 0 '.$btn_shadow_color.';';
						// $style .= 'right: '.($btn_shadow_size-3).'px;';
						$box_shadow .= '-'.$btn_shadow_size.'px 0 '.$btn_shadow_color.';';
						if($shadow_click !== "none")
							$shadow_hover .= '-3px 0 '.$shadow_color.';';
						else
							$shadow_hover .= '-'.$btn_shadow_size.'px 0 '.$shadow_color.';';	
						break;
					case 'shd-right':
						$style .= 'box-shadow: '.$btn_shadow_size.'px 0 '.$btn_shadow_color.';';
						// $style .= 'left: '.($btn_shadow_size-3).'px;';
						$box_shadow .= $btn_shadow_size.'px 0 '.$btn_shadow_color.';';
						if($shadow_click !== "none")
							$shadow_hover .= '3px 0 '.$shadow_color.';';
						else
							$shadow_hover .= $btn_shadow_size.'px 0 '.$shadow_color.';';
						break;
				}
			}
			if($btn_bg_color !== ''){
				$style .= 'background: '.$btn_bg_color.';';
			}
			if($btn_title_color !== ''){
				$style .= 'color: '.$btn_title_color.';';
			}
			
			if($btn_shadow){
				$el_class .= ' ubtn-shd ';
			}
			if($btn_align){
				$el_class .= ' '.$btn_align.' ';
			}
			if($btn_title == "" && $icon !== ""){
				$el_class .= ' ubtn-only-icon ';
			}
			$output .= '<button type="button" class="ubtn '.$btn_size.' '.$btn_hover.' '.$el_class.' '.$btn_shadow.'" data-hover="'.$btn_title_color_hover.'" data-border-color="'.$btn_color_border.'" data-hover-bg="'.$btn_bg_color_hover.'" data-border-hover="'.$btn_color_border_hover.'" data-shadow-hover="'.$shadow_hover.'" data-shadow-click="'.$shadow_click.'" data-shadow="'.$box_shadow.'" data-shd-shadow="'.$btn_shadow_size.'" style="'.$style.'">';
			if($icon !== ''){
				$output .= '<span class="ubtn-data ubtn-icon"><i class="'.$icon.'" style="font-size:'.$icon_size.'px;color:'.$icon_color.';"></i></span>';
			}
			$output .= '<span class="ubtn-hover"></span>';
			$output .= '<span class="ubtn-data ubtn-text">'.$btn_title.'</span>';
			$output .= '</button>';
			
			$output = $link_prefix.$output.$link_sufix;
			
			if($btn_align == "ubtn-center"){
				$output = '<div class="ubtn-ctn-center">'.$output.'</div>';
			}
			if($img !== ''){
				$html = '<div class="ubtn-img-container">';
				$html .= '<img src="'.$img.'"/>';
				$html .= $output;
				$html .= '</div>';
				$output = $html;
			}
			
			if($enable_tooltip !== ""){
				$output .= '<script>
					jQuery(function () {
						jQuery(".tooltip-'.$uniqid.'").bsf_tooltip();
					})
				</script>';
			}
			return $output;
		}
		function init_buttons(){
			$vc = vc_manager();
			if(function_exists("vc_map"))
			{
				$json = ultimate_get_icon_position_json();
				vc_map(
					array(
						"name" => $vc->l("Advanced Button", "js_composer"),
						"base" => "ult_buttons",
						"icon" => "ult_buttons",
						"class" => "ult_buttons",
						"content_element" => true,
						"controls" => "full",
						"category" => "Ultimate VC Addons",
						"description" => "Create creative buttons.",
						"params" => array(
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => $vc->l("Button Title"),
								"param_name" => "btn_title",
								"value" => "",
								"description" => "",
								"group" => "General",
								"admin_label" => true
						  	),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => $vc->l("Button Link"),
								"param_name" => "btn_link",
								"value" => "",
								"description" => "",
								"group" => "General"
						  	),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Button Alignment"),
								"param_name" => "btn_align",
								"value" => array(
										"Left Align" => "ubtn-left",
										"Center Align" => "ubtn-center",
										"Right Align" => "ubtn-right",
									),
								"group" => "General"
						  	),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Button Size"),
								"param_name" => "btn_size",
								"value" => array(
										"Normal Button" => "ubtn-normal",
										"Mini Button" => "ubtn-mini",
										"Small Button" => "ubtn-small",
										"Large Button" => "ubtn-large",
										"Button Block" => "ubtn-block",
										"Custom Size" => "ubtn-custom",
									),
								"description" => "",
								"group" => "General"
						  	),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Button Width"),
								"param_name" => "btn_width",
								"value" => "",
								"min" => 10,
								"max" => 1000,
								"suffix" => "px",
								"description" => "",
								"dependency" => Array("element" => "btn_size", "value" => "ubtn-custom" ),
								"group" => "General"
						  	),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Button Height"),
								"param_name" => "btn_height",
								"value" => "",
								"min" => 10,
								"max" => 1000,
								"suffix" => "px",
								"description" => "",
								"dependency" => Array("element" => "btn_size", "value" => "ubtn-custom" ),
								"group" => "General"
						  	),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Button Left / Right Padding"),
								"param_name" => "btn_padding_left",
								"value" => "",
								"min" => 10,
								"max" => 1000,
								"suffix" => "px",
								"description" => "",
								"dependency" => Array("element" => "btn_size", "value" => "ubtn-custom" ),
								"group" => "General"
						  	),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Button Top / Bottom Padding"),
								"param_name" => "btn_padding_top",
								"value" => "",
								"min" => 10,
								"max" => 1000,
								"suffix" => "px",
								"description" => "",
								"dependency" => Array("element" => "btn_size", "value" => "ubtn-custom" ),
								"group" => "General"
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Button Title Color"),
								"param_name" => "btn_title_color",
								"value" => "#000000",
								"description" => "",
								"group" => "General"
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Background Color"),
								"param_name" => "btn_bg_color",
								"value" => "#e0e0e0",
								"description" => "",
								"group" => "General"
						  	),
							array(
								"type" => "textfield",
								"heading" => $vc->l("Extra class name", "js_composer"),
								"param_name" => "el_class",
								"group" => "General"
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Button Hover Background Effect"),
								"param_name" => "btn_hover",
								"value" => array(
										"No Effect" => "ubtn-no-hover-bg",
										"Fade Background" => "ubtn-fade-bg",
										"Fill Background from Top" => "ubtn-top-bg",
										"Fill Background from Bottom" => "ubtn-bottom-bg",
										"Fill Background from Left" => "ubtn-left-bg",
										"Fill Background from Right" => "ubtn-right-bg",
										"Fill Background from Center Horizontally" => "ubtn-center-hz-bg",
										"Fill Background from Center Vertically" => "ubtn-center-vt-bg",
										"Fill Background from Center Diagonal" => "ubtn-center-dg-bg",
									),
								"description" => "",
								"group" => "Background"
						  	),
							array(
								"type" => "dropdown",
								"class" => "no-ult-effect",
								'edit_field_class' => 'ult-no-effect vc_column vc_col-sm-12',
								"heading" => $vc->l("Button Hover Animation Effects"),
								"param_name" => "btn_anim_effect",
								"value" => array(
										"No Effect" 			   => "none",
										"Grow" 					=> "ulta-grow",
										"Shrink" 			  	  => "ulta-shrink",
										"Pulse" 			   	   => "ulta-pulse",
										"Pulse Grow" 		  	  => "ulta-pulse-grow",
										"Pulse Shrink" 			=> "ulta-pulse-shrink",
										"Push" 					=> "ulta-push",
										"Pop" 				 	 => "ulta-pop",
										"Rotate" 			  	  => "ulta-rotate",
										"Grow Rotate" 		 	 => "ulta-grow-rotate",
										"Float" 			   	   => "ulta-float",
										"Sink" 					=> "ulta-sink",
										"Hover" 			   	   => "ulta-hover",
										"Hang" 					=> "ulta-hang",
										"Skew" 					=> "ulta-skew",
										"Skew Forward" 			=> "ulta-skew-forward",
										"Skew Backward" 	   	   => "ulta-skew-backward",
										"Wobble Horizontal"   	   => "ulta-wobble-horizontal",
										"Wobble Vertical" 	 	 => "ulta-wobble-vertical",
										"Wobble to Bottom Right"  => "ulta-wobble-to-bottom-right",
										"Wobble to Top Right" 	 => "ulta-wobble-to-top-right",
										"Wobble Top" 		  	  => "ulta-wobble-top",
										"Wobble Bottom" 	   	   => "ulta-wobble-bottom",
										"Wobble Skew" 		 	 => "ulta-wobble-skew",
										"Buzz" 					=> "ulta-buzz",
										"Buzz Out" 				=> "ulta-buzz-out",
									),
								"description" => "",
								"group" => "Background"
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Hover Background Color"),
								"param_name" => "btn_bg_color_hover",
								"value" => "",
								"description" => "",
								"group" => "Background"
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Hover Text Color"),
								"param_name" => "btn_title_color_hover",
								"value" => "",
								"description" => "",
								"group" => "Background"
						  	),
							array(
								"type" => "attach_image",
								"class" => "",
								"heading" => $vc->l("Button Background Image"),
								"param_name" => "button_bg_img",
								"value" => "",
								"description" => $vc->l("Upload the image on which you want to place the button."),
								"group" => "Background"
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => $vc->l("Select Icon "),
								"param_name" => "icon",
								"value" => "",
								"group" => "Icon"
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Size of Icon"),
								"param_name" => "icon_size",
								"value" => 32,
								"min" => 12,
								"max" => 72,
								"suffix" => "px",
								"description" => $vc->l("How big would you like it?"),
								"group" => "Icon"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Color"),
								"param_name" => "icon_color",
								"value" => "",
								"description" => $vc->l("Give it a nice paint!"),
								"group" => "Icon"
							),
							array(
								"type" => "ult_button",
								"class" => "",
								"heading" => $vc->l("Icon Position "),
								"param_name" => "btn_icon_pos",
								"value" => "",
								"json" => '',
								"description" => "",
								"group" => "Icon"
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Button Border Style"),
								"param_name" => "btn_border_style",
								"value" => array(
									"None"=> "",
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"description" => "",
								"group" => "Border"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Border Color"),
								"param_name" => "btn_color_border",
								"value" => "",
								"description" => "",
								"dependency" => Array("element" => "btn_border_style", "not_empty" => true),
								"group" => "Border"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Border Color on Hover"),
								"param_name" => "btn_color_border_hover",
								"value" => "",
								"description" => "",
								"dependency" => Array("element" => "btn_border_style", "not_empty" => true),
								"group" => "Border"
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Border Width"),
								"param_name" => "btn_border_size",
								"value" => 1,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => "",
								"dependency" => Array("element" => "btn_border_style", "not_empty" => true),
								"group" => "Border"
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Border Radius"),
								"param_name" => "btn_radius",
								"value" => 3,
								"min" => 0,
								"max" => 500,
								"suffix" => "px",
								"description" => "",
								"dependency" => Array("element" => "btn_border_style", "not_empty" => true),
								"group" => "Border"
						  	),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Button Shadow"),
								"param_name" => "btn_shadow",
								"value" => array(
										'No Shadow' => '',
										'Shadow at Top' => 'shd-top',
										'Shadow at Bottom' => 'shd-bottom',
										'Shadow at Left' => 'shd-left',
										'Shadow at Right' => 'shd-right',
									),
								"description" => $vc->l(""),
								"group" => "Shadow"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Shadow Color"),
								"param_name" => "btn_shadow_color",
								"value" => "",
								"description" => "",
								"dependency" => Array("element" => "btn_shadow", "not_empty" => true),
								"group" => "Shadow"
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Shadow Color on Hover"),
								"param_name" => "btn_shadow_color_hover",
								"value" => "",
								"description" => "",
								"dependency" => Array("element" => "btn_shadow", "not_empty" => true),
								"group" => "Shadow"
						  	),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Shadow Size"),
								"param_name" => "btn_shadow_size",
								"value" => 5,
								"min" => 0,
								"max" => 100,
								"suffix" => "px",
								"description" => "",
								"dependency" => Array("element" => "btn_shadow", "not_empty" => true),
								"group" => "Shadow"
						  	),
							array(
								"type" => "chk-switch",
								"class" => "",
								"heading" => $vc->l("Button Click Effect", "upb_parallax"),
								"param_name" => "btn_shadow_click",
								"value" => "",
								"options" => array(
										"enable" => array(
											"label" => "",
											"on" => "Yes",
											"off" => "No",
										)
									),
								"description" => $vc->l("Enable Click effect on hover", "upb_parallax"),
								"dependency" => Array("element" => "btn_shadow", "not_empty" => true),
								"group" => "Shadow"
						),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => $vc->l("Font Family"),
								"param_name" => "btn_font_family",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	$vc->l("Font Style"),
								"param_name"	=>	"btn_font_style",
								"group" => "Typography"
							),
							array(
								"type" => "number",
								"class" => "font-size",
								"heading" => $vc->l("Font Size"),
								"param_name" => "btn_font_size",
								"min" => 14,
								"suffix" => "px",
								"group" => "Typography"
							),
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => $vc->l("Tooltip Options"),
								"param_name" => "enable_tooltip",
								"value" => array("Enable tooltip on button" => "yes"),
								"group" => "Tooltip"
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => $vc->l("Text"),
								"param_name" => "tooltip_text",
								"value" => "",
								"dependency" => Array("element" => "enable_tooltip", "value" => "yes"),
								"group" => "Tooltip",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Position"),
								"param_name" => "tooltip_pos",
								"value" => array(
									"Tooltip from Left" => "left",
									"Tooltip from Right" => "right",
									"Tooltip from Top" => "top",
									"Tooltip from Bottom" => "bottom",
								),
								"description" => $vc->l("Select the tooltip position"),
								"dependency" => Array("element" => "enable_tooltip", "value" => "yes"),
								"group" => "Tooltip",
							),
							array(
								"type" => "heading",
								"param_name" => "notification",
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
								"group" => "General"
							),
						)
					)
				);
			}
		}
	}
	// new Ultimate_Buttons;
}