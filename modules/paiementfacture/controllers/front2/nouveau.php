<?php
require_once _PS_MODULE_DIR_ . 'paiementfacture/classes/PaiementFactureClass.php';
use GuzzleHttp\Client;
use PrestaShop\CircuitBreaker\Client\GuzzleClient;

class paiementfacturenouveauModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();

        Media::addJsDef([
            'my_ajax_url' => $this->context->link->getModuleLink('paiementfacture', 'nouveau')
        ]);

    }


    public function initContent()
    {
        parent::initContent();
 
        $this->setTemplate('module:paiementfacture/views/templates/front/formulairePF.tpl');
        if (Tools::isSubmit('sendtopaybtn')) {
 
            $newpaiement = new PaiementFactureClass();
            $now = new DateTime();
            $newpaiement->created_date = $now->format('Y-m-d H:i:s');
            $newpaiement->modified_date = $now->format('Y-m-d H:i:s');
            $newpaiement->factures = json_encode(Tools::getValue('factures'));
            $newpaiement->client = Tools::getValue('clientname');
            $newpaiement->reference_crm = Tools::getValue('refabonn');
            $newpaiement->num_fixe = Tools::getValue('numfixe');
            $newpaiement->ammount = Tools::getValue('totalammount');
            $newpaiement->payment_type = Tools::getValue('paiement');
            $newpaiement->save();

            $returnURL = $this->context->link->getModuleLink('paiementfacture', 'successpayment');
            $FailURL = $this->context->link->getModuleLink('paiementfacture', 'errorpayment');

            $client = new Client();
            $ammount = floatval($newpaiement->ammount) * 1000;
            $testlinkpay = 'https://test.clictopay.com';
            $langcode = $this->context->language->iso_code == 'ar' ? 'fr' :  $this->context->language->iso_code;
            $currencycode = $this->context->currency->numeric_iso_code;
            $username = '0870565017';
            $userpassword = 'L32yKy6k';
            $request = $client->createRequest('GET', $testlinkpay.'/payment/rest/register.do?amount=' . $ammount . '&currency='.$currencycode.'&language='.$langcode.'&orderNumber=' . (int) $newpaiement->id . '&password='.$userpassword.'&returnUrl=' . $returnURL . '&failUrl=' . $FailURL . '&userName='.$username);
            // dump( $request);die();
           
            $response = $client->send($request);

            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);
                //  dump('response' , $successresponse );die();  
                if (!array_key_exists('errorCode', $successresponse) || (array_key_exists('errorCode', $successresponse) && $successresponse['errorCode'] == 0 )) {
                    $newpaiement->order_id = $successresponse['orderId'];
                    $newpaiement->sendto_pay = true;
                    $newpaiement->save();
                    Tools::redirect($successresponse['formUrl']);
                } else {
                    $newpaiement->message = $successresponse['errorMessage'];
                    $newpaiement->save();
                    $this->context->controller->errors[] = $this->trans(
                        'Une erreur systeme se produite' . $successresponse['errorMessage'],
                        [],
                        'Modules.paiementfacture'
                    );
                }
            } else {
                $newpaiement->message_smt = $response->getStatusCode();
                $newpaiement->sendto_pay = true;
                $newpaiement->save();
                $this->context->controller->errors[] = $this->trans(
                    'Une erreur systeme se produite ',
                    [],
                    'Modules.paiementfacture'
                );
            }

        }

        //Gestion de l'affichage du captcha
        if ($eicaptcha = Module::getInstanceByName('eicaptcha')) {
          
            $this->context->smarty->assign([
                'module_dir' => _MODULE_DIR_ . '/paiementfacture/',
                'renderCaptcha' => $eicaptcha->hookDisplayEicaptchaVerification(['module' => 'paiementfacture' ])
            ]); 

        } else {
            $this->context->smarty->assign([
                'module_dir' => _MODULE_DIR_ . '/paiementfacture/',
                'renderCaptcha' => ''
            ]);

        } 

    }


    public function displayAjaxGetFactures()
    {
        $type_identif = (int) Tools::getValue('type_identif');
        $identif = (string) Tools::getValue('identifiant');
        $client = new GuzzleClient();

        try {
            //$linkcrm = 'https://crm.chifco.com';
            //if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
            //    $linkcrm = 'https://customer.chifco.com';
            //}
            $response = $client->request(LINK_CRM . '/api/listeFactureNonPayee?identifiant=' . $identif . '&type_identif=' . $type_identif, []);
            $this->ajaxRender($response);

        } catch (Exception $e) {
            $this->ajaxRender(
                json_encode([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'data' => null
                ])
            );
        }


    }


}