<?php

/*
 * Add-on Name: Ultimate Google Maps
 * Add-on URI: https://www.brainstormforce.com
 */
if ( ! class_exists( 'Ultimate_Google_Maps' ) ) {

	class Ultimate_Google_Maps {



		public $vcaddonsinstance;
		private $context, $gmap_key;

		function __construct() {
			$this->vcaddonsinstance = jscomposer::getInstance();
			JsComposer::add_shortcode( 'ultimate_google_map', array( &$this, 'display_ultimate_map' ) );
			$this->context  = Context::getContext();
			$this->gmap_key = Configuration::get( 'ult_map_key' );
			if ( $this->vcaddonsinstance->is_admin() ) {
				$this->ultimate_google_map_script();
			}
		}

		function ultimate_google_map_script() {
			if ( $this->gmap_key ) {
				$addmapsjs = "https://maps.googleapis.com/maps/api/js?key={$this->gmap_key}&v=3.exp&sensor=false";
				$this->context->controller->addJS( $addmapsjs );
				return true;
			}
			return false;
		}

		function google_maps_init() {
			if ( function_exists( 'vc_map' ) ) {
				$vc = vc_manager();
				vc_map(
					array(
						'name'                    => $vc->l( 'Google Map' ),
						'base'                    => 'ultimate_google_map',
						'class'                   => 'vc_google_map',
						'controls'                => 'full',
						'show_settings_on_create' => true,
						'icon'                    => 'vc_google_map',
						'description'             => $vc->l( 'Display Google Maps to indicate your location.' ),
						'category'                => 'Ultimate VC Addons',
						'params'                  => array(
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Width (in %)' ),
								'param_name'  => 'width',
								'admin_label' => true,
								'value'       => '100%',
								'group'       => 'General Settings',
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Height (in px)' ),
								'param_name'  => 'height',
								'admin_label' => true,
								'value'       => '300px',
								'group'       => 'General Settings',
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Map type' ),
								'param_name'  => 'map_type',
								'admin_label' => true,
								'value'       => array(
									$vc->l( 'Roadmap' )   => 'ROADMAP',
									$vc->l( 'Satellite' ) => 'SATELLITE',
									$vc->l( 'Hybrid' )    => 'HYBRID',
									$vc->l( 'Terrain' )   => 'TERRAIN',
								),
								'group'       => 'General Settings',
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Latitude' ),
								'param_name'  => 'lat',
								'admin_label' => true,
								'value'       => '18.591212',
								'group'       => 'General Settings',
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Longitude' ),
								'param_name'  => 'lng',
								'admin_label' => true,
								'value'       => '73.741261',
								'group'       => 'General Settings',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => $vc->l( 'Map Zoom' ),
								'param_name' => 'zoom',
								'value'      => array(
									$vc->l( '18 - Default' ) => 12,
									1,
									2,
									3,
									4,
									5,
									6,
									7,
									8,
									9,
									10,
									11,
									13,
									14,
									15,
									16,
									17,
									18,
									19,
									20,
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'checkbox',
								'heading'    => '',
								'param_name' => 'scrollwheel',
								'value'      => array(
									$vc->l( 'Disable map zoom on mouse wheel scroll' ) => 'disable',
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'textarea_html',
								'class'      => '',
								'heading'    => $vc->l( 'Info Window Text' ),
								'param_name' => 'content',
								'value'      => '',
								'group'      => 'Info Window',
							),
							array(
								'type'        => 'ult_switch',
								'heading'     => $vc->l( 'Open on Marker Click' ),
								'param_name'  => 'infowindow_open',
								'options'     => array(
									'infowindow_open_value' => array(
										'label' => '',
										'on'    => $vc->l( 'Yes' ),
										'off'   => $vc->l( 'No' ),
									),
								),
								'value'       => 'infowindow_open_value',
								'default_set' => true,
								'group'       => 'Info Window',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Marker/Point icon' ),
								'param_name' => 'marker_icon',
								'value'      => array(
									$vc->l( 'Use Google Default' ) => 'default',
									$vc->l( "Use Plugin's Default" ) => 'default_self',
									$vc->l( 'Upload Custom' ) => 'custom',
								),
								'group'      => 'Marker',
							),
							array(
								'type'        => 'attach_image',
								'class'       => '',
								'heading'     => $vc->l( 'Upload Image Icon:' ),
								'param_name'  => 'icon_img',
								'admin_label' => true,
								'value'       => '',
								'description' => $vc->l( 'Upload the custom image icon.' ),
								'dependency'  => array(
									'element' => 'marker_icon',
									'value'   => array( 'custom' ),
								),
								'group'       => 'Marker',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Street view control' ),
								'param_name' => 'streetviewcontrol',
								'value'      => array(
									$vc->l( 'Disable' ) => 'false',
									$vc->l( 'Enable' )  => 'true',
								),
								'group'      => 'Advanced',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Map type control' ),
								'param_name' => 'maptypecontrol',
								'value'      => array(
									$vc->l( 'Disable' ) => 'false',
									$vc->l( 'Enable' )  => 'true',
								),
								'group'      => 'Advanced',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Map pan control' ),
								'param_name' => 'pancontrol',
								'value'      => array(
									$vc->l( 'Disable' ) => 'false',
									$vc->l( 'Enable' )  => 'true',
								),
								'group'      => 'Advanced',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Zoom control' ),
								'param_name' => 'zoomcontrol',
								'value'      => array(
									$vc->l( 'Disable' ) => 'false',
									$vc->l( 'Enable' )  => 'true',
								),
								'group'      => 'Advanced',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Zoom control size' ),
								'param_name' => 'zoomcontrolsize',
								'value'      => array(
									$vc->l( 'Small' ) => 'SMALL',
									$vc->l( 'Large' ) => 'LARGE',
								),
								'dependency' => array(
									'element' => 'zoomControl',
									'value'   => array( 'true' ),
								),
								'group'      => 'Advanced',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Top margin' ),
								'param_name' => 'top_margin',
								'value'      => array(
									$vc->l( 'Page (small)' ) => 'page_margin_top',
									$vc->l( 'Section (large)' ) => 'page_margin_top_section',
									$vc->l( 'None' ) => 'none',
								),
								'group'      => 'General Settings',
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Map Width Override' ),
								'param_name'  => 'map_override',
								'value'       => array(
									'Default Width'      => '0',
									"Apply 1st parent element's width" => '1',
									"Apply 2nd parent element's width" => '2',
									"Apply 3rd parent element's width" => '3',
									"Apply 4th parent element's width" => '4',
									"Apply 5th parent element's width" => '5',
									"Apply 6th parent element's width" => '6',
									"Apply 7th parent element's width" => '7',
									"Apply 8th parent element's width" => '8',
									"Apply 9th parent element's width" => '9',
									'Full Width '        => 'full',
									'Maximum Full Width' => 'ex-full',
								),
								'group'       => 'General Settings',
							),
							array(
								'type'        => 'textarea_raw_html',
								'class'       => '',
								'heading'     => $vc->l( 'Google Styled Map JSON' ),
								'param_name'  => 'map_style',
								'value'       => '',
								'group'       => 'Styling',
							),
							array(
								'type'        => 'textfield',
								'heading'     => $vc->l( 'Extra class name' ),
								'param_name'  => 'el_class',
								'group'       => 'General Settings',
							),
							array(
								'type'             => 'ult_param_heading',
								'param_name'       => 'notification',
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
								'group'            => 'General Settings',
							),
						),
					)
				);
			}
		}

		function display_ultimate_map( $atts, $content = null ) {

			if ( ! $this->ultimate_google_map_script() ) {
				return;
			}
			$width = $height = $map_type = $lat = $lng = $zoom = $streetviewcontrol = $maptypecontrol = $top_margin = $pancontrol = $zoomcontrol = $zoomcontrolsize = $marker_icon = $icon_img = $map_override = $output = $map_style = $scrollwheel = $el_class = '';
			extract(
				JsComposer::shortcode_atts(
					array(
						// "id" => "map",
						'width'             => '100%',
						'height'            => '300px',
						'map_type'          => 'ROADMAP',
						'lat'               => '18.591212',
						'lng'               => '73.741261',
						'zoom'              => '14',
						'scrollwheel'       => '',
						'streetviewcontrol' => '',
						'maptypecontrol'    => '',
						'pancontrol'        => '',
						'zoomcontrol'       => '',
						'zoomcontrolsize'   => '',
						'marker_icon'       => '',
						'icon_img'          => '',
						'top_margin'        => 'page_margin_top',
						'map_override'      => '0',
						'map_style'         => '',
						'el_class'          => '',
						'infowindow_open'   => '',
						'map_vc_template'   => '',
					),
					$atts
				)
			);
			$marker_lat = $lat;
			$marker_lng = $lng;
			if ( $marker_icon == 'default_self' ) {
					  $icon_url = jscomposer::plugins_url( 'assets/img/icon-marker-pink.png' );
					  echo $icon_url;
			} elseif ( $marker_icon == 'default' ) {
				$icon_url = '';
			} else {
				// $icon_url = JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($icon_img);
				// $icon_url = Tools::getHttpHost(true).$icon_url;
				$icon_url = JsComposer::getFullImageUrl( $icon_img );
			}
			$id         = 'map_' . uniqid();
			$wrap_id    = 'wrap_' . $id;
			$map_type   = strtoupper( $map_type );
			$width      = ( substr( $width, -1 ) != '%' && substr( $width, -2 ) != 'px' ? $width . 'px' : $width );
			$map_height = ( substr( $height, -1 ) != '%' && substr( $height, -2 ) != 'px' ? $height . 'px' : $height );

			$margin_css = '';
			if ( $top_margin != 'none' ) {
				$margin_css = $top_margin;
			}

			if ( $map_vc_template == 'map_vc_template_value' ) {
				$el_class .= 'uvc-boxed-layout';
			}

			$output .= "<div id='" . $wrap_id . "' class='ultimate-map-wrapper " . $el_class . "' style='" . ( $map_height != '' ? 'height:' . $map_height . ';' : '' ) . "'><div id='" . $id . "' data-map_override='" . $map_override . "' class='ultimate_google_map wpb_content_element " . $margin_css . "'" . ( $width != '' || $map_height != '' ? " style='" . ( $width != '' ? 'width:' . $width . ';' : '' ) . ( $map_height != '' ? 'height:' . $map_height . ';' : '' ) . "'" : '' ) . '></div></div>';
			if ( $scrollwheel == 'disable' ) {
				$scrollwheel = 'false';
			} else {
				$scrollwheel = 'true';
			}
			$output .= "<script type='text/javascript'>
			(function($) {
  			'use strict';
			var map_$id = null;
			var coordinate_$id;
			try
			{			
				var map_$id = null;
				var coordinate_$id;
				coordinate_$id=new google.maps.LatLng($lat, $lng);
				var mapOptions= 
				{
					zoom: $zoom,
					center: coordinate_$id,
					scaleControl: true,
					streetViewControl: $streetviewcontrol,
					mapTypeControl: $maptypecontrol,
					panControl: $pancontrol,
					zoomControl: $zoomcontrol,
					scrollwheel: $scrollwheel,
					zoomControlOptions: {
					  style: google.maps.ZoomControlStyle.$zoomcontrolsize
					},";
			if ( $map_style == '' ) {
				$output .= "mapTypeId: google.maps.MapTypeId.$map_type,";
			} else {
				$output .= " mapTypeControlOptions: {
					  		mapTypeIds: [google.maps.MapTypeId.$map_type, 'map_style']
						}";
			}
			$output .= '};';
			if ( $map_style !== '' ) {
				$output .= 'var styles = ' . rawurldecode( base64_decode( strip_tags( $map_style ) ) ) . ';
						var styledMap = new google.maps.StyledMapType(styles,
					    	{name: "Styled Map"});';
			}
			$output .= "var map_$id = new google.maps.Map(document.getElementById('$id'),mapOptions);";
			if ( $map_style !== '' ) {
				$output .= "map_$id.mapTypes.set('map_style', styledMap);
 							 map_$id.setMapTypeId('map_style');";
			}
			if ( $marker_lat != '' && $marker_lng != '' ) {
				$output .= "var marker_$id = new google.maps.Marker({
						position: new google.maps.LatLng($marker_lat, $marker_lng),
						animation:  google.maps.Animation.DROP,
						map: map_$id,
						icon: '" . $icon_url . "'
					});
					google.maps.event.addListener(marker_$id, 'click', toggleBounce);";
				if ( $content !== '' ) {
					$output .= "var infowindow = new google.maps.InfoWindow();
							infowindow.setContent('<div class=\"map_info_text\" style=\'color:#000;\'>" . trim( preg_replace( '/\s+/', ' ', JsComposer::do_shortcode( $content ) ) ) . "</div>');";

					if ( $infowindow_open == 'off' ) {
						$output .= "infowindow.open(map_$id,marker_$id);";
					}

					$output .= "google.maps.event.addListener(marker_$id, 'click', function() {
								infowindow.open(map_$id,marker_$id);
						  	});";
				}
			}
			$output .= "}
			catch(e){};
			jQuery(document).ready(function($){
				google.maps.event.trigger(map_$id, 'resize');
				$(window).resize(function(){
					google.maps.event.trigger(map_$id, 'resize');
					if(map_$id!=null)
						map_$id.setCenter(coordinate_$id);
				});
				$('.ui-tabs').bind('tabsactivate', function(event, ui) {
				   if($(this).find('.ultimate-map-wrapper').length > 0)
					{
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					}
				});
				$('.ui-accordion').bind('accordionactivate', function(event, ui) {
				   if($(this).find('.ultimate-map-wrapper').length > 0)
					{
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					}
				});
				$(window).load(function(){
					setTimeout(function(){
						$(window).trigger('resize');
					},200);
				});
				$('.ult_exp_section').select(function(){
					if($(map_$id).parents('.ult_exp_section'))
					{
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					}
				});
				$(document).on('onUVCModalPopupOpen', function(){
					if($(map_$id).parents('.ult_modal-content'))
					{
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					}	
				});
				$(document).on('click','.ult_tab_li',function(){
					$(window).trigger('resize');
					setTimeout(function(){
						$(window).trigger('resize');
					},200);
				});
			});
			function toggleBounce() {
			  if (marker_$id.getAnimation() != null) {
				marker_$id.setAnimation(null);
			  } else {
				marker_$id.setAnimation(google.maps.Animation.BOUNCE);
			  }
			}
			})(jQuery);
			</script>";
			return $output;
		}

	}

	new Ultimate_Google_Maps();
	if ( class_exists( 'WPBakeryShortCode' ) ) {

		class WPBakeryShortCode_ultimate_google_map extends WPBakeryShortCode {




		}

	}
}
