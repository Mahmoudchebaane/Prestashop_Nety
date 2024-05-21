<?php
/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
class PaiementFactureClass extends ObjectModel
{
     
   
    public $order_number; 
    public $order_id;
    public $factures; 
    public $created_date; 
    public $modified_date; 
    public $ammount;
    public $payment_type; 
    public $payment_state; 
    public $message; 
    public $message_smt;
    public $client;
    
    public $num_fixe;
    public $reference_crm;
    public $sendto_crm;  
    public $sendto_pay;  
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'paiementfacture',
        'primary' => 'order_number',
        'fields' => [  
            'created_date'  => ['type' => self::TYPE_DATE , 'required' => false],  
            'modified_date'  => ['type' => self::TYPE_DATE , 'required' => false],  
            'order_id'  => ['type' => self::TYPE_STRING , 'required' => false],  
            'factures'  => ['type' => self::TYPE_STRING , 'required' => true], 
            'ammount'  => ['type' => self::TYPE_FLOAT , 'required' => true],   
            'payment_type'  => ['type' => self::TYPE_STRING , 'required' => true], 
            'payment_state'  => ['type' => self::TYPE_BOOL , 'required' => false],  
            'message'  => ['type' => self::TYPE_STRING , 'required' => false], 
            'message_smt' => ['type' => self::TYPE_STRING , 'required' => false], 
            'client'  => ['type' => self::TYPE_STRING , 'required' => false], 
            'num_fixe'  => ['type' => self::TYPE_INT , 'required' => false], 
            'reference_crm'  => ['type' => self::TYPE_STRING , 'required' => false], 
            'sendto_pay'  => ['type' => self::TYPE_BOOL , 'required' => false] ,
            'sendto_crm'  => ['type' => self::TYPE_BOOL , 'required' => false] 
        ],
    ];    
}

