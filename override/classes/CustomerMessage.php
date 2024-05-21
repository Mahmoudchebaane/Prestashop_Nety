<?php
 
class CustomerMessage extends CustomerMessageCore {
  
    /*
    * module: customcontactus
    * date: 2023-07-05 08:57:19
    * version: 1.0
    */
    public $tel; 
 
    /*
    * module: customcontactus
    * date: 2023-07-05 08:57:19
    * version: 1.0
    */
    public $gsm;
    /*
    * module: customcontactus
    * date: 2023-07-05 08:57:19
    * version: 1.0
    */
    public $address;
    /*
    * module: customcontactus
    * date: 2023-07-05 08:57:19
    * version: 1.0
    */
    public $firstname;
    
    /*
    * module: customcontactus
    * date: 2023-07-05 08:57:19
    * version: 1.0
    */
    public function __construct($id= null, $id_lang = null, $id_shop = null){        
        self::$definition['fields']['gsm'] = array('type' => self::TYPE_HTML, 'lang' => false);
        self::$definition['fields']['tel'] = array('type' => self::TYPE_HTML, 'lang' => false);
        self::$definition['fields']['address'] = array('type' => self::TYPE_HTML, 'lang' => false);
        self::$definition['fields']['firstname'] = array('type' => self::TYPE_HTML, 'lang' => false);
        parent::__construct($id, $id_lang, $id_shop);
    }
 
}
