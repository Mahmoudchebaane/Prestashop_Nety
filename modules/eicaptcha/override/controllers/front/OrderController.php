<?php

// class OrderController extends OrderControllerCore
// {
//     public function postProcess()
//     {

//         dump('fff');die;
//         if (
//             Tools::isSubmit('submitCreate')
//             && Module::isInstalled('eicaptcha')
//             && Module::isEnabled('eicaptcha')
//             && false === Module::getInstanceByName('eicaptcha')->hookActionCustomerRegisterSubmitCaptcha([])
//             && !empty($this->errors)
//         ) {
//             unset($_POST['submitCreate']);
//         }
//         parent::postProcess();
//     }
// }
