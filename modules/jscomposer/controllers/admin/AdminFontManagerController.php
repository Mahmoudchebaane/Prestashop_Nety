<?php


require_once dirname( __FILE__ ) . '/../../jscomposer.php';

// require_once dirname(__FILE__) . '/../../classes/VcImageType.php';


class AdminFontManagerController extends AdminController {




	private $module_instance, $paths = array();

	public $googleFontsEditClass, $name, $displayName;
	static $iconlist = array();


	public function __construct() {
		parent::__construct();

		$ulti_status = Configuration::get( 'VC_ULTIMATE_STATUS' );

		$this->bootstrap = true;

		$this->_ajax_results['error_on'] = 1;
		$this->context                   = Context::getContext();
		$this->module_instance           = JsComposer::getInstance();
		$this->name                      = 'smartultimatevcaddons';
		$this->displayName               = $this->l( 'Smart Ultimate VC Addons' );

		$this->paths            = array();
		$this->paths['basedir'] = $this->module_instance->get_module_dir( 'include/smartultimatevcaddons' );

		$this->paths['baseurl'] = $this->module_instance->asset_media_path;
		$this->paths['fonts']   = 'smile_fonts';
		$this->paths['temp']    = $this->paths['fonts'] . '/' . 'smile_temp';
		$this->paths['fontdir'] = $this->paths['basedir'] . '/' . $this->paths['fonts'];
		$this->paths['tempdir'] = $this->paths['basedir'] . '/' . $this->paths['temp'];
		$this->paths['fonturl'] = $this->paths['baseurl'] . '/' . $this->paths['fonts'];
		$this->paths['tempurl'] = $this->paths['baseurl'] . $this->paths['temp'] . '/';
		$this->paths['config']  = 'charmap.php';
		$this->vc_fonts         = $this->paths['basedir'] . '/' . $this->paths['fonts'] . '/Defaults';
		$this->vc_fonts_dir     = $this->paths['basedir'] . '/assets/fonts/';

	}

	/**
	 * Function initPageHeaderToolbar can add button or links to header.
	 *
	 * @return void
	 */
	public function initPageHeaderToolbar() {
		parent::initPageHeaderToolbar();
	}


	public function renderList() {

		$ulti_status = Configuration::get( 'VC_ULTIMATE_STATUS' );

		if ( $ulti_status ) {

			$this->module_instance->include_plugins_module_file( 'modules/Ultimate_Font_Manager.php' );
			$this->module_instance->include_plugins_module_file( 'modules/Ultimate_Icon_Manager.php' );

			$AIO_Icon_Manager           = new AIO_Icon_Manager();
			$this->googleFontsEditClass = new Ultimate_Google_Font_Manager();

			$this->googleFontsEditClass->admin_google_font_scripts();

			$ultimateajaxurl = Context::getContext()->link->getAdminLink( 'AdminFontManager' );
			$vc_ajaxurl      = $this->context->link->getAdminLink( 'VC_ajax' );
			$scripts         = "<script type=\"text/javascript\">
			var ultimateajaxurl = '$ultimateajaxurl';
			var ajaxurl = '$vc_ajaxurl';
			</script>";

			$html = $this->getHelperForm() . $scripts;
			ob_start();

			$AIO_Icon_Manager->icon_manager_dashboard();
			$this->googleFontsEditClass->ultimate_font_manager_dashboard();

			return $html .= ob_get_clean();

		} else {
			$html = $this->getInactiveWarning();
			ob_start();
			return $html .= ob_get_clean();

		}

	}



	public function postProcess() {

		if ( Tools::isSubmit( 'saveutimate' ) ) {

			$allowedExts = array( 'zip' );
			$temp        = explode( '.', $_FILES['VC_ICON']['name'] );
			$extension   = end( $temp );

			if ( in_array( $_FILES['VC_ICON']['type'], array( 'application/octet-stream', 'application/zip', 'application/x-zip-compressed' ) )
				&& in_array( $extension, $allowedExts )
			) {
				if ( $_FILES['VC_ICON']['error'] > 0 ) {
					return 'Return Code: ' . $_FILES['VC_ICON']['error'] . '<br>';
				} else {
					$exportzippath = _PS_ROOT_DIR_ . '/upload/' . basename( $_FILES['VC_ICON']['name'] );
					if ( move_uploaded_file( $_FILES['VC_ICON']['tmp_name'], $exportzippath ) ) {
						$this->add_zipped_font( $exportzippath );
					}
				}
			} else {

			}
		}
	}



	public function add_zipped_font( $path ) {
		$unzipped = $this->zip_flatten( $path, array( '\.eot', '\.svg', '\.ttf', '\.woff', '\.json', '\.css' ) );
		if ( $unzipped ) {
			$this->create_config();
		} else {
			$this->displayWarning( 'Was not able to retrieve the Font name from your Uploaded Folder' );
			return;
		}
		if ( $this->font_name == 'unknown' ) {
			$this->delete_folder( $this->paths['tempdir'] );
			$this->displayWarning( 'Was not able to retrieve the Font name from your Uploaded Folder' );
			return;
		}
	}

	public function zip_flatten( $zipfile, $filter ) {

		if ( is_dir( $this->paths['tempdir'] ) ) {
			$this->delete_folder( $this->paths['tempdir'] );
			$tempdir = smile_backend_create_folder( $this->paths['tempdir'], false );
		} else {
			$tempdir = smile_backend_create_folder( $this->paths['tempdir'], false );
		}
		if ( ! $tempdir ) {
			echo "Wasn't able to create temp folder";
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
				$fp  = $zip->getStream( $entry );
				$ofp = fopen( $this->paths['tempdir'] . '/' . basename( $entry ), 'w' );
				if ( ! $fp ) {
					echo 'Unable to extract the file.';
				}
				while ( ! feof( $fp ) ) {
					fwrite( $ofp, fread( $fp, 8192 ) );
				}
				fclose( $fp );
				fclose( $ofp );
			}
			$zip->close();
		} else {
			$this->displayWarning( "Wasn\'t able to work with Zip Archive" );
		}
		return true;
	}

	public function create_config() {
		$this->json_file = $this->find_json();
		$this->svg_file  = $this->find_svg();
		if ( empty( $this->json_file ) || empty( $this->svg_file ) ) {
			$this->delete_folder( $this->paths['tempdir'] );
			$this->displayWarning( 'selection.json or SVG file not found. Was not able to create the necessary config files' );
		}
		$json     = Tools::file_get_contents( trailingslashit( $this->paths['tempdir'] ) . $this->json_file );
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
				$this->displayWarning( $this->l( 'It seems that the font with the same name is already exists! Please upload the font with different name.' ) );
				return;
			}
			$file_contents = json_decode( $json );
			if ( ! isset( $file_contents->IcoMoonType ) ) {
				$this->delete_folder( $this->paths['tempdir'] );
				$this->displayWarning( 'Uploaded font is not from IcoMoon. Please upload fonts created with the IcoMoon App Only.' );
				return;
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

	public function delete_folder( $new_name ) {
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


	public function find_json() {
		$files = scandir( $this->paths['tempdir'] );
		foreach ( $files as $file ) {
			if ( strpos( strtolower( $file ), '.json' ) !== false && $file[0] != '.' ) {
				return $file;
			}
		}
	}


	public function find_svg() {
		$files = scandir( $this->paths['tempdir'] );
		foreach ( $files as $file ) {
			if ( strpos( strtolower( $file ), '.svg' ) !== false && $file[0] != '.' ) {
				return $file;
			}
		}
	}

	public function write_config() {
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
					$this->displayWarning( 'Was not able to write a config file' );
				}
			}
			fclose( $handle );
		} else {
			$this->delete_folder( $this->paths['tempdir'] );
			$this->displayWarning( 'Was not able to write a config file' );
		}
	}

	public function re_write_css() {
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
			$this->displayWarning( 'Unable to write css. Upload icons downloaded only from icomoon' );
		}
	}

	public function rename_files() {
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

	public function rename_folder() {
		$new_name = trailingslashit( $this->paths['fontdir'] ) . $this->font_name;
		$this->delete_folder( $new_name );
		if ( rename( $this->paths['tempdir'], $new_name ) ) {
			return true;
		} else {
			$this->delete_folder( $this->paths['tempdir'] );
			$this->displayWarning( 'Unable to add this font. Please try again.' );
		}
	}

	public function add_font() {
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

	public function remove_zipped_font() {
		$font = $_POST['del_font'];

		$list   = $this->load_iconfont_list();
		$delete = isset( $list[ $font ] ) ? $list[ $font ] : false;
		if ( $delete ) {
			$this->delete_folder( $delete['include'] );
			$this->remove_font( $font );
			die( 'smile_font_removed' );
		}
		die( 'Was not able to remove Font' );
	}

	public function remove_font( $font ) {
		$fonts = Configuration::get( 'smile_fonts' );
		$fonts = @unserialize( $fonts );
		if ( isset( $fonts[ $font ] ) ) {
			unset( $fonts[ $font ] );
			$fonts = @serialize( $fonts );
			Configuration::updateValue( 'smile_fonts', $fonts );
		}
	}

	public function load_iconfont_list() {
		if ( ! empty( self::$iconlist ) ) {
			return self::$iconlist;
		}
		$extra_fonts = Configuration::get( 'smile_fonts' );
		$extra_fonts = @unserialize( $extra_fonts );
		if ( empty( $extra_fonts ) ) {
			$extra_fonts = array();
		}

		$font_configs = $extra_fonts;
		$path         = $this->module_instance->get_module_dir( 'include/smartultimatevcaddons/' );

		$url = $this->module_instance->_url_ultimate;
		foreach ( $font_configs as $key => $config ) {
			if ( empty( $config['full_path'] ) ) {
				$font_configs[ $key ]['include'] = $path . $font_configs[ $key ]['include'];
				$font_configs[ $key ]['folder']  = $url . $font_configs[ $key ]['folder'];
			}
		}
		self::$iconlist = $font_configs;
		return $font_configs;
	}

	public function getHelperForm() {
		$fields_form             = array();
		$fields_form[]           = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l( 'Ultimate Addons Settings' ),
				),
				'input'  => array(
					array(
						'type'  => 'file',
						'label' => $this->l( 'Upload Font' ),
						'name'  => 'VC_ICON',
						'desc'  => $this->l( 'Upload Font' ),
					),
					array(
						'type'     => 'text',
						'label'    => $this->l( 'Google Map API Key' ),
						'name'     => 'ult_map_key',
						'size'     => 70,
						'required' => false,
					),
				),
				'submit' => array(
					'title' => $this->l( 'Save' ),
				),
			),
		);
		$helper                  = new HelperForm();
		$helper->module          = $this;
		$helper->name_controller = 'AdminFontManager';
		$helper->token           = $this->token;
		$helper->currentIndex    = AdminController::$currentIndex . '&configure=' . $this->name;
		$default_lang            = (int) Configuration::get( 'PS_LANG_DEFAULT' );

		$helper->default_form_language    = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		$helper->title                    = $this->displayName;
		$helper->show_toolbar             = true;
		$helper->toolbar_scroll           = true;
		$helper->submit_action            = 'saveutimate';

		$helper->fields_value['ult_map_key'] = Configuration::get( 'ult_map_key' );
		// echo $helper->submit_action;

		return $helper->generateForm( $fields_form );

	}

	public function getInactiveWarning() {

		$this->context->controller->addCSS( $this->module_instance->get_module_dir( 'assets/' ) . 'css/js_composer_backend_editor.css' );
		$this->context->controller->addCSS( $this->module_instance->admin_media_path_css . 'icon-manager.css' );

		$gen_setings_url = Context::getContext()->link->getAdminLink( 'AdminJsComposerSetting' );

		$warning = '<section class="ultimate-warning-sec">
						<div class="ultimate-back-overlay"></div>
						<div class="ultimate-inner-sec">
							<div class="row">
								<div class="col-lg-12 heading-section">
									<h2 class="heading-vc">Ultimate Addons for PrestaShop<br> Visual Composer</h2>
									<p>Extended Premium elements for your Visual Composer Addons and <br> add more power too. Try it Now!</p>
								</div>
								<div class="col-lg-12 inner-section">
									<a href="' . $gen_setings_url . '" class="vc-sec-activate-bt">Activate Now</a>
									<div class="intro-image-section">
										<img src="' . context::getcontext()->shop->getBaseURL() . 'modules/jscomposer/assets/images/ua-intro.png' . '" alt="intro image" width="1000" height="412">
									</div>
								</div>
							</div>
						</div>
					</section>
					

<section class="ultimate-feature-sec">
<div>
	<div class="row">
		<div class="col-lg-12 heading-section">
			<h2 class="heading-vc">Awesome Features</h2>
			<div class="wpb-elements-list">
				<ul class="wpb-content-layouts" style="position: relative;">
				<li data-element="bsf-info-box"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e info_box_o">
				<div class="vc_el-container"><a id="bsf-info-box" data-tag="bsf-info-box"
					class="dropable_el info_box_nav" ><i
						class="vc_element-icon vc_info_box"></i> Info Box</a></div>
				</li>
				<li data-element="just_icon"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_simple_icon_o">
				<div class="vc_el-container"><a id="just_icon" data-tag="just_icon"
					class="dropable_el vc_simple_icon_nav" ><i
						class="vc_element-icon vc_just_icon"></i> Just Icon</a></div>
				</li>
				<li data-element="ult_animation_block"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e animation_block_o">
				<div class="vc_el-container"><a id="ult_animation_block" data-tag="ult_animation_block"
					class="dropable_el animation_block_nav" ><i
						class="vc_element-icon animation_block"></i> Animation Block</a></div>
				</li>
				<li data-element="ult_buttons"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e ult_buttons_o">
				<div class="vc_el-container"><a id="ult_buttons" data-tag="ult_buttons"
					class="dropable_el ult_buttons_nav" ><i
						class="vc_element-icon ult_buttons"></i> Advanced Button</a></div>
				</li>
				<li data-element="ult_dualbutton"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e ult_dualbutton_o">
				<div class="vc_el-container"><a id="ult_dualbutton" data-tag="ult_dualbutton"
					class="dropable_el ult_dualbutton_nav" ><i
						class="vc_element-icon ult_dualbutton"></i> Dual Button</a>
				</div>
				</li>
				<li data-element="ultimate_carousel"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e ultimate_carousel_o">
				<div class="vc_el-container"><a id="ultimate_carousel" data-tag="ultimate_carousel"
					class="dropable_el ultimate_carousel_nav" ><i
						class="vc_element-icon ultimate_carousel"></i> Advanced Carousel</a></div>
				</li>
				<li data-element="ult_countdown"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_countdown_o">
				<div class="vc_el-container"><a id="ult_countdown" data-tag="ult_countdown"
					class="dropable_el vc_countdown_nav" ><i
						class="vc_element-icon vc_countdown"></i> Countdown</a></div>
				</li>
				<li data-element="icon_counter"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_flip_box_o">
				<div class="vc_el-container"><a id="icon_counter" data-tag="icon_counter"
					class="dropable_el vc_flip_box_nav" ><i
						class="vc_element-icon vc_icon_block"></i> Flip Box</a>
				</div>
				</li>
				<li data-element="ultimate_google_map"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_google_map_o">
				<div class="vc_el-container"><a id="ultimate_google_map" data-tag="ultimate_google_map"
					class="dropable_el vc_google_map_nav" ><i
						class="vc_element-icon vc_google_map"></i> Google Map</a>
				</div>
				</li>
				<li data-element="ultimate_google_trends"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_google_trends_o">
				<div class="vc_el-container"><a id="ultimate_google_trends" data-tag="ultimate_google_trends"
					class="dropable_el vc_google_trends_nav" ><i
						class="vc_element-icon vc_google_trends"></i> Google Trends</a></div>
				</li>
				<li data-element="ultimate_heading"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_ultimate_heading_o">
				<div class="vc_el-container"><a id="ultimate_heading" data-tag="ultimate_heading"
					class="dropable_el vc_ultimate_heading_nav" ><i
						class="vc_element-icon vc_ultimate_heading"></i> Headings</a></div>
				</li>
				<li data-element="ultimate_ctation"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_ctaction_icon_o">
				<div class="vc_el-container"><a id="ultimate_ctation" data-tag="ultimate_ctation"
					class="dropable_el vc_ctaction_icon_nav" ><i
						class="vc_element-icon vc_icon_ctaction"></i> Hightlight Box</a></div>
				</li>
				<li data-element="icon_timeline"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_timeline_o">
				<div class="vc_el-container"><a id="icon_timeline" data-tag="icon_timeline"
					class="dropable_el vc_timeline_nav" ><i
						class="vc_element-icon vc_timeline_icon"></i> Timeline</a></div>
				</li>
				<li data-element="icon_timeline_sep"
				class="wpb-layout-element-button category-3d1f92a565d3b1a61880236e33c49bf3 vc_timeline_sep_o">
				<div class="vc_el-container"><a id="icon_timeline_sep" data-tag="icon_timeline_sep"
					class="dropable_el vc_timeline_sep_nav" ><i
						class="vc_element-icon vc_timeline_sep_icon"></i> Items Separator</a></div>
				</li>
				<li data-element="icon_timeline_item"
				class="wpb-layout-element-button category-3d1f92a565d3b1a61880236e33c49bf3 vc_timeline_item_o">
				<div class="vc_el-container"><a id="icon_timeline_item" data-tag="icon_timeline_item"
					class="dropable_el vc_timeline_item_nav" ><i
						class="vc_element-icon vc_timeline_item_icon"></i> Timeline Item</a></div>
				</li>
				<li data-element="icon_timeline_feat"
				class="wpb-layout-element-button category-3d1f92a565d3b1a61880236e33c49bf3 vc_timeline_feat_o">
				<div class="vc_el-container"><a id="icon_timeline_feat" data-tag="icon_timeline_feat"
					class="dropable_el vc_timeline_feat_nav" ><i
						class="vc_element-icon vc_timeline_feat_icon"></i> Timeline Featured Item</a></div>
				</li>
				<li data-element="ultimate_icons"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e ultimate_icons_o">
				<div class="vc_el-container"><a id="ultimate_icons" data-tag="ultimate_icons"
					class="dropable_el ultimate_icons_nav" ><i
						class="vc_element-icon ultimate_icons"></i> Icons</a></div>
				</li>
				<li data-element="single_icon"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_simple_icon_o">
				<div class="vc_el-container"><a id="single_icon" data-tag="single_icon"
					class="dropable_el vc_simple_icon_nav" ><i
						class="vc_element-icon vc_just_icon"></i> Icon Item</a></div>
				</li>
				<li data-element="ult_ihover"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e ult_ihover_o">
				<div class="vc_el-container"><a id="ult_ihover" data-tag="ult_ihover"
					class="dropable_el ult_ihover_nav" ><i
						class="vc_element-icon ult_ihover"></i> iHover</a></div>
				</li>
				<li data-element="ult_ihover_item"
				class="wpb-layout-element-button category-0ba2860ee94259026016fcfb8bcf1c0b ult_ihover_o">
				<div class="vc_el-container"><a id="ult_ihover_item" data-tag="ult_ihover_item"
					class="dropable_el ult_ihover_nav" ><i
						class="vc_element-icon ult_ihover"></i> iHover Item</a></div>
				</li>
				<li data-element="ultimate_info_banner"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_info_banner_icon_o">
				<div class="vc_el-container"><a id="ultimate_info_banner" data-tag="ultimate_info_banner"
					class="dropable_el vc_info_banner_icon_nav" ><i
						class="vc_element-icon vc_icon_info_banner"></i> Info Banner</a></div>
				</li>
				<li data-element="info_circle"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_info_circle_o">
				<div class="vc_el-container"><a id="info_circle" data-tag="info_circle"
					class="dropable_el vc_info_circle_nav" ><i
						class="vc_element-icon vc_info_circle"></i> Info Circle</a></div>
				</li>
				<li data-element="info_circle_item"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_info_circle_item_o">
				<div class="vc_el-container"><a id="info_circle_item" data-tag="info_circle_item"
					class="dropable_el vc_info_circle_item_nav" ><i
						class="vc_element-icon vc_info_circle_item"></i> Info Circle Item</a></div>
				</li>
				<li data-element="info_list"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_info_list_o">
				<div class="vc_el-container"><a id="info_list" data-tag="info_list"
					class="dropable_el vc_info_list_nav" ><i
						class="vc_element-icon vc_icon_list"></i> Info List</a></div>
				</li>
				<li data-element="info_list_item"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_info_list_o">
				<div class="vc_el-container"><a id="info_list_item" data-tag="info_list_item"
					class="dropable_el vc_info_list_nav" ><i
						class="vc_element-icon vc_icon_list"></i> Info List Item</a></div>
				</li>
				<li data-element="ultimate_info_table"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_ultimate_info_table_o">
				<div class="vc_el-container"><a id="ultimate_info_table" data-tag="ultimate_info_table"
					class="dropable_el vc_ultimate_info_table_nav"
					><i class="vc_element-icon vc_ultimate_info_table"></i> Info Tables</a></div>
				</li>
				<li data-element="interactive_banner_2"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_interactive_icon_o">
				<div class="vc_el-container"><a id="interactive_banner_2" data-tag="interactive_banner_2"
					class="dropable_el vc_interactive_icon_nav" ><i
						class="vc_element-icon vc_icon_interactive"></i> Interactive Banner 2</a></div>
				</li>
				<li data-element="interactive_banner"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_interactive_icon_o">
				<div class="vc_el-container"><a id="interactive_banner" data-tag="interactive_banner"
					class="dropable_el vc_interactive_icon_nav" ><i
						class="vc_element-icon vc_icon_interactive"></i> Interactive Banner</a></div>
				</li>
				<li data-element="ultimate_icon_list"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e ultimate_icon_list_o">
				<div class="vc_el-container"><a id="ultimate_icon_list" data-tag="ultimate_icon_list"
					class="dropable_el ultimate_icon_list_nav" ><i
						class="vc_element-icon ultimate_icon_list"></i> List Icon</a></div>
				</li>
				<li data-element="ultimate_icon_list_item"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e icon_list_item_o">
				<div class="vc_el-container"><a id="ultimate_icon_list_item" data-tag="ultimate_icon_list_item"
					class="dropable_el icon_list_item_nav" ><i
						class="vc_element-icon icon_list_item"></i> List Icon Item</a></div>
				</li>
				<li data-element="ultimate_modal"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e modal_box_o">
				<div class="vc_el-container"><a id="ultimate_modal" data-tag="ultimate_modal"
					class="dropable_el modal_box_nav" ><i
						class="vc_element-icon vc_modal_box"></i> Modal Box</a></div>
				</li>
				<li data-element="ultimate_pricing"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_ultimate_pricing_o">
				<div class="vc_el-container"><a id="ultimate_pricing" data-tag="ultimate_pricing"
					class="dropable_el vc_ultimate_pricing_nav" ><i
						class="vc_element-icon vc_ultimate_pricing"></i> Price Box</a></div>
				</li>
				<li data-element="ultimate_spacer"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_ultimate_spacer_o">
				<div class="vc_el-container"><a id="ultimate_spacer" data-tag="ultimate_spacer"
					class="dropable_el vc_ultimate_spacer_nav" ><i
						class="vc_element-icon vc_ultimate_spacer"></i> Spacer / Gap</a></div>
				</li>
				<li data-element="stat_counter"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_stats_counter_o">
				<div class="vc_el-container"><a id="stat_counter" data-tag="stat_counter"
					class="dropable_el vc_stats_counter_nav" ><i
						class="vc_element-icon vc_icon_stats"></i> Counter</a></div>
				</li>
				<li data-element="swatch_container"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_swatch_container_o">
				<div class="vc_el-container"><a id="swatch_container" data-tag="swatch_container"
					class="dropable_el vc_swatch_container_nav" ><i
						class="vc_element-icon vc_swatch_container"></i> Swatch Book</a></div>
				</li>
				<li data-element="swatch_item"
				class="wpb-layout-element-button category-0ba2860ee94259026016fcfb8bcf1c0b vc_swatch_item_o">
				<div class="vc_el-container"><a id="swatch_item" data-tag="swatch_item"
					class="dropable_el vc_swatch_item_nav" ><i
						class="vc_element-icon vc_swatch_item"></i> Swatch Book Item</a></div>
				</li>
				<li data-element="ultimate_fancytext"
				class="wpb-layout-element-button category-82525e9ca9d25a59b51155883077e35e vc_ultimate_fancytext_o">
				<div class="vc_el-container"><a id="ultimate_fancytext" data-tag="ultimate_fancytext"
					class="dropable_el vc_ultimate_fancytext_nav" ><i
						class="vc_element-icon vc_ultimate_fancytext"></i> Fancy Text</a></div>
				</li>
				</ul>
				<div class="vc_clearfix"></div>
				</div>
					</div>
				</div>
		</section>
					';

		return $warning;

	}

	public function initHeader() {

		parent::initHeader();

	}

	public function initContent() {

		$isAjax = Tools::getValue( 'ajax' );

		if ( $isAjax == 'true' ) {
			$this->remove_zipped_font();
		}

		return parent::initContent();
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
					@chmod(
						$target_parent . '/' . implode(
							'/',
							array_slice(
								$folder_parts,
								0,
								$i
							)
						),
						$dir_perms
					);
				}
			} return true;
		}
	}
}
