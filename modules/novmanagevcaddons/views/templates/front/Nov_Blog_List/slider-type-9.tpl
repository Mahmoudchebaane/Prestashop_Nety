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
<div class="nov-bloglist slider-style-9{$el_class}">
	<div class="block-blog clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			<span class="title_content">{$title}</span>
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content">
			<div class="nov-blogslick slick-slider novblog-box-content" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
	            {foreach from=$posts item=post}
	                {assign var="options" value=null}
	                {$options.id_post = $post.id}
	                {$options.slug = $post.link_rewrite}
	                <div class="item post-item item_list">
	                	<div class="row">
		                    <div class="post-image col-md-6 mb-xs-15">
		                        <a class="position-relative" href="{smartblog::GetSmartBlogLink('smartblog_post', $options)}">
		                        	<img alt="{$post.title}" class="feat_img_small img-fluid" src="{$nov_modules_dir}/smartblog/images/{$post.post_img}-home-default.jpg">
	                        		<span class="post-time position-absolute">
	        	                        <span class="date">{$post.date_added|date_format:"%d"}</span>
	        	                    	<span class="month d-block">{$post.date_added|date_format:"%b"}</span>
	        	                    </span>
		                        </a>
		                    </div>
		                    <div class="col-md-6">
			                    <div class="post-info">
			                    	<span><i class="zmdi zmdi-calendar-note"></i>{$post.date_added|date_format:"%d %B, %Y"}</span>
			                    </div>
			                    <div class="post_title mb-20 mb-xs-5"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></div>
			                    <div class="post-desc">{$post.short_description|escape:'htmlall':'UTF-8'|truncate:120}</div>
			                </div>
		                </div>
	                </div>
	            {/foreach}
		    </div>
		</div>
	</div>
</div>
{/if}