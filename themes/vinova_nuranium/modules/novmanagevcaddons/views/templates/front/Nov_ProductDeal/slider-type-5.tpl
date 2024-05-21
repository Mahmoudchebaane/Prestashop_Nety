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

{if isset($products)}
<div class="nov-productdeals type-slider-5{if isset($el_class) && $el_class}{$el_class}{/if}">
	<div class="block-product clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			<span class="title_content">{$title}</span>
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content">
			<div class="nov-productslick product_list slick-slider" data-rows="{$number_row}" data-xl="{$xl}" data-lg="{$lg}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
				{foreach from=$products item=product name=products}
					<div class="item">
						<div class="product-miniature js-product-miniature pt-10 pb-10 row {if $smarty.foreach.products.first} first_item{elseif $smarty.foreach.products.last} last_item{/if}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
							<div class="thumbnail-container col-md-6">
								{block name='product_thumbnail'}
									{if isset($novconfig.novthemeconfig_second_img) && $novconfig.novthemeconfig_second_img == 1 && (count($product.images) > 1)}
										<a href="{$product.url}" class="thumbnail product-thumbnail two-image">
											<img
											class="img-fluid image-cover nov-lazyload"
											data-src="{$product.cover.bySize.large_default.url}"
											src="{$product.cover.bySize.large_default.url}"
											alt="{$product.cover.legend}"
											width="{$product.cover.bySize.large_default.width}px"
											height="{$product.cover.bySize.large_default.height}px"
											>
											{foreach from=$product.images item=image}
											{if $image.cover != '1'}
											<img 
											class="img-fluid image-secondary nov-lazyload"
											src = "{$image.bySize.large_default.url}"
											alt = "{$product.cover.legend}"
											data-full-size-image-url = "{$image.large.url}"
											width="{$product.cover.bySize.large_default.width}"
											height="{$product.cover.bySize.large_default.height}"
											>
											{break}
											{/if}
											{/foreach}
										</a>
									{else}
										<a href="{$product.url}" class="thumbnail product-thumbnail one-image">
											<img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.large_default.url}" src="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}" width="{$product.cover.bySize.large_default.width}px" height="{$product.cover.bySize.large_default.height}px">
										</a>
									{/if}
								{/block}
							</div>
							<div class="product-description col-md-6">
								<div class="block_description pl-xs-0">
									{hook h='countdownProduct' product=$product}
									{block name='product_name'}
										<div class="product-title" itemprop="name"><a href="{$product.url}">{$product.name}</a></div>
									{/block}	
									{if isset($novconfig.novthemeconfig_cat_product_rate) && $novconfig.novthemeconfig_cat_product_rate == 1 }
										{hook h='displayProductListReviews' product=$product}
									{/if}
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

												{/if}
												{hook h='displayProductPriceBlock' product=$product type='unit_price'}
												{hook h='displayProductPriceBlock' product=$product type='weight'}
											</div>
											{/if}
											{/block}
										</div>
										<div class="product-desc" itemprop="desciption">{$product.description_short|strip_tags|truncate:190 nofilter}</div>

										{assign var="link" value = Context::getContext()->link }
										{assign var="static_token" value = Tools::getToken(false)}
										<div class="product-buttons">
											{if isset($novconfig.novthemeconfig_cat_product_addtocart) && $novconfig.novthemeconfig_cat_product_addtocart == 1 }
												{if $product.quantity > 0}
													{if $product.id_product_attribute != 0 }
														<a class="add-to-cart has-text" href="{$product.url}"><i class="zmdi zmdi-check"></i><span>{l s='Select Options' d='Shop.Theme.Actions'}</span></a>
													{else}
														<form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
															<input type="hidden" name="token" value="{$static_token}">
															<input type="hidden" name="id_product" value="{$product.id}">
															<input type="hidden" name="qty" value="{$product.minimal_quantity}">
															<button class="btn add-to-cart show_popup has-text align-self-center" href="#" data-button-action="add-to-cart">
																<span class="loading"><i class="fa fa-spinner fa-spin"></i></span>
																<i class="novicon-cart"></i><span>{l s='Add to cart' d='Shop.Theme.Actions'}</span>
															</button>
														</form>
													{/if}
												{else}
													<form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
														<input type="hidden" name="token" value="{$static_token}">
														<input type="hidden" name="id_product" value="{$product.id}">
														<input type="hidden" name="qty" value="{$product.minimal_quantity}">
														<button class="btn add-to-cart show_popup" href="#" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url} disabled {/if}>
															<span class="loading"><i class="fa fa-spinner fa-spin"></i></span>
															<i class="novicon-cart mr-0"></i><span>{if !$product.add_to_cart_url} {l s='Out of Stock' d='Shop.Theme.Actions'}{else}{l s='Add to cart' d='Shop.Theme.Actions'}{/if}</span>
														</button>
													</form>
												{/if}
											{/if}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				{/foreach}
			</div>
		</div>
	</div>
</div>
{/if}