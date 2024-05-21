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

<div class="nov-socials{$el_class}">
	<div class="block-socials clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block">
			{$title}
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}

		<div class="block_content">
			<ul class="list-inline mb-0">
				{$content_socials nofilter}
			</ul>
		</div>
	</div>
</div>