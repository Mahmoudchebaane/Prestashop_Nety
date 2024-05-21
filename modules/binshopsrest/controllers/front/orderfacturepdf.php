<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestorderfacturepdfModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
      $id_order= $_REQUEST['id_order'];
      dump($_ENV);die;
      Tools::redirect('/fr/index.php?controller=pdf-invoice&id_order='.$id_order);
    }
}