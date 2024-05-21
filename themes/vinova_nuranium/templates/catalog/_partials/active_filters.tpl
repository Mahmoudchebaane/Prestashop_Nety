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
<section id="js-active-search-filters" class="{if $activeFilters|count}active_filters{else}hide{/if}">
  <h1 class="h5 active-filter-title">{l s='Active filters' d='Shop.Theme.Catelog'}</h1>
  {if $activeFilters|count}
    <ul>
      {foreach from=$activeFilters item="filter"}
        <li class="filter-block filterBlock">
          {*
        	<span>{l s='%1$s: ' d='Shop.Theme.Catalog' sprintf=[$filter.facetLabel]} {$filter.label}</span>
          *}
          <span>{$filter.label}</span>
          <a class="js-search-link" href="{$filter.nextEncodedFacetsURL}"><i class="zmdi zmdi-close"></i></a>
        </li>
      {/foreach}
      <li id="_desktop_search_filters_clear_all" class="hidden-sm-down clear-all-wrapper filter-block">
        <span data-search-url="{$clear_all_link}" class="js-search-filters-clear-all">
          {l s='Clear all' d='Shop.Theme.Actions'}
          <i class="zmdi zmdi-close"></i>
        </span>
      </li>
    </ul>
  {/if}
</section>