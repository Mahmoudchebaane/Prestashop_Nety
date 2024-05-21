<?php
/*
 * Add-on Name: Icon Manager
 * Add-on URI: https://www.brainstormforce.com
 */
if ( ! class_exists( 'AIO_Icon_Manager' ) ) {

	class AIO_Icon_Manager {



		public $vcaddonsinstance;
		var $paths = array();
		var $svg_file;
		var $json_file;
		var $vc_fonts;
		var $vc_fonts_dir;
		var $font_name            = 'unknown';
		var $unicode              = '';
		var $svg_config           = array();
		var $json_config          = array();
		static $charlist          = array();
		static $charlist_fallback = array();
		static $iconlist          = array();
		var $assets_js;
		var $assets_css;
		var $admin_js;
		var $admin_css;

		function __construct() {
			$this->context          = Context::getContext();
			$this->vcaddonsinstance = jscomposer::getInstance();
			$this->assets_js        = "{$this->vcaddonsinstance->asset_media_path}js/";
			$this->assets_css       = "{$this->vcaddonsinstance->asset_media_path}css/";
			$this->admin_js         = "{$this->vcaddonsinstance->admin_media_path_js}";
			$this->admin_css        = "{$this->vcaddonsinstance->admin_media_path_css}";
			$this->paths            = array();
			$this->paths['basedir'] = _PS_MODULE_DIR_ . 'jscomposer/include/smartultimatevcaddons';
			$this->paths['baseurl'] = $this->vcaddonsinstance->asset_media_path;
			$this->paths['fonts']   = 'smile_fonts';
			$this->paths['temp']    = $this->paths['fonts'] . '/' . 'smile_temp';
			$this->paths['fontdir'] = $this->paths['basedir'] . '/' . $this->paths['fonts'];
			$this->paths['tempdir'] = $this->paths['basedir'] . '/' . $this->paths['temp'];
			$this->paths['fonturl'] = $this->paths['baseurl'] . '/' . $this->paths['fonts'];
			$this->paths['tempurl'] = $this->paths['baseurl'] . $this->paths['temp'] . '/';
			$this->paths['config']  = 'charmap.php';
			$this->vc_fonts         = $this->paths['basedir'] . '/' . $this->paths['fonts'] . '/Defaults';
			$this->vc_fonts_dir     = $this->paths['basedir'] . '/assets/fonts/';
			JsComposer::add_shortcode_param( 'icon_manager', array( $this, 'icon_manager' ) );
			JsComposer::add_shortcode_param( 'number', array( &$this, 'number_settings_field' ) );
			JsComposer::add_shortcode_param( 'heading', array( $this, 'heading_settings_field' ) );
			JsComposer::add_shortcode_param( 'colorpicker_alpha', array( $this, 'colorpicker_alpha_gen' ) );
			JsComposer::add_shortcode_param( 'datetimepicker', array( $this, 'datetimepicker' ) );
			JsComposer::add_shortcode_param( 'animator', array( $this, 'animator_param' ) );
			JsComposer::add_shortcode_param( 'ult_select2', array( $this, 'select2_param' ) );
			JsComposer::add_shortcode_param( 'ult_button', array( $this, 'button_prev_param' ) );
			JsComposer::add_shortcode_param( 'chk-switch', array( $this, 'checkboxes_param' ) );
			JsComposer::add_shortcode_param( 'ult_switch', array( $this, 'checkbox_param' ) );
			JsComposer::add_shortcode_param( 'ult_param_heading', array( $this, 'ult_param_heading_callback' ) );

			if ( ! $this->vcaddonsinstance->is_admin() ) {
				$this->register_headings_assets();
			} else {
				$this->admin_scripts();
			}

		}

		function register_headings_assets() {
			$fonts = Configuration::get( 'smile_fonts' );
			$fonts = @unserialize( $fonts );
			if ( isset( $fonts ) && is_array( $fonts ) ) {
				foreach ( $fonts as $font => $info ) {
					$this->context->controller->addCSS( $this->vcaddonsinstance->_url_ultimate . $info['include'] . '/' . basename( $info['style'] ) );
					// jscomposer::$front_styles[] = $this->vcaddonsinstance->_url_ultimate . $info['include'] . '/'.basename($info['style']);
				}
			}
		}

		function ult_param_heading_callback( $settings, $value ) {
			$dependency = vc_generate_dependencies_attributes( $settings );
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$text       = isset( $settings['text'] ) ? $settings['text'] : '';
			$output     = '<h4 ' . $dependency . ' class="wpb_vc_param_value ' . $class . '">' . $text . '</h4>';
			return $output;
		}

		function button_prev_param( $settings, $value ) {
			$param_name   = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type         = isset( $settings['type'] ) ? $settings['type'] : '';
			$class        = isset( $settings['class'] ) ? $settings['class'] : '';
			$json         = isset( $settings['json'] ) ? $settings['json'] : '';
			$jsonIterator = json_decode( $json, true );
			$selector     = '<select name="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '">';
			foreach ( $jsonIterator as $key => $val ) {
				if ( is_array( $val ) ) {
					$labels    = str_replace( '_', ' ', $key );
					$selector .= '<optgroup label="' . ucwords( $labels ) . '">';
					foreach ( $val as $label => $style ) {
						$label = str_replace( '_', ' ', $label );
						if ( $style == $value ) {
							$selector .= '<option selected value="' . $style . '">' . $label . '</option>';
						} else {
							$selector .= '<option value="' . $style . '">' . $label . '</option>';
						}
					}
				} else {
					if ( $val == $value ) {
						$selector .= '<option selected value=' . $val . '>' . $key . '</option>';
					} else {
						$selector .= '<option value=' . $val . '>' . $key . '</option>';
					}
				}
			}
			$selector .= '<select>';

			$output  = '';
			$output .= '<div class="select2_option" style="width: 45%; float: left;">';
			$output .= $selector;
			$output .= '</div>';
			$output .= '<div class="anim_prev" style="width: 45%; float: left; text-align: center; margin-left: 15px; margin-top: -15px;">';
			$output .= '<button class="ubtn ubtn-normal ubtn-sep-icon ubtn-center ubtn-sep-icon-left-rev" data-animation="ubtn-sep-icon-left-push" style="border-radius:3px; border-width:1px; border-color:#ffffff; border-style:solid; background: #2786ce;color: #ffffff;"><span class="ubtn-data ubtn-icon"><i class="Defaults-star" style="font-size:20px;color:;"></i></span><span class="ubtn-hover" style="background: rgb(30, 115, 190);"></span><span class="ubtn-data ubtn-text">Button</span></button>';
			$output .= '</div>';
			$output .= '<script type="text/javascript">
					jQuery(document).ready(function(){
						var animator = jQuery(".' . $param_name . '");
						var anim_target = jQuery(".ubtn");
						animator.on("change",function(){
							var anim = jQuery(this).val();
							var prev_anim = anim_target.data("animation");
							anim_target.removeClass().addClass("ubtn ubtn-normal ubtn-sep-icon ubtn-center ubtn-sep-icon-left-rev " + anim);
						});
					});
				</script>';
			return $output;
		}

		function select2_param( $settings, $value ) {
			$param_name   = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type         = isset( $settings['type'] ) ? $settings['type'] : '';
			$class        = isset( $settings['class'] ) ? $settings['class'] : '';
			$json         = isset( $settings['json'] ) ? $settings['json'] : '';
			$jsonIterator = json_decode( $json, true );
			$selector     = '<select name="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '">';
			foreach ( $jsonIterator as $key => $val ) {
				if ( is_array( $val ) ) {
					$labels    = str_replace( '_', ' ', $key );
					$selector .= '<optgroup label="' . ucwords( $labels ) . '">';
					foreach ( $val as $label => $style ) {
						$label = str_replace( '_', ' ', $label );
						if ( $style == $value ) {
							$selector .= '<option selected value="' . $style . '">' . $label . '</option>';
						} else {
							$selector .= '<option value="' . $style . '">' . $label . '</option>';
						}
					}
				} else {
					if ( $val == $value ) {
						$selector .= '<option selected value=' . $val . '>' . $key . '</option>';
					} else {
						$selector .= '<option value=' . $val . '>' . $key . '</option>';
					}
				}
			}
			$selector .= '<select>';

			$output  = '';
			$output .= '<div class="select2_option" style="width: 45%; float: left;">';
			$output .= $selector;
			$output .= '</div>';
			return $output;
		}

		function checkboxes_param( $settings, $value ) {
			$dependency = vc_generate_dependencies_attributes( $settings );
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$options    = isset( $settings['options'] ) ? $settings['options'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = $checked = '';
			$values     = explode( ',', $value );
			$un         = uniqid( 'chkparam-' . rand() );
			if ( is_array( $options ) && ! empty( $options ) ) {
				foreach ( $options as $key => $opts ) {
					if ( is_array( $values ) && ! empty( $values ) ) {
						if ( in_array( $key, $values ) ) {
							$checked = 'checked';
						} else {
							$checked = '';
						}
					}
					$uid     = uniqid( 'chkparaminside-' . rand() );
					$output .= '<div class="onoffswitch">
							<input type="checkbox" name="' . $param_name . '[]" value="' . $key . '" ' . $dependency . ' class="' . $dependency . ' onoffswitch-checkbox chk-switch-' . $un . '" id="switch' . $uid . '" ' . $checked . '>
							<label class="onoffswitch-label" for="switch' . $uid . '">
								<div class="onoffswitch-inner">
									<div class="onoffswitch-active">
										<div class="onoffswitch-switch">' . $opts['on'] . '</div>
									</div>
									<div class="onoffswitch-inactive">
										<div class="onoffswitch-switch">' . $opts['off'] . '</div>
									</div>
								</div>
							</label>
						</div>';
					$output .= '<div class="chk-label">' . $opts['label'] . '</div><br/>';
				}
			}
			$output .= '<input type="hidden" id="chk-switch-' . $un . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';
			$output .= '<script type="text/javascript">
				jQuery(".chk-switch-' . $un . '").change(function(){
					 var val = "";
					 var l = jQuery(".chk-switch-' . $un . ':checked").length;
					 var c = 1;
					 jQuery(".chk-switch-' . $un . '").each(function(index, element) {
						if(jQuery(this).is(":checked")){
							val += jQuery(this).val();
							if(l>1 && c!=l)
								val += ",";
							c++;
						}
					});
					jQuery("#chk-switch-' . $un . '").val(val);
				});
			</script>';
			return $output;
		}

		function animator_param( $settings, $value ) {
			$param_name   = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type         = isset( $settings['type'] ) ? $settings['type'] : '';
			$class        = isset( $settings['class'] ) ? $settings['class'] : '';
			$json         = ultimate_get_animation_json();
			$jsonIterator = json_decode( $json, true );

			$animators = '<select name="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '">';

			foreach ( $jsonIterator as $key => $val ) {
				if ( is_array( $val ) ) {
					$labels     = str_replace( '_', ' ', $key );
					$animators .= '<optgroup label="' . ucwords( $labels ) . '">';
					foreach ( $val as $label => $style ) {
						$label = str_replace( '_', ' ', $label );
						if ( $label == $value ) {
							$animators .= '<option selected value="' . $label . '">' . $label . '</option>';
						} else {
							$animators .= '<option value="' . $label . '">' . $label . '</option>';
						}
					}
				} else {
					if ( $key == $value ) {
						$animators .= '<option selected value=' . $key . '>' . $key . '</option>';
					} else {
						$animators .= '<option value=' . $key . '>' . $key . '</option>';
					}
				}
			}
			$animators .= '<select>';
			$output     = '';
			$output    .= '<div class="select_anim" style="width: 45%; float: left;">';
			$output    .= $animators;
			$output    .= '</div>';
			$output    .= '<div class="anim_prev" style=" padding: 8px; width: 45%; float: left; text-align: center; margin-left: 15px;"> <span id="animate-me" style="padding: 15px; background: #1C8FCF; color: #FFF;">Animation Preview</span></div>';
			$output    .= '<script type="text/javascript">
					$(document).ready(function(){
						var animator = $(".' . $param_name . '");
						var anim_target = $("#animate-me");
						animator.on("change",function(){
							
							var anim = $(this).val();
							anim_target.removeClass().addClass(anim + " animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function(){$(this).removeClass(anim + " animated");
							});
						});
					});
				</script>';
			return $output;
		}

		function colorpicker_alpha_gen( $settings, $value ) {
			$base       = $opacity = $output = '';
			$dependency = vc_generate_dependencies_attributes( $settings );
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$uni        = uniqid( 'colorpicker-' . rand() );
			if ( $value != '' ) {
				$arr_v = explode( ',', $value );
				if ( is_array( $arr_v ) ) {
					if ( isset( $arr_v[1] ) ) {
						$opacity = $arr_v[1];
					}
					if ( isset( $arr_v[0] ) ) {
						$base = $arr_v[0];
					}
				}
			} else {
				// $opacity=1;
				// $base='#fff';
			}
			$output  = '
                <input id="alpha_val' . $uni . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' vc_column_alpha" value="' . $value . '" ' . $dependency . ' data-uniqid="' . $uni . '" data-opacity="' . $opacity . '" data-hex-code="' . $base . '"/>
';
			$output .= '
<input class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" ' . $dependency . ' name="' . $param_name . '" value="' . $value . '" style="display:none"/>
<button class="alpha_clear" type="button">clear</button>
';
			?> 
			<script type="text/javascript">
				jQuery(document).ready(function() {
					function colorpicker_alpha(selector, id_prefix) {
						jQuery(selector).each(function() {
							var aid = jQuery(this).data('uniqid');
							jQuery(id_prefix + aid).minicolors({
								change: function(hex, opacity) {
									console.log(hex + ',' + opacity);
									jQuery(this).parent().next().val(hex + ',' + opacity);
									console.log(jQuery(this).parent().next().attr('class'))
								},
								opacity: true,
								defaultValue: jQuery(this).data('hex-code'),
								position: 'default',
							});
							jQuery('.alpha_clear').click(function() {
								jQuery(this).parent().find('input').val('');
								jQuery(this).parent().find('.minicolors-swatch-color').css('background-color', '');
								//$select.val('');
								//jQuery(id_prefix+aid).val('');
								//jQuery(id_prefix+aid).next().find('.minicolors-swatch-color').css('background-color','');
							})
						});
					}
					colorpicker_alpha('.vc_column_alpha', '#alpha_val');
				})
			</script>
			<?php
			return $output;
		}

		function datetimepicker( $settings, $value ) {

			$dependency = vc_generate_dependencies_attributes( $settings );
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$uni        = uniqid( 'datetimepicker-' . rand() );
			$output     = '<div id="ult-date-time' . $uni . '" class="ult-datetime"><input data-format="yyyy/MM/dd hh:mm:ss" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" style="width:258px;" value="' . $value . '" ' . $dependency . '/><div class="add-on" >  <i data-time-icon="Defaults-time" data-date-icon="Defaults-time"></i></div></div>';
			$output    .= '<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#ult-date-time' . $uni . '").datetimepicker({
						language: "pt-BR"
					});
				})
				</script>';
			return $output;
		}

		function heading_settings_field( $settings, $value ) {
			$output = '<div class="vc_type_heading"><p>' . $settings['sub_heading'] . '</p></div>';
			return $output;
		}

		// Function generate param type "number"
		function number_settings_field( $settings, $value ) {
			$dependency = vc_generate_dependencies_attributes( $settings );
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$step       = isset( $settings['step'] ) ? $settings['step'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = '<input type="number" min="' . $min . '" max="' . $max . '" step="' . $step . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;
			return $output;
		}

		function icon_manager( $settings, $value ) {
			$font_manager = self::get_font_manager();
			$dependency   = vc_generate_dependencies_attributes( $settings );
			$output       = '<div class="my_param_block">'
			. '<input name="' . $settings['param_name'] . '"
					  class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' 
					  ' . $settings['type'] . '_field" type="hidden" 
					  value="' . $value . '" ' . $dependency . '/>'
			. '</div>';
			$output      .= '<script type="text/javascript">
				jQuery(document).ready(function(){
					console.log("herenow");
					jQuery(".preview-icon").html("<i class=\'' . $value . '\'></i>");
					jQuery("li[data-icons=\'' . $value . '\']").addClass("selected");
				});
				jQuery(".icons-list li").click(function() {
                    jQuery(this).attr("class","selected").siblings().removeAttr("class");
                    var icon = jQuery(this).attr("data-icons");
                    jQuery("input[name=\'' . $settings['param_name'] . '\']").val(icon);
                    jQuery(".preview-icon").html("<i class=\'"+icon+"\'></i>");
                });
				</script>';
			$output      .= $font_manager;
			return $output;
		}

		// Icon font manager
		public function get_icon_manager( $input_name, $icon ) {
			$font_manager = self::get_font_manager();
			$output       = '<div class="my_param_block">';
			$output      .= '<input name="' . $input_name . '" class="textinput ' . $input_name . ' text_field" type="hidden" value="' . $icon . '"/>';
			$output      .= '</div>';
			$output      .= '<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(".preview-icon").html("<i class=\'' . $icon . '\'></i>");
					jQuery("li[data-icons=\'' . $icon . '\']").addClass("selected");
				});
				jQuery(".icons-list li").click(function() {
					jQuery(this).attr("class","selected").siblings().removeAttr("class");
					var icon = jQuery(this).attr("data-icons");
					jQuery("input[name=\'' . $input_name . '\']").val(icon);
					jQuery(".preview-icon").html("<i class=\'"+icon+"\'></i>");
				});
				</script>';
			$output      .= $font_manager;
			return $output;
		}

		// ult_switch param
		function checkbox_param( $settings, $value ) {
			$dependency = vc_generate_dependencies_attributes( $settings );
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$options    = isset( $settings['options'] ) ? $settings['options'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = $checked = '';
			$un         = uniqid( 'ultswitch-' . rand() );
			if ( is_array( $options ) && ! empty( $options ) ) {
				foreach ( $options as $key => $opts ) {
					if ( $value == $key ) {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					$uid     = uniqid( 'ultswitchparam-' . rand() );
					$output .= '<div class="onoffswitch">
							<input type="checkbox" name="' . $param_name . '" value="' . $value . '" ' . $dependency . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' ' . $dependency . ' onoffswitch-checkbox chk-switch-' . $un . '" id="switch' . $uid . '" ' . $checked . '>
							<label class="onoffswitch-label" for="switch' . $uid . '">
								<div class="onoffswitch-inner">
									<div class="onoffswitch-active">
										<div class="onoffswitch-switch">' . $opts['on'] . '</div>
									</div>
									<div class="onoffswitch-inactive">
										<div class="onoffswitch-switch">' . $opts['off'] . '</div>
									</div>
								</div>
							</label>
						</div>';
					if ( isset( $opts['label'] ) ) {
						   $lbl = $opts['label'];
					} else {
						$lbl = '';
					}
					$output .= '<div class="chk-label">' . $lbl . '</div><br/>';
				}
			}

			// $output .= '<input type="hidden" id="chk-switch-'.$un.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" />';
			$output .= '<script type="text/javascript">
				jQuery("#switch' . $uid . '").change(function(){
					 
					 if(jQuery("#switch' . $uid . '").is(":checked")){
						jQuery("#switch' . $uid . '").val("' . $key . '");
						jQuery("#switch' . $uid . '").attr("checked","checked");
					 } else {
						jQuery("#switch' . $uid . '").val("off");
						jQuery("#switch' . $uid . '").removeAttr("checked");
					 }
					
				});
			</script>';

			return $output;
		}

		function icon_manager_menu() {
			$page = add_submenu_page(
				'bsf-dashboard',
				'Icon Manager',
				'Icon Manager',
				'administrator',
				'font-icon-Manager',
				array( $this, 'icon_manager_dashboard' )
			);
			add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_scripts' ) );
		}

		function admin_scripts() {
			// enqueue js files on backend
			if ( Tools::getValue( 'controller' ) == 'AdminFontManager' ) {
				$this->context->controller->addJS( $this->admin_js . 'admin-media.js' );

			}
			$this->context->controller->addCSS( $this->admin_css . 'icon-manager-admin.css' );

			$fonts = Configuration::get( 'smile_fonts' );
			$fonts = unserialize( $fonts );
			if ( is_array( $fonts ) ) {
				foreach ( $fonts as $font => $info ) {
					if ( strpos( $info['style'], 'http://' ) !== false ) {
						// wp_enqueue_style('bsf-'.$font,$info['style']);
					} else {
						$this->context->controller->addCSS( $this->vcaddonsinstance->_url_ultimate . $info['include'] . '/' . basename( $info['style'] ) );
						// wp_enqueue_style('bsf-'.$font,trailingslashit($this->paths['fonturl']).$info['style']);
					}
				}
			}
		}

		// end AIO_admin_scripts

		function icon_manager_dashboard() {

			?>

			<div class="row">
				<div class="panel col-lg-12">
					<h3>Icon Fonts Manager &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</h3>
					<div id="msg"></div>
			<?php
			$fonts = Configuration::get( 'smile_fonts' );
			$fonts = unserialize( $fonts );
			if ( is_array( $fonts ) ) :
				?>

						<h3>
							<input class="search-icon" type="text" placeholder="Search" />
							<span class="search-count"></span> </h3>
					</div>
				<?php self::get_font_set(); ?>
				</div>
				<?php else : ?>
				<div class="error">
					<p>
					<?php echo 'No font icons uploaded. Upload some font icons to display here.'; ?>
					</p>
				</div>
					<?php
				endif;
		}

		public static function get_font_manager() {
			$fonts            = Configuration::get( 'smile_fonts' );
			$fonts            = @unserialize( $fonts );
			$context          = Context::getContext();
			$vcaddonsinstance = jscomposer::getInstance();
			$output           = '<p><div class="preview-icon"><i class=""></i></div><input class="search-icon" type="text" placeholder="Search for a suitable icon.." /></p>';
			$output          .= '<div id="smile_icon_search">';
			$output          .= '<ul class="icons-list smile_icon">';

			foreach ( $fonts as $font => $info ) {

				$icon_set = array();
				$icons    = array();
				$path     = jscomposer::get_module_dir( '/include/smartultimatevcaddons/' );
				$file     = $path . $info['include'] . '/' . $info['config'];
				if ( file_exists( $file ) ) {
					include $file;
				}
				$output .= '<link rel="stylesheet" href="' . $vcaddonsinstance->_url_ultimate . $info['include'] . '/' . basename( $info['style'] ) . '" />';

				if ( ! empty( $icons ) ) {
					$icon_set = array_merge( $icon_set, $icons );
				}
				if ( $font == 'smt' ) {
					$set_name = 'Default Icons';
				} else {
					$set_name = ucfirst( $font );
				}
				if ( ! empty( $icon_set ) ) {
					$output .= '<p><strong>' . $set_name . '</strong></p>';
					$output .= '<li title="no-icon" data-icons="none" data-icons-tag="none,blank" style="cursor: pointer;"></li>';
					foreach ( $icon_set as $icons ) {
						foreach ( $icons as $icon ) {
							$output .= '<li title="' . $icon['class'] . '" data-icons="' . $font . '-' . $icon['class'] . '" data-icons-tag="' . $icon['tags'] . '">';
							$output .= '<i class="icon ' . $font . '-' . $icon['class'] . '"></i><label class="icon">' . $icon['class'] . '</label></li>';
						}
					}
				}
			}
			$output . '</ul>';
			$output .= '<script type="text/javascript">
					jQuery(document).ready(function(){
						setTimeout(function() {
							jQuery(".search-icon").focus();
						}, 1000);
						jQuery(".search-icon").keyup(function(){
							// Retrieve the input field text and reset the count to zero
							var filter = jQuery(this).val(), count = 0;
							// Loop through the icon list
							jQuery(".icons-list li").each(function(){
								// If the list item does not contain the text phrase fade it out
								if (jQuery(this).attr("data-icons-tag").search(new RegExp(filter, "i")) < 0) {
									jQuery(this).fadeOut();
								} else {
									jQuery(this).show();
									count++;
								}
							});
						});
					});
			</script>';
			$output .= '</div>';
			return $output;
		}

		// Generate Icon Set Preview and settings page
		static function get_font_set() {
			$fonts            = Configuration::get( 'smile_fonts' );
			$fonts            = unserialize( $fonts );
			$vcaddonsinstance = jscomposer::getInstance();
			$n                = count( $fonts );
			foreach ( $fonts as $font => $info ) {
				$icon_set = array();
				$icons    = array();
				$path     = _PS_MODULE_DIR_ . 'jscomposer/include/smartultimatevcaddons/';
				$file     = $path . $info['include'] . '/' . $info['config'];
				$output   = '<div class="col-lg-6 ' . $font . '_section">';
				$output  .= '<link href="' . $vcaddonsinstance->_url_ultimate . $info['include'] . '/' . basename( $info['style'] ) . '" rel="stylesheet" type="text/css"/>';
				$output  .= '<div class="icon_set-' . $font . ' metabox-holder panel ">';
				$output  .= '<div class="postbox">';
				if ( file_exists( $file ) ) {
					include $file;
				}
				if ( ! empty( $icons ) ) {
					$icon_set = array_merge( $icon_set, $icons );
				}
				if ( ! empty( $icon_set ) ) {
					foreach ( $icon_set as $icons ) {
						$count = count( $icons );
					}
					if ( $font == 'smt' || $font == 'Defaults' ) {
						$output .= '<h3 class="icon_font_name"><strong>' . 'Default Icons' . '</strong>';
					} else {
						$output .= '<h3 class="icon_font_name"><strong>' . ucfirst( $font ) . '</strong>';
					}
					$output .= '<span class="badge fonts-count count-' . $font . '">' . $count . '</span>';
					if ( $n != 1 && $font != 'Defaults' ) {
						$output .= '<button class="btn btn-default smile_del_icon" data-sec_name="' . $font . '_section" data-delete=' . $font . ' data-title="Delete This Icon Set"><i class="icon-trash"></i>Delete Icon Set</button>';
					}
					$output .= '</h3>';
					$output .= '<div class="inside"><div class="icon_actions">';
					$output .= '</div>';
					$output .= '<div class="icon_search"><ul class="icons-list fi_icon">';
					foreach ( $icon_set as $icons ) {
						foreach ( $icons as $icon ) {
							$output .= '<li title="' . $icon['class'] . '" data-icons="' . $icon['class'] . '" data-icons-tag="' . $icon['tags'] . '">';
							$output .= '<i class="' . $font . '-' . $icon['class'] . '"></i><label class="icon">' . $icon['class'] . '</label></li>';
						}
					}
					$output . '</ul>';
					$output .= '</div><!-- .icon_search-->';
					$output .= '</div><!-- .inside-->';
					$output .= '</div><!-- .postbox-->';
					$output .= '</div><!-- .icon_set-' . $font . ' -->';
					$output .= '</div><!-- .metabox-->';
					echo $output;
				}
			}
			$script = '<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(".search-icon").keyup(function(){
						jQuery(".fonts-count").hide();
						// Retrieve the input field text and reset the count to zero
						var filter = jQuery(this).val(), count = 0;
						// Loop through the icon list
						jQuery(".icons-list li").each(function(){
							// If the list item does not contain the text phrase fade it out
							if (jQuery(this).attr("data-icons-tag").search(new RegExp(filter, "i")) < 0) {
								jQuery(this).fadeOut();
							} else {
								jQuery(this).show();
								count++;
							}
							if(count == 0)
								jQuery(".search-count").html(" Can\'t find the icon? <a href=\'#smile_upload_icon\' class=\'add-new-h2 smile_upload_icon\' data-target=\'iconfont_upload\' data-title=\'Upload/Select Fontello Font Zip\' data-type=\'application/octet-stream, application/zip\' data-button=\'Insert Fonts Zip File\' data-trigger=\'smile_insert_zip\' data-class=\'media-frame\'>Click here to upload</a>");
							else
								jQuery(".search-count").html(count+" Icons found.");
							if(filter == "")
								jQuery(".fonts-count").show();
						});
					});
				});
			</script>';
			echo $script;
		}



		function AIO_move_fonts() {
			// Make destination directory

			if ( ! is_dir( $this->vc_fonts ) ) {
				mkdir( $this->vc_fonts, 0777 );
			}
			@chmod( $this->vc_fonts, 0777 );
			foreach ( glob( $this->vc_fonts_dir . '*' ) as $file ) {
				$new_file = basename( $file );
				@copy( $file, $this->vc_fonts . '/' . $new_file );
			}
			$fonts['Defaults'] = array(
				'include' => $this->paths['fonts'] . '/Defaults',
				'folder'  => $this->paths['fonts'] . '/Defaults',
				'style'   => 'Defaults' . '/' . 'Defaults' . '.css',
				'config'  => $this->paths['config'],
			);

			$defaults = Configuration::get( 'smile_fonts' );
			$defaults = unserialize( $defaults );
			if ( ! $defaults ) {
				Configuration::updateValue( 'smile_fonts', serialize( $fonts ) );
			}
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
	// new AIO_Icon_Manager;
}
