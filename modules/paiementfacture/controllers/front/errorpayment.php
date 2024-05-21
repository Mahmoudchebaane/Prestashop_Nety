<?php
require_once _PS_MODULE_DIR_ . 'paiementfacture/classes/PaiementFactureClass.php';
use GuzzleHttp\Client;

class paiementfactureerrorpaymentModuleFrontController extends ModuleFrontController
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
        $logger->logInfo('Enter error paiement | orderId =' . Tools::getValue('orderId'));

        $sql = new DbQuery();
        $sql->select('order_number')
            ->from('paiementfacture')
            ->where('order_id = "' . Tools::getValue('orderId') . '"');
        $data = Db::getInstance()->getRow($sql);
        $langcode = $this->context->language->iso_code;
        if ($data) {
            $client = new Client();
            // $testlinkpay = 'https://test.clictopay.com';
            // $username = '0870565017';
            // $userpassword = 'L32yKy6k';
            // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
            //     $testlinkpay = 'https://ipay.clictopay.com';
            //     $username = '0870565017';
            //     $userpassword = '9K{[,tZ)';
            // }
            $editpayment = new PaiementFactureClass($data['order_number']);
            if ($editpayment  && $editpayment->sendto_crm  !=1) {
                $editpayment = new PaiementFactureClass($data['order_number']);
                $requestcheck = $client->createRequest('GET', LINK_SMT . '/payment/rest/getOrderStatusExtended.do?userName=' . PAYMENT_LOGIN . '&password=' . PAYMENT_PASSWD . '&orderId=' . Tools::getValue('orderId') . '&language=' . $langcode);
                $responsecheck = $client->send($requestcheck);
                $logger->logInfo('error payment: Call api check smt paiement status of factures : ' . $editpayment->factures);
                if ($responsecheck->getStatusCode() == 200) {
                    $successcheck = json_decode($responsecheck->getBody());
                    $message = 'Autorise';
                    if (!array_key_exists('orderStatus', $successcheck)) {
                        $logger->logInfo('api smt return error payment with message :' . $successcheck->errorMessage);
                    } else {
                        switch ((int)$successcheck->orderStatus) {
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

                        $logger->logInfo('error payment: api smt return error payment with message: ' . $message);
                        if ($successcheck->orderStatus == 2) {
                            $logger->logInfo('error payment: return success payment with message ' . $editpayment->message_smt);
                            $editpayment->payment_state = 1;
                            $editpayment->message_smt = $message;
                            $editpayment->save();
                            Tools::redirect($this->context->link->getModuleLink('paiementfacture', 'successpayment') . '?orderId=' . Tools::getValue('orderId') . '&lang=' . $langcode);

                        } else {
                            $logger->logInfo('error payment: return error payment with message ' . $message);
                            $editpayment->payment_state = 0;
                            $editpayment->message_smt = $message;
                            $editpayment->save();

                        }
                    }
                }
            }
        }
        $this->setTemplate('module:paiementfacture/views/templates/front/errorpayment.tpl');
        // $newpaiement->payment_state = null;
        // $newpaiement->sendto_crm = null; 
        $this->context->smarty->assign(
            array(
                'newpaylink' => $this->context->link->getModuleLink('paiementfacture', 'nouveau'),
                'homelink' => Context::getContext()->shop->getBaseURL(true),
                'module_dir' => _MODULE_DIR_ . '/paiementfacture/',
            )
        );

    }



}