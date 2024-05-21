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
{block name='order_messages_table'}
  {if $order.messages}
    <div class="box messages">
      <h3>{l s='Messages' d='Shop.Theme.Customeraccount'}</h3>
     
      {foreach from=$order.messages item=message}
            
        <div class="message col pl-0 pr-0">
          <div class="col-md-6  pl-0 pr-0" {if $message.id_employee != 0}style="text-align:end;color:#59049D"{/if}>
            {* {$message.name} *}
            {$message.name}
            <br>
            {$message.message_date}
          </div>
          <div class="d-flex form-group mb-0" >
            {* <label class="col-lg-1 col-md-2 form-control-label pl-0 pr-0"></label> *}
            <textarea disabled  class="col-md-6 form-control disabled mt-20 mb-20 pl-10 pr-10">{$message.message nofilter}</textarea>
          </div>
          {* <div class="col-sm-8">
            {$message.message nofilter}
          </div> *}
        </div>
      {/foreach}
    </div>
  {/if}
{/block}

{block name='order_message_form'}
  <section class="order-message-form box">
    <form action="{$urls.pages.order_detail}" method="post">

      <header class="mb-20">
        <h4>{l s='Add a message' d='Shop.Theme.Customeraccount'}</h4>
        <p>
          {l s='If you would like to add a comment about your order, please write it in the field below.' d='Shop.Theme.Customeraccount'}
        </p>
      </header>

      <section class="form-fields">

        <div class="form-group row pl-xs-15 pr-xs-15">
          <label class="col-lg-1 col-md-2 form-control-label" style="color: black;">{l s='Product' d='Shop.Forms.Labels'}</label>
          <div class="col-md-5 pl-0 pr-0">
            <select name="id_product" class="form-control form-control-select">
              <option value="0">{l s='-- please choose --' d='Shop.Forms.Labels'}</option>
              {foreach from=$order.products item=product}
                <option value="{$product.id_product}">{$product.name}</option>
              {/foreach}
            </select>
          </div>
        </div>

        <div class="form-group row pl-xs-15 pr-xs-15">
          <label class="col-lg-1 col-md-2 form-control-label"></label>
          <div class="col-md-5 pl-0 pr-0">
            <textarea rows="3" name="msgText" class="form-control pl-10 pr-10"></textarea>
          </div>
        </div>

      </section>

      <footer class="form-footer text-xs-center row pl-xs-15 pr-xs-15">
        <div class="col-lg-1 col-md-2"></div>
        <div class="col-md-5" style="text-align: end;padding: 0;}">
          <input type="hidden" name="id_order" value="{$order.details.id}">
          <button type="submit" name="submitMessage" class="btn btn-primary form-control-submit ">
            {l s='Send' d='Shop.Theme.Actions'}
          </button>
        </div>
      </footer>

    </form>
  </section>
{/block}