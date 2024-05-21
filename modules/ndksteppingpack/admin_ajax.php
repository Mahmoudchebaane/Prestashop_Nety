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

if ('ajaxGetProducts' == Tools::getValue('action')) {
    $query = Tools::getValue('q', false);
    if (!$query or '' == $query or strlen($query) < 1) {
        exit;
    }

    /*
     * In the SQL request the "q" param is used entirely to match result in database.
     * In this way if string:"(ref : #ref_pattern#)" is displayed on the return list,
     * they are no return values just because string:"(ref : #ref_pattern#)"
     * is not write in the name field of the product.
     * So the ref pattern will be cut for the search request.
     */
    if ($pos = strpos($query, ' (ref:')) {
        $query = substr($query, 0, $pos);
    }

    $excludeIds = Tools::getValue('excludeIds', false);
    if ($excludeIds && 'NaN' != $excludeIds) {
        $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
    } else {
        $excludeIds = '';
    }

    // Excluding downloadable products from packs because download from pack is not supported
    $excludeVirtuals = (bool) Tools::getValue('excludeVirtuals', true);
    $exclude_packs = (bool) Tools::getValue('exclude_packs', true);

    $context = Context::getContext();

    $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, image_shop.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
		FROM `' . _DB_PREFIX_ . 'product` p
		LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int) $context->language->id . Shop::addSqlRestrictionOnLang('pl') . ')
		LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
			ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
		LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $context->language->id . ')
		WHERE (pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\')' .
            (!empty($excludeIds) ? ' AND p.id_product NOT IN (' . $excludeIds . ') ' : ' ') .
            ($excludeVirtuals ? 'AND NOT EXISTS (SELECT 1 FROM `' . _DB_PREFIX_ . 'product_download` pd WHERE (pd.id_product = p.id_product))' : '') .
            ($exclude_packs ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '') .
            ' GROUP BY p.id_product';

    $items = Db::getInstance()->executeS($sql);

    if ($items && ($excludeIds || false !== strpos($_SERVER['HTTP_REFERER'], 'AdminScenes'))) {
        foreach ($items as $item) {
            echo trim(str_replace('|', '', $item['name'])) . (!empty(str_replace('|', '', $item['reference'])) ? ' (ref: ' . str_replace('|', '', $item['reference']) . ')' : '') . '|' . (int) $item['id_product'] . "\n";
        }
    } elseif ($items) {
        // packs
        $results = [];
        foreach ($items as $item) {
            // check if product have combination
            if (Combination::isFeatureActive() && $item['cache_default_attribute']) {
                $sql = 'SELECT pa.`id_product_attribute`, pa.`reference`, ag.`id_attribute_group`, pai.`id_image`, agl.`name` AS group_name, al.`name` AS attribute_name,
						a.`id_attribute`
					FROM `' . _DB_PREFIX_ . 'product_attribute` pa
					LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
					LEFT JOIN `' . _DB_PREFIX_ . 'attribute` a ON a.`id_attribute` = pac.`id_attribute`
					LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
					LEFT JOIN `' . _DB_PREFIX_ . 'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ' . (int) $context->language->id . ')
					LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ' . (int) $context->language->id . ')
					LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_image` pai ON pai.`id_product_attribute` = pa.`id_product_attribute`
					WHERE pa.`id_product` = ' . (int) $item['id_product'] . '
					GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`
					ORDER BY pa.`id_product_attribute`';

                $combinations = Db::getInstance()->executeS($sql);
                if (!empty($combinations)) {
                    foreach ($combinations as $k => $combination) {
                        $results[$combination['id_product_attribute']]['id'] = $item['id_product'];
                        $results[$combination['id_product_attribute']]['id_product_attribute'] = $combination['id_product_attribute'];
                        !empty($results[$combination['id_product_attribute']]['name']) ? $results[$combination['id_product_attribute']]['name'] .= ' ' . $combination['group_name'] . '-' . $combination['attribute_name']
                        : $results[$combination['id_product_attribute']]['name'] = str_replace('|', '', $item['name']) . ' ' . $combination['group_name'] . '-' . $combination['attribute_name'];
                        if (!empty($combination['reference'])) {
                            $results[$combination['id_product_attribute']]['ref'] = $combination['reference'];
                        } else {
                            $results[$combination['id_product_attribute']]['ref'] = !empty(str_replace('|', '', $item['reference'])) ? str_replace('|', '', $item['reference']) : '';
                        }
                        if (empty($results[$combination['id_product_attribute']]['image'])) {
                            $results[$combination['id_product_attribute']]['image'] = str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $combination['id_image'], ImageType::getFormattedName('home')));
                        }
                    }
                } else {
                    $product = [
                        'id' => (int) $item['id_product'],
                        'name' => str_replace('|', '', $item['name']),
                        'ref' => (!empty(str_replace('|', '', $item['reference'])) ? str_replace('|', '', $item['reference']) : ''),
                        'image' => str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $item['id_image'], ImageType::getFormattedName('home'))),
                    ];
                    array_push($results, $product);
                }
            } else {
                $product = [
                    'id' => (int) $item['id_product'],
                    'name' => str_replace('|', '', $item['name']),
                    'ref' => (!empty(str_replace('|', '', $item['reference'])) ? str_replace('|', '', $item['reference']) : ''),
                    'image' => str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $item['id_image'], ImageType::getFormattedName('home'))),
                ];
                array_push($results, $product);
            }
        }
        $results = array_values($results);
        echo json_encode($results);
    } else {
        json_encode(new stdClass());
    }
}
