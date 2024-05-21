{**
 * 2007-2016 PrestaShop
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
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<div id="search_filters">
  {foreach from=$facets item="facet"}
    {if $facet.displayed}
      <section class="facet{if $facet.label == "Size"} facet-size{/if}">
        <div class="facet-title hidden-sm-down">{if $facet.label == 'Brand'}{l s='Manufacture'}{else}{$facet.label}{/if}
        </div>
        {assign var=_expand_id value=10|mt_rand:100000}
        {assign var=_collapse value=true}
        {foreach from=$facet.filters item="filter"}
          {if $filter.active}{assign var=_collapse value=false}{/if}
        {/foreach}
        <div class="title hidden-md-up" data-target="#facet_{$_expand_id}" data-toggle="collapse" {if !$_collapse}
          aria-expanded="true" {/if}>
          <div class="facet-title">{$facet.label}</div>
          <span class="navbar-toggler collapse-icons">
            <i class="material-icons add">&#xE313;</i>
            <i class="material-icons remove">&#xE316;</i>
          </span>
        </div>
        {if $facet.widgetType !== 'dropdown'}
          <ul id="facet_{$_expand_id}" class="collapse{if !$_collapse} in{/if}">
            {foreach from=$facet.filters item="filter"}
              {if $filter.displayed}
                <li{if isset($filter.properties.color)} class="facet_color" {/if}{if $facet.label == "Size"} class="facet_size"
                {/if}>
                <label class="facet-label{if $filter.active} active {/if}">
                  {if $facet.multipleSelectionAllowed}
                    <span class="custom-checkbox">
                      <input data-search-url="{$filter.nextEncodedFacetsURL}" type="checkbox" {if $filter.active } checked {/if}>
                      {if isset($filter.properties.color)}
                        <span class="color{if $filter.label =='White'} white{/if}{if $filter.active } checked {/if}"
                          style="background-color:{$filter.properties.color}"><i
                            class="material-icons checkbox-checked">check</i></span>
                      {elseif isset($filter.properties.texture)}
                        <span class="color texture" style="background-image:url({$filter.properties.texture})"></span>
                      {else}
                        <span {if !$js_enabled} class="ps-shown-by-js" {/if}><i
                            class="material-icons checkbox-checked">check</i></span>
                      {/if}
                    </span>
                  {else}
                    <span class="custom-checkbox">
                      <input data-search-url="{$filter.nextEncodedFacetsURL}" type="checkbox" name="filter {$facet.label}"
                        {if $filter.active } checked {/if}>
                      <span {if !$js_enabled} class="ps-shown-by-js" {/if}><i
                          class="material-icons checkbox-checked">check</i></span>
                    </span>
                  {/if}

                  <a href="{$filter.nextEncodedFacetsURL}" class="_gray-darker search-link js-search-link" rel="nofollow">
                    {$filter.label}
                    {if $filter.magnitude}
                      <span class="magnitude">({$filter.magnitude})</span>
                    {/if}
                  </a>
                </label>
                </li>
              {/if}
            {/foreach}
        </ul>
      {else}
        <form>
          <input type="hidden" name="order" value="{$sort_order}">
          <select name="q">
            <option disabled selected hidden>{l s='(no filter)' d='Shop.Theme'}</option>
            {foreach from=$facet.filters item="filter"}
              {if $filter.displayed}
                <option {if $filter.active} selected value="{$smarty.get.q}" {else} value="{$filter.nextEncodedFacets}" {/if}>
                  {$filter.label}
                  {if $filter.magnitude}
                    ({$filter.magnitude})
                  {/if}
                </option>
              {/if}
            {/foreach}
          </select>
          {if !$js_enabled}
            <button class="ps-hidden-by-js" type="submit">
              {l s='Filter' d='Shop.Theme.Actions'}
            </button>
          {/if}
        </form>
      {/if}
    </section>
  {/if}
  {/foreach}
</div>
<div class="searchfilter-title d-none">{l s='Filter By' d='Shop.Theme.Actions'}</div>
<div id="_desktop_search_filters_clear_all" class="d-none clear-all-wrapper">
  <button data-search-url="{$clear_all_link}" class="btn btn-tertiary js-search-filters-clear-all">
    <i class="material-icons">&#xE14C;</i>
    <span>{l s='Clear all' d='Shop.Theme.Actions'}</span>
  </button>
</div>