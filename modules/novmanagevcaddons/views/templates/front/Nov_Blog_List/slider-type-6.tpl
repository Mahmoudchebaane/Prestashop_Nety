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
<div class="nov-bloglist slider-style-6{$el_class}">
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
			<div class="nov-blogslick row slick-slider novblog-box-content" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
	            {foreach from=$posts item=post}
	                {assign var="options" value=null}
	                {$options.id_post = $post.id}
	                {$options.slug = $post.link_rewrite}
	                <div class="item post-item col item_list">
	                	<div class="row">
		                    <div class="post-image col-md-5 mb-xs-15">
		                        <a href="{smartblog::GetSmartBlogLink('smartblog_post', $options)}">
		                        	<img alt="{$post.title}" class="feat_img_small img-fluid" src="{$nov_modules_dir}/smartblog/images/{$post.post_img}-home-default.jpg">
		                        </a>
		                    </div>
		                    <div class="col-md-7">
			                    <div class="post_title mb-10 mb-xs-5"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></div>
			                    <div class="post-info">
			                    	<span><i class="zmdi zmdi-calendar-note"></i>{$post.date_added|date_format:"%d %B, %Y"}</span>
			                    	&nbsp;&nbsp;&nbsp;|
			                    	<span>
			                    		<i class="zmdi zmdi-comments"></i> {if $post.countcomment != ''}{$post.countcomment}{else}0{/if}
			                    	</span>
			                    </div>
			                </div>
		                </div>
	                </div>
	            {/foreach}
		    </div>
		</div>
	</div>
</div>
{/if}