{*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{capture name=path}{l s='Request for Quote' mod='requestforquote'}{/capture}
{include file="$tpl_dir./errors.tpl"}
{if $success > 0}
<p class="alert alert-success">{l s='Message submitted' mod='requestforquote'}</p>
{/if}
{if $captcha > 0}<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>{/if}
<form action="{$form_action|escape:'htmlall':'UTF-8'}" enctype="multipart/form-data" method="post" id="fmm_quote_form">
	<div id="pq_form_major">
		<div class="form-group col-lg-12">
			<label for="brief">{l s='Message' mod='requestforquote'} <sup>*</sup></label>
			<textarea class="form-control" id="message" name="message"></textarea>
		</div>
		{if $captcha > 0}<div class="form-group col-lg-6"><label id="gCaptchaVerifyLabel">{l s='Verify: ' mod='requestforquote'}</label> <div class="g-recaptcha" id="fmmGcaptcha"></div></div>{/if}
		<div class="submit col-lg-12">
			<button id="fmm_submit_btn"{if $captcha > 0} style="display: none"{/if} type="submit" class="button btn btn-default button-medium"><span>{l s='Send'}<i class="icon-chevron-right right"></i></span></button>
		</div>
	</div>
</form>
<script>{literal}
//G-Captcha Response Data
 var onloadCallback = function() {
	 var fmm_catcha_key = {/literal}"{$captcha_key}";{literal}
        grecaptcha.render('fmmGcaptcha', {
          'sitekey' : fmm_catcha_key,
          'callback' : fmmVerifyCallback
        });
      };
//G-Captcha trigger after verified
function fmmVerifyCallback(response) { $('#fmm_submit_btn').show();}
</script>{/literal}