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

<div id="js-product-list">
    <div class="products product_list grid row no-flow" data-default-view="grid">
        {if $novconfig.novthemeconfig_category_layout == 'layout-one-column'}
            {include file='_partials/layout/items/item_categories.tpl' products=$listing.products class_item='col-lg-3 col-md-4 col-xs-6'}
        {else}
            {if isset($class_homepage) && $class_homepage && $class_homepage == 'home-36' || $class_homepage == 'home-35' || $class_homepage == 'home-34'}
                {include file='_partials/layout/items/item_categories.tpl' products=$listing.products class_item='col-lg-3 col-md-6 col-xs-6'}
            {else}
                {include file='_partials/layout/items/item_categories.tpl' products=$listing.products class_item='col-lg-4 col-md-6 col-xs-6'}
            {/if}
        {/if}
    </div>
</div>

