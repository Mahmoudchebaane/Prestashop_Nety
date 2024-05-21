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

<div class="policy-item style-1{$el_class}{if $bg == true} has_bg{/if}{$el_class}"{if $bg == true} style="background: {$accent_color};"{/if}>
	<div>
		{$policy_icon nofilter}
		<div class="title_policy title-style-{$title_style}">{$title}</div>
		<div class="content-policy">{$content_policy nofilter}</div>
	</div>
</div>
