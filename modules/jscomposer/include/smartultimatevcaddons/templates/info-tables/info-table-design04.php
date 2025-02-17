<?php
/*
* Add-on Name: Info Tables for Visual Composer
* Template : Design layout 04
*/
if(class_exists("Ultimate_Info_Table")){
	class Info_Design04 extends Ultimate_Info_Table{
		public static function generate_design($atts,$content = null){
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $el_class = $package_heading = $package_sub_heading = $package_price = $package_unit = $package_btn_text = $package_link = $package_featured = $color_bg_main = $color_txt_main = $color_bg_highlight = $color_txt_highlight = $color_scheme = $use_cta_btn = '';
			extract(jscomposer::shortcode_atts(array(
				'color_scheme' => '',
				'package_heading' => '',
				'package_sub_heading' => '',
				'icon_type' => '',
				'icon' => '',
				'icon_img' => '',
				'img_width' => '',
				'icon_size' => '',				
				'icon_color' => '',
				'icon_style' => '',
				'icon_color_bg' => '',
				'icon_color_border' => '',			
				'icon_border_style' => '',
				'icon_border_size' => '',
				'icon_border_radius' => '',
				'icon_border_spacing' => '',
				'use_cta_btn' => '',
				'package_btn_text' => '',
				'package_link' => '',
				'package_featured' => '',
				'color_bg_main' => '',
				'color_txt_main' => '',
				'color_bg_highlight' => '',
				'color_txt_highlight' => '',
				'heading_font_family' => '',
				'heading_font_style' => '',
				'heading_font_size' => '',
				'heading_font_color' => '',
				'heading_line_height' => '',
				'subheading_font_family' => '',
				'subheading_font_style' => '',
				'subheading_font_size' => '',
				'subheading_font_color' => '',
				'subheading_line_height' => '',
				'features_font_family' => '',
				'features_font_style' => '',
				'features_font_size' => '',
				'features_font_color' => '',
				'features_line_height' => '',
				'button_font_family' => '',
				'button_font_style' => '',
				'button_font_size' => '',
				'button_font_color' => '',
				'button_line_height' => '',
				'el_class' => ''
			),$atts));
			$output = $link = $target = $featured = $featured_style = $normal_style = $dynamic_style = $box_icon = '';
			if($icon_type !== "none"){
				$box_icon = jscomposer::do_shortcode('[just_icon icon_type="'.$icon_type.'" icon="'.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width.'" icon_size="'.$icon_size.'" icon_color="'.$icon_color.'" icon_style="'.$icon_style.'" icon_color_bg="'.$icon_color_bg.'" icon_color_border="'.$icon_color_border.'"  icon_border_style="'.$icon_border_style.'" icon_border_size="'.$icon_border_size.'" icon_border_radius="'.$icon_border_radius.'" icon_border_spacing="'.$icon_border_spacing.'"]');
			}
			if($color_scheme == "custom"){
				if($color_bg_main !== ""){
					$normal_style .= 'background:'.$color_bg_main.';';
					$normal_style .= 'border-top-color:'.$color_bg_highlight.';';
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
			if($use_cta_btn == "box"){
				$output .= '<a href="'.$link.'" '.$target.' class="ult_price_action_button" style="'.$featured_style.'">'.$package_btn_text;
			}
			
			/* typography */
			
			$heading_style_inline = $sub_heading_inline = $features_inline = $button_inline = '';
			
			// heading
			if($heading_font_family != '')
			{
				$hdfont_family = get_ultimate_font_family($heading_font_family);
				$heading_style_inline .= 'font-family:\''.$hdfont_family.'\';';
			}
			
			$heading_style_inline .= get_ultimate_font_style($heading_font_style);
			
			if($heading_font_size != '')
				$heading_style_inline .= 'font-size:'.$heading_font_size.'px;';

			if($heading_font_color != '')
				$heading_style_inline .= 'color:'.$heading_font_color.';';

			if($heading_line_height != '')
				$heading_style_inline .= 'line-height:'.$heading_line_height.'px;';
				
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
				$heading_font_family, $subheading_font_family, $features_font_family, $button_font_family
			);
			enquque_ultimate_google_fonts($args);
			
			/* end typgoraphy */
			
			$output .= '<div class="ult_pricing_table_wrap ult_info_table ult_design_4 '.$featured.' ult-cs-'.$color_scheme.' '.$el_class.'">
						<div class="ult_pricing_table" style="'.$normal_style.'">';
				$output .= '<div class="ult_pricing_heading">
								<h3 style="'.$heading_style_inline.'">'.$package_heading.'</h3>';
							if($package_sub_heading !== ''){
								$output .= '<h5 style="'.$sub_heading_inline.'">'.$package_sub_heading.'</h5>';
							}
				$output .= '</div><!--ult_pricing_heading-->';
				if(isset($box_icon) && $box_icon != '') :
				$output .= '<div class="ult_price_body_block">
								<div class="ult_price_body">
									<div class="ult_price">
										'.$box_icon.'
									</div>
								</div>
							</div><!--ult_price_body_block-->';
				endif;
				$output .= '<div class="ult_price_features" style="'.$features_inline.'">
								'.wpb_js_remove_wpautop(jscomposer::do_shortcode($content), true).'
							</div><!--ult_price_features-->';
				if($use_cta_btn == "true"){
					$output .= '<div class="ult_price_link" style="'.$normal_style.'">
								<a href="'.$link.'" '.$target.' class="ult_price_action_button" style="'.$featured_style.' '.$button_inline.'">'.$package_btn_text.'</a>
							</div><!--ult_price_link-->';
				}
				$output .= '<div class="ult_clr"></div>
				</div><!--pricing_table-->
			</div><!--pricing_table_wrap-->';
			if($use_cta_btn == "box"){
				$output .= '</a>';
			}
			return $output;
		}
	}
}