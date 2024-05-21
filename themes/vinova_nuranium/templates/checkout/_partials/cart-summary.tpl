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

<div id="js-checkout-summary" class="cart-summary js-cart" data-refresh-url="{$urls.pages.cart}?ajax=1&action=refresh">
  {block name='hook_checkout_summary_top'}
    {hook h='displayCheckoutSummaryTop'}
  {/block}
  {block name='cart_summary_products'}
  <div class="nov-cart-summary-products {if $page.page_name != "checkout"} pr-30 pl-30 mb-20{else}pr-10 pl-10{/if}">
    <h2 class="summaryTitle">{l s='Cart summary' d='Shop.Theme.Actions'}</h2>
      <div class="summary-label d-flex align-items-center justify-content-between">
        <span>{if $cart.products_count > 1}{l s='There are %cart_item% items in your cart' sprintf=['%cart_item%' => $cart.products_count] d='Shop.Theme.Checkout'}{else}{l s='There is %cart_item% item in your cart' sprintf=['%cart_item%' => $cart.products_count] d='Shop.Theme.Checkout'}{/if}</span>
        <span class="show-details {if $page.page_name != "checkout"}ml-auto{/if}">
          <a href="#" data-toggle="collapse" data-target="#cart-summary-product-list">
          </a>
        </span>
      </div>
      {block name='cart_summary_product_list'}
        <div class="collapse in" id="cart-summary-product-list">
          <ul class="media-list">
            {foreach from=$cart.products item=product}
              <li class="media">{include file='checkout/_partials/cart-summary-product-line.tpl' product=$product}</li>
            {/foreach}
          </ul>
        </div>
      {/block}
    </div>
  {/block}

  {block name='cart_summary_totals'}
    {include file='checkout/_partials/cart-summary-totals.tpl' cart=$cart}
  {/block}
<button type="button" class="btn btn-primary backToShopping hidden-sm-up {if $page.page_name == "checkout"} d-none {/if}"
    data-dismiss="modal">{l s='Continue shopping' d='Shop.Theme.Actions'}</button>

</div>