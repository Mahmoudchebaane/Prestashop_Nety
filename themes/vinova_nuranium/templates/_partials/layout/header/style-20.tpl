{block name="header-mobile"}
  <div class="header-mobile hidden-md-up">
    <div class="hidden-md-up text-xs-center mobile d-flex align-items-center">
      <div id="_mobile_mainmenu" class="item-mobile-top"><i class="zmdi zmdi-sort-amount-asc"></i></div>
      <div class="mobile_logo item-mobile-top">
        <a href="{$urls.base_url}">
          <img class="logo img-fluid" src="{$img_dir_themeconfig}/{$novconfig.novthemeconfig_logo_mobile}" alt="{$shop.name}">
        </a>
      </div>
      <div id="_mobile_advancsearch"></div>
      <div id="_mobile_menutop" class="item-mobile-top nov-toggle-page d-flex align-items-center justify-content-center" data-target="#mobile-pagemenu"><i class="zmdi zmdi-view-headline"></i></div>
    </div>
  </div>
{/block}

{block name='header_topbar'}
  <div class="topbar hidden-sm-down header-color-1">
    <div class="container">
      <div class="row">
        <div class="col-md-6 d-flex align-items-center group-login">
          <div>
            <i class="zmdi zmdi-account"></i>
            {if $nov_customer.logged}
              <a class="account" href="{$link->getPageLink('my-account', true)}" title="{l s='View my customer account' d='Modules.Shop.Theme.Customeraccount'}" rel="nofollow">{$nov_customer.customerName}</a>
              <span class="or">{l s='or' d='Shop.Theme.Customeraccount'}</span>
              <a class="logout" href="{$link->getPageLink('index', true, null, 'mylogout')}" rel="nofollow" title="{l s='Log me out' d='Shop.Theme.Customeraccount'}">{l s='Sign out' d='Shop.Theme.Customeraccount'}</a>
            {else}
              <a class="register" href="{$urls.pages.register}" rel="nofollow" title="{l s='Register Account' d='Shop.Theme.Customeraccount'}">{l s='Register' d='Shop.Theme.Customeraccount'}</a>
              &nbsp;<span class="or">{l s='or' d='Shop.Theme.Customeraccount'}</span>&nbsp;
              <a class="login" href="{$link->getPageLink('my-account', true)}" rel="nofollow" title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}">{l s='Login' d='Shop.Theme.Customeraccount'}</a>
            {/if}
          </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end group-cu-lg">
          <div class="link_wishlist">
            <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="{l s='My Wishlists' mod='novblockwishlist'}">
              <i class="novicon_wishlist small"></i>
              <span class="title_icon">{l s='wishlist' mod='novblockwishlist'}</span>
            </a>
          </div>
          {hook h='displayNav1'}
        </div>
      </div>
    </div>
  </div>
{/block}

{block name='header_top'}
  <div class="header-top header-color-2 hidden-sm-down">
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
        <div id="_desktop_logo" class="contentsticky_logo col-lg-3 col-md-2">
          {if isset($novconfig.novthemeconfig_customlogo) && $novconfig.novthemeconfig_customlogo && isset($novconfig.novthemeconfig_customlogo_enable) && $novconfig.novthemeconfig_customlogo_enable == 1}
            <a href="{$urls.base_url}">
              <img class="logo img-fluid" src="{$img_dir_themeconfig}logos/{$novconfig.novthemeconfig_customlogo}.png" alt="{$shop.name}">
            </a>
          {else}
            <a href="{$urls.base_url}">
              <img class="logo img-fluid" src="{$shop.logo}" alt="{$shop.name}">
            </a>
          {/if}
        </div>
        <div class="col-lg-9 col-md-10 d-flex align-items-center justify-content-end">
          {include file="_elements/social-list.tpl"}
          <div id="_desktop_advancsearch" >
          {hook h='displayAdvanceSearch'}
          </div>
          <div class="block_hotline d-xl-flex align-items-center text-lg-center">
            <i class="novicon_phone"></i>
            <div class="content">
              <p class="phone_number">{$novconfig.novthemeconfig_contact_phone}</p>
              <p>{$novconfig.novthemeconfig_contact_open_hour}</p>
            </div>
          </div>
          <div class="contentsticky_cart">{hook h='displayNav2'}</div>
        </div>
      </div>
    </div>
  </div>
{/block}

{block name='header_bottom'}
  <div class="header-bottom header-color-3 hidden-sm-down">
    <div class="container d-flex align-items-end ">
      <div class="verticalmenu-main"><span class="toggle-nav"><i class="zmdi zmdi-sort-amount-asc"></i></span></div>
      {hook h='displayVerticalMenu'}
      <div id="_desktop_top_menu" class="contentsticky_menu w-100">
        {hook h="displayMegamenu" menu_type="horizontal"}
      </div>
      
    </div>
  </div>
{/block}
<div id="_desktop_account_list" class="d-none">
  <div class="account-list-content">
    {hook h='displayMyAccountBlock'}
  </div>
</div>
<div class="canvas-vertical"></div>
{if $novconfig.novthemeconfig_header_sticky == '1'}
  <div id="header-sticky">
    <div class="container">
      <div class="row align-items-center">
        <div class="contentstickynew_logo col-xl-3 col-lg-2"></div>
        <div class="contentstickynew_menu col-xl-6 col-lg-7 position-static"></div>
        <div class="contentstickynew_cart d-flex justify-content-end col-lg-3"></div>
      </div>
    </div>
  </div>
{/if}