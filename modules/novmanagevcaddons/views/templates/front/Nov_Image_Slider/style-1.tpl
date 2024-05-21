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

<div class="nov_image_slider{if !empty($el_class)}{$el_class}{/if}">
	<div class="nov-imageslick row spacing-{$spacing} slick-slider" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
		{foreach from=$images item=image}
	       	<div class="item image col">
				{$image nofilter}
			</div>
	    {/foreach}
	</div>	
</div>
