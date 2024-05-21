<?php
/******************
 * Vinova Themes  Framework for Prestashop 1.7.x 
 * @package    novtestimonials
 * @version    1.0
 * @author    http://vinovathemes.com/
 * @copyright  Copyright (C) May 2017 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/

class Testimonials extends ObjectModel
{

	public $content;
	public $url;
	public $html;
	public $image;
	public $company;
	public $name;
	public $email;
	public $address;
	public $active;
	public $position;
	public $id_shop;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'novtestimonials',
		'primary' => 'id_novtestimonials',
		'multilang' => true,
		'fields' => array(
			'active' =>			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'position' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
			'company' =>		array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
			'name' =>			array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
			'email' =>			array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'size' => 255),
			'address' =>			array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),

			// Lang fields
			'content' =>	array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 4000),
			'html' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
			'url' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => false, 'size' => 255),
			'image' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
		)
	);

	public	function __construct($id_novtestimonials = null, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_novtestimonials, $id_lang, $id_shop);
	}

	public function add($autodate = true, $null_values = false)
	{
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$res = parent::add($autodate, $null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'novtestimonials_shop` (`id_shop`, `id_novtestimonials`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		return $res;
	}

	public function delete()
	{
		$res = true;

		$images = $this->image;
		foreach ($images as $image)
		{
			if (preg_match('/sample/', $image) === 0)
				if ($image && file_exists(dirname(__FILE__).'/images/'.$image))
					$res &= @unlink(dirname(__FILE__).'/images/'.$image);
		}

		$res &= $this->reOrderPositions();

		$res &= Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'novtestimonials`
			WHERE `id_novtestimonials` = '.(int)$this->id
		);

		$res &= parent::delete();
		return $res;
	}

	public function reOrderPositions()
	{
		$id_novtestimonials = $this->id;
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$max = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT MAX(hs.`position`) as position
			FROM `'._DB_PREFIX_.'novtestimonials_shop` hss, `'._DB_PREFIX_.'novtestimonials` hs
			WHERE hss.`id_novtestimonials` = hs.`id_novtestimonials` AND hss.`id_shop` = '.(int)$id_shop
		);

		if ((int)$max == (int)$id_novtestimonials)
			return true;

		$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`position` as position, hss.`id_novtestimonials` as id_novtestimonials
			FROM `'._DB_PREFIX_.'novtestimonials_shop` hss
			LEFT JOIN `'._DB_PREFIX_.'novtestimonials` hs ON (hss.`id_novtestimonials` = hs.`id_novtestimonials`)
			WHERE hss.`id_shop` = '.(int)$id_shop.' AND hs.`position` > '.(int)$this->position
		);

		foreach ($rows as $row)
		{
			$current_testimonial = new Testimonials($row['id_novtestimonials']);
			--$current_testimonial->position;
			$current_testimonial->update();
			unset($current_testimonial);
		}

		return true;
	}

	public static function getAssociatedIdsShop($id_novtestimonials)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hss.`id_shop`
			FROM `'._DB_PREFIX_.'novtestimonials_shop` hss
			WHERE hss.`id_novtestimonials` = '.(int)$id_novtestimonials
		);

		if (!is_array($result))
			return false;

		$return = array();

		foreach ($result as $id_shop)
			$return[] = (int)$id_shop['id_shop'];

		return $return;
	}

}
