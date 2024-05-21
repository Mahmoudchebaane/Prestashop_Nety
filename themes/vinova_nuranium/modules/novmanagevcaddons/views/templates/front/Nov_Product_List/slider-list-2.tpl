{if isset($products)}
<div class="nov-productlist slider-list-2{if isset($el_class) && $el_class} {$el_class}{/if}">
	<div class="block-product clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			<span class="title_content">{$title}</span>
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content">
			<div class="nov-product-list-2 product_list product_item_list style-2 slick-slider row" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
				{include file="$nov_dir./templates/_partials/layout/items/item_list.tpl" showdeal=false}
			</div>
		</div>
	</div>
</div>
{/if}