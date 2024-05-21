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

require_once _PS_MODULE_DIR_ . 'paiementfacture/classes/paiementFactureClass.php';
use GuzzleHttp\Client;

class BinshopsrestpaiementfactureModuleFrontController extends AbstractRESTController
{
    protected function processPostRequest()
    {
        $_POST = json_decode(Tools::file_get_contents('php://input'), true);

        $psdata = null;
        $message = "success";
        $hasError = false;
        $messageCode = 0;
        $success = false;
        $client = new Client();
        $logger = new FileLogger();
        $filePath = _PS_ROOT_DIR_ . '/var/logs/' . _PS_ENV_ . '_payment.log';
        $logger->setFilename($filePath);
        $logger->logInfo('Entrer controller paiement facture for mobile app ');
        $logger->logInfo('send to pay process');
        $newpaiement = new PaiementFactureClass();
        $now = new DateTime();
        
        if (!Tools::getValue('factures')) {
            $success = false;
            $message = 'list of invoices is required ';
        } elseif (!Tools::getValue('order_number')) {
            $success = false;
            $message = 'order number is required ';
        } elseif (!Tools::getValue('order_id')) {
            $success = false;
            $message = 'order id is required ';
        } elseif (!Tools::getValue('client_name')) {
            $success = false;
            $message = 'client name is required ';
        } elseif (!Tools::getValue('ref_abonnement')) {
            $success = false;
            $message = 'ref abonnement required ';
        } elseif (!Tools::getValue('numfixe')) {
            $success = false;
            $message = 'numfixe is required ';
        } elseif (!Tools::getValue('totalammount')) {
            $success = false;
            $message = 'Total to pay is required';
        } elseif (!Tools::getValue('paiement_type')) {
            $success = false;
            $message = 'paiement_type is required';
        } elseif (!Tools::getValue('sent_to_pay')) {
            $success = false;
            $message = 'Send to pay is required';
        } elseif (!Tools::getValue('order_status')) {
            $success = false;
            $message = 'order status is required';
        } else {
            $newpaiement->created_date = $now->format('Y-m-d H:i:s');
            $newpaiement->modified_date = $now->format('Y-m-d H:i:s');
            $newpaiement->factures =Tools::getValue('factures');
            $newpaiement->order_number = Tools::getValue('order_number');
            $newpaiement->order_id = Tools::getValue('order_id');
            $newpaiement->client = Tools::getValue('client_name');
            $newpaiement->reference_crm = Tools::getValue('ref_abonnement');
            $newpaiement->num_fixe = Tools::getValue('numfixe');
            $newpaiement->ammount = Tools::getValue('totalammount');
            $newpaiement->payment_type = Tools::getValue('paiement_type'); //carte bancaire
            $newpaiement->sendto_pay = (bool)Tools::getValue('sent_to_pay');
            $order_status = Tools::getValue('order_status'); //retour SMT
            switch ((int) $order_status) {
                case 0:
                    $message_smt = '0 -> Commande enregistrée, mais pas payé';
                    break;
                case 1:
                    $message_smt = '1 -> Montant pré-autorisation bloqué (pour le paiement en deux phases)';
                    break;
                case 2:
                    $message_smt = '2 -> Le montant a été déposé avec succès';
                    break;
                case 3:
                    $message_smt = '3 -> Annulation d\'autorisation';
                    break;
                case 4:
                    $message_smt = '4 -> La transaction a été remboursé';
                    break;
                case 5:
                    $message_smt = '5 -> Autorisation par ACS de l\'émetteur initié';
                    break;
                case 6:
                    $message_smt = '6 -> Autorisation refusé';
                    break;
            }

            // $newpaiement->message = $message;

            if ($order_status == 2) {
                $logger->logInfo('Mobile Customer payment: return success payment with message:' . $message);
                $newpaiement->payment_state = 1;
                $newpaiement->message_smt = $message_smt;
                $newpaiement->save();
            } else {
                $logger->logInfo('MobileCustomer payment: return error payment with message :' . $message);
                $newpaiement->payment_state = 0;
                $newpaiement->message_smt = $message_smt;
                $newpaiement->save();
            }
            $newpaiement->save();
            $headers = [
                'Content-Type' => 'application/json'
            ];
            try {
                $body = '{
                "factures": ' . $newpaiement->factures . ',
                "transactionId": "' . $newpaiement->order_id . '",
                "bankname": "",
                "methodePayment": ""  
                }';

                $request = $client->createRequest('POST', LINK_CRM . '/api/payeementFacture', ['headers' => $headers, 'body' => $body]);
                $response = $client->send($request);
                $logger->logInfo('Mobile Customer success: CALL CRM API to pay CRM factures : ' . $newpaiement->factures);
                if ($response->getStatusCode() == 200) {
                    $successresponse = json_decode($response->getBody(), 1);
                    if ($successresponse['success']) {
                        $logger->logInfo('Mobile Customer payment: Call API pay CRM factures return succsess response with message : ' . $successresponse['message']);
                        $newpaiement->sendto_crm = 1;
                        $newpaiement->message = 'Payé et envoyé au CRM ';
                        $success = true;
                        $message = 'Payé et envoyé au CRM';
                    } else {
                        $logger->logInfo('Mobile Customer payment: Call API pay CRM factures return error response with message : ' . $successresponse['message']);
                        $newpaiement->sendto_crm = 0;
                        $success = false;
                        $newpaiement->message = $successresponse['message'];
                        $message = $successresponse['message'];

                    }
                    $newpaiement->save();
                }
            } catch (Exception $e) {
                $logger->logInfo('Mobile Customer payment: Call API pay CRM factures return Exception with message : ' . $e->getMessage());
                $newpaiement->payment_state = 1;
                $newpaiement->sendto_crm = 0;
                $newpaiement->message = 'Une erreur lors de l\'envoie au CRM';
                $success = false;
                $message = 'Une erreur lors de l\'envoie au CRM';
                $newpaiement->save();
            }
        }
        $this->ajaxRender(json_encode([
            'success' => $success,
            'message' => $message
        ]));
        die;
    }
}
