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

<div class="nov-producttabs tab-slider tab-style-{$tabs_style}{if $show_arrows == 'true'} show_arrows{/if} {$el_class} tab-style-9">
    <div class="block-producttabs clearfix">
        {if $tabs_style == '2' || $tabs_style == '3' || $tabs_style == '4' || $tabs_style == '5' || $tabs_style == '7' || $tabs_style == '8'}
            {if isset($title) && !empty($title)}
                <h2 class="title_block text-center mb-30">
                    <span class="title_content">{$title}</span>
                    {if isset($sub_title) && !empty($sub_title)}
                        <span class="sub_title">{$sub_title}</span>
                    {/if}
                </h2>
            {/if}
        {/if}
        <div class="d-flex align-items-center d-xs-block{if $tabs_style == '2' || $tabs_style == '3' || $tabs_style == '4' || $tabs_style == '4' || $tabs_style == '7' || $tabs_style == '8'} justify-content-center{/if} block_nav">
            {if $tabs_style == '1' || $tabs_style == '6'}
                {if isset($title) && !empty($title)}
                    <h2 class="title_block">
                        {$title}
                        {if isset($sub_title) && !empty($sub_title)}
                            <span class="sub_title">{$sub_title}</span>
                        {/if}
                    </h2>
                {/if}
            {/if}

            <ul class="nav nav-tabs" role="tablist">
                {foreach from=$tabs item=tab_item name=tab}
                    {if $tab_item == 'newproducts'}
                        <li class="nav-item">
                            <a href="#newproducts{$tab}" class="nav-link active" role="tab" data-toggle="tab"><i class="zmdi zmdi-check"></i><span class="title1">{l s='New' mod='novmanagevcaddons'}</span><span class="title_content">{l s='Arrivals' mod='novmanagevcaddons'}</span></a>
                        </li>
                    {/if}
                    {if $tab_item == 'bestsellers'}
                        <li class="nav-item">
                            <a href="#bestsellers{$tab}" class="nav-link" role="tab" data-toggle="tab"><i class="zmdi zmdi-check"></i><span class="title1">{l s='Best' mod='novmanagevcaddons'}</span><span class="title_content">{l s='seller' mod='novmanagevcaddons'}</span>
                            </a>
                        </li>
                    {/if}
                    {if $tab_item == 'specialproducts'}
                        <li class="nav-item">
                            <a href="#specialproducts{$tab}" class="nav-link" role="tab" data-toggle="tab"><i class="zmdi zmdi-check"></i><span class="title1">{l s='On' mod='novmanagevcaddons'}</span><span class="title_content">{l s='Sale' mod='novmanagevcaddons'}</span></a></li>
                        {/if}
                        {if $tab_item == 'featureproducts'}
                        <li class="nav-item">
                            <a href="#featureproducts{$tab}" class="nav-link" role="tab" data-toggle="tab" ><i class="zmdi zmdi-check"></i><span class="title1">{l s='Featured' mod='novmanagevcaddons'}</span><span class="title_content">{l s='Product' mod='novmanagevcaddons'}</span></a></li>
                        {/if}
                    {/foreach}
            </ul>
        </div>
        <div class="block_content block_content_item_5">
            <div class="tab-content">
                {foreach from=$tabs item=tab_item name=tabcontent}
                    {if $tab_item == 'newproducts'}
                        <div class="tab-pane fade active" id="newproducts{$tab}" role="tabpanel">
                            {if !empty($newproducts)}
                                <div class="nov-productslick product_list grid row slick-slider" data-rows="{$number_row}" data-xl="{$xl}" data-lg="{$lg}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
                                    {include file="$nov_dir./templates/_partials/layout/items/item_five.tpl" products=$newproducts class_item='pl-15 pr-15 pl-xs-5 pr-xs-5' showdeal=false}
                                </div>
                            {else}
                                <p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
                            {/if}
                        </div>
                    {/if}
                    {if $tab_item == 'bestsellers'}
                        <div class="tab-pane fade" id="bestsellers{$tab}" role="tabpanel">
                            {if !empty($bestsellersproducts)}
                                <div class="nov-productslick product_list row grid slick-slider" data-rows="{$number_row}" data-xl="{$xl}" data-lg="{$lg}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
                                    {include file="$nov_dir./templates/_partials/layout/items/item_five.tpl" products=$bestsellersproducts class_item='pl-15 pr-15 pl-xs-5 pr-xs-5' showdeal=false}
                                </div>
                            {else}
                                <p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
                            {/if}
                        </div>
                    {/if}
                    {if $tab_item == 'specialproducts'}
                        <div class="tab-pane fade" id="specialproducts{$tab}" role="tabpanel">
                            {if !empty($specialproducts)}
                                <div class="nov-productslick product_list row grid slick-slider" data-rows="{$number_row}" data-xl="{$xl}" data-lg="{$lg}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
                                    {include file="$nov_dir./templates/_partials/layout/items/item_five.tpl" products=$specialproducts class_item='pl-15 pr-15 pl-xs-5 pr-xs-5' showdeal=false}
                                </div>
                            {else}
                                <p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
                            {/if}
                        </div>
                    {/if}
                    {if $tab_item == 'featureproducts'}
                        <div class="tab-pane fade" id="featureproducts{$tab}" role="tabpanel">
                            {if !empty($featureproducts)}
                                <div class="nov-productslick product_list row grid slick-slider" data-rows="{$number_row}" data-xl="{$xl}" data-lg="{$lg}" data-md="{$md}" data-xs="{$xs}" data-arrows="{$show_arrows}" data-dots="{$show_dots}" data-autoplay="{$autoplay}">
                                    {include file="$nov_dir./templates/_partials/layout/items/item_five.tpl" products=$featureproducts class_item='pl-15 pr-15 pl-xs-5 pr-xs-5' showdeal=false}
                                </div>
                            {else}
                                <p class="alert alert-info">{l s='No products at this time.' mod='novmanagevcaddons'}</p>
                            {/if}
                        </div>
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>
</div>