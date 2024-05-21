{if isset($listing.rendered_facets)}
  <div id="search_filters_wrapper" class="block  ">
    <div class="title_block"><span>{l s='Filter' d='Shop.Theme.Actions'}</span></div>
    <div id="search_filter_controls" class="hidden-md-up">
      <span id="_mobile_search_filters_clear_all"></span>
      <button class="btn btn-secondary ok filterOk">
        {* <i class="material-icons">&#xE876;</i> *}
        {l s='Filter' d='Shop.Theme.Actions'}
      </button>
    </div>
    {if $novconfig.novthemeconfig_category_layout != "layout-one-column"}
      {block name='product_list_active_filters'}
        <div class="hidden-sm-down">
          {$listing.rendered_active_filters nofilter}
        </div>
      {/block}
    {/if}
    {$listing.rendered_facets nofilter}
  </div>
{/if}