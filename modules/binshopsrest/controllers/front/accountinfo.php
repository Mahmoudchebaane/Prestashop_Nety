<?php
/**
 * BINSHOPS | Best In Shops
 *
 * @author BINSHOPS | Best In Shops
 * @copyright BINSHOPS | Best In Shops
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * Best In Shops eCommerce Solutions Inc.
 *
 */
use GuzzleHttp\Client;
require_once dirname(__FILE__) . '/../AbstractAuthRESTController.php';

class BinshopsrestAccountinfoModuleFrontController extends AbstractAuthRESTController
{
    protected function processGetRequest()
    {

        $user = $this->context->customer;
        unset($user->secure_key);
        unset($user->passwd);
        unset($user->last_passwd_gen);
        unset($user->reset_password_token);
        unset($user->reset_password_validity);
        if ($user->ref_abonnement) {
            try {
                $client = new Client();              
                $request = $client->createRequest('POST', LINK_CRM . '/api/getAbonneeCRM', [
                    'body' => [
                        'identifiant' => $user->ref_client,
                        'num_fixe' => $user->num_fixe,
                    ]
                ]);
                $response = $client->send($request);
                if ($response->getStatusCode() == 200) {                    
                    $successresponse = json_decode($response->getBody(), 1);                    
                    if ($successresponse['success']) {
                        $offre = ($successresponse['data']['nameOffre']);
                        // $this->context->customer->save();
                    }
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
            $this->ajaxRender(json_encode([
                'code' => 200,
                'success' => true,
                'offre'=>$offre,
                'psdata' => $user
            ]));
            die;
        } else {
            $this->ajaxRender(json_encode([
                'code' => 200,
                'success' => true,
                'psdata' => $user,
                
            ]));
            die;
        }
    }
}
