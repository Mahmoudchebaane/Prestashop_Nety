<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
 */
class NdkSpack extends ObjectModel
{
    /** @var string Name */
    public $id_ndksteppingpack;
    public $name;
    public $description;
    public $short_description;
    public $id_shop;
    public $id_cart_rule;
    public $id_product_rule_group;
    public $id_product_rule;
    public $id_pack_prod;
    public $type;
    public $position;
    public $reduction_amount;
    public $reduction_percent;
    public $fixed_price;
    public $active;
    public $display_categories;

    protected static $cacheIsVirtualPack = [];

    public static $definition = [
        'table' => 'ndksteppingpack',
        'primary' => 'id_ndksteppingpack',
        'multilang' => true,
        'fields' => [
            'position' => [
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false,
            ],
            'id_cart_rule' => [
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false,
            ],
            'id_product_rule_group' => [
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false,
            ],
            'id_product_rule' => [
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false,
            ],
            'id_pack_prod' => [
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false,
            ],
            'type' => [
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false,
            ],
            'reduction_amount' => [
                'type' => self::TYPE_FLOAT,
                'validate' => 'isPrice',
                'required' => false,
            ],
            'reduction_percent' => [
                'type' => self::TYPE_FLOAT,
                'validate' => 'isPrice',
                'required' => false,
            ],
            'fixed_price' => [
                'type' => self::TYPE_FLOAT,
                'validate' => 'isPrice',
                'required' => false,
            ],
            'name' => [
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isGenericName',
                'required' => true,
            ],
            'description' => [
                'type' => self::TYPE_HTML,
                'lang' => true,
                'validate' => 'isCleanHtml',
                'size' => 3999999999999,
            ],
            'short_description' => [
                'type' => self::TYPE_HTML,
                'lang' => true,
                'validate' => 'isCleanHtml',
                'size' => 150,
            ],
            'active' => [
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false,
            ],
            'display_categories' => [
                'type' => self::TYPE_STRING,
                'required' => false,
                'lang' => false,
            ],
        ],
    ];

    public static function getRelatedPacks($id_category = null)
    {
        $sql_query =
            'SELECT cp.id_ndksteppingpack  
		FROM `' .
            _DB_PREFIX_ .
            'ndksteppingpack` cp ' .
            (Shop::isFeatureActive()
                ? 'LEFT JOIN `' .
                    _DB_PREFIX_ .
                    'ndksteppingpack_shop` shop ON (shop.`id_ndksteppingpack`= cp.`id_ndksteppingpack`) '
                : ' ') .
            'WHERE FIND_IN_SET( ' .
            (int) $id_category .
            ', cp.`display_categories`)';

        return Db::getInstance()->executeS($sql_query);
    }

    public static function getPacks(
        $ids = null,
        $id_category = null,
        $query = null
    ) {
        $id_lang = Context::getContext()->language->id;
        $where_product = '';

        if (Shop::isFeatureActive()) {
            $where_product .=
                'WHERE shop.id_shop = ' .
                (int) Context::getContext()->shop->id .
                ' ';
        } else {
            $where_product .= 'WHERE 1 ';
        }

        /*if(isset($id_product) && $id_product != null && $id_product > 0)
        {
            $where_product .= 'AND ( FIND_IN_SET( '.(int)$id_product. ', cps.`products`) ';
            $categories = Product::getProductCategories((int)$id_product);
            foreach($categories as $cat)
                $where_product .= ' OR FIND_IN_SET( '.(int)$cat. ', cps.`categories`)';

            $where_product .=')';

        }*/
        if (isset($ids) && null != $ids) {
            $where_product .= 'AND cp.id_ndksteppingpack IN (' . implode(',', array_map('intval', $ids)) . ')';
            // var_dump(implode(',', $ids));
        }

        if (isset($id_category) && $id_category > 0) {
            // $prodIDs = Db::getInstance()->executeS('SELECT id_product FROM `'._DB_PREFIX_.'category_product` WHERE id_category = '.(int)$id_category);
            $where_product .=
                ' AND (FIND_IN_SET( ' .
                (int) $id_category .
                ', cps.`categories`) ';
            $where_product .=
                ' OR FIND_IN_SET( ' .
                (int) $id_category .
                ', cp.`display_categories`)';
            // foreach($prodIDs as $prod)
            // 	$where_product .= ' OR FIND_IN_SET( '.(int)$prod['id_product']. ', cps.`products`)';

            $where_product .= ')';
        }

        if (isset($query) && '' != $query) {
            $where_product .=
                ' AND (cpl.name LIKE "%' .
                pSQL($query) .
                '%" OR cpl.description LIKE "%' .
                pSQL($query) .
                '%" OR cpl.short_description LIKE "%' .
                pSQL($query) .
                '%")';
        }

        $sql_query =
            'SELECT cp.*, cpl.*   
		FROM `' .
            _DB_PREFIX_ .
            'ndksteppingpack` cp 
		LEFT JOIN `' .
            _DB_PREFIX_ .
            'ndksteppingpack_lang` cpl ON (cpl.`id_ndksteppingpack`= cp.`id_ndksteppingpack`AND cpl.`id_lang` = ' .
            (int) $id_lang .
            ' ) 
		LEFT JOIN `' .
            _DB_PREFIX_ .
            'ndksteppingpack_step` cps ON (cps.`id_ndksteppingpack`= cp.`id_ndksteppingpack`) ' .
            (Shop::isFeatureActive()
                ? 'LEFT JOIN `' .
                    _DB_PREFIX_ .
                    'ndksteppingpack_shop` shop ON (shop.`id_ndksteppingpack`= cp.`id_ndksteppingpack`) '
                : ' ') .
            $where_product .
            ' AND cp.active =1 GROUP BY  cp.`id_ndksteppingpack`';

        $packs = Db::getInstance()->executeS($sql_query);

        // var_dump($sql_query);

        $i = 0;
        foreach ($packs as $pack) {
            $packs[$i]['link'] = NdkSpack::linkPack(
                $pack['id_ndksteppingpack'],
                null
            );

            if ($pack['id_cart_rule'] > 0) {
                $packs[$i]['cart_rule'] = true;
            } else {
                $packs[$i]['cart_rule'] = false;
            }

            if ($packs[$i]['fixed_price'] > 0) {
                $packs[$i]['fixed_price'] = Product::getPriceStatic(
                    (int) $pack['id_pack_prod']
                );
            }

            ++$i;
        }

        return $packs;
    }

    public static function getPacksCount(
        $id_product = null,
        $id_category = null,
        $query = null
    ) {
        $id_lang = Context::getContext()->language->id;
        $where_product = '';

        if (Shop::isFeatureActive()) {
            $where_product .=
                'WHERE shop.id_shop = ' .
                (int) Context::getContext()->shop->id .
                ' ';
        } else {
            $where_product .= 'WHERE 1 ';
        }

        if (isset($id_product) && null != $id_product && $id_product > 0) {
            $where_product .=
                'AND ( FIND_IN_SET( ' .
                (int) $id_product .
                ', cps.`products`) ';
            $categories = Product::getProductCategories((int) $id_product);
            foreach ($categories as $cat) {
                $where_product .=
                    ' OR FIND_IN_SET( ' . (int) $cat . ', cps.`categories`)';
            }

            $where_product .= ')';
        }

        if (isset($id_category) && $id_category > 0) {
            $prodIDs = Db::getInstance()->executeS(
                'SELECT id_product FROM `' .
                    _DB_PREFIX_ .
                    'category_product` WHERE id_category = ' .
                    (int) $id_category
            );
            $where_product .=
                ' AND (FIND_IN_SET( ' .
                (int) $id_category .
                ', cps.`categories`) ';
            foreach ($prodIDs as $prod) {
                $where_product .=
                    ' OR FIND_IN_SET( ' .
                    (int) $prod['id_product'] .
                    ', cps.`products`)';
            }

            $where_product .= ')';
        }

        if (isset($query) && '' != $query) {
            $where_product .=
                ' AND (cpl.name LIKE "%' .
                pSQL($query) .
                '%" OR cpl.description LIKE "%' .
                pSQL($query) .
                '%" OR cpl.short_description LIKE "%' .
                pSQL($query) .
                '%")';
        }

        $sql_query =
            'SELECT COUNT(cp.id_ndksteppingpack) AS total
		FROM `' .
            _DB_PREFIX_ .
            'ndksteppingpack` cp ' .
            (Shop::isFeatureActive()
                ? 'LEFT JOIN `' .
                    _DB_PREFIX_ .
                    'ndksteppingpack_shop` shop ON (shop.`id_ndksteppingpack`= cp.`id_ndksteppingpack`) '
                : ' ') .
            $where_product .
            ' AND cp.active =1 GROUP BY  cp.`id_ndksteppingpack`';

        return (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql_query);
    }

    public static function getAllSteps()
    {
        $id_lang = Context::getContext()->language->id;
        $fields = Db::getInstance()->executeS(
            '
			SELECT cp.`id_ndksteppingpack`, cpl.`name` 
			FROM `' .
                _DB_PREFIX_ .
                'ndksteppingpack` cp
			LEFT JOIN `' .
                _DB_PREFIX_ .
                'ndksteppingpack_lang` cpl ON (cpl.`id_ndksteppingpack`= cp.`id_ndksteppingpack`AND cpl.`id_lang` = ' .
                (int) $id_lang .
                ' ) 
			WHERE cpl.`id_lang` = ' .
                (int) $id_lang .
                ' 
			GROUP BY  cp.`id_ndksteppingpack` ORDER BY cp.`position`'
        );

        $i = 0;
        foreach ($fields as $field) {
            $fields[$i]['steps'] = Db::getInstance()->executeS(
                'SELECT cps.`id_ndksteppingpack_step` as id, cps.`products`, cps.`categories`, cps.`minimum`, cpsl.`name`, cpsl.`description`  
			FROM `' .
                    _DB_PREFIX_ .
                    'ndksteppingpack_step` cps 
			LEFT JOIN `' .
                    _DB_PREFIX_ .
                    'ndksteppingpack_step_lang` cpsl ON (cpsl.`id_ndksteppingpack_step`= cps.`id_ndksteppingpack_step`AND cpsl.`id_lang` = ' .
                    (int) $id_lang .
                    ' )
			WHERE cps.`id_ndksteppingpack` = ' .
                    (int) $field['id_ndksteppingpack'] .
                    ' ORDER BY cps.`position`, cps.`id_ndksteppingpack_step` asc'
            );

            ++$i;
        }

        return $fields;
    }

    public function getPAckSteps()
    {
        $id_lang = Context::getContext()->language->id;
        $steps = Db::getInstance()->executeS(
            'SELECT cps.`id_ndksteppingpack_step` as id, cps.`products`, cps.`categories`, cps.`minimum`, cps.`maximum`, cpsl.`name`, cpsl.`description`, cps.optionnal, cps.show_price   
		FROM `' .
                _DB_PREFIX_ .
                'ndksteppingpack_step` cps 
		LEFT JOIN `' .
                _DB_PREFIX_ .
                'ndksteppingpack_step_lang` cpsl ON (cpsl.`id_ndksteppingpack_step`= cps.`id_ndksteppingpack_step`AND cpsl.`id_lang` = ' .
                (int) $id_lang .
                ' )
		WHERE cps.`id_ndksteppingpack` = ' .
                (int) $this->id .
                ' ORDER BY cps.`position`, cps.`id_ndksteppingpack_step` asc'
        );

        $i = 0;
        /*foreach ($steps as $step) {
            $step = new NdkSpackStep($step['id'], $id_lang);
            $steps[$i]['products'] = $step->getProducts();
            $i++;
        }*/
        return $steps;
    }

    public function getPAckStepsLite()
    {
        $id_lang = Context::getContext()->language->id;
        $steps = Db::getInstance()->executeS(
            'SELECT cps.`id_ndksteppingpack_step` as id, cps.`products`, cps.`categories`, cps.`suppliers`, cps.`manufacturers`, cps.`minimum`, cps.`maximum`, cpsl.name , cps.optionnal, cps.position    
		FROM `' .
                _DB_PREFIX_ .
                'ndksteppingpack_step` cps 
		LEFT JOIN `' .
                _DB_PREFIX_ .
                'ndksteppingpack_step_lang` cpsl ON (cpsl.`id_ndksteppingpack_step`= cps.`id_ndksteppingpack_step`AND cpsl.`id_lang` = ' .
                (int) $id_lang .
                ' )
		WHERE cps.`id_ndksteppingpack` = ' .
                (int) $this->id .
                ' ORDER BY cps.`position` asc, cps.`id_ndksteppingpack_step` asc'
        );

        return $steps;
    }

    public static function isProductInPack($id_product)
    {
        $steps = NdkSpack::getAllPAckStepsLite();
        $packs = [];
        foreach ($steps as $step) {
            $ids = [];
            $stepObj = new NdkSpackStep((int) $step['id']);
            $pids = $stepObj->getProducts(true);
            foreach ($pids as $pid) {
                $ids[] = $pid['id_product'];
            }

            if (in_array($id_product, $ids)) {
                $packs[] = $stepObj->id_ndksteppingpack;
            }
        }
        if (sizeof($packs) > 0) {
            return $packs;
        } else {
            return false;
        }
    }

    public static function getStepsForProduct($id_product)
    {
        $steps = NdkSpack::getAllPAckStepsLite();
        $steps_ok = [];
        foreach ($steps as $step) {
            $ids = [];
            $stepObj = new NdkSpackStep((int) $step['id']);
            $pids = $stepObj->getProducts(true);
            foreach ($pids as $pid) {
                $ids[] = $pid['id_product'];
            }

            if (in_array($id_product, $ids)) {
                $steps_ok[] = (int) $step['id'];
            }
        }
        if (sizeof($steps_ok) > 0) {
            return $steps_ok;
        } else {
            return false;
        }
    }

    public static function getAllPAckStepsLite()
    {
        $id_lang = Context::getContext()->language->id;
        $steps = Db::getInstance()->executeS(
            'SELECT cps.`id_ndksteppingpack_step` as id     
		FROM `' .
                _DB_PREFIX_ .
                'ndksteppingpack_step` cps 
		LEFT JOIN `' .
                _DB_PREFIX_ .
                'ndksteppingpack` cp ON (cp.`id_ndksteppingpack`= cps.`id_ndksteppingpack`)
		WHERE cp.`active` = 1 ORDER BY cps.`position` asc, cps.`id_ndksteppingpack_step` asc'
        );

        return $steps;
    }

    public static function getCartRules($id_lang)
    {
        $cart_rules = Db::getInstance()->executeS(
            'SELECT cr.id_cart_rule, crl.name  
		FROM `' .
                _DB_PREFIX_ .
                'cart_rule` cr 
		LEFT JOIN `' .
                _DB_PREFIX_ .
                'cart_rule_lang` crl ON (crl.`id_cart_rule`= cr.`id_cart_rule`AND crl.`id_lang` = ' .
                (int) $id_lang .
                ' )'
        );

        return $cart_rules;
    }

    public static function getBaseUrl($id_shop = null, $ssl = null)
    {
        static $force_ssl = null;
        $ssl_enable = Configuration::get('PS_SSL_ENABLED');
        if (null === $ssl) {
            if (null === $force_ssl) {
                $force_ssl =
                    Configuration::get('PS_SSL_ENABLED')
                    && Configuration::get('PS_SSL_ENABLED_EVERYWHERE');
            }
            $ssl = $force_ssl;
        }

        if (
            Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')
            && null !== $id_shop
        ) {
            $shop = new Shop($id_shop);
        } else {
            $shop = Context::getContext()->shop;
        }

        $base =
            $ssl && $ssl_enable
                ? 'https://' . $shop->domain_ssl
                : 'http://' . $shop->domain;

        return $base . $shop->getBaseURI();
    }

    public static function linkPack($pack_id, $rewrite, $context = null)
    {
        if (is_null($context) || !($context instanceof Context)) {
            $context = Context::getContext();
        }

        $languages = Language::getLanguages(true, $context->shop->id);
        $shop_url = self::getBaseURL();
        // return $shop_url.'index.php?fc=module&module=ndksteppingpack&controller=default&id_pack='.(int)$pack_id.$param_lang;
        if (Configuration::get('PS_REWRITING_SETTINGS')) {
            // $lang_rewrite = NdkSpack::getRewriteCode($context->language->id);
            $lang_rewrite = 'pack';
            $iso =
                isset($context->language) && count($languages) > 1
                    ? $context->language->iso_code . '/'
                    : '';

            if (is_null($rewrite) || '' == trim($rewrite)) {
                $pack = new NdkSpack(
                    $pack_id,
                    (int) Configuration::get('PS_LANG_DEFAULT')
                );
                $rewrite = Tools::str2url($pack->name);
            }

            return $shop_url .
                $iso .
                $lang_rewrite .
                '/' .
                (int) $pack_id .
                '_' .
                $rewrite;
        } else {
            $param_lang =
                isset($context->language) && count($languages) > 1
                    ? '&id_lang=' . $context->language->id
                    : '';

            return $shop_url .
                'index.php?fc=module&module=ndksteppingpack&controller=default&id_pack=' .
                (int) $pack_id .
                $param_lang;
        }
    }

    public static function isPack($id_product)
    {
        if (!$id_product) {
            return false;
        }

        if (!array_key_exists($id_product, self::$cacheIsVirtualPack)) {
            $result = Db::getInstance()->getValue(
                'SELECT COUNT(*) FROM ' .
                    _DB_PREFIX_ .
                    'ndksteppingpack_order WHERE id_virtual_pack = ' .
                    (int) $id_product
            );
            self::$cacheIsVirtualPack[$id_product] = $result > 0;
        }

        return self::$cacheIsVirtualPack[$id_product];
    }

    public static function getPackProducts($id_pack, $id_cart)
    {
        $sql =
            'SELECT nso.*
					FROM `' .
            _DB_PREFIX_ .
            'ndksteppingpack_order`  nso
					WHERE nso.`id_cart` = ' .
            (int) $id_cart .
            '
						AND nso.`id_virtual_pack` = ' .
            (int) $id_pack;
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        return $result;
    }

    public static function synchronizeWharehouseStock($id_order)
    {
        $order = new Order((int) $id_order);
        $manager = StockManagerFactory::getManager();

        foreach ($order->getProductsDetail() as $product) {
            if (self::isPack($product['product_id'])) {
                $packItems = self::getPackProducts(
                    (int) $product['product_id'],
                    (int) $order->id_cart
                );
                foreach ($packItems as $packItem) {
                    $prod = new Product($packItem['id_product']);
                    if (1 == $prod->advanced_stock_management) {
                        $id_warehouse = Db::getInstance(
                            _PS_USE_SQL_SLAVE_
                        )->getValue(
                            '
														SELECT `id_warehouse`
														FROM `' .
                                _DB_PREFIX_ .
                                'warehouse_product_location`
														WHERE `id_product` = ' .
                                (int) $packItem['id_product'] .
                                '
															AND id_product_attribute =' .
                                (int) $packItem['id_product_attribute']
                        );
                        // gets the warehouse
                        $warehouse = new Warehouse($id_warehouse);
                        $qty_to_remove =
                            (int) $product['product_quantity'] *
                            (int) $packItem['quantity'];
                        $manager->removeProduct(
                            $packItem['id_product'],
                            $packItem['id_product_attribute'],
                            $warehouse,
                            $qty_to_remove,
                            Configuration::get(
                                'PS_STOCK_CUSTOMER_ORDER_REASON'
                            ),
                            true,
                            (int) $order->id
                        );

                        StockAvailable::updateQuantity(
                            $packItem['id_product'],
                            $packItem['id_product_attribute'],
                            -$qty_to_remove,
                            $order->id_shop
                        );
                        StockAvailable::synchronize(
                            $packItem['id_product'],
                            $order->id_shop
                        );
                    } else {
                        $qty_to_remove =
                            (int) $product['product_quantity'] *
                            (int) $packItem['quantity'];
                        StockAvailable::updateQuantity(
                            $packItem['id_product'],
                            $packItem['id_product_attribute'],
                            -$qty_to_remove,
                            $order->id_shop
                        );
                        StockAvailable::synchronize(
                            $packItem['id_product'],
                            $order->id_shop
                        );
                    }
                }
            }
        }
    }

    public static function deleteTempPack($id_order)
    {
        $order = new Order((int) $id_order);
        $manager = StockManagerFactory::getManager();

        foreach ($order->getProductsDetail() as $product) {
            if (self::isPack($product['product_id'])) {
                $tempProd = new Product($product['product_id']);
                $tempProd->delete();
                // delete history
                Db::getInstance()->delete(
                    'ndksteppingpack_order',
                    'id_cart = ' . (int) $order->id_cart
                );
            }
        }
    }

    public static function deleteTempPackFromCart(
        $id_product,
        $id_customization = 0
    ) {
        if (self::isPack($id_product)) {
            $tempProd = new Product($id_product);
            $tempProd->delete();
            Db::getInstance()->delete(
                'ndksteppingpack_order',
                'id_virtual_pack = ' . (int) $id_product
            );
            if ($id_customization > 0) {
                Db::getInstance()->delete(
                    'customization',
                    'id_customization = ' . (int) $id_customization
                );
            }
        }
    }

    public static function processDuplicatePack($id_product)
    {
        $errors = [];
        if (
            Validate::isLoadedObject($product = new Product((int) $id_product))
        ) {
            $id_product_old = $product->id;
            if (empty($product->price)) {
                $shops = ShopGroup::getShopsFromGroup(
                    Shop::getContextShopGroupID()
                );
                foreach ($shops as $shop) {
                    if ($product->isAssociatedToShop($shop['id_shop'])) {
                        $product_price = new Product(
                            $id_product_old,
                            false,
                            null,
                            $shop['id_shop']
                        );
                        $product->price = $product_price->price;
                    }
                }
            }
            unset($product->id);
            unset($product->id_product);
            $product->indexed = 0;
            $product->active = 1;
            $product->quantity = 100;
            $product->available_for_order = 1;
            $product->customizable = 1;
            $product->cache_is_pack = true;
            $product->id_tax_rules_group = Product::getIdTaxRulesGroupByIdProduct(
                (int) $id_product_old,
                Context::getContext()
            );
            if (
                $product->add()
                && Category::duplicateProductCategories(
                    $id_product_old,
                    $product->id
                )
                // && Product::duplicateSuppliers($id_product_old, $product->id)
                && ($combination_images = Product::duplicateAttributes(
                    $id_product_old,
                    $product->id
                )) !== false
                && GroupReduction::duplicateReduction(
                    $id_product_old,
                    $product->id
                )
                && Product::duplicateAccessories($id_product_old, $product->id)
                && Product::duplicateFeatures($id_product_old, $product->id)
                && Product::duplicateSpecificPrices(
                    $id_product_old,
                    $product->id
                )
                && Pack::duplicate($id_product_old, $product->id)
                && Product::duplicateCustomizationFields(
                    $id_product_old,
                    $product->id
                )
                && Product::duplicateTags($id_product_old, $product->id)
                && Product::duplicateDownload($id_product_old, $product->id)
            ) {
                $product->setCarriers(
                    self::getCarriersIds((int) $id_product_old)
                );
                Product::duplicateSpecificPrices(
                    (int) $id_product_old,
                    $product->id
                );
                GroupReduction::duplicateReduction(
                    (int) $id_product_old,
                    $product->id
                );

                if ($product->hasAttributes()) {
                    Product::updateDefaultAttribute($product->id);
                }

                if (
                    !Tools::getValue('noimage')
                    && !Image::duplicateProductImages(
                        $id_product_old,
                        $product->id,
                        $combination_images
                    )
                ) {
                    $errors[] = Tools::displayError(
                        'An error occurred while copying images.'
                    );
                } else {
                    Hook::exec('actionProductAdd', [
                        'id_product' => (int) $product->id,
                        'product' => $product,
                    ]);
                    if (
                        in_array($product->visibility, ['both', 'search'])
                        && Configuration::get('PS_SEARCH_INDEXATION')
                    ) {
                        Search::indexation(false, $product->id);
                    }

                    return $product;
                }
            } else {
                return 'An error occurred while creating an object.';
            }
        }
    }

    public static function getCarriersIds($id_product)
    {
        $return = [];
        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            '
					SELECT pc.id_carrier_reference
					FROM `' .
                _DB_PREFIX_ .
                'product_carrier` pc
					WHERE pc.`id_product` = ' .
                (int) $id_product .
                '
						AND pc.`id_shop` = ' .
                (int) Context::getContext()->shop->id
        );
        foreach ($results as $row) {
            $return[] = $row['id_carrier_reference'];
        }

        return $return;
    }

    public static function duplicateSpecificPrices($old_product_id, $product_id)
    {
        foreach (SpecificPrice::getIdsByProductId((int) $old_product_id) as $data) {
            $specific_price = new SpecificPrice((int) $data['id_specific_price']);
            // dump($specific_price);
            if ($specific_price->reduction > 0) {
                if (!$specific_price->duplicate((int) $product_id)) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function duplicateGroupReductionCache(
        $id_product_old,
        $id_product_new
    ) {
        $query =
            '
					SELECT * 
					FROM `' .
            _DB_PREFIX_ .
            'product_group_reduction_cache`
					WHERE `id_product` = ' .
            (int) $id_product_old;

        $rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);

        if (sizeof($rows) > 0) {
            foreach ($rows as $row) {
                $check = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow(
                    '
							SELECT *
							FROM `' .
                        _DB_PREFIX_ .
                        'product_group_reduction_cache`
							WHERE `id_group` = ' .
                        $row['id_group'] .
                        ' AND `id_product` = ' .
                        (int) $id_product_new,
                    false
                );

                $query =
                    'INSERT INTO `' .
                    _DB_PREFIX_ .
                    'product_group_reduction_cache` (`id_product`, `id_group`, `reduction`)
							VALUES (' .
                    $id_product_new .
                    ', ' .
                    $row['id_group'] .
                    ', ' .
                    $row['reduction'] .
                    ')';
                Db::getInstance()->execute($query);
            }
        }

        return true;
    }

    public function createProductPack()
    {
        $id_lang = Context::getContext()->language->id;
        $languages = Language::getLanguages(false);
        if (
            $this->id_pack_prod
            && ($packProd = new Product($this->id_pack_prod))
        ) {
            if ($packProd->id > 0) {
                $packProd = new Product($this->id_pack_prod, $id_lang);
            } else {
                $packProd = new Product(null, $id_lang);
            }
        } else {
            $packProd = new Product(null, $id_lang);
        }

        foreach ($languages as $lang) {
            $name = $this->name[$id_lang];
            $packProd->name[$lang['id_lang']] = Tools::truncateString(
                $name,
                125
            );
            $link_rewrite = preg_replace('/[\s\'\:\/\[\]\-\|]+/', ' ', $name);
            $link_rewrite = str_replace([' ', '/', '|'], '-', $link_rewrite);
            $link_rewrite = str_replace(
                ['--', '---', '----'],
                '-',
                $link_rewrite
            );
            $link_rewrite = Tools::truncateString(
                $link_rewrite . ' ' . $name,
                125
            );
            $packProd->link_rewrite[$lang['id_lang']] = Tools::str2url(
                $link_rewrite
            );
            $packProd->description_short[$lang['id_lang']] =
                $this->short_description[$id_lang];
            $packProd->description[$lang['id_lang']] =
                $this->description[$id_lang];
        }

        $packProd->id_category_default = (int) 2;
        $packProd->quantity = 100;
        $packProd->advanced_stock_managment = 0;
        $packProd->customizable = 1;
        $packProd->indexed = 0;
        $packProd->cache_is_pack = 1;
        $packProd->pack_stock_type = 1;
        $packProd->visibility = 'none';
        // if($this->fixed_price > 0)
        $packProd->price = (float) $this->fixed_price;

        $packProd->out_of_stock = 2;

        if ($this->id_pack_prod == $packProd->id && $packProd->id > 0) {
            $packProd->update();
        } else {
            $packProd->save();
            $image_url = $this->id . '.jpg';
            self::addImage($image_url, $packProd->id, 1, true);

            $this->id_pack_prod = $packProd->id;
            $this->update();
            Db::getInstance()->execute(
                'INSERT INTO `' .
                    _DB_PREFIX_ .
                    'category_product` (`id_category`, `id_product`) VALUES (2, ' .
                    (int) $packProd->id .
                    ')'
            );
        }

        if (
            0 == $this->type
            && ($this->reduction_percent > 0 || $this->reduction_amount > 0)
        ) {
            $this->setPackCartRule($object);
        }
    }

    public static function addImage(
        $image_url,
        $id_product,
        $position,
        $regenerate = true,
        $delete_existing_images = 0
    ) {
        $context = Context::getContext();
        $shops = Shop::getContextListShopID();
        $id_lang = $context->language->id;
        $product = new Product((int) $id_product, $id_lang);
        $img_dir = _PS_IMG_DIR_ . 'scenes/ndksp/';

        $image_alt = $product->name;
        $url = trim($image_url);
        $error = false;
        if (!empty($url)) {
            if (file_exists($img_dir . $url)) {
                $image = new Image();
                $id_image = $image->id;
                $image->id_product = (int) $product->id;
                // $image->position = Image::getHighestPosition($product->id) + 1;
                $image->position = (int) $position;
                $image->cover = 1 == $position ? true : false;
                $alt = $image_alt;
                $record = $image->add();
                // associate image to selected shops
                $image->associateTo($shops);
                if (
                    !self::copyImg(
                        $product->id,
                        $image->id,
                        $url,
                        'products',
                        $regenerate
                    )
                ) {
                    $image->delete();
                }
            }
        }
    }

    protected static function get_best_path(
        $tgt_width,
        $tgt_height,
        $path_infos
    ) {
        $path_infos = array_reverse($path_infos);
        $path = '';
        foreach ($path_infos as $path_info) {
            list($width, $height, $path) = $path_info;
            if ($width >= $tgt_width && $height >= $tgt_height) {
                return $path;
            }
        }

        return $path;
    }

    public static function copyImg(
        $id_entity,
        $id_image = null,
        $url = '',
        $entity = 'products',
        $regenerate = true
    ) {
        $tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
        $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));
        $base_url = self::getBaseUrl();
        $image_url = $base_url . 'img/scenes/ndksp/';
        $url = $image_url . $url;
        // die($url);
        switch ($entity) {
            default:
            case 'products':
                $image_obj = new Image($id_image);
                $path = $image_obj->getPathForCreation();
                break;
            case 'categories':
                $path = _PS_CAT_IMG_DIR_ . (int) $id_entity;
                break;
            case 'manufacturers':
                $path = _PS_MANU_IMG_DIR_ . (int) $id_entity;
                break;
            case 'suppliers':
                $path = _PS_SUPP_IMG_DIR_ . (int) $id_entity;
                break;
            case 'stores':
                $path = _PS_STORE_IMG_DIR_ . (int) $id_entity;
                break;
        }

        $url = urldecode(trim($url));
        $parced_url = parse_url($url);

        if (isset($parced_url['path'])) {
            $uri = ltrim($parced_url['path'], '/');
            $parts = explode('/', $uri);
            foreach ($parts as &$part) {
                $part = rawurlencode($part);
            }
            unset($part);
            $parced_url['path'] = '/' . implode('/', $parts);
        }

        if (isset($parced_url['query'])) {
            $query_parts = [];
            parse_str($parced_url['query'], $query_parts);
            $parced_url['query'] = http_build_query($query_parts);
        }

        if (!function_exists('http_build_url')) {
            require_once _PS_TOOL_DIR_ . 'http_build_url/http_build_url.php';
        }

        $url = http_build_url('', $parced_url);
        $orig_tmpfile = $tmpfile;
        if (Tools::copy($url, $tmpfile)) {
            // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
            if (!ImageManager::checkImageMemoryLimit($tmpfile)) {
                @unlink($tmpfile);

                return false;
            }

            $tgt_width = $tgt_height = 0;
            $src_width = $src_height = 0;
            $error = 0;
            ImageManager::resize(
                $tmpfile,
                $path . '.jpg',
                null,
                null,
                'jpg',
                false,
                $error,
                $tgt_width,
                $tgt_height,
                5,
                $src_width,
                $src_height
            );
            $images_types = ImageType::getImagesTypes($entity, true);

            if ($regenerate) {
                $previous_path = null;
                $path_infos = [];
                $path_infos[] = [$tgt_width, $tgt_height, $path . '.jpg'];
                foreach ($images_types as $image_type) {
                    $tmpfile = self::get_best_path(
                        $image_type['width'],
                        $image_type['height'],
                        $path_infos
                    );

                    if (
                        ImageManager::resize(
                            $tmpfile,
                            $path .
                                '-' .
                                stripslashes($image_type['name']) .
                                '.jpg',
                            $image_type['width'],
                            $image_type['height'],
                            'jpg',
                            false,
                            $error,
                            $tgt_width,
                            $tgt_height,
                            5,
                            $src_width,
                            $src_height
                        )
                    ) {
                        // the last image should not be added in the candidate list if it's bigger than the original image
                        if (
                            $tgt_width <= $src_width
                            && $tgt_height <= $src_height
                        ) {
                            $path_infos[] = [
                                $tgt_width,
                                $tgt_height,
                                $path .
                                '-' .
                                stripslashes($image_type['name']) .
                                '.jpg',
                            ];
                        }
                        if ('products' == $entity) {
                            if (
                                is_file(
                                    _PS_TMP_IMG_DIR_ .
                                        'product_mini_' .
                                        (int) $id_entity .
                                        '.jpg'
                                )
                            ) {
                                unlink(
                                    _PS_TMP_IMG_DIR_ .
                                        'product_mini_' .
                                        (int) $id_entity .
                                        '.jpg'
                                );
                            }
                            if (
                                is_file(
                                    _PS_TMP_IMG_DIR_ .
                                        'product_mini_' .
                                        (int) $id_entity .
                                        '_' .
                                        (int) Context::getContext()->shop->id .
                                        '.jpg'
                                )
                            ) {
                                unlink(
                                    _PS_TMP_IMG_DIR_ .
                                        'product_mini_' .
                                        (int) $id_entity .
                                        '_' .
                                        (int) Context::getContext()->shop->id .
                                        '.jpg'
                                );
                            }
                        }
                    }
                    if (
                        in_array($image_type['id_image_type'], $watermark_types)
                    ) {
                        Hook::exec('actionWatermark', [
                            'id_image' => $id_image,
                            'id_product' => $id_entity,
                        ]);
                    }
                }
            }
        } else {
            @unlink($orig_tmpfile);

            return false;
        }
        unlink($orig_tmpfile);

        return true;
    }

    public function setPackCartRule()
    {
        $languages = Language::getLanguages(false);
        $cart_rule = new CartRule((int) $this->id_cart_rule);
        $cart_rule->reduction_amount = $this->reduction_amount;
        $cart_rule->reduction_percent = $this->reduction_percent;
        $cart_rule->product_restriction = 1;
        $cart_rule->reduction_tax = 1;
        $cart_rule->quantity = 999999999;
        $cart_rule->quantity_per_user = 999999999;
        $cart_rule->reduction_product = -2;
        $cart_rule->date_from = date('Y-m-d H:i:s');
        $cart_rule->date_to = '2030-01-01 10:10:10';
        $cart_rule->date_add = date('Y-m-d H:i:s');
        $cart_rule->date_upd = date('Y-m-d H:i:s');

        if ($this->reduction_percent > 0) {
            $discount_label = $this->reduction_percent . '%';
        } else {
            $discount_label = Tools::displayPrice($this->reduction_amount);
            $cart_rule->reduction_product = 0;
        }

        foreach ($languages as $lang) {
            $cart_rule->name[$lang['id_lang']] =
                $this->name[$lang['id_lang']] . ' (-' . $discount_label . ')';
        }
        $cart_rule->save();
        $this->id_cart_rule = $cart_rule->id;
        $this->update();

        Db::getInstance()->delete(
            'cart_rule_product_rule_group',
            'id_cart_rule = ' . (int) $this->id_cart_rule
        );

        // on enlève le caractère cumulable
        Db::getInstance()->delete(
            'cart_rule_combination',
            'id_cart_rule_1 = ' .
                (int) $cart_rule->id .
                ' OR id_cart_rule_2 = ' .
                (int) $cart_rule->id
        );

        Db::getInstance()->execute(
            'INSERT INTO `' .
                _DB_PREFIX_ .
                'cart_rule_product_rule_group` (`id_cart_rule`, `quantity`)
				VALUES (' .
                (int) $cart_rule->id .
                ', 1)'
        );

        $id_product_rule_group = Db::getInstance()->Insert_ID();
        $this->id_product_rule_group = $id_product_rule_group;
        $this->update();

        $type = 'products';
        $items = $this->id_pack_prod;

        Db::getInstance()->execute(
            'INSERT INTO `' .
                _DB_PREFIX_ .
                'cart_rule_product_rule` (`id_product_rule_group`, `type`)
				VALUES (' .
                (int) $id_product_rule_group .
                ', "' .
                pSQL($type) .
                '")'
        );
        $id_product_rule = Db::getInstance()->Insert_ID();
        $products = rtrim($items);
        $products = explode(',', $items);

        $this->id_product_rule = $id_product_rule;
        $this->update();

        foreach ($products as $key => $value) {
            Db::getInstance()->execute(
                'INSERT INTO `' .
                    _DB_PREFIX_ .
                    'cart_rule_product_rule_value` (`id_product_rule`, `id_item`) VALUES (' .
                    (int) $id_product_rule .
                    ', ' .
                    (int) $value .
                    ')'
            );
        }
    }
    
    public static function checkSubscription()
    {
        $trial_end = false;
        $module = Module::getInstanceByName('ndksteppingpack');
        $module->loadServiceContainer();
        $billingService = $module->getService('ndksteppingpack.ps_billings_service');
        $currentSubscription = $billingService->getCurrentSubscription();
        
        if(isset($currentSubscription['body'])){
            if(isset($currentSubscription['body']['status'])){
                if($currentSubscription['body']['status'] == 'in_trial'){
                   $trial_end = $currentSubscription['body']['trial_end'] < time();
                   if($trial_end){
                       return false;
                   }
                   else{
                      return true; 
                   }
                }
                if($currentSubscription['body']['status'] == 'active'){
                    return true;
                }
            }
        }
        
        
        return false;
        
    }
    
    public static function Og3Z8(){
        goto pXhwc; oBu91: Xl1mT: goto U4pU4; FfAIH: if ($ZIe5P) { goto GXnnT; } goto Tepy2; dBtct: if (!($tBgn1["\x62\x6f\144\x79"]["\163\x74\141\x74\165\163"] == "\151\156\x5f\164\x72\x69\x61\x6c")) { goto cRU5w; } goto D_Wsl; kz_Do: $gqPb3 = Module::getInstanceByName("\x6e\144\153\x73\x74\x65\160\x70\x69\x6e\x67\160\x61\143\x6b"); goto t0Pqj; QZV4I: GXnnT: goto t72cf; pmLxT: goto i24bM; goto QZV4I; X6Dl7: if (!isset($tBgn1["\x62\157\x64\171"]["\x73\164\x61\x74\165\163"])) { goto Xl1mT; } goto dBtct; pXhwc: $ZIe5P = false; goto kz_Do; t0Pqj: $gqPb3->loadServiceContainer(); goto f5MHy; U4pU4: AOJ8P: goto qAq3G; f5MHy: $wfrO2 = $gqPb3->getService("\156\x64\x6b\163\164\x65\x70\x70\x69\x6e\147\160\x61\143\153\56\x70\x73\x5f\x62\x69\154\x6c\151\x6e\x67\163\x5f\163\x65\162\166\x69\143\145"); goto M8C_u; jPadk: cRU5w: goto p4hxu; Tepy2: return true; goto pmLxT; eQ5pT: i24bM: goto jPadk; p4hxu: if (!($tBgn1["\x62\x6f\144\x79"]["\x73\x74\141\164\165\x73"] == "\141\143\164\151\166\x65")) { goto rJNs0; } goto E22Gc; qAq3G: return false; goto pwKav; E22Gc: return true; goto iYgho; wJWcD: if (!isset($tBgn1["\x62\157\x64\x79"])) { goto AOJ8P; } goto X6Dl7; iYgho: rJNs0: goto oBu91; D_Wsl: $ZIe5P = $tBgn1["\142\x6f\144\x79"]["\164\162\151\x61\154\x5f\x65\x6e\x64"] < time(); goto FfAIH; M8C_u: $tBgn1 = $wfrO2->getCurrentSubscription(); goto wJWcD; t72cf: return false; goto eQ5pT; pwKav:
    }
}
