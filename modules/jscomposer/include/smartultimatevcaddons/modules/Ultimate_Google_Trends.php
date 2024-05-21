<?php
/*
* Add-on Name: Ultimate Google Trends
* Add-on URI: https://www.brainstormforce.com
*/
if(!class_exists("Ultimate_Google_Trends")){
	class Ultimate_Google_Trends{
		 function __construct(){
		 	//add_action("admin_init",array($this,"google_trends_init"));
		 	JsComposer::add_shortcode("ultimate_google_trends",array(&$this,"display_ultimate_trends"));
		}
		function google_trends_init(){
			$vc = vc_manager();
			if ( function_exists('vc_map'))
			{
				vc_map( array(
					"name" => $vc->l("Google Trends"),
					"base" => "ultimate_google_trends",
					"class" => "vc_google_trends",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "vc_google_trends",
					"description" => $vc->l("Display Google Trends to show insights."),
					"category" => $vc->l("Ultimate VC Addons"),
					"params" => array(
						array(
							"type" => "textarea",
							"class" => "",
							"heading" => $vc->l("Comparison Terms"),
							"param_name" => "gtrend_query",
							"value" => "",
							"dependency" => Array("element" => "search_by","value" => array("q")),				
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => $vc->l("Location"),
							"param_name" => "location_by",
							"admin_label" => true,
							"value" => array(
								$vc->l("Worldwide") => "", 
								$vc->l("Argentina") => "", 
								$vc->l("Australia") => "",
								$vc->l("Austria") => "", 
								$vc->l("Bangladesh") => "",
								$vc->l("Belgium") => "", 
								$vc->l("Brazil") => "",
								$vc->l("Bulgaria") => "", 
								$vc->l("Canada") => "",
								$vc->l("Chile") => "", 
								$vc->l("China") => "",
								$vc->l("Colombia") => "", 
								$vc->l("Costa Rica") => "",
								$vc->l("Croatia") => "", 
								$vc->l("Czech Republic") => "",
								$vc->l("Denmark") => "", 
								$vc->l("Dominican Republic") => "",
								$vc->l("Ecuador") => "", 
								$vc->l("Egypt") => "",
								$vc->l("El Salvador") => "", 
								$vc->l("Estonia") => "",
								$vc->l("Finland") => "", 
								$vc->l("France") => "",
								$vc->l("Germany") => "", 
								$vc->l("Ghana") => "",
								$vc->l("Guatemala") => "", 
								$vc->l("Honduras") => "",
								$vc->l("Hong Kong") => "", 
								$vc->l("Hungary") => "",
								$vc->l("India") => "IN", 
								$vc->l("Indonesia") => "", 
								$vc->l("Ireland") => "",
								$vc->l("Israel") => "", 
								$vc->l("Italy") => "",
								$vc->l("Japan") => "", 
								$vc->l("Kenya") => "",
								$vc->l("Latvia") => "", 
								$vc->l("Lithuania") => "",
								$vc->l("Malaysia") => "", 
								$vc->l("Mexico") => "",
								$vc->l("Netherlands") => "", 
								$vc->l("New Zealand") => "",
								$vc->l("Nigeria") => "", 
								$vc->l("Norway") => "",
								$vc->l("Pakistan") => "", 
								$vc->l("Panama") => "",
								$vc->l("Peru") => "", 
								$vc->l("Philippines") => "",
								$vc->l("Poland") => "", 
								$vc->l("Portugal") => "",
								$vc->l("Puerto Rico") => "", 
								$vc->l("Romania") => "",
								$vc->l("Russia") => "", 
								$vc->l("Saudi Arabia") => "",
								$vc->l("Senegal") => "", 
								$vc->l("Serbia") => "",
								$vc->l("Singapore") => "", 
								$vc->l("Slovakia") => "",
								$vc->l("Slovenia") => "", 
								$vc->l("South Africa") => "",
								$vc->l("South Korea") => "", 
								$vc->l("Spain") => "",
								$vc->l("Sweden") => "", 
								$vc->l("Switzerland") => "",
								$vc->l("Taiwan") => "", 
								$vc->l("Thailand") => "",
								$vc->l("Turkey") => "", 
								$vc->l("Uganda") => "",
								$vc->l("Ukraine") => "", 
								$vc->l("United Arab Emirates") => "",
								$vc->l("United Kingdom") => "", 
								$vc->l("United States") => "",
								$vc->l("Uruguay") => "",
								$vc->l("Venezuela") => "",
								$vc->l("Vietnam") => "",
							)
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => $vc->l("Graph type"),
							"param_name" => "graph_type",
							"admin_label" => true,
							"value" => array($vc->l("Interest over time") => "TIMESERIES_GRAPH_0", $vc->l("Interest over time with average") => "TIMESERIES_GRAPH_AVERAGES_CHART", $vc->l("Regional interest in map") => "GEO_MAP_0_0", $vc->l("Regional interest in table") => "GEO_TABLE_0_0", $vc->l("Related searches (Topics)") => "TOP_ENTITIES_0_0", $vc->l("Related searches (Queries)") => "TOP_QUERIES_0_0"),
							"dependency" => Array("element" => "search_by","value" => array("q"))
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => $vc->l("Frame Width (optional)"),
							"param_name" => "gtrend_width",
							"value" => "",
							"description" => $vc->l("For Example: <em>500</em>")
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => $vc->l("Frame Height (optional)"),
							"param_name" => "gtrend_height",
							"value" => "",
							"description" => $vc->l("For Example: <em>350</em>")
						),
						array(
								"type" => "textfield",
								"heading" => $vc->l("Extra class name", "js_composer"),
								"param_name" => "el_class",
								"description" => $vc->l("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
						),
						array(
							"type" => "heading",
							"sub_heading" => "<span style='display: block;'><a href='http://bsf.io/skwuz' target='_blank'>Watch Video Tutorial &nbsp; <span class='icon icon-youtube-play' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
							"param_name" => "notification",
							'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
						),
					)
				));
			}
		}
		function display_ultimate_trends($atts,$content = null){

			$width = $height = $graph_type = $graph_type_2 = $search_by = $location_by = $gtrend_query = $gtrend_query_2 = $el_class = '';
			extract(JsComposer::shortcode_atts(array(
				//"id" => "map",
				"gtrend_width" => "",
				"gtrend_height" => "",
				"graph_type" => "TIMESERIES_GRAPH_0",
				"graph_type_2" => "",
				"search_by" => "q",
				"location_by" => "",
				"gtrend_query" => "",
				"gtrend_query_2" => "",
				"el_class" => ""
			), $atts));
			if($search_by === 'q')
			{
				$graph_type_new = $graph_type;
				$gtrend_query_new = $gtrend_query;
			}
			else
			{
				$graph_type_new = $graph_type_2;
				$gtrend_query_new = $gtrend_query_2;
			}
			if($gtrend_width != '')
			{
				$width = $gtrend_width;
				$width = '&amp;w='.$width;
			}
			if($gtrend_height != '')
			{
				$height = $gtrend_height;
				$height = '&amp;h='.$height;
			}
			$id = uniqid('vc-trends-');
			$output = '<div id="'.$id.'" class="ultimate-google-trends '.$el_class.'">
				<script type="text/javascript" src="//www.google.com/trends/embed.js?hl=en-US&amp;q='.$gtrend_query_new.'&cmpt='.$search_by.'&amp;geo='.$location_by.'&amp;content=1&amp;cid='.$graph_type_new.'&amp;export=5'.$width.$height.'"></script>
			</div>';
			return $output;
		}
	}
	// new Ultimate_Google_Trends;
}