{*
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="block_newsletter{if $novconfig.novthemeconfig_footer_style == 'style-2'} style-2{/if}">
  <form action="{$urls.pages.index}#footer" method="post">
    {if $conditions}
    {/if}
    {if $msg}
      <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
        {$msg}
      </p>
    {/if}

   
    <div class="input-group">
      <input type="text" class="form-control" name="email" value="{$value}"
        placeholder="{l s='Your email address' d='Shop.Forms.Labels'}...">
      <span class="input-group-btn">
        <button class="btn" name="submitNewsletter" type="submit">{l s='Subscribe' d='Shop.Theme.Actions'}</button>
      </span>
    </div>
      
    <input type="hidden" name="action" valu e="0">
    <div class=" ">
    {hook h='displayNewsletterRegistration'}
    </div>

  </form>
</div>


<!-- Popup newsletter -->
{if isset($novconfig.novpopup_newsletter) && $novconfig.novpopup_newsletter == 1}
  <div id="popup-subscribe" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
              class="zmdi zmdi-close"></i></button>
        </div>
        <div class="modal-body">
          <form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post">
            <div
              class="subscribe_form row no-gutters justify-content-center {if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if}">
              <div class="inner col-12 text-center">
                <div class="title_block">{l s='Sign up to Newsletter' d='Shop.Theme.Actions'}</div>
                <p>{l s='Receive email-only deals, special offers & product exclusives' d='Shop.Theme.Actions'}</p>
                <div class="input-subscribe-wrap">
                  <input class="inputNew form-control grey newsletter-input"
                    placeholder="{l s='Enter Your email' d='Shop.Theme.Actions'}" type="text" name="email" size="18"
                    value="" />
                  <span class="input-group-btn">
                    <button type="submit" name="submitNewsletter"
                      class="btn btn-primary">{l s='Subscribe' d='Shop.Theme.Actions'}</button>
                  </span>
                  <input type="hidden" name="action" value="0" />
                </div>
                <div class="checkbox">
                  <span class="custom-checkbox">
                    <input name="no-view" class="no-view" type="checkbox">
                    <span class="ps-shown-by-js"><i class="material-icons checkbox-checked">check</i></span>
                  </span>
                  <span>{l s="Don't show this popup again" d="Shop.Theme.Actions"}</span>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
{/if}