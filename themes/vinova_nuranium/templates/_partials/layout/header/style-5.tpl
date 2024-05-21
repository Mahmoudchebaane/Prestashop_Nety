{assign var=cms value=Shop::getShops()}
{assign var=context value=Context::getContext()}

{block name="header-mobile"}
  <div class="header-mobile hidden-md-up p-0 " id="mobileHeader">
    <div class="headerUser ">
    
      <a class="titleB2C {if $context->shop->id == NETY_SHOP }b2cActive{/if}"
        href='{$context->link->protocol_link}{$cms[{NETY_SHOP}].domain_ssl}'>
        {l s='Particulier' d='Shop.Theme.Global'}</a>
      <a class="titleB2B {if $context->shop->id == NETY_PRO}b2bActive{/if}"
        href='{$context->link->protocol_link}{$cms[{NETY_PRO}].domain_ssl}'>
        {l s='Professional' d='Shop.Theme.Global'}</a>
    </div>
    <div class="hidden-md-up p-10 text-xs-center mobile d-flex align-items-center justify-content-between"
      style="padding: 5px 0px;">
      <div class="mobile_logo item-mobile-top">
        <a href="{$urls.base_url}">
          <img class="logo img-fluid" src="{$img_dir_themeconfig}/{$novconfig.novthemeconfig_logo_mobile}"
            alt="{$shop.name}">
        </a>
      </div>
      <div class="d-flex align-items-center">
        {if $context->shop->id == NETY_SHOP}
          <div id='cart_mobile' style="padding: 0 10px;">
            {widget name="ps_shoppingcart"}
          </div>
        {/if}
        <div id="_mobile_mainmenu" class="item-mobile-top"><i class="zmdi zmdi-format-align-left"></i></div>
      </div>
    </div>
  </div>
{/block}

{block name='header_top'}
  <div class="header-top hidden-sm-down header-color-1 py-4">
    <div class="container">
      <div class="d-flex align-items-center font-size-16 no-gutters justify-content-between">
        <div class="d-flex align-items-center font-size-18 justify-content-left ">
          <a class="titleB2C {if $context->shop->id == NETY_SHOP }b2cActive{/if}"
            href='{$context->link->protocol_link}{$cms[{NETY_SHOP}].domain_ssl}'>
            {l s='Particulier' d='Shop.Theme.Global'}</a>
          <a class="titleB2B {if $context->shop->id == NETY_PRO}b2bActive{/if}"
            href='{$context->link->protocol_link}{$cms[{NETY_PRO}].domain_ssl}'>
            {l s='Professional' d='Shop.Theme.Global'}</a>
        </div>
        <div class="{if $context->shop->id == NETY_PRO}hidden{else}d-flex{/if}">
          <div class="nov_button nety-secondary mx-2 ">
            {hook h='displayPaiementFacture'}
          </div>
          <div class="nov_button nety-primary mx-2">
            {if ! $customer.ref_abonnement}
              {hook h="displayTopHeader" id_pack=null  }
            {/if}
          </div>
        </div>
        <div class="d-flex align-items-center  justify-content-right ">
          <div class="d-flex align-items-center ">
            <div class="px-4">
              {if $context->shop->id != NETY_PRO}
                <a href="/5-produits" style="color:#fdec25; display:flex; align-items:center; font-size: 18px;">
                  <i class="zmdi zmdi-store" style="font-size: 24px;"></i>
                  <span>&nbsp; E-shop</span>
                </a>
              {/if}
            </div>
            {if $context->shop->id == NETY_PRO}
            {else}
              {hook h='displayMyAccountBlock'}
              <div id='cart_desk' class="px-2">
                {widget name="ps_shoppingcart"}
              </div>
            {/if}
            <div style="padding: 0 7px;">
              {widget name="ps_languageselector"}
            </div>

          </div>

        </div>

      </div>
    </div>
  </div>
{/block}

<div class="canvas-vertical"></div>
{hook h='displayPreloader'}
{block name='header_bottom'}
  <div class="header-bottom hidden-sm-down header-color-2 ">
    <div class="container  headerBottomAr">
      <div class="d-flex align-items-center no-gutters justify-content-between">
        <div id="_desktop_logo" class="contentsticky_logo col-auto">
          {if isset($novconfig.novthemeconfig_customlogo) && $novconfig.novthemeconfig_customlogo && isset($novconfig.novthemeconfig_customlogo_enable) && $novconfig.novthemeconfig_customlogo_enable == 1}
            <a href="{$urls.base_url}">
              <img class="logo" src="{$img_dir_themeconfig}logos/{$novconfig.novthemeconfig_customlogo}.png"
                alt="{$shop.name}">
            </a>
          {else}
            <a href="{$urls.base_url}">
              <img class="logo img-fluid" src="{$shop.logo}" alt="{$shop.name}">
            </a>
          {/if}
        </div>
        <div id="_desktop_top_menu" class="contentsticky_menu col text-right">
          {hook h="displayMegamenu" menu_type="horizontal"}
        </div>
        <div class="hidden-md-up">
          {hook h='displayVerticalMenu'}
        </div>
      </div>
{/block}

    {if $novconfig.novthemeconfig_header_sticky == '1'}
      <div id="header-sticky">
        <div class="container ">
          <div class="d-flex align-items-center">
            <div class="contentstickynew_logo col-auto"></div>
            <div class="contentstickynew_menu col  p-0 d-flex justify-content-end position-static"></div>
            {* <div class="contentstickynew_cart d-flex justify-content-end col-lg-3"></div> *}
          </div>
        </div>
      </div>
{/if}