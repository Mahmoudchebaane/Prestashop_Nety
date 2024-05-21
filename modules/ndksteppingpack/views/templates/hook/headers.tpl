{*
 *  Tous droits réservés NDKDESIGN
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
*}
{if $ps_version > 1.6}
	{assign var="base_dir_ssl" value=$urls.base_url}
	{assign var="base_dir" value=$urls.base_url}
	{assign var="page_name" value=$page.page_name}
	{addJsDefL name=baseUri}{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}{/addJsDefL}
{/if}

{addJsDefL name=page_name}{$page_name}{/addJsDefL}
{addJsDefL name=ps_version}{$ps_version}{/addJsDefL}
{if Context::getContext()->controller->php_self == 'category'}
{addJsDefL name=id_category}{Tools::getValue('id_category')}{/addJsDefL}
{/if}
{addJsDefL name=show_packs_category}{$show_packs_category}{/addJsDefL}      

<script>
 var hiddenPrices = [];
 var page_name = '{$page_name}';
 var id_category = "{Tools::getValue('id_category')}";
 var show_packs_category = '{$show_packs_category}';
</script>



{addJsDefL name=ajaxUrl}{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}modules/ndksteppingpack/ajaxCheckCart.php{/addJsDefL}
{addJsDefL name=ajaxUrlProducts}{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}modules/ndksteppingpack/ajax-getProducts.php{/addJsDefL}
{addJsDefL name=page_name}{$page_name}{/addJsDefL}


{addJsDef base_url=$base_dir}
{addJsDefL name=continueText}{l s='Add another product' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=optionnalText}{l s='Add an optional product' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=nextText}{l s='Go to the next step' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=orderText}{l s='Proceed to checkout' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=WhatYouWant}{l s='What do you want to do now?' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=WhatYouCan}{l s='You have to continue in this step' mod='ndksteppingpack' js='1'}{/addJsDefL}
{if $ps_version > 1.6}
{addJsDefL name=orderLink}{$cart_url|escape:"html":"UTF-8"}{/addJsDefL}
{else}
{addJsDefL name=orderLink}{$link->getPageLink("order", true)|escape:"html":"UTF-8"}{/addJsDefL}
{/if}
{addJsDefL name=fullText}{l s='You reach the maximum products number in this step' mod='ndksteppingpack' js='1'}{/addJsDefL}
