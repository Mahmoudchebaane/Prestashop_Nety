<?php

use GuzzleHttp\Client;

class MyAccountController extends MyAccountControllerCore
{
    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
    }

    public function initContent()
    {
        parent::initContent();
        $client = new Client();
        $identif = $this->context->customer->ref_client;
        $num_fixe = $this->context->customer->num_fixe;
        $this->context->customer->nameOffre = '';
        $this->context->customer->email = '';
        $this->context->customer->phone = '';
        $this->context->customer->adresse = '';
        $this->context->customer->nameOffre = '';
        $this->context->customer->factureCount = 0;
        try {
            // $linkcrm = 'https://crm.chifco.com';
            // // $linkcrm = 'http://172.16.16.112:8080';
            // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
            //     $linkcrm = 'https://customer.chifco.com';
            // }
            $request = $client->createRequest('POST', LINK_CRM . '/api/getAbonneeCRM', [
                'body' => [
                    'identifiant' => $identif,
                    'num_fixe' => $num_fixe,
                ]
            ]);
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);      
                if ($successresponse['success']) {
                    $this->context->customer->email = ($successresponse['data']['email']);
                    $this->context->customer->phone = ($successresponse['data']['num_mobile']);
                    $this->context->customer->adresse = ($successresponse['data']['adresse']);
                    $this->context->customer->nameOffre = ($successresponse['data']['nameOffre']);
                    $this->context->customer->factureCount = floatval(($successresponse['data']['factureCount']));
                    $this->context->customer->save();
                }
            }
        } catch (Exception $e) {}
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'] = [];
        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $breadcrumb['links'][] = [
            'title' => $this->getTranslator()->trans('Bienvenue dans votre espace client', [], 'Shop.Theme.Customeraccount'),
            'url' => $this->context->link->getPageLink('identity'),
        ];
        // dump($breadcrumb);die;
        return $breadcrumb;
    }
}
