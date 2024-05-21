<?php
/******************
 * Vinova Login Social for Prestashop 1.7.x 
 * @package     novloginsocial
 * @version     1.0.0
 * @author      Vinovathemes
 * @copyright   Copyright (C) October 2017 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/

include _PS_MODULE_DIR_ . '/novloginsocial/vendor/autoload.php';

use PrestaShop\PrestaShop\Adapter\ServiceLocator;
use PrestaShop\PrestaShop\Adapter\CoreException;
use Hybridauth\Hybridauth;

class NovLoginSocialAuthenticateModuleFrontController extends ModuleFrontController
{
    public $page;

    public function initContent()
    {
        parent::initContent();

        $provider = Tools::getValue('provider');
        $page = Tools::getValue('page');
        $callbackUrl = $this->context->link->getModuleLink('novloginsocial', 'authenticate', array('provider' => $provider, 'page' => $page),  true);
        $noError = true;
        $popup = Configuration::get($this->module->configName . 'type_social');

        $facebookKey = Configuration::get($this->module->configName . 'facebook_key');
        $facebookSecret = Configuration::get($this->module->configName . 'facebook_secret');
	
        $twitterKey = Configuration::get($this->module->configName . 'twitter_key');
        $twitterSecret = Configuration::get($this->module->configName . 'twitter_secret');
	
        $googleKey = Configuration::get($this->module->configName . 'google_key');
        $googleSecret = Configuration::get($this->module->configName . 'google_secret');

        $config = [
            'callback' => $callbackUrl,

            'providers' => [
                'Facebook' => [
                    'enabled' => true,
                    'keys'    => [ 'id' => $facebookKey, 'secret' => $facebookSecret],
                    'scope'    => 'email'
                ],
                'Twitter' => [
                    'enabled' => true,
                    'keys'    => [ 'key' => $twitterKey, 'secret' => $twitterSecret ],
                    'authorize' => true
                ],
                'Google' => [
                    'enabled' => true,
                    'keys'    => [ 'id' => $googleKey, 'secret' => $googleSecret ],
                ],
                
            ],
        ];

        try {
            $hybridauth = new Hybridauth( $config );
            switch ($provider) {
                case 'facebook':
                    $adapter = $hybridauth->authenticate( 'Facebook' );
                    break;
                case 'google':
                    $adapter = $hybridauth->authenticate( 'Google' );
                    break;
                case 'twitter':
                    $adapter = $hybridauth->authenticate( 'Twitter' );
                    break;
            }

            $userProfile = $adapter->getUserProfile();

            if (Customer::customerExists($userProfile->email)) {
                $noError = $this->authenticateCustomer($userProfile->email);
            } else{
                $firstName = $userProfile->firstName;
                $lastName = $userProfile->lastName;
                switch ($provider) {
                    case 'twitter':
                        if ($lastName  == ''){
                            $lastName = $userProfile->firstName;
                        }
                        break;
                }

                $noError = $this->createCustomer($userProfile->email, $firstName, $lastName);
                $noError = $this->authenticateCustomer($userProfile->email);
            }

            $adapter->disconnect();

            if (!$popup){
                if ($noError){
                    if ($page == 'checkout'){
                        Tools::redirect($this->context->link->getPageLink('order'));
                    } else{
                        Tools::redirect($this->context->link->getPageLink('my-account'));
                    }
                }
            }

            $this->context->smarty->assign(array(
                'popup' => $popup,
            ));
        }
        catch (\Exception $e) {
            $this->context->smarty->assign(array(
                'message' => $e->getMessage(),
            ));
        }

        $template_name  = 'module:novloginsocial/views/templates/front/notification.tpl';
        $this->setTemplate($template_name);
    }


    public function createCustomer($email, $firstName, $lastName) {

        $customer = new Customer();
        $customer->active = 1;
        $customer->firstname = $firstName;
        $customer->lastname = $lastName;
        $customer->email = $email;
        $customer->newsletter = 1;
        $customer->optin = true;

        $original_passd = Tools::passwdGen(8, 'RANDOM');
        $crypto = ServiceLocator::get('\\PrestaShop\\PrestaShop\\Core\\Crypto\\Hashing');
        $customer->passwd = $crypto->hash($original_passd);

        if ($customer->add()){
            $this->sendConfirmationMail($customer, $original_passd);
            return true;
        } else{
            return false;
        }

    }

    public function sendConfirmationMail($customer, $passd)
    {
        Mail::Send(
            $this->context->language->id, 'account', Mail::l('Welcome!'), array(
            '{firstname}' => $customer->firstname,
            '{lastname}' => $customer->lastname,
            '{email}' => $customer->email,
            '{passwd}' => $passd), $customer->email,
            $customer->firstname.' '.$customer->lastname,
            null, null, null, null, dirname(__FILE__).'/mails/'
        );
    }

    public function authenticateCustomer($email) {

        Hook::exec('actionAuthenticationBefore');

        $customer = new Customer();
        $authentication = $customer->getByEmail($email);

        if (!$authentication){
            return false;
        }

        if (!$customer->active){
           return false;
        }

        $this->context->updateCustomer($customer);

        Hook::exec('actionAuthentication', ['customer' => $this->context->customer]);
        CartRule::autoRemoveFromCart($this->context);
        CartRule::autoAddToCart($this->context);

        return true;
    }
}
