<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestidentifierModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {

        header('Content-Type: ' . "application/json");
        $identifiant = Tools::getValue('identifiant');
        if ($identifiant) {

            $client = new Client();
            $optionsexist = [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'body' => [
                    'cin' => $identifiant,
                ]
            ];

            try {
                $request = $client->createRequest('POST', LINK_CRM . '/api/verificationexistancecin', $optionsexist);
                $response = $client->send($request);
                if ($response->getStatusCode() == 200) {
                    $successresponse = json_decode($response->getBody(), 1);
                    if ($successresponse['verif'] == "true") {
                       
                        $psdata = array(
                            'success' => false,
                            'message' => $successresponse['msg'],
                            'data' => null
                        );  
                    } else {
                        $psdata = array(
                            'success' => false,
                            'message' => 'Identifier is already used, please choose another one',
                            'data' => null
                        );                        
                    }
                } else {
                    $psdata = array(
                        'success' => false,
                        'message' => 'An error occured',
                        'data' => null
                    );                
                }
            } catch (Exception $e) {
                $psdata = array(
                    'success' => false,
                    'message' => 'An error occured',
                    'data' => null
                );
            }
        } else {
            $psdata = array(
                'success' => false,
                'message' => 'Identifier is missing',
                'data' => null
            );
        }
        $this->ajaxRender(json_encode(
            $psdata
        ));
        die;

        parent::init();
    }
}