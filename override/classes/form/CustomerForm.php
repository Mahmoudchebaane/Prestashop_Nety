<?php
use PrestaShop\PrestaShop\Core\Util\InternationalizedDomainNameConverter;
use Symfony\Component\Translation\TranslatorInterface;


class CustomerForm extends CustomerFormCore
{
    protected $translator;
    protected $formatter;
    private $context;
    private $urls;
    private $is_nety = false;


    public function __construct(
        Smarty $smarty,
        Context $context,
        TranslatorInterface $translator,
        CustomerFormatter $formatter,
        CustomerPersister $customerPersister,
        array $urls
    ) {
        parent::__construct(
            $smarty,
            $context,
            $translator,
            $formatter,
            $customerPersister,
            $urls
        );

        $this->context = $context;
        $this->urls = $urls;
        $this->customerPersister = $customerPersister;
        $this->IDNConverter = new InternationalizedDomainNameConverter();
        $this->is_nety = false;        

    }
    public function validate()
    {
        //Confirm password - check if is the same
        $confPasswField = $this->getField('confirm_password');
        $confPasswValue = $confPasswField->getValue();
        $controller = $_GET['controller'];
        $testPass = Tools::getValue('testPass');

        // if ($page_name == '') {
        if($controller == 'identity'){
            $oldPassField = $this->getField('password');
            $oldPassdValue = $oldPassField->getValue();
            $passwField = $this->getField('new_password');
            $passwordValue = $passwField->getValue();

            if ($testPass == "2") {
                if ($oldPassdValue == '') {

                    $oldPassField->addError(
                        $this->translator->trans(
                            "This field is required",
                            array(),
                            'Shop.Theme.Customeraccount'
                        )
                    );
                } elseif ($passwordValue == '') {
                    $passwField->addError(
                        $this->translator->trans(
                            "This field is required",
                            array(),
                            'Shop.Theme.Customeraccount'
                        )
                    );
                } elseif (strlen($passwordValue) < 6) {
                    $passwField->addError(
                        $this->translator->trans(
                            "Password should contain at least 6 characters",
                            array(),
                            'Shop.Theme.Customeraccount'
                        )
                    );
                } elseif ($confPasswValue == '') {
                    $confPasswField->addError(
                        $this->translator->trans(
                            "This field is required",
                            array(),
                            'Shop.Theme.Customeraccount'
                        )
                    );
                } elseif ($passwordValue != $confPasswValue) {

                    $confPasswField->addError(
                        $this->translator->trans(
                            "The password and the confirmation password does not match",
                            array(),
                            'Shop.Theme.Customeraccount'
                        )
                    );
                } else {
                    return true;
                }
            } else{                
                $telField = $this->getField('phone');
                $telValue = $telField->getValue();
                $emailField = $this->getField('email');
                $emailValue = $emailField->getValue();
                if ($emailValue == '') {
                    $emailField->addError(
                        $this->translator->trans(
                            "This field is required",
                            array(),
                            'Shop.Theme.Customeraccount'
                        )
                    );
                } elseif ($telValue == '') {
                    $telField->addError(
                        $this->translator->trans(
                            "Phone number should not be empty",
                            array(),
                            'Shop.Theme.Customeraccount'
                        )
                    );
                } elseif (!preg_match('/^[0-9]{8}+$/', $telValue)) {
                    $telField->addError(
                        $this->translator->trans(
                            "Invalid phone number",
                            array(),
                            'Shop.Theme.Customeraccount'
                        )
                    );
                } else {
                    return true;
                }
            }
        } elseif ($controller == 'authentication')  {
            $telField = $this->getField('phone');
            $telValue = $telField->getValue();
            $passwField = $this->getField('password');
            $passwordValue = $passwField->getValue();
            if ($telValue == '') {
                $telField->addError(
                    $this->translator->trans(
                        "Phone number should not be empty",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            } elseif (!preg_match('/^[0-9]{8}+$/', $telValue)) {
                $telField->addError(
                    $this->translator->trans(
                        "Invalid phone number",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            }elseif ($passwordValue == '') {
                $passwField->addError(
                    $this->translator->trans(
                        "This field is required",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            } elseif (strlen($passwordValue) < 6) {
                $passwField->addError(
                    $this->translator->trans(
                        "Password should contain at least 6 characters",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            } elseif ($passwordValue != $confPasswValue) {
                $confPasswField->addError(
                    $this->translator->trans(
                        "The password and the confirmation password does not match",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            }else {
                return true;
            }
        }
        else{
            $telField = $this->getField('phone');
            $telValue = $telField->getValue();
            $passwField = $this->getField('password');
            $passwordValue = $passwField->getValue();
           if (strlen($telValue) != 8) {
                $telField->addError(
                    $this->translator->trans(
                        "Invalid phone number",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            } elseif (!preg_match('/^[0-9]{8}+$/', $telValue)) {
                $telField->addError(
                    $this->translator->trans(
                        "Invalid phone number",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            }  elseif($passwordValue == '') {
                $passwField->addError(
                    $this->translator->trans(
                        "This field is required",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            } elseif (strlen($passwordValue) < 6) {
                $passwField->addError(
                    $this->translator->trans(
                        "Password should contain at least 6 characters",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            } elseif ($passwordValue != $confPasswValue) {
                $confPasswField->addError(
                    $this->translator->trans(
                        "The password and the confirmation password does not match",
                        array(),
                        'Shop.Theme.Customeraccount'
                    )
                );
            }else {
                return true;
            }  
        }
        return parent::validate();
    }
    public function submit()
    {

        if ($this->validate()) {
            $clearTextPassword = $this->getValue('password');
            $newPassword = $this->getValue('new_password');

            $ok = $this->customerPersister->save(
                $this->getCustomer(),
                $clearTextPassword,
                $newPassword,
                ($newPassword != "")
            );
            if (!$ok) {
                foreach ($this->customerPersister->getErrors() as $field => $errors) {
                    $this->formFields[$field]->setErrors($errors);
                }
            }

            return $ok;
        }

        return false;
    }

    public function setIs_Nety($is_nety)
    {  
        $this->is_nety = $is_nety;
        return $this;
    }  

}