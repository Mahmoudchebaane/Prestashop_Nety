 <div class=" row">

   <div class="panel block_abonnement col-12">
     <div class=" row">
       <b class="col-md-6">{l s='Date création' mod='demandeabonnement'} :</b> <span
         class="col-md-6">{$data.createddate}</span>
     </div> 

     <div class="row">
       <div class="col-md-12">
         <h3 class="mt-3">{l s='Détails demande abonnement' mod='demandeabonnement'}</h3>
       </div>
     </div>

     <div class="row">
       <div class="col-md-6">
         <b class="col-md-6">{l s='Prénom' mod='demandeabonnement'} :</b> <span
           class="col-md-6">{$data.first_name}</span>
       </div>
       <div class="col-md-6">
         <b class="col-md-6">{l s='Nom' mod='demandeabonnement'} :</b> <span class="col-md-6">{$data.last_name}</span>
       </div>
     </div>

     <div class="row">
       <div class="col-md-6">
         <b class="col-md-6">{l s='N° C.I.N / Carte Séjour' mod='demandeabonnement'} :</b> <span
           class="col-md-6">{$data.identifiant}</span>
       </div>
       <div class="col-md-6">
         <b class="col-md-6">{l s='Contact' mod='demandeabonnement'} :</b> <span
           class="col-md-6">{$data.telmobile}</span>
       </div>
     </div>
     <div class="row">

       <div class="col-md-6">
         <b class="col-md-6">{l s='Adresse Email' mod='demandeabonnement'} :</b><span class="col-md-6">
           {$data.email}</span>
       </div>
       <div class="col-md-6">
         <b class="col-md-6">{l s='Adresse' mod='demandeabonnement'} :</b> <span class="col-md-6">{$data.adresse}</span>
       </div>
     </div>
     <div class="row">
       <div class="col-md-6">
         <b class="col-md-6">{l s='Coordonnée Map ' mod='demandeabonnement'} :</b> <span class="col-md-6">{$data.codeadresse}</span>
       </div>
       <div class="col-md-6">
         <b class="col-md-6">{l s='Gouvernorat' mod='demandeabonnement'} :</b> <span
           class="col-md-6">{$data.gouvernoratid}</span>
         <b class="col-md-6">{l s='Ville' mod='demandeabonnement'} :</b> <span class="col-md-6">{$data.villeid}</span>
         <b class="col-md-6">{l s='Code Postal' mod='demandeabonnement'} :</b> <span
           class="col-md-6">{$data.codepostale}</span>
       </div>
     </div>

     <div class="row">
       <div class="col-md-12">
         {* <h3>{l s='Les carte d\'identité nationale (CIN)' mod='demandeabonnement'}</h3> *}
       </div>
     </div>
     <div class="row">
       {if $data.photocin1 != '' }
         <div class="col-md-6">
           <b>{l s='Recto de la CIN' mod='demandeabonnement'} :</b> <img src="/upload/{$data.photocin1}"
             alt="{$data.photocin1}" width="150" />
         </div>
       {/if}
       {if $data.photocin2 != '' }
         <div class="col-md-6">
           <b>{l s='Verso de la CIN' mod='demandeabonnement'} :</b> <img src="/upload/{$data.photocin2}" width="150"
             alt="{$data.photocin2}" />
         </div>
       {/if}
     </div>



     <div class="form-group row">
       <div class="col-md-12">
         {* <h3>{l s='Forfait Abonnement' mod='demandeabonnement'}</h3> *}
       </div>
     </div>

     <div class="row mb-3">
       <div class="col-md-6">
         <b class="col-md-6">{l s='N° Tél. Fixe' mod='demandeabonnement'} :</b> <span
           class="col-md-6">{if $data.telfixe }{$data.telfixe} {/if}</span>
       </div>
     </div>
     <div class="row  mb-3 justify-content-evenly">
       <div class="col-md-6">
         <b class="col-md-6">{l s='Forfait' mod='demandeabonnement'} :</b>
         <span class="col-md-6"> {$data.produitid} </span>
       </div>
     </div>


     <div class="row">
       <div class="col-md-6">
       <b class="col-md-6">{l s='Périodicité Facturation ' mod='demandeabonnement'} :</b>
         <span class="col-md-6">  
           {if $data.periodpaiement_id == 'ref_1mois' }
             Mensuel
           {elseif $data.periodpaiement_id == 'ref_3mois'}
             Trimestriel
           {elseif $data.periodpaiement_id =='ref_6mois'}
             Semestriel
           {elseif $data.periodpaiement_id == 'ref_1an'}
             Annuel
           {/if}
         </span>
       </div>


     </div>
</div>