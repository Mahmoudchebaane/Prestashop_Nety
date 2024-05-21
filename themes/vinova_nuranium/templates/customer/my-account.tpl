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
{extends file='customer/page.tpl'}

{block name='page_title'}
  {l s='My Nety' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
  {assign var=context value=Context::getContext()}
  {assign var=orders value=Order::getCustomerOrders($customer.id)}
  <ul class="portfolio-items">
    <li
      class="portfolio-item quarter double-height responsive-half {if $context->customer->ref_abonnement  == ''}pub_order {/if}"
      {if  $context->customer->ref_abonnement  == ''}style="height:auto" {/if}>
      <div class="card is-active" data-state="#contact">
        <div class="card-header">
          <div class="card-avatar pt-5  text-center">
            <i class="fa fa-user-o mt-5 fa-2x"></i>
          </div>
          <h2 class="card-jobtitle"> {l s='Bienvenue Mr/Mme,' d='Shop.Theme.Customeraccount'}</h2>
          <h1 class="card-fullname"> {assign var="fullname" value=$customer.firstname|cat:' '|cat:$customer.lastname  }
            {$fullname|truncate:36:"..." } </h1>
        </div>
        {if  $context->customer->ref_abonnement  != ''}
          <br>
        {/if}
        <div class="card-main">
          <div class="card-section is-active" id="contact">
            <div class="card-content">
              {if $context->customer->nameOffre}
                <div class="card-subtitle textstyle2">{l s='Mon offre' d='Shop.Theme.Customeraccount'} :
                  {$context->customer->nameOffre} </div>
              {/if}
              {if $context->customer->num_fixe && is_int($context->customer->num_fixe)}
                <div class="card-subtitle"><span>{l s='N° ligne fixe' d='Shop.Theme.Customeraccount'} : </span><span
                    style="direction: ltr !important;"> {$customer.num_fixe|number_format:0:" ":" "}</span> </div>
              {/if}
              {if $context->customer->ref_abonnement}
                <div class="card-subtitle"><span>{l s='Réference' d='Shop.Theme.Customeraccount'} : </span>
                  {$customer.ref_abonnement} </div>

                <hr>
              {/if}
              <div class="card-contact-wrapper">
                {if $customer.phone && is_int($customer.phone)}
                  <div class="card-contact">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path
                        d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z">
                      </path>
                    </svg><span style="direction: ltr !important;"> {$customer.phone|number_format:0:" ":" "}</span>
                  </div>
                {/if}
                <div class="card-contact">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <path d="M22 6l-10 7L2 6"></path>
                  </svg> {$customer.email}
                </div>
                {if  $context->customer->ref_abonnement  != '' }
                  <div class="card-contact">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                      <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    {if  $context->customer->adresse}
                      {$context->customer->adresse}
                    {else if $customer.addresses !=[]}
                      {$firstItem = $customer.addresses|reset}
                      {$firstItem.address1}
                    {else}
                      -----
                    {/if}
                  </div>
                  
                {/if}
                
              
                  <a class="contact-me"
                    href="{$urls.pages.identity}">{l s='Modifier mes informations' d='Shop.Theme.Customeraccount'} </a>
                </div>
            </div>
          </div>
        </div>

    </li>
    {if $context->customer->ref_abonnement  != ''}
      <li class="portfolio-item quarter no_pub   responsive-half  ">
        <div class="no_pub_intern ">
          <svg xmlns="http://www.w3.org/2000/svg" height="4em" viewBox="0 0 400 512" fill="#7e37b1">
            <path
              d="M288 256H96v64h192v-64zm89-151L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-153 31V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zM64 72c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8V72zm0 64c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8v-16zm256 304c0 4.42-3.58 8-8 8h-80c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16zm0-200v96c0 8.84-7.16 16-16 16H80c-8.84 0-16-7.16-16-16v-96c0-8.84 7.16-16 16-16h224c8.84 0 16 7.16 16 16z" />
          </svg>
          <div class="mt-md-3 mt-sm-1">
            <h2> {l s='Mes factures' d='Shop.Theme.Customeraccount'}</h2>
            <h5 class="textstyle1 "> {$context->customer->factureCount}
              {l s='Factures Impayées !' d='Shop.Theme.Customeraccount'} </h5>
            <p class="py-1">
              {l s='Votre tranquillité assurée : consultez et payez vos factures en toute sécurité.' d='Shop.Theme.Customeraccount'}
              </small>

              <a class="contact-me" href="{$link->getPageLink('facturesCRM', true)|escape:'html':'UTF-8'}">
                {l s='Consulter mes factures' d='Shop.Theme.Customeraccount'}
              </a>
          </div>
      </li>

    {/if}
    <li class="portfolio-item half  pub_nety3 responsive-half " id="place-before-me">
    </li>
    <li class="portfolio-item half pub_nety4 pub_nety2 d-flex flex-start p-5 left-element" id="beforelast">
    </li>
    <li
      class="portfolio-item quarter responsive-half pub_nety1 {if $context->customer->ref_abonnement  == ''}pub_order {/if}"
      id="reorderthis">
    </li>
  </ul>


{/block}
{block name='hook_before_body_closing_tag'}

  <script type="text/javascript">
    $(document).ready(function() {
      if ($(window).width() < 992) {
        $(document.getElementById('reorderthis')).insertBefore(document.getElementById('place-before-me'));
      } else {
        $(document.getElementById('reorderthis')).insertAfter(document.getElementById('beforelast'));
      }
    });
    $(window).resize(function() {
      if ($(window).width() < 992) {
        $(document.getElementById('reorderthis')).insertBefore(document.getElementById('place-before-me'));
      } else {
        $(document.getElementById('reorderthis')).insertAfter(document.getElementById('beforelast'));
      }
    });
  </script>
{/block}