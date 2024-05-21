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

class RequestForQuoteRfqModuleFrontController extends ModuleFrontController
{

	public function __construct()
	{
		parent::__construct();
		$this->context = Context::getContext();

	}

	public function init()
	{
		parent::init();
		require_once($this->module->getLocalPath() . 'model/QuoteModel.php');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$rfq_id = (int) Tools::getValue('id_requestforquote');
			if ($rfq_id <= 0) {
				$extension = array('doc', 'docx', 'pdf', 'jpeg', 'jpg');
				$file_attachment = Tools::fileAttachment('attchment');
				$class = new Quote;
				$class->name = Tools::getValue('name');
				$class->company_name = Tools::getValue('company_name');
				$class->contact_number = Tools::getValue('contact_number');
				$class->email = Tools::getValue('email');
				$class->module_name = Tools::getValue('module_name');
				$class->quote_date = Tools::getValue('quote_date');
				$class->brief = Tools::getValue('brief');
				$class->budget_state = Tools::getValue('offer');
				$class->id_customer = (int) $this->context->customer->id;
				$class->add();
				$id = $class->id;
				//$ext = pathinfo($file_attachment['name'], PATHINFO_EXTENSION);
				if (!empty($file_attachment['name']) && in_array($ext, $extension)) {
					if (!is_dir(_PS_UPLOAD_DIR_ . 'rfq'))
						@mkdir(_PS_UPLOAD_DIR_ . 'rfq', 0777, true);
					@mkdir(_PS_UPLOAD_DIR_ . 'rfq/' . $id, 0777, true);
					$path = _PS_UPLOAD_DIR_ . 'rfq/' . $id . '/';
					$absolute_path = $path . $file_attachment['name'];
					move_uploaded_file($file_attachment['tmp_name'], $absolute_path);
					$imgPath = 'rfq/' . $id . '/' . $file_attachment['name'];

					Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'requestforquote`
					SET `attchment` = "' . pSQL($imgPath) . '"
					WHERE `id_requestforquote` = ' . (int) $id);
				}
				

				$send_mail_admin = (int) Configuration::get('RFQ_SENDMAIL_ADMIN');
				if ($send_mail_admin > 0) {
					
					if ($class->brief == ''){
						// $this->sendMailToAdmin($id, $class->email, $class->name, $class->module_name, $class->contact_number, $class->company_name);
						$this->sendMailToAdminWithMessage($id, $class->email, $class->name, $class->module_name, $class->contact_number, $class->company_name, '');

					}else{
						$this->sendMailToAdminWithMessage($id, $class->email, $class->name, $class->module_name, $class->contact_number, $class->company_name, $class->brief);
					}					

					$this->success[] = $this->trans('Quote submitted successfully',[], 'Shop.Theme.Global');
					$this->redirectWithNotifications($_SERVER['HTTP_REFERER']);
				}
			} elseif ($rfq_id > 0) {
			
				$class = new Quote;
				$message = Tools::getValue('message');
				$class->saveMessageUser($rfq_id, $message);
				$send_mail_admin = (int) Configuration::get('RFQ_SENDMAIL_ADMIN');
				if ($send_mail_admin > 0) {
					// $this->sendMailToAdminNewMessage($rfq_id, $message);
					$this->sendMailToAdminWithMessage($id, $class->email, $class->name, $class->module_name, $class->contact_number, $class->company_name, $class->brief);
					$this->success[] = $this->trans('Quote submitted successfully',[], 'Shop.Theme.Global');
					$this->redirectWithNotifications($_SERVER['HTTP_REFERER']);
				}
			}
		}
	}

	public function initContent()
	{
		parent::initContent();

		$this->ajax = true;
		$rfq_id = (int) Tools::getValue('id_requestforquote');
		$form_action = $this->context->link->getModuleLink('requestforquote', 'rfq');
		$success = (int) Tools::getValue('success');
		$error = (int) Tools::getValue('error');
		$captcha = (int) Configuration::get('RFQ_CAPTCHA');
		$currentUrl = Tools::getCurrentUrlProtocolPrefix() . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . htmlspecialchars($_SERVER['REQUEST_URI'], ENT_COMPAT, 'UTF-8');

		$this->context->smarty->assign(
			array(
				'currentUrl' => $currentUrl,
				'path_uri' => $this->module->getPathUri(),
				'form_action' => $form_action . '?success=1',
				'success' => $success,
				'error' => $error,
				'captcha' => $captcha,
				'captcha_key' => Configuration::get('RFQ_CAPTCHA_KEY'),
			)
		);

		if ($rfq_id > 0) {
			$form_action = $this->context->link->getModuleLink('requestforquote', 'rfq') . '?success=1&id_requestforquote=' . $rfq_id;
			$this->context->smarty->assign(
				array(
					'form_action' => $form_action,
				)
			);
			if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=') == true) {
				$this->context->smarty->assign('base_dir_ssl', _PS_BASE_URL_SSL_ . __PS_BASE_URI__);
				$this->setTemplate('module:requestforquote/views/templates/front/message-17.tpl');
			} else
				$this->setTemplate('message.tpl');
		} else {
			if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=') == true) {
				$this->context->smarty->assign('base_dir_ssl', _PS_BASE_URL_SSL_ . __PS_BASE_URI__);
				$this->setTemplate('module:requestforquote/views/templates/front/quote-17.tpl');
			} else
				$this->setTemplate('quote.tpl');
		}
	}

	public function setMedia()
	{
		parent::setMedia();
		$this->addJqueryUI('ui.datepicker');

	}



	private function sendMailToAdmin($id, $email, $name, $offre, $phone, $company)
	{
		$employee = new Employee(1);
		$admin_email = Configuration::get('RFQ_ADMIN_EMAIL');
		$admin_email = (empty($admin_email)) ? $employee->email : $admin_email;
		$bccRecipientsString = Configuration::get('RFQ_ADMIN_EMAIL');
		$bccRecipientsArray = explode(';', $bccRecipientsString);
		$id_lang = (int) $this->context->language->id;
		$template = 'notifyadmin';
		$heading = Mail::l('Request for quote', (int) $id_lang);
		$vars = array('{id}' => $id, '{email}' => $email, '{name}' => $name, '{module_name}' => $offre, '{contact_number}' => $phone, '{company_name}' => $company);
		
		foreach ($bccRecipientsArray as $bccRecipient) {
			Mail::Send(
				(int) $id_lang,
				$template,
				$this->trans('Request for Quote', [], 'Shop.Theme.Global'),
				$vars,
				trim($bccRecipient),
				null,
				null,
				$this->context->shop->name,
				null,
				null,
				_PS_MODULE_DIR_ . 'requestforquote/mails/',
				false,
				1
			);
		}
	}
	private function sendMailToAdminWithMessage($id, $email, $name, $offre, $phone, $company, $message)
	{
		$employee = new Employee(1);
		$admin_email = Configuration::get('RFQ_ADMIN_EMAIL');
		$admin_email = (empty($admin_email)) ? $employee->email : $admin_email;
		$bccRecipientsString = Configuration::get('RFQ_ADMIN_EMAIL');
		$bccRecipientsArray = explode(';', $bccRecipientsString);
		$id_lang = (int) $this->context->language->id;
		$template = 'notifyadminwithMsg';
		$heading = Mail::l('Request for quote', (int) $id_lang);
		$vars = array('{id}' => $id, '{email}' => $email, '{name}' => $name, '{module_name}' => $offre, '{contact_number}' => $phone, '{company_name}' => $company, '{message}'=>$message);
		foreach ($bccRecipientsArray as $bccRecipient) {
			Mail::Send(
				(int) $id_lang,
				$template,
				// $heading,
				$this->trans('Request for Quote', [], 'Shop.Theme.Global'),
				$vars,
				trim($bccRecipient),
				null,
				null,
				$this->context->shop->name,
				null,
				null,
				_PS_MODULE_DIR_ . 'requestforquote/mails/',
				false,
				1
			);
		}
	}

	private function sendMailToAdminNewMessage($id, $message)
	{
		$employee = new Employee(1);
		$admin_email = Configuration::get('RFQ_ADMIN_EMAIL');
		$admin_email = (empty($admin_email)) ? $employee->email : $admin_email;
		$bccRecipientsString = Configuration::get('RFQ_ADMIN_EMAIL');
		$bccRecipientsArray = explode(';', $bccRecipientsString);
		$id_lang = (int) $this->context->language->id;
		$template = 'notifyadminmessage';
		$heading = Mail::l('Message from User', (int) $id_lang);
		$vars = array('{id}' => $id, '{message}' => $message);
		foreach ($bccRecipientsArray as $bccRecipient) {
			Mail::Send(
				(int) $id_lang,
				$template,
				$heading,
				$vars,
				$bccRecipient,
				null,
				null,
				$this->context->shop->name,
				null,
				null,
				_PS_MODULE_DIR_ . 'requestforquote/mails/',
				false,
				1,

			);
		}
	}


}
