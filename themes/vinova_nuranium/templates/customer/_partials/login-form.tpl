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
{block name='login_form'}

  <form id="login-form" action="{block name='login_form_actionurl'}{$action}{/block}" method="post" class="formulaire"
    novalidate>
    <section>
      {block name='login_form_fields'}
        {foreach from=$formFields item="field"}
          {block name='form_field'}
            {if $field.name=="back"}
            {else}
              <h3 class='inputName'>{l s={$field.label} d='Shop.Theme.Customeraccount'}</h3>
            {/if}

            {if $field.name=="back"}
            {else}
              <div class="{if $page.page_name == 'checkout'}col-md-6{/if} form-group row no-gutters novform-{$field.name}{if !empty($field.errors)} has-error{/if}">
                <div class="col">
                  {if $page.page_name == 'checkout'}
                    <label class='form-control-label'>{l s={$field.label} d='Shop.Theme.Customeraccount'}</label>
                  {/if}
                <input class="form-control" name="{$field.name}" type="{$field.type}" value="{$field.value}"
                    placeholder="{$field.label}" {if $field.maxLength}maxlength="{$field.maxLength}" {/if}
                    {if $field.required}required{/if}>
                  {include file='_partials/form-errors.tpl' errors=$field.errors}
                </div>
              </div>
              <div class='text-danger {if $page.page_name == 'checkout'}d-none hidden{/if}' id='error-{$field.name}'></div>
            {/if}
          {/block}
        {/foreach}
      {/block}
      {* {hook h='displayPaCaptcha' posTo='login'} *}
    <div class='text-danger {if $page.page_name == 'checkout'}d-none hidden{/if} ' id="loginError"></div>
    </section>
    {block name='login_form_errors'}
      <div class="row no-gutters">
        <div class="col-md-10 ">
          {include file='_partials/form-errors.tpl' errors=$errors['']}
        </div>
      </div>
    {/block}
    {block name='login_form_footer'}
      <footer class="form-footer clearfix">
        <div class="row no-gutters">
          <div class="col-md-10 offset-md-2">
            <input type="hidden" name="submitLogin" value="1">
            {block name='form_buttons'}
              <button class="loginBtn" data-link-action="sign-in" type="submit" class="form-control-submit">
                {l s='Login' d='Shop.Theme.Customeraccount'}
              </button>
            {/block}
          </div>
        </div>
        <div class="LoginFooterLinks">
        {if $page.page_name != 'checkout'}
          <div class="forgot-password text-center mt-25 mb-25">
            {* <i class="zmdi zmdi-email"></i>&nbsp; *}
            <a href="{$urls.pages.password}" rel="nofollow">
              {l s='Forgot your' d='Shop.Theme.Customeraccount'}&nbsp;
              {l s='Password' d='Shop.Theme.Actions'}
              {* <span>{l s='Password' d='Shop.Theme.Actions'}</span>&nbsp; *}
            </a>
          </div>
         
            <div class="no-account">
              <a class="font-weight-bold" href="{$urls.pages.register}" data-link-action="display-register-form">
                {l s='No account? Create one here' d='Shop.Theme.Customeraccount'}
              </a>
            </div>
          {/if}
        </div>
     
      </footer>
    {/block}

  </form>

  {block name='hook_before_body_closing_tag'}
    <script>
      var twoParam='{l s='You should fill in the fields'  d='Shop.Theme.Customeraccount'}';
      var missingPass = '{l s='This field is required' d='Shop.Theme.Customeraccount'}';
      var weak =  '{l s="Password should contain at least 6 characters"  d='Shop.Theme.Customeraccount'}';
      var invalidEMail='{l s="Invalid email address!"  d="Shop.Theme.Customeraccount"}';
      var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
      $("#btn-password").on("click", function() {
        var e = $('input[name="password"]');
        if ("password" === e.attr("type")) {
          $('input[name="password"]').attr("type", "text");
        } else {
          $('input[name="password"]').attr("type", "password");
        }
      })

      $('#login-form').submit(function(evt) {
        $('#loginError').text('');
        $('#error-email').text('');
        $('#helpAuth').text('');
        if ($('input[name="email"]').val() == '') {
          $('#error-email').text(missingPass);
          evt.preventDefault();
        } else if (!($('input[name="email"]').val().match(validRegex))) {
          $('#error-email').text(invalidEMail);
          evt.preventDefault();
        } else if ($('input[name="password"]').val() == '' && $('input[name="email"]').val() == "") {
          $('#loginError').text(twoParam);
          evt.preventDefault();
        } else if ($('input[name="password"]').val() == '') {
          $('#loginError').text(missingPass);
          evt.preventDefault();
        } else if ($('input[name="password"]').val().length < 6) {
          $('#loginError').text(weak);
              evt.preventDefault();
            }
          })
    </script>
  {/block}
{/block}