<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2014 Hendrik Masson
 *  @license   Tous droits réservés
 */
include dirname(__FILE__) . '/../../config/config.inc.php';
include dirname(__FILE__) . '/../../init.php';
require_once _PS_MODULE_DIR_ . 'ndksteppingpack/models/ndkSpack.php';
require_once _PS_MODULE_DIR_ . 'ndksteppingpack/models/ndkSpackStep.php';

$context = Context::getContext();
$saved_currency = $context->currency->id;
$context->currency->id = (int) Configuration::get('PS_CURRENCY_DEFAULT');

$languages = Language::getLanguages();
$id_lang = $context->language->id;

$blockResume = Module::getInstanceByName('ndksteppingpack');
echo $blockResume->hookAjaxCall(['categorycontext' => Tools::getValue('id_category'), 'search' => '']);
