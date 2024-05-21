<?php
class OrderController extends OrderControllerCore
{
    /*
    * module: eicaptcha
    * date: 2023-04-27 14:34:09
    * version: 2.4.2
    */
   
    public function postProcess()
    {
        if (
            Tools::isSubmit('submitCreate')
            && Module::isInstalled('eicaptcha')
            && Module::isEnabled('eicaptcha')
            && false === Module::getInstanceByName('eicaptcha')->hookActionCustomerRegisterSubmitCaptcha([])
            && !empty($this->errors)
        ) {
            unset($_POST['submitCreate']);
        }
        parent::postProcess();
    }

}
