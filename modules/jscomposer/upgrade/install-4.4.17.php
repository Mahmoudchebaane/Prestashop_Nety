<?php
if ( ! defined( '_PS_VERSION_' ) ) {
	exit;
}

function upgrade_module_4_4_17( $object ) {
	 $id_tab   = (int) Tab::getIdFromClassName( 'AdminFontManager' );
	$id_parent = (int) Tab::getIdFromClassName( 'Adminjscomposer' );

	Configuration::updateValue( 'VC_ULTIMATE_STATUS', '0' );
	Configuration::updateValue( 'VC_ULTIMATE_CHECK', '0' );

	if ( ! $id_tab ) {
		$tab             = new Tab();
		$tab->active     = 1;
		$tab->class_name = 'AdminFontManager';
		$tab->name       = array();
		foreach ( Language::getLanguages( true ) as $lang ) {
			$tab->name[ $lang['id_lang'] ] = 'Ultimate Addons Manager';
		}
		$tab->id_parent = $id_parent;
		$tab->module    = $object->name;

		$tab->add();
	}
	return true;

}
