<?php
use PrestaShop\Decimal\DecimalNumber;


class Product extends ProductCore
{
 
    /**
     * Get product accessories.
     *
     * @param int|null $id_product Product identifier
     * @param bool $active
     * @param int|null $id_lang Language identifier
     * @param int|null $id_shop Shop identifier
     * @param Context|null $context Context to use for retrieve cart
     *
     * @return array Product accessories
     */
    public static function getAccessoriesStatic($id_product = null, $active = true, $id_lang = null, $id_shop = null, Context $context = null)
    {

        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`,
                    pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`,
                    image_shop.`id_image` id_image, il.`legend`, m.`name` as manufacturer_name, cl.`name` AS category_default, IFNULL(product_attribute_shop.id_product_attribute, 0) id_product_attribute,
                    DATEDIFF(
                        p.`date_add`,
                        DATE_SUB(
                            "' . date('Y-m-d') . ' 00:00:00",
                            INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY
                        )
                    ) > 0 AS new
                FROM `' . _DB_PREFIX_ . 'accessory`
                LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON p.`id_product` = `id_product_2`
                ' . Shop::addSqlAssociation('product', 'p') . '
                LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
                    ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $id_shop . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
                    p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . '
                )
                LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (
                    product_shop.`id_category_default` = cl.`id_category`
                    AND cl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('cl') . '
                )
                LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
                    ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $id_shop . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (p.`id_manufacturer`= m.`id_manufacturer`)
                ' . Product::sqlStock('p', 0) . '
                WHERE `id_product_1` = ' . (int) $id_product .
            ($active ? ' AND product_shop.`active` = 1 AND product_shop.`visibility` != \'none\'' : '') . '
                GROUP BY product_shop.id_product';

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return [];
        }


        $assembler = new ProductAssembler($context);
        $presenterFactory = new ProductPresenterFactory($context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = $presenterFactory->getPresenter();
        foreach ($result as $k => &$row) {
            if (!Product::checkAccessStatic((int) $row['id_product'], false)) {
                unset($result[$k]);

                continue;
            } else {
                $row['id_product_attribute'] = Product::getDefaultAttribute((int) $row['id_product']);
            }
            $result[$k] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($row),
                $context->language
            );

        }


        return $result; 
    }

}