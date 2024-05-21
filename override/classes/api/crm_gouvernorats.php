<?php
class crm_gouvernorats extends ObjectModel
{
    public $gouvernorat_name;
    public $gouvernorat_id;
    public $created_date;
    public $modified_date;
    public $abreviation;
    public static $definition = [
        'table' => 'crm_gouvernorats',
        'primary' => 'gouvernorat_id',
        'fields' => [
            'gouvernorat_name' => ['type' => self::TYPE_STRING, 'required' => true],
            'created_date' => ['type' => self::TYPE_DATE, 'required' => false],
            'modified_date' => ['type' => self::TYPE_DATE, 'required' => false],
            'abreviation' => ['type' => self::TYPE_STRING, 'required' => true]

        ],
    ];


    protected $webserviceParameters = [
        'objectNodeName' => 'govs',

        'fields' => [
            'gouvernorat_name' => [],
            'created_date' => [],
            'modified_date' => [],
            'abreviation' => []

        ],

    ];

    public function getWebserviceObjectList($sql_join, $sql_filter, $sql_sort, $sql_limit)
    {
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `crm_gouvernorats`');
        return $result;
    }

}