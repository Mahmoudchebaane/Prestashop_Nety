{block name="header-mobile"}
  <div class="header-mobile hidden-md-up">
    <div class="hidden-md-up text-xs-center mobile d-flex align-items-center">
      <div id="_mobile_mainmenu" class="item-mobile-top"><i class="zmdi zmdi-sort-amount-asc"></i></div>
      <div class="mobile_logo item-mobile-top">
        <a href="{$urls.base_url}">
          <img class="logo img-fluid" src="{$img_dir_themeconfig}/{$novconfig.novthemeconfig_logo_mobile}"
            alt="{$shop.name}">
        </a>
      </div>
      <div id="_mobile_advancsearch"></div>
      <div id="_mobile_menutop" class="item-mobile-top nov-toggle-page d-flex align-items-center justify-content-center"
        data-target="#mobile-pagemenu"><i class="zmdi zmdi-view-headline"></i></div>
    </div>
  </div>
{/block}

{*
    {block name='header_bottom'}
        <div class="header-top hidden-sm-down header-color-1">
          <div class="container">
            <div class="row align-items-center no-gutters">

              <div class="col-md-10 d-flex align-items-center justify-content-end">

                <div id="_desktop_advancsearch">

        

    
      {block name='header_bottom'}
          <div class="header-top hidden-sm-down header-color-1">
            <div class="container">
              <div class="row align-items-center no-gutters">

                <div class="col-md-10 d-flex align-items-center justify-content-end">

                  <div id="_desktop_advancsearch">

          
          {block name='header_bottom'}
              <div class="header-top hidden-sm-down header-color-1">
                <div class="container">
                  <div class="row align-items-center no-gutters">

                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                      <div id="_desktop_advancsearch">
                        {hook h='displayAdvanceSearch'}
                      </div>

                      <div class="header-top-right d-flex align-items-center">

                        <div>

                          {if $nov_customer.logged}
                              <a class="account" href="{$link->getPageLink('my-account', true)}"
                                title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                <i class="novicon_account white"></i>
                              </a>
                          {else}
                              <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                <i class="novicon_account white"></i>
                              </span>
                          {/if}

                        </div>
                        <div class="link_wishlist">
                          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                            title="{l s='My Wishlists' mod='novblockwishlist'}">
                            <i class="novicon_wishlist white"></i>
                          </a>
                        </div>

                        <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                        <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                          <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                            <i class="novicon_accountblock white"></i>
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
              </div>
          {/block}
          *}
          {hook h='displayAdvanceSearch'}{block name='header_bottom'}
              <div class="header-top hidden-sm-down header-color-1">
                <div class="container">
                  <div class="row align-items-center no-gutters">

                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                      <div id="_desktop_advancsearch">

        {*
          {block name='header_bottom'}
              <div class="header-top hidden-sm-down header-color-1">
                <div class="container">
                  <div class="row align-items-center no-gutters">

                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                      <div id="_desktop_advancsearch">

              
              {block name='header_bottom'}
                  <div class="header-top hidden-sm-down header-color-1">
                    <div class="container">
                      <div class="row align-items-center no-gutters">

                        <div class="col-md-10 d-flex align-items-center justify-content-end">

                          <div id="_desktop_advancsearch">
                            {hook h='displayAdvanceSearch'}
                          </div>

                          <div class="header-top-right d-flex align-items-center">

                            <div>

                              {if $nov_customer.logged}
                                  <a class="account" href="{$link->getPageLink('my-account', true)}"
                                    title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                    <i class="novicon_account white"></i>
                                  </a>
                              {else}
                                  <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                    <i class="novicon_account white"></i>
                                  </span>
                              {/if}

                            </div>
                            <div class="link_wishlist">
                              <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                title="{l s='My Wishlists' mod='novblockwishlist'}">
                                <i class="novicon_wishlist white"></i>
                              </a>
                            </div>

                            <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                            <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                              <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                <i class="novicon_accountblock white"></i>
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
                  </div>
              {/block}
              *}{hook h='displayAdvanceSearch'}{hook h='displayAdvanceSearch'}
                        </div>

                        <div class="header-top-right d-flex align-items-center">

                          <div>


          {*
            {block name='header_bottom'}
                <div class="header-top hidden-sm-down header-color-1">
                  <div class="container">
                    <div class="row align-items-center no-gutters">

                      <div class="col-md-10 d-flex align-items-center justify-content-end">

                        <div id="_desktop_advancsearch">

                {*
                {block name='header_bottom'}
                    <div class="header-top hidden-sm-down header-color-1">
                      <div class="container">
                        <div class="row align-items-center no-gutters">

                          <div class="col-md-10 d-flex align-items-center justify-content-end">

                            <div id="_desktop_advancsearch">
                              {hook h='displayAdvanceSearch'}
                            </div>

                            <div class="header-top-right d-flex align-items-center">

                              <div>

                                {if $nov_customer.logged}
                                    <a class="account" href="{$link->getPageLink('my-account', true)}"
                                      title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                      <i class="novicon_account white"></i>
                                    </a>
                                {else}
                                    <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                      <i class="novicon_account white"></i>
                                    </span>
                                {/if}

                              </div>
                              <div class="link_wishlist">
                                <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                  title="{l s='My Wishlists' mod='novblockwishlist'}">
                                  <i class="novicon_wishlist white"></i>
                                </a>
                              </div>

                              <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                              <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                  aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                  <i class="novicon_accountblock white"></i>
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
                    </div>
                {/block}
                *}{hook h='displayAdvanceSearch'}{if $nov_customer.logged}
                                  <a class="account" href="{$link->getPageLink('my-account', true)}"
                                    title="
              {*
                {block name='header_bottom'}
                    <div class="header-top hidden-sm-down header-color-1">
                      <div class="container">
                        <div class="row align-items-center no-gutters">

                          <div class="col-md-10 d-flex align-items-center justify-content-end">

                            <div id="_desktop_advancsearch">

                    {*
                    {block name='header_bottom'}
                        <div class="header-top hidden-sm-down header-color-1">
                          <div class="container">
                            <div class="row align-items-center no-gutters">

                              <div class="col-md-10 d-flex align-items-center justify-content-end">

                                <div id="_desktop_advancsearch">
                                  {hook h='displayAdvanceSearch'}
                                </div>

                                <div class="header-top-right d-flex align-items-center">

                                  <div>

                                    {if $nov_customer.logged}
                                        <a class="account" href="{$link->getPageLink('my-account', true)}"
                                          title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                          <i class="novicon_account white"></i>
                                        </a>
                                    {else}
                                        <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                          <i class="novicon_account white"></i>
                                        </span>
                                    {/if}

                                  </div>
                                  <div class="link_wishlist">
                                    <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                      title="{l s='My Wishlists' mod='novblockwishlist'}">
                                      <i class="novicon_wishlist white"></i>
                                    </a>
                                  </div>

                                  <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                  <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                    <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                      aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                      <i class="novicon_accountblock white"></i>
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
                        </div>
                    {/block}
                    *}{hook h='displayAdvanceSearch'}{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                      <i class="novicon_account white"></i>
                                    </a>

                {*
                  {block name='header_bottom'}
                      <div class="header-top hidden-sm-down header-color-1">
                        <div class="container">
                          <div class="row align-items-center no-gutters">

                            <div class="col-md-10 d-flex align-items-center justify-content-end">

                              <div id="_desktop_advancsearch">

                      {*
                      {block name='header_bottom'}
                          <div class="header-top hidden-sm-down header-color-1">
                            <div class="container">
                              <div class="row align-items-center no-gutters">

                                <div class="col-md-10 d-flex align-items-center justify-content-end">

                                  <div id="_desktop_advancsearch">
                                    {hook h='displayAdvanceSearch'}
                                  </div>

                                  <div class="header-top-right d-flex align-items-center">

                                    <div>

                                      {if $nov_customer.logged}
                                          <a class="account" href="{$link->getPageLink('my-account', true)}"
                                            title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                            <i class="novicon_account white"></i>
                                          </a>
                                      {else}
                                          <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                            <i class="novicon_account white"></i>
                                          </span>
                                      {/if}

                                    </div>
                                    <div class="link_wishlist">
                                      <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                        title="{l s='My Wishlists' mod='novblockwishlist'}">
                                        <i class="novicon_wishlist white"></i>
                                      </a>
                                    </div>

                                    <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                    <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                      <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                        <i class="novicon_accountblock white"></i>
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
                          </div>
                      {/block}
                    *}{hook h='displayAdvanceSearch'}{else}
                                      <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                        <i class="novicon_account white"></i>
                                      </span>

                  {*
                    {block name='header_bottom'}
                        <div class="header-top hidden-sm-down header-color-1">
                          <div class="container">
                            <div class="row align-items-center no-gutters">

                              <div class="col-md-10 d-flex align-items-center justify-content-end">

                                <div id="_desktop_advancsearch">

                        {*
                        {block name='header_bottom'}
                            <div class="header-top hidden-sm-down header-color-1">
                              <div class="container">
                                <div class="row align-items-center no-gutters">

                                  <div class="col-md-10 d-flex align-items-center justify-content-end">

                                    <div id="_desktop_advancsearch">
                                      {hook h='displayAdvanceSearch'}
                                    </div>

                                    <div class="header-top-right d-flex align-items-center">

                                      <div>

                                        {if $nov_customer.logged}
                                            <a class="account" href="{$link->getPageLink('my-account', true)}"
                                              title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                              <i class="novicon_account white"></i>
                                            </a>
                                        {else}
                                            <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                              <i class="novicon_account white"></i>
                                            </span>
                                        {/if}

                                      </div>
                                      <div class="link_wishlist">
                                        <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                          title="{l s='My Wishlists' mod='novblockwishlist'}">
                                          <i class="novicon_wishlist white"></i>
                                        </a>
                                      </div>

                                      <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                      <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                        <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                          <i class="novicon_accountblock white"></i>
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
                            </div>
                        {/block}
                      *}{hook h='displayAdvanceSearch'}{/if}

                                  </div>
                                  <div class="link_wishlist">
                                    <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                      title="
                  {*
                    {block name='header_bottom'}
                        <div class="header-top hidden-sm-down header-color-1">
                          <div class="container">
                            <div class="row align-items-center no-gutters">

                              <div class="col-md-10 d-flex align-items-center justify-content-end">

                                <div id="_desktop_advancsearch">

                        {*
                        {block name='header_bottom'}
                            <div class="header-top hidden-sm-down header-color-1">
                              <div class="container">
                                <div class="row align-items-center no-gutters">

                                  <div class="col-md-10 d-flex align-items-center justify-content-end">

                                    <div id="_desktop_advancsearch">
                                      {hook h='displayAdvanceSearch'}
                                    </div>

                                    <div class="header-top-right d-flex align-items-center">

                                      <div>

                                        {if $nov_customer.logged}
                                            <a class="account" href="{$link->getPageLink('my-account', true)}"
                                              title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                              <i class="novicon_account white"></i>
                                            </a>
                                        {else}
                                            <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                              <i class="novicon_account white"></i>
                                            </span>
                                        {/if}

                                      </div>
                                      <div class="link_wishlist">
                                        <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                          title="{l s='My Wishlists' mod='novblockwishlist'}">
                                          <i class="novicon_wishlist white"></i>
                                        </a>
                                      </div>

                                      <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                      <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                        <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                          <i class="novicon_accountblock white"></i>
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
                            </div>
                        {/block}
                        *}{hook h='displayAdvanceSearch'}{l s='My Wishlists' mod='novblockwishlist'}">
                                        <i class="novicon_wishlist white"></i>
                                      </a>
                                    </div>

                                    <div class="contentsticky_cart">
                    {*
                      {block name='header_bottom'}
                          <div class="header-top hidden-sm-down header-color-1">
                            <div class="container">
                              <div class="row align-items-center no-gutters">

                                <div class="col-md-10 d-flex align-items-center justify-content-end">

                                  <div id="_desktop_advancsearch">

                          {*
                          {block name='header_bottom'}
                              <div class="header-top hidden-sm-down header-color-1">
                                <div class="container">
                                  <div class="row align-items-center no-gutters">

                                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                                      <div id="_desktop_advancsearch">
                                        {hook h='displayAdvanceSearch'}
                                      </div>

                                      <div class="header-top-right d-flex align-items-center">

                                        <div>

                                          {if $nov_customer.logged}
                                              <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                <i class="novicon_account white"></i>
                                              </a>
                                          {else}
                                              <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                <i class="novicon_account white"></i>
                                              </span>
                                          {/if}

                                        </div>
                                        <div class="link_wishlist">
                                          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                            title="{l s='My Wishlists' mod='novblockwishlist'}">
                                            <i class="novicon_wishlist white"></i>
                                          </a>
                                        </div>

                                        <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                        <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                          <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                            <i class="novicon_accountblock white"></i>
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
                              </div>
                          {/block}
                          *}{hook h='displayAdvanceSearch'}{hook h='displayNav2'}</div>
                                      <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                        <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                          <i class="novicon_accountblock white"></i>
                                        </div>
                                        <div class="account-list dropdown-menu" aria-labelledby="dropdownMenuButton" id="_desktop_account_list">
                                          <div class="account-list-content">

                      {*
                        {block name='header_bottom'}
                            <div class="header-top hidden-sm-down header-color-1">
                              <div class="container">
                                <div class="row align-items-center no-gutters">

                                  <div class="col-md-10 d-flex align-items-center justify-content-end">

                                    <div id="_desktop_advancsearch">

                            {*
                            {block name='header_bottom'}
                                <div class="header-top hidden-sm-down header-color-1">
                                  <div class="container">
                                    <div class="row align-items-center no-gutters">

                                      <div class="col-md-10 d-flex align-items-center justify-content-end">

                                        <div id="_desktop_advancsearch">
                                          {hook h='displayAdvanceSearch'}
                                        </div>

                                        <div class="header-top-right d-flex align-items-center">

                                          <div>

                                            {if $nov_customer.logged}
                                                <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                  title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                  <i class="novicon_account white"></i>
                                                </a>
                                            {else}
                                                <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                  <i class="novicon_account white"></i>
                                                </span>
                                            {/if}

                                          </div>
                                          <div class="link_wishlist">
                                            <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                              title="{l s='My Wishlists' mod='novblockwishlist'}">
                                              <i class="novicon_wishlist white"></i>
                                            </a>
                                          </div>

                                          <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                          <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                            <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                              aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                              <i class="novicon_accountblock white"></i>
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
                                </div>
                            {/block}
                            *}{hook h='displayAdvanceSearch'}{hook h='displayMyAccountBlock'}
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                        {*
                          {block name='header_bottom'}
                              <div class="header-top hidden-sm-down header-color-1">
                                <div class="container">
                                  <div class="row align-items-center no-gutters">

                                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                                      <div id="_desktop_advancsearch">

                              {*
                              {block name='header_bottom'}
                                  <div class="header-top hidden-sm-down header-color-1">
                                    <div class="container">
                                      <div class="row align-items-center no-gutters">

                                        <div class="col-md-10 d-flex align-items-center justify-content-end">

                                          <div id="_desktop_advancsearch">
                                            {hook h='displayAdvanceSearch'}
                                          </div>

                                          <div class="header-top-right d-flex align-items-center">

                                            <div>

                                              {if $nov_customer.logged}
                                                  <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                    title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                    <i class="novicon_account white"></i>
                                                  </a>
                                              {else}
                                                  <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                    <i class="novicon_account white"></i>
                                                  </span>
                                              {/if}

                                            </div>
                                            <div class="link_wishlist">
                                              <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                <i class="novicon_wishlist white"></i>
                                              </a>
                                            </div>

                                            <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                            <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                              <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                <i class="novicon_accountblock white"></i>
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
                                  </div>
                              {/block}
                            *}{hook h='displayAdvanceSearch'}{/block}
                            *}
                        {*
                          {block name='header_bottom'}
                              <div class="header-top hidden-sm-down header-color-1">
                                <div class="container">
                                  <div class="row align-items-center no-gutters">

                                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                                      <div id="_desktop_advancsearch">

                              {*
                              {block name='header_bottom'}
                                  <div class="header-top hidden-sm-down header-color-1">
                                    <div class="container">
                                      <div class="row align-items-center no-gutters">

                                        <div class="col-md-10 d-flex align-items-center justify-content-end">

                                          <div id="_desktop_advancsearch">
                                            {hook h='displayAdvanceSearch'}
                                          </div>

                                          <div class="header-top-right d-flex align-items-center">

                                            <div>

                                              {if $nov_customer.logged}
                                                  <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                    title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                    <i class="novicon_account white"></i>
                                                  </a>
                                              {else}
                                                  <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                    <i class="novicon_account white"></i>
                                                  </span>
                                              {/if}

                                            </div>
                                            <div class="link_wishlist">
                                              <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                <i class="novicon_wishlist white"></i>
                                              </a>
                                            </div>

                                            <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                            <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                              <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                <i class="novicon_accountblock white"></i>
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
                                  </div>
                              {/block}
                              *}{hook h='displayAdvanceSearch'}{hook h='displayAdvanceSearch'}
                          </div>

                          <div class="header-top-right d-flex align-items-center">

                            <div>


                              {*
                                {block name='header_bottom'}
                                    <div class="header-top hidden-sm-down header-color-1">
                                      <div class="container">
                                        <div class="row align-items-center no-gutters">

                                          <div class="col-md-10 d-flex align-items-center justify-content-end">

                                            <div id="_desktop_advancsearch">

                                  {hook h='displayAdvanceSearch'}
                                            </div>

                                            <div class="header-top-right d-flex align-items-center">

                                              <div>


                                  {if $nov_customer.logged}
                                                    <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                      title="
                                    {l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                      <i class="novicon_account white"></i>
                                                    </a>

                                  {else}
                                                    <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                      <i class="novicon_account white"></i>
                                                    </span>

                                  {/if}

                                              </div>
                                              <div class="link_wishlist">
                                                <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                  title="
                                  {l s='My Wishlists' mod='novblockwishlist'}">
                                                  <i class="novicon_wishlist white"></i>
                                                </a>
                                              </div>

                                              <div class="contentsticky_cart">
                                  {hook h='displayNav2'}</div>
                                              <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                  aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                  <i class="novicon_accountblock white"></i>
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
                                    </div>

                                {/block}
                                *}
                                {if $nov_customer.logged}
                                  <a class="account" href="{$link->getPageLink('my-account', true)}" title="
                                      {*
                                      {block name='header_bottom'}
                                          <div class="header-top hidden-sm-down header-color-1">
                                            <div class="container">
                                              <div class="row align-items-center no-gutters">

                                                <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                  <div id="_desktop_advancsearch">

                                      {hook h='displayAdvanceSearch'}
                                                  </div>

                                                  <div class="header-top-right d-flex align-items-center">

                                                    <div>


                                      {if $nov_customer.logged}
                                                          <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                            title="
                                        {l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                            <i class="novicon_account white"></i>
                                                          </a>

                                      {else}
                                                          <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                            <i class="novicon_account white"></i>
                                                          </span>

                                      {/if}

                                                    </div>
                                                    <div class="link_wishlist">
                                                      <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                        title="
                                      {l s='My Wishlists' mod='novblockwishlist'}">
                                                        <i class="novicon_wishlist white"></i>
                                                      </a>
                                                    </div>

                                                    <div class="contentsticky_cart">
                                      {hook h='displayNav2'}</div>
                                                    <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                      <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                        <i class="novicon_accountblock white"></i>
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
                                          </div>
                                      {/block}
                                      *}{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                        <i class="novicon_account white"></i>
                                      </a>

                                      {*

                                        {block name='header_bottom'}
                                            <div class="header-top hidden-sm-down header-color-1">
                                              <div class="container">
                                                <div class="row align-items-center no-gutters">

                                                  <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                    <div id="_desktop_advancsearch">

                                          {hook h='displayAdvanceSearch'}
                                                    </div>

                                                    <div class="header-top-right d-flex align-items-center">

                                                      <div>


                                          {if $nov_customer.logged}
                                                            <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                              title="
                                            {l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                              <i class="novicon_account white"></i>
                                                            </a>

                                          {else}
                                                            <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                              <i class="novicon_account white"></i>
                                                            </span>

                                          {/if}

                                                      </div>
                                                      <div class="link_wishlist">
                                                        <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                          title="
                                          {l s='My Wishlists' mod='novblockwishlist'}">
                                                          <i class="novicon_wishlist white"></i>
                                                        </a>
                                                      </div>

                                                      <div class="contentsticky_cart">
                                          {hook h='displayNav2'}</div>
                                                      <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                        <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                          aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                          <i class="novicon_accountblock white"></i>
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
                                            </div>
                                        {/block}
                                    *}{else}
                                      <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                        <i class="novicon_account white"></i>
                                      </span>

                                      {*
                                          {block name='header_bottom'}
                                              <div class="header-top hidden-sm-down header-color-1">
                                                <div class="container">
                                                  <div class="row align-items-center no-gutters">

                                                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                      <div id="_desktop_advancsearch">

                                          {hook h='displayAdvanceSearch'}
                                                      </div>

                                                      <div class="header-top-right d-flex align-items-center">

                                                        <div>


                                          {if $nov_customer.logged}
                                                              <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                title="
                                            {l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                <i class="novicon_account white"></i>
                                                              </a>

                                          {else}
                                                              <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                <i class="novicon_account white"></i>
                                                              </span>

                                          {/if}

                                                        </div>
                                                        <div class="link_wishlist">
                                                          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                            title="
                                          {l s='My Wishlists' mod='novblockwishlist'}">
                                                            <i class="novicon_wishlist white"></i>
                                                          </a>
                                                        </div>

                                                        <div class="contentsticky_cart">
                                          {hook h='displayNav2'}</div>
                                                        <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                          <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                            <i class="novicon_accountblock white"></i>
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
                                              </div>

                                        {/block}
                                        *}
                                      {/if}

                                    </div>
                                    <div class="link_wishlist">
                                      <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}" title="
                                        {*
                                        {block name='header_bottom'}
                                            <div class="header-top hidden-sm-down header-color-1">
                                              <div class="container">
                                                <div class="row align-items-center no-gutters">

                                                  <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                    <div id="_desktop_advancsearch">

                                          {hook h='displayAdvanceSearch'}
                                                    </div>

                                                    <div class="header-top-right d-flex align-items-center">

                                                      <div>


                                          {if $nov_customer.logged}
                                                            <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                              title="
                                            {l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                              <i class="novicon_account white"></i>
                                                            </a>

                                          {else}
                                                            <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                              <i class="novicon_account white"></i>
                                                            </span>

                                          {/if}

                                                      </div>
                                                      <div class="link_wishlist">
                                                        <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                          title="
                                          {l s='My Wishlists' mod='novblockwishlist'}">
                                                          <i class="novicon_wishlist white"></i>
                                                        </a>
                                                      </div>

                                                      <div class="contentsticky_cart">
                                          {hook h='displayNav2'}</div>
                                                      <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                        <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                          aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                          <i class="novicon_accountblock white"></i>
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
                                            </div>
                                        {/block}
                                        *}{l s='My Wishlists' mod='novblockwishlist'}">
                                            <i class="novicon_wishlist white"></i>
                                          </a>
                                        </div>

                                        <div class="contentsticky_cart">
                                          {*

                                          {block name='header_bottom'}
                                              <div class="header-top hidden-sm-down header-color-1">
                                                <div class="container">
                                                  <div class="row align-items-center no-gutters">

                                                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                      <div id="_desktop_advancsearch">

                                            {hook h='displayAdvanceSearch'}
                                                      </div>

                                                      <div class="header-top-right d-flex align-items-center">

                                                        <div>


                                            {if $nov_customer.logged}
                                                              <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                title="
                                              {l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                <i class="novicon_account white"></i>
                                                              </a>

                                            {else}
                                                              <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                <i class="novicon_account white"></i>
                                                              </span>

                                            {/if}

                                                        </div>
                                                        <div class="link_wishlist">
                                                          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                            title="
                                            {l s='My Wishlists' mod='novblockwishlist'}">
                                                            <i class="novicon_wishlist white"></i>
                                                          </a>
                                                        </div>

                                                        <div class="contentsticky_cart">
                                            {hook h='displayNav2'}</div>
                                                        <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                          <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                            <i class="novicon_accountblock white"></i>
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
                                              </div>
                                          {/block}
                                          *}{hook h='displayNav2'}</div>
                                        <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                          <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"" id=" _desktop_user_info">
                                              <i class="novicon_accountblock white"></i>
                                            </div>
                                            <div class="account-list dropdown-menu" aria-labelledby="dropdownMenuButton" id="_desktop_account_list">
                                              <div class="account-list-content">

                                                {*
                                            {block name='header_bottom'}
                                                <div class="header-top hidden-sm-down header-color-1">
                                                  <div class="container">
                                                    <div class="row align-items-center no-gutters">

                                                      <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                        <div id="_desktop_advancsearch">

                                                {hook h='displayAdvanceSearch'}
                                                        </div>

                                                        <div class="header-top-right d-flex align-items-center">

                                                          <div>


                                                {if $nov_customer.logged}
                                                                <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                  title="
                                                  {l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                  <i class="novicon_account white"></i>
                                                                </a>

                                                {else}
                                                                <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                  <i class="novicon_account white"></i>
                                                                </span>

                                                {/if}

                                                          </div>
                                                          <div class="link_wishlist">
                                                            <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                              title="
                                                {l s='My Wishlists' mod='novblockwishlist'}">
                                                              <i class="novicon_wishlist white"></i>
                                                            </a>
                                                          </div>

                                                          <div class="contentsticky_cart">
                                                {hook h='displayNav2'}</div>
                                                          <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                            <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                              aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                              <i class="novicon_accountblock white"></i>
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
                                                </div>
                                            {/block}
                                            *}{hook h='displayMyAccountBlock'}
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>

                                        {*
                                              {block name='header_bottom'}
                                                  <div class="header-top hidden-sm-down header-color-1">
                                                    <div class="container">
                                                      <div class="row align-items-center no-gutters">

                                                        <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                          <div id="_desktop_advancsearch">

                                            {*
                                                {block name='header_bottom'}
                                                    <div class="header-top hidden-sm-down header-color-1">
                                                      <div class="container">
                                                        <div class="row align-items-center no-gutters">

                                                          <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                            <div id="_desktop_advancsearch">
                                                              {hook h='displayAdvanceSearch'}
                                                            </div>

                                                            <div class="header-top-right d-flex align-items-center">

                                                              <div>

                                                                {if $nov_customer.logged}
                                                                    <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                      title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                      <i class="novicon_account white"></i>
                                                                    </a>
                                                                {else}
                                                                    <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                      <i class="novicon_account white"></i>
                                                                    </span>
                                                                {/if}

                                                              </div>
                                                              <div class="link_wishlist">
                                                                <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                                  title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                                  <i class="novicon_wishlist white"></i>
                                                                </a>
                                                              </div>

                                                              <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                              <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                                <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                                  aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                                  <i class="novicon_accountblock white"></i>
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
                                                    </div>
                                                {/block}
                                            *}{/block}{hook h='displayAdvanceSearch'}
                                                        </div>

                                                        <div class="header-top-right d-flex align-items-center">

                                                          <div>


                                          {*
                                              {block name='header_bottom'}
                                                  <div class="header-top hidden-sm-down header-color-1">
                                                    <div class="container">
                                                      <div class="row align-items-center no-gutters">

                                                        <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                          <div id="_desktop_advancsearch">
                                                            {hook h='displayAdvanceSearch'}
                                                          </div>

                                                          <div class="header-top-right d-flex align-items-center">

                                                            <div>

                                                              {if $nov_customer.logged}
                                                                  <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                    title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                    <i class="novicon_account white"></i>
                                                                  </a>
                                                              {else}
                                                                  <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                    <i class="novicon_account white"></i>
                                                                  </span>
                                                              {/if}

                                                            </div>
                                                            <div class="link_wishlist">
                                                              <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                                title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                                <i class="novicon_wishlist white"></i>
                                                              </a>
                                                            </div>

                                                            <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                            <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                              <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                                <i class="novicon_accountblock white"></i>
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
                                                  </div>
                                              {/block}
                                            *}{/block}
                                              {if $nov_customer.logged}
                                                                  <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                    title="
                                              {*
                                                  {block name='header_bottom'}
                                                      <div class="header-top hidden-sm-down header-color-1">
                                                        <div class="container">
                                                          <div class="row align-items-center no-gutters">

                                                            <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                              <div id="_desktop_advancsearch">
                                                                {hook h='displayAdvanceSearch'}
                                                              </div>

                                                              <div class="header-top-right d-flex align-items-center">

                                                                <div>

                                                                  {if $nov_customer.logged}
                                                                      <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                        title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                        <i class="novicon_account white"></i>
                                                                      </a>
                                                                  {else}
                                                                      <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                        <i class="novicon_account white"></i>
                                                                      </span>
                                                                  {/if}

                                                                </div>
                                                                <div class="link_wishlist">
                                                                  <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                                    title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                                    <i class="novicon_wishlist white"></i>
                                                                  </a>
                                                                </div>

                                                                <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                                <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                                  <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                                    <i class="novicon_accountblock white"></i>
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
                                                      </div>
                                                  {/block}
                                              *}{/block}{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                  <i class="novicon_account white"></i>
                                                                </a>

                                            {*
                                                {block name='header_bottom'}
                                                    <div class="header-top hidden-sm-down header-color-1">
                                                      <div class="container">
                                                        <div class="row align-items-center no-gutters">

                                                          <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                            <div id="_desktop_advancsearch">
                                                              {hook h='displayAdvanceSearch'}
                                                            </div>

                                                            <div class="header-top-right d-flex align-items-center">

                                                              <div>

                                                                {if $nov_customer.logged}
                                                                    <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                      title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                      <i class="novicon_account white"></i>
                                                                    </a>
                                                                {else}
                                                                    <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                      <i class="novicon_account white"></i>
                                                                    </span>
                                                                {/if}

                                                              </div>
                                                              <div class="link_wishlist">
                                                                <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                                  title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                                  <i class="novicon_wishlist white"></i>
                                                                </a>
                                                              </div>

                                                              <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                              <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                                <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                                  aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                                  <i class="novicon_accountblock white"></i>
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
                                                    </div>
                                                {/block}
                                            *}{/block}
                                            {else}
                                                                <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                  <i class="novicon_account white"></i>
                                                                </span>

                                            {*
                                                {block name='header_bottom'}
                                                    <div class="header-top hidden-sm-down header-color-1">
                                                      <div class="container">
                                                        <div class="row align-items-center no-gutters">

                                                          <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                            <div id="_desktop_advancsearch">
                                                              {hook h='displayAdvanceSearch'}
                                                            </div>

                                                            <div class="header-top-right d-flex align-items-center">

                                                              <div>

                                                                {if $nov_customer.logged}
                                                                    <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                      title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                      <i class="novicon_account white"></i>
                                                                    </a>
                                                                {else}
                                                                    <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                      <i class="novicon_account white"></i>
                                                                    </span>
                                                                {/if}

                                                              </div>
                                                              <div class="link_wishlist">
                                                                <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                                  title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                                  <i class="novicon_wishlist white"></i>
                                                                </a>
                                                              </div>

                                                              <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                              <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                                <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                                  aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                                  <i class="novicon_accountblock white"></i>
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
                                                    </div>
                                                {/block}
                                            *}{/block}
                                          {/if}

                                                        </div>
                                                        <div class="link_wishlist">
                                                          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                            title="
                                        {*
                                            {block name='header_bottom'}
                                                <div class="header-top hidden-sm-down header-color-1">
                                                  <div class="container">
                                                    <div class="row align-items-center no-gutters">

                                                      <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                        <div id="_desktop_advancsearch">
                                                          {hook h='displayAdvanceSearch'}
                                                        </div>

                                                        <div class="header-top-right d-flex align-items-center">

                                                          <div>

                                                            {if $nov_customer.logged}
                                                                <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                  title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                  <i class="novicon_account white"></i>
                                                                </a>
                                                            {else}
                                                                <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                  <i class="novicon_account white"></i>
                                                                </span>
                                                            {/if}

                                                          </div>
                                                          <div class="link_wishlist">
                                                            <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                              title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                              <i class="novicon_wishlist white"></i>
                                                            </a>
                                                          </div>

                                                          <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                          <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                            <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                              aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                              <i class="novicon_accountblock white"></i>
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
                                                </div>
                                            {/block}
                                        *}{/block}{l s='My Wishlists' mod='novblockwishlist'}">
                                                          <i class="novicon_wishlist white"></i>
                                                        </a>
                                                      </div>

                                                      <div class="contentsticky_cart">
                                      {*
                                          {block name='header_bottom'}
                                              <div class="header-top hidden-sm-down header-color-1">
                                                <div class="container">
                                                  <div class="row align-items-center no-gutters">

                                                    <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                      <div id="_desktop_advancsearch">
                                                        {hook h='displayAdvanceSearch'}
                                                      </div>

                                                      <div class="header-top-right d-flex align-items-center">

                                                        <div>

                                                          {if $nov_customer.logged}
                                                              <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                                title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                                <i class="novicon_account white"></i>
                                                              </a>
                                                          {else}
                                                              <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                                <i class="novicon_account white"></i>
                                                              </span>
                                                          {/if}

                                                        </div>
                                                        <div class="link_wishlist">
                                                          <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                            title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                            <i class="novicon_wishlist white"></i>
                                                          </a>
                                                        </div>

                                                        <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                        <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                          <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                            <i class="novicon_accountblock white"></i>
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
                                              </div>
                                          {/block}
                                      *}{/block}{hook h='displayNav2'}</div>
                                                    <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                      <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                        <i class="novicon_accountblock white"></i>
                                                      </div>
                                                      <div class="account-list dropdown-menu" aria-labelledby="dropdownMenuButton" id="_desktop_account_list">
                                                        <div class="account-list-content">

                                    {*
                                        {block name='header_bottom'}
                                            <div class="header-top hidden-sm-down header-color-1">
                                              <div class="container">
                                                <div class="row align-items-center no-gutters">

                                                  <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                    <div id="_desktop_advancsearch">
                                                      {hook h='displayAdvanceSearch'}
                                                    </div>

                                                    <div class="header-top-right d-flex align-items-center">

                                                      <div>

                                                        {if $nov_customer.logged}
                                                            <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                              title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                              <i class="novicon_account white"></i>
                                                            </a>
                                                        {else}
                                                            <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                              <i class="novicon_account white"></i>
                                                            </span>
                                                        {/if}

                                                      </div>
                                                      <div class="link_wishlist">
                                                        <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                          title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                          <i class="novicon_wishlist white"></i>
                                                        </a>
                                                      </div>

                                                      <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                      <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                        <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                          aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                          <i class="novicon_accountblock white"></i>
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
                                            </div>
                                        {/block}
                                    *}{/block}{hook h='displayMyAccountBlock'}
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                  {*
                                      {block name='header_bottom'}
                                          <div class="header-top hidden-sm-down header-color-1">
                                            <div class="container">
                                              <div class="row align-items-center no-gutters">

                                                <div class="col-md-10 d-flex align-items-center justify-content-end">

                                                  <div id="_desktop_advancsearch">
                                                    {hook h='displayAdvanceSearch'}
                                                  </div>

                                                  <div class="header-top-right d-flex align-items-center">

                                                    <div>

                                                      {if $nov_customer.logged}
                                                          <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                            title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                            <i class="novicon_account white"></i>
                                                          </a>
                                                      {else}
                                                          <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                            <i class="novicon_account white"></i>
                                                          </span>
                                                      {/if}

                                                    </div>
                                                    <div class="link_wishlist">
                                                      <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                        title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                        <i class="novicon_wishlist white"></i>
                                                      </a>
                                                    </div>

                                                    <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                    <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                      <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                        <i class="novicon_accountblock white"></i>
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
                                          </div>
                                      {/block}
                                  *}{/block}
                                {/block}
                                *}
                              {*
                                  {block name='header_bottom'}
                                      <div class="header-top hidden-sm-down header-color-1">
                                        <div class="container">
                                          <div class="row align-items-center no-gutters">

                                            <div class="col-md-10 d-flex align-items-center justify-content-end">

                                              <div id="_desktop_advancsearch">
                                                {hook h='displayAdvanceSearch'}
                                              </div>

                                              <div class="header-top-right d-flex align-items-center">

                                                <div>

                                                  {if $nov_customer.logged}
                                                      <a class="account" href="{$link->getPageLink('my-account', true)}"
                                                        title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                                                        <i class="novicon_account white"></i>
                                                      </a>
                                                  {else}
                                                      <span class="toggle-popup-login" data-toggle="modal" data-target="#toggle_popup_login">
                                                        <i class="novicon_account white"></i>
                                                      </span>
                                                  {/if}

                                                </div>
                                                <div class="link_wishlist">
                                                  <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"
                                                    title="{l s='My Wishlists' mod='novblockwishlist'}">
                                                    <i class="novicon_wishlist white"></i>
                                                  </a>
                                                </div>

                                                <div class="contentsticky_cart">{hook h='displayNav2'}</div>
                                                <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
                                                  <div class="myaccount-title dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"" id=" _desktop_user_info">
                                                    <i class="novicon_accountblock white"></i>
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
                                      </div>
                                  {/block}
                              *}{/block}
                            {/block}
                          *}

                          {block name='header_bottom'}
                            <div class="header-color-2 hidden-sm-down">
                              <div class="mx-5 px-5">
                                <div class="header-bottom">
                                  <div class="row align-items-center justify-content-between no-gutters">
                                    <div id="_desktop_logo" class="contentsticky_logo col-auto">
                                      {if isset($novconfig.novthemeconfig_customlogo) && $novconfig.novthemeconfig_customlogo &&
                                          isset($novconfig.novthemeconfig_customlogo_enable) && $novconfig.novthemeconfig_customlogo_enable == 1}
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

                                  <div class="nov_button type-1 mr-auto ">
                                    {hook h="displayTopHeader"}
                                  </div>
                                  <div id="_desktop_top_menu" class="contentsticky_menu col text-right">

                                    <!-- test hook DA -->
                                    {hook h="displayTopHeader"}

                                    {hook h="displayMegamenu" menu_type="horizontal"}
                                  </div>
                                </div>
                              </div>
                            </div>
                          {/block}
                          {if $novconfig.novthemeconfig_header_sticky == '1'}
                            <div id="header-sticky">
                              <div class="container px-5">
                                <div class="row align-items-center">
                                  <div class="contentstickynew_logo col-auto"></div>
                                  <div class="contentstickynew_menu col d-flex justify-content-end"></div>
                                  <div class="contentstickynew_cart d-flex justify-content-end col-auto"></div>
                                </div>
                              </div>
                            </div>
                        {/if}