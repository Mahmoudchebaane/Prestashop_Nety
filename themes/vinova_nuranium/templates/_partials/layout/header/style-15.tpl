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

<div class="container container-1740">
  {block name='header_top'}
    <div class="header-top hidden-sm-down header-color-1">
      <div class="row align-items-center no-gutters">
        <div class="col-md-5">
          <span class="toggle-megamenu">
            <i class="zmdi zmdi-sort-amount-asc"></i>
          </span>
        </div>
        <div id="_desktop_logo" class="col-md-2 text-center">
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
        <div class="col-md-5 d-flex align-items-center justify-content-end header-top-right group-login has_after">
          <div id="_desktop_advancsearch">{hook h='displayAdvanceSearch'}</div>
          <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
            <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="_desktop_user_info">
              <i class="novicon_account small"></i>
            </div>
            <div class="account-list dropdown-menu" aria-labelledby="dropdownMenuButton" id="_desktop_account_list">
              <div class="account-list-content">
                {hook h='displayMyAccountBlock'}
              </div>
            </div>
          </div>
          <div class="link_wishlist">
            <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="{l s='My Wishlists' mod='novblockwishlist'}">
              <i class="novicon_wishlist small"></i>
            </a>
          </div>
          {hook h='displayNav2'}
        </div>
      </div>
    </div>
  {/block}
</div>
<div id="_desktop_top_menu" class="position-fixed menu_vertical">
  <div class="menu_close text-center hidden-sm-down"><i class="zmdi zmdi-close"></i></div>
  {hook h="displayMegamenu" menu_type="vertical"}
</div>

