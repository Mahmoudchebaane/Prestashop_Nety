<?php

use GuzzleHttp\Client;

/***
 * override Class CustomerCore
 */
class Customer extends CustomerCore
{


    public $ref_client;

    public $num_fixe;
    public $phone;
    public $ref_abonnement;
   


    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        self::$definition['fields']['ref_client'] = array('type' => self::TYPE_HTML, 'lang' => false);
        self::$definition['fields']['num_fixe'] = array('type' => self::TYPE_HTML, 'lang' => false);
        self::$definition['fields']['phone'] = array('type' => self::TYPE_HTML, 'lang' => false);
        self::$definition['fields']['ref_abonnement'] = array('type' => self::TYPE_HTML, 'lang' => false);
        parent::__construct($id, $id_lang, $id_shop);
    }


    public static function getCustomers($onlyActive = null)
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            '
            SELECT `id_customer`, `email`, `firstname`, `lastname`, `ref_client`, `num_fixe`, `phone`, `ref_abonnement`
            FROM `' . _DB_PREFIX_ . 'customer`
            WHERE 1 ' . Shop::addSqlRestriction(Shop::SHARE_CUSTOMER) .
            ($onlyActive ? ' AND `active` = 1' : '') . '
            ORDER BY `id_customer` ASC'
        );
    }
    public static function getCustomerById($id)
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            '
            SELECT `id_customer`, `email`, `firstname`, `lastname`, `ref_client`, `num_fixe`, `phone`, `ref_abonnement`
            FROM `' . _DB_PREFIX_ . 'customer`
            WHERE id_customer ='.$id 
        );
    }
    public static function getTokenCustomerById($id)
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            '
            SELECT `token`
            FROM `' . _DB_PREFIX_ . 'customer_session`
            WHERE id_customer = ' . (int)$id . '
            ORDER BY id_customer DESC
            LIMIT 1'
        );
    }

    public function add($autodate = true, $null_values = true)
    {        
        $client = new Client();
        parent::add($autodate, $null_values);       
        $ref_abonnement = $this->ref_abonnement;
        $id = $this->id;
        try {
            // $linkcrm = 'https://crm.chifco.com';
            // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
            //     $linkcrm = 'https://customer.chifco.com';
            // }
            $request = $client->createRequest('POST', LINK_CRM . '/api/saveWebsiteAccount', [
                'body' => [
                    'ref_abonnement' => $ref_abonnement,
                    'ref_clientsite' => $id,
                ]
            ]);
            $response = $client->send($request);

            if ($response->getStatusCode() == 200) {
                try {
                    $client = new Client();
                    // $linkcrm = 'https://crm.chifco.com';
                    // if (Tools::getShopDomain(true) == 'http://www.nety.tn' || Tools::getShopDomainSsl(true) == 'https://www.nety.tn') {
                    //     $linkcrm = 'https://customer.chifco.com';
                    // }

                    $request1 = $client->createRequest('POST', LINK_CRM . '/api/updateAccount', [
                        'body' => [
                            'ref_abonnement' => Tools::getValue('ref_abonnement'),
                            'numTel' => Tools::getValue('phone'),
                            'email' =>Tools::getValue('email'),
                        ]
                    ]);

                    $response1 = $client->send($request1);
                    if ($response1->getStatusCode() == 200) {
                        $successresponse = json_decode($response1->getBody(), 1);
                        return true;
                    }
                } catch (Exception $e) {
                    
                }
            } else {
                return false;
            }



        } catch (Exception $e) {
            return false;
        }
    }

}
