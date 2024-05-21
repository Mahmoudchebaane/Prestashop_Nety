{extends file="helpers/form/form.tpl"}

{block name='defaultForm'}
	<div class="themeconfig-heading">
		<span class="module-name">Themes configurator</span>
	</div>
	<div class="row-flex no-gutters">
		<div class="nov-config-tabs">
			<ul id="nov-config-tabs">
		        {foreach $sptabs as $tabTitle => $tabClass}
	            <li class="tab" data-tab="{$tabClass}">
	                {$tabTitle}
	            </li>
		        {/foreach}
		    </ul>
		</div>
	    <div class="nov-config-contents">
    		{$smarty.block.parent}
	    </div>
	</div>
{/block}

{block name="legend"}
{/block}

{block name="label"}
	{if isset($input.label)}
		<label class="control-label col-lg-2{if isset($input.required) && $input.required && $input.type != 'radio'} required{/if}">
			{if isset($input.hint)}
			<span class="label-tooltip"
				data-toggle="tooltip"
				data-html="true"
				title="
					{if is_array($input.hint)}
						{foreach $input.hint as $hint}
							{if is_array($hint)}
								{$hint.text|escape:'html':'UTF-8'}
							{else}
								{$hint|escape:'html':'UTF-8'}
							{/if}
						{/foreach}
					{else}
						{$input.hint|escape:'html':'UTF-8'}
					{/if}
				"
				>
			{/if}
			{$input.label}
			{if isset($input.hint)}
			</span>
			{/if}
		</label>
	{/if}
{/block}

{block name="input"}
	{if $input.type == 'color'}
		<div class="input-group input-large">
			<input type="color"
			data-hex="true"
			{if isset($input.class)} class="{$input.class}"
			{else} class="color mColorPickerInput"{/if}
			name="{$input.name}"
			value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" />
		</div>
		{elseif $input.type == 'textarea'}
		{assign var=use_textarea_autosize value=true}
		{if isset($input.lang) AND $input.lang}
			{foreach $languages as $language}
				{if $languages|count > 1}
				<div class="form-group translatable-field lang-{$language.id_lang}"{if $language.id_lang != $defaultFormLanguage} style="display:none;"{/if}>
					<div class="col-lg-11">
				{/if}
						{if isset($input.maxchar) && $input.maxchar}
						<div class="input-group">
							<span id="{if isset($input.id)}{$input.id}_{$language.id_lang}{else}{$input.name}_{$language.id_lang}{/if}_counter" class="input-group-addon">
								<span class="text-count-down">{$input.maxchar|intval}</span>
							</span>
						{/if}
						<textarea{if isset($input.readonly) && $input.readonly} readonly="readonly"{/if} name="{$input.name}_{$language.id_lang}" id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}_{$language.id_lang}" class="{if isset($input.autoload_rte) && $input.autoload_rte}rte autoload_rte{else}textarea-autosize{/if}{if isset($input.class)} {$input.class}{/if}"{if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}{if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}>{$fields_value[$input.name][$language.id_lang]|escape:'html':'UTF-8'}</textarea>
						{if isset($input.maxchar) && $input.maxchar}
						</div>
						{/if}
				{if $languages|count > 1}
					</div>
					<div class="col-lg-1">
						<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
							{$language.iso_code}
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							{foreach from=$languages item=language}
							<li>
								<a href="javascript:hideOtherLanguage({$language.id_lang});" tabindex="-1">{$language.name}</a>
							</li>
							{/foreach}
						</ul>
					</div>
				</div>
				{/if}
			{/foreach}
			{if isset($input.maxchar) && $input.maxchar}
				<script type="text/javascript">
				$(document).ready(function(){
				{foreach from=$languages item=language}
					countDown($("#{if isset($input.id)}{$input.id}_{$language.id_lang}{else}{$input.name}_{$language.id_lang}{/if}"), $("#{if isset($input.id)}{$input.id}_{$language.id_lang}{else}{$input.name}_{$language.id_lang}{/if}_counter"));
				{/foreach}
				});
				</script>
			{/if}
		{else}
			{if isset($input.maxchar) && $input.maxchar}
				<span id="{if isset($input.id)}{$input.id}_{$language.id_lang}{else}{$input.name}_{$language.id_lang}{/if}_counter" class="input-group-addon">
					<span class="text-count-down">{$input.maxchar|intval}</span>
				</span>
			{/if}
			<textarea{if isset($input.readonly) && $input.readonly} readonly="readonly"{/if} name="{$input.name}" id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}" {if isset($input.cols)}cols="{$input.cols}"{/if} {if isset($input.rows)}rows="{$input.rows}"{/if} class="{if isset($input.autoload_rte) && $input.autoload_rte}rte autoload_rte{else}textarea-autosize{/if}{if isset($input.class)} {$input.class}{/if}"{if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}{if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}>{$fields_value[$input.name]|escape:'html':'UTF-8'}</textarea>
			{if isset($input.maxchar) && $input.maxchar}
				<script type="text/javascript">
				$(document).ready(function(){
					countDown($("#{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"), $("#{if isset($input.id)}{$input.id}{else}{$input.name}{/if}_counter"));
				});
				</script>
			{/if}
		{/if}
	{elseif $input.type == 'switch'}
		<span class="switch prestashop-switch fixed-width-lg">
			{foreach $input.values as $value}
			<input type="radio" name="{$input.name}"{if $value.value == 1} id="{$input.name}_on"{else} id="{$input.name}_off"{/if} value="{$value.value}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if (isset($input.disabled) && $input.disabled) or (isset($value.disabled) && $value.disabled)} disabled="disabled"{/if}/>
			{strip}
			<label {if $value.value == 1} for="{$input.name}_on"{else} for="{$input.name}_off"{/if}>
				{if $value.value == 1}
					{l s='Yes' d='Admin.Global'}
				{else}
					{l s='No' d='Admin.Global'}
				{/if}
			</label>
			{/strip}
			{/foreach}
			<a class="slide-button btn"></a>
		</span>
    {elseif $input.name == 'novthemeconfig_payment_image'}
		{$smarty.block.parent}
        {if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
            <div class="remove-image-content">
	            <a href="{$current}&{$identifier}={$form_id}&token={$token}&deleteConfig={$input.name}">
	                <i class="icon-trash-o"></i>{l s='Delete' mod='novthemeconfig'}
	            </a>
	            <small>{l s='Do not forget to save the options after deleted the image!' mod='novthemeconfig'}</small>
	        </div>
            <div class="image-content">
            	<img class="img-responsive" src="{$imagePath}{$fields_value[$input.name]}"/>
        	</div>
        {/if}
	{elseif $input.name == 'novthemeconfig_logo_mobile'}
		{$smarty.block.parent}
        {if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
            <div class="remove-image-content">
	            <a href="{$current}&{$identifier}={$form_id}&token={$token}&deleteConfig={$input.name}">
	                <i class="icon-trash-o"></i>{l s='Delete' mod='novthemeconfig'}
	            </a>
	            <small>{l s='Do not forget to save the options after deleted the image!' mod='novthemeconfig'}</small>
	        </div>
            <div class="image-content">
            	<img class="img-responsive" src="{$imagePath}{$fields_value[$input.name]}"/>
        	</div>
        {/if}
	{elseif $input.name == 'novthemeconfig_logo_footer'}
		{$smarty.block.parent}
        {if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
            <div class="remove-image-content">
	            <a href="{$current}&{$identifier}={$form_id}&token={$token}&deleteConfig={$input.name}">
	                <i class="icon-trash-o"></i>{l s='Delete' mod='novthemeconfig'}
	            </a>
	            <small>{l s='Do not forget to save the options after deleted the image!' mod='novthemeconfig'}</small>
	        </div>
            <div class="image-content">
            	<img class="img-responsive" src="{$imagePath}{$fields_value[$input.name]}"/>
        	</div>
        {/if}
	{elseif $input.name == 'novthemeconfig_body_bg_image'}
		{if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
            <div class="remove-image-content">
	            <a href="{$current}&{$identifier}={$form_id}&token={$token}&deleteConfig={$input.name}">
	                <i class="icon-trash-o"></i>{l s='Delete' mod='novthemeconfig'}
	            </a>
	            <small>{l s='Do not forget to save the options after deleted the image!' mod='novthemeconfig'}</small>
            </div>
            <div class="image-content">
            	<img class="img-responsive" src="{$imagePath}{$fields_value[$input.name]}"/>
        	</div>
        {/if}
		{$smarty.block.parent}
	{elseif $input.name == 'novpopup_loading_image'}
		{$smarty.block.parent}
		{if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
            <div class="remove-image-content">
	            <a href="{$current}&{$identifier}={$form_id}&token={$token}&deleteConfig={$input.name}">
	                <i class="icon-trash-o"></i>{l s='Delete' mod='novthemeconfig'}
	            </a>
	            <small>{l s='Do not forget to save the options after deleted the image!' mod='novthemeconfig'}</small>
        	</div>
            <div class="image-content">
            	<img class="img-responsive" src="{$imagePath}{$fields_value[$input.name]}"/>
        	</div>
        {/if}
	{elseif $input.name == 'novpopup_newsletter_bg'}
		{$smarty.block.parent}
	 	{if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
	 		<div class="remove-image-content">
	            <a href="{$current}&{$identifier}={$form_id}&token={$token}&deleteConfig={$input.name}">
	                <i class="icon-trash-o"></i>{l s='Delete' mod='novthemeconfig'}
	            </a>
	            <small>{l s='Do not forget to save the options after deleted the image!' mod='novthemeconfig'}</small>
        	</div>
            <div class="image-content">
            	<img class="img-responsive" src="{$imagePath}{$fields_value[$input.name]}"/>
        	</div>
        {/if}
	{elseif $input.name == 'nov_clearcss'}
		<div class="alert alert-warning">
			<button id="nov_clearcss" class="btn btn-success" type="button">
				<i class="icon-eraser"></i>{l s='Clear CSS' mod='novthemeconfig'}
			</button>
		  	<span style="margin:0 10px;">{l s='Delete all of the theme css file and regenerate from sass.' mod='novthemeconfig'}</span>
		</div>
		<script>
			function objToString(obj) {
				var str = '';
				for (var p in obj) {
					if (obj.hasOwnProperty(p)) {
						str += '&' + p + '=' + obj[p];
					}
				}
				return str;
			}
			$('#nov_clearcss').on('click', function(){
				var that = $(this);
				that.attr('class', 'btn btn-warning disabled');
				that.find('i').attr('class', 'icon-spinner icon-spin');
				var params = {
					action : 'clearCss',
					ajax : 1
				};
				var query = $.ajax({
					type: 'POST',
					url: '{$controller_url}',
					data: objToString(params),
					dataType: 'json',
					success: function(data) {
						if(data.success){
							that.attr('class', 'btn btn-success disabled');
							that.find('i').attr('class', 'icon-eraser');
						} else {
							that.attr('class', 'btn btn-danger');
							that.find('i').attr('class', 'icon-frown');
						}
					}
				});
			});
		</script>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name="footer"}
	{capture name='form_submit_btn'}{counter name='form_submit_btn'}{/capture}
	{if isset($fieldset['form']['submit']) || isset($fieldset['form']['buttons'])}
		<div class="panel-footer">
			{if isset($fieldset['form']['submit']) && !empty($fieldset['form']['submit'])}
			<button type="submit" value="1"	id="{if isset($fieldset['form']['submit']['id'])}{$fieldset['form']['submit']['id']}{else}{$table}_form_submit_btn{/if}{if $smarty.capture.form_submit_btn > 1}_{($smarty.capture.form_submit_btn - 1)|intval}{/if}" name="{if isset($fieldset['form']['submit']['name'])}{$fieldset['form']['submit']['name']}{else}{$submit_action}{/if}{if isset($fieldset['form']['submit']['stay']) && $fieldset['form']['submit']['stay']}AndStay{/if}" class="{if isset($fieldset['form']['submit']['class'])}{$fieldset['form']['submit']['class']}{else}btn btn-default pull-right{/if}">
				<i class="{if isset($fieldset['form']['submit']['icon'])}{$fieldset['form']['submit']['icon']}{else}process-icon-save{/if}"></i><span>{$fieldset['form']['submit']['title']}</span>
			</button>
			{/if}
			{if isset($show_cancel_button) && $show_cancel_button}
			<a href="{$back_url|escape:'html':'UTF-8'}" class="btn btn-default" onclick="window.history.back();">
				<i class="process-icon-cancel"></i> {l s='Cancel' d='Admin.Actions'}
			</a>
			{/if}
			{if isset($fieldset['form']['reset'])}
			<button
				type="reset"
				id="{if isset($fieldset['form']['reset']['id'])}{$fieldset['form']['reset']['id']}{else}{$table}_form_reset_btn{/if}"
				class="{if isset($fieldset['form']['reset']['class'])}{$fieldset['form']['reset']['class']}{else}btn btn-default{/if}"
				>
				{if isset($fieldset['form']['reset']['icon'])}<i class="{$fieldset['form']['reset']['icon']}"></i> {/if} {$fieldset['form']['reset']['title']}
			</button>
			{/if}
			{if isset($fieldset['form']['buttons'])}
			{foreach from=$fieldset['form']['buttons'] item=btn key=k}
				{if isset($btn.href) && trim($btn.href) != ''}
					<a href="{$btn.href}" {if isset($btn.target) && $btn.target=='_blank'}target="_blank"{/if} {if isset($btn['id'])}id="{$btn['id']}"{/if} class="{if isset($btn['class'])} {$btn['class']}{/if}" {if isset($btn.js) && $btn.js} onclick="{$btn.js}"{/if}>{if isset($btn['icon'])}<i class="material-icons {$btn['icon']}" >{$btn['icon']}</i> {/if}{$btn.title}</a>
				{else}
					<button type="{if isset($btn['type'])}{$btn['type']}{else}button{/if}" {if isset($btn['id'])}id="{$btn['id']}"{/if} class="{if isset($btn['class'])} {$btn['class']}{/if}" name="{if isset($btn['name'])}{$btn['name']}{else}submitOptions{$table}{/if}"{if isset($btn.js) && $btn.js} onclick="{$btn.js}"{/if}>{if isset($btn['icon'])}<i class="material-icons {$btn['icon']}" >{$btn['icon']}</i>{/if}<span>{$btn.title}</span></button>
				{/if}
			{/foreach}
			{/if}
		</div>
	{/if}
{/block}