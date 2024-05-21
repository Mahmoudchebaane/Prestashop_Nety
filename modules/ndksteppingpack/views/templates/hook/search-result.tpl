{*
 *  Tous droits réservés NDKDESIGN
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2016 Hendrik Masson
 *  @license   Tous droits réservés
*}
{if $ps_version > 1.6}
	{assign var="base_dir_ssl" value=$base_url}
	{assign var="base_dir" value=$base_url}
	{addJsDefL name=baseUri}{if isset($is_https) && $is_https}{$base_dir_ssl}{else}{$base_dir}{/if}{/addJsDefL}
{/if}

{if $packs|@count > 0}
<div class="pack-list clear clearfix row">
	<div class="col-xs-12">
	<h2>{l s='Pack results'  mod='ndksteppingpack'}</h2>
	</div>
<ul class="clear clearfix row">
	{foreach from=$packs item="pack"}
		<li class="pack-item col-md-4 col-sm-6 span3">
			<div class="block-container">
				<div class="image-block">
					<a href="{$pack.link|escape:'htmlall':'UTF-8'}"><img class="img-responsive" src="{$base_url}/img/scenes/ndksp/thumbs/{$pack.id_ndksteppingpack|escape:'htmlall':'UTF-8'}-home_default.jpg"/></a>
				</div>
				<div class="pack-infos-block">
					<h3 class="pack_name">{$pack.name|escape:'html':'UTF-8'}</h3>
					<p class="pack_desc clearfix">{$pack.short_description|strip_tags:false|escape:'htmlall':'UTF-8'}</p>
					<p class="price clearfix">
						{if $pack.fixed_price > 0}{convertPrice price=$pack.fixed_price}{/if}
						{if $pack.cart_rule && ( $pack.reduction_amount > 0 || $pack.reduction_percent > 0)}
							{l s='A discount of' mod='ndksteppingpack'}{if $pack.reduction_amount > 0}
								<span class="price">{convertPrice price=$pack.reduction_amount}</span>
							{else if $pack.reduction_percent > 0}
								<span class="reduction_percent">{$pack.reduction_percent|escape:'htmlall':'UTF-8'}%</span>
							{/if}
						{/if}
					</p>
					<a  href="{$pack.link|escape:'htmlall':'UTF-8'}" class="btn btn-default button exclusive-medium" ><span>{l s='Compose your pack' mod='ndksteppingpack'}</span></a>
				</div>
			</div>
		</li>
	{/foreach}
</ul>
</div>
{/if}