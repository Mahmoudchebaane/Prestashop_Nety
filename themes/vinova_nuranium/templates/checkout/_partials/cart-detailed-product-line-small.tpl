<div class="product-line-grid small-item  hidden-md-up"
  style="display: flex;align-items: flex-start;height: 100%;justify-content: space-between;">
  <span class="product-image media-middle">
    <img class="img-fluid" src="{$product.cover.bySize.cart_default.url}" alt="{$product.name|escape:'quotes'}">
  </span>
  <div class="" style="display: flex;flex-direction: column;justify-content: space-between;height: 130px">

    <div>
      <a class="label " href="{$product.url}"
        data-id_customization="{$product.id_customization|intval}">{$product.name}</a>

      {foreach from=$product.attributes key="attribute" item="value"}
        <div class="product-line-info variant ">
          <span class="label-atrr">{$attribute}:&nbsp;</span>
          <span class="value">{$value}</span>
        </div>
      {/foreach}
    </div>
    
    <div class=" product-price ">
      <span class="title_price hidden-sm-up d-none">{l s='Price' d='Shop.Theme.Checkout'}</span>
      {if $product.has_discount}
        <span class="value ">{$product.price}</span>
        {* <span class="promoTag"> {l s='Discount' d='Shop.Theme.Checkout'}</span> *}
        <span class="regularPrice">{$product.regular_price}</span>
      {else}
        <span class="value ">{$product.price}</span>
      {/if}
      {if $product.unit_price_full}
        <div class="unit-price-cart">{$product.unit_price_full}</div>
      {/if}
    </div>
 


    <div class="qty ml-auto ">
      {if isset($product.is_gift) && $product.is_gift}
        <span class="gift-quantity">{$product.quantity}</span>
      {else}
        <input id="quantity_wanted" class="js-cart-line-product-quantity" data-down-url="{$product.down_quantity_url}"
          data-up-url="{$product.up_quantity_url}" data-update-url="{$product.update_quantity_url}"
          data-product-id="{$product.id_product}" type="text" value="{$product.quantity}" name="product-quantity-spin"
          min="{$product.minimal_quantity}" />
      {/if}
    </div>
    <div class="price">
    <div class="product-price total">
      {if isset($product.is_gift) && $product.is_gift}
    
      {else}
         {$product.total}
      {/if}
    </div>
  </div>


  </div>

  <div class="remove ">
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
</div>