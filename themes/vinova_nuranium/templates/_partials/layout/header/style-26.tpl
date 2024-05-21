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

<div class="header-content hidden-sm-down">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-3 col-md-2">
        <div id="_desktop_logo" class="contentsticky_logo">
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
      </div>
      <div class="contentsticky_menu col-xl-6 col-lg-7 position-static">
        <div id="_desktop_top_menu">{hook h="displayMegamenu" menu_type="horizontal"}</div>
      </div>
      <div class="col-md-3 d-flex justify-content-end pl-0 pr-0">
        {if isset($novconfig.novthemeconfig_purchase) && $novconfig.novthemeconfig_purchase}
          <div class="nov_button type-5">
            <a href="{$novconfig.novthemeconfig_purchase}">{l s='Purchase Now' d='Shop.Theme.Action'}</a>
          </div>
        {/if}
      </div>
    </div>
  </div>
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
