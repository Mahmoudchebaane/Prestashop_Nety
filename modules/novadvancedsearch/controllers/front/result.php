<?php
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Product\Search\Pagination;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchResult;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;
class NovAdvancedSearchResultModuleFrontController extends ModuleFrontController
{
	public $ajax_search;

	public function init(){
            parent::init();
			$this->ajax_search = Tools::getValue('ajaxSearch');
	}
	public function initContent(){

        parent::initContent();
		$query = Tools::replaceAccentedChars(urldecode(Tools::getValue('q')));
		$currency = Context::getContext()->currency;
		if ($this->ajax_search)
		{
			$id_category = (int)Tools::getValue('id_category');
			$searchResults = $this->findByCategory((int)$id_category,(int)(Tools::getValue('id_lang')), $query, 1, 10, 'position', 'desc', true);
			if (is_array($searchResults))
				foreach ($searchResults as &$product){
					$product['product_link'] = $this->context->link->getProductLink($product['id_product'], $product['crewrite'], $product['crewrite']);
					$image = Image::getCover($product['id_product']);
					$product['pimage'] = Context::getContext()->link->getImageLink($product['prewrite'], $image['id_image'], 'small_default');
					$price_tax_incl = Product::getPriceStatic((int)$product['id_product'], true);
					$product['pprice'] = Tools::displayPrice(Tools::convertPrice($price_tax_incl, $currency), $currency);
				}
			$this->ajaxDie(Tools::jsonEncode($searchResults));
		}
		if (($query = Tools::getValue('search_query', Tools::getValue('ref'))) && !is_array($query))
		{
			$n = abs((int)(Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'))));
			$p = abs((int)(Tools::getValue('p', 1)));
			$original_query = $query;
			$query = Tools::replaceAccentedChars(urldecode($query));
			$id_category = (int)Tools::getValue('id_category');
			$search = $this->findByCategory($id_category,$this->context->language->id, $query, $p, $n, $this->orderBy, $this->orderWay);
			if (is_array($search['result']))
				foreach ($search['result'] as &$product)
					$product['link'] .= (strpos($product['link'], '?') === false ? '?' : '&').'search_query='.urlencode($query).'&results='.(int)$search['total'];

			Hook::exec('actionSearch', array('expr' => $query, 'total' => $search['total']));
			$nbProducts = $search['total'];

			$pages_nb = ceil($nbProducts / (int)$n);
			$range = 2;
			$start = (int)($p - $range);
			if ($start < 1)
			    $start = 1;
			$stop = (int)($p + $range);
			if ($stop > $pages_nb)
			    $stop = (int)$pages_nb;

			$assembler = new ProductAssembler(Context::getContext());
			$presenterFactory = new ProductPresenterFactory(Context::getContext());
			$presentationSettings = $presenterFactory->getPresentationSettings();
			$presenter = new ProductListingPresenter(
				new ImageRetriever(
					Context::getContext()->link
				),
				Context::getContext()->link,
				new PriceFormatter(),
				new ProductColorsRetriever(),
				Context::getContext()->getTranslator()
			);
			if($search['result']){
				foreach ($search['result'] as &$product)
				{
					$product = $presenter->present(
						$presentationSettings,
						$assembler->assembleProduct($product),
						Context::getContext()->language
					);
				}
			}

			$protocol_link = (Configuration::get('PS_SSL_ENABLED') || Tools::usingSecureMode()) ? 'https://' : 'http://';
	        $useSSL = ((isset($this->ssl) && $this->ssl && Configuration::get('PS_SSL_ENABLED')) || Tools::usingSecureMode()) ? true : false;
	        $protocol_content = ($useSSL) ? 'https://' : 'http://';
	        $link = new Link($protocol_link, $protocol_content);

			$this->context->smarty->assign(
				array(
					'products' =>  $search['result'],
					'margin_bottom' => 30,
					'action_url' => '',
					'p' => $p,
					'n' => $n,
					'range' => $range,
					'start' => $start,
					'stop' => $stop,
					'pages_nb' => $pages_nb,
					'requestPage' => preg_replace('/&?p=[0-9]+&?/', '', $link->getPaginationLink(false, false, false, true))
				)
			);
		} else {
			$this->context->smarty->assign(array (
					'products' =>  '',
					'margin_bottom' => 30
				)
			);
		}

		$template_name  = 'module:novadvancedsearch/views/templates/front/view.tpl';
        $this->setTemplate($template_name);
	}

	public static function findByCategory($id_category=0, $id_lang, $expr, $page_number = 1, $page_size = 1, $order_by = 'position',
		$order_way = 'desc', $ajax = false, $use_cookie = true, Context $context = null)
	{

		if (!$context)
			$context = Context::getContext();
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);

		// TODO : smart page management
		if ($page_number < 1) $page_number = 1;
		if ($page_size < 1) $page_size = 1;

		$intersect_array = array();
		$score_array = array();
		$words = explode(' ', Search::sanitize($expr, $id_lang, false, $context->language->iso_code));
		$where = '';
		if($id_category != 0)
			$where = ' AND  cp.id_category = '.(int)$id_category;
		foreach ($words as $key => $word)
			if (!empty($word) && strlen($word) >= (int)Configuration::get('PS_SEARCH_MINWORDLEN'))
			{
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

				if ($word[0] != '-')
					$score_array[] = 'sw.word LIKE \''.$start_search.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\'';
			}
			else
				unset($words[$key]);

		if (!count($words))
			return ($ajax ? array() : array('total' => 0, 'result' => array()));

		$score = '';
		if (count($score_array))
			$score = ',(
				SELECT SUM(weight)
				FROM '._DB_PREFIX_.'search_word sw
				LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
				WHERE sw.id_lang = '.(int)$id_lang.'
					AND sw.id_shop = '.$context->shop->id.'
					AND si.id_product = p.id_product
					AND ('.implode(' OR ', $score_array).')
			) position';

		$sql_groups = '';
		if (Group::isFeatureActive())
		{
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
		foreach ($results as $row)
			$eligible_products[] = $row['id_product'];
		foreach ($intersect_array as $query)
		{
			$eligible_products2 = array();
			foreach ($db->executeS($query) as $row)
				$eligible_products2[] = $row['id_product'];

			$eligible_products = array_intersect($eligible_products, $eligible_products2);
			if (!count($eligible_products))
				return ($ajax ? array() : array('total' => 0, 'result' => array()));
		}

		$eligible_products = array_unique($eligible_products);

		$product_pool = '';
		foreach ($eligible_products as $id_product)
			if ($id_product)
				$product_pool .= (int)$id_product.',';
		if (empty($product_pool))
			return ($ajax ? array() : array('total' => 0, 'result' => array()));
		$product_pool = ((strpos($product_pool, ',') === false) ? (' = '.(int)$product_pool.' ') : (' IN ('.rtrim($product_pool, ',').') '));

		if ($ajax)
		{
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

		if (strpos($order_by, '.') > 0)
		{
			$order_by = explode('.', $order_by);
			$order_by = pSQL($order_by[0]).'.`'.pSQL($order_by[1]).'`';
		}
		$alias = '';
		if ($order_by == 'price')
			$alias = 'product_shop.';
		elseif (in_array($order_by, array('date_upd', 'date_add')))
			$alias = 'p.';
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
				'.(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa	ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, Context::getContext()->shop)).'
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
				LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
				Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
				WHERE p.`id_product` '.$product_pool.'
				GROUP BY product_shop.id_product
				'.($order_by ? 'ORDER BY  '.$alias.$order_by : '').($order_way ? ' '.$order_way : '').'
				LIMIT '.(int)(($page_number - 1) * $page_size).','.(int)$page_size;
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
		$total = $db->getValue($sql);

		if (!$result)
			$result_properties = false;
		else
			$result_properties = Product::getProductsProperties((int)$id_lang, $result);

		return array('total' => $total,'result' => $result_properties);
	}
}