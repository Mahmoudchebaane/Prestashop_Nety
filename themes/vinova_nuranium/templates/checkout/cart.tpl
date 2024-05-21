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
{extends file=$layout}

{block name='content'}
  <section id="main">
  <i class="fa fa-cart-shopping"></i>
        <h1 class="page-title">   
           <i class="fa fa-shopping-cart"> </i>
        {l s='Shopping Cart' d='Shop.Theme.Checkout'}
        </h1>
    <div class="cart-grid row no-flow">

      <!-- Left Block: cart product informations & shpping -->
      <div class="cart-grid-body col-lg-8">
      
        <!-- cart products detailed -->
        <div class="cart-container">
          
          {block name='cart_overview'}
            {include file='checkout/_partials/cart-detailed.tpl' cart=$cart}
          {/block}
        </div>

        {block name='continue_shopping'}
          <a class="label btn continue_shopping hidden-md-down" href="{$urls.pages.index}">
          {* <i class="fa fa-chevon-left"></i> *}
          <i class="fa fa-chevron-left"></i>
            {l s='Continue shopping' d='Shop.Theme.Actions'}
          </a>
        {/block}


        <!-- shipping informations -->
        {block name='hook_shopping_cart_footer'}
          {hook h='displayShoppingCartFooter'}
        {/block}
      </div>

      <!-- Right Block: cart subtotal & cart total -->
      <div class="cart-grid-right col-lg-4 mt-sm-30">

        {block name='cart_summary'}
          <div class="cart-summary">

            {block name='hook_shopping_cart'}
            {hook h='displayShoppingCart'}
            {/block}

            {block name='cart_totals'}
              {include file='checkout/_partials/cart-detailed-totals.tpl' cart=$cart}
            {/block}

            {block name='cart_actions'}
              {include file='checkout/_partials/cart-detailed-actions.tpl' cart=$cart}
            {/block}
          </div>
          {block name='continue_shopping'}
            <a class="label btn continue_shopping hidden-lg-up" href="{$urls.pages.index}">
            {* <i class="fa fa-chevon-left"></i> *}
            <i class="fa fa-chevron-left"></i>
              {l s='Continue shopping' d='Shop.Theme.Actions'}
            </a>
          {/block}
        {/block}
     
        {block name='hook_reassurance'}
          {hook h='displayReassurance'}
        {/block}
      </div>

    </div>
  </section>
{/block}
