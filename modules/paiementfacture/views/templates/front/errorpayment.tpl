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
{extends file=$layout}
{block name='head_seo'}
<title>{block name='head_seo_title'}{l s='Paiement Facture' mod='paiementfacture'}{/block}</title>
{/block}

{block name='hook_header'}
  <link rel="stylesheet" type="text/css" href="{$module_dir|escape:'html':'UTF-8'}views/css/paiement.css">
  {*
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" /> *}
{/block}


{block name='breadcrumb'}
  <div class="pageheader "> </div>
{/block}

{block name='notifications'} {/block}
{block name='content' }

 

  {block name='page_header_container'}
    {block name='page_title' hide}

    {/block}
  {/block}

  {block name='page_content_container'}
    <section id="content" class="page-content abo-form-card abo-card-block paiementSection ">
      {block name='page_content_top'}
      {/block}
      {block name='page_content' }
 
          <div class="row">
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/IconAbo.png" class="title-icon col-auto" />
            <div class="col ">
              <label class="title-form-page font-size-35 font-weight-bold   ">
                {l s='Paiement Facture ' mod='paiementfacture' }</label>
              <div>
                {l s='Effectuez le règlement de vos factures en toute sécurité.' mod='paiementfacture' }
              </div>
            </div>
          </div>

          <div class="p-40 flex-row justify-content-center d-flex text-danger ">
         <sapn> <i class="zmdi zmdi-alert-octagon zmdi-hc-5x mr-20"></i> </sapn><h2  class="mt-25" >{l s='Votre tentative de paiement a échoué.' mod='paiementfacture' }</h2> 
          </div>
           <div class="mb-30 flex-wrap  justify-content-center d-flex   ">
            <button class="donePFoutline" type="button" onclick="location.href='{$homelink|escape:'html':'UTF-8'}'" > {l s='Retour acceuil' mod='paiementfacture' }</button>
            <button class="donePF" type="button" onclick="location.href='{$newpaylink|escape:'html':'UTF-8'}'" > {l s='Essayer de nouveau' mod='paiementfacture' }</button>
           </div>

      {/block}
    </section>
  {/block}

  {block name='page_footer_container'}
    <footer class="page-footer">
      {block name='page_footer'}
        <!-- Footer content -->
      {/block}
    </footer>
  {/block}
  </div>
{/block}

{block name='hook_before_body_closing_tag'}
 
{/block}