<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author	Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
 */
class NdkSpackStep extends ObjectModel
{
    /** @var string Name */
    public $id_ndksteppingpack;
    public $products;
    public $categories;
    public $suppliers;
    public $manufacturers;
    public $minimum;
    public $maximum;
    public $position;
    public $name;
    public $description;
    public $id_product_rule_group;
    public $optionnal;
    public $show_price;

    public static $definition = [
        'table' => 'ndksteppingpack_step',
        'primary' => 'id_ndksteppingpack_step',
        'multilang' => true,
        'fields' => [
            'id_ndksteppingpack' => [
                'type' => ObjectModel::TYPE_INT,
                'lang' => false,
                'required' => true,
            ],
            'position' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            'id_product_rule_group' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            'minimum' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            'maximum' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            'products' => ['type' => self::TYPE_STRING, 'required' => false, 'lang' => false],
            'categories' => ['type' => self::TYPE_STRING, 'required' => false, 'lang' => false],
            'suppliers' => ['type' => self::TYPE_STRING, 'required' => false, 'lang' => false],
            'manufacturers' => ['type' => self::TYPE_STRING, 'required' => false, 'lang' => false],
            'optionnal' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            'show_price' => ['type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false],
            // Lang fields
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'lang' => true, 'required' => true, 'size' => 128],
            'description' => ['type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 3999999999999],
        ],
    ];

    public static function createPagination($count_res, $nb, $paginate)
    {
        $scope = 2;
        $pagination = [];
        $count_pages = ceil((int) $count_res / (int) $nb);
        if ((int) $count_pages > 1) {
            $pagination['should_be_displayed'] = true;
            $pagination['pages'] = [];
            $pagination['items_shown_from'] = $nb * ($paginate - 1) + 1;
            $pagination['items_shown_to'] = ($nb * $paginate <= $count_res ? $nb * $paginate : $count_res);
            $pagination['total_items'] = $count_res;

            for ($i = 1; $i <= (int) $count_pages; ++$i) {
                if (1 != $i && $i != $count_pages && ($i == ($paginate + $scope) || $i == ($paginate - $scope))) {
                    $pagination['pages'][] = self::addPaginationElement('...', 'spacer', false);
                } elseif ($i == $paginate - 1) {
                    $pagination['pages'][] = self::addPaginationElement($i, 'previous');
                    $pagination['pages'][] = self::addPaginationElement($i, 'common');
                } elseif ($i == $paginate) {
                    $pagination['pages'][] = self::addPaginationElement($i, 'current', false);
                } elseif ($i == $paginate + 1) {
                    $pagination['pages'][] = self::addPaginationElement($i, 'next');
                    $pagination['pages'][] = self::addPaginationElement($i, 'common');
                } elseif (1 != $i && $i != $count_pages && $i != ($paginate - $scope) && $i != ($paginate + $scope)) {
                    continue;
                } else {
                    $pagination['pages'][] = self::addPaginationElement($i, 'common');
                }
            }
        } else {
            $pagination['should_be_displayed'] = false;
            $pagination['pages'] = [];
            $pagination['items_shown_from'] = 1;
            $pagination['items_shown_to'] = $count_res;
            $pagination['total_items'] = $count_res;
        }

        return $pagination;
    }

    public static function addPaginationElement($page, $type, $clickable = true)
    {
        return [
            'page' => $page,
            'type' => $type,
            'url' => $page,
            'clickable' => $clickable,
        ];
    }

    public function getProducts($only_ids = false, $paginate = 1, $count = false, $only_active = true, $id_lang = null, $lite_result = true, Context $context = null, $order_by = null, $order_way = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }

        $prodsIds = '';
        $cat_prodsIds = '';
        $supplier_prodsIds = '';
        $manufacturer_prodsIds = '';
        $where_products = ' AND p.id_product > 0';
        $ids = [];
        $nb = Configuration::get('NDKSTEPPINGPACK_PAGINATE');
        if ((int) $nb < 1) {
            $nb = 16;
        }
        $my_return = [];

        if (!empty($this->categories)) {
            $q_prodsIds = Db::getInstance()->executeS(
                'SELECT id_product	
				FROM `' . _DB_PREFIX_ . 'category_product` cp 
				WHERE cp.`id_category` IN (' . pSQL($this->categories) . ')'
            );
            $ids = [];
            foreach ($q_prodsIds as $prodId) {
                $ids[] = $prodId['id_product'];
            }
            $cat_prodsIds = implode(',', $ids);
            if ('' != $cat_prodsIds) {
                $where_products .= ' AND p.id_product IN (' . pSQL($cat_prodsIds) . ')';
            }
        }
        if (!empty($this->suppliers)) {
            $q_prodsIds = Db::getInstance()->executeS(
                'SELECT p.`id_product`
					FROM `' . _DB_PREFIX_ . 'product` p
					' . Shop::addSqlAssociation('product', 'p') . '
					INNER JOIN `' . _DB_PREFIX_ . 'product_supplier` ps ON (
						ps.`id_product` = p.`id_product`
						AND ps.`id_supplier` IN (' . pSQL($this->suppliers) . ')
					) GROUP BY p.`id_product`'
            );

            $ids = [];
            foreach ($q_prodsIds as $prodId) {
                $ids[] = $prodId['id_product'];
            }
            $supplier_prodsIds = implode(',', $ids);
            $where_products .= ' AND p.id_product IN (' . pSQL($supplier_prodsIds) . ')';
        }

        if (!empty($this->manufacturers)) {
            $q_prodsIds = Db::getInstance()->executeS(
                'SELECT p.`id_product`
				FROM `' . _DB_PREFIX_ . 'product` p
				' . Shop::addSqlAssociation('product', 'p') . '
				WHERE p.`id_manufacturer`  IN (' . pSQL($this->manufacturers) . ')
				 GROUP BY p.`id_product`'
            );

            $ids = [];
            foreach ($q_prodsIds as $prodId) {
                $ids[] = $prodId['id_product'];
            }
            $manufacturer_prodsIds = implode(',', $ids);
            $where_products .= ' AND p.id_product IN (' . pSQL($manufacturer_prodsIds) . ')';
        }

        if (!empty($this->products)) {
            $prodsIds = $this->products;
            $prodsIdsArr = explode(',', $this->products);
            $ids = [];
            foreach ($prodsIdsArr as $k => $v) {
                if (',' != $v && '' != $v) {
                    $ids[] = $v;
                }
            }
            $prodsIds = implode(',', $ids);
            if (empty($this->categories) && empty($this->manufacturers) && empty($this->suppliers)) {
                $where_products .= ' AND p.id_product IN (' . pSQL($prodsIds) . ')';
            } else {
                $where_products .= ' OR p.id_product IN (' . pSQL($prodsIds) . ')';
            }
        }

        // var_dump($where_products);

        $id_lang = Context::getContext()->language->id;

        $order_by_values = [0 => 'name', 1 => 'price', 2 => 'date_add', 3 => 'date_upd', 4 => 'position', 5 => 'manufacturer_name', 6 => 'quantity', 7 => 'reference'];
        $order_way_values = [0 => 'asc', 1 => 'desc'];

        $order_by = Tools::strtolower(Tools::getValue('orderby', $order_by_values[(int) Configuration::get('PS_PRODUCTS_ORDER_BY')]));
        $order_way = Tools::strtolower(Tools::getValue('orderway', $order_way_values[(int) Configuration::get('PS_PRODUCTS_ORDER_WAY')]));
        /** Tools::strtolower is a fix for all modules which are now using lowercase values for 'orderBy' parameter */
        $order_by = Validate::isOrderBy($order_by) ? Tools::strtolower($order_by) : 'position';
        $order_way = Validate::isOrderWay($order_way) ? Tools::strtoupper($order_way) : 'ASC';

        $order_by_prefix = false;
        if ('id_product' == $order_by || 'date_add' == $order_by || 'date_upd' == $order_by) {
            $order_by_prefix = 'p';
        } elseif ('name' == $order_by) {
            $order_by_prefix = 'pl';
        } elseif ('manufacturer' == $order_by || 'manufacturer_name' == $order_by) {
            $order_by_prefix = 'm';
            $order_by = 'name';
        } elseif ('position' == $order_by) {
            $order_by_prefix = 'cp';
        }

        if ('price' == $order_by) {
            $order_by = 'orderprice';
        }

        if ($only_ids) {
            $sql = 'SELECT p.id_product 
						FROM `' . _DB_PREFIX_ . 'product` p
						' . Shop::addSqlAssociation('product', 'p') . '
						WHERE product_shop.`id_shop` = ' . (int) $context->shop->id . '
						' . $where_products
                            . ($only_active ? ' AND product_shop.`active` = 1' : '') . ' AND product_shop.`visibility` IN ("both", "catalog") GROUP BY p.id_product';
        } elseif ($count) {
            $sql_count = 'SELECT COUNT(p.id_product) 
						FROM `' . _DB_PREFIX_ . 'product` p
						' . Shop::addSqlAssociation('product', 'p') . '
						WHERE product_shop.`id_shop` = ' . (int) $context->shop->id . '
						' . $where_products
                            . ($only_active ? ' AND product_shop.`active` = 1' : '') . ' AND product_shop.`visibility` IN ("both", "catalog")';

            $count_res = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql_count);

            $pagination = self::createPagination($count_res, $nb, $paginate);

            return $pagination;
            // var_dump($pagination);
        } else {
            $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, MAX(product_attribute_shop.id_product_attribute) id_product_attribute, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
							pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,
							il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
							DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
							INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . '
								DAY)) > 0 AS new, product_shop.price AS orderprice
						FROM `' . _DB_PREFIX_ . 'product` p
						' . Shop::addSqlAssociation('product', 'p') . '
						LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa
						ON (p.`id_product` = pa.`id_product`)
						' . Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1') . '
						' . Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) . '
						LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl
							ON (product_shop.`id_category_default` = cl.`id_category`
							AND cl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('cl') . ')
						LEFT JOIN `' . _DB_PREFIX_ . 'category_product` cp
							ON (product_shop.`id_product` = cp.`id_product` AND cp.`id_category` = product_shop.`id_category_default` 
							AND cl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('cl') . ')
						LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
							ON (p.`id_product` = pl.`id_product`
							AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . ')
						LEFT JOIN `' . _DB_PREFIX_ . 'image` i
							ON (i.`id_product` = p.`id_product`)' .
                        Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1') . '
						LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il
							ON (image_shop.`id_image` = il.`id_image`
							AND il.`id_lang` = ' . (int) $id_lang . ')
						LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m
							ON m.`id_manufacturer` = p.`id_manufacturer`
						WHERE product_shop.`id_shop` = ' . (int) $context->shop->id . '
						' . $where_products
                            . ($only_active ? ' AND product_shop.`active` = 1' : '') . ' AND product_shop.`visibility` IN ("both", "catalog", "search") GROUP BY p.id_product';

            if ($paginate > 0) {
                $limit = ($paginate - 1) * $nb . ', ' . $nb;
            }
            $sql .= ' ORDER BY ' . (!empty($order_by_prefix) ? $order_by_prefix . '.' : '') . '`' . bqSQL($order_by) . '` ' . pSQL($order_way) . ($paginate > 0 ? ' LIMIT ' . $limit : '');
            // dump($sql);
        }

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return [];
        }

        if ($only_ids || $count) {
            return $result;
        } else {
            return Product::getProductsProperties($id_lang, $result);
        }
    }

    public static function getproductsLight($ids_product = 0)
    {
        if ($ids_product && 0 != $ids_product) {
            $id_lang = Context::getContext()->language->id;

            return Db::getInstance()->executeS(
                '
			SELECT p.`id_product`, p.`reference`, pl.`name`
			FROM `' . _DB_PREFIX_ . 'product`p
			LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
				p.`id_product` = pl.`id_product`
				AND pl.`id_lang` = ' . (int) $id_lang . '
			) 
			WHERE p.id_product IN (' . $ids_product . ') GROUP BY id_product'
            );
        }
    }
}
