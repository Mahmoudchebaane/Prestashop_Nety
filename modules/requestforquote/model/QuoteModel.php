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

class Quote extends ObjectModel
{
	public $id;
	public $id_requestforquote;
	public $name;
	public $company_name;
	public $contact_number;
	public $email;
	public $module_name;
	public $quote_date;
	public $brief;
	public $budget_state;
	public $id_customer;
	public $date;

	public static $definition = array(
		'table' => 'requestforquote',
		'primary' => 'id_requestforquote',
		'multilang' => false,
		'fields' => array(
			'name' => array('type' => self::TYPE_STRING),
			'company_name' => array('type' => self::TYPE_STRING),
			'contact_number' => array('type' => self::TYPE_STRING),
			'email' => array('type' => self::TYPE_STRING),
			'module_name' => array('type' => self::TYPE_STRING),
			'quote_date' => array('type' => self::TYPE_DATE),
			'brief' => array('type' => self::TYPE_STRING),
			'budget_state' => array('type' => self::TYPE_STRING),
			'id_customer' => array('type' => self::TYPE_INT),
		),
	);

	public static function getDetails($id)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT *
		FROM `'._DB_PREFIX_.'requestforquote`
		WHERE `id_requestforquote` = '.(int)$id);
		return $result;
	}

	public function getThreads($id)
	{
		$result = Db::getInstance()->executeS('
		SELECT *
		FROM `'._DB_PREFIX_.'quote_messages`
		WHERE `id_requestforquote` = '.(int)$id);
		return $result;
	}

	public function saveMessage($id, $message)
	{
		return Db::getInstance()->execute('
		INSERT INTO '._DB_PREFIX_.'quote_messages (`id_requestforquote`, `message`, `author`)
		VALUES('.(int)$id.', "'.pSQL($message).'", 1)
		');
	}
	
	public function saveMessageUser($rfq_id, $message)
	{
		return Db::getInstance()->execute('
		INSERT INTO '._DB_PREFIX_.'quote_messages (`id_requestforquote`, `message`, `author`)
		VALUES('.(int)$rfq_id.', "'.pSQL($message).'", 0)
		');
	}
}