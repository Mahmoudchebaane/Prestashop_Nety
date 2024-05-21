<?php

require_once dirname(__FILE__) . '/../AbstractRESTController.php';

class  BinshopsrestAlltoppackModuleFrontController extends AbstractRESTController
{
    protected function processGetRequest()
    {
        $lang=1;
        if(Tools::getValue('lang'))
        {
            $lang = Tools::getValue('lang');
        }
        $sql="SELECT p.id_product, pl.name AS product_name, CONCAT(i.id_product, '-', i.id_image, '.jpg') AS url_image
FROM ps_product p
INNER JOIN ps_product_lang pl ON p.id_product = pl.id_product
LEFT JOIN ps_image i ON p.id_product = i.id_product AND i.cover = 1
WHERE p.product_type = 'pack'
AND pl.id_shop = 1
AND pl.id_lang=1";
        $psdata = Db::getInstance()->executeS($sql);
        $this->ajaxRender(json_encode([
            'success' => true,
            'code' => 200,
            'psdata' => $psdata
        ]));
        die;
    }

}