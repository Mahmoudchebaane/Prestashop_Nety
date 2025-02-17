<?php
/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * You must not modify, adapt or create derivative works of this source code
 *
 * @author Mr. APPs
 * @copyright Mr. APPs 2023
 * @license Mr. APPs
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_0_10($module)
{
    // Hook Languages
    $module->registerHook('actionObjectLanguageAddAfter');
    $module->registerHook('actionObjectLanguageUpdateAfter');
    $module->registerHook('actionObjectLanguageDeleteAfter');

    return true;
}
