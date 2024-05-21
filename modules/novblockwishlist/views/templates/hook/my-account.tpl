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

<div class="link_wishlist">
	<a{if $page.page_name == 'module-novblockwishlist-mywishlist'} class="active"{/if} href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="{l s='My Wishlists' mod='novblockwishlist'}">
		<i class="fa fa-heart"></i><span>{l s='My Wishlists' mod='novblockwishlist'}</span>
	</a>
</div>
