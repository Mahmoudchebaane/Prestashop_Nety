<?php
function get_ultimate_vc_responsive_media_css( $args ) {
	$content = '';
	if ( isset( $args ) && is_array( $args ) ) {
		// get targeted css class/id from array
		if ( array_key_exists( 'target', $args ) ) {
			if ( ! empty( $args['target'] ) ) {
				$content .= " data-ultimate-target='" . $args['target'] . "' ";
			}
		}

		// get media sizes
		if ( array_key_exists( 'media_sizes', $args ) ) {
			if ( ! empty( $args['media_sizes'] ) ) {
				$content .= " data-responsive-json-new='" . json_encode( $args['media_sizes'] ) . "' ";
			}
		}
	}
	return $content;
}
if ( ! function_exists( 'admin_url' ) ) {
	function admin_url( $path = '', $scheme = 'admin' ) {
		return $path;
	}
}
if ( ! function_exists( 'esc_html' ) ) {
	function esc_html( $text ) {
		return $text;
	}
}

if ( ! function_exists( '__' ) ) {
	function __( $a, $b ) {
		return $a;
	}
}
if ( ! function_exists( 'esc_url' ) ) {
	function esc_url( $url, $protocols = null, $_context = 'display' ) {
		if ( '' == $url ) {
			return $url;
		}
		$url = str_replace( ' ', '%20', $url );
		$url = preg_replace( '|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\[\]\\x80-\\xff]|i', '', $url );
		if ( '' === $url ) {
			return $url;
		}

		$url = str_replace( ';//', '://', $url );
		if ( strpos( $url, ':' ) === false && ! in_array( $url[0], array( '/', '#', '?' ) ) && ! preg_match( '/^[a-z0-9-]+?\.php/i', $url ) ) {
			$url = 'http://' . $url;
		}

		return $url;
	}
}

if ( ! function_exists( 'get_ControllerModuleUltimate_vc_responsive_media_css' ) ) {
	function get_ControllerModuleUltimate_vc_responsive_media_css( $timeline_featured_title_args ) {
		echo '<style>';
		$target      = $timeline_featured_title_args['target'];// => #timeline-item-5232 .ult-timeline-title
		$media_sizes = $timeline_featured_title_args['media_sizes'];// => Array
		echo $target . '{';
		foreach ( $media_sizes as $key => $value ) {
			echo $key . ':' . $value . ';';
		}
		echo '}';
		echo '</style>';
		// return $timeline_featured_title_args;
	}
}

if ( ! function_exists( 'plugins_url' ) ) {
	function plugins_url( $val1, $val2 ) {
		if ( ! defined( 'VC_HTTP_SERVER' ) ) {
			define( 'VC_HTTP_SERVER', str_replace( '/admin/', '/', HTTP_SERVER ) );
		}
		return VC_HTTP_SERVER;
	}
}

if ( ! function_exists( 'plugin_dir_url' ) ) {
	function plugin_dir_url( $val ) {
		if ( ! defined( 'VC_HTTP_SERVER' ) ) {
			define( 'VC_HTTP_SERVER', str_replace( '/admin/', '/', HTTP_SERVER ) );
		}
		return VC_HTTP_SERVER;
	}
}

if ( ! function_exists( 'esc_attr' ) ) {
	function esc_attr( $val ) {
		return $val;
	}
}


function ultimate_get_icon_position_json() {
	$json = '{"Display Text and Icon - Always":{"Icon_at_Left":"ubtn-sep-icon-at-left","Icon_at_Right":"ubtn-sep-icon-at-right"},"Display Icon With Text - On_Hover":{"Bring_in_Icon_from_Left":"ubtn-sep-icon-left","Bring_in_Icon_from_Right":"ubtn-sep-icon-right","Push_Icon_to_Left":"ubtn-sep-icon-left-rev","Push_Icon_to_Right":"ubtn-sep-icon-right-rev"},"Replace Text by Icon - On Hover":{"Push_out_Text_to_Top":"ubtn-sep-icon-bottom-push","Push_out_Text_to_Bottom":"ubtn-sep-icon-top-push","Push_out_Text_to_Left":"ubtn-sep-icon-right-push","Push_out_Text_to_Right":"ubtn-sep-icon-left-push"}}';
	return $json;
}

if ( ! function_exists( 'ultimate_get_banner2_json' ) ) {
	function ultimate_get_banner2_json() {
		$json = '{"Long_Text":{"Style_1":"style1","Style_2":"style5","Style_3":"style13"},"Medium_Text":{"Style_4":"style2","Style_5":"style4","Style_6":"style6","Style_7":"style7","Style_8":"style10","Style_9":"style14"},"Short_Description":{"Style_10":"style9","Style_11":"style11","Style_12":"style15"}}';
		return $json;
	}
}
if ( ! function_exists( 'ultimate_get_animation_json' ) ) {
	function ultimate_get_animation_json() {
		$json = '{"attention_seekers":{"bounce":true,"flash":true,"pulse":true,"rubberBand":true,"shake":true,"swing":true,"tada":true,"wobble":true},"bouncing_entrances":{"bounceIn":true,"bounceInDown":true,"bounceInLeft":true,"bounceInRight":true,"bounceInUp":true},"bouncing_exits":{"bounceOut":true,"bounceOutDown":true,"bounceOutLeft":true,"bounceOutRight":true,"bounceOutUp":true},"fading_entrances":{"fadeIn":true,"fadeInDown":true,"fadeInDownBig":true,"fadeInLeft":true,"fadeInLeftBig":true,"fadeInRight":true,"fadeInRightBig":true,"fadeInUp":true,"fadeInUpBig":true},"fading_exits":{"fadeOut":true,"fadeOutDown":true,"fadeOutDownBig":true,"fadeOutLeft":true,"fadeOutLeftBig":true,"fadeOutRight":true,"fadeOutRightBig":true,"fadeOutUp":true,"fadeOutUpBig":true},"flippers":{"flip":true,"flipInX":true,"flipInY":true,"flipOutX":true,"flipOutY":true},"lightspeed":{"lightSpeedIn":true,"lightSpeedOut":true},"rotating_entrances":{"rotateIn":true,"rotateInDownLeft":true,"rotateInDownRight":true,"rotateInUpLeft":true,"rotateInUpRight":true},"rotating_exits":{"rotateOut":true,"rotateOutDownLeft":true,"rotateOutDownRight":true,"rotateOutUpLeft":true,"rotateOutUpRight":true},"sliders":{"slideInDown":true,"slideInLeft":true,"slideInRight":true,"slideOutLeft":true,"slideOutRight":true,"slideOutUp":true,"slideInUp":true,"slideOutDown":true},"specials":{"hinge":true,"rollIn":true,"rollOut":true},"zooming_entrances":{"zoomIn":true,"zoomInDown":true,"zoomInLeft":true,"zoomInRight":true,"zoomInUp":true},"zooming_exits":{"zoomOut":true,"zoomOutDown":true,"zoomOutLeft":true,"zoomOutRight":true,"zoomOutUp":true},"infinite_animations":{"InfiniteRotate":true,"InfiniteDangle":true,"InfiniteSwing":true,"InfinitePulse":true,"InfiniteHorizontalShake":true,"InfiniteVericalShake":true,"InfiniteBounce":true,"InfiniteFlash":true,"InfiniteTADA":true,"InfiniteRubberBand":true,"InfiniteHorizontalFlip":true,"InfiniteVericalFlip":true,"InfiniteHorizontalScaleFlip":true,"InfiniteVerticalScaleFlip":true}}';
		return $json;
	}
}