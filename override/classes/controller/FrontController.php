<?php
class FrontController extends FrontControllerCore
{
    /*
    * module: binshopsrest
    * date: 2023-12-18 13:12:34
    * version: 2.5.0
    */
    public function restRun(){
        header('Content-Type: ' . "application/json");
        if (Tools::getValue('iso_currency')){
            $_GET['id_currency'] = (string)Currency::getIdByIsoCode(Tools::getValue('iso_currency'));
            $_GET['SubmitCurrency'] = "1";
        }
        parent::init();
        $response = [
            'success' => true,
            'code' => 210,
            'psdata' => null,
            'message' => 'empty'
        ];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $response = $this->processGetRequest();
                break;
            case 'POST':
                $response = $this->processPostRequest();
                break;
            case 'PATCH':
            case 'PUT':
                $response = $this->processPutRequest();
                break;
            case 'DELETE':
                $response = $this->processDeleteRequest();
                break;
            default:
        }
        $this->ajaxRender(json_encode($response));
        die;
    }
    /*
    * module: binshopsrest
    * date: 2023-12-18 13:12:34
    * version: 2.5.0
    */
    protected function processGetRequest(){
        return [
            'success' => true,
            'code' => 310,
            'psdata' => null,
            'message' => $this->trans('GET not supported on this path', [], 'Modules.Binshopsrest.Admin'),
        ];
    }
    /*
    * module: binshopsrest
    * date: 2023-12-18 13:12:34
    * version: 2.5.0
    */
    protected function processPostRequest(){
        return [
            'success' => true,
            'code' => 310,
            'psdata' => null,
            'message' => $this->trans('POST not supported on this path', [], 'Modules.Binshopsrest.Admin'),
        ];
    }
    /*
    * module: binshopsrest
    * date: 2023-12-18 13:12:34
    * version: 2.5.0
    */
    protected function processPutRequest(){
        return [
            'success' => true,
            'code' => 310,
            'psdata' => null,
            'message' => $this->trans('PUT not supported on this path', [], 'Modules.Binshopsrest.Admin'),
        ];
    }
    /*
    * module: binshopsrest
    * date: 2023-12-18 13:12:34
    * version: 2.5.0
    */
    protected function processDeleteRequest(){
        return [
            'success' => true,
            'code' => 310,
            'psdata' => null,
            'message' => $this->trans('DELETE not supported on this path', [], 'Modules.Binshopsrest.Admin'),
        ];
    }
}
