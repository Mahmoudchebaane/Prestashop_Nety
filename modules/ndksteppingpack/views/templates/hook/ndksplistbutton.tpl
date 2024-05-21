{*
 *  Tous droits réservés NDKDESIGN
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2016 Hendrik Masson
 *  @license   Tous droits réservés
*}

{if $exists_in_pack && Context::getContext()->controller->php_self !=  'module-ndksteppingpack-ajax-getProducts'}
	<div class="ndksplistbutton-container clearfix clear" >
		<a href="{$packs_url}" class="ndksplistbutton"  title="{l s='This product is available in pack, you can save money ordering it with other products.' mod='ndksteppingpack'} "><i class="icon icon-puzzle"></i>{l s='view packs for this product' mod='ndksteppingpack'}</a>
	</div>
{/if}