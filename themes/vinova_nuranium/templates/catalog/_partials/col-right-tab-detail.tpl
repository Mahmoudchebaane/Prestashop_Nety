<div class="block_content">
  {block name='product_accessories'}
    {if $accessories}
      <section class="relate-product product-accessories clearfix pb-30 mb-30">
        <h3 class="h5 title_block">
          <span>{l s='Relate products' d='Shop.Theme.Catalog'}</span>
        </h3>
        <div 
          class="products product_list related-slick-carousel-column"
          data-autoplay="false" 
          data-autoplayTimeout="6000"
          data-loop="false"
          data-items="1"
          data-items_mobile="1"
          data-items_tablet="1"
          data-arrows="true"
          data-dots="false"
          data-rows="4"
        >
          {foreach from=$accessories item=product name=products}
          <div class="item">
            <div class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
              <div class="row m-0">
                <div class="thumbnail-container" itemprop="image">
                  {block name='product_thumbnail'}
                  {if isset($is_category) && !empty($is_category)}
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
                  {/if}
                  {/block}
                </div>
                <div class="product-description">
                  {if isset($novconfig.novthemeconfig_cat_product_rate) && $novconfig.novthemeconfig_cat_product_rate == 1 }
					{hook h='displayProductListReviews' product=$product}
				{/if}
                  {block name='product_name'}
                  <div class="product-title" itemprop="name"><a href="{$product.url}">{$product.name}</a></div>
                  {/block}
                  {block name='product_prices'}
                    {include file='catalog/_partials/product-prices.tpl'}
                  {/block}
                </div>
              </div>
            </div>
          </div>
          {/foreach}
        </div>
      </section>
    {/if}
  {/block}
</div>