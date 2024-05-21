<?php

class AdminultimateajaxactionController extends ModuleAdminController {
	public $vcaddonsinstance;
		var $paths   = array();
	static $iconlist = array();

	public function __construct() {
		parent::__construct();
		$this->_ajax_results['error_on'] = 1;
				$this->context           = Context::getContext();
				$this->vcaddonsinstance  = jscomposer::getInstance();

	}

	// public function ajaxProcessRemoveUltimatevcicon() {
	// $this->remove_zipped_font();
	// }
	protected function bindToAjaxRequest( $post_method = false ) {
		if ( ! $this->isXmlHttpRequest() ) {
			die( 'We Only Accept Ajax Request' );
		}
		if ( $post_method ) {
			if ( ! isset( $_SERVER['REQUEST_METHOD'] ) or 'POST' != $_SERVER['REQUEST_METHOD'] ) {
				die( 'Only POST Request Method is allowed' );
			}
		}
		return true;
	}

	function delete_folder( $new_name ) {
		if ( is_dir( $new_name ) ) {
			$objects = scandir( $new_name );
			foreach ( $objects as $object ) {
				if ( $object != '.' && $object != '..' ) {
					unlink( $new_name . '/' . $object );
				}
			}
			 reset( $objects );
			 rmdir( $new_name );
		}
	}

	function remove_zipped_font() {
		$font   = $_POST['del_font'];
		$list   = self::load_iconfont_list();
		$delete = isset( $list[ $font ] ) ? $list[ $font ] : false;
		if ( $delete ) {
			$this->delete_folder( $delete['include'] );
			$this->remove_font( $font );
				die( 'smile_font_removed' );
		}
		die( 'Was not able to remove Font' );
	}
	function remove_font( $font ) {
		$fonts = Configuration::get( 'smile_fonts' );
		$fonts = @unserialize( $fonts );
		if ( isset( $fonts[ $font ] ) ) {
			unset( $fonts[ $font ] );
			$fonts = @serialize( $fonts );
			Configuration::updateValue( 'smile_fonts', $fonts );
		}
	}
	static function load_iconfont_list() {
		if ( ! empty( self::$iconlist ) ) {
			return self::$iconlist;
		}
		$extra_fonts = Configuration::get( 'smile_fonts' );
		$extra_fonts = @unserialize( $extra_fonts );
		if ( empty( $extra_fonts ) ) {
			$extra_fonts = array();
		}
			$font_configs = $extra_fonts;
		// $upload_dir = wp_upload_dir();
		// $path       = trailingslashit($upload_dir['basedir']);
		// $url        = trailingslashit($upload_dir['baseurl']);
		$vcaddonsinstance = jscomposer::getInstance();
		$path             = _PS_MODULE_DIR_ . 'smartultimatevcaddons/';
		$url              = $vcaddonsinstance->_url_ultimate;
		foreach ( $font_configs as $key => $config ) {
			if ( empty( $config['full_path'] ) ) {
				$font_configs[ $key ]['include'] = $path . $font_configs[ $key ]['include'];
				$font_configs[ $key ]['folder']  = $url . $font_configs[ $key ]['folder'];
			}
		}
		self::$iconlist = $font_configs;
			return $font_configs;
	}
}

