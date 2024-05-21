{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

	{if $node.children|count > 0}
		{foreach from=$node.children item=child name=categoryTreeBranch}
			<li class="dropdown-item" data-value="{$child.id}" {if isset($id_category) && $id_category == $child.id}selected{/if}>
				<span>{for $foo=1 to $lever}-{/for} {$child.name}</span>
				{if $child.children|count > 0}
				<ul class="list-unstyled">
					{include file="./category-tree-branch.tpl" node=$child lever=$lever+1}
				</ul>
				{/if}
			</li>
		{/foreach}
	{/if}