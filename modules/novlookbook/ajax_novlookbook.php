<?php
/**
 * Vinova Themes Framework for Prestashop 1.6.x
 * @author      http://vinovathemes.com/
 * @copyright   Copyright (C) October 2017 vinovathemes.com <@email:vinovathemes@gmail.com>
 * @license   GNU General Public License version 1
 * @version     1.0
 * @package     novlookbook
 * <info@vinovathemes.com>.All rights reserved.
 **/

include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('novlookbook.php');

$context = Context::getContext();
$home_slider = new NovLookbook();
$slides = array();

if (!Tools::isSubmit('secure_key') || Tools::getValue('secure_key') != $home_slider->secure_key || !Tools::getValue('action')) {
    die(1);
}

if (Tools::getValue('action') == 'updateSlidesPosition' && Tools::getValue('slides')) {
    $slides = Tools::getValue('slides');
    foreach ($slides as $position => $id_slide) {
        $res = Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'novlookbook_slides` SET `position` = '.(int)$position.' WHERE `id_novlookbook_slides` = '.(int)$id_slide);
    }
    $home_slider->clearCache();
}

if (Tools::getValue('action') == 'search_product' && Tools::getValue('character')) {
    $character = Tools::getValue('character');
    $result = $home_slider->findByCategory(Context::getContext()->language->id, $character);
    $html = "";
    if (count($result['result']) > 0) {
        $html .= '<ul class="list-product">';
        foreach ($result['result'] as $item) {
            $html .= '<li class="item-list-product" data-slug="' . $item['id_product'] . '">';
            $html .= $item['name'] . '(' . $item['id_product'] . ')';
            $html .= '</li>';
        }
        $html .= '</ul>';
    }

    die($html);
}

if (Tools::getValue('action') == 'check_product' && Tools::getValue('post_id')) {
    $id_product = Tools::getValue('post_id');
    $product = new Product((int)$id_product);
    echo (Validate::isLoadedObject($product) ? 1 : ('don\'t exist'));
}
