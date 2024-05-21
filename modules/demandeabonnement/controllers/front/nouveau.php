<?php
require_once _PS_MODULE_DIR_ . 'demandeabonnement/classes/demandeAbonnementClass.php';
use GuzzleHttp\Client;
use PrestaShop\CircuitBreaker\Client\GuzzleClient;
use GuzzleHttp\Psr7\Utils;
class demandeabonnementnouveauModuleFrontController extends ModuleFrontController
{


    public function __construct()
    {     
        parent::__construct();
        $this->context = Context::getContext();
        Media::addJsDef([
            'my_ajax_url' => $this->context->link->getModuleLink('demandeabonnement', 'nouveau')
        ]);
        // $this->loadTranslations();
    }


    public function initContent()
    {
     
        // 1 -> nety
        // 2 -> jawhra
        // 3 -> diwan 
        // 5 -> CSS
        $id_shop = $this->context->shop->id;
        // $source = 'demandeabonnementwebsite@nety.tn';
        switch ($id_shop) {
            case NETY_SHOP:
                $source = 'demandeabonnementwebsite@nety.tn';
                $template = 'module:demandeabonnement/views/templates/front/formulaireDA.tpl';
         
                break;
            case JAWHRA_ABON:
                $source = 'demandeabonnementjawhara@nety.tn';
            $template = 'module:demandeabonnement/views/templates/front/jawharaDA.tpl';
   

                break;
            case DIWAN_ABON:
                $source = 'diwanwebsite@nety.tn';
                $template = 'module:demandeabonnement/views/templates/front/diwanDA.tpl';
                break;
                //case 9:
            case CSS_ABON:
                $source = 'csswebsite@nety.tn';
                $template = 'module:demandeabonnement/views/templates/front/cssDA.tpl';
                break;
            default:
            $source = 'demandeabonnementwebsite@nety.tn';
            $template = 'module:demandeabonnement/views/templates/front/formulaireDA.tpl';
                break;
        }      
        

        if (Tools::isSubmit('submit')) {
            parent::postProcess();
            if (!count($this->errors)) {
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
                $newDemande->type_identifiant = Tools::getValue('type_identifiant');
                $newDemande->identifiant = Tools::getValue('identifiant');
                $newDemande->produitid = Tools::getValue('produitid');
                $newDemande->periodpaiement_id = Tools::getValue('periodpaiement_id');
                $newDemande->hastelfixe = Tools::getValue('hastelfixe');
                $newDemande->telfixe = (Tools::getValue('telfixe') > 0) ? Tools::getValue('telfixe') : null;
                $newDemande->last_name = Tools::getValue('last_name');
                $newDemande->first_name = Tools::getValue('first_name');
                $newDemande->locataire = Tools::getValue('locataire');
                $newDemande->gouvernoratid = Tools::getValue('gouvernoratid');
                $newDemande->villeid = Tools::getValue('villeid');
                $newDemande->codepostale = Tools::getValue('codepostale');
                $newDemande->adresse = Tools::getValue('adresse');
                $newDemande->codeadresse = Tools::getValue('codeadresse');
                $newDemande->email = Tools::getValue('email');
                $newDemande->telmobile = Tools::getValue('telmobile');
                $newDemande->save();
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
                        $newDemande->log_message = 'Envoyée CRM ';
                        $newDemande->save();
                        $this->context->controller->success[] = $this->l(
                            'Nous vous informons que votre demande d’abonnement est en cours de traitement',
                            [],
                            'Modules.demandeabonnement.Shop'
                        );
                        $this->redirectWithNotifications($this->getCurrentURL());
                    } else {
                        $newDemande->sendtocrm = false;
                        $newDemande->log_message = 'Erreur envoie CRM ' . $response->getStatusCode();
                        $newDemande->save();
                    }

                } catch (Exception $e) {
                    $newDemande->sendtocrm = false;
                    $newDemande->log_message = 'Erreur API CRM ' . $e->getMessage();
                    $newDemande->save();
                    $this->errors[] = 'Une erreur systeme se produite';
                }
            }
            $this->redirectWithNotifications($this->getCurrentURL());
        }

        parent::initContent();
        $value = "good";
        $id_product = Tools::getValue("id_product");

        $getIdcategory = 4;
        $category = new Category($getIdcategory);

        $subcategory_objects = [];

        if ($subCategories = $category->getSubCategories($this->context->language->id)) {

            foreach ($subCategories as $subcategory) {

                $subcategory_objects = array_merge($subcategory_objects, vccontentanywhere::getProductsByCategoryID((int) $subcategory['id_category']));
            }
        }

        $data = array_reverse($subcategory_objects, true);
        $listgouvernerat = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `crm_gouvernorats`');
        Media::addJsDef([
            'listgouvernerat' => $listgouvernerat,
        ]);
        $this->context->smarty->assign([
            'id_product' => $id_product,
            'module_dir' => _MODULE_DIR_ . '/demandeabonnement/',
            'catproducts' => $data
        ]);          
        $this->setTemplate($template);
        
    }

    public function displayAjaxGetVille()
    {
        $villesList = [];
        $idgov = Tools::getValue('idgov');
        if (!$idgov) {
            return $villesList;
        }
        $listvilles = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `crm_villes` WHERE `gouvernorat_id` =' . $idgov);
        return $this->ajaxRender(json_encode($listvilles, 1));
    }

    public function displayAjaxGetCodePostal()
    {
        $codeslist = [];
        $abrev_ville = Tools::getValue('abrev_ville');
        if (!$abrev_ville) {
            return $codeslist;
        }
        $idville = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT `ville_id` FROM `crm_villes` WHERE `abreviation` LIKE "' . $abrev_ville . '"');

        $codeslist = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `crm_postal_code`   WHERE `ville_id` =' . $idville);
        return $this->ajaxRender(json_encode($codeslist, 1));
    }


    public function displayAjaxGetCode()
    {
        $tel = Tools::getValue('numtel');
        if ($tel) {
            $this->context->cookie->__set('tel', $tel);
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json'
            ];
            $body = '{
            "phoneNb": "' . $tel . '",
            "otpValidity": 1500,
            "otpToken": "6271608B-9C06-4EDC-9ED9-E245928A11B1",
            "message": "Demande d\'abonnement Nety : code de confirmation",
            "source": "Nety"
            }';
            $request = $client->createRequest('POST', 'https://smsingotp.chifco.com/api/Contact/SENDOTP', ['headers' => $headers, 'body' => $body]);
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);
                $check = false;
                if (!array_key_exists('error', $successresponse)) {
                    //  time();      // 1660338149  1676388556789  timestamp 
                    $this->context->cookie->__set('code', $successresponse['otpCode']);
                    $this->context->cookie->__set('expire', $successresponse['expiryDate']);
                    $this->context->cookie->write();
                    $check = true;
                }
                $this->ajaxRender(
                    json_encode([
                        'success' => $check,
                        'data' => $response->getStatusCode(),
                    ])
                );
            } else {

                $this->ajaxRender(
                    json_encode([
                        'success' => false,
                        'data' => $response->getStatusCode(),
                    ])
                );
            }
        }
        $this->ajaxRender(
            json_encode([
                'success' => false,
                'data' => "",
            ])
        );

    }

    public function displayAjaxCheckCode()
    {
        $tel = Tools::getValue('numtel');
        $codesms = Tools::getValue('codesms');
        $check = false;
        $message = 1;
        if ($codesms && $tel && $this->context->cookie->__isset('tel') && $this->context->cookie->__isset('code') && $this->context->cookie->__isset('expire')) {
            if ($tel == $this->context->cookie->__get('tel')) {
                if ($codesms == $this->context->cookie->__get('code')) {
                    $expire = (int) ($this->context->cookie->__get('expire'));
                    $curtime = new DateTimeImmutable();
                    $now = (int) $curtime->format('Uv');
                    if (($now - $expire) < 0) {
                        $check = true;
                        $message = 2;
                    } else {
                        $message = 3;
                    }
                } else {
                    $message = 4;
                }
            }
            $this->ajaxRender(
                json_encode([
                    'success' => $check,
                    'message' => $message,
                ])
            );
        }
    }


    public function displayAjaxCheckExist()
    {
        $identif = (string) Tools::getValue('identifiant');
        $client = new Client();
        $optionsexist = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'body' => [
                'cin' => $identif,
            ]
        ];
        try {
            $request = $client->createRequest('POST',LINK_CRM . '/api/verificationexistancecin', $optionsexist);
           
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);
                $check = false;
                if (!array_key_exists('error', $successresponse)) {
                    $check = true;
                }
                $this->ajaxRender(
                    json_encode([
                        'success' => $check,
                        'data' => $successresponse,
                    ])
                );
            } else {
                $this->ajaxRender(
                    json_encode([
                        'success' => false,
                        'data' => $response->getStatusCode(),
                    ])
                );
            }
        } catch (Exception $e) {

            $this->ajaxRender(
                json_encode([
                    'success' => false,
                    'data' => $e->getMessage(),
                ])
            );
        }
    }


    
}