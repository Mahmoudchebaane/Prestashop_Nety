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

 */
class AdminCustomerThreadsController extends AdminCustomerThreadsControllerCore{
  
    public function __construct(){
        
  parent::__construct(); 
        $this->fields_list = array_merge($this->fields_list,array( 'firstname' => [
                'title' => $this->trans('Firstname', [], 'Admin.Global'),
                'filter_key' => 'firstname', 
                'tmpTableFilter' => true,
        ]));
       
    }

    public function renderList(){
       
        $this->addRowAction('view');
        $this->addRowAction('delete');
        $this->_select ='
			CONCAT(c.`firstname`," ",c.`lastname`) as customer, cl.`name` as contact, l.`name` as language, group_concat(cm.`message`) as messages, cm.private,cm.firstname,
			(
				SELECT IFNULL(CONCAT(LEFT(e.`firstname`, 1),". ",e.`lastname`), "test")
				FROM `' . _DB_PREFIX_ . 'customer_message` cm2
				INNER JOIN ' . _DB_PREFIX_ . 'employee e
					ON e.`id_employee` = cm2.`id_employee`
				WHERE cm2.id_employee > 0
					AND cm2.`id_customer_thread` = a.`id_customer_thread`
				ORDER BY cm2.`date_add` DESC LIMIT 1
			) as employee';
       
        $this->_join = '
			LEFT JOIN `' . _DB_PREFIX_ . 'customer` c
				ON c.`id_customer` = a.`id_customer`
			LEFT JOIN `' . _DB_PREFIX_ . 'customer_message` cm
				ON cm.`id_customer_thread` = a.`id_customer_thread`
			LEFT JOIN `' . _DB_PREFIX_ . 'lang` l
				ON l.`id_lang` = a.`id_lang`
			LEFT JOIN `' . _DB_PREFIX_ . 'contact_lang` cl
				ON (cl.`id_contact` = a.`id_contact` AND cl.`id_lang` = ' . (int) $this->context->language->id . ')';

        if ($id_order = Tools::getValue('id_order')) {
            $this->_where .= ' AND id_order = ' . (int) $id_order;
        }

        $this->_group = 'GROUP BY cm.id_customer_thread';
        $this->_orderBy = 'id_customer_thread';
        $this->_orderWay = 'DESC';      
        $contacts = CustomerThread::getContacts();
        $customers= Customer::getCustomers();
        

        $categories = Contact::getCategoriesContacts();

        $params = [
            $this->trans('Total threads', [], 'Admin.Catalog.Feature') => $all = CustomerThread::getTotalCustomerThreads(),
            $this->trans('Threads pending', [], 'Admin.Catalog.Feature') => $pending = CustomerThread::getTotalCustomerThreads('status LIKE "%pending%"'),
            $this->trans('Total number of customer messages', [], 'Admin.Catalog.Feature') => CustomerMessage::getTotalCustomerMessages('id_employee = 0'),
            $this->trans('Total number of employee messages', [], 'Admin.Catalog.Feature') => CustomerMessage::getTotalCustomerMessages('id_employee != 0'),
            $this->trans('Unread threads', [], 'Admin.Catalog.Feature') => $unread = CustomerThread::getTotalCustomerThreads('status = "open"'),
            $this->trans('Closed threads', [], 'Admin.Catalog.Feature') => $all - ($unread + $pending),
        ];

        $this->tpl_list_vars = [
            'contacts' => $contacts,
            'categories' => $categories,
            'params' => $params,
        ];
        return AdminController::renderList() ;        
       
    }
  
    
    public function renderView()
    {
        //$firstname = CustomerThread::getMessageCustomerThreads((int) Tools::getValue('id_customer_thread'))[0]['firstname'];
        if (!$id_customer_thread = (int) Tools::getValue('id_customer_thread')) {
            return;
        }

        $this->context = Context::getContext();
        if (!($thread = $this->loadObject())) {
            return;
        }
        $this->context->cookie->{'customer_threadFilter_cl!id_contact'} = $thread->id_contact;

        $employees = Employee::getEmployees();

        $messages = CustomerThread::getMessageCustomerThreads($id_customer_thread);

        foreach ($messages as $key => $mess) {
            if ($mess['id_employee']) {
                $employee = new Employee($mess['id_employee']);
                $messages[$key]['employee_image'] = $employee->getImage();
            }
            if (empty($mess['file_name'])) {
                unset($messages[$key]['file_name']);
            } else {
                $messages[$key]['file_link'] = $this->context->link->getAdminLink(
                    'AdminCustomerThreads',
                    true,
                    [],
                    [
                        'id_customer_thread' => $id_customer_thread,
                        'viewcustomer_thread' => '',
                        'filename' => $mess['file_name'],
                        'show' => true,
                    ]
                );
            }

            if ($mess['id_product']) {
                $product = new Product((int) $mess['id_product'], false, $this->context->language->id);
                if (Validate::isLoadedObject($product)) {
                    $messages[$key]['product_name'] = $product->name;
                    $messages[$key]['product_link'] = $this->context->link->getAdminLink('AdminProducts', true, ['id_product' => (int) $product->id, 'updateproduct' => '1']);
                }
            }
        }

        $next_thread = CustomerThread::getNextThread((int) $thread->id);

        $contacts = Contact::getContacts($this->context->language->id);

        $actions = [];

        if ($next_thread) {
            $next_thread = [
                'href' => self::$currentIndex . '&id_customer_thread=' . (int) $next_thread . '&viewcustomer_thread&token=' . $this->token,
                'name' => $this->trans('Reply to the next unanswered message in this thread', [], 'Admin.Catalog.Feature'),
            ];
        }

        if ($thread->status != 'closed') {
            $actions['closed'] = [
                'href' => self::$currentIndex . '&viewcustomer_thread&setstatus=2&id_customer_thread=' . (int) Tools::getValue('id_customer_thread') . '&viewmsg&token=' . $this->token,
                'label' => $this->trans('Mark as "handled"', [], 'Admin.Catalog.Feature'),
                'name' => 'setstatus',
                'value' => 2,
            ];
        } else {
            $actions['open'] = [
                'href' => self::$currentIndex . '&viewcustomer_thread&setstatus=1&id_customer_thread=' . (int) Tools::getValue('id_customer_thread') . '&viewmsg&token=' . $this->token,
                'label' => $this->trans('Re-open', [], 'Admin.Catalog.Feature'),
                'name' => 'setstatus',
                'value' => 1,
            ];
        }

        if ($thread->status != 'pending1') {
            $actions['pending1'] = [
                'href' => self::$currentIndex . '&viewcustomer_thread&setstatus=3&id_customer_thread=' . (int) Tools::getValue('id_customer_thread') . '&viewmsg&token=' . $this->token,
                'label' => $this->trans('Mark as "pending 1" (will be answered later)', [], 'Admin.Catalog.Feature'),
                'name' => 'setstatus',
                'value' => 3,
            ];
        } else {
            $actions['pending1'] = [
                'href' => self::$currentIndex . '&viewcustomer_thread&setstatus=1&id_customer_thread=' . (int) Tools::getValue('id_customer_thread') . '&viewmsg&token=' . $this->token,
                'label' => $this->trans('Disable pending status', [], 'Admin.Catalog.Feature'),
                'name' => 'setstatus',
                'value' => 1,
            ];
        }

        if ($thread->status != 'pending2') {
            $actions['pending2'] = [
                'href' => self::$currentIndex . '&viewcustomer_thread&setstatus=4&id_customer_thread=' . (int) Tools::getValue('id_customer_thread') . '&viewmsg&token=' . $this->token,
                'label' => $this->trans('Mark as "pending 2" (will be answered later)', [], 'Admin.Catalog.Feature'),
                'name' => 'setstatus',
                'value' => 4,
            ];
        } else {
            $actions['pending2'] = [
                'href' => self::$currentIndex . '&viewcustomer_thread&setstatus=1&id_customer_thread=' . (int) Tools::getValue('id_customer_thread') . '&viewmsg&token=' . $this->token,
                'label' => $this->trans('Disable pending status', [], 'Admin.Catalog.Feature'),
                'name' => 'setstatus',
                'value' => 1,
            ];
        }

        if ($thread->id_customer) {
            $customer = new Customer($thread->id_customer);
            $orders = Order::getCustomerOrders($customer->id);
            if ($orders && count($orders)) {
                $total_ok = 0;
                $orders_ok = [];
                foreach ($orders as $key => $order) {
                    if ($order['valid']) {
                        $orders_ok[] = $order;
                        $total_ok += $order['total_paid_real'] / $order['conversion_rate'];
                    }
                    $orders[$key]['date_add'] = Tools::displayDate($order['date_add']);
                    $orders[$key]['total_paid_real'] = $this->context->getCurrentLocale()->formatPrice($order['total_paid_real'], Currency::getIsoCodeById((int) $order['id_currency']));
                }
            }

            $products = $customer->getBoughtProducts();
            if ($products && count($products)) {
                foreach ($products as $key => $product) {
                    $products[$key]['date_add'] = Tools::displayDate($product['date_add'], null, true);
                }
            }
        }
        $timeline_items = $this->getTimeline($messages, $thread->id_order);
        $first_message = end($messages);

        if (!$messages[0]['id_employee']) {
            unset($messages[0]);
        }

        $contact = '';
        foreach ($contacts as $c) {
            if ($c['id_contact'] == $thread->id_contact) {
                $contact = $c['name'];
            }
        }

        $this->tpl_view_vars = [
            'id_customer_thread' => $id_customer_thread,
            // 'firstname'=> $firstname,
            'thread' => $thread,
            'actions' => $actions,
            'employees' => $employees,
            'current_employee' => $this->context->employee,
            'messages' => $messages,
            'first_message' => $first_message,
            'contact' => $contact,
            'next_thread' => $next_thread,
            'orders' => isset($orders) ? $orders : false,
            'customer' => isset($customer) ? $customer : false,
            'products' => isset($products) ? $products : false,
            'total_ok' => isset($total_ok) ? $this->context->getCurrentLocale()->formatPrice($total_ok, $this->context->currency->iso_code) : false,
            'orders_ok' => isset($orders_ok) ? $orders_ok : false,
            'count_ok' => isset($orders_ok) ? count($orders_ok) : false,
            'PS_CUSTOMER_SERVICE_SIGNATURE' => str_replace('\r\n', "\n", Configuration::get('PS_CUSTOMER_SERVICE_SIGNATURE', (int) $thread->id_lang)),
            'timeline_items' => $timeline_items,
        ];

        if ($next_thread) {
            $this->tpl_view_vars['next_thread'] = $next_thread;
        }

        return parent::renderView();
    }

    public function postProcess()
    {
        //$firstname = CustomerThread::getMessageCustomerThreads((int) Tools::getValue('id_customer_thread'))[0]['firstname'];
        
        if ($id_customer_thread = (int) Tools::getValue('id_customer_thread')) {
            if (($id_contact = (int) Tools::getValue('id_contact'))) {
                $result = Db::getInstance()->execute(
                    '
					UPDATE ' . _DB_PREFIX_ . 'customer_thread
					SET id_contact = ' . $id_contact . '
					WHERE id_customer_thread = ' . $id_customer_thread
                );
                if ($result) {
                    $this->object->id_contact = $id_contact;
                }
            }
            if ($id_status = (int) Tools::getValue('setstatus')) {
                $status_array = [1 => 'open', 2 => 'closed', 3 => 'pending1', 4 => 'pending2'];
                $result = Db::getInstance()->execute('
					UPDATE ' . _DB_PREFIX_ . 'customer_thread
					SET status = "' . $status_array[$id_status] . '"
					WHERE id_customer_thread = ' . $id_customer_thread . ' LIMIT 1
				');
                if ($result) {
                    $this->object->status = $status_array[$id_status];
                }
            }
            if (isset($_POST['id_employee_forward'])) {
                $messages = Db::getInstance()->getRow('
					SELECT ct.*, cm.*, cl.name subject, CONCAT(e.firstname, \' \', e.lastname) employee_name,
						CONCAT(c.firstname, \' \', c.lastname) customer_name, c.firstname
					FROM ' . _DB_PREFIX_ . 'customer_thread ct
					LEFT JOIN ' . _DB_PREFIX_ . 'customer_message cm
						ON (ct.id_customer_thread = cm.id_customer_thread)
					LEFT JOIN ' . _DB_PREFIX_ . 'contact_lang cl
						ON (cl.id_contact = ct.id_contact AND cl.id_lang = ' . (int) $this->context->language->id . ')
					LEFT OUTER JOIN ' . _DB_PREFIX_ . 'employee e
						ON e.id_employee = cm.id_employee
					LEFT OUTER JOIN ' . _DB_PREFIX_ . 'customer c
						ON (c.email = ct.email)
					WHERE ct.id_customer_thread = ' . (int) Tools::getValue('id_customer_thread') . '
					ORDER BY cm.date_add DESC
				');
                $output = $this->displayMessage($messages, true, (int) Tools::getValue('id_employee_forward'));
                $cm = new CustomerMessage();
                $cm->id_employee = (int) $this->context->employee->id;
                $cm->id_customer_thread = (int) Tools::getValue('id_customer_thread');
                $cm->ip_address = (int) ip2long(Tools::getRemoteAddr());
                $current_employee = $this->context->employee;
                $id_employee = (int) Tools::getValue('id_employee_forward');
                $employee = new Employee($id_employee);
                $email = Tools::getValue('email');
                $message = Tools::getValue('message_forward');
                if (($error = $cm->validateField('message', $message, null, [], true)) !== true) {
                    $this->errors[] = $error;
                } elseif ($id_employee && $employee && Validate::isLoadedObject($employee)) {
                    $params = [
                        '{messages}' => Tools::stripslashes($output),
                        '{employee}' => $current_employee->firstname . ' ' . $current_employee->lastname,
                        '{comment}' => Tools::stripslashes(Tools::nl2br($_POST['message_forward'])),
                        '{firstname}' => $employee->firstname,
                        '{lastname}' => $employee->lastname,
                    ];

                    if (Mail::Send(
                        $this->context->language->id,
                        'forward_msg',
                        $this->trans(
                            'Fwd: Customer message',
                            [],
                            'Emails.Subject',
                            $this->context->language->locale
                        ),
                        $params,
                        $employee->email,
                        $employee->firstname . ' ' . $employee->lastname,
                        $current_employee->email,
                        $current_employee->firstname . ' ' . $current_employee->lastname,
                        null,
                        null,
                        _PS_MAIL_DIR_,
                        true
                    )) {
                        $cm->private = 1;
                        $cm->message = $this->trans('Message forwarded to', [], 'Admin.Catalog.Feature') . ' ' . $employee->firstname . ' ' . $employee->lastname . "\n" . $this->trans('Comment:') . ' ' . $message;
                        $cm->add();
                    }
                } elseif ($email && Validate::isEmail($email)) {
                    $params = [
                        '{messages}' => Tools::nl2br(Tools::stripslashes($output)),
                        '{employee}' => $current_employee->firstname . ' ' . $current_employee->lastname,
                        '{comment}' => Tools::stripslashes($_POST['message_forward']),
                        '{firstname}' => '',
                        '{lastname}' => '',
                    ];

                    if (Mail::Send(
                        $this->context->language->id,
                        'forward_msg',
                        $this->trans(
                            'Fwd: Customer message',
                            [],
                            'Emails.Subject',
                            $this->context->language->locale
                        ),
                        $params,
                        $email,
                        //$firstname,
                        null,
                        $current_employee->email,
                        $current_employee->firstname . ' ' . $current_employee->lastname,
                        null,
                        null,
                        _PS_MAIL_DIR_,
                        true
                    )) {
                        $cm->message = $this->trans('Message forwarded to', [], 'Admin.Catalog.Feature') . ' ' . $email . "\n" . $this->trans('Comment:') . ' ' . $message;
                        $cm->add();
                    }
                } else {
                    $this->errors[] = '<div class="alert error">' . $this->trans('The email address is invalid.', [], 'Admin.Notifications.Error') . '</div>';
                }
            }
            if (Tools::isSubmit('submitReply')) {
                $ct = new CustomerThread($id_customer_thread);

                ShopUrl::cacheMainDomainForShop((int) $ct->id_shop);

                $cm = new CustomerMessage();
                $cm->id_employee = (int) $this->context->employee->id;
                $cm->id_customer_thread = $ct->id;
                $cm->ip_address = (int) ip2long(Tools::getRemoteAddr());
                $cm->message = Tools::getValue('reply_message');
                if (($error = $cm->validateField('message', $cm->message, null, [], true)) !== true) {
                    $this->errors[] = $error;
                } elseif (isset($_FILES) && !empty($_FILES['joinFile']['name']) && $_FILES['joinFile']['error'] != 0) {
                    $this->errors[] = $this->trans('An error occurred during the file upload process.', [], 'Admin.Notifications.Error');
                } elseif ($cm->add()) {
                    $file_attachment = null;
                    if (!empty($_FILES['joinFile']['name'])) {
                        $file_attachment['content'] = file_get_contents($_FILES['joinFile']['tmp_name']);
                        $file_attachment['name'] = $_FILES['joinFile']['name'];
                        $file_attachment['mime'] = $_FILES['joinFile']['type'];
                    }
                    $customer = new Customer($ct->id_customer);

                    $params = [
                        '{reply}' => Tools::nl2br(Tools::htmlentitiesUTF8(Tools::getValue('reply_message'))),
                        '{link}' => Tools::url(
                            $this->context->link->getPageLink('contact', true, null, null, false, $ct->id_shop),
                            'id_customer_thread=' . (int) $ct->id . '&token=' . $ct->token
                        ),
                        '{firstname}' => $customer->firstname,
                        '{lastname}' => $customer->lastname,
                    ];
                    //#ct == id_customer_thread    #tc == token of thread   <== used in the synchronization imap
                    $contact = new Contact((int) $ct->id_contact, (int) $ct->id_lang);

                    if (Validate::isLoadedObject($contact)) {
                        $from_name = $contact->name;
                        $from_email = $contact->email;
                    } else {
                        $from_name = null;
                        $from_email = null;
                    }

                    $language = new Language((int) $ct->id_lang);

                    if (Mail::Send(
                        (int) $ct->id_lang,
                        'reply_msg',
                        $this->trans(
                            'An answer to your message is available #ct%thread_id% #tc%thread_token%',
                            [
                                '%thread_id%' => $ct->id,
                                '%thread_token%' => $ct->token,
                            ],
                            'Emails.Subject',
                            $language->locale
                        ),
                        $params,
                        Tools::getValue('msg_email'),
                        null,
                        $from_email,
                        $from_name,
                        $file_attachment,
                        null,
                        _PS_MAIL_DIR_,
                        true,
                        $ct->id_shop
                    )) {
                        $ct->status = 'closed';
                        $ct->update();
                    }
                    Tools::redirectAdmin(
                        self::$currentIndex . '&id_customer_thread=' . (int) $id_customer_thread . '&viewcustomer_thread&token=' . Tools::getValue('token')
                    );
                } else {
                    $this->errors[] = $this->trans('An error occurred. Your message was not sent. Please contact your system administrator.', [], 'Admin.Orderscustomers.Notification');
                }
            }
        }

        return parent::postProcess();
    }
    protected function displayMessage($message, $email = false, $id_employee = null)
    {
        $tpl = $this->createTemplate('message.tpl');

        $contacts = Contact::getContacts($this->context->language->id);
        foreach ($contacts as $contact) {
            $contact_array[$contact['id_contact']] = ['id_contact' => $contact['id_contact'], 'name' => $contact['name']];
        }
        $contacts = $contact_array;

        if (!$email) {
            if (!empty($message['id_product']) && empty($message['employee_name'])) {
                $id_order_product = Order::getIdOrderProduct((int) $message['id_customer'], (int) $message['id_product']);
            }
        }
        $message['date_add'] = Tools::displayDate($message['date_add'], null, true);
        $message['user_agent'] = strip_tags($message['user_agent']);
        $message['message'] = preg_replace(
            '/(https?:\/\/[a-z0-9#%&_=\(\)\.\? \+\-@\/]{6,1000})([\s\n<])/Uui',
            '<a href="\1">\1</a>\2',
            html_entity_decode(
                $message['message'],
            ENT_QUOTES,
                'UTF-8'
            )
        );

        $is_valid_order_id = true;
        $order = new Order((int) $message['id_order']);

        if (!Validate::isLoadedObject($order)) {
            $is_valid_order_id = false;
        }

        $tpl->assign([
            'thread_url' => Tools::getAdminUrl(basename(_PS_ADMIN_DIR_) . '/' .
                $this->context->link->getAdminLink('AdminCustomerThreads') . '&amp;id_customer_thread='
                . (int) $message['id_customer_thread'] . '&amp;viewcustomer_thread=1'),
            'link' => Context::getContext()->link,
            'current' => self::$currentIndex,
            'token' => $this->token,
            'message' => $message,
            'id_order_product' => isset($id_order_product) ? $id_order_product : null,
            'email' => $email,
            'id_employee' => $id_employee,
            'PS_SHOP_NAME' => Configuration::get('PS_SHOP_NAME'),
            'file_name' => file_exists(_PS_UPLOAD_DIR_ . $message['file_name']),
            'contacts' => $contacts,
            'is_valid_order_id' => $is_valid_order_id,
        ]);

        return $tpl->fetch();
    }

}
    