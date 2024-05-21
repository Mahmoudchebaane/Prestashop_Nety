<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestcredentialsModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {

        header('Content-Type: ' . "application/json");
        try {
            $client = new Client();
            $identifiant = Tools::getValue('identifiant');
            $num_fixe = Tools::getValue('num_fixe');
            $request = $client->createRequest('POST', LINK_CRM . '/api/getAbonneeCRM', [
                'body' => [
                    'identifiant' => $identifiant,
                    'num_fixe' => $num_fixe,
                ]
            ]);
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                $res = json_decode($response->getBody())->data;
                $tel = $res->num_mobile;
                $successresponse = json_decode($response->getBody(), 1);
                if ($successresponse['success']) {
                    $email = ($successresponse['data']['email']);
                    $phone = ($successresponse['data']['num_mobile']);
                    $firstname = ($successresponse['data']['prenom']);
                    $lastname = ($successresponse['data']['nom']);
                    // $this->context->customer->save();
                }
                
                $psdata = array('success' => true,
                    'code' => 200,
                    'data' => $successresponse);

            } else {
                $psdata = array(
                        'success' => false,
                        'message' => 'une erreur se produite',
                        'data' => null                    
                );
            }
        } catch (Exception $e) {
            $psdata = array(
                    'success' => false,
                    'message' => 'error: ' . $e->getMessage(),
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