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
<div id="js-product-list-top" class="products-selection">
  <div class="col-md-6 col-xs-6 hidden-sm-down">
    {* d-none d-md-block *}
    <!-- <div class="change-type">
      <span class="grid-type active" data-view-type="grid"><i class="fa fa-th-large"></i></span>
      <span class="list-type" data-view-type="list"><i class="fa fa-bars"></i></span>
    </div> -->
    <div class=" total-products ">
      {* hidden-sm-down *}
      {if $listing.products|count > 1}
        <p>
          {l s='There are %product_count% products.' d='Shop.Theme.Catalog' sprintf=['%product_count%' => $listing.products|count]}
        </p>
      {else}
        <p>
          {l s='There is 1 product.' d='Shop.Theme.Catalog' sprintf=['%product_count%' => $listing.products|count]}
        </p>
      {/if}
    </div>
  </div>
  <div class="col-md-6 col-xs-8">
    <div class="d-flex sort-by-row justify-content-end">
      {block name='sort_by'}
        {include file='catalog/_partials/sort-orders.tpl' sort_orders=$listing.sort_orders}
      {/block}
    </div>
  </div>
  {if !empty($listing.rendered_facets)}
    <div class="col-sm-3 hidden-md-up  text-center pl-0 pr-0">
      {* filter-button *}
      <button id="search_filter_toggler" class="btn btn-secondary filterTopBtn">
        {l s='Filter' d='Shop.Theme.Actions'}
      </button>
    </div>
  {/if}

  {* <div class="col-sm-12 hidden-md-up text-xs-center showing">
    {l s='Showing %from%-%to% of %total% item(s)' d='Shop.Theme.Catalog' sprintf=[
      '%from%' => $listing.pagination.items_shown_from ,
      '%to%' => $listing.pagination.items_shown_to,
      '%total%' => $listing.pagination.total_items
      ]}
  </div> *}

</div>