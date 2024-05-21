{if isset($posts) AND !empty($posts)}
<div id="recent_article_smart_blog_block_left"  class="block block-blog blogModule boxPlain">
   <h4 class="text-uppercase h6 hidden-sm-down"><a href="{smartblog::GetSmartBlogLink('smartblog')}">{l s='Recent Articles' mod='smartblogrecentposts'}</a></h4>
   <div class="block_content sdsbox-content">
    <ul class="recentArticles">
      {foreach from=$posts item="post"}

      <li>
       <div class="block-image">
          <a class="image" title="{$post.meta_title}" href="{$smartbloglink->getSmartBlogPostLink($post.id_smart_blog_post,$post.link_rewrite)}">
           <img alt="{$post.meta_title}" src="{_MODULE_DIR_}smartblog/images/{$post.id_smart_blog_post}-home-small.jpg" style="overflow: hidden;">
          </a>
        </div>
        <div class="popularpost-content">
          <a class="title"  title="{$post.meta_title}" href="{$smartbloglink->getSmartBlogPostLink($post.id_smart_blog_post,$post.link_rewrite)}">{$post.meta_title}</a>
          <span class="info">{$post.created}</span>
       </div>
      </li>
     {/foreach}
   </ul>
   </div>
</div>
{/if}