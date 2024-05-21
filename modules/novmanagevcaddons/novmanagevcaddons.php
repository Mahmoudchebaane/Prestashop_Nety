<?php

if (!defined('_PS_VERSION_'))
    exit;
require_once(_PS_MODULE_DIR_ . '/novthemeconfig/novthemeconfig.php');
class novmanagevcaddons extends Module
{
    private $jscomposer;
    public static $actions, $instance, $backoffice_inline_styles = array(), $backoffice_styles = array(), $backoffice_scripts = array(), $google_front_css = array(), $front_styles = array(), $front_scripts = array(), $front_inline_tags = array();
    public $admin_media_path_css, $admin_media_path_js, $asset_media_path, $_url, $googleFontsEditClass;

    public function __construct()
    {
        $this->name = 'novmanagevcaddons';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'vinovathemes';
        $this->need_instance = 0;
        $this->dependencies = array('jscomposer');
        $this->bootstrap = true;
        // start media link
        $this->admin_media_path_css = _MODULE_DIR_ . 'novmanagevcaddons/admin/css/';
        $this->admin_media_path_js = _MODULE_DIR_ . 'novmanagevcaddons/admin/js/';
        $this->asset_media_path = _MODULE_DIR_ . 'novmanagevcaddons/assets/';
        // end media link
        parent::__construct();
        $this->_url = $this->_path;
        $this->displayName = $this->l('Vinova Manage VC Addons');
        $this->description = $this->l('Manage Items for Visual Composer module.');
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        // Prepare tab
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'Adminnovmanagevction';
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $tab->name[$lang['id_lang']] = 'NovmanageAjaxAction';
        $tab->id_parent = -1;
        $tab->module = $this->name;

        if (
            !$tab->add() ||
            !parent::install() ||
            !$this->registerHook('displayBackOfficeHeader') ||
            !$this->registerHook('displayBackOfficeFooter') ||
            !$this->registerHook('vcBeforeInit')
        )
            return false;
        return true;
    }
    public function uninstall()
    {
        $id_tab = (int)Tab::getIdFromClassName('Adminnovmanagevction');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            $tab->delete();
        }

        if (!parent::uninstall())
            return false;
        return true;
    }

    public function is_admin()
    {
        if (isset($this->context->controller->admin_webpath) && !empty($this->context->controller->admin_webpath))
            return true;
        return false;
    }

    public function smart_vc_map()
    {
        self::DoAction('mapcode');
    }

    public function hookDisplayBackOfficeHeader()
    {
        $scripts = '';
        $this->context->controller->addCSS($this->admin_media_path_css . 'icon-manager.css');
        $this->context->controller->addCSS($this->asset_media_path . 'css/animate.css');
        $this->context->controller->addJquery();
        $contents = '<script type="text/javascript">
            if(typeof vc_ajaxurl == "undefined"){
                var vc_ajaxurl = "' . $this->context->link->getAdminLink('VC_ajax') . '";
            }
            var ajaxurl = vc_ajaxurl;</script>';
        $contents .= $scripts;
        if (!empty(self::$backoffice_styles)) {
            self::$backoffice_styles = array_unique(self::$backoffice_styles);
            foreach (self::$backoffice_styles as $style) {
                $contents .= "<link rel='stylesheet' href='{$style}' />";
            }
        }
        if (!empty(self::$backoffice_inline_styles)) {
            foreach (self::$backoffice_inline_styles as $style) {
                $contents .= $style;
            }
        }
        return $contents;
    }
    public function hookDisplayBackOfficeFooter()
    {
        $contents = '';
        // if (jscomposer::condition()) {
        //     if (Tools::getValue('controller') === 'VC_frontend') {
        //         self::$backoffice_scripts = array_unique(self::$backoffice_scripts);
        //     }
        // }
        if (!empty(self::$backoffice_scripts)) {
            self::$backoffice_scripts = array_unique(self::$backoffice_scripts);
            foreach (self::$backoffice_scripts as $script) {
                $contents .= "<script type='text/javascript' src='{$script}'></script>";
            }
        }
        return $contents;
    }

    public static function DoAction($ac_type = 'addcode')
    {
        $includes = array();
        require_once(dirname(__FILE__) . '/inc/include.php');
        if (isset($includes) && !empty($includes)) {
            foreach ($includes as $key => $include) {
                if (isset($include['file']) && isset($include['class'])) :
                    $fileuri = dirname(__FILE__) . '/modules/' . $include['file'];
                    if (file_exists($fileuri)) :
                        require_once($fileuri);
                        $include_obj = new $include['class'](); // add_shortcode runs in class constructor
                        if ($ac_type == 'mapcode') {
                            if (is_callable(array($include_obj, $include['mapcode']))) {
                                call_user_func(array($include_obj, $include['mapcode']));
                            }
                        }
                    endif;
                endif;
            }
        }
    }

    public static function getInstance()
    {
        if (!empty(self::$instance) && self::$instance instanceof novmanagevcaddons) {
            return self::$instance;
        }
        return self::$instance = new novmanagevcaddons();
    }

    public function hookvcBeforeInit()
    {
        if ((Module::isEnabled('jscomposer') == 1) && (Module::isInstalled('jscomposer') == 1)) {
            if ($this->is_admin()) {
                $this->context->controller->addJquery();
                $this->smart_vc_map();
                if (Tools::getvalue('controller') == 'VC_frontend') {
                    self::DoAction('addcode');
                }
            } else {
                self::DoAction('addcode');
            }
        }
    }

    //Get file in module
    public static function get_module_dir($path = '')
    {
        return dirname(__FILE__) . '/' . $path;
    }

    //Get file
    public static function nov_getfile($path, $name)
    {
        $result = array();
        $files = array_diff(scandir($path), array('..', '.'));
        if (count($files) > 0) {
            foreach ($files as $file) {
                if (strpos($file, '.tpl') !== false) {
                    $name = str_replace('.tpl', "", $file);
                    $name = ucwords(str_replace("-", " ", $name));
                    $result[$name] = str_replace(".tpl", "", $file);
                }
            }
        }
        return $result;
    }

    //Math class column
    public static function get_classnumbercolumn($xl_number, $md_number, $number)
    {
        $class = "";
        if ($xl_number == 5) {
            $class .= 'col-xl-cus-5';
        } else {
            $class .= 'col-xl-' . (12 / $xl_number);
        }
        if ($md_number == 5) {
            $class .= ' col-md-cus-5';
        } else {
            $class .= ' col-md-' . (12 / $md_number);
        }
        if ($number == 5) {
            $class .= ' col-cus-5';
        } else {
            $class .= ' col-' . (12 / $number);
        }
        return $class;
    }

    public static function NovgetProducts($filter, $id_lang, $page_number = 0, $nb_products = 10, $count = false, $order_by = null, $order_way = null, Context $context = null)
    {
        $now = date('Y-m-d') . ' 00:00:00';
        if (!$context) {
            $context = Context::getContext();
        }

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        if ($page_number < 1) {
            $page_number = 1;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        if (empty($order_by) || $order_by == 'position') {
            $order_by = 'date_add';
        }
        if (empty($order_way)) {
            $order_way = 'DESC';
        }
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'product_shop';
        } elseif ($order_by == 'name') {
            $order_by_prefix = 'pl';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }

        $sql_groups = '';
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = ' AND EXISTS(SELECT 1 FROM `' . _DB_PREFIX_ . 'category_product` cp
                JOIN `' . _DB_PREFIX_ . 'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` ' . (count($groups) ? 'IN (' . implode(',', $groups) . ')' : '= ' . (int) Configuration::get('PS_UNIDENTIFIED_GROUP')) . ')
                WHERE cp.`id_product` = p.`id_product`)';
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }

        $nb_days_new_product = (int) Configuration::get('PS_NB_DAYS_NEW_PRODUCT');

        if ($count) {
            $sql = 'SELECT COUNT(p.`id_product`) AS nb
                    FROM `' . _DB_PREFIX_ . 'product` p
                    ' . Shop::addSqlAssociation('product', 'p') . '
                    WHERE product_shop.`active` = 1
                    ' . ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '') . '
                    ' . $sql_groups;

            return (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        }
        $sql = new DbQuery();
        $sql->select(
            'p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
            pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`, image_shop.`id_image` id_image, il.`legend`, m.`name` AS manufacturer_name,
            (DATEDIFF(product_shop.`date_add`,
                DATE_SUB(
                    "' . $now . '",
                    INTERVAL ' . $nb_days_new_product . ' DAY
                )
            ) > 0) as new'
        );

        $sql->from('product', 'p');
        $sql->join(Shop::addSqlAssociation('product', 'p'));
        $sql->leftJoin(
            'product_lang',
            'pl',
            '
            p.`id_product` = pl.`id_product`
            AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl')
        );
        $sql->leftJoin('image_shop', 'image_shop', 'image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id);
        $sql->leftJoin('image_lang', 'il', 'image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang);
        $sql->leftJoin('manufacturer', 'm', 'm.`id_manufacturer` = p.`id_manufacturer`');
        $sql->leftJoin('category_product', 'cp', 'cp.`id_product` = p.`id_product`');

        $sql->where('product_shop.`active` = 1');
        if ($filter != '') {
            $sql->where($filter);
        }
        if ($front) {
            $sql->where('product_shop.`visibility` IN ("both", "catalog")');
        }

        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql->where('EXISTS(SELECT 1 FROM `' . _DB_PREFIX_ . 'category_product` cp
                JOIN `' . _DB_PREFIX_ . 'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` ' . (count($groups) ? 'IN (' . implode(',', $groups) . ')' : '= 1') . ')
                WHERE cp.`id_product` = p.`id_product`)');
        }

        $sql->groupBy('p.`id_product`');

        $sql->orderBy((isset($order_by_prefix) ? pSQL($order_by_prefix) . '.' : '') . '`' . pSQL($order_by) . '` ' . pSQL($order_way));
        $sql->limit($nb_products, (int) (($page_number - 1) * $nb_products));

        if (Combination::isFeatureActive()) {
            $sql->select('product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, IFNULL(product_attribute_shop.id_product_attribute,0) id_product_attribute');
            $sql->leftJoin('product_attribute_shop', 'product_attribute_shop', 'p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id);
        }
        $sql->join(Product::sqlStock('p', 0));

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return false;
        }

        if ($order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }
        $products_ids = array();
        foreach ($result as $row) {
            $products_ids[] = $row['id_product'];
        }
        // Thus you can avoid one query per product, because there will be only one query for all the products of the cart
        Product::cacheFrontFeatures($products_ids, $id_lang);

        return Product::getProductsProperties((int) $id_lang, $result);
    }

    public static function getPricesDrop($filter, $id_lang, $page_number = 0, $nb_products = 10, $count = false, $order_by = null, $order_way = null, $beginning = false, $ending = false, Context $context = null)
    {
        if (!Validate::isBool($count))
            die(Tools::displayError());

        if (!$context) $context = Context::getContext();
        if ($page_number < 0) $page_number = 0;
        if ($nb_products < 1) $nb_products = 10;
        if (empty($order_by) || $order_by == 'position') $order_by = 'price';
        if (empty($order_way)) $order_way = 'DESC';
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add'  || $order_by == 'date_upd')
            $order_by_prefix = 'p';
        else if ($order_by == 'name')
            $order_by_prefix = 'pl';
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way))
            die(Tools::displayError());
        $current_date = date('Y-m-d H:i:s');
        $ids_product = self::_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context);

        $tab_id_product = array();
        foreach ($ids_product as $product)
            if (is_array($product))
                $tab_id_product[] = (int)$product['id_product'];
            else
                $tab_id_product[] = (int)$product;

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
            $front = false;

        $sql_groups = '';
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = 'AND p.`id_product` IN (
                SELECT cp.`id_product`
                FROM `' . _DB_PREFIX_ . 'category_group` cg
                LEFT JOIN `' . _DB_PREFIX_ . 'category_product` cp ON (cp.`id_category` = cg.`id_category`)
                WHERE cg.`id_group` ' . (count($groups) ? 'IN (' . implode(',', $groups) . ')' : '= 1') . (($filter && $filter != '') ? (' AND ' . $filter) : ' ') . '
            )';
        }

        if ($count) {
            return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
            SELECT COUNT(DISTINCT p.`id_product`)
            FROM `' . _DB_PREFIX_ . 'product` p
            ' . Shop::addSqlAssociation('product', 'p') . '
            WHERE product_shop.`active` = 1
            AND product_shop.`show_price` = 1
            ' . ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '') . '
            ' . ((!$beginning && !$ending) ? 'AND p.`id_product` IN(' . ((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0) . ')' : '') . '
            ' . $sql_groups);
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by = pSQL($order_by[0]) . '.`' . pSQL($order_by[1]) . '`';
        }

        $sql = '
        SELECT
            p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`,
            MAX(product_attribute_shop.id_product_attribute) id_product_attribute,
            pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`,
            pl.`name`, MAX(image_shop.`id_image`) id_image, il.`legend`, m.`name` AS manufacturer_name,
            DATEDIFF(
                p.`date_add`,
                DATE_SUB(
                    NOW(),
                    INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY
                )
            ) > 0 AS new
        FROM `' . _DB_PREFIX_ . 'product` p
        ' . Shop::addSqlAssociation('product', 'p') . '
        LEFT JOIN ' . _DB_PREFIX_ . 'product_attribute pa ON (pa.id_product = p.id_product)
        ' . Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on=1') . '
        ' . Product::sqlStock('p', 0, false, $context->shop) . '
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
            p.`id_product` = pl.`id_product`
            AND pl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('pl') . '
        )
        LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product`)' .
            Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1') . '
        LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$id_lang . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
        WHERE product_shop.`active` = 1
        AND product_shop.`show_price` = 1
        ' . ($front ? ' AND p.`visibility` IN ("both", "catalog")' : '') . '
        ' . ((!$beginning && !$ending) ? ' AND p.`id_product` IN (' . ((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0) . ')' : '') . '
        ' . $sql_groups . '
        GROUP BY product_shop.id_product
        ORDER BY ' . (isset($order_by_prefix) ? pSQL($order_by_prefix) . '.' : '') . pSQL($order_by) . ' ' . pSQL($order_way) . '
        LIMIT ' . (int)($page_number * $nb_products) . ', ' . (int)$nb_products;

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result)
            return false;

        if ($order_by == 'price')
            Tools::orderbyPrice($result, $order_way);

        return Product::getProductsProperties($id_lang, $result);
    }

    public static function getBestSales($filter, $idLang, $pageNumber = 0, $nbProducts = 10, $orderBy = null, $orderWay = null, Context $context = null)
    {
        if (!$context)
            $context = Context::getContext();

        if ($pageNumber < 1) {
            $pageNumber = 1;
        }
        if ($nbProducts < 1) {
            $nbProducts = 10;
        }
        $finalOrderBy = $orderBy;
        $orderTable = '';

        $invalidOrderBy = !Validate::isOrderBy($orderBy);
        if ($invalidOrderBy || is_null($orderBy)) {
            $orderBy = 'quantity';
            $orderTable = 'ps';
        }

        if ($orderBy == 'date_add' || $orderBy == 'date_upd') {
            $orderTable = 'product_shop';
        }

        $invalidOrderWay = !Validate::isOrderWay($orderWay);
        if ($invalidOrderWay || is_null($orderWay) || $orderBy == 'sales') {
            $orderWay = 'DESC';
        }

        $interval = Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20;

        // no group by needed : there's only one attribute with default_on=1 for a given id_product + shop
        // same for image with cover=1
        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,
                    ' . (Combination::isFeatureActive() ? 'product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity,IFNULL(product_attribute_shop.id_product_attribute,0) id_product_attribute,' : '') . '
                    pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
                    pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`,
                    m.`name` AS manufacturer_name, p.`id_manufacturer` as id_manufacturer,
                    image_shop.`id_image` id_image, il.`legend`,
                    ps.`quantity` AS sales, t.`rate`, pl.`meta_keywords`, pl.`meta_title`, pl.`meta_description`,
                    DATEDIFF(p.`date_add`, DATE_SUB("' . date('Y-m-d') . ' 00:00:00",
                    INTERVAL ' . (int) $interval . ' DAY)) > 0 AS new'
            . ' FROM `' . _DB_PREFIX_ . 'product_sale` ps
                LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON ps.`id_product` = p.`id_product`
                ' . Shop::addSqlAssociation('product', 'p', false);
        if (Combination::isFeatureActive()) {
            $sql .= ' LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
                            ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id . ')';
        }

        $sql .= ' LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
                    ON p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = ' . (int) $idLang . Shop::addSqlRestrictionOnLang('pl') . '
                LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
                    ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'category_product` cp ON (cp.`id_product` = p.`id_product`)
                LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $idLang . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
                LEFT JOIN `' . _DB_PREFIX_ . 'tax_rule` tr ON (product_shop.`id_tax_rules_group` = tr.`id_tax_rules_group`)
                    AND tr.`id_country` = ' . (int) $context->country->id . '
                    AND tr.`id_state` = 0
                LEFT JOIN `' . _DB_PREFIX_ . 'tax` t ON (t.`id_tax` = tr.`id_tax`)
                ' . Product::sqlStock('p', 0);

        $sql .= '
                WHERE product_shop.`active` = 1 AND ' . $filter . '
                    AND product_shop.`visibility` != \'none\'';

        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql .= ' AND EXISTS(SELECT 1 FROM `' . _DB_PREFIX_ . 'category_product` cp
                    JOIN `' . _DB_PREFIX_ . 'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` ' . (count($groups) ? 'IN (' . implode(',', $groups) . ')' : '= 1') . ')
                    WHERE cp.`id_product` = p.`id_product`)';
        }

        if ($finalOrderBy != 'price') {
            $sql .= '
                    ORDER BY ' . (!empty($orderTable) ? '`' . pSQL($orderTable) . '`.' : '') . '`' . pSQL($orderBy) . '` ' . pSQL($orderWay) . '
                    LIMIT ' . (int) (($pageNumber - 1) * $nbProducts) . ', ' . (int) $nbProducts;
        }

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if ($finalOrderBy == 'price') {
            Tools::orderbyPrice($result, $orderWay);
            $result = array_slice($result, (int) (($pageNumber - 1) * $nbProducts), (int) $nbProducts);
        }
        if (!$result) {
            return false;
        }

        return Product::getProductsProperties($idLang, $result);
    }

    public static function getProducts($filter, $id_lang, $start, $limit, $order_by, $order_way, $only_active = false, Context $context = null)
    {

        if (!$context)
            $context = Context::getContext();

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
            $front = false;

        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way))
            die(Tools::displayError());
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd')
            $order_by_prefix = 'p';
        elseif ($order_by == 'name')
            $order_by_prefix = 'pl';
        elseif ($order_by == 'position')
            $order_by_prefix = 'c';

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }
        $sql = 'SELECT p.*, product_shop.*, pl.* , m.`name` AS manufacturer_name, s.`name` AS supplier_name,MAX(image_shop.`id_image`) id_image
                FROM `' . _DB_PREFIX_ . 'product` p
                ' . Shop::addSqlAssociation('product', 'p') . '
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` ' . Shop::addSqlRestrictionOnLang('pl') . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product`)' .
            Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1') . '
                LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$id_lang . ') 
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
                LEFT JOIN `' . _DB_PREFIX_ . 'supplier` s ON (s.`id_supplier` = p.`id_supplier`)
                LEFT JOIN `' . _DB_PREFIX_ . 'category_product` cp ON (cp.`id_product` = p.`id_product`)
                WHERE pl.`id_lang` = ' . (int)$id_lang .
            $filter .
            ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '') .
            ($only_active ? ' AND product_shop.`active` = 1' : '') . '
                ORDER BY ' . (isset($order_by_prefix) ? pSQL($order_by_prefix) . '.' : '') . '`' . pSQL($order_by) . '` ' . pSQL($order_way) .
            ($limit > 0 ? ' LIMIT ' . (int)$start . ',' . (int)$limit : '');
        $rq = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if ($order_by == 'price')
            Tools::orderbyPrice($rq, $order_way);

        foreach ($rq as &$row)
            $row = Product::getTaxesInformations($row);

        return ($rq);
    }

    public static function _getProductIdByDate($beginning, $ending, Context $context = null, $with_combination = false)
    {
        
         
        if (!$context)
            $context = Context::getContext();
           
        $id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
    
        $ids = Address::getCountryAndState($id_address);
        
        $id_country = (int)( (is_array($ids)  &&  $ids['id_country'] ) ? $ids['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT'));
        
        return SpecificPrice::getProductIdByDate(
            $context->shop->id,
            $context->currency->id, 
            $id_country,
            $context->customer->id_default_group,
            $beginning,
            $ending,
            0,
            $with_combination
        );
        
 
    }
    public static function NovgetBlogs($filter, $limit = 12, $order_by = null, $order_way = null, $categories, $tags)
    {
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;

        $result = array();
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('smart_blog_post', 'p');
        $sql->innerJoin('smart_blog_post_lang', 'pl', 'pl.`id_smart_blog_post` = p.`id_smart_blog_post`');
        $sql->innerJoin('smart_blog_post_shop', 'ps', 'pl.`id_smart_blog_post` = ps.`id_smart_blog_post`');
        $sql->leftJoin('smart_blog_post_category', 'sbpc', 'sbpc.`id_smart_blog_post` = p.`id_smart_blog_post`');
        $sql->leftJoin('smart_blog_post_tag', 'sbpt', 'sbpt.`id_post` = p.`id_smart_blog_post`');
        $sql->where('ps.`id_shop` = ' . (int) $id_shop);
        $sql->where('pl.`id_lang` = ' . (int) $id_lang);
        $sql->where('p.`active` = 1');
        //$sql .= ' WHERE ps.id_shop=' . (int) $id_shop . ' AND pl.id_lang=' . (int) $id_lang. ' AND p.active=1';

        if (isset($categories) && $categories != '') {
            $sql->where('sbpc.`id_smart_blog_category` IN (' . pSQL($categories) . ')');
        }
        if (isset($tags) && $tags != '') {
            $sql->where('sbpt.`id_tag` IN (' . pSQL($tags) . ')');
        }
        $sql->groupBy('p.`id_smart_blog_post`');
        if (isset($order_by) && !empty($order_by)) {
            if ($order_by == 'meta_title' || $order_by == 'link_rewrite') {
                $orderby = 'pl.`' . $order_by . '`';
            } elseif ($order_by == 'date') {
                $order_by = 'created';
                $orderby = 'p.`' . $order_by . '`';
            } else {
                $orderby = 'p.`' . $order_by . '`';
            }
        }
        $sql->orderBy(pSQL($order_by) . ' ' . pSQL($order_way));
        $sql->limit($limit);

        $posts = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        $blogcomment = new Blogcomment();

        $i = 0;
        foreach ($posts as $post) {
            $result[$i]['id'] = $post['id_smart_blog_post'];
            $result[$i]['title'] = $post['meta_title'];
            $result[$i]['meta_description'] = strip_tags($post['meta_description']);
            $result[$i]['short_description'] = strip_tags($post['short_description']);
            $result[$i]['content'] = strip_tags($post['content']);
            $result[$i]['category'] = $post['id_category'];
            $result[$i]['date_added'] = Smartblog::displayDate($post['created']);;
            $result[$i]['viewed'] = $post['viewed'];
            $result[$i]['is_featured'] = $post['is_featured'];
            $result[$i]['link_rewrite'] = $post['link_rewrite'];
            $result[$i]['countcomment'] = $blogcomment->getToltalComment($post['id_smart_blog_post']);
            if (file_exists(_PS_MODULE_DIR_ . 'smartblog/images/' . $post['id_smart_blog_post'] . '.jpg')) {
                $image = $post['id_smart_blog_post'];
                $result[$i]['post_img'] = $image;
            } else {
                $result[$i]['post_img'] = 'no';
            }
            $i++;
        }
        return $result;
    }

    public static function getLookbook($filter = null)
    {
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT hs.`id_novlookbook_slides` as id_slide, hss.`image`,hss.`width`,hss.`height`, hss.`position`,hss.`active`,hss.`hotsposts`, hssl.`title`, hssl.`description` 
        FROM ' . _DB_PREFIX_ . 'novlookbook hs 
        LEFT JOIN ' . _DB_PREFIX_ . 'novlookbook_slides hss 
        ON (hs.id_novlookbook_slides = hss.id_novlookbook_slides) 
        LEFT JOIN ' . _DB_PREFIX_ . 'novlookbook_slides_lang hssl ON (hss.id_novlookbook_slides = hssl.id_novlookbook_slides) 
        WHERE id_shop = ' . (int)$id_shop . ' 
        AND hssl.id_lang = ' . (int)$id_lang . '
        AND hss.`active` = 1
        ' . $filter . '
        ORDER BY hss.position');
    }

    public static function  getNovthemeconfig()
    {


        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            "
            SELECT `id_configuration`,`name`, `value`
            FROM " . _DB_PREFIX_ . "configuration 
            WHERE `name` LIKE  '%novthemeconfig%' ORDER BY `id_configuration` ASC "
        );
    }

    public static function getTestimonialss($active = null, $limit = 12)
    {
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            '
            SELECT hs.`id_novtestimonials` as id_novtestimonials, hssl.`image`,hs.`name`, hs.`company`, hs.`address`, hs.`position`, hs.`active`, hssl.`content`,
            hssl.`url`, hssl.`image`
            FROM ' . _DB_PREFIX_ . 'novtestimonials  hs
            LEFT JOIN ' . _DB_PREFIX_ . 'novtestimonials_shop hss ON (hs.id_novtestimonials = hss.id_novtestimonials)
            LEFT JOIN ' . _DB_PREFIX_ . 'novtestimonials_lang hssl ON (hss.id_novtestimonials = hssl.id_novtestimonials)
            WHERE id_shop = ' . (int)$id_shop . '
            AND hssl.id_lang = ' . (int)$id_lang .
                ($active ? ' AND hs.`active` = 1' : ' ') . '
            ORDER BY hs.position LIMIT ' . $limit
        );
    }

    public static function parseData($value)
    {
        $data = array();
        $values_pairs = preg_split('/\|/', $value);
        foreach ($values_pairs as $pair) {
            if (!empty($pair)) {
                list($key, $value) = preg_split('/\:/', $pair);
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public static function getExtraClass($el_class)
    {
        $output = '';
        if ($el_class != '') {
            $output = " " . str_replace(".", "", $el_class);
        }
        return $output;
    }

    public static function getConfigTheme()
    {
        $NovThemeConfig = new ThemeConfig;
        $defaults = $NovThemeConfig->getThemeFields();
        $context = Context::getContext();
        $novconfig = array();
        $id_lang = Context::getContext()->language->id;
        foreach ($defaults as $key => $value) {
            if (is_array($value)) {
                $novconfig[$key] = Configuration::get($key, $context->language->id);
            } else {
                $prefix_key = str_replace('novthemeconfig_', '', $key);
                $novconfig[$key] = Configuration::get($key);
                if (Tools::getValue($prefix_key)) {
                    Tools::clearSmartyCache();
                    $novconfig[$key] = Tools::getValue($prefix_key);
                    $context->cookie->__set($prefix_key,  Tools::getValue($prefix_key));
                }

                if ($context->cookie->__get($prefix_key)) {
                    $novconfig[$key] = $context->cookie->__get($prefix_key);
                }
            }
        }
        return $novconfig;
    }
}
