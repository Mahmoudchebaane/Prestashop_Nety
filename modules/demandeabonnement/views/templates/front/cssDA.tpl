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
{extends file=$layout}

{block name='head_seo'}
  <title>{block name='head_seo_title'}{l s='Demande Abonnement CSS' mod='demandeabonnement'}{/block}</title>
{/block}

{block name='hook_header'}
  <link rel="stylesheet" type="text/css" href="/modules/demandeabonnement/views/js/arcgis/esri/css/main.css">
  <link rel="stylesheet" type="text/css" href="/modules/demandeabonnement/views/css/front.css">

{/block}

{block name='breadcrumb'}
  <div class="cssHeader">
    <img src="{$module_dir|escape:'html':'UTF-8'}views/img/css/cssLogo.png" class="cssLogo">
    <img src="{$module_dir|escape:'html':'UTF-8'}views/img/css/ballon.png" class="diwanRight">
  </div>
{/block}

{block name='notifications'} {/block}
{block name='content' }

  {if  $notifications.success ||  $notifications.error   }

    <div id="Modalnotif" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title">{if $notifications.error} {l s='Echec' mod='demandeabonnement'} !!
              {else} {l s='Félicitation' mod='demandeabonnement'}
              {/if}</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <aside id="notifications">

              {if $notifications.error}
                {block name='notifications_error'}
                  <article class="alert alert-danger" role="alert" data-alert="danger">
                    <ul>
                      {foreach $notifications.error as $notif}
                        {* <li>{$notif nofilter}</li> *}
                        <span class="font-size-16  text-muted"> {$notif nofilter } <br></span>
                        {* <li> {l s='Une erreur systeme se produite'  mod='demandeabonnement' }</li> *}
                      {/foreach}
                    </ul>
                  </article>
                {/block}
              {/if}

              {if $notifications.success}
                {foreach $notifications.success as $notif}
                  <span class="font-size-16  text-muted">
                    {* {$notif nofilter } *}
                    {l s=' Nous vous informons que votre demande d’abonnement est en cours de traitement'  mod='demandeabonnement' }
                    <br></span>
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

  <div id="main">
    {block name='page_header_container'}
      {block name='page_title' hide}
        <div class="page-header">
          <h1 class="page-title hidden-xs-up">{$smarty.block.child}</h1>
        </div>
      {/block}
    {/block}
    {block name='page_content_container'}

      <section id="content" class="page-content abo-form-card abo-card-block cssSection ">
        {*class="page-content card card-block"*}
        {block name='page_content_top'}

        {/block}
        {block name='page_content' }
          <div class="row blocTitle">
            {* <i class="zmdi zmdi-accounts-add" style="font-size: 48px; color:white; background-color:#59049D;border-radius:50%;height:100%"> </i> *}
            <img src="{$module_dir|escape:'html':'UTF-8'}views/img/css/IconAboCss.png" class="title-icon col-auto" />
            <div class="col ">
              <label
                class="title-form-page css-title font-size-35 font-weight-bold   ">{l s='Formulaire d’abonnement' mod='demandeabonnement' }</label>
              <div>
                {l s='Merci de remplir le formulaire suivant pour vous abonner à Net\'s GO' mod='demandeabonnement' }
              </div>
            </div>
          </div>
          <form role="form" id="formDA" action="{$urls.current_url}" method="post" enctype="multipart/form-data"
            class="form-container" novalidate>
            <div class="stepwizard">
              <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                  <a href="#step-1" type="button" class="btn  btn-step btn-step-css btn-circle">1</a>
                  <p class="active-title">{l s='Forfait abonnement' mod='demandeabonnement' }</p>
                </div>
                <div class="stepwizard-step">
                  <a href="#step-2" type="button" class="btn btn-outline-step btn-circle disabled">2</a>
                  <p>{l s='Coordonnées' mod='demandeabonnement' }</p>
                </div>
                <div class="stepwizard-step">
                  <a href="#step-3" type="button" class="btn btn-outline-step btn-circle  disabled">3</a>
                  <p>{l s='Position' mod='demandeabonnement' }</p>
                </div>
                <div class="stepwizard-step">
                  <a href="#step-4" type="button" class="btn btn-outline-step btn-circle  beforelaststep disabled">4</a>
                  <p>{l s='Confirmation' mod='demandeabonnement' }</p>
                </div>
              </div>
            </div>
            <div class="stepwizard-content">

              <div class="row setup-content" id="step-1">
                <div>
                  <div class="form-group">
                    <label class="control-label mb-2 ">
                      {l s='Forfait abonnement' mod='demandeabonnement' } <sup>*</sup>: </label>
                    <div class=" checkboxoffre  ">
                      {foreach from=$catproducts  item=produit}
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="produitid" id="{$produit.reference}"
                            value="{$produit.reference}" {if $produit.id_product == $id_product} checked 
                            {elseif $produit@first}
                            checked {/if } />
                          <label class="form-check-label" for="{$produit.reference}">{$produit.name} </label>
                        </div>
                      {/foreach}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label mb-2 ">{l s='Périodicité de facturation' mod='demandeabonnement' }
                      <sup>*</sup>: </label>

                    <div class="checkboxoffre">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodpaiement_id" id="inlineRadioM"
                          value="ref_1mois" checked>
                        <label class="form-check-label" for="inlineRadioM">{l s='Mensuel' mod='demandeabonnement' }</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodpaiement_id" id="inlineRadioT"
                          value="ref_3mois">
                        <label class="form-check-label"
                          for="inlineRadioT">{l s='Trimestriel' mod='demandeabonnement' }</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodpaiement_id" id="inlineRadioS"
                          value="ref_6mois">
                        <label class="form-check-label" for="inlineRadioS">{l s='Semestriel' mod='demandeabonnement' }</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodpaiement_id" id="inlineRadioA"
                          value="ref_1an">
                        <label class="form-check-label" for="inlineRadioA">{l s='Annuel' mod='demandeabonnement' }</label>
                      </div>
                    </div>
                  </div>


                  <div class="row col ">
                    <span
                      class="font-size-16  mr-30 text-muted">{l s='Avez-vous déjà un téléphone fixe? ' mod='demandeabonnement' }
                    </span>
                    <div class="row font-size-16 ">
                      <div class="form-check col form-check-inline">
                        <input class="form-check-input" type="radio" name="hastelfixe" id="inlineRadioOui" value="optionOui">
                        <label class="form-check-label mr-30  mr-xs-0"
                          for="inlineRadioOui">{l s='Oui' mod='demandeabonnement' }</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <p>&nbsp;</p>
                      </div>
                      <div class="form-check   form-check-inline">
                        <input class="form-check-input" type="radio" name="hastelfixe" id="inlineRadioNon" value="optionNon"
                          checked>
                        <label class="form-check-label" for="inlineRadioNon">{l s='Non' mod='demandeabonnement' }</label>
                      </div>
                    </div>
                  </div>

                  <div class="row   rowfix">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label class="control-label" for="telfixe"> {l s='N° Tél. Fixe' mod='demandeabonnement' }
                          <sup>*</sup></label>
                        <input class="form-control" name="telfixe" type="text" maxlength="8" minlength="8" required />
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-next  nextBtn pull-right " id="StepDA1"
                    type="button">{l s='Suivant' mod='demandeabonnement' }</button>
                </div>
              </div>
            </div>

            <div class="row setup-content" id="step-2">
              <div>

                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label"> {l s='Type Identifiant' mod='demandeabonnement' }
                        <sup>*</sup></label>

                      <select name="type_identifiant" required>
                        <option value="1">{l s='CIN' mod='demandeabonnement'}</option>
                        <option value="2">{l s='Carte Séjour' mod='demandeabonnement'}</option>
                        <option value="3">{l s='Passeport' mod='demandeabonnement'}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label">
                        {l s='Identifiant' mod='demandeabonnement' }<sup>*</sup></label>
                      <input name="identifiant" type="text" class="form-control" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label">
                        {l s='Nom' mod='demandeabonnement' } <sup>*</sup></label>
                      <input name="first_name" required type="text" class="form-control" />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label">

                        {l s='Prénom' mod='demandeabonnement' } <sup>*</sup></label>
                      <input name="last_name" type="text" required class="form-control" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label"> {l s='Numéro téléphone' mod='demandeabonnement' }
                        <sup>*</sup></label>
                      <input name="telmobile" type="text" maxlength="8" minlength="8" required class="form-control" />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label">
                        {l s='Email' mod='demandeabonnement' }</label>
                      <input name="email" type="text" class="form-control" />
                    </div>
                  </div>
                </div>

                <div class="row mt-30">
                  <label class="font-size-16 font-weight-bold col">
                    {l s='Télécharger votre carte d’identité nationale(CIN)' mod='demandeabonnement' } </label>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group mb-0">
                      <label class="control-label"> {l s='Recto de la CIN' mod='demandeabonnement' } *</label>
                      <input id="photocin1" required class="filestyle" data-buttonName="custum-file-buton"
                        data-buttonBefore="true" name="photocin1" type="file" data-placeholder=""
                        data-buttonText="{l s='Choisir un fichier' mod='demandeabonnement'}" />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group mb-0">
                      <label class="control-label">{l s='Verso de la CIN' mod='demandeabonnement' }
                        <sup>*</sup></label>
                      <input id="photocin2" class="filestyle" required data-buttonBefore="true"
                        data-buttonName="custum-file-buton" data-buttonBefore="true" name="photocin2" type="file"
                        data-placeholder="" data-buttonText="{l s='Choisir un fichier' mod='demandeabonnement'}">

                    </div>
                  </div>
                </div>

                <button class="btn btn-next mt-10 nextBtn pull-right" id="StepDA2"
                  type="button">{l s='Suivant' mod='demandeabonnement' }</button>
              </div>
            </div>

            <div class="row setup-content" id="step-3">
              <div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="row col  d-flex mt-30 flexrow">
                      <label class="control-label locControl">{l s='Résidence' mod='demandeabonnement' }<sup>*</sup></label>
                      <div class="form-check form-check-inline  mt-8">
                        <input class="form-check-input" type="radio" name="locataire" id="locataireOption1" value="false"
                          checked>
                        <label class="form-check-label"
                          for="locataireOption1">{l s='Locataire' mod='demandeabonnement' }</label>
                      </div>
                      <div class="form-check form-check-inline mt-8">
                        <input class="form-check-input" type="radio" name="locataire" id="locataireOption2" value="true">
                        <label class="form-check-label"
                          for="locataireOption2">{l s='Propriétaire' mod='demandeabonnement' }</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label">{l s='Gouvernerat' mod='demandeabonnement' }<sup>*</sup></label>
                      <input required name="gouvernoratid" class="form-control" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label"> {l s='Délégation' mod='demandeabonnement' }
                        <sup>*</sup></label>
                      <input name="villeid" required class="form-control" />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label class="control-label"> {l s='Localité' mod='demandeabonnement' }
                        <sup>*</sup></label>
                      <input name="codepostale" required class="form-control" />

                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label class="control-label"> {l s='Adresse' mod='demandeabonnement' } *</label>
                      <textarea name="adresse" type="text" rows="2" class="form-control" required
                        autocomplete="nope"></textarea>

                    </div>
                  </div>
                </div>


                <div class=" mb-15 ">
                  <div id="viewDiv"></div>
                </div>
                <div class="row col mt-10 mr-1  ">
                  <label class="font-size-16 col-auto font-weight-bold  ">
                    {l s='Veuillez indiquer votre position' mod='demandeabonnement' } </label>
                  <input name="codeadresse" type="text" class="postionxy form-control col pull-right" required />
                </div>
                <button class="btn btn-next  nextBtn pull-right" id="stepconfirm"
                  type="button">{l s='Suivant' mod='demandeabonnement' }</button>
              </div>
            </div>
            <div class="row setup-content" id="step-4">
              <div>
                <div class="row mx-0 my-3">
                  <label class="col-auto  font-size-20 font-weight-medium mr-50 custumlabel">
                    {l s='Forfait abonnement' mod='demandeabonnement'} </label>
                </div>
                <div class="row">
                  <label class="col  col-xxs-12 font-size-16 font-weight-medium ">{l s='Débit' mod='demandeabonnement' }:<span
                      id="debit"> </span></label>
                  <label
                    class="col  col-xxs-12 font-size-16 font-weight-medium ">{l s='Périodicité de facturation' mod='demandeabonnement' }:
                    <span id="period"> </span></label>
                </div>

                <div class="row mx-0 my-3">
                  <label
                    class="col-auto  font-size-20 font-weight-medium mr-50 custumlabel">{l s='Coordonnées' mod='demandeabonnement' }
                  </label>
                </div>

                <div class="row">
                  <label class="col col-xxs-12 font-size-16 font-weight-medium  ">
                    {l s='Nom' mod='demandeabonnement' }: <span id="nom"> </span></label>
                  <label class="col col-xxs-12 font-size-16 font-weight-medium  ">
                    {l s='Prénom' mod='demandeabonnement' }: <span id="prenom"> </span></label>
                </div>
                <div class="row">
                  <label
                    class="col  col-xxs-12 font-size-16 font-weight-medium  ">{l s='Identifiant' mod='demandeabonnement' }:
                    <span id="identifiant"> </span></label>
                  <label
                    class="col  col-xxs-12 font-size-16 font-weight-medium  ">{l s='N° téléphone' mod='demandeabonnement' }:
                    <span id="numtel"> </span></label>
                </div>

                <div class="row">
                  <label class="col  col-xxs-12 font-size-16 font-weight-medium  ">
                    {l s='Email' mod='demandeabonnement' }: <span id="email"></span></label>
                  <label class="col  col-xxs-12 font-size-16 font-weight-medium  ">
                    {l s='N° fixe' mod='demandeabonnement' }: <span id="numfixe"></span></label>
                </div>

                <div class="row my-3 mx-0 ">
                  <label class="col-auto  font-size-20 font-weight-medium mr-50 custumlabel">
                    {l s='Position' mod='demandeabonnement' } </label>
                </div>
                <div class="row">
                  <label class="col col-xxs-12 font-size-16 font-weight-medium">{l s='Résidence' mod='demandeabonnement' }:
                    <span id="residence"></span></label>
                  <label class="col col-xxs-12 font-size-16 font-weight-medium">{l s='Gouvernerat' mod='demandeabonnement' }:
                    <span id="gov"> </span></label>
                </div>
                <div class="row">
                  <label class="col col-xxs-12 font-size-16  font-weight-medium">{l s='Délégation' mod='demandeabonnement' }:
                    <span id="ville"> </span></label>
                  <label class="col col-xxs-12 font-size-16  font-weight-medium">{l s='Localité' mod='demandeabonnement' }:
                    <span id="codpostal"> </span></label>
                </div>

                <div class="row">
                  <label class="col font-size-16  font-weight-medium  "> {l s='Adresse' mod='demandeabonnement' }:
                    <span id="adr"> </span></label>
                </div>

                <input id="submit" name="submit" type="submit" value="Submit" class="hidden" />
                <div>

                  <div class="my-15 mr-10 d-flex align-items-center justify-content-end flex-wrap">
                    <canvas id="captcha" width="200" height="80"></canvas>

                    <input class="form-control" type="text" id="captcha-input" required
                      placeholder="{l s='Enter Captcha code' mod='demandeabonnement' }" />
                    <button type="button" class="  btn-icon" id="refresh-captcha"> <i class="fa fa-refresh mr-0"></i></button>
                  </div>
                  <div class="d-flex align-items-center justify-content-end  m-2">
                    <span id="captcha_error" class="has-error"></span>
                  </div>
                  <button id="confirmbtn" class="btn btn-next  nextBtn2 pull-right"
                    type="button">{l s='Confirmer' mod='demandeabonnement' }</button>
                </div>
              </div>
              <div class="mt-35">
                <div class="col codeverifciation py-4 ">
                  <div class="row">
                    <label class="col font-size-16 font-weight-bold">
                      {l s='Code de confirmation' mod='demandeabonnement' } </label>
                  </div>
                  <div class="row px-4 mb-5 form-group justify-content-end ">
                    <small
                      class="font-size-14 text-muted mt-8  ">{l s='Saisissez le code qui vous a été envoyé par SMS.' mod='demandeabonnement' }
                    </small>
                    <input name="codemobile" type="number" required length="6"
                      class="form-control mb-5 ml-auto  codesmsinput  px-2" />
                    <input id="submitDA" name="submitDA" class="btn  mb-5 ml-auto btn-next nextBtn ml-5" type="button"
                      value="{l s='Envoyer demande' mod='demandeabonnement' }" />
                  </div>
                  <div class="row m-2">
                    <span id="sms_error" class="has-error"> </span>
                  </div>
                  <div class="row m-2 w-100">
                    <u id="renvoyersms" class="d-none text-primary">{l s='Renvoyer le code' mod='demandeabonnement' }</u>
                  </div>
                </div>
              </div>
            </div>
          </form>

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
    var echec = '{l s='Echec' mod='demandeabonnement'}';
    var codeadresseError = '{l s="Veuillez cliquer sur votre emplacement sur la carte." mod='demandeabonnement' }';
    var formatInvalid = '{l s="Format invalide , Seuls les chiffres positifs sont acceptés" mod='demandeabonnement' }';
    var telFixeInvalid = '{l s="Invalid landline number" mod='demandeabonnement' }';
    var IdentifiantExist = '{l s="Identifiant déja utilisé" mod='demandeabonnement'}';
    var ValidFile = '{l s="Veuillez entrer un fichier valide: types autorisés ( image / pdf)" mod='demandeabonnement' }';
    var Letters = '{l s="Seuls les lettres et les chiffres  sont acceptés" mod='demandeabonnement'}';
    var MsgErrorCaptcha= '{l s="Invalid captcha code. Please try again." mod='demandeabonnement' }';
    var MsgError = '{l s="une erreur se produite" mod='demandeabonnement' }'
    var MsgExpire = '{l s="Code de vérification expiré" mod='demandeabonnement' }'
    var MsgInvalid = '{l s="Code de vérification invalide" mod='demandeabonnement' }'
    var MsgValid = '{l s="Code de vérification valide" mod='demandeabonnement' }'
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="/modules/demandeabonnement/views/js/arcgis/init.js"></script>
  <script src="/modules/demandeabonnement/views/js/arcGIS.js"></script>
  <script src="/modules/demandeabonnement/views/js/front.js"></script>
  <style>
    @media (max-width: 767px) {
      #header {
        margin-bottom: 0;
      }
    }
  </style>
{/block}