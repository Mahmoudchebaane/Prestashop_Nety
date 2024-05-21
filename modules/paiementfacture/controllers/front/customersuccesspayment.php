<?php
require_once _PS_MODULE_DIR_ . 'paiementfacture/classes/PaiementFactureClass.php';
use Dotenv\Regex\Success;
use GuzzleHttp\Client;


class paiementfacturecustomersuccesspaymentModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();

    }


    public function initContent()
    {
        parent::initContent();
        $logger = new FileLogger();
        $filePath = _PS_ROOT_DIR_ . '/var/logs/' . _PS_ENV_ . '_payment.log';
        $logger->setFilename($filePath);
        $logger->logInfo('Enter customer success payment | orderId=' . Tools::getValue('orderId'));
        $sql = new DbQuery();
        $sql->select('order_number')
            ->from('paiementfacture')
            ->where('order_id = "' . Tools::getValue('orderId') . '"');
        $data = Db::getInstance()->getRow($sql);

        if ($data) {
            $client = new Client();
            $langcode = $this->context->language->iso_code;
            // $testlinkpay = 'https://test.clictopay.com';            
            // $username = '0870565017';
            // $userpassword = 'L32yKy6k';

            $editpayment = new PaiementFactureClass($data['order_number']);

            if ($editpayment && $editpayment->sendto_crm != 1) {
                $requestcheck = $client->createRequest('GET', LINK_SMT . '/payment/rest/getOrderStatusExtended.do?userName=' . PAYMENT_LOGIN . '&password=' . PAYMENT_PASSWD . '&orderId=' . Tools::getValue('orderId') . '&language=' . $langcode);
                $responsecheck = $client->send($requestcheck);
                $logger->logInfo('cutomer payment: Call api check smt paiement status of factures : ' . $editpayment->factures);
                if ($responsecheck->getStatusCode() == 200) {
                    $successcheck = json_decode($responsecheck->getBody(), 1);
                    $message = 'Autorise';
                    if (!array_key_exists('orderStatus', $successcheck)) {
                        $logger->logInfo('customer payment: api smt return error paiement with message :' . $successcheck['errorMessage']);

                    } else {
                        switch ((int) $successcheck['orderStatus']) {
                            case 0:
                                $message = '0 -> Commande enregistrée, mais pas payé';
                                break;
                            case 1:
                                $message = '1 -> Montant pré-autorisation bloqué (pour le paiement en deux phases)';
                                break;
                            case 2:
                                $message = '2 -> Le montant a été déposé avec succès';
                                break;
                            case 3:
                                $message = '3 -> Annulation d\'autorisation';
                                break;
                            case 4:
                                $message = '4 -> La transaction a été remboursé';
                                break;
                            case 5:
                                $message = '5 -> Autorisation par ACS de l\'émetteur initié';
                                break;
                            case 6:
                                $message = '6 -> Autorisation refusé';
                                break;
                        }
                        if ($successcheck['orderStatus'] == 2) {
                            $logger->logInfo('Customer payment: return success payment with message:' . $message);
                            $editpayment->payment_state = 1;
                            $editpayment->message_smt = $message;
                            $editpayment->save();
                        } else {
                            $logger->logInfo('Customer payment: return error payment with message :' . $message);
                            $editpayment->payment_state = 0;
                            $editpayment->message_smt = $message;
                            $editpayment->save();
                            Tools::redirect($this->context->link->getModuleLink('paiementfacture', 'customererrorpayment') . '?orderId=' . Tools::getValue('orderId') . '&lang=' . $langcode);

                        }
                    }
                }
                //  CALL CRM API to post pay facture in crm  
                $headers = [
                    'Content-Type' => 'application/json'
                ];
                try {
                    $body = '{
                        "factures": ' . $editpayment->factures . ',
                        "transactionId": "' . $editpayment->order_id . '",
                        "bankname": "",
                        "methodePayment": ""  
                        }';
                    // $linkcrm = 'https://crm.chifco.com';
                    // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
                    //     $linkcrm = 'https://customer.chifco.com';
                    // }
                    $request = $client->createRequest('POST', LINK_CRM . '/api/payeementFacture', ['headers' => $headers, 'body' => $body]);
                    $response = $client->send($request);
                    $logger->logInfo('Customer success: CALL CRM API to pay CRM factures : ' . $editpayment->factures);
                    if ($response->getStatusCode() == 200) {
                        $successresponse = json_decode($response->getBody(), 1);
                        if ($successresponse['success']) {
                            $logger->logInfo('Customer payment: Call API pay CRM factures return succsess response with message : ' . $successresponse['message']);
                            $editpayment->payment_state = 1;
                            $editpayment->sendto_crm = 1;
                            $editpayment->message = 'Payé et envoyé au CRM ';
                        } else {
                            $logger->logInfo('Customer payment: Call API pay CRM factures return error response with message : ' . $successresponse['message']);
                            $editpayment->payment_state = 0;
                            $editpayment->sendto_crm = 0;
                            $editpayment->message = $successresponse['message'];
                        }
                        $editpayment->save();
                    }
                } catch (Exception $e) {
                    $logger->logInfo('Customer payment: Call API pay CRM factures return Exception with message : ' . $e->getMessage());
                    $editpayment->payment_state = 1;
                    $editpayment->sendto_crm = 0;
                    $editpayment->message = 'Une erreur lors de l\'envoie au CRM';
                    $editpayment->save();
                }
            }
        }
        $this->setTemplate('module:paiementfacture/views/templates/front/customersuccesspayment.tpl');
        $this->context->smarty->assign(
            array(
                'listpaylink' => $this->context->link->getPageLink('facturesCRM'),
                'module_dir' => _MODULE_DIR_ . '/paiementfacture/',
            )
        );

    }



}