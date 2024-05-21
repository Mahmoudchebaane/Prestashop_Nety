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
  {extends file='page.tpl'}

  {block name='page_title'}
  {l s='Our stores' d='Shop.Theme.Cms'}
  {/block}

  {block name='page_content_container'}
  <div class="col">
    <h1 class="contactH1 mb-10">OÙ NOUS &nbsp;<strong>Trouvez</strong></h1>
    <p style="color:#585858;font-size:20px;text-align:center;font-weight:400;margin-bottom:50px">
      Retrouvez l’agence Nety et le revendeur la plus proche de vous !</p>
  </div>
  <div class="row filterStores">
    <div class="brands-sort dropdown">

      <button class="btn-unstyle select-title filterItem" rel="nofollow" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        {l s='Category' d='messages'}
        <i class="material-icons float-xs-right">arrow_drop_down</i>
      </button>
      <div class="dropdown-menu">
        {foreach from=$stores item=address}

        {/foreach}
      </div>
    </div>
    <div class="brands-sort dropdown">
    

      <button class="btn-unstyle select-title filterItem" rel="nofollow" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        {l s='Gouvernerat' d='Shop.Theme.Catalog'}
        <i class="material-icons float-xs-right">arrow_drop_down</i>
      </button>
      <div class="dropdown-menu">
        {foreach from=$stores item=address}
        {$stores|@json_encode}
        {/foreach}
      </div>
    </div>
    <div class="brands-sort dropdown">

      <button class="btn-unstyle select-title filterItem" rel="nofollow" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        {l s='Ville' d='Shop.Theme.Catalog'}
        <i class="material-icons float-xs-right">arrow_drop_down</i>
      </button>
      <div class="dropdown-menu">
        {foreach from=$stores item=address}

        {/foreach}
      </div>
    </div>

    <button class="filterBtn">{l s='Done' d='messages'}</button>
  </div>
  <section id="content" class="page-content page-stores storeContainer">

    {foreach $stores as $store}
    <article id="store-{$store.id}" class="store-item card storeItem">
      <div class=" clearfix h-100">
        <div class="col-md-3 store-picture hidden-sm-down d-none">
          <img src="{$store.image.bySize.stores_default.url}" alt="{$store.image.legend}" title="{$store.image.legend}">
        </div>
        <div class="col-md-5 col-sm-7 col-xs-12 store-description storeDescription">
          <h3 class="h3 card-title">{$store.name}</h3>
          <div>
            <table>
              {if $store.email}
              <tr>
                <td class="storeLabel">Mail:</td>
                <td class="storeInfo">{$store.email}</td>
              </tr>
              {/if}
              {if $store.address}
              <tr>
                <th class="storeLabel">Adresse:</th>
                <td class="storeInfo">
                  <!-- <address>{$store.address.formatted nofilter}</address> -->
                  {$store.address.address1}
                </td>
              </tr>
              {/if}
              {if $store.phone}
              <tr>
                <th class="storeLabel">Telephone:</th>
                <td class="storeInfo">{$store.phone}</td>
              </tr>
              {/if}
            </table>

          </div>
          <!-- <div>
        {if $store.note || $store.phone || $store.fax || $store.email}
        <a data-toggle="collapse" href="#about-{$store.id}" aria-expanded="false"
          aria-controls="about-{$store.id}"><strong>{l s='About and Contact' d='Shop.Theme.Cms'}</strong><i
            class="material-icons d-none">&#xE409;</i></a>
        {/if}
      </div> -->

        </div>
        <div class="col-md-4 col-sm-5 col-xs-12 divide-left d-none">
          <table>
            {foreach $store.business_hours as $day}
            <tr>
              <th>{$day.day|truncate:4:'.'}</th>
              <td>
                <ul>
                  {foreach $day.hours as $h}
                  <li>{$h}</li>
                  {/foreach}
                </ul>
              </td>
            </tr>
            {/foreach}
          </table>
        </div>
      </div>

      <footer id="about-{$store.id}" class="collapse">
        <div class="store-item-footer divide-top">
          <div class="card-block">
            {if $store.note}
            <p class="text-justify">{$store.note}
            <p>
              {/if}
          </div>
          <ul class="card-block">
            {if $store.phone}
            <li><i class="material-icons">&#xE0B0;</i>{$store.phone}</li>
            {/if}
            {if $store.fax}
            <li><i class="material-icons">&#xE8AD;</i>{$store.fax}</li>
            {/if}
            {if $store.email}
            <li><i class="material-icons">&#xE0BE;</i>{$store.email}</li>
            {/if}
          </ul>
        </div>
      </footer>
    </article>
    {/foreach}

  </section>

  {/block}