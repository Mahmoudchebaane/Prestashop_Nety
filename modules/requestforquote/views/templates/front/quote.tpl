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

{capture name=path}{l s='Request a Quote' mod='requestforquote'}{/capture}
{include file="$tpl_dir./errors.tpl"}
{if $success > 0}
<p class="alert alert-success">{l s='Quotation submitted' mod='requestforquote'}</p>
{/if}
{if $captcha > 0}<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>{/if}
<form action="{$form_action|escape:'htmlall':'UTF-8'}" enctype="multipart/form-data" method="post" id="fmm_quote_form">
	<div id="pq_form_major">
		<h3 class="page-subheading">{l s='Request a Quote' mod='requestforquote'}</h3>
		<div class="form-group col-lg-6">
			<label for="name">{l s='Your Name' mod='requestforquote'} <sup>*</sup></label>
			<input type="text" value="" name="name" class="form-control" id="name" />
		</div>
		<div class="form-group col-lg-6">
			<label for="company_name">{l s='Company Name' mod='requestforquote'}</label>
			<input type="text" value="" name="company_name" class="form-control" id="company_name" />
		</div>
		<div class="required form-group col-lg-6">
			<label for="fmm_email">{l s='Email' mod='requestforquote'} <sup>*</sup></label>
			<input type="text" value="" name="email" class="is_required validate form-control" id="fmm_email" required="required" />
		</div>
		<div class="form-group col-lg-6">
			<label for="contact_number">{l s='Contact Number' mod='requestforquote'}</label>
			<input type="text" value="" name="contact_number" class="form-control" id="contact_number" />
		</div>
		<div class="form-group col-lg-6">
			<label for="module_name">{l s='Module Name' mod='requestforquote'}</label>
			<input type="text" value="" name="module_name" class="form-control" id="module_name" />
		</div>
		<div class="form-group col-lg-6">
			<label for="quote_date">{l s='Needed By' mod='requestforquote'}</label>
			<input type="text" value="" name="quote_date" class="form-control fmmdatepicker" id="quote_date" />
		</div>
		<div class="form-group col-lg-12">
			<label for="quote_date">{l s='Project Budget Status:' mod='requestforquote'}</label>&nbsp;
			<div class="radio-inline">
				<label for="id_pbs1" class="top">
					<input type="radio" name="budget_state" value="{l s='Approved' mod='requestforquote'}" id="id_pbs1" />
					{l s='Approved' mod='requestforquote'}
				</label>
			</div>
			<div class="radio-inline">
				<label for="id_pbs2" class="top">
					<input type="radio" name="budget_state" value="{l s='Approved Pending' mod='requestforquote'}" id="id_pbs2" />
					{l s='Approved Pending' mod='requestforquote'}
				</label>
			</div>
			<div class="radio-inline">
				<label for="id_pbs3" class="top">
					<input type="radio" name="budget_state" value="{l s='Open' mod='requestforquote'}" id="id_pbs3" />
					{l s='Open' mod='requestforquote'}
				</label>
			</div>
			<div class="radio-inline">
				<label for="id_pbs4" class="top">
					<input type="radio" name="budget_state" value="{l s='No Approval' mod='requestforquote'}" id="id_pbs4" />
					{l s='No Approval' mod='requestforquote'}
				</label>
			</div>
		</div>
		<div class="form-group col-lg-12">
			<label for="brief">{l s='Brief' mod='requestforquote'} <sup>*</sup></label>
			<textarea class="form-control" id="brief" name="brief"></textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="attchment">{l s='Attachment' mod='requestforquote'}</label>
			<input type="file" name="attchment" id="attchment" class="form-control" />(doc,docx,pdf,jpg)
		</div>
		{if $captcha > 0}<div class="form-group col-lg-6"><label id="gCaptchaVerifyLabel">{l s='Verify: ' mod='requestforquote'}</label> <div class="g-recaptcha" id="fmmGcaptcha"></div></div>{/if}
		<div class="submit col-lg-12">
			<button id="fmm_submit_btn"{if $captcha > 0} style="display: none"{/if} type="button" onclick="submitRfqForm();" class="button btn btn-default button-medium"><span>{l s='Send'}<i class="icon-chevron-right right"></i></span></button>
		</div>
	</div>
</form>

<script>var fmm_label_fail = "{l s='Email incorrect or Empty' mod='requestforquote'}";
var fmm_label_fail_name = "{l s='Name cannot be Empty' mod='requestforquote'}";
var fmm_label_fail_brief = "{l s='Brief cannot be Empty' mod='requestforquote'}";
var fmm_label_fail_recaptcha = "{l s='Please validate recaptcha' mod='requestforquote'}";{literal}
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
//Reset Default for form
function fmmReset() {$('#fmm_submit_btn').hide();}
$(document).ready(function(){
	$('.fmmdatepicker').datepicker({
		dateFormat: 'yy-mm-dd'
	});
});
</script>{/literal}