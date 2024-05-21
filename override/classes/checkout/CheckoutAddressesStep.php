<?php
use Symfony\Component\Translation\TranslatorInterface;
class CheckoutAddressesStep extends CheckoutAddressesStepCore
{
    protected $template = 'checkout/_partials/steps/addresses.tpl';
    private $addressForm;
    private $use_same_address = true;
    private $show_delivery_address_form = false;
    private $show_invoice_address_form = false;
    private $form_has_continue_button = false;    

    public function __construct(
        Context $context,
        TranslatorInterface $translator,
        CustomerAddressForm $addressForm
    ) {
         $this->addressForm = $addressForm;
        parent::__construct($context, $translator,$addressForm);
       
    }
    
    public function handleRequest(array $requestParams = [])
    {  
        // Can't really hurt to set the firstname and lastname.
        $this->addressForm->fillWith([
            'firstname' => $this->getCheckoutSession()->getCustomer()->firstname,
            'lastname' => $this->getCheckoutSession()->getCustomer()->lastname,
            'phone' => $this->getCheckoutSession()->getCustomer()->phone,
        ]);

        parent::handleRequest($requestParams);   


        return $this;
    }

}
