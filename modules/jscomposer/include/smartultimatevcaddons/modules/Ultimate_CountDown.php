<?php

/*
 * Add-on Name: CountDown for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if ( ! class_exists( 'Ultimate_CountDown' ) ) {

	class Ultimate_CountDown {

		public $vcaddonsinstance, $context;

		function __construct() {
			$this->context = Context::getContext();

			$this->vcaddonsinstance = jscomposer::getInstance();
			// add_action('admin_init',array($this,'countdown_init'));
			JsComposer::add_shortcode( 'ult_countdown', array( &$this, 'countdown_shortcode' ) );

			
		}

		function count_down_styles() {

			$this->context->controller->addCSS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-css/countdown.min.css" );
		}

		function count_down_scripts() {
			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/jquery.countdown_org.min.js" );
			$this->context->controller->addJS( "{$this->vcaddonsinstance->_url_ultimate}assets/min-js/count-timer.min.js" );
		}

		function admin_scripts() {
			if ( jscomposer::condition() ) {
				jscomposer::$backoffice_scripts[] = "{$this->vcaddonsinstance->_url_ultimate}admin/js/bootstrap-datetimepicker.min.js";
				jscomposer::$backoffice_styles[]  = "{$this->vcaddonsinstance->_url_ultimate}admin/css/bootstrap-datetimepicker.min.css";
			}
		}

		function countdown_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Countdown' ),
						'base'        => 'ult_countdown',
						'class'       => 'vc_countdown',
						'icon'        => 'vc_countdown',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Countdown Timer.' ),
						'params'      => array(
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Countdown Timer Style' ),
								'param_name' => 'count_style',
								'value'      => array(
									$vc->l( 'Digit and Unit Side by Side' ) => 'ult-cd-s1',
									$vc->l( 'Digit and Unit Up and Down' ) => 'ult-cd-s2',
								),
								'group'      => 'General Settings',
							),
							array(
								'type'        => 'datetimepicker',
								'class'       => '',
								'heading'     => $vc->l( 'Target Time For Countdown' ),
								'param_name'  => 'datetime',
								'value'       => '',
								'description' => $vc->l( 'Date and time format (yyyy/mm/dd hh:mm:ss).' ),
								'group'       => 'General Settings',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Countdown Timer Depends on' ),
								'param_name' => 'ult_tz',
								'value'      => array(
									$vc->l( 'Prestashop Defined Timezone' ) => 'ult-wptz',
									$vc->l( "User's System Timezone" ) => 'ult-usrtz',
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'checkbox',
								'class'      => '',
								'heading'    => $vc->l( 'Select Time Units To Display In Countdown Timer' ),
								'param_name' => 'countdown_opts',
								'value'      => array(
									$vc->l( 'Years' )   => 'syear',
									$vc->l( 'Months' )  => 'smonth',
									$vc->l( 'Weeks' )   => 'sweek',
									$vc->l( 'Days' )    => 'sday',
									$vc->l( 'Hours' )   => 'shr',
									$vc->l( 'Minutes' ) => 'smin',
									$vc->l( 'Seconds' ) => 'ssec',
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Text Color' ),
								'param_name' => 'tick_col',
								'value'      => '',
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Text Size' ),
								'param_name' => 'tick_size',
								'suffix'     => 'px',
								'min'        => '0',
								'value'      => '36',
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Text Style' ),
								'param_name' => 'tick_style',
								'value'      => array(
									'Normal'        => '',
									'Bold'          => 'bold',
									'Italic'        => 'italic',
									'Bold & Italic' => 'boldnitalic',
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Unit Text Color' ),
								'param_name' => 'tick_sep_col',
								'value'      => '',
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Unit Text Size' ),
								'param_name' => 'tick_sep_size',
								'value'      => '13',
								'suffix'     => 'px',
								'min'        => '0',
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Unit Text Style' ),
								'param_name' => 'tick_sep_style',
								'value'      => array(
									'Normal'        => '',
									'Bold'          => 'bold',
									'Italic'        => 'italic',
									'Bold & Italic' => 'boldnitalic',
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Border Style' ),
								'param_name' => 'br_style',
								'value'      => array(
									'None'   => '',
									'Solid'  => 'solid',
									'Dashed' => 'dashed',
									'Dotted' => 'dotted',
									'Double' => 'double',
									'Inset'  => 'inset',
									'Outset' => 'outset',
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Border Size' ),
								'param_name' => 'br_size',
								'value'      => '',
								'min'        => '0',
								'suffix'     => 'px',
								'dependency' => array(
									'element' => 'br_style',
									'value'   => array( 'solid', 'dotted', 'dashed', 'double', 'inset', 'outset' ),
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Border Color' ),
								'param_name' => 'br_color',
								'value'      => '',
								'dependency' => array(
									'element' => 'br_style',
									'value'   => array( 'solid', 'dotted', 'dashed', 'double', 'inset', 'outset' ),
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Border Radius' ),
								'param_name' => 'br_radius',
								'value'      => '',
								'min'        => '0',
								'suffix'     => 'px',
								'dependency' => array(
									'element' => 'br_style',
									'value'   => array( 'solid', 'dotted', 'dashed', 'double', 'inset', 'outset' ),
								),
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Background Color' ),
								'param_name' => 'timer_bg_color',
								'value'      => '',
								'group'      => 'General Settings',
							),
							array(
								'type'       => 'number',
								'class'      => '',
								'heading'    => $vc->l( 'Timer Digit Background Size' ),
								'param_name' => 'br_time_space',
								'min'        => '0',
								'value'      => '0',
								'suffix'     => 'px',
								'group'      => 'General Settings',
							),
							array(
								'type'        => 'textfield',
								'class'       => '',
								'heading'     => $vc->l( 'Extra Class' ),
								'param_name'  => 'el_class',
								'value'       => '',
								'description' => $vc->l( 'Extra Class for the Wrapper.' ),
								'group'       => 'General Settings',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Day (Singular)' ),
								'param_name' => 'string_days',
								'value'      => 'Day',
								// "description" => $vc->l("Enter your string for day."),
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Days (Plural)' ),
								'param_name' => 'string_days2',
								'value'      => 'Days',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Week (Singular)' ),
								'param_name' => 'string_weeks',
								'value'      => 'Week',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Weeks (Plural)' ),
								'param_name' => 'string_weeks2',
								'value'      => 'Weeks',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Month (Singular)' ),
								'param_name' => 'string_months',
								'value'      => 'Month',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Months (Plural)' ),
								'param_name' => 'string_months2',
								'value'      => 'Months',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Year (Singular)' ),
								'param_name' => 'string_years',
								'value'      => 'Year',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Years (Plural)' ),
								'param_name' => 'string_years2',
								'value'      => 'Years',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Hour (Singular)' ),
								'param_name' => 'string_hours',
								'value'      => 'Hour',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Hours (Plural)' ),
								'param_name' => 'string_hours2',
								'value'      => 'Hours',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Minute (Singular)' ),
								'param_name' => 'string_minutes',
								'value'      => 'Minute',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Minutes (Plural)' ),
								'param_name' => 'string_minutes2',
								'value'      => 'Minutes',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Second (Singular)' ),
								'param_name' => 'string_seconds',
								'value'      => 'Second',
								'group'      => 'Strings Translation',
							),
							array(
								'type'       => 'textfield',
								'class'      => '',
								'heading'    => $vc->l( 'Seconds (Plural)' ),
								'param_name' => 'string_seconds2',
								'value'      => 'Seconds',
								'group'      => 'Strings Translation',
							),
							array(
								'type'             => 'heading',
								'param_name'       => 'notification',
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
								'group'            => 'General Settings',
							),
						),
					)
				);
			}
		}

		// Shortcode handler function for  icon block
		function countdown_shortcode( $atts ) {
			if ( $this->vcaddonsinstance->is_admin() ) {
				$this->admin_scripts();
			}
			$count_style    = $datetime = $ult_tz = $countdown_opts = $tick_col = $tick_size = $tick_style = $tick_sep_col = $tick_sep_size = '';
			$tick_sep_style = $br_color = $br_style = $br_size = $timer_bg_color = $br_radius = $br_time_space = $el_class = '';
			$string_days    = $string_weeks = $string_months = $string_years = $string_hours = $string_minutes = $string_seconds = '';
			$string_days2   = $string_weeks2 = $string_months2 = $string_years2 = $string_hours2 = $string_minutes2 = $string_seconds2 = '';
			extract(
				JsComposer::shortcode_atts(
					array(
						'count_style'     => '',
						'datetime'        => '',
						'ult_tz'          => 'ult-usrtz',
						'countdown_opts'  => '',
						'tick_col'        => '',
						'tick_size'       => '',
						'tick_style'      => '',
						'tick_sep_col'    => '',
						'tick_sep_size'   => '',
						'tick_sep_style'  => '',
						'br_color'        => '',
						'br_style'        => '',
						'br_size'         => '',
						'timer_bg_color'  => '',
						'br_radius'       => '',
						'br_time_space'   => '',
						'el_class'        => '',
						'string_days'     => 'Day',
						'string_days2'    => 'Days',
						'string_weeks'    => 'Week',
						'string_weeks2'   => 'Weeks',
						'string_months'   => 'Month',
						'string_months2'  => 'Months',
						'string_years'    => 'Year',
						'string_years2'   => 'Years',
						'string_hours'    => 'Hour',
						'string_hours2'   => 'Hours',
						'string_minutes'  => 'Minute',
						'string_minutes2' => 'Minutes',
						'string_seconds'  => 'Second',
						'string_seconds2' => 'Seconds',
					),
					$atts
				)
			);

			$this->count_down_scripts();
			$this->count_down_styles();

			$count_frmt    = $labels = '';
			$labels        = $string_years2 . ',' . $string_months2 . ',' . $string_weeks2 . ',' . $string_days2 . ',' . $string_hours2 . ',' . $string_minutes2 . ',' . $string_seconds2;
			$labels2       = $string_years . ',' . $string_months . ',' . $string_weeks . ',' . $string_days . ',' . $string_hours . ',' . $string_minutes . ',' . $string_seconds;
			$countdown_opt = explode( ',', $countdown_opts );
			if ( is_array( $countdown_opt ) ) {
				foreach ( $countdown_opt as $opt ) {
					if ( $opt == 'syear' ) {
						$count_frmt .= 'Y';
					}
					if ( $opt == 'smonth' ) {
						$count_frmt .= 'O';
					}
					if ( $opt == 'sweek' ) {
						$count_frmt .= 'W';
					}
					if ( $opt == 'sday' ) {
						$count_frmt .= 'D';
					}
					if ( $opt == 'shr' ) {
						$count_frmt .= 'H';
					}
					if ( $opt == 'smin' ) {
						$count_frmt .= 'M';
					}
					if ( $opt == 'ssec' ) {
						$count_frmt .= 'S';
					}
				}
			}
			$data_attr = '';
			if ( $count_frmt == '' ) {
				$count_frmt = 'DHMS';
			}
			if ( $br_size == '' || $br_color == '' || $br_style == '' ) {
				if ( $timer_bg_color == '' ) {
					$el_class .= ' ult-cd-no-border';
				}
			} else {
				$data_attr .= 'data-br-color="' . $br_color . '" data-br-style="' . $br_style . '" data-br-size="' . $br_size . '" ';
			}
			$data_attr .= ' data-tick-style="' . $tick_style . '" ';
			$data_attr .= ' data-tick-p-style="' . $tick_sep_style . '" ';
			$data_attr .= ' data-bg-color="' . $timer_bg_color . '" data-br-radius="' . $br_radius . '" data-padd="' . $br_time_space . '" ';
			$output     = '<div class="ult_countdown ' . $el_class . ' ' . $count_style . '">';
			if ( $datetime != '' ) {

				$output .= '<div class="ult_countdown-div ult_countdown-dateAndTime ' . $ult_tz . '" data-labels="' . $labels . '" data-labels2="' . $labels2 . '"  data-terminal-date="' . $datetime . '" data-countformat="' . $count_frmt . '" data-time-zone="0" data-time-now="' . date( 'Y-m-d H:i:s' ) . '" data-tick-size="' . $tick_size . '" data-tick-col="' . $tick_col . '" data-tick-p-size="' . $tick_sep_size . '" data-tick-p-col="' . $tick_sep_col . '" ' . $data_attr . '>' . $datetime . '</div>';
			}
			$output .= '</div>';
			return $output;
		}

	}

	// instantiate the class
	// $ult_countdown = new Ultimate_CountDown;
}
