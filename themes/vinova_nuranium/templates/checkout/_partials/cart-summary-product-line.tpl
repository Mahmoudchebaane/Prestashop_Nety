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
{block name='cart_summary_product_line'}
  <div class="media-left d-flex">
    <a href="{$product.url}" title="{$product.name}">
      <img class="media-object" src="{$product.cover.small.url}" alt="{$product.name}">
    </a>
  </div>
  <div class="media-body d-lg-flex cart-summary-product-list justify-content-between">
    <div class="product-name"><a href="{$product.url}">{$product.name}</a></div>
    <div>
      <div class="product-price pull-xs-right">{$product.price}</div>
      <div class="product-quantity">x{$product.quantity}</div>
      {hook h='displayProductPriceBlock' product=$product type="unit_price"}
    </div>
  </div>
{/block}
