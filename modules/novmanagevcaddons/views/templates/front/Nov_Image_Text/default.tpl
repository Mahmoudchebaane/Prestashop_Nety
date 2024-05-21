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

<div class="nov_image_text{if !empty($el_class)}{$el_class}{/if}">
	<div class="d-flex">
		{$image nofilter}
		<div class="content_text">
			<div class="text_top">{$texttop nofilter}</div>
			<div class="text_botton">{$textbottom nofilter}</div>
		</div>
	</div>
</div>
