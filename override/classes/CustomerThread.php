<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
class CustomerThread extends CustomerThreadCore
{
   public static function getMessageCustomerThreads($id_customer_thread){
        return Db::getInstance()->executeS('
			SELECT ct.*, cm.*, cl.name subject, CONCAT(e.firstname, \' \', e.lastname) employee_name,
				CONCAT(c.firstname, \' \', c.lastname) customer_name, cm.firstname
			FROM ' . _DB_PREFIX_ . 'customer_thread ct
			LEFT JOIN ' . _DB_PREFIX_ . 'customer_message cm
				ON (ct.id_customer_thread = cm.id_customer_thread)
			LEFT JOIN ' . _DB_PREFIX_ . 'contact_lang cl
				ON (cl.id_contact = ct.id_contact AND cl.id_lang = ' . (int) Context::getContext()->language->id . ')
			LEFT JOIN ' . _DB_PREFIX_ . 'employee e
				ON e.id_employee = cm.id_employee
			LEFT JOIN ' . _DB_PREFIX_ . 'customer c
				ON (IFNULL(ct.id_customer, ct.email) = IFNULL(c.id_customer, c.email))
			WHERE ct.id_customer_thread = ' . (int) $id_customer_thread . '
			ORDER BY cm.date_add ASC
		');
    }
    
}
