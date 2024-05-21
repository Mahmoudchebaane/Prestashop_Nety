<?php
if ( ! defined( '_PS_VERSION_' ) ) {
	exit;
}

function upgrade_module_4_4_28( $object ) {
	$id_tab   = (int) Tab::getIdFromClassName( 'AdminOurProducts' );
	$id_parent = (int) Tab::getIdFromClassName( 'Adminjscomposer' );

	if ( ! $id_tab ) {
		$tab             = new Tab();
		$tab->active     = 1;
		$tab->class_name = 'AdminOurProducts';
		$tab->name       = array();
		foreach ( Language::getLanguages( true ) as $lang ) {
			$tab->name[ $lang['id_lang'] ] = 'Our Products';
		}
		$tab->id_parent = $id_parent;
		$tab->module    = $object->name;

		$tab->add();
	}
	return true;

}
