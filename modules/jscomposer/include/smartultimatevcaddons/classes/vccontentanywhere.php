<?php
class vccontentanywhere extends ObjectModel
{
        public $id_vccontentanywhere;   
        public $active = 1;
        public $hook_name;
        public $display_type;
        public $prd_page;
        public $prd_specify;
        public $cat_page;
        public $content_type;
        public $modules_list;
        public $module_hook_list;
        public $cat_specify;
        public $cms_page;
        public $cms_specify;
        public $blg_page;
        public $blg_specify;
        public $position;
        //lang field
        public $title;
        public $content;
        public $skip_modules = array('jscomposer','revsliderprestashop','smartshortcode');
    public static $definition = array(
        'table' => 'vccontentanywhere',
        'primary' => 'id_vccontentanywhere',
        'multilang'=>true,
        'fields' => array(
            'display_type' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'content_type' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'modules_list' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'module_hook_list' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'prd_page' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'prd_specify' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'cat_page' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'cat_specify' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'cms_page' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'cms_specify' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'blg_page' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'blg_specify' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'position' => array('type' => self::TYPE_INT),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool','required' => true),
            'hook_name' => array('type' => self::TYPE_STRING, 'validate' => 'isString','required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang'=>true, 'validate' => 'isString','required' => true),
            'content' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString')
        ),
    );
    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        Shop::addTableAssociation('vccontentanywhere', array('type' => 'shop'));
                parent::__construct($id, $id_lang, $id_shop);
    }
    public function add($autodate = true, $null_values = false)
    {
        if ($this->position <= 0)
            $this->position = vccontentanywhere::getHigherPosition() + 1;
        if (!parent::add($autodate, $null_values) || !Validate::isLoadedObject($this))
            return false;
        return true;
    }
    public static function getHigherPosition()
    {
        $sql = 'SELECT MAX(`position`)
                FROM `'._DB_PREFIX_.'vccontentanywhere`';
        $position = DB::getInstance()->getValue($sql);
        return (is_numeric($position)) ? $position : -1;
    }
    public static function GetInstance()
    {
        $ins = new vccontentanywhere();
        return $ins;
    }
    public function GetVcContentAnyWhereByHook($hook_name = '')
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        $outputs = $this->ContentFilterEngine($results);
        return $outputs;
    }
    public function GetVcContentByAll($hook_name = '')
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`display_type` = 1 AND ';
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        $outputs = $this->ContentFilterEngine($results);
        return $outputs;
    }
    public function ModHookExec($mod_name = '',$hook_name='')
    {
        $results = '';
        if(Module::isInstalled($mod_name)){
            if(!Module::isEnabled($mod_name)){
                require_once(_PS_MODULE_DIR_ .$mod_name.'/'.$mod_name.'.php');
            }
            $mod_ins = new $mod_name();
            // $mod_method = 'hook'.$hook_name;
            $retro_hook_name = Hook::getRetroHookName($hook_name);
            $params = array();
            if(is_callable(array(
                $mod_ins,
                'hook'.$hook_name
            ))){
                $mod_method = 'hook'.$hook_name;
                $results = $mod_ins->$mod_method($params);
            }elseif(is_callable(array(
                $mod_ins,
                'hook'.$retro_hook_name
            ))){
                $mod_retro_method = 'hook'.$retro_hook_name;
                $results = $mod_ins->$mod_retro_method($params);
            }
        }else{
            $results = '<strong>'.$mod_name.'</strong> is not install. Please Install <strong>'.$mod_name.'</strong> Module.';
        }
        return $results;
    }
    public function GetVcContentByAllPRD($hook_name = '')
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`display_type` = 0 AND ';
        $sql .= ' v.`prd_page` = 1 AND ';
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        $outputs = $this->ContentFilterEngine($results);
        return $outputs;
    }
    public function GetVcContentByAllCAT($hook_name = '')
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`display_type` = 0 AND ';
        $sql .= ' v.`cat_page` = 1 AND ';
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        $outputs = $this->ContentFilterEngine($results);
        return $outputs;
    }
    public function GetVcContentByAllCMS($hook_name = '')
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`display_type` = 0 AND ';
        $sql .= ' v.`cms_page` = 1 AND ';
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        $outputs = $this->ContentFilterEngine($results);
        return $outputs;
    }
    public function GetVcContentByAllCMSID($hook_name = '',$id_cms = 1)
    {
        $reslt = array();
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`display_type` = 0 AND ';
        $sql .= ' v.`cms_page` = 0 AND ';
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        if(isset($results) && !empty($results)){
            $i = 0;
            foreach($results as $result){
                if(isset($result['cms_specify']) && !empty($result['cms_specify'])){
                    $cms_specify = explode(',',$result['cms_specify']);
                    if(isset($cms_specify) && !empty($cms_specify)){
                        if(in_array($id_cms,$cms_specify)){
                            $reslt[$i] = $result;
                        }
                    }
                }
            $i++;
            }
        }
        $outputs = $this->ContentFilterEngine($reslt);
        return $outputs;
    }
    public function GetVcContentByAllCATID($hook_name = '',$id_category = 1)
    {
        $reslt = array();
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`display_type` = 0 AND ';
        $sql .= ' v.`cat_page` = 0 AND ';
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        if(isset($results) && !empty($results)){
            $i = 0;
            foreach($results as $result){
                if(isset($result['cat_specify']) && !empty($result['cat_specify'])){
                    $cat_specify = explode(',',$result['cat_specify']);
                    if(isset($cat_specify) && !empty($cat_specify)){
                        if(in_array($id_category,$cat_specify)){
                            $reslt[$i] = $result;
                        }
                    }
                }
            $i++;
            }
        }
        $outputs = $this->ContentFilterEngine($reslt);
        return $outputs;
    }
    public function GetVcContentByAllPRDID($hook_name = '',$id_product = 1)
    {
        $reslt = array();
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`display_type` = 0 AND ';
        $sql .= ' v.`prd_page` = 0 AND ';
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        if(isset($results) && !empty($results)){
            $i = 0;
            foreach($results as $result){
                if(isset($result['prd_specify']) && !empty($result['prd_specify'])){
                    $prd_specify = explode(',',$result['prd_specify']);
                    if(isset($prd_specify) && !empty($prd_specify)){
                        if(in_array('PRD_'.$id_product,$prd_specify)){
                            $reslt[$i] = $result;
                        }
                    }
                }
            $i++;
            }
        }
        $outputs = $this->ContentFilterEngine($reslt);
        return $outputs;
    }
    public function GetVcContentByAllPRDCATID($hook_name = '',$id_prd_cat = 1)
    {
        $reslt = array();
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'vccontentanywhere` v 
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_lang` vl ON (v.`id_vccontentanywhere` = vl.`id_vccontentanywhere` AND vl.`id_lang` = '.$id_lang.')
                INNER JOIN `'._DB_PREFIX_.'vccontentanywhere_shop` vs ON (v.`id_vccontentanywhere` = vs.`id_vccontentanywhere` AND vs.`id_shop` = '.$id_shop.')
                WHERE ';
        if(isset($hook_name) && !empty($hook_name)){
            $hook_retro_name = Hook::getRetroHookName($hook_name);
            $sql .= '( v.`hook_name` = "'.$hook_name.'" or v.`hook_name` = "'.$hook_retro_name.'") AND ';
        }
        $sql .= ' v.`display_type` = 0 AND ';
        $sql .= ' v.`prd_page` = 0 AND ';
        $sql .= ' v.`active` = 1 ORDER BY v.`position` ASC';
        $results = Db::getInstance()->executeS($sql);
        if(isset($results) && !empty($results)){
            $i = 0;
            foreach($results as $result){
                if(isset($result['prd_specify']) && !empty($result['prd_specify'])){
                    $prd_specify = explode(',',$result['prd_specify']);
                    if(isset($prd_specify) && !empty($prd_specify)){
                        if(in_array('CAT_'.$id_prd_cat,$prd_specify)){
                            $reslt[$i] = $result;
                        }
                    }
                }
            $i++;
            }
        }
        $outputs = $this->ContentFilterEngine($reslt);
        return $outputs;
    }
    public static function getProductsByCategoryID($category_id,$id_lang = null, $id_shop = null, $child_count = false, $order_by = 'id_product', $order_way = "DESC")
    {
            $context = Context::getContext(); 
            $id_lang = is_null($id_lang) ? $context->language->id : $id_lang ;
            $id_shop = is_null($id_shop) ? $context->shop->id : $id_shop ;
            $id_supplier = '';
            $active = true;
            $front = true;
            $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, MAX(product_attribute_shop.id_product_attribute) id_product_attribute, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
                                    pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,
                                    il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
                                    DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
                                    INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
                        DAY)) > 0 AS new, product_shop.price AS orderprice
                FROM `'._DB_PREFIX_.'category_product` cp
                LEFT JOIN `'._DB_PREFIX_.'product` p
                    ON p.`id_product` = cp.`id_product`
                '.Shop::addSqlAssociation('product', 'p').'
                LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
                ON (p.`id_product` = pa.`id_product`)
                '.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
                '.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop).'
                LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
                    ON (product_shop.`id_category_default` = cl.`id_category`
                    AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
                    ON (p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
                LEFT JOIN `'._DB_PREFIX_.'image` i
                    ON (i.`id_product` = p.`id_product`)'.
                Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
                LEFT JOIN `'._DB_PREFIX_.'image_lang` il
                    ON (image_shop.`id_image` = il.`id_image`
                    AND il.`id_lang` = '.(int)$id_lang.')
                LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
                    ON m.`id_manufacturer` = p.`id_manufacturer`
                WHERE product_shop.`id_shop` = '.(int)$context->shop->id.'
                    AND cp.`id_category` = '.(int)$category_id
                    .($active ? ' AND product_shop.`active` = 1' : '')
                    .($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
                    .($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '')
                    .' GROUP BY product_shop.id_product';
                
                
            if (empty($order_by) || $order_by == 'position') $order_by = 'price';
            if (empty($order_way)) $order_way = 'DESC';
            if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add'  || $order_by == 'date_upd')
                    $order_by_prefix = 'p';
            else if ($order_by == 'name')
                    $order_by_prefix = 'pl';

            $sql .= " ORDER BY {$order_by_prefix}.{$order_by} {$order_way}";
            // $sql .= ' LIMIT '.$limit.' '; 
           $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if(!$result)
            return array();    
        return Product::getProductsProperties($id_lang, $result);
    }
    public function getSimpleProducts()
    {
        $context = Context::getContext();
        $id_lang = (int)Context::getContext()->language->id;
        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
            $front = false;
        $sql = 'SELECT p.`id_product`, pl.`name`
                FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').'
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
                WHERE pl.`id_lang` = '.(int)$id_lang.'
                '.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').'
                ORDER BY pl.`name`';
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
    }
    public function getproduct()
    {
        $rs = array();
        $rslt[0]['id_product'] = '0';
        $rslt[0]['name'] = 'None';
        $sql = 'SELECT p.id_product,pl.name FROM '._DB_PREFIX_.'product p INNER JOIN 
        '._DB_PREFIX_.'product_lang pl ON p.id_product=pl.id_product INNER JOIN 
        '._DB_PREFIX_.'product_shop ps ON pl.id_product = ps.id_product AND ps.id_shop = '.(int) Context::getContext()->shop->id.'
        WHERE pl.id_lang='.(int)Context::getContext()->language->id.'
        AND p.active= 1 ORDER BY p.id_product DESC';
        $rs =  $this->getSimpleProducts();
        $i = 1;
        foreach($rs as $r){
            $rslt[$i]['id_product'] = $r['id_product'];
            $rslt[$i]['name'] = $r['name'];
            $i++;
         }
         return $rslt;
    }
    public function getAllCMSPage()
    {
        $results = array();
        $results[0]['id_cms'] = 'none';
        $results[0]['name'] = 'None';
        $i = 1;
        $allcategories = CMS::listCms();
        foreach($allcategories as  $value){
           $results[$i]['id_cms'] = $value['id_cms'];
           $results[$i]['name'] = $value['meta_title'];
           $i++;
        }
        return $results;
    }
    public function GetModuleHook($module_name = '',$hook_name = '')
    {
        $results = '';
        if(isset($module_name) && !empty($module_name)){
           $hooks = $this->getModuleHooks($module_name);
           if(isset($hooks) && !empty($hooks)){
               foreach($hooks as $hook){
                if(isset($hook_name) && !empty($hook_name) && $hook['name'] == $hook_name){
                   $results .= '<option value="'.$hook['name'].'"selected="selected">'.$hook['name']."</option>";
                }else{
                    $results .= '<option value="'.$hook['name'].'">'.$hook['name']."</option>";
                }
               }
           }
        }
        return $results;
    }
    public function GetAllModules()
    {
        $results = array();
        $id_shop = Context::getcontext()->shop->id;
        $sql = 'SELECT m.`name` FROM `'._DB_PREFIX_.'module` m
        JOIN `'._DB_PREFIX_.'module_shop` ms ON (m.`id_module` = ms.`id_module` AND ms.`id_shop` = '.(int)($id_shop).')';
        $results = Db::getInstance()->ExecuteS($sql);
        return $results;
    }
    public function GetAllFilterModules()
    {
        $results = array();
        $AllModules =  $this->GetAllModules();
        if(isset($AllModules) && !empty($AllModules)){
            $i = 0;
            foreach($AllModules as $mod){
                if(!in_array($mod['name'],$this->skip_modules)){
                    if($this->getModuleHooks($mod['name'])){
                        $results[$i]['id'] = $mod['name'];
                        $results[$i]['name'] = Module::getModuleName($mod['name']);
                    $i++;
                    }
                }
            }
        }
        return $results;
    }
    public function GetAllHooks()
    {
        $results = array();
        $support_hooks = array();
        require (_PS_MODULE_DIR_ .'jscomposer/include/helpers/support_hooks.php');
        if(isset($support_hooks) && !empty($support_hooks)){
            $i = 0;
            foreach($support_hooks as $value){
                if(!empty($value)){
                        $results[$i]['id'] = Hook::getRetroHookName($value);
                        $results[$i]['name'] = Hook::getRetroHookName($value);
                    $i++;
                } 
            }
        }
        return $results;
    }
    public function getModuleHooks($module = '')
    {
        $support_hooks = array();
        require (_PS_MODULE_DIR_ .'jscomposer/include/helpers/support_hooks.php');
        if(!Module::isEnabled($module)){
                require_once(_PS_MODULE_DIR_ .$module.'/'.$module.'.php');
            }
        $module_Ins = Module::getInstanceByName($module);
        $hooks = array();
        if(isset($support_hooks) && !empty($support_hooks)){
            foreach($support_hooks as $support_hook){
                $support_retro_hook = Hook::getRetroHookName($support_hook);
                if(is_callable(array($module_Ins, 'hook'.$support_hook)) || is_callable(array($module_Ins, 'hook'.$support_retro_hook))){
                    $hooks[] = $support_retro_hook;
                }
            }
        }
        $results = $this->GetHookName($hooks);
        return $results;
    }
    public function getModuleHookbyedit($module = '')
    {
        $reslt = array();
        $support_hooks = array();
        require (_PS_MODULE_DIR_ .'jscomposer/include/helpers/support_hooks.php');
        $module_Ins = Module::getInstanceByName($module);
        $hooks = array();
        if(isset($support_hooks) && !empty($support_hooks)){
            foreach($support_hooks as $support_hook){
                $support_retro_hook = Hook::getRetroHookName($support_hook);
                if(is_callable(array($module_Ins, 'hook'.$support_hook)) || is_callable(array($module_Ins, 'hook'.$support_retro_hook))){
                    $hooks[] = $support_retro_hook;
                }
            }
        }
        $results = $this->GetHookName($hooks);
        if(isset($results) && !empty($results)){
            $i=0;
            foreach($results as $vchook){
               $reslt[$i]['name'] = $vchook['name'];
               $reslt[$i]['id'] = $vchook['name'];
               $i++;
            }
        }
        return $reslt;
    }
    public function GetHookName($hooks = array())
    {
        $results = array();
        if(isset($hooks) && !empty($hooks)){
            $sql = 'SELECT `id_hook`, `name`
            FROM `'._DB_PREFIX_.'hook` 
            WHERE `name` IN (\''.implode("','",$hooks).'\')';
            $results = Db::getInstance()->ExecuteS($sql);
        }
        return $results;
    }
    public function GetModulesList($type='module',$mod_name='')
    {
        $GetAllmodules_list = array();
        $modules_list = $this->getAllModules();
        if($type == 'module'){
            if(isset($modules_list) && !empty($modules_list)){
                    $i = 0;
                foreach($modules_list as $key => $value){
                    if(Module::isInstalled($key)){
                        $GetAllmodules_list[$i]['id'] = $key;
                        $GetAllmodules_list[$i]['name'] = $key;
                        $i++;
                    }
                }
            }
        }elseif($type == 'hook'){
            if(isset($modules_list[$mod_name]) && !empty($modules_list[$mod_name])){
                    $i = 0;
                foreach($modules_list[$mod_name] as $key => $value){
                    if(Module::isInstalled($key)){
                        $GetAllmodules_list[$i]['id'] = $value;
                        $GetAllmodules_list[$i]['name'] = $value;
                        $i++;
                    }
                }
            }
        }
        return $GetAllmodules_list;
    }
    public function getProductCategories($id_product = 1)
    {
        $reslt = array();
        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            'SELECT cp.`id_category` AS id
            FROM `'._DB_PREFIX_.'category_product` cp
            LEFT JOIN `'._DB_PREFIX_.'category` c ON (c.id_category = cp.id_category)
            '.Shop::addSqlAssociation('category', 'c').'
            WHERE cp.`id_product` = '.(int)$id_product
        );
        if(isset($results) && !empty($results)){
            foreach ($results as $result) {
                $reslt[] = $result['id'];
            }
        }
        return $reslt;
    }
    public function getAllProductsByCats()
    {
        $results = array();
        $results[0]['id_product'] = 'none';
        $results[0]['name'] = 'None';
        $i = 1;
        $allcategories = $this->generateCategoriesOption(Category::getNestedCategories(null, (int)Context::getContext()->language->id, true));
        foreach($allcategories as  $value){
           $results[$i]['id_product'] = 'CAT_'.$value['id_category'];
           $results[$i]['name'] = 'Category-------'.$value['name'];
                $catproducts = self::getProductsByCategoryID($value['id_category']);
                if(isset($catproducts) && !empty($catproducts)){
                     foreach($catproducts as  $catproduct){
                        $i++;
                        $results[$i]['id_product'] = 'PRD_'.$catproduct['id_product'];
                        $results[$i]['name'] = $catproduct['name'];
                     }
                }
           $i++;
        }
        return $results;
    }
    public function generatesubCategoriesOption($categories, $items_to_skip = null)
    {
        $subcatvals = array();
        $spacer_size = '5';
         $this->element_index++;
        foreach ($categories as $key => $category)
        {
            $this->smartcat[$this->element_index]['id_category'] = $category['id_category'];
            $this->smartcat[$this->element_index]['name'] = str_repeat('&nbsp;', $spacer_size * (int)$category['level_depth']).$category['name'];
            if (isset($category['children']))
                  $this->generatesubCategoriesOption($category['children']);
        $this->element_index++;
        }
        return true;
    }
    public function generateCategoriesOption($categories, $items_to_skip = null)
    {
        $subcatvals = array();
        $spacer_size = '3';
        $this->smartcat[0]['id_category'] = 'none';
        $this->smartcat[0]['name'] = 'None';            
        $this->element_index = 1;
        foreach ($categories as $key => $category)
        {
                $this->smartcat[$this->element_index]['id_category'] = $category['id_category'];
                $this->smartcat[$this->element_index]['name'] = str_repeat('&nbsp;', $spacer_size * (int)$category['level_depth']).$category['name'];
            if (isset($category['children']))
                  $this->generatesubCategoriesOption($category['children']);
            $this->element_index++;
        }
        return $this->smartcat;
    }
    public function ContentFilterEngine($results = array())
    {
        $outputs = array();
        if(isset($results) && !empty($results)){
            $i = 0;
            foreach($results as $vcvalues){
                foreach($vcvalues as $vckey => $vcval){
                    if($vckey == 'content'){
                        $outputs[$i][$vckey] = JsComposer::vc_content_filter($vcval);
                    }else{
                        $outputs[$i][$vckey] = $vcval;
                    } 
                }
            $i++;
            }
        }
        return $outputs;
    }
    public function updatePosition($way, $position)
    {
        if (!$res = Db::getInstance()->executeS('
            SELECT `id_vccontentanywhere`, `position`
            FROM `'._DB_PREFIX_.'vccontentanywhere`
            ORDER BY `position` ASC'
        ))
            return false;
        foreach ($res as $vccontentanywhere)
            if ((int)$vccontentanywhere['id_vccontentanywhere'] == (int)$this->id)
                $moved_vccontentanywhere = $vccontentanywhere;
        if (!isset($moved_vccontentanywhere) || !isset($position))
            return false;
        $query_1 = ' UPDATE `'._DB_PREFIX_.'vccontentanywhere`
        SET `position`= `position` '.($way ? '- 1' : '+ 1').'
        WHERE `position`
        '.($way
        ? '> '.(int)$moved_vccontentanywhere['position'].' AND `position` <= '.(int)$position
        : '< '.(int)$moved_vccontentanywhere['position'].' AND `position` >= '.(int)$position.'
        ');
        $query_2 = ' UPDATE `'._DB_PREFIX_.'vccontentanywhere`
        SET `position` = '.(int)$position.'
        WHERE `id_vccontentanywhere` = '.(int)$moved_vccontentanywhere['id_vccontentanywhere'];
        return (Db::getInstance()->execute($query_1)
        && Db::getInstance()->execute($query_2));
    }
}