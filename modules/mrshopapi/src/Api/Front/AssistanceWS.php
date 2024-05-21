<?php
/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * You must not modify, adapt or create derivative works of this source code
 *
 * @author Mr. APPs
 * @copyright Mr. APPs 2023
 * @license Mr. APPs
 */

namespace MrAPPs\MrShopApi\Api\Front;

use Configuration;
use Contact;
use Customer;
use CustomerMessage;
use CustomerThread;
use DateTime;
use Mail;
use MrAPPs\MrShopApi\Api\BaseWS;
use Order;
use Tools;

class AssistanceWS extends BaseWS
{
    public function __construct($dataHandler)
    {
        parent::__construct($dataHandler);
        $this->cacheEnabled = false;
    }

    public function getList($params, $id_customer)
    {
        if (!array_key_exists('id_order', $params)) {
            return $this->orderNotFoundResponse();
        }

        $orderId = (int) $params['id_order'];
        $order = new Order($orderId);
        if (!$order->reference || $order->id_customer != $id_customer) {
            return $this->orderNotFoundResponse();
        }

        $out = [];
        $messages = CustomerMessage::getMessagesByOrderId($orderId, false);
        foreach ($messages as $m) {
            $fromUser = (int) $m['id_employee'] == 0;
            $firstname = $fromUser ? $m['cfirstname'] : $m['efirstname'];
            $lastname = $fromUser ? $m['clastname'] : $m['elastname'];

            $out[] = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'from_user' => $fromUser,
                'message' => $m['message'],
                'read' => (bool) $m['read'],
                'is_new_for_me' => (bool) $m['is_new_for_me'],
                'date' => (new DateTime($m['date_add']))->getTimestamp()
            ];
        }

        $this->response(true, null, $out);
    }

    public function updateOrCreate($params, $id, $id_customer)
    {
        if (!array_key_exists('message', $params) || $params['message'] == null) {
            $this->response(false, $this->module->l('Assistance message is required', 'assistancews'));
        }

        if (!array_key_exists('id_order', $params)) {
            return $this->orderNotFoundResponse();
        }

        $orderId = (int) $params['id_order'];
        $order = new Order($orderId);
        if (!$order->reference || $order->id_customer != $id_customer) {
            return $this->orderNotFoundResponse();
        }

        $productId = array_key_exists('id_product', $params) ? (int) $params['id_product'] : 0;
        $id_customer_thread = CustomerThread::getIdCustomerThreadByEmailAndIdOrder(
            $this->context->customer->email,
            $orderId
        );
        if (!$id_customer_thread) {
            $ct = new CustomerThread();
            $ct->id_contact = 0;
            $ct->id_customer = $id_customer;
            $ct->id_shop = (int) $this->context->shop->id;
            $ct->id_product = $productId;
            $ct->id_order = $orderId;
            $ct->id_lang = (int) $this->context->language->id;
            $ct->email = $this->context->customer->email;
            $ct->status = 'open';
            $ct->token = Tools::passwdGen(12);
            $ct->save();
        } else {
            $ct = new CustomerThread((int) $id_customer_thread);
            $ct->status = 'open';
            $ct->save();
        }
        $customerMessage = new CustomerMessage();
        $customerMessage->id_customer_thread = $ct->id;
        $customerMessage->message = $params['message'];
        $customerMessage->ip_address = (int) ip2long(Tools::getRemoteAddr());
        $customerMessage->save();

        /* modifica invio mail */
        $customer = new Customer($id_customer);
        $order = new Order($orderId);

        if (!Configuration::get('PS_MAIL_EMAIL_MESSAGE')) {
            $to = (string) Configuration::get('PS_SHOP_EMAIL');
        } else {
            $to = new Contact((int) Configuration::get('PS_MAIL_EMAIL_MESSAGE'));
            $to = (string) $to->email;
        }

        Mail::Send(
            $this->context->language->id,
            'order_customer_comment',
            'Message from a customer from app',
            [
                '{lastname}' => $customer->lastname,
                '{firstname}' => $customer->firstname,
                '{email}' => $customer->email,
                '{id_order}' => (int) $order->id,
                '{order_name}' => $order->getUniqReference(),
                '{message}' => Tools::nl2br(Tools::htmlentitiesUTF8($params['message'])),
            ],
            $to,
            null,
            (string) Configuration::get('PS_SHOP_EMAIL'),
            $customer->firstname.' '.$customer->lastname,
            null,
            null,
            _PS_MAIL_DIR_,
            false,
            null,
            null,
            $customer->email
        );

        /* fine modifica invio mail */

        return $this->getList($params, $id_customer);
    }

    private function orderNotFoundResponse()
    {
        $this->response(false, $this->module->l('Order not found', 'assistancews'));
    }
}
