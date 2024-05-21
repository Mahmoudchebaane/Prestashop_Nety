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
* @author PrestaShop SA <contact@prestashop.com>
  * @copyright 2007-2016 PrestaShop SA
  * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
  * International Registered Trademark & Property of PrestaShop SA
  *}



  {extends file='catalog/listing/product-list.tpl'}

  {block name='product_list_header'}
  {if $novconfig.novthemeconfig_category_image == 1 || $novconfig.novthemeconfig_category_desc == 1 ||
  $novconfig.novthemeconfig_category_title == 1 }
  <div class="block-category hidden-sm-down">
    {if isset($novconfig.novthemeconfig_category_title) && $novconfig.novthemeconfig_category_title == 1}
    <h1 class="h1 d-none">{$category.name}</h1>
    {/if}
    {if $category.description && isset($novconfig.novthemeconfig_category_desc) &&
    $novconfig.novthemeconfig_category_desc == 1}
    <div id="category-description" class="text-muted">{$category.description nofilter}</div>
    {/if}
    {if isset($novconfig.novthemeconfig_category_image) && $novconfig.novthemeconfig_category_image == 1}
    <div class="category-cover">
      <img class="img-fluid" src="{$category.image.large.url}" alt="{$category.image.legend}">
    </div>
    {/if}
  </div>
  {/if}

  {/block}