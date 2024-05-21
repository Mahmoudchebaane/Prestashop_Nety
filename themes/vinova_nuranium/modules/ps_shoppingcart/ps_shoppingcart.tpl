<div id="_desktop_cart" onmouseover="desktopClick()" onmouseout="desktopout()">
  <div class="blockcart cart-preview" data-refresh-url="{$refresh_url}" >
    {if $novconfig.novthemeconfig_header_style == 'style-18'}
      <div class="open_header_cart_canvas hidden-sm-down">
        <i class="icon_cart"></i>

        <div class="cart-products-count">{$cart.products_count}</div>
      </div>
    {/if}
    <div id='_cartHeader'
      class="header-cart{if $novconfig.novthemeconfig_header_style == 'style-18'} hidden-md-up{/if} d-flex flex-row align-items-center">
      <div class="cart-left">
        {* <div class="shopping-cart">{l s='Cart Icon' d='Shop.Theme.Checkout'}</div> *}
        <i class="fa fa-shopping-cart" style="color: white; font-size:24px; padding: 0 10px"></i>
      </div>
      {* <span style="color: white;background-color: transparent;border: none;outline: none; padding: 0 10px">
        {l s='Nety shop' d='Shop.Theme.Checkout'}
      </span> *}
      <div class="cart-right">
        <span class="title-cart title_icon">{l s='My Cart' d='Shop.Theme.Checkout'}</span>
      </div>
      {if $cart.products_count > 0}
        <span class="cart-products-count">{$cart.products_count}</span>
      {/if}
      <span class="label-items d-xs-none">{l s='items' d='Shop.Theme.Checkout'}</span>
    </div>
    <div
      class="cart_block{if $novconfig.novthemeconfig_header_style == 'style-18'} header-cart-canvas{/if}{if $cart.products|count > 3} has-scroll{/if}" >
      {if $novconfig.novthemeconfig_header_style == 'style-18'}<div class="close_canvas cart hidden-sm-down"><i
          class="zmdi zmdi-close"></i></div>{/if}
      <div class="cart-block-content">
        {if $cart.products_count > 0}
          <ul>
            {foreach from=$cart.products item=product}
              <li>{include 'module:ps_shoppingcart/ps_shoppingcart-product-line.tpl' product=$product}</li>
            {/foreach}
          </ul>
          <div class="cart-total">
            <div>
              <span class="label">{$cart.totals.total.label}</span>
              <span class="value">{$cart.totals.total.value}</span>
            </div>
          </div>
          <div class="cart-buttons">
            {assign var="link" value = Context::getContext()->link }
            <a href="{$cart_url}"
              class="btn btn-primary btn-cart headerViewCart">{l s='View cart' d='Shop.Theme.Actions'}</a>
            <a class="btn btn-primary mb-5 btn-checkout headerCheckout"
              href="{$link->getPageLink('order')|escape:'html'}">
              {* <i class="fa fa-check-square-o" aria-hidden="true"></i> *}
              {l s='Order' d='Shop.Theme.Actions'}
              {* {l s='Check out' d='Shop.Theme.Actions'} *}
            </a>

          </div>
        {else}
          <div class="no-items">
            {l s='No products in the cart' d='Shop.Theme.Checkout'}
          </div>
        {/if}
      </div>
    </div>
  </div>
</div>

