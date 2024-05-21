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
{* {extends "customer/_partials/customer-form.tpl"} *}
{block name='customer_form'}
  {block name='customer_form_errors'}
    {include file='_partials/form-errors.tpl' errors=$errors['']}
  {/block}

<form novalidate action="{block name='customer_form_actionurl'}{$action}{/block}" id="customer-form"
  class="js-customer-form" method="post" style="display: flex;flex-direction: column;align-items: center;}">
  <section style="width:100%">
    <table style="width:100%">
      <tbody class="guestForm">
        {block "form_fields"}
          {foreach from=$formFields item="field"  }
            {block "form_field"}
              <tr class="{if $field.name == 'id_gender'}genderField{else}guestFields {/if}">
                {if $field.name== 'psgdpr'}
                {else}
                  <td class='col-md-6 col-3 ml-30 mr-30'> {form_field field=$field}</td>                 
                {/if}
              </tr>
            {/block}
            <div class='text-danger' id='error-{$field.name}'></div>
          {/foreach}
        {/block}
      </tbody>
    </table>
    {foreach from=$formFields item="field"}
      {* <div style="display: flex; align-items: center; justify-content: space-between;"> *}
      {if $field.name == 'psgdpr'}
        {form_field field=$field}
      {else}
      {/if}

    {/foreach}
  </section>

  {$hook_create_account_form nofilter}

  {block name='customer_form_footer'}
    <footer class="form-footer clearfix mt-50 w-100">
      <div class="row no-gutters">
        {if $page.page_name != 'checkout'}
          <div class="col-md-10 offset-md-2">
          {else}
            <div>
            {/if}
            <input type="hidden" name="submitCreate" value="1">
            {block "form_buttons"}
              <button class="continue btn btn-primary pull-xs-right" name="continue"
                data-link-action="register-new-customer" type="submit" value="1">
                {l s='Continue' d='Shop.Theme.Actions'}
              </button>
            {/block}
          </div>
        </div>
    </footer>
  {/block}
</form>
{/block}
{block name='hook_before_body_closing_tag'}
  <script>
    $("#btn-password").on("click", function() {
      if ("password" === e.attr("type")) {
        $('input[type="password"]').attr("type", "text");
      } else {
        $('input[name="password"]').attr("type", "password");
      }
  })
  </script>
{/block}