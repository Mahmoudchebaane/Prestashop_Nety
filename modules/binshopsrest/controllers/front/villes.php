<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestvillesModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
        $gov_id  = Tools::getValue('gouvernorat_id');
        if ($gov_id){
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM crm_villes WHERE gouvernorat_id='.$gov_id  );
            $psdata = array(
                'success' => true,
                'data' => $result
            );
        }
        else{
            $psdata = array(
                'success' => false,
                'data' => null,
                'message'=>'Gov id is required'
            );
        }
        

        $this->ajaxRender(json_encode(
            $psdata
        ));
        die;

        
    }
}