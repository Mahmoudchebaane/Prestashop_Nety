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
    <div class="nov-productlist productlist_deal slider-type-11{if isset($el_class) && $el_class} {$el_class}{/if}">
        <div class="block-product clearfix">
            {if isset($title) && !empty($title)}
                <h2 class="title_block text-{$title_align} style-6">
                    <div class="text-block">
                        <span class="title1"> {$title1} </span>
                        <span class="title_content">{$title}</span>
                    </div>
                    {if isset($sub_title) && !empty($sub_title)}
                        <span class="sub_title">{$sub_title}</span>
                    {/if}
                </h2>
            {/if}
            <div class="block_content block_content_item_7">
                <div class=" product_list owl-carousel owl-theme " data-rows="{$number_row}" data-items="{$xl}" data-items_large="{$lg}"  data-items_tablet="{$md}" data-items_mobile="{$xs}" data-nav="true" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
                    {foreach from=$products item=product name=products}
                        <div class="item">
                            <div class="border-item">
                                <div class="d-flex align-items-center product-miniature js-product-miniature{if $smarty.foreach.products.first} first_item{elseif $smarty.foreach.products.last} last_item{/if}" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="thumbnail ">
                                            {block name='product_thumbnail'}
                                                <div class="thumnailslider-for col-cus-100 thumnailslider-for{$smarty.foreach.products.index}" data-asnavfornav=".thumnailslider-nav{$smarty.foreach.products.index}">
                                                    {foreach from=$product.images item=image}
                                                        <div class="item thumb-container">
                                                            <img 
                                                                class="img-fluid"
                                                                src = "{$image.bySize.home_default.url}"
                                                                alt = "{$product.cover.legend}"
                                                                >
                                                        </div>
                                                    {/foreach}
                                                </div>
                                                <div class="product-groups" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                    {assign var="link" value = Context::getContext()->link }
                                                    {assign var="static_token" value = Tools::getToken(false)}
                                                    <div class="product-buttons">
                                                        {if isset($novconfig.novthemeconfig_cat_product_addtocart) && $novconfig.novthemeconfig_cat_product_addtocart == 1 }
                                                            <div class="groups-1">
                                                                {if $product.quantity > 0}
                                                                    {if $product.id_product_attribute != 0 }
                                                                        <a class="add-to-cart has-text" href="{$product.url}"><i class="zmdi zmdi-check m-0"></i>
                                                                        </a>
                                                                    {else}
                                                                        <form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
                                                                            <input type="hidden" name="token" value="{$static_token}">
                                                                            <input type="hidden" name="id_product" value="{$product.id}">
                                                                            <input type="hidden" name="qty" value="{$product.minimal_quantity}">
                                                                            <button class="add-to-cart show_popup has-text align-self-center btn" href="#" data-button-action="add-to-cart">
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
                                                                        <button class="btn btn-link add-to-cart show_popup" href="#" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url} disabled {/if}>
                                                                            <span class="loading"><i class="fa fa-spinner fa-spin"></i></span>
                                                                            <i class="novicon-cart mr-0"></i>
                                                                        </button>
                                                                    </form>
                                                                {/if}
                                                            </div>
                                                        {/if}
                                                        {if isset($novconfig.novthemeconfig_cat_product_wishlist) && $novconfig.novthemeconfig_cat_product_wishlist == 1 }
                                                            <div class="groups-2">
                                                                {hook h='displayProductListFunctionalButtons' product=$product}
                                                            </div>
                                                        {/if}
                                                        {if isset($novconfig.novthemeconfig_cat_product_quickview) && $novconfig.novthemeconfig_cat_product_quickview == 1 }
                                                            <div class="groups-3">
                                                                <a href="#" class="quick-view hidden-sm-down pt-bt" data-link-action="quickview">
                                                                    <i class="zmdi zmdi-search"></i>
                                                                </a>
                                                            </div>
                                                        {/if}
                                                    </div>
                                                </div>
                                                {block name='product_name'}
                                                    <div class="d-md-flex mb-4 mt-16 desc-top">
                                                        <div class="product-title" itemprop="name"><a href="{$product.url}">{$product.name}</a></div>
                                                        {/block}	
                                                        {if isset($novconfig.novthemeconfig_cat_product_rate) && $novconfig.novthemeconfig_cat_product_rate == 1 }
                                                            {hook h='displayProductListReviews' product=$product}
                                                        {/if}
                                                </div>
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
                                                <div class="thumnailslider-nav col-cus-100 thumnailslider-nav{$smarty.foreach.products.index}" data-asnavforfor=".thumnailslider-for{$smarty.foreach.products.index}" data-vertical="true" data-autoplay="false" data-autoplayTimeout="6000" data-items="8" data-items_mobile="6" data-margin="0" data-nav="false" data-dots="false" data-loop="false" data-items_mobile="3">
                                                    {foreach from=$product.images item=image}
                                                        <div class="item thumb-container">
                                                            <img 
                                                                class="img-fluid"
                                                                src = "{$image.bySize.small_default.url}"
                                                                alt = "{$product.cover.legend}"
                                                            >
                                                        </div>
                                                    {/foreach}
                                                </div>
                                            {/block}	
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