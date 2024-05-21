<?php

/*
 * Add-on Name: Adjustable Spacer for Visual Composer
 * Add-on URI: http://dev.brainstormforce.com
 */
if ( ! class_exists( 'Ultimate_Spacer' ) ) {

	class Ultimate_Spacer {

		public $vcaddonsinstance, $context;

		function __construct() {
			$this->vcaddonsinstance = jscomposer::getInstance();
			$this->context          = Context::getContext();

			// add_action("admin_init",array($this,"ultimate_spacer_init"));
			JsComposer::add_shortcode( 'ultimate_spacer', array( $this, 'ultimate_spacer_shortcode' ) );
		}

		function ultimate_spacer_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'        => $vc->l( 'Spacer / Gap' ),
						'base'        => 'ultimate_spacer',
						'class'       => 'vc_ultimate_spacer',
						'icon'        => 'vc_ultimate_spacer',
						'category'    => $vc->l( 'Ultimate VC Addons' ),
						'description' => $vc->l( 'Adjust space between components.' ),
						'params'      => array(
							array(
								'type'        => 'number',
								'class'       => '',
								'heading'     => $vc->l( "<i class='icon icon-desktop'></i> Desktop" ),
								'param_name'  => 'height',
								'admin_label' => true,
								'value'       => 10,
								'min'         => 1,
								'max'         => 500,
								'suffix'      => 'px',
								'description' => $vc->l( 'Enter value in pixels' ),
							),
							array(
								'type'             => 'number',
								'class'            => '',
								'heading'          => $vc->l( "<i class='icon icon-tablet' style='transform: rotate(90deg);'></i> Tabs" ),
								'param_name'       => 'height_on_tabs',
								'admin_label'      => true,
								'value'            => '',
								'min'              => 1,
								'max'              => 500,
								'suffix'           => 'px',
								// "description" => $vc->l("Enter value in pixels"),
								'edit_field_class' => 'vc_col-sm-3 vc_column',
							),
							array(
								'type'             => 'number',
								'class'            => '',
								'heading'          => $vc->l( "<i class='icon icon-tablet'></i> Tabs" ),
								'param_name'       => 'height_on_tabs_portrait',
								'admin_label'      => true,
								'value'            => '',
								'min'              => 1,
								'max'              => 500,
								'suffix'           => 'px',
								// "description" => __("Enter value in pixels", "ultimate_vc"),
								'edit_field_class' => 'vc_col-sm-3 vc_column',
							),
							array(
								'type'             => 'number',
								'class'            => '',
								'heading'          => $vc->l( "<i class='icon icon-mobile' style='transform: rotate(90deg);'></i> Mobile" ),
								'param_name'       => 'height_on_mob_landscape',
								'admin_label'      => true,
								'value'            => '',
								'min'              => 1,
								'max'              => 500,
								'suffix'           => 'px',
								// "description" => __("Enter value in pixels", "ultimate_vc"),
								'edit_field_class' => 'vc_col-sm-3 vc_column',
							),
							array(
								'type'             => 'number',
								'class'            => '',
								'heading'          => $vc->l( "<i class='icon icon-mobile'></i> Mobile" ),
								'param_name'       => 'height_on_mob',
								'admin_label'      => true,
								'value'            => '',
								'min'              => 1,
								'max'              => 500,
								'suffix'           => 'px',
								// "description" => $vc->l("Enter value in pixels"),
								'edit_field_class' => 'vc_col-sm-3 vc_column',
							),
						),
					)
				);
			}
		}

		function ultimate_spacer_shortcode( $atts ) {
			// wp_enqueue_script('ultimate-custom');
			$this->context->controller->addJS( $this->vcaddonsinstance->_url_ultimate . 'assets/min-js/custom.min.js' );
			$height = $output = $height_on_tabs = $height_on_mob = '';
			extract(
				JsComposer::shortcode_atts(
					array(
						'height'         => '',
						'height_on_tabs' => '',
						'height_on_mob'  => '',
					),
					$atts
				)
			);
			if ( $height_on_mob == '' && $height_on_tabs == '' ) {
				$height_on_mob = $height_on_tabs = $height;
			}
			$style   = 'clear:both;';
			$style  .= 'display:block;';
			$uid     = uniqid();
			$output .= '<div class="ult-spacer spacer-' . $uid . '" data-id="' . $uid . '" data-height="' . $height . '" data-height-mobile="' . $height_on_mob . '" data-height-tab="' . $height_on_tabs . '" style="' . $style . '"></div>';
			return $output;
		}

	}

	// end class
	// new Ultimate_Spacer;
}
