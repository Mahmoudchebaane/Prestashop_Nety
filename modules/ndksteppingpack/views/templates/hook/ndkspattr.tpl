{*
 *  Tous droits réservés NDKDESIGN
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2016 Hendrik Masson
 *  @license   Tous droits réservés
*}
 
{if Context::getContext()->controller->php_self == 'module-ndksteppingpack-ajax-getProducts' || Context::getContext()->controller->php_self == 'pagenotfound' || Context::getContext()->controller->php_self == 'module-ndksteppingpack-default'}
<div class="ndk_att_list clear clearfix" data-key-product="">
{if $ndksp_combinations && $ndksp_combinations.values|@count > 0}
	<label class="ndk_attribute_label">{$ndksp_combinations.attribute_groups|escape:'html':'UTF-8'}&nbsp;</label>
	<select name="attribute_combination_{$id_product}" id="attribute_combination_{$id_product}" class=" ndk_attribute_select" ref="{$id_product}">
		{foreach from=$ndksp_combinations.values key=id_product_attribute item=combination}
		{if $combination.quantity > 0 || $allow_oosp == 1}
			<option data-price="{$combination.price}" data-display-price="{$combination.display_price|escape:'html':'UTF-8'}" value="{$id_product_attribute|intval}" {if $combination.default_on == 1 }selected="selected"{/if} title="{$combination.attributes_names|escape:'html':'UTF-8'}">{$combination.attributes_names|escape:'html':'UTF-8'} {if $combination.price}: {$combination.display_price|escape:'html':'UTF-8'}{/if}</option>
		{/if}
		{/foreach}
	</select>
{/if}
	<p class="clear clearfix ndk_quantity_wanted_p">
	<label class="ndk_attribute_label">{l s='Quantity : '  mod='ndksteppingpack'}&nbsp;</label>
	<input type="number" class="ndk_qtty_input " id="quantity_wanted_{$id_product}" min="1" size="3" value="1" ref="{$id_product}"/>
	<span class="quantity-ndk-minus btn-default btn"><i class="icon-minus"></i></span>
				<span class="quantity-ndk-plus btn-default btn"><i class="icon-plus"></i></span>
	</p>
</div>
{/if}
