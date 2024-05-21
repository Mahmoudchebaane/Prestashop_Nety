<?php
if (!defined('_PS_VERSION_'))
    exit;

function upgrade_module_4_4_22($object){
    $object->registerHook('dashboardZoneOne');
    $id_hook = (int) Hook::getIdByName('dashboardZoneOne');
	$object->updatePosition($id_hook, 0, 1);
    return true;
}