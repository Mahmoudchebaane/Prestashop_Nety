<?php
class crm_postal_code extends ObjectModel
{
    public static $definition = [
        'table' => ' crm_postal_code',
        'primary' => 'ville_id',
        'fields' => [
            'ville_name' => ['type' => self::TYPE_STRING, 'required' => true],
            'gouvernorat_id' => ['type' => self::TYPE_INT, 'required' => true],
            'created_date' => ['type' => self::TYPE_DATE, 'required' => false],
            'modified_date' => ['type' => self::TYPE_DATE, 'required' => false],
            'abreviation' => ['type' => self::TYPE_STRING, 'required' => true]
        ],
    ];


    protected $webserviceParameters = [
        'objectMethods' => [
            'get' => 'getWebserviceObjectList'
        ]
    ];

    public function getWebserviceObjectList($sql_join, $sql_filter, $sql_sort, $sql_limit)
    {
        $villeid = $_REQUEST['ville_id'];
        $result = json_encode(Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM crm_postal_code  WHERE ville_id='.$villeid ));
     
        echo $result;
     
    }

}