<?php

/*
 * Add-on Name: Swatch Book for Visual Composer
 * Add-on URI: http://.brainstormforce.com/demos/ultimate/swatch-book
 */
if ( ! class_exists( 'Ultimate_Revslidersix' ) ) {

	class Ultimate_Revslidersix {
		var $swatch_trans_bg_img;
		var $swatch_width;
		var $swatch_height;
		public $vcaddonsinstance, $context;

		function __construct() {
			$this->vcaddonsinstance = jscomposer::getInstance();
			$this->context          = Context::getContext();
			JsComposer::add_shortcode( 'ultimate_revslidersix', array( &$this, 'ultimate_revsix_content' ) );
		}

		function ulti_get_revsliders() {
			if ( \Module::isInstalled( 'revsliderprestashop' ) && \Module::isEnabled( 'revsliderprestashop' ) ) {

				$db         = \Db::getInstance();
				$getsliderq = 'SELECT * FROM ' . _DB_PREFIX_ . 'revslider_sliders';
				$sliders    = $db->executeS( $getsliderq );

				$slider_lists = array();

				if ( isset( $sliders ) && is_array( $sliders ) ) {
					foreach ( $sliders as $slider ) {
						if ( $slider['type'] != 'template' ) {
							   $slider_lists[ $slider['alias'] ] = $slider['alias'];
						}
					}
				}

				return $slider_lists;
			}
		}

		function ulti_revsix_init() {
			$vc = vc_manager();
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'                    => $vc->l( 'Slider Revolution 6 Sliders' ),
						'base'                    => 'ultimate_revslidersix',
						'class'                   => 'vc_ultimate_revslidersix',
						'icon'                    => 'vc_ultimate_revslidersix',
						'category'                => $vc->l( 'Ultimate VC Addons' ),
						'content_element'         => true,
						'show_settings_on_create' => true,
						'content_element'         => true,
						'params'                  => array(
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => $vc->l( 'Select Sliders' ),
								'param_name'  => 'revsix_sliders',
								'value'       => $this->ulti_get_revsliders(),
								'description' => $vc->l( '' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => $vc->l( 'Extra class name' ),
								'param_name'  => 'el_class',
							),
						),
					)
				);
			}
		}

		function ultimate_revsix_content( $atts, $content = null ) {
			$revsix_sliders = '';
			extract(
				JsComposer::shortcode_atts(
					array(
						'revsix_sliders' => '',
					),
					$atts
				)
			);
			if ( \Module::isInstalled( 'revsliderprestashop' ) && \Module::isEnabled( 'revsliderprestashop' ) ) {
				if ( class_exists( 'RevSliderFront' ) ) {

					$select_slider = $revsix_sliders;

					$rev_slider_front = new \RevSliderFront();
					\RevLoader::loadAllAddons();
					$content_sliders = '';

					ob_start();
					\RevLoader::do_action( 'wp_head' );
					\RevLoader::do_action( 'wp_enqueue_scripts' );
					\RevLoader::rev_front_print_styles();

					\RevLoader::rev_front_print_head_scripts();

					\RevLoader::do_action( 'revslider_slider_init_by_data_post', array() );
					$output = new \RevSliderOutput();

					$output->add_slider_to_stage( $select_slider );
					\RevLoader::do_action( 'wp_footer' );
					\RevLoader::rev_front_print_footer_scripts();

					$content_sliders = ob_get_contents();

					ob_get_clean();
					return $content_sliders;
				}
			}

		}
	}
}
