<?php
/******************
 * Vinova Themes  Framework for Prestashop 1.7.x
 * @package   	novadvancedsearch
 * @version   	1.0
 * @author   	http://vinovathemes.com/
 * @copyright 	Copyright (C) October 2017 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/

if (!defined('_PS_VERSION_'))
	exit;

class NovAdvancedSearch extends Module
{
	public function __construct()
	{
		$this->name = 'novadvancedsearch';
		$this->tab = 'search_filter';
		$this->version = '1.0.0';
		$this->author = 'vinovatheme';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Nova Quick Search Product By Category');
		$this->description = $this->l('Adds a quick search field to your website.');
		$this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
	}

	public function install()
	{
		if (!parent::install() || !$this->registerHook('displayAdvanceSearch') || !$this->registerHook('header') || !$this->registerHook('displayMobileTopSiteMap'))
			return false;
		return true;
	}

	public function hookdisplayMobileTopSiteMap($params)
	{
		$this->smarty->assign(array('hook_mobile' => true, 'instantsearch' => false));
		$params['hook_mobile'] = true;
		return $this->hookTop($params);
	}


	public function hookHeader($params)
	{
		$this->context->controller->addCSS(($this->_path).'novadvancedsearch.css', 'all');

		if (Configuration::get('PS_SEARCH_AJAX'))
			$this->context->controller->addJS ($this->_path.'jquery.autocomplete.js');

		if (Configuration::get('PS_INSTANT_SEARCH'))
			$this->context->controller->addCSS(_THEME_CSS_DIR_.'product_list.css');

		if (Configuration::get('PS_SEARCH_AJAX') || Configuration::get('PS_INSTANT_SEARCH'))
		{
			Media::addJsDef(array('search_url' => $this->context->link->getPageLink('search', Tools::usingSecureMode())));
			$this->context->controller->addJS(($this->_path).'novadvancedsearch.js');
		}
	}

	public function hookLeftColumn($params)
	{
		return $this->hookRightColumn($params);
	}

	public function hookRightColumn($params)
	{
		if (Tools::getValue('search_query') || !$this->isCached('module:novadvancedsearch/novadvancedsearch.tpl', $this->getCacheId()))
		{
			$this->calculHookCommon($params);
			$this->smarty->assign(array(
				'novadvancedsearch_type' => 'block',
				'search_query' => (string)Tools::getValue('search_query')
				)
			);
		}
		Media::addJsDef(array('novadvancedsearch_type' => 'block'));
		return $this->display(__FILE__, 'novadvancedsearch.tpl', Tools::getValue('search_query') ? null : $this->getCacheId());
	}

	public function hookdisplayAdvanceSearch($params)
	{
		$key = $this->getCacheId('novadvancedsearch-top'.((!isset($params['hook_mobile']) || !$params['hook_mobile']) ? '' : '-hook_mobile'));
		if (Tools::getValue('search_query') || !$this->isCached('module:novadvancedsearch/novadvancedsearch-top.tpl', $key))
		{
			$categoriesTree  = Category::getRootCategory()->recurseLiteCategTree(0);
			//echo"<pre>".print_r($categoriesTree);die();
			$id_category =  Tools::getValue('id_category') ? Tools::getValue('id_category') : 0;
			$this->calculHookCommon($params);
			$this->smarty->assign(array(
				'novcategoriesTree'	=>	$categoriesTree,
				'novadvancedsearch_type' => 'top',
				'id_category'		=> $id_category,
				'search_query' => (string)Tools::getValue('search_query'),
				'id_lang'		=> Context::getContext()->language->id
				)
			);
		}
		Media::addJsDef(array('novadvancedsearch_type' => 'top'));

		return $this->display(__FILE__, 'novadvancedsearch-top.tpl', Tools::getValue('search_query') ? null : $key);
	}

	public function hookDisplayNav($params)
	{
		return $this->hookTop($params);
	}

	private function calculHookCommon($params)
	{
		$this->smarty->assign(array(
			'ENT_QUOTES' =>		ENT_QUOTES,
			'search_ssl' =>		Tools::usingSecureMode(),
			'ajaxsearch' =>		Configuration::get('PS_SEARCH_AJAX'),
			'instantsearch' =>	Configuration::get('PS_INSTANT_SEARCH'),
			'self' =>			dirname(__FILE__),
		));

		return true;
	}

}

