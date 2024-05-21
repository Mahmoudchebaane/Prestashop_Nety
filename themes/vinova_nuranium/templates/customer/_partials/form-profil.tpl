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
 * to mailto:license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <mailto:contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='customer_form'}

  <form novalidate action="{block name='customer_form_actionurl'}{$action}{/block}" id="customerForm"
    class="js-customer-form d-flex flex-wrap flex-row" method="post">

    <div class="block_content-right ml-0 firstcol">

      <div class="topProfile">
        <div id="identity-link" style="display: flex; justify-content: space-between;align-items: center;">
          <span class="link-name">{l s='Modifier mes informations' d='Shop.Theme.Customeraccount'}</span>
        </div>
      </div>
      <section class="p-5" id="profilChange1">

        {block "form_fields"}
          {foreach from=$formFields item="field"}
            {block "form_field"}
              {if $field.name=='password' ||  $field.name=='new_password'|| $field.name =='confirm_password' }
              {else}
                {if $customer.ref_abonnement}
                  {form_field field=$field}
                {else}
                  {if $field.name=='ref_abonnement' ||  $field.name=='ref_client'|| $field.name =='num_fixe' }
                  {else}
                    {form_field field=$field}
                  {/if}
                {/if}
              {/if}
              {/block}
            {/foreach}
            {$hook_create_account_form nofilter}
          {/block}
          {block name='customer_form_footer'}
            <footer class="form-footer clearfix">
              <div class="row no-gutters">
                <div class="col-md-10 offset-md-2">
                  <input type="hidden" name="submitCreate" value="1">
                  {block "form_buttons"}
                    <button class=" SubscriptionBtn" data-link-action="save-customer" type="submit"
                      onclick=" $('input[name=\'testPass\']').val(1);  this.disabled=true;this.form.submit();">
                      {if $page.page_name == 'identity'}
                        {l s='Save' d='Shop.Theme.Actions'}
                      {else}
                        {l s='Register' d='Shop.Theme.Actions'}
                      {/if}
                    </button>
                  {/block}
                </div>
              </div>
            </footer>
          {/block}

          {if ($formFields['password']['errors']|count > 0 )}
            <script type="text/javascript">
              var test1 = $(':input[name="email"]').next();
              test1.css("display", "none");
            </script>
          {/if}
        </section>
      </div>

      <div class="block_content-right secondcol">
        <div class="topProfile">
          <div id="identity-link" style="display: flex; justify-content: space-between;align-items: center;">
            <span class="link-name"> {l s='Modifier mot de passe' d='Shop.Theme.Customeraccount'}</span>
          </div>
        </div>
        <section class="d-flex p-5" style=" display: flex; flex-direction:column ">
          {block "form_fields"}
            {foreach from=$formFields item="field"}
              {block "form_field"}

                {if $field.name !='password' &&  $field.name!='new_password' && $field.name!='confirm_password' }
                {else}

                  {form_field field=$field}
                {/if}
              {/block}
            {/foreach}

            <input type="hidden" name='testPass'
              value="{if ($formFields['password']['errors']|count > 0 ||$formFields['confirm_password']['errors']|count > 0 ||$formFields['new_password']['errors']|count > 0 )} 2 {else} 1{/if}">
            {$hook_create_account_form nofilter}
          {/block}

          {block name='customer_form_footer'}
            <footer class="form-footer clearfix">
              <div class="row no-gutters">
                <div class="col-md-10 offset-md-2">
                  <input type="hidden" name="submitCreate" value="1">
                  {block "form_buttons"}
                    <button id='passwodsave' class=" SubscriptionBtn disabledsavebtn" data-link-action="save-customer"
                      type="submit" disabled
                      onclick="$('input[name=\'testPass\']').val(2); this.disabled=true;this.form.submit();">
                      {if $page.page_name == 'identity'}
                        {l s='Save' d='Shop.Theme.Actions'}
                      {else}
                        {l s='Register' d='Shop.Theme.Actions'}
                      {/if}
                    </button>
                  {/block}
                </div>
              </div>
            </footer>
          {/block}

        </section>

      </div>

    </form>
    <style>
      .disabledsavebtn {
        cursor: not-allowed;
      }

      .firstcol {
        flex-grow: 2;
      }

      .secondcol {
        flex-grow: 0;
      }

      @media only screen and (max-width: 991px) {
        .secondcol {
          flex-grow: 1;
          margin-top: 15px;
          margin-left: 0px;
        }
      }
    </style>

    </div>
    {block name='customer_form_errors'}
      {include file='_partials/form-errors.tpl' errors=$errors['']}
    {/block}
    {block name='hook_before_body_closing_tag'}
      {* <script src="/js/profil.js" type="text/javascript"></script> *}
      <script type="text/javascript">
        var notMatching =  '{l s="The password and the confirmation password does not match"  d='Shop.Theme.Customeraccount'}';
        var oldPass = '{l s="Old password" d="Shop.Forms.Labels"}'
        var confirmPass = '{l s="Confirm password" d="Shop.Forms.Labels"}'
        var phoneEmpty = '{l s="Phone number should not be empty" d="Shop.Theme.Customeraccount"}'
        var invalidPhone = '{l s="Invalid phone number" d="Shop.Theme.Customeraccount"}'


        // document.addEventListener('contextmenu', (e) => e.preventDefault());

        // function ctrlShiftKey(e, keyCode) {
        //     return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
        // }

        // document.onkeydown = (e) => {

        //     // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
        //     if (
        //         event.keyCode === 123 ||
        //         ctrlShiftKey(e, 'I') ||
        //         ctrlShiftKey(e, 'J') ||
        //         ctrlShiftKey(e, 'C') ||
        //         (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
        //     )
        //         return false;
        // };


        $(document).ready(function() {

          $(':input[type="password"]').each(function() {
            $(this).parent().parent().parent().find('label').addClass('required');
          });

          var client
          $.ajax({
            type: 'POST',
            data: {
              ajax: true,
              action: 'GetUpdateCRM',
            },
            dataType: 'json'
          }).done(function(response) {
            if (response.success) {
              client = response.data.data
              $("input[name='firstname']").val(client.prenom);
              $("input[name='lastname']").val(client.nom);
              $("input[name='ref_client']").val(client.identifiant);
              $("input[name='num_fixe']").val(client.num_fixe);
              $("input[name='phone']").val(client.num_mobile);
              $("input[name='ref_abonnement']").val(client.ref_aonnement);
              $("input[name='email']").val(client.email);

              $("input[name='firstname']").css("background-color", " #e9e9e9");
              $("input[name='lastname']").css("background-color", " #e9e9e9");
              $("input[name='ref_client']").css("background-color", " #e9e9e9");
              $("input[name='num_fixe']").css("background-color", " #e9e9e9");
              $("input[name='ref_abonnement']").css("background-color", " #e9e9e9");

              $("input[name='firstname']").css("pointer-events", " none");
              $("input[name='lastname']").css("pointer-events", " none");
              $("input[name='ref_client']").css("pointer-events", " none");
              $("input[name='num_fixe']").css("pointer-events", " none");
              $("input[name='ref_abonnement']").css("pointer-events", " none");
              // document.getElementById("customer-form").reset();
            } else {

            }
          }).fail(function(error) {
            console.log('erruuuor=', error)
          });

          $('input[name="new_password"] , input[name="password"] , input[name="confirm_password"]').on('input',
        function() {

            var val1 = $('input[name="password"] , input[name="confirm_password"], input[name="new_password"]')
              .filter(function() {
                return this.value.trim().length === 0
              }).length === 0;
            if (val1) {
              $('#passwodsave').prop('disabled', false);
              $('#passwodsave').removeClass('disabledsavebtn')
            } else {
              $('#passwodsave').prop('disabled', true);
              $('#passwodsave').addClass('disabledsavebtn')
            }
          });
        });
      </script>
    {/block}
  {/block}