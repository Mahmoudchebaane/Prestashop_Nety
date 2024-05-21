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
  {if $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-1'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-2'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-4'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-5'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-6'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-9'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-12'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-14'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-15'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-16'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-17'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-18'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-19'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-22'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-27'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-28'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-29'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-30'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-32'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-34'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-35'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-36'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-37'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-38'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-39'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-40'
  || $novconfig.novthemeconfig_header_style && $novconfig.novthemeconfig_header_style == 'style-41'
  }
  <div id="_desktop_currency_selector" class="currency-selector groups-selector hidden-sm-down">
    <div class="title_header">
      {l s='Currency' d='Shop.Theme.Customeraccount'}
    </div>
    <ul class="list-inline">
      {foreach from=$currencies item=currency}
      <li {if $currency.current} class="current list-inline-item" {/if}>
        <a title="{$currency.name}" rel="nofollow" href="{$currency.url}">{$currency.iso_code}</a>
      </li>
      {/foreach}
    </ul>
  </div>
  {else}
  <div id="_desktop_currency_selector"
    class="currency-selector groups-selector hidden-sm-down currentcy-selector-dropdown">
    <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="main">
      <span class="expand-more">{$current_currency.iso_code}</span>
    </div>
    <div class="currency-list dropdown-menu">
      <div class="currency-list-content text-left">
        {foreach from=$currencies item=currency}
        <div class="currency-item{if $currency.current} current flex-first{/if}">
          <a title="{$currency.name}" rel="nofollow" href="{$currency.url}">{$currency.sign} {$currency.iso_code}</a>
        </div>
        {/foreach}
      </div>
    </div>
  </div>
  {/if}