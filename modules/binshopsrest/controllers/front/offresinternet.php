<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestoffresinternetModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {

        $category = new Category(4, (int) (Context::getContext()->language->id));
        // $category->id ==  4  && count($category->getSubCategories($id_lang)) > 0
        $products = $category->getProducts(1, 1, 8);
        $offres = [];
        foreach ($products as $offre) {
            $value = [
                "name" => $offre['name'],
                "reference" => $offre['reference'],
                "price" => $offre['price'],
            ];
            array_push($offres, $value);
        }
        $psdata = array(
            'success' => false,
            'data' => $offres
        );
        $this->ajaxRender(json_encode(
            $psdata
        ));
        die;


    }
}