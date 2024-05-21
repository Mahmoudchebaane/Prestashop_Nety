<?php

if (!defined('_PS_VERSION_')) {
    exit;
}
 
class paiementfacture extends Module
{
    public $vcaddonsinstance, $context,$templateFile;
    public function __construct()
    {
        // Settings
        $this->name = 'paiementfacture';
        $this->tab = 'formulaire';
        $this->version = '1.0';
        $this->author = 'Sabrine Mabrouk';
        $this->need_instance = false;
        $this->bootstrap = true;
        parent::__construct(); 
        $this->displayName = $this->l('Paiement facture');  
        $this->description =  $this->l('Description paiement facture.'); 
        $this->templateFile = 'module:paiementfacture/views/templates/hook/paiementfacture.tpl';
    
    }

    
    /**
     * install db  pre-config
     *
     * @return bool
     */
    public function sqlInstall()
    {
        $query = ' CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'paiementfacture` (
            `order_number` int(10) unsigned NOT NULL AUTO_INCREMENT,    
            `order_id` varchar(255) NULL, 
            `factures` JSON  NOT NULL, 
            `ammount` decimal(20,6) NOT NULL, 
            `payment_type` varchar(255) NULL,
            `created_date` datetime NOT NULL,  
            `modified_date` datetime NULL, 
            `payment_state`  int(11) DEFAULT 0,
            `message` varchar(255) NULL, 
            `message_smt` varchar(1000) NULL, 
            `client` varchar(255) NULL,  
            `num_fixe` int(8) NULL,  
            `reference_crm` varchar(255) NULL,              
            `sendto_pay` int(11) DEFAULT 0,
            `sendto_crm` int(11) DEFAULT 0,
            PRIMARY KEY (`order_number`)
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
        if (
            $this->sqlInstall()
            && parent::install()
            && $this->registerHook('displayPaiementFacture') 
            && $this->registerHook('actionFrontControllerSetMedia')  
            && $this->registerHook('displayBackOfficeHeader')
            && $this->installTab()
        )  return true; 
        return false;          
    }

    /**
     * Uninstall module configuration
     *
     * @return bool
     */
    public function uninstall()
    {
        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'paiementfacture`';
        if (Db::getInstance()->execute($sql) == false) {
            return false;
        }
        if (
            parent::uninstall() && $this->unregisterHook('displayPaiementFacture') &&
            $this->unregisterHook('actionFrontControllerSetMedia') && $this->uninstallTab()
        ) {
            return true;
        }
        return false;
    }
    public function installTab()
    {
        $tab = new Tab();
        $tab->class_name = 'AdminPaiements';
        $tab->module = $this->name;
        $tab->id_parent = (int) Tab::getIdFromClassName('DEFAULT');
        $tab->icon = 'settings_applications';
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = $this->l('Paiements factures');
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
        $idTab = (int) Tab::getIdFromClassName('AdminPaiements');
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
    }


    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->addJquery();
        $this->context->controller->registerJavascript(
            'psgdpr',
            $this->_path.'views/js/sweetalert.min.js',
            [
                'position' => 'top',
                'priority' => 999,
            ]
        );      
        $this->context->controller->registerJavascript(
            'module-jscomposer-js',
            $this->_path.'views/js/select2.js',
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
        // $parameters = array("action" => "getListVilleAction");
        // $ajax_link = $link->getModuleLink('paiementfacture', 'nouveau', $parameters);        
        Media::addJsDef(
            array(
                // "my_module_link_ajax" => $ajax_link, 
                "map_lang"=> $this->context->language->iso_code ,
                "my_module_path"=> $this->_path
            )
        );       
    }


    public function hookdisplayPaiementFacture(){      
        $this->context->smarty->assign([
            'my_module_name' => Configuration::get('paiementfacture'), 
            'my_module_link' => $this->context->link->getModuleLink('paiementfacture', 'nouveau'  )
        ]);  
      return $this->display(__FILE__, 'paiementfacture.tpl');
    }

    public function getContent(){
        return 'tesgt';
    }     
}