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
    <div class="header-top hidden-sm-down ">
        <div class="row align-items-center no-gutters">
            <div id="_desktop_logo" class="contentsticky_logo col-lg-3 col-md-3 ">
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
            <div class="group_right col-lg-9 col-md-9">
                <div class="position-static d-flex">
                    <div id="_desktop_advancsearch" class="bg-transparent">
                        {hook h='displayAdvanceSearch'}
                    </div>
                    <div id="_desktop_top_menu" class="contentsticky_menu">
                        {hook h="displayMegamenu" menu_type="horizontal"}
                    </div>
                    <div class="group_left">
                        <div class="d-flex align-items-center justify-content-end header-top-right">
                            <div id="block_myaccount_infos" class="myaccount_infos groups-selector hidden-sm-down dropdown">
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
                            <div class="link_wishlist text-center">
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
        </div>
    </div>
{/block}

{block name='js_search'}
    <div id="nov-searchBox" class="d-flex align-items-center text-center">
        <div class="container">
            <span class="nov-seachBoxClose"><i class="zmdi zmdi-close"></i></span>
            <div class="nov-seachBoxInner">
                <div class="title_search">
                    <i class="zmdi zmdi-search"></i>
                    <span>{l s='Search' d='Shop.Theme.Search'}</span>
                </div>
                <div class="description">
                    {l s='Find your product with fast search. Enter some keyword such as dress, shirts, shoes etc. Or can search by product sku.' d='Shop.Theme.Search'}
                </div>
                <div id="_desktop_advancsearch">{hook h='displayAdvanceSearch'}</div>
            </div>
        </div>
    </div>
{/block}
{if $novconfig.novthemeconfig_header_sticky == '1'}
    <div id="header-sticky">
        <div class="container">
            <div class="row align-items-center">
                <div class="contentstickynew_logo col-lg-2"></div>
                <div class="contentstickynew_menu  col-lg-9 position-static"></div>
                <div class="contentstickynew_cart d-flex justify-content-end col-lg-1"></div>
            </div>
        </div>
    </div>
{/if}