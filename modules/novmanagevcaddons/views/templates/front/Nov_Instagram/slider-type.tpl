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

{if isset($images) && !empty($images)}
<div id="instagram" class="nov-instagramlist{$el_class}">
	<div class="block-instagramlist clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			<span class="title_content">{$title}</span>
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content">
			<div class="nov-instagramslick slick-slider row spacing-{$spacing}" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">          
	            {foreach from=$images key=i item=image}
	            	<div class="item col">
		               	<div class="item item-instagram d-flex">
							<a href="{$url[$i]}" title="{$user[$i]->full_name}" target="_blank">
								<img class="img-fluid" src="{$image->standard_resolution->url}" alt=""/>
							</a>
						</div>
					</div>
	            {/foreach}
		    </div>
		</div>
	</div>
</div>
{/if}