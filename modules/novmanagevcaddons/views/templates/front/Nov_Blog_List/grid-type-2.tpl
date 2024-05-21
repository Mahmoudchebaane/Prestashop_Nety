{if isset($posts) && !empty($posts)}
  <div class="nov-bloglist {$el_class}">
    <div class="block block-blog clearfix novblog-box-content grid-style-2">
      {if isset($title) && !empty($title)}
        <h2 class="title_block text-{$title_align} style-{$title_style}">
          <span class="title_content">{$title}</span>
          {if isset($sub_title) && !empty($sub_title)}
            <span class="sub_title">{$sub_title}</span>
          {/if}
        </h2>
      {/if}
      <div class="row no-flow grid_style">
        {assign var='i' value=1}
        <div class="col-lg-6 post-item-left mb-sm-30">
          {foreach from=$posts item=post name=posts}
            {assign var="options" value=null}
            {$options.id_post = $post.id}
            {$options.slug = $post.link_rewrite}
            {if $smarty.foreach.posts.first}
              <div class="post-content position-relative">
                <div class="post-image position-relative">
                  <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}"><img alt="{$post.title}" class="feat_img_small img-fluid" src="{$nov_modules_dir}/smartblog/images/{$post.post_img}-single-default.jpg"></a>
                  <div class="post-time position-absolute">
                      <div class="date">{$post.date_added|date_format:"%d"}</div>
                      <div class="month">{$post.date_added|date_format:"%b"}</div>
                  </div>
                </div>
                <div class="description-content position-absolute">
                  <div class="post_title mb-10"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></div>
                  <div class="post-desc">{$post.short_description|strip_tags:'UTF-8'|truncate:150:'...'}</div>
                </div>
              </div>
            {/if}
          {/foreach}
        </div>
        <div class="col-lg-5 post-item-right">
          {foreach from=$posts item=post name=posts}
            {assign var="options" value=null}
            {$options.id_post = $post.id}
            {$options.slug = $post.link_rewrite}
            {if $smarty.foreach.posts.first =='' && $smarty.foreach.posts.index < 4}
              <div class="post-content d-flex">
                <div class="post-image">
                  <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}"><img alt="{$post.title}" class="feat_img_small img-fluid" src="{$nov_modules_dir}/smartblog/images/{$post.post_img}-single-default.jpg"></a>
                </div>
                <div class="description-content">
                  <div class="post_title"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></div>
                  <div class="post-info">
                    <span><i class="zmdi zmdi-calendar-note"></i>{$post.date_added|date_format:"%d %B, %Y"}</span>
                    <a title="{$post.countcomment} Comments" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}#articleComments"></a>
                    <span><i class="zmdi zmdi-comments"></i> {if $post.countcomment != ''}{$post.countcomment} {l s='comments' mod='novmanagevcaddons'}{else}{l s='0 comment' mod='novmanagevcaddons'}{/if}</span>
                  </div>
                </div>
              </div>
            {/if}
          {/foreach}
        </div>   
      </div>
    </div>
  </div>
{/if}
