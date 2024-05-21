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
<div class="header-top hidden-sm-down header-color-1">
  <div class="container container-1810">
    <div class="row align-items-center no-gutters">
      <div id="_desktop_logo" class="contentsticky_logo col-xl-3 col-md-2">
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
      <div class="col-xl-6 col-md-7 text-center position-static">
        <div id="_desktop_top_menu" class="contentsticky_menu">
          {hook h="displayMegamenu" menu_type="horizontal"}
        </div>
      </div>
      <div class="col-md-3 d-flex align-items-center justify-content-end header-top-right">
        <div id="_desktop_advancsearch">{hook h='displayAdvanceSearch'}</div>
        <div>
          {if $nov_customer.logged}
            <a class="account" href="{$link->getPageLink('my-account', true)}" title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
              <i class="novicon_account small"></i>
            </a>
          {else}
            <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
              <i class="novicon_account small"></i>
            </span>
          {/if}
        </div>
        <div class="link_wishlist">
          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="{l s='My Wishlists' mod='novblockwishlist'}">
            <i class="novicon_wishlist small"></i>
          </a>
        </div>
        <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
          <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"" id="_desktop_user_info">
            <i class="zmdi zmdi-format-subject"></i>
          </div>
          <div class="account-list dropdown-menu" aria-labelledby="dropdownMenuButton" id="_desktop_account_list">
            <div class="account-list-content">
              {hook h='displayMyAccountBlock'}
            </div>
          </div>
        </div>
        <div class="contentsticky_cart">{hook h='displayNav2'}</div>
      </div>
    </div>
  </div>
</div>
{/block}
{if $novconfig.novthemeconfig_header_sticky == '1'}
  <div id="header-sticky">
    <div class="container">
      <div class="row align-items-center">
        <div class="contentstickynew_logo col-xl-3 col-md-2"></div>
        <div class="contentstickynew_menu col-xl-6 col-md-8"></div>
        <div class="contentstickynew_cart d-flex justify-content-end col-xs-3 col-md-2"></div>
      </div>
    </div>
  </div>
{/if}

