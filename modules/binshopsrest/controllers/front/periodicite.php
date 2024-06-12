<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestperiodiciteModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
        $periode = ['Mensuel', 'Trimestriel', 'Semestriel', 'Annuel'];
        $psdata = array(
            'success' => true,
            'data' => $periode
        );
        $this->ajaxRender(json_encode(
            $psdata
        ));
        die;
    }
}