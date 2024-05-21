<?php
/**
 * BINSHOPS
 *
 * @author BINSHOPS
 * @copyright BINSHOPS
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * Best In Shops eCommerce Solutions Inc.
 *
 */

require_once dirname(__FILE__) . '/../AbstractRESTController.php';

use PrestaShop\PrestaShop\Core\Security\PasswordPolicyConfiguration;
use ZxcvbnPhp\Zxcvbn;

use GuzzleHttp\Client;

class BinshopsrestfacturepdfModuleFrontController extends AbstractRESTController
{
    protected function processPostRequest()
    {
        $_POST = json_decode(Tools::file_get_contents('php://input'), true);
        $client = new Client();
        $ref_facture = $_REQUEST['ref_facture'];
        $type_facture = $_REQUEST['typeFacture'];
        $pgdata =null;
        if (!$ref_facture) {
            $success = false;
            $message = "Ref facture is required";
        } elseif (!$type_facture) {
            $success = false;
            $message = "type facture is required";
        } else {
            try {
                $request = $client->createRequest('POST', LINK_CRM . '/api/facture', [
                    'body' => [
                        'refFacture' => $ref_facture,
                        'typeFacture' => $type_facture
                    ]
                ]);
                $response = $client->send($request);
                if ($response->getStatusCode() == 200) {
                    $pgdata = $response->getBody();
                    $success = true;
                    $message = '';
                } else {

                    $success = false;
                    $message = 'une erreur se produite';
                    $pgdata = null;


                }
            } catch (Exception $e) {              
                $success = false;
                $message = 'une erreur API CRM ';
                $pgdata = null;
            }            
        }
        $this->ajaxRender(json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $pgdata
        ]));die;
    }
}