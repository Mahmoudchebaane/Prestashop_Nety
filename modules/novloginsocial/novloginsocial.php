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

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;

class NovLoginSocial extends Module implements WidgetInterface
{
    protected $templateFile;
    public $defaults;
    public $configName;

    public function __construct()
    {
        $this->name = 'novloginsocial';
        $this->version = '1.0.0';
        $this->author = 'Vinovathemes';
        $this->controllers = array('authenticate');
        $this->bootstrap = true;

        $this->configName = 'novsocial_';
        $this->defaults = array(
            'type_social' => 1,

            'facebook_status' => 0,
            'facebook_key' => '',
            'facebook_secret' => '',

            'twitter_status' => 0,
            'twitter_key' => '',
            'twitter_secret' => '',

            'google_status' => 0,
            'google_key' => '',
            'google_secret' => '',
        );

        parent::__construct();

        $this->displayName = $this->l('Vinova Login Social');
        $this->description = $this->l('Allow customers login to with Facebook, Google social account');

        $this->templateFile = 'module:' . $this->name . '/views/templates/hook/';
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

    }

    public function install()
    {
        if (parent::install() && $this->registerHook('displayPopupLogin') && $this->registerHook('displayLoginSocialAnywhere') && $this->registerHook('displayRegistrationBeforeForm') && $this->registerHook('displayCheckoutLoginFormAfter')) {
            foreach ($this->defaults as $default => $value) {
                Configuration::updateValue($this->configName . $default, $value);
            }
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->configName . $default);
        }
        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submitNovloginsocial')) {
            foreach ($this->defaults as $default => $value) {
                    Configuration::updateValue($this->configName . $default, Tools::getValue($default));
            }

            if (Tools::getValue('facebook_status')) {
                if (Tools::getValue('facebook_key') == '' || Tools::getValue('facebook_secret') == '') {
                    Configuration::updateValue($this->configName . 'facebook_status', 0);
                    $output .= $this->displayError($this->l('To enable Facebook login you need to fill API key an secret'));
                }
            }

            if (Tools::getValue('twitter_status')) {
                if (Tools::getValue('twitter_key') == '' || Tools::getValue('twitter_secret') == '') {
                    Configuration::updateValue($this->configName . 'twitter_status', 0);
                    $output .= $this->displayError($this->l('To enable Twitter login you need to fill API key an secret'));
                }
            }

            if (Tools::getValue('google_status')) {
                if (Tools::getValue('google_key') == '' || Tools::getValue('google_secret') == '') {
                    Configuration::updateValue($this->configName . 'google_status', 0);
                    $output .= $this->displayError($this->l('To enable Google login you need to fill API key an secret'));
                }
            }

            $output .= $this->displayConfirmation($this->l('Configuration updated'));
        }
        return $output.$this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings Login Socials'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Popup'),
                        'name' => 'type_social',
                        'class' => 'fixed-width-xs',
                        'desc' => $this->l('Select a type Popup login when customers click button login social'),
                        'default' => 1,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                                ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'line',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Facebook login'),
                        'name' => 'facebook_status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook API ID'),
                        'name' => 'facebook_key',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook API secret'),
                        'name' => 'facebook_secret',
                    ),
                    array(
                        'type' => 'line',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Twitter login'),
                        'name' => 'twitter_status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Twitter API key'),
                        'name' => 'twitter_key',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Twitter API secret'),
                        'name' => 'twitter_secret',
                    ),
                    array(
                        'type' => 'line',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Google login'),
                        'name' => 'google_status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google API client ID'),
                        'name' => 'google_key',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google API secret'),
                        'name' => 'google_secret',
                    )
                ),
                'submit' => array(
                    'name' => 'submitNovloginsocial',
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules',
                false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues(){
        $var_field = array();
        foreach ($this->defaults as $default => $value) {
                $var_field[$default] = Configuration::get($this->configName . $default);
        }
        return $var_field;
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayCustomerLoginFormAfter\d*$/', $hookName)) {
            $templateFile = 'authentication.tpl';
        } elseif (preg_match('/^displayCheckoutLoginFormAfter\d*$/', $hookName)){
            $templateFile = 'checkout.tpl';
        } elseif (preg_match('/^displayRegistrationBeforeForm\d*$/', $hookName)){
            $templateFile = 'checkout.tpl';
        } else {
            $templateFile = 'authentication.tpl';
        }

        //echo"<pre>".print_r($configuration);die();
        if (!$this->isCached($this->templateFile . $templateFile, $this->getCacheId())) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        return $this->fetch($this->templateFile . $templateFile, $this->getCacheId());
    }

    protected function getCurrentURL()
    {
        return Tools::getCurrentUrlProtocolPrefix() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public function getTemplateVarUrls()
    {
        $http = Tools::getCurrentUrlProtocolPrefix();
        $base_url = $this->context->shop->getBaseURL(true, true);

        if (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) {
            $ssl = true;
        } else {
            $ssl = false;
        }

        $urls = array(
            'base_url' => $base_url,
            'current_url' => $this->context->shop->getBaseURL(true, false) . $_SERVER['REQUEST_URI'],
            'shop_domain_url' => $this->context->shop->getBaseURL(true, false),
        );

        $assign_array = array(
            'img_ps_url' => _PS_IMG_,
            'img_cat_url' => _THEME_CAT_DIR_,
            'img_lang_url' => _THEME_LANG_DIR_,
            'img_prod_url' => _THEME_PROD_DIR_,
            'img_manu_url' => _THEME_MANU_DIR_,
            'img_sup_url' => _THEME_SUP_DIR_,
            'img_ship_url' => _THEME_SHIP_DIR_,
            'img_store_url' => _THEME_STORE_DIR_,
            'img_col_url' => _THEME_COL_DIR_,
            'img_url' => _THEME_IMG_DIR_,
            'css_url' => _THEME_CSS_DIR_,
            'js_url' => _THEME_JS_DIR_,
            'pic_url' => _THEME_PROD_PIC_DIR_,
        );

        foreach ($assign_array as $assign_key => $assign_value) {
            if (substr($assign_value, 0, 1) == '/' || $ssl) {
                $urls[$assign_key] = $http . Tools::getMediaServer($assign_value) . $assign_value;
            } else {
                $urls[$assign_key] = $assign_value;
            }
        }

        $pages = array();
        $p = array(
            'address', 'addresses', 'authentication', 'cart', 'category', 'cms', 'contact',
            'discount', 'guest-tracking', 'history', 'identity', 'index', 'my-account',
            'order-confirmation', 'order-detail', 'order-follow', 'order', 'order-return',
            'order-slip', 'pagenotfound', 'password', 'pdf-invoice', 'pdf-order-return', 'pdf-order-slip',
            'prices-drop', 'product', 'search', 'sitemap', 'stores', 'supplier',
        );
        foreach ($p as $page_name) {
            $index = str_replace('-', '_', $page_name);
            $pages[$index] = $this->context->link->getPageLink($page_name, $ssl);
        }
        $pages['register'] = $this->context->link->getPageLink('authentication', true, null, array('create_account' => '1'));
        $pages['order_login'] = $this->context->link->getPageLink('order', true, null, array('login' => '1'));
        $urls['pages'] = $pages;

        $urls['alternative_langs'] = $this->getAlternativeLangsUrl();

        $urls['theme_assets'] = __PS_BASE_URI__ . 'themes/' . $this->context->shop->theme->getName() . '/assets/';

        $urls['actions'] = array(
            'logout' => $this->context->link->getPageLink('index', true, null, 'mylogout'),
        );

        $imageRetriever = new ImageRetriever($this->context->link);
        $urls['no_picture_image'] = $imageRetriever->getNoPictureImage($this->context->language);

        return $urls;
    }

    protected function getAlternativeLangsUrl()
    {
        $alternativeLangs = array();
        $languages = Language::getLanguages(true, $this->context->shop->id);

        if ($languages < 2) {
            // No need to display alternative lang if there is only one enabled
            return $alternativeLangs;
        }

        foreach ($languages as $lang) {
            $alternativeLangs[$lang['language_code']] = $this->context->link->getLanguageLink($lang['id_lang']);
        }

        return $alternativeLangs;
    }

    protected function makeLoginForm()
    {
        $form = new CustomerLoginForm(
            $this->context->smarty,
            $this->context,
            $this->getTranslator(),
            new CustomerLoginFormatter($this->getTranslator()),
            $this->getTemplateVarUrls()
        );

        $form->setAction($this->context->link->getPageLink('authentication', true).'?back='.$this->getCurrentURL());

        return $form;
    }

    function hookdisplayPopupLogin($params)
    {
        if (!$this->isCached('module:novloginsocial/views/templates/hook/popuplogin.tpl', $this->getCacheId('popuplogin')))
        {
            if (isset($this->context->controller->php_self) && $this->context->controller->php_self == 'authentication') {
                return;
            } else {
                /*$fontcontroller = new FrontController();
                $register_form = $fontcontroller
                    ->makeCustomerForm()
                    ->setGuestAllowed(false)
                    ->fillWith(Tools::getAllValues())
                ;*/
                $login_form = $this->makeLoginForm()->fillWith(
                    Tools::getAllValues()
                );
                $this->context->smarty->assign(
                    array(

                        'login_form_popup' => $login_form->getProxy(),
                    )
                );

            }
        }
        return $this->display(__FILE__, 'views/templates/hook/popuplogin.tpl', $this->getCacheId('popuplogin'));
    }
    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        $page = 'authentication';

        if (preg_match('/^displayCustomerLoginFormAfter\d*$/', $hookName)) {
            $page = 'authentication';
        } elseif (preg_match('/^displayCheckoutLoginFormAfter\d*$/', $hookName)){
            $page = 'checkout';
        } elseif (preg_match('/^displayRegistrationBeforeForm\d*$/', $hookName)){
            $page = 'authentication';
        } else {
            $page = 'authentication';
        }

        return array(
            'page' => $page,
            'type_social' => Configuration::get($this->configName . 'type_social'),
            'facebook_status' => Configuration::get($this->configName . 'facebook_status'),
            'twitter_status' => Configuration::get($this->configName . 'twitter_status'),
            'google_status' => Configuration::get($this->configName . 'google_status')
        );
    }
}
