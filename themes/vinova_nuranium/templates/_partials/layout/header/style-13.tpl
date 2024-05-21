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

<div class="container container-1800">
  {block name='header_top'}
    <div class="header-top hidden-sm-down header-color-1">
      <div class="row align-items-center no-gutters">
        <div class="col-md-5">
          {include file="_elements/social-list.tpl"}
        </div>
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
        <div class="col-md-5 d-flex align-items-center justify-content-end header-top-right group-login has_after">
          <div id="_desktop_advancsearch">{hook h='displayAdvanceSearch'}</div>
          <div class="group-account">
            <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
              <i class="novicon_account small m-0"></i>
            </span>
          </div>
          <div class="link_wishlist">
            <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="{l s='My Wishlists' mod='novblockwishlist'}">
              <i class="novicon_wishlist small"></i>
            </a>
          </div>
          <div class="contentsticky_cart">{hook h='displayNav2'}</div>
        </div>
      </div>
    </div>
  {/block}
  {block name='header_bottom'}
    <div class="header-bottom hidden-sm-down header-color-2 position-relative">
      <div class="row align-items-center">
        <div class="col-md-2"></div>
        <div id="_desktop_top_menu" class="contentsticky_menu col-md-8 text-center position-static">
          {hook h="displayMegamenu" menu_type="horizontal"}
        </div>
        <div class="col-md-2 d-flex align-items-center justify-content-end">{hook h='displayNav1'}</div>
      </div>
    </div>
  {/block}
</div>
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

