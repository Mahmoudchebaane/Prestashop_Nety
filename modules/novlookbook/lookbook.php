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

class LookBook extends ObjectModel
{
    public $title;
    public $description;
    public $image;
    public $active;
    public $position;
    public $width;
    public $height;
    public $hotsposts;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'novlookbook_slides',
        'primary' => 'id_novlookbook_slides',
        'multilang' => true,
        'fields' => array(
            'active'        =>          array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'position'      =>          array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'image'         =>          array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
            'width'         =>          array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'height'        =>          array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'hotsposts'     =>      array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 4000),
            // Lang fields
            'description'   =>          array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 4000),
            'title'         =>          array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
        )
    );

    public function __construct($id_slide = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_slide, $id_lang, $id_shop);
    }

    public function add($autodate = true, $null_values = false)
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $res = parent::add($autodate, $null_values);
        $res &= Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'novlookbook` (`id_shop`, `id_novlookbook_slides`) VALUES('.(int)$id_shop.', '.(int)$this->id.')');
        return $res;
    }

    public function delete()
    {
        $res = true;
        $images = $this->image;
        foreach ($images as $image) {
            if (preg_match('/sample/', $image) === 0) {
                if ($image && file_exists(dirname(__FILE__).'/views/img/'.$image)) {
                    $res &= @unlink(dirname(__FILE__).'/views/img/'.$image);
                }
            }
        }
        $res &= $this->reOrderPositions();
        $res &= Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'novlookbook` WHERE `id_novlookbook_slides` = '.(int)$this->id);
        $res &= parent::delete();
        return $res;
    }

    public function reOrderPositions()
    {
        $id_slide = $this->id;
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $max = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT MAX(hss.`position`) as position FROM `'._DB_PREFIX_.'novlookbook_slides` hss, `'._DB_PREFIX_.'novlookbook` hs WHERE hss.`id_novlookbook_slides` = hs.`id_novlookbook_slides` AND hs.`id_shop` = '.(int)$id_shop);
        if ((int)$max == (int)$id_slide) {
            return true;
        }
        $rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT hss.`position` as position, hss.`id_novlookbook_slides` as id_slide FROM `'._DB_PREFIX_.'novlookbook_slides` hss LEFT JOIN `'._DB_PREFIX_.'novlookbook` hs ON (hss.`id_novlookbook_slides` = hs.`id_novlookbook_slides`) WHERE hs.`id_shop` = '.(int)$id_shop.' AND hss.`position` > '.(int)$this->position);
        foreach ($rows as $row) {
            $current_slide = new LookBook($row['id_slide']);
            --$current_slide->position;
            $current_slide->update();
            unset($current_slide);
        }

        return true;
    }
}
