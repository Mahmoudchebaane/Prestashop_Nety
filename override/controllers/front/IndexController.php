<?php
/**
 * Override IndexControllerCore
 */


class IndexController extends IndexControllerCore
{
    public $php_self = 'index';
    /**
     * Assign template vars related to page content.
     *
     * @see FrontController::initContent()
     */
    public function initContent()
    {  
        parent::initContent();
        $id_shop = (int) Context::getContext()->shop->id;
        if ($id_shop != NETY_SHOP && $id_shop != NETY_PRO) {
            Tools::redirect($this->context->link->getModuleLink('demandeabonnement', 'nouveau'));
        }
        
        $this->setTemplate('index');
    }

}