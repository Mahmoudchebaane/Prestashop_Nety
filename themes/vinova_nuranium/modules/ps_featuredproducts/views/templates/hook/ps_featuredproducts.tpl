{*
* 2007-2019 PrestaShop
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
* @author PrestaShop SA <contact@prestashop.com>
  * @copyright 2007-2019 PrestaShop SA
  * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
  * International Registered Trademark & Property of PrestaShop SA
  *}

<section class="nov-productlist featured-products">


  {* <h2 class="title_block text_center contactH1 pt-50">{l s='Popular Products' d='Shop.Theme.Catalog'}</h2> *}
  {* <h2 class="title_block text_center">{l s='Popular Products' d='Shop.Theme.Catalog'}</h2> *}
  <h1 class="contactH1 pt-30">{l s='Popular Products' d='Shop.Theme.Catalog'} </h1>

  <div class="block_content ">
    <div class="oneArea">
      {foreach from=$products item=product name=products}
        <div
          class="oneBox product-miniature js-product-miniature item-one lupanh{if $smarty.foreach.products.first} first_item{elseif $smarty.foreach.products.last} last_item{/if}"
          data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope
          itemtype="http://schema.org/Product">
          <div class="card_pack-header pack_header">
            {block name='product_name'}
              <div class="pack_header d-flex align-items-center" itemprop="name">
                <p style="font-weight: 600;" itemprop="desciption">
                  {$product.description_short|strip_tags|truncate:280 nofilter} </p>
                <p href="{$product.url}">{$product.name}</p>
                {* <span itemprop="desciption">{$product.description_short|strip_tags|truncate:280 nofilter}</span> *}
              </div>
            {/block}

            {* {block name='product_price_and_shipping'}
              <div class="d-flex align-items-end">
                {if $product.show_price}
                  <div class="product-price-and-shipping">

                    {hook h='displayProductPriceBlock' product=$product type="before_price"}
                    <span itemprop="price" class="price">{$product.price} </span>

                    {hook h='displayProductPriceBlock' product=$product type='unit_price'}
                    <span class="ttc"> {l s='Tax included' d='Shop.Theme.Global'}</span>

                  </div>
                {/if}
              </div>
            {/block} *}
            {block name='product_price_and_shipping'}
              <div class="d-flex align-items-end" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                  {if $product.show_price}
                      <div class="product-price-and-shipping">
                          {hook h='displayProductPriceBlock' product=$product type="before_price"}
                          <link itemprop="availability" href="https://schema.org/InStock" />
                          <span itemprop="price" class="price">{$product.price} </span>
                          <meta itemprop="priceCurrency" content="{$currency.iso_code}">
                          {hook h='displayProductPriceBlock' product=$product type='unit_price'}
                          <span class="ttc"> {l s='Tax included' d='Shop.Theme.Global'}</span>

                      </div>
                  {/if}
              </div>
          {/block}
          <div class="hidden">
                <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
                    <span itemprop="reviewCount"></span>
                    <span itemprop="ratingValue"></span>
                </div>
                <div itemprop="review" itemscope itemtype="https://schema.org/Review" >
                    <div itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                        <meta itemprop="worstRating" content="1">
                        <span itemprop="ratingValue"></span>
                        <span itemprop="bestRating"></span>
                    </div>
                    <span itemprop="reviewBody"></span>
                </div>
            </div>
          </div>
          <div class="card_pack-body" >
            <div class="product-description mb-50 mb-xs-30 " itemprop="desciption">
              {if $product.description} {$product.description nofilter} {/if}

              {if $product.accessories}
                {foreach from=$product.accessories item=productassoc name=productassocs}
                  <div class="vc_row wpb_row vc_row-fluid mb-0">
                    <div class="vc_col-sm-12 wpb_column vc_column_container">
                      <div class="vc_column-inner">
                        <div class="wpb_wrapper">
                          <div class="nov_image_text">
                            <div class="d-flex align-items-top"><img src="/modules/jscomposer/uploads/Icon-2x.png"
                                class="image mt-3" alt="Icon-2x.png" />
                              <div class="content_text">
                                <div class="text_top associated_product">
                                  {if $productassoc.price > 0  }
                                    {if $productassoc.features|@count > 0  &&  $productassoc.features[0].name == "Afficher Prix " && $productassoc.features[0].value=='OUI'  }
                                      <span class="noetiquette"> {$productassoc.name} {$productassoc.price}
                                        {$productassoc.description|strip_tags  nofilter} </span>
                                    {else}
                                      <span class="noetiquette"> {$productassoc.name}
                                        {$productassoc.description|strip_tags  nofilter}</span>
                                    {/if}
                                  {else}
                                    <span class="beforetiquette">{$productassoc.name} </span><span
                                      class="etiquette">{$productassoc.description_short|strip_tags|truncate:280 nofilter}</span>
                                    {$productassoc.description|strip_tags  nofilter}
                                  {/if}
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                {/foreach}
              {/if}
            </div>


            <div class="nov_button type-1">
              {hook h="displayTopHeader" id_pack=$product.id_product }
            </div>


          </div>
          <div class="nov_button type-1">
            {hook h="displayTopHeader" id_pack=$product.id_product }
          </div>
        </div>
      {/foreach}
    </div>

</section>