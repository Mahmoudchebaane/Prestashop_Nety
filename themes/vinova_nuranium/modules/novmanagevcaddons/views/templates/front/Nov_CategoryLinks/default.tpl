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

<div class="nov-categorylinks style-{$style}{$el_class}">
	<div class="block-categorylinks clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block">
			{$title}
		</h2>
		{/if}

		<div class="block_content">
			<ul class="list-unstyled mb-0 p-0">
			{foreach from=$categories item=category}
				<li>
					<a href="{$category.link nofilter}">{$category.name}</a>
				</li>
			{/foreach}
			</ul>
		</div>
	</div>
</div>