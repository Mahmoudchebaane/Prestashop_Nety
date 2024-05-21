<?php
if ( ! defined( '_PS_VERSION_' ) ) {
	exit;
}

function upgrade_module_4_4_16( $object ) {
	 $controllers = Configuration::get( 'VC_ENQUEUED_CONTROLLERS' );
	$controllers  = Tools::jsonDecode( $controllers, true );

	$controller_exists = false;
	foreach ( $controllers as $key => $controller ) {
		if ( 'vccontentanywhere' == $key ) {
			if ( $controller['controller'] == 'Adminvccontentanywhere' ) {
				unset( $controllers[ $key ] );
			}
			if ( $controller['controller'] == 'AdminProducts' ) {
				unset( $controllers[ $key ] );
			}
		}
	}
	return true;
}
