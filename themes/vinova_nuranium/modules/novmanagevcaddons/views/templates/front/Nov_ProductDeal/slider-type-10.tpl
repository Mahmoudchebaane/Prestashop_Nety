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
    <div class="nov-productdeals type-slider-10{if isset($el_class) && $el_class}{$el_class}{/if}">
        <div class="block-product clearfix">
            {if isset($title) && !empty($title)}
                <h2 class="title_block text-{$title_align} style-{$title_style} mb-0">
                    <span class="title_content">{$title}</span>
                    {if isset($sub_title) && !empty($sub_title)}
                        <span class="sub_title">{$sub_title}</span>
                    {/if}
                </h2>
            {/if}
            <div class="block_content">
                <div class="nov-productslick product_list slick-slider" data-rows="{$number_row}" data-xl="{$xl}"  data-lg="{$lg}"  data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
                    {foreach from=$products item=product name=products}
                        <div class="item">
                            <div class="product-miniature js-product-miniature row spacing-20" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
                                <div class="thumbnail-container col-lg-6 col-md-5">
                                    {block name='product_thumbnail'}
                                        {if isset($novconfig.novthemeconfig_second_img) && $novconfig.novthemeconfig_second_img == 1 && (count($product.images) > 1)}
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
                                        {else}
                                            <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                                <img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.home_default.url}" src="{$product.cover.bySize.home_default.url}" alt="{$product.cover.legend}" width="{$product.cover.bySize.home_default.width}px" height="{$product.cover.bySize.home_default.height}px">
                                            </a>
                                        {/if}
                                    {/block}
                                </div>
                                <div class="product-description col-lg-6 col-md-7 mt-xs-30">
                                    <div class="block_description pl-xs-0 d-flex flex-column h-100">
                                        <div>
                                            {block name='product_name'}
                                                <div class="product-title" itemprop="name"><a href="{$product.url}">{$product.name}</a></div>
                                                {/block}	
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

                                                            {/if}
                                                            {hook h='displayProductPriceBlock' product=$product type='unit_price'}
                                                            {hook h='displayProductPriceBlock' product=$product type='weight'}
                                                        </div>
                                                    {/if}
                                                {/block}
                                            </div>
                                            <div class="product-groups" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                {assign var="link" value = Context::getContext()->link }
                                                {assign var="static_token" value = Tools::getToken(false)}
                                                <div class="product-buttons d-flex">
                                                    {if isset($novconfig.novthemeconfig_cat_product_addtocart) && $novconfig.novthemeconfig_cat_product_addtocart == 1 }
                                                        {if $product.quantity > 0}
                                                            {if $product.id_product_attribute != 0 }
                                                                <a class="add-to-cart has-text" href="{$product.url}"><i class="zmdi zmdi-check m-0"></i></a>
                                                                {else}
                                                                <form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
                                                                    <input type="hidden" name="token" value="{$static_token}">
                                                                    <input type="hidden" name="id_product" value="{$product.id}">
                                                                    <input type="hidden" name="qty" value="{$product.minimal_quantity}">
                                                                    <button class="btn add-to-cart show_popup has-text align-self-center" href="#" data-button-action="add-to-cart">
                                                                        <span class="loading"><i class="fa fa-spinner fa-spin"></i></span>
                                                                        <i class="novicon-cart"></i>
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
                                                    {if isset($novconfig.novthemeconfig_cat_product_wishlist) && $novconfig.novthemeconfig_cat_product_wishlist == 1 }
                                                        {hook h='displayProductListFunctionalButtons' product=$product}
                                                    {/if}
                                                    {if isset($novconfig.novthemeconfig_cat_product_quickview) && $novconfig.novthemeconfig_cat_product_quickview == 1 }
                                                        <a href="#" class="quick-view hidden-sm-down pt-bt" data-link-action="quickview">
                                                            <i class="zmdi zmdi-search"></i>
                                                        </a>
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-auto">
                                            {hook h='countdownProduct' product=$product}
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