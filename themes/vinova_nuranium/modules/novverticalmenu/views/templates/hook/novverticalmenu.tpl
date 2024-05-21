<div class="verticalmenu-content{if $novconfig.novthemeconfig_enable_showmore_vertical == '1'} has-showmore{/if}"
	data-textshowmore="{l s='Show More' mod='verticalmenu'}" data-textless="{l s='Hide' mod='verticalmenu'}">
	<div id="_desktop_verticalmenu" class="nov-verticalmenu block"
		{if isset($novconfig.novthemeconfig_count_showmore_vertical) && $novconfig.novthemeconfig_count_showmore_vertical}
		data-count_showmore="{$novconfig.novthemeconfig_count_showmore_vertical}" {/if}
		data-count_showmore_lg="{$novconfig.novthemeconfig_count_showmore_vertical_lg}">
		<div class="box-content block_content">
			<div id="verticalmenu" class="verticalmenu" role="navigation">
				<div class='verticalMenuTop'>
					<div
						class="title_vertical mb-20 font-size-20 toggle-vertical{if $novconfig.novthemeconfig_header_style == 'style-3' || $novconfig.novthemeconfig_header_style == 'style-7' || $novconfig.novthemeconfig_header_style == 'style-8' || $novconfig.novthemeconfig_header_style == 'style-20' || $novconfig.novthemeconfig_header_style == 'style-24' && $page.page_name == 'index'} act{/if}">
						<i class="zmdi zmdi-format-align-left"></i>
						<span>{l s='Menu' d='Shop.Theme.Action'}</span>
					</div>
					{assign var=context value=Context::getContext()}
					{if $context->shop->id == NETY_SHOP																			 }
						{hook h='displayMyAccountBlock'}
					{/if}
				</div>
				{$mgmenu nofilter}			
			</div>
		</div>
	</div>
</div>