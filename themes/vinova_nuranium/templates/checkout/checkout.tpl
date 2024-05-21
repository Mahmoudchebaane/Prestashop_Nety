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
<!doctype html>
<html lang="{$language.iso_code}">

<head>
  <title>{block name='head_seo_title'}{l s='Payment' d='Shop.Theme.Checkout'}{/block}</title>
  {block name='head'}
    {include file='_partials/head.tpl'}
  {/block}

</head>

<body id="{$page.page_name}" class="{$page.body_classes|classnames}">

  {block name='hook_after_body_opening_tag'}
    {hook h='displayAfterBodyOpeningTag'}
  {/block}

  <header id="header" class="header-{$novconfig.novthemeconfig_header_style}">
    {block name='header'}
      {include file='_partials/header.tpl'}
    {/block}
  </header>

  {block name='notifications'}
    {include file='_partials/notifications.tpl'}
  {/block}

  <section id="wrapper">
    {* {block name='breadcrumb'}
        {include file='_partials/breadcrumb.tpl'}
      {/block} *}

    {block name='content'}
      <div class="container">
        <section id="content">
          <div class="row">
            <div class="col-md-8">
              {block name='cart_summary'}
                {render file='checkout/checkout-process.tpl' ui=$checkout_process}
              {/block}
            </div>
            <div class="col-md-4 mt-xs-30">

              {block name='cart_summary'}
                {include file='checkout/_partials/cart-summary.tpl' cart = $cart}
                  <div class="cartPub">
                    <img src="/img/paymentCash.png" />
                    <p>{l s='Cash on delivery for all purchases' d='Shop.Theme.Checkout'}</p>
                  </div>
                  <div class="cartPub">
                    <img src="/img/exclusive.png" />
                    <p>{l s='Exclusive promotions' d='Shop.Theme.Checkout'}</p>
                  </div>
               
              {/block}

              {* {hook h='displayReassurance'} *}
            </div>
          </div>
        </section>
      </div>
    {/block}


  </section>

  {if $novconfig.novthemeconfig_footer_style}
    {* {include file="_partials/layout/footer/`$novconfig.novthemeconfig_footer_style`.tpl"} *}
  {else}
    {include file='_partials/footer.tpl'}
  {/if}

  {block name='javascript_bottom'}
    {include file="_partials/javascript.tpl" javascript=$javascript.bottom}
  {/block}

  {block name='hook_before_body_closing_tag'}
    {hook h='displayBeforeBodyClosingTag'}
  {/block}
  
  {block name="mainmenu_mobile"}
    <div id="mobile_top_menu_wrapper" class="hidden-md-up">
        <div class="content">
            <div id="_mobile_verticalmenu">{hook h='displayVerticalMenu'}</div>
            <div class="d-flex align-items-center  justify-content-right">
                {widget name="ps_languageselector"}
            </div>
        </div>
    </div>
{/block}
  <div id="mobile-pagemenu" class="mobile-boxpage d-flex hidden-md-up">
    <div class="content-boxpage col">
      <div class="box-header d-flex justify-content-between align-items-center">
        <div class="title-box">{l s="Menu" d='Shop.Theme.Layout'}</div>
        <div class="close-box">{l s="Close" d='Shop.Theme.Layout'}{*<i class="zmdi zmdi-close"></i>*}</div>
      </div>
      <div id="_mobile_top_menu" class="js-top-menu box-content"></div>
    </div>
  </div>

  <div id="mobile-blockcart" class="mobile-boxpage d-flex hidden-md-up">
    <div class="content-boxpage col">
      <div class="box-header d-flex justify-content-between align-items-center">
        <div class="title-box">{l s="Cart" d='Shop.Theme.Layout'}</div>
        <div class="close-box">{l s="Close" d='Shop.Theme.Layout'}</div>
      </div>
      <div id="_mobile_cart" class="box-content"></div>
    </div>
  </div>

  <div id="mobile-pageaccount" class="mobile-boxpage d-flex hidden-md-up" data-titlebox-parent="{l s='Account'}">
    <div class="content-boxpage col">
      <div class="box-header d-flex justify-content-between align-items-center">
        <div class="back-box">{l s="Back" d='Shop.Theme.Layout'}</div>
        <div class="title-box">{l s='Account' d='Shop.Theme.Layout'}</div>
        <div class="close-box">{l s="Close" d='Shop.Theme.Layout'}</div>
      </div>
      <div class="box-content d-flex justify-content-center align-items-center text-center">
        <div>
          <div id="_mobile_account_list"></div>
          <div class="links-currency" data-target="#box-currency" data-titlebox="{l s='Currency'}">
            <span>{l s='Currency' d='Shop.Theme.Layout'}</span><i class="zmdi zmdi-arrow-right"></i>
          </div>
          <div class="links-language" data-target="#box-language" data-titlebox="{l s='Language'}">
            <span>{l s='Language' d='Shop.Theme.Layout'}</span><i class="zmdi zmdi-arrow-right"></i>
          </div>
        </div>
      </div>
      <div id="box-currency" class="box-content d-flex">
        <div class="w-100">
          {foreach from=$nov_currency.currencies item=currency}
            <div class="item-currency{if $currency.current} current{/if}">
              <a title="{$currency.name}" rel="nofollow" href="{$currency.url}">{$currency.name}: {$currency.iso_code}</a>
            </div>
          {/foreach}
        </div>
      </div>

      <div id="box-language" class="box-content d-flex">
        <div class="w-100">
          {foreach from=$nov_languages.languages item=language}
            <div class="item-language{if $language.id_lang == $nov_languages.current_language.id_lang} current{/if}">
              <a href="{url entity='language' id=$language.id_lang}" class="d-flex align-items-center"><img
                  class="img-fluid mr-2" src="{$img_lang nofilter}{$language.id_lang}.jpg" alt="{$language.name}"
                  width="16" height="11" /><span>{$language.name_simple}</span></a>
            </div>
          {/foreach}
        </div>
      </div>

    </div>
  </div>

  {block name="stickymenu_bottom_mobile"}
    <div id="stickymenu_bottom_mobile" class="d-none">
      <div class="row align-items-center justify-content-center hidden-md-up text-center no-gutters">
        <div class="stickymenu-item col">
          <a href="{$urls.base_url}"><i class="icon-house"></i><span>{l s='Home' d='Shop.Theme.Layout'}</span></a>
        </div>
        {* <div class="stickymenu-item"><a href="#header"><i class="zmdi zmdi-search"></i><span>{l s='Search' d='Shop.Theme.Layout'}</span></a></div> *}
        <div class="stickymenu-item col">
          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"><i
              class="zmdi zmdi-favorite-outline"></i><span>{l s='Wishlist' d='Shop.Theme.Layout'}</span></a>
        </div>
        <div class="stickymenu-item col">
          <div id="_mobile_cart_bottom" class="nov-toggle-page" data-target="#mobile-blockcart"></div>
        </div>
        <div class="stickymenu-item col">
          <a href="#" class="nov-toggle-page" data-target="#mobile-pageaccount"><i
              class="icon-settings"></i><span>{l s='Setting' d='Shop.Theme.Layout'}</span></a>
        </div>
        <div class="stickymenu-item col">
          <div id="_mobile_back_top"></div>
        </div>
      </div>
    </div>
  {/block}

</body>

</html>