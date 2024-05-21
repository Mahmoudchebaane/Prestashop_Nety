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
	<div class="slider-for">
		{foreach from=$images item=image}
	       	<div class="item image">
				{$image nofilter}
			</div>
	    {/foreach}
	</div>
	<div class="slider-nav row spacing-10 mt-5">
		{foreach from=$images item=image}
	       	<div class="item image col">
				{$image nofilter}
			</div>
	    {/foreach}
	</div>
</div>
