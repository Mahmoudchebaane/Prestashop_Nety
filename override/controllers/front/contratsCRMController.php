<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 
 */
use GuzzleHttp\Client;
use PrestaShop\CircuitBreaker\Client\GuzzleClient;


class contratsCRMController extends FrontController
{
    public $auth = true;
    public $php_self = 'contratsCRM';
    public $authRedirection = 'contratsCRM';
    public $ssl = true;

    protected $customer;

    public function __construct(){
        parent::__construct();
    }
    public function init()
    {
        parent::init();
        // Media::addJsDef([
        //     'language' => $this->context->link->getModuleLink('paiementfacture', 'nouveau')
        // ]);
        $this->customer = $this->context->customer;
    }
    public function postProcess()
    {
        return $this->customer;
    }
    public function initContent()
    {
        parent::initContent();
        $id_customer = $this->customer->id;
        $this->context->smarty->assign(
            array(
                'id_customer' => $id_customer,
            )
        );
        $this->setTemplate('customer/contrats_crm');
    }

    public function setMedia()
    { // Optionnal
        parent::setMedia();
        // $this->addCSS(_MODULE_DIR_.'...PATH...mypage.css');
        // $this->addJS(_MODULE_DIR_.'...PATH...mypage.js');
    }
    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'] = [];
        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $breadcrumb['links'][] = [
            'title' => $this->trans('My contracts', [], 'Shop.Theme.Customeraccount'),
            'url' => $this->context->link->getPageLink('contratsCRM', true),
        ];
        //  dump($breadcrumb);die;
        return $breadcrumb;
    }
    public function displayAjaxlistContrat()
    {
        $ref_abonnement = $this->customer->ref_abonnement;
        $list = array();
        $client = new Client();
        try {
            // $linkcrm = 'https://crm.chifco.com';
            // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
            //     $linkcrm = 'https://customer.chifco.com';
            // }

            $request = $client->createRequest('POST', LINK_CRM . '/api/getInfoContratAbonnee', [
                'body' => [
                    'ref_abonnement' => $ref_abonnement
                ]
            ]);

            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                $res = json_decode($response->getBody())->data;
                foreach ($res as $value) {
                    if ($value->haveContrat) {
                        array_push($list, $value);
                    }
                }
                $result = ["code" => "SUCCESS", "data" => $list, "success" => true, "message" => null];
                $this->ajaxRender(json_encode($result));
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

    public function displayAjaxPdfContrat()
    {
        $client = new Client();
        //$ref_abonnement = $this->customer->ref_abonnement;
        $reference = Tools::getValue('reference');
        try {
            // $linkcrm = 'https://crm.chifco.com';
            // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
            //     $linkcrm = 'https://customer.chifco.com';
            // }
            $request = $client->createRequest('POST', LINK_CRM . '/api/getContratFile', [
                'body' => [
                    'reference' => $reference
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
    public function displayAjaxGetKey()
    {
        $client = new Client();
        $ref_abonnement = $this->customer->ref_abonnement;    
        try {
            // $linkcrm = 'https://crm.chifco.com';
            // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
            //     $linkcrm = 'https://customer.chifco.com';
            // }
            $request = $client->createRequest('POST', LINK_CRM . '/api/getAntiVirusKey', [
                'body' => [
                    'ref_abonnement' => $ref_abonnement
                ]
            ]);
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                $res = json_decode( $response->getBody());                
                $this->ajaxRender($response->getBody());
            } else {
                $this->ajaxRender(json_encode([
                    "success" => true,
                    "code" => "NO_KEYS_AVAILABLE",
                    "message" => "Aucune clé disponible."
                ]));
            }
        } catch (Exception $e) {           
            $this->ajaxRender(json_encode([
                "success" => false,
                "code" => "Unavailable",//PARAMS_MISSING
                "message" => "service unavailable"
            ]));
        }

    }
}