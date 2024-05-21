<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
 */
if (!defined('_PS_VERSION_')) {
    exit();
}

/**
 * Function used to update your module from previous versions to the version 1.1,
 * Don't forget to create one file per version.
 */
function upgrade_module_1_5_3($module)
{
    include dirname(dirname(__FILE__)).'/sql/install.php';
    if (Tools::file_exists_no_cache(_PS_MODULE_DIR_.'ndksteppingpack/views/templates/admin/helpers/uploader/simple.tpl')) {
        @unlink(_PS_MODULE_DIR_.'ndksteppingpack/views/templates/admin/helpers/uploader/simple.tpl');
    }

    return true;
}
