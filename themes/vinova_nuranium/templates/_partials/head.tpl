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
{block name='head_charset'}
  <meta charset="utf-8">
{/block}
{block name='head_ie_compatibility'}
  <meta http-equiv="x-ua-compatible" content="ie=edge">
{/block}

{block name='head_seo'}
  
  <title>{block name='head_seo_title'}{$page.meta.title}{/block}</title>
  <meta name="description" content="{block name='head_seo_description'}{$page.meta.description}{/block}">
  <meta name="keywords" content="{block name='head_seo_keywords'}{$page.meta.keywords}{/block}">
  <meta name="title" content="{$page.meta.title}" />


  {* {if $page.meta.robots !== 'index'}
    <meta name="robots" content="{$page.meta.robots}">
  {/if} *}
  {if $page.canonical}
    <link rel="canonical" href="{$page.canonical}">
  {/if}
{/block}
{block name='head_viewport'}
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=yes">
{/block}

{block name='head_icons'}
<link rel="icon" type="image/vnd.microsoft.icon" href="{$shop.favicon}?{$shop.favicon_update_time}">
<link rel="shortcut icon" type="image/x-icon" href="{$shop.favicon}?{$shop.favicon_update_time}">
{/block}
{if isset($novconfig.novthemeconfig_main_font) && $novconfig.novthemeconfig_main_font}
  <link href="https://fonts.googleapis.com/css?family={$novconfig.novthemeconfig_main_font|replace:' ':'+'}:300,400,400i,500,600,700,800,900,900i" rel="stylesheet">
{/if}
{if isset($novconfig.novthemeconfig_main_font_primary) && $novconfig.novthemeconfig_main_font_primary}
<link href="https://fonts.googleapis.com/css?family={$novconfig.novthemeconfig_main_font_primary|replace:' ':'+'}:100,300,400,500,600,700,900,900i" rel="stylesheet">
{/if}
{block name='stylesheets'}
  {include file="_partials/stylesheets.tpl" stylesheets=$stylesheets}
{/block}
{block name='javascript_head'}
  {include file="_partials/javascript.tpl" javascript=$javascript.head vars=$js_custom_vars}
  
{/block}

{block name='hook_header'}
  {$HOOK_HEADER nofilter}
{/block}
{if isset($nov_custom_css) && $nov_custom_css}
<style type="text/css">
  {$nov_custom_css nofilter}
</style>
{/if}