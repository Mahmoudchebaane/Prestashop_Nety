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

{if isset($testimonials) && !empty($testimonials)}
<div class="nov-testimonial type_4{if isset($el_class) && $el_class}{$el_class}{/if}">
	<div class="testimonial clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
			<span class="title_content">{$title}</span>
		</h2>
		{/if}
		<div class="box-margin">
			<div class="box-padding">
				<div class="block_content">
					<div class="nov-testimonialslick slick-slider row" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">        
			            {foreach from=$testimonials item=testimonial}
			            <div class="item col">
			               	<div class="item-testimonial slider-type-four">
								{if $testimonial.name }
									<h5 class="box-info">{$testimonial.name}</h5>
								{/if}
								{if $testimonial.address }
									<span class="box-dress text-uppercase">{$testimonial.address}</span>
								{/if}
								{if $testimonial.content }
									<div class="text mt-18 mb-15">{$testimonial.content|truncate:225 nofilter}</div>
								{/if}
							</div>
						</div>
			            {/foreach}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{/if}