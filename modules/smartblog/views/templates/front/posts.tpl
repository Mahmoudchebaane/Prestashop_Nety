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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{extends file="layouts/`$novconfig.novthemeconfig_cateblog_layout`.tpl"}
{block name='breadcrumb'}
	{if isset($breadcrumb)}
            <div class="breadcrumb">
		<nav class="container">
		  <ol>
		      <li>
		        <a href="{$breadcrumb.links[0].url}">
		          <span>{$breadcrumb.links[0].title}</span>
		        </a>
		      </li>
		      <li>
		        <a href="{smartblog::GetSmartBlogLink('smartblog')}">
		        <span>{l s='All Post' mod='smartblog'}</span>
		        </a>
		      </li>
		      {if $title_category != ''}
		     {assign var="link_detail" value=null}
		    {$link_detail.id_post = $id_post} 
		    {$link_detail.slug = $link_rewrite_}
		      <li>
		        <a href="{smartblog::GetSmartBlogLink('smartblog_post',$link_detail)}">
		        <span>{$meta_title}</span>
		        </a>
		      </li>
		    {/if}
		  </ol>
		</nav>
            </div>
	{/if}
{/block}
{block name='content'}
    <div class="blogwapper{if $novconfig.novthemeconfig_cateblog_layout == 'layout-one-column'} one-columns{/if}{if $novconfig.novthemeconfig_cateblog_layout == 'layout-left-column'} has-sidebar-left{/if}{if $novconfig.novthemeconfig_cateblog_layout == 'layout-right-column'} has-sidebar-right{/if}">
        {capture name=path}<a href="{smartblog::GetSmartBlogLink('smartblog')}">{l s='All Blog News' d='Modules.Blog'}</a>{$meta_title}{/capture}
    <div id="content" class="block">
        <div itemtype="#" itemscope="" id="sdsblogArticle" class="blog-post">
                <div class="post-img">
                    {assign var="activeimgincat" value='0'}
                    {$activeimgincat = $smartshownoimg}
                    {if ($post_img != "no" && $activeimgincat == 0) || $activeimgincat == 1}
                        <a id="post_images" href="{$modules_dir}/smartblog/images/{$post_img}-single-default.jpg"><img class="img-fluid" src="{$modules_dir}/smartblog/images/{$post_img}-single-default.jpg" alt="{$meta_title}"></a>
                            {/if}
        </div>
                <h1 class="post-title">{$meta_title}</h1>

                <div class="articleContent" itemprop="articleBody">
                    <div class="sdsarticle-des">
                        {$content nofilter}
                </div>
            </div>
            {if $tags != ''}
                <div class="sdstags-update">
                        <span class="tags"><b>{l s='Tags:' d='Modules.Blog'} </b>
                        {foreach from=$tags item=tag}
                                {assign var="options" value=null}
                                {$options.tag = $tag.name}
                                <a title="tag" href="{smartblog::GetSmartBlogLink('smartblog_tag',$options)}">{$tag.name}</a>
                        {/foreach}
                    </span>
                </div>
            {/if}
                <div class="sdsarticleBottom d-flex align-items-center">
                    <div class="post-info col-md-8 col-12 no-padding">
                        {assign var="catOptions" value=null}
                        {$catOptions.id_category = $id_category}
                        {$catOptions.slug = $cat_link_rewrite}
                        <span class="datetime">{$post.created|date_format:"%B %d, %Y"}</span>
                        <span class="comment">
                    {if $countcomment != ''}{$countcomment}{else}{l s='0' d='Modules.Blog'}{/if}{l s=' Comments' d='Modules.Blog'}
                </span>
                {if $smartshowauthor == 1}

                    <span itemprop="author" class="author">
                        {if $smartshowauthorstyle != 0}{$post.firstname} {$post.lastname}{else}{$post.lastname} {$post.firstname}{/if}
                    </span>
        {/if}
                <a title="" style="display:none" itemprop="url" href="#"></a>
    </div>
            <div class="col-md-4 col-12 button-share no-padding">
                <div class="dropdown social-sharing">
                    {assign var="optionspost" value=null}
                    {$optionspost.id_post = $post.id_post}
                    {$optionspost.slug = $post.link_rewrite}
                    <button class="btn btn-link" type="button" id="social-sharingButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fa fa-share-alt" aria-hidden="true"></i>Share</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="social-sharingButton">
                        <a class="dropdown-item" href="http://www.facebook.com/sharer.php?u={smartblog::GetSmartBlogLink('smartblog_post',$optionspost)}" title="Share" target="_blank"><i class="fa fa-facebook"></i>{l s='Facebook' d='Modules.Blog'}</a></a>
                        <a class="dropdown-item" href="https://twitter.com/intent/tweet?text={$meta_title} {smartblog::GetSmartBlogLink('smartblog_post',$optionspost)}" title="Twitter" target="_blank"><i class="fa fa-twitter"></i>{l s='Twitter' d='Modules.Blog'}</a>
                        <a class="dropdown-item" href="https://plus.google.com/share?url={smartblog::GetSmartBlogLink('smartblog_post',$optionspost)}" title="Google+" target="_blank"><i class="fa fa-google-plus"></i>{l s='Google Plus' d='Modules.Blog'}</a>
</div>
</div>

                <a class="btn btn-link" href="javascript:print();">
                    <span><i class="fa fa-print" aria-hidden="true"></i>{l s='Print' d='Shop.Theme.Actions'}</span>
                </a>
            </div>
        </div>
        {hook h="displaySmartAfterPost"}
    </div>

{if $countcomment != ''}
    <div id="articleComments">
        <h3>{if $countcomment != ''}{$countcomment|escape:'htmlall':'UTF-8'}{else}{l s='0' mod='smartblog'}{/if}{l s=' Comments' mod='smartblog'}<span></span></h3>
        <div id="comments">      
            <ul class="commentList">
                {$i=1}
                {foreach from=$comments item=comment}
                    {include file="module:smartblog/views/templates/front/comment_loop.tpl" childcommnets=$comment}
                {/foreach}
            </ul>
        </div>
    </div>
{/if}

{if ($enableguestcomment==0) && isset($is_looged) && $is_looged==''}
    <section class="page-product-box">
        <h3 class="page-product-heading">{l s='Comments' mod='smartblog'}</h3>
        {l s='Log in or register to post comments' mod='smartblog'}
    </section>
{else}
    {if Configuration::get('smartenablecomment') == 1}
        {if $comment_status == 1}
            <div class="smartblogcomments" id="respond">
                    <h4 class="comment-reply-title" id="reply-title">{l s='Submit comment'  mod='smartblog'}
                    <small style="float:right;">
                        <a style="display: none;" href="/wp/sellya/sellya/this-is-a-post-with-preview-image/#respond" id="cancel-comment-reply-link" rel="nofollow">{l s='Cancel Reply'  mod='smartblog'}</a>
                    </small>
                </h4>
                <div id="commentInput">
                        <form action="" method="post" id="commentform" class="row no-flow">
                                {if ($enableguestcomment==0) && isset($is_looged) && $is_looged>0}
                                <div class="col-md-4">
                                            <input type="hidden" tabindex="1" class="inputName form-control grey" value="{$is_looged_fname|escape:'htmlall':'UTF-8'}" name="name" id="name">
                                </div>
                                <div class="col-md-4">
                                            <input type="hidden" tabindex="2" class="inputMail form-control grey" value="{$is_looged_email|escape:'htmlall':'UTF-8'}" name="mail" id="mail">
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" tabindex="3" value="" name="website" class="form-control grey">
                                </div>
                                {else}
                                <div class="col-md-4">
                                    <input type="text" tabindex="1" class="inputName form-control grey" value="" name="name" placeholder="{l s='Your Name'  mod='smartblog'}">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" tabindex="2" class="inputMail form-control grey" value="" name="mail" placeholder="{l s='E-mail:' mod='smartblog'}{l s='(Not Published)'  mod='smartblog'}">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" tabindex="3" value="" name="website" class="form-control grey" placeholder="{l s='Website:'  mod='smartblog'} {l s='(Site url with'  mod='smartblog'}http://)">
                                </div>
                                {/if}	
                            <div class="col-12 mt-10">
                                <textarea tabindex="4" class="inputContent form-control grey" rows="8" cols="50" name="comment" placeholder="{l s='Comment'  mod='smartblog'}"></textarea>
                            </div>
                            <div class="col-12">
                                {if Configuration::get('smartcaptchaoption') == '1'}
                                    <img src="{$modules_dir|escape:'htmlall':'UTF-8'}smartblog/classes/CaptchaSecurityImages.php?width=100&height=40&characters=5">
                                    <b>{l s='Type Code' mod='smartblog'}</b>
                                    <input type="text" tabindex="" value="" name="smartblogcaptcha" class="smartblogcaptcha form-control grey mt-30">
                                {/if}
                        <input type='hidden' name='comment_post_ID' value='1478' id='comment_post_ID' />
                        <input type='hidden' name='id_post' value='{$id_post|escape:'htmlall':'UTF-8'}' id='id_post' />
                        <input type='hidden' name='comment_parent' id='comment_parent' value='0' />
                            <div class="submit">
                                    <button type="submit" name="addComment" id="submitComment" class="bbutton btn btn-default button-medium" >{l s='Post a comment' mod='smartblog'}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            </div>
				{/if}
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
				<script type="text/javascript">
					$('#submitComment').bind('click',function(event) {
					event.preventDefault();
					 
					 
					var data = { 'action':'postcomment', 
					'id_post':$('input[name=\'id_post\']').val(),
					'comment_parent':$('input[name=\'comment_parent\']').val(),
					'name':$('input[name=\'name\']').val(),
					'website':$('input[name=\'website\']').val(),
					'smartblogcaptcha':$('input[name=\'smartblogcaptcha\']').val(),
					'comment':$('textarea[name=\'comment\']').val(),
					'mail':$('input[name=\'mail\']').val() };
						$.ajax( {
						  url: '{$baseDir}modules/smartblog/ajax.php',
						  data: data,
						  method: 'POST',
						  dataType: 'json',
						  
						  beforeSend: function() {
									$('.success, .warning, .error').remove();
									$('#submitComment').attr('disabled', true);
									//$('#commentInput').before('<div class="attention"><img src="views/img/loading.gif" alt="" />Please wait!</div>');

									},
									complete: function() {
									$('#submitComment').attr('disabled', false);
									$('.attention').remove();
									},
							success: function(json) {
								if (json['error']) {
										 
											$('#commentInput').before('<div class="warning">' + '<i class="icon-warning-sign icon-lg"></i>' + json['error']['common'] + '</div>');
											
											if (json['error']['name']) {
												$('.inputName').after('<span class="error">' + json['error']['name'] + '</span>');
											}
											if (json['error']['mail']) {
												$('.inputMail').after('<span class="error">' + json['error']['mail'] + '</span>');
											}
											if (json['error']['comment']) {
												$('.inputContent').after('<span class="error">' + json['error']['comment'] + '</span>');
											}
											if (json['error']['captcha']) {
												$('.smartblogcaptcha').after('<span class="error">' + json['error']['captcha'] + '</span>');
											}
										}
										
										if (json['success']) {
											$('input[name=\'name\']').val('');
											$('input[name=\'mail\']').val('');
											$('input[name=\'website\']').val('');
											$('textarea[name=\'comment\']').val('');
									 		$('input[name=\'smartblogcaptcha\']').val('');
										
											$('#commentInput').before('<div class="success">' + json['success'] + '</div>');
											setTimeout(function(){
												$('.success').fadeOut(300).delay(450).remove();
																		},2500);
										
										}
									}
								} );
							} );
					    var addComment = {
						moveForm : function(commId, parentId, respondId, postId) {

							var t = this, div, comm = t.I(commId), respond = t.I(respondId), cancel = t.I('cancel-comment-reply-link'), parent = t.I('comment_parent'), post = t.I('comment_post_ID');
							if ( ! comm || ! respond || ! cancel || ! parent )
								return;
					                    
					 		t.I('mail').value='{$is_looged_email|escape:'htmlall':'UTF-8'}';
					 		t.I('name').value='{$is_looged_fname|escape:'htmlall':'UTF-8'}';
							t.respondId = respondId;
							postId = postId || false;

							if ( ! t.I('wp-temp-form-div') ) {
								div = document.createElement('div');
								div.id = 'wp-temp-form-div';
								div.style.display = 'none';
								respond.parentNode.insertBefore(div, respond);
							}


							comm.parentNode.insertBefore(respond, comm.nextSibling);
							if ( post && postId )
								post.value = postId;
							parent.value = parentId;
							cancel.style.display = '';

							cancel.onclick = function() {
								var t = addComment, temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId);

								if ( ! temp || ! respond )
									return;

								t.I('comment_parent').value = '0';
								t.I('mail').value='{$is_looged_email|escape:'htmlall':'UTF-8'}';
					 			t.I('name').value='{$is_looged_fname|escape:'htmlall':'UTF-8'}';
								temp.parentNode.insertBefore(respond, temp);
								temp.parentNode.removeChild(temp);
								this.style.display = 'none';
								this.onclick = null;
								return false;
							};

							try { t.I('comment').focus(); }
							catch(e) {}

							return false;
						},

						I : function(e) {
							var elem = document.getElementById(e);
					                if(!elem){
					                    return document.querySelector('[name="'+e+'"]');
					                }else{
					                    return elem;
					                }
						}
					}; 
				</script>
			{/if}
		{/if}
		{if isset($smartcustomcss)}
		    <style>
		        {$smartcustomcss|escape:'htmlall':'UTF-8'}
		    </style>
		{/if}
{/block}