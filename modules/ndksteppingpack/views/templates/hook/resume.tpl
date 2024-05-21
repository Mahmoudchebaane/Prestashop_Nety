{*
*  Tous droits réservés NDKDESIGN
*
*  @author    Hendrik Masson <postmaster@ndk-design.fr>
*  @copyright Copyright 2013 - 2017 Hendrik Masson
*  @license   Tous droits réservés
*}

{if isset($products) && $products}
	
		{foreach from=$products item='product' name='myLoop'}
			{assign var='productId' value=$product.id_product}
			{assign var='productAttributeId' value=$product.id_product_attribute}
			
			<div data-id="cart_block_product_{$product.id_product|intval}_{if $product.id_product_attribute}{$product.id_product_attribute|intval}{else}0{/if}_{if $product.id_address_delivery}{$product.id_address_delivery|intval}{else}0{/if}" class="timeline-product-item {if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} clearfix">
				<div class="container_block">
					<img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'medium_default')}" alt="{$product.name|escape:'html':'UTF-8'}" class="col-xs-12 pack-content-img"/>
					<div class="cart-info col-xs-12 ">
						<div class="product-name">
							<span class="quantity-formated"><span class="quantity">{$product.cart_quantity|escape:'htmlall':'UTF-8'}</span>&nbsp;x&nbsp;</span>{$product.name|escape:'html':'UTF-8'}
						</div>
						{if isset($product.attributes_small)}
							<div class="product-atributes">
								{$product.attributes_small|escape:'htmlall':'UTF-8'}
							</div>
						{/if}
						
						
					</div>
					<span class="remove_link clearfix">
						{if !isset($customizedDatas.$productId.$productAttributeId) && (!isset($product.is_gift) || !$product.is_gift)}
							<a href="#"  class="ajax-del-resume" data-id_product="{$product.id_product|intval}" data-id_product_attribute="{$product.id_product_attribute|intval}" data-id_address_delivery="{$product.id_address_delivery|intval}"  data-id_customization="" data-qtty="{$product.cart_quantity}"><i class="material-icons">delete</i><span class="hidden">{l s='remove' mod='ndksteppingpack'}</span></a>
						{/if}
					</span>
					
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
										<span class="remove_link clearfix">
										<a  href="#" class="ajax-del-resume" data-id_product="{$product.id_product|intval}" data-id_product_attribute="{$product.id_product_attribute|intval}" data-id_address_delivery="{$product.id_address_delivery|intval}" data-id_customization="{$id_customization|intval}"><i class="icon-trash"></i><span class="hidden">{l s='remove' mod='ndksteppingpack'}</span></a>
										</span>
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
				</div>
			</div>
			
		{/foreach}
{/if}
