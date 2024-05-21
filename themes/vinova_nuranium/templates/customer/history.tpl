
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

{block name='page_title'}
  {l s='My orders' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}


  <div class="">
    <div class="block_content-right pb-10 ml-0">
      {include file="customer/_partials/top-page.tpl"}
      <div style="margin:20px">   
        {* <p class="font-weight-bold mb-40"> {l s='Here are the orders you\'ve placed since your account was created.' d='Shop.Theme.Customeraccount'}</p> *}
        {if $orders}
          <table class="table table-striped table-bordered table-labeled hidden-sm-down ">
            <thead class="thead-default">
              <tr>
                <th>{l s='Order reference' d='Shop.Theme.Checkout'}</th>
                <th>{l s='Date' d='Shop.Theme.Checkout'}</th>
                <th>{l s='Total price' d='Shop.Theme.Checkout'}</th>
                <th class="hidden-sm-down">{l s='Payment' d='Shop.Theme.Checkout'}</th>
                <th class="hidden-sm-down">{l s='Status' d='Shop.Theme.Checkout'}</th>
                {* <th>{l s='Invoice' d='Shop.Theme.Checkout'}</th>
                <th>&nbsp;</th> *}
                <th class="hidden-sm-down">{l s='Actions' d='Shop.Theme.Checkout'}</th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$orders item=order}
              
                <tr>
                  <th scope="row">{$order.details.reference}</th>
                  <td>{$order.details.order_date}</td>
                  <td class="text-xs-right">{$order.totals.total.value}</td>
                  <td class="hidden-sm-down">{$order.details.payment}</td>
                  <td class="hidden-sm-down">
                    <span class="label label-pill {$order.history.current.contrast}"
                      style="background-color:{$order.history.current.color}">
                      {$order.history.current.ostate_name}
                    </span>
                  </td>
                  <td class="text-xs-center hidden-sm-down d-flex justify-content-between">
                  <a href="{$order.details.details_url}" data-link-action="view-order-details">
                  {* {l s='Details' d='Shop.Theme.Customeraccount'} *}
                  <i class="fa fa-info-circle" aria-hidden="true"></i>

                </a>
                    {if $order.details.invoice_url}
                      <a href="{$order.details.invoice_url}">
                        {* <i class="material-icons">&#xE415;</i> *}
                        <i class="fa fa-download" aria-hidden="true"></i>
                      </a>
                    {else}

                    {/if}
                   
                  </td>
                  <td class="text-xs-center order-actions d-none">
                    <a href="{$order.details.details_url}" data-link-action="view-order-details">
                      {l s='Details' d='Shop.Theme.Customeraccount'}
                    </a>
                    {* {if $order.details.reorder_url}
                      <a href="{$order.details.reorder_url}">{l s='Reorder' d='Shop.Theme.Actions'}</a>
                    {/if} *}
                  </td>
                </tr>
              {/foreach}
            </tbody>
          </table>

          <div class="orders hidden-md-up">
            {foreach from=$orders item=order}
              <div class="order mb-xs-20">
                <div class="">{*row*}
                  <div class="col-xs-10 w-100">
                    <a class="w-100" href="{$order.details.details_url}">
                      <h3 class="referenceOrder">
                        <p>{l s='Reference' d='Shop.Theme.Customeraccount'}</p>{$order.details.reference}
                      </h3>
                    </a>
                    <div class="date">
                      <p>{l s='Date' d='Shop.Theme.Checkout'}</p>
                      {$order.details.order_date}
                    </div>
                    <div class="total">
                      <p>{l s='Total price' d='Shop.Theme.Checkout'}</p>{$order.totals.total.value}
                    </div>
                    <div class="status">
                      <p>{l s='Status' d='Shop.Theme.Checkout'}</p>
                      <span class="label label-pill {$order.history.current.contrast}"
                        style="background-color:{$order.history.current.color}">
                        {$order.history.current.ostate_name}
                      </span>
                    </div>
                  </div>
                  <div class="col-xs-2 details ">{*text-xs-right*}
                    <div>
                      <a href="{$order.details.details_url}" data-link-action="view-order-details"
                        title="{l s='Details' d='Shop.Theme.Customeraccount'}">
                        {* <i class="material-icons">&#xE8B6;</i> *}
                        {* <p>{l s='Details' d='Shop.Theme.Checkout'}</p> *}
                        <i class="fa fa-info-circle" aria-hidden="true"></i>

                      </a>
                      {if $order.details.invoice_url}
                        <a href="{$order.details.invoice_url}">
                          {* <i class="material-icons">&#xE415;</i> *}
                          <i class="fa fa-download" aria-hidden="true" class=""></i>
                        </a>
                      {else}

                      {/if}

                    </div>
                    {if $order.details.reorder_url}
                      <div class="d-none">
                        <a href="{$order.details.reorder_url}" title="{l s='Reorder' d='Shop.Theme.Actions'}">
                          {* <i class="material-icons">&#xE863;</i> *}
                        </a>
                      </div>
                    {/if}
                  </div>
                </div>
              </div>
            {/foreach}
          </div>
          {else}
            <div style="height: 105px;">{l s='You have never palced an orders' d='Shop.Theme.Actions'}</div>
        {/if}
      </div>

    </div>

  </div>
{/block}