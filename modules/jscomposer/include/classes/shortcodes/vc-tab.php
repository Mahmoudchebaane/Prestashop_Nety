<?php
define( 'TAB_TITLE', vc_manager()->l( "Tab") );
require_once vc_path_dir('SHORTCODES_DIR', 'vc-column.php');

class WPBakeryShortCode_VC_Tab extends WPBakeryShortCode_VC_Column {
	protected $controls_css_settings = 'tc vc_control-container';
	protected $controls_list = array('add', 'edit', 'clone', 'delete');
	protected $predefined_atts = array(
		'tab_id' => TAB_TITLE,
		'title' => ''
	);
	protected $controls_template_file = 'editors/partials/backend_controls_tab.tpl.php';
	public function __construct( $settings ) {
		parent::__construct( $settings );
	}

	public function customAdminBlockParams() {
		if(isset($this->atts)){
			return ' id="tab-' . $this->atts['tab_id'] . '"';
		}
		
	}

	public function mainHtmlBlockParams( $width, $i ) {
		return 'data-element_type="' . $this->settings["base"] . '" class="wpb_' . $this->settings['base'] . ' wpb_sortable wpb_content_holder"' . $this->customAdminBlockParams();
	}

	public function containerHtmlBlockParams( $width, $i ) {
		return 'class="wpb_column_container vc_container_for_children"';
	}

	public function getColumnControls( $controls, $extended_css = '' ) {
		return $this->getColumnControlsModular($extended_css);
	}
}


function tab_id_settings_field( $settings, $value ) {
	$dependency = vc_generate_dependencies_attributes( $settings );
	return '<div class="my_param_block">'
	  . '<input name="' . $settings['param_name']
	  . '" class="wpb_vc_param_value wpb-textinput '
	  . $settings['param_name'] . ' ' . $settings['type'] . '_field" type="hidden" value="'
	  . $value . '" ' . $dependency . ' />'
	  . '<label>' . $value . '</label>'
	  . '</div>';
	// TODO: Add data-js-function to documentation
}

add_shortcode_param( 'tab_id', 'tab_id_settings_field' );