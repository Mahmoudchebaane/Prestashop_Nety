{foreach from=$products item=product name=products}
<div class="item {$class_item}">
	<div class="product-miniature js-product-miniature item-seven" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
		<div class="thumbnail-container" itemprop="image">
			{block name='product_thumbnail'}
			{if isset($novconfig.novthemeconfig_second_img) && $novconfig.novthemeconfig_second_img == 1}
			{if (count($product.images) > 1) && $product.cover}
			<a href="{$product.url}" class="thumbnail product-thumbnail two-image">
				<img
				class="img-fluid image-cover nov-lazyload"
				data-src="{$product.cover.bySize.home_default.url}"
				src="{$product.cover.bySize.home_default.url}"
				alt="{$product.cover.legend}"
				width="{$product.cover.bySize.home_default.width}px"
				height="{$product.cover.bySize.home_default.height}px"
				>
				{foreach from=$product.images item=image}
				{if $image.cover != '1'}
				<img 
				class="img-fluid image-secondary nov-lazyload"
				src = "{$image.bySize.home_default.url}"
				alt = "{$product.cover.legend}"
				data-full-size-image-url = "{$image.large.url}"
				width="{$product.cover.bySize.home_default.width}"
				height="{$product.cover.bySize.home_default.height}"
				>
				{break}
				{/if}
				{/foreach}
			</a>
			{elseif (count($product.images) == 1) && $product.cover}
			<a href="{$product.url}" class="thumbnail product-thumbnail one-image">
				<img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.home_default.url}" src="{$product.cover.bySize.home_default.url}" alt="{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
			</a>
			{else}
			<a href="{$product.url}" class="thumbnail product-thumbnail one-image">
				<img class="img-fluid image-cover nov-lazyload" data-src="{$urls.no_picture_image.bySize.home_default.url}" src="{$urls.no_picture_image.bySize.home_default.url}" alt="{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
			</a>
			{/if}
			
			{else}
			{if (count($product.images) >= 1) && $product.cover}
			<a href="{$product.url}" class="thumbnail product-thumbnail one-image">
				<img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.home_default.url}" src="{$product.cover.bySize.home_default.url}" alt="{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
			</a>
			{else}
			<a href="{$product.url}" class="thumbnail product-thumbnail one-image">
				<img class="img-fluid image-cover nov-lazyload" data-src="{$urls.no_picture_image.bySize.home_default.url}" src="{$urls.no_picture_image.bySize.home_default.url}" alt="{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
			</a>
			{/if}
			{/if}
			{/block}
			{if isset($novconfig.novthemeconfig_cat_product_label) && $novconfig.novthemeconfig_cat_product_label == 1 }
			{block name='product_flags'}
			{foreach from=$product.flags item=flag}
				{if $flag.type == 'discount'}
					{if ($product.has_discount && $product.discount_type === 'percentage') }
						<div class="product-flags {$flag.type}">{$product.discount_percentage}</div>
					{else}
						<div class="product-flags {$flag.type}">{$flag.label}</div>
					{/if}
				{else}
					<div class="product-flags {$flag.type}">{$flag.label}</div>
				{/if}
			{/foreach}
			{/block}
			{/if}
		</div>
		<div class="product-description d-flex align-items-center justify-content-center">
			<div>
				{block name='product_name'}
					<div class="product-title mb-15 mb-sm-10" itemprop="name"><a href="{$product.url}">{$product.name}</a></div>
				{/block}
				{if isset($novconfig.novthemeconfig_cat_product_rate) && $novconfig.novthemeconfig_cat_product_rate == 1 }
					{hook h='displayProductListReviews' product=$product}
				{/if}
				<div class="product-groups" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<div class="product-group-price mb-25 mb-sm-15">
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
					<div class="info-stock">
						{if $product.availability == 'available'}
						<i class="fa fa-check-square-o"></i>
						{elseif $product.availability == 'last_remaining_items'}
						<i class="fa fa-exclamation-triangle product-last-items"></i>
						{else}
						<i class="fa fa-exclamation-triangle"></i>
						{/if}
						{$product.availability_message}
					</div>
					<div class="product-desc" itemprop="desciption">{$product.description_short|strip_tags|truncate:280 nofilter}</div>

					{assign var="link" value = Context::getContext()->link }
					{assign var="static_token" value = Tools::getToken(false)}
					<div class="product-buttons">
						{if isset($novconfig.novthemeconfig_cat_product_addtocart) && $novconfig.novthemeconfig_cat_product_addtocart == 1 }
							{if $product.quantity > 0}
								{if $product.id_product_attribute != 0 }
									<a class="add-to-cart" href="{$product.url}"><i class="zmdi zmdi-check"></i><span>{l s='Select Options' d='Shop.Theme.Actions'}</span></a>
								{else}
									<form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
										<input type="hidden" name="token" value="{$static_token}">
										<input type="hidden" name="id_product" value="{$product.id}">
										<input type="hidden" name="qty" value="{$product.minimal_quantity}">
										<button class="add-to-cart show_popup btn" href="#" data-button-action="add-to-cart">
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
									<button class="btn btn-link add-to-cart show_popup" href="#" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url} disabled {/if}>
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