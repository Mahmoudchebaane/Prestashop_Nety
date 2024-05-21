{*
/******************
 * Vinova Themes  Framework for Prestashop 1.7.x
 * @package   	novblockwishlist
 * @version   	1.0
 * @author   	http://vinovathemes.com/
 * @copyright 	Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/
*}

<a class="addToWishlist" href="#" data-rel="{$product.id_product|intval}" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', false, 1, '', '{$product.name}', '{$product.url}', '{$product.cover.bySize.cart_default.url}'); return false;">
	<i class="zmdi zmdi-favorite-outline"></i>
	<span>{l s="Add to Wishlist" mod='novblockwishlist'}</span>
</a>