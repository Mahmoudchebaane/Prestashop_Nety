<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 
 */ 
require_once (_PS_MODULE_DIR_.'paiementfacture/classes/PaiementFactureClass.php');
use GuzzleHttp\Client;
use PrestaShop\CircuitBreaker\Client\GuzzleClient;


class facturesCRMController extends FrontController
{
    public $auth = true;
    public $php_self = 'facturesCRM';
    public $authRedirection = 'facturesCRM';
    public $ssl = true;

    protected $customer;



    public function init()
    {

        parent::init();
        
        $this->customer = $this->context->customer;
    }
    public function postProcess()
    {
        return $this->customer;
    }
    public function initContent()
    {
        parent::initContent();
        $logger = new FileLogger();
        $filePath = _PS_ROOT_DIR_ . '/var/logs/' . _PS_ENV_ . '_payment.log';
        $logger->setFilename($filePath);
        $logger->logInfo('Enter customer invoices ');
        if (Tools::isSubmit('listpaybtn')) {
            $logger->logInfo('listpaybtn btn clicked');
            $newpaiement = new PaiementFactureClass();
            $now = new DateTime();
            $newpaiement->created_date = $now->format('Y-m-d H:i:s');
            $newpaiement->modified_date = $now->format('Y-m-d H:i:s');
            $newpaiement->factures = json_encode(Tools::getValue('factures'));
            $newpaiement->client = $this->customer->firstname . ' ' . $this->customer->lastname;
            $newpaiement->reference_crm = $this->customer->ref_abonnement ;
            $newpaiement->num_fixe =  $this->customer->num_fixe ;
            $newpaiement->ammount = Tools::getValue('totalammount'); 
            $newpaiement->payment_type = Tools::getValue('paiement'); 
            $newpaiement->save();
            $returnURL = $this->context->link->getModuleLink('paiementfacture', 'customersuccesspayment');
            $FailURL = $this->context->link->getModuleLink('paiementfacture', 'customererrorpayment');
            $client = new Client();
            $ammount = floatval($newpaiement->ammount) * 1000;            
            $langcode = $this->context->language->iso_code == 'ar' ? 'fr' :  $this->context->language->iso_code;
            $currencycode = $this->context->currency->numeric_iso_code;          
            $request = $client->createRequest('GET', LINK_SMT.'/payment/rest/register.do?amount=' . $ammount . '&currency='.$currencycode.'&language='.$langcode.'&orderNumber=' . (int) $newpaiement->id . '&password='.PAYMENT_PASSWD.'&returnUrl=' . $returnURL . '&failUrl=' . $FailURL . '&userName='.PAYMENT_LOGIN);            
            $logger->logInfo('Customer invoice: CALL CRM API to pay CRM factures : ' . $newpaiement->factures );
            $response = $client->send($request); 
            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);
                if (!array_key_exists('errorCode', $successresponse) || (array_key_exists('errorCode', $successresponse) && $successresponse['errorCode'] == 0 )) {
                    $logger->logInfo('Customer invoice: Call API pay CRM factures return succsess response with message : ' .$successresponse['orderId']  );
                    $newpaiement->order_id = $successresponse['orderId'];
                    $newpaiement->sendto_pay = true;
                    $newpaiement->save();
                    Tools::redirect($successresponse['formUrl']);
                } else {
                    $logger->logInfo('Customer invoice: Call API pay CRM factures return error response with message : ' .$successresponse['errorMessage']  );
                    $newpaiement->message = $successresponse['errorMessage'];
                    $newpaiement->save();
                    $this->context->controller->errors[] = $this->trans(
                        'Une erreur systeme se produite' . $successresponse['errorMessage'],
                        [],
                        'Modules.paiementfacture'
                    );
                }
            } else {
                $logger->logInfo('Customer invoice: Call API pay  return error response with message : ' .$newpaiement->message_smt  );
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
        $id_customer = $this->customer->id;
        $this->context->smarty->assign(
            array(
                'id_customer' => $id_customer,
            )
        ); 
        $this->setTemplate('customer/factures_crm');

    }

    public function setMedia()  
    {
        parent::setMedia();
        
    }
    

    public function displayAjaxConsulterFacture(){
         
        $client = new Client();   
        $ref_facture = Tools::getValue('ref_facture');
        $type_facture = Tools::getValue('typeFacture');
 
        try {           
            $request = $client->createRequest('POST',LINK_CRM . '/api/facture', [
                'body' => [
                    'refFacture'=> $ref_facture,
                    'typeFacture'=>$type_facture
                ]
            ]);
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) { 
                $this->ajaxRender($response->getBody());
            } else {  
                $this->ajaxRender(
                    json_encode([
                        'success' => false,
                        'message' => 'une erreur se produite',
                        'data' => null
                    ])
                );
            }
        } catch (Exception $e) {            
            $this->ajaxRender(
                json_encode([
                    'success' => false,
                    'message' => 'error: ' . $e->getMessage(),
                    'data' => null
                ])
            );
        }    
    }
    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links']=[];
        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
         
        $breadcrumb['links'][] = [
            'title' => $this->trans('My invoices', [], 'Shop.Theme.Customeraccount'),
            'url' => $this->context->link->getPageLink('facturesCRM', true),
        ];
        return $breadcrumb;
    }
    
    public function displayAjaxlistFacture(){
        $client = new Client(); 
        $ref_abonnement = $this->customer->ref_abonnement;
        $page =$_POST['start']   ; //Tools::getValue('from');
        $size =$_POST['length']  ;//  Tools::getValue('take');
        $order =$_POST['order'][0]["column"]  ;
        $dir =$_POST['order'][0]["dir"];  
        $search= $_POST['search']["value"];
        // dump('eeeee', $_POST);die;
        try {           
            $request = $client->createRequest('POST', LINK_CRM. '/api/getAllFacture', [
                'body' => [
                    'ref_abonnement'=> $ref_abonnement,
                    'page' => $page , 
                    'size' =>$size,
                    'sortBy'=> $order,
                    'sortOrder'=>$dir,
                    'search'=>$search
                ]
            ]);

            $response = $client->send($request);            
            if ($response->getStatusCode() == 200) {
                $res =json_decode( $response->getBody())->data;
                $show =json_decode( $response->getBody())->showFacture;       
                $output = array(
                    'showFacture' =>$show,
                    'draw'=> intval($_POST['draw']),
                    'recordsTotal' => $res->totalElements ,
                    'recordsFiltered'=> $res->totalElements,
                    'data'=> $res->content,
                ); 
                $this->ajaxRender(json_encode($output));
            } else {
                $this->ajaxRender(
                    json_encode([
                        'success' => false,
                        'message' => 'une erreur se produite',
                        'data' => null
                    ])
                );
            }
        } catch (Exception $e) {
            $this->ajaxRender(
                json_encode([
                    'success' => false,
                    'message' => 'error: ' . $e->getMessage(),
                    'data' => null
                ])
            );
        }
        
    }
}