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

<div class="nov-link-list style-3{if isset($icon_hover) && !empty($icon_hover)} hover_img{/if}{if isset($border_right) && $border_right == true} border_right{/if}{if isset($el_class) && $el_class}{$el_class}{/if}">
	<div class="block-link-list clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title text-{$title_align}">{$title}</h2>
		{/if}
		<div class="block_content">
			<div class="link_list">
				<ul class="list-unstyled item p-0">
					{$content_list_link nofilter}
				</ul>
			</div>
		</div>
	</div>
</div>