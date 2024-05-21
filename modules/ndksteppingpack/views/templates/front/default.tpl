{*
 *  Tous droits réservés NDKDESIGN
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2016 Hendrik Masson
 *  @license   Tous droits réservés
*}
<script>
 var hiddenPrices = [];
</script>
{function jsaddHiddenPrices}
    {foreach $data as $item}
        {if not $item|@is_array}
            hiddenPrices.push('{$item}')
        {else}
            {jsaddHiddenPrices data = $item}
        {/if}
    {/foreach}
{/function}



{capture name=path}
     <a title="{l s='Compose your pack' mod='ndksteppingpack'}" href="#">{l s='Compose your pack' mod='ndksteppingpack'}</a>
		<span class="navigation-pipe">{$navigationPipe|escape:'html':'UTF-8'}</span>
        {$pack->name|escape:'html':'UTF-8'}
{/capture}

{************** Modif By Polykode *************}

{if $disablePack}

	<div class="alert alert-danger">
		<div style="padding-left: 30px;">
		
		{l s='Sorry this pack is out of stock for the moment '  mod='ndksteppingpack'}
		<br>
		{l s='Thanks'  mod='ndksteppingpack'}
		</div>
	</div>

{else}

{*********************************************}
<h1>
	{$pack->name|escape:'html':'UTF-8'}
	{if $pack->type == 1 && $pack->fixed_price > 0}
		{assign var=packPrice value=Product::getPriceStatic($pack->id_pack_prod)}
		 : <span class="big_price">{convertPrice price=$packPrice}</span>
	{/if}
</h1>
{if $pack->description}
<div class="description rte main_description">
	{$pack->description nofilter}
</div>
{/if}

{if $pack->fixed_price == 0}
<p class="discount">
	{l s='You save' mod='ndksteppingpack'}{if $pack->reduction_amount > 0}
		<span class="price">{convertPrice price=$pack->reduction_amount}</span>
	{else if $pack->reduction_percent > 0}
		<span class="reduction_percent">{$pack->reduction_percent}%</span>
	{/if}
</p>
{/if}
{*}{if isset($cart_rule)}
<div class="cart_rule_details">
	<h3>{$cart_rule->name|escape:'html':'UTF-8'}</h3>
	<p>{$cart_rule->description|escape:'html':'UTF-8'}</p>
	<p class="discount">
		{l s='A discount of'}{if $cart_rule->reduction_amount > 0}
			<span class="price">{convertPrice price=$cart_rule->reduction_amount}</span>
		{else if $cart_rule->reduction_percent > 0}
			<span class="reduction_percent">{$cart_rule->reduction_percent}%</span>
		{/if}
	</p>
</div>
{/if}{*}

<ul class="stepnav">
	{foreach from=$steps item=step name='steps'}
		<li id="stepNav_{$step.id|escape:'html':'UTF-8'}" class="stepnavButton button btn btn-default {if $smarty.foreach.steps.first} activeStep firstStep{/if} {if $smarty.foreach.steps.index > 0} disabled{/if}" {if $smarty.foreach.steps.index > 0} disabled="disabled"{/if} data-target="step_{$step.id|escape:'html':'UTF-8'}" data-id-step="{$step.id|escape:'html':'UTF-8'}"><span class="number">{$smarty.foreach.steps.iteration}.</span>{$step.name|escape:'html':'UTF-8'}</li>
		
			<li><i class="icon-chevron-right"></i></li>
	{/foreach}
	<li id="stepNav_order" class="">
		<a id="stepNav_999" disabled="disabled" class="btn btn-default button button-medium"	href="{$link->getPageLink("order", true)|escape:"html":"UTF-8"}" title="{l s='Proceed to checkout' mod='ndksteppingpack'}" rel="nofollow">
			<span>
				{l s='Proceed to checkout' mod='ndksteppingpack'}<i class="icon-chevron-right right"></i>
			</span>
		</a>
	</li>
	
</ul>
<div id="timeline">
	<h3 class="clear clearfix toggler">{l s='Your pack contain' mod='ndksteppingpack'} : <span id="counter_mark"></span></h3>
	<div id="resume_pack" class="clearfix row">
		{if $steps|@count > 5}
			{assign var='resumeCol' value='col-md-3 col-sm-6 col-xs-12 col-lg-2'}
		{elseif $steps|@count > 3}
			{assign var='resumeCol' value='col-md-3 col-sm-6 col-xs-12 col-lg-3'}
		{elseif $steps|@count > 1}
			{assign var='resumeCol' value='col-md-6 col-sm-6 col-xs-12 col-lg-6'}
		{elseif $steps|@count == 1}
			{assign var='resumeCol' value='col-md-12 col-sm-12 col-xs-12 col-lg-12'}
		{else}
			{assign var='resumeCol' value='col-md-3 col-sm-6 col-xs-12 col-lg-2'}
		{/if}
		{foreach from=$steps item=step name='steps'}
			<div class="resume-step {$resumeCol}" id="resume-step-{$step.id|escape:'html':'UTF-8'}"></div>
		{/foreach}
		<p>
			<a class="pull-right continue btn btn-default button exclusive-medium" id="removeAllFromPack"><span>{l s='Remove all products' mod='ndksteppingpack'}</span></a>
		</p>
		
	</div>
</div>
{foreach from=$steps item=step name='steps'}
	{math assign="nextindex" equation='x+y' x=$smarty.foreach.steps.index y=1}
	<div class="stepBlock" id="step_{$step.id|escape:'html':'UTF-8'}" data-min="{$step.minimum|escape:'html':'UTF-8'}" data-step="{$step.id|escape:'html':'UTF-8'}" {if $smarty.foreach.steps.index > 0} style="display:none;"{/if}>
	{if $step.description}
	<div class="step-description rte">
		{$step.description nofilter}
	</div>
	{/if}
	<div class="counter" id="counter_{$step.id|escape:'html':'UTF-8'}" data-min="{$step.minimum|escape:'html':'UTF-8'}" data-max="{$step.maximum|escape:'html':'UTF-8'}">
		<p>({l s='You have to add' mod='ndksteppingpack'} <span class="counterLeft">{$step.minimum|escape:'html':'UTF-8'}</span> {l s='more products in this step to continue' mod='ndksteppingpack'})</p>
	</div>
	<div class="packIsFull alert alert-danger">
		<h4>{l s='You reach the maximum products number in this step' mod='ndksteppingpack'}</h4>
		{if $smarty.foreach.steps.last}
		<a class="continue btn btn-default button exclusive-medium" onclick="simulateLinkFromPopup(999);"><span>{l s='Proceed to checkout' mod='ndksteppingpack'}</span></a>
		{else}
		<a class="continue btn btn-default button exclusive-medium" onclick="simulateLinkFromPopup({$steps[$nextindex].id});"><span>{l s='Go to the next step' mod='ndksteppingpack'}</span></a>
		{/if}
	</div>
	<div id="step_products_{$step.id|escape:'html':'UTF-8'}">
	{*include file="$tpl_dir./product-list.tpl" products = $step.products*}
	</div>
	</div>
	{if $step.show_price == 0}
		<script>
		    {jsaddHiddenPrices data=$step.id}
		</script>
	{/if}
{/foreach}
{************** Modif By Polykode *************}

{/if}

{*********************************************}

<script>
 var hiddenPrices = [];
 var page_name = '{$page_name}';
 var added = '{$added}';
 //var stepsLite = '{$stepsLite}';
 var idPack = '{$pack->id}';
 var showPopup = '{$show_modal_popup}';
</script>

{addJsDef added=$added}
{addJsDef stepsLite=$stepsLite}
{addJsDefL name=ajaxUrl}{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}modules/ndksteppingpack/ajaxCheckCart.php{/addJsDefL}
{addJsDefL name=ajaxUrlProducts}{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}modules/ndksteppingpack/ajax-getProducts.php{/addJsDefL}
{addJsDefL name=page_name}{$page_name}{/addJsDefL}

{addJsDef idPack=$pack->id}
{addJsDef base_url=$base_dir}
{addJsDefL name=continueText}{l s='Add another product' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=optionnalText}{l s='Add an optional product' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=nextText}{l s='Go to the next step' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=orderText}{l s='Proceed to checkout' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=WhatYouWant}{l s='What do you want to do now?' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=WhatYouCan}{l s='You have to continue in this step' mod='ndksteppingpack' js='1'}{/addJsDefL}
{addJsDefL name=orderLink}{$link->getPageLink("order", true)|escape:"html":"UTF-8"}{/addJsDefL}
{addJsDefL name=fullText}{l s='You reach the maximum products number in this step' mod='ndksteppingpack' js='1'}{/addJsDefL}

