{*
 *  Tous droits réservés NDKDESIGN
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2014 Hendrik Masson
 *  @license   Tous droits réservés
*}
{if isset($products) && $products}
	<dl class="products col-md-2">
		{foreach from=$products item='product' name='myLoop'}
			{assign var='productId' value=$product.id_product}
			{assign var='productAttributeId' value=$product.id_product_attribute}
			
			<dt data-id="cart_block_product_{$product.id_product|intval}_{if $product.id_product_attribute}{$product.id_product_attribute|intval}{else}0{/if}_{if $product.id_address_delivery}{$product.id_address_delivery|intval}{else}0{/if}" class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
				<img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'cart_default')}" alt="{$product.name|escape:'html':'UTF-8'}" />
				<div class="cart-info">
					<div class="product-name">
						<span class="quantity-formated"><span class="quantity">{$product.cart_quantity|escape:'htmlall':'UTF-8'}</span>&nbsp;x&nbsp;</span>{$product.name|escape:'html':'UTF-8'}
					</div>
					{if isset($product.attributes_small)}
						<div class="product-atributes">
							{$product.attributes_small|escape:'htmlall':'UTF-8'}
						</div>
					{/if}
					<span class="price">
						{if !isset($product.is_gift) || !$product.is_gift}
							{if $priceDisplay == $smarty.const.PS_TAX_EXC}{displayWtPrice p="`$product.total`"}{else}{displayWtPrice p="`$product.total_wt`"}{/if}
						{else}
							{l s='Free!' mod='ndksteppingpack'}
						{/if}
					</span>
				</div>
				<span class="remove_link">
					{if !isset($customizedDatas.$productId.$productAttributeId) && (!isset($product.is_gift) || !$product.is_gift)}
						<a href="#" onclick="removeFromCart($(this), event);" class="ajax-del-resume" data-id_product="{$product.id_product|intval}" data-id_product_attribute="{$product.id_product_attribute|intval}" data-id_address_delivery="{$product.id_address_delivery|intval}"  data-id_customization=""><i class="icon-trash"></i>{l s='remove' mod='ndksteppingpack'}</a>
					{/if}
				</span>
			</dt>
			{if isset($product.attributes_small)}
				<dd data-id="cart_block_combination_of_{$product.id_product|intval}{if $product.id_product_attribute}_{$product.id_product_attribute|intval}{/if}_{$product.id_address_delivery|intval}" class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
			{/if}
			<!-- Customizable datas -->
			{if isset($customizedDatas.$productId.$productAttributeId[$product.id_address_delivery])}
				{if !isset($product.attributes_small)}
					<dd data-id="cart_block_combination_of_{$product.id_product|intval}_{if $product.id_product_attribute}{$product.id_product_attribute|intval}{else}0{/if}_{if $product.id_address_delivery}{$product.id_address_delivery|intval}{else}0{/if}" class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
				{/if}
				<ul class="cart_block_customizations" data-id="customization_{$productId}_{$productAttributeId}">
					{foreach from=$customizedDatas.$productId.$productAttributeId[$product.id_address_delivery] key='id_customization' item='customization' name='customizations'}
						<li name="customization">
							<div data-id="deleteCustomizableProduct_{$id_customization|intval}_{$product.id_product|intval}_{$product.id_product_attribute|intval}_{$product.id_address_delivery|intval}" class="deleteCustomizableProduct">
								<a onclick="removeFromCart($(this), event);" href="#" class="ajax-del-resume" data-id_product="{$product.id_product|intval}" data-id_product_attribute="{$product.id_product_attribute|intval}" data-id_address_delivery="{$product.id_address_delivery|intval}" data-id_customization="{$id_customization|intval}"><i class="icon-trash"></i>{l s='remove' mod='ndksteppingpack'}</a>
							</div>
							{if isset($customization.datas.$CUSTOMIZE_TEXTFIELD.0)}
								{$customization.datas.$CUSTOMIZE_TEXTFIELD.0.value|replace:"<br />":" "|truncate:28:'...'|escape:'html':'UTF-8'}
							{else}
								{l s='Customization #%d:' sprintf=$id_customization|intval mod='ndksteppingpack'}
							{/if}
						</li>
					{/foreach}
				</ul>
				{if !isset($product.attributes_small)}</dd>{/if}
			{/if}
			{if isset($product.attributes_small)}</dd>{/if}
		{/foreach}
	</dl>
{/if}
