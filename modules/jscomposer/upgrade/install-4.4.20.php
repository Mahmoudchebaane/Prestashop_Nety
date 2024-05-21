<?php
if (!defined('_PS_VERSION_'))
    exit;

function upgrade_module_4_4_20($object){
    $today           = date( 'Y-m-d' );
    Configuration::updateValue( 'VC_ULTIMATE_CHECK_DATE', $today );
    $object->registerHook('dashboardZoneOne');
    return true;
}