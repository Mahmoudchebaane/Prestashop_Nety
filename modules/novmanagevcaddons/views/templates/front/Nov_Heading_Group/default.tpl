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

<div class="nov-heading-group{if isset($categories) && $categories} has_category{/if} mb-sm-15{$el_class}">
	<div class="block-heading-group">
		{if isset($title) && !empty($title)}
		<h2 class="title_block mb-0 text-{$title_align} style-{$title_style}"><span class="title_content">{$title nofilter}</span></h2>
		{/if}
		{if isset($view_all) && $view_all == 'true'}
		<a class="view-more" href="{$view_all_link}">{$view_all_text}</a>
		{/if}
		{if empty($categories)}
			{if isset($show_arrow_custom) && $show_arrow_custom == 'true'}
				<div class="custom-arrows ml-auto">
					<span class="custombutton prev_custom d-xs-none ml-auto"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
					<span class="custombutton next_custom d-xs-none ml-auto"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
				</div>
			{/if}
		{/if} 
		{if isset($categories) && $categories}
			<div class="group_cate d-flex align-items-center pt-15 pb-15">
				<ul class="list-category list-inline mb-0 p-0">
					{foreach from=$categories item=category}
						<li class="list-inline-item">
							<a href="{$category.link nofilter}">{$category.name}</a>
						</li>
					{/foreach}
				</ul>
				{if isset($categories) && $categories}
					{if isset($show_arrow_custom) && $show_arrow_custom == 'true'}
						<div class="custom-arrows">
							<span class="custombutton prev_custom d-xs-none ml-auto"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
							<span class="custombutton next_custom d-xs-none ml-auto"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
						</div>
					{/if}
				{/if}
			</div>
		{/if}
	</div>
</div>