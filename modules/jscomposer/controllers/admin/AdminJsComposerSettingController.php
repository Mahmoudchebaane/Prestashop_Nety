<?php

/*
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2014 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class AdminJsComposerSettingController extends AdminController {
	
	public function __construct() {
		$this->bootstrap = true;
		$this->className = 'Configuration';
		$this->table     = 'Configuration';

		parent::__construct();

		$arr       = array();
		$arr[]     = array(
			'id'   => 'no',
			'name' => 'No',
		);
		$arr[]     = array(
			'id'   => 'yes',
			'name' => 'Yes',
		);
		$tab_arr[] = array(
			'id'   => 'general',
			'name' => 'General Style',
		);
		$tab_arr[] = array(
			'id'   => 'classic',
			'name' => 'Classic Style',
		);

		parent::__construct();

		$this->fields_options = array(
			'email' => array(
				'title'  => $this->l( 'General Setting for Visual Composer' ),
				'icon'   => 'icon-cogs',
				'fields' => array(
					'vc_load_flex_js'      => array(
						'title'      => $this->l( 'Load Flexslider JS:' ),
						'desc'       => $this->l( 'if you want to load Flexslider JS from your theme or module.' ),
						'validation' => 'isGenericName',
						'type'       => 'select',
						'identifier' => 'id',
						'list'       => $arr,
					),
					'vc_load_flex_css'     => array(
						'title'      => $this->l( 'Load Flexslider CSS:' ),
						'desc'       => $this->l( 'if you want to load Flexslider CSS from your theme or module.' ),
						'validation' => 'isGenericName',
						'type'       => 'select',
						'identifier' => 'id',
						'list'       => $arr,
					),
					'vc_load_nivo_js'      => array(
						'title'      => $this->l( 'Load NivoSlider JS:' ),
						'desc'       => $this->l( 'if you want to load NivoSlider JS from your theme or module.' ),
						'validation' => 'isGenericName',
						'type'       => 'select',
						'identifier' => 'id',
						'list'       => $arr,
					),
					'vc_load_nivo_css'     => array(
						'title'      => $this->l( 'Load NivoSlider CSS:' ),
						'desc'       => $this->l( 'if you want to load NivoSlider CSS from your theme or module.' ),
						'validation' => 'isGenericName',
						'type'       => 'select',
						'identifier' => 'id',
						'list'       => $arr,
					),
					'vc_load_slick_js'      => array(
						'title'      => $this->l( 'Load Slick Slider JS:' ),
						'desc'       => $this->l( 'if you want to load Slick Slider JS from your theme or module.' ),
						'validation' => 'isGenericName',
						'type'       => 'select',
						'identifier' => 'id',
						'list'       => $arr,
					),
					'vc_product_tab_style' => array(
						'title'      => $this->l( 'Product Tab Style' ),
						'desc'       => $this->l( 'you Can Change Product Tab Style.' ),
						'validation' => 'isGenericName',
						'type'       => 'select',
						'identifier' => 'id',
						'list'       => $tab_arr,
					),
					'vc_include_modules'   => array(
						'title'      => $this->l( 'Include Modules' ),
						'desc'       => $this->l( 'You can include modules by putting modules name here(e.g. blockcms) to be appear in visual composer shortcodes list. Put a module name per line.' ),
						'type'       => 'textarea',
						'identifier' => 'id',
						'rows'       => 7,
						'cols'       => 7,
					),
					'vc_exclude_modules'   => array(
						'title'      => $this->l( 'Exclude Modules' ),
						'desc'       => $this->l( 'You can exclude modules by putting modules name here(e.g. blockcms) to be removed from visual composer shortcodes list. Put a module name per line.' ),
						'type'       => 'textarea',
						'identifier' => 'id',
						'rows'       => 7,
						'cols'       => 7,
					),
				),
				'submit' => array( 'title' => $this->l( 'Save' ) ),
			),
		);
		// ksort($this->fields_options['email']['fields']);
	}

	public function initPageHeaderToolbar() {
		parent::initPageHeaderToolbar();

	}

	public function renderList() {

		$custom_hook = unserialize( Configuration::get( 'vc_custom_hook' ) );
		$hook_list   = array();
		if ( ! empty( $custom_hook ) ) {
			foreach ( $custom_hook as $inc ) {
				$inc         = trim( $inc );
				$hook_list[] = $inc;
			}
		}

		// checking if update is available------------------

		if ( Tools::isSubmit( 'check_update' ) ) {
			$Smartlisence = new Smartlisence();
			$this_val     = array(
				'version'      => JsComposer::$vc_version,
				'module_name'  => JsComposer::$vc_mode_name,
				'theme_name'   => basename( _THEME_DIR_ ),
				'purchase_key' => Tools::getValue( 'purchase_key' ),
			);
			// remove

			Configuration::deleteByName( 'jscomposer_update_timeout' );

			$out = $Smartlisence->checkUpdate( $this_val );
		}

		// checking if update is available------------------

		$css               = '
            <style>
            .active-status {
            background: #e74c3c;
            padding: 5px 18px;
            font-size: 17px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            margin: -17px 0px 17px 0px;
            }
            .activated {
            background: #27ae60; 
            }
            .not-activated {
            background: #e74c3c; 
            }
            .update-available{
            background: #e67e22; 
            }
            .reminder-msg{
                font-size: 13px;
                margin: 10px 0px;
            }
            .update-msg{
               font-weight: bold;
                font-size: 13px;
                padding: 7px 0px;
            }
            .code-helper{
            margin: 35px 0px 10px 0px;
            font-size: 13px;
            }
			.warning{
				color: #eb685b;
				border: 2px solid;
				width: 85%;
				padding: 6px;
			}
			.safe{
				color: #39ae60;
				border: 2px solid;
				width: 85%;
				padding: 6px;
			}
			.learn-bt-warn{
				color: #eb685b !important;
				text-decoration: underline !important;
				font-size: 12px;
				cursor: pointer;
				padding: 6px;
				font-weight: 800;
			}
			.learn-bt-warn:hover {
				color: #29245c !important;
				text-decoration: underline !important;
			}
            </style>
    ';
		$jscomposer_status = Configuration::get( 'jscomposer_status', '0' );
		if ( $jscomposer_status == '1' ) {

			$check_diff = Configuration::get( 'VC_ULTIMATE_CHECK' );
			$day_diff = abs(round($check_diff / 86400));
			$sup_msg = "";
			$sup_msg_class = "";
			if($day_diff <= 0){
				$sup_msg = "Your Support is Expired. Please extend support in order to use Ultimate Addons." . '<a class="learn-bt-warn" data-toggle="modal" data-target="#exampleModalCenter">Learn More</a>';
				$sup_msg_class = "warning";
			}else{
				if($day_diff <= 10){
					$sup_msg = "Your have only " . $day_diff . " days remaining of your support. You need extended support in order to use Ultimate Addons." . '<a class="learn-bt-warn" data-toggle="modal" data-target="#exampleModalCenter">Learn More</a>';
					$sup_msg_class = "warning";
				}else{
					$sup_msg = "Your Support Will Expire In " . $day_diff . " Days.";
					$sup_msg_class = "safe";
				}
			}

			$activation_details = $css . '<div class="active-status activated pull-right" style="padding: 0px 13px 0px 8px;margin: 0px 16px 17px 0px;">'
			. '<i class="icon-check-circle-o"></i> Module Activated'
			. '</div>';
			$disable_status     = 'disabled';
			$below_message      = '<div class="reminder-msg" style="margin-left: 21px;">In order to register your purchase code on another domain, deregister it first by <br> clicking the button below.</div>';
			$below_message      .= '<div class="reminder-msg-support ' . $sup_msg_class . '" style="margin-left: 21px;">' . $sup_msg . '</div>';
			$active_button      = '';
			$deactive_button    = "<input type='submit' value='DeActivate' name='deactivateVc' id ='deactivateVc' class='btn btn-primary' style='margin-left: 21px;margin-bottom: 27px;margin-top: 23px;' />";
			$gen_hook_vt        = "<input type='submit' value='Generate Hooks' name='generate_hook' id ='generate_hook' class='btn btn-success' style='margin-right: 22px;margin-bottom: 27px;margin-top: 23px; float: right;' />";
		} else {
			$activation_details = $css . '<div class="active-status not-activated pull-right" style="padding: 0px 13px 0px 8px;margin: 0px 16px 17px 0px;">'
			. '<i class="icon-ban"></i> Not Activated'
			. '</div>';
			$disable_status     = '';
			$below_message      = '<div class="reminder-msg" style="margin-left: 21px;">Reminder ! One registration per Website. If registered elsewhere please deactivate that registration first.</div>';

			$active_button   = "<input type='submit' value='Activate' name='activateVc' id ='activateVc' class='btn btn-primary' style='margin-left: 21px;margin-bottom: 27px;margin-top: 23px;'/>";
			$deactive_button = '';
			$gen_hook_vt     = '';
		}

		$purchase_key = Configuration::get( 'jscomposer_purchase_key', '' );
		$html         = "<form method='post' action='' name='lisenceForm'>";

		$html .= '<style>';
		$html .= '.vc-dash-title, .ulti-dash-title{';
		$html .= 'font-size: 19px;';
		$html .= 'line-height: 32px;';
		$html .= 'vertical-align: middle;';
		$html .= 'display: inline-block;';
		$html .= 'font-weight: 600;';
		$html .= 'position: relative;';
		$html .= 'z-index: 1;';
		$html .= 'color: #e74c3c;';
		$html .= 'width: 100%;';
		$html .= 'padding: 16px 0px 0px 8px;';
		$html .= 'border-bottom: 1px solid rgba(0,0,0,0.1);';
		$html .= '}';

		$html .= '.ulti-dash-title{';
		$html .= 'padding: 0px 0px 0px 8px;';
		$html .= 'margin-bottom: 18px;';
		$html .= '}';

		$html .= '.activate_ulti{';
		$html .= 'font-size: 14px !important;';
		$html .= 'background: #29245c;';
		$html .= 'color: #f5f5f5;';
		$html .= 'vertical-align: middle;';
		$html .= 'font-weight: 600;';
		$html .= 'position: relative;';
		$html .= 'border-radius: 5px;';
		$html .= 'padding: 12px;';
		$html .= 'text-align: center;';
		$html .= 'border: 0px;';
		$html .= 'cursor: pointer;';
		$html .= 'border: 2px solid #29245c;';
		$html .= '-webkit-appearance: button;';
		$html .= '    margin-top: 50px;';
		$html .= '}';

		$html .= '.ultimate-features{';
		$html .= 'list-style: square;';
		$html .= 'font-size: 14px;';
		$html .= 'line-height: 30px;';
		$html .= 'font-weight: 600;';
		$html .= '}';

		$html .= '.amazing{';
		$html .= 'color: #3ca6f1;';
		$html .= '}';

		$html .= 'span.paid-ulti{';
		$html .= 'color: #f2321e !important;';
		$html .= '}';

		$html .= '.free-activation{';
		$html .= 'padding: 4px;';
		$html .= 'border: 2px solid;';
		$html .= 'font-size: 15px;';
		$html .= 'font-weight: 700;';
		$html .= '}';

		$html .= '.free-activation span,.ulti-modal-body span{';
		$html .= 'color: #39ae60;';
		$html .= 'font-size: 16px;';
		$html .= '}';

		$html .= '.ulti-modal-body span{';
		$html .= 'font-weight: 700;';
		$html .= '}';

		$html .= '.ulti-modal-title{';
		$html .= 'font-size: 24px !important;';
		$html .= 'color: #de5548 !important;';
		$html .= '}';

		$html .= '.ulti-modal-body{';
		$html .= 'font-size: 14px !important;';
		$html .= 'line-height: 28px;';
		$html .= 'color: #14122e;';
		$html .= '}';

		$html .= '.learn-bt{';
		$html .= 'color: #39ae60 !important;';
		$html .= 'text-decoration: underline !important;';
		$html .= 'font-size: 12px;';
		$html .= 'cursor: pointer;';
		$html .= 'padding: 6px;';
		$html .= '}';

		$html .= '.learn-bt:hover{';
		$html .= 'color: #29245c !important;';
		$html .= 'text-decoration: underline !important;';
		$html .= '}';

		$html .= '.flexibility{';
		$html .= 'color: #007f31';
		$html .= '}';

		$html .= '.no-coding{';
		$html .= 'color: #ff0000;';
		$html .= '}';

		$html .= '.activate_ulti:hover{';
		$html .= 'background: #f5f5f5;';
		$html .= 'color: #29245c;';
		$html .= 'border: 2px solid #29245c;';
		$html .= '}';

		$html .= '.ult-section{';
		$html .= '    display: inline-block;';
		$html .= '}';

		$html .= '.desc_ulti{';
		$html .= 'width: 90%;';
		$html .= 'font-size: 16px;';
		$html .= 'line-height: 26px;';
		$html .= '}';

		$html .= '.ult-img, .ult-desc {';
		$html .= 'float: left;';
		$html .= 'width: 50%;';
		$html .= 'color: #29245c;';
		$html .= '}';

		$html .= '.msg_ulti{';
		$html .= 'color: #fff;';
		$html .= 'display: none;';
		$html .= 'font-size: 14px;';
		$html .= 'padding-left: 10px;';
		$html .= 'padding-top: 4px;';
		$html .= 'padding-bottom: 4px;';
		$html .= 'border-radius: 5px;';
		$html .= 'line-height: 20px;';
		$html .= '}';

		$html .= '.hide_active{';
		$html .= 'display: none;';
		$html .= '}';

		$html .= '.show_active{';
		$html .= 'display: block;';
		$html .= '}';

		$html .= '.active_ulti{';
		$html .= 'background-color: #39ae60;';
		$html .= 'display: block;';
		$html .= '}';

		$html .= '.warning_ulti{';
		$html .= 'background-color: #e84c3c;';
		$html .= 'display: block;';
		$html .= '}';

		$html .= '.ult-img{';
		$html .= 'text-align: center;';
		$html .= '}';

		$html .= '.panel-body-overlay{';
		$html .= 'position: absolute;';
		$html .= 'width: 100%;';
		$html .= 'height: 100%;';
		$html .= 'background: white;';
		$html .= 'z-index: 1;';
		$html .= 'padding: 8px 0px;';
		$html .= '-webkit-transition: all 0.5s ease-in-out;';
		$html .= '-moz-transition: all 0.5s ease-in-out;';
		$html .= '-o-transition: all 0.5s ease-in-out;';
		$html .= 'transition: all 0.5s ease-in-out;';
		$html .= '}';

		$html .= '.panel-body-overlay-deregistered{';
		$html .= '';
		$html .= '}';

		$html .= '.vc-dash-icon{';
		$html .= 'width: 40px;';
		$html .= 'height: 35px;';
		$html .= 'float: left;';
		$html .= 'margin-left: 41px;';
		$html .= 'margin-top: 6px;';
		$html .= '}';

		$html .= '.vc-dash-refresh{';
		$html .= 'background: url(' . context::getcontext()->shop->getBaseURL() . 'modules/jscomposer/assets/images/validation/dash-refresh.png);';
		$html .= 'background-repeat: no-repeat;';
		$html .= 'background-position: center;';
		$html .= '}';

		$html .= '.vc-dash-content-with-icon{';
		$html .= 'float: left;margin-left: 6px;';
		$html .= '}';

		$html .= '.vc-dash-content-space{';
		$html .= 'clear: both;padding: 5px;';
		$html .= '}';

		$html .= '.vc-dash-ticket{';
		$html .= 'background: url(' . context::getcontext()->shop->getBaseURL() . 'modules/jscomposer/assets/images/validation/dash-ticket.png);';
		$html .= 'background-repeat: no-repeat;';
		$html .= 'background-position: center;';
		$html .= '}';

		$html .= '.vc-dash-gift{';
		$html .= 'background: url(' . context::getcontext()->shop->getBaseURL() . 'modules/jscomposer/assets/images/validation/dash-gift.png);';
		$html .= 'background-repeat: no-repeat;';
		$html .= 'background-position: center;';
		$html .= '}';

		$html .= '.vc-dash-strong-content{';
		$html .= 'font-weight: 600;';
		$html .= 'color: #000;';
		$html .= 'margin-top: 7px;';
		$html .= '}';

		$html .= '.vc-dash-bottom-wrapper{';
		$html .= 'height: 32px;';
		$html .= 'display: block;';
		$html .= 'margin-top: 9px;';
		$html .= '}';

		$html .= '.vc-validation-activate-step-a{';
		$html .= '';
		$html .= '}';

		$html .= '.vc-dash-button{';
		$html .= 'background: #2c8ac8;';
		$html .= 'color: #fff;';
		$html .= 'font-size: 13px;';
		$html .= 'font-weight: bold;';
		$html .= 'padding: 5px 10px;';
		$html .= 'border-radius: 5px;';
		$html .= 'margin-left: 45px;';
		$html .= 'cursor: pointer;';
		$html .= '}';

		$html .= '.rev6-advertisement{';
			$html .= 'margin-bottom: 10px;';
			$html .= 'text-align: center;';
			$html .= '}';

		$html .= '</style>';

		$html .= "<script>\n";
		$html .= "function showRegisterForm(){\n";
		$html .= '';
		$html .= "$('.panel-body-overlay-deregistered').css( { marginLeft : '-1000px' } );\n";

		$html .= '';
		$html .= "}\n";
		$html .= '</script>';
		$html .= "<div class='row'>"
		. "<div class='col-md-12 rev6-advertisement'>"
		. "<a href='https://1.envato.market/RyR6da' target='_blank'><img src=" . context::getContext()->shop->getBaseURL() . 'modules/jscomposer/assets/images/layout_builder_add.png' . "></a>"
		. "</div>"
		. "<div class='col-md-4'>"
		. "<div class='panel' style='padding: 0px;position: relative;overflow: hidden;'>"
		. "<div class='vc-dash-title'>Visual Composer Activation"
		. $activation_details
		. '</div>'
		. "<div class='panel-body' style='padding: 0px;position: relative;'>";

		if ( $jscomposer_status != '1' ) {
			$html .= "<div class='panel-body-overlay panel-body-overlay-deregistered'>"
			. "<div class='vc-dash-icon vc-dash-refresh'></div>"
			. "<div class='vc-dash-content-with-icon'>"
			. "<div class='vc-dash-strong-content'>Live Updates</div>"
			. '<div>Fresh versions directly to your admin</div>'
			. '</div>'
			. "<div class='vc-dash-content-space'></div>"
			. "<div class='vc-dash-icon vc-dash-ticket'></div>"
			. "<div class='vc-dash-content-with-icon'>"
			. "<div class='vc-dash-strong-content'>Ticket Support</div>"
			. '<div>Direct help from our qualified support team</div>'
			. '</div>'
			. "<div class='vc-dash-content-space'></div>"
			. "<div class='vc-dash-icon vc-dash-gift'></div>"
			. "<div class='vc-dash-content-with-icon'>"
			. "<div class='vc-dash-strong-content'>Free Premium Facility</div>"
			. '<div>Exclusive new facility for our easy customize</div>'
			. '</div>'
			. "<div class='vc-dash-content-space'></div>"
			. "<div class='vc-dash-bottom-wrapper'>"
			. "<span id='vc-validation-activate-step-a' class='vc-dash-button' onclick='showRegisterForm()'>Register Visual Composer</span>"
			. '</div>'
			. '</div>';
		}

		$html .= "<div class='code-helper' style='margin-left: 22px;'><i class='icon-credit-card'></i> You can learn how to find your purchase key <a target='_blank' href='https://smartdatasoft.zendesk.com/hc/en-us/articles/333757002735-where-to-find-the-purchase-code'>here</a></div>"
		. "<input $disable_status type='text' name='purchase_key'  style='width: 90%;margin-left: 21px;' value='" . $purchase_key . "' class='form-control' id='purchase_key' />";
		if ( $disable_status == 'disabled' ) {
			$html .= "<input type='hidden' name='purchase_key' style='width: 90%;margin-left: 21px;' value='" . $purchase_key . "' />";
		}

		$jsComposerObject = JsComposer::$instance;
		$update_disable   = '';
		if ( ! isset( $latest_version ) ) {
			$latest_version = Configuration::get( 'jscomposer_new_version', $jsComposerObject->version );
		}
		if ( $jscomposer_status != '1' ) {
			$update_disable = 'disabled';
		}
		if ( Tools::version_compare( $latest_version, $jsComposerObject->version, '>' ) ) {
			$update_details = '<div class="active-status update-available pull-right">'
			. '<i class="icon-refresh"></i> Update Available'
			. '</div>';
		} elseif ( ! isset( $update_details ) ) {
			$update_details = '<div class="active-status activated pull-right">'
			. '<i class="icon-check-circle-o"></i> Module is up-to-date'
			. '</div>';
		}

		$html .= $below_message;
		$html .= $active_button;
		$html .= $deactive_button;
		$html .= $gen_hook_vt
		. '</div>'
		. '</div>'
		. '</div>'
		. "<div class='col-md-3'>"
		. "<div class='panel' style='max-width:550px; '>"
		. "<div class='panel-heading'>Visual Composer Updates</div>"
		. "<div class='panel-body'>"
		. $update_details
		. '<h4>Installed Version</h4>'
		. '<div>' . $jsComposerObject->version . '</div>'
		. '<h4>Latest Available Version</h4>'
		. '<div>' . $latest_version . '</div>'
		. "<div style='margin-bottom:10px;margin-top:10px;'><input type='submit' value='Check for Updates' name='check_update' id ='check_update' class='btn btn-default' /></div>"
		. "<input $update_disable type='submit' value='Update' name='updateVc' id ='updateVc' class='btn btn-primary' />"
		. '</div>'
		. '</div>'
		. '</div>';

		$ulti_status    = Configuration::get( 'VC_ULTIMATE_STATUS' );
		$active_cstring = 'Activate';

		if ( Module::isInstalled( 'smartultimatevcaddons' ) ) {
			$ulti_status = 1;
		}

		if ( $ulti_status ) {
			$active_cstring = 'Deactivate';

			$activation_details  = '<div class="active-status not-activated pull-right hide_active" style="padding: 0px 13px 0px 8px;margin: 0px 16px 17px 0px;">'
			. '<i class="icon-ban"></i> Not Activated'
			. '</div>';
			$activation_details .= '<div class="active-status ulti-activated activated pull-right show_active" style="padding: 0px 13px 0px 8px;margin: 0px 16px 17px 0px;">'
			. '<i class="icon-check-circle-o"></i> Ultimate Addons Activated'
			. '</div>';
		} else {
			$activation_details  = '<div class="active-status not-activated pull-right show_active" style="padding: 0px 13px 0px 8px;margin: 0px 16px 17px 0px;">'
			. '<i class="icon-ban"></i> Not Activated'
			. '</div>';
			$activation_details .= '<div class="active-status ulti-activated activated pull-right hide_active" style="padding: 0px 13px 0px 8px;margin: 0px 16px 17px 0px;">'
			. '<i class="icon-check-circle-o"></i> Ultimate Addons Activated'
			. '</div>';
		}

		$html .= "<div class='col-lg-5'>"
		. '<div class="panel ult-section">'
		. "<div class='ulti-dash-title'>Ultimate Addons Activation"
		. $activation_details
		. '</div>'
		. '<p class="msg_ulti"></p>'
		. '<div class="ult-img">'
		. '<img src="' . context::getcontext()->shop->getBaseURL() . 'modules/jscomposer/assets/images/ultimate_image.jpg' . '" width="250" height="140" alt="Girl in a jacket">'
		. "<input  value='" . $active_cstring . " Ultimate Addons' name='activate_ultimate' data-js_ulti_status='" . $ulti_status . "'  data-js_module_name='ultimateaddons' id='activateUltimate' readonly='readonly' class='activate_ulti'>"
		. '</div>'
		. '<div class="ult-desc">'
		. '<p class="desc_ulti"><strong>Prestashop Ultimate Addons</strong> presents...</p>'
		. '<ul class="ultimate-features">'
		. '<li class="amazing">Amazing Design</li>'
		. '<li class="flexibility">Limitless Flexibility</li>'
		. '<li class="no-coding">No coding knowledge</li>'
		. '</ul>'
		. '<p class="free-activation"><span>Free activation</span> of this <span>Paid Plugin</span> is available for customers who has extended Support of Visual Composer.'
		. '<a class="learn-bt" data-toggle="modal" data-target="#exampleModalCenter">Learn More</a>'
		. '</p>'
		. '</div>'
		. '</div>'
		. '</div>'
		. '<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title ulti-modal-title" id="exampleModalLongTitle">Notice: Ultimate Addons For Prestashop</h5>
					</div>
					<div class="modal-body ulti-modal-body">
					  Ultimate Addons For Prestashop is a <span class="paid-ulti">PAID EXTENSION</span> for Visual Composer Page Builder PrestaShop which we are providing <span>FREE activation</span> for customers who has Extended Support of Visual Composer.
					  Extend your support and enjoy ultimate facility of awesomely built addons for VC PrestaShop. 
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>'
		. '</div>';

		$html .= '</form>';
		$html .= '<div class="panel">';

		$Smartlisence = new Smartlisence();
		if ( $Smartlisence->isActive() ) {

			$html .= '<div class="panel-heading" >
            Custom Hook <span class="badge">' . count( $hook_list ) . '</span>
                <span class="panel-heading-action" style="width: 121px; font-size: 18px;">
                    <a id="desc-image_type-new" href="#" data-toggle="modal" data-target="#myModal">
                        <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new Hook" data-html="true" data-placement="top">
                            <i class="process-icon-new" style="margin-left: -72px; font-size: 20px;"> Add New Hook</i>
                        </span> 
                    </a>
                </div>';
		} else {

			$html .= '<div class="panel-heading" >
            Custom Hook <span class="badge">' . count( $hook_list ) . '</span>
                <span class="panel-heading-action" style="width: 121px; font-size: 18px;">
                    <a href="javascript:addHookDisable();">
                        <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new Hook" data-html="true" data-placement="top">
                            <i class="process-icon-new" style="margin-left: -72px; font-size: 20px;"> Add New Hook</i>
                        </span> 
                    </a>
                </div>';

			$html .= '
            <script>
                function addHookDisable(){
                    $(\'#ajaxBox\').html(\'<div class="bootstrap"><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><ul class="list-unstyled"><li>You need to activate JsComposer</li></ul></div></div>\');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $(\'#ajaxBox\').show(\'slow\');
                }
            </script>
        ';
		}

		$html .= '<div class="table-responsive-row clearfix">';
		// -----------

		$html .= '<table class="table">';
		$html .= '<thead>';
		$html .= '<tr class="nodrag nodrop"> ';
		$html .= '<th class="fixed-width-xs">';
		$html .= '<span class="title_box active">Hook Name</span>';
		$html .= '</th> ';
		$html .= '<th class="fixed-width-xs center">';
		$html .= '<span class="title_box active">Description</span>';
		$html .= '</th> ';
		$html .= ' <th class="fixed-width-xs"> ';
		$html .= ' </th>';
		$html .= '</tr>';
		$html .= ' </thead>';
		$html .= '<tbody >';
		foreach ( $hook_list as $inc ) {
			$url   = $_SERVER['REQUEST_URI'] . '&deleteCustomHook=' . $inc;
			$html .= '<tr> ';
			$html .= ' <td class=" fixed-width-xs"> ';
			$html .= $inc;
			$html .= '</td> ';
			$html .= ' <td class=" fixed-width-xs"> ';
			$html .= 'This block is attached to custom hook. To display it in .tpl file use:<strong> {hook h="' . $inc . '"}</strong>';
			$html .= '</td> ';
			$html .= '<td  class="">  ';
			$html .= '<div class="btn-group pull-right">';
			$html .= ' <a href="' . $url . '" class="btn btn-default confirm-delete" title="Delete" class="confirm-delete">';
			$html .= '  <i class="icon-trash"></i> Delete';
			$html .= ' </a>';
			$html .= ' </div>    ';
			$html .= '  </td>';
			$html .= ' </tr>';
		}
		if ( empty( $hook_list ) ) {
			$html .= ' <tr>';
			$html .= '<td class="list-empty" colspan="3">';
			$html .= ' <div class="list-empty-msg">';
			$html .= '<i class="icon-warning-sign list-empty-icon"></i>';
			$html .= '   No records found';
			$html .= ' </div>';
			$html .= '  </td>';
			$html .= '</tr> ';
		}
		$html .= '  </tbody>';
		$html .= ' </table>  ';

		// ---------
		$html .= '</div></div>';
		$html .= '  
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form method="post" action="">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add new hook</h4>
      </div>
      <div class="modal-body">
        <p>Put custom hook name</p>
        
        <input type="text" name="vc_custom_hook">
        
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-default value="submit" name="customhookadd" >
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</form>
  </div>
</div>';

		$html .= '<script type="text/javascript">
    $(document).ready(function () {


        $(".confirm-delete").click(function () {
            if (confirm(\'Delete the Custom hook?\')) {
                return true;
            } else {
                return false;
            }
        });
    });
</script>';
		$html .= $this->externalControllers();
		return $html;
	}
	public function externalControllers() {

		$controllers = Configuration::get( 'VC_ENQUEUED_CONTROLLERS' );
		$controllers = Tools::jsonDecode( $controllers, true );

		$template = _PS_MODULE_DIR_ . '/jscomposer/views/templates/admin/backend_hook_list.tpl';

		$this->context->smarty->assign(
			array(
				'controllers'     => $controllers,
				'baseDir'         => _PS_BASE_URL_ . __PS_BASE_URI__,
				'url_base'        => Context::getContext()->link->getAdminLink( 'AdminJsModuleList' ),
				'url_admin_ajax'  => Context::getContext()->link->getAdminLink( 'AdminJsComposerAjax' ),
				'url_module_name' => '',
				'url_status'      => '',
			)
		);

		$html = '';

		$html = $this->context->smarty->fetch( $template );

		return $html;
	}
	public function initContent() {

		if ( Tools::isSubmit( 'deactivateVc' ) ) {

			$this_val     = array(
				'version'      => JsComposer::$vc_version,
				'module_name'  => JsComposer::$vc_mode_name,
				'theme_name'   => basename( _THEME_DIR_ ),
				'purchase_key' => Tools::getValue( 'purchase_key' ),
			);
			$Smartlisence = new Smartlisence();
			$Smartlisence->deactivateModule( $this_val );

		}

		if ( Tools::isSubmit( 'generate_hook' ) ) {

			$mod_ins = Module::getInstanceByName( 'jscomposer' );

			$mod_ins->registerHook( 'displayBackOfficeHeader' );
			$mod_ins->registerHook( 'displayBackOfficeFooter' );
			$mod_ins->registerHook( 'displayBackOfficeTop' );
			$mod_ins->registerHook( 'displayAdminAfterHeader' );
			$mod_ins->registerHook( 'vcBeforeInit' );
			$mod_ins->registerHook( 'VcShortcodesCssClass' );
			$mod_ins->registerHook( 'displayAdminProductsExtra' );
			$mod_ins->registerHook( 'displayHeader' );
			$mod_ins->registerHook( 'overrideLayoutTemplate' );
			$mod_ins->registerHook( 'displayHome' );
			$mod_ins->registerHook( 'displayFooter' );
			$mod_ins->registerHook( 'displayTop' );
			$mod_ins->registerHook( 'displayLeftColumn' );
			$mod_ins->registerHook( 'displayRightColumn' );
			$mod_ins->registerHook( 'displaySmartBlogLeft' );
			$mod_ins->registerHook( 'displaySidearea' );
			$mod_ins->registerHook( 'displaySmartBlogRight' );
			$mod_ins->registerHook( 'displayFooterProduct' );
			$mod_ins->registerHook( 'displayMaintenance' );
			$mod_ins->registerHook( 'actionObjectvccontentanywhereAddAfter' );
			$mod_ins->registerHook( 'actionObjectvccontentanywhereUpdateAfter' );
			$mod_ins->registerHook( 'actionObjectvccontentanywhereDeleteAfter' );
			$mod_ins->registerHook( 'actionObjectvcproducttabcreatorAddAfter' );
			$mod_ins->registerHook( 'actionObjectvcproducttabcreatorUpdateAfter' );
			$mod_ins->registerHook( 'actionObjectvcproducttabcreatorDeleteAfter' );
			$mod_ins->registerHook( 'actionAdminPerformanceControllerAfter' );
			$mod_ins->registerHook( 'actionvccontentanywhereUpdate' );
			$mod_ins->registerHook( 'actionvcproducttabcreatorUpdate' );
			$mod_ins->registerHook( 'VcAllowedImgAttrs' );

		}

		if ( Tools::isSubmit( 'activateVc' ) ) {

			$this_val     = array(
				'version'      => JsComposer::$vc_version,
				'module_name'  => JsComposer::$vc_mode_name,
				'theme_name'   => basename( _THEME_DIR_ ),
				'purchase_key' => Tools::getValue( 'purchase_key' ),
			);

			

			$Smartlisence = new Smartlisence();
			$Smartlisence->activateModule( $this_val );

			$support_data = $Smartlisence->has_support();
			if ( $support_data['validity'] ) {
				$status = true;
				$msg    = 'Ultimate Addons <strong>Activated</strong>';
				Configuration::updateValue( 'VC_ULTIMATE_STATUS', 1 );

			} else {
				$msg = $support_data['msg'];
				Configuration::updateValue( 'VC_ULTIMATE_STATUS', 0 );

			}
		}
		if ( Tools::isSubmit( 'updateVc' ) ) {

			$this_val     = array(
				'version'      => JsComposer::$vc_version,
				'module_name'  => JsComposer::$vc_mode_name,
				'theme_name'   => basename( _THEME_DIR_ ),
				'purchase_key' => Tools::getValue( 'purchase_key' ),
			);
			$Smartlisence = new Smartlisence();
			$Smartlisence->updateModule( $this_val );

		}

		if ( isset( $_REQUEST['deleteCustomHook'] ) ) {
			$deleteCustomHook = $_REQUEST['deleteCustomHook'];
			if ( $deleteCustomHook != '' ) {

				$old_hook_list = unserialize( Configuration::get( 'vc_custom_hook' ) );

				if ( $old_hook_list == '' ) {
					$old_hook_list = array();
				}

				$key = array_search( $deleteCustomHook, $old_hook_list );

				unset( $old_hook_list[ $key ] );

				$updated_hook_list = serialize( $old_hook_list );
				Configuration::updateValue( 'vc_custom_hook', $updated_hook_list );
				$mod_obj = Module::getInstanceByName( 'jscomposer' );
				$id_hook = Hook::getIdByName( $deleteCustomHook );
				$mod_obj->unregisterHook( $id_hook );

				$url = $this->context->link->getAdminLink( 'AdminJsComposerSetting', true );
				Tools::redirectAdmin( $url );
			}
		}

		if ( Tools::isSubmit( 'customhookadd' ) ) {
			$Smartlisence = new Smartlisence();
			if ( $Smartlisence->isActive() ) {
				$old_hook_list = unserialize( Configuration::get( 'vc_custom_hook' ) );

				if ( isset( $old_hook_list ) && ( $old_hook_list == '' ) ) {
					$old_hook_list = array();
				}
				$new_hook = Tools::getValue( 'vc_custom_hook' );

				if ( in_array( $new_hook, $old_hook_list ) ) {
					$new_hook = '';
				} else {
					$old_hook_list[] = $new_hook;
				}

				$updated_hook_list = serialize( $old_hook_list );
				Configuration::updateValue( 'vc_custom_hook', $updated_hook_list );
				if ( $new_hook != '' ) {
					// $new_hook_list = explode("\n", $new_hook_list);
					// foreach ($new_hook_list as $inc) {
					$inc = trim( $new_hook );

					$mod_obj = Module::getInstanceByName( 'jscomposer' );
					$mod_obj->registerHook( $inc );
					// }
				}
			}
		}

		parent::initContent();
	}

	// public function beforeUpdateOptions()
	// {
	// echo $_SERVER['REQUEST_URI'];die();
	// $old_hook_list = unserialize(Configuration::get('vc_custom_hook'));
	//
	// if($old_hook_list==''){
	// $old_hook_list = array();
	// }
	// $new_hook = Tools::getValue('vc_custom_hook');
	//
	// if(in_array($new_hook, $old_hook_list)){
	// $new_hook='';
	// }else{
	// $old_hook_list[] = $new_hook;
	// }
	//
	//
	// $updated_hook_list=  serialize($old_hook_list);
	// Configuration::updateValue('vc_custom_hook', $updated_hook_list);
	//
	// $old_hook_list = array();
	// $new_hook_list = array();
	//
	// $hook_remove_list = array();
	//
	// if (!empty($old_hook)) {
	// $old_hook = explode("\n", $old_hook);
	// foreach ($old_hook as $inc) {
	// $inc = trim($inc);
	// $old_hook_list [] = $inc;
	// }
	// }
	//
	//
	// if (!empty($new_hook)) {
	// $new_hook = explode("\n", $new_hook);
	// foreach ($new_hook as $inc) {
	// $inc = trim($inc);
	// if(!in_array($inc, $old_hook_list)){
	// $old_hook_list []= $inc;
	// $new_hook_list[] = $inc;
	// }
	// }
	// }
	//
	//
	// var_dump($new_hook_list);die();
	// $hook_remove_list = array_diff($new_hook_list, $old_hook_list);
	// *
	// print_r($new_hook_list );
	// print_r($old_hook_list );
	// print_r($hook_remove_list );
	// */
	// foreach ($hook_remove_list as $handle) {
	// $handle = trim($handle);
	//
	// $mod_obj = Module::getInstanceByName('jscomposer');
	// $id_hook = Hook::getIdByName($handle);
	// $mod_obj->unregisterHook($id_hook);
	// }
	// print_r(Configuration::get('vc_custom_hook'));
	// if ($new_hook!='') {
	// $new_hook_list = explode("\n", $new_hook_list);
	// foreach ($new_hook_list as $inc) {
	// $inc = trim($new_hook);
	//
	// $mod_obj = Module::getInstanceByName('jscomposer');
	// $mod_obj->registerHook($inc);
	// }
	// }
	// $_POST['vc_custom_hook'] =  $fonts;
	// }

	public function initHeader() {
		// if (Tools::getValue('action') == 'importtinymce') {
		// JsComposer::installTinymce(false);
		// $redirect = $this->context->link->getAdminLink('AdminJsComposerSetting') . '&importsuccess=true';
		// Tools::redirectAdmin($redirect);
		// }
		parent::initHeader();
	}

}