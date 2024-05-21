{*
/******************
* Vinova Themes Framework for Prestashop 1.7.x
* @package novblockwishlist
* @version 1.0
* @author http://vinovathemes.com/
* @copyright Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
* <info@vinovathemes.com>.All rights reserved.
* @license GNU General Public License version 1
* *****************/
*}
{extends file='page.tpl'}


{block name='breadcrumb-link'}
  <div class="container">
    <ol itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="_/">
            <span itemprop="name">Home</span>
          </a>
          <meta itemprop="position" content="1">
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="#">
            <span itemprop="name">{l s='Wishlist' mod='novblockwishlist'}</span>
          </a>
          <meta itemprop="position" content="2">
        </li>
    </ol>
  </div>
  {/block}

{block name='breadcrumb-link'}{l s='Wishlist' mod='novblockwishlist'}{/block}

{block name='page_content_container'}
    <section id="content" class="page-content page-wishlist">
        <div id="view_wishlist">
            <h2 class="page-title">{l s='Wishlist' mod='novblockwishlist'}</h2>
            <div class="wlp_bought">
                <div class="row product_list grid">
                    {foreach from=$products item=product name=i}
                    <div class="item col-md-3 col-6">
                        <div class="product-miniature js-product-miniature item-one" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
                            <div class="thumbnail-container" itemprop="image">
                                <a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}" class="thumbnail product-thumbnail">
                                    <img class="img-fluid image-cover nov-lazyload" data-src="{$link->getImageLink($product.link_rewrite, $product.cover, ImageType::getFormatedName('medium'))|escape:'html'}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="{$product.name|escape:'html':'UTF-8'}">
                                </a>
                            </div>
                            <div class="product-description">
                                <div class="row-reverse">
                                {block name='product_name'}
                                    <div class="product-title" itemprop="name"><a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}">{$product.name|escape:'html':'UTF-8'}</a></div>
                                {/block}
                                </div>
                                <div class="product-groups" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                    <div class="product-buttons">
                                        {if (isset($product.attribute_quantity) && $product.attribute_quantity >= 1) || (!isset($product.attribute_quantity) && $product.product_quantity >= 1) || $product.allow_oosp}
                                            {if $ajax}
                                                <form action="{$link->getPageLink('cart')|escape:'html'}" method="post">
                                                    <input type="hidden" name="token" value="{$token}">
                                                    <input type="hidden" name="id_product" value="{$product.id_product}">
                                                    <a class="add-to-cart show_popup has-text align-self-center" href="#" data-button-action="add-to-cart"><span class="loading"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span><i class="novicon-cart"></i><span>{l s='Order Now' mod='novblockwishlist'}</span></a>
                                                </form>
                                            {else}
                                                <a href="javascript:;" class="exclusive" onclick="WishlistBuyProduct('{$token|escape:'html':'UTF-8'}', '{$product.id_product}', '{$product.id_product_attribute}', '{$product.id_product}_{$product.id_product_attribute}', this, {$ajax});" title="{l s='Add to cart' mod='novblockwishlist'}">{l s='Order Now' mod='novblockwishlist'}</a>
                                            {/if}
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </section>
{/block}
{block name="page_footer_container"}
{/block}