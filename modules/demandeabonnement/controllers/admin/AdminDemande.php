<?php 
require_once _PS_MODULE_DIR_ . 'demandeabonnement/classes/demandeAbonnementClass.php';
    class AdminDemandeController extends ModuleAdminController {

        
            public function __construct()
            {
                $this->table = 'demandeabonnement';  
                $this->_orderWay = 'DESC'; 
                $this->className = 'demandeAbonnementClass';
                $this->identifier = demandeAbonnementClass::$definition['primary'];
                $this->bootstrap = true;
                $this->display = 'list'; 
                $this->show_toolbar =true ;
                $this->show_toolbar_options =true ;
                
                $this->fields_list = [
                    'type_identifiant' => [
                        'title' => 'Type Identifiant',
                        'align' => 'left'
                    ],
                    'identifiant' => [
                        'title' => 'Identifiant',
                        'align' => 'left'
                    ],
                    'createddate' => [
                        'title' => 'Date Création',
                        'align' => 'left'
                    ],
                    'last_name' => [
                        'title' => 'Nom',
                        'align' => 'left'
                    ],
                    'first_name' => [
                        'title' => 'Prénom',
                        'align' => 'left'
                    ],
                    'telmobile' => [
                        'title' => 'Prénom',
                        'align' => 'left'
                    ] ,                    
                    'adresse' => [
                        'title' => 'Adresse',
                        'align' => 'left'
                    ],                    
                    'sendtocrm' => [
                        'title' => 'Envoyée CRM',
                        'align' => 'left'
                    ] ,                    
                    'log_message' => [
                        'title' => 'Log Message',
                        'align' => 'left'
                    ] 

                ];
  
                $this->addRowAction('view'); 
                   parent::__construct();
               }

               public function initToolbar()
               {
                    $this->toolbar_btn = array();

                    $this->toolbar_btn['export'] = [
                        'href' => self::$currentIndex . '&export' . $this->table . '&token=' . $this->token,
                        'desc' => $this->trans('Export', [], 'Admin.Actions'),
                    ];
 
               }
 
 
                public function renderView()
                {
                    $tplFile = dirname(__FILE__).'/../../views/templates/admin/view.tpl';
                    $tpl = $this->context->smarty->createTemplate($tplFile);
                    $sql = new DbQuery();
                    $sql->select('*')
                        ->from($this->table)
                        ->where('id_demande = '. Tools::getValue('id_demande'));
                    $data = Db::getInstance()->executeS($sql);  
                    $tpl->assign([
                        'data' => $data[0]
                    ]);
                    return $tpl->fetch();
                }
    }
?>