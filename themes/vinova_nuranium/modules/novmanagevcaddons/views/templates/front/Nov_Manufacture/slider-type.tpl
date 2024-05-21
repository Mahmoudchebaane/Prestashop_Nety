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

{if isset($manus) && !empty($manus)}
<div class="nov-manufacturelist style-{$mn_style}{$el_class}">
	<div class="block-manufacturelist clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block">
			<span class="title">{$title}</span>
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content">
			<div class="nov-manufactureslick slick-slider" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">          
	            {foreach from=$manus item=manu}
	               	<div class="item logo-manu">
						<a href="{$link->getmanufacturerLink($manu.id_manufacturer, $manu.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$manu.name}">
							<img class="img-fluid" src="{$manu.image|escape:'htmlall':'UTF-8'}" alt="logo-manu"/>
						</a>
					</div>
	            {/foreach}
		    </div>
		</div>
	</div>
</div>
{/if}