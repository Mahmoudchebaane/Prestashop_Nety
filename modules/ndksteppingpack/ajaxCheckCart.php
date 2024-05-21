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
require_once _PS_MODULE_DIR_ . 'ndksteppingpack/models/ndkSpack.php';
require_once _PS_MODULE_DIR_ . 'ndksteppingpack/models/ndkSpackStep.php';

$context = Context::getContext();
$saved_currency = $context->currency->id;
$context->currency->id = (int) Configuration::get('PS_CURRENCY_DEFAULT');

if (Tools::getValue('remove_product') && 1 == Tools::getValue('remove_product')) {
    $context->cart->updateQty((int) Tools::getValue('qtty'), (int) Tools::getValue('productId'), (int) Tools::getValue('productAttributeId'), false, 'down');
}
// $context->cart->deleteProduct((int)Tools::getValue('productId'), (int)Tools::getValue('productAttributeId'));

$languages = Language::getLanguages();
$id_lang = $context->language->id;

if (is_array(Tools::getValue('stepsLite'))) {
    $steps = Tools::getValue('stepsLite');
} else {
    $steps = json_decode(Tools::getValue('stepsLite'));
    $steps = dismount($steps);
}

// var_dump($steps);
$results = [];
$h = -1;
$i = 0;
$j = 1;
$finished = false;

if (!$context->cart->id) {
    $context->cart->add();
    $context->cookie->id_cart = (int) $context->cart->id;
}

$global_qtty = [];
$step_todo = false;
$step_cando = false;
$results[0]['step_todo'] = 0;
$results[0]['step_cando'] = 0;
$virtualPack = [];
if ($steps) {
    foreach ($steps as $step) {
        $step = dismount($step);
        $stepObj = new NdkSpackStep((int) $step['id']);
        $pids = $stepObj->getProducts(true);
        $ids = [];
        foreach ($pids as $pid) {
            $ids[] = $pid['id_product'];
        }
        $prodsIds = implode(',', $ids);

        $count_quantities = 0;
        $count = Db::getInstance()->getRow(
            'SELECT COUNT(*) as count   
	FROM `' . _DB_PREFIX_ . 'cart_product` cp 
	WHERE cp.`id_product` IN (' . pSQL($prodsIds) . ') AND id_cart = ' . (int) $context->cookie->id_cart
        );

        $id_products = Db::getInstance()->executeS(
            'SELECT id_product, quantity    
	FROM `' . _DB_PREFIX_ . 'cart_product` cp 
	WHERE cp.`id_product` IN (' . pSQL($prodsIds) . ') AND id_cart = ' . (int) $context->cookie->id_cart . ' GROUP BY id_product ORDER BY cp.date_add'
        );

        $count_sql = Db::getInstance()->executeS(
            'SELECT id_product, id_product_attribute, quantity    
	FROM `' . _DB_PREFIX_ . 'cart_product` cp 
	WHERE cp.`id_product` IN (' . pSQL($prodsIds) . ') AND id_cart = ' . (int) $context->cookie->id_cart . ' ORDER BY cp.date_add'
        );

        $prodIds = [];
        $prodIds[] = 0;
        $products = '';
        $results[$i]['resume'] = '';
        $results[$i]['added'] = [];
        $blockResume = Module::getInstanceByName('ndksteppingpack');

        foreach ($id_products as $products) {
            $prodIds[] = $products['id_product'];
            $cart = new Cart((int) $context->cookie->id_cart);
            // $products =$cart->getProducts(false, $products['id_product']);
            // $results[$i]['resume'] .= $blockResume->hookAjaxCall(array('products' => $products));
            $virtualPack[$steps[$i]['id']]['name'] = $steps[$i]['name'];

            $virtualPack[$steps[$i]['id']]['maximum'] = $steps[$i]['maximum'];
            $virtualPack[$steps[$i]['id']]['optionnal'] = $steps[$i]['optionnal'];
        }

        foreach ($count_sql as $row) {
            if ($count_quantities < $steps[$i]['maximum'] || 0 == $steps[$i]['maximum']) {
                if (!array_key_exists($row['id_product'] . '-' . $row['id_product_attribute'], $global_qtty)) {
                    $global_qtty[$row['id_product'] . '-' . $row['id_product_attribute']] = 0;
                }

                $prod_step_qtty = $row['quantity'] - (int) $global_qtty[$row['id_product'] . '-' . $row['id_product_attribute']];

                if ($prod_step_qtty + $count_quantities > $steps[$i]['maximum']) {
                    $prod_step_qtty -= $steps[$i]['maximum'];
                }

                $count_quantities += $prod_step_qtty;

                if ($prod_step_qtty > 0) {
                    $results[$i]['added'][] = ['id_product' => $row['id_product'], 'id_product_attribute' => $row['id_product_attribute'], 'qtty' => $prod_step_qtty];
                }

                $global_qtty[$row['id_product'] . '-' . $row['id_product_attribute']] += $prod_step_qtty;
            }
        }

        $resume_prod = [];
        foreach ($results[$i]['added'] as $incart) {
            $cart_products = $cart->getProducts(false);
            foreach ($cart_products as $prod) {
                // var_dump($prod);
                if ((int) $prod['id_product'] == (int) $incart['id_product'] && (int) $prod['id_product_attribute'] == (int) $incart['id_product_attribute']) {
                    $prod['cart_quantity'] = $incart['qtty'];
                    $resume_prod[] = $prod;
                }
            }
        }
        $virtualPack[$steps[$i]['id']]['products'][] = $resume_prod;
        $results[$i]['resume'] .= $blockResume->hookAjaxCall(['products' => $resume_prod, 'steps_nb' => count($steps)]);

        // var_dump($products);

        if (isset($steps[$j])) {
            $results[$i]['id'] = (int) $steps[$j]['id'];
        } else {
            $results[$i]['id'] = 999;
        }

        if ($h > -1) {
            $results[$i]['prev_step'] = (int) $steps[$h]['id'];
        } else {
            $results[$i]['prev_step'] = (int) $steps[$i]['id'];
        }

        $results[$i]['id_step'] = (int) $steps[$i]['id'];
        $results[$i]['count'] = $count_quantities;
        $results[$i]['id_step'] = (int) $steps[$i]['id'];
        $results[$i]['position'] = (int) $steps[$i]['position'];

        $results[$i]['disable_it'] = 0;

        if ((!$step_cando || false == $step_cando) && 0 == $step['minimum']) {
            $results[0]['step_cando'] = $steps[$i]['id'];
            $results[0]['optionnal'] = $steps[$i]['optionnal'];
            $step_cando = true;
        }

        if (($count_quantities >= $step['maximum']) && $step['maximum'] > 0) {
            $results[$i]['disable_it'] = 1;
        } else {
            $results[$i]['disable_it'] = 0;
        }

        if ($count_quantities >= $step['minimum']) {
            $results[$i]['status'] = 1;
            $finished = true;
        } else {
            $results[$i]['status'] = 0;
            if (!$step_todo || false == $step_todo) {
                $results[0]['step_todo'] = $steps[$i]['id'];
                $step_todo = true;
            }

            $finished = false;
        }
        ++$h;
        ++$i;
        ++$j;
    }
}
// var_dump($global_qtty);

if ($finished && Tools::getValue('create_pack')) {
    $pack = new NdkSpack(Tools::getValue('ndk_id_pack'), $id_lang);
    if (1 == $pack->type && $pack->id_pack_prod > 0) {
        $packProd = new Product($pack->id_pack_prod, $id_lang);
        if (!Validate::isLoadedObject($packProd)) {
            $pack->createProductPack();
            $packProd = new Product($pack->id_pack_prod, $id_lang);
        }

        $pack_price = 0;
        $opt_price = 0;
        $newWeight = 0;
        $newPackProd = NdkSpack::processDuplicatePack($packProd->id);
        $newPackProd->reference = Tools::str2url('Pack-' . $packProd->id . '-Cart-' . (int) $context->cart->id);
        $newPackProd->supplier_reference = Tools::str2url('myndkcustomprodPack');
        $newPackProd->cache_is_pack = 1;
        $newPackProd->pack_stock_type = 1;
        $newPackProd->available_for_order = 1;

        Db::getInstance()->delete('ndksteppingpack_order', 'id_cart = ' . (int) $context->cart->id . ' AND id_virtual_pack = ' . (int) $newPackProd->id);

        Db::getInstance()->delete('pack', 'id_product_pack = ' . (int) $newPackProd->id);

        $fields_nb = 0;
        foreach ($virtualPack as $vpack) {
            $labels = [];
            foreach ($languages as $language) {
                $labels[$language['id_lang']][0]['name'] = $vpack['name'];
            }
            $index = createLabel($languages, 1, $newPackProd->id, $labels);

            /*$field_ids = $newPackProd->getCustomizationFields($id_lang);
            foreach($field_ids as $row){
                if($row['name'] == $vpack['name'])
                {
                    $index = $row['id_customization_field'] ;
                }
            }*/
            $row = '';
            $incart = 0;

            $pack_available_quantity = 0;
            $last_quantity_encountred = 999999999999;

            // var_dump($vpack['products']);
            foreach ($vpack['products'] as $prod) {
                foreach ($prod as $prodItem) {
                    $maxP = $prodItem['cart_quantity'];
                    if (($vpack['maximum'] > 0) && (($prodItem['cart_quantity'] + $incart) > $vpack['maximum'])) {
                        $maxP = (int) $vpack['maximum'] - $incart;
                    }

                    // $products =$cart->getProducts(false, $prod['id_product']);
                    if ($prodItem['id_product_attribute'] > 0) {
                        $p = new Product((int) $prodItem['id_product']);
                        $accessorycombNames = $p->getAttributesResume(Context::getContext()->language->id);
                        foreach ($accessorycombNames as $comb) {
                            // var_dump($comb);
                            if ($comb['id_product_attribute'] == $prodItem['id_product_attribute']) {
                                $accessorycombName = $comb['attribute_designation'];
                            }
                        }
                    }

                    $row .= $maxP . 'X ' . $prodItem['name'] . ($prodItem['id_product_attribute'] > 0 ? ' | ' . $accessorycombName : '') . '; ';
                    // on renseigne la table pour gérer ensuite les stocks
                    Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'ndksteppingpack_order` (`id_cart`, `id_product`, `id_product_attribute`, `quantity`,`id_virtual_pack`)
						VALUES (' . (int) $context->cart->id . ', ' . (int) $prodItem['id_product'] . ', ' . (int) $prodItem['id_product_attribute'] . ', ' . (int) $maxP . ', ' . (int) $newPackProd->id . ')');

                    $pack_price += (float) ($prodItem['price'] * $maxP);

                    if (1 == $vpack['optionnal']) {
                        $opt_price += (float) ($prodItem['price'] * $maxP);
                    }

                    $newWeight += (float) $prodItem['weight'] * $maxP;
                    Pack::addItem((int) $newPackProd->id, (int) $prodItem['id_product'], (int) $maxP, (int) $prodItem['id_product_attribute']);

                    // on récupère la personnalisation du produit
                    if ($prodItem['id_customization'] > 0) {
                        copyCustomisations((int) $prodItem['id_customization'], (int) $newPackProd->id, $cart);
                    }

                    if ($maxP == $prodItem['cart_quantity']) {
                        $context->cart->deleteProduct((int) $prodItem['id_product'], (int) $prodItem['id_product_attribute']);
                    } else {
                        $context->cart->updateQty((int) $maxP, (int) $prodItem['id_product'], (int) $prodItem['id_product_attribute'], null, 'down');
                    }

                    $incart += $maxP;
                    if ((int) $maxP > 0) {
                        $prod_available = StockAvailable::getQuantityAvailableByProduct($prodItem['id_product'], $prodItem['id_product_attribute']) / $maxP;
                    } else {
                        $prod_available = StockAvailable::getQuantityAvailableByProduct($prodItem['id_product'], $prodItem['id_product_attribute']);
                    }

                    if ($prod_available < $last_quantity_encountred) {
                        $pack_available_quantity = $prod_available;
                        $last_quantity_encountred = $prod_available;
                    }
                }
            }
            $myIdCustomization = addTextFieldToProduct($newPackProd->id, $index, 1, $row);
            ++$fields_nb;
        }

        $pack_price += (float) $opt_price;
        $newPackProd->text_fields = $fields_nb;
        $newPackProd->minimal_quantity = 1;
        $newPackProd->quantity = 100;
        $newPackProd->weight = (float) $newWeight;
        $newPackProd->save();

        // Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'cart_rule_product_rule_value` (`id_product_rule`, `id_item`) VALUES ('.(int)$pack->id_product_rule.', '.(int)$newPackProd->id.')');

        if (0 == $pack->fixed_price) {
            $newPackProd->price = $pack_price;
            $newPackProd->save();

            // on ajoute la remise si necessaire
            if ($pack->reduction_amount > 0 || $pack->reduction_percent > 0) {
                if ($pack->reduction_percent > 0) {
                    $reduc = $pack->reduction_percent / 100;
                } else {
                    $reduc = $pack->reduction_amount;
                }

                $specific_price = new SpecificPrice();
                $specific_price->id_product = $newPackProd->id;
                $specific_price->id_product_attribute = 0;
                $specific_price->id_shop = (int) $context->shop->id;
                // $specific_price->id_currency = (int)$context->currency->id;
                $specific_price->id_currency = 0;
                $specific_price->id_shop_group = 0;
                $specific_price->id_specific_price_rule = 0;
                $specific_price->id_cart = 0;
                $specific_price->id_country = 0;
                $specific_price->id_group = 0;
                $specific_price->id_customer = 0;
                $specific_price->price = -1;
                $specific_price->from_quantity = 1;
                $specific_price->reduction_tax = 1;
                $specific_price->reduction_type = ($pack->reduction_amount > 0 ? 'amount' : 'percentage');
                $specific_price->reduction = $reduc;
                $specific_price->from = '0000-00-00 00:00:00';
                $specific_price->to = '0000-00-00 00:00:00';
                $specific_price->save();
            }
        } else {
            $newPackProd->price = $newPackProd->price + (float) $opt_price;
            $newPackProd->available_for_order = 1;

            $newPackProd->save();
        }
        if ($pack_available_quantity < 1) {
            $pack_available_quantity = 1;
        }
        // var_dump($opt_price);
        // on met à jour la quantité dispo
        Db::getInstance()->execute('
			UPDATE `' . _DB_PREFIX_ . 'stock_available` SET `quantity` = ' . (int) $pack_available_quantity . ' WHERE id_product = ' . (int) $newPackProd->id);

        Db::getInstance()->execute('
			UPDATE `' . _DB_PREFIX_ . 'product_shop` SET `available_for_order` = 1 WHERE id_product = ' . (int) $newPackProd->id);
        Db::getInstance()->execute('
			UPDATE `' . _DB_PREFIX_ . 'product` SET `available_for_order` = 1 WHERE id_product = ' . (int) $newPackProd->id);

        foreach ($vpack['products'] as $prod) {
            foreach ($prod as $prodItem) {
                $context->cart->updateQty((int) $prodItem['cart_quantity'], (int) $prodItem['id_product'], (int) $prodItem['id_product_attribute'], null, 'down');
            }
        }

        // var_dump($myIdCustomization);

        NdkSpack::duplicateGroupReductionCache($pack->id_pack_prod, $newPackProd->id);
        $context->cart->updateQty(1, $newPackProd->id, null, (int) $myIdCustomization);

        setInCart((int) $myIdCustomization);
    }
}

function setInCart($id_customization)
{
    Db::getInstance()->execute('
	UPDATE `' . _DB_PREFIX_ . 'customization`
	SET `in_cart` = 1
	WHERE `id_customization` = ' . (int) $id_customization);
}

echo json_encode($results);
// //var_dump($results);
// $context->cookie->id_cart;

function copyCustomisations($id_customization, $id_product, $cart)
{
    $result = Db::getInstance()->executeS('SELECT `type`, `index`, `value` FROM `' . _DB_PREFIX_ . 'customized_data` WHERE `id_customization` = ' . (int) $id_customization);

    foreach ($result as $row) {
        addTextFieldToProduct($id_product, $row['index'], $row['type'], $row['value']);
    }
    Db::getInstance()->delete('customization', 'id_customization = ' . (int) $id_customization);
}

function createLabel($languages, $type, $id_product, $labels, $required = 0)
{
    $count = 0;
    $id_customization_field = 0;
    if ('' != $labels[(int) Context::getContext()->language->id][0]['name']) {
        // on recherche un champs existant
        $result = Db::getInstance()->executeS('
	               SELECT cf.`id_product`, cfl.id_customization_field 
	               FROM `' . _DB_PREFIX_ . 'customization_field` cf
	               NATURAL JOIN `' . _DB_PREFIX_ . 'customization_field_lang` cfl
	               WHERE cf.`id_product` = ' . (int) $id_product . ' AND cfl.`id_lang` = ' . (int) Context::getContext()->language->id . ' AND cfl.name = \'' . pSQL($labels[(int) Context::getContext()->language->id][0]['name']) . '\' 
	               ORDER BY cf.`id_customization_field`');
        $count += sizeof($result);
    }

    if (0 == $count) {
        // Label insertion
        if (!Db::getInstance()->execute('
	            INSERT INTO `' . _DB_PREFIX_ . 'customization_field` (`id_product`, `type`, `required`)
	            VALUES (' . (int) $id_product . ', ' . (int) $type . ', ' . (int) $required . ')')
           || !$id_customization_field = (int) Db::getInstance()->Insert_ID()) {
            return false;
        }

        // Multilingual label name creation
        $values = '';

        foreach (Shop::getContextListShopID() as $id_shop) {
            foreach ($languages as $language) {
                $values .= '(' . (int) $id_customization_field . ', ' . (int) $language['id_lang'] . ', ' . (int) $id_shop . ', \'' . pSQL($labels[(int) Context::getContext()->language->id][0]['name']) . '\'), ';
            }
        }

        $values = rtrim($values, ', ');
        if (!Db::getInstance()->execute('
	            INSERT INTO `' . _DB_PREFIX_ . 'customization_field_lang` (`id_customization_field` ,`id_lang`, `id_shop`, `name`)
	            VALUES ' . $values)) {
            return false;
        }

        // Set cache of feature detachable to true
        Configuration::updateGlobalValue('PS_CUSTOMIZATION_FEATURE_ACTIVE', '1');
    } else {
        if ($result) {
            $id_customization_field = $result[0]['id_customization_field'];
        }
        Db::getInstance()->execute('
	            UPDATE `' . _DB_PREFIX_ . 'customization_field` SET `required` = ' . (int) $required . ' WHERE id_customization_field = ' . (int) $id_customization_field);
    }

    return (int) $id_customization_field;
}

function dismount($data)
{
    if (is_array($data) || is_object($data)) {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = dismount($value);
        }

        return $result;
    }

    return $data;
}

function addTextFieldToProduct($id_product, $index, $type, $text_value)
{
    return _addCustomization($id_product, 0, $index, $type, $text_value, 0);
}

/**
 * Add customer's pictures.
 *
 * @return bool Always true
 */
function addPictureToProduct($id_product, $index, $type, $file)
{
    return _addCustomization($id_product, 0, $index, $type, $file, 0);
}

function _addCustomization($id_product, $id_product_attribute, $index, $type, $field, $quantity)
{
    $context = Context::getContext();

    $exising_customization = Db::getInstance()->executeS(
        '
	         SELECT cu.`id_customization`, cd.`index`, cd.`value`, cd.`type` FROM `' . _DB_PREFIX_ . 'customization` cu
	         LEFT JOIN `' . _DB_PREFIX_ . 'customized_data` cd
	         ON cu.`id_customization` = cd.`id_customization`
	         WHERE cu.id_cart = ' . (int) $context->cart->id . '
	         AND cu.id_product = ' . (int) $id_product . '
	         AND in_cart = 0'
    );

    if ($exising_customization) {
        // If the customization field is alreay filled, delete it
        foreach ($exising_customization as $customization) {
            if ($customization['type'] == $type && $customization['index'] == $index) {
                Db::getInstance()->execute('
	                  DELETE FROM `' . _DB_PREFIX_ . 'customized_data`
	                  WHERE id_customization = ' . (int) $customization['id_customization'] . '
	                  AND type = ' . (int) $customization['type'] . '
	                  AND `index` = ' . (int) $customization['index']);
                if (Product::CUSTOMIZE_FILE == $type) {
                    @unlink(_PS_UPLOAD_DIR_ . $customization['value']);
                    @unlink(_PS_UPLOAD_DIR_ . $customization['value'] . '_small');
                }
                break;
            }
        }
        $id_customization = $exising_customization[0]['id_customization'];
    } else {
        Db::getInstance()->execute(
            'INSERT INTO `' . _DB_PREFIX_ . 'customization` (`id_cart`, `id_product`, `id_product_attribute`, `quantity`)
	            VALUES (' . (int) $context->cart->id . ', ' . (int) $id_product . ', ' . (int) $id_product_attribute . ', ' . (int) $quantity . ')'
        );
        $id_customization = Db::getInstance()->Insert_ID();
    }

    $query = 'INSERT INTO `' . _DB_PREFIX_ . 'customized_data` (`id_customization`, `type`, `index`, `value`)
	         VALUES (' . (int) $id_customization . ', ' . (int) $type . ', ' . (int) $index . ', \'' . pSQL($field) . '\')';

    if (!Db::getInstance()->execute($query)) {
        return false;
    }

    return $id_customization;
}
