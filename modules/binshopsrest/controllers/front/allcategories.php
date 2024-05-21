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



class BinshopsrestAllcategoriesModuleFrontController extends AbstractRESTController
{
    protected $categoryRepository;

    protected function processGetRequest()
    {

        $lang=1;
        if(Tools::getValue('lang'))
        {
            $lang = Tools::getValue('lang');
        }
        $sql = 'SELECT * FROM ps_category_lang where id_shop=1 and id_lang='.$lang.' AND description !="" ';
        $result = Db::getInstance()->executeS($sql);

        if (($result)) {
            $this->ajaxRender(json_encode([
                'code' => 200,
                'success' => true,
                'data' => $result
            ]));
            die;
        }
    }
}
