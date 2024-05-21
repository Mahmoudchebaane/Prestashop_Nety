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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='address_block_item'}
  <article id="address-{$address.id}" class="address" data-id-address="{$address.id}">
    <div class="address-body">
      <div class="address_alias d-flex mb-30">
        <div class="alias">{$address.alias}</div>
        <div class="ml-auto block_right">
          {block name='address_block_item_actions'}
            <div class="address-footer">

              <a class="update" href="{url entity=address id=$address.id}" data-link-action="edit-address">
                <i class="zmdi zmdi-edit"></i>
                <span>{l s='Update' d='Shop.Theme.Actions'}</span>
              </a>
              <a class="delete" href="{url entity=address id=$address.id params=['delete' => 1, 'token' => $token]}" data-link-action="delete-address">
                <i class="fa fa-trash-o"></i>
                <span>{l s='Delete' d='Shop.Theme.Actions'}</span>
              </a>
            </div>
          {/block}
        </div>
      </div>
      <ul class="list-unstyled">
        <li class="row">
          <div class="col-lg-3 col-md-4 font-weight-bold">{l s='Your Name' d='Shop.Theme.Actions'} :</div>
          <div class="col-lg-9 col-md-8">{$address.firstname}&nbsp;{$address.lastname}</div>
        </li>
        <li class="row">
          <div class="col-lg-3 col-md-4 font-weight-bold">{l s='Company' d='Shop.Theme.Actions'} :</div>
          <div class="col-lg-9 col-md-8">{$address.company}</div>
        </li>
        <li class="row">
          <div class="col-lg-3 col-md-4 font-weight-bold">{l s='Address' d='Shop.Theme.Actions'} :</div>
          <div class="col-lg-9 col-md-8">{$address.address1}</div>
        </li>
        {if $address.address1 !== blank}
          <li class="row">
            <div class="col-lg-3 col-md-4 font-weight-bold">{l s='Address Complement' d='Shop.Theme.Actions'} :</div>
            <div class="col-lg-9 col-md-8">{$address.address2}</div>
          </li>
        {/if}
        <li class="row">
          <div class="col-lg-3 col-md-4 font-weight-bold">{l s='City / State' d='Shop.Theme.Actions'} :</div>
          <div class="col-lg-9 col-md-8">{$address.city},&nbsp;{$address.id_state}&nbsp;{$address.postcode}</div>
        </li>
        <li class="row">
          <div class="col-lg-3 col-md-4 font-weight-bold">{l s='Country' d='Shop.Theme.Actions'} :</div>
          <div class="col-lg-9 col-md-8">{$address.id_country}</div>
        </li>
        <li class="row">
          <div class="col-lg-3 col-md-4 font-weight-bold">{l s='Phone' d='Shop.Theme.Actions'} :</div>
          <div class="col-lg-9 col-md-8">{$address.phone}</div>
        </li>
      </ul>
      {* <h4>{$address.alias}</h4>
      <address>{$address.formatted nofilter}</address> *}
    </div>

    {* {block name='address_block_item_actions'}
      <div class="address-footer">
        <a href="{url entity=address id=$address.id}" data-link-action="edit-address">
          <i class="material-icons">&#xE254;</i>
          <span>{l s='Update' d='Shop.Theme.Actions'}</span>
        </a>
        <a href="{url entity=address id=$address.id params=['delete' => 1, 'token' => $token]}" data-link-action="delete-address">
          <i class="material-icons">&#xE872;</i>
          <span>{l s='Delete' d='Shop.Theme.Actions'}</span>
        </a>
      </div>
    {/block} *}
  </article>
{/block}
