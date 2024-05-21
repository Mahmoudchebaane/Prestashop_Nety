<?php
 

if (!defined('_PS_VERSION_')) {
    exit;
}
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
 

class CustomContactUs extends  Module  implements WidgetInterface  
{
    
     /** @var string */
     const SEND_CONFIRMATION_EMAIL = 'CONTACTFORM_SEND_CONFIRMATION_EMAIL';

     /** @var string */
     const SEND_NOTIFICATION_EMAIL = 'CONTACTFORM_SEND_NOTIFICATION_EMAIL';
 
     /** @var string */
     const MESSAGE_PLACEHOLDER_FOR_OLDER_VERSION = '(hidden)';
 
     /** @var string */
     const SUBMIT_NAME = 'update-configuration';
 
     /** @var Contact */
     protected $contact;
 
     /** @var CustomerThread */
     protected $customer_thread;
   private $templateFile;
    public function __construct()
    {
        $this->name = 'customcontactus'; 
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'Fatima Bouzidi';
        $this->need_instance = 0;
       // $this->ps_versions_compliancy = array('min' => '1.7.1', 'max' => _PS_VERSION_);
        $this->bootstrap = true; 
        parent::__construct();
        
        // $this->displayName = $this->trans('Custom contact form', [], 'Modules.customcontactus.Admin');
        // $this->description = $this->trans(
        //     'Adds a Custom contact form to the "Contact us" page.',
        //     [],
        //     'Modules.customcontactus.Admin'
        // );
        $this->displayName = $this->l('Custom contact form');
        $this->description = $this->l( 'Adds a Custom contact form to the "Contact us" page.');

       // $this->templateFile = "module:customcontactus/views/templates/widget/contactform.tpl";
    }

    /**
     * @return bool
     */
    public function install()
    {
        return parent::install() && $this->_installSql() && $this->registerHook('registerGDPRConsent');
    }


    protected function _installSql() {
 
        $sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "customer_message "
            . "ADD COLUMN gsm TEXT NULL ,ADD COLUMN tel TEXT NULL, ADD COLUMN address LONGTEXT NULL, ADD COLUMN firstname LONGTEXT NULL";

            // gsm tel address
        $returnSql = Db::getInstance()->execute($sqlInstall);

        return $returnSql;
    }
  
    public function uninstall()
    {
        return parent::uninstall() && $this->_unInstallSql();
    }

    protected function _unInstallSql() {
        $sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "customer_message "
            . "DROP gsm , DROP tel , DROP address, DROP firstname";

        $returnSql = Db::getInstance()->execute($sqlInstall);

        return $returnSql;
    } 
   
    /**
     * {@inheritdoc}
     */
    public function renderWidget($hookName = null, array $configuration = [])
    {
        if (!$this->active) {
            return;
        }
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));

        return $this->display(__FILE__, 'views/templates/widget/contactform.tpl');
    }

    /**
     * {@inheritdoc}
     */
    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $notifications = false;

        if (Tools::isSubmit('submitMessage')) { 
            $this->sendMessage();   
            if (!empty($this->context->controller->errors)) {
                $notifications['messages'] = $this->context->controller->errors;
                $notifications['nw_error'] = true;
            } elseif (!empty($this->context->controller->success)) {
                $notifications['messages'] = $this->context->controller->success;
                $notifications['nw_error'] = false;
            }
        } elseif (empty($this->context->cookie->contactFormToken)
            || empty($this->context->cookie->contactFormTokenTTL)
            || $this->context->cookie->contactFormTokenTTL < time()
        ) {
            $this->createNewToken();
        }

        if (($id_customer_thread = (int)Tools::getValue('id_customer_thread'))
            && $token = Tools::getValue('token')
        ) {
            $cm = new CustomerThread($id_customer_thread);

            if ($cm->token == $token) {
                $this->customer_thread = $this->context->controller->objectPresenter->present($cm);
            }
        }
        $this->contact['contacts'] = $this->getTemplateVarContact();
        $this->contact['message'] = Tools::getValue('message');
        $this->contact['tel'] = Tools::getValue('tel');
        $this->contact['address'] = Tools::getValue('address');
        $this->contact['gsm'] = Tools::getValue('gsm');
        $this->contact['firstname'] = Tools::getValue('firstname');

    

        $this->contact['allow_file_upload'] = (bool) Configuration::get('PS_CUSTOMER_SERVICE_FILE_UPLOAD');

        if (!(bool)Configuration::isCatalogMode()) {
            $this->contact['orders'] = $this->getTemplateVarOrders();
        } else {
            $this->contact['orders'] = [];
        }

        if (isset($this->customer_thread['email'])) {
            $this->contact['email'] = $this->customer_thread['email'];
        } else {
            $this->contact['email'] = Tools::safeOutput(
                Tools::getValue(
                    'from',
                    !empty($this->context->cookie->email) && Validate::isEmail($this->context->cookie->email) ?
                    $this->context->cookie->email :
                    ''
                )
            );
        }

         
        return [
            'contact' => $this->contact,
            'notifications' => $notifications,
            'token' => $this->context->cookie->contactFormToken,
            'id_module' => $this->id
        ];
    }

    /**
     * @return $this
     */
    protected function createNewToken()
    {
        $this->context->cookie->contactFormToken = md5(uniqid());
        $this->context->cookie->contactFormTokenTTL = time()+600;

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplateVarContact()
    {
        $contacts = [];
        $all_contacts = Contact::getContacts($this->context->language->id);

        foreach ($all_contacts as $one_contact) {
            $contacts[$one_contact['id_contact']] = $one_contact;
        }

        if (isset($this->customer_thread['id_contact'])) {
            return [
                $contacts[$this->customer_thread['id_contact']]
            ];
        }

        return $contacts;
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function getTemplateVarOrders()
    {
        $orders = [];

        if (empty($this->customer_thread['id_order'])
            && isset($this->context->customer)
            && $this->context->customer->isLogged()
        ) {
            $customer_orders = Order::getCustomerOrders($this->context->customer->id);

            foreach ($customer_orders as $customer_order) {
                $myOrder = new Order((int)$customer_order['id_order']);

                if (Validate::isLoadedObject($myOrder)) {
                    $orders[$customer_order['id_order']] = $customer_order;
                    $orders[$customer_order['id_order']]['products'] = $myOrder->getProducts();
                }
            }
        } elseif (isset($this->customer_thread['id_order']) && (int) $this->customer_thread['id_order'] > 0) {
            $myOrder = new Order($this->customer_thread['id_order']);

            if (Validate::isLoadedObject($myOrder)) {
                $orders[$myOrder->id] = $this->context->controller->objectPresenter->present($myOrder);
                $orders[$myOrder->id]['id_order'] = $myOrder->id;
                $orders[$myOrder->id]['products'] = $myOrder->getProducts();
            }
        }

        if (!empty($this->customer_thread['id_product'])) {
            $id_order = isset($this->customer_thread['id_order']) ?
                      (int) $this->customer_thread['id_order'] :
                      0;

            $orders[$id_order]['products'][(int)$this->customer_thread['id_product']] = $this->context->controller->objectPresenter->present(
                new Product((int) $this->customer_thread['id_product'])
            );
        }

        return $orders;
    }

    /**
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function sendMessage()
    {
        $extension = ['.txt', '.rtf', '.doc', '.docx', '.pdf', '.zip', '.png', '.jpeg', '.gif', '.jpg'];
        $file_attachment = Tools::fileAttachment('fileUpload');
        $message = trim(Tools::getValue('message')); 
        $telfixe = trim(Tools::getValue('tel'));
        $gsm = trim(Tools::getValue('gsm'));
        $adress = trim(Tools::getValue('address'));
        $url = Tools::getValue('url');
        $clientToken = Tools::getValue('token');
        $serverToken = $this->context->cookie->contactFormToken;
        $clientTokenTTL = $this->context->cookie->contactFormTokenTTL; 
        $firstname = trim(Tools::getValue('firstname'));
  
        if (empty( trim(Tools::getValue('firstname')))) {
             
            $this->context->controller->errors[] = $this->trans(
                'The %s field is required.', 
                [
                    sprintf('"%s"', $this->trans('Last name',[], 'Admin.Global') .' & ' .$this->trans('First name',[], 'Admin.Global')),
                    
                ] ,'Admin.Notifications.Error',
            );
          //  [sprintf('"%s"', $this->trans('First name', 'Admin.Global'))]
          //  return $this->trans('The %s field is required.', [$this->displayFieldName($field, get_class($this))], 'Admin.Notifications.Error');

        } elseif (!($from = trim(Tools::getValue('from'))) || !Validate::isEmail($from)) { 

            $this->context->controller->errors[] = $this->trans(
                'Invalid email address.',
                [], 
                'Shop.Notifications.Error'
            );
        }  elseif (empty($message)) {
            $this->context->controller->errors[] = $this->trans(
                'The message cannot be blank.',
                [],
                'Shop.Notifications.Error'
            );
        } elseif (!Validate::isCleanHtml($message)) {
            $this->context->controller->errors[] = $this->trans(
                'Invalid message',
                [],
                'Shop.Notifications.Error'
            );
        } elseif (!($id_contact = (int)Tools::getValue('id_contact')) ||
                  !(Validate::isLoadedObject($contact = new Contact($id_contact, $this->context->language->id)))
        ) {
            $this->context->controller->errors[] = $this->trans(
                'Please select a subject from the list provided. ',
                [],
                'Modules.Contactform.Shop'
            );
        } elseif (!empty($file_attachment['name']) && $file_attachment['error'] != 0) {
            $this->context->controller->errors[] = $this->trans(
                'An error occurred during the file-upload process.',
                [],
                'Modules.Contactform.Shop'
            );
        } elseif (!empty($file_attachment['name']) &&
                  !in_array(Tools::strtolower(Tools::substr($file_attachment['name'], -4)), $extension) &&
                  !in_array(Tools::strtolower(Tools::substr($file_attachment['name'], -5)), $extension)
        ) {
            $this->context->controller->errors[] = $this->trans(
                'Bad file extension',
                [],
                'Modules.Contactform.Shop'
            );
        } elseif ($url !== ''
            || empty($serverToken)
            || $clientToken !== $serverToken
            || $clientTokenTTL < time()
        ) {
            $this->context->controller->errors[] = $this->trans(
                'An error occurred while sending the message, please try again.',
                [],
                'Modules.Contactform.Shop'
            );
            $this->createNewToken();
        } else {
            $customer = $this->context->customer;           
            if (!$customer->id) {
                $customer->getByEmail($from);                
            }

            /**
             * Check that the order belongs to the customer.
             */
            $id_order = (int) Tools::getValue('id_order');
            if (!empty($id_order)) {
                $order = new Order($id_order);
                $id_order = (int) $order->id_customer === (int) $customer->id ? $id_order : 0;
            
            }

            $id_customer_thread = CustomerThread::getIdCustomerThreadByEmailAndIdOrder($from, $id_order);

            if ($contact->customer_service) {
                if ((int)$id_customer_thread) {
                    $ct = new CustomerThread($id_customer_thread);
                    $ct->status = 'open';
                    $ct->id_lang = (int)$this->context->language->id;
                    $ct->id_contact = (int)$id_contact;
                    $ct->id_order = $id_order;
                    $ct->firstname = $firstname;
                    if ($id_product = (int)Tools::getValue('id_product')) {
                        $ct->id_product = $id_product;
                    }
                    $ct->update();
                } else {
                    $ct = new CustomerThread();
                    if (isset($customer->id)) {
                        $ct->id_customer = (int)$customer->id;
                    }
                    $ct->id_shop = (int)$this->context->shop->id;
                    $ct->id_order = $id_order;

                    if ($id_product = (int)Tools::getValue('id_product')) {
                        $ct->id_product = $id_product;
                    }
                    $ct->id_contact = (int)$id_contact;
                    $ct->id_lang = (int)$this->context->language->id;
                    $ct->email = $from;
                    $ct->status = 'open';
                    $ct->token = Tools::passwdGen(12);
                    $ct->firstname = $firstname;
                    $ct->add();
                }

                if ($ct->id) {
                    $lastMessage = CustomerMessage::getLastMessageForCustomerThread($ct->id);
                    $testFileUpload = (isset($file_attachment['rename']) && !empty($file_attachment['rename']));

                  
                    // if last message is the same as new message (and no file upload), do not consider this contact
                    if ($lastMessage != $message || $testFileUpload) {
                        $cm = new CustomerMessage();
                        $cm->tel = $telfixe;
                        $cm->gsm = $gsm;
                        $cm->address = $adress;                 
                        $cm->id_customer_thread = $ct->id;
                        $cm->message = $message; 
                        $customer->email = $from;
                        $customer->firstname = $firstname;
                        $cm->firstname = $firstname;
                      

                        
                        if ($testFileUpload && rename($file_attachment['tmp_name'], _PS_UPLOAD_DIR_ . basename($file_attachment['rename']))) {
                            $cm->file_name = $file_attachment['rename'];
                            @chmod(_PS_UPLOAD_DIR_ . basename($file_attachment['rename']), 0664);
                        }
                        $cm->ip_address = (int)ip2long(Tools::getRemoteAddr());
                        $cm->user_agent = $_SERVER['HTTP_USER_AGENT'];  
                   
                        if (!$cm->add()) {
                            $this->context->controller->errors[] = $this->trans(
                                'An error occurred while sending the message.',
                                [],
                                'Modules.Contactform.Shop'
                            );
                        } 
                     
                  
                    } else {
                        $mailAlreadySend = true;                         
                    }

                    
                } else {
                    $this->context->controller->errors[] = $this->trans(
                        'An error occurred while sending the message.',
                        [],
                        'Modules.Contactform.Shop'
                    );
                }
                
            }
               
            $sendConfirmationEmail = Configuration::get(self::SEND_CONFIRMATION_EMAIL);
            $sendNotificationEmail =  Configuration::get(self::SEND_NOTIFICATION_EMAIL);
           
            if (!count($this->context->controller->errors)
                
                && ($sendConfirmationEmail || $sendNotificationEmail)
            ) {
                $var_list = [
                    '{firstname}' =>  (isset($customer) && $customer->firstname ) ? $customer->firstname : '', 
                    '{lastname}' => '',
                    '{order_name}' => '-',
                    '{attached_file}' => '-',
                    '{message}' => Tools::nl2br(Tools::htmlentitiesUTF8(Tools::stripslashes($message))),                    
                    '{email}' =>  $from,
                    '{product_name}' => '',
                    '{telfixe}' =>  (isset($cm) && $cm->tel ) ? $cm->tel : '',
                    '{gsm}' =>  (isset($cm) && $cm->gsm ) ? $cm->gsm : '',
                    '{address}' =>  (isset($cm) && $cm->address ) ? $cm->address : ''
                ];
                
                if (isset($customer->id)) {   
                    $var_list['{firstname}'] = $customer->firstname;
                    $var_list['{lastname}'] = $customer->lastname;
                     
                }

                if (isset($file_attachment['name'])) {
                    $var_list['{attached_file}'] = $file_attachment['name'];
                }
                $id_product = (int)Tools::getValue('id_product');

                if ($id_order) {
                    $order = new Order((int)$id_order);
                    $var_list['{order_name}'] = $order->getUniqReference();
                    $var_list['{id_order}'] = (int)$order->id;
                }

                if ($id_product) {
                    $product = new Product((int)$id_product);

                    if (Validate::isLoadedObject($product) &&
                        isset($product->name[Context::getContext()->language->id])
                    ) {
                        $var_list['{product_name}'] = $product->name[Context::getContext()->language->id];
                    }
                }
 
                if ($sendNotificationEmail) {
                    if (empty($contact->email) || !Mail::Send(
                        $this->context->language->id,
                        'contact',
                        // $this->trans('Message from contact form', [], 'Emails.Subject').' [no_sync]',
                        $this->trans('Message from contact form', [], 'Emails.Subject'),
                        $var_list,
                        $contact->email,
                        $contact->name,
                        null,
                        null,
                        $file_attachment,
                        null,
                        _PS_MAIL_DIR_,
                        false,
                        null,
                        null,
                        $from
                    )) {
                        $this->context->controller->errors[] = $this->trans(
                            'An error occurred while sending the message.',
                            [],
                            'Modules.Contactform.Shop'
                        );
                    }
                }

                if ($sendConfirmationEmail) {
                    $var_list['{message}'] = self::MESSAGE_PLACEHOLDER_FOR_OLDER_VERSION;

                    if (!Mail::Send(
                        $this->context->language->id,
                        'contact_form',  $this->trans('Your message has been correctly sent', [], 'Emails.Subject') ,
                        $var_list,
                        $from,
                        null,
                        null,
                        null,
                        $file_attachment,
                        null,
                        _PS_MAIL_DIR_,
                        false,
                        null,
                        null,
                        $contact->email
                    )) {
                        $this->context->controller->errors[] = $this->trans(
                            'An error occurred while sending the message.',
                            [],
                            'Modules.Contactform.Shop'
                        );
                    }
                }
                
            }
            
            
            // try{
            //     $contact->save();
            // }catch(Exception $e){
            //     
            // }
 
           
            if (!count($this->context->controller->errors)) {
               
                $this->context->controller->success[] = $this->trans(
                    'Your message has been successfully sent to our team.',
                    [],
                    'Modules.Contactform.Shop'
                );
                 
            }
            
        }
  
    }
   
//    
}
