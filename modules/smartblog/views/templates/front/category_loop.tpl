{assign var="options" value=null}
{$options.id_post = $post.id_post} 
{$options.slug = $post.link_rewrite}
  {$column='col-sm-12'}
{if isset($novconfig.novthemeconfig_cateblog_type) && $novconfig.novthemeconfig_cateblog_type == 'grid'}
 <div itemtype="#" itemscope="" class="sdsarticleCat col-md-6 {if isset($novconfig.novthemeconfig_cateblog_type)} {$column} {else}{$column} {/if}">
        <div id="smartblogpost-{$post.id_post}">
            <div class="articleContent">
                <a itemprop="url" title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="imageFeaturedLink">
                    {assign var="activeimgincat" value='0'}
                    {$activeimgincat = $smartshownoimg}
                    {if ($post.post_img != "no" && $activeimgincat == 0) || $activeimgincat == 1}
                        <img itemprop="image" alt="{$post.meta_title}" src="{$modules_dir}/smartblog/images/{$post.post_img}-single-default.jpg" class="imageFeatured img-fluid">
                    {/if}
                </a>
            </div>
            <div class="sdsarticleHeader">
                <div class="sdstitle_block"><a title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.meta_title}</a></div>
                    {assign var="options" value=null}
                    {$options.id_post = $post.id_post}
                    {$options.slug = $post.link_rewrite}
                    {assign var="catlink" value=null}
                    {$catlink.id_category = $post.id_category}
                    {$catlink.slug = $post.cat_link_rewrite}
                <div class="sdsarticle-info post-info">
                    <span class="datetime">{$post.created|date_format:"%B %d, %Y"}{*<span class="time">{$post.created|date_format:"%H:%M:%S"}</span>*}</span>
                    <span class="comment">
                        <i class="fa fa-comment-o"></i>
                        <a title="{$post.totalcomment} Comments" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}#articleComments">{$post.totalcomment} {l s='Comments' d='Modules.Blog'}</a>
                    </span>
                    {if $smartshowviewed == 1}
                        <span class="viewed">
                            <i class="fa fa-eye"></i>{l s='Views' d='Modules.Blog'} ({$post.viewed})
                        </span>
                    {/if}
                    {if $smartshowauthor == 1}
                        {*
                        {l s='Posted by' d='Modules.Blog'} 
                        *}
                        <span itemprop="author" class="author">
                            <i class="fa fa-user"></i>
                            {if $smartshowauthorstyle != 0}{$post.firstname} {$post.lastname}{else}{$post.lastname} {$post.firstname}{/if}
                        </span>
                    {/if}
                </div>
            </div>
            <div class="sdsarticle-des">
                <div itemprop="description">
                    {$post.content|strip_tags|truncate:260} 
                </div>
            </div>
            <div class="sdsreadMore ">
                <span class="more"><a title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="r_more">{l s='Read more' mod='Modules.Blog'}</a></span>
            </div>
        </div>
    </div>
{else}
    <div itemtype="#" itemscope="" class="sdsarticleCat items-list {$column}">
        <div id="smartblogpost-{$post.id_post}" class="media">
            <div class="articleContent d-flex">
                <a itemprop="url" title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="imageFeaturedLink">
                    {assign var="activeimgincat" value='0'}
                    {$activeimgincat = $smartshownoimg} 
                    {if ($post.post_img != "no" && $activeimgincat == 0) || $activeimgincat == 1}
                        <img itemprop="image" alt="{$post.meta_title}" src="{$modules_dir}/smartblog/images/{$post.post_img}-single-default.jpg" class="imageFeatured img-fluid">
                    {/if}
                </a>
            </div>
            <div class="media-body">
                <div class="sdsarticleHeader">
                    <div class='sdstitle_block'><a title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.meta_title}</a></div>
                        {assign var="options" value=null}
                        {$options.id_post = $post.id_post}
                        {$options.slug = $post.link_rewrite}
                        {assign var="catlink" value=null}
                        {$catlink.id_category = $post.id_category}
                        {$catlink.slug = $post.cat_link_rewrite}
                    <div class="sdsarticle-info post-info">
                        <span class="datetime">{$post.created|date_format:"%B %d, %Y"}{*<span class="time">{$post.created|date_format:"%H:%M:%S"}*}</span></span>

                        <span itemprop="articleSection" class="info-cate">
                            <i class="fa fa-tags"></i>
                            <a href="{smartblog::GetSmartBlogLink('smartblog_category',$catlink)}">{if $title_category != ''}{$title_category}{else}{$post.cat_name}{/if}</a>
                        </span>
                        <span class="comment">
                            <i class="fa fa-comment-o"></i>
                            <a title="{$post.totalcomment} Comments" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}#articleComments">{$post.totalcomment} {l s='Comments' d='Modules.Blog'}</a>
                        </span>
                        {if $smartshowviewed == 1}
                            <span class="viewed">
                                <i class="fa fa-eye"></i>{l s='Views' d='Modules.Blog'} ({$post.viewed})
                            </span>
                        {/if}
                        {if $smartshowauthor == 1}
                            <span itemprop="author" class="author">
                                <i class="fa fa-user"></i>
                                {if $smartshowauthorstyle != 0}{$post.firstname} {$post.lastname}{else}{$post.lastname} {$post.firstname}{/if}
                            </span>
                        {/if}
                    </div>
                </div>
                <div class="sdsarticle-des">
                    <div itemprop="description">
                        {$post.content|strip_tags|truncate:260} 
                    </div>
                    
                </div>
                <div class="sdsreadMore">
                    <span class="more"><a title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="r_more">{l s='Read more' mod='Modules.Blog'}</a></span>
                </div>
            </div>
        </div>
    </div> 
{/if}