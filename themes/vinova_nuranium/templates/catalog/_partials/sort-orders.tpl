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

<span class="hidden-sm-down sort-by">{l s='Sort by:' d='Shop.Theme.Global'}</span>
{*<div
    class="{if !empty($listing.rendered_facets)}col-sm-9 col-xs-8{else}col-sm-12 col-xs-12{/if} col-md-9 products-sort-order dropdown">
    *}
<div class="products-sort-order dropdown ">
  <button class="btn-unstyle select-title  " rel="follow" data-toggle="dropdown" aria-haspopup="true"
    aria-expanded="true">
    <span>{if isset($listing.sort_selected)}{$listing.sort_selected}
      {else}
        {l s='Select' d='Shop.Theme.Actions'}
      {/if}</span>
    <i class="material-icons pull-xs-right">&#xE5C5;</i>

  </button>

  <div class="dropdown-menu" role="menu">
    {foreach from=$listing.sort_orders item=sort_order}
      <a rel="nofollow" href="{$sort_order.url}"
        class="select-list {['current' => $sort_order.current, 'js-search-link' => true]|classnames}">
        {$sort_order.label}
      </a>
    {/foreach}
  </div>

</div>