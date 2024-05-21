<?php

class AdminTabsController extends AdminTabsControllerCore {
 
 
    /**
     * Changement du mode d'accès pour pouvoir afficher l'onglet
     * @param string $action
     * @param bool $disable
     */
    public function access($action, $disable = false)
    {
        return Profile::getProfileAccess($this->context->employee->id_profile, Tab::getCurrentTabId());       
    }
 
}