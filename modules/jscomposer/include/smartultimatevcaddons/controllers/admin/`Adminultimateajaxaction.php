<?php

class AdminultimateajaxactionController extends ModuleAdminController {


	public $vcaddonsinstance;
		var $paths = array();
		var $svg_file;
		var $json_file;
		var $vc_fonts;
		var $vc_fonts_dir;
		var $font_name        = 'unknown';
		var $unicode          = '';
		var $svg_config       = array();
		var $json_config      = array();
	static $charlist          = array();
	static $charlist_fallback = array();
	static $iconlist          = array();
		var $assets_js;
		var $assets_css;
		var $admin_js;
		var $admin_css;

	protected $_ajax_results;
	protected $_ajax_stripslash;
	protected $_filter_whitespace;
	protected $lushslider_model;
	public function __construct() {
		$this->display_header = false;
		$this->display_footer = false;
		$this->content_only   = true;
		parent::__construct();
		$this->_ajax_results['error_on']            = 1;
				$this->context                      = Context::getContext();
				$this->vcaddonsinstance             = jscomposer::getInstance();
				$this->assets_js                    = "{$this->vcaddonsinstance->asset_media_path}js/";
				$this->assets_css                   = "{$this->vcaddonsinstance->asset_media_path}css/";
				$this->admin_js                     = "{$this->vcaddonsinstance->admin_media_path_js}";
				$this->admin_css                    = "{$this->vcaddonsinstance->admin_media_path_css}";
				$this->paths                        = array();
							$this->paths['basedir'] = _PS_MODULE_DIR_ . 'jscomposer/include/smartultimatevcaddons';
							$this->paths['baseurl'] = $this->vcaddonsinstance->asset_media_path;
				$this->paths['fonts']               = 'smile_fonts';
				$this->paths['temp']                = $this->paths['fonts'] . '/' . 'smile_temp';
				$this->paths['fontdir']             = $this->paths['basedir'] . '/' . $this->paths['fonts'];
				$this->paths['tempdir']             = $this->paths['basedir'] . '/' . $this->paths['temp'];
				$this->paths['fonturl']             = $this->paths['baseurl'] . '/' . $this->paths['fonts'];
				$this->paths['tempurl']             = $this->paths['baseurl'] . $this->paths['temp'] . '/';
				$this->paths['config']              = 'charmap.php';
				$this->vc_fonts                     = $this->paths['basedir'] . '/' . $this->paths['fonts'] . '/Defaults';
				$this->vc_fonts_dir                 = $this->paths['basedir'] . '/assets/fonts/';
	}
	public function init() {
		// $this->bindToAjaxRequest();
	}
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
	public function processUltimatevcicon() {
		return true;
	}
	// public function ajaxProcessRemoveUltimatevcicon() {
	// 	$this->remove_zipped_font();
	// }
	public function ProcessVcicon() {
		return true;
	}
	public function ajaxProcessImportVcicon() {
		$allowedExts = array( 'zip' );
		$temp        = explode( '.', $_FILES['ImportVcIconId']['name'] );
		$extension   = end( $temp );

		if ( in_array( $_FILES['ImportVcIconId']['type'], array( 'application/octet-stream', 'application/zip', 'application/x-zip-compressed' ) )
			&& in_array( $extension, $allowedExts )
		) {
			if ( $_FILES['ImportVcIconId']['error'] > 0 ) {
				return 'Return Code: ' . $_FILES['ImportVcIconId']['error'] . '<br>';
			} else {
				$exportzippath = _PS_ROOT_DIR_ . '/upload/' . basename( $_FILES['ImportVcIconId']['name'] );
				if ( move_uploaded_file( $_FILES['ImportVcIconId']['tmp_name'], $exportzippath ) ) {
					$this->add_zipped_font( $exportzippath );
				}
				die( '1' );
			}
		} else {
			die( '0' );
		}
	}
	public function add_zipped_font( $path ) {
		$unzipped = $this->zip_flatten( $path, array( '\.eot', '\.svg', '\.ttf', '\.woff', '\.json', '\.css' ) );
		if ( $unzipped ) {
			$this->create_config();
		}
		if ( $this->font_name == 'unknown' ) {
			$this->delete_folder( $this->paths['tempdir'] );
			die( 'Was not able to retrieve the Font name from your Uploaded Folder' );
		}
		die( '1' );
	}
	function zip_flatten( $zipfile, $filter ) {
		if ( is_dir( $this->paths['tempdir'] ) ) {
			$this->delete_folder( $this->paths['tempdir'] );
			$tempdir = smile_backend_create_folder( $this->paths['tempdir'], false );
		} else {
			$tempdir = smile_backend_create_folder( $this->paths['tempdir'], false );
		}
		if ( ! $tempdir ) {
			die( 'Wasn\'t able to create temp folder' );
		}
				$zip = new ZipArchive();
		if ( $zip->open( $zipfile ) ) {
			for ( $i = 0; $i < $zip->numFiles; $i++ ) {
				$entry = $zip->getNameIndex( $i );
				if ( ! empty( $filter ) ) {
					$delete  = true;
					$matches = array();
					foreach ( $filter as $regex ) {
						preg_match( '!' . $regex . '!', $entry, $matches );
						if ( ! empty( $matches ) ) {
							$delete = false;
							break;
						}
					}
				}
				if ( substr( $entry, -1 ) == '/' || ! empty( $delete ) ) {
					continue;
				}
					$fp = $zip->getStream( $entry );
				$ofp    = fopen( $this->paths['tempdir'] . '/' . basename( $entry ), 'w' );
				if ( ! $fp ) {
					die( 'Unable to extract the file.' );
				}
				while ( ! feof( $fp ) ) {
					fwrite( $ofp, fread( $fp, 8192 ) );
				}
				fclose( $fp );
				fclose( $ofp );
			}
			$zip->close();
		} else {
			die( 'Wasn\'t able to work with Zip Archive' );
		}
			return true;
	}
	function create_config() {
		$this->json_file = $this->find_json();
		$this->svg_file  = $this->find_svg();
		if ( empty( $this->json_file ) || empty( $this->svg_file ) ) {
			$this->delete_folder( $this->paths['tempdir'] );
			die( 'selection.json or SVG file not found. Was not able to create the necessary config files' );
		}
		// $response       = wp_remote_fopen(trailingslashit($this->paths['tempurl']).$this->svg_file );
		$json = Tools::file_get_contents( trailingslashit( $this->paths['tempdir'] ) . $this->json_file );
		// if(empty($response))
		 $response = Tools::file_get_contents( trailingslashit( $this->paths['tempdir'] ) . $this->svg_file );
		if ( ! empty( $json ) ) {
			$xml             = simplexml_load_string( $response );
			$font_attr       = $xml->defs->font->attributes();
			$glyphs          = $xml->defs->font->children();
			$this->font_name = (string) $font_attr['id'];
			$unicodes        = array();
			foreach ( $glyphs as $item => $glyph ) {
				if ( $item == 'glyph' ) {
					$attributes = $glyph->attributes();
					$unicode    = (string) $attributes['unicode'];
					array_push( $unicodes, $unicode );
				}
			}
			$font_folder = trailingslashit( $this->paths['fontdir'] ) . $this->font_name;
			if ( is_dir( $font_folder ) ) {
				$this->delete_folder( $this->paths['tempdir'] );
				die( 'It seems that the font with the same name is already exists! Please upload the font with different name.' );
			}
			$file_contents = json_decode( $json );
			if ( ! isset( $file_contents->IcoMoonType ) ) {
				$this->delete_folder( $this->paths['tempdir'] );
				die( 'Uploaded font is not from IcoMoon. Please upload fonts created with the IcoMoon App Only.' );
			}
			$icons = $file_contents->icons;
			unset( $unicodes[0] );
			$n = 1;
			foreach ( $icons as $icon ) {
				$icon_name = $icon->properties->name;
				if ( isset( $icon->icon->tags ) && ! empty( $icon->icon->tags ) ) {
					$tags = implode( ',', $icon->icon->tags );
				} else {
					$tags = '';
				}
				$this->json_config[ $this->font_name ][ $icon_name ] = array(
					'class'   => str_replace( ' ', '', $icon_name ),
					'tags'    => $tags,
					'unicode' => $unicodes[ $n ],
				);
				$n++;
			}
			if ( ! empty( $this->json_config ) && $this->font_name != 'unknown' ) {
				$this->write_config();
				$this->re_write_css();
				$this->rename_files();
				$this->rename_folder();
				$this->add_font();
			}
		}
		return false;
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
	function find_json() {
			$files = scandir( $this->paths['tempdir'] );
		foreach ( $files as $file ) {
			if ( strpos( strtolower( $file ), '.json' ) !== false && $file[0] != '.' ) {
				return $file;
			}
		}
	}
		// finds the svg file we need to create the config
	function find_svg() {
		$files = scandir( $this->paths['tempdir'] );
		foreach ( $files as $file ) {
			if ( strpos( strtolower( $file ), '.svg' ) !== false && $file[0] != '.' ) {
				return $file;
			}
		}
	}
	function write_config() {
		$charmap = $this->paths['tempdir'] . '/' . $this->paths['config'];
		$handle  = @fopen( $charmap, 'w' );
		if ( $handle ) {
			fwrite( $handle, '<?php $icons = array();' );
			foreach ( $this->json_config[ $this->font_name ] as $icon => $info ) {
				if ( ! empty( $info ) ) {
					$delimiter = "'";
					fwrite( $handle, "\r\n" . '$icons[\'' . $this->font_name . '\'][' . $delimiter . $icon . $delimiter . '] = array("class"=>' . $delimiter . $info['class'] . $delimiter . ',"tags"=>' . $delimiter . $info['tags'] . $delimiter . ',"unicode"=>' . $delimiter . $info['unicode'] . $delimiter . ');' );
				} else {
					$this->delete_folder( $this->paths['tempdir'] );
					die( 'Was not able to write a config file' );
				}
			}
			fclose( $handle );
		} else {
			$this->delete_folder( $this->paths['tempdir'] );
			die( 'Was not able to write a config file' );
		}
	}
	function re_write_css() {
		$style = $this->paths['tempdir'] . '/style.css';
		$file  = @file_get_contents( $style );
		if ( $file ) {
			$str = str_replace( 'fonts/', '', $file );
			$str = str_replace( 'icon-', $this->font_name . '-', $str );
			$str = str_replace( '.icon {', '[class^="' . $this->font_name . '-"], [class*=" ' . $this->font_name . '-"] {', $str );
			$str = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str );
			$str = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $str );
			@file_put_contents( $style, $str );
		} else {
			die( 'Unable to write css. Upload icons downloaded only from icomoon' );
		}
	}
	function rename_files() {
		$extensions = array( 'eot', 'svg', 'ttf', 'woff', 'css' );
		$folder     = trailingslashit( $this->paths['tempdir'] );
		foreach ( glob( $folder . '*' ) as $file ) {
			$path_parts = pathinfo( $file );
			if ( strpos( $path_parts['filename'], '.dev' ) === false && in_array( $path_parts['extension'], $extensions ) ) {
				if ( $path_parts['filename'] !== $this->font_name ) {
					rename( $file, trailingslashit( $path_parts['dirname'] ) . $this->font_name . '.' . $path_parts['extension'] );
				}
			}
		}
	}
	function rename_folder() {
		$new_name = trailingslashit( $this->paths['fontdir'] ) . $this->font_name;
		$this->delete_folder( $new_name );
		if ( rename( $this->paths['tempdir'], $new_name ) ) {
			return true;
		} else {
			$this->delete_folder( $this->paths['tempdir'] );
			die( 'Unable to add this font. Please try again.' );
		}
	}
	function add_font() {
		$fonts = Configuration::get( 'smile_fonts' );
		$fonts = @unserialize( $fonts );
		if ( empty( $fonts ) ) {
			$fonts = array();
		}
		$fonts[ $this->font_name ] = array(
			'include' => trailingslashit( $this->paths['fonts'] ) . $this->font_name,
			'folder'  => trailingslashit( $this->paths['fonts'] ) . $this->font_name,
			'style'   => $this->font_name . '/' . $this->font_name . '.css',
			'config'  => $this->paths['config'],
		);
		$fonts                     = @serialize( $fonts );
		Configuration::updateValue( 'smile_fonts', $fonts );
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
		$path             = _PS_MODULE_DIR_ . 'jscomposer/include/smartultimatevcaddons/';
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

if ( ! function_exists( 'smile_backend_create_folder' ) ) {
	function smile_backend_create_folder( &$folder, $addindex = true ) {
		if ( is_dir( $folder ) && $addindex == false ) {
			return true;
		}
		$created = wp_mkdir_p( trailingslashit( $folder ) );
		@chmod( $folder, 0777 );
		if ( $addindex == false ) {
			return $created;
		}
		$index_file = trailingslashit( $folder ) . 'index.php';
		if ( file_exists( $index_file ) ) {
			return $created;
		}
		$handle = @fopen( $index_file, 'w' );
		if ( $handle ) {
			fwrite(
				$handle,
				"<?php\r\necho 'Sorry, browsing the directory is not allowed!';\r\n?>
"
			);
			fclose( $handle );
		}
		return $created;
	}
}
if ( ! function_exists( 'trailingslashit' ) ) {
	function trailingslashit( $string ) {
		return rtrim( $string, '/\\' ) . '/';
	}
}
if ( ! function_exists( 'wp_mkdir_p' ) ) {
	function wp_mkdir_p( $target ) {
		$wrapper = null;
		// if( wp_is_stream( $target ) ) {
		// list( $wrapper, $target ) = explode( '://', $target, 2 );
		// }
		$target = str_replace( '//', '/', $target );
		if ( $wrapper !== null ) {
			$target = $wrapper . '://' . $target;
		}
		$target = rtrim( $target, '/' );
		if ( empty( $target ) ) {
			$target = '/';
		}
		if ( file_exists( $target ) ) {
			return @is_dir( $target );
		}
		$target_parent = dirname( $target );
		while ( '.' != $target_parent && ! is_dir( $target_parent ) ) {
			$target_parent = dirname( $target_parent );
		}
		if ( $stat = @stat( $target_parent ) ) {
			$dir_perms = $stat['mode'] & 0007777;
		} else {
			$dir_perms = 0777;
		}
		if ( @mkdir( $target, $dir_perms, true ) ) {
			if ( $dir_perms != ( $dir_perms & ~umask() ) ) {
				$folder_parts = explode( '/', substr( $target, strlen( $target_parent ) + 1 ) );
				for ( $i = 1; $i <= count( $folder_parts ); $i++ ) {
					@chmod( $target_parent . '/' . implode( '/', array_slice( $folder_parts, 0, $i ) ), $dir_perms );
				}
			}
			return true;
		}
	}
}
