<?php
/*
* Add-on Name: Ultimate Modals
* Add-on URI: https://www.brainstormforce.com
*/
if(!class_exists('Ultimate_Modals'))
{
	class Ultimate_Modals
	{
		public $vcaddonsinstance, $context;
		function __construct()
		{
				// Add shortcode for modal popup
                    JsComposer::add_shortcode('ultimate_modal', array(&$this, 'modal_shortcode' ) );

                    $this->vcaddonsinstance = jscomposer::getInstance();
                    $this->context = Context::getContext();
                    if(!$this->vcaddonsinstance->is_admin()){
                        $this->register_modal_assets();
                    }
		}
		function register_modal_assets()
		{
                    jscomposer::$front_inline_tags[] = $this->enqueue_modal_js();
		}
		function enqueue_modal_js(){
			$return = '<script type="text/javascript">';
			$return .= 'document.addEventListener("DOMContentLoaded", function(event) {
					jQuery(".ult_modal-body iframe").each(function(index, element) {
						var w = jQuery(this).attr("width");
						var h = jQuery(this).attr("height");
						var st = \'<style type="text/css" id="modal-css">\';
							st += "#"+jQuery(this).closest(".ult-overlay").attr("id")+" iframe{width:"+w+"px !important;height:"+h+"px !important;}";
							st += ".fluid-width-video-wrapper{padding: 0 !important;}";
							st += "</style>";
						jQuery("head").append(st);
					}); 
                                    });';
			return $return .= '</script>';
		}		
		// Add shortcode for icon-box
		function modal_shortcode($atts, $content = null)
		{
            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/modal.min.css"); 
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/modernizr.custom.min.js"); 
			$this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/modal-all.min.js");
                    
			$row_setting = '';
			$icon = $modal_on = $modal_contain = $btn_size = $btn_bg_color = $btn_txt_color = $btn_text = $read_text = $txt_color = $modal_title = $modal_size = $el_class = $modal_style = $icon_type = $icon_img = $btn_img = $overlay_bg_color = $overlay_bg_opacity = $modal_on_align = $content_bg_color = $content_text_color = $header_bg_color = $header_text_color = $modal_border_style = $modal_border_width = $modal_border_color = $modal_border_radius = '';
			extract(JsComposer::shortcode_atts(array(
				'icon_type' => '',
				'icon' => '',
				'icon_img' => '',
				'modal_on' => '',
				'modal_contain' => '',
				'onload_delay'=>'',
				'btn_size' => '',
				'overlay_bg_color' => '',
				'overlay_bg_opacity' => '80',
				'btn_bg_color' => '',
				'btn_txt_color' => '',
				'btn_text' => '',				
				'read_text' => '',
				'txt_color' => '',
				'btn_img' => '',
				'modal_title' => '',
				'modal_size' => '',
				'modal_style' => '',
				'content_bg_color' => '',
				'content_text_color' => '',
				'header_bg_color' => '',
				'header_text_color' => '',
				'modal_on_align' => '',
				'modal_border_style' => '',
				'modal_border_width' => '',
				'modal_border_color' => '',
				'modal_border_radius' => '',
				'el_class' => '',
				),$atts,'ultimate_modal'));
			$html = $style = $box_icon = $modal_class = $modal_data_class = $uniq = $overlay_bg = $content_style = $header_style = $border_style = '';
			if($modal_on == "ult-button"){
				$modal_on = "button";
			}
			// Create style for content background color
			if($content_bg_color !== '')
				$content_style .= 'background:'.$content_bg_color.';';
			// Create style for content text color
			if($content_text_color !== '')
				$content_style .= 'color:'.$content_text_color.';';
			// Create style for header background color
			if($header_bg_color !== '')
				$header_style .= 'background:'.$header_bg_color.';';
			// Create style for header text color
			if($header_text_color !== '')
				$header_style .= 'color:'.$header_text_color.';';
			if($modal_border_style !== ''){
				$border_style .= 'border-style:'.$modal_border_style.';';
				$border_style .= 'border-width:'.$modal_border_width.'px;';
				$border_style .= 'border-radius:'.$modal_border_radius.'px;';
				$border_style .= 'border-color:'.$modal_border_color.';';
				$header_style .= 'border-color:'.$modal_border_color.';';
			}
			$overlay_bg_opacity = ($overlay_bg_opacity/100);
			if($overlay_bg_color !== ''){
				if(strlen($overlay_bg_color) <= 7)
					$overlay_bg = jscomposer::ultimate_hex2rgb($overlay_bg_color,$overlay_bg_opacity);
				else
					$overlay_bg = $overlay_bg_color;
					
				if($modal_style != 'overlay-show-cornershape' && $modal_style != 'overlay-show-genie' && $modal_style != 'overlay-show-boxes'){
					$overlay_bg = 'background:'.$overlay_bg.';';
				} else {
					$overlay_bg = 'fill:'.$overlay_bg.';';
				}
			}
			$uniq = uniqid();
			if($icon_type == 'custom'){
//				$ico_img = wp_get_attachment_image_src( $icon_img, 'large');
				$ico_img = JsComposer::$_url.'uploads/'.JsComposer::get_media_thumbnail_url( $icon_img );
				$box_icon = '<div class="modal-icon"><img src="'.$ico_img.'" class="ult-modal-inside-img"></div>';
			} elseif($icon_type == 'selector'){
				if($icon !== '')
					$box_icon = '<div class="modal-icon"><i class="'.$icon.'"></i></div>';
			}
			if($modal_style != 'overlay-show-cornershape' && $modal_style != 'overlay-show-genie' && $modal_style != 'overlay-show-boxes'){
				$modal_class = 'overlay-show';
				$modal_data_class = 'data-overlay-class="'.$modal_style.'"';
			} else {
				$modal_class = $modal_style;
				$modal_data_class = '';
			}
			if($modal_on == "button"){
				if($btn_bg_color !== ''){
					$style .= 'background:'.$btn_bg_color.';';
					$style .= 'border-color:'.$btn_bg_color.';';
				}
				if($btn_txt_color !== ''){
					$style .= 'color:'.$btn_txt_color.';';
				}
				if($el_class != '')
					$modal_class .= ' '.$el_class.'-button ';
					
				$html .= '<button style="'.$style.'" data-class-id="content-'.$uniq.'" class="btn-ult btn-primary btn-'.$btn_size.' '.$modal_class.' ult-align-'.$modal_on_align.'" '.$modal_data_class.'>'.$btn_text.'</button>';
			} elseif($modal_on == "image"){
				if($btn_img !==''){
					if($el_class != '')
						$modal_class .= ' '.$el_class.'-image ';
					$img = JsComposer::$_url.'uploads/'.JsComposer::get_media_thumbnail_url( $btn_img );
					$html .= '<img src="'.$img.'" data-class-id="content-'.$uniq.'" class="ult-modal-img '.$modal_class.' ult-align-'.$modal_on_align.' ult-modal-image-'.$el_class.'" '.$modal_data_class.'/>';
				}
			} 
			elseif($modal_on == "onload"){
				$html .= '<div data-class-id="content-'.$uniq.'" class="ult-onload '.$modal_class.' " '.$modal_data_class.' data-onload-delay="'.$onload_delay.'"></div>';				
			} 
			else {
				if($txt_color !== ''){
					$style .= 'color:'.$txt_color.';';
					$style .= 'cursor:pointer;';
				}
				if($el_class != '')
					$modal_class .= ' '.$el_class.'-link ';
				$html .= '<span style="'.$style.'" data-class-id="content-'.$uniq.'" class="'.$modal_class.' ult-align-'.$modal_on_align.'" '.$modal_data_class.'>'.$read_text.'</span>';
			}
			if($modal_style == 'overlay-show-cornershape') {
				$html .= "\n".'<div class="ult-overlay overlay-cornershape content-'.$uniq.' '.$el_class.'" style="display:none" data-class="content-'.$uniq.'" data-path-to="m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z">';
            	$html .= "\n\t".'<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1440 806" preserveAspectRatio="none">
                					<path class="overlay-path" d="m 0,0 1439.999975,0 0,805.99999 0,-805.99999 z" style="'.$overlay_bg.'"/>
            					</svg>';
			} elseif($modal_style == 'overlay-show-genie') {
				$html .= "\n".'<div class="ult-overlay overlay-genie content-'.$uniq.' '.$el_class.'" style="display:none" data-class="content-'.$uniq.'" data-steps="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z;m 698.9986,728.03569 41.23353,0 -3.41953,77.8735 -34.98557,0 z;m 687.08153,513.78234 53.1506,0 C 738.0505,683.9161 737.86917,503.34193 737.27015,806 l -35.90067,0 c -7.82727,-276.34892 -2.06916,-72.79261 -14.28795,-292.21766 z;m 403.87105,257.94772 566.31246,2.93091 C 923.38284,513.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 455.17312,480.07689 403.87105,257.94772 z;M 51.871052,165.94772 1362.1835,168.87863 C 1171.3828,653.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 31.173122,513.78234 51.871052,165.94772 z;m 52,26 1364,4 c -12.8007,666.9037 -273.2644,483.78234 -322.7299,776 l -633.90062,0 C 359.32034,432.49318 -6.6979288,733.83462 52,26 z;m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z">';
				$html .= "\n\t".'<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1440 806" preserveAspectRatio="none">
							<path class="overlay-path" d="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z" style="'.$overlay_bg.'"/>
						</svg>';
			} elseif($modal_style == 'overlay-show-boxes') {
				$html .= "\n".'<div class="ult-overlay overlay-boxes content-'.$uniq.' '.$el_class.'" style="display:none" data-class="content-'.$uniq.'">';
				$html .= "\n\t".'<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="101%" viewBox="0 0 1440 806" preserveAspectRatio="none">';
				$html .= "\n\t\t".'<path d="m0.005959,200.364029l207.551124,0l0,204.342453l-207.551124,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m0.005959,400.45401l207.551124,0l0,204.342499l-207.551124,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m0.005959,600.544067l207.551124,0l0,204.342468l-207.551124,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m205.752151,-0.36l207.551163,0l0,204.342437l-207.551163,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m204.744629,200.364029l207.551147,0l0,204.342453l-207.551147,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m204.744629,400.45401l207.551147,0l0,204.342499l-207.551147,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m204.744629,600.544067l207.551147,0l0,204.342468l-207.551147,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m410.416046,-0.36l207.551117,0l0,204.342437l-207.551117,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m410.416046,200.364029l207.551117,0l0,204.342453l-207.551117,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m410.416046,400.45401l207.551117,0l0,204.342499l-207.551117,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m410.416046,600.544067l207.551117,0l0,204.342468l-207.551117,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m616.087402,-0.36l207.551086,0l0,204.342437l-207.551086,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m616.087402,200.364029l207.551086,0l0,204.342453l-207.551086,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m616.087402,400.45401l207.551086,0l0,204.342499l-207.551086,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m616.087402,600.544067l207.551086,0l0,204.342468l-207.551086,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m821.748718,-0.36l207.550964,0l0,204.342437l-207.550964,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m821.748718,200.364029l207.550964,0l0,204.342453l-207.550964,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m821.748718,400.45401l207.550964,0l0,204.342499l-207.550964,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m821.748718,600.544067l207.550964,0l0,204.342468l-207.550964,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1027.203979,-0.36l207.550903,0l0,204.342437l-207.550903,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1027.203979,200.364029l207.550903,0l0,204.342453l-207.550903,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1027.203979,400.45401l207.550903,0l0,204.342499l-207.550903,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1027.203979,600.544067l207.550903,0l0,204.342468l-207.550903,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1232.659302,-0.36l207.551147,0l0,204.342437l-207.551147,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1232.659302,200.364029l207.551147,0l0,204.342453l-207.551147,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1232.659302,400.45401l207.551147,0l0,204.342499l-207.551147,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1232.659302,600.544067l207.551147,0l0,204.342468l-207.551147,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m-0.791443,-0.360001l207.551163,0l0,204.342438l-207.551163,0l0,-204.342438z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t".'</svg>';
			} else {
				$html .= "\n".'<div class="ult-overlay content-'.$uniq.' '.$el_class.'" data-class="content-'.$uniq.'" id="button-click-overlay" style="'.$overlay_bg.' display:none;">';
			}
			$html .= "\n\t".'<div class="ult_modal ult-fade ult-'.$modal_size.'">';
			$html .= "\n\t\t".'<div class="ult_modal-content" style="'.$border_style.'">';
			if($modal_title !== ''){
				$html .= "\n\t\t\t".'<div class="ult_modal-header" style="'.$header_style.'">';
				$html .= "\n\t\t\t\t".$box_icon.'<h3 class="ult_modal-title">'.$modal_title.'</h3>';
				$html .= "\n\t\t\t".'</div>';
			}
			$html .= "\n\t\t\t".'<div class="ult_modal-body '.$modal_contain.'" style="'.$content_style.'">';
			$html .= "\n\t\t\t".JsComposer::do_shortcode($content);
			$html .= "\n\t\t\t".'</div>';
			$html .= "\n\t".'</div>';
			$html .= "\n\t".'</div>';
			$html .= "\n\t".'<div class="ult-overlay-close">Close</div>';
			$html .= "\n".'</div>';
			Media::addJsDef(array(
					'modal_all_js_loaded' => true
				));
			return $html;
		}
		/* Add modal popup Component*/
		function ultimate_modal_init()
		{
			$vc = vc_manager();
			if ( function_exists('vc_map'))
			{
				vc_map( 
					array(
						"name"		=> $vc->l("Modal Box"),
						"base"		=> "ultimate_modal",
						"icon"		=> "vc_modal_box",
						"class"	   => "modal_box",
						"category"  => $vc->l("Ultimate VC Addons"),
						"description" => "Adds bootstrap modal box in your content",
						"controls" => "full",
						"show_settings_on_create" => true,
						"params" => array(
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Icon to display:"),
								"param_name" => "icon_type",
								"value" => array(
									"No Icon" => "none",
									"Font Icon Manager" => "selector",
									"Custom Image Icon" => "custom",
								),
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => $vc->l("Select Icon "),
								"param_name" => "icon",
								"value" => "",
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "attach_image",
								"class" => "",
								"heading" => $vc->l("Upload Image Icon:"),
								"param_name" => "icon_img",
								"value" => "",
								"description" => $vc->l("Upload the custom image icon."),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => $vc->l("Modal Box Title"),
								"param_name" => "modal_title",
								"admin_label" => true,
								"value" => "",
								"description" => $vc->l("Provide the title for modal box."),
							),
							array(
								"type" => "textarea_html",
								"class" => "",
								"heading" => $vc->l("Modal Content"),
								"param_name" => "content",
								"value" => "",
								"description" => $vc->l("Content that will be displayed in Modal Popup.")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Whats in Modal Popup?"),
								"param_name" => "modal_contain",
								"value" => array(
									"Miscellaneous Things" => "ult-html",
									"Youtube Video" => "ult-youtube",
									"Vimeo Video" => "ult-vimeo",
								)
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Display Modal On"),
								"param_name" => "modal_on",
								"value" => array(
									"Button" => "ult-button",
									"Image" => "image",
									"Text" => "text",
									"On Page Load" => "onload",
								),
								"description" => $vc->l("When should the popup be initiated?")
							),
							array(
								"type"=>"number",
								"class"=>'',
								"heading"=>"Delay in Popup Display",
								"param_name"=>"onload_delay",
								"value"=>"2",
								"suffix"=>"seconds",
								"description"=>$vc->l("Time delay before modal popup on page load in seconds"),
								"dependency"=>Array("element"=>"modal_on","value"=>array("onload"))
								),
							array(
								"type" => "attach_image",
								"class" => "",
								"heading" => $vc->l("Upload Image"),
								"param_name" => "btn_img",
								"admin_label" => true,
								"value" => "",
								"description" => $vc->l("Upload the custom image / image banner."),
								"dependency" => Array("element" => "modal_on","value" => array("image")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Button Size"),
								"param_name" => "btn_size",
								"value" => array(
									"Small" => "sm",
									"Medium" => "md",
									"Large" => "lg",
									"Block" => "block",
								),
								"description" => $vc->l("How big the button would you like?"),
								"dependency" => Array("element" => "modal_on","value" => array("ult-button")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Button Background Color"),
								"param_name" => "btn_bg_color",
								"value" => "#333333",
								"dependency" => Array("element" => "modal_on","value" => array("ult-button")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Button Text Color"),
								"param_name" => "btn_txt_color",
								"value" => "#FFFFFF",
								"description" => $vc->l("Give it a nice paint!"),
								"dependency" => Array("element" => "modal_on","value" => array("ult-button")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Alignment"),
								"param_name" => "modal_on_align",
								"value" => array(
									"Center" => "center",
									"Left" => "left",
									"Right" => "right",
								),
								"dependency"=>Array("element"=>"modal_on","value"=>array("button","image","text")),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => $vc->l("Text on Button"),
								"param_name" => "btn_text",
								"admin_label" => true,
								"value" => "",
								"dependency" => Array("element" => "modal_on","value" => array("ult-button")),
							),
							// // Custom text for modal trigger
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => $vc->l("Enter Text"),
								"param_name" => "read_text",
								"value" => "",
								"dependency" => array("element" => "modal_on","value" => array("text")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Text Color"),
								"param_name" => "txt_color",
								"value" => "#f60f60",
								"dependency" => Array("element" => "modal_on","value" => array("text")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => $vc->l("Modal Size"),
								"param_name" => "modal_size",
								"value" => array(
									"Small" => "small",
									"Medium" => "medium",
									"Large" => "container",
									"Block" => "block",
								),
							),
							// // // Modal Style
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => "Modal Box Style",
								"param_name" => "modal_style",
								"value" => array(
									"Corner Bottom Left" => "overlay-cornerbottomleft",
									"Corner Bottom Right" => "overlay-cornerbottomright",
									"Corner Top Left" => "overlay-cornertopleft",
									"Corner Top Right" => "overlay-cornertopright",
									"Corner Shape" => "overlay-show-cornershape",
									"Door Horizontal" => "overlay-doorhorizontal",
									"Door Vertical" => "overlay-doorvertical",
									"Fade" => "overlay-fade",
									"Genie" => "overlay-show-genie",
									"Little Boxes" => "overlay-show-boxes",
									"Simple Genie" => "overlay-simplegenie",
									"Slide Down" => "overlay-slidedown",
									"Slide Up" => "overlay-slideup",
									"Slide Left" => "overlay-slideleft",
									"Slide Right" => "overlay-slideright",
									"Zoom in" => "overlay-zoomin",
									"Zoom out" => "overlay-zoomout",
								),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => $vc->l("Overlay Background Color"),
								"param_name" => "overlay_bg_color",
								"value" => "#333333",
								"description" => $vc->l("Give it a nice paint!"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => $vc->l("Overlay Background Opacity"),
								"param_name" => "overlay_bg_opacity",
								"value" => 80,
								"min" => 10,
								"max" => 100,
								"suffix" => "%",
								"description" => $vc->l("Select opacity of overlay background."),
							)
						)// end params array
					)// end vc_map array
				);// end vc_map
			}// end function check 'vc_map'
		}// end function icon_box_init
	}//Class Ultimate_Modals end
}
