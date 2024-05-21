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

class Mgmenu extends ObjectModel
{
	public $id;
    public $id_novmegamenu;
    public $id_parent = 1;
	public $value;
    public $width;
	public $sub_menu;
	public $sub_width;
    public $type;
	public $type_submenu;
    public $show_title = 1;
	public $show_sub_title = 1;
    public $level;
    public $active = 1;
	public $group = 0;
    public $position;
    public $url;
    public $menu_class;
	public $type_icon;
	public $icon;
	public $icon_class;	
    // Lang
    public $title;
	public $sub_title;
    public $html;
    public $id_shop = '';
	private $user_groups;
	private $page_name = '';
	/**
	 * @see ObjectModel::$definition
	 */
 public static $definition = array(
        'table' => 'novmegamenu',
        'primary' => 'id_novmegamenu',
        'multilang' => true,
        'fields' => array(
            'id_parent' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'width' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'sub_menu' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'sub_width' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
            'value' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'type_submenu' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'show_title' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'show_sub_title' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'level' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'group' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'position' => array('type' => self::TYPE_INT),
            'menu_class' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 255),
			'type_icon' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
			'icon' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
			'icon_class' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),			
            'level' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            //Lang fields
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
			'sub_title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
			'url' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
            'html' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
        ),
    );

	public function add($autodate = true,$null_values = false)
	{
		$id_shop = Context::getContext()->shop->id;
		$parent = new Mgmenu($this->id_parent);
		$this->level = $parent->level + 1;
		
		$res = parent::add($autodate,$null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'novmegamenu_shop` (`id_shop`, `id_novmegamenu`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		return $res;
	}

	public function update($null_values = false)
	{
		$id_shop = Context::getContext()->shop->id;
		$parent = new Mgmenu($this->id_parent);
		$this->level = $parent->level + 1;
		parent::update($null_values);
	}
	
	public function delete()
	{
		$res = true;
		$res &= Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'novmegamenu_shop`
			WHERE `id_novmegamenu` = '.(int)$this->id
		);

		$res &= parent::delete();
		return $res;
	}
	
	public function getChildren($id_novmegamenu = null, $id_lang = null, $id_shop = null, $active = false) {
        if (!$id_lang)
            $id_lang = Context::getContext()->language->id;
        if (!$id_shop)
            $id_shop = Context::getContext()->shop->id;
        $sql = ' SELECT m.*, ml.title,ml.sub_title, ml.html, ml.url
					FROM ' . _DB_PREFIX_ . 'novmegamenu m
						LEFT JOIN ' . _DB_PREFIX_ . 'novmegamenu_lang ml ON m.id_novmegamenu = ml.id_novmegamenu AND ml.id_lang = ' . (int) $id_lang
						. ' JOIN ' . _DB_PREFIX_ . 'novmegamenu_shop ms ON m.id_novmegamenu = ms.id_novmegamenu AND ms.id_shop = ' . (int) ($id_shop);
        if ($id_novmegamenu != null) {
            $sql .= ' WHERE id_parent=' . (int) $id_novmegamenu;
        }
		if ($active)
            $sql .= ' AND m.`active`=1 ';
			
        $sql .= ' ORDER BY `position` ';
        return Db::getInstance()->executeS($sql);
    }
	
	public function getTreeChildren($id_parent) {
		$id_lang       = Context::getContext()->language->id;
		$id_shop       = Context::getContext()->shop->id;
		$menus         	= $this->getChildren($id_parent, $id_lang,$id_shop);
		$novmenu = array();
		if($menus){
			foreach ($menus as  $menu) {
				$novmenu[] = $menu;
				$childs = $this->getChildren($menu['id_novmegamenu'], $id_lang,$id_shop);
				if($childs){
					foreach($childs as $child){
						$novmenu[] = $child;
						$childs1 = $this->getChildren($child['id_novmegamenu'], $id_lang,$id_shop);
						if($childs1){
							foreach($childs1 as $child1){
								$novmenu[] = $child1;
								$childs2 = $this->getChildren($child1['id_novmegamenu'], $id_lang,$id_shop);
								if($childs2){
									foreach($childs2 as $child2){
										$novmenu[] = $child2;
									}
								}
							}
						}
					}
				}
			}
		}

		return $novmenu;
	}
	
	
	public function getTree($id_parent, $level) {
            $id_lang       = Context::getContext()->language->id;
			$id_shop       = Context::getContext()->shop->id;
			$menus         	= $this->getChildren($id_parent, $id_lang,$id_shop);
			$current 		= AdminController::$currentIndex.'&configure=novmegamenu&token='.Tools::getAdminTokenLite('AdminModules').'';	
			$output = '';
            if($level == 1)
			$output .= '<div class="mgmenu" id="nestable">';
			$output .= '<ol class="level'.$level.' mgmenu-list">';
            foreach ($menus as $menu) {
                $slc = Tools::getValue('id_novmegamenu') == $menu['id_novmegamenu']?"selected":"";
				$disable = ($menu['active'] && $menu['active'] == 1) ? '' : 'disable';
                $output .='<li id="list_' . $menu['id_novmegamenu'] . '" class="'.$slc.' mgmenu-item " data-id="' . $menu['id_novmegamenu'] . '">
				<div class="mgmenu-handle"></div>
				<div class="mgmenu-content">
				' . ($menu['title'] ? $menu['title'] : "") . ' (ID:' . $menu['id_novmegamenu'] . ') 
					<a class="icon-remove pull-right" data-idnovmegamenu="'.$menu['id_novmegamenu'].'"></a>
					<a class="icon-edit pull-right" data-idnovmegamenu="'.$menu['id_novmegamenu'].'" href="'.$current.'&id_novmegamenu='.$menu['id_novmegamenu'].'"></a>
					<a class="icon-copy pull-right" data-idnovmegamenu="'.$menu['id_novmegamenu'].'" ></a>
					<a class="icon-check '.$disable.' pull-right" data-idnovmegamenu="'.$menu['id_novmegamenu'].'"></a>
				</div>';
				$chil = $this->getCategoryChild($menu['id_novmegamenu']);
                if ($menu['id_novmegamenu'] != $id_parent && count($chil) > 0)
                    $output .= $this->getTree($menu['id_novmegamenu'], $level + 1);
                $output .= '</li>';
            }

            $output .= '</ol>';
			if($level == 1)
				$output .= '</div>';
			
            return $output;
    }   
	
	public function updatePositions($lists,$level,$id_parent){
		if($lists){
			foreach ($lists as $position => $list)
			{
				$res = Db::getInstance()->execute('
					UPDATE `'._DB_PREFIX_.'novmegamenu` SET `position` = '.(int)$position.',`level` = '.(int)$level.',`id_parent` = '.(int)$id_parent.'
				WHERE `id_novmegamenu` = '.(int)$list['id']
				);
				if(isset($list['children']) && $list['children']){
					$level++;
					$this->updatePositions($list['children'],$level,$list['id']);
				}
			}
		}
	}
	
	public function getMegamenu($id_parent, $level){
		global $link, $cookie;
		$module    = new novmegamenu();
		$id_lang    = Context::getContext()->language->id;
		$id_shop    = Context::getContext()->shop->id;
		$menus      = $this->getChildren($id_parent, $id_lang,$id_shop,true);
		$this->themeName = Context::getContext()->shop->theme_name;
      	if(Configuration::get('PS_SSL_ENABLED'))
			$this->iconurl = _PS_BASE_URL_SSL_.__PS_BASE_URI__.'themes/'.$this->themeName.'/assets/img/modules/novmegamenu/icon/';
		else
			$this->iconurl = _PS_BASE_URL_.__PS_BASE_URI__.'themes/'.$this->themeName.'/assets/img/modules/novmegamenu/icon/';
		$current	=	'';
		$output = '';
		if($menus ){
		if($level ==1 )
			$output = '<ul class="menu level'.$level.'">';
		else
			$output ='<ul class="">';//class="d-flex"
			foreach ($menus as $menu) {
			$class = 'item ';
			$opener = '';
			if($menu['menu_class'])
				$class .= $menu['menu_class'];
				
			$chil = $this->getCategoryChild($menu['id_novmegamenu']);
			if(count($chil) > 0 && $menu['group'] == 1 && $menu['sub_menu'] == 'yes') {
				$class .= " group";
				$opener = '<span class="opener"></span>';
			}
			if(count($chil) > 0 && $menu['group'] == 0 && $menu['sub_menu'] == 'yes') {
				$class .= " has-sub";
				$opener = '<span class="opener"></span>';
			}
			$style = '';
			$style_sub = '';			
			if($menu['width'])	
				$style = 'style="width:'.$menu['width'].'"';	
			if($menu['sub_menu'] == 'yes' && $menu['sub_width'])	
				$style_sub = 'style="width:'.$menu['sub_width'].'"';	

			if( $menu['type_icon'] == 'class'){
				$icon = '<i class="'.$menu['icon_class'].'"></i>';
			}elseif( $menu['type_icon'] == 'image' ) {
				$icon = '<i class="hasicon nov-icon" style="background:url(\'' . $this->iconurl . $menu['icon'] . '\') no-repeat scroll center center;"></i>';
			}
			else
				$icon = '';			
			switch ($menu['type'])
			{
				case 'category':
					    
						$selected = ($this->page_name == 'category' && (Tools::getValue('category') == $menu['value'])) ? ' class="sfHover"' : '';
						if (Validate::isLoadedObject($category = new Category($menu['value'], $id_lang))) {

							if($category->id ==  4  && count($category->getSubCategories($id_lang)) > 0   ) {
								$class .= " has-sub";
								 $opener = '<span class="opener"></span>';
							}
							$output .= '<li'.$selected.' class="'.$class.'" '.$style.'>'. $opener .'<a href="'.Tools::HtmlEntitiesUTF8($link->getCategoryLink((int) $category->id, $category->link_rewrite, $id_lang)).'" title="'.$menu['title'].'">'.$icon.$menu['title'].'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-sub-title">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
									$output .= $this->getSubMenu($menu['id_novmegamenu'],$id_parent,$level,$style_sub); 
							 
								if($category->id ==  4){ 
									if ($subCategories = $category->getSubCategories($id_lang,true)) {
										$output .='<div class="dropdown-menu"><ul class=""> ';
										foreach ($subCategories as $subcategory) {  
										 	$output .='<li class="item "><a href="'. Tools::HtmlEntitiesUTF8($link->getCategoryLink((int) $subcategory["id_category"], $subcategory["link_rewrite"], $id_lang)).'" title="'.$subcategory["name"].'">'.$subcategory["name"].'</a></li>';
										 }
										 $output .='</ul> </div>'; 
									} 
								}
							
							$output .= '</li>'.PHP_EOL;
						}
					break;
				case 'product':
					$selected = ($this->page_name == 'product' && (Tools::getValue('id_product') == $menu['value'])) ? ' class="sfHover"' : '';
					$product = new Product((int)$menu['value'], true, (int)$id_lang);
					if (!is_null($product->id))
						$output .= '<li'.$selected.' class="'.$class.'" '.$style.'>'. $opener .'<a href="'.Tools::HtmlEntitiesUTF8($product->getLink()).'" title="'.$product->name.'">'.$icon.$product->name.'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-sub-title">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->getSubMenu($menu['id_novmegamenu'],$id_parent,$level,$style_sub);
						$output .= '</li>'.PHP_EOL;
					break;
				
				case 'productlist':	
						$output .= '<li class="'.$class.'" '.$style.'>';
							if($menu['show_title'] == 1)
								$output .= $opener.'<span class="menu-title">'.$menu['title']."</span>";
							if( $menu['value']){ 
								$products = array();	
								switch ( $menu['value'] ) {
									case 'new':
										 $products = Product::getNewProducts((int) Context::getContext()->language->id, 0, 8);
										break;
									case 'featured':
										$category = new Category(Context::getContext()->shop->getCategory(), (int)(Context::getContext()->language->id) );
										$products = $category->getProducts((int)(Context::getContext()->language->id), 1, 8);
										break;
									case 'bestseller':
										$products = ProductSale::getBestSales((int)(Context::getContext()->language->id), 0, 8,'date_add');
										break;	
									case 'special': 
										 $products = $special = Product::getPricesDrop((int)(Context::getContext()->language->id), 0, 8,false);
										break;		
								}
								$module = new novmegamenu();
								$output .= 	$module->renderProductList($products);
							}
						$output .= '</li>';
					
					break;	
				
				case 'cms':
					$selected = ($this->page_name == 'cms' && (Tools::getValue('id_cms') == $menu['value'])) ? ' class="sfHover"' : '';
					$cms = CMS::getLinks((int)$id_lang, array($menu['value']));
					if (count($cms))
						$output .= '<li'.$selected.' class="'.$class.'" '.$style.'>'. $opener .'<a href="'.Tools::HtmlEntitiesUTF8($cms[0]['link']).'" title="'.Tools::safeOutput($menu['title']).'">'.$icon.Tools::safeOutput($menu['title']).'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-sub-title">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->getSubMenu($menu['id_novmegamenu'],$id_parent,$level,$style_sub);
						$output .= '</li>'.PHP_EOL;
					break;

				// Case to handle the option to show all Manufacturers
				case 'all_manufacture':
					$link = new Link;
					$output .= '<li class="'.$class.'" '.$style.'>'. $opener .'<a href="'.$link->getPageLink('manufacturer').'" title="'.$module->l('All manufacturers').'">'.$icon.$module->l('All manufacturers').'</a>';
					if($menu['show_title'] == 1)
								$output .= '<span class="menu-title">'.$menu['title']."</span>";	
					$output .= '<ul>'.PHP_EOL;
					$manufacturers = Manufacturer::getManufacturers();
					foreach ($manufacturers as $key => $manufacturer)
						$output .= '<li><a href="'.$link->getManufacturerLink((int)$manufacturer['id_manufacturer'], $manufacturer['link_rewrite']).'" title="'.Tools::safeOutput($manufacturer['name']).'">'.$icon.Tools::safeOutput($manufacturer['name']).'</a></li>'.PHP_EOL;
					$output .= '</ul>';
					break;

				case 'manufacture':
					$selected = ($this->page_name == 'manufacturer' && (Tools::getValue('id_manufacturer') == $menu['value'])) ? ' class="sfHover"' : '';
					$manufacturer = new Manufacturer((int)$menu['value'], (int)$id_lang);
					if (!is_null($manufacturer->id))
					{
						if (intval(Configuration::get('PS_REWRITING_SETTINGS')))
							$manufacturer->link_rewrite = Tools::link_rewrite($manufacturer->name);
						else
							$manufacturer->link_rewrite = 0;
						$link = new Link;
						$output .= '<li'.$selected.' class="'.$class.'" '.$style.'>'. $opener .'<a href="'.Tools::HtmlEntitiesUTF8($link->getManufacturerLink((int)$menu['value'], $manufacturer->link_rewrite)).'" title="'.$icon.Tools::safeOutput($menu['title']).'">'.Tools::safeOutput($menu['title']).'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-sub-title">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->getSubMenu($menu['id_novmegamenu'],$id_parent,$level,$style_sub);
						$output .= '</li>'.PHP_EOL;
					}
					break;

				// Case to handle the option to show all Suppliers
				case 'all_supplier':
					$link = new Link;
					$output .= '<li class="'.$class.'" '.$style.'>'. $opener .'<a href="'.$link->getPageLink('supplier').'" title="'.$module->l('All suppliers').'">'.$icon.$module->l('All suppliers').'</a>';
					if($menu['show_title'] == 1)
								$output .= '<span class="menu-title">'.$menu['title']."</span>";
					$output .= '<ul>'.PHP_EOL;
					$suppliers = Supplier::getSuppliers();
					foreach ($suppliers as $key => $supplier)
						$output .= '<li><a href="'.$link->getSupplierLink((int)$supplier['id_supplier'], $supplier['link_rewrite']).'" title="'.Tools::safeOutput($supplier['name']).'">'.Tools::safeOutput($supplier['name']).'</a></li>'.PHP_EOL;
					$output .= '</ul>';
					break;

				case 'supplier':
					$selected = ($this->page_name == 'supplier' && (Tools::getValue('id_supplier') == $menu['value'])) ? ' class="sfHover"' : '';
					$supplier = new Supplier((int)$menu['value'], (int)$id_lang);
					if (!is_null($supplier->id))
					{
						$link = new Link;
						$output .= '<li'.$selected.' class="'.$class.'" '.$style.'>'. $opener .'<a href="'.Tools::HtmlEntitiesUTF8($link->getSupplierLink((int)$menu['value'], $supplier->link_rewrite)).'" title="'.$menu['title'].'">'.$icon.$menu['title'].'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-sub-title">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->getSubMenu($menu['id_novmegamenu'],$id_parent,$level,$style_sub);
						$output .= '</li>'.PHP_EOL;
					}
					break;

				case 'url':
						if (strpos($menu['url'], '?home=') !== false) {
							$menu['url'] = Context::getContext()->shop->getBaseURL(true, true).$menu['url'];
						}
						$output .= '<li class="'.$class.'" '.$style.'>';
							if($menu['show_title'] == 1)
							$output .= $opener.'<a href="'.Tools::HtmlEntitiesUTF8($menu['url']).'" title="'.Tools::safeOutput($menu['title']).'">'.$icon.Tools::safeOutput($menu['title']).'</a>';
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-sub-title">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->getSubMenu($menu['id_novmegamenu'],$id_parent,$level,$style_sub);
						$output .= '</li>'.PHP_EOL;
					break;
				case 'html':
						$class .= " html";				
						$output .= '<li class="'.$class.'" '.$style.'>';
							if($menu['show_title'] == 1)
								$output .= $opener.'<span class="menu-title">'.$menu['title']."</span>";
							if( $menu['html']){   
								$output .= '<div class="menu-content">'.$icon.Tools::jsonDecode(base64_decode($menu['html'])).'</div>'; 
							}
						$output .= '</li>';
					
					break;
				case 'title':
						$output .= '<li class="'.$class.'" '.$style.'>';
							if($menu['show_title'] == 1)
							$output .= $opener.'<span class="menu-title">'.$menu['title']."</span>";
							if($menu['show_sub_title'] == 1 && $menu['sub_title'])
								$output .= '<span class="menu-sub-title">'.$menu['sub_title']."</span>";
							if(count($chil) > 0 && $menu['sub_menu'] == 'yes')
								$output .= $this->getSubMenu($menu['id_novmegamenu'],$id_parent,$level,$style_sub);
						$output .= '</li>'.PHP_EOL;
					break;
			}
        }
		$output .= '</ul>';
		}
		
		
		return $output;
	}

	public function getSubMenu($id_novmegamenu,$id_parent,$level,$style_sub){
		$output = '';
			if ($id_novmegamenu != $id_parent){
				$parent = new Mgmenu($id_novmegamenu);
				$output .= '<div class="dropdown-menu" '.$style_sub.'>';
					$output .= $this->getMegamenu($id_novmegamenu, $level + 1);
				$output .= '</div>';
			 }
		return 	$output;
	}	
	
	public static function deleteMenu($idnovmegamenu){
		$object = new Mgmenu((int)$idnovmegamenu);
		if($object->delete()){
			self::deleteChildren($idnovmegamenu);
		}	
	}
	
	public static function deleteChildren($idnovmegamenu){
		$childrens =  self::getCategoryChild($idnovmegamenu);
		if($childrens){
			foreach($childrens as $children)
				self::deleteMenu($children['id_novmegamenu']);
		}
	}
	
	
	public function getCategoryChild($id_novmegamenu){
		$id_lang    = Context::getContext()->language->id;
		$id_shop    = Context::getContext()->shop->id;
		$sql = ' SELECT m.*, ml.title, ml.sub_title , ml.html, ml.url
					FROM ' . _DB_PREFIX_ . 'novmegamenu m
						LEFT JOIN ' . _DB_PREFIX_ . 'novmegamenu_lang ml ON m.id_novmegamenu = ml.id_novmegamenu AND ml.id_lang = ' . (int) $id_lang
						. ' JOIN ' . _DB_PREFIX_ . 'novmegamenu_shop ms ON m.id_novmegamenu = ms.id_novmegamenu AND ms.id_shop = ' . (int) ($id_shop).'
							WHERE m.id_parent = ' . (int) ($id_novmegamenu);			
		return Db::getInstance()->executeS($sql);					
	}

	private function getCMSMenuItems($parent, $depth = 1, $id_lang = false)
	{
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;

		if ($depth > 3)
			return;

		$categories = $this->getCMSCategories(false, (int)$parent, (int)$id_lang);
		
		$pages = $this->getCMSPages((int)$parent);

		if (count($categories) || count($pages))
		{
			$output .= '<ul>';

			foreach ($categories as $category)
			{
				$cat = new CMSCategory((int)$category['id_cms_category'], (int)$id_lang);
				
				$output .= '<li>';
				$output .= '<a href="'.Tools::HtmlEntitiesUTF8($cat->getLink()).'">'.$category['name'].'</a>';
				$this->getCMSMenuItems($category['id_cms_category'], (int)$depth + 1);
				$output .= '</li>';
			}

			foreach ($pages as $page)
			{
				$cms = new CMS($page['id_cms'], (int)$id_lang);
				$links = $cms->getLinks((int)$id_lang, array((int)$cms->id));

				$selected = ($this->page_name == 'cms' && ((int)Tools::getValue('id_cms') == $page['id_cms'])) ? ' class="sfHoverForce"' : '';
				$output .= '<li '.$selected.'>';
				$output .= '<a href="'.$links[0]['link'].'">'.$cms->meta_title.'</a>';
				$output .= '</li>';
			}

			$output .= '</ul>';
		}
	}

	public function getPositonMenu(){
		$sql = ' SELECT MAX(position) as max
					FROM ' . _DB_PREFIX_ . 'novmegamenu';
		$max =  Db::getInstance()->getRow($sql);
		return $max['max'] + 1;	
	}
}
