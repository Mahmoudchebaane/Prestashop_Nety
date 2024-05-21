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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

<div class="product-line-grid row hidden-sm-down">
  <!--  product left content: image-->
  <div class="product-line-grid-left col-md-10">
    <div class="row">

      <div class="col-md-6 d-flex align-items-center">
        <span class="product-image media-middle">
          <img class="img-fluid" src="{$product.cover.bySize.cart_default.url}" alt="{$product.name|escape:'quotes'}">
        </span>
        <div class="product-line-info pl-20 pr-20">
          <a class="label" href="{$product.url}"
            data-id_customization="{$product.id_customization|intval}">{$product.name}</a>
          {foreach from=$product.attributes key="attribute" item="value"}
            <div class="product-line-info variant">
              <span class="label-atrr">{$attribute}:</span>
              <span class="value">{$value}</span>
            </div>

          {/foreach}
          <div class="mt-xs-10 remove ml-auto">
            <div class="cart-line-product-actions ">
              <a class="remove-from-cart" rel="nofollow" href="{$product.remove_from_cart_url}"
                data-link-action="delete-from-cart" data-id-product="{$product.id_product|escape:'javascript'}"
                data-id-product-attribute="{$product.id_product_attribute|escape:'javascript'}"
                data-id-customization="{$product.id_customization|escape:'javascript'}">
                {if !isset($product.is_gift) || !$product.is_gift}
                  <i class="fa fa-trash-o" aria-hidden="true"></i>
                {/if}
              </a>

              {block name='hook_cart_extra_product_actions'}
                {hook h='displayCartExtraProductActions' product=$product}
              {/block}
            </div>
          </div>

          {if $product.customizations|count}
            <br>
            {block name='cart_detailed_product_line_customization'}
              {foreach from=$product.customizations item="customization"}
                <a href="#" data-toggle="modal"
                  data-target="#product-customizations-modal-{$customization.id_customization}">{l s='Product customization' d='Shop.Theme.Catalog'}</a>
                <div class="modal fade customization-modal"
                  id="product-customizations-modal-{$customization.id_customization}" tabindex="-1" role="dialog"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">{l s='Product customization' d='Shop.Theme.Catalog'}</h4>
                      </div>
                      <div class="modal-body">
                        {foreach from=$customization.fields item="field"}
                          <div class="product-customization-line">
                            <div class="label mb-20">
                              {$field.label}
                            </div>
                            <div class="value">
                              {if $field.type == 'text'}
                                {if (int)$field.id_module}
                                  {$field.text nofilter}
                                {else}
                                  {$field.text}
                                {/if}
                              {elseif $field.type == 'image'}
                                <img src="{$field.image.small.url}">
                              {/if}
                            </div>
                          </div>
                        {/foreach}
                      </div>
                    </div>
                  </div>
                </div>
              {/foreach}
            {/block}
          {/if}
        </div>
      </div>

      <div class=" d-flex align-items-center col-md-2">
        <div class="product-line-info product-price ">
          <span class="title_price hidden-sm-up ">{l s='Price' d='Shop.Theme.Checkout'}</span>
          {if $product.has_discount}
            <span class="value ">{$product.price}</span>
            <span class="promoTag"> {l s='Discount' d='Shop.Theme.Checkout'}</span>
            <span class="regularPrice">{$product.regular_price}</span>
          {else}
            <span class="value ">{$product.price}</span>
          {/if}

          {if $product.unit_price_full}
            <div class="unit-price-cart">{$product.unit_price_full}</div>
          {/if}
        </div>

      </div>
      <div class="qty ml-auto col-md-2 ">
        {if isset($product.is_gift) && $product.is_gift}
          <span class="gift-quantity">{$product.quantity}</span>
        {else}
          <input id="quantity_wanted" class="js-cart-line-product-quantity" data-down-url="{$product.down_quantity_url}"
          data-up-url="{$product.up_quantity_url}" data-update-url="{$product.update_quantity_url}"
          data-product-id="{$product.id_product}" type="text" value="{$product.quantity}" name="product-quantity-spin"
          min="{$product.minimal_quantity}" />

        {/if}
      </div>

    </div>
  </div>
  <!--  product left body: description -->
  <div class="product-line-grid-right product-line-actions col-md-2 d-flex align-items-center">
    <div class="price">
      <div class="product-price total">
        {if isset($product.is_gift) && $product.is_gift}
          <span class="gift">{l s='Gift' d='Shop.Theme.Checkout'}</span>
        {else}
          <span class="title_total hidden-sm-up">{l s='Subtotal' d='Shop.Theme.Checkout'}</span> {$product.total}
        {/if}
      </div>
    </div>

  </div>
</div>