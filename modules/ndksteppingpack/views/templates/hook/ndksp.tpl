{*
 *  Tous droits réservés NDKDESIGN
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2016 Hendrik Masson
 *  @license   Tous droits réservés
*}
{if $exists_in_pack && !$content_only}
	<div class="block pack_button_block" id="exists_in_pack">
		<p class="notice">{l s='This product is available in pack, you can save money ordering it with other products.' mod='ndksteppingpack'}</p>
		<a href="{$packs_url}" class="btn btn-default"><i class="icon icon-puzzle"></i>{l s='view packs for this product' mod='ndksteppingpack'}</a>
	</div>
{/if}

{if $related_packs|@count > 0 && !$content_only}
	<div class="block pack_button_block" id="exists_in_related_pack">
		<a href="{$related_packs_url}" class="btn btn-default"><i class="icon icon-puzzle"></i>{l s='view related packs' mod='ndksteppingpack'}</a>
	</div>
{/if}