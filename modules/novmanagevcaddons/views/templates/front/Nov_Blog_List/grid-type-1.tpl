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

{if isset($posts) && !empty($posts)}
<div class="nov-bloglist{$el_class}">
	<div class="block block-blog clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			<span class="title_content">{$title}</span>
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content grid-style-1">
			<div class="row no-flow novblog-box-content">
	            {assign var='i' value=1}
	            {foreach from=$posts item=post}
	                {assign var="options" value=null}
	                {$options.id_post = $post.id}
	                {$options.slug = $post.link_rewrite}
	                <div class="item post-item {$column} mb-30">
	                    <div class="post-image">
	                         <a href="{smartblog::GetSmartBlogLink('smartblog_post', $options)}"><img alt="{$post.title}" class="feat_img_small img-fluid" src="{$nov_modules_dir}smartblog/images/{$post.post_img}-home-default.jpg"></a>
	                    </div>
	                    <div class="post-info mt-30">
	                        <span>
	                          <i class="fa fa-comments"></i> {if $post.countcomment != ''}{$post.countcomment} {l s='comments' mod='novmanagevcaddons'}{else}{l s='0 comment' mod='novmanagevcaddons'}{/if}
	                        </span>
	                        <span>
	                        	<i class="fa fa-calendar" aria-hidden="true"></i>{$post.date_added|date_format:"%d %B, %Y"}
	                    	</span>
	                    </div>
	                    <div class="post_title"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></div>
	                    <div class="post-desc">
	                        {$post.short_description|escape:'htmlall':'UTF-8'}
	                    </div>
	                    <div class="">
	                    	<a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="read_more">{l s='Read More' mod='novmanagevcaddons'}</a>
	                	</div>
	                </div>
	            {/foreach}
			</div>
		</div>
	</div>
</div>
{/if}