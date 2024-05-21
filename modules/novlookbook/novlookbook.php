<?php
/**
 * Vinova Themes Framework for Prestashop 1.6.x
 * @author      http://vinovathemes.com/
 * @copyright   Copyright (C) October 2017 vinovathemes.com <@email:vinovathemes@gmail.com>
 * @license   GNU General Public License version 1
 * @version     1.0
 * @package     novlookbook
 * <info@vinovathemes.com>.All rights reserved.
 **/

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once(_PS_MODULE_DIR_.'novlookbook/lookbook.php');

class NovLookbook extends Module
{
    private $_html = '';
    public function __construct()
    {
        $this->name = 'novlookbook';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'VinovaThemes';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Vinova Lookbook for your homepage');
        $this->description = $this->l('Adds an Lookbook to your homepage.');
        $this->ps_versions_compliancy = array('min' => '1.6.0.4', 'max' => _PS_VERSION_);
    }

    /**
     * @see Module::install()
     */
    public function install()
    {
        /* Adds Module */
        if (parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('actionShopDataDuplication')
        ) {
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        /* Deletes Module */
        if (parent::uninstall()) {
            return true;
        }

        return false;
    }

    public function getContent()
    {
        $this->_html .= $this->headerHTML();
        /* Validate & process */
        if (Tools::isSubmit('submitSlide') || Tools::isSubmit('delete_id_slide') || Tools::isSubmit('changeStatus') || Tools::isSubmit('submitSlider')) {
            if ($this->_postValidation()) {
                $this->_postProcess();
                $this->_html .= $this->renderList();
            } else {
                $this->_html .= $this->renderAddForm();
            }
        } elseif (Tools::isSubmit('addSlide') || (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide')))) {
            $this->_html .= $this->renderAddForm();
        } else {
            $this->_html .= $this->renderList();
        }
        return $this->_html;
    }

    private function _postValidation()
    {
        $errors = array();

        if (Tools::isSubmit('changeStatus')) {
            if (!Validate::isInt(Tools::getValue('id_slide'))) {
                $errors[] = $this->l('Invalid slide');
            }
        } elseif (Tools::isSubmit('submitSlide')) {
            /* Checks state (active) */
            if (!Validate::isInt(Tools::getValue('active_slide')) || (Tools::getValue('active_slide') != 0 && Tools::getValue('active_slide') != 1)) {
                $errors[] = $this->l('Invalid slide state.');
            }
            /* Checks position */
            if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0)) {
                $errors[] = $this->l('Invalid slide position.');
            }
            /* Checks width */
            if (!Validate::isInt(Tools::getValue('width')) || (Tools::getValue('width') < 0)) {
                $errors[] = $this->l('Invalid slide width.');
            }
            /* Checks height */
            if (!Validate::isInt(Tools::getValue('height')) || (Tools::getValue('height') < 0)) {
                $errors[] = $this->l('Invalid slide height.');
            }
            /* If edit : checks id_slide */

            if (Tools::getValue('image') != null && !Validate::isFileName(Tools::getValue('image'))) {
                $errors[] = $this->l('Invalid filename.');
            }

            if (Tools::isSubmit('id_slide')) {
                //d(var_dump(Tools::getValue('id_slide')));
                if (!Validate::isInt(Tools::getValue('id_slide')) && !$this->slideExists(Tools::getValue('id_slide'))) {
                    $errors[] = $this->l('Invalid slide ID');
                }
            }

            if (!Tools::isSubmit('has_picture') && (!isset($_FILES['image']) || empty($_FILES['image']['tmp_name']))) {
                $errors[] = $this->l('The image is not set.');
            }
            if (Tools::getValue('image_old') && !Validate::isFileName(Tools::getValue('image_old'))) {
                $errors[] = $this->l('The image is not set.');
            }

            /* Checks title/url/legend/description/image */
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                if (Tools::strlen(Tools::getValue('title_'.$language['id_lang'])) > 255) {
                    $errors[] = $this->l('The title is too long.');
                }
                if (Tools::strlen(Tools::getValue('description_'.$language['id_lang'])) > 4000) {
                    $errors[] = $this->l('The description is too long.');
                }
                if (Tools::getValue('image_old') != null && !Validate::isFileName(Tools::getValue('image_old'))) {
                    $errors[] = $this->l('Invalid filename.');
                }
            }

            /* Checks title/url/legend/description for default lang */
            $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
            if (Tools::strlen(Tools::getValue('title_'.$id_lang_default)) == 0) {
                $errors[] = $this->l('The title is not set.');
            }
        } elseif (Tools::isSubmit('delete_id_slide') && (!Validate::isInt(Tools::getValue('delete_id_slide')) || !$this->slideExists((int)Tools::getValue('delete_id_slide')))) {
            $errors[] = $this->l('Invalid slide ID');
        }

        /* Display errors if needed */
        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));
            return false;
        }

        /* Returns if validation is ok */
        return true;
    }

    private function _postProcess()
    {
        $errors = array();
		if (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_slide')) {
            $slide = new LookBook((int)Tools::getValue('id_slide'));
            if ($slide->active == 0) {
                $slide->active = 1;
            } else {
                $slide->active = 0;
            }
            $res = $slide->update();

            $this->_html .= ($res ? $this->displayConfirmation($this->l('Configuration updated')) : $this->displayError($this->l('The configuration could not be updated.')));
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
        } elseif (Tools::isSubmit('submitData') || Tools::isSubmit('submitDataAndStay')) {
            /* Sets ID if needed */
            if (Tools::getValue('id_slide')) {
                $slide = new LookBook((int)Tools::getValue('id_slide'));
                if (!Validate::isLoadedObject($slide)) {
                    $this->_html .= $this->displayError($this->l('Invalid slide ID'));

                    return false;
                }
            } else {
                $slide = new LookBook();
            }
            /* Sets position */
            $slide->position = (int)Tools::getValue('position');
            /* Sets active */
            $slide->active = (int)Tools::getValue('active_slide');
            $slide->hotsposts = Tools::getValue('hotsposts');
            /* Uploads image and sets slide */
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image']['name'], '.'), 1));
            $imagesize = @getimagesize($_FILES['image']['tmp_name']);
            if (isset($_FILES['image']) && isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name']) && !empty($imagesize) && in_array(Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array('jpg', 'gif', 'jpeg', 'png')) && in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
            ) {
                $slide->width = (int)$imagesize[0];
                $slide->height = (int)$imagesize[1];
                $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                $salt = sha1(microtime());
                if ($error = ImageManager::validateUpload($_FILES['image'])) {
                    $errors[] = $error;
                } elseif (!$temp_name || !move_uploaded_file($_FILES['image']['tmp_name'], $temp_name)) {
                    return false;
                } elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/views/img/'.$salt.'_'.$_FILES['image']['name'], $imagesize[0], $imagesize[1], $type)) {
                    $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                } if (isset($temp_name)) {
                    @unlink($temp_name);
                }
                $slide->image = $salt.'_'.$_FILES['image']['name'];
            } elseif (Tools::getValue('image_old') != '') {
                $slide->image = Tools::getValue('image_old');
            }

            /* Sets each langue fields */
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                $slide->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
                $slide->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
            }
            /* Processes if no errors  */
            if (!$errors) {
                /* Adds */
                if (!Tools::getValue('id_slide')) {
                    if (!$slide->add()) {
                        $errors[] = $this->displayError($this->l('The slide could not be added.'));
                    }
                } elseif (!$slide->update()) {
                    $errors[] = $this->displayError($this->l('The slide could not be updated.'));
                }
            }
            if (Tools::isSubmit('submitDataAndStay')) {
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_slide='.(int)$slide->id);
            }
        } /* Deletes */
        elseif (Tools::isSubmit('delete_id_slide')) {
            $slide = new LookBook((int)Tools::getValue('delete_id_slide'));
            $res = $slide->delete();

            if (!$res) {
                $this->_html .= $this->displayError('Could not delete.');
            } else {
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }
        }

        /* Display errors if needed */
        if (count($errors)) {
            $this->_html .= $this->displayError(implode('<br />', $errors));
        } elseif (Tools::isSubmit('submitSlide') && Tools::getValue('id_slide')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
        } elseif (Tools::isSubmit('submitSlide')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
        }
    }

    public function hookdisplayHeader($params)
    {
        if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index') {
            return;
        }
    if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->context->controller->registerJavascript('js-jmarketplace-owl', 'modules/'.$this->name.'/views/js/owl.carousel.min.js', ['position' => 'bottom', 'priority' => 150]);
            $this->context->controller->registerJavascript('js-jmarketplace-lookbook', 'modules/'.$this->name.'/views/js/novlookbook.js', ['position' => 'bottom', 'priority' => 151]);
        $this->context->controller->registerStyleSheet('css-jmarketplace-owl', 'modules/'.$this->name.'/views/css/owl.carousel.min.css', ['position' => 'head', 'priority' => 150]);
        $this->context->controller->registerStyleSheet('css-jmarketplace-owltheme', 'modules/'.$this->name.'/views/css/owl.theme.default.min.css', ['position' => 'head', 'priority' => 150]);
        $this->context->controller->registerStyleSheet('css-jmarketplace-novlookbook', 'modules/'.$this->name.'/views/css/novlookbook.css', ['position' => 'head', 'priority' => 150]);
    } else {
            $this->context->controller->addJS(($this->_path).'/views/js/owl.carousel.min.js', 'all');
            $this->context->controller->addJS(($this->_path).'/views/js/novlookbook.js', 'all');
            $this->context->controller->addCSS(($this->_path).'/views/css/owl.carousel.min.css', 'all');
            $this->context->controller->addCSS(($this->_path).'/views/css/owl.theme.default.min.css', 'all');
            $this->context->controller->addCSS(($this->_path).'/views/css/novlookbook.css', 'all');
        }
    }
    public function renderWidget($hookName, array $params)
    {
        if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index') {
            return;
        }
    if (version_compare(_PS_VERSION_, '1.7', '>=')) {
        $this->context->controller->registerJavascript('js-jmarketplace-owl', 'modules/'.$this->name.'/views/js/owl.carousel.min.js', ['position' => 'bottom', 'priority' => 150]);
        $this->context->controller->registerJavascript('js-jmarketplace-lookbook', 'modules/'.$this->name.'/views/js/novlookbook.js', ['position' => 'bottom', 'priority' => 151]);
        $this->context->controller->registerStyleSheet('css-jmarketplace-owl', 'modules/'.$this->name.'/views/css/owl.carousel.min.css', ['position' => 'head', 'priority' => 150]);
        $this->context->controller->registerStyleSheet('css-jmarketplace-owltheme', 'modules/'.$this->name.'/views/css/owl.theme.default.min.css', ['position' => 'head', 'priority' => 150]);
        $this->context->controller->registerStyleSheet('css-jmarketplace-novlookbook', 'modules/'.$this->name.'/views/css/novlookbook.css', ['position' => 'head', 'priority' => 150]);
    } else {
            $this->context->controller->addJS(($this->_path).'/views/js/owl.carousel.min.js', 'all');
            $this->context->controller->addJS(($this->_path).'/views/js/novlookbook.js', 'all');
            $this->context->controller->addCSS(($this->_path).'/views/css/owl.carousel.min.css', 'all');
            $this->context->controller->addCSS(($this->_path).'/views/css/owl.theme.default.min.css', 'all');
            $this->context->controller->addCSS(($this->_path).'/views/css/novlookbook.css', 'all');
        }
    }

    public function hookActionShopDataDuplication($params)
    {
        Db::getInstance()->execute('INSERT IGNORE INTO '._DB_PREFIX_.'novlookbook (id_novlookbook_slides, id_shop) SELECT id_novlookbook_slides, '.(int)$params['new_id_shop'].' FROM '._DB_PREFIX_.'novlookbook WHERE id_shop = '.(int)$params['old_id_shop']);
    }

    public function headerHTML()
    {
        if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name) {
            return;
        }

        $this->context->controller->addJqueryUI('ui.sortable');
        /* Style & js for fieldset 'slides configuration' */
        $html = '<script type="text/javascript">
            $(function() {
                var $mySlides = $("#slides");
                $mySlides.sortable({
                    opacity: 0.6,
                    cursor: "move",
                    update: function() {
                        var order = $(this).sortable("serialize") + "&action=updateSlidesPosition";
                        $.post("'.$this->context->shop->physical_uri.$this->context->shop->virtual_uri.'modules/'.$this->name.'/ajax_'.$this->name.'.php?secure_key='.$this->secure_key.'", order);
                        }
                    });
                $mySlides.hover(function() {
                    $(this).css("cursor","move");
                    },
                    function() {
                    $(this).css("cursor","auto");
                });
            });
        </script>';

        return $html;
    }

    public function getNextPosition()
    {
        $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('SELECT MAX(hss.`position`) AS `next_position` FROM `'._DB_PREFIX_.'novlookbook_slides` hss, `'._DB_PREFIX_.'novlookbook` hs WHERE hss.`id_novlookbook_slides` = hs.`id_novlookbook_slides` AND hs.`id_shop` = '.(int)$this->context->shop->id);
        return (++$row['next_position']);
    }

    public function getSlides($active = null)
    {
        $this->context = Context::getContext();
        $id_shop = $this->context->shop->id;
        $id_lang = $this->context->language->id;
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT hs.`id_novlookbook_slides` as id_slide, hss.`image`,hss.`width`,hss.`height`, hss.`position`,hss.`active`,hss.`hotsposts`, hssl.`title`, hssl.`description` FROM '._DB_PREFIX_.'novlookbook hs LEFT JOIN '._DB_PREFIX_.'novlookbook_slides hss ON (hs.id_novlookbook_slides = hss.id_novlookbook_slides) LEFT JOIN '._DB_PREFIX_.'novlookbook_slides_lang hssl ON (hss.id_novlookbook_slides = hssl.id_novlookbook_slides) WHERE id_shop = '.(int)$id_shop.' AND hssl.id_lang = '.(int)$id_lang . ($active ? ' AND hss.`active` = 1' : ' ').' ORDER BY hss.position');
    }

    public function getAllImagesBySlidesId($id_slides, $active = null, $id_shop = null)
    {
        $this->context = Context::getContext();
        $images = array();
        if (!isset($id_shop)) {
            $id_shop = $this->context->shop->id;
        }
        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT hss.`image`, hssl.`id_lang` FROM '._DB_PREFIX_.'novlookbook hs LEFT JOIN '._DB_PREFIX_.'novlookbook_slides hss ON (hs.id_novlookbook_slides = hss.id_novlookbook_slides) LEFT JOIN '._DB_PREFIX_.'novlookbook_slides_lang hssl ON (hss.id_novlookbook_slides = hssl.id_novlookbook_slides) WHERE hs.`id_novlookbook_slides` = '.(int)$id_slides.' AND hs.`id_shop` = '.(int)$id_shop. ($active ? ' AND hss.`active` = 1' : ' '));
        foreach ($results as $result) {
            $images[$result['id_lang']] = $result['image'];
        }

        return $images;
    }

    public function displayStatus($id_slide, $active)
    {
        $title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
        $icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
        $class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
        $html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&changeStatus&id_slide='.(int)$id_slide.'" title="'.$title.'"><i class="'.$icon.'"></i> '.$title.'</a>';
        return $html;
    }

    public function slideExists($id_slide)
    {
        $req = 'SELECT hs.`id_novlookbook_slides` as id_slide FROM `'._DB_PREFIX_.'novlookbook` hs WHERE hs.`id_novlookbook_slides` = '.(int)$id_slide;
        $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);
        return ($row);
    }

    public function renderList()
    {
        $slides = $this->getSlides();
        foreach ($slides as $key => $slide) {
            $slides[$key]['status'] = $this->displayStatus($slide['id_slide'], $slide['active']);
        }
        $this->context->smarty->assign(array('link' => $this->context->link, 'slides' => $slides, 'image_baseurl' => $this->_path.'views/img/'));
        return $this->display(__FILE__, 'list.tpl');
    }

    public function renderAddForm()
    {
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJqueryUI('ui.resizable');
        $this->context->controller->addJqueryUI('ui.draggable');
        $this->context->controller->addJS(($this->_path).'views/js/hotspots.js', 'all');
        $this->context->controller->addJS(($this->_path).'views/js/lookbook.js', 'all');
        $this->context->controller->addCSS(($this->_path).'views/css/lookbook.css', 'all');
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Lookbook item information'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enabled'),
                        'name' => 'active_slide',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    ),
                    array(
                        'type' => 'file_image',
                        'label' => $this->l('Select a file'),
                        'name' => 'image',
                        'desc' => $this->l(sprintf('Maximum image size: %s.', ini_get('upload_max_filesize')))
                    )
                ),
                'buttons' => array(
                    array(
                        'title' => $this->l('Cancel'),
                        'icon' => 'process-icon-cancel',
                        'class' => 'pull-left',
                        'type' => 'submit',
                        'name' => 'submitCancel'
                    ),
                    array(
                        'title' => $this->l('Save'),
                        'icon' => 'process-icon-save',
                        'class' => 'module_form_submit_btn pull-right',
                        'type' => 'submit',
                        'name' => 'submitData',
                        'id'
                    ),
                    array(
                        'title' => $this->l('Save And Stay'),
                        'icon' => 'process-icon-save',
                        'class' => 'module_form_submit_btn pull-right',
                        'type' => 'submit',
                        'name' => 'submitDataAndStay'
                    ),
                )
            ),
        );

        if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide'))) {
            $slide = new LookBook((int)Tools::getValue('id_slide'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_slide');
            $fields_form['form']['images'] = $slide->image;
            $fields_form['form']['width'] = $slide->width;
            $fields_form['form']['height'] = $slide->height;
            $fields_form['form']['id'] = (int)Tools::getValue('id_slide');
            $fields_form['form']['hotsposts'] = $slide->hotsposts;
            $fields_form['form']['get_site_url'] = $this->context->shop->physical_uri.$this->context->shop->virtual_uri.'modules/'.$this->name.'/ajax_'.$this->name.'.php?secure_key='.$this->secure_key;
            $has_picture = true;

            foreach (Language::getLanguages(false) as $lang) {
                if (!isset($slide->image[$lang['id_lang']])) {
                    $has_picture &= false;
                }
            }
            if ($has_picture) {
                $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'has_picture');
            }
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitSlide';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'views/img/'
        );

        $helper->override_folder = '/';

        return $helper->generateForm(array($fields_form));
    }

    public function getAddFieldsValues()
    {
        $fields = array();

        if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide'))) {
            $slide = new LookBook((int)Tools::getValue('id_slide'));
            $fields['id_slide'] = (int)Tools::getValue('id_slide', $slide->id);
        } else {
            $slide = new LookBook();
        }

        $fields['active_slide'] = Tools::getValue('active_slide', $slide->active);
        $fields['width'] = Tools::getValue('width', $slide->width);
        $fields['height'] = Tools::getValue('width', $slide->height);
        $fields['image'] = Tools::getValue('image');
        $fields['has_picture'] = true;

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields['title'][$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], $slide->title[$lang['id_lang']]);
            $fields['description'][$lang['id_lang']] = Tools::getValue('description_'.(int)$lang['id_lang'], $slide->description[$lang['id_lang']]);
        }

        return $fields;
    }

    public static function findByCategory($id_lang, $expr, $limit = 50, $order_by = 'position', $order_way = 'desc', $ajax = false, Context $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

        $intersect_array = array();
        $score_array = array();
        $words = explode(' ', Search::sanitize($expr, $id_lang, false, $context->language->iso_code));
        $where = '';
        foreach ($words as $key => $word) {
            if (!empty($word) && Tools::strlen($word) >= (int)Configuration::get('PS_SEARCH_MINWORDLEN')) {
                $word = str_replace('%', '\\%', $word);
                $word = str_replace('_', '\\_', $word);
                $start_search = Configuration::get('PS_SEARCH_START') ? '%': '';
                $end_search = Configuration::get('PS_SEARCH_END') ? '': '%';

                $intersect_array[] = 'SELECT si.id_product
                    FROM '._DB_PREFIX_.'search_word sw
                    LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
                    WHERE sw.id_lang = '.(int)$id_lang.'
                        AND sw.id_shop = '.$context->shop->id.'
                        AND sw.word LIKE
                    '.($word[0] == '-'
                        ? ' \''.$start_search.pSQL(Tools::substr($word, 1, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\''
                        : ' \''.$start_search.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\''
                    );

                if ($word[0] != '-') {
                    $score_array[] = 'sw.word LIKE \''.$start_search.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\'';
                }
            } else {
                unset($words[$key]);
            }
        }
        if (!count($words)) {
            return ($ajax ? array() : array('total' => 0, 'result' => array()));
        }

        $score = '';
        if (count($score_array)) {
            $score = ',(
                SELECT SUM(weight)
                FROM '._DB_PREFIX_.'search_word sw
                LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
                WHERE sw.id_lang = '.(int)$id_lang.'
                    AND sw.id_shop = '.$context->shop->id.'
                    AND si.id_product = p.id_product
                    AND ('.implode(' OR ', $score_array).')
            ) position';
        }

        $sql_groups = '';
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1');
        }

        $results = $db->executeS('
        SELECT cp.`id_product`
        FROM `'._DB_PREFIX_.'category_product` cp
        '.(Group::isFeatureActive() ? 'INNER JOIN `'._DB_PREFIX_.'category_group` cg ON cp.`id_category` = cg.`id_category`' : '').'
        INNER JOIN `'._DB_PREFIX_.'category` c ON cp.`id_category` = c.`id_category`
        INNER JOIN `'._DB_PREFIX_.'product` p ON cp.`id_product` = p.`id_product`
        '.Shop::addSqlAssociation('product', 'p', false).'
        WHERE c.`active` = 1
        '.$where.'
        AND product_shop.`active` = 1
        AND product_shop.`visibility` IN ("both", "search")
        AND product_shop.indexed = 1
        '.$sql_groups);

        $eligible_products = array();
        foreach ($results as $row) {
            $eligible_products[] = $row['id_product'];
        }
        foreach ($intersect_array as $query) {
            $eligible_products2 = array();
            foreach ($db->executeS($query) as $row) {
                $eligible_products2[] = $row['id_product'];
            }

            $eligible_products = array_intersect($eligible_products, $eligible_products2);
            if (!count($eligible_products)) {
                return ($ajax ? array() : array('total' => 0, 'result' => array()));
            }
        }

        $eligible_products = array_unique($eligible_products);

        $product_pool = '';
        foreach ($eligible_products as $id_product) {
            if ($id_product) {
                $product_pool .= (int)$id_product.',';
            }
        }
        if (empty($product_pool)) {
            return ($ajax ? array() : array('total' => 0, 'result' => array()));
        }
        $product_pool = ((strpos($product_pool, ',') === false) ? (' = '.(int)$product_pool.' ') : (' IN ('.rtrim($product_pool, ',').') '));

        if ($ajax) {
            $sql = 'SELECT DISTINCT p.id_product, pl.name pname, cl.name cname,
                        cl.link_rewrite crewrite, pl.link_rewrite prewrite '.$score.'
                    FROM '._DB_PREFIX_.'product p
                    INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                        p.`id_product` = pl.`id_product`
                        AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                    )
                    '.Shop::addSqlAssociation('product', 'p').'
                    INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (
                        product_shop.`id_category_default` = cl.`id_category`
                        AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').'
                    )
                    WHERE p.`id_product` '.$product_pool.'
                    ORDER BY position DESC LIMIT 10';
            return $db->executeS($sql);
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by = pSQL($order_by[0]).'.`'.pSQL($order_by[1]).'`';
        }
        $alias = '';
        if ($order_by == 'price') {
            $alias = 'product_shop.';
        } elseif (in_array($order_by, array('date_upd', 'date_add'))) {
            $alias = 'p.';
        }
        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,
                pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`name`,
             MAX(image_shop.`id_image`) id_image, il.`legend`, m.`name` manufacturer_name '.$score.(Combination::isFeatureActive() ? ', MAX(product_attribute_shop.`id_product_attribute`) id_product_attribute' : '').',
                DATEDIFF(
                    p.`date_add`,
                    DATE_SUB(
                        NOW(),
                        INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
                    )
                ) > 0 new'.(Combination::isFeatureActive() ? ', MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity' : '').'
                FROM '._DB_PREFIX_.'product p
                '.Shop::addSqlAssociation('product', 'p').'
                INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                    p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                )
                '.(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa    ON (p.`id_product` = pa.`id_product`)
                '.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
                '.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, Context::getContext()->shop)).'
                LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
                LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
                Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
                LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
                WHERE p.`id_product` '.$product_pool.'
                GROUP BY product_shop.id_product
                '.($order_by ? 'ORDER BY  '.$alias.$order_by : '').($order_way ? ' '.$order_way : '').'
                LIMIT '.(int)$limit;
        $result = $db->executeS($sql);

        $sql = 'SELECT COUNT(*)
                FROM '._DB_PREFIX_.'product p
                '.Shop::addSqlAssociation('product', 'p').'
                INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                    p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                )
                LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
                WHERE p.`id_product` '.$product_pool;
        if (!$result) {
            $result_properties = false;
        } else {
            $result_properties = Product::getProductsProperties((int)$id_lang, $result);
        }
        return array('result' => $result_properties);
    }
}
