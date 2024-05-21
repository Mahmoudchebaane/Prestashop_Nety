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

<div class="nov_group_image_text style-{$style}{if isset($el_class) && $el_class} {$el_class}{/if}">
	<div class="block-nov-group-image-text clearfix">
		{if isset($title) && !empty($title) or isset($text_link) && !empty($text_link)}
			<div class="block_header d-flex align-items-center mb-25">
				{if isset($title) && !empty($title)}<h2 class="title">{$title}</h2>{/if}
				{if isset($text_link) && !empty($text_link)}
					<a href="{$header_link}">{$text_link}</a>
				{/if}
			</div>
		{/if}
		<div class="block_content">
			<div class="row no-flow spacing-{$spacing}">{$content_group_image_text nofilter}</div>
		</div>
	</div>
</div>