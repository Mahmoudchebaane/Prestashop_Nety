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

<div class="nov-map style-1{if isset($el_class) && !empty($el_class)} {$el_class}{/if}">
	<div class="block block-map clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block">
			<div>
				<div class="title">{$title}</div>
				{if isset($sub_title) && !empty($sub_title)}
					<span class="sub_title">{$sub_title}</span>
				{/if}
				<div class="desc_title">{if !empty($desc_title)}{$desc_title}{/if}</div>
			</div>
		</h2>
		{/if}
		<div class="block_content">
			<div class="map-content" height="{$size}" width = "{$novmapwidth}">
				{$link nofilter}
			</div>
		</div>
	</div>
</div>
