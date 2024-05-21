{foreach from=$products item=product name=products}
    {* <div  class="item itemProduct {$class_item} {if $smarty.foreach.products.first} first_item{elseif $smarty.foreach.products.last} last_item{/if}"> --> *}
    <div
        class="item itemProduct {if $smarty.foreach.products.first} first_item{elseif $smarty.foreach.products.last} last_item{/if}">
        <div class='d-flex justify-content-end'>
            {if $product.availability == 'available'}
                <a href="{$product.link}">
                    <i class="fa fa-shopping-cart px-md-2" style='font-size:24px; color:#59049D;'></i>
                </a>
            {else}
                <i class="fa fa-shopping-cart px-md-2" style='font-size:24px; color: grey; cursor:no-drop; '></i>
            {/if}
        </div>
        <div class="product-miniature js-product-miniature item-categories{if $smarty.foreach.products.first} first_item{elseif $smarty.foreach.products.last} last_item{/if}"
            data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope
            itemtype="http://schema.org/Product">
            <div class="thumbnail-container" itemprop="image">
                {block name='product_thumbnail'}
                    {if isset($novconfig.novthemeconfig_second_img) && $novconfig.novthemeconfig_second_img == 1}
                        {if (count($product.images) > 1) && $product.cover}
                            <a href="{$product.url}" class="thumbnail product-thumbnail two-image">
                                <img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.home_default.url}"
                                    src="{$product.cover.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}"
                                    width="{$product.cover.bySize.home_default.width}px"
                                    height="{$product.cover.bySize.home_default.height}px">
                                {foreach from=$product.images item=image}
                                    {if $image.cover != '1'}
                                        <img class="img-fluid image-secondary nov-lazyload" src="{$image.bySize.home_default.url}"
                                            alt="thumbnail-{$product.cover.legend}" data-full-size-image-url="{$image.large.url}"
                                            width="{$product.cover.bySize.home_default.width}"
                                            height="{$product.cover.bySize.home_default.height}">
                                        {break}
                                    {/if}
                                {/foreach}
                            </a>
                        {elseif (count($product.images) == 1) && $product.cover}
                            <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                <img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.home_default.url}"
                                    src="{$product.cover.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}"
                                    width="{$product.cover.bySize.home_default.width}px"
                                    height="{$product.cover.bySize.home_default.height}px">
                            </a>
                        {else}
                            <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                <img class="img-fluid image-cover nov-lazyload"
                                    data-src="{$urls.no_picture_image.bySize.home_default.url}"
                                    src="{$urls.no_picture_image.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}"
                                    width="{$product.cover.bySize.home_default.width}px"
                                    height="{$product.cover.bySize.home_default.height}px">
                            </a>
                        {/if}

                    {else}
                        {if (count($product.images) >= 1) && $product.cover}
                            <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                <img class="img-fluid image-cover nov-lazyload" data-src="{$product.cover.bySize.home_default.url}"
                                    src="{$product.cover.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}"
                                    width="{$product.cover.bySize.home_default.width}px"
                                    height="{$product.cover.bySize.home_default.height}px">
                            </a>
                        {else}
                            <a href="{$product.url}" class="thumbnail product-thumbnail one-image">
                                <img class="img-fluid image-cover nov-lazyload"
                                    data-src="{$urls.no_picture_image.bySize.home_default.url}"
                                    src="{$urls.no_picture_image.bySize.home_default.url}" alt="thumbnail-{$product.cover.legend}"
                                    width="{$product.cover.bySize.home_default.width}px"
                                    height="{$product.cover.bySize.home_default.height}px">
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
                <div class="button-top">
                    {if isset($novconfig.novthemeconfig_cat_product_wishlist) &&
                                                            $novconfig.novthemeconfig_cat_product_wishlist == 1 }
                    {hook h='displayProductListFunctionalButtons' product=$product}
                {/if}
                {if isset($novconfig.novthemeconfig_cat_product_quickview) &&
            $novconfig.novthemeconfig_cat_product_quickview == 1 }
                <a href="#" class="quick-view hidden-sm-down pt-bt" data-link-action="quickview">
                    <i class="zmdi zmdi-search"></i>
                </a>
                {/if}
            </div>
        </div>



        <div class="product-description">
            {block name='product_name'}
                <div class="product-title" itemprop="name" style="text-align: center;">
                    <a href="{$product.url}">{$product.name}</a>
                    <div class="d-flex justify-content-center" itemprop="description" >
                        {if $product.id_category_default == 8}
                            {foreach from=$product.features item=feature}
                                {if $feature.id_feature && $feature.id_feature == 1}
                                    <p class="name featureValue">{$feature.value}/</p>
                                {/if}
                                {if $feature.id_feature && $feature.id_feature == 5}
                                    <p class="name featureValue">{$feature.value}</p>
                                {/if}
                            {/foreach}
                        {else}
                            {foreach from=$product.features item=feature}
                                {if $feature.id_feature && $feature.id_feature == 1}
                                    <p class="name featureValue">{$feature.value}/</p>
                                {/if}
                                {if $feature.id_feature && $feature.id_feature == 5}
                                    <p class="name featureValue">{$feature.value}</p>
                                {/if}

                            {/foreach}
                        {/if}
                    </div>
                </div>
            {/block}

            {* {if isset($novconfig.novthemeconfig_cat_product_rate) && $novconfig.novthemeconfig_cat_product_rate == 1}
                {hook h='displayProductListReviews' product=$product}
            {/if} *}
            
            <div class="info-stock mb-10">
                {if $product.availability == 'available'}
                    <span class='available-products'>
                        <i class="fa fa-check-square-o"></i>
                        {$product.availability_message}
                    </span>

                {else}
                    <span class='unavailable-products'>
                        <i class="fa fa-ban"></i>
                        {$product.availability_message}
                    </span>
                {/if}

            </div>
            {* <div class="product-groups" itemprop="offers" itemscope itemtype="http://schema.org/Offer"> *}
            <div class="product-groups" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

                <div class="product-group-price">
                    {block name='product_price_and_shipping'}
                        {if $product.show_price}
                            <div class="product-price-and-shipping">
                                {hook h='displayProductPriceBlock' product=$product type="before_price"}
                                <span itemprop="price" class="price">{$product.price}</span>
                                <link itemprop="availability" href="https://schema.org/InStock" />
                                <meta itemprop="priceCurrency" content="{$currency.iso_code}">
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
                <div class="hidden">
                    <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                        <span itemprop="reviewCount"></span>
                        <span itemprop="ratingValue"></span>
                    </div>
                    <div itemprop="review" itemscope itemtype="https://schema.org/Review">
                        <div itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                            <meta itemprop="worstRating" content="1">
                            <span itemprop="ratingValue"></span>
                            <span itemprop="bestRating"></span>
                        </div>
                        <span itemprop="reviewBody"></span>
                    </div>
                </div>
                {* <div class="info-stock">
                {if $product.availability == 'available'}
                    <i class="fa fa-check-square-o"></i>
                {elseif $product.availability == 'last_remaining_items'}
                    <i class="fa fa-exclamation-triangle product-last-items"></i>
                {else}
                    <i class="fa fa-exclamation-triangle"></i>
                {/if}
                {$product.availability_message}
                    </div> *}
                <div class="product-desc" itemprop="desciption">{$product.description_short|strip_tags|truncate:180
                nofilter}</div>

                {assign var="link" value = Context::getContext()->link }
                {assign var="static_token" value = Tools::getToken(false)}
                <div class="product-buttons d-none">
                    {if isset($novconfig.novthemeconfig_cat_product_addtocart) &&
                $novconfig.novthemeconfig_cat_product_addtocart == 1 }
                    {if $product.quantity > 0}
                        {if $product.id_product_attribute != 0 }
                            <a class="add-to-cart has-text" href="{$product.url}"><i
                                    class="zmdi zmdi-check"></i><span>{l
                                                                                                                        s='Select Options' d='Shop.Theme.Actions'}</span></a>
                        {else}
                            <form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
                                <input type="hidden" name="token" value="{$static_token}">
                                <input type="hidden" name="id_product" value="{$product.id}">
                                <input type="hidden" name="qty" value="{$product.minimal_quantity}">
                                <button class="add-to-cart show_popup has-text align-self-center btn" href="#"
                                    data-button-action="add-to-cart">
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
                            <button class="btn btn-link add-to-cart show_popup" href="#" data-button-action="add-to-cart"
                                type="submit" {if !$product.add_to_cart_url} disabled {/if}>
                                <span class="loading"><i class="fa fa-spinner fa-spin"></i></span>
                                <i class="novicon-cart mr-0"></i>
                                <span>
                                    {if !$product.add_to_cart_url}
                                        {l s='Out of Stock' d='Shop.Theme.Actions'}
                                    {else}
                                        {l s='Add to cart' d='Shop.Theme.Actions'}
                                    {/if}
                                </span>
                            </button>
                        </form>
                    {/if}
                    {/if}

                    <div class="button-top">
                        {if isset($novconfig.novthemeconfig_cat_product_wishlist) &&
                    $novconfig.novthemeconfig_cat_product_wishlist == 1 }
                        {hook h='displayProductListFunctionalButtons' product=$product}
                        {/if}
                        {if isset($novconfig.novthemeconfig_cat_product_quickview) &&
                    $novconfig.novthemeconfig_cat_product_quickview == 1 }
                        <a href="#" class="quick-view hidden-sm-down pt-bt" data-link-action="quickview">
                            <i class="zmdi zmdi-search"></i>
                        </a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden">
                <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
                    <span itemprop="reviewCount"></span>
                    <span itemprop="ratingValue"></span>
                </div>
                <div itemprop="review" itemscope itemtype="https://schema.org/Review">
                    <div itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                        <meta itemprop="worstRating" content="1">
                        <span itemprop="ratingValue"></span>
                        <span itemprop="bestRating"></span>
                    </div>
                    <span itemprop="reviewBody"></span>
                </div>
            </div>
        {* <a href="{$product.url}" class="detailsLink">
        <img src="/themes/vinova_nuranium/assets/img/IconDetails.png" class="imgDetails">
        <span class="productDetails">Détails</span>
    </a> *}
    </div>
</div>
{/foreach}