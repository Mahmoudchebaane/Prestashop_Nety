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
{extends 'customer/page.tpl'}

{block name='page_title'}
	{l s='My informations' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
	{* <div class="page_title_account">{l s='Your account' d='Shop.Theme.Customeraccount'}</div> *}
	{* <div class="row userAccount">  *}
	{render file='customer/_partials/form-profil.tpl' ui=$customer_form}  
	
		{* <div class="col">  
			<div class="block_content-right">				
				{include file="customer/_partials/top-page.tpl"}
 				  {render file='customer/_partials/form-profil.tpl' ui=$customer_form}  
			</div>
		 </div>
	  <div class="col-md-4 col-sm-3">
			  {include file="customer/_partials/list-link-account.tpl"} 
		</div>  *}
	{* </div> *}
	{block name='hook_before_body_closing_tag'} 	
		<script>
		var passLink="{l s='Password' d='Shop.Theme.Customeraccount'}"
		</script>	 
		<style>
		input[name="firstname"], 
		input[name="lastname"],
		input[name="ref_client"],
		input[name="ref_abonnement"],
		input[name="num_fixe"]{
			pointer-events: none;
			background-color: #e9e9e9;
		}
		.novform-psgdpr  label.required:after {
			content: '';
		}
		.form-control-comment{
			display: none;
		}
		.novform-psgdpr  label.required:after {
			content: '';
		}
		.form-control-comment{
			display: none;
		}
		</style>
	{/block}
{/block}
{block name='page_footer'}
	{block name='my_account_links'}
	{/block}
{/block}