<?php
/**
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AdminQuotesController extends ModuleAdminController {

	public function __construct()
	{
		$this->className = 'Quote';
		$this->table = 'requestforquote';
		$this->identifier = 'id_requestforquote';
		$this->lang = false;
		$this->bootstrap = true;
		$this->context = Context::getContext();
		$success = (int)Tools::getValue('success');
		parent::__construct();
		$this->fields_list = array(
			'id_requestforquote' => array('title' => $this->l('ID'), 'align' => 'center', 'class' => 'fixed-width-xs'),
			'name' => array('title' => $this->l('Name'), 'align' => 'center'),
			'email'  => array('title' => $this->l('email'), 'align' => 'center'),
			'contact_number'  => array('title' => $this->l('Phone'), 'align' => 'center'),
			'company_name'  => array('title' => $this->l('Company'), 'align' => 'center'),
			'module_name' => array('title' => $this->l('Offer'), 'align' => 'center'),
			'date'  => array('title' => $this->l('Date'), 'align' => 'center'),
		);
	}

	public function init()
	{
		parent::init();
		require_once($this->module->getLocalPath().'model/QuoteModel.php');
	}

	public function initToolbar()
	{
		parent::initToolbar();
		unset($this->toolbar_btn['new']);
	}

	public function renderList()
	{
		$this->addRowAction('view');
		$this->addRowAction('delete');
		return parent::renderList();
	}

	public function renderView()
	{
		$class = new Quote;
		$id = (int)Tools::getValue('id_requestforquote');
		$details = $class->getDetails($id);
		$threads = $class->getThreads($id);
		$success = (int)Tools::getValue('success');
		$this->context->smarty->assign(array(
			'action' => self::$currentIndex.'&token='.$this->token.'&viewrequestforquote&id_requestforquote='.$id,
			'quote' => $details,
			'upload_url' => _PS_BASE_URL_.__PS_BASE_URI__.'upload/',
			'success' => $success,
			'threads' => $threads
		));
		parent::renderView();
		return $this->context->smarty->fetch(dirname(__FILE__).'/../../views/templates/admin/requestforquote/helpers/form/view.tpl');
	}

	public function postProcess()
	{
		$class = new Quote;
		$id = (int)Tools::getValue('id_requestforquote');
		$message = Tools::getValue('message');
		if (Tools::isSubmit('submitMessage'))
		{
			if (empty($message))
				$this->errors[] = Tools::displayError($this->l('Not Sent: Please fill message.'));
				else
				{
					$user_data = $class->getDetails($id);
					$class->saveMessage($id, $message);
					$this->sendMailToUser($id, $user_data['email'], $message);
				}
		}
		parent::postProcess();
	}

	private function sendMailToUser($id, $email, $message)
	{
		$id_lang = (int)$this->context->language->id;
		$template = 'notifyusernewmessage';
		$heading = Mail::l('New message received', (int)$id_lang);
		$message_link = $this->context->link->getModuleLink('requestforquote', 'rfq').'?id_requestforquote='.$id;
		$vars = array('{message}' => $message, '{message_link}' => $message_link);
		return Mail::Send(
				(int)$id_lang,
				$template,
				$heading,
				$vars,
				$email,
				null,
				null,
				$this->context->shop->name,
				null,
				null,
				_PS_MODULE_DIR_.'requestforquote/mail/',
				false,
				1
				);
	}
}