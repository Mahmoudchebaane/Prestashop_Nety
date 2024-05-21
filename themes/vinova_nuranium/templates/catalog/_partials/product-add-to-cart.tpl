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
<div class="product-add-to-cart">

  {if !$configuration.is_catalog}
    {*<span class="control-label">{l s='QTY' d='Shop.Theme.Catalog'} : </span>*}
    {block name='product_quantity'}
      <div class="product-quantity">
        <div class=" qty">
          {* <span>{l s='Quantity' d='Shop.Theme.Catalog'}</span> *}
          <span></span>
          <input {* type="number" *} name="qty" id="quantity_wanted" inputmode="numeric" pattern="[0-9]*"
            {if $product.quantity_wanted} value="{$product.quantity_wanted}" min="{$product.minimal_quantity}" 
            {else}
            value="1" min="1" {/if} class="input-group " aria-label="{l s='Quantity' d='Shop.Theme.Actions'}"
            {if !$product.add_to_cart_url} disabled {/if} style="pointer-events: none;">
        </div>


        <div class="add">
          <button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit"
            {if !$product.add_to_cart_url || $product.quantity_wanted > $product.quantity} disabled {/if}>
            <!-- <i class="novicon-cart"></i> -->
            <i class="fa fa-shopping-cart custom"></i>
            <span>{l s='Add to cart' d='Shop.Theme.Actions'}</span>
          </button>
          {* {hook h='displayProductListFunctionalButtons' product=$product} *}
        </div>
      </div>
      <div class="clearfix"></div>
    {/block}

    {* {($product.quantity <= $configuration.low_quantity_threshold)|dump} *}
    {if $product.show_availability}
      <div class="product-availability" id="product-availability">
        <label class="control-label d-none">{l s='Availability: ' d='Shop.Theme.Actions'}</label>
        {* {if $product.quantity_wanted < $product.quantity} *}
          {if $product.availability == 'available' }
            <span class="product-available">
              <i class="fa fa-check-square-o"></i>
              {$product.availability_message}
            </span>
          {elseif $product.availability == 'last_remaining_items' }
            <span class="d-none product-last-items">
              <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
              {$product.availability_message}
            </span>
          
        {else}
          <span class="product-unavailable">
            <i class="fa fa-ban" aria-hidden="true"></i>
            {$product.availability_message}
          </span>
        {/if}
      </div>
    {/if}

  {/if}
</div>