{*
* 2007-2017 PrestaShop
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
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{block name='social_sharing'}
  {if $social_share_links}
  <div class="dropdown social-sharing">
    <button class="btn btn-link" type="button" id="social-sharingButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span><i class="fa fa-share-alt" aria-hidden="true"></i>{l s='Share' d='Shop.Theme.Actions'}</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="social-sharingButton">
      {foreach from=$social_share_links item='social_share_link'}
        {if $social_share_link.class == 'googleplus'}
          <a class="dropdown-item" href="{$social_share_link.url}" title="{$social_share_link.label}" target="_blank"><i class="fa fa-google-plus"></i>{$social_share_link.label}</a>
        {elseif $social_share_link.class == 'facebook'}
          <a class="dropdown-item" href="{$social_share_link.url}" title="{$social_share_link.label}" target="_blank"><i class="fa fa-{$social_share_link.class}"></i>{l s='Facebook' d='Shop.Theme.Actions'}</a>
        {else}
          <a class="dropdown-item" href="{$social_share_link.url}" title="{$social_share_link.label}" target="_blank"><i class="fa fa-{$social_share_link.class}"></i>{$social_share_link.label}</a>
        {/if}
      {/foreach}
    </div>
  </div>
  {/if}
{/block}
