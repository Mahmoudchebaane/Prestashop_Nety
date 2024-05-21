{*
/******************
 * Vinova Login Social for Prestashop 1.7.x
 * @package    novloginsocial
 * @version    1.0.0
 * @author     Vinovathemes
 * @copyright  Copyright (C) May 2019 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <vinovathemes@gmail.com>.All rights reserved.
 * @license    GNU General Public License version 1
 * *****************/
*}

{block name='login_form_container'}
<div class="block-form-login">
    <section class="login-form">
        <div class="page_title_account"><span>{l s='Login' d='Shop.Theme.Customeraccount'}</span></div>
        {hook h='displayLoginSocialAnywhere'}
        <p class="mb-15">{l s='Login' d='Shop.Theme.Customeraccount'}</p>
        {render file='module:novloginsocial/views/templates/hook/login-form.tpl' ui=$login_form_popup}
    </section>
    {block name='display_after_login_form'}
        {hook h='displayCustomerLoginFormAfter'}
    {/block}
    <div class="no-account">
        <a class="font-weight-bold" href="{$urls.pages.register}" data-link-action="display-register-form">
        {l s='No account? Create one here' d='Shop.Theme.Customeraccount'}
        </a>
    </div>
 </div>
{/block}