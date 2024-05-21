{*
/******************
 * Vinova Themes Framework for Prestashop 1.7.x
 * @package    novmanagevcaddons
 * @version    1.0.0
 * @author     http://vinovathemes.com/
 * @copyright  Copyright (C) May 2019 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <vinovathemes@gmail.com>.All rights reserved.
 * @license    GNU General Public License version 1
 * *****************/
*}

{if isset($products) && $products}
<div class="nov-singleproduct {$display_type}{if isset($el_class) && $el_class} {$el_class}{/if}">
	<div class="block-product clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align}">
			{$title}
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content">
			{foreach from=$products item="product"}
          	<div class="product-miniature js-product-miniature item-one" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
					{hook h='countdownProduct' product=$product}
					<div class="product-groups" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
						<div class="product-group-price">
							{block name='product_price_and_shipping'}
							{if $product.show_price}
							<div class="product-price-and-shipping">
								{hook h='displayProductPriceBlock' product=$product type="before_price"}
								<span itemprop="price" class="price">{$product.price}</span>
								{if $product.has_discount}
								{hook h='displayProductPriceBlock' product=$product type="old_price"}
								<span class="regular-price">{$product.regular_price}</span>
								{*{if $product.discount_type === 'percentage'}
								<span class="discount-percentage">{$product.discount_percentage}</span>
								{/if}*}
								{/if}
								{hook h='displayProductPriceBlock' product=$product type='unit_price'}
								{hook h='displayProductPriceBlock' product=$product type='weight'}
							</div>
							{/if}
							{/block}
						</div>
						{assign var="link" value = Context::getContext()->link }
						{assign var="static_token" value = Tools::getToken(false)}
						<div class="product-buttons">
							{if $product.main_variants}
								<a class="add-to-cart" href="{$product.url}"><i class="zmdi zmdi-check"></i><span>{l s='Select Options' d='Shop.Theme.Actions'}</span></a>
							{else}
								<form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
									<input type="hidden" name="token" value="{$static_token}">
									<input type="hidden" name="id_product" value="{$product.id}">
									<input type="hidden" name="qty" value="{$product.minimal_quantity}">
									<button class="btn add-to-cart show_popup has-text align-self-center" href="#" data-button-action="add-to-cart"><span class="loading"><i class="fa fa-spinner fa-spin"></i></span><i class="novicon-cart"></i><span>{l s='Add to cart' d='Shop.Theme.Actions'}</span></button>
								</form>
							{/if}
						</div>
					</div>
			</div>
            {/foreach}
		</div>
	</div>
</div>
{/if}