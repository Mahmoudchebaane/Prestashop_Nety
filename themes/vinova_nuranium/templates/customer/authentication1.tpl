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

{* {block name='page_content'} *}
  <div class="cnxPage">
    <div class="leftSide">
      <h1>{l s='Bienvenue dans votre espace client' d='Shop.Theme.Customeraccount'}</h1>
      <h2>
        {l s='L’espace client vous permet de consulter vos données personnelles, payer vos facture, passer vos réclamation...' d='Shop.Theme.Customeraccount'}
      </h2>
      <button>{l s='Retour au site' d='Shop.Theme.Customeraccount'}</button>
    </div>
    <div class="block-form-login">
      {block name='login_form_container'}
        <section class="login-form">
          <div class="page_title_account text-center">{l s='Login' d='Shop.Theme.Customeraccount'}</div>
          {hook h='displayLoginSocialAnywhere'}
          <p class="text-center mb-15">{l s='Or Insert your account information:' d='Shop.Theme.Customeraccount'}</p>
          {render file='customer/_partials/login-form.tpl' ui=$login_form}
        </section>
        {block name='display_after_login_form'}
          {hook h='displayCustomerLoginFormAfter'}
        {/block}
        <div class="no-account">
          <a class="font-weight-bold" href="{$urls.pages.register}" data-link-action="display-register-form">
            {l s='No account? Create one here' d='Shop.Theme.Customeraccount'}
          </a>
        </div>
      {/block}
    </div>
  </div>
{* {/block} *}