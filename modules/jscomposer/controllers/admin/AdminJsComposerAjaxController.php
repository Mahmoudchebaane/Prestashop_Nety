<?php
defined( '_PS_VERSION_' ) or die( 'No Direct Access Allowed' );

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

require_once dirname( __FILE__ ) . '/../../classes/VcImageType.php';
require_once dirname( __FILE__ ) . '/../../classes/vccontentanywhere.php';
require_once dirname( __FILE__ ) . '/../../classes/vcproducttabcreator.php';
require_once dirname( __FILE__ ) . '/../../classes/smartlisence.php';

class AdminJsComposerAjaxController extends AdminController {




	public function __construct() {
		$this->display_header = false;
		$this->display_footer = false;
		$this->content_only   = true;
		parent::__construct();
		$this->_ajax_results['error_on'] = 1;
	}
	public function init() {
		switch ( Tools::getValue( 'method' ) ) {
			case 'changeJsModuleStatus':
				$controllers = Configuration::get( 'VC_ENQUEUED_CONTROLLERS' );
				$controllers = Tools::jsonDecode( $controllers, true );
				foreach ( $controllers as $key => $controller ) {
					if ( Tools::getValue( 'module_name' ) == $key ) {
						$controllers[ $key ]['module_status'] = Tools::getValue( 'status' );
					}
				}
				Configuration::updateValue( 'VC_ENQUEUED_CONTROLLERS', Tools::jsonEncode( $controllers ) );
				break;
			case 'changeFrontendEnableStatus':
				$controllers = Configuration::get( 'VC_ENQUEUED_CONTROLLERS' );
				$controllers = Tools::jsonDecode( $controllers, true );
				foreach ( $controllers as $key => $controller ) {
					if ( Tools::getValue( 'module_name' ) == $key ) {
						$controllers[ $key ]['module_frontend_enable'] = Tools::getValue( 'status' );
					}
				}
				Configuration::updateValue( 'VC_ENQUEUED_CONTROLLERS', Tools::jsonEncode( $controllers ) );
				break;
			case 'changeJsModuleBFStatus':
				$controllers = Configuration::get( 'VC_ENQUEUED_CONTROLLERS' );

				$controllers = Tools::jsonDecode( $controllers, true );

				foreach ( $controllers as $key => $controller ) {
					if ( Tools::getValue( 'module_name' ) == $key ) {
						$controllers[ $key ][ Tools::getValue( 'js_module_status_for' ) ] = Tools::getValue( 'status' );
					}
				}

				$Smartlisence = new Smartlisence();
				$status       = false;

				if ( $Smartlisence->isActive() and Tools::getValue( 'module_name' ) == 'vccontentanywhere' ) {
					Configuration::updateValue( 'VC_ENQUEUED_CONTROLLERS', Tools::jsonEncode( $controllers ) );
					$status = true;
				} elseif ( Tools::getValue( 'module_name' ) != 'vccontentanywhere' ) {
					Configuration::updateValue( 'VC_ENQUEUED_CONTROLLERS', Tools::jsonEncode( $controllers ) );
					$status = true;
				}
				$result = array(
					'status' => $status,
				);
				echo json_encode( $result );
				break;
			case 'changeUltimateStatus':
				$Smartlisence = new Smartlisence();
				$status       = false;
				$msg          = '';
				$ulti_status  = Tools::getValue( 'ulti_status' );

				if ( $ulti_status ) {
					Configuration::updateValue( 'VC_ULTIMATE_STATUS', 0 );
					$msg    = 'Ultimate Addons <strong>Deactivated</strong>';
					$result = array(
						'status' => 0,
						'msg'    => $msg,
					);
					echo json_encode( $result );
					die();
				}

				if ( $Smartlisence->isActive() and Tools::getValue( 'module_name' ) == 'ultimateaddons' ) {
					$support_data = $Smartlisence->has_support();
					if ( $support_data['validity'] ) {
						$status = true;
						$msg    = 'Ultimate Addons <strong>Activated</strong>';
						Configuration::updateValue( 'VC_ULTIMATE_STATUS', 1 );

					} else {
						$msg = $support_data['msg'];
						Configuration::updateValue( 'VC_ULTIMATE_STATUS', 0 );

					}
				} else {
					$msg = 'Licence is not Activated!!!';
				}
				$result = array(
					'status' => $status,
					'msg'    => $msg,
				);
				echo json_encode( $result );
				break;
			case 'deleteJsModule':
				$controllers = Configuration::get( 'VC_ENQUEUED_CONTROLLERS' );
				$controllers = Tools::jsonDecode( $controllers, true );
				foreach ( $controllers as $key => $controller ) {
					if ( Tools::getValue( 'module_name' ) == $key ) {
						if ( $controllers[ $key ]['type'] != 'core' ) {
							unset( $controllers[ $key ] );
						}
					}
				}
				Configuration::updateValue( 'VC_ENQUEUED_CONTROLLERS', Tools::jsonEncode( $controllers ) );
				break;
			case 'addJsModule':
				$controllers = Configuration::get( 'VC_ENQUEUED_CONTROLLERS' );
				$controllers = Tools::jsonDecode( $controllers, true );

				$new_controller[ Tools::getValue( 'js_module_name' ) ] = array(
					'controller'             => Tools::getValue( 'js_controller_name' ),
					'identifier'             => Tools::getValue( 'js_controller_identifier' ),
					'shortname'              => Tools::getValue( 'js_controller_shortname' ),
					'field'                  => Tools::getValue( 'js_controller_field' ),
					'dbtable'                => Tools::getValue( 'js_controller_table' ),
					'module_status'          => 1,
					'module_frontend_status' => 1,
					'module_backend_status'  => 1,
					'type'                   => 'custom',
				);

				$Smartlisence = new Smartlisence();
				$status       = false;
				$success      = false;
				if ( $Smartlisence->isActive() ) {
					$status            = true;
					$controller_exists = false;
					foreach ( $controllers as $key => $controller ) {
						if ( Tools::getValue( 'js_module_name' ) == $key ) {
							if ( $controller['controller'] == Tools::getValue( 'js_controller_name' ) ) {
								$controller_exists = true;
							}
						}
					}
					if ( $controller_exists ) {
						$success = false;
					} else {
						$success     = true;
						$controllers = array_merge( $controllers, $new_controller );
						Configuration::updateValue( 'VC_ENQUEUED_CONTROLLERS', Tools::jsonEncode( $controllers ) );
					}
				}
				$result = array(
					'status'  => $status,
					'success' => $success,
				);
				echo json_encode( $result );
				break;
			default:
				die();
		}
		die();
	}
}
