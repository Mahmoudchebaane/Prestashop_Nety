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

<div class="nov_button type-{$button_type}{if !empty($el_class)}{$el_class}{/if}"{if $button_type == '7'} style="background: {$accent_color};"{/if}>
	{if $button_type != '7'}
		<a href="{$nov_button_link}">{if isset($icon) && !empty($icon)}{$btn_icon nofilter}{/if}{$nov_button_text}</a>
	{else}
		{$nov_button_text}
	{/if}
</div>
