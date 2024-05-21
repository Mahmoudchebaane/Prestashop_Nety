<?php
/**
 * Request For Quote
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category  front_office_features
 * @package   requestforquote
 * @author    FMM Modules
 * @copyright Copyright 2016 © FMM Modules All right reserved
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_'))
	exit;
include_once(dirname(__FILE__) . '/model/QuoteModel.php');

class RequestForQuote extends Module
{
	public function __construct()
	{
		$this->name = 'requestforquote';
		$this->tab = 'front_office_features';
		$this->version = '2.0.0';
		$this->author = 'FMM Modules';
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Request For Quote');
		$this->description = $this->l('Customers can request a quote using this module.');
		$this->module_key = '';
        $this->templateFile = 'module:requestforquote/views/templates/front/quote-17.tpl';

	}

	public function install()
	{
		return (parent::install()
			&& $this->registerHook('header')
			&& $this->registerHook('displayCustomerAccount')
			&& $this->registerHook('ModuleRoutes')
			&& $this->installDb()
			&& $this->installTab());
	}

	public function installDb()
	{
		$return = true;
		$return = Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'requestforquote` (
					`id_requestforquote` int(10) NOT NULL auto_increment,
					`name` varchar(255) NOT NULL,
					`company_name` varchar(255) NOT NULL,
					`contact_number` varchar(255) NOT NULL,
					`email` varchar(255) NOT NULL,
					`module_name` varchar(255) NOT NULL,
					`quote_date` datetime default NULL,
					`brief` text,
					`budget_state` varchar(255) NOT NULL,
					`attchment` varchar(255) NOT NULL,
					`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					`id_customer` int(10) NOT NULL,
					PRIMARY KEY (`id_requestforquote`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');
		$return &= Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'quote_messages` (
					`id_quote_messages` int(10) NOT NULL auto_increment,
					`id_requestforquote` int(10) NOT NULL,
					`message` text,
					`author` int(10) NOT NULL,
					`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (`id_quote_messages`, `id_requestforquote`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');
		return $return;
	}

	private function installTab()
	{
		$tab = new Tab();
		$tab->active = 1;
		$tab->class_name = 'AdminQuotes';
		$tab->name = array();
		foreach (Language::getLanguages(true) as $lang)
			$tab->name[$lang['id_lang']] = $this->l('Quotes By Users');
		$tab->id_parent = (int) Tab::getIdFromClassName('DEFAULT');
		$tab->module = $this->name;
		return $tab->add();
	}

	public function uninstall()
	{
		return ($this->uninstallDB() && parent::uninstall() && $this->uninstallTab());
	}

	public function uninstallTab()
	{
		$id_tab = (int) Tab::getIdFromClassName('AdminQuotes');
		if ($id_tab) {
			$tab = new Tab($id_tab);
			return $tab->delete();
		} else
			return false;
	}

	public function uninstallDB()
	{
		return (Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'requestforquote`') && Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'quote_messages`'));
	}

	public function postProcess()
	{
		if (Tools::isSubmit('submitPquote')) {
			Configuration::updateValue('RFQ_SENDMAIL_ADMIN', Tools::getValue('RFQ_SENDMAIL_ADMIN'));
			Configuration::updateValue('RFQ_ADMIN_EMAIL', Tools::getValue('RFQ_ADMIN_EMAIL'));
			Configuration::updateValue('RFQ_CAPTCHA', Tools::getValue('RFQ_CAPTCHA'));
			Configuration::updateValue('RFQ_CAPTCHA_KEY', Tools::getValue('RFQ_CAPTCHA_KEY'));
			return $this->displayConfirmation($this->l('The settings have been updated.'));
		}
		return '';
	}

	public function getContent()
	{
		return $this->postProcess() . $this->renderForm();
	}

	public function renderForm()
	{
		if (_PS_VERSION_ >= '1.6.0' || _PS_VERSION_ >= '1.6.0.0') {
			$status_admin = array(
				'type' => 'switch',
				'label' => $this->l('Notify Admin by Email?'),
				'name' => 'RFQ_SENDMAIL_ADMIN',
				'required' => false,
				'class' => 't',
				'is_bool' => true,
				'values' => array(
						array(
							'id' => 'rsa_on',
							'value' => 1,
							'label' => $this->l('Yes')
						),
						array(
							'id' => 'rsa_off',
							'value' => 0,
							'label' => $this->l('No')
						)
					),
				'hint' => $this->l('Send email to admin each time user quotes/replies.')
			);
			$status_admin_2 = array(
				'type' => 'switch',
				'label' => $this->l('Enable Captcha?'),
				'name' => 'RFQ_CAPTCHA',
				'required' => false,
				'class' => 't',
				'is_bool' => true,
				'values' => array(
						array(
							'id' => 'rc_on',
							'value' => 1,
							'label' => $this->l('Yes')
						),
						array(
							'id' => 'rc_off',
							'value' => 0,
							'label' => $this->l('No')
						)
					),
				'hint' => $this->l('Send email to admin each time user quotes/replies.')
			);
		} else {
			$status_admin = array(
				'type' => 'radio',
				'label' => $this->l('Notify Admin by Email?'),
				'name' => 'RFQ_SENDMAIL_ADMIN',
				'required' => false,
				'class' => 't',
				'is_bool' => true,
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
					),
			);
			$status_admin_2 = array(
				'type' => 'radio',
				'label' => $this->l('Enable Captcha?'),
				'name' => 'RFQ_CAPTCHA',
				'required' => false,
				'class' => 't',
				'is_bool' => true,
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
					),
			);
		}
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					$status_admin,
					array(
						'type' => 'text',
						'lang' => false,
						'label' => $this->l('Administrator Email:'),
						'name' => 'RFQ_ADMIN_EMAIL',
						'desc' => $this->l('Leave empty for default email / Multiple emails should be ')
					),
					$status_admin_2,
					array(
						'type' => 'text',
						'lang' => false,
						'label' => $this->l('Google ReCaptcha Key:'),
						'name' => 'RFQ_CAPTCHA_KEY',
						'desc' => $this->l('You can generate one by Google recaptcha website.')
					),
				),
				'submit' => array(
					'title' => $this->l('Save')
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->module = $this;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitPquote';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'uri' => $this->getPathUri(),
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		$fields = array();
		$fields['RFQ_SENDMAIL_ADMIN'] = (int) Configuration::get('RFQ_SENDMAIL_ADMIN');
		$fields['RFQ_ADMIN_EMAIL'] = Configuration::get('RFQ_ADMIN_EMAIL');
		$fields['RFQ_CAPTCHA'] = Configuration::get('RFQ_CAPTCHA');
		$fields['RFQ_CAPTCHA_KEY'] = Configuration::get('RFQ_CAPTCHA_KEY');
		return $fields;
	}

	public function hookHeader()
	{
		return ($this->context->controller->addCSS($this->_path . 'views/css/quote.css')
			|| $this->context->controller->addJS($this->_path . 'views/js/quote.js'));
	}


	public function hookModuleRoutes()
	{
		return array(
			'module-requestforquote-rfq' => array(
				'controller' => 'rfq',
				'rule' => 'rfq',
				'keywords' => array(),
				'params' => array(
						'fc' => 'module',
						'module' => 'requestforquote',
					),
			),
		);
	}

	public function hookDisplayCustomerAccount()
	{
		return $this->display(__FILE__, 'account.tpl');
	}
	public function renderWidget($hookName = null, array $configuration = [])
	{		
		$rfq_id = (int) Tools::getValue('id_requestforquote');
		$form_action = $this->context->link->getModuleLink('requestforquote', 'rfq');
		$success = (int)Tools::getValue('success');
		$error = (int)Tools::getValue('error');
		$captcha = (int) Configuration::get('RFQ_CAPTCHA');
	 	$currentUrl = Tools::getCurrentUrlProtocolPrefix() . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . htmlspecialchars($_SERVER['REQUEST_URI'], ENT_COMPAT, 'UTF-8');
		// $form_action = $currentUrl;	
		

		$this->context->smarty->assign(
			array(
				'path_uri' => $this->_path,
				'currentUrl'=>$currentUrl ,
				'form_action' => $form_action.'?success=1',
				'success' => $success,
				'error'=>$error,
				'captcha' => $captcha,
				'captcha_key' => Configuration::get('RFQ_CAPTCHA_KEY'),
			)
		);
		$this->context->smarty->assign('base_dir_ssl', _PS_BASE_URL_SSL_ . __PS_BASE_URI__);

		return $this->fetch('module:requestforquote/views/templates/front/quote-17.tpl');
	}
	
}