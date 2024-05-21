<?php

/**
 * BINSHOPS
 *
 * @author BINSHOPS
 * @copyright BINSHOPS
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * Best In Shops eCommerce Solutions Inc.
 *
 */

require_once dirname(__FILE__) . '/../AbstractAuthRESTController.php';

use PrestaShop\PrestaShop\Adapter\Presenter\Order\OrderPresenter;

class BinshopsrestOrderHistoryModuleFrontController extends AbstractAuthRESTController
{
    protected function processGetRequest()
    {
        //proccess single order
        if (Tools::getIsset('id_order')) {
            $id_order = Tools::getValue('id_order');
            if (Tools::isEmpty($id_order) or !Validate::isUnsignedId($id_order)) {

                $this->ajaxRender(json_encode([
                    'success' => false,
                    'code' => 404,
                    'message' => $this->trans('order not found', [], 'Modules.Binshopsrest.Order')
                ]));
                die;
            }

            //there is a duplication of code but a prevention of new object creation too
            $order = new Order($id_order, $this->context->language->id);
            if (Validate::isLoadedObject($order) && $order->id_customer == $this->context->customer->id) {
                $order_images = [];
                foreach ($order->getCartProducts() as $product) {
                    $order_images[] = $product['image'];
                }
                $order_data = [
                    'id_order' => $order->id,
                    'id_cart' => $order->id_cart,
                    'invoice' => $order->invoice_number,
                    'order_reference' => $order->reference,
                    'order_date' => $order->date_add,
                    'order_update' => $order->date_upd,
                    'order_payment_method' => $order->payment,
                    'order_subtotal' => $order->getOrdersTotalPaid(),
                    'order_shipping_cost' => $order->total_shipping,
                    'order_tax_stamp' => $order->total_wrapping,
                    'invoice_address' => $order->id_address_invoice,
                    'delivery_address' => $order->id_address_delivery,
                    'invoice_date' =>$order->invoice_date,
                    'delivery_date'=>$order->delivery_date,
                    'valid' => $order->valid,
                    'date_add' =>$order->date_add,
                    'date_upd' =>$order->date_upd,
                    'note' => $order->note,
                    'shipping' => $order->getShipping(),
                    'delivery_number' => $order->delivery_number,
                    'details' => $order->getWsOrderRows(),
                    'order_images' => $order_images,
                ];


                if (Tools::isEmpty($id_order) or !Validate::isLoadedObject($order)) {

                    $this->ajaxRender(json_encode([
                        'success' => true,
                        'code' => 404,
                        'message' => $this->trans('order not found', [], 'Modules.Binshopsrest.Order')
                    ]));
                    die;
                } else {

                    $this->ajaxRender(json_encode([
                        'success' => true,
                        'code' => 200,
                        'psdata' => $order_data
                    ]));
                    die;
                }
            }else{
                $this->ajaxRender(json_encode([
                    'success' => false,
                    'code' => 404,
                    'message' => $this->trans('order not found', [], 'Modules.Binshopsrest.Order')
                ]));
                die;
            }
        }

        //process all orders
        $customer_orders = Order::getCustomerOrders($this->context->customer->id);
        $filtred_data = [];
        foreach ($customer_orders as $order){
            $filtred_data[] = [
                "id_order" => $order['id_order'],
                "reference" => $order['reference'],
                "id_lang" => $order['id_lang'],
                "id_customer" => $order['id_customer'],
                "id_cart" => $order['id_cart'],
                "id_address_delivery" => $order['id_address_delivery'],
                "id_address_invoice" => $order['id_address_invoice'],
                "current_state" => $order['current_state'],
                "total_discounts" => $order['total_discounts'],
                "total_discounts_tax_incl" => $order['total_discounts_tax_incl'],
                "total_discounts_tax_excl" => $order['total_discounts_tax_excl'],
                "total_paid" => $order['total_paid'],
                "total_paid_tax_incl" => $order['total_paid_tax_incl'],
                "total_paid_tax_excl" => $order['total_paid_tax_excl'],
                "total_paid_real" => $order['total_paid_real'],
                "total_products" => $order['total_products'],
                "total_products_wt" => $order['total_products_wt'],
                "total_shipping" => $order['total_shipping'],
                "total_shipping_tax_incl" => $order['total_shipping_tax_incl'],
                "total_shipping_tax_excl" => $order['total_shipping_tax_excl'],
                "carrier_tax_rate" => $order['carrier_tax_rate'],
                "total_wrapping" => $order['total_wrapping'],
                "total_wrapping_tax_incl" => $order['total_wrapping_tax_incl'],
                "total_wrapping_tax_excl" => $order['total_wrapping_tax_excl'],
                "invoice_date" => $order['invoice_date'],
                "delivery_date" => $order['delivery_date'],
                "note" => $order['note'],
                "nb_products" => $order['nb_products'],
                "id_order_state" => $order['id_order_state'],
                "order_state" => $order['order_state'],
                "order_state_color" => $order['order_state_color']
            ];
        }
        $this->ajaxRender(json_encode([
            'success' => true,
            'code' => 200,
            'psdata' => $filtred_data
        ]));
        die;
    }
}
