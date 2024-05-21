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

<div class="nov-producttabs{$el_class} tab-style-{$tabs_style}">
	<div class="block-producttabs clearfix">
		{if $tabs_style == '2' || $tabs_style == '3' || $tabs_style == '4' || $tabs_style == '5' || $tabs_style == '7'}
			{if isset($title) && !empty($title)}
				<h2 class="title_block text-center mb-30">
					<span class="title_content">{$title}</span>
					{if isset($sub_title) && !empty($sub_title)}
						<span class="sub_title">{$sub_title}</span>
					{/if}
				</h2>
			{/if}
		{/if}
		<div class="d-flex align-items-center d-xs-block{if $tabs_style == '2' || $tabs_style == '3' || $tabs_style == '4' || $tabs_style == '7'} justify-content-center{/if} block_nav">
			{if $tabs_style == '1' || $tabs_style == '6'}
				{if isset($title) && !empty($title)}
					<h2 class="title_block">
						{$title}
						{if isset($sub_title) && !empty($sub_title)}
							<span class="sub_title">{$sub_title}</span>
						{/if}
					</h2>
				{/if}
			{/if}

			<ul class="nav nav-tabs" role="tablist">
				{foreach from=$tabs item=tab_item name=tab}
					{if $tab_item == 'newproducts'}
		      			<li class="nav-item">
		      				<a href="#newproducts{$tab}" class="nav-link active" role="tab" data-toggle="tab" aria-selected="true">{l s='New Arrivals' mod='novmanagevcaddons'}</a>
		      			</li>
					{/if}
					{if $tab_item == 'bestsellers'}
		      			<li class="nav-item">
		      				<a href="#bestsellers{$tab}" class="nav-link" role="tab" data-toggle="tab" aria-selected="false">{l s='Bestseller' mod='novmanagevcaddons'}
		      				</a>
		      			</li>
					{/if}
					{if $tab_item == 'specialproducts'}
		      			<li class="nav-item">
		      				<a href="#specialproducts{$tab}" class="nav-link" role="tab" data-toggle="tab" aria-selected="false">{l s='On Sale' mod='novmanagevcaddons'}</a></li>
					{/if}
					{if $tab_item == 'featureproducts'}
		      			<li class="nav-item">
		      				<a href="#featureproducts{$tab}" class="nav-link" role="tab" data-toggle="tab" aria-selected="false">{l s='Featured Product' mod='novmanagevcaddons'}</a></li>
					{/if}
			  	{/foreach}
		    </ul>			
		</div>
		<div class="block_content">
			<div class="tab-content">
				{foreach from=$tabs item=tab_item name=tabcontent}
					{if $tab_item == 'newproducts'}
					<div class="tab-pane fade active" id="newproducts{$tab}" role="tabpanel">
						{if !empty($newproducts)}
							<div class="nov-productgrid product_list grid row">
								{include file="$nov_dir./templates/_partials/layout/items/item_one.tpl" products=$newproducts class_item=$column showdeal=false}
							</div>
						{else}
							<p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
						{/if}
					</div>
					{/if}
					{if $tab_item == 'bestsellers'}
					<div class="tab-pane fade" id="bestsellers{$tab}" role="tabpanel">
						{if !empty($bestsellersproducts)}
							<div class="nov-productgrid product_list grid row" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
								{include file="$nov_dir./templates/_partials/layout/items/item_one.tpl" products=$bestsellersproducts class_item=$column showdeal=false}
							</div>
						{else}
							<p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
						{/if}
					</div>
					{/if}
					{if $tab_item == 'specialproducts'}
					<div class="tab-pane fade" id="specialproducts{$tab}" role="tabpanel">
						{if !empty($specialproducts)}
							<div class="nov-productgrid product_list grid row" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
								{include file="$nov_dir./templates/_partials/layout/items/item_one.tpl" products=$specialproducts class_item=$column showdeal=false}
							</div>
						{else}
							<p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
						{/if}
					</div>
					{/if}
					{if $tab_item == 'featureproducts'}
					<div class="tab-pane fade" id="featureproducts{$tab}" role="tabpanel">
						{if !empty($featureproducts)}
							<div class="nov-productgrid product_list grid row" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
								{include file="$nov_dir./templates/_partials/layout/items/item_one.tpl" products=$featureproducts class_item=$column showdeal=false}
							</div>
						{else}
							<p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
						{/if}
					</div>
					{/if}
				{/foreach}
			</div>
		</div>
	</div>
</div>