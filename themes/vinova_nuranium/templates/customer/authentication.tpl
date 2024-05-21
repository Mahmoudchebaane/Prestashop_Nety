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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

{* {extends file='page.tpl'} *}

{* {block name='page_title'}
  {l s='Log in to your account' d='Shop.Theme.Customeraccount'}
{/block} *}
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
  <main id="main-site" class="w-100 h-100">
    {block name='page_content'}
      <div class="cnxPage">
        <div class="leftSide ">
          <div class='firstBloc'>
         
            <h1>{l s='Bienvenue' d='Shop.Theme.Customeraccount'}</h1>
            <h2>{l s='dans votre espace client' d='Shop.Theme.Customeraccount'}</h2>
            <p>
              {l s='L’espace client vous permet de consulter vos données personnelles, payer vos facture, passer vos réclamation...' d='Shop.Theme.Customeraccount'}
            </p>
            <a href="/">{l s='Revenir au site' d='Shop.Theme.Customeraccount'}</a>
          </div>
          <div class='imgLeft'>
          <img src="/img/cms/cnx.png" class="h-100" style="object-fit: contain"  >
          </div>

        </div>
        
        <div class="block-form-login" id="loginForm">
          {block name='login_form_container'}
            <section class="login-form">
              <div class="pb-30">
                <div class="page_title_account">{l s='Login' d='Shop.Theme.Customeraccount'}</div>
                <p class="titleDesc mb-15">{l s='Connectez-vous à votre compte' d='Shop.Theme.Customeraccount'}
                </p>

              </div>
              {hook h='displayLoginSocialAnywhere'}

              {* <p class="text-center mb-15">{l s='Or Insert your account information:' d='Shop.Theme.Customeraccount'}</p> *}
              {render file='customer/_partials/login-form.tpl' ui=$login_form}

              {block name='display_after_login_form'}
                {hook h='displayCustomerLoginFormAfter'}
              {/block}

            {/block}

        </div>
      </div>
    {/block}
  </main>

</body>

</html>