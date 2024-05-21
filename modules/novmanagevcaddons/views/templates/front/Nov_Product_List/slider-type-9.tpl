{if isset($products)}
<div class="nov-productlist slider-type-9{if $title_style == 4} title_4{/if}{if isset($el_class) && $el_class}{$el_class}{/if}">
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
			<div class="nov-productslick product_list grid slick-slider row spacing-{$spacing}" data-rows="{$number_row}" data-xl="{$xl}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
				{include file="$nov_dir./templates/_partials/layout/items/item_nine.tpl" class_item='col' showdeal=false margin_bottom =$spacing}
		</div>
	</div>
</div>
{/if}