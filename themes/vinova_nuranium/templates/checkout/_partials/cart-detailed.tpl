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


{block name='cart_detailed_product'}
  <div class="cart-overview js-cart" data-refresh-url="{url entity='cart' params=['ajax' => true, 'action' => 'refresh']}">
    {if $cart.products}
    <div class="group_title mb-30 hidden-sm-down">
      <div class="row">
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-6">
              <div class="label label-product">{l s='Article' d='Shop.Theme.Catalog'}</div>
            </div>
            {* <div class="col-md-5 d-flex"> *}
              <div class="label label-price col-md-2">{l s='Price' d='Shop.Theme.Catalog'}</div>
              <div class="label label-qty ml-auto col-md-2">{l s='Qty' d='Shop.Theme.Catalog'}</div>
            {* </div> *}
          </div>
        </div>
        <div class="col-md-2">
          <div class="label label-total  col-md-2">{l s='Total' d='Shop.Theme.Catalog'}</div>
        </div>
      </div>
    </div>
    <ul class="cart-items">
      {foreach from=$cart.products item=product}
        <li class="cart-item">
          {block name='cart_detailed_product_line'}
            {include file='checkout/_partials/cart-detailed-product-line.tpl' product=$product}
          {/block}
          {block name='cart_detailed_product_line'}
            {include file='checkout/_partials/cart-detailed-product-line-small.tpl' product=$product}
          {/block}
        </li>
        {if $product.customizations|count >1}<hr>{/if}
      {/foreach}
    </ul>
    {else}
      <span class="no-items px-5" >{l s='There are no more items in your cart' d='Shop.Theme.Checkout'}</span>
    {/if}
  </div>
{/block}