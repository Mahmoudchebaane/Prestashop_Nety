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
  {l s='Credit slips' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
  <div class="page_title_account">{l s='Your account' d='Shop.Theme.Customeraccount'}</div>
  <div class="row">
    <div class="col-md-3">
      {include file="customer/_partials/list-link-account.tpl"}
    </div>
    <div class="col-md-9 mt-xs-30">
      <div class="block_content-right">
      {include file="customer/_partials/top-page.tpl"}
        {* <div class="title_account_second d-flex">{l s='Credit slips' d='Shop.Theme.Customeraccount'}</div> *}

        {block name='customer_notifications'}
          {include file='_partials/notifications.tpl'}
        {/block}

        <p class="font-weight-bold mb-40">{l s='Credit slips you have received after canceled orders.' d='Shop.Theme.Customeraccount'}</p>
        {if $credit_slips}
          <table class="table table-striped table-bordered hidden-sm-down">
            <thead class="thead-default">
              <tr>
                <th>{l s='Order' d='Shop.Theme.Customeraccount'}</th>
                <th>{l s='Credit slip' d='Shop.Theme.Customeraccount'}</th>
                <th>{l s='Date issued' d='Shop.Theme.Customeraccount'}</th>
                <th>{l s='View credit slip' d='Shop.Theme.Customeraccount'}</th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$credit_slips item=slip}
                <tr>
                  <td><a href="{$slip.order_url_details}" data-link-action="view-order-details">{$slip.order_reference}</a></td>
                  <td scope="row">{$slip.credit_slip_number}</td>
                  <td>{$slip.credit_slip_date}</td>
                  <td class="text-xs-center">
                    <a href="{$slip.url}"><i class="material-icons">&#xE415;</i></a>
                  </td>
                </tr>
              {/foreach}
            </tbody>
          </table>
          <div class="credit-slips hidden-md-up">
            {foreach from=$credit_slips item=slip}
              <div class="credit-slip">
                <ul>
                  <li>
                    <strong>{l s='Order' d='Shop.Theme.Customeraccount'}</strong>
                    <a href="{$slip.order_url_details}" data-link-action="view-order-details">{$slip.order_reference}</a>
                  </li>
                  <li>
                    <strong>{l s='Credit slip' d='Shop.Theme.Customeraccount'}</strong>
                    {$slip.credit_slip_number}
                  </li>
                  <li>
                    <strong>{l s='Date issued' d='Shop.Theme.Customeraccount'}</strong>
                    {$slip.credit_slip_date}
                  </li>
                  <li>
                    <a href="{$slip.url}">{l s='View credit slip' d='Shop.Theme.Customeraccount'}</a>
                  </li>
                </ul>
              </div>
            {/foreach}
          </div>
        {/if}
      </div>
    </div>
  </div>
  
{/block}
