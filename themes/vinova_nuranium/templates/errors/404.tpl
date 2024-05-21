{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{extends file='page.tpl'}

{block name='page_title'}
	<div class="hidden-xs-up">
  		{$page.title}
  	</div>
{/block}

{block name='header'}{/block}

{block name='breadcrumb'}
{/block}

{block name='page_content_container'}
  	{if $novconfig.novthemeconfig_404_style == 'style_dark'}
  		<section id="content" class="page-content page-not-found style_dark d-flex align-items-center justify-content-center">
  			<div class="text-center">
				<div class="image">
					<img class="img-fluid" src="{$img_dir}img-404-1.png" alt="Image 404" />
				</div>
				<h2 class="text-uppercase">{l s='Page Not found' d='Shop.Theme.Errors'}</h2>
				<h4>{l s='We’re sorry — something has gone wrong on our end.' d='Shop.Theme.Errors'}</h4>
				<p class="info">{l s='If difficulties persist, please contact the System Administrator of this site and report the error below...' d='Shop.Theme.Errors'}</p>
				<a class="btn btn-default" href="{$urls.base_url}">
					<i class="fa fa-home"></i><span>{l s='Back to homepage' d='Shop.Theme.Errors'}</span>
				</a>
				{hook h='displayNotFound'}
			</div>
		</section>
	{else}
  		<section id="content" class="page-content page-not-found style_light d-flex align-items-center justify-content-center">
  			<div class="text-center">
				<div class="image">
					<img class="img-fluid" src="{$img_dir}img-404-2.png" alt="Image 404" />
				</div>
				<h1 class="text-uppercase">{l s='404' d='Shop.Theme.Errors'}</h1>
				<h2 class="text-uppercase">{l s='Page Not Found' d='Shop.Theme.Errors'}</hw>
				<h4>{l s='We’re sorry — something has gone wrong on our end.' d='Shop.Theme.Errors'}</h4>
				<p class="info">{l s='If difficulties persist, please contact the System Administrator of this site and report the error below...' d='Shop.Theme.Errors'}</p>
				<a class="btn btn-default" href="{$urls.base_url}">
					<i class="fa fa-home"></i><span>{l s='Back to homepage' d='Shop.Theme.Errors'}</span>
				</a>
				{hook h='displayNotFound'}
			</div>
		</section>
  	{/if}
{/block}

{block name="footer"}{/block}