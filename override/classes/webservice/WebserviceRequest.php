<?php
require_once(_PS_MODULE_DIR_ . 'Paiementfacture\classes\PaiementFactureClass.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\regitserDemande.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\crm_gouvernorats.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\crm_villes.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\crm_postal_code.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\facturesAPI.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\Login.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\identifier.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\Signout.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\otp.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\contratCRM.php');
require_once(_PS_ROOT_DIR_ . '\override\classes\api\internetOffers.php');
// include_once _PS_MODULE_DIR_.'customWebServic\classes\CustomWebService';
class WebserviceRequest extends WebserviceRequestCore
{

    public static function getResources()
    {
        $resources = parent::getResources();
        $resources['login'] = array('description' => 'Authentication', 'class' => 'Login','forbidden_method' => ['PUT','GET','DELETE']);
        $resources['logout'] = array('description' => 'Customer log out', 'class' => 'Signout','forbidden_method' => ['PUT','GET','DELETE']);
        $resources['otp_code'] = array('description' => 'Otp code', 'class' => 'Otp','forbidden_method' => ['PUT',  'DELETE']);
        $resources['demande_abonnement'] = array('description' => 'save demande abonnement', 'class' => 'RegisterDemande','forbidden_method' => ['GET','PUT',  'DELETE']);
        $resources['govs'] = array('description' => 'Liste des gouvernerats', 'class' => 'crm_gouvernorats', 'forbidden_method' => ['PUT', 'POST', 'DELETE']);
        $resources['villes'] = array('description' => 'Liste des villes', 'class' => 'crm_villes', 'forbidden_method' => ['PUT', 'POST', 'DELETE']);
        $resources['code_postaux'] = array('description' => 'Liste des code postaux', 'class' => 'crm_postal_code', 'forbidden_method' => ['PUT', 'POST', 'DELETE']);
        $resources['contratCRM'] = array('description' => 'Liste des contrats', 'class' => 'contratCRM', 'forbidden_method' => ['PUT', 'POST', 'DELETE']);
        // $resources['paiement_facture'] = array('description' => 'Paiement factures', 'class' => 'PaiementFactureClass', 'forbidden_method' => ['PUT', 'DELETE']);
        $resources['factures'] = array('description' => ' factures', 'class' => 'facturesAPI', 'forbidden_method' => ['PUT', 'DELETE']);
        $resources['identifier'] = array('description' => ' test identifiant', 'class' => 'demandeIdentifier', 'forbidden_method' => ['PUT', 'DELETE']);
        $resources['internetOffers'] = array('description' => 'Liste des offres internets', 'class' => 'InternetOffers', 'forbidden_method' => ['PUT', 'DELETE']);
        $mp_resource = Hook::exec('addWebserviceResources', array('resources' => $resources), null, true, false);

        if (is_array($mp_resource) && count($mp_resource)) {
            foreach ($mp_resource as $new_resources) {
                if (is_array($new_resources) && count($new_resources)) {
                    $resources = array_merge($resources, $new_resources);
                }
            }
        }
        // dump($resources);die;
        ksort($resources);
        return $resources;
    }


    protected function saveEntityFromXml($successReturnCode)
    {
        $array = json_decode($this->_inputXml, true);
        // Create SimpleXML object
        $xml = new SimpleXMLElement('<root/>');
       
        // Function to convert array to XML
        function arrayToXml($array, $xml)
        {
            foreach ($array as $key => $value) {

                if (is_array($value)) {
                    $subnode = $xml->addChild($key);
                    arrayToXml($value, $subnode);
                } else {
                    $xml->addChild($key, htmlspecialchars($value));
                }
            }
            return $xml;
        }

        // Call the function to convert array to XML
        arrayToXml($array, $xml);

        // Return formatted XML string


        $this->_inputXml = $xml->asXML();

        parent::saveEntityFromXml($successReturnCode);
    }

}