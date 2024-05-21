{*
* 2007-2014 PrestaShop
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
    * @copyright 2007-2014 PrestaShop SA
    * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
    * International Registered Trademark & Property of PrestaShop SA
    *}
    <!-- block seach mobile -->
    {if isset($hook_mobile)}
    <div class="input_search" data-role="fieldcontain">
        <form method="get" action="{$link->getModuleLink('novadvancedsearch', 'result')|escape:'html'}" id="searchbox">
            <input type="hidden" name="controller" value="search" />
            <input type="hidden" name="orderby" value="position" />
            <input type="hidden" name="orderway" value="desc" />
            <input class="search_query" type="search" id="search_query_top" name="search_query"
                placeholder="{l s='Search' d='Modules.Novadvancedsearch.Search'}"
                value="{$search_query|escape:'html':'UTF-8'|stripslashes}" />
        </form>
    </div>
    {else}
    <!-- Block search module TOP -->

    <div id="desktop_search_content"
        class="{if $novconfig.novthemeconfig_header_style == 'style-1' || $novconfig.novthemeconfig_header_style == 'style-2' || $novconfig.novthemeconfig_header_style == 'style-3' || $novconfig.novthemeconfig_header_style == 'style-4' || $novconfig.novthemeconfig_header_style == 'style-9' || $novconfig.novthemeconfig_header_style == 'style-10' || $novconfig.novthemeconfig_header_style == 'style-11' || $novconfig.novthemeconfig_header_style == 'style-12' || $novconfig.novthemeconfig_header_style == 'style-11' || $novconfig.novthemeconfig_header_style == 'style-13' || $novconfig.novthemeconfig_header_style == 'style-14' || $novconfig.novthemeconfig_header_style == 'style-15' || $novconfig.novthemeconfig_header_style == 'style-17' || $novconfig.novthemeconfig_header_style == 'style-19' || $novconfig.novthemeconfig_header_style == 'style-20' || $novconfig.novthemeconfig_header_style == 'style-21' || $novconfig.novthemeconfig_header_style == 'style-22' || $novconfig.novthemeconfig_header_style == 'style-23' || $novconfig.novthemeconfig_header_style == 'style-24'}style_1{else}style_2{/if}"
        data-id_lang="{$id_lang}" data-ajaxsearch="{$ajaxsearch}"
        data-novadvancedsearch_type="{$novadvancedsearch_type}" data-instantsearch="{$instantsearch}"
        data-search_ssl="{$search_ssl}"
        data-link_search_ssl="{if $search_ssl == 1}{$link->getPageLink('search', true)|addslashes}{else}{$link->getPageLink('search')|addslashes}{/if}"
        data-action="{$link->getModuleLink('novadvancedsearch', 'result')|escape:'html'}">
        <div class="toggle-search"><i class="icon-header-search"></i>
            {if isset($class_homepage) && $class_homepage == 'home-40'}
            <span class="d-block title_icon">{l s='Search' d='Modules.Novadvancedsearch.Search'}</span>
            {/if}
        </div>
        <form method="get" action="{$link->getModuleLink('novadvancedsearch', 'result')|escape:'html'}" id="searchbox"
            class="form-novadvancedsearch">
            <input type="hidden" name="fc" value="module">
            <input type="hidden" name="module" value="novadvancedsearch">
            <input type="hidden" name="controller" value="result">
            <input type="hidden" name="orderby" value="position" />
            <input type="hidden" name="orderway" value="desc" />
            <input type="hidden" name="id_category" class="id_category" value="0" />
            <div class="input-group">
                <div class="input-group-btn nov_category_tree hidden-sm-down">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        value="" aria-expanded="false">
                        <span>{l s='categories' d='Shop.Theme.Catalog'}</span>
                    </button>
                    <ul class="dropdown-menu list-unstyled">
                        <li class="dropdown-item {if !isset($id_category) || $id_category == 0}active{/if}"
                            data-value="0"><span>{l s='All Categories' d='Modules.Novadvancedsearch.Search'}</span></li>
                        <li class="dropdown-item {if !isset($id_category) || $id_category == $novcategoriesTree.id}active{/if}"
                            data-value="{$novcategoriesTree.id}"><span>{$novcategoriesTree.name}</span></li>
                        {if isset($novcategoriesTree.children)}
                        <ul class="list-unstyled pl-5">
                            {foreach $novcategoriesTree.children as $child}
                            <li class="dropdown-item font-weight-bold" data-value="{$child.id}" {if isset($id_category)
                                && $id_category==$child.id}selected{/if}>
                                <span>{$child.name}</span>
                            </li>
                            {include file="./category-tree-branch.tpl" node=$child lever=1}
                            {/foreach}
                        </ul>
                        {/if}
                    </ul>
                </div>

                <input type="text" id="search_query_top" class="search_query ui-autocomplete-input form-control"
                    name="search_query" value="{$search_query|escape:'html':'UTF-8'|stripslashes}"
                    placeholder="{if $novconfig.novthemeconfig_header_style == 'style-20' || $novconfig.novthemeconfig_header_style == 'style-21'}{l s='Search' d='Modules.Novadvancedsearch.Search'}{else}{l s='Enter search keywords' d='Shop.Theme.Search'}{/if}" />
                <span class="btn_search">
                    <button type="submit" name="submit_search">{* {l s='Search' d='Modules.Novadvancedsearch.Search'} *}
                        {if isset($class_homepage) && $class_homepage == 'home-40'}<i
                            class="zmdi zmdi-forward"></i>{else}<i class="material-icons">search</i>{/if}</button>
                </span>
            </div>
        </form>
    </div>
    {/if}

    <!-- /Block search module TOP -->