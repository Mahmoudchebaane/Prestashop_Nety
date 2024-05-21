<?php  if(isset($novconfig["novthemeconfig_body_bg_color"]) && $novconfig["novthemeconfig_body_bg_color"]){ ?>
	body {
		background-color: <?php echo $novconfig["novthemeconfig_body_bg_color"] ?>;
	}
<?php } ?>
<?php  if(isset($novconfig["novthemeconfig_header_mobile_bg_color"]) && $novconfig["novthemeconfig_header_mobile_bg_color"]){ ?>
	.header-mobile { 
    position: fixed;
    background: #7e37b1;
    width: 100%;
    left: 0;
    top: 0;
    z-index: 3;
    padding: 10px; 
		background-color: <?php echo $novconfig["novthemeconfig_header_mobile_bg_color"] ?> !important;
	}
<?php } ?>

<?php  if(isset($novconfig["novthemeconfig_header_bg_color_1"]) && $novconfig["novthemeconfig_header_bg_color_1"]){ ?>
	.header-color-1 {
		background-color: <?php echo $novconfig["novthemeconfig_header_bg_color_1"] ?> !important;
	}
<?php } ?>
<?php  if(isset($novconfig["novthemeconfig_header_bg_color_2"]) && $novconfig["novthemeconfig_header_bg_color_2"]){ ?>
	.header-color-2 {
		background-color: <?php echo $novconfig["novthemeconfig_header_bg_color_2"] ?> !important;
	}
<?php } ?>
<?php  if(isset($novconfig["novthemeconfig_header_bg_color_3"]) && $novconfig["novthemeconfig_header_bg_color_3"]){ ?>
	.header-color-3 {
		background-color: <?php echo $novconfig["novthemeconfig_header_bg_color_3"] ?> !important;
	}
<?php } ?>

<?php  if(isset($novconfig["novthemeconfig_bg_header_sticky"]) && $novconfig["novthemeconfig_bg_header_sticky"]){ ?>
	#header-sticky {
		background-color: <?php echo $novconfig["novthemeconfig_bg_header_sticky"] ?> !important;
	}
<?php } ?>


<?php  if(isset($novconfig["novthemeconfig_body_bg_pattern"]) && $novconfig["novthemeconfig_body_bg_pattern"] != 'none'){ ?>
	body {
		background-image: url(<?php echo $this->_path.'images/'.$novconfig["novthemeconfig_body_bg_pattern"].'.png'; ?>);
	}
<?php } ?>
<?php  if(isset($novconfig["novthemeconfig_body_bg_image"]) && $novconfig["novthemeconfig_body_bg_image"]){ ?>
	body {
		background-image: url(<?php echo $this->_path.'images/'.$novconfig["novthemeconfig_body_bg_image"]; ?>);
		background-repeat: <?php echo $novconfig["novthemeconfig_body_bg_repeat"];?>;
	}
<?php } ?>
<?php  if(isset($novconfig["novthemeconfig_body_bg_position"]) && $novconfig["novthemeconfig_body_bg_position"] != 'none'){ ?>
	body {
		background-position: <?php echo $novconfig["novthemeconfig_body_bg_position"] ?>;
	}
<?php } ?>

<?php if( isset($novconfig["novthemeconfig_width_layout"]) && $novconfig["novthemeconfig_width_layout"] && $novconfig["novthemeconfig_width_layout"] >= 1200 ) { ?>
	@media (min-width: 1200px) {
		.container {
			width: <?php echo $novconfig["novthemeconfig_width_layout"];?>px;
		}

		<?php if( isset($novconfig["novthemeconfig_mode_layout"]) && $novconfig["novthemeconfig_mode_layout"] == "boxed" ) { ?>
		#main-site {
			width: <?php echo $novconfig["novthemeconfig_width_layout"];?>px;
			margin: 0 auto;
		}
		<?php } ?>
	}
<?php } else { ?>
	@media (min-width: 1600px) {
		#header .container {
			width: <?php echo $novconfig["novthemeconfig_width_layout"];?>px;
		}
		.footer .container {
			width: <?php echo $novconfig["novthemeconfig_width_layout"];?>px;
		}
		#index .container {
			width: <?php echo $novconfig["novthemeconfig_width_layout"];?>px;
		}
	}
<?php } ?>

<?php  if(isset($novconfig["novpopup_newsletter_bg"]) && $novconfig["novpopup_newsletter_bg"]){ ?>
	#popup-subscribe .modal-dialog .modal-content {
		background-image: url(<?php echo $this->_path.'images/'.$novconfig["novpopup_newsletter_bg"]; ?>);
	}
<?php } ?>

<?php  if(isset($novconfig["novthemeconfig_w_logo_sticky"]) && $novconfig["novthemeconfig_w_logo_sticky"] != 'none'){ ?>
	.contentstickynew_logo .logo {
		width: <?php echo $novconfig["novthemeconfig_w_logo_sticky"]; ?>px;
	}
<?php } ?>

<?php
	if(isset($novconfig["novthemeconfig_customCSS"]) && $novconfig["novthemeconfig_customCSS"]){
		echo $novconfig["novthemeconfig_customCSS"];
	}
?>

<?php  if(isset($novconfig["novthemeconfig_bottom_nav_bg_color"]) && $novconfig["novthemeconfig_bottom_nav_bg_color"]){ ?>
	#stickymenu_bottom_mobile {
		background-color: <?php echo $novconfig["novthemeconfig_bottom_nav_bg_color"] ?>;
	}
<?php } ?>

<?php  if(isset($novconfig["novthemeconfig_bottom_nav_opacity"]) && $novconfig["novthemeconfig_bottom_nav_opacity"] != ''){ ?>

	<?php 
		function devvn_hextorgba($hex, $opacity = 0.7) {
		    $hex = str_replace("#", "", $hex);
		 
		    if(strlen($hex) == 3) {
		        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		    } else {
		        $r = hexdec(substr($hex,0,2));
		        $g = hexdec(substr($hex,2,2));
		        $b = hexdec(substr($hex,4,2));
		    }
		    $rgba = 'rgba('.$r.','. $g.','. $b.','. floatval($opacity).')';
		    return $rgba;
		}
	?>a
	#stickymenu_bottom_mobile{
		background-color: <?php echo devvn_hextorgba($novconfig["novthemeconfig_bottom_nav_bg_color"],$novconfig["novthemeconfig_bottom_nav_opacity"])?>!important;
	}
	<?php } ?>



<?php  if(isset($novconfig["novthemeconfig_on_top_desktop_enable"]) && $novconfig["novthemeconfig_on_top_desktop_enable"] == 0){ ?>
	#_desktop_back_top {
		display: none!important;
	}
<?php } ?>