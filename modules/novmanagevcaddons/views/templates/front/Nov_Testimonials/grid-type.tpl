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
<div class="nov-testimonial{$el_class}">
	<div class=testimonial clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			<span class="title_content">{$title}</span>
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content">      
            {foreach from=$testimonials item=testimonial}
               	<div class="item item-testimonial grid-type-one">
					<div class="media d-xs-block">
						{if isset($testimonial.image) && $testimonial.image neq "" }
						<div class="testimonial-avatar d-flex">
							<img class="img-fluid" src="{$image_path}{$testimonial.image}" alt="">
						</div>
						{/if}
						<div class="media-body">
							{if $testimonial.name }
							<h5 class="mt-0 box-info mt-10 mt-xs-30">{$testimonial.name}</h5>
							{/if}
							{if $testimonial.address }
								<span class="box-dress mb-15">{$testimonial.address}</span>
							{/if}
							<div class="text">{$testimonial.content nofilter}</div>
						</div>
					</div>
				</div>
            {/foreach}
		</div>
	</div>
</div>
{/if}