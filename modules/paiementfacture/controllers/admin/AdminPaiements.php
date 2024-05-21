<?php
require_once _PS_MODULE_DIR_ . 'paiementfacture/classes/PaiementFactureClass.php';
class AdminPaiementsController extends ModuleAdminController
{


    public function __construct()
    {
        $this->table = 'paiementfacture';
        $this->_orderWay = 'DESC'; // ->orderBy('id_demande DESC')
        $this->className = 'PaiementFactureClass';
        $this->identifier = PaiementFactureClass::$definition['primary'];
        $this->bootstrap = true;
        $this->display = 'list';
        $this->show_toolbar = true;
        $this->show_toolbar_options = true;
        $this->list_no_link = true;

        $this->fields_list = [
            'order_number' => [
                'title' => 'Order Number',
                'align' => 'left'
            ],
            'order_id' => [
                'title' => 'Order ID',
                'align' => 'left'
            ], 
            'created_date' => [
                'title' => 'Date Création',
                'align' => 'left'
            ],            
            'client' => [
                'title' => 'Client',
                'align' => 'left'
            ],
            'num_fixe' => [
                'title' => 'Fixe Number',
                'align' => 'left'
            ],
            'reference_crm' => [
                'title' => 'Ref. Abonnement',
                'align' => 'left'
            ],
            'factures' => [
                'title' => 'Factures',
                'align' => 'left'
            ],
            'ammount' => [
                'title' => 'Ammount',
                'align' => 'left'
            ],
            // 'payment_type' => [
            //     'title' => 'Payment Type',
            //     'align' => 'left'
            // ],
            'sendto_pay' => [
                'title' => 'Send To Pay',
                'align' => 'left'
            ],
            'payment_state' => [
                'title' => 'Payment State',
                'align' => 'left'
            ],            
            'sendto_crm' => [
                'title' => 'Send to crm',
                'align' => 'left'
            ],'message' => [
                'title' => 'Message CRM',
                'align' => 'left'
            ],'message_smt' => [
                'title' => 'Message SMT',
                'align' => 'left'
            ],
            ];

        // $this->addRowAction('view');
        parent::__construct();
    }

    public function initToolbar()
    {
        $this->toolbar_btn = array();

        $this->toolbar_btn['export'] = [
            'href' => self::$currentIndex . '&export' . $this->table . '&token=' . $this->token,
            'desc' => $this->trans('Export', [], 'Admin.Actions'),
        ];
    }
 
}
?>