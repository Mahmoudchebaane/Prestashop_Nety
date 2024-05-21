<?php
/**
 * This file provides the Smartarget Reviews module for PrestaShop.
 *
 * @author Smartarget
 * @copyright Smartarget 2023
 * @license MIT
 */
class AdminSmartargetReviewsController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true, [], ['configure' => 'smartargetreviews']));
    }
}
