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

<div class="nov-restaurantmenu{if isset($el_class) && $el_class} {$el_class}{/if}">
	<div class="block-restaurantmenu clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-center">
			{$title}
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title mt-10 mb-25">{$sub_title}</span>
			{/if}
			{$img_title nofilter}
		</h2>
		{/if}
		<div class="block_content">
			<div class="restaurantmenu_list row no-flow spacing-100">
				{$content_restaurantmenu nofilter}
			</div>
		</div>
	</div>
</div>