{**
* 2007-2017 PrestaShop
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
* @author PrestaShop SA <contact@prestashop.com>
  * @copyright 2007-2017 PrestaShop SA
  * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
  * International Registered Trademark & Property of PrestaShop SA
  *}
  <div id="quickview-modal-{$product.id}-{$product.id_product_attribute}" class="modal fade quickview" tabindex="-1"
    role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
              class="material-icons close">close</i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-5 divide-right">
              <div class="images-container">
                {block name='product_cover'}
                <div class="product-cover">
                  <img class="js-qv-product-cover img-fluid"
                    src="{if $novconfig.novthemeconfig_product_layout == 'layout-one-column'}{$product.cover.bySize.large_default.url}{else}{$product.cover.bySize.large_default.url}{/if}"
                    alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image">
                </div>
                {/block}
                {block name='product_images'}
                <div class="js-qv-mask mask">
                  <div class="product-images slick-images" data-autoplay="false" data-autoplayTimeout="6000"
                    data-items="5" data-margin="10" data-nav="true" data-dots="false" data-loop="false"
                    data-items_mobile="3" data-vertical="false">
                    {foreach from=$product.images item=image}
                    <div class="item thumb-container">
                      <img class="thumb js-thumb img-fluid{if $image.id_image == $product.cover.id_image} selected{/if}"
                        data-image-medium-src="{$image.bySize.medium_default.url}"
                        data-image-large-src="{$image.bySize.large_default.url}" src="{$image.bySize.small_default.url}"
                        alt="{$image.legend}" title="{$image.legend}" itemprop="image">
                    </div>
                    {/foreach}
                  </div>
                </div>
                {/block}
              </div>
            </div>
            <div class="col-sm-7">
              <div class="product-name mb-10"><a href="{$product.url}">{$product.name}</a></div>
              {block name='product_prices'}
              {include file='catalog/_partials/product-prices.tpl'}
              {/block}
              <div class="d-flex">
                <div class="instock">
                  {block name='product_availability'}
                  {if isset($novconfig.novthemeconfig_product_availability) &&
                  $novconfig.novthemeconfig_product_availability}
                  <span>
                    {if $product.show_availability}
                    <div class="product-availability">
                      <label class="control-label">{l s='Availability : ' d='Shop.Theme.Actions'}</label>
                      {if $product.availability == 'available'}
                      <span id="product-availability" class="product-available">
                        <i class="fa fa-check-square-o"></i>
                        {$product.availability_message}
                      </span>
                      {elseif $product.availability == 'last_remaining_items'}
                      <span id="product-availability" class="product-last-items">
                        <i class="fa fa-exclamation-triangle"></i>
                        {$product.availability_message}
                      </span>
                      {else}
                      <span id="product-availability" class="product-unavailable">
                        <i class="fa fa-ban"></i>
                        {$product.availability_message}
                      </span>
                      {/if}
                    </div>
                    {/if}
                    {/if}
                  </span>
                  {/block}
                </div>
                {if isset($novconfig.novthemeconfig_product_sku) && $novconfig.novthemeconfig_product_sku}
                <div class="sku text-uppercase">
                  <label class="control-label font-weight-bold">{l s='Sku' d='Shop.Theme.Actions'}:</label>
                  <span itemprop="sku" content="{$product.reference}">{$product.reference}</span>
                </div>
                {/if}
              </div>
              {block name='product_description_short'}
              <div id="product-description-short" class="has_border" itemprop="description">
                {$product.description_short|strip_tags|truncate:120 nofilter}</div>
              {/block}
              {block name='product_buy'}
              <div class="product-actions">
                <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                  <input type="hidden" name="token" value="{$static_token}">
                  <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
                  <input type="hidden" name="id_customization" value="{$product.id_customization}"
                    id="product_customization_id">
                  {block name='product_variants'}
                  {include file='catalog/_partials/product-variants.tpl'}
                  {/block}
                  {block name='product_add_to_cart'}
                  <div class="product-add-to-cart">
                    {if !$configuration.is_catalog}
                    {*<span class="control-label">{l s='QTY' d='Shop.Theme.Catalog'} : </span>*}
                    {block name='product_quantity'}
                    <div class="product-quantity">
                      <div class="qty">
                        <input type="text" name="qty" id="quantity_wanted" value="{$product.quantity_wanted}"
                          class="input-group" min="{$product.minimal_quantity}" />
                      </div>
                      <div class="add">
                        {if $product.main_variants}
                        <a class="btn btn-primary add-to-cart" href="{$product.url}">
                          <i class="zmdi zmdi-check"></i><span>{l s='Select Options' d='Shop.Theme.Actions'}</span>
                        </a>
                        {else}
                        <button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit" {if
                          !$product.add_to_cart_url || $product.quantity_wanted> $product.quantity}disabled{/if}>
                          <i class="novicon-cart"></i>
                          <span>{l s='Add to cart' d='Shop.Theme.Actions'}</span>
                        </button>
                        {/if}
                        {hook h='displayProductListFunctionalButtons' product=$product}
                      </div>

                    </div>
                    {/block}
                    {/if}
                  </div>
                  {/block}
                  {* Input to refresh product HTML removed, block kept for compatibility with themes *}
                  {block name='product_refresh'}{/block}
                </form>
              </div>
              {/block}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>