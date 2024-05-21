<?php

class State extends StateCore
{
    public function getStateById($id)
    { 
            return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT `id_state`, `id_country`, `id_zone`, `iso_code`, `name`, `active`
            FROM `' . _DB_PREFIX_ . 'state`
            WHERE id_state = '. $id . '
            ORDER BY `name` ASC');
        
    }
}