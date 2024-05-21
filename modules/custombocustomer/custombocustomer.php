<?php

if (!defined('_PS_VERSION_')) {
    exit;
}
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class custombocustomer extends Module
{

    public $vcaddonsinstance, $context, $templateFile;
    public function __construct()
    {
        // Settings
        $this->name = 'custombocustomer';
        $this->tab = 'formulaire';
        $this->version = '1.0';
        $this->author = 'Fatima Bouzidi';
        $this->need_instance = false;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Custom BO Customer');
        $this->description = $this->l('Custom BO Customer List');
        // $this->templateFile = 'module:custombocustomer/views/templates/hook/custombocustomer.tpl';

    }



    /**
     * install pre-config
     *
     * @return bool
     */
    public function install()
    {
        if (
            parent::install()
            && $this->registerHook('ActionCustomerGridDefinitionModifier') && $this->registerHook('ActionCustomerGridQueryBuilderModifier')
        )
            return true;

        return false;

    }

    /**
     * Uninstall module configuration
     *
     * @return bool
     */
    public function uninstall()
    {
        if (
            parent::uninstall() && $this->unregisterHook('ActionCustomerGridDefinitionModifier') && $this->unregisterHook('ActionCustomerGridQueryBuilderModifier')
        ) {
            return true;
        }
        return false;

    }


    public function hookActionCustomerGridQueryBuilderModifier(array $params)
    {
        $searchQueryBuilder = $params['search_query_builder'];
        $searchQueryBuilder->addSelect('c.`ref_abonnement`, c.`num_fixe`, c.`phone`, c.`ref_client`');

        /** @var CustomerFilters $searchCriteria */
        $searchCriteria = $params['search_criteria'];
        foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
            if ($filterName == 'ref_abonnement') {
                $searchQueryBuilder->andWhere('ref_abonnement = :ref_abonnement');
                $searchQueryBuilder->setParameter('ref_abonnement', $filterValue);
            }
            if ($filterName == 'num_fixe') {
                $searchQueryBuilder->andWhere('num_fixe = :num_fixe');
                $searchQueryBuilder->setParameter('num_fixe', $filterValue);
            }
            if ($filterName == 'phone') {
                $searchQueryBuilder->andWhere('phone = :phone');
                $searchQueryBuilder->setParameter('phone', $filterValue);
            }
            if ($filterName == 'ref_client') {
                $searchQueryBuilder->andWhere('ref_client = :ref_client');
                $searchQueryBuilder->setParameter('ref_client', $filterValue);
            }
        }
    }


    public function hookActionCustomerGridDefinitionModifier(array $params)
    {
        /** @var GridDefinitionInterface $definition */
        $definition = $params['definition'];


        /** @var ColumnCollection */
        $columns = $definition->getColumns();
        $columns->remove('social_title')
            // ->remove('id_customer')
            ->remove('newsletter')
            ->remove('optin');
      
        $newColumn = (new DataColumn('ref_abonnement'))->setName($this->trans('Ref. Abonnement', [], 'Admin.Global'))->setOptions(['field' => 'ref_abonnement']);
        $columns->addBefore('firstname', $newColumn);

        $newColumn = (new DataColumn('num_fixe'))->setName($this->trans('N° Fixe', [], 'Admin.Global'))->setOptions(['field' => 'num_fixe']);
        $columns->addAfter('lastname', $newColumn);

        $newColumn = (new DataColumn('phone'))->setName($this->trans('Télephone', [], 'Admin.Global'))->setOptions(['field' => 'phone']);
        $columns->addAfter('num_fixe', $newColumn);

        $newColumn = (new DataColumn('ref_client'))->setName($this->trans('Identifiant', [], 'Admin.Global'))->setOptions(['field' => 'ref_client']);
        $columns->addBefore('ref_abonnement', $newColumn);

      

        $filters = $definition->getFilters();

        $filters->remove('social_title')
            ->remove('newsletter')
            ->remove('id_customer')
            ->remove('optin')
            ->add(
                (new Filter('ref_client', TextType::class))
                    ->setTypeOptions([
                        'attr' => [
                            'placeholder' => $this->trans('Search identifier', [], 'Admin.Actions'),
                        ],
                        'required' => false,
                    ])
                    ->setAssociatedColumn('ref_client')
            )
            ->add(
                (new Filter('ref_abonnement', TextType::class))
                    ->setTypeOptions([
                        'attr' => [
                            'placeholder' => $this->trans('Search Ref. Abonnement', [], 'Admin.Actions'),
                        ],
                        'required' => false,
                    ])
                    ->setAssociatedColumn('ref_abonnement')
            )
            ->add(
                (new Filter('num_fixe', TextType::class))
                    ->setTypeOptions([
                        'attr' => [
                            'placeholder' => $this->trans('Search N° Fixe', [], 'Admin.Actions'),
                        ],
                        'required' => false,
                    ])
                    ->setAssociatedColumn('num_fixe')
            )
            ->add(
                (new Filter('phone', TextType::class))
                    ->setTypeOptions([
                        'attr' => [
                            'placeholder' => $this->trans('Search Télephone', [], 'Admin.Actions'),
                        ],
                        'required' => false,
                    ])
                    ->setAssociatedColumn('phone')
            )
        ;

    }

    public function getContent()
    {
        return 'custombocustomer';
    }

}