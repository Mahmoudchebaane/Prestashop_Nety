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

/* SSL Managemen't */
$useSSL = true;

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/WishList.php');
require_once(dirname(__FILE__).'/novblockwishlist.php');
$context = Context::getContext();
if ($context->customer->isLogged())
{
	$action = Tools::getValue('action');
	$id_wishlist = (int)Tools::getValue('id_wishlist');
	$id_product = (int)Tools::getValue('id_product');
	$id_product_attribute = (int)Tools::getValue('id_product_attribute');
	$quantity = (int)Tools::getValue('quantity');
	$priority = Tools::getValue('priority');
	$wishlist = new WishList((int)($id_wishlist));
	if (!strcmp($action, 'update'))
	{
		WishList::updateProduct($id_wishlist, $id_product, $id_product_attribute, $priority, $quantity);
	}
	else
	{
		if (!strcmp($action, 'delete'))
			WishList::removeProduct((int)$context->customer->id, $id_product, $id_product_attribute);

		$products = WishList::getProductByIdCustomer($context->customer->id, $context->language->id);

		for ($i = 0; $i < sizeof($products); ++$i)
		{
			$obj = new Product((int)($products[$i]['id_product']), false, $context->language->id);
			if (!Validate::isLoadedObject($obj))
				continue;
			else
			{
				if ($products[$i]['id_product_attribute'] != 0)
				{
					$combination_imgs = $obj->getCombinationImages($context->language->id);
					if (isset($combination_imgs[$products[$i]['id_product_attribute']][0]))
						$products[$i]['cover'] = $obj->id.'-'.$combination_imgs[$products[$i]['id_product_attribute']][0]['id_image'];
					else
					{
						$cover = Product::getCover($obj->id);
						$products[$i]['cover'] = $obj->id.'-'.$cover['id_image'];
					}
				}
				else
				{
					$images = $obj->getImages($context->language->id);
					foreach ($images AS $k => $image)
						if ($image['cover'])
						{
							$products[$i]['cover'] = $obj->id.'-'.$image['id_image'];
							break;
						}
				}
				if (!isset($products[$i]['cover']))
					$products[$i]['cover'] = $context->language->iso_code.'-default';
			}
		}

		$context->smarty->assign(array(
			'link' => $context->link,
			'products' => $products,
			'token_wish' => $wishlist->token,
			'wishlists' => WishList::getByIdCustomer($cookie->id_customer)
		));

		// Instance of module class for translations
		$module = new NovBlockWishList();

		if (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/novblockwishlist/views/templates/front/managewishlist.tpl'))
			$context->smarty->display(_PS_THEME_DIR_.'modules/novblockwishlist/views/templates/front/managewishlist.tpl');
		elseif (Tools::file_exists_cache(dirname(__FILE__).'/views/templates/front/managewishlist.tpl'))
			$context->smarty->display(dirname(__FILE__).'/views/templates/front/managewishlist.tpl');
		elseif (Tools::file_exists_cache(dirname(__FILE__).'/managewishlist.tpl'))
			$context->smarty->display(dirname(__FILE__).'/managewishlist.tpl');
		else
			echo $module->l('No template found', 'managewishlist');
	}
}

