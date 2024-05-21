{**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author PrestaShop SA <contact@prestashop.com>
    * @copyright 2007-2017 PrestaShop SA
    * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    * International Registered Trademark & Property of PrestaShAop SA
    *}
<!doctype html>
<html lang="{$language.iso_code}">

<head>
    {block name='head'}
        {include file='_partials/head.tpl'}
    {/block}
    {if $smarty.server.HTTP_HOST == 'www.nety.tn'}
        <!-- Google Tag Manager -->
        {literal}
            <script>
                (function(w, d, s, l, i) {
                    w[l] = w[l] || [];
                    w[l].push({
                        'gtm.start': new Date().getTime(),
                        event: 'gtm.js'
                    });
                    var f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s),
                        dl = l != 'dataLayer' ? '&l=' + l : '';
                    j.async = true;
                    j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                    f.parentNode.insertBefore(j, f);
                })(window, document, 'script', 'dataLayer', 'GTM-NPSMQN8');
            </script>
        {/literal}
        <!-- End Google Tag Manager -->
    {/if}
</head>

<body style="    overflow-x: hidden;" id="{$page.page_name}"
    class="{$page.body_classes|classnames}{if isset($novconfig.novthemeconfig_mode_layout) && $novconfig.novthemeconfig_mode_layout == 'boxed'} layout-boxed{/if}{if isset($class_homepage) && $class_homepage} {$class_homepage}{/if}">
    {if $smarty.server.HTTP_HOST == 'www.nety.tn'}
        <!-- Google Tag Manager (noscript) -->
        {literal}
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NPSMQN8" height="0" width="0"
                    style="display:none;visibility:hidden"></iframe></noscript>
        {/literal}
        <!-- End Google Tag Manager (noscript) -->
    {/if}
    {block name='hook_after_body_opening_tag'}
        {hook h='displayAfterBodyOpeningTag'}
    {/block}

    <main id="main-site">

        {block name='product_activation'}
            {include file='catalog/_partials/product-activation.tpl'}
        {/block}
        <header id="header"
            class="header-{$novconfig.novthemeconfig_header_style}{if $novconfig.novthemeconfig_header_sticky == '1'} sticky-menu{/if}">
            {block name='header'}
                {include file='_partials/header.tpl'}
            {/block}
        </header>
        {if $page.page_name == 'category' }
            {block name='product_list_header'}
                {include file='catalog/_partials/category-header.tpl' listing=$listing category=$category}
            {/block}
        {/if}
        {if $page.page_name == 'stores'}
            <div class="TopPageAbout mb-40">
                <div class="BgTop">
                    <h1 class="Page_title">
                        <span
                            style="color:#FDEC25;font-size:45px;font-weight: 600;text-transform: uppercase;">{l s='nos' d='Shop.Theme.Catalog'}
                            &nbsp;</span>
                        <span
                            style="color:white;font-size:45px;font-weight: 600;text-transform: uppercase;">{l s='boutiques' d='Shop.Theme.Catalog'}
                        </span>
                    </h1>
                    <p><img src="/img/cms/network.png" alt="stores"></p>
                    <!-- style="float:right;height: 400px;"> -->
                </div>
            </div>
        {/if}



        {block name='notifications'}
            {include file='_partials/notifications.tpl'}
        {/block}

        <div id="wrapper-site" class="{if isset($class_homepage)}{$class_homepage}-edit{/if}">

            {if $page.page_name != 'index'}
                {block name='breadcrumb'}
                    {include file='_partials/breadcrumb.tpl'}
                {/block}
            {/if}

            {block name="left_column"}
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        {* Page category filter *}
                        <div id=" left-column" class="sidebar col-lg-3 col-md-4 ">
                            {if $page.page_name == 'product'  }
                                {hook h='displayLeftColumnProduct'}
                                <div class="col-right ">
                                    {include file='catalog/_partials/col-right-tab-detail.tpl'}</div>rretertretert
                            {elseif (strpos($page.page_name, 'smartblog') !== false)}
                                <div>{widget name="ps_facetedsearch" hook='displayLeftColumn'}</div>
                                {* {hook h="displaySmartBlogLeft"} *}
                            {else}
                                <div>{widget name="ps_facetedsearch" hook='displayLeftColumn'} </div>
                                {* {hook h='displayLeftColumn'} *}
                            {/if}
                        </div>
                    {/block}

                    {if isset($class_homepage) && $class_homepage && $class_homepage == 'home-23' &&
                            $page.page_name
                            == 'index'}
                    <div class="content_displaytop">

                        {hook h='displayTopColumn'}
                    </div>

                    {/if}

                    {block name="content_wrapper"}
                        <div id="content-wrapper" class="left-column right-column col-md-6 flex-xs-first">

                            {block name="content"}
                                <p>Hello world! This is HTML5 Boilerplate.</p>

                            {/block}
                        </div>

                    {/block}

                    {block name="right_column"}
                        <div id="right-column" class="sidebar col-lg-3 col-md-4">
                            {if $page.page_name == 'product'}
                                {hook h='displayRightColumnProduct'}
                                <div class="col-right">

                                    {include file='catalog/_partials/col-right-tab-detail.tpl'}
                                </div>

                            {elseif (strpos($page.page_name, 'smartblog') !== false)}

                                {hook h="displaySmartBlogRight"}

                            {else}

                                {hook h='displayRightColumn'}

                            {/if}
                        </div>

                    {/block}

                    {block name="left_column"}
                    </div>
                </div>

            {/block}

            {block name="right_column"}
            </div>
            </div>

        {/block}
        </div>
        {include file="_partials/layout/footer/style-15.tpl"}

    </main>


    {block name="mainmenu_mobile"}
        <div id="mobile_top_menu_wrapper" class="hidden-md-up">
            <div class="content">
                <div id="_mobile_verticalmenu"> {hook h='displayVerticalMenu'} </div>
                <div class="d-flex align-items-center  justify-content-right">
                    {widget name="ps_languageselector"}
                </div>
            </div>
        </div>
    {/block}

    <div id="mobile-pagemenu" class="mobile-boxpage d-flex hidden-md-up">
        <div class="content-boxpage col">
            <div class="box-header d-flex justify-content-between align-items-center">
                <div class="title-box">{l s="Menu" d='Shop.Theme.Layout'}</div>
                <div class="close-box"> {l s="Close" d='Shop.Theme.Layout'}</div>
            </div>
            <div id="_mobile_top_menu" class="js-top-menu box-content"></div>
        </div>
    </div>

    <div id="mobile-blockcart" class="mobile-boxpage d-flex hidden-md-up">
        <div class="content-boxpage col">
            <div class="box-header d-flex justify-content-between align-items-center">
                <div class="title-box">{l s="Cart" d='Shop.Theme.Layout'}</div>
                <div class="close-box">{l s="Close" d='Shop.Theme.Layout'}</div>
            </div>
            <div id="_mobile_cart" class="box-content"></div>
        </div>
    </div>

    <div id="mobile-pageaccount" class="mobile-boxpage d-flex hidden-md-up" data-titlebox-parent="{l s='Account'}">
        <div class="content-boxpage col">
            <div class="box-header d-flex justify-content-between align-items-center">
                <div class="back-box">{l s="Back" d='Shop.Theme.Layout'}</div>
                <div class="title-box">{l s='Account' d='Shop.Theme.Layout'}</div>
                <div class="close-box">{l s="Close" d='Shop.Theme.Layout'}</div>
            </div>
            <div class="box-content d-flex justify-content-center align-items-center text-center">
                <div>
                    <div id="_mobile_account_list"></div>
                    <div class="links-currency" data-target="#box-currency" data-titlebox="{l s='Currency'}">
                        <span>{l s='Currency' d='Shop.Theme.Layout'}</span><i class="zmdi zmdi-arrow-right"></i>
                    </div>
                    <div class="links-language" data-target="#box-language" data-titlebox=" {l s='Language'}">
                        <span>{l s='Language' d='Shop.Theme.Layout'}</span><i class="zmdi zmdi-arrow-right"></i>
                    </div>
                </div>
            </div>
            <div id="box-currency" class="box-content d-flex">
                <div class="w-100">
                    {foreach from=$nov_currency.currencies item=currency}
                        <div class="item-currency

                            {if $currency.current} current

                            {/if}">
                            <a title="{$currency.name}" rel="nofollow" href="{$currency.url}">{$currency.name}:
                                {$currency.iso_code}</a>
                        </div>
                    {/foreach}
                </div>
            </div>

            <div id="box-language" class="box-content d-flex">
                <div class="w-100">
                    {foreach from=$nov_languages.languages item=language}
                        <div class="item-language

                            {if $language.id_lang == $nov_languages.current_language.id_lang} current

                            {/if}">
                            <a href="

                            {url entity='language' id=$language.id_lang}" class="d-flex align-items-center"><img
                                    class="img-fluid mr-2" src="{$img_lang nofilter}{$language.id_lang}.jpg"
                                    alt="{$language.name}" width="16" height="11" /><span>{$language.name_simple}</span></a>
                        </div>

                    {/foreach}
                </div>
            </div>
        </div>
    </div>

    {if isset($class_homepage) && $class_homepage && $class_homepage == 'home-15' && $page.page_name == 'index'}
        <div id="social_sticky">
            {include file="_elements/social-list.tpl"}
        </div>
    {/if}

    {if isset($novconfig.novthemeconfig_bottom_nav_disable) && $novconfig.novthemeconfig_bottom_nav_disable == 1}
        {block name="stickymenu_bottom_mobile"}
            <div id="stickymenu_bottom_mobile">
                <div class="row align-items-center justify-content-center hidden-md-up text-center no-gutters">
                    <div class="stickymenu-item col">
                        <a href="{$urls.base_url}"><i class="icon-house"></i><span>{l s='Home' d='Shop.Theme.Layout'}</span></a>
                    </div>
                    {if isset($novconfig.novthemeconfig_bottom_nav_wishlist_disable) && $novconfig.novthemeconfig_bottom_nav_wishlist_disable == 1}
                        <div class="stickymenu-item col">
                            <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}">
                                <i class="zmdi zmdi-favorite-outline"></i><span>{l s='Wishlist' d='Shop.Theme.Layout'}</span>
                            </a>
                        </div>
                    {/if}
                    <div class="stickymenu-item col">
                        <div id="_mobile_cart_bottom" class="nov-toggle-page" data-target="#mobile-blockcart"></div>
                    </div>
                    {if isset($novconfig.novthemeconfig_bottom_nav_setting_disable) && $novconfig.novthemeconfig_bottom_nav_setting_disable == 1}
                        <div class="stickymenu-item col">
                            <a href="#" class="nov-toggle-page" data-target="#mobile-pageaccount">
                                <i class="icon-settings"></i>
                                <span> {l s='Setting' d='Shop.Theme.Layout'}</span>
                            </a>
                        </div>
                    {/if}

                    {if isset($novconfig.novthemeconfig_on_top_disable) && $novconfig.novthemeconfig_on_top_disable == 1}
                        <div class="stickymenu-item col">
                            <div id="_mobile_back_top"></div>
                        </div>
                    {/if}
                </div>
            </div>
        {/block}
    {/if}
    {*
        <div class="modal-login modal fade">
            <div class="modal-dialog modal-dialog-centered">


                {hook h='displayPopupLogin'}
            </div>
        </div>

        <div id="toggle_popup_login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="toggle_popup_login"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">


                            {if $page.page_name == 'authentication'}
                            <div class="col-12">
                                {else}
                                <div class="col-6">


                                    {/if}
                                    <div class="block-form-login">
                                        <div class="page_title_account"><span>{l s='Create an account'
                                                d='Shop.Forms.Labels'}</span>
                                        </div>
                                        <p class="mb-15">

                                            {l s='Insert your account information' d='Shop.Forms.Labels'}:
                                        </p>
                                        <form action="{$link->getPageLink('authentication', true)}" id="customer-form"
                                            class="js-customer-form" method="post">
                                            <section>
                                                <input type="hidden" name="id_customer" value="">

                                                <div class="form-group row no-gutters novform-firstname">
                                                    <div class="col-md-8"><input class="form-control" name="firstname"
                                                            type="text" value="" placeholder="

                    {l s='First name' d='Shop.Forms.Labels'}" required=""></div>
                                                </div>

                                                <div class="form-group row no-gutters novform-lastname">
                                                    <div class="col-md-8"><input class="form-control" name="lastname"
                                                            type="text" value="" placeholder="

                    {l s='Last name' d='Shop.Forms.Labels'}" required=""></div>
                                                </div>

                                                <div class="form-group row no-gutters novform-email">
                                                    <div class="col-md-8"><input class="form-control" name="email"
                                                            type="email" value="" placeholder="Email" required=""></div>
                                                </div>

                                                <div class="form-group row no-gutters novform-password">
                                                    <div class="col-md-8">
                                                        <div class="input-group js-parent-focus">
                                                            <input
                                                                class="form-control js-child-focus js-visible-password"
                                                                name="password" type="password" value="" placeholder="

                    {l s='Password' d='Shop.Forms.Labels'}" required="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row no-gutters novform-newsletter">
                                                    <div class="col-md-8">
                                                        <span class="custom-checkbox d-inline-flex">
                                                            <input name="newsletter" type="checkbox" value="1">
                                                            <span><i
                                                                    class="material-icons checkbox-checked">check</i></span>
                                                            <label>{l s='Sign up for our newsletter'
                                                                d='Shop.Forms.Labels'}</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </section>

                                            <footer class="form-footer clearfix">
                                                <div class="row no-gutters">
                                                    <div class="col-md-10 offset-md-2">
                                                        <input type="hidden" name="submitCreate" value="1">


                                                        {block "form_buttons"}
                                                        <button class="btn btn-primary form-control-submit mb-30"
                                                            data-link-action="save-customer" type="submit">


                                                            {l s='Register' d='Shop.Theme.Actions'}
                                                        </button>


                                                        {/block}
                                                    </div>
                                                </div>
                                            </footer>
                                        </form>
                                    </div>
                                </div>


                                {if $page.page_name != 'authentication'}
                                <div class="col-6">
                                    {hook h='displayPopupLogin'}
                                </div>


                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div> *}
    {block name='javascript_bottom'}
        {include file="_partials/javascript.tpl" javascript=$javascript.bottom}
    {/block}
    {block name='hook_before_body_closing_tag'}
        {hook h='displayBeforeBodyClosingTag'}
    {/block}
   
</body>

</html>