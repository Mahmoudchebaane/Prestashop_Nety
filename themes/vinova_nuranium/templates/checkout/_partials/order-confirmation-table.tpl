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
{block name='order_items_table_head'}
  <h3 class="card-title h3">{l s='Order items' d='Shop.Theme.Checkout'}</h3>
{/block}
<div id="order-items" class="col-md-6">
  <div class="order-confirmation-table">
    <div class="col-md-6 order-line-container">
      {block name='order_confirmation_table'}
        {foreach from=$products item=product}
          <div class="order-line row align-items-center ">
            <div class="col-sm-2 col-xs-3">
              <span class="image">
                <img src="{$product.cover.medium.url}" />
              </span>
            </div>
            <div class="col-sm-4 col-xs-3 details font-weight-bold">
              {if $add_product_link}<a href="{$product.url}" target="_blank">{/if}
                <span class="d-flex flex-column">
                  {* {$product.name} *}
                  {if $product.name }
                    {assign var="teststring" value={$product.name}}
                    {assign var="testsplit" value="("|explode:$teststring}
                    {if $testsplit|@count gt 1}
                      <span>{$testsplit[0]} </span>
                      <span>
                        {if $testsplit}
                          {assign var="teststring1" value=$testsplit[1]}
                          {assign var="testsplit1" value=")"|explode:$teststring1}
                        {/if}
                        {$testsplit1[0]}
                      </span>
                    {else}
                      <span>{$testsplit[0]} </span>
                    {/if}                    
                  {/if}
                </span>
                {if $add_product_link}</a>{/if}
              {if $product.customizations|count}
                {foreach from=$product.customizations item="customization"}
                  <div class="customizations">
                    <a href="#" data-toggle="modal"
                      data-target="#product-customizations-modal-{$customization.id_customization}">{l s='Product customization' d='Shop.Theme.Catalog'}</a>
                  </div>
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
                            <div class="product-customization-line row">
                              <div class="col-sm-3 col-xs-4 label">
                                {$field.label}
                              </div>
                              <div class="col-sm-9 col-xs-8 value">
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
              {/if}
              {hook h='displayProductPriceBlock' product=$product type="unit_price"}
            </div>
            <div class="col-sm-6 col-xs-3 qty ">
              <div class="row">
                <div class="col-sm-5 text-sm-right price-order-confirmation">{$product.price}</div>
                <div class="col-sm-2 d-none">{$product.quantity}</div>
                <div class="col-sm-5 text-sm-right font-weight-bold d-none">{$product.total}</div>
              </div>
            </div>
          </div>

        {/foreach}
      </div>
      <hr class="hidden-sm-down">

      <table class="col-md-6">
        {foreach $subtotals as $subtotal}
          {if $subtotal.type !== 'tax'}
            <tr>
              <td>{$subtotal.label}</td>
              <td class="font-weight-bold">{$subtotal.value}</td>
            </tr>
          {/if}
        {/foreach}
        {if $subtotals.tax.label !== null}
          <tr class="sub">
            <td>{$subtotals.tax.label}</td>
            <td class="font-weight-bold">{$subtotals.tax.value}</td>
          </tr>
        {/if}
        <tr class="font-weight-bold total_price_order">
          <td><span class="text-uppercase">{$totals.total.label}</span> {$labels.tax_short}</td>
          <td>{$totals.total.value}</td>
        </tr>
      </table>
    {/block}

  </div>
</div>