{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div id="gear-right" class="hidden-xs">
	<i class="fa fa-cogs icon-2x icon-light"></i>
</div>
<form action="#" method="post" class="hidden-xs">
	<div id="tool_customization">
		<h3 class="header-theme">
			{l s='Theme Configs.' mod='novthemeconfig'}
		</h3>
		<div class="list-tools">
			<div class="tab-paneltool">
				<ul class="nav nav-tabs clearfix">
					<li class="active"><a data-toggle="tab" href="#skin">{l s='Skin' mod='novthemeconfig'}</a></li>
					<li><a data-toggle="tab" href="#layouts">{l s='Layout style' mod='novthemeconfig'}</a></li>
				</ul>
				<div class="tab-content clearfix">
					<div id="skin" class="tab-pane active">
						{if isset($skin_base)}
							<h5 id="skin-title">
								{l s='Skin' mod='novthemeconfig'} 
							</h5>
							<div class="nov-skin clearfix">
								<select name="novthemeconfig_skin">
									<option value="default">default</option>	
									{foreach $skin_base as $skin}
										<option value="{$skin}" {if $novthemeconfig_skin && $novthemeconfig_skin == $skin}selected="selected"{/if}>{$skin}</option>	
									{/foreach}
								</select>
							</div>
							<span class="desc">{l s='Select Theme Skin' mod='novthemeconfig'}</span>
						{/if}
						{if isset($images)}
							<h5 id="background-title">
								{l s='Background' mod='novthemeconfig'} 
							</h5>
							<div class="nov-background clearfix">
								{foreach $images as $image}
									<div style="background:url('{$url}{$image}') no-repeat center center;" class="pull-left {if $novthemeconfig_image && $novthemeconfig_image == $image}active{/if}" data-background="{$url}{$image}" data-image="{$image}">

									</div>
								{/foreach}
								<input type="hidden" value="{if $novthemeconfig_image}{$novthemeconfig_image}{/if}" data-image="{if $novthemeconfig_image}{$url}{$novthemeconfig_image}{/if}" name="novthemeconfig_image" class="nov-image"/>	
							</div>
								<span class="desc">{l s='Select background for body' mod='novthemeconfig'}</span>
						{/if}
					</div>
					<div id="layouts" class="tab-pane">
						{if isset($layouts) && $layouts}
							{foreach $layouts  as $layout}
								{if $layout}
									<h5 id="{$layout.name}-title">{$layout.title}</h5>
									<div class="nov-{$layout.name} clearfix">
										<select name="{$layout.name}">	
											{foreach $layout.option as $item}
												<option value="{$item.value}" {if isset($d_layout) && $d_layout[$layout.name] && $d_layout[$layout.name] == $item.value}selected="selected"{/if}>{$item.title}</option>	
											{/foreach}
										</select>
									</div>
									<span class="desc">{l s='Select Layout' mod='novthemeconfig'} {$layout.title}</span>
								{/if}
							{/foreach}
						{/if}						
					</div>
				</div>
			</div>
		</div>
		<div class="btn-tools clearfix">
			<button type="submit" class="btn btn-1"  name="resetNovConfigurator">{l s='Reset' mod='novthemeconfig'}</button>
			<button type="submit" class="btn btn-2" name="submitNovConfigurator">{l s='Save' mod='novthemeconfig'}</button>
		</div>
	</div>
</form>
