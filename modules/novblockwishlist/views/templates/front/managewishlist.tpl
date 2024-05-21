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

{if $products}
	<div class="wlp_bought">
		<div class="clearfix row wlp_bought_list">
		{foreach from=$products item=product name=i}
			<div id="wlp_{$product.id_product}_{$product.id_product_attribute}" class="col-md-3 col-sm-4 col-xs-6 address {if $smarty.foreach.i.index % 2}alternate_{/if}item">
				<a href="javascript:;" class="lnkdel" onclick="WishlistProductManage('wlp_bought', 'delete', '{$product.id_product}', '{$product.id_product_attribute}', $('#quantity_{$product.id_product}_{$product.id_product_attribute}').val(), $('#priority_{$product.id_product}_{$product.id_product_attribute}').val());" title="{l s='Delete' mod='novblockwishlist'}"><i class="material-icons close">close</i></a>
				<div class="clearfix">
					<div class="product_image">
						<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}" title="{l s='Product detail' mod='novblockwishlist'}">
							<img class="img-fluid" src="{$link->getImageLink($product.link_rewrite, $product.cover, 'medium_default')|escape:'html'}" alt="{$product.name|escape:'html':'UTF-8'}" />
						</a>
					</div>
					<div class="product_infos">
						<div id="s_title" class="product_name"><a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}">{$product.name|escape:'html':'UTF-8'}</a></div>
					</div>
				</div>
			</div>
		{/foreach}
		</div>
	</div>
{else}
	<p class="warning">{l s='No products' mod='novblockwishlist'}</p>
{/if}
