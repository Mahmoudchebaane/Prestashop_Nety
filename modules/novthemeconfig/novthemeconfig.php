<?php

/******************
 * Vinova Themes  Framework for Prestashop 1.7.x
 * @package   	novthemeconfig
 * @version   	1.0
 * @author   	http://vinovatheme.com/
 * @copyright 	Copyright (C) October 2017 vinovatheme.com <@emai:vinovatheme@gmail.com>
 * <info@vinovatheme.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_'))
	exit;
require_once(_PS_MODULE_DIR_ . '/novthemeconfig/libs/themeconfig.php');
require_once(_PS_MODULE_DIR_ . 'novthemeconfig/libs/DataSample.php');
class novthemeconfig extends ThemeConfig
{
	protected $default_language;
	protected $languages;

	public function __construct()
	{
		$this->name = 'novthemeconfig';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->bootstrap = true;
		$this->secure_key = Tools::encrypt($this->name);
		$this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
		$this->languages = Language::getLanguages();
		$this->author = 'VinovaThemes';
		parent::__construct();
		$this->themeName = Context::getContext()->shop->theme_name;
		$this->displayName = $this->l('Vinova Themes configurator');
		$this->description = $this->l('Configure the main elements of your theme.');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->module_path = _PS_MODULE_DIR_ . $this->name . '/';
		$this->uploads_path = _PS_MODULE_DIR_ . $this->name . '/img/';
		$this->admin_tpl_path = _PS_MODULE_DIR_ . $this->name . '/views/templates/admin/';
		$this->hooks_tpl_path = _PS_MODULE_DIR_ . $this->name . '/views/templates/hooks/';
		$this->NovThemeConfig = new ThemeConfig;
		$this->defaults = $this->NovThemeConfig->getThemeFields();
	}

	public function install()
	{
		$this->installHook();
		//$this->_installSql();
		if (
			parent::install() &&
			$this->registerHook('header') &&
			$this->registerHook('home') &&
			$this->registerHook('displayFooter') &&
			$this->registerHook('displayBackOfficeHeader') &&
			$this->registerHook('countdownProduct') &&
			$this->_installSql() &&
			//$this->_defaultValues() &&
			$this->_createTab()
		) {
			return true;
		}
		return false;
	}

	private function installHook()
	{
		$hooks = array();
		require_once(_PS_MODULE_DIR_ . 'novthemeconfig/libs/hook.php');
		foreach ($hooks as $hook) {
			if (!Hook::getIdByName($hook)) {
				$install_hook = new Hook();
				$install_hook->name = pSQL($hook);
				$install_hook->title = pSQL($hook);
				$install_hook->add();
				$id_hook = $install_hook->id;
			}
		}
		return true;
	}

	public function uninstall()
	{
		$this->_unInstallSql();
		if (
			!parent::uninstall() ||
			$this->_deleteTab() ||
			!$this->_deleteConfigs()
		)
			return true;
	}

	protected function _installSql()
	{
		$sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "cms "
			. "ADD COLUMN header_type TEXT NULL,ADD COLUMN footer_type TEXT NULL";
		$returnSql = Db::getInstance()->execute($sqlInstall);
		return $returnSql;
	}

	protected function _unInstallSql()
	{
		$sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "cms "
			. "DROP header_type, DROP footer_type";
		$returnSql = Db::getInstance()->execute($sqlInstall);
		return $returnSql;
	}

	public function hookDisplayBackOfficeHeader()
	{
		$this->context->controller->addCss(($this->_path) . 'css/backoffice.css');
		$use_theme = Configuration::get("NOV_USETHEME");
		if (empty($use_theme)  || $use_theme != $this->themeName) {
			if (Configuration::updateValue("NOV_USETHEME", $this->themeName)) {
				$sample = new DataSample($this->themeName);
				$sample->importData();
			}
		}

		if (Tools::getValue('configure') != $this->name)
			return;
		$this->context->controller->addJquery();
	}

	public function psversion()
	{
		$version = _PS_VERSION_;
		$exp = $explode = explode(".", $version);
		return $exp[1];
	}

	public function hookhome($params)
	{
		global $smarty;
		if (Tools::getValue('home')) {
			Tools::clearSmartyCache();
			require(_PS_ALL_THEMES_DIR_ . $this->themeName . '/sample/ConfigHomePage.php');
			if ($this->context->cookie->__get('home')) {
				$home = $this->context->cookie->__get('home');
			} else {
				$home = Tools::getValue('home');
			}
			$CMS = new CMS($home_page[$home]['home_page'], $this->context->cookie->id_lang);
		} else {
			if ($this->context->cookie->__get('home')) {
				require(_PS_ALL_THEMES_DIR_ . $this->themeName . '/sample/ConfigHomePage.php');
				$home = $this->context->cookie->__get('home');
				$CMS = new CMS($home_page[$home]['home_page'], $this->context->cookie->id_lang);
			} else {
				$CMS = new CMS(Configuration::get('novthemeconfig_home_page'), $this->context->cookie->id_lang);
			}
		}
		if (Module::isInstalled('jscomposer') && (bool) Module::isEnabled('jscomposer')) {
			if (isset($CMS->content)) {
				$instance = Module::getInstanceByName('jscomposer');
				$instance->init();
				$cmsonhome = $instance->do_shortcode($CMS->content);
			}
		} else {
			$cmsonhome = $CMS->content;
		}
		$smarty->assign('cmsonhome', $cmsonhome);
		return ($this->display(__FILE__, '/views/templates/hook/homepage.tpl'));
	}

	public function hookHeader()
	{
		global $smarty;
		//Load css theme
		$this->context->controller->unregisterStylesheet('theme-main');
		// if(Tools::getValue('home')) {
		// 	Tools::clearSmartyCache();
		// 	$style = Tools::getValue('home');
		// 	$this->context->cookie->__set('home', Tools::getValue('home'));
		// 	$name_style = substr($style, 5, 6);
		// 	  if($name_style == '1'){
		// 		$this->context->controller->registerStylesheet('theme-main', 'themes/' . $this->themeName . '/assets/css/theme.css', ['priority' => 899]);
		// 	  } else {
		// 	  	$this->context->controller->registerStylesheet('theme-main', 'themes/' . $this->themeName . '/assets/css/home' . $name_style .'.css', ['priority' => 899]);
		// 	  }
		// } elseif($this->context->cookie->__get('home')) {
		// 	$style = $this->context->cookie->__get('home');
		// 	$name_style = substr($style, 5, 6);
		// 	  if($name_style == '1'){
		// 		$this->context->controller->registerStylesheet('theme-main', 'themes/' . $this->themeName . '/assets/css/theme.css', ['priority' => 899]);
		// 	  } else {
		// 	  	$this->context->controller->registerStylesheet('theme-main', 'themes/' . $this->themeName . '/assets/css/home' . $name_style .'.css', ['priority' => 899]);
		// 	  }
		// } else {
		$this->context->controller->registerStylesheet('theme-main', 'themes/' . $this->themeName . '/assets/css/theme.css', ['priority' => 899]);
		// }
		//Load js theme
		$autoload_jss = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/js/autoload/', '.js');
		if ($autoload_jss) {
			foreach ($autoload_jss as $autoload_js) {
				$name_autoload_js = str_replace('.', '-', $autoload_js);
				$this->context->controller->registerJavascript($name_autoload_js, 'themes/' . $this->themeName . '/assets/js/autoload/' . $autoload_js, ['position' => 'bottom', 'priority' => 150, 'attribute' => 'async']);
			}
		}
		$this->context->controller->registerJavascript('global-js', 'themes/' . $this->themeName . '/assets/js/global.js', ['position' => 'bottom', 'priority' => 151, 'attribute' => 'async']);

		//include css
		$file_csss = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/css/', '.css');
		if ($file_csss) {
			foreach ($file_csss as $file_css) {
				if ($file_css != "theme.css" && $file_css != "custom.css" && strpos($file_css, 'home') === false) {
					$name_file_css = str_replace('.', '-', $file_css);
					if ($file_css == "rtl.css" || $file_css == "rtl-global") {
						if ($this->context->language->is_rtl) {
							$this->context->controller->registerStylesheet($name_file_css, 'themes/' . $this->themeName . '/assets/css/' . $name_file_css);
						}
					} else {
						$this->context->controller->registerStylesheet($name_file_css, 'themes/' . $this->themeName . '/assets/css/' . $file_css);
					}
				}
			}
		}

		//Load bootstrap 4 css
		$bootstrap_csss = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/css/bootstrap/');
		if ($bootstrap_csss) {
			$i = 0;
			foreach ($bootstrap_csss as $bootstrap_css) {
				$i = $i++;
				$name_bootstrap_css = str_replace('.', '-', $bootstrap_css);
				$this->context->controller->registerStylesheet($name_bootstrap_css, 'themes/' . $this->themeName . '/assets/css/bootstrap/' . $bootstrap_css, ['priority' => $i]);
			}
		}

		$autoload_csss = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/css/autoload/', '.css');
		if ($autoload_csss) {
			foreach ($autoload_csss as $autoload_css) {
				$name_autoload_css = str_replace('.', '-', $autoload_css);
				$this->context->controller->registerStylesheet($name_autoload_css, 'themes/' . $this->themeName . '/assets/css/autoload/' . $autoload_css);
			}
		}

		$module_csss = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/css/modules/');
		if ($module_csss) {
			foreach ($module_csss as $module_css) {
				$name_module_css = str_replace('.', '-', $module_css);
				$this->context->controller->registerStylesheet($name_module_css, 'themes/' . $this->themeName . '/assets/css/modules/' . $module_css . '/' . $module_css . '.css');
			}
		}

		$font_awesome_csss = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/css/font-awesome/', '.css');
		if ($font_awesome_csss) {
			foreach ($font_awesome_csss as $font_awesome_css) {
				$name_font_awesome_css = str_replace('.', '-', $font_awesome_css);
				$this->context->controller->registerStylesheet($name_font_awesome_css, 'themes/' . $this->themeName . '/assets/css/font-awesome/' . $font_awesome_css);
			}
		}



		$smarty->assign('novthemeconfig_layout_lang', $this->context->language->is_rtl ? 'rtl' : 'ltr');

		//theme option
		$novconfig = $this->getConfigTheme();


		ob_start();
		include(_PS_MODULE_DIR_ . 'novthemeconfig/libs/custom_css.php');
		$custom_css = ob_get_clean();
		$custom_css = str_replace(array("\r\n", "\r"), "\n", $custom_css);
		$lines = explode("\n", $custom_css);
		$new_lines = '';
		foreach ($lines as $i => $line) {
			if (!empty($line))
				$new_lines .= trim($line);
		}

		$smarty->assign('nov_custom_css', $new_lines);
		$smarty->assign('novconfig', $novconfig);

		$smarty->assign('img_dir', _THEME_IMG_DIR_);
		$smarty->assign('img_dir_themeconfig', _MODULE_DIR_ . 'novthemeconfig/images/');
		$smarty->assign('modules_dir', _MODULE_DIR_);
		$smarty->assign('img_lang', _THEME_LANG_DIR_);

		$smarty->assign('class_homepage', self::getClassCMS($novconfig['novthemeconfig_home_page']));
		//echo('<prev>').print_r(self::getClassCMS($novconfig['novthemeconfig_home_page']),1);die();

		$smarty->assign('link', $this->context->link);

		if (Module::isInstalled('ps_customersignin') && Module::isEnabled('ps_customersignin')) {
			$ps_customersignin = Module::getInstanceByName('ps_customersignin');
			$smarty->assign('nov_customer', $ps_customersignin->getWidgetVariables('', array()));
		} else {
			$smarty->assign('nov_customer', '');
		}
		if (Module::isInstalled('ps_languageselector') && Module::isEnabled('ps_languageselector')) {
			$ps_languageselector = Module::getInstanceByName('ps_languageselector');
			$smarty->assign('nov_languages', $ps_languageselector->getWidgetVariables('displayVerticalmenu', array()));
		} else {
			$smarty->assign('nov_languages', '');
		}
		if (Module::isInstalled('ps_currencyselector') && Module::isEnabled('ps_currencyselector')) {
			$ps_currencyselector = Module::getInstanceByName('ps_currencyselector');
			$smarty->assign('nov_currency', $ps_currencyselector->getWidgetVariables('displayVerticalmenu', array()));
		} else {
			$smarty->assign('nov_currency', '');
		}
		if (Module::isInstalled('ps_bestsellers') && Module::isEnabled('ps_bestsellers')) {
			$ps_bestsellers = Module::getInstanceByName('ps_bestsellers');
			$smarty->assign('nov_bestsellers', $ps_bestsellers->getWidgetVariables('displayHome', array()));
		} else {
			$smarty->assign('nov_bestsellers', '');
		}
	}

	public function getConfigTheme()
	{
		$novconfig = array();
		$id_lang = Context::getContext()->language->id;
		foreach ($this->defaults as $key => $value) {
			if (is_array($value)) {
				$novconfig[$key] = Configuration::get($key, $this->context->language->id);
			} else {
				$prefix_key = str_replace("novthemeconfig_", "", $key);

				$novconfig[$key] = Configuration::get($key);

				if (Tools::getValue($prefix_key)) {
					Tools::clearSmartyCache();
					$novconfig[$key] = Tools::getValue($prefix_key);
					$this->context->cookie->__set($prefix_key,  Tools::getValue($prefix_key));
				}

				if (Tools::getValue('home')) {
					Tools::clearSmartyCache();
					require_once(_PS_ALL_THEMES_DIR_ . $this->themeName . '/sample/ConfigHomePage.php');
					$home = Tools::getValue('home');
					$config_home = (isset($home_page[$home]) && ($home_page[$home])) ? ($home_page[$home]) : array();
					if ($config_home) {
						foreach ($config_home as $key => $config) {
							$novconfig['novthemeconfig_' . $key] = $config;
							$this->context->cookie->__set($key, $config);
						}
					}
				}
				if (Tools::getValue('product_detail')) {
					Tools::clearSmartyCache();
					require_once(_PS_ALL_THEMES_DIR_ . $this->themeName . '/sample/ConfigHomePage.php');
					$product_detail = Tools::getValue('product_detail');
					$config_product_detail = (isset($product_detail_style[$product_detail]) && ($product_detail_style[$product_detail])) ? ($product_detail_style[$product_detail]) : array();
					if ($config_product_detail) {
						foreach ($config_product_detail as $key => $config) {
							$novconfig['novthemeconfig_' . $key] = $config;
							$this->context->cookie->__set($key, $config);
						}
					}
				}
				if (Tools::getValue('page_error')) {
					Tools::clearSmartyCache();
					require_once(_PS_ALL_THEMES_DIR_ . $this->themeName . '/sample/ConfigHomePage.php');
					$page_error = Tools::getValue('page_error');
					$config_page_error = (isset($page_error_style[$page_error]) && ($page_error_style[$page_error])) ? ($page_error_style[$page_error]) : array();
					if ($config_page_error) {
						foreach ($config_page_error as $key => $config) {
							$novconfig['novthemeconfig_' . $key] = $config;
							$this->context->cookie->__set($key, $config);
						}
					}
				}

				if ($this->context->cookie->__get($prefix_key)) {
					$novconfig[$key] = $this->context->cookie->__get($prefix_key);
				}
			}
		}
		return 	$novconfig;
	}

	private function getNameSimpleNov($name)
	{
		return preg_replace('/\s\(.*\)$/', '', $name);
	}

	public function getLayoutsXml($dir_layout_xml)
	{
		$layouts = array();
		$data = simplexml_load_string(file_get_contents($dir_layout_xml));
		if ($data) {
			$data = get_object_vars($data);
			foreach ($data['layout'] as $layout) {
				$layout = get_object_vars($layout);
				foreach ($layout['option'] as &$option) {
					$option = 	get_object_vars($option);
					$option = 	$option['@attributes'];
				}
				$layouts[] = 	$layout;
			}
		}
		return $layouts;
	}

	public function hookDisplayFooter()
	{
		global $cookie;
		$html = '';

		if ((int)Configuration::get('novthemeconfig_liveconf') == 1) {
			$layouts = array();
			$dir_layout_xml =  _PS_ALL_THEMES_DIR_ . $this->themeName . '/sample/layout.xml';
			$protocol_link = Tools::getCurrentUrlProtocolPrefix();
			$domain = Context::getContext()->shop->domain;
			$request_uri  = $protocol_link . $domain . rawurldecode($_SERVER['REQUEST_URI']);
			if (file_exists($dir_layout_xml)) {
				$layouts = $this->getLayoutsXml($dir_layout_xml);
			}
			if (Tools::isSubmit('submitConfigurator')) {
				if (Tools::getValue('novthemeconfig_image'))
					Context::getContext()->cookie->novthemeconfig_image = Tools::getValue('novthemeconfig_image');
				else
					unset(Context::getContext()->cookie->novthemeconfig_image);
				if (Tools::getValue('novthemeconfig_skin'))
					Context::getContext()->cookie->novthemeconfig_skin = Tools::getValue('novthemeconfig_skin');
				else
					unset(Context::getContext()->cookie->novthemeconfig_skin);

				if ($layouts) {
					foreach ($layouts as $layout) {
						if (Tools::getValue($layout['name']))
							Context::getContext()->cookie->$layout['name']  = Tools::getValue($layout['name']);
						else
							unset(Context::getContext()->cookie->$layout['name']);
					}
				}
				Tools::redirect($request_uri);
			} elseif (Tools::isSubmit('resetNovConfigurator')) {
				unset(Context::getContext()->cookie->novthemeconfig_image);
				unset(Context::getContext()->cookie->novthemeconfig_skin);
				if ($layouts) {
					foreach ($layouts as $layout) {
						unset(Context::getContext()->cookie->$layout['name']);
					}
				}
				Tools::redirect($request_uri);
			}


			$images = array();
			$skin_base = array();
			$imgpngs = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/img/novthemeconfig/', '.png');
			$imgjpgs = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/img/novthemeconfig/', '.jpg');
			$skin_base = $this->getFileName(_PS_ALL_THEMES_DIR_ . $this->themeName . '/assets/css/skins/', '.css', true);
			$images = array_merge($imgjpgs, $imgpngs);
			if ($layouts) {
				$d_layout = array();
				foreach ($layouts as $layout) {
					$d_layout[$layout['name']] = $this->getLayoutConfig($layout['name']);
				}
				$this->smarty->assign('layouts', $layouts);
				$this->smarty->assign('d_layout', $d_layout);
			}
			$novthemeconfig_skin = $this->getLayoutConfig('novthemeconfig_skin');
			$novthemeconfig_image = ($this->getLayoutConfig('novthemeconfig_image')) ? $this->getLayoutConfig('novthemeconfig_image') : '';

			$this->smarty->assign(array(
				'id_shop' => (int)$this->context->shop->id,
				'images' => $images,
				'url' => $this->context->shop->getBaseURL() . '/themes/' . $this->context->shop->theme_name . '/assets/img/novthemeconfig/',
				'novthemeconfig_image' => $novthemeconfig_image,
				'novthemeconfig_skin' => $novthemeconfig_skin,
				'skin_base' => $skin_base
			));

			$html .= $this->display(__FILE__, 'live_configurator.tpl');
		}
		return $html;
	}

	public function hookcountdownProduct($params)
	{
		if (Tools::getValue('novthemeconfig_countdown', (int)Configuration::get('novthemeconfig_countdown')) == 1) {
			$id_product = (int)$params['product']['id_product'];
			$id_lang = Context::getContext()->language->id;
			$specific = $this->getspecialProducts($id_product, $id_lang);
			if ($specific) {
				$id_specific_price = $specific['id_specific_price'];
				$specific_prices = self::getSpecificPriceById((int)$specific['id_specific_price']);
				$this->smarty->assign(array(
					'specific_prices' => $specific_prices,
				));
				return  $this->display(__FILE__, 'countdown.tpl');
			}
		}
	}

	public function getLiveConfiguratorToken()
	{
		return Tools::getAdminToken($this->name . (int)Tab::getIdFromClassName($this->name)
			. (is_object(Context::getContext()->employee) ? (int)Context::getContext()->employee->id :
				Tools::getValue('id_employee')));
	}

	private function getFileName($path, $file = false, $getname = false)
	{
		$result = array();
		$allfiles = glob($path . '*' . $file);
		foreach ($allfiles as $name) {
			if ($getname)
				$name = basename($name, $file);
			else
				$name = basename($name);
			$result[$name] = $name;
		}
		return $result;
	}


	public function getspecialProducts($id_product, $id_lang)
	{
		$context = Context::getContext();
		$id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
		$country = Address::getCountryAndState($id_address);
		$id_country = (int)($country['id_country'] ? $country['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT'));
		$sql = 'SELECT sp.`id_specific_price`
				FROM `' . _DB_PREFIX_ . 'product` p
				LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` ' . Shop::addSqlRestrictionOnLang('pl') . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'specific_price` sp ON (sp.`id_product` = p.`id_product`
						AND sp.`id_shop` IN(0, ' . (int)($context->shop->id) . ')
						AND sp.`id_currency` IN(0, ' . (int)($context->currency->id) . ')
						AND sp.`id_country` IN(0, ' . (int)($id_country) . ')
						AND sp.`id_group` IN(0, ' . (int)($context->customer->id_default_group) . ')
						AND sp.`id_customer` IN(0, ' . (int)($context->customer->id) . ')
						AND sp.`reduction` > 0
					)
				WHERE pl.`id_lang` = ' . (int)$id_lang .
			' AND p.`id_product` = ' . (int)$id_product . '';
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
		return 	$result;
	}

	public static function getSpecificPriceById($id_specific_price)
	{
		if (!SpecificPrice::isFeatureActive())
			return array();

		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT *
			FROM `' . _DB_PREFIX_ . 'specific_price` sp
			WHERE `id_specific_price` =' . (int)($id_specific_price));

		return $res;
	}

	public function getLayoutConfig($layout)
	{
		if (Context::getContext()->cookie->$layout)
			$v_layout = Context::getContext()->cookie->$layout;
		else
			$v_layout = Configuration::get($layout) ? Configuration::get($layout) : 'default';
		return 	$v_layout;
	}
}
