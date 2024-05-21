<?php
class Dispatcher extends DispatcherCore {
  public function __construct(){
 
    $this->default_routes['route-factures-crm'] = [
      'controller' => 'facturesCRM', // will be linked to PastaController (see next section)
      'rule' => 'factures-CRM', //  the actual URL without trailing slash
      'keywords' => [], 
    ];

    $this->default_routes['route-contrats-crm'] = [
      'controller' => 'contratsCRM', 
      'rule' => 'Contrats-CRM', 
      'keywords' => [], 
    ];
    // $this->default_routes['route-b2b-pro'] = [
    //   'controller' => 'b2bPRO', 
    //   'rule' => 'B2b-PRO', 
    //   'keywords' => [], 
    // ];
    
  

    parent::__construct();
  }
}