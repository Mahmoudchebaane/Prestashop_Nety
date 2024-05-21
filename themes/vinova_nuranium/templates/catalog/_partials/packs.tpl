<div id="js-product-list" class="js-listContainer">
    <div  data-default-view="grid">  {* class="listContainer grid row no-flow  " *}
   
        {if $novconfig.novthemeconfig_category_layout == 'layout-one-column'}
            {include file='_partials/layout/items/item_pack.tpl' products=$listing.products class_item='col-lg-3 col-md-4 col-xs-6'}
        {else}
            {if isset($class_homepage) && $class_homepage && $class_homepage == 'home-36' || $class_homepage == 'home-35' || $class_homepage == 'home-34'}
                {include file='_partials/layout/items/item_pack.tpl' products=$listing.products class_item='col-lg-3 col-md-6 col-xs-6'}
            {else}
                {include file='_partials/layout/items/item_pack.tpl' products=$listing.products class_item='col-lg-4 col-md-6 col-xs-6'}
            {/if}
        {/if}
    </div>
</div>