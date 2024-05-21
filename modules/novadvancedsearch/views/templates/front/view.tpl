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
{extends file=$layout}


{block name='content'}

  <div id="main">
    {block name='page_header_container'}
      {block name='page_title'}
        <div class="page-header">
          <h1 class="page-title">{l s="Search results"}</h1>
        </div>
      {/block}
    {/block}

    {block name='page_content_container'}
      <section id="content" class="page-content">
        {block name='page_content_top'}{/block}
        {block name='page_content'}
            {if $products}
              <div class="row product_list grid no-flow">
              {include file='_partials/layout/items/item_one.tpl' class_item='col-lg-3 col-md-4' number_row=1}
                </div>
                
                {if $start!=$stop}
                    <nav class="pagination">
                        <ul class="page-list {$p}">
                            {if $p != 1}
                            {assign var='p_previous' value=$p-1}
                                <li id="pagination_previous"><a href="{$link->goPage($requestPage, $p_previous)}">« {l s=''}</a></li>
                            {else}
                                <li id="pagination_previous" class="disabled"><span>« {l s=''}</span></li>
                            {/if}

                            {if $start>3}
                                <li><a href="{$link->goPage($requestPage, 1)}">1</a></li>
                                <li class="truncate">...</li>
                            {/if}

                            {section name=pagination start=$start loop=$stop+1 step=1}
                                {if $p == $smarty.section.pagination.index}
                                    <li class="current"><span>{$p|escape:'htmlall':'UTF-8'}</span></li>
                                {else}
                                    <li><a href="{$link->goPage($requestPage, $smarty.section.pagination.index)}">{$smarty.section.pagination.index|escape:'htmlall':'UTF-8'}</a></li>
                                {/if}
                            {/section}

                            {if $pages_nb>$stop+2}
                                <li class="truncate">...</li>
                                <li><a href="{$link->goPage($requestPage, $pages_nb)}">{$pages_nb|intval}</a></li>
                            {/if}

                            {if $pages_nb > 1 AND $p != $pages_nb}
                            {assign var='p_next' value=$p+1}
                                <li id="pagination_next"><a href="{$link->goPage($requestPage, $p_next)}">{l s=''} »</a></li>
                            {else}
                                <li id="pagination_next" class="disabled"><span>{l s=''} »</span></li>
                            {/if}
                        </ul>
                    </nav>
                {/if}
               
          {else}
            {l s="Sorry for the inconvenience."}
          {/if}
        {/block}
      </section>
    {/block}

    {block name='page_footer_container'}
      <footer class="page-footer">
        {block name='page_footer'}
          <!-- Footer content -->
        {/block}
      </footer>
    {/block}

  </div>

{/block}
