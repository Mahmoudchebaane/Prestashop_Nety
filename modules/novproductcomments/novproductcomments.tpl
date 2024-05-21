{*
/******************

 * Vinova Themes  Framework for Prestashop 1.7.x 
 * @package   	novblockwishlist
 * @version   	1.0
 * @author   	http://vinovathemes.com/
 * @copyright 	Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 
 * *****************/
*}
{literal}
<script type="text/javascript">
var novproductcomments_controller_url = "{/literal}{$novproductcomments_controller_url}{literal}";
var confirm_report_message = "{/literal}{l s='Are you sure that you want to report this comment?' mod='novproductcomments' js=1}{literal}";
var secure_key = "{/literal}{$secure_key}{literal}";
var novproductcomments_url_rewrite = "{/literal}{$novproductcomments_url_rewriting_activated}{literal}";
var productcomment_added = "{/literal}{l s='Your comment has been added!' mod='novproductcomments' js=1}{literal}";
var productcomment_added_moderation = "{/literal}{l s='Your comment has beens submitted and will be available once approved by a moderator.' mod='novproductcomments' js=1}{literal}";
var productcomment_title = "{/literal}{l s='New comment' mod='novproductcomments' js=1}{literal}";
var productcomment_ok = "{/literal}{l s='OK' mod='novproductcomments' js=1}{literal}";
var moderation_active = {/literal}{$moderation_active}{literal};
</script>
{/literal}
<div class="tab-pane fade in" id="reviews">
	<div id="product_comments_block_tab">
	{if $comments}
		{foreach from=$comments item=comment}
			{if $comment.content}
			<div class="comment clearfix">
				<div class="comment_author">
					<span>{l s='Grade' mod='novproductcomments'}&nbsp</span>
					<div class="star_content clearfix">
						{section name="i" start=0 loop=5 step=1}
							{if $comment.grade le $smarty.section.i.index}
								<div class="star"></div>
							{else}
								<div class="star star_on"></div>
							{/if}
						{/section}
					</div>
					<div class="comment_author_infos">
						<div class="user-comment"><i class="fa fa-user-o"></i>  {$comment.customer_name|escape:'html':'UTF-8'}</div>
						<div class="date-comment">{dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}</div>
					</div>
				</div>
				<div class="comment_details">
					<h4>{$comment.title}</h4>
					<p>{$comment.content|escape:'html':'UTF-8'|nl2br}</p>
					<ul>
						{if $comment.total_advice > 0}
							<li>{l s='%1$d out of %2$d people found this review useful.' sprintf=[$comment.total_useful,$comment.total_advice] mod='novproductcomments'}</li>
						{/if}
						{if $logged}
							{if !$comment.customer_advice}
							<li>{l s='Was this comment useful to you?' mod='novproductcomments'}<button class="usefulness_btn yes" data-is-usefull="1" data-id-product-comment="{$comment.id_product_comment}">{l s='yes' mod='novproductcomments'}</button><button class="usefulness_btn no" data-is-usefull="0" data-id-product-comment="{$comment.id_product_comment}">{l s='no' mod='novproductcomments'}</button></li>
							{/if}
							{if !$comment.customer_report}
							<li><span class="report_btn" data-id-product-comment="{$comment.id_product_comment}"><i class="fa fa-exclamation" aria-hidden="true"></i> {l s='Report' mod='novproductcomments'}</span></li>
							{/if}
						{/if}
					</ul>
				</div>
			</div>
			{/if}
		{/foreach}
        {if (!$too_early AND ($logged OR $allow_guests))}
		<p class="text-center mt-10">
			<a id="new_comment_tab_btn" class="open-comment-form btn btn-default" data-toggle="modal" data-target="#new_comment_form" href="#">{l s='Write your review' mod='novproductcomments'} !</a>
		</p>
        {/if}
	{else}
		{if (!$too_early AND ($logged OR $allow_guests))}
		<p class="text-center mt-10">
			<a id="new_comment_tab_btn" class="open-comment-form" data-toggle="modal" data-target="#new_comment_form" href="#">{l s='Be the first to write your review' mod='novproductcomments'} !</a>
		</p>
		{else}
		<p class="text-center mt-10">{l s='No customer reviews for the moment.' mod='novproductcomments'}</p>
		{/if}
	{/if}	
	</div>
</div>

{if isset($product) && $product}

<div class="modal fade in" id="new_comment_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<div class="modal-header">
    		<h4 class="modal-title text-xs-center"><i class="fa fa-edit"></i> {l s='Write your review' mod='novproductcomments'}</h4>
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <i class="material-icons close">close</i>
	        </button>
    	</div>
		<div class="modal-body">
			<form id="id_new_comment_form" action="#">
				{if isset($product) && $product}
				<div class="product row no-gutters">
					<div class="product-image col-4">
						<img class="img-fluid" src="{$productcomment_cover_image}" height="{$mediumSize.height}" width="{$mediumSize.width}" alt="{$product->name|escape:html:'UTF-8'}" />
					</div>
					<div class="product_desc col-8">
						<p class="product_name">{$product->name nofilter}</p>
						{$product->description_short nofilter}
					</div>
				</div>
				{/if}
				<div class="new_comment_form_content">
					<div id="new_comment_form_error" class="error alert alert-danger">
						<ul></ul>
					</div>
					{if $criterions|@count > 0}
						<ul id="criterions_list">
						{foreach from=$criterions item='criterion'}
							<li>
								<label>{$criterion.name|escape:'html':'UTF-8'}</label>
								<div class="star_content">
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="1" />
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="2" />
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="3" />
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="4" />
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="5" checked="checked" />
								</div>
								<div class="clearfix"></div>
							</li>
						{/foreach}
						</ul>
					{/if}
					<label for="comment_title">{l s='Title for your review' mod='novproductcomments'}<sup class="required">*</sup></label>
					<input id="comment_title" name="title" type="text" value=""/>

					<label for="content">{l s='Your review' mod='novproductcomments'}<sup class="required">*</sup></label>
					<textarea id="content" name="content"></textarea>

					{if $allow_guests == true && !$logged}
					<label>{l s='Your name' mod='novproductcomments'}<sup class="required">*</sup></label>
					<input id="commentCustomerName" name="customer_name" type="text" value=""/>
					{/if}

					<div id="new_comment_form_footer">
						<input id="id_product_comment_send" name="id_product" type="hidden" value='{$id_product_comment_form}' />
						<div class="fl"><sup class="required">*</sup> {l s='Required fields' mod='novproductcomments'}</div>
						<div class="fr">
							<button id="submitNewMessage" data-dismiss="modal" aria-label="Close" class="btn btn-primary" name="submitMessage" type="submit">{l s='Send' mod='novproductcomments'}</button>
						</div>
					</div>
				</div>
			</form><!-- /end new_comment_form_content -->
		</div>
		</div>
	</div>
</div>

{/if}
