<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

use PrestaShop\PrestaShop\Core\Domain\Product\Pack\ValueObject\PackStockType;


class Pack extends PackCore
{
    /**
     * Only decrement pack quantity.
     *
     * @var string
     */
    const STOCK_TYPE_PACK_ONLY = PackStockType::STOCK_TYPE_PACK_ONLY;

    /**
     * Only decrement pack products quantities.
     *
     * @var string
     */
    const STOCK_TYPE_PRODUCTS_ONLY = PackStockType::STOCK_TYPE_PRODUCTS_ONLY;

    /**
     * Decrement pack quantity and pack products quantities.
     *
     * @var string
     */
    const STOCK_TYPE_PACK_BOTH = PackStockType::STOCK_TYPE_BOTH;

    /**
     * Use pack quantity default setting.
     *
     * @var string
     */
    const STOCK_TYPE_DEFAULT = PackStockType::STOCK_TYPE_DEFAULT;

    /**
     * Returns the available quantity of a given pack (this method already have decreased products in cart).
     *
     * @param int $id_product Product id
     * @param int $id_product_attribute Product attribute id (optional)
     * @param bool|null $cacheIsPack
     * @param Cart $cart
     * @param int $idCustomization Product customization id (optional)
     *
     * @return int
     *
     * @throws PrestaShopException
     */
    public static function getQuantity(
        $idProduct,
        $idProductAttribute = null,
        $cacheIsPack = null,
        Cart $cart = null,
        $idCustomization = null
    ) {
        $idProduct = (int) $idProduct;
        $idProductAttribute = (int) $idProductAttribute;
        $cacheIsPack = (bool) $cacheIsPack;

        if (!self::isPack($idProduct)) {
            throw new PrestaShopException("Product with id $idProduct is not a pack");
        }

        // Initialize
        $product = new Product($idProduct, false);
        $packQuantity = 0;
        $packQuantityInStock = StockAvailable::getQuantityAvailableByProduct(
            $idProduct,
            $idProductAttribute
        );
        $packStockType = $product->pack_stock_type;
        $allPackStockType = [
            self::STOCK_TYPE_PACK_ONLY,
            self::STOCK_TYPE_PRODUCTS_ONLY,
            self::STOCK_TYPE_PACK_BOTH,
            self::STOCK_TYPE_DEFAULT,
        ];

        if (!in_array($packStockType, $allPackStockType)) {
            throw new PrestaShopException('Unknown pack stock type');
        }

        // If no pack stock or shop default, set it
        if (empty($packStockType)
            || $packStockType == self::STOCK_TYPE_DEFAULT
        ) {
            $packStockType = Configuration::get('PS_PACK_STOCK_TYPE');
        }

        // Initialize with pack quantity if not only products
        if (in_array($packStockType, [self::STOCK_TYPE_PACK_ONLY, self::STOCK_TYPE_PACK_BOTH])) {
            $packQuantity = $packQuantityInStock;
        }
        // Initialize with pack quantity if not only products
        if (in_array($packStockType, [self::STOCK_TYPE_PACK_BOTH])) {
            $packQuantity = $packQuantityInStock;
            $items = array_values(Pack::getItems($idProduct, Configuration::get('PS_LANG_DEFAULT')));
            foreach ($items as $index => $item) {
                $itemQuantity = Product::getQuantity($item->id, $item->id_pack_product_attribute ?: null, null, $cart, $idCustomization);
                $nbPackAvailableForItem = (int) floor($itemQuantity / $item->pack_quantity);

                // Initialize packQuantity with the first product quantity
                // if pack decrement stock type is products only
                if ($index === 0
                    && $packStockType == self::STOCK_TYPE_PRODUCTS_ONLY
                ) {
                    $packQuantity = $nbPackAvailableForItem;
                    continue;
                }

                if ($nbPackAvailableForItem < $packQuantity) {
                    $packQuantity = $nbPackAvailableForItem;
                }
            }
        }
        // Set pack quantity to the minimum quantity of pack, or
        // product pack
        if (in_array($packStockType, [self::STOCK_TYPE_PRODUCTS_ONLY])) {
            $items = array_values(Pack::getItems($idProduct, Configuration::get('PS_LANG_DEFAULT')));

            foreach ($items as $index => $item) {
                $itemQuantity = Product::getQuantity($item->id, $item->id_pack_product_attribute ?: null, null, $cart, $idCustomization);
                $nbPackAvailableForItem = (int) floor($itemQuantity / $item->pack_quantity);

                // Initialize packQuantity with the first product quantity
                // if pack decrement stock type is products only
                if ($index === 0
                    && $packStockType == self::STOCK_TYPE_PRODUCTS_ONLY
                ) {
                    $packQuantity = $nbPackAvailableForItem;

                    continue;
                }

                if ($nbPackAvailableForItem < $packQuantity) {
                    $packQuantity = $nbPackAvailableForItem;
                }
            }
        } elseif (!empty($cart)) {
            $cartProduct = $cart->getProductQuantity($idProduct, $idProductAttribute, $idCustomization);

            if (!empty($cartProduct['deep_quantity'])) {
                $packQuantity -= $cartProduct['deep_quantity'];
            }
        }

        return $packQuantity;
    }

}
