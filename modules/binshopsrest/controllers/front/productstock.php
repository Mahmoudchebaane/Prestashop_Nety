<?php

/**
 * BINSHOPS | Best In Shops
 *
 * @author BINSHOPS | Best In Shops
 * @copyright BINSHOPS | Best In Shops
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * Best In Shops eCommerce Solutions Inc.
 *
 */

require_once dirname(__FILE__) . '/../AbstractRESTController.php';


class BinshopsrestProductstockModuleFrontController extends AbstractRESTController
{
    protected function processGetRequest()
    {
        $productId = (int)Tools::getValue('productId');
        $ProductAttribute = (int)Tools::getValue('ProductAttribute');
        $sql = 'SELECT DISTINCT s.quantity,s.id_product, p.name 
        FROM ' . _DB_PREFIX_ . 'stock_available s 
        LEFT JOIN ' . _DB_PREFIX_ . 'product_lang p ON p.id_product = s.id_product 
        WHERE p.id_product = ' . (int)$productId . ' AND p.id_lang = ' . (int)$this->context->language->id . ' AND s.id_product_attribute ='.(int)$ProductAttribute.'  AND s.id_shop = ' . (int)$this->context->shop->id;

        $result = Db::getInstance()->executeS($sql);

        if ($result) {
            $this->ajaxRender(json_encode([
                'code' => 200,
                'success' => true,
                'data' => $result
            ]));
            die;

        } else {
            $this->ajaxRender(json_encode([
                'code' => 404,
                'success' => false,
                'message' => 'Product stock not found'
            ]));
            die;
        }
    }
}
