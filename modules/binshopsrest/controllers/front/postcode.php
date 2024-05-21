<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestpostcodeModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
        $villeid = Tools::getValue('ville_id');
        if ($villeid) {
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM crm_postal_code  WHERE ville_id=' . $villeid);
            $psdata = array(
                'success' => true,
                'data' => $result
            );
        } else {
            $psdata = array(
                'success' => false,
                'data' => null,
                'message' => 'Ville id is required'
            );
        }


        $this->ajaxRender(json_encode(
            $psdata
        ));
        die;


    }
}