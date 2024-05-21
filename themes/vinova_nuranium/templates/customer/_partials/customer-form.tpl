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
{block name='customer_form'}
  {block name='customer_form_errors'}
    {include file='_partials/form-errors.tpl' errors=$errors['']}
  {/block}

  <form novalidate action="{block name='customer_form_actionurl'}{$action}{/block}" id="customer-form"
    class="js-customer-form" method="post" style="display: flex;flex-direction: column;align-items: center;}">
    <section style="width:100%">
      <table style="width:100%">
        <tbody>
          {block "form_fields"}

            {foreach from=$formFields item="field"  }
              {block "form_field"}
                <tr>
                
                  {if $field.name== 'psgdpr' }
                  {else}
                    <td class='d-flex'> <label class="inputName" style="padding: 5px 0; font-size:14px">{$field.label}</label>
                    </td>
                    <td> {form_field field=$field}</td>
                    <div class='text-danger' id='error-{$field.name}'></div>
                  {/if}
                </tr>
              {/block}
            {/foreach}
            
            {$hook_create_account_form nofilter}
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
    {if $page.page_name != 'checkout'}

       {if $register_form_errors &&  $register_form_errors_email ==false }
        <script>      
          $("input[name='firstname']").css("background-color", " #e9e9e9");
          $("input[name='lastname']").css("background-color", " #e9e9e9");
          $("input[name='ref_client']").css("background-color", " #e9e9e9");
          $("input[name='num_fixe']").css("background-color", " #e9e9e9");
          $("input[name='phone']").css("background-color", " #e9e9e9");
          $("input[name='ref_abonnement']").css("background-color", " #e9e9e9");
          $("input[name='firstname']").css("pointer-events", " none");
          $("input[name='lastname']").css("pointer-events", " none");
          $("input[name='ref_client']").css("pointer-events", " none");
          $("input[name='num_fixe']").css("pointer-events", " none");
          $("input[name='phone']").css("pointer-events", " none");
          $("input[name='ref_abonnement']").css("pointer-events", " none");
 
          $('#customer-form').submit(function(evt) {
            $('#helpAuth').text('');
          })
        </script>
      {/if} 

      {if $register_form_errors_email }
        <script>   
        $(".novform-ref_client").parent().parent().remove() ;
        $(".novform-ref_abonnement").parent().parent().remove() ;
        $(".novform-num_fixe").parent().parent().remove() ;
        </script>
      {/if}
    {/if}

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
                <button class="SubscriptionBtn" data-link-action="save-customer" type="submit">
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
  </form>
{/block}