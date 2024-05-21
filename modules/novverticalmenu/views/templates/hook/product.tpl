{if !empty($products)}
{assign var='itempage' value=3}
{assign var='count' value=0}
<div class="block_content">
	{$novproduct=array_chunk($products,$itempage)}
		{foreach from=$novproduct item=products name=mypLoop}
			{if $count < 3}
			<ul class="products_block row">
				{foreach from=$products item=product name=products}
					
						{$count = $count + 1}
							<li class="col-xs-12 col-sm-6 col-md-{12/$itempage} col-lg-{12/$itempage} {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}">
								<div class="ajax_block_product product_block">
								<div class="product-container" itemscope itemtype="http://schema.org/Product">
									<div class="left-block">
										<div class="product-image-container">
										{block name='product_thumbnail'}
										  <a href="{$product.link}" class="thumbnail product-thumbnail">
											<img
											  src = "{$product.cover.bySize.home_default.url}"
											  alt = "{$product.cover.legend}"
											  data-full-size-image-url = "{$product.cover.large.url}"
											>
										  </a>
										{/block}
										</div>
									</div>
									<div class="right-block ">
										<h5 itemprop="name">
										  {block name='product_name'}
											<h1 class="h3 product-title" itemprop="name"><a href="{$product.link}">{$product.name|truncate:30:'...'}</a></h1>
										  {/block}
										</h5>
										<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price">
										  {block name='product_price_and_shipping'}
											<div class="product-price-and-shipping">
											  {if $product.has_discount}
												{hook h='displayProductPriceBlock' product=$product type="old_price"}

												<span class="regular-price">{$product.regular_price}</span>
												{if $product.discount_type === 'percentage'}
												  <span class="discount-percentage">{$product.discount_percentage}</span>
												{/if}
											  {/if}

											  {hook h='displayProductPriceBlock' product=$product type="before_price"}

											  <span itemprop="price" class="price">{$product.price}</span>

											  {hook h='displayProductPriceBlock' product=$product type='unit_price'}

											  {hook h='displayProductPriceBlock' product=$product type='weight'}
											</div>
										  {/block}
										</div>
									</div>
								</div><!-- .product-container> -->
								</div>
							</li>
				{/foreach}
			</ul>	
			{/if}
		{/foreach}
</div>
{/if}