{**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author PrestaShop SA <contact@prestashop.com>
  * @copyright 2007-2017 PrestaShop SA
  * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
  * International Registered Trademark & Property of PrestaShop SA
  *}
<div class="modal fade js-product-images-modal" id="product-modal" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        {assign var=imagesCount value=$product.images|count}
        <figure>
          <img id="imgModal" class="js-modal-product-cover product-cover-modal" width="{$product.cover.large.width}"
            src="{$product.cover.large.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}"
            itemprop="image">
        </figure>
        <aside id="thumbnails" class="thumbnails js-thumbnails text-xs-center">
          {block name='product_images'}
            <div class="js-modal-mask mask {if $imagesCount <= 5} nomargin {/if}">
              <ul class="product-images js-modal-product-images">
                {foreach from=$product.images item=image}
                  <li class="thumb-container" onclick="changeImgModal({$product.images|json_encode},{$image|json_encode})">
                    <img id="imgModalThumb" data-image-large-src="{$image.large.url}" class="thumb js-modal-thumb"
                      src="{$image.small.url}" alt="{$image.legend}" title="{$image.legend}" width="{$image.small.width}"
                      itemprop="image">
                  </li>
                {/foreach}
              </ul>
            </div>
          {/block}
          {if $imagesCount > 5}
            <div class="arrows js-modal-arrows">
              <i class="fa fa-angle-up arrow-up js-modal-arrow-up"></i>
              <i class="fa fa-angle-down arrow-down js-modal-arrow-down"></i>
            </div>
          {/if}
        </aside>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  function changeImgModal(list, img) {
    var imgs = list;
    document.getElementById("imgModal").src = img.bySize.large_default.url;
    // $('#imgThumbs').addClass('selected')
    imgs.shift()
    // console.log('test1', $('#imgThumbs').addClass('selected'))
  }
</script>