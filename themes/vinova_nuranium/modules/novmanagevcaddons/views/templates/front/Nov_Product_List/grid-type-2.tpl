{if isset($products)}
<div class="nov-productlist grid-type-2{if isset($class) && $class} {$class}{/if}">
	<div class="block-product clearfix">
		{if isset($title) && !empty($title)}
		<h2 class="title_block text-{$title_align} style-{$title_style}">
			{$title}
			{if isset($sub_title) && !empty($sub_title)}
				<span class="sub_title">{$sub_title}</span>
			{/if}
		</h2>
		{/if}
		<div class="block_content">
			<div class="product_list grid row no-flow spacing-{$spacing}">
				{include file="$nov_dir./templates/_partials/layout/items/item_ten.tpl" class_item=$column number_row=1 showdeal=false margin_bottom =$spacing}
			</div>
		</div>
	</div>
</div>
{/if}