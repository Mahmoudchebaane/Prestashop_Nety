<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestpdfcontratModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
        $reference = $_REQUEST['ref_contrat'];
        if (!$reference) {
            $success = false;
            $message = 'ref contrat is required';
            $pgdata = null;
        } else {
            $list = array();
            $client = new Client();
            try {
                $request = $client->createRequest('POST', LINK_CRM . '/api/getContratFile', [
                    'body' => [
                        'reference' => $reference
                    ]
                ]);
                $response = $client->send($request);
                if ($response->getStatusCode() == 200) {
                    $this->ajaxRender($response->getBody());die;
                } else {
                    $success = false;
                    $message = 'une erreur se produite';
                    $pgdata = null;
                }
            } catch (Exception $e) {
                $success = false;
                $message = 'error: ' . $e->getMessage();
                $pgdata = null;
                
            }            
        }
        $this->ajaxRender(json_encode([
            'success' => $success,
            'message' => $message,
            'pgdata' => $pgdata
        ]));
        die;
    }
}