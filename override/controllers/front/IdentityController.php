<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 
 */
use GuzzleHttp\Client;

class IdentityController extends IdentityControllerCore
{
    public $auth = true;
    public $php_self = 'identity';
    public $authRedirection = 'identity';
    public $ssl = true;
    public $passwordRequired = false;
    private $ask_for_partner_optin = false;
    private $partner_optin_is_required = false;

    public function init(){
        parent::init();
    }

    public function initContent()
    {
        $customers = Customer::getCustomers();
        foreach ($customers as $customer) {
            $customerEmails[] = $customer['email'];
        }       
        $email = $this->context->customer->email;
        $should_redirect = false;
        $customer_form = $this->makeCustomerForm()->setPasswordRequired($this->passwordRequired);
        $customer = new Customer();
        $customer_form->getFormatter()
            ->setAskForNewPassword(true)
            ->setAskForPassword(true)
            ->setPasswordRequired($this->passwordRequired)
            ->setPartnerOptinRequired($customer->isFieldRequired('optin'));
        if (Tools::isSubmit('submitCreate')) {
            $customer_form->fillWith(Tools::getAllValues());
            if ($customer_form->submit()) {
                if (in_array($this->context->customer->email, $customerEmails) && ($email !=$this->context->customer->email)  ) {
                    $this->errors[] = $this->trans('Email already used', [], 'Shop.Notifications.Error');
                } else {
                    try {
                        $client = new Client();
                        // $linkcrm = 'https://crm.chifco.com';
                        // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
                        //     $linkcrm = 'https://customer.chifco.com';
                        // }
                        $request = $client->createRequest('POST', LINK_CRM . '/api/updateAccount', [
                            'body' => [
                                'ref_abonnement' => $this->context->customer->ref_abonnement,
                                'numTel' => $this->context->customer->phone,
                                'email' => $this->context->customer->email,
                            ]
                        ]);

                        $response = $client->send($request);
                        if ($response->getStatusCode() == 200) {
                            $successresponse = json_decode($response->getBody(), 1);
                        }

                    } catch (Exception $e) {
                    }

                    $this->success[] = $this->trans('Information successfully updated.', [], 'Shop.Notifications.Success');
                    $should_redirect = true;
                }
            } else {
                $this->errors[] = $this->trans('Could not update your information, please check your data.', [], 'Shop.Notifications.Error');
            }

        } else {
            $customer_form->fillFromCustomer(
                $this->context->customer
            );
        }
        $this->context->smarty->assign([
            'customer_form' => $customer_form->getProxy(),
        ]);
        if ($should_redirect) {
            $this->redirectWithNotifications($this->getCurrentURL());
        }
        FrontController::initContent();
        $this->setTemplate('customer/identity');
    }


    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'] = [];
        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $breadcrumb['links'][] = [
            'title' => $this->trans('My informations', [], 'Shop.Theme.Customeraccount'),
            'url' => $this->context->link->getPageLink('identity'),
        ];

        return $breadcrumb;
    }

    public function displayAjaxGetUpdateCRM()
    {
        $client = new Client();
        $identif = $this->context->customer->ref_client;
        $num_fixe = $this->context->customer->num_fixe;
        $customer_form = $this->makeCustomerForm()->setPasswordRequired($this->passwordRequired);
        try {
            // $linkcrm = 'https://crm.chifco.com';
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
                $res = json_decode($response->getBody())->data;
                $tel = $res->num_mobile;
                $successresponse = json_decode($response->getBody(), 1);
                if ($successresponse['success']) {
                    $this->context->customer->email = ($successresponse['data']['email']);
                    $this->context->customer->phone = ($successresponse['data']['num_mobile']);
                    $this->context->customer->firstname = ($successresponse['data']['prenom']);
                    $this->context->customer->lastname = ($successresponse['data']['nom']);
                    $this->context->customer->save();
                }
                $this->ajaxRender(
                    json_encode([
                        'success' => true,
                        'message' => '',
                        'data' => $successresponse
                    ])
                );
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