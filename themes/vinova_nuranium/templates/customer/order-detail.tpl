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
{extends file='customer/page.tpl'}
{block name='head_seo'}
  <title>{block name='head_seo_title'}{l s='Order details' d='Shop.Theme.Customeraccount'}{/block}</title>
{/block}
{block name='page_title'}
  {l s='Order details' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
  <div class="pt-30 pb-30 backHistory">
    <a href="{$urls.pages.history}"> 
    <i class="fa fa-chevron-left px-2"></i>
    {l s='Back to order list' d='Shop.Theme.Checkout'}
    </a>
  </div>
  <div class="d-flex align-items-center justify-content-between flex-wrap">
    {block name='order_infos'}
      <div id="order-infos">
        <div class="box mb-10">
          <div class="row">
            <div class="d-flex col-md-{if $order.details.reorder_url}9{else}12{/if}">
              <strong class="refOrder">
                {l
                          s='Order Reference %reference% - placed on %date%'
                          d='Shop.Theme.Customeraccount'
                          sprintf=['%reference%' => $order.details.reference, '%date%' => $order.details.order_date]
                        }
              </strong>
            </div>
            {* {if $order.details.reorder_url}
              <div class="col-md-3 text-md-right">
                <a href="{$order.details.reorder_url}" class="button-primary btn-reorder">{l s='Reorder' d='Shop.Theme.Actions'}</a>
              </div>
            {/if} *}
            <div class="clearfix"></div>
          </div>
        </div>

        <div class="">{*box mb-20*}
          <ul>
            <li><strong>{l s='Carrier' d='Shop.Theme.Checkout'}</strong> {$order.carrier.name}</li>
            <li><strong>{l s='Payment method' d='Shop.Theme.Checkout'}</strong> {$order.details.payment}</li>

            {if $order.details.invoice_url}
              <li>
                <a href="{$order.details.invoice_url}">
                  {l s='Download your invoice as a PDF file.' d='Shop.Theme.Customeraccount'}
                </a>
              </li>
            {/if}

            {if $order.details.recyclable}
              <li>
                {l s='You have given permission to receive your order in recycled packaging.' d='Shop.Theme.Customeraccount'}
              </li>
            {/if}

            {if $order.details.gift_message}
              <li>{l s='You have requested gift wrapping for this order.' d='Shop.Theme.Customeraccount'}</li>
              <li>{l s='Message' d='Shop.Theme.Customeraccount'} {$order.details.gift_message nofilter}</li>
            {/if}
          </ul>
        </div>
      </div>
    {/block}

    {block name='order_history'}
      <section id="order-history" class="box">
        <h3 class="mt-15">{l s='Follow your order\'s status step-by-step' d='Shop.Theme.Customeraccount'}</h3>
        <table class="table table-striped table-bordered table-labeled ">
          <thead class="thead-default">
            <tr>
              <th>{l s='Date' d='Shop.Theme.Checkout'}</th>
              <th>{l s='Status' d='Shop.Theme.Checkout'}</th>
            </tr>
          </thead>
          <tbody>
          
          {assign var="hist" value=$order->getHistory(0)}        
          
            {foreach from=$order.history item=state}
              <tr>
                <td>{$state.history_date}</td>
                <td>
                  <span class="label label-pill {$state.contrast}" style="background-color:{$state.color}; color: #fff;">
                    {$state.ostate_name}
                  </span>
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
        <div class="hidden-sm-up history-lines d-none">
          {foreach from=$order.history item=state}
            <div class="history-line">
              <div class="date">
                <p style="font-weight:600">{l s='Date' d='Shop.Theme.Checkout'}:&nbsp;</p>{$state.history_date}
              </div>
              <div class="state">
                <span class="label label-pill {$state.contrast}" style="background-color:{$state.color}; color: #fff;">
                  {$state.ostate_name}
                </span>
              </div>
            </div>
          {/foreach}
        </div>
      </section>
    {/block}
  </div>
  {if $order.follow_up}
    <div class="box">
      <p>{l s='Click the following link to track the delivery of your order' d='Shop.Theme.Customeraccount'}</p>
      <a href="{$order.follow_up}">{$order.follow_up}</a>
    </div>
    <hr>
  {/if}
  <hr>
  {block name='addresses'}
    <h3> {l s='List of addresses' d='Shop.Theme.Checkout'}</h3>
    <div class="addresses row mt-10 mb-20">
      {if $order.addresses.delivery}
        <div class="col-lg-3 col-md-6 col-sm-6">
          <article id="delivery-address" class="box">
            {* <h4>{l s='Delivery address %alias%' d='Shop.Theme.Checkout' sprintf=['%alias%' => $order.addresses.delivery.alias]}</h4> *}
            <h4>{l s='Delivery address' d='Shop.Theme.Checkout'}</h4>
            <h5> {$order.addresses.delivery.alias}</h5>

            <address>{$order.addresses.delivery.formatted nofilter}</address>
          </article>
        </div>
      {/if}

      <div class="col-lg-6 col-md-6 col-sm-6">
        <article id="invoice-address" class="box">
          {* <h4>{l s='Invoice address %alias%' d='Shop.Theme.Checkout' sprintf=['%alias%' => $order.addresses.invoice.alias]}</h4> *}
          <h4>{l s='Invoice address' d='Shop.Theme.Checkout'}</h4>
          <h5>{$order.addresses.invoice.alias}</h5>


          <address>{$order.addresses.invoice.formatted nofilter}</address>
        </article>
      </div>
      <div class="clearfix"></div>
    </div>
  {/block}

  {$HOOK_DISPLAYORDERDETAIL nofilter}
  <hr>
  {block name='order_detail'}
    {if $order.details.is_returnable}
      {include file='customer/_partials/order-detail-return.tpl'}
    {else}
      {include file='customer/_partials/order-detail-no-return.tpl'}
    {/if}
  {/block}
  <hr>
  {block name='order_carriers'}
    {if $order.shipping}
      <div class="box">
        <h3>{l s='Shipping' d='Shop.Theme.Checkout'}</h3>
        <table class="table table-striped table-bordered ">{*hidden-sm-down*}
          <thead class="thead-default">
            <tr>
              <th>{l s='Date' d='Shop.Theme.Checkout'}</th>
              <th>{l s='Carrier' d='Shop.Theme.Checkout'}</th>
              {* <th>{l s='Weight' d='Shop.Theme.Checkout'}</th> *}
              <th>{l s='Shipping cost' d='Shop.Theme.Checkout'}</th>
              {* <th>{l s='Tracking number' d='Shop.Theme.Checkout'}</th> *}
            </tr>
          </thead>
          <tbody>
            {foreach from=$order.shipping item=line}
              <tr>
                <td>{$line.shipping_date}</td>
                <td>{$line.carrier_name}</td>
                {* <td>{$line.shipping_weight}</td> *}
                <td>{$line.shipping_cost}</td>
                {* <td>{$line.tracking nofilter}</td> *}
              </tr>
            {/foreach}
          </tbody>
        </table>
        <div class="hidden-md-up shipping-lines d-none">
          {foreach from=$order.shipping item=line}
            <div class="shipping-line">
              <ul>
                <li>
                  <strong>{l s='Date' d='Shop.Theme.Checkout'}</strong> {$line.shipping_date}
                </li>
                <li>
                  <strong>{l s='Carrier' d='Shop.Theme.Checkout'}</strong> {$line.carrier_name}
                </li>
                {* <li>
                  <strong>{l s='Weight' d='Shop.Theme.Checkout'}</strong> {$line.shipping_weight}
                </li> *}
                <li>
                  <strong>{l s='Shipping cost' d='Shop.Theme.Checkout'}</strong> {$line.shipping_cost}
                </li>
                <li>
                  <strong>{l s='Tracking number' d='Shop.Theme.Checkout'}</strong> {$line.tracking}
                </li>
              </ul>
            </div>
          {/foreach}
        </div>
      </div>
    {/if}
  {/block}
  <hr>
  {block name='order_messages'}
    {include file='customer/_partials/order-messages.tpl'}
  {/block}
{/block}