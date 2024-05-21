<?php

use GuzzleHttp\Client;

class AuthController extends AuthControllerCore
{
    /*
     * module: eicaptcha
     * date: 2023-04-27 14:34:09
     * version: 2.4.2
     */
    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
    }
    public function initContent()
    { 
        $this->context->smarty->assign('register_form_errors_email', false);
        $this->context->smarty->assign('register_form_errors', false);
        if (Tools::isSubmit('submitCreate')) {
            $register_form = $this
                ->makeCustomerForm()
                ->setIs_Nety(false)
                ->setGuestAllowed(false)
                ->fillWith(Tools::getAllValues());
            $hookResult = array_reduce(
                Hook::exec('actionSubmitAccountBefore', array(), null, true),
                function ($carry, $item) {
                    return $carry && $item;
                },
                true
            );
            $identif = Tools::getValue('ref_client');
            $num_fixe = Tools::getValue('num_fixe');
            if ($identif && $num_fixe) {
                $ref_abonnement = Tools::getValue('ref_abonnement');
                $client = new Client();
                $customerIDs = array();
                $customers = Customer::getCustomers();
                foreach ($customers as $customer) {
                    $customerIDs[] = $customer['ref_client'];
                }
                if (!in_array($identif, $customerIDs)) {
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
                            $successresponse = json_decode($response->getBody(), 1);
                            if ($successresponse['success']) {
                                if ($identif != $successresponse['data']['identifiant']) {
                                    $register_form->getField('psgdpr_psgdpr')->addError($this->translator->trans('Could you please check your data', [], 'Shop.Theme.Errors'));
                                    $this->context->smarty->assign('register_form_errors', true);
                                } elseif ($num_fixe != $successresponse['data']['num_fixe']) {
                                    $register_form->getField('psgdpr_psgdpr')->addError($this->translator->trans('Could you please check your data', [], 'Shop.Theme.Errors'));
                                    $this->context->smarty->assign('register_form_errors', true);
                                } elseif ($ref_abonnement != $successresponse['data']['ref_aonnement']) {
                                    $register_form->getField('psgdpr_psgdpr')->addError($this->translator->trans('Could you please check your data', [], 'Shop.Theme.Errors'));
                                    $this->context->smarty->assign('register_form_errors', true);
                                } else {

                                    if ($hookResult && $register_form->submit()) {
                                        $this->redirectWithNotifications('index.php?controller=my-account');
                                    } else {
                                        $this->context->smarty->assign('register_form_errors', true);
                                    }
                                }
                            } else {
                                $register_form->getField('psgdpr_psgdpr')->addError($this->translator->trans('Could you please check your data', [], 'Shop.Theme.Errors'));
                                $this->context->smarty->assign('register_form_errors', true);
                            }
                        } else {
                            $register_form->getField('psgdpr_psgdpr')->addError($this->translator->trans('Could you please check your data', [], 'Shop.Theme.Errors'));
                            $this->context->smarty->assign('register_form_errors', true);
                        }
                    } catch (Exception $e) {
                        $register_form->getField('psgdpr_psgdpr')->addError($this->translator->trans('Could you please check your data', [], 'Shop.Theme.Errors'));
                        $this->context->smarty->assign('register_form_errors', true);
                    }
                } else {
                    $register_form->getField('psgdpr_psgdpr')->addError($this->translator->trans('Could you please check your data', [], 'Shop.Theme.Errors'));
                    $this->context->smarty->assign('register_form_errors', true);
                }
            } else {
                if ($hookResult && $register_form->submit()) {
                    $this->redirectWithNotifications('index.php?controller=my-account');
                } else {
                    $this->context->smarty->assign('register_form_errors_email', true);
                    $this->context->smarty->assign('register_form_errors', true);
                }
            }
            FrontController::initContent();
            $this->context->smarty->assign([
                'register_form' => $register_form->getProxy(),
                'hook_create_account_top' => Hook::exec('displayErrorsFormTop'),
            ]);
            $this->setTemplate('customer/registration');
        } else {
            parent::initContent();
            
        }
    }


    public function displayAjaxCheckCode()
    {
        $this->context->customer->id_guest = false;
        $tel = Tools::getValue('numtel');
        $codesms = Tools::getValue('codesms');
        $check = false;
        $message = 1;
        if ($codesms && $tel && $this->context->cookie->__isset('tel') && $this->context->cookie->__isset('code') && $this->context->cookie->__isset('expire')) {
            if ($tel == $this->context->cookie->__get('tel')) {
                if ($codesms == $this->context->cookie->__get('code')) {
                    $expire = (int) ($this->context->cookie->__get('expire'));
                    $curtime = new DateTimeImmutable();
                    $now = (int) $curtime->format('Uv');
                    if (($now - $expire) < 0) {
                        $check = true;
                        $message = 2;
                    } else {$message = 3;}
                } else {$message = 4;}
            }
            $this->ajaxRender(
                json_encode([
                    'success' => $check,
                    'message' => $message,
                    'guest' => $this->context->customer->id_guest
                ])
            );
        }
    }

    public function displayAjaxGetParameters()
    {
        $client = new Client();
        $identif = Tools::getValue('identifiant');
        $num_fixe = Tools::getValue('num_fixe');
        $customerIDs = array();
        $customers = Customer::getCustomers();
        foreach ($customers as $customer) {
            $customerIDs[] = $customer['ref_client'];
        }
        if (!in_array($identif, $customerIDs)) {
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
                    // call api sms 
                    if ($tel) {
                        $this->context->cookie->__set('tel', $tel);
                        $client = new Client();
                        $headers = [
                            'Content-Type' => 'application/json'
                        ];
                        $body = '{
                        "phoneNb": "' . $tel . '",
                        "otpValidity": 1500,
                        "otpToken": "6271608B-9C06-4EDC-9ED9-E245928A11B1",
                        "message": "Code de récuperation de paramètres d\'espace client My nety",
                        "source": "Nety"
                        }';
                        $request = $client->createRequest('POST', 'https://smsingotp.chifco.com/api/Contact/SENDOTP', ['headers' => $headers, 'body' => $body]);
                        $response = $client->send($request);

                        if ($response->getStatusCode() == 200) {
                            $successres = json_decode($response->getBody(), 1);

                            $check = false;
                            if (!array_key_exists('error', $successres)) {
                                //  time();      // 1660338149  1676388556789  timestamp 
                                $this->context->cookie->__set('code', $successres['otpCode']);
                                $this->context->cookie->__set('expire', $successres['expiryDate']);
                                $this->context->cookie->write();
                                $check = true;
                            }
                            $this->ajaxRender(
                                json_encode([
                                    'success' => $check,
                                    'data' => $response->getStatusCode(),
                                    'client' => $successresponse
                                ])
                            );

                        } else {
                            $this->ajaxRender(
                                json_encode([
                                    'success' => false,
                                    'data' => $response->getStatusCode(),
                                ])
                            );
                        }
                    }
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
        } else {
            if ($identif == '') {
                $this->ajaxRender(
                    json_encode([
                        'code' => 'IDENT_MANQ',
                        'success' => false,
                        'message' => 'identifiant requis',
                        'data' => null
                    ])
                );
            } else {
                $this->ajaxRender(
                    json_encode([
                        'code' => 'IDENT_EXISTE',
                        'success' => false,
                        'message' => 'identifiant existe déja',
                        'data' => null
                    ])
                );
            }
        }
    }

}