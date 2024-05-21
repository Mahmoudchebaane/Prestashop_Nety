<?php

/**
 * @Override CustomerFormatter
 */

use Symfony\Component\Translation\TranslatorInterface;

class CustomerFormatter extends CustomerFormatterCore
{
    private $translator;
    private $language;

    private $ask_for_password = true;
    public $password_is_required = true;
    private $ask_for_new_password = true;

    public function __construct(
        TranslatorInterface $translator,
        Language $language
    ) {
        parent::__construct($translator, $language);
        $this->translator = $translator;
        $this->language = $language;
    }

    public function getFormat()
    {
        $format = parent::getFormat();            
        if ($_GET['controller'] == 'order' ) {
            unset($format['optin']);
            unset($format['birthday']);
            unset($format['ps_dataprivacy_customer_privacy']);
            unset($format['ps_emailsubscription_newsletter']);
            unset($format['g-recaptcha-response']);
            $format['password']->setRequired(true);            
            $format['confirm_password'] = (new FormField())
            ->setName('confirm_password')
            ->setType('password')
            ->setRequired(true)
            ->setLabel(
                $this->translator->trans(
                    'Confirm password',
                    [],
                    'Shop.Forms.Labels'
                )
            );
            $format['phone'] = (new FormField)
            ->setName('phone')
            ->setRequired(true)
            ->setType('tel')
            ->setLabel(
                $this->translator->trans(
                    'Phone',
                    [],
                    'Shop.Forms.Labels'
                )
            );
            //array_replace(array_flip(array('id_gender','firstname', 'lastname',  'phone', 'email', 'password', 'confirm_password', 'psgdpr_psgdpr')), $format);
            //dump('$format', $format);die;
            return array_replace(array_flip(array('id_gender','firstname', 'lastname',  'phone', 'email', 'password', 'confirm_password', 'psgdpr_psgdpr')), $format);;
        }
        
        $format['ref_client'] = (new FormField)
            ->setName('ref_client')
            ->setLabel(
                $this->translator->trans(
                    'Identifiant',
                    [],
                    'Shop.Theme.Customeraccount'
                ));
            // ->setRequired(true);

        $format['num_fixe'] = (new FormField)
            ->setName('num_fixe')
            ->setLabel(
                $this->translator->trans(
                    'Numero de ligne',
                    [],
                    'Shop.Forms.Help'
                ));
            // ->setRequired(true);

        $format['phone'] = (new FormField)
            ->setName('phone')
            ->setType('tel')
            ->setRequired(true)
            ->setLabel(
                $this->translator->trans(
                    'Phone',
                    [],
                    'Shop.Forms.Labels'
                )
            );

        $format['ref_abonnement'] = (new FormField)
            ->setName('ref_abonnement')
            ->setLabel(
                $this->translator->trans(
                    'Ref abonnement',
                    [],
                    'Shop.Theme.Customeraccount'
                ));
                // ->setRequired(true);

        if (array_key_exists('psgdpr_psgdpr', $format) !== false) {

            $format['password'] = (new FormField())
                ->setName('password')
                ->setType('password')
                ->setRequired(true)
                ->setLabel(
                    $this->translator->trans(
                        'Password',
                        [],
                        'Shop.Forms.Labels'
                    )
                );
        } else {
            $format['password'] = (new FormField())
                ->setName('password')
                ->setType('password')
                ->setLabel(
                    $this->translator->trans(
                        'Old password',
                        [],
                        'Shop.Forms.Labels'
                    )
                );
        }

        $format['confirm_password'] = (new FormField())
            ->setName('confirm_password')
            ->setType('password')
            ->setRequired(true)
            ->setLabel(
                $this->translator->trans(
                    'Confirm password',
                    [],
                    'Shop.Forms.Labels'
                )
            );

        unset($format['optin']);
        unset($format['id_gender']);
        unset($format['birthday']);
        unset($format['ps_dataprivacy_customer_privacy']);
        unset($format['ps_emailsubscription_newsletter']);

        

        if (array_key_exists('psgdpr_psgdpr', $format) !== false) {
            $properOrderedArray = array_replace(array_flip(array('firstname', 'lastname', 'ref_client', 'ref_abonnement', 'num_fixe', 'phone', 'email', 'password', 'confirm_password', 'psgdpr_psgdpr')), $format);

        } else {
            $properOrderedArray = array_replace(array_flip(array('firstname', 'lastname', 'ref_client', 'ref_abonnement', 'num_fixe', 'phone', 'email', 'password', 'new_password', 'confirm_password')), $format);
        }
        return $properOrderedArray;

    }
}