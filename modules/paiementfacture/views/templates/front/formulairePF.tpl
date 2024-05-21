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

  {if  $notifications.success ||  $notifications.error ||  $notifications.warning   ||  $notifications.info }
    <div id="Modalnotif" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title"> Félicitation</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <aside id="notifications">

              {if $notifications.error}
                {block name='notifications_error'}
                  <article class="alert alert-danger" role="alert" data-alert="danger">
                    <ul>
                      {foreach $notifications.error as $notif}
                        <li>{$notif nofilter}</li>
                      {/foreach}
                    </ul>
                  </article>
                {/block}
              {/if}

              {if $notifications.warning}
                {block name='notifications_warning'}
                  <article class="alert alert-warning" role="alert" data-alert="warning">
                    <ul>
                      {foreach $notifications.warning as $notif}
                        <li>{$notif nofilter}</li>
                      {/foreach}
                    </ul>
                  </article>
                {/block}
              {/if}

              {if $notifications.success}
                {foreach $notifications.success as $notif}
                  <span class="font-size-16  text-muted">{$notif nofilter } <br></span>
                {/foreach}
              {/if}

              {if $notifications.info}
                {block name='notifications_info'}
                  <article class="alert alert-info" role="alert" data-alert="info">
                    <ul>
                      {foreach $notifications.info as $notif}
                        <li>{$notif nofilter}</li>
                      {/foreach}
                    </ul>
                  </article>
                {/block}
              {/if}
            </aside>
          </div>


        </div>
      </div>
    </div>
  {/if}

  {block name='page_header_container'}
    {block name='page_title' hide}

    {/block}
  {/block}

  {block name='page_content_container'}
    <section id="content" class="page-content abo-form-card abo-card-block paiementSection ">
      {block name='page_content_top'}
      {/block}
      {block name='page_content' }



        <div id="payStep1">


          <div class="row">
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/IconAbo.png" class="title-icon col-auto" />
            <div class="col ">
              <label class="title-form-page font-size-35 font-weight-bold   ">
                {l s='Paiement Facture ' mod='paiementfacture' }</label>
              <div>
                {l s='Pour accèder au paiement de vos factures, veuillez remplir l’un des champs suivants' mod='paiementfacture' }
              </div>
            </div>
          </div>

          <div class="container1">
            <div class=" typeContainer btn-group d-none">
              <p class="firstLabel"> {l s='Rechercher par:' mod='paiementfacture' }</p>
              <div class=" " role="group" aria-label="Basic radio toggle button group">
                <button class=" paymentType" onclick="cinInput()" id='cin'
                  for="cin">{l s='Numéro de CIN' mod='paiementfacture' }</button>
              </div>
            </div>
            <div class="typeContainer">
              <p class="firstLabel"> {l s='Rechercher par:' mod='paiementfacture' }</p>
              <ul class="nav nav-tabs mt-10 " id="myTab" role="tablist">

                <li class="nav-item ">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">{l s='Numéro de CIN' mod='paiementfacture'}</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                    aria-selected="false">{l s='Numéro de facture' mod='paiementfacture'}</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages"
                    aria-selected="false">{l s='Numéro de ligne' mod='paiementfacture'}</a>
                </li>
              </ul>
            </div>
            <form>
              <div class="tab-content inputNumContainer ">
                <div class="tab-pane text-center active" id="home" role="tabpanel" aria-labelledby="home-tab">

                  <p>{l s='Entrez le numéro de votre CIN' mod='paiementfacture'}</p>
                  <input type='text' required name="identif1" class="inputPF mb-5" />

                  <button class="donePF mb-5" onclick="goToPayment(1,event)"  id="searchByCIN">{l s='Rechercher' mod='paiementfacture'}</button>

                </div>
                <div class="tab-pane text-center" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <p>{l s='Entrez le numéro de votre facture' mod='paiementfacture'}</p>

                  <input type='text' name="identif2" required class="inputPF mb-5" />
                  <button class="donePF mb-5" onclick="goToPayment(2,event)"  id="searchByFacture" >{l s='Rechercher' mod='paiementfacture'}</button>

                </div>
                <div class="tab-pane text-center" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                  <p>{l s='Entrez le numéro de votre ligne fixe' mod='paiementfacture'}</p>
                  <input type='text' name="identif3" required class="inputPF mb-5" />
                  <button class="donePF mb-5" onclick="goToPayment(3,event)" id="searchByFixe" >{l s='Rechercher' mod='paiementfacture'}</button>

                </div>
              </div>

              {* On utilise la fonctionnalité de eicaptcha *}
              {$renderCaptcha nofilter}
            </form>
          </div>
        </div>

        <div id="payStep2">
          <div class="row">
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/IconAbo.png" class="title-icon col-auto" />
            <div class="col ">
              <label class="title-form-page font-size-35 font-weight-bold   ">
                {l s='Paiement facture(s) ' mod='paiementfacture' }</label>
              <div>
                {l s='Sélectionner les factures à régler' mod='paiementfacture' }
              </div>
            </div>
          </div>

          <form class="container1" name='sendtopay' onsubmit="return handleData()" method="POST">

            <div id="fact_list">
            </div>
            <div class="hidden text-danger font-size-16 text-right pt-10 pr-35" id="chk_option_error">
              {l s='Veuillez choisir au minimum une facture'  mod='paiementfacture'}
            </div>
            <div class="client" id="info_pied">
            </div>


            <div class="typeCarte">
              <div class="d-flex flex-wrap justify-content-center ">
                <p class=" mb-5 mr-0 font-weight-bold font-size-16 text-black nowrap">
                  {l s='Paiement par:' mod='paiementfacture' }</p>
                <div class="d-flex flex-wrap justify-content-center ">
                  <div class="form-check custom-control custom-radio custom-control-inline"
                    style="width:140px; margin:0 20px">
                    <input class="form-check-input" type="radio" name="paiement" value="Carte bancaire" checked>
                    <label class="form-check-label paiementLabel"
                      for="carte">{l s='Carte bancaire' mod='paiementfacture' }</label>
                  </div>
                </div>
              </div>
              <button class="donePF" type="submit" name="sendtopaybtn" id="paybtn"> {l s='Passer au paiement' mod='paiementfacture' }</button>
            </div>
          </form>
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
  <script type="text/javascript">
    // <![CDATA[
    var Client = '{l s='Client' mod='paiementfacture' js=1}';
    var numfixe = '{l s='N° ligne' mod='paiementfacture' js=1}'; 
    var Total = '{l s='Total à payer' mod='paiementfacture' js=1}';
    var numfact='{l s='Num facture ' mod='paiementfacture' js=1}';
    var numavoir='{l s='Num Avoir' mod='paiementfacture' js=1}';
    var payerAvant='{l s='A payer avant le ' mod='paiementfacture' js=1}';
    var btnfact='{l s='Télécharger votre facture ' mod='paiementfacture' js=1}';
    var Du='{l s='Du' mod='paiementfacture' js=1}';
    var Au='{l s='Au' mod='paiementfacture' js=1}';
    var NOF='{l s='Aucune facture à payer .' mod='paiementfacture' js=1}';
    var EROR='{l s='Une erreur se produite,Veuillez réessayer plus tard.' mod='paiementfacture' js=1}';
    var TND = '{l s='TND' mod='paiementfacture' js=1}';
    var NL='{l s='Le numéro de ligne fixe n\'existe pas.' mod='paiementfacture' js=1}';
    var NF='{l s='Le numéro de facture n\'existe pas.' mod='paiementfacture' js=1}';
    var NC='{l s='Le numéro de CIN n\'existe pas.' mod='paiementfacture' js=1}';
    var revendeur = "{l s='Please head to the nearest Nety point of sale to complete the subscription process' mod='paiementfacture'}"
    var  noInvoices = "{l s='No invoices to display' mod='paiementfacture'}"
    var previousInvoice ="{l s='Please pay the old bills first.' mod='paiementfacture'}";
  //]]>
</script>
{* <script src="{$module_dir|escape:'html':'UTF-8'}views/js/sweeatalert.min.js"></script> *}

<script src="{$module_dir|escape:'html':'UTF-8'}views/js/paiement.js"></script>
{/block}