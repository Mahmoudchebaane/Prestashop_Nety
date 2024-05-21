<?php
/******************

 * Vinova Themes  Framework for Prestashop 1.7.x
 * @package   	novblockwishlist
 * @version   	1.0.0
 * @author   	http://vinovathemes.com/
 * @copyright 	Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1

 * *****************/

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/WishList.php');
require_once(dirname(__FILE__).'/novblockwishlist.php');

$context = Context::getContext();
$action = Tools::getValue('action');
$add = (!strcmp($action, 'add') ? 1 : 0);
$delete = (!strcmp($action, 'delete') ? 1 : 0);
$id_wishlist = (int)Tools::getValue('id_wishlist');
$id_product = (int)Tools::getValue('id_product');
$quantity = (int)Tools::getValue('quantity');
$id_product_attribute = (int)Tools::getValue('id_product_attribute');

// Instance of module class for translations
$module = new NovBlockWishList();

if (Configuration::get('PS_TOKEN_ENABLE') == 1 &&
	strcmp(Tools::getToken(false), Tools::getValue('token')) &&
	$context->customer->isLogged() === true
)
	echo $module->l('Invalid token', 'cart');
if ($context->customer->isLogged())
{
	if ($id_wishlist && WishList::exists($id_wishlist, $context->customer->id) === true)
		$context->cookie->id_wishlist = (int)$id_wishlist;

	if ((int)$context->cookie->id_wishlist > 0 && !WishList::exists($context->cookie->id_wishlist, $context->customer->id))
		$context->cookie->id_wishlist = '';

	if (empty($context->cookie->id_wishlist) === true || $context->cookie->id_wishlist == false)
		$context->smarty->assign('error', true);

	if (($add || $delete) && empty($id_product) === false)
	{
		if (!isset($context->cookie->id_wishlist) || $context->cookie->id_wishlist == '')
		{
			$wishlist = new WishList();
			$wishlist->id_shop = $context->shop->id;
			$wishlist->id_shop_group = $context->shop->id_shop_group;
			$wishlist->default = 1;

			$wishlist->name = $module->default_wishlist_name;
			$wishlist->id_customer = (int)$context->customer->id;
			list($us, $s) = explode(' ', microtime());
			srand($s * $us);
			$wishlist->token = strtoupper(substr(sha1(uniqid(rand(), true)._COOKIE_KEY_.$context->customer->id), 0, 16));
			$wishlist->add();
		}

		if ($add && $quantity)
			WishList::addProduct($context->customer->id, $id_product, $id_product_attribute, $quantity);
		else if ($delete)
			WishList::removeProduct($context->cookie->id_wishlist, $context->customer->id, $id_product, $id_product_attribute);
	}
	die($module->l('Added Sucess.', 'cart'));
	//$context->smarty->assign('products', WishList::getProductByIdCustomer($context->cookie->id_wishlist, $context->customer->id, $context->language->id, null, true));
	//$context->smarty->display(dirname(__FILE__).'/novblockwishlist-ajax.tpl');

} else
	echo $module->l('You must be logged in to manage your wishlist.', 'cart');
