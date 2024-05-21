{if isset($images) && count($images) > 0}
	{if count($images) == 1}
		<div class="nov-image-more" data-idproduct="{$product->id}">
			{if isset($images)}
				{foreach from=$images item=image name=thumbnails}
					{assign var=imageIds value="`$product->id`-`$image.id_image`"}
					{if !empty($image.legend)}
						{assign var=imageTitle value=$image.legend|escape:'html':'UTF-8'}
					{else}
						{assign var=imageTitle value=$product->name|escape:'html':'UTF-8'}
					{/if}
						<a href="{$link->getProductlink($product->id, $product->link_rewrite)|escape:'html'}"	data-fancybox-group="other-views" title="{$imageTitle}">
							<img class="img-responsive" src="{$link->getImageLink($product->link_rewrite, $imageIds, 'home_default')|escape:'html':'UTF-8'}" alt="{$imageTitle}" title="{$imageTitle}"  itemprop="image" />
						</a>
				{/foreach}
			{/if}
		</div>
	{else} 
		<div class="nov-image-more multi" data-idproduct="{$product->id}">
				<div class="views_block clearfix {if isset($images) && count($images) < 2}hidden{/if}">
				{if isset($images) && count($images) > 5}
					<span class="view_scroll_spacer">
						<a class="view_scroll_left view_scroll_left_{$product->id}" data-idproduct="{$product->id}" title="{l s='Other views' mod='novthemeconfig'}" href="javascript:{ldelim}{rdelim}">
							<em class="icon icon-chevron-up"></em>
						</a>
					</span>
				{/if}	
				<div class="thumbs_list thumbs_list_{$product->id}">
					<ul class="thumbs_list_frame">
						{if isset($images)}
							{foreach from=$images item=image}
								{assign var=imageIds value="`$product->id`-`$image.id_image`"}
								{if !empty($image.legend)}
									{assign var=imageTitle value=$image.legend|escape:'html':'UTF-8'}
								{else}
									{assign var=imageTitle value=$product->name|escape:'html':'UTF-8'}
								{/if}
									<li>
										<a href="{$link->getImageLink($product->link_rewrite, $imageIds, 'thickbox_default')|escape:'html':'UTF-8'}" data-fancybox-group="other-views" title="{$imageTitle}">
											<img class="img-responsive nov-list-image" src="{$link->getImageLink($product->link_rewrite, $imageIds, 'cart_default')|escape:'html':'UTF-8'}" alt="{$imageTitle}"   title="{$imageTitle}"  itemprop="image" />
										</a>
									</li>
							{/foreach}
						{/if}
					</ul>
				</div>
				{if isset($images) && count($images) > 5}
					<a class="view_scroll_right view_scroll_right_{$product->id}" data-idproduct="{$product->id}" title="{l s='Other views' mod='novthemeconfig'}" href="javascript:{ldelim}{rdelim}">
						<em class="icon icon-chevron-down"></em>
					</a>
				{/if}
			</div>
		</div>
	{/if}	
{/if}
