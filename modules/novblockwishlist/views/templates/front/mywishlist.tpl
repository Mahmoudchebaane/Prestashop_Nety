{*
/******************

 * Vinova Themes  Framework for Prestashop 1.7.x
 * @package   	novblockwishlist
 * @version   	1.0
 * @author   	http://vinovathemes.com/
 * @copyright 	Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1

 * *****************/
*}
{extends file='page.tpl'}
{block name="page_content"}
	<div class="page_title_account">{l s='Your account' d='Shop.Theme.Customeraccount'}</div>
	<div class="row">
	    <div class="col-md-3">
	      {include file="customer/_partials/list-link-account.tpl"}
	    </div>
	    <div class="col-md-9 mt-xs-30">
	    	<div class="block_content-right">
	    		<div class="title_account_second d-flex">{l s='Wishlist' d='Shop.Theme.Customeraccount'}</div>
	    		<div id="mywishlist">
	    			{if $id_customer|intval neq 0}
	    				{if $products}
							<div class="wlp_bought">
								<div class="row wlp_bought_list no-flow">
								{foreach from=$products item=product name=i}
								<div id="wlp_{$product.id_product}_{$product.id_product_attribute}" class="col-md-3 col-sm-4 col-6 address mb-15">
									<a href="#" class="lnkdel" onclick="WishlistProductManage('wlp_bought', 'delete', '{$product.id_product}', '{$product.id_product_attribute}', $('#quantity_{$product.id_product}_{$product.id_product_attribute}').val(), $('#priority_{$product.id_product}_{$product.id_product_attribute}').val());" title="{l s='Delete' mod='novblockwishlist'}"><i class="material-icons close">close</i>
									</a>
									<div class="clearfix">
										<div class="product_image">
											<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}" title="{l s='Product detail' mod='novblockwishlist'}">
												<img class="img-fluid" src="{$link->getImageLink($product.link_rewrite, $product.cover, 'medium_default')|escape:'html'}" alt="{$product.name|escape:'html':'UTF-8'}" />
											</a>
										</div>
										<div class="product_infos">
											<div id="s_title" class="product_name"><a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html'}">{$product.name|escape:'html':'UTF-8'}</a></div>
										</div>
									</div>
								</div>
								{/foreach}
								</div>
							</div>
							<div class="wishlistLinkBottom">
								<div class="title_account_second">{l s='Share your wishlist' mod='novblockwishlist'}</div>
								<div class="input-group">
				                    <input class="form-control js-to-clipboard" readonly="readonly" type="url" value="{$link->getModuleLink('novblockwishlist', 'view', ['token' => $token_wish])|escape:'html':'UTF-8'}">
				                    <span class="input-group-append">
				                        <button class="btn input-group-text ml-1" type="button" id="NovCopyLink" data-text-copied="{l s='Copied' mod='novblockwishlist'}" data-text-copy="{l s='Copy Link' mod='novblockwishlist'}">{l s='Copy Link' mod='novblockwishlist'}</button>
				                    </span>
				                </div>
							</div>
						{else}
							<p class="warning">{l s='No products' mod='novblockwishlist'}</p>
						{/if}

	    			{/if}
	    		</div>
	    	</div>
	    </div>
	</div>
{/block}