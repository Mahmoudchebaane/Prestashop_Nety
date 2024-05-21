<?php
/**
 * BINSHOPS
 *
 * @author BINSHOPS
 * @copyright BINSHOPS
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * Best In Shops eCommerce Solutions Inc.
 *
 */

require_once dirname(__FILE__) . '/../AbstractRESTController.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;

use PrestaShop\PrestaShop\Core\Security\PasswordPolicyConfiguration;
use ZxcvbnPhp\Zxcvbn;

require_once _PS_MODULE_DIR_ . 'demandeabonnement/classes/demandeAbonnementClass.php';

class BinshopsrestdemandeabonnementModuleFrontController extends AbstractRESTController
{
    protected function processPostRequest()
    {
        $_POST = json_decode(Tools::file_get_contents('php://input'), true);
        // dump($_REQUEST, (int) $_REQUEST['type_identifiant']);die;

        $psdata = null;
        $message = "success";
        $hasError = false;
        $messageCode = 0;
        $success = true;
        $newDemande = new demandeAbonnementClass();
        $source = 'demandeabonnementwebsite@nety.tn';
        $type_identifiant = (int) $_REQUEST['type_identifiant'];
        $identifiant = $_REQUEST['identifiant'];
        $produitid = $_REQUEST['offre'];
        $periodpaiement_id = $_REQUEST['periodpaiement_id'];
        $hastelfixe = (bool) $_REQUEST['hastelfixe'];
        $telfixe = ($_REQUEST['telfixe'] > 0) ? $_REQUEST['telfixe'] : null;
        $last_name = $_REQUEST['last_name'];
        $first_name = $_REQUEST['first_name'];
        $locataire = $_REQUEST['locataire'];
        $gouvernoratid = $_REQUEST['gouvernoratid'];
        $villeid = $_REQUEST['villeid'];
        $codepostale = $_REQUEST['codepostale'];
        $adresse = $_REQUEST['adresse'];
        $codeadresse = $_REQUEST['codeadresse'];
        $email = $_REQUEST['email'];
        $telmobile = $_REQUEST['telmobile'];
        $file_photocin1 = Tools::fileAttachment('photocin1');
        $file_photocin2 = Tools::fileAttachment('photocin2');

        if (!$first_name) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('First name is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$last_name) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Last name is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$type_identifiant) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Identifier type is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$identifiant) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Identifier is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$email) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Email adress is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$telmobile) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Phone is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$gouvernoratid) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Gov is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$villeid) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('City is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$codepostale) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Zip code is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$periodpaiement_id) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Periodicity is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$locataire) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Residence is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$produitid) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('offer reference is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$adresse) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Address is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$codeadresse) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('XY position is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$file_photocin1) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('CIN recto is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$file_photocin1) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('CIN verso is missing', [], 'Modules.Binshopsrest.Account');
        } elseif (!$hastelfixe) {
            $success = false;
            $messageCode = 200;
            $message = $this->trans('Customer has a landline number or not!!?', [], 'Modules.Binshopsrest.Account');
        } else {
            $now = new DateTime();
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
            $newDemande->type_identifiant = (int) $_REQUEST['type_identifiant'];
            $newDemande->identifiant = $_REQUEST['identifiant'];
            $newDemande->produitid = $_REQUEST['offre'];
            $newDemande->periodpaiement_id = $_REQUEST['periodpaiement_id'];
            $newDemande->hastelfixe = (bool) $_REQUEST['hastelfixe'];
            $newDemande->telfixe = ($_REQUEST['telfixe'] > 0) ? $_REQUEST['telfixe'] : null;
            $newDemande->last_name = $_REQUEST['last_name'];
            $newDemande->first_name = $_REQUEST['first_name'];
            $newDemande->locataire = $_REQUEST['locataire'];
            $newDemande->gouvernoratid = $_REQUEST['gouvernoratid'];
            $newDemande->villeid = $_REQUEST['villeid'];
            $newDemande->codepostale = $_REQUEST['codepostale'];
            $newDemande->adresse = $_REQUEST['adresse'];
            $newDemande->codeadresse = $_REQUEST['codeadresse'];
            $newDemande->email = $_REQUEST['email'];
            $newDemande->telmobile = $_REQUEST['telmobile'];



            try {
                $client = new Client();
                $options = [
                    'body' => [
                        'prenom' => $newDemande->first_name,
                        'nom' => $newDemande->last_name,
                        'cin' => $newDemande->identifiant,
                        'email' => $newDemande->email,
                        'tel' => $newDemande->telmobile,
                        'ville' => (int)$newDemande->villeid,
                        'gouvernorat' => $newDemande->gouvernoratid,
                        'adresse' => $newDemande->adresse,
                        'codePostale' => (int)$newDemande->codepostale,
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
                $response = $client->post(LINK_CRM . '/api/adddemandeabonnement', $options);
                if ($response->getStatusCode() == 200) {
                    
                    $newDemande->sendtocrm = true;
                    $newDemande->log_message = 'Envoyée CRM ';
                    $newDemande->save();
                    $success = true;
                    $messageCode = 200;
                    $message = $this->trans('Subscription request sent successfully', [], 'Modules.Binshopsrest.Account');
                } else {
                    $newDemande->sendtocrm = false;
                    $newDemande->log_message = 'Erreur envoie CRM ' . $response->getStatusCode();
                    $newDemande->save();
                    $success = false;
                    $messageCode = 404;
                    $message = $this->trans('Error sending to CRM', [], 'Modules.Binshopsrest.Account');
                }

            } catch (Exception $e) {
                $newDemande->sendtocrm = false;
                $newDemande->log_message = 'Erreur API CRM ' . $e->getMessage();
                $newDemande->save();
                $success = false;
                $messageCode = 404;
                $message = $this->trans('Error API CRM', [], 'Modules.Binshopsrest.Account');
            }
        }
        $this->ajaxRender(json_encode([
            'success' => $success,
            'code' => $messageCode,
            'psdata' => $psdata,
            'message' => $message
        ]));
        die;
    }
}
