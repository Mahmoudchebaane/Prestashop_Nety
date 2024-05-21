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

<div class="nov-element-category{if isset($el_class) && $el_class} {$el_class}{/if}">
	<div class="block-link-list clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title text-center">
			{$title}
		</h2>
		{/if}
		<div class="block_content">
			<div class="list_calegory">
				<ul class="list-unstyled item row p-0 no-flow m-0">
					{$content_element_category nofilter}
				</ul>
			</div>
		</div>
	</div>
</div>