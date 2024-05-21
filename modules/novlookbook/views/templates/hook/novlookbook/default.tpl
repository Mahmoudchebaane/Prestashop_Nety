{*
 * Vinova Themes Framework for Prestashop 1.6.x
 * @author      http://vinovathemes.com/
 * @copyright   Copyright (C) October 2017 vinovathemes.com <@email:vinovathemes@gmail.com>
 * @license   GNU General Public License version 1
 * @version     1.0
 * @package     novlookbook
 * <info@vinovathemes.com>.All rights reserved.
*}
<!-- Module Lookbooks -->
{if isset($lookbooks)}
	<div class="nov-lookbook row default {$novlookbook.class}">
		{foreach from=$lookbooks item=lookbook name=lookbook}
			<div class="item {$novlookbook.attributes}">
				<div class="nov-content-lookbook">
					<img class="img-fluid img-responsive" src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`novlookbook/views/img/`$lookbook.image|escape:'htmlall':'UTF-8'`")}" alt="lookbook"/>
					{if $lookbook.hotsposts}
						{foreach $lookbook.hotsposts item=hotspost name=hotspost key=k}
							<div class="item-lookbook" style="left:{$hotspost.left}%;top:{$hotspost.top}%">
								<span class="number-lookbook">{$k+1}</span>
								{if $hotspost.sku}
									<div class="content-lookbook" style="{$hotspost.style}">
										<div class="item-thumb">
											<a href="{$hotspost.link}" alt="{$hotspost.link_rewrite}" ><img src="{$hotspost.image}" alt="{$hotspost.link_rewrite}"/></a>
										</div>
										<div class="item-title">
											<a href="{$hotspost.link}" alt="{$hotspost.link_rewrite}" >{$hotspost.name}</a>
										</div>
										<div class="item-price">
											{$hotspost.price}
										</div>
									</div>
								{else}
									<div class="content-lookbook with-link" style="{$hotspost.style}">
										<a href="{$hotspost.href}" target="_blank">{$hotspost.text}</a>
									</div>
								{/if}
							</div>
						{/foreach}
					{/if}
				</div>
				{if $lookbook.title || $lookbook.description}
				<div class="info-lookbook">
					{if $lookbook.title}
						<h2 class="title-lookbook">
							{$lookbook.title}
						</h2>
					{/if}
					{if $lookbook.description}
						<div class="description-lookbook">
							{$lookbook.description nofilter}
						</div>
					{/if}
				</div>
				{/if}
			</div>
		{/foreach}
	</div>
{/if}
<!-- Module Lookbooks -->