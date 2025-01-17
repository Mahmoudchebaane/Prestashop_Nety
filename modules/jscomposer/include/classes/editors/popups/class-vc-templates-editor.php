<?php

/**
 * The templates manager for VC.
 *
 * The templates manager provides ability to copy and reuse existing pages. Save templates for later use.
 *
 * @since 4.2
 */
class Vc_Templates_Editor {

	protected $option_name       = 'wpb_js_templates';
	protected $default_templates = false;
	protected $_action_index     = array();
	/**
	 * Add ajax hooks.
	 */
	public function init() {
		// add_action( 'wp_ajax_wpb_save_template', array( &$this, 'save' ) );
		// add_action( 'wp_ajax_vc_backend_template', array( &$this, 'load' ) );
		// add_action( 'wp_ajax_vc_frontend_template', array( &$this, 'renderFrontendTemplate' ) );
		// add_action( 'wp_ajax_wpb_load_template_shortcodes', array( &$this, 'loadTemplateShortcodes' ) );
		// add_action( 'wp_ajax_wpb_load_default_template_shortcodes', array( &$this, 'getDefaultTemplate' ) );
		// add_action( 'wp_ajax_vc_frontend_default_template', array( &$this, 'renderFrontendDefaultTemplate' ) );
		// add_action( 'wp_ajax_vc_backend_default_template', array( &$this, 'getBackendDefaultTemplate' ) );
		// add_action( 'wp_ajax_wpb_delete_template', array( &$this, 'delete' ) );

		$this->_action_index = array(
			'wpb_save_template'                        => array( &$this, 'save' ),
			'vc_backend_template'                      => array( &$this, 'load' ),
			// 'vc_frontend_template' => array( &$this, 'renderFrontendTemplate' ) ,
						'wpb_load_template_shortcodes' => array( &$this, 'loadTemplateShortcodes' ),
			// 'vc_frontend_default_template' => array( &$this, 'renderFrontendDefaultTemplate' ) ,
						'vc_backend_default_template'  => array( &$this, 'getBackendDefaultTemplate' ),
			'wpb_delete_template'                      => array( &$this, 'delete' ),
		);
				$action = Tools::getValue( 'action' );

				JsComposer::$sds_action_hooks['vc_frontend_template']         = array( &$this, 'renderFrontendTemplate' );
				JsComposer::$sds_action_hooks['vc_frontend_default_template'] = array( &$this, 'renderFrontendDefaultTemplate' );

		if ( isset( $this->_action_index[ $action ] ) ) {

			call_user_func( $this->_action_index[ $action ] );
		}

	}

	function renderFrontendTemplate() {

		$this->template_id = vc_post_param( 'template_id' );
		if ( empty( $this->template_id ) ) {
			die();
		}
		$option_name = 'wpb_js_templates';
		// $saved_templates = get_option( $option_name );

				$saved_templates = Tools::jsonDecode( Configuration::get( $option_name ), true );

		vc_frontend_editor()->setTemplateContent( $saved_templates[ $this->template_id ]['template'] );
		// vc_frontend_editor()->enqueueRequired();
		vc_include_template(
			'editors/frontend_template.tpl.php',
			array(
				'editor' => vc_frontend_editor(),
			)
		);
		// var_dump(__LINE__);
		die();
	}
	public function save() {
				$editor = vc_manager();
		$template_name  = $editor->vc_post_param( 'template_name' );
		$template       = vc_post_param( 'template' );
		if ( ! isset( $template_name ) || trim( $template_name ) == '' || ! isset( $template ) || trim( $template ) == '' ) {
			echo 'Error: TPL-01';
			die();
		}

				$template = urlencode( $template );

		$template_arr = array(
			'name'     => stripslashes( $template_name ),
			'template' => $template,
		);

		$saved_templates = Tools::jsonDecode( Configuration::get( $this->option_name ), true );

		$template_id = Tools::safeOutput( $template_name, true ) . '_' . rand();

		if ( $saved_templates === false ) {

			$new_template                 = array();
			$new_template[ $template_id ] = $template_arr;
			Configuration::updateValue( $this->option_name, Tools::jsonEncode( $new_template ) );
		} else {
			$saved_templates[ $template_id ] = $template_arr;
			Configuration::updateValue( $this->option_name, Tools::jsonEncode( $saved_templates ) );
		}
		$this->renderMenu( true );
		die();
	}

	public function load() {
				$editor = vc_manager();
		$template_id    = $editor->vc_post_param( 'template_id' );

		if ( ! isset( $template_id ) || $template_id == '' ) {
			echo 'Error: TPL-02';
			die();
		}

		$saved_templates = Tools::jsonDecode( Configuration::get( $this->option_name ), true );

		$content = trim( urldecode( $saved_templates[ $template_id ]['template'] ) );
		// $content = str_ireplace('\"', '"', $content);

		// $pattern = $editor->get_shortcode_regex();
		// $content = preg_replace_callback( "/{$pattern}/s", 'vc_convert_shortcode', $content );
		echo $content;
		// echo do_shortcode( $content );

		die();
	}

	public function loadInline() {
		echo $this->renderMenu();
		die();
	}

	public function loadTemplateShortcodes() {
				$editor = vc_manager();
		$template_id    = $editor->vc_post_param( 'template_id' );

		if ( ! isset( $template_id ) || $template_id == '' ) {
			echo 'Error: TPL-02';
			die();
		}

		$saved_templates = Tools::jsonDecode( Configuration::get( $this->option_name ), true );

		$content = trim( urldecode( $saved_templates[ $template_id ]['template'] ) );
		// echo $content;
		$pattern = $editor->get_shortcode_regex();
		$content = preg_replace_callback( "/{$pattern}/s", 'vc_convert_shortcode', $content );
		echo $content;
		die();
	}

	/**
	 * Add custom template to default templates list ( at end of list )
	 * $data = array( 'name'=>'', 'image'=>'', 'content'=>'' )
	 *
	 * @param $data
	 *
	 * @return boolean true if added, false if failed
	 */
	public function addDefaultTemplates( $data ) {
		if ( is_array( $data ) && ! empty( $data ) && isset( $data['name'], $data['content'] ) ) {
			$this->default_templates[] = $data;

			return $this->default_templates;
		}

		return false;
	}

	/**
	 * Load default templates list and initialize variable
	 * To modify you should use add_filter('vc_load_default_templates','your_custom_function');
	 * Argument is array of templates data like:
	 *      array(
	 *          array(
	 *              'name'=>__('My custom template','my_plugin'),
	 *              'image_path'=> preg_replace( '/\s/', '%20', plugins_url( 'images/my_image.png', __FILE__ ) ), // always use preg replace to be sure that "space" will not break logic
	 *              'custom_class'=>'my_custom_class', // if needed
	 *              'content'=>'[my_shortcode]yeah[/my_shortcode]', // Use HEREDoc better to escape all single-quotes and double quotes
	 *          ),
	 *          ...
	 *      );
	 * Also see filters 'vc_load_default_templates_panels' and 'vc_load_default_templates_welcome_block' to modify templates in panels tab and/or in welcome block.
	 *
	 * @return array
	 */
	public function loadDefaultTemplates() {
		if ( ! is_array( $this->default_templates ) ) {

			include_once vc_path_dir( 'CONFIG_DIR', 'templates.php' );
			// $templates               =  $this->default_templates ;
			// $this->default_templates = $templates;
			// do_action( 'vc_load_default_templates_action' );

		}
		return $this->default_templates;
	}

	/**
	 * Get default template data by template index in array.
	 *
	 * @param number $template_index
	 *
	 * @return array|bool
	 */
	public function getDefaultTemplate( $template_index ) {
		$this->loadDefaultTemplates();
		if ( ! isset( $template_index ) || $template_index == '' || ! is_numeric( $template_index ) || ! is_array( $this->default_templates ) || ! isset( $this->default_templates[ $template_index ] ) ) {
			return false;
		}

		return $this->default_templates[ $template_index ];
	}

	/**
	 * Load default template content by index from ajax
	 *
	 * @param bool $return | should function return data or not
	 */
	public function getBackendDefaultTemplate( $return = false ) {
			$editor = vc_manager();
		// $template_index = $editor->vc_post_param( 'template_name' );
			$template_index = Tools::getValue( 'template_name' );

			$data = $this->getDefaultTemplate( $template_index );

		if ( ! $data ) {
				echo 'Error: TPL-02';
				die();
		}
		if ( $return ) {
				return trim( $data['content'] );
		} else {
				echo trim( $data['content'] );
				die();
		}
	}


	public function delete() {
		$template_id = Tools::getValue( 'template_id' );

		if ( ! isset( $template_id ) || $template_id == '' ) {
			echo 'Error: TPL-03';
			die();
		}
				$saved_templates = Tools::jsonDecode( Configuration::get( $this->option_name ), true );

		// $saved_templates = get_option( $this->option_name );
		unset( $saved_templates[ $template_id ] );

		if ( count( $saved_templates ) > 0 ) {
			Configuration::updateValue( $this->option_name, Tools::jsonEncode( $saved_templates ) );
		} else {

						Configuration::deleteByName( $this->option_name );
		}
		echo $this->renderMenu( true );
		die();
	}

	public function render( $editor ) {
		$editor->vc_include_template(
			'editors/popups/panel_templates_editor.tpl.php',
			array(
				'box'    => $this,
				'editor' => $editor,
			)
		);
	}

	public function outputMenuButton( $id, $params ) {
		if ( empty( $params ) ) {
			return '';
		}
				$editor = vc_manager();
		$output         = '<li class="wpb_template_li"><a data-template_id="' . $id . '" href="#">' . htmlspecialchars( $params['name'] ) . '</a> <span class="wpb_remove_template" title="' . $editor->l( 'Delete template' ) . '" rel="' . $id . '"><i class="icon wpb_template_delete_icon"> </i></span></li>';
		return $output;
	}

	public function renderMenu( $only_list = false ) {

				$templates = Tools::jsonDecode( Configuration::get( $this->option_name ), true );
		// var_dump($templates);
		// $templates = get_option( $this->option_name );

		$output         = '';
				$editor = vc_manager();
		if ( $only_list === false ) {
			$output .= '<li><ul>
                        <li id="wpb_save_template"><a href="#" id="wpb_save_template_button" class="button">' . $editor->l( 'Save current page as a Template' ) . '</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">' . $editor->l( 'Load Template' ) . '</li>
                        </ul></li>
                        <li>
                        <ul class="wpb_templates_list">';
		}
		if ( empty( $templates ) ) {
			$output .= '<li class="wpb_no_templates"><span>' . $editor->l( 'No custom templates yet.' ) . '</span></li></ul>';
			echo $output;
			return '';
		}
		$templates_arr = $templates;
		foreach ( $templates as $id => $template ) {
			if ( is_array( $template ) && isset( $template['name'], $template['template'] ) && strlen( trim( $template['name'] ) ) > 0 && strlen( trim( $template['template'] ) ) > 0 ) {
				$output .= $this->outputMenuButton( $id, $template );
			} else {
				/* This will delete exists "Wrong" templates */
				unset( $templates_arr[ $id ] );
				if ( count( $templates_arr ) > 0 ) {
					Configuration::updateValue( $this->option_name, Tools::jsonEncode( $templates_arr ) );
				} else {
					Configuration::updateValue( $this->option_name, '' );
				}
			}
		}
		// $output .= '</ul></li>';
		echo $output;
	}

	/**
	 * Load frontend default template content by index
	 */
	public function renderFrontendDefaultTemplate() {
		$template_index = vc_post_param( 'template_name' );
		$data           = $this->getDefaultTemplate( $template_index );
		! $data && die();
		vc_frontend_editor()->setTemplateContent( trim( $data['content'] ) );
		// vc_frontend_editor()->enqueueRequired();
		vc_include_template(
			'editors/frontend_template.tpl.php',
			array(
				'editor' => vc_frontend_editor(),
			)
		);
		die();
	}
}