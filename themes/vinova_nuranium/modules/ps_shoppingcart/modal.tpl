<div id="blockcart-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i
            class="fa fa-check"></i>{l s='Product successfully added to your shopping cart' d='Shop.Theme.Checkout'}
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="zmdi zmdi-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class=" divide-right px-0">
            <div class="row no-gutters h-100">
              <div class="imgContainer">
                <img class="product-image img-fluid " src="{$product.cover.bySize.cart_default.url}"
                  alt="{$product.cover.legend}" title="{$product.cover.legend}" itemprop="image">
              </div>
              <div class=" productDescription">

                <div class="product-name"><a href="{$product.url}">{$product.name}</a></div>
                <span>{l s='Quantity:' d='Shop.Theme.Checkout'}&nbsp;{$product.cart_quantity}</span>
                

                {foreach from=$product.attributes item="property_value" key="property"}
                  <span class="product-property">{$property}: {$property_value}</span><br>
                {/foreach}
                <div class="product-price">{$product.price}</div>
                {hook h='displayProductPriceBlock' product=$product type="unit_price"}


              </div>
            </div>
          </div>
          <div class=" divide-left text-xs-center">
            <div class="cart-content mb-25 ">
              {if $cart.products_count > 1}
                <p class="cart-products-count">
                  {l s='There are %products_count% items in your cart.' sprintf=['%products_count%' => $cart.products_count] d='Shop.Theme.Checkout'}
                </p>
              {else}
                <p class="cart-products-count">
                  {l s='There is %product_count% item in your cart.' sprintf=['%product_count%' =>$cart.products_count] d='Shop.Theme.Checkout'}
                </p>
              {/if}
              {* <p class="mb-5">{l s='Total products:' d='Shop.Theme.Checkout'}&nbsp;<span class="font-weight-bold">{$cart.subtotals.products.value}</span></p>
              <p class="mb-5">{l s='Total shipping:' d='Shop.Theme.Checkout'}&nbsp;<span class="font-weight-bold">{$cart.subtotals.shipping.value} {hook h='displayCheckoutSubtotalDetails' subtotal=$cart.subtotals.shipping}</span></p> *}
              {if $cart.subtotals.tax}
                <p class="mb-5">{$cart.subtotals.tax.label}&nbsp;<span
                    class="font-weight-bold">{$cart.subtotals.tax.value}</span></p>
              {/if}
              <p>{l s='Total:' d='Shop.Theme.Checkout'}&nbsp;<span
                  class="font-weight-bold">{$cart.subtotals.products.value}
                  {* {$cart.totals.total.value} *}
                </span>
                {* {$cart.labels.tax_short} *}
              </p>
            </div>

            <a href="{$link->getPageLink('cart')|escape:'html'}" class="btn btn-primary mb-5 goToCart">
              {* <i class="fa fa-check-square-o" aria-hidden="true"></i> *}
              {l s='View cart' d='Shop.Theme.Actions'}</a>
            <button type="button" class="btn btn-primary backToShopping"
              data-dismiss="modal">{l s='Continue shopping' d='Shop.Theme.Actions'}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>