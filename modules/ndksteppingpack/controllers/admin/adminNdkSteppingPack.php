<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2016 Hendrik Masson
 *  @license   Tous droits réservés
 */
class AdminNdkSteppingPackController extends ModuleAdminController
{
    public $bootstrap = true;
    public $tpl_form;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'ndksteppingpack';
        $this->className = 'NdkSpack';
        $this->lang = true;
        $this->display = 'list';
        $this->_defaultOrderBy = 'id_ndksteppingpack';
        Shop::addTableAssociation($this->table, ['type' => 'shop']);

        $this->identifier = 'id_ndksteppingpack';

        $this->fieldImageSettings = [
            ['name' => 'image', 'dir' => 'scenes/ndksp/'],
            ['name' => 'thumb', 'dir' => 'scenes/ndksp/thumbs'],
        ];

        if (!is_dir(_PS_IMG_DIR_ . 'scenes/ndksp/')) {
            mkdir(_PS_IMG_DIR_ . 'scenes/ndksp/', 0777);
        }

        if (!is_dir(_PS_IMG_DIR_ . 'scenes/ndksp/thumbs/')) {
            mkdir(_PS_IMG_DIR_ . 'scenes/ndksp/thumbs/', 0777);
        }

        parent::__construct();

        $this->fields_list = [
            'id_ndksteppingpack' => [
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 25,
            ],
            'name' => [
                'title' => $this->l('Name'),
                'filter_key' => 'b!name',
            ],
            'active' => [
                'title' => $this->l('Active'),
                'active' => 'active',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
                'align' => 'center',
                'orderby' => false,
            ],
        ];

        parent::__construct();
    }

    public function renderList()
    {
        if (Tools::getIsset($this->_filter) && '' == trim($this->_filter)) {
            $this->_filter = $this->original_filter;
        }

        $this->addRowAction('edit');
        $this->addRowAction('view');
        $this->addRowAction('delete');

        return parent::renderList();
    }

    public function init()
    {
        if (Tools::isSubmit('updatendksteppingpack_step')) {
            $this->display = 'editndksteppingpack_step';
        } elseif (Tools::isSubmit('submitAddndksteppingpack_step')) {
            $this->display = 'editndksteppingpack_step';
        } elseif (Tools::isSubmit('add_ndksteppingpack')) {
            $this->display = 'add';
        }

        parent::init();
    }

    public function processSave()
    {
        if ('add' == $this->display || 'edit' == $this->display) {
            $this->identifier = 'id_ndksteppingpack';
        }

        if (!$this->id_object) {
            return $this->processAdd();
        } else {
            return $this->processUpdate();
        }
    }

    public function processAdd()
    {
        $object = parent::processAdd();
        if (
            Tools::isSubmit('submitAdd' . $this->table . 'AndStay')
            && !count($this->errors)
        ) {
            if ('add' == $this->display) {
                $this->redirect_after =
                    self::$currentIndex .
                    '&' .
                    $this->identifier .
                    '=&conf=3&update' .
                    $this->table .
                    '&token=' .
                    $this->token;
            } else {
                $this->redirect_after =
                    self::$currentIndex .
                    '&id_ndksteppingpack=' .
                    (int) Tools::getValue('id_ndksteppingpack') .
                    '&conf=3&update' .
                    $this->table .
                    '&token=' .
                    $this->token;
            }
        } else {
            $this->redirect_after =
                self::$currentIndex .
                '&' .
                $this->identifier .
                '=&id_ndksteppingpack=' .
                (int) Tools::getValue('id_ndksteppingpack') .
                '&conf=3&viewndksteppingpack&token=' .
                $this->token;
        }

        if (count($this->errors)) {
            $this->setTypeValues();
        }

        return $object;
    }

    public function processUpdate()
    {
        $object = parent::processUpdate();

        if (
            Tools::isSubmit('submitAdd' . $this->table . 'AndStay')
            && !count($this->errors)
        ) {
            if ('add' == $this->display) {
                $this->redirect_after =
                    self::$currentIndex .
                    '&' .
                    $this->identifier .
                    '=&conf=3&update' .
                    $this->table .
                    '&token=' .
                    $this->token;
            } else {
                $this->redirect_after =
                    self::$currentIndex .
                    '&' .
                    $this->identifier .
                    '=&id_ndksteppingpack=' .
                    (int) Tools::getValue('id_ndksteppingpack') .
                    '&conf=3&update' .
                    $this->table .
                    '&token=' .
                    $this->token;
            }
        } else {
            $this->redirect_after =
                self::$currentIndex .
                '&' .
                $this->identifier .
                '=&id_ndksteppingpack=' .
                (int) Tools::getValue('id_ndksteppingpack') .
                '&conf=3&viewndksteppingpack&token=' .
                $this->token;
        }

        if (count($this->errors)) {
            $this->setTypeValues();
        }

        if (
            Tools::isSubmit('updatendksteppingpack_step')
            || Tools::isSubmit('deletendksteppingpack_step')
            || Tools::isSubmit('submitAddndksteppingpack_step')
            || Tools::isSubmit('submitBulkdeletendksteppingpack_step')
        ) {
            return $object;
        }
    }

    public function processPosition()
    {
        if (Tools::getIsset('ndksteppingpack')) {
            $object = new NdkSpack(
                (int) Tools::getValue('id_ndksteppingpack')
            );
            self::$currentIndex = self::$currentIndex . '&viewndksteppingpack';
        } else {
            $object = new $this->className();
        }

        if (!Validate::isLoadedObject($object)) {
            $this->errors[] =
                Tools::displayError(
                    'An error occurred while updating the status for an object.'
                ) .
                ' <b>' .
                $this->table .
                '</b> ' .
                Tools::displayError('(cannot load object)');
        } elseif (
            !$object->updatePosition(
                (int) Tools::getValue('way'),
                (int) Tools::getValue('position')
            )
        ) {
            $this->errors[] = Tools::displayError(
                'Failed to update the position.'
            );
        } else {
            $id_identifier_str = ($id_identifier = (int) Tools::getValue(
                $this->identifier
            ))
                ? '&' . $this->identifier . '=' . $id_identifier
                : '';
            $redirect =
                self::$currentIndex .
                '&' .
                $this->table .
                'Orderby=position&' .
                $this->table .
                'Orderway=asc&conf=5' .
                $id_identifier_str .
                '&token=' .
                $this->token;
            $this->redirect_after = $redirect;
        }

        return $object;
    }

    public function initContent()
    {
        // toolbar (save, cancel, new, ..)
        // $this->initTabModuleList();
        $this->initToolbar();
        $this->initPageHeaderToolbar();
        if ('edit' == $this->display || 'add' == $this->display) {
            if (!($this->object = $this->loadObject(true))) {
                return;
            }
            $this->content .= $this->renderForm();
        } elseif ('editndksteppingpack_step' == $this->display) {
            if (
                !($this->object = new NdkSpackStep(
                    (int) Tools::getValue('id_ndksteppingpack_step')
                ))
            ) {
                return;
            }

            $this->content .= $this->renderFormValues();
        } elseif ('view' != $this->display && !$this->ajax) {
            $this->content .= $this->renderList();
            $this->content .= $this->renderOptions();
        } elseif ('view' == $this->display && !$this->ajax) {
            $this->content = $this->renderView();
        }

        $this->context->smarty->assign([
            'table' => $this->table,
            'current' => self::$currentIndex,
            'token' => $this->token,
            'content' => $this->content,
            'url_post' => self::$currentIndex . '&token=' . $this->token,
            'show_page_header_toolbar' => $this->show_page_header_toolbar,
            'page_header_toolbar_title' => $this->page_header_toolbar_title,
            'page_header_toolbar_btn' => $this->page_header_toolbar_btn,
        ]);
    }

    public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_ndksteppingpack'] = [
                'href' => self::$currentIndex .
                    '&addndksteppingpack&token=' .
                    $this->token,
                'desc' => $this->l('Add new pack', null, null, false),
                'icon' => 'process-icon-new',
            ];
            $this->page_header_toolbar_btn['new_value'] = [
                'href' => self::$currentIndex .
                    '&updatendksteppingpack_step&id_ndksteppingpack=' .
                    (int) Tools::getValue('id_ndksteppingpack') .
                    '&token=' .
                    $this->token,
                'desc' => $this->l('Add new step', null, null, false),
                'icon' => 'process-icon-new',
            ];
        }

        if ('view' == $this->display) {
            $this->page_header_toolbar_btn['new_value'] = [
                'href' => self::$currentIndex .
                    '&updatendksteppingpack_step&id_ndksteppingpack=' .
                    (int) Tools::getValue('id_ndksteppingpack') .
                    '&token=' .
                    $this->token,
                'desc' => $this->l('Add new step', null, null, false),
                'icon' => 'process-icon-new',
            ];
        }

        parent::initPageHeaderToolbar();
    }

    public function initToolbar()
    {
        switch ($this->display) {
            // @todo defining default buttons
            case 'add':
            case 'edit':
            case 'editndksteppingpack_step':
                // Default save button - action dynamically handled in javascript
                $this->toolbar_btn['save'] = [
                    'href' => '#',
                    'desc' => $this->l('Save'),
                ];

                if (
                    'editndksteppingpack_step' == $this->display
                    && !$this->id_ndksteppingpack_step
                ) {
                    $this->toolbar_btn['save-and-stay'] = [
                        'short' => 'SaveAndStay',
                        'href' => '#',
                        'desc' => $this->l(
                            'Save then add another step',
                            null,
                            null,
                            false
                        ),
                        'force_desc' => true,
                    ];
                }

                $this->toolbar_btn['back'] = [
                    'href' => self::$currentIndex . '&token=' . $this->token,
                    'desc' => $this->l('Back to list', null, null, false),
                ];
                break;
            case 'view':
                $this->toolbar_btn['newndksteppingpack_step'] = [
                    'href' => self::$currentIndex .
                        '&updatendksteppingpack_step&id_ndksteppingpack=' .
                        (int) Tools::getValue('id_ndksteppingpack') .
                        '&token=' .
                        $this->token,
                    'desc' => $this->l('Add New Pack', null, null, false),
                    'class' => 'toolbar-new',
                ];

                $this->toolbar_btn['back'] = [
                    'href' => self::$currentIndex . '&token=' . $this->token,
                    'desc' => $this->l('Back to list', null, null, false),
                ];
                break;
            default:
                // list
                $this->toolbar_btn['new'] = [
                    'href' => self::$currentIndex .
                        '&add' .
                        $this->table .
                        '&token=' .
                        $this->token,
                    'desc' => $this->l('Add New Pack', null, null, false),
                ];
        }
    }

    public function initToolbarTitle()
    {
        $bread_extended = $this->breadcrumbs;

        switch ($this->display) {
            case 'edit':
                $bread_extended[] = $this->l('Edit Step');
                break;

            case 'add':
                $bread_extended[] = $this->l('Add New Step');
                break;

            case 'view':
                if (Tools::getIsset('viewndksteppingpack')) {
                    if ($id = Tools::getValue('id_ndksteppingpack')) {
                        if (
                            Validate::isLoadedObject(
                                $obj = new NdkSpack((int) $id)
                            )
                        ) {
                            $bread_extended[] =
                                $obj->name[$this->context->employee->id_lang];
                        }
                    }
                } else {
                    $bread_extended[] =
                        $this->value[$this->context->employee->id_lang];
                }
                break;

            case 'editndksteppingpack_step':
                if ($this->id_ndksteppingpack_step) {
                    if ($id = Tools::getValue('id_ndksteppingpack')) {
                        if (
                            Validate::isLoadedObject(
                                $obj = new NdkSpack((int) $id)
                            )
                        ) {
                            $bread_extended[] =
                                '<a href="' .
                                Context::getContext()->link->getAdminLink(
                                    'AdminNdkCustomFields'
                                ) .
                                '&id_ndksteppingpack=' .
                                $id .
                                '&viewndksteppingpack">' .
                                $obj->name[$this->context->employee->id_lang] .
                                '</a>';
                        }
                        if (
                            Validate::isLoadedObject(
                                $obj = new NdkSpackStep(
                                    (int) $this->id_ndksteppingpack_step
                                )
                            )
                        ) {
                            $bread_extended[] = sprintf(
                                $this->l('Edit: %s'),
                                $obj->name[$this->context->employee->id_lang]
                            );
                        }
                    } else {
                        $bread_extended[] = $this->l('Edit Step');
                    }
                } else {
                    $bread_extended[] = $this->l('Add New Step');
                }
                break;
        }

        if (count($bread_extended) > 0) {
            $this->addMetaTitle($bread_extended[count($bread_extended) - 1]);
        }

        $this->toolbar_title = $bread_extended;
    }

    public function getList(
        $id_lang,
        $order_by = null,
        $order_way = null,
        $start = 0,
        $limit = null,
        $id_lang_shop = false
    ) {
        if(!NdkSpack::checkSubscription()){
            return [];
        }
        goto jISNq; h9o92: return []; goto J5m6D; jISNq: if (NdkSpack::Og3Z8()) { goto Mqo5d; } goto h9o92; J5m6D: Mqo5d:
        parent::getList(
            $id_lang,
            $order_by,
            $order_way,
            $start,
            $limit,
            $id_lang_shop
        );

        $nb_items = count($this->_list);
        for ($i = 0; $i < $nb_items; ++$i) {
            $item = &$this->_list[$i];

            $query = new DbQuery();
            $query->select('COUNT(a.id_ndksteppingpack_step) as count_values');
            $query->from('ndksteppingpack_step', 'a');
            $query->join(Shop::addSqlAssociation('ndksteppingpack_step', 'a'));
            $query->where(
                'a.id_ndksteppingpack =' . (int) $item['id_ndksteppingpack']
            );
            $query->orderBy('count_values DESC');
            $item['count_values'] = (int) Db::getInstance(
                _PS_USE_SQL_SLAVE_
            )->getValue($query);
            unset($query);
        }
    }

    public function processBulkDelete()
    {
        if (Tools::getIsset('valueBox')) {
            $this->className = 'NdkSpackStep';
            $this->table = 'ndksteppingpack_step';
            $this->boxes = Tools::getValue($this->table . 'Box');
        }

        $result = parent::processBulkDelete();
        // Restore vars
        $this->className = 'NdkSpack';
        $this->table = 'ndksteppingpack';

        return $result;
    }

    public function renderFormValues()
    {
        $fields = NdkSpack::getAllSteps();
        // Override var of Controller
        $this->table = 'ndksteppingpack_step';
        $this->className = 'NdkSpackStep';
        $this->lang = true;

        $additionnals = '';
        $this->show_form_cancel_button = true;
        $this->fields_form = [
            'legend' => [
                'title' => $this->l('Steps'),
                'icon' => 'icon-info-sign',
            ],
            'input' => [
                [
                    'type' => 'select',
                    'label' => $this->l('Pack'),
                    'name' => 'id_ndksteppingpack',
                    'required' => true,
                    'options' => [
                        'query' => $fields,
                        'id' => 'id_ndksteppingpack',
                        'name' => 'name',
                    ],
                    'hint' => $this->l(
                        'Choose the parent field for this step.'
                    ),
                ],
            ],
        ];

        $this->addJqueryPlugin(['autocomplete']);
        $this->addJs(_MODULE_DIR_ . 'ndksteppingpack/views/js/admin.js');
        $this->addCss(_MODULE_DIR_ . 'ndksteppingpack/views/css/back.css');

        $obj = $this->loadObject(true);
        $parent = new NdkSpack((int) $obj->id_ndksteppingpack);

        $boxprod = '<div class="clear clearfix prodlist">';

        if ('' != $obj->products) {
            $lightProds = NdkSpackStep::getproductsLight($obj->products);
            foreach ($lightProds as $prod) {
                $boxprod .=
                    '
                    <button data-id="' .
                    $prod['id_product'] .
                    '" class="btn btn-default prodrow" type="button"><i class="icon-remove"></i>' .
                    $prod['name'] .
                    ' ( ref : ' .
                    $prod['reference'] .
                    ' )</button>';
            }
        }
        $boxprod .= '</div><br/>';

        $searchbox =
            $boxprod .
            '
                    <div id="ajax_choose_product" class="row">
                        <div class="col-lg-12">
                        <p class="alert alert-info">' .
            $this->l(
                'Begin typing the first few letters of the product name, then select the product you are looking for from the drop-down list:'
            ) .
            '
                        </p>
                        <div class="input-group row-margin-bottom">
                            <span class="input-group-addon">
                                <i class="icon-search"></i>
                            </span>
                            <input type="text" value="" id="product_autocomplete_input" />
                        </div>
                        <button type="button" class="btn btn-default" onclick="undoEdit();"><i class="icon-remove"></i>&nbsp;' .
            $this->l('Delete') .
            '</button>
                        <button type="button" class="btn btn-default" onclick="$(this).prev().search();"><i class="icon-check-sign"></i>&nbsp;' .
            $this->l('Ok') .
            '</button>
                        </div>
                    </div>
                    ';

        $this->fields_form['input'][] = [
            'type' => 'text',
            'label' => $this->l('Name'),
            'name' => 'name',
            'size' => 48,
            'lang' => true,
        ];

        // if($parent->type == 1)
        $this->fields_form['input'][] = [
            'type' => 'switch',
            'label' => $this->l('Optional step :'),
            'name' => 'optionnal',
            'required' => false,
            'hint' => $this->l(
                'If set to yes, price(s) will be added to fixed price'
            ),
            'class' => 't visible-field hidden-10 hidden-5',
            'is_bool' => true,
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Yes'),
                ],
                [
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->l('No'),
                ],
            ],
        ];

        $this->fields_form['input'][] = [
            'type' => 'switch',
            'label' => $this->l('Show price :'),
            'name' => 'show_price',
            'required' => false,
            'hint' => $this->l(
                'If set to no, price(s) will be hidden for this step'
            ),
            'class' => 't visible-field',
            'is_bool' => true,
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Yes'),
                ],
                [
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->l('No'),
                ],
            ],
        ];

        $this->fields_form['input'][] = [
            'type' => 'textarea',
            'label' => $this->l('Description'),
            'name' => 'description',
            'size' => 48,
            'lang' => true,
            'autoload_rte' => true,
        ];

        $this->fields_form['input'][] = [
            'type' => 'html',
            'label' => $this->l('Choose your product'),
            'name' => 'infos',
            'desc' => '<p>' .
                $this->l(
                    'You have 4 filters available for products to show : picks products, choose categories, choose supplier and choose manufacturer'
                ) .
                '</p>' .
                '<p>' .
                $this->l(
                    'picks products filter will be added to the list, 3 other filters will be rules so if you select categories, supplier and manufacturer, products has to be in selected categories AND selected maufacturer AND selected manufacturer'
                ) .
                '</p>' .
                '<p>' .
                $this->l(
                    'Final query will be products WHERE in selected categories AND selected maufacturer AND selected manufacturer OR selected products'
                ) .
                '</p>',
        ];

        $this->fields_form['input'][] = [
            'type' => 'text',
            'readonly' => 'readonly',
            'label' => $this->l('Products'),
            'name' => 'products',
            'id' => 'products',
            'size' => 48,
            'desc' => $searchbox,
        ];

        $this->fields_form['input'][] = [
            'type' => 'html',
            'label' => $this->l('OR'),
            'name' => 'OR',
        ];

        $selected_cat = [];
        if ($obj->categories) {
            $cats = explode(',', $obj->categories);
            foreach ($cats as $key => $value) {
                $selected_cat[] = (int) $value;
            }
        }

        $root = Category::getRootCategory();
        $tree = new HelperTreeCategories('categories-tree'); // The string in param is the ID used by the generated tree
        $tree
            ->setUseCheckBox(true)
            ->setAttribute('is_category_filter', $root->id)
            ->setRootCategory($root->id)
            ->setSelectedCategories($selected_cat)
            ->setInputName('categories'); // Set the name of input. The option "name" of $fields_form doesn't seem to work with "categories_select" type
        $categoryTree = $tree->render();

        $this->fields_form['input'][] = [
            'type' => 'categories_select',
            'label' => $this->l('Categories'),
            'name' => 'categories',
            'category_tree' => $categoryTree, // This is the category_tree called in form.tpl
        ];

        $this->fields_form['input'][] = [
            'type' => 'html',
            'label' => $this->l('AND'),
            'name' => 'AND',
        ];

        if ($obj = $this->loadObject(true)) {
            $suppliers = explode(',', $obj->suppliers);
            $this->fields_value['suppliers[]'] = $suppliers;
        }
        $supplier_list = Supplier::getSuppliers();
        array_push($supplier_list, [
            'id_supplier' => '',
            'name' => $this->l('none'),
        ]);
        $this->fields_form['input'][] = [
            'type' => 'select',
            'multiple' => false,
            'label' => $this->l('Suppliers'),
            'name' => 'suppliers[]',
            'class' => 'chosen',
            'options' => [
                'query' => $supplier_list,
                'id' => 'id_supplier',
                'name' => 'name',
            ],
            'size' => 4,
        ];

        $this->fields_form['input'][] = [
            'type' => 'html',
            'label' => $this->l('AND'),
            'name' => 'AND',
        ];

        if ($obj = $this->loadObject(true)) {
            $manufacturers = explode(',', $obj->manufacturers);
            $this->fields_value['manufacturers[]'] = $manufacturers;
        }
        $manufacturers_list = Manufacturer::getManufacturers();
        array_push($manufacturers_list, [
            'id_manufacturer' => '',
            'name' => $this->l('none'),
        ]);
        $this->fields_form['input'][] = [
            'type' => 'select',
            'multiple' => false,
            'class' => 'chosen',
            'label' => $this->l('Manufacturers'),
            'name' => 'manufacturers[]',
            'options' => [
                'query' => $manufacturers_list,
                'id' => 'id_manufacturer',
                'name' => 'name',
            ],
            'size' => 4,
        ];

        $this->fields_form['input'][] = [
            'type' => 'text',
            'label' => $this->l('Position'),
            'name' => 'position',
            'size' => 4,
        ];

        $this->fields_form['input'][] = [
            'type' => 'text',
            'label' => $this->l('Minimum'),
            'name' => 'minimum',
            'size' => 48,
        ];

        $this->fields_form['input'][] = [
            'type' => 'text',
            'label' => $this->l('Maximum'),
            'name' => 'maximum',
            'size' => 48,
        ];

        $this->fields_form['submit'] = [
            'title' => $this->l('Save'),
        ];

        $this->fields_form['buttons'] = [
            'save-and-stay' => [
                'title' => $this->l('Save then add another step'),
                'name' => 'submitAdd' . $this->table . 'AndStay',
                'type' => 'submit',
                'class' => 'btn btn-default pull-right',
                'icon' => 'process-icon-save',
            ],
        ];

        $this->fields_value['id_ndksteppingpack'] = (int) Tools::getValue(
            'id_ndksteppingpack'
        );

        // Override var of Controller
        $this->table = 'ndksteppingpack_step';
        $this->className = 'NdkSpackStep';
        $this->identifier = 'id_ndksteppingpack_step';
        $this->lang = true;

        // Create object Field
        if (
            !($obj = new NdkSpackStep((int) Tools::getValue($this->identifier)))
        ) {
            return;
        }

        $parent = new NdkSpack((int) Tools::getValue('id_ndksteppingpack'));

        return parent::renderForm();
    }

    public function renderView()
    {
        if ($id = Tools::getValue('id_ndksteppingpack')) {
            $this->table = 'ndksteppingpack_step';
            $this->className = 'NdkSpackStep';
            $this->identifier = 'id_ndksteppingpack_step';
            $this->position_identifier = 'id_ndksteppingpack_step';
            $this->position_group_identifier = 'id_ndksteppingpack';
            $this->list_id = 'id_ndksteppingpack_step';
            $this->lang = true;

            $this->_defaultOrderBy = 'position';

            $this->context->smarty->assign([
                'current' => self::$currentIndex .
                    '&id_ndksteppingpack=' .
                    (int) $id .
                    '&viewndksteppingpack',
            ]);

            if (!Validate::isLoadedObject($obj = new NdkSpack((int) $id))) {
                $this->errors[] =
                    Tools::displayError(
                        'An error occurred while updating the status for an object.'
                    ) .
                    ' <b>' .
                    $this->table .
                    '</b> ' .
                    Tools::displayError('(cannot load object)');

                return;
            }

            $this->name = $obj->name;
            $this->fields_list = [
                'id_ndksteppingpack_step' => [
                    'title' => $this->l('ID'),
                    'align' => 'center',
                    'class' => 'fixed-width-xs',
                ],
                'name' => [
                    'title' => $this->l('Name'),
                    'width' => 'auto',
                    'filter_key' => 'a!name',
                    'lang' => true,
                ],
                'position' => [
                    'title' => $this->l('Position'),
                    'width' => 'auto',
                    'filter_key' => 'a!position',
                ],
            ];

            $this->addRowAction('edit');
            $this->addRowAction('delete');

            $this->_where = 'AND a.`id_ndksteppingpack` = ' . (int) $id;
            // $this->_orderBy = 'id_ndksteppingpack_step';

            self::$currentIndex =
                self::$currentIndex .
                '&id_ndksteppingpack=' .
                (int) $id .
                '&viewndksteppingpack';
            // $this->processFilter();
            return parent::renderList();
        }
    }

    protected function afterUpdate($object)
    {
        if ('ndksteppingpack_step' == $this->table) {
            $parent = new NdkSpack($object->id_ndksteppingpack);
            $this->setCartRule($object, $parent);
        }

        if ('ndksteppingpack' == $this->table) {
            $languages = Language::getLanguages(false);
            $cart_rule = new CartRule($object->id_cart_rule);
            $cart_rule->reduction_amount = $object->reduction_amount;
            $cart_rule->reduction_percent = $object->reduction_percent;
            $cart_rule->product_restriction = 1;
            $cart_rule->date_from = date('Y-m-d H:i:s', strtotime('-1 days'));
            $cart_rule->date_to = '2040-01-01 10:10:10';
            $cart_rule->date_add = date('Y-m-d H:i:s');
            $cart_rule->date_upd = date('Y-m-d H:i:s');
            foreach ($languages as $lang) {
                $cart_rule->name[$lang['id_lang']] =
                    $object->name[$lang['id_lang']];
            }
            $cart_rule->update();
            if (1 == $object->type) {
                $object->createProductPack($object);
            }
        }

        return parent::afterUpdate($object);
    }

    protected function afterAdd($object)
    {
        if ('ndksteppingpack_step' == $this->table) {
            $parent = new NdkSpack($object->id_ndksteppingpack);
            $this->setCartRule($object, $parent);
        }
        if ('ndksteppingpack' == $this->table) {
            $languages = Language::getLanguages(false);

            $cart_rule = new CartRule();
            $cart_rule->reduction_amount = $object->reduction_amount;
            $cart_rule->reduction_percent = $object->reduction_percent;
            $cart_rule->product_restriction = 1;
            $cart_rule->date_from = date('Y-m-d H:i:s', strtotime('-1 days'));
            $cart_rule->date_to = '2040-01-01 10:10:10';
            $cart_rule->date_add = date('Y-m-d H:i:s');
            $cart_rule->date_upd = date('Y-m-d H:i:s');
            foreach ($languages as $lang) {
                $cart_rule->name[$lang['id_lang']] = Tools::getValue(
                    'name[' . $lang['id_lang'] . ']'
                );
            }
            $cart_rule->save();
            $object->id_cart_rule = $cart_rule->id;
            $object->update();
            if (1 == $object->type) {
                $object->createProductPack($object);
            }
        }

        return parent::afterAdd($object);
    }

    protected function afterImageUpload()
    {
        /* Generate image with differents size */
        if (!($obj = $this->loadObject(true))) {
            return;
        }

        if ($obj->id && isset($_FILES['image'])) {
            $base_img_path =
                _PS_IMG_DIR_ . 'scenes/ndksp/' . $obj->id . '.jpg';
            // ImageManager::resize($base_img_path, _PS_IMG_DIR_.'scenes/'.'ndkcf/thumbs/'.$obj->id.'.jpg', 458, 458);

            $images_types = ImageType::getImagesTypes('products');

            foreach ($images_types as $k => $image_type) {
                ImageManager::resize(
                    $base_img_path,
                    _PS_IMG_DIR_ .
                        'scenes/' .
                        'ndksp/thumbs/' .
                        $obj->id .
                        '-' .
                        Tools::stripslashes($image_type['name']) .
                        '.jpg',
                    (int) $image_type['width'],
                    (int) $image_type['height']
                );
            }
        }

        return true;
    }

    public function renderForm()
    {
        $this->table = 'ndksteppingpack';
        $this->identifier = 'id_ndksteppingpack';
        $cart_rules = NdkSpack::getCartRules($this->context->employee->id_lang);
        array_push($cart_rules, [
            'id_cart_rule' => 0,
            'name' => $this->l('none'),
        ]);
        $link = new Link();

        $packlink = NdkSpack::linkPack(
            Tools::getValue('id_ndksteppingpack'),
            null
        );
        $this->addJqueryPlugin(['autocomplete']);
        $this->addJs(_MODULE_DIR_ . 'ndksteppingpack/views/js/admin.js');

        $types = [
            ['id_type' => 0, 'name' => $this->l('Cart rule')],
            ['id_type' => 1, 'name' => $this->l('Product pack')],
        ];
        if (!($obj = new NdkSpack((int) Tools::getValue($this->identifier)))) {
            return;
        }

        if ($obj->type > 0) {
            if ((float) _PS_VERSION_ > 1.6) {
                $prodlink =
                    '<a class="btn btn-default btn" href="' .
                    $this->context->link->getAdminLink('AdminProducts', true, [
                        'id_product' => (int) $obj->id_pack_prod,
                    ]) .
                    '" target="_blank">' .
                    $this->l('Manage created product pack') .
                    '</a>';
            } else {
                $prodlink =
                    '<a class="btn btn-default btn" href="' .
                    $this->context->link->getAdminLink('AdminProducts') .
                    '&id_product=' .
                    (int) $obj->id_pack_prod .
                    '&updateproduct" target="_blank">' .
                    $this->l('Manage created product pack') .
                    '</a>';
            }
        } else {
            $prodlink = '';
        }

        if ($obj->id > 0) {
            $additionnals =
                '<img width="300" height="auto" src="../img/scenes/' .
                'ndksp/' .
                $obj->id .
                '.jpg" />';
        } else {
            $additionnals = '';
        }

        $this->fields_form = [
            'legend' => [
                'title' => $this->l('Ndk Stepping Pack'),
            ],
            'submit' => [
                'title' => $this->l('Save'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'name',
                    'lang' => true,
                    'size' => 48,
                    'required' => true,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                    'desc' => '<a class="btn btn-default btn" href="' .
                        $packlink .
                        '" target="_blank">' .
                        $this->l('View pack on website') .
                        '</a>' .
                        $prodlink,
                ],

                [
                    'type' => 'select',
                    'label' => $this->l('Type'),
                    'name' => 'type',
                    'hint' => $this->l('Select the type of field.'),
                    'required' => true,
                    'options' => [
                        'query' => $types,
                        'id' => 'id_type',
                        'name' => 'name',
                    ],
                    'desc' => $this->l(
                        'Type "Cart rule" wil create a cart rule automatically.'
                    ) .
                        ' <br>' .
                        $this->l(
                            'Type "Product Pack" wil create a customizable product width a fixed price.'
                        ),
                ],

                [
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes'),
                        ],
                        [
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No'),
                        ],
                    ],
                ],

                [
                    'type' => 'file',
                    'label' => $this->l('Image:'),
                    'name' => 'image',
                    'display_image' => true,
                    'desc' => $additionnals,
                ],
                [
                    'type' => 'textarea',
                    'label' => $this->l('Short description'),
                    'name' => 'short_description',
                    'lang' => true,
                    'autoload_rte' => true,
                    'required' => true,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                ],

                [
                    'type' => 'textarea',
                    'label' => $this->l('Description'),
                    'name' => 'description',
                    'lang' => true,
                    'autoload_rte' => true,
                    'required' => true,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Reduction amount'),
                    'name' => 'reduction_amount',
                    'size' => 5,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Reduction percent'),
                    'name' => 'reduction_percent',
                    'size' => 3,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Fixed price (Tax excl.)'),
                    'name' => 'fixed_price',
                    'size' => 3,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                ],

                [
                    'type' => 'hidden',
                    'label' => $this->l('Join cart rule'),
                    'name' => 'id_cart_rule',
                    'required' => true,
                    'options' => [
                        'query' => $cart_rules,
                        'id' => 'id_cart_rule',
                        'name' => 'name',
                    ],
                    'desc' => $this->l(
                        'will display informations of cart rule'
                    ),
                ],
            ],
        ];

        $obj = $this->loadObject(true);

        $selected_cat = [];
        if ($obj->display_categories) {
            $cats = explode(',', $obj->display_categories);
            foreach ($cats as $key => $value) {
                $selected_cat[] = (int) $value;
            }
        }

        $root = Category::getRootCategory();
        $tree = new HelperTreeCategories('categories-tree'); // The string in param is the ID used by the generated tree
        $tree
            ->setUseCheckBox(true)
            ->setAttribute('is_category_filter', $root->id)
            ->setRootCategory($root->id)
            ->setSelectedCategories($selected_cat)
            ->setUseSearch(true)
            ->setInputName('false_display_categories'); // Set the name of input. The option "name" of $fields_form doesn't seem to work with "categories_select" type
        $categoryTree = $tree->render();

        $this->fields_form['input'][] = [
            'type' => 'categories_select',
            'label' => $this->l('Display on theses categories'),
            'desc' => $this->l(
                'Select categories where you want to promote your packs.'
            ),
            'name' => 'false_display_categories',
            'category_tree' => $categoryTree,
            'class' => 'implode_input',
            'form_group_class' => 'ndk-crossselling',
        ];

        $this->fields_form['input'][] = [
            'type' => 'hidden',
            'name' => 'display_categories',
            'form_group_class' => 'ndk-crossselling',
        ];

        if (Shop::isFeatureActive()) {
            // We get all associated shops for all attribute groups, because we will disable group shops
            // for attributes that the selected attribute group don't support
            $sql =
                'SELECT id_ndksteppingpack, id_shop FROM ' .
                _DB_PREFIX_ .
                'ndksteppingpack';
            $associations = [];
            foreach (Db::getInstance()->executeS($sql) as $row) {
                $associations[$row['id_ndksteppingpack']][] = $row['id_shop'];
            }

            $this->fields_form['input'][] = [
                'type' => 'shop',
                'label' => $this->l('Shop association'),
                'name' => 'checkBoxShopAsso',
                'values' => Shop::getTree(),
            ];
        } else {
            $associations = [];
        }

        $this->fields_form['shop_associations'] = json_encode(
            $associations
        );

        $this->fields_form['submit'] = [
            'title' => $this->l('Save'),
        ];

        if (!($obj = $this->loadObject(true))) {
            return;
        }

        return parent::renderForm();
    }

    public function postProcess()
    {
        $selected_cat = [];
        if (Tools::isSubmit('categories')) {
            foreach (Tools::getValue('categories') as $row) {
                $selected_cat[] = $row;
            }
        }

        $_POST['categories'] = implode(',', $selected_cat);

        if (Tools::isSubmit('suppliers')) {
            $_POST['suppliers'] = implode(',', Tools::getValue('suppliers'));
        }

        if (Tools::isSubmit('manufacturers')) {
            $_POST['manufacturers'] = implode(
                ',',
                Tools::getValue('manufacturers')
            );
        }

        if (
            !Tools::getValue($this->identifier)
            && Tools::getValue('id_ndksteppingpack_step')
            && !Tools::getValue('ndksteppingpack_stepOrderby')
        ) {
            // Override var of Controller
            $this->table = 'ndksteppingpack_step';
            $this->className = 'NdkSpackStep';
            $this->identifier = 'id_ndksteppingpack_step';
        }

        // If it's an attribute, load object Attribute()
        if (
            Tools::getValue('updatendksteppingpack_step')
            || Tools::getValue('deletendksteppingpack_step')
            || Tools::getValue('submitAddndksteppingpack_step')
        ) {
            /*if ($this->tabAccess['edit'] !== '1')
                        $this->errors[] = Tools::displayError('You do not have permission to edit this.');
                    elseif (!$object = new NdkSpackStep((int)Tools::getValue($this->identifier)))
                        $this->errors[] = Tools::displayError('An error occurred while updating the status for an object.').' <b>'.$this->table.'</b> '.Tools::displayError('(cannot load object)');*/

            if (
                Tools::getValue('deletndksteppingpack_step')
                && Tools::getValue('id_ndksteppingpack_step')
            ) {
                if (!$object->delete()) {
                    $this->errors[] = Tools::displayError(
                        'Failed to delete the value.'
                    );
                } else {
                    Tools::redirectAdmin(
                        self::$currentIndex .
                            '&conf=1&token=' .
                            Tools::getAdminTokenLite('AdminNdkCustomFields')
                    );
                }
            } elseif (Tools::isSubmit('submitAddndksteppingpack_step')) {
                $this->action = 'save';
                $id_ndksteppingpack_step = (int) Tools::getValue(
                    'id_ndksteppingpack_step'
                );
                // Adding last position to the attribute if not exist

                $this->processSave($this->token);
            }
        } else {
            if (Tools::getValue('way')) {
                $_POST['id_ndksteppingpack'] = Tools::getValue('id');
            }
            if (Tools::getValue('submitDel' . $this->table)) {
                if ('1' === $this->tabAccess['delete']) {
                    if (Tools::getValue($this->table . 'Box')) {
                        $object = new $this->className();
                        if (
                            $object->deleteSelection(
                                Tools::getValue($this->table . 'Box')
                            )
                        ) {
                            Tools::redirectAdmin(
                                self::$currentIndex .
                                    '&conf=2' .
                                    '&token=' .
                                    $this->token
                            );
                        }
                        $this->errors[] = Tools::displayError(
                            'An error occurred while deleting this selection.'
                        );
                    } else {
                        $this->errors[] = Tools::displayError(
                            'You must select at least one element to delete.'
                        );
                    }
                } else {
                    $this->errors[] = Tools::displayError(
                        'You do not have permission to delete this.'
                    );
                }
                // clean position after delete
            } elseif (Tools::isSubmit('submitAdd' . $this->table)) {
                $id_ndksteppingpack = (int) Tools::getValue(
                    'id_ndksteppingpack'
                );
                // Adding last position to the attribute if not exist
                if ($id_ndksteppingpack <= 0) {
                    $sql =
                        'SELECT `position`+1
                                    FROM `' .
                        _DB_PREFIX_ .
                        'ndksteppingpack`
                                    WHERE `id_ndksteppingpack` = ' .
                        (int) Tools::getValue('id_ndksteppingpack') .
                        '
                                    ORDER BY position DESC';
                    // set the position of the new group attribute in $_POST for postProcess() method
                    $_POST['position'] = Db::getInstance(
                        _PS_USE_SQL_SLAVE_
                    )->getValue($sql);
                }
                // $_POST['id_parent'] = 0;
                $this->processSave($this->token);

                // clean \n\r characters
                foreach ($_POST as $key => $value) {
                    if (preg_match('/^name_/Ui', $key)) {
                        $_POST[$key] = str_replace(
                            '\n',
                            '',
                            str_replace('\r', '', $value)
                        );
                    }
                }
                // parent::postProcess();
            } elseif (Tools::getIsset('active' . $this->table)) {
                $id_ndksteppingpack = (int) Tools::getValue(
                    'id_ndksteppingpack'
                );
                // Adding last position to the attribute if not exist
                if ($id_ndksteppingpack > 0) {
                    // $sql = 'UPDATE '._DB_PREFIX_.$this->table . ' SET active = 1 WHERE active = 0 AND id_ndksteppingpack = '.$id_ndksteppingpack;

                    Db::getInstance()->execute(
                        '
                            UPDATE ' .
                            _DB_PREFIX_ .
                            $this->table .
                            ' 
                            SET active = case
                               when active = 0 then 1
                               else 0
                               end
                            WHERE id_ndksteppingpack = ' .
                            $id_ndksteppingpack
                    );
                }
            } elseif (
                Tools::getIsset('submitBulkdisableSelection' . $this->table)
            ) {
                foreach (
                    Tools::getValue($this->table . 'Box')
                    as $key => $id_ndksteppingpack
                ) {
                    if ($id_ndksteppingpack > 0) {
                        // $sql = 'UPDATE '._DB_PREFIX_.$this->table . ' SET active = 1 WHERE active = 0 AND id_ndksteppingpack = '.$id_ndksteppingpack;

                        Db::getInstance()->execute(
                            '
                                UPDATE ' .
                                _DB_PREFIX_ .
                                $this->table .
                                ' 
                                SET active = 0 WHERE id_ndksteppingpack = ' .
                                $id_ndksteppingpack
                        );
                    }
                }
            } elseif (
                Tools::getIsset('submitBulkenableSelection' . $this->table)
            ) {
                foreach (
                    Tools::getValue($this->table . 'Box')
                    as $key => $id_ndksteppingpack
                ) {
                    if ($id_ndksteppingpack > 0) {
                        // $sql = 'UPDATE '._DB_PREFIX_.$this->table . ' SET active = 1 WHERE active = 0 AND id_ndksteppingpack = '.$id_ndksteppingpack;

                        Db::getInstance()->execute(
                            '
                                UPDATE ' .
                                _DB_PREFIX_ .
                                $this->table .
                                ' 
                                SET active = 1 WHERE id_ndksteppingpack = ' .
                                $id_ndksteppingpack
                        );
                    }
                }
            } else {
                parent::postProcess();
            }
        }
    }

    public function ajaxProcessUpdatePositions()
    {
        $way = (int) Tools::getValue('way');
        $id_ndksteppingpack = (int) Tools::getValue('id_ndksteppingpack');
        $positions = Tools::getValue('ndksteppingpack');

        $new_positions = [];
        foreach ($positions as $k => $v) {
            if (4 == count(explode('_', $v))) {
                $new_positions[] = $v;
            }
        }

        foreach ($new_positions as $position => $value) {
            $pos = explode('_', $value);

            if (isset($pos[2]) && (int) $pos[2] === $id_ndksteppingpack) {
                if ($ndksteppingpack = new NdkSpack((int) $pos[2])) {
                    if (
                        isset($position)
                        && $ndksteppingpack->updatePosition($way, $position)
                    ) {
                        echo 'ok position ' .
                            (int) $position .
                            ' for field group ' .
                            (int) $pos[2] .
                            '\r\n';
                    } else {
                        echo '{"hasError" : true, "errors" : "Can not update the ' .
                            (int) $ndksteppingpack .
                            ' field group to position ' .
                            (int) $position .
                            ' "}';
                    }
                } else {
                    echo '{"hasError" : true, "errors" : "The (' .
                        (int) $id_ndksteppingpack .
                        ') field group cannot be loaded."}';
                }

                break;
            }
        }
    }

    public function initProcess()
    {
        if (Tools::getIsset('query_ajax_request')) {
            return $this->displayAjaxNdkAction();
        }
        $this->setTypeValues();

        if (Tools::getIsset('viewndksteppingpack')) {
            $this->list_id = 'ndksteppingpack_step';

            /*if (Tools::getIsset($_POST['submitReset'.$this->list_id]))
             $this->processResetFilters();*/
        } else {
            $this->list_id = 'ndksteppingpack';
        }

        parent::initProcess();

        if ('ndksteppingpack_step' == $this->table) {
            $this->display = 'editndksteppingpack_step';
            $this->id_ndksteppingpack_step = (int) Tools::getValue(
                'id_ndksteppingpack_step'
            );
        }
    }

    protected function setTypeValues()
    {
        if (
            Tools::isSubmit('updatendksteppingpack_step')
            || Tools::isSubmit('deletendksteppingpack_step')
            || Tools::isSubmit('submitAddndksteppingpack_step')
            || Tools::isSubmit('submitBulkdeletevalue')
        ) {
            $this->table = 'ndksteppingpack_step';
            $this->className = 'NdkSpackStep';
            $this->identifier = 'id_ndksteppingpack_step';
        }
    }

    public function addMetaTitle($entry)
    {
        // Only add entry if the meta title was not forced.
        if (is_array($this->meta_title)) {
            $this->meta_title[] = $entry;
        }
    }

    public function setCartRule($object, $parent)
    {
        $cart_rule = new CartRule((int) $parent->id_cart_rule);
        if (0 == $parent->reduction_percent && 0 == $parent->reduction_amount || 0 != (int) $parent->type) {
            $cart_rule->delete();
            $parent->id_cart_rule = 0;
            $parent->save();

            return true;
        }

        $cart_rule->reduction_amount = $parent->reduction_amount;
        $cart_rule->reduction_percent = $parent->reduction_percent;
        $cart_rule->product_restriction = 1;
        $cart_rule->reduction_product = -2;
        $cart_rule->reduction_tax = 1;
        $cart_rule->quantity = 999999999;
        $cart_rule->quantity_per_user = 999999999;
        $cart_rule->date_from = date('Y-m-d H:i:s', strtotime('-1 days'));
        $cart_rule->date_to = date('Y-m-d H:i:s', strtotime('+2 years'));
        $cart_rule->date_add = date('Y-m-d H:i:s');
        $cart_rule->date_upd = date('Y-m-d H:i:s');

        $languages = Language::getLanguages(false);
        if ($parent->reduction_percent > 0) {
            $discount_label = $parent->reduction_percent . '%';
        } else {
            $discount_label = Tools::displayPrice($parent->reduction_amount);
            $cart_rule->reduction_product = 0;
        }

        foreach ($languages as $lang) {
            $cart_rule->name[$lang['id_lang']] =
            $parent->name[$lang['id_lang']] . ' (-' . $discount_label . ')';
        }
        $cart_rule->save();
        $parent->id_cart_rule = $cart_rule->id;
        $parent->update();

        // on supprimes les règles existantes avant
        $this->deleteProductRules((int) $cart_rule->id);
        // on enlève le caractère cumulable
        Db::getInstance()->execute(
            'DELETE FROM ' . _DB_PREFIX_ . 'cart_rule_combination  WHERE id_cart_rule_1 = ' . (int) $cart_rule->id . ' OR id_cart_rule_2 = ' .
                (int) $cart_rule->id
        );

        foreach ($parent->getPAckSteps() as $step) {
            $stepObj = new NdkSpackStep((int) $step['id']);
            if (0 == $stepObj->optionnal) {
                $this->addStepCartRules($stepObj, $parent, $cart_rule);
            }
        }
    }

    public function deleteProductRules($id_cart_rule)
    {
        $groups = Db::getInstance()->executeS('
        SELECT id_product_rule_group as id
        FROM ' . _DB_PREFIX_ . 'cart_rule_product_rule_group
        WHERE id_cart_rule = ' . (int) $id_cart_rule);

        // dump($groups);die();
        foreach ($groups as $group) {
            $rules = Db::getInstance()->executeS('
            SELECT id_product_rule as id
            FROM ' . _DB_PREFIX_ . 'cart_rule_product_rule
            WHERE id_product_rule_group = ' . (int) $group['id']);

            foreach ($rules as $rule) {
                // dump($rule);
                Db::getInstance()->execute(
                    'DELETE FROM ' . _DB_PREFIX_ . 'cart_rule_product_rule_value WHERE id_product_rule = ' . (int) $rule['id']
                );
            }

            Db::getInstance()->execute(
                'DELETE FROM ' . _DB_PREFIX_ . 'cart_rule_product_rule WHERE id_product_rule_group = ' . (int) $group['id']
            );
        }
        Db::getInstance()->execute(
            'DELETE FROM ' . _DB_PREFIX_ . 'cart_rule_product_rule_group WHERE id_cart_rule = ' . (int) $id_cart_rule
        );

        // die();
    }

    public function addStepCartRules($object, $parent, $cart_rule)
    {
        // var_dump($object);
        Db::getInstance()->execute(
            'INSERT INTO `' .
                _DB_PREFIX_ .
                'cart_rule_product_rule_group` (`id_cart_rule`, `quantity`)
            VALUES (' .
                (int) $cart_rule->id .
                ', ' .
                (int) $object->minimum .
                ')'
        );

        $id_product_rule_group = Db::getInstance()->Insert_ID();
        $object->id_product_rule_group = $id_product_rule_group;
        $object->update();

        $type = 'products';

        Db::getInstance()->execute(
            'INSERT INTO `' .
                _DB_PREFIX_ .
                'cart_rule_product_rule` (`id_product_rule_group`, `type`)
            VALUES (' .
                (int) $id_product_rule_group .
                ', "' .
                pSQL($type) .
                '")'
        );
        $id_product_rule = Db::getInstance()->Insert_ID();
        // $object->id_product_rule_group = $id_product_rule;
        // $object->update();
        $pids = $object->getProducts(true);
        // dump($pids);
        // dump($id_product_rule);
        foreach ($pids as $prod) {
            Db::getInstance()->execute(
                'INSERT INTO `' .
                    _DB_PREFIX_ .
                    'cart_rule_product_rule_value` (`id_product_rule`, `id_item`) VALUES (' .
                    (int) $id_product_rule .
                    ', ' .
                    (int) $prod['id_product'] .
                    ')'
            );
        }
    }

    public function processDelete()
    {
        $object = parent::processDelete();
        $cart_rule = new CartRule($object->id_cart_rule);
        $cart_rule->delete();
    }

    public function displayAjaxNdkAction()
    {
        $additionnals = '';

        if ('ajaxGetProducts' == Tools::getValue('action')) {
            $query = Tools::getValue('q', false);
            if (!$query || '' == $query || Tools::strlen($query) < 1) {
                exit;
            }

            if ($pos = strpos($query, ' (ref:')) {
                $query = Tools::substr($query, 0, $pos);
            }

            $excludeIds = Tools::getValue('excludeIds', false);
            if ($excludeIds && 'NaN' != $excludeIds) {
                $excludeIds = implode(
                    ',',
                    array_map('intval', explode(',', $excludeIds))
                );
            } else {
                $excludeIds = '';
            }

            // Excluding downloadable products from packs because download from pack is not supported
            $forceJson = false;
            $disableCombination = true;
            $excludeVirtuals = 'true' == Tools::getValue('excludeVirtuals');
            $exclude_packs = 'true' == Tools::getValue('exclude_packs');

            $context = Context::getContext();

            $sql =
                'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, image_shop.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
                        FROM `' .
                _DB_PREFIX_ .
                'product` p
                        ' .
                Shop::addSqlAssociation('product', 'p') .
                '
                        LEFT JOIN `' .
                _DB_PREFIX_ .
                'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' .
                (int) $context->language->id .
                Shop::addSqlRestrictionOnLang('pl') .
                ')
                        LEFT JOIN `' .
                _DB_PREFIX_ .
                'image_shop` image_shop
                            ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' .
                (int) $context->shop->id .
                ')
                        LEFT JOIN `' .
                _DB_PREFIX_ .
                'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' .
                (int) $context->language->id .
                ')
                        WHERE (pl.name LIKE \'%' .
                pSQL($query) .
                '%\' OR p.reference LIKE \'%' .
                pSQL($query) .
                '%\')' .
                (!empty($excludeIds)
                    ? ' AND p.id_product NOT IN (' . $excludeIds . ') '
                    : ' ') .
                ($excludeVirtuals
                    ? 'AND NOT EXISTS (SELECT 1 FROM `' .
                        _DB_PREFIX_ .
                        'product_download` pd WHERE (pd.id_product = p.id_product))'
                    : '') .
                ($exclude_packs
                    ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)'
                    : '') .
                ' GROUP BY p.id_product';

            $items = Db::getInstance()->executeS($sql);

            if ($items && ($disableCombination || $excludeIds)) {
                $results = [];
                foreach ($items as $item) {
                    if (!$forceJson) {
                        $item['name'] = str_replace(
                            '|',
                            '&#124;',
                            $item['name']
                        );
                        $results[] =
                            trim($item['name']) .
                            (!empty($item['reference'])
                                ? ' (ref: ' . $item['reference'] . ')'
                                : '') .
                            '|' .
                            (int) $item['id_product'];
                    } else {
                        $results[] = [
                            'id' => $item['id_product'],
                            'name' => $item['name'] .
                                (!empty($item['reference'])
                                    ? ' (ref: ' . $item['reference'] . ')'
                                    : ''),
                            'ref' => !empty($item['reference'])
                                ? $item['reference']
                                : '',
                            'image' => str_replace(
                                'http://',
                                Tools::getShopProtocol(),
                                $context->link->getImageLink(
                                    $item['link_rewrite'],
                                    $item['id_image'],
                                    ImageType::getFormattedName('home')
                                )
                            ),
                        ];
                    }
                }

                if (!$forceJson) {
                    $this->ajaxRender(implode("\n", $results));
                } else {
                    $this->ajaxRender(json_encode($results));
                }
            } elseif ($items) {
                // packs
                $results = [];
                foreach ($items as $item) {
                    // check if product have combination
                    if (
                        Combination::isFeatureActive()
                        && $item['cache_default_attribute']
                    ) {
                        $sql =
                            'SELECT pa.`id_product_attribute`, pa.`reference`, ag.`id_attribute_group`, pai.`id_image`, agl.`name` AS group_name, al.`name` AS attribute_name,
                                        a.`id_attribute`
                                    FROM `' .
                            _DB_PREFIX_ .
                            'product_attribute` pa
                                    ' .
                            Shop::addSqlAssociation('product_attribute', 'pa') .
                            '
                                    LEFT JOIN `' .
                            _DB_PREFIX_ .
                            'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
                                    LEFT JOIN `' .
                            _DB_PREFIX_ .
                            'attribute` a ON a.`id_attribute` = pac.`id_attribute`
                                    LEFT JOIN `' .
                            _DB_PREFIX_ .
                            'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
                                    LEFT JOIN `' .
                            _DB_PREFIX_ .
                            'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ' .
                            (int) $context->language->id .
                            ')
                                    LEFT JOIN `' .
                            _DB_PREFIX_ .
                            'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ' .
                            (int) $context->language->id .
                            ')
                                    LEFT JOIN `' .
                            _DB_PREFIX_ .
                            'product_attribute_image` pai ON pai.`id_product_attribute` = pa.`id_product_attribute`
                                    WHERE pa.`id_product` = ' .
                            (int) $item['id_product'] .
                            '
                                    GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`
                                    ORDER BY pa.`id_product_attribute`';

                        $combinations = Db::getInstance()->executeS($sql);
                        if (!empty($combinations)) {
                            foreach ($combinations as $k => $combination) {
                                $results[$combination['id_product_attribute']][
                                    'id'
                                ] = $item['id_product'];
                                $results[$combination['id_product_attribute']][
                                    'id_product_attribute'
                                ] = $combination['id_product_attribute'];
                                !empty(
                                    $results[
                                        $combination['id_product_attribute']
                                    ]['name']
                                )
                                    ? ($results[
                                        $combination['id_product_attribute']
                                    ]['name'] .=
                                        ' ' .
                                        $combination['group_name'] .
                                        '-' .
                                        $combination['attribute_name'])
                                    : ($results[
                                        $combination['id_product_attribute']
                                    ]['name'] =
                                        $item['name'] .
                                        ' ' .
                                        $combination['group_name'] .
                                        '-' .
                                        $combination['attribute_name']);
                                if (!empty($combination['reference'])) {
                                    $results[
                                        $combination['id_product_attribute']
                                    ]['ref'] = $combination['reference'];
                                } else {
                                    $results[
                                        $combination['id_product_attribute']
                                    ]['ref'] = !empty($item['reference'])
                                        ? $item['reference']
                                        : '';
                                }
                                if (
                                    empty(
                                        $results[
                                            $combination['id_product_attribute']
                                        ]['image']
                                    )
                                ) {
                                    $results[
                                        $combination['id_product_attribute']
                                    ]['image'] = str_replace(
                                        'http://',
                                        Tools::getShopProtocol(),
                                        $context->link->getImageLink(
                                            $item['link_rewrite'],
                                            $combination['id_image'],
                                            ImageType::getFormattedName('home')
                                        )
                                    );
                                }
                            }
                        } else {
                            $results[] = [
                                'id' => $item['id_product'],
                                'name' => $item['name'],
                                'ref' => !empty($item['reference'])
                                    ? $item['reference']
                                    : '',
                                'image' => str_replace(
                                    'http://',
                                    Tools::getShopProtocol(),
                                    $context->link->getImageLink(
                                        $item['link_rewrite'],
                                        $item['id_image'],
                                        ImageType::getFormattedName('home')
                                    )
                                ),
                            ];
                        }
                    } else {
                        $results[] = [
                            'id' => $item['id_product'],
                            'name' => $item['name'],
                            'ref' => !empty($item['reference'])
                                ? $item['reference']
                                : '',
                            'image' => str_replace(
                                'http://',
                                Tools::getShopProtocol(),
                                $context->link->getImageLink(
                                    $item['link_rewrite'],
                                    $item['id_image'],
                                    ImageType::getFormattedName('home')
                                )
                            ),
                        ];
                    }
                }
                $this->ajaxRender(json_encode(array_values($results)));
            } else {
                $this->ajaxRender(json_encode([]));
            }
        }

        if (
            Tools::getValue('action')
            && 'modifyPost' == Tools::getValue('action')
        ) {
            $myvalues = [];
            $values = Tools::getValue('values');
            $values = str_replace(
                Tools::getValue('input_name'),
                '',
                Tools::getValue('values')
            );
            $values = json_decode($values, true);
            // var_dump($values);
            foreach ($values as $k => $v) {
                $new_k = str_replace(['[', ']'], '', $k);
                $myvalues[$new_k] = $v;
            }
            // $values = $myvalues;
            // var_dump($values);

            switch (Tools::getValue('function')) {
                case 'serialize':
                    $this->ajaxRender(
                        str_replace(['[', ']'], '', serialize($myvalues))
                    );
                    break;
                case 'implode':
                    $selected_values = [];
                    foreach ($values as $row) {
                        $selected_values[] = $row;
                    }
                    if (is_array($selected_values[0])) {
                        $this->ajaxRender(implode(',', $selected_values[0]));
                    } else {
                        $this->ajaxRender(implode(',', $selected_values));
                    }
                    break;
                default:
                    return true;
            }
        }
    }
}
