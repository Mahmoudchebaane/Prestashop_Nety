{extends file="layouts/`$novconfig.novthemeconfig_cateblog_layout`.tpl"}

{block name='head_seo_title'}{$title_category}{/block}
{block name='head_seo_description'}{$meta_description}{/block}
{block name='breadcrumb'}
	{if isset($breadcrumb)}
            <div class="breadcrumb">
		<nav class="container">
		  <ol>
		      <li>
		        <a href="{$breadcrumb.links[0].url}">
		          <span>{$breadcrumb.links[0].title}</span>
		        </a>
		      </li>
		      <li>
		        <a href="{smartblog::GetSmartBlogLink('smartblog')}">
		        <span>{l s='All Post' mod='smartblog'}</span>
		        </a>
		      </li>
		      {if $title_category != ''}
		     {assign var="link_detail" value=null}
		    {$link_detail.id_post = $id_post} 
		    {$link_detail.slug = $link_rewrite_}
		      <li>
		        <a href="{smartblog::GetSmartBlogLink('smartblog_post',$link_detail)}">
		        <span>{$meta_title}</span>
		        </a>
		      </li>
		    {/if}
		  </ol>
		</nav>
            </div>
	{/if}
{/block}
{block name='content'}
    <div class="pb-50 blogwapper{if $novconfig.novthemeconfig_cateblog_layout == 'layout-one-column'} one-columns{/if}{if $novconfig.novthemeconfig_cateblog_layout == 'layout-left-column'} has-sidebar-left{/if}{if $novconfig.novthemeconfig_cateblog_layout == 'layout-right-column'} has-sidebar-right{/if}">
        {capture name=path}
            <a href="{smartblog::GetSmartBlogLink('smartblog')}">{l s='All Blog News' d='Modules.Blog'}</a>
            {if $title_category != ''}
            {*<span class="navigation-pipe">{$navigationPipe}</span>*}{$title_category}{/if}
        {/capture}
        {if $postcategory == ''}
            {if $title_category != ''}
                <p class="error">{l s='No Post in Category' d='Modules.Blog'}</p>
            {else}
                <p class="error">{l s='No Post in Blog' d='Modules.Blog'}</p>
            {/if}
        {else}
            {if $smartdisablecatimg == '1'}
                {assign var="activeimgincat" value='0'}
                {$activeimgincat = $smartshownoimg} 
                {if $title_category != ''}
                    {foreach from=$categoryinfo item=category}
                        <div id="sdsblogCategory">
                            <h1>{$title_category}</h1>
                            {* if $cat_image != 'no' || $activeimgincat == 0}
                            <img alt="{$category.meta_title}" src="{$modules_dir}/smartblog/images/category/{$cat_image}-home-default.jpg" class="imageFeatured">
                            {/if *}
                            {if $category.description != ''}
                                <div class="blog-description">
                                    {$category.description nofilter}
                                </div>
                            {/if}

                        </div>
                    {/foreach}  
                {/if}
            {/if}
            {if $novconfig.novthemeconfig_cateblog_columns == "1"}
                {$column='col-sm-12'}
            {elseif $novconfig.novthemeconfig_cateblog_columns =="2"}
                 {$column='col-sm-6'}
            {elseif $novconfig.novthemeconfig_cateblog_columns == "3"}
                 {$column='col-sm-4'}
            {elseif $novconfig.novthemeconfig_cateblog_columns == "4"}
                  {$column='col-sm-3'}
            {/if}
            <div id="smartblogcat" class="no-flow block row {if $novconfig.novthemeconfig_cateblog_type == 'grid'}grid-blog {/if}" {if $novconfig.novthemeconfig_cateblog_layout == 'layout-one-column'}items-center{/if}">
                {foreach from=$postcategory item=post}
                    {include 'module:smartblog/views/templates/front/category_loop.tpl' postcategory=$postcategory}
                {/foreach}
            </div>

            {if !empty($pagenums)}
                <div class="post-page row">
                    <div class="col-lg-12">
                        <ul class="pagination text-center">
                            {for $k=0 to $pagenums}
                                {if $title_category != ''}
                                    {assign var="options" value=null}
                                    {$options.page = $k+1}
                                    {$options.id_category = $id_category}
                                    {$options.slug = $cat_link_rewrite}
                                {else}
                                    {assign var="options" value=null}
                                    {$options.page = $k+1}
                                {/if}
                                {if ($k+1) == $c}
                                    <li><span class="page-active">{$k+1}</span></li>
                                    {else}
                                        {if $title_category != ''}
                                        <li><a class="page-link" href="{smartblog::GetSmartBlogLink('smartblog_category_pagination',$options)}">{$k+1}</a></li>
                                        {else}
                                        <li><a class="page-link" href="{smartblog::GetSmartBlogLink('smartblog_list_pagination',$options)}">{$k+1}</a></li>
                                        {/if}
                                    {/if}
                                {/for}
                        </ul>
                    </div>
                </div>
            {/if}
        {/if}
      {if isset($smartcustomcss)}
        <style>
          {$smartcustomcss|escape:'htmlall':'UTF-8'}
        </style>
      {/if}
    </div>
{/block}