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

{if isset($products)}
    <div class="nov-category-productlist{if isset($class) && $class} {$class}{/if}">
        <div class="block-product clearfix">
            {if isset($title) && !empty($title)}
                <h2 class="title_block text-{$title_align} style-{$title_style}">
                    {$title}
                    {if isset($sub_title) && !empty($sub_title)}
                        <span class="sub_title">{$sub_title}</span>
                    {/if}
                </h2>
            {/if}
            <div class="nov-tabs d-flex flex-nowrap">
                {foreach from=$products item=category key=k name=categories}
                    <a href="#{$tab}category{$k}-panel" id="{$tab}category{$k}-tab"
                        class="tab col {if $smarty.foreach.categories.first }active{/if}">
                        {foreach from=$category.image_urls item=image_url}
                            <img class="img-fluid" src="{$image_url}" alt="{$category.name}">
                        {/foreach}
                        <div class="title_category">{$category.name}</div>
                    </a>
                {/foreach}
            </div>

            <div class="nov-panels">
                {$xy =300}
                {foreach from=$products item=category key=k name=categories}
                    <div id="{$tab}category{$k}-panel" class="panel {if $smarty.foreach.categories.first }active{/if}">
                        {$products=$category.products}
                        {if !empty($products)}
                            <div class="nov-productslick row spacing-{$spacing} product_list grid slick-slider"
                                data-rows="{$number_row}" data-xl="{$xl}" data-lg="{$lg}" data-md="{$md}" data-xs="{$xs}">
                                {include file="$nov_dir./templates/_partials/layout/items/item_five_1.tpl" class_item='pl-15 pr-15 pl-xs-5 pr-xs-5' margin_bottom =$spacing}
                            </div>
                        {else}
                            <div class="product_list">
                                <p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
                            </div>
                        {/if}

                    </div>
                {/foreach}
            </div>
        </div>
    </div>
{/if}