<?php
class crm_villes extends ObjectModel
{
    public static $definition = [
        'table' => ' crm_villes',
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
        $gov_id = $_REQUEST['gouvernorat_id'];
        $result = json_encode(Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM crm_villes WHERE gouvernorat_id='.$gov_id  ));
        
        echo $result;
    }

}