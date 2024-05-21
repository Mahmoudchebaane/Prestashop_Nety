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

{if isset($products)}
<div class="nov-productlist {if isset($el_class) && $el_class} {$el_class}{/if}">
	<div class="block-product clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			<span class="title_content">{$title}</span>
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content block_content_item_2">
			<div class="nov-productslick product_list grid slick-slider row {if isset($class_homepage) && $class_homepage && $class_homepage != 'home-33' && $page.page_name == 'index'} spacing-15 {/if}" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
				{include file="$nov_dir./templates/_partials/layout/items/item_two.tpl" class_item='col-6' showdeal=false}
			</div>
		</div>
	</div>
</div>
{/if}