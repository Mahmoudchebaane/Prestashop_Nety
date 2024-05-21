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

{if isset($lookbooks) && !empty($lookbooks)}
<div class="nov-lookbooklist{$el_class}">
	<div class="block block-lookbooklist clearfix">
		{if isset($title) && !empty($title)}
			{if $type_title == '1'}
				<h2 class="title_block type_1">
					<div class="title">{$title}</div>
					{if isset($sub_title) && !empty($sub_title)}
						<div class="sub_title">{$sub_title}</div>
					{/if}
					{if !empty($desc_title)}
					<div class="desc_title">{$desc_title nofilter}</div>
					{/if}
				</h2>
			{else}
				<h2 class="title_block type_2 d-flex align-items-center justify-content-center">
					<div>
						{if isset($sub_title) && !empty($sub_title)}
							<span class="sub_title">{$sub_title}</span>
						{/if}
						<span class="title">{$title}</span>
						<div class="desc_title">{$desc_title nofilter}</div>
					</div>
				</h2>
			{/if}
		{/if}
		
		<div class="block_content">
			<div class="row no-flow spacing-10">
			{foreach from=$lookbooks item=lookbook name=lookbook}
				<div class="item {$column}">
					<div class="nov-content-lookbook mb-10">
						<img class="img-fluid img-responsive" src="{$nov_dir}modules/novlookbook/views/img/{$lookbook.image}" alt="lookbook" class="img-fluid"/>
						{if $lookbook.hotsposts}
							{foreach $lookbook.hotsposts item=hotspost name=hotspost key=k}
								<div class="item-lookbook" style="left:{$hotspost.left}%;top:{$hotspost.top}%">
									<span class="number-lookbook">{*{$k+1}*}+</span>
									{if $hotspost.sku}
										<div class="content-lookbook{if $hotspost.top > 50 } top{else} bottom{/if}" style="{$hotspost.style}">
											<div class="main-lookbook">
												<div class="item-thumb">
													<a href="{$hotspost.link}" alt="{$hotspost.link_rewrite}"><img src="{$hotspost.image}" alt="{$hotspost.link_rewrite}" class="img-fluid"/></a>
												</div>
												<div class="content-bottom">
													<div class="item-title">
														<a href="{$hotspost.link}" alt="{$hotspost.link_rewrite}">{$hotspost.name}</a>
													</div>
													<div class="item-price">
														{$hotspost.price}
													</div>
													{* <div class="readmore">
														<a href="{$hotspost.link}" alt="{$hotspost.link_rewrite}" >View More</a>
													</div> *}
												</div>
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
				</div>
			{/foreach}
			</div>
		</div>
	</div>
</div>
{/if}