<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestgouverneratsModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `crm_gouvernorats`');
        $psdata = array(
            'success' => true,
            'data' => $result
        );

        $this->ajaxRender(json_encode(
            $psdata
        ));
        die;

 
    }
}