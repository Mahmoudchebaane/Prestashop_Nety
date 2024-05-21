{*
/******************
* Vinova Themes Framework for Prestashop 1.7.x
* @package novmanagevcaddons
* @version 1.0.0
* @author http://vinovathemes.com/
* @copyright Copyright (C) May 2019 vinovathemes.com <@emai:vinovathemes@gmail.com>
	* <vinovathemes@gmail.com>.All rights reserved.
		* @license GNU General Public License version 1
		* *****************/
		*}

		<div class="nov-contactform{$el_class}">
			<div class="block block-contactform clearfix">
				{if isset($title) && !empty($title)}
				<h2 class="title_block d-flex align-items-center justify-content-center">
					<div>
						<div class="title">{$title}</div>
						{if isset($sub_title) && !empty($sub_title)}
						<span class="sub_title">{$sub_title}</span>
						{/if}
						<div class="desc_title">{if !empty($desc_title)}{$desc_title}{/if}</div>
					</div>
				</h2>
				{/if}
				<div class="block_content">
					<section class="contact-form">
						<form action="{$link->getPageLink('contact')|escape:'html':'UTF-8'}" method="post"
							enctype="multipart/form-data">

							{if $notifications}
							<div
								class="col-xs-12 alert {if $notifications.nw_error}alert-danger{else}alert-success{/if}">
								<ul>
									{foreach $notifications.messages as $notif}
									<li>{$notif}</li>
									{/foreach}
								</ul>
							</div>
							{/if}

							<section class="form-fields">
								<div class="form-group row no-flow">
									<div class="col-md-6">
										<input class="form-control" name="name"
											placeholder="{l s='Your name' d='Shop.Forms.Help'}">
									</div>
									<div class="col-md-6">
										<input class="form-control" name="from" type="email" value="{$contact.email}"
											placeholder="{l s='Your email' d='Shop.Forms.Help'}">
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-6 form-select">
										<select name="id_contact" class="form-control form-control-select">
											{foreach from=$contacts item=contact_elt}
											<option value="{$contact_elt.id_contact}">{$contact_elt.name}</option>
											{/foreach}
										</select>
									</div>
								</div>


								<div class="form-group row">
									<div class="col-md-12">
										<textarea class="form-control" name="message"
											placeholder="{l s='Message' d='Shop.Forms.Help'}"
											rows="8">{if $contact.message}{$contact.message}{/if}</textarea>
									</div>
								</div>
							</section>

							<footer class="form-footer">
								<style>
									input[name=url] {
										display: none !important;
									}
								</style>
								<input type="text" name="url" value="" />
								<input type="hidden" name="token" value="{$token}" />
								<button class="btn" type="submit" name="submitMessage">
									<img class="img-fluid" src="{_THEME_IMG_DIR_}img-send.png" alt="img">
									<span>{l s='Send message' d='Shop.Theme.Actions'}</span>
								</button>
							</footer>
						</form>
					</section>
				</div>
			</div>
		</div>