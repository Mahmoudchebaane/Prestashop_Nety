<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

// D:\xampp\htdocs\nety_project\config\config.inc.php
//require _PS_ADMIN_DIR_.'/../../config/config.inc.php';


class demandeabonnement extends Module
{

    public $vcaddonsinstance, $context;
    public function __construct()
    {
        // Settings
        $this->name = 'demandeabonnement';
        $this->tab = 'formulaire';
        $this->version = '1.0';
        $this->author = 'Berri Marwa';
        $this->need_instance = false;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Demande abonnement');
        $this->description = $this->l('Description demande abonnement.');
        $this->templateFile = 'module:demandeabonnement/views/templates/hook/demandeabonnement.tpl';
      

    }

    /**
     * install pre-config
     *
     * @return bool
     */
    public function sqlInstall()
    { 
        $query = ' CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'demandeabonnement` (
            `id_demande` int(10) unsigned NOT NULL AUTO_INCREMENT,            
            `identifiant` varchar(255) NULL,
            `type_identifiant` int(1) unsigned NOT NULL, 
            `createddate` datetime NOT NULL,  
            `modifieddate` datetime NULL,
            `first_name` varchar(255) NULL,
            `last_name` varchar(255) NULL,
            `photocin1` varchar(255) NULL,
            `photocin2` varchar(255) NULL, 
            `email` varchar(255) NULL,
            `telmobile` BIGINT NULL,      
            `locataire` bit NULL, 
            `hastelfixe` bit NULL,
            `telfixe` varchar(10) NULL,
            `periodpaiement_id` varchar(255) NULL,
            `categorieproduitid` BIGINT NULL, 
            `produitid` varchar(255) NULL,            
            `produitcrm` BIGINT NULL, 
            `userid` BIGINT NULL,
            `gouvernoratid` varchar(100) NULL,
            `villeid` varchar(100) NULL,
            `adresse` varchar(255) NULL,
            `codepostale` varchar(100) NULL,
            `positionx` varchar(255) NULL,
            `positiony` varchar(255) NULL,
            `codeadresse` varchar(255) NULL,
            `referencett` varchar(255) NULL,
            `referencechifco` varchar(255) NULL,     
            `ancien_client` int(10) unsigned  NULL,
            `isactive` bit NULL,
            `sendtocrm` bit NULL,
            `log_message` varchar(1000) NULL,
            `statutid` BIGINT NULL,
            `etattt`  varchar(255) NULL, 
            PRIMARY KEY (`id_demande`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

        if (Db::getInstance()->execute($query) == false) {
            return false;
        }

        return true;
    }

    /**
     * install pre-config
     *
     * @return bool
     */
    public function install()
    {
        // Hooks
        if (
            $this->sqlInstall()
            && parent::install()
            && $this->registerHook('displayTopHeader')
            && $this->registerHook('actionFrontControllerSetMedia')
            && $this->registerHook('displayBackOfficeHeader')
            && $this->installTab()
        ) {
            return true;
        }
        //return false;
    }

    /**
     * Uninstall module configuration
     *
     * @return bool
     */
    public function uninstall()
    {

        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'demandeabonnement`';
        if (Db::getInstance()->execute($sql) == false) {
            return false;
        }

        if (
            parent::uninstall() && $this->unregisterHook('displayTopHeader') &&
            $this->unregisterHook('actionFrontControllerSetMedia') && $this->uninstallTab()
        ) {
            return true;
        }

        return false;

    }
    public function installTab()
    {
        $tab = new Tab();
        $tab->class_name = 'AdminDemande';
        $tab->module = $this->name;
        $tab->id_parent = (int) Tab::getIdFromClassName('DEFAULT');
        $tab->icon = 'settings_applications';
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = $this->l('Demandes d\'abonnements');
        }
        try {
            $tab->save();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function uninstallTab()
    {
        $idTab = (int) Tab::getIdFromClassName('AdminDemande');

        if ($idTab) {
            $tab = new Tab($idTab);
            try {
                $tab->delete();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
        return true;

    }
    
    
    public function hookDisplayBackOfficeHeader()
    {

        // $this->context->controller->addJS($this->_path.'views/js/demandeabonnementBO.js');
    }



    public function hookActionFrontControllerSetMedia()
    {

        $this->context->controller->addJquery();

        $this->context->controller->registerJavascript(
            'demandeabonnement-validate-javascript',
            _PS_JS_DIR_ . 'jquery/plugins/jquery.validate.js',
            [
                'position' => 'bottom',
                'priority' => 999,
            ]
        );

        $this->context->controller->registerJavascript(
            'module-jscomposer-js',
            $this->_path . 'views/js/select2.js',
            [
                'position' => 'bottom',
                'priority' => 999,
            ]
        );
        $this->context->controller->registerJavascript(
            'demandeabonnement-select2_locale-javascript',
            _PS_JS_DIR_ . 'jquery/plugins/select2/select2_locale_' . $this->context->language->iso_code . '.js',
            [
                'position' => 'bottom',
                'priority' => 999,
            ]
        );

        $this->context->controller->registerJavascript(
            'demandeabonnement-validate-localization-javascript',
            _PS_JS_DIR_ . 'jquery/plugins/validate/localization/messages_' . $this->context->language->iso_code . '.js',
            [
                'position' => 'bottom',
                'priority' => 999,
            ]
        );


        $this->context->controller->registerStylesheet(
            'module-select2-bootstrap-style',
            'modules/jscomposer/assets/css/select2-bootstrap.css',
            [
                'media' => 'all',
                'priority' => 1000,
            ]
        );
        $this->context->controller->registerStylesheet(
            'module-select2-style',
            'modules/jscomposer/assets/css/select2.css',
            [
                'media' => 'all',
                'priority' => 1000,
            ]
        );

        $link = new Link;
        $parameters = array("action" => "getListVilleAction");
        $ajax_link = $link->getModuleLink('demandeabonnement', 'nouveau', $parameters);

        Media::addJsDef(
            array(
                "my_module_link_ajax" => $ajax_link,
                "map_lang" => $this->context->language->iso_code,
                "my_module_path" => $this->_path
            )
        );


    }


    public function hookdisplayTopHeader($params)
    {
        $btn_text = '1';
        $idbtn = 'DACommander'.$params['id_pack'];
        if ($params['id_pack'] == null) {
            $btn_text = '2';
            $idbtn = 'DAHeader';
        }

        $this->context->smarty->assign([
            'my_module_name' => Configuration::get('DEMANDE_NAME'),
            'btn_text' => $btn_text,
            'idbtn' => $idbtn,
            'my_module_link' => $this->context->link->getModuleLink('demandeabonnement', 'nouveau', ['id_product' => $params['id_pack']])
        ]);

        return $this->display(__FILE__, 'demandeabonnement.tpl');
    }

    public function getContent()
    {
        return 'tesgt';
    }






}