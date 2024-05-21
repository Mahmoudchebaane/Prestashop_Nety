<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
 */
include dirname(__FILE__) . '/../../config/config.inc.php';
include dirname(__FILE__) . '/../../init.php';

Context::getContext()->controller->php_self = 'module-ndksteppingpack-default';
$ndksteppingpack = Module::getInstanceByName('ndksteppingpack');
echo $ndksteppingpack->ajaxCall();
