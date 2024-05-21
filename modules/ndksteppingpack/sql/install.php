<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
 */
$sql = [];
$sqlIndexes = [];
$prefix = _DB_PREFIX_;
$engine = _MYSQL_ENGINE_;
$tables =
[
    ['name' => 'ndksteppingpack', 
    'primary' => 'id_ndksteppingpack',  
    'index_primary' => ['id_ndksteppingpack'],
    'index' => ['id_ndksteppingpack', 'active'],
    'cols' => [
        ['name' => 'id_ndksteppingpack', 'opts' => 'int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT'],
        ['name' => 'id_shop', 'opts' => 'int(10) NOT NULL NOT NULL DEFAULT 0'],
        ['name' => 'id_cart_rule', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'id_product_rule_group', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'id_product_rule', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'id_pack_prod', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'type', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'position', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'reduction_amount', 'opts' => 'float NOT NULL DEFAULT 0'],
        ['name' => 'reduction_percent', 'opts' => 'float NOT NULL DEFAULT 0'],
        ['name' => 'fixed_price', 'opts' => 'float NOT NULL DEFAULT 0'],
        ['name' => 'active', 'opts' => 'int(1) NOT NULL DEFAULT 1'],
        ['name' => 'display_categories', 'opts' => 'varchar(5000) NOT NULL'],
    ],
    ],
    ['name' => 'ndksteppingpack_lang', 
    'primary' => '',
    'index_primary' => ['id_ndksteppingpack', 'id_lang'],
    'cols' => [
        ['name' => 'id_ndksteppingpack', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'name', 'opts' => 'varchar(255) NOT NULL'],
        ['name' => 'short_description', 'opts' => 'varchar(5000) NOT NULL'],
        ['name' => 'description', 'opts' => 'varchar(5000) NOT NULL'],
        ['name' => 'id_lang', 'opts' => 'int(10) NOT NULL'],
    ],
    ],
    ['name' => 'ndksteppingpack_step', 
    'primary' => 'id_ndksteppingpack_step',
    'index_primary' => ['id_ndksteppingpack_step'],
    'index' => ['id_ndksteppingpack', 'id_ndksteppingpack_step'],  
    'cols' => [
        ['name' => 'id_ndksteppingpack_step', 'opts' => 'int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT'],
        ['name' => 'id_ndksteppingpack', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'id_product_rule_group', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'minimum', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'maximum', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'products', 'opts' => 'varchar(5000) NOT NULL DEFAULT 0'],
        ['name' => 'categories', 'opts' => 'varchar(5000) NOT NULL DEFAULT 0'],
        ['name' => 'suppliers', 'opts' => 'varchar(500) NOT NULL DEFAULT 0'],
        ['name' => 'manufacturers', 'opts' => 'varchar(500) NOT NULL DEFAULT 0'],
        ['name' => 'position', 'opts' => 'int(11) NOT NULL'],
        ['name' => 'optionnal', 'opts' => 'int(11) NOT NULL DEFAULT 0'],
        ['name' => 'show_price', 'opts' => 'int(11) NOT NULL DEFAULT 1'],
    ],
    ],
    ['name' => 'ndksteppingpack_step_lang', 
    'primary' => '',  
    'index_primary' => ['id_ndksteppingpack_step', 'id_lang'],
    'index' => ['id_ndksteppingpack_step'], 
    'cols' => [
        ['name' => 'id_ndksteppingpack_step', 'opts' => 'int(10) NOT NULL'],
        ['name' => 'name', 'opts' => 'varchar(255) NOT NULL'],
        ['name' => 'description', 'opts' => 'varchar(5000) NOT NULL'],
        ['name' => 'id_lang', 'opts' => 'int(10) NOT NULL'],
    ],
    ],
    ['name' => 'ndksteppingpack_shop', 
    'primary' => '',  
    'index_primary' => ['id_ndksteppingpack', 'id_shop'],
    'index' => ['id_ndksteppingpack', 'id_shop'],  
    'cols' => [
        ['name' => 'id_ndksteppingpack', 'opts' => 'int(10) NOT NULL DEFAULT 0'],
        ['name' => 'id_shop', 'opts' => 'int(10) NOT NULL DEFAULT 0'],
    ],
    ],
    ['name' => 'ndksteppingpack_order', 
    'primary' => '',
    'index_primary' => [],
    'index' => [], 
    'cols' => [
        ['name' => 'id_cart', 'opts' => 'int(10) NOT NULL DEFAULT 0'],
        ['name' => 'id_product', 'opts' => 'int(10) NOT NULL DEFAULT 0'],
        ['name' => 'id_product_attribute', 'opts' => 'int(10) NOT NULL DEFAULT 0'],
        ['name' => 'quantity', 'opts' => 'int(10) NOT NULL DEFAULT 0'],
        ['name' => 'id_virtual_pack', 'opts' => 'int(10) NOT NULL DEFAULT 0'],
    ],
    ],
];


// check if old tables
$sqlCheckOld = 'SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = \''.$prefix.'ndk_steppingpack\'' ;
$hasOldTables = (int)Db::getInstance()->getValue($sqlCheckOld) > 0;

if($hasOldTables){
    $old_tables = ['ndk_steppingpack', 'ndk_steppingpack_lang', 'ndk_steppingpack_step', 'ndk_steppingpack_step_lang', 'ndk_steppingpack_shop', 'ndk_steppingpack_order'];
    foreach($old_tables as $old_table){
        //on renomme la table si elle existe avant : 
        $new_table = str_replace("ndk_steppingpack", "ndksteppingpack", $old_table);
        $mysql = 'ALTER TABLE  IF EXISTS '. $prefix .$old_table.' RENAME TO '. $prefix .$new_table;
        Db::getInstance()->execute($mysql);
            
        $mysql = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = \''. $prefix .$new_table.'\'';
        $results = Db::getInstance()->executeS($mysql);
            
        foreach($results as $row) {
            $old_column_name = $row["COLUMN_NAME"];
            $new_column_name = str_replace("ndk_steppingpack", "ndksteppingpack", $old_column_name);
            $mysql = 'ALTER TABLE '. $prefix .$new_table.' CHANGE COLUMN '.$old_column_name.' '.$new_column_name.'  varchar(255) NOT NULL';
            Db::getInstance()->execute($mysql);
        }      
    }
}

foreach ($tables as $table) {
    $sql[$table['name']] =
        'CREATE TABLE IF NOT EXISTS '.
        $prefix.
        $table['name'].
        ' ( remove_me_after float NOT NULL';
    $sql[$table['name']] .= ' )  ENGINE='.$engine;
    
    //$sql_indexes[] = 'DROP INDEX IF EXISTS PRIMARY ON '.$prefix.$table['name'];
    foreach ($table['cols'] as $col) {
        //check if col exists
        $sqlCheck =
            'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
     WHERE table_name = "'.
            $prefix.
            $table['name'].
            '"
     AND table_schema = "'.
            _DB_NAME_.
            '"
     AND column_name = "'.
            $col['name'].
            '" ';

        $check = Db::getInstance()->executeS($sqlCheck);

        if (0 == sizeof($check)) {
            $sql[] =
                'ALTER TABLE '.
                $prefix.
                $table['name'].
                ' ADD  '.
                $col['name'].
                ' '.
                $col['opts'];
        }
    }

    //on enlève la premiere colonne
    //check if col exists
    $sqlCheckRemove =
        'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
     WHERE table_name = "'.
        $prefix.
        $table['name'].
        '"
     AND table_schema = "'.
        _DB_NAME_.
        '"
     AND column_name = "remove_me_after" ';

    $checkRemove = Db::getInstance()->executeS($sqlCheckRemove);

    if (sizeof($checkRemove) > 0) {
        $sql[] =
            'ALTER TABLE '.
            $prefix.
            $table['name'].
            ' DROP COLUMN remove_me_after';
    }
}
//dump($sql);die();

foreach ($sql as $query) {
    if (false == Db::getInstance()->execute($query)) {
        return false;
    }
}

$sql_indexes = [];
foreach ($tables as $table) {
    $chekIndex = Db::getInstance()->executeS('SHOW INDEX FROM '.$prefix.$table['name']);
    $is_primary = false;
    foreach($chekIndex as $index)
    {
        //$sql_indexes[] = 'DROP INDEX '.$index['Key_name'].' ON '.$prefix.$table['name'];
        if($index['Key_name'] == 'PRIMARY') $is_primary = true;
        else $sql_indexes[] = 'DROP INDEX '.$index['Key_name'].' ON '.$prefix.$table['name'];
    }
    //dump($chekIndex); die();
    
    if ($table['index_primary'] && !$is_primary) {
        
        if ('' != $table['index_primary'][0]) {
            $sql_indexes[] =
                'ALTER TABLE `'.
                $prefix.
                $table['name'].
                '`
            ADD PRIMARY KEY `'.
                implode('_', $table['index_primary']).
                '` (`'.
                implode('`,`', $table['index_primary']).
                '`);';
        }
    }
    if (isset($table['index'])) {
            foreach($table['index'] as $index){
                $sql_indexes[] ='ALTER TABLE '.$prefix.$table['name'].' ADD INDEX '.$index.' ('.$index.')';
            }
    }
}
//dump($sql_indexes);die();
foreach ($sql_indexes as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
