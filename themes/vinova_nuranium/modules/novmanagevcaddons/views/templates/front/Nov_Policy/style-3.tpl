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

<div class="policy-item style-3 text-xs-center{if $bg == true} has_bg{/if}{$el_class}"{if $bg == true} style="background: {$accent_color};"{/if}>
	<div class="d-lg-flex align-items-center">
		<div class="policy_icon">{$policy_icon nofilter}</div>
		<div class="media-body">
			<div class="text-uppercase sub_title">{$sub_title}</div>
			<div class="title_policy title-style-{$title_style}">{$title}</div>
			{if $content_policy}<div class="content-policy">{$content_policy nofilter}</div>{/if}
		</div>
	</div>
</div>