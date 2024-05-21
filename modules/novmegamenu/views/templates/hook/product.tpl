{if !empty($products)}
{assign var='itempage' value=3}
{assign var='count' value=0}
<div class="block_content">
	{$novproduct=array_chunk($products,$itempage)}
	{foreach from=$novproduct item=products name=mypLoop}
		{if $count < 3}
		<div class="products_block row">
			{foreach from=$products item=product name=products}
				{$count = $count + 1}
				<div class="product-miniature js-product-miniature col item {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product" >
				    <div class="thumbnail-container" itemprop="image">
				      {block name='product_thumbnail'}
				        <a href="{$product.url}" class="thumbnail product-thumbnail">
				          <img
				            class="img-fluid"
				            src = "{$product.cover.bySize.home_default.url}"
				            alt = "{$product.cover.legend}"
				            data-full-size-image-url = "{$product.cover.large.url}"
				          >
				        </a>
				      {/block}
				      <a href="#" class="quick-view hidden-sm-down" data-link-action="quickview">
				        <i class="fa fa-search"></i>{* {l s='Quick view' mod='novmegamenu'} *}
				      </a>
				      {* Label *}
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

				    </div>

				    <div class="product-description">
				      {block name='product_name'}
				        <div class="product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></div>
				      {/block}
				      <div class="product-groups">
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
				          {*
				          <div class="highlighted-informations{if !$product.main_variants} no-variants{/if} hidden-sm-down">
				            {block name='product_variants'}
				              {if $product.main_variants}
				                {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
				              {/if}
				            {/block}
				          </div>
				          *}
				        </div>
				        <div class="product-buttons">
				          <a class="add-to-cart" href="#"><i class="fa fa-shopping-cart"></i>{l s='Add to cart' mod='novmegamenu'}</a>
				        </div>
				        
				      </div>

				    </div>		    
				</div>
			{/foreach}
		</div>	
		{/if}
	{/foreach}
</div>
{/if}