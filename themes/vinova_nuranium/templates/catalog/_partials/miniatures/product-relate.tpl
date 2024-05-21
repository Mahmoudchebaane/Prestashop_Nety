{**
 * 2007-2016 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
  <div class="thumbnail-container" itemprop="image">
    {block name='product_thumbnail'}
    {if isset($novconfig.novthemeconfig_second_img) && $novconfig.novthemeconfig_second_img == 1}
    {if (count($product.images) > 1) && $product.cover}
    <a href="{$product.url}" class="thumbnail product-thumbnail two-image">
      <img
      class="img-fluid image-cover nov-lazyload"
      data-src="{$product.cover.bySize.home_default.url}"
      src="{$product.cover.bySize.home_default.url}"
      alt="thumbnail-{$product.cover.legend}"
      width="{$product.cover.bySize.home_default.width}px"
      height="{$product.cover.bySize.home_default.height}px"
      >
      {foreach from=$product.images item=image}
      {if $image.cover != '1'}
      <img 
      class="img-fluid image-secondary nov-lazyload"
      src = "{$image.bySize.home_default.url}"
      alt = "thumbnail-{$product.cover.legend}"
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
      <img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.home_default.url}" src="{$product.cover.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
    </a>
    {else}
    <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
      <img class="img-fluid image-cover nov-lazyload" data-src="{$urls.no_picture_image.bySize.home_default.url}" src="{$urls.no_picture_image.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
    </a>
    {/if}
    
    {else}
    {if (count($product.images) >= 1) && $product.cover}
    <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
      <img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.home_default.url}" src="{$product.cover.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
    </a>
    {else}
    <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
      <img class="img-fluid image-cover nov-lazyload" data-src="{$urls.no_picture_image.bySize.home_default.url}" src="{$urls.no_picture_image.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
    </a>
    {/if}
    {/if}
    {/block}
    <a href="#" class="quick-view hidden-sm-down" data-link-action="quickview">
      <i class="zmdi zmdi-search"></i>
    </a>
    {* Label *}
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

  <div class="product-description">
    {block name='product_name'}
      <div class="product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></div>
    {/block}
    <div class="product-groups">
      {if isset($novconfig.novthemeconfig_cat_product_rate) && $novconfig.novthemeconfig_cat_product_rate == 1 }
					{hook h='displayProductListReviews' product=$product}
				{/if}
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
        <button class="add-to-cart" href="#" data-button-action="add-to-cart"{if !$product.add_to_cart_url || $product.minimal_quantity > $product.quantity} disabled{/if}>
          <i class="novicon-cart"></i>
          <span>{l s='Add to cart'}</span>
        </button>
      </div>
      
    </div>
  </div>
</article>