{*
/******************
 * Vinova Themes Framework for Prestashop 1.7.x
 * @package    novmanagevcaddons
 * @version    1.0.0
 * @author     http://vinovathemes.com/
 * @copyright  Copyright (C) May 2019 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <vinovathemes@gmail.com>.All rights reserved.
 * @license    GNU General Public License version 1
 * *****************/
*}

<div class="nov-subscription style-2{if isset($el_class) && !empty($el_class)} {$el_class}{/if}">
	<div class="block block-subscription clearfix">
		<div class="row align-items-center no-gutters">
			<div class="col-xl-5 col-md-6 d-flex align-items-center mb-xs-30">
				{if isset($title) && !empty($title)}
					<div class="img_email">{$subs_icon nofilter}</div>
					<div>
						<div class="title_news">{$title}</div>
						{if isset($sub_title) && !empty($sub_title)}
							<span class="sub_title">{$sub_title}</span>
						{/if}
						{if !empty($desc_title)}<div class="desc_title">{$desc_title}</div>{/if}
					</div>
				{/if}
			</div>
			<div class="col-xl-7 col-md-6">
				<div class="block_content block_newsletter">
					{if isset($nov_emailsubscription) && $nov_emailsubscription}
					<form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post">
					    {if $nov_emailsubscription.msg}
					      <p class="alert {if $nov_emailsubscription.nw_error}alert-danger{else}alert-success{/if}">
					        {$nov_emailsubscription.msg}
					      </p>
					    {/if}
					    <div class="input-group">
					      <input type="text" class="form-control" name="email" value="{$nov_emailsubscription.value}" placeholder="{l s='ENTER YOUR EMAIL' d='Shop.Forms.Labels'}...">
					      <span class="input-group-btn">
					        <button class="btn" name="submitNewsletter" type="submit">{l s='Subscribe' d='Shop.Theme.Actions'}</button>
					      </span>
					    </div>
					    <input type="hidden" name="action" value="0">
				  	</form>
				  	{/if}
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Popup newsletter -->
{if isset($novconfig.novpopup_newsletter) && $novconfig.novpopup_newsletter == 1}
<div id="popup-subscribe" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="zmdi zmdi-close"></i></button>
            </div>
            <div class="modal-body">
                <form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post">
                    <div class="subscribe_form row no-gutters justify-content-center {if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if}">
                        <div class="inner col-12 text-center">
                            <div class="title_block">{l s='Sign up to Newsletter' d='Shop.Theme.Actions'}</div>
                            <p>{l s='Receive email-only deals, special offers & product exclusives' d='Shop.Theme.Actions'}</p>
                            <div class="input-subscribe-wrap">
                                <input class="inputNew form-control grey newsletter-input" placeholder="{l s='Enter Your email' d='Shop.Theme.Actions'}" type="text" name="email" size="18" value="" />
                                <span class="input-group-btn">
                                    <button type="submit" name="submitNewsletter" class="btn btn-primary">{l s='Subscribe' d='Shop.Theme.Actions'}</button>
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