{*
* 2007-2015 PrestaShop
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
*  @author    FMM Modules
*  @copyright 2015 FME Modules
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
{if $success > 0}
	<div class="bootstrap">
		<div class="alert alert-success">Message successfully sent.</div>
	</div>
{/if}
<div class="panel AdminQuote">
	<div class="panel-heading"><i class="icon-cogs"></i> {l s='RFQ Details' mod='requestforquote'}</div>
	<table class="table">
		<tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Name' mod='requestforquote'}</td>
			<td>{$quote.name|escape:'htmlall':'UTF-8'}</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Email' mod='requestforquote'}</td>
			<td>{$quote.email|escape:'htmlall':'UTF-8'}</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Company' mod='requestforquote'}</td>
			<td>{if $quote.company_name}
					{$quote.company_name|escape:'htmlall':'UTF-8'}
				{else}
					--
				{/if}
			</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Phone' mod='requestforquote'}</td>
			<td>{$quote.contact_number|escape:'htmlall':'UTF-8'}</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Offre' mod='requestforquote'}</td>
			<td>{$quote.module_name|escape:'htmlall':'UTF-8'}</td>
		</tr>
		{* <tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Quote Needed By' mod='requestforquote'}
			</td>
			<td>{$quote.quote_date|escape:'htmlall':'UTF-8'}</td>
		</tr> *}
		<tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Submit date' mod='requestforquote'}
			</td>
			<td>{$quote.date|escape:'htmlall':'UTF-8'}</td>
		</tr>
		{* <tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Offer' mod='requestforquote'}</td>
			<td>{$quote.budget_state|escape:'htmlall':'UTF-8'}</td>
		</tr> *}
		<tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Brief' mod='requestforquote'}</td>
			<td>{$quote.brief|escape:'htmlall':'UTF-8'}</td>
		</tr>
		{* <tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='Attachment' mod='requestforquote'}</td>
			<td><a href="{$upload_url}{$quote.attchment|escape:'htmlall':'UTF-8'}"
					target="_blank">{$quote.attchment|escape:'htmlall':'UTF-8'}</a></td>
		</tr> *}
		{* <tr>
			<td style="border-right: 1px solid #EEEEEE; font-weight: bold">{l s='ID Customer' mod='requestforquote'}
			</td>
			<td>{$quote.id_customer|escape:'htmlall':'UTF-8'}</td>
		</tr> *}
	</table>
	<br />
	{* <div class="panel-heading"><i class="icon-cogs"></i> {l s='Messages' mod='requestforquote'}</div> *}
	{* <form class="form-horizontal" enctype="multipart/form-data" method="post" id="configuration_form"
		action="{$action|escape:'htmlall':'UTF-8'}">
		<div>
			{if !empty($threads)}
				<div class="col-lg-12" id="fmm_message_tree">

					<ul>
						{foreach from=$threads key=i item=thread}
							<li class="fmm_level_thread_{$thread.author|escape:'htmlall':'UTF-8'}">
								{$thread.message}<span class="date">{l s='Posted' mod='productquotation'}:
									{$thread.date|escape:'htmlall':'UTF-8'}</span></li>
						{/foreach}
					</ul>
				</div>
			{/if}
			<div class="form-group">
				<label class="control-label col-lg-2">Send Message</label>
				<div class="col-lg-9">
					<textarea class="textarea-autosize" rows="6" name="message"></textarea>
				</div>
			</div>
			<div class="panel-footer">
				<button name="submitMessage" class="btn btn-default pull-right" type="submit"><i
						class="process-icon-envelope"></i> Send Message</button>
			</div>
		</div>
	</form> *}
	<style>
		{literal}
			.AdminQuote .table tbody>tr>td{
				height: 25px;
				line-height: 25px;
				border: 1px solid #EEEEEE;
				border-top: 1px solid #EEEEEE !important;

			}
			.AdminQuote .panel>.table>tbody:first-child>tr:first-child td{
				border-top: 1px solid #EEEEEE !important;
			}
			#fmm_message_tree {
				clear: both;
				padding: 0 0 40px;
				float: none !important;
			}

			#fmm_message_tree ul {
				padding: 0px;
				list-style: none;
			}

			#fmm_message_tree ul li {
				padding: 15px 20px 0px;
				font-size: 13px;
				color: #333333;
				border-left: 2px solid #333333;
				margin-top: 10px;
				margin-bottom: 12px;
				clear: both
			}

			#fmm_message_tree ul li span {
				display: block;
				background: #333333;
				color: #fff;
				padding: 2px 10px;
				font-size: 11px;
				line-height: 18px;
				margin-left: -20px;
				margin-right: -20px;
				margin-top: 10px
			}

			#fmm_message_tree ul li.fmm_level_thread_0 {
				margin-left: 2%;
				background: #F6F6F6
			}

			#fmm_message_tree ul li.fmm_level_thread_1 {
				margin-left: 12%;
				background: #E2FFE4
			}

		{/literal}
	</style>
</div>