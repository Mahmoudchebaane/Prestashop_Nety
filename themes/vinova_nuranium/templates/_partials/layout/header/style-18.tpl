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

{if $page.page_name == 'index'}
  {block name='header_vertical'}
    <div class="container hidden-sm-down">
      <div class="header-vertical hidden-sm-down header-color-1 text-center active">
          <div id="_desktop_logo">
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
          <span class="show-header-vertical"><i class="zmdi zmdi-plus"></i></span>
          <div class="header-hidden hidden w-100 flex-column">
            <div id="_desktop_advancsearch" class="w-100">{hook h='displayAdvanceSearch'}</div>
            <div id="_desktop_top_menu" class="w-100">
              {hook h="displayMegamenu" menu_type=""} 
            </div>
            <div class="w-100 mt-auto">{include file="_elements/social-list.tpl"}</div>
            <span class="hidden-header-vertical">
              <i class="zmdi zmdi-eject"></i>
              <p>{l s='Hide sidebar' d='Shop.Theme.Action'}</p>
            </span>
          </div>
      </div>
    </div>
  {/block}
    {hook h='displayNav2'}
  <div class="settings-canvas hidden-sm-down">
    <div class="close_canvas settings"><i class="zmdi zmdi-close"></i></div>
    <div class="show_settings_canvas"><i class="novicon_accountblock"></i></div>
    <div class="account-list" id="_desktop_account_list"><div class="account-list-content">{hook h='displayMyAccountBlock'}</div></div>
  </div>
{/if}
{if $page.page_name != 'index'}
  {block name='header_top'}
    <div class="header-top hidden-sm-down">
      <div class="container">
         <div class="row align-items-center no-gutters">
          <div id="_desktop_advancsearch" class="col-md-5">{hook h='displayAdvanceSearch'}</div>
          <div id="_desktop_logo" class="col-md-2">
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
            <div>
              {if $nov_customer.logged}
                <a class="account" href="{$link->getPageLink('my-account', true)}" title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                  <i class="novicon_account"></i>
                </a>
              {else}
                <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                  <i class="novicon_account"></i>
                </span>
              {/if}
            </div>
            <div class="link_wishlist">
              <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="{l s='My Wishlists' mod='novblockwishlist'}">
                <i class="novicon_wishlist"></i>
              </a>
            </div>
            {hook h='displayNav2'}
            <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
              <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"" id="_desktop_user_info">
                <i class="novicon_accountblock"></i>
              </div>
              <div class="account-list dropdown-menu" aria-labelledby="dropdownMenuButton" id="_desktop_account_list">
                <div class="account-list-content">
                  {hook h='displayMyAccountBlock'}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  {/block}

  {block name='header_bottom'}
  <div class="hidden-sm-down">
    <div class="container">
     <div class="header-bottom">
        <div id="_desktop_top_menu" class="text-center">
          {hook h="displayMegamenu" menu_type="horizontal"}
        </div>
      </div>
    </div>
  </div>
  {/block}
{/if}
