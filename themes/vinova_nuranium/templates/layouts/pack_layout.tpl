<!DOCTYPE html>
<html lang="{$language.iso_code}">

<head>
    {block name='head'}
        {include file='_partials/head.tpl'}
    {/block}

</head>

<body id="{$page.page_name}"
    class="{$page.body_classes|classnames}{if isset($novconfig.novthemeconfig_mode_layout) && $novconfig.novthemeconfig_mode_layout == 'boxed'} layout-boxed{/if}{if isset($class_homepage) && $class_homepage} {$class_homepage}{/if}">
    {block name='hook_after_body_opening_tag'}
        {hook h='displayAfterBodyOpeningTag'}
    {/block}
    <main id="main-site" class="packPageContainer">
        {* Header *}
        <header id="header"
            class="header-{$novconfig.novthemeconfig_header_style}{if $novconfig.novthemeconfig_header_sticky == '1'} sticky-menu{/if}">
            {block name='header'}
                {include file='_partials/header.tpl'}
            {/block}
        </header>

        <div class="pagePacks">
            {* Top page block *}
            <div class="TopPageAbout mb-40">
                <div class="BgTop">
                    <div class="Page_title">
                        <h1 style="color:#FDEC25;font-size:50px;font-weight: 600;text-transform: uppercase;">
                            {l s='Offres' d='Shop.Theme.Global'} <b style="color:white">{l s="Net's go"
                                d='Shop.Theme.Global'}</b>
                        </h1>
                    </div>
                    <img src="/img/cms/offres.png" alt="offres"> {*style="float:right;height: 500px;"*}
                </div>
            </div>
            {* BreadCrumbs *}
            {block name='breadcrumb'}
                {include file='_partials/breadcrumb.tpl'}
            {/block}
            {* Title *}
            {* <h1 class="contactH1 d-flex justify-content-center mt-50">
                <span style="color:#640fa2;text-transform:uppercase;">
                    <p style="color:black ;margin-bottom:5px">{l s="INTERNET en illimité" d="Shop.Theme.Global"}
                    </p>35
                    {l s="en mode Guichet Unique" d="Shop.Theme.Global"}
                </span>
            </h1> *}
            <h2 class="contactH1 d-flex justify-content-center mt-50 px-2">
                <span style="color:black;text-transform:uppercase;">
                    {l s="INTERNET en illimité <br /> en mode Guichet Unique" d="Shop.Theme.Cms"}

                    {l s="" d="Shop.Theme.Global"}
                </span>
            </h2>
            {* Subtitle *}
            {* <div style="color:#585858;font-size:18px;text-align:center;font-weight:400;padding:10px;">
                {l s="Nous sommes au 2ème pôle du marché de l’Internet, alors rejoignez-nous dès maintenant <br />et ne
                ratez pas nos packs Net’s Go offrant une connexion haute Débit + des services et cadeaux gratuits."
                d="Shop.Theme.Global"}
            </div> *}
            {* List of Packs *}
            {block name="content_wrapper"}
                <div id="content-wrapper" class="wrapperPack">
                    {block name="content"}
                        <p>Hello world! This is HTML5 Boilerplate.</p>
                    {/block}
                </div>
            {/block}
        </div>

        {* Bloc Newsletters *}
        <div class="mt-50">
            <div class="block-title d-flex align-items-center justify-content-center">
                {* <img src="/img/cms/Icon%20Inscription.png" alt="newsletters" width="82" height="81"> *}
                <h2 class="contactH1 mb-0">
                    <strong>{l s='Newsletter subscription' d='Modules.Emailsubscription.Shop'}</strong>
                </h2>
            </div>
            <div class="block-description mb-30 ">
                <p class="pt-20">{l s='Newsletter' d='Modules.Emailsubscription.Shop' }</p>
            </div>

            {include file='module:ps_emailsubscription/views/templates/hook/ps_emailsubscription.tpl'
            conditions='' msg='' value =''}

            {* <div class="bottomPhoto mb-0">
                <img class=" " alt="" width="" height="" src=" /modules/jscomposer/uploads/Design6-2.png">
            </div> *}

        </div>


        {* footer *}
        {include file="_partials/layout/footer/style-15.tpl"}

    </main>



    {block name="mainmenu_mobile"}
        <div id="mobile_top_menu_wrapper" class="hidden-md-up">
            <div class="content">
                <div id="_mobile_verticalmenu">{hook h='displayVerticalMenu'}</div>
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
                <div class="close-box">{l s="Close" d='Shop.Theme.Layout'}</div>
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
                    <div class="links-language" data-target="#box-language" data-titlebox="{l s='Language'}">
                        <span>{l s='Language' d='Shop.Theme.Layout'}</span><i class="zmdi zmdi-arrow-right"></i>
                    </div>
                </div>
            </div>
            <div id="box-currency" class="box-content d-flex">
                <div class="w-100">
                    {foreach from=$nov_currency.currencies item=currency}
                        <div class="item-currency{if $currency.current} current{/if}">
                            <a title="{$currency.name}" rel="nofollow" href="{$currency.url}">{$currency.name}:
                                {$currency.iso_code}</a>
                        </div>
                    {/foreach}
                </div>
            </div>

            <div id="box-language" class="box-content d-flex">
                <div class="w-100">
                    {foreach from=$nov_languages.languages item=language}
                        <div
                            class="item-language{if $language.id_lang == $nov_languages.current_language.id_lang} current{/if}">
                            <a href="{url entity='language' id=$language.id_lang}" class="d-flex align-items-center"><img
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
                    {if isset($novconfig.novthemeconfig_bottom_nav_wishlist_disable) &&
                                                                                                                                                                                                                                                    $novconfig.novthemeconfig_bottom_nav_wishlist_disable == 1}
                    <div class="stickymenu-item col">
                        <a href="{$link->getModuleLink('novblockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"><i
                                class="zmdi zmdi-favorite-outline"></i><span>{l s='Wishlist'
                                                                                                                                                                                                                                                                d='Shop.Theme.Layout'}</span></a>
                    </div>
                {/if}
                <div class="stickymenu-item col">
                    <div id="_mobile_cart_bottom" class="nov-toggle-page" data-target="#mobile-blockcart"></div>
                </div>
                {if isset($novconfig.novthemeconfig_bottom_nav_setting_disable) &&
                                                                                                                                $novconfig.novthemeconfig_bottom_nav_setting_disable == 1}
                <div class="stickymenu-item col">
                    <a href="#" class="nov-toggle-page" data-target="#mobile-pageaccount"><i
                            class="icon-settings"></i><span>{l s='Setting' d='Shop.Theme.Layout'}</span></a>
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
                                            d='Shop.Forms.Labels'}</span></div>
                                    <p class="mb-15">{l s='Insert your account information' d='Shop.Forms.Labels'}:
                                    </p>
                                    <form action="{$link->getPageLink('authentication', true)}" id="customer-form"
                                        class="js-customer-form" method="post">
                                        <section>
                                            <input type="hidden" name="id_customer" value="">

                                            <div class="form-group row no-gutters novform-firstname">
                                                <div class="col-md-8"><input class="form-control" name="firstname"
                                                        type="text" value=""
                                                        placeholder="{l s='First name' d='Shop.Forms.Labels'}"
                                                        required=""></div>
                                            </div>

                                            <div class="form-group row no-gutters novform-lastname">
                                                <div class="col-md-8"><input class="form-control" name="lastname"
                                                        type="text" value=""
                                                        placeholder="{l s='Last name' d='Shop.Forms.Labels'}"
                                                        required=""></div>
                                            </div>

                                            <div class="form-group row no-gutters novform-email">
                                                <div class="col-md-8"><input class="form-control" name="email"
                                                        type="email" value="" placeholder="Email" required=""></div>
                                            </div>

                                            <div class="form-group row no-gutters novform-password">
                                                <div class="col-md-8">
                                                    <div class="input-group js-parent-focus">
                                                        <input class="form-control js-child-focus js-visible-password"
                                                            name="password" type="password" value=""
                                                            placeholder="{l s='Password' d='Shop.Forms.Labels'}"
                                                            required="">
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
        </div>

        {block name='javascript_bottom'}
            {include file="_partials/javascript.tpl" javascript=$javascript.bottom}
        {/block}

        {block name='hook_before_body_closing_tag'}
            {hook h='displayBeforeBodyClosingTag'}

        {/block}

</html>