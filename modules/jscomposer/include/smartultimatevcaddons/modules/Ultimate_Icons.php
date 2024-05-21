<?php
/*
* Add-on Name: Icons Block for Visual Composer
*/
if(!class_exists('Ultimate_Icons')) 
{
	class Ultimate_Icons
	{
		public $vcaddonsinstance, $context;
		function __construct()
		{
                    $this->vcaddonsinstance = jscomposer::getInstance();
                    $this->context = Context::getContext();
                    JsComposer::add_shortcode('ultimate_icons',array($this,'ultimate_icons_shortcode'));
                    JsComposer::add_shortcode('single_icon',array($this,'single_icon_shortcode'));
		}
		function ultimate_icon_init()
		{
			$vc = vc_manager();
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
						"name" => $vc->l("Icons"),
						"base" => "ultimate_icons",
						"class" => "ultimate_icons",
						"icon" => "ultimate_icons",
						"category" => $vc->l("Ultimate VC Addons"),
						"description" => $vc->l("Add a set of multiple icons and give some custom style."),
						"as_parent" => array('only' => 'single_icon'), 
						"content_element" => true,
						"show_settings_on_create" => true,
						"js_view" => 'VcColumnView',
						"params" => array(							
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Alignment"),
								"param_name" => "align",
								"value" => array("Left Align" => "uavc-icons-left", "Right Align" => "uavc-icons-right", "Center Align" => "uavc-icons-center"),
								"description" => $vc->l(""),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => $vc->l("Extra Class"),
								"param_name" => "el_class",
								"value" => "",
								"description" => $vc->l("Write your own CSS and mention the class name here."),
							),
						)
					)
				);
				vc_map(
					array(
					   "name" => $vc->l("Icon Item"),
					   "base" => "single_icon",
					   "class" => "vc_simple_icon",
					   "icon" => "vc_just_icon",
					   "category" => $vc->l("Ultimate VC Addons"),
					   "description" => $vc->l("Add a set of multiple icons and give some custom style."),
					   "as_child" => array('only' => 'ultimate_icons'), 
					   "show_settings_on_create" => true,
					   "params" => array(							
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => $vc->l("Select Icon "),
								"param_name" => "icon",
								"value" => "",
								"admin_label" => true,
								"group"=> "Select Icon",
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
								"group"=> "Select Icon",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Space after Icon"),
								"param_name" => "icon_margin",
								"value" => 5,
								"min" => 0,
								"max" => 100,
								"suffix" => "px",
								"description" => $vc->l("How much distance would you like in two icons?"),
								"group" => "Other Settings"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Color"),
								"param_name" => "icon_color",
								"value" => "#333333",
								"description" => $vc->l("Give it a nice paint!"),
								"group"=> "Select Icon",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Icon Style"),
								"param_name" => "icon_style",
								"value" => array(
									"Simple" => "none",
									"Circle Background" => "circle",
									"Square Background" => "square",
									"Design your own" => "advanced",
								),
								"description" => $vc->l("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options."),
								"group" => "Select Icon"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Background Color"),
								"param_name" => "icon_color_bg",
								"value" => "#ffffff",
								"description" => $vc->l("Select background color for icon."),	
								"dependency" => Array("element" => "icon_style", "value" => array("circle","square","advanced")),
								"group" => "Select Icon"
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Icon Border Style"),
								"param_name" => "icon_border_style",
								"value" => array(
									"None"=> "",
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"description" => $vc->l("Select the border style for icon."),
								"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
								"group" => "Select Icon"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Border Color"),
								"param_name" => "icon_color_border",
								"value" => "#333333",
								"description" => $vc->l("Select border color for icon."),	
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => "Select Icon"
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Border Width"),
								"param_name" => "icon_border_size",
								"value" => 1,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => $vc->l("Thickness of the border."),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => "Select Icon"
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Border Radius"),
								"param_name" => "icon_border_radius",
								"value" => 500,
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => "Select Icon"
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Background Size"),
								"param_name" => "icon_border_spacing",
								"value" => 50,
								"min" => 30,
								"max" => 500,
								"suffix" => "px",
								"description" => $vc->l("Spacing from center of the icon till the boundary of border / background"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => "Select Icon"
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => $vc->l("Link "),
								"param_name" => "icon_link",
								"value" => "",
								"description" => $vc->l("Add a custom link or select existing page. You can remove existing link as well."),
								"group" => "Other Settings"
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Animation"),
								"param_name" => "icon_animation",
								"value" => array(
							 		$vc->l("No Animation") => "",
									$vc->l("Swing") => "swing",
									$vc->l("Pulse") => "pulse",
									$vc->l("Fade In") => "fadeIn",
									$vc->l("Fade In Up") => "fadeInUp",
									$vc->l("Fade In Down") => "fadeInDown",
									$vc->l("Fade In Left") => "fadeInLeft",
									$vc->l("Fade In Right") => "fadeInRight",
									$vc->l("Fade In Up Long") => "fadeInUpBig",
									$vc->l("Fade In Down Long") => "fadeInDownBig",
									$vc->l("Fade In Left Long") => "fadeInLeftBig",
									$vc->l("Fade In Right Long") => "fadeInRightBig",
									$vc->l("Slide In Down") => "slideInDown",
									$vc->l("Slide In Left") => "slideInLeft",
									$vc->l("Slide In Left") => "slideInLeft",
									$vc->l("Bounce In") => "bounceIn",
									$vc->l("Bounce In Up") => "bounceInUp",
									$vc->l("Bounce In Down") => "bounceInDown",
									$vc->l("Bounce In Left") => "bounceInLeft",
									$vc->l("Bounce In Right") => "bounceInRight",
									$vc->l("Rotate In") => "rotateIn",
									$vc->l("Light Speed In") => "lightSpeedIn",
									$vc->l("Roll In") => "rollIn",
									),
								"group" => "Other Settings"
						  	),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Tooltip"),
								"param_name" => "tooltip_disp",
								"value" => array(
									"None"=> "",
									"Tooltip from Left" => "left",
									"Tooltip from Right" => "right",
									"Tooltip from Top" => "top",
									"Tooltip from Bottom" => "bottom",
								),
								"description" => $vc->l("Select the tooltip position"),
								"group" => "Other Settings"
							),							
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => $vc->l("Tooltip Text"),
								"param_name" => "tooltip_text",
								"value" => "",
								"description" => $vc->l("Enter your tooltip text here."),
								"dependency" => Array("element" => "tooltip_disp", "not_empty" => true),
								"group" => "Other Settings"
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => $vc->l("Custom CSS Class"),
								"param_name" => "el_class",
								"value" => "",
								"group" => "Select Icon"
							),
						),
					)
				);
			}
		}
		// Shortcode handler function for stats Icon
		function ultimate_icons_shortcode($atts,$content = null)
		{
			$align = $el_class = '';
			extract(JsComposer::shortcode_atts(array(
				'align' => '',
				'el_class' => ''
			),$atts));
			
			$output = '<div class="'.$align.' uavc-icons '.$el_class.'">';
			$output .= JsComposer::do_shortcode($content);
			$output .= '</div>';
			
			return $output;
		}
		
		function single_icon_shortcode($atts){
			
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation =  $tooltip_disp = $tooltip_text = $icon_margin = '';
			extract(JsComposer::shortcode_atts( array(
				'icon'=> '',				
				'icon_size' => '',				
				'icon_color' => '',
				'icon_style' => '',
				'icon_color_bg' => '',
				'icon_color_border' => '',			
				'icon_border_style' => '',
				'icon_border_size' => '',
				'icon_border_radius' => '',
				'icon_border_spacing' => '',
				'icon_link' => '',
				'icon_margin' => '',
				'icon_animation' => '',
				'tooltip_disp' => '',
				'tooltip_text' => '',
				'el_class'=>'',
			),$atts));

			if(isset($tooltip_disp) && $tooltip_disp != '')
                            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/tooltip.min.js");
				
			if($icon_animation !== 'none')
			{
				$css_trans = 'data-animation="'.$icon_animation.'" data-animation-delay="03"';
			}
			$output = $style = $link_sufix = $link_prefix = $target = $href = $icon_align_style = '';
			$uniqid = uniqid();
			if($icon_link !== ''){
				$href = vc_build_link($icon_link);
				$target = (isset($href['target'])) ? "target='".$href['target']."'" : '';
				$link_prefix .= '<a class="aio-tooltip '.$uniqid.'" href = "'.$href['url'].'" '.$target.' data-toggle="tooltip" data-placement="'.$tooltip_disp.'" title="'.$tooltip_text.'">';
				$link_sufix .= '</a>';
			} else {
				if($tooltip_disp !== ""){
					$link_prefix .= '<span class="aio-tooltip '.$uniqid.'" href = "'.$href.'" '.$target.' data-toggle="tooltip" data-placement="'.$tooltip_disp.'" title="'.$tooltip_text.'">';
					$link_sufix .= '</span>';
				}
			}
						
			if($icon_color !== '')
				$style .= 'color:'.$icon_color.';';
			if($icon_style !== 'none'){
				if($icon_color_bg !== '')
					$style .= 'background:'.$icon_color_bg.';';
			}
			if($icon_style == 'advanced'){
				$style .= 'border-style:'.$icon_border_style.';';
				$style .= 'border-color:'.$icon_color_border.';';
				$style .= 'border-width:'.$icon_border_size.'px;';
				$style .= 'width:'.$icon_border_spacing.'px;';
				$style .= 'height:'.$icon_border_spacing.'px;';
				$style .= 'line-height:'.$icon_border_spacing.'px;';
				$style .= 'border-radius:'.$icon_border_radius.'px;';
			}
			if($icon_size !== '')
				$style .='font-size:'.$icon_size.'px;';
			
			if($icon_margin !== '')
				$style .= 'margin-right:'.$icon_margin.'px;';
			
			if($icon !== ""){
				$output .= "\n".$link_prefix.'<div class="aio-icon '.$icon_style.' '.$el_class.'" '.$css_trans.' style="'.$style.'">';				
				$output .= "\n\t".'<i class="'.$icon.'"></i>';	
				$output .= "\n".'</div>'.$link_sufix;
			}
			//$output .= JsComposer::do_shortcode($content);
			if($tooltip_disp !== ""){
				$output .= '<script>
					jQuery(function () {
						jQuery(".'.$uniqid.'").bsf_tooltip("hide");
					})
				</script>';
			}			
			return $output;
		}
	}
}
// if(class_exists('Ultimate_Icons'))
// {
// 	$Ultimate_Icons = new Ultimate_Icons;
// }
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_ultimate_icons extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_single_icon extends WPBakeryShortCode {
    }
}