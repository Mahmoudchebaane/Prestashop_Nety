<?php
/*
* Add-on Name: Stats Counter for Visual Composer
* Template : Design layout 06
*/
if(class_exists("Ultimate_Pricing_Table")){
	class Pricing_Design06 extends Ultimate_Pricing_Table{
		public static function generate_design($atts,$content = null){
			$package_heading = $package_sub_heading = $package_price = $package_unit = $package_btn_text = $package_link = $package_featured = $color_bg_main = $color_txt_main = $color_bg_highlight = $color_txt_highlight = $color_scheme = $el_class = '';
			extract(jscomposer::shortcode_atts(array(
				"color_scheme" => "",
				"package_heading" => "",
				"package_sub_heading" => "",
				"package_price" => "",
				"package_unit" => "",
				"package_btn_text" => "",
				"package_link" => "",
				"package_featured" => "",
				"color_bg_main" => "",
				"color_txt_main" => "",
				"color_bg_highlight" => "",
				"color_txt_highlight" => "",
				"package_name_font_family" => "",
				"package_name_font_style" => "",
				"package_name_font_size" => "",
				"package_name_font_color" => "",
				"package_name_line_height" => "",
				"subheading_font_family" => "",
				"subheading_font_style" => "",
				"subheading_font_size" => "",
				"subheading_font_color" => "",
				"subheading_line_height" => "",
				"price_font_family" => "",
				"price_font_style" => "",
				"price_font_size" => "",
				"price_font_color" => "",
				"price_line_height" => "",
				"price_unit_font_family" => "",
				"price_unit_font_style" => "",
				"price_unit_font_size" => "",
				"price_unit_font_color" => "",
				"price_unit_line_height" => "",
				"features_font_family" => "",
				"features_font_style" => "",
				"features_font_size" => "",
				"features_font_color" => "",
				"features_line_height" => "",
				"button_font_family" => "",
				"button_font_style" => "",
				"button_font_size" => "",
				"button_font_color" => "",
				"button_line_height" => "",
				"el_class" => "",
			),$atts));
			$output = $link = $target = $featured = $featured_style = $normal_style = $dynamic_style = '';
			if($color_scheme == "custom"){
				if($color_bg_main !== ""){
					$normal_style .= 'background:'.$color_bg_main.';';
				}
				if($color_txt_main !== ""){
					$normal_style .= 'color:'.$color_txt_main.';';
				}
				if($color_bg_highlight!== ""){
					$featured_style .= 'background:'.$color_bg_highlight.';';
				}
				if($color_txt_highlight !== ""){
					$featured_style .= 'color:'.$color_txt_highlight.';';
				}
			}
			if($package_link !== ""){
				$link = vc_build_link($package_link);
				if(isset($link['target'])){
					$target = 'target="'.$link['target'].'"';
				} else {
					$target = '';
				}
				$link = $link['url'];
			} else {
				$link = "#";
			}
			if($package_featured !== ""){
				$featured = "ult_featured";
			}
			
			/* Typography */
			
			$package_name_inline = $sub_heading_inline = $price_inline = $price_unit_inline = $features_inline = $button_inline = '';
			
			// package name/title
			if($package_name_font_family != '')
			{
				$pkgfont_family = get_ultimate_font_family($package_name_font_family);
				$package_name_inline .= 'font-family:\''.$pkgfont_family.'\';';
			}
			
			$package_name_inline .= get_ultimate_font_style($package_name_font_style);
			
			if($package_name_font_size != '')
				$package_name_inline .= 'font-size:'.$package_name_font_size.'px;';

			if($package_name_font_color != '')
				$package_name_inline .= 'color:'.$package_name_font_color.';';

			if($package_name_line_height != '')
				$package_name_inline .= 'line-height:'.$package_name_line_height.'px;';
			
			// sub heading
			if($subheading_font_family != '')
			{
				$shfont_family = get_ultimate_font_family($subheading_font_family);
				$sub_heading_inline .= 'font-family:\''.$shfont_family.'\';';
			}
			
			$sub_heading_inline .= get_ultimate_font_style($subheading_font_style);
			
			if($subheading_font_size != '')
				$sub_heading_inline .= 'font-size:'.$subheading_font_size.'px;';
					
			if($subheading_font_color != '')
				$sub_heading_inline .= 'color:'.$subheading_font_color.';';

			if($subheading_line_height != '')
				$sub_heading_inline .= 'line-height:'.$subheading_line_height.'px;';
				
			// price
			if($price_font_family != '')
			{
				$pricefont_family = get_ultimate_font_family($price_font_family);
				$price_inline .= 'font-family:\''.$pricefont_family.'\';';
			}
			
			$price_inline .= get_ultimate_font_style($price_font_style);
			
			if($price_font_size != '')
				$price_inline .= 'font-size:'.$price_font_size.'px;';
					
			if($price_font_color != '')
				$price_inline .= 'color:'.$price_font_color.';';

			if($price_line_height != '')
				$price_inline .= 'line-height:'.$price_line_height.'px;';
				
			// price unit
			if($price_unit_font_family != '')
			{
				$price_unitfont_family = get_ultimate_font_family($price_unit_font_family);
				$price_unit_inline .= 'font-family:\''.$price_unitfont_family.'\';';
			}
			
			$price_unit_inline .= get_ultimate_font_style($price_unit_font_style);
			
			if($price_unit_font_size != '')
				$price_unit_inline .= 'font-size:'.$price_unit_font_size.'px;';
					
			if($price_unit_font_color != '')
				$price_unit_inline .= 'color:'.$price_unit_font_color.';';

			if($price_unit_line_height != '')
				$price_unit_inline .= 'line-height:'.$price_unit_line_height.'px;';
				
			// features
			if($features_font_family != '')
			{
				$featuresfont_family = get_ultimate_font_family($features_font_family);
				$features_inline .= 'font-family:\''.$featuresfont_family.'\';';
			}
			
			$features_inline .= get_ultimate_font_style($features_font_style);
			
			if($features_font_size != '')
				$features_inline .= 'font-size:'.$features_font_size.'px;';
					
			if($features_font_color != '')
				$features_inline .= 'color:'.$features_font_color.';';

			if($features_line_height != '')
				$features_inline .= 'line-height:'.$features_line_height.'px;';
				
			// button
			if($button_font_family != '')
			{
				$buttonfont_family = get_ultimate_font_family($button_font_family);
				$button_inline .= 'font-family:\''.$buttonfont_family.'\';';
			}
			
			$button_inline .= get_ultimate_font_style($button_font_style);
			
			if($button_font_size != '')
				$button_inline .= 'font-size:'.$button_font_size.'px;';
					
			if($button_font_color != '')
				$button_inline .= 'color:'.$button_font_color.';';

			if($button_line_height != '')
				$button_inline .= 'line-height:'.$button_line_height.'px;';
				
			$args = array(
				$package_name_font_family, $subheading_font_family, $price_font_family, $features_font_family, $button_font_family
			);
			enquque_ultimate_google_fonts($args);
			
			/* End Typography */
			
			$output .= '<div class="ult_pricing_table_wrap ult_design_6 '.$featured.' ult-cs-'.$color_scheme.' '.$el_class.'">
						<div class="ult_pricing_table" style="'.$normal_style.'">';
				$output .= '<div class="ult_pricing_heading" style="'.$featured_style.'">
								<h3 style="'.$package_name_inline.'">'.$package_heading.'</h3>';
							if($package_sub_heading !== ''){
								$output .= '<h5 style="'.$sub_heading_inline.'">'.$package_sub_heading.'</h5>';
							}
				$output .= '</div><!--ult_pricing_heading-->';
				$output .= '<div class="ult_price_body_block" style="'.$featured_style.'">
								<div class="ult_price_body">
									<div class="ult_price">
										<span class="ult_price_figure" style="'.$price_inline.'">'.$package_price.'</span>
										<span class="ult_price_term" style="'.$price_unit_inline.'">'.$package_unit.'</span>
									</div>
								</div>
							</div><!--ult_price_body_block-->';
				$output .= '<div class="ult_price_features" style="'.$features_inline.'">
								'.wpb_js_remove_wpautop(jscomposer::do_shortcode($content), true).'
							</div><!--ult_price_features-->';
				if($package_btn_text !== ""){
					$output .= '<div class="ult_price_link" style="'.$normal_style.'">
								<a href="'.$link.'" '.$target.' class="ult_price_action_button" style="'.$featured_style.' '.$button_inline.'">'.$package_btn_text.'</a>
							</div><!--ult_price_link-->';
				}
				$output .= '<div class="ult_clr"></div>
				</div><!--pricing_table-->
			</div><!--pricing_table_wrap-->';
			return $output;
		}
	}
}