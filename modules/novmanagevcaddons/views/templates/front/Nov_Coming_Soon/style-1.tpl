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

<div class="nov-coming-soon position-relative text-center style-1">
	<div class="logo">{$img nofilter}</div>
	<div class="block_content d-flex align-items-center">
		<div class="w-100">
			<div class="title_block">{$title_1}</div>
			<div class="des">{$description}</div>
			<div class="comingsoon d-flex justify-content-center position-static"
			data-date="{$date|date_format:'%Y/%m/%d'}"
			data-days="{l s='Days' d='Shop.Theme.Comingsoon'}"
			data-hours="{l s='Hours' d='Shop.Theme.Comingsoon'}"
			data-min="{l s='Minutes' d='Shop.Theme.Comingsoon'}"
			data-seconds="{l s='Seconds' d='Shop.Theme.Comingsoon'}"
			></div>
			<div class="title">{$title_2}</div>
			{if isset($nov_emailsubscription) && $nov_emailsubscription}
			<div class="block_newsletter">
				<form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post">
				    {if $nov_emailsubscription.msg}
				      <p class="alert {if $nov_emailsubscription.nw_error}alert-danger{else}alert-success{/if}">
				        {$nov_emailsubscription.msg}
				      </p>
				    {/if}
				    <div class="input-group">
				      <input type="text" class="form-control" name="email" value="{$nov_emailsubscription.value}" placeholder="{l s='ENTER YOUR EMAIL' d='Shop.Forms.Labels'}...">
				      <span class="input-group-btn">
				        <button class="btn" name="submitNewsletter" type="submit">{l s='Subscribe' d='Shop.Theme.Actions'}</button>
				      </span>
				    </div>
				    <input type="hidden" name="action" value="0">
			  	</form>
			</div>
		  	{/if}
		  		
			  	<div class="social list-social nov-socials">
			  		<ul class="list-unstyled mb-0 p-0">
			  			{foreach from=$novconfigtheme item=novconfig}
			  			{if $novconfig.name == 'novthemeconfig_social_facebook' && !empty($novconfig.value)}
			  			<li class="social_facebook"><a href="{$novconfig.value}" target="_blank"><span>Facebook</span><i class="fa fa-facebook"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_twitter' && !empty($novconfig.value)}
			  			<li class="social_twitter"><a href="{$novconfig.value}" target="_blank"><span>Twitter</span><i class="fa fa-twitter"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_youtube' && !empty($novconfig.value)}
			  			<li class="social_youtube"><a href="{$novconfig.value}" target="_blank"><span>Youtube</span><i class="fa fa-youtube-play"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_google' && !empty($novconfig.value)}
			  			<li class="social_google"><a href="{$novconfig.value}" target="_blank"><span>Google</span><i class="fa fa-google-plus"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_dribbble' && !empty($novconfig.value)}
			  			<li class="social_dribbble"><a href="{$novconfig.value}" target="_blank"><span>Dribbble</span><i class="fa fa-dribbble"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_instagram' && !empty($novconfig.value)}
			  			<li class="social_instagram"><a href="{$novconfig.value}" target="_blank"><span>Instagram</span><i class="fa fa-instagram"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_flickr' && !empty($novconfig.value)}
			  			<li class="social_flickr"><a href="{$novconfig.value}" target="_blank"><span>Flickr</span><i class="fa fa-flickr"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_pinterest' && !empty($novconfig.value)}
			  			<li class="social_pinterest"><a href="{$novconfig.value}" target="_blank"><span>Pinterest</span><i class="fa fa-pinterest"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_linkedIn' && !empty($novconfig.value)}
			  			<li class="social_linkedin"><a href="{$novconfig.value}" target="_blank"><span>Linkedin</span><i class="fa fa-linkedin"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_skype' && !empty($novconfig.value)}
			  			<li class="social_skype"><a href="{$novconfig.value}" target="_blank"><span>Skype</span><i class="fa fa-skype"></i></a></li>
			  			{/if}
			  			{if $novconfig.name == 'novthemeconfig_social_vimeo' && !empty($novconfig.value)}
			  			<li class="social_vimeo"><a href="{$novconfig.value}" target="_blank"><span>Vimeo</span><i class="fa fa-vimeo"></i></a></li>
			  			{/if}
			  			{/foreach}
			  		</ul>
			  	</div>
		</div>
	</div>
</div>