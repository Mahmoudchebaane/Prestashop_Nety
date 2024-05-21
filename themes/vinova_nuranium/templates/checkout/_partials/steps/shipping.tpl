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
{extends file='checkout/_partials/steps/checkout-step.tpl'}

{block name='step_content'}
  <div id="hook-display-before-carrier">
    {$hookDisplayBeforeCarrier nofilter}
  </div>
  <div class="delivery-options-list">
    {assign var="context" value=Context::getContext()}
    {assign var="adressId" value=$context->cart->id_address_delivery}
    {assign var="adress" value=Address::getCountryAndState($adressId)}
    {assign var="state" value=State::getStateById($adress.id_state)}
    {if $delivery_options|count}
      <form class="clearfix" id="js-delivery"
        data-url-update="{url entity='order' params=['ajax' => 1, 'action' => 'selectDeliveryOption']}" method="post">
        <div class="form-fields">
          {block name='delivery_options'}
            <div class="delivery-options">
            
              {foreach from=$delivery_options item=carrier key=carrier_id name=delivery_option}
    
                {if $carrier.is_free == "1" && ($state[0].iso_code == 'TN-11' || $state[0].iso_code == 'TN-51' )}
                  {l s='If you want to pick up your package from one of our stores, please choose the in-store pickup option' d='Shop.Theme.Checkout'}
                  <div
                    class="  spacing-10 no-gutters d-flex justify-content-between align-items-center delivery-option {if $smarty.foreach.delivery_option.last} last{/if}">
                    {* row align-items-center *}
                    <div class="">{*col-sm-1*}
                      <span class="custom-radio pull-xs-left d-flex">
                        <input type="radio" name="delivery_option[{$id_address}]" id="delivery_option_{$carrier.id}"
                          value="{$carrier_id}" {if $delivery_option == $carrier_id} checked{/if}>
                      </span>
                    </div>

                    <div for="delivery_option_{$carrier.id}" class=" delivery-option-2"> {* col-sm-11 *}
                      <div class="row  spacing-10 ">
                        {if $carrier.logo}
                          <div class="">{*col-sm-2*}
                            <img class="img-fluid" src="{$carrier.logo}" alt="{$carrier.name}" />
                          </div>
                        {/if}
                        <div class="">{*col-sm-7*}
                          <div class="row align-items-center spacing-10">
                            <div class="">{*col-sm-6*}
                              <div class="carrier-name">{$carrier.name}</div>
                            </div>

                          </div>
                        </div>
                        <div class="">{*col-sm-6*}
                          <div class="carrier-delay">{$carrier.delay}</div>
                        </div>
                        <div class=" text-sm-right">{*col-sm-3*}
                          <span class="carrier-price">{$carrier.price}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row carrier-extra-content" {if $delivery_option != $carrier_id} style="display:none;" {/if}>
                    {$carrier.extraContent nofilter}
                  </div>
                {else if $carrier.is_free == "0"}
                  <div
                    class="  spacing-10 no-gutters d-flex justify-content-between align-items-center delivery-option {if $smarty.foreach.delivery_option.last} last{/if}">
                    {* row align-items-center *}
                    <div class="">{*col-sm-1*}
                      <span class="custom-radio pull-xs-left d-flex">
                        <input type="radio" name="delivery_option[{$id_address}]" id="delivery_option_{$carrier.id}"
                          value="{$carrier_id}" {if $delivery_option == $carrier_id} checked{/if}>
                      </span>
                    </div>

                    <div for="delivery_option_{$carrier.id}" class=" delivery-option-2"> {* col-sm-11 *}
                      <div class="row  spacing-10 ">
                        {if $carrier.logo}
                          <div class="">{*col-sm-2*}
                            <img class="img-fluid" src="{$carrier.logo}" alt="{$carrier.name}" />
                          </div>
                        {/if}
                        <div class="">{*col-sm-7*}
                          <div class="row align-items-center spacing-10">
                            <div class="">{*col-sm-6*}
                              <div class="carrier-name">{$carrier.name}</div>
                            </div>

                          </div>
                        </div>
                        <div class="">{*col-sm-6*}
                          <div class="carrier-delay">{$carrier.delay}</div>
                        </div>
                        <div class=" text-sm-right">{*col-sm-3*}
                          <span class="carrier-price">{$carrier.price}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row carrier-extra-content" {if $delivery_option != $carrier_id} style="display:none;" {/if}>
                    {$carrier.extraContent nofilter}
                  </div>
                {/if}
              {/foreach}
            </div>
          {/block}
          <div class="order-options">
            <div id="delivery" class="delivery_message">
              <label
                for="delivery_message">{l s='If you would like to add a comment about your order, please write it in the field below.' d='Shop.Theme.Checkout'}</label>
              <textarea rows="2" cols="120" id="delivery_message" name="delivery_message">{$delivery_message}</textarea>
            </div>
            {if $recyclablePackAllowed}
              <div class="custom-checkbox d-block">
                <input type="checkbox" name="recyclable" value="1" {if $recyclable} checked {/if}>
                <span><i class="material-icons checkbox-checked">check</i></span>
                <label>{l s='I would like to receive my order in recycled packaging.' d='Shop.Theme.Checkout'}</label>
              </div>
            {/if}

            {if $gift.allowed}
              <div class="custom-checkbox d-block hidden">
                <input class="js-gift-checkbox" name="gift" type="checkbox" value="1" checked="checked">
                <span><i class="material-icons checkbox-checked">check</i></span>
                <label>{$gift.label}</label>
              </div>

              <div id="gift" class="d-none collapse{if $gift.isGift} in{/if}">
                <label
                  for="gift_message">{l s='If you\'d like, you can add a note to the gift:' d='Shop.Theme.Checkout'}</label>
                <textarea rows="2" cols="120" id="gift_message" name="gift_message">{$gift.message}</textarea>
              </div>
            {/if}
          </div>
        </div>
        <button type="submit" class="continue btn btn-primary  mt-10" name="confirmDeliveryOption" value="1">
          {l s='Continue' d='Shop.Theme.Actions'}
        </button>
      </form>
    {else}
      <p class="alert alert-danger">
        {l s='Unfortunately, there are no carriers available for your delivery address.' d='Shop.Theme.Checkout'}</p>
    {/if}
  </div>

  <div id="hook-display-after-carrier">
    {$hookDisplayAfterCarrier nofilter}
  </div>

  <div id="extra_carrier"></div>
{/block}