{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
  * @copyright 2007-2015 PrestaShop SA
  * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
  * International Registered Trademark & Property of PrestaShop SA
  *}

  <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
    <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
      aria-expanded="false" id="_desktop_user_info">
    </div>

    <div class="account-list dropdown-menu" aria-labelledby="dropdownMenuButton" id="_desktop_account_list">
      <div class="account-list-content">
        {if $nov_customer.logged}
        <div>
          <a class="account" href="{$link->getPageLink('my-account', true)}"
            title="{l s='View my customer account' d='Modules.Customeraccount'}" rel="nofollow"><i
              class="fa fa-cog"></i>{$nov_customer.customerName}</a>
        </div>
        <div>
          <a class="logout" href="{$link->getPageLink('index', true, null, 'mylogout')}" rel="nofollow"
            title="{l s='Log me out' d='Shop.Theme.Customeraccount'}"><i class="fa fa-sign-out"></i>{l s='Sign out'
            d='Modules.Customeraccount'}</a>
        </div>
        {else}
        <div>
          <a class="login" href="{$link->getPageLink('my-account', true)}" rel="nofollow"
            title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}"><i class="fa fa-cog"></i>{l
            s='My Account' d='Modules.Customeraccount'}</a>
        </div>
        <div>
          <a class="login" href="{$link->getPageLink('my-account', true)}" rel="nofollow"
            title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}"><i
              class="fa fa-sign-in"></i>{l s='Sign in' d='Modules.Customeraccount'}</a>
        </div>
        {/if}
        <div>
          <a class="register" href="{$link->getPageLink('my-account', true)}" rel="nofollow"
            title="{l s='Register Account' d='Modules.Customeraccount'}"><i class="fa fa-user"></i>{l s='Register
            Account' d='Modules.Customeraccount'}</a>
        </div>
        <div>
          <a class="check-out" href="{$link->getPageLink('order')|escape:'html'}" rel="nofollow"
            title="{l s='Checkout' d='Modules.Customeraccount'}"><i class="material-icons">check_circle</i>{l
            s='Checkout' d='Modules.Customeraccount'}</a>
        </div>
        {* <div class="link_wishlist">
          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
            title="{l s='My Wishlists' mod='novblockwishlist'}">
            <i class="fa fa-heart"></i>{l s='My Wishlists' d='Modules.Customeraccount'}
          </a>
        </div> *}

      </div>
    </div>
  </div>