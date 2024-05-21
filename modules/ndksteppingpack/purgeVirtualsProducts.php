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

$sql = 'SELECT p.id_product FROM ' . _DB_PREFIX_ . "product p 
	WHERE p.reference LIKE '%pack-%'
	AND p.supplier_reference LIKE 'myndkcustomprodPack' 
	AND p.id_product NOT IN( SELECT product_id FROM " . _DB_PREFIX_ . 'order_detail) 
	AND p.date_add < DATE_SUB(DATE(NOW()), INTERVAL 3 DAY)';

$products = Db::getInstance()->executeS($sql);
foreach ($products as $product) {
    $tempProd = new Product($product['id_product']);

    if ('myndkcustomprodpack' == Tools::strtolower($tempProd->supplier_reference)) {
        echo $tempProd->supplier_reference;
        $tempProd->delete();
        $sqlc = 'SELECT c.id_customization FROM ' . _DB_PREFIX_ . 'customization c 
			WHERE c.id_product = ' . (int) $product['id_product'];

        $customisation = new Customization((int) Db::getInstance()->getRow($sqlc));
        $customisation->delete();
    }
}
