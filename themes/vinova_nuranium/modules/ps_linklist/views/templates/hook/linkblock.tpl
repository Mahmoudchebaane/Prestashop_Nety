<div class="links">
  {foreach $linkBlocks as $linkBlock}
      {assign var=_expand_id value=10|mt_rand:100000}
      <ul id="footer_sub_menu_{$_expand_id}" class="list-inline mb-0">
        {foreach $linkBlock.links as $link}
          <li class="list-inline-item">
            <a
                id="{$link.id}-{$linkBlock.id}"
                class="{$link.class}"
                href="{$link.url}"
                title="{$link.description}">
              {$link.title}
            </a>
          </li>
        {/foreach}
      </ul>
  {/foreach}
</div>
