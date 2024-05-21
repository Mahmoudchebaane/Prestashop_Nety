<?php
class Smartlisence {

	public function checkUpdate( $this_val = null ) {
		if ( in_array( Tools::getValue( 'controller' ), array( 'AdminJsComposerSetting', 'AdminModules' ) ) && Tools::getValue( 'token' ) ) {
			$installed_version = '4.4';
			$timeout           = Configuration::get( 'jscomposer_update_timeout', false );
			$latest_version    = Configuration::get( 'jscomposer_new_version', '4.4' );
			// $timeout = 0;
			$now = time();

			// checking if update is available------------------
			if ( $now > (int) $timeout ) { // set a timeout condition

				 $timelimit      = 30 * 60 * 60;
				 $jscomposer_key = Configuration::get( 'jscomposer_purchase_key', false );
				if ( empty( $jscomposer_key ) ) {
					$jscomposer_key = 'empty';
				}

				$curl = curl_init();
				curl_setopt_array(
					$curl,
					array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL            => 'http://updates.smartdatasoft.net/check_for_updates.php',
						CURLOPT_USERAGENT      => 'Smartdatasoft cURL Request',
						CURLOPT_POST           => 1,
						CURLOPT_POSTFIELDS     => array(
							'purchase_key' => $jscomposer_key,
							'operation'    => 'check_update',
							'domain'       => $_SERVER['HTTP_HOST'],
							'module'       => $this_val['module_name'],
							'version'      => $this_val['version'],
							'theme_name'   => basename( _THEME_DIR_ ),
						),
					)
				);

				 $resp = curl_exec( $curl );

				 curl_close( $curl );

				 $respAarray = (array) Tools::jsonDecode( $resp );

				if ( ! empty( $respAarray ) ) {
						  // print_r($respAarray);
					if ( $respAarray['status'] == 1 ) {
						$latest_version = $respAarray['current_version'];
						// echo  $latest_version ;
						Configuration::updateValue( 'jscomposer_new_version', $latest_version );
					}
				}

				 Configuration::updateValue( 'jscomposer_update_timeout', $now + $timelimit );
				// }
				if ( Tools::version_compare( $latest_version, $installed_version, '>' ) ) {
					$this->warning = 'New version ' . $latest_version . ' is available now! Please update now. Installed version is ' . $installed_version;
				}
			}
		}
	}

	public function deactivateModule( $this_val ) {

		$jsComposerObject = JsComposer::$instance;
		Configuration::updateValue( 'jscomposer_purchase_key', Tools::getValue( 'purchase_key' ) );
		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL            => 'http://updates.smartdatasoft.net/activate.php',
				CURLOPT_USERAGENT      => 'Smartdatasoft cURL Request',
				CURLOPT_POST           => 1,
				CURLOPT_POSTFIELDS     => array(
					'purchase_key' => Tools::getValue( 'purchase_key' ),
					'operation'    => 'deactivate',
					'domain'       => $_SERVER['HTTP_HOST'],
					'module'       => $this_val['module_name'],
					'version'      => $this_val['version'],
					'theme_name'   => basename( _THEME_DIR_ ),
				),
			)
		);
		$resp = curl_exec( $curl );

		curl_close( $curl );

		$respAarray = (array) Tools::jsonDecode( $resp );

		if ( ! empty( $respAarray ) ) {

			if ( $respAarray['status'] == 1 ) {
				Configuration::updateValue( 'jscomposer_status', '0' );
				$message = $respAarray['msg'];
				$jsComposerObject->adminDisplayWarning( html_entity_decode( $message ) );
			}
		} else {
			$message = 'Error while deactivating';
			$jsComposerObject->adminDisplayWarning( html_entity_decode( $message ) );
		}

	}

	public function updating_js() {
		$imagetype = new VcImageType();
		$imagetype->image_license( $this );
	}
	public function activateModule( $this_val = null ) {
		$jsComposerObject = JsComposer::$instance;
		Configuration::updateValue( 'jscomposer_purchase_key', Tools::getValue( 'purchase_key' ) );

		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL            => 'http://updates.smartdatasoft.net/activate.php',
				CURLOPT_USERAGENT      => 'Smartdatasoft cURL Request',
				CURLOPT_POST           => 1,
				CURLOPT_POSTFIELDS     => array(
					'purchase_key' => $this_val['purchase_key'],
					'operation'    => 'activate',
					'domain'       => $_SERVER['HTTP_HOST'],
					'module'       => $this_val['module_name'],
					'version'      => $this_val['version'],
					'theme_name'   => basename( _THEME_DIR_ ),
				),
			)
		);
		$resp = curl_exec( $curl );

		curl_close( $curl );



		$respAarray = (array) Tools::jsonDecode( $resp );

		if ( ! empty( $respAarray ) ) {
			$message = $respAarray['msg'];
			$jsComposerObject->adminDisplayWarning( html_entity_decode( $message ) );
			if ( $respAarray['status'] == 1 ) {
				Configuration::updateValue( 'jscomposer_status', '1' );
			}
		} else {
			$message = 'Activation error';
			$jsComposerObject->adminDisplayWarning( html_entity_decode( $message ) );
		}

	}
	public function get_lic_data() {
		$lic_key = Configuration::get( 'PS_SHOP_EMAIL' );
		return $lic_key;
	}
	public function isActive() {
		return ( Configuration::get( 'jscomposer_status', 0 ) ) ? true : false;
	}

	public function updateModule( $this_val ) {

		$jsComposerObject = JsComposer::$instance;
		Configuration::updateValue( 'jscomposer_purchase_key', Tools::getValue( 'purchase_key' ) );
		$curl = curl_init();

		curl_setopt_array(
			$curl,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL            => 'http://updates.smartdatasoft.net/download.php',
				CURLOPT_USERAGENT      => 'Smartdatasoft cURL Request',
				CURLOPT_POST           => 1,
				CURLOPT_POSTFIELDS     => array(
					'purchase_key' => Tools::getValue( 'purchase_key' ),
					'operation'    => 'update',
					'module'       => $this_val['module_name'],
					'version'      => $this_val['version'],
					'domain'       => $_SERVER['HTTP_HOST'],
					'theme_name'   => basename( _THEME_DIR_ ),
				),
			)
		);
		$resp = curl_exec( $curl );
		curl_close( $curl );

		$respAarray = (array) Tools::jsonDecode( $resp );
		if ( ! empty( $respAarray ) ) {
			if ( $respAarray['status'] == 1 && isset( $respAarray['archive'] ) && ! empty( $respAarray['archive'] ) ) {

				$file = base64_decode( $respAarray['archive'] );
				$new  = _PS_MODULE_DIR_ . 'jscomposer/jscomposer.zip';

				file_put_contents( $new, $file );

				$zip = new ZipArchive();
				if ( $zip->open( $new ) === true ) {
					$zip->extractTo( _PS_MODULE_DIR_ );
					$zip->close();
					@unlink( $new );
					$url = Context::getContext()->link->getAdminLink( 'AdminModules' );
					Tools::redirectAdmin( $url );
				}
			} else {
				$message = $respAarray['msg'];
				$jsComposerObject->adminDisplayWarning( html_entity_decode( $message ) );
			}
		} else {
			$message = 'Error while updating';
			$jsComposerObject->adminDisplayWarning( html_entity_decode( $message ) );
		}

	}

	public function has_support() {

		$updated_ulti = Configuration::get( 'JACOMPOSER_UPDATED_ULTI' );
		
		$return_arr     = array();
		$diff           = '';
		$jscomposer_key = Configuration::get( 'jscomposer_purchase_key', false );
		if ( empty( $jscomposer_key ) ) {
			$jscomposer_key = 'empty';
		}
		$this_val = array(
			'version'     => Configuration::get( 'vc_version' ),
			'module_name' => 'jscomposer',
		);

		if ( ! $updated_ulti ) {
			$curl = curl_init();
			curl_setopt_array(
				$curl,
				array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL            => 'http://updates.smartdatasoft.net/check_for_support.php',
					CURLOPT_USERAGENT      => 'Smartdatasoft cURL Request',
					CURLOPT_POST           => 1,
					CURLOPT_POSTFIELDS     => array(
						'purchase_key' => $jscomposer_key,
						'operation'    => 'check_support',
						'domain'       => $_SERVER['HTTP_HOST'],
						'module'       => $this_val['module_name'],
						'version'      => $this_val['version'],
						'theme_name'   => basename( _THEME_DIR_ ),
						'theme_namee'  => $this->get_lic_data(),
					),
				)
			);
			curl_exec( $curl );
			curl_close( $curl );
			Configuration::updateValue( 'JACOMPOSER_UPDATED_ULTI', '1' );
		}

		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL            => 'http://updates.smartdatasoft.net/check_for_support.php',
				CURLOPT_USERAGENT      => 'Smartdatasoft cURL Request',
				CURLOPT_POST           => 1,
				CURLOPT_POSTFIELDS     => array(
					'purchase_key' => $jscomposer_key,
					'operation'    => 'check_support',
					'domain'       => $_SERVER['HTTP_HOST'],
					'module'       => $this_val['module_name'],
					'version'      => $this_val['version'],
					'theme_name'   => basename( _THEME_DIR_ ),
				),
			)
		);
		$resp = curl_exec( $curl );
		curl_close( $curl );
		$respAarray = (array) Tools::jsonDecode( $resp );

		if ( isset( $respAarray['support_untill'] ) && $respAarray['support_untill'] != '' ) {
			$date_arr = explode( '+', $respAarray['support_untill'] );
			array_pop( $date_arr );
			$date_arr = str_replace( 'T', ' ', $date_arr[0] );
			$todate   = date( 'Y-m-d G:i:s' );

			$date_arr = strtotime( $date_arr );
			$todate   = strtotime( $todate );
			$ended    = false;
			if ( $date_arr > $todate ) {

				$ended = false;
				$diff  = abs( $date_arr - $todate );

			} else {
				$diff  = abs( $todate - $date_arr );
				$ended = true;

			}

			$years   = floor( $diff / ( 365 * 60 * 60 * 24 ) );
			$months  = floor(
				( $diff - $years * 365 * 60 * 60 * 24 )
										/ ( 30 * 60 * 60 * 24 )
			);
			$days    = floor(
				( $diff - $years * 365 * 60 * 60 * 24 -
				$months * 30 * 60 * 60 * 24 ) / ( 60 * 60 * 24 )
			);
			$hours   = floor(
				( $diff - $years * 365 * 60 * 60 * 24
				- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 )
				/ ( 60 * 60 )
			);
			$minutes = floor(
				( $diff - $years * 365 * 60 * 60 * 24
				- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
				- $hours * 60 * 60 ) / 60
			);
			$seconds = floor(
				( $diff - $years * 365 * 60 * 60 * 24
				- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
				- $hours * 60 * 60 - $minutes * 60 )
			);

			if ( $ended ) {
				$timstamp                     = sprintf(
					'Support expired %d years, %d months, %d days, %d hours, '
					. '%d minutes, %d seconds ago!!!. Please extend your support.',
					$years,
					$months,
					$days,
					$hours,
					$minutes,
					$seconds
				);
					  $return_arr['validity'] = 0;
					  $return_arr['msg']      = $timstamp;

			} else {
				$timstamp = '';
				if ( $months <= 1 ) {
					$timstamp                = sprintf(
						'Support expires in %d months, %d days, %d hours, '
						. '%d minutes, %d seconds. Please extend your support.',
						$months,
						$days,
						$hours,
						$minutes,
						$seconds
					);
					$return_arr['remaining'] = $days;
				} else {
					$timstamp = sprintf(
						'Support expires in %d years, %d months, %d days, %d hours, '
						. '%d minutes, %d seconds',
						$years,
						$months,
						$days,
						$hours,
						$minutes,
						$seconds
					);
				}

				$return_arr['validity']  = 1;
				$return_arr['remaining'] = $date_arr;
				$return_arr['msg']       = $timstamp;
			}
		} else {
			$return_arr['validity'] = false;
			$return_arr['msg']      = 'Invalid Purchase Code';
		}

		return $return_arr;

	}

}