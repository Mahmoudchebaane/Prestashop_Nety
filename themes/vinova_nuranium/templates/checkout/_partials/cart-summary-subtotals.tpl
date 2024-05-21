<div class="cart-detailed-totals">

  {block name='cart_summary_total'}
    <div class="group-price">
      {foreach from=$cart.subtotals item="subtotal"}
      
        {if $subtotal != null}
        
          {if $subtotal.value && $subtotal.type !== 'tax'}
            <div class="cart-summary-line" id="cart-subtotal-{$subtotal.type}">
              <span class="label{if 'products' === $subtotal.type} js-subtotal{/if}">
                {if 'products' == $subtotal.type}
                  {l s="Total products" d='Shop.Theme.Checkout'}:
                {else}
                  {l s='Total %label_subtotal%' sprintf=['%label_subtotal%' => $subtotal.label] d='Shop.Theme.Checkout'}:
                {/if}
              </span>
              <span class="value">{$subtotal.value}</span>
              {if $subtotal.type === 'shipping'}
                <div><small class="value">{hook h='displayCheckoutSubtotalDetails' subtotal=$subtotal}</small></div>
              {/if}
            </div>
          {/if}
        {/if}
      {/foreach}
      {block name='cart_summary_total'}
        {if $cart.subtotals.tax != null}
          {if $cart.subtotals.tax.label != ""}
            <div class="cart-summary-line cart-tax">
              <span class="label sub">{$cart.subtotals.tax.label}:</span>
              <span class="value sub">{$cart.subtotals.tax.value}</span>
            </div>
          {/if}
        {/if}
      {/block}
    </div>
  {/block}
</div>