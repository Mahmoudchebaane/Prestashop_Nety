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
{extends file="layouts/`$novconfig.novthemeconfig_product_layout`.tpl"}

{block name='head_seo' prepend}
    <link rel="canonical" href="{$product.canonical_url}">
{/block}

{block name='head' append}
    <meta property="og:type" content="product">
    <meta property="og:url" content="{$urls.current_url}">
    <meta property="og:title" content="{$page.meta.title}">
    <meta property="og:site_name" content="{$shop.name}">
    <meta property="og:description" content="{$page.meta.description}">
    <meta property="og:image" content="{$product.cover.large.url}">
    <meta property="product:pretax_price:amount" content="{$product.price_tax_exc}">
    <meta property="product:pretax_price:currency" content="{$currency.iso_code}">
    <meta property="product:price:amount" content="{$product.price_amount}">
    <meta property="product:price:currency" content="{$currency.iso_code}">
    {if isset($product.weight) && ($product.weight != 0)}
        <meta property="product:weight:value" content="{$product.weight}">
        <meta property="product:weight:units" content="{$product.weight_unit}">
    {/if}
{/block}

{block name='content'}

    <section id="main" itemscope itemtype="https://schema.org/Product">
        <meta itemprop="url" content="{$product.url}">

        <div class="row no-flow mb-75">
            {if $novconfig.novthemeconfig_product_layout == 'layout-one-column'}
                {if $novconfig.novthemeconfig_product_thumbtype == 'true'}
                    <div class="col-md-6 col-xs-12">
                    {else}
                        <div class="col-md-5 col-xs-12">
                        {/if}
                    {else}
                        <div class="col-lg-5">
                        {/if}
                        {block name='page_content_container'}
                            <section class="page-content" id="content">
                                {block name='page_content'}
                                    {block name='product_cover_tumbnails'}
                                        {include file='catalog/_partials/product-cover-thumbnails.tpl'}
                                    {/block}
                                {/block}
                            </section>
                        {/block}
                    </div>

                    {if $novconfig.novthemeconfig_product_layout == 'layout-one-column'}
                        {if $novconfig.novthemeconfig_product_thumbtype == 'true'}
                            <div class="col-md-6 col-xs-12 mt-xs-30 product_info">
                            {else}
                                <div class="col-md-7 col-xs-12 mt-xs-30 product_info">
                                {/if}
                            {else}
                                <div class="col-lg-7 mt-sm-30 product_info">
                                {/if}
                                <h1 class="detail-product-name" itemprop="name">
                                    {block name='page_title'}{$product.name}{/block}</h1>
                                {block name='product_prices'}
                                    {include file='catalog/_partials/product-prices.tpl'}
                                {/block}

                                {if isset($novconfig.novthemeconfig_product_shortdesc) && $novconfig.novthemeconfig_product_shortdesc}
                                    {block name='product_description_short'}
                                        <div id="product-description-short-{$product.id}" class="mb-25" itemprop="description">
                                            {$product.description_short|strip_tags nofilter}</div>
                                    {/block}
                                {/if}

                                <div class="instock mb-5 product-add-to-cart pt-0 pb-0">
                                    {block name='product_availability'}
                                        {if isset($novconfig.novthemeconfig_product_availability) && $novconfig.novthemeconfig_product_availability}
                                            <span>
                                                {if $product.show_availability}
                                                    <div class="product-availability" id="product-availability">
                                                        <label
                                                            class="control-label">{l s='Availability : ' d='Shop.Theme.Actions'}</label>
                                                        {if $product.availability == 'available'}
                                                            <span class="product-available">
                                                                {$product.availability_message}
                                                                <i class="fa fa-check-square-o"></i>
                                                            </span>
                                                        {elseif $product.availability == 'last_remaining_items'}
                                                            <span class="product-last-items">
                                                                {$product.availability_message}
                                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                            </span>
                                                        {else}
                                                            <span class="product-unavailable">
                                                                {$product.availability_message}
                                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                                            </span>
                                                        {/if}
                                                    </div>

                                                {/if}
                                            </span>
                                        {/if}
                                    {/block}
                                </div>

                                {if isset($novconfig.novthemeconfig_product_sku) && $novconfig.novthemeconfig_product_sku}
                                    <div class="sku text-uppercase font-weight-bold mb-5">
                                        <label class="control-label">{l s='Sku' d='Shop.Theme.Actions'}:</label>
                                        <span itemprop="sku" content="{$product.reference}">{$product.reference}</span>
                                    </div>
                                {/if}

                                {if Product::getProductCategoriesFull(Tools::getValue('id_product'))}
                                    <div class="pro-cate mb-5">
                                        <label class="control-label">{l s='Categories' d='Shop.Theme.Actions'}:</label>
                                        {foreach from=Product::getProductCategoriesFull(Tools::getValue('id_product')) item=cat}
                                            {if $cat.link_rewrite =='home'}
                                            {else}
                                                <span><a href="{$link->getCategoryLink({$cat.id_category})}"
                                                        title="{$cat.name}">{$cat.name}</a></span>
                                            {/if}
                                        {/foreach}
                                    </div>
                                {/if}

                                {if Tag::getProductTags(Tools::getValue('id_product'))}
                                    <div class="pro-tag">
                                        <label class="control-label">{l s='Tags' d='Shop.Theme.Actions'}:</label>
                                        {foreach from=Tag::getProductTags(Tools::getValue('id_product')) key=k item=v}
                                            {foreach from=$v item=value}
                                                <span><a href="{$link->getPageLink('search', true, NULL, "tag={$value|urlencode}"
                                        )}">{$value|escape:html:'UTF-8'}</a></span>
                                            {/foreach}
                                        {/foreach}
                                    </div>
                                {/if}
                                <div class="product-information">
                                    {if $product.is_customizable && count($product.customizations.fields)}
                                        {block name='product_customization'}
                                            {include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
                                        {/block}
                                    {/if}

                                    <div class="product-actions">
                                        {block name='product_buy'}
                                            <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                                                <input type="hidden" name="token" value="{$static_token}">
                                                <input type="hidden" name="id_product" value="{$product.id}"
                                                    id="product_page_product_id">
                                                <input type="hidden" name="id_customization" value="{$product.id_customization}"
                                                    id="product_customization_id">
                                                <input type="hidden" name="qty" value="{$product.minimal_quantity}">
                                                {block name='product_variants'}
                                                    {include file='catalog/_partials/product-variants.tpl'}
                                                {/block}

                                                <div class="productbuttons in_border">
                                                    {hook h='displayProductButtons' product=$product}
                                                    <a class="btn btn-link" href="javascript:print();">
                                                        <span><i class="fa fa-print"
                                                                aria-hidden="true"></i>{l s='Print' d='Shop.Theme.Actions'}</span>
                                                    </a>
                                                </div>

                                                {block name='product_pack'}
                                                    {if $packItems}
                                                        <section class="product-pack mt-0">
                                                            <h3 class="h4">{l s='This pack contains' d='Shop.Theme.Catalog'}</h3>
                                                            {foreach from=$packItems item="product_pack"}
                                                                {block name='product_miniature'}
                                                                    {include file='catalog/_partials/miniatures/pack-product.tpl' product=$product_pack}
                                                                {/block}
                                                            {/foreach}
                                                        </section>
                                                    {/if}
                                                {/block}
                                                <div class="rating d-flex align-items-center">
                                                    <h4>{l s='Rating' d='Shop.Theme.Actions'} : &nbsp;</h4>
                                                    {if isset($novconfig.novthemeconfig_cat_product_rate) && $novconfig.novthemeconfig_cat_product_rate == 1 }
                                                        {hook h='displayProductListReviews' product=$product}
                                                    {/if}
                                                </div>
                                                {block name='product_add_to_cart'}
                                                    {include file='catalog/_partials/product-add-to-cart.tpl'}
                                                {/block}

                                                {block name='product_refresh'}
                                                    <input class="product-refresh ps-hidden-by-js" name="refresh" type="submit"
                                                        value="{l s='Refresh' d='Shop.Theme.Actions'}">
                                                {/block}
                                            </form>
                                        {/block}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tabs mb-60">
                            <ul class="nav nav-tabs">
                                {if $product.description}
                                    <li class="nav-item">
                                        <a class="nav-link{if $product.description} active{/if}" data-toggle="tab"
                                            href="#description">{l s='Description' d='Shop.Theme.Catalog'}</a>
                                    </li>
                                {/if}
                                <li class="nav-item">
                                    <a class="nav-link{if !$product.description} active{/if}" data-toggle="tab"
                                        href="#product-details">{l s='Product Details' d='Shop.Theme.Catalog'}</a>
                                </li>
                                {if $product.attachments}
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab"
                                            href="#attachments">{l s='Attachments' d='Shop.Theme.Catalog'}</a>
                                    </li>
                                {/if}
                                {foreach from=$product.extraContent item=extra key=extraKey}
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#extra-{$extraKey}">{$extra.title}</a>
                                    </li>
                                {/foreach}
                                {hook h='ProductTab' mod='novproductcomments'}
                            </ul>
                            <div class="tab-content" id="tab-content">
                                <div class="tab-pane fade in{if $product.description} active{/if}" id="description">
                                    {block name='product_description'}
                                        <div class="product-description">{$product.description nofilter}</div>
                                    {/block}
                                </div>

                                {block name='product_details'}
                                    {include file='catalog/_partials/product-details.tpl'}
                                {/block}

                                {block name='product_attachments'}
                                    {if $product.attachments}
                                        <div class="tab-pane fade in" id="attachments">
                                            <section class="product-attachments">
                                                <h3 class="h5 text-uppercase">{l s='Download' d='Shop.Theme.Actions'}</h3>
                                                {foreach from=$product.attachments item=attachment}
                                                    <div class="attachment">
                                                        <h4><a
                                                                href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">{$attachment.name}</a>
                                                        </h4>
                                                        <p>{$attachment.description}</p>
                                                        <a
                                                            href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">
                                                            {l s='Download' d='Shop.Theme.Actions'} ({$attachment.file_size_formatted})
                                                        </a>
                                                    </div>
                                                {/foreach}
                                            </section>
                                        </div>
                                    {/if}
                                {/block}

                                {foreach from=$product.extraContent item=extra key=extraKey}
                                    <div class="tab-pane fade in {$extra.attr.class}" id="extra-{$extraKey}"
                                        {foreach $extra.attr as $key => $val} {$key}="{$val}" {/foreach}>
                                        {$extra.content nofilter}
                                    </div>
                                {/foreach}
                                {hook h='productTabContent' mod='novproductcomments'}
                            </div>

                            <div class="product_footer">
                                {block name='product_footer'}
                                    {* {hook h='displayFooterProduct' product=$product category=$category} *}
                                {/block}
                            </div>
                        </div>

                        {if $novconfig.novthemeconfig_product_layout == 'layout-one-column'}
                            {block name='product_accessories'}
                                {if $accessories}
                                    <section class="relate-product product-accessories clearfix pb-30 mb-30">
                                        <h3 class="h5 title_block style-2">
                                            <span class="title_content">{l s='Relate products' d='Shop.Theme.Catalog'}</span>
                                        </h3>
                                        <div class="products product_list grid related-slick-carousel row" data-autoplay="false"
                                            data-autoplayTimeout="6000" data-loop="false" data-items="5" data-items_tablet="4"
                                            data-items_mobile="2" data-arrows="true" data-dots="false" data-rows="1">
                                            {foreach from=$accessories item=product name=products}
                                                <div class="item pl-15 pr-15 pl-xs-5 pr-xs-5">
                                                    <div class="product-miniature js-product-miniature item-three"
                                                        data-id-product="{$product.id_product}"
                                                        data-id-product-attribute="{$product.id_product_attribute}" itemscope
                                                        itemtype="http://schema.org/Product">
                                                        <div class="thumbnail-container" itemprop="image">
                                                            {block name='product_thumbnail'}
                                                                {if isset($novconfig.novthemeconfig_second_img) && $novconfig.novthemeconfig_second_img == 1}
                                                                    {if (count($product.images) > 1) && $product.cover}
                                                                        <a href="{$product.url}" class="thumbnail product-thumbnail two-image">
                                                                            <img class="img-fluid image-cover nov-lazyload"
                                                                                data-src="{$product.cover.bySize.home_default.url}"
                                                                                src="{$product.cover.bySize.home_default.url}"
                                                                                alt="{$product.cover.legend}"
                                                                                width="{$product.cover.bySize.home_default.width}px"
                                                                                height="{$product.cover.bySize.home_default.height}px">
                                                                            {foreach from=$product.images item=image}
                                                                                {if $image.cover != '1'}
                                                                                    <img class="img-fluid image-secondary nov-lazyload"
                                                                                        src="{$image.bySize.home_default.url}" alt="{$product.cover.legend}"
                                                                                        data-full-size-image-url="{$image.large.url}"
                                                                                        width="{$product.cover.bySize.home_default.width}"
                                                                                        height="{$product.cover.bySize.home_default.height}">
                                                                                    {break}
                                                                                {/if}
                                                                            {/foreach}
                                                                        </a>
                                                                    {elseif (count($product.images) == 1) && $product.cover}
                                                                        <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                                                            <img class="img-fluid image-cover nov-lazyload"
                                                                                data-src="{$product.cover.bySize.home_default.url}"
                                                                                src="{$product.cover.bySize.home_default.url}"
                                                                                alt="{$product.cover.legend}"
                                                                                width="{$product.cover.bySize.home_default.width}px"
                                                                                height="{$product.cover.bySize.home_default.height}px">
                                                                        </a>
                                                                    {else}
                                                                        <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                                                            <img class="img-fluid image-cover nov-lazyload"
                                                                                data-src="{$urls.no_picture_image.bySize.home_default.url}"
                                                                                src="{$urls.no_picture_image.bySize.home_default.url}"
                                                                                alt="{$product.cover.legend}"
                                                                                width="{$product.cover.bySize.home_default.width}px"
                                                                                height="{$product.cover.bySize.home_default.height}px">
                                                                        </a>
                                                                    {/if}

                                                                {else}
                                                                    {if (count($product.images) >= 1) && $product.cover}
                                                                        <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                                                            <img class="img-fluid image-cover nov-lazyload"
                                                                                data-src="{$product.cover.bySize.home_default.url}"
                                                                                src="{$product.cover.bySize.home_default.url}"
                                                                                alt="{$product.cover.legend}"
                                                                                width="{$product.cover.bySize.home_default.width}px"
                                                                                height="{$product.cover.bySize.home_default.height}px">
                                                                        </a>
                                                                    {else}
                                                                        <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                                                            <img class="img-fluid image-cover nov-lazyload"
                                                                                data-src="{$urls.no_picture_image.bySize.home_default.url}"
                                                                                src="{$urls.no_picture_image.bySize.home_default.url}"
                                                                                alt="{$product.cover.legend}"
                                                                                width="{$product.cover.bySize.home_default.width}px"
                                                                                height="{$product.cover.bySize.home_default.height}px">
                                                                        </a>
                                                                    {/if}
                                                                {/if}
                                                            {/block}
                                                            <div class="button-top">
                                                                {if isset($novconfig.novthemeconfig_cat_product_wishlist) && $novconfig.novthemeconfig_cat_product_wishlist == 1 }
                                                                    {hook h='displayProductListFunctionalButtons' product=$product}
                                                                {/if}
                                                                {if isset($novconfig.novthemeconfig_cat_product_quickview) && $novconfig.novthemeconfig_cat_product_quickview == 1 }
                                                                    <a href="#" class="quick-view hidden-sm-down pt-bt"
                                                                        data-link-action="quickview">
                                                                        <i class="zmdi zmdi-search"></i>
                                                                    </a>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="product-description position-relative">
                                                            {block name='product_name'}
                                                                <div class="product-title" itemprop="name"><a
                                                                        href="{$product.url}">{$product.name}</a></div>
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
                                                            <div class="product-buttons">
                                                                {if isset($novconfig.novthemeconfig_cat_product_addtocart) && $novconfig.novthemeconfig_cat_product_addtocart == 1 }
                                                                    {if $product.quantity > 0}
                                                                        {if $product.id_product_attribute != 0 }
                                                                            <a class="add-to-cart has-text" href="{$product.url}"><i
                                                                                    class="zmdi zmdi-check"></i><span>{l s='Select Options' d='Shop.Theme.Actions'}</span></a>
                                                                        {else}
                                                                            <form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
                                                                                <input type="hidden" name="token" value="{$static_token}">
                                                                                <input type="hidden" name="id_product" value="{$product.id}">
                                                                                <input type="hidden" name="qty" value="{$product.minimal_quantity}">
                                                                                <button class="add-to-cart show_popup has-text align-self-center btn"
                                                                                    href="#" data-button-action="add-to-cart">
                                                                                    <span class="loading"><i class="fa fa-spinner fa-spin"></i></span>
                                                                                    <i
                                                                                        class="novicon-cart"></i><span>{l s='Add To Cart' d='Shop.Theme.Actions'}</span>
                                                                                </button>
                                                                            </form>
                                                                        {/if}
                                                                    {else}
                                                                        <form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
                                                                            <input type="hidden" name="token" value="{$static_token}">
                                                                            <input type="hidden" name="id_product" value="{$product.id}">
                                                                            <input type="hidden" name="qty" value="{$product.minimal_quantity}">
                                                                            <button class="btn add-to-cart show_popup" href="#"
                                                                                data-button-action="add-to-cart" type="submit"
                                                                                {if !$product.add_to_cart_url} disabled {/if}>
                                                                                <span class="loading"><i class="fa fa-spinner fa-spin"></i></span>
                                                                                <i class="novicon-cart mr-0"></i><span>{if !$product.add_to_cart_url}
                                                                                    {l s='Out of Stock' d='Shop.Theme.Actions'}
                                                                                    {else}
                                                                                        {l s='Add to cart' d='Shop.Theme.Actions'}
                                                                                    {/if}</span>
                                                                            </button>
                                                                        </form>
                                                                    {/if}
                                                                {/if}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {/foreach}
                                        </div>
                                    </section>
                                {/if}
                            {/block}
                        {/if}

                        {block  name='product_images_modal'}
                            {include file='catalog/_partials/product-images-modal.tpl'}
                        {/block}

                        {block name='page_footer_container'}
                            <footer class="page-footer">
                                {block name='page_footer'}
                                    <!-- Footer content -->
                                {/block}
                            </footer>
                        {/block}
    </section>

{/block}