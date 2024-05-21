{if $comment.id_smart_blog_comment != ''}
<ul class="commentList">
    <div id="comment-{$comment.id_smart_blog_comment}">
      <li class="even">
        <img class="avatar" alt="Avatar" src="{$modules_dir}/smartblog/images/avatar/avatar-author-default.jpg">
        <div class="d-flex align-items-center mb-15 pb-5">
          <div class="name">{$childcommnets.name}</div>
          <div class="ml-auto d-flex align-items-center">
            <div class="created m-0">
              {l s="Comment in " mod="smartblog"}<span itemprop="commentTime">{$childcommnets.created|date_format}/&nbsp;</span>
            </div>
            {if Configuration::get('smartenablecomment') == 1}
              {if $comment_status == 1}
                <div class="reply m-0">
                  <a onclick="return addComment.moveForm('comment-{$comment.id_smart_blog_comment}', '{$comment.id_smart_blog_comment}', 'respond', '{$id_post}')" class="comment-reply-link">{l s="Reply" mod="smartblog"}</a>
                </div>
              {/if}
            {/if}
          </div>
        </div>
        <p class="mb-15">{$childcommnets.content}</p>
        {if isset($childcommnets.child_comments)}
          {foreach from=$childcommnets.child_comments item=comment}  
            {if isset($childcommnets.child_comments)}
              {include file="module:smartblog/views/templates/front/comment_loop.tpl" childcommnets=$comment}
              {$i=$i+1}
            {/if}
          {/foreach}
        {/if}
      </li>
    </div>
</ul>
{/if}