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

<div id="wishlist_block" class="block account">
	<h4 class="title_block">
		<a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|addslashes}" title="{l s='My wishlists' mod='novblockwishlist'}" >{l s='Wishlist' mod='novblockwishlist'}</a>
	</h4>
	<div class="block_content">
		<div id="wishlist_block_list" class="expanded">
		{if $wishlist_products}
			<dl class="products">
			{foreach from=$wishlist_products item=product name=i}
				<dt class="{if $smarty.foreach.i.first}first_item{elseif $smarty.foreach.i.last}last_item{else}item{/if}">
					<span class="quantity-formated"><span class="quantity">{$product.quantity|intval}</span>x</span>
					<a class="cart_block_product_name"
					href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}" title="{$product.name|escape:'html':'UTF-8'}">{$product.name|truncate:30:'...'|escape:'html':'UTF-8'}</a>
					<a class="ajax_cart_block_remove_link" href="javascript:;" onclick="javascript:WishlistCart('wishlist_block_list', 'delete', '{$product.id_product}', {$product.id_product_attribute}, '0', '{if isset($token)}{$token}{/if}');" title="{l s='remove this product from my wishlist' mod='novblockwishlist'}" ><img src="{$img_dir}icon/delete.gif" width="12" height="12" alt="{l s='Delete'}" class="icon" /></a>
				</dt>
				{if isset($product.attributes_small)}
				<dd class="{if $smarty.foreach.i.first}first_item{elseif $smarty.foreach.i.last}last_item{else}item{/if}">
					<a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}" title="{l s='Product detail'}">{$product.attributes_small|escape:'html':'UTF-8'}</a>
				</dd>
				{/if}
			{/foreach}
			</dl>
		{else}
			<dl class="products">
				<dt>{l s='No products' mod='novblockwishlist'}</dt>
			</dl>
		{/if}
		</div>
		<p class="lnk">
		{if $wishlists}
			<select name="wishlists" id="wishlists" onchange="WishlistChangeDefault('wishlist_block_list', $('#wishlists').val());">
			{foreach from=$wishlists item=wishlist name=i}
				<option value="{$wishlist.id_wishlist}"{if $id_wishlist eq $wishlist.id_wishlist or ($id_wishlist == false and $smarty.foreach.i.first)} selected="selected"{/if}>{$wishlist.name|truncate:22:'...'|escape:'html':'UTF-8'}</option>
			{/foreach}
			</select>
		{/if}
			<a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|addslashes}" title="{l s='My wishlists' mod='novblockwishlist'}" >&raquo; {l s='My wishlists' mod='novblockwishlist'}</a>
		</p>
	</div>
</div>
