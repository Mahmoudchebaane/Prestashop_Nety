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
{extends "customer/_partials/customer-form.tpl"}

{block "form_field"}
  {if $field.name === 'password' and $guest_allowed}
    <div class="desc-password">
      <span class="font-weight-bold">{l s='Create an account' d='Shop.Theme.Checkout'}</span>
      {* <span>{l s='(optional)' d='Shop.Theme.Checkout'}</span> *}
      <br>
      <span class="text-muted">{l s='And save time on your next order!' d='Shop.Theme.Checkout'}</span>
    </div>
    {$smarty.block.parent}
  {elseif $field.name === 'birthday'}
    <div class='hidden-comment'>
      {$smarty.block.parent}
    </div>
  {else}
    {$smarty.block.parent}
  {/if}
{/block}

{block "form_buttons"}
  <button class="continue btn btn-primary pull-xs-right" name="continue" data-link-action="register-new-customer"
    type="submit" value="1">
    {l s='Continue' d='Shop.Theme.Actions'}
  </button>
{/block}