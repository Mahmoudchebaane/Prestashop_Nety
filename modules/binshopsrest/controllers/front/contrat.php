<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestcontratModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
        $ref_abonnement = $_REQUEST['ref_abonnement'];
        if (!$ref_abonnement) {
            $success = false;
            $message = 'ref abonnement is required';
            $pgdata = null;
        } else {
            $list = array();
            $client = new Client();
            try {
                $request = $client->createRequest('POST', LINK_CRM . '/api/getInfoContratAbonnee', [
                    'body' => [
                        'ref_abonnement' => $ref_abonnement
                    ]
                ]);

                $response = $client->send($request);
                if ($response->getStatusCode() == 200) {
                    $res = json_decode($response->getBody())->data;
                    foreach ($res as $value) {
                        if ($value->haveContrat) {
                            array_push($list, $value);
                        }
                    }
                    $success = true;
                    $message='';
                    $pgdata =  $list;
                    // $this->ajaxRender(json_encode($result));
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