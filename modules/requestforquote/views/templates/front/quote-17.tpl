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

{* {extends file='page.tpl'}  *}



{block name="page_content"}
	<div class="container alertPro">
		{block name='notifications'}
			{include file='_partials/notifications.tpl'}
		{/block}
	</div>
	{if $success > 0}
		<p class="alert alert-success mb-20 col-lg-6">{l s='Quotation submitted' mod='requestforquote'}</p>
	{else if $error > 1 }
		<p class="alert alert-danger mb-20 col-lg-6">{l s='Error sending quotation' mod='requestforquote'}</p>
	{else}
	{/if}
	{if $captcha > 0}
		<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
	{/if}

	<div class="quoteContainer">
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-outline-success btn-lg  devisOffer" data-toggle="modal"
			data-target="#quoteModal">
			{l s='Demander un devis' mod='requestforquote'}
		</button>

		<!-- Modal -->
		<div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="quoteModalLabel">
							{l s='One of our advisors will contact you as soon as possible' mod='requestforquote'}</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						{* " *}
						<form method="post" id="fmm_quote_form" action="{$form_action|escape:'htmlall':'UTF-8'}"
							enctype="multipart/form-data">
							<div id="pq_form_major">
								{* <h3 class="page-subheading">{l s='Request a Quote' mod='requestforquote'}</h3> *}
								<div class="form-group col-lg-6">
									<label for="name">{l s='Your Name' mod='requestforquote'} <sup>*</sup></label>
									<input type="text" value="" name="name" class="form-control" id="name" required />
									<div id='nameError'></div>
								</div>
								<div class="form-group col-lg-6">
									<label for="company_name">{l s='Company Name' mod='requestforquote'}<sup>*</sup></label>
									<input type="text" value="" name="company_name" class="form-control" required
										id="company_name" />
									<div id='companyError'></div>
								</div>
								<div class="required form-group col-lg-6">
									<label for="fmm_email">{l s='Email' mod='requestforquote'} <sup>*</sup></label>
									<input type="text" value="" required name="email"
										class="is_required validate form-control" id="fmm_email" required="required" />
									<div id='emailError'></div>
								</div>
								<div class="form-group col-lg-6">
									<label
										for="contact_number">{l s='Contact Number' mod='requestforquote'}<sup>*</sup></label>
									<input type="text" value="" required="required" name="contact_number"
										class="form-control" id="contact_number" />
									<div id='telError'></div>
								</div>

								<div class="form-group col-lg-6 hidden">
								{* {$category.id}- *}
									<label for="module_name">{l s='Module Name' mod='requestforquote'}</label>
									<input type="text" value="{$category.name}" name="module_name"
										class="form-control" id="module_name" />
								</div>
								{* <div class="form-group col-lg-6 d-none">
									<label for="quote_date">{l s='Needed By' mod='requestforquote'}</label>
									<input type="text" value="" name="quote_date" class="form-control fmmdatepicker"
										id="quote_date" />
								</div> *}
								{* <div class="form-group col-lg-6 ">
									 <label for="quote_date">{l s='Project Budget Status:' mod='requestforquote'}</label>&nbsp; 
									<label for="quote_date">{l s='Debit:' mod='requestforquote'}</label>&nbsp;
									<select class="form-control form-control-select" name="offer" id="offer">
										<option value="30">30 Mbps</option>
										<option value="40">40 Mbps</option>
										<option value="50">50 Mbps</option>
										<option value="100">100 Mbps</option>
									</select>
								</div> *}
								{* <div class="form-group col-lg-6">
									<label for="attchment">{l s='Attachment' mod='requestforquote'}</label>
									<input type="file" name="attchment" id="attchment"
										class="form-control" />(doc,docx,pdf,jpg)
								</div> *}
								<div class="form-group col-lg-12">
									<label for="brief">{l s='Message' mod='requestforquote'}
										{* <sup>*</sup> *}
									</label>
									<textarea class="form-control" id="brief" name="brief"></textarea>
								</div>

								{if $captcha > 0}
									<div class="form-group col-lg-6">
										<label id="gCaptchaVerifyLabel">{l s='Verify: ' mod='requestforquote'}</label>
										<div class="g-recaptcha" id="fmmGcaptcha"></div>
									</div>
								{/if}
								<input type='hidden' name='submitQuote' value='0' id='submitQuote' />
								<div class="submit col-lg-12" style="text-align: end;">
									<button id="fmm_submit_btn" {if $captcha > 0} style="display: none" {/if} type="button"
										class="">
										 {l s='Send' mod='requestforquote' }
										{* <i class="icon-chevron-right right"></i> *}
									</button>
									{* button btn btn-default button-medium *}
									{* <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> *}

								</div>
							</div>
						</form>
					</div>
					{* <div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div> *}
				</div>
			</div>
		</div>

	</div>
	<script type="text/javascript" src="{$base_dir_ssl|escape:'htmlall':'UTF-8'}js/jquery/jquery-1.11.0.min.js"></script>
	<script>
		var requiredName = "{l s='Name is required' mod='requestforquote'}";
		var requiredCompany = "{l s='Company name is required' mod='requestforquote'}";
		var requiredTel = "{l s='Phone number is required' mod='requestforquote'}";
		var requiredEmail = "{l s='Email is required' mod='requestforquote'}";
		var alertsuccess= '{l s='Quote submitted successfully' d='Shop.Theme.Global'}'
		var emailSubject= '{l s='Request for Quote' d='Shop.Theme.Global'}'
		var fmm_label_fail = "{l s='Email format incorrect ' mod='requestforquote'}";
		var wrongTel = "{l s='Incorrect phone number' mod='requestforquote'}";
		// var fmm_label_fail_name = "{l s='Name cannot be Empty' mod='requestforquote'}";
		var fmm_label_fail_brief = "{l s='Brief cannot be Empty' mod='requestforquote'}";
		var fmm_label_fail_recaptcha = "{l s='Please validate recaptcha' mod='requestforquote'}";{literal}
			//G-Captcha Response Data
			var onloadCallback = function() {
				var fmm_catcha_key = {/literal}"{$captcha_key}";{literal}
				grecaptcha.render('fmmGcaptcha', {
					'sitekey': fmm_catcha_key,
					'callback': fmmVerifyCallback
				});
			};
			//G-Captcha trigger after verified
			function fmmVerifyCallback(response) { $('#fmm_submit_btn').show(); }
			//Reset Default for form
			function fmmReset() {$('#fmm_submit_btn').hide();}
			$(document).ready(function() {
				$('.fmmdatepicker').datepicker({
					dateFormat: 'yy-mm-dd'
				});
			});
	</script>{/literal}

<script src="/modules/requestforquote/views/js/quote.js" type="text/javascript"></script>

{/block}
