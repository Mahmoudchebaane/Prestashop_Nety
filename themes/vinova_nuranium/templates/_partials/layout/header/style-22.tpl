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

{block name='header_top'}
  <div class="container">
    <div class="header-top hidden-sm-down header-color-1">
      <div class="row align-items-center no-gutters">
        <div id="_desktop_advancsearch" class="col-md-5">{hook h='displayAdvanceSearch'}</div>
        <div id="_desktop_logo" class="contentsticky_logo col-md-2 text-center">
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
        <div class="col-md-5 d-flex align-items-center justify-content-end header-top-right">
          <div id="block_myaccount_infos" class="myaccount_infos hidden-sm-down dropdown">
            <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"" id="_desktop_user_info">
              <i class="novicon_account"></i>
              <span class="d-block title_icon">{l s='Account' d='Shop.Theme.Customeraccount'}</span>
            </div>
            <div class="account-list dropdown-menu" aria-labelledby="dropdownMenuButton" id="_desktop_account_list">
              <div class="account-list-content">
                {hook h='displayMyAccountBlock'}
              </div>
            </div>
          </div>
          <div class="link_wishlist">
            <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="{l s='My Wishlists' mod='novblockwishlist'}">
              <i class="novicon_wishlist"></i>
              <span class="d-block title_icon">{l s='Wishlists' mod='novblockwishlist'}</span>
            </a>
          </div>
          <div class="contentsticky_cart">{hook h='displayNav2'}</div>
        </div>
      </div>
    </div>
  </div>
{/block}

{block name='header_bottom'}
  <div class="container hidden-sm-down">
    <div class="header-bottom header-color-2 position-relative">
      <div class="row align-items-center">
        <div class="col-lg-3">{include file="_elements/social-list.tpl"}</div>
        <div id="_desktop_top_menu" class="contentsticky_menu text-center col-xl-6 col-lg-7 col-md-9 position-static">
          {hook h="displayMegamenu" menu_type="horizontal"}
        </div>
      </div>
    </div>
  </div>
{/block}
<div id="_desktop_account_list" class="d-none">
  <div class="account-list-content">
    {hook h='displayMyAccountBlock'}
  </div>
</div>
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
