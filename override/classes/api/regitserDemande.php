<?php
require_once(_PS_MODULE_DIR_ . '/demandeabonnement/classes/DemandeAbonnementClass.php');
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
class RegisterDemande extends demandeAbonnementClass
{
   
    protected $webserviceParameters = [
        'objectMethods' => [
            'add' => 'registerSubscription'
        ]
    ];
   

    public function registerDemande($autodate = true, $null_values = false)
    {
        
        $logger = new FileLogger();
        $filePath = _PS_ROOT_DIR_ . '/var/logs/' . _PS_ENV_ . '_demande.log';
        $logger->setFilename($filePath);
        $newDemande = new demandeAbonnementClass(); 
        $logger->logInfo('mobile app subscription request');
        $file_photocin1 = Tools::fileAttachment('photocin1');
        $file_photocin2 = Tools::fileAttachment('photocin2');
        $now = new DateTime();
        $newDemande = new demandeAbonnementClass();
        $testFileUpload = (isset($file_photocin1['rename']) && !empty($file_photocin1['rename']));
        if ($testFileUpload && rename($file_photocin1['tmp_name'], _PS_UPLOAD_DIR_ . basename($file_photocin1['rename']))) {
            $newDemande->photocin1 = $file_photocin1['rename'];
            @chmod(_PS_UPLOAD_DIR_ . basename($file_photocin1['rename']), 0664);
        }
        $testFileUpload1 = (isset($file_photocin2['rename']) && !empty($file_photocin2['rename']));
        if ($testFileUpload1 && rename($file_photocin2['tmp_name'], _PS_UPLOAD_DIR_ . basename($file_photocin2['rename']))) {
            $newDemande->photocin2 = $file_photocin2['rename'];
            @chmod(_PS_UPLOAD_DIR_ . basename($file_photocin2['rename']), 0664);
        }
        $newDemande->createddate = $now->format('Y-m-d H:i:s');
        $newDemande->modifieddate = $now->format('Y-m-d H:i:s');
        $newDemande->type_identifiant = $_POST('type_identifiant');
        $newDemande->identifiant = $_POST('identifiant');
        $newDemande->produitid = $_POST('produitid');
        $newDemande->periodpaiement_id = $_POST('periodpaiement_id');
        $newDemande->hastelfixe = $_POST('hastelfixe');
        $newDemande->telfixe = ($_POST('telfixe') > 0) ? $_POST('telfixe') : null;
        $newDemande->last_name = $_POST('last_name');
        $newDemande->first_name = $_POST('first_name');
        $newDemande->locataire = $_POST('locataire');
        $newDemande->gouvernoratid = $_POST('gouvernoratid');
        $newDemande->villeid = $_POST('villeid');
        $newDemande->codepostale = $_POST('codepostale');
        $newDemande->adresse = $_POST('adresse');
        $newDemande->codeadresse = $_POST('codeadresse');
        $newDemande->email = $_POST('email');
        $newDemande->telmobile = $_POST('telmobile');
        $newDemande->save();
        $source = 'demandeabonnementwebsite@nety.tn';
        $client = new Client();
        $options = [
            'body' => [
                'prenom' => $newDemande->first_name,
                'nom' => $newDemande->last_name,
                'cin' => $newDemande->identifiant,
                'email' => $newDemande->email,
                'tel' => $newDemande->telmobile,
                'ville' => $newDemande->villeid,
                'gouvernorat' => $newDemande->gouvernoratid,
                'adresse' => $newDemande->adresse,
                'codePostale' => $newDemande->codepostale,
                'paiement' => $newDemande->periodpaiement_id,
                'residence' => $newDemande->locataire,
                'produit' => $newDemande->produitid,
                'cinRecto' => Utils::tryFopen(_PS_UPLOAD_DIR_ . $newDemande->photocin1, 'r'),
                'cinVerso' => Utils::tryFopen(_PS_UPLOAD_DIR_ . $newDemande->photocin2, 'r'),
                'positionxy' => $newDemande->codeadresse,
                'telfixe' => $newDemande->telfixe,
                'website' => $source
            ],
        ];
        try {
            $response = $client->post(LINK_CRM . '/api/adddemandeabonnement', $options);
            if ($response->getStatusCode() == 200) {
                $newDemande->sendtocrm = true;
                $logger->logInfo( 'Envoyée CRM');
                $newDemande->save();
                echo json_encode([
                    "success" => true,
                    "message" => $this->trans(
                        'Nous vous informons que votre demande d’abonnement est en cours de traitement',
                        [],
                        'Modules.demandeabonnement.Shop'
                    )
                ]);
            } else {
                $newDemande->sendtocrm = false;
                $logger->logInfo('Erreur envoie CRM ' . $response->getStatusCode());
                $newDemande->save();
                echo json_encode([
                    "success" => false,
                    "message" => 'Error sending to crm'
                ]);
            }

        } catch (Exception $e) {
            $newDemande->sendtocrm = false;
            $logger->logInfo( 'Erreur API CRM ' . $e->getMessage());
            $newDemande->save();
            $this->errors[] = 'Une erreur systeme se produite';
            echo json_encode([
                "success" => false,
                "message" => 'Une erreur systeme se produite'
            ]);
        }

    }
}