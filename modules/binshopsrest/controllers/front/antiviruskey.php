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
require_once dirname(__FILE__) . '/../AbstractRESTController.php';


/**
 * This REST endpoint gets details of a product
 *
 * This module can be used to get category products, pagination and faceted search
 */
use GuzzleHttp\Client;
class BinshopsrestantiviruskeyModuleFrontController extends AbstractRESTController
{
    protected function processGetRequest()
    {
        $ref_abonnement = Tools::getValue('ref_abonnement');
        $client=new Client();
        $success=false;
        try {
            $request = $client->createRequest('POST', LINK_CRM . '/api/getAntiVirusKey', [
                'body' => [
                    'ref_abonnement' => $ref_abonnement
                ]
            ]);
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);
                $success = true;
                $message = $successresponse['message'];
            }
            else{
                $success=false;
                $message= 'An error occured api crm';
            }
        }catch(Exception $e){
            $success=false;
            $message= 'error:'.$e;
        }
        $this->ajaxRender(json_encode([
            'success' => $success,           
            'message' => $message
        ]));
        die;
    }
    
}

