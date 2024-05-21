<?php
/******************
 * Vinova Themes  Framework for Prestashop 1.6.x 
 * @package   	novmegamenu
 * @version   	1.0
 * @author   	http://vinovathemes.com/
 * @copyright 	Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/

if (!defined('_PS_VERSION_'))
    exit;

include_once(_PS_MODULE_DIR_ . 'novmegamenu/class/Megamenu.php');


use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

class novmegamenu extends Module
{
    /**
     * Constructor
     */
    public function __construct()
    {
        global $currentIndex;
        $this->name = 'novmegamenu';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'VinovaThemes';
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Vinova Themes Mega Menu ');
        $this->description = $this->l('Vinova Themes  Version 1.0');
        $this->themeName = Context::getContext()->shop->theme_name;
        $this->icon_path = _PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/img/modules/' . $this->name . '/icon/';
    }

    public function install()
    {
        if (parent::install() && $this->registerHook('displayMegamenu') && $this->registerHook('displayHeader')) {
            return true;
        }
        return false;
    }


    public function uninstall()
    {
        if (!parent::uninstall())
            return false;
        return true;
    }

    public function createFolderIcon()
    {
        if (file_exists($this->icon_path) && is_dir($this->icon_path))
            return;
        if (!file_exists($this->icon_path) && !is_dir($this->icon_path)) {
            @mkdir(_PS_ALL_THEMES_DIR_ . $this->themeName . '/img/modules/', 0777, true);
            @mkdir(_PS_ALL_THEMES_DIR_ . $this->themeName . '/img/modules/' . $this->name . '/', 0777, true);
            @mkdir(_PS_ALL_THEMES_DIR_ . $this->themeName . '/img/modules/' . $this->name . '/icon/', 0777, true);
        }
    }

    public function getContent()
    {
        $html = '';
        if (Tools::isSubmit('savemegamenu') || Tools::isSubmit('savemegamenuandnew')) {
            $languages = Language::getLanguages(false);
            if ($id_novmegamenu = Tools::getValue('id_novmegamenu'))
                $object = new Mgmenu($id_novmegamenu);
            else
                $object = new Mgmenu();
            $input_lang = array('title', 'sub_title', 'url', 'html');
            foreach ($object as $key => $value) {
                if ($key != 'id' && $key != 'position' && $key != 'icon') {
                    if (in_array($key, $input_lang)) {
                        foreach ($languages as $language) {
                            if ($key == 'html')
                                $object->{$key}[$language['id_lang']] = base64_encode(Tools::jsonEncode(Tools::getValue($key . '_' . $language['id_lang'])));
                            else
                                $object->{$key}[$language['id_lang']] = Tools::getValue($key . '_' . $language['id_lang']);
                        }
                    } else
                        $object->{$key} = Tools::getValue($key);
                }

            }
            $object->id_shop = $this->context->shop->id;
            if ($object->type && $object->type != "html" && Tools::getValue("type_" . $object->type)) {
                $object->value = Tools::getValue("type_" . $object->type);
            }
            if (!Tools::getValue('id_novmegamenu'))
                $object->position = $object->getPositonMenu();
            if ($object->validateFields(false) && $object->validateFieldsLang(false)) {
                $object->save();
                $this->clearCache();
                if (isset($_FILES['icon']) && isset($_FILES['icon']['tmp_name']) && !empty($_FILES['icon']['tmp_name'])) {
                    if ($error = ImageManager::validateUpload($_FILES['icon']))
                        return false;
                    elseif (!($name = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['icon']['tmp_name'], $name))
                        return false;
                    elseif (!ImageManager::resize($name, $this->icon_path . $_FILES['icon']['name']))
                        return false;
                    unlink($name);
                    $object->icon = $_FILES['icon']['name'];
                    $object->save();
                    $this->clearCache();
                }
                if (Tools::isSubmit('savemegamenuandnew'))
                    Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&conf=4');
                else
                    Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&id_novmegamenu=' . $object->id . '&conf=4');
            } else
                $errors[] = $this->displayError($this->l('Save Error.'));
            if (isset($errors) and sizeof($errors))
                $html .= $this->displayError(implode('<br />', $errors));
            else
                $html .= $this->displayConfirmation($this->l('Save Success.'));

        } elseif (Tools::getValue('updatePosition') && Tools::getValue('serialized')) {
            $object = new Mgmenu();
            $serialized = Tools::getValue('serialized');
            $lists = Tools::jsonDecode($serialized, true);
            $level = 1;
            $id_parent = 1;
            $object->updatePositions($lists, $level, $id_parent);
            $this->clearCache();
            die();
        } elseif (Tools::getValue('duplicatedata')) {
            $object = new Mgmenu((int) Tools::getValue('idnovmegamenu'));
            $object->id = null;
            $object->id_novmegamenu = null;
            $object->active = 0;
            $object->id_parent = 1;
            $object->position = $object->getPositonMenu();
            $object->add();
            $this->clearCache();
            die();
        } elseif (Tools::getValue('deletedata')) {
            $idnovmegamenu = Tools::getValue('idnovmegamenu') ? Tools::getValue('idnovmegamenu') : 0;
            Mgmenu::deleteMenu($idnovmegamenu);
            $this->clearCache();
            die();
        } elseif (Tools::getValue('changestatus')) {
            $idnovmegamenu = Tools::getValue('idnovmegamenu') ? Tools::getValue('idnovmegamenu') : 0;
            $object = new Mgmenu((int) $idnovmegamenu);
            if ($object->active == 0)
                $object->active = 1;
            else
                $object->active = 0;
            $object->update();
            $this->clearCache();
            die();
        }
        return $html . $this->displayForm();
    }

    /**
     * show novmegamenu item configuration.
     */
    protected function displayForm()
    {
        $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/novmegamenu/libs/js/jquery.nestable.js');
        $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/novmegamenu/libs/js/form.js');
        $this->context->controller->addCss(__PS_BASE_URI__ . 'modules/novmegamenu/libs/css/form.css');

        $id_lang = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        if ($id_novmegamenu = Tools::getValue('id_novmegamenu'))
            $obj = new Mgmenu($id_novmegamenu);
        else
            $obj = new Mgmenu();

        $tree = $obj->getTree(1, 1);
        $manufacturers = Manufacturer::getManufacturers(false, $id_lang, true);
        $suppliers = Supplier::getSuppliers(false, $id_lang, true);
        $cms = CMS::listCms($this->context->language->id, false, true);

        $child_menu = $obj->getTreeChildren(1);
        $check = 0;
        if ($child_menu) {
            foreach ($child_menu as &$child) {
                if ($child['id_novmegamenu'] == 1)
                    $check = 1;

                $level = '';
                for ($i = 1; $i <= $child['level']; $i++) {
                    $level .= '--';
                }
                $child['title'] = $level . $child['title'];
            }
        }

        if ($check == 0) {
            $root['id_novmegamenu'] = 1;
            $root['title'] = $this->l('Root');
            array_unshift($child_menu, $root);
        }

        $default_lang = (int) Configuration::get('PS_LANG_DEFAULT');

        $active = array(
            array(
                'id' => 'active_on',
                'value' => 1,
                'label' => $this->l('Enabled')
            ),
            array(
                'id' => 'active_off',
                'value' => 0,
                'label' => $this->l('Disabled')
            )
        );

        $sub_menu = array(
            array(
                'value' => 'yes',
                'label' => $this->l('Yes')
            ),
            array(
                'value' => 'no',
                'label' => $this->l('No')
            )
        );

        $type_product = array(
            array(
                'id' => 'new',
                'label' => $this->l('New')
            ),
            array(
                'id' => 'bestseller',
                'label' => $this->l('Bestseller')
            ),
            array(
                'id' => 'special',
                'label' => $this->l('Special')
            ),
            array(
                'id' => 'featured',
                'label' => $this->l('Featured')
            )
        );

        $type_icon = array(
            array(
                'value' => 'class',
                'label' => $this->l('Class')
            ),
            array(
                'value' => 'image',
                'label' => $this->l('Image')
            ),
            array(
                'value' => 'none',
                'label' => $this->l('None')
            )
        );

        $categories = (isset($obj->type) && $obj->type == 'category') ? $obj->value : 0;

        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Create Menu.'),
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'label' => $this->l('Megamenu ID'),
                    'name' => 'id_novmegamenu',
                    'default' => 0,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Title:'),
                    'name' => 'title',
                    'value' => true,
                    'lang' => true,
                    'required' => true,
                    'default' => '',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Submenu Title:'),
                    'name' => 'sub_title',
                    'value' => true,
                    'lang' => true,
                    'default' => '',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Parent ID'),
                    'name' => 'id_parent',
                    'options' => array(
                        'query' => $child_menu,
                        'id' => 'id_novmegamenu',
                        'name' => 'title'
                    ),
                    'default' => 1,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Title'),
                    'name' => 'show_title',
                    'values' => $active,
                    'default' => 1,

                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Sub Title'),
                    'name' => 'show_sub_title',
                    'values' => $active,
                    'default' => 1,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Menu Type'),
                    'name' => 'type',
                    'id' => 'type_menu',
                    'options' => array(
                        'query' => array(
                            array('id' => 'url', 'name' => $this->l('Url')),
                            array('id' => 'product', 'name' => $this->l('Product')),
                            array('id' => 'productlist', 'name' => $this->l('Product List')),
                            array('id' => 'manufacture', 'name' => $this->l('Manufacture')),
                            array('id' => 'all_manufacture', 'name' => $this->l('All Manufacture')),
                            array('id' => 'supplier', 'name' => $this->l('Supplier')),
                            array('id' => 'all_supplier', 'name' => $this->l('All Supplier')),
                            array('id' => 'cms', 'name' => $this->l('Cms')),
                            array('id' => 'html', 'name' => $this->l('Html')),
                            array('id' => 'category', 'name' => $this->l('Category')),
                            array('id' => 'title', 'name' => $this->l('Title'))

                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'default' => "url",

                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Product ID'),
                    'name' => 'type_product',
                    'id' => 'type_product',
                    'class' => 'type_group',
                    'default' => "",
                ),

                array(
                    'type' => 'select',
                    'label' => $this->l('Products List'),
                    'name' => 'type_productlist',
                    'options' => array(
                        'query' => $type_product,
                        'id' => 'id',
                        'name' => 'label'
                    ),
                    'default' => "new",
                    'class' => 'type_group',
                    'desc' => $this->l('Select Product Type')
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('CMS Type'),
                    'name' => 'type_cms',
                    'id' => 'type_cms',
                    'options' => array(
                        'query' => $cms,
                        'id' => 'id_cms',
                        'name' => 'meta_title'
                    ),
                    'default' => "",
                    'class' => 'type_group',
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('URL'),
                    'name' => 'url',
                    'id' => 'type_url',
                    'required' => true,
                    'lang' => true,
                    'class' => 'type_group_lang',
                    'default' => "#",
                ),
                array(
                    'type' => 'categories',
                    'label' => $this->l('Categories'),
                    'name' => 'type_category',
                    'default' => '',
                    'tree' => array(
                        'id' => 'categories',
                        'title' => 'Categories',
                        'selected_categories' => array($categories),
                        'use_search' => true,
                        'use_checkbox' => false
                    )
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Manufacture Type'),
                    'name' => 'type_manufacture',
                    'id' => 'type_manufacture',
                    'options' => array(
                        'query' => $manufacturers,
                        'id' => 'id_manufacturer',
                        'name' => 'name'
                    ),
                    'default' => "",
                    'class' => 'type_group',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Supplier Type'),
                    'name' => 'type_supplier',
                    'id' => 'type_supplier',
                    'options' => array(
                        'query' => $suppliers,
                        'id' => 'id_supplier',
                        'name' => 'name'
                    ),
                    'default' => "",
                    'class' => 'type_group',
                ),

                array(
                    'type' => 'textarea',
                    'label' => $this->l('Html'),
                    'name' => 'html',
                    'lang' => true,
                    'default' => '',
                    'autoload_rte' => true,
                    'class' => 'html_lang',
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Menu Class'),
                    'name' => 'menu_class',
                    'display_image' => true,
                    'default' => ''
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Width'),
                    'name' => 'width',
                    'id' => 'width',
                    'class' => 'width',
                    'default' => "",
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Type Class Icon'),
                    'name' => 'type_icon',
                    'options' => array(
                        'query' => $type_icon,
                        'id' => 'value',
                        'name' => 'label'
                    ),
                    'default' => 'none'
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l('Icon Image'),
                    'name' => 'icon',
                    'thumb' => '../themes/' . $this->themeName . '/assets/img/modules/' . $this->name . '/icon/' . $obj->icon,
                    'display_image' => false,
                    'default' => ''
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Icon Class'),
                    'name' => 'icon_class',
                    'default' => '',
                    'desc' => $this->l('Select icon in here')
                    . ' <a href="http://fontawesome.io/" target="_blank">http://fontawesome.io/</a> or your icon class'
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Sub Menu'),
                    'name' => 'sub_menu',
                    'options' => array(
                        'query' => $sub_menu,
                        'id' => 'value',
                        'name' => 'label'
                    ),
                    'default' => 'no',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Submenu Width'),
                    'name' => 'sub_width',
                    'id' => 'sub_width',
                    'class' => 'sub_width',
                    'default' => "",
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Group'),
                    'name' => 'group',
                    'values' => $active,
                    'default' => 0,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'values' => $active,
                    'default' => 1,
                ),

            ),
            'buttons' => array(
                array(
                    'title' => $this->l('Save'),
                    'icon' => 'process-icon-save',
                    'class' => 'button btn',
                    'type' => 'submit',
                    'name' => 'savemegamenu'
                ),
                array(
                    'title' => $this->l('Save And New'),
                    'icon' => 'process-icon-save',
                    'class' => 'button btn',
                    'type' => 'submit',
                    'name' => 'savemegamenuandnew'
                )
            )
        );


        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        foreach (Language::getLanguages(false) as $lang)
            $helper->languages[] = array(
                'id_lang' => $lang['id_lang'],
                'iso_code' => $lang['iso_code'],
                'name' => $lang['name'],
                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
            );

        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->displayName;
        $helper->submit_action = 'save' . $this->name;

        $id_novmegamenu = Tools::getValue('id_novmegamenu') ? (int) Tools::getValue('id_novmegamenu') : 0;
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues($id_novmegamenu),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        $action = AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules');
        $content = '';
        $content .= '<div class="col-md-7">' . $helper->generateForm($this->fields_form) . '</div>';
        $content .= '<div class="col-md-5"><div class="panel panel-default">
				<h3 class="panel-title">' . $this->l('List Link Megamenu') . '</h3><a class="btn btn-default" href="' . $helper->currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules') . '">' . $this->l('New') . '</a>'
            . '<div class="panel-content">' . $tree . '</div><hr><p><input type="button" value="' . $this->l('Update') . '" id="updateposition" data-loading-text="' . $this->l('Processing ...') . '" class="btn" name="updateposition"></p></div></div>';
        $content .= '<script type="text/javascript">var action="' . $action . '";</script></div>';
        $content .= '</div>';
        return $content;
    }
    public function getConfigFieldsValues($id_novmegamenu = 0)
    {
        $languages = Language::getLanguages(false);
        $fields = array();
        $object = new Mgmenu($id_novmegamenu);
        foreach ($this->fields_form as $field) {
            foreach ($field['form']['input'] as $input) {
                if (isset($object->{trim($input['name'])})) {
                    $data = $object->{trim($input['name'])};
                    if (isset($input['lang'])) {
                        foreach ($languages as $lang) {
                            $value = (isset($data[$lang['id_lang']]) && $data[$lang['id_lang']]) ? $data[$lang['id_lang']] : '';
                            if ($input['name'] == 'html')
                                $fields[$input['name']][$lang['id_lang']] = $value ? Tools::jsonDecode(base64_decode($value)) : $input['default'];
                            else
                                $fields[$input['name']][$lang['id_lang']] = $value ? $value : $input['default'];
                        }
                    } else {
                        if ($input['name'] == 'html')
                            $fields[trim($input['name'])] = $data ? Tools::jsonDecode(base64_decode($data)) : $input['default'];
                        else
                            $fields[trim($input['name'])] = $data ? $data : $input['default'];
                    }
                } else {
                    if (isset($input['lang'])) {
                        foreach ($languages as $lang) {
                            $fields[trim($input['name'])][$lang['id_lang']] = $input['default'];
                        }
                    } else {
                        $fields[trim($input['name'])] = $input['default'];
                    }
                }
                if ($input['name'] == "type_" . $object->type)
                    $fields[trim($input['name'])] = $object->value;
            }
        }
        $fields['show_sub_title'] = $object->show_sub_title;
        $fields['show_title'] = $object->show_title;
        $fields['active'] = $object->active;
        $fields['group'] = $object->group;
        return $fields;
    }


    public function hookDisplayTopColumn($params)
    {
        return $this->hookDisplayTop($params);
    }

    function hookDisplayHeaderRight($params)
    {
        return $this->hookDisplayTop($params);
    }

    function hookDisplayMegamenu($params)
    {
        return $this->hookDisplayTop($params);
    }

    function hookTopNavigation($params)
    {
        return $this->hookDisplayTop($params);
    }

    function hookDisplayPromoteTop($params)
    {
        return $this->hookDisplayTop($params);
    }

    function hookRightColumn($params)
    {
        return $this->hookDisplayTop($params);
    }

    function hookLeftColumn($params)
    {
        return $this->hookDisplayTop($params);
    }

    function hookdisplayHome($params)
    {
        return $this->hookDisplayTop($params);
    }


    public function hookDisplayTop($params)
    {
        $tpl = 'views/templates/hook/novmegamenu.tpl';
        // if (!$this->isCached($tpl, $this->getCacheId())) {
            global $link;
            $current_link = $link->getPageLink('', false, $this->context->language->id);
            $object = new Mgmenu();
            $mgmenu = $object->getMegamenu(1, 1);
            if ($this->context->customer->logged && ($this->context->controller->php_self == 'identity' || $this->context->controller->php_self == 'facturesCRM' || $this->context->controller->php_self == 'contratsCRM' || $this->context->controller->php_self == 'my-account' || $this->context->controller->php_self == 'history' || $this->context->controller->php_self == 'order-detail')) {

                if ($this->context->customer->ref_abonnement) {
                    $mgmenu = '<ul class="menu level1">
                    <li class="item "><a href="' . $link->getPageLink('my-account', true) . '" title="' . $this->trans('My Nety', [], 'Shop.Theme.Customeraccount') . '">' . $this->trans('My Nety', [], 'Shop.Theme.Customeraccount') . '</a></li>
                    <li class="item "><a href="' . $link->getPageLink('identity', true) . '" title="' . $this->trans('Mes informations', [], 'Shop.Theme.Customeraccount') . '">' . $this->trans('Mes informations', [], 'Shop.Theme.Customeraccount') . '</a> </li>
                    <li class="item "><a href="' . $link->getPageLink('facturesCRM', true) . '" rel="nofollow" title="' . $this->trans('My invoices', [], 'Shop.Theme.Customeraccount') . '">' . $this->trans('My invoices', [], 'Shop.Theme.Customeraccount') . ' </a></li>
                    <li class="item "><a href="' . $link->getPageLink('contratsCRM', true) . '" rel="nofollow" title="' . $this->trans('My contracts', [], 'Shop.Theme.Customeraccount') . '">' . $this->trans('My contracts', [], 'Shop.Theme.Customeraccount') . ' </a></li>
                    <li class="item "><a href="' . $link->getPageLink('history', true) . '" rel="nofollow" title="' . $this->trans('My orders', [], 'Shop.Theme.Customeraccount') . '">' . $this->trans('My orders', [], 'Shop.Theme.Customeraccount') . ' </a></li>
                    </ul>';
                } else {
                    
                    $mgmenu = '<ul class="menu level1">
                    <li class="item "><a href="' . $link->getPageLink('my-account', true) . '" title="' . $this->trans('My Nety', [], 'Shop.Theme.Customeraccount') . '">' . $this->trans('My Nety', [], 'Shop.Theme.Customeraccount') . '</a></li>
                    <li class="item "><a href="' . $link->getPageLink('identity', true) . '" title="' . $this->trans('Mes informations', [], 'Shop.Theme.Customeraccount') . '">' . $this->trans('Mes informations', [], 'Shop.Theme.Customeraccount') . '</a> </li>
                    <li class="item "><a href="' . $link->getPageLink('history', true) . '" rel="nofollow" title="' . $this->trans('My orders', [], 'Shop.Theme.Customeraccount') . '">' . $this->trans('My orders', [], 'Shop.Theme.Customeraccount') . ' </a></li>
                    </ul>';

                }
                
            }
            
            $this->smarty->assign('mgmenu', $mgmenu);
            $this->smarty->assign('current_link', $current_link);
            $this->smarty->assign('menu_type', $params['menu_type']);
            return $this->display(__FILE__, $tpl);
        // }
        // return $this->display(__FILE__, $tpl, $this->getCacheId());
    }

    public function hookdisplayHeader($params)
    {
        // if(file_exists(Context::getContext()->shop->theme_name . 'assets/css/modules/novmegamenu/novmegamenu.css'))
        // 	$this->context->controller->addCSS( Context::getContext()->shop->theme_name . 'assets/css/modules/novmegamenu/novmegamenu.css', 'all' );
        // else
        // 	$this->context->controller->addCSS( $this->_path.'novmegamenu.css', 'all' );
    }

    protected function getCacheId($name = null, $hook = '')
    {
        $cache_array = array(
            $name !== null ? $name : $this->name,
            $hook,
            date('Ymd'),
            (int) Tools::usingSecureMode(),
            (int) $this->context->shop->id,
            (int) Group::getCurrent()->id,
            (int) $this->context->language->id,
            (int) $this->context->currency->id,
            (int) $this->context->country->id,
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
        );
        return implode('|', $cache_array);
    }

    public function renderProductList($products)
    {
        $assembler = new ProductAssembler($this->context);
        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->context->getTranslator()
        );

        foreach ($products as &$product) {
            $product = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($product),
                $this->context->language
            );
        }
        $tpl = 'views/templates/hook/product.tpl';
        $this->smarty->assign('products', $products);
        return $this->display(__FILE__, $tpl);
    }

    public function clearCache()
    {
        $tpl = 'views/templates/hook/novmegamenu.tpl';
        $this->_clearCache($tpl);
    }

}