<?php

$vc_main = vc_manager();

extract(
	JsComposer::shortcode_atts(
		array(
			'id_supplier'  => '1',
			'title'        => '',
			'page'         => '0',
			'per_page'     => '12',
			'orderby'      => 'position',
			'order'        => 'DESC',
			'display_type' => 'grid',
		),
		$atts
	)
);

$context = Context::getContext();

if ( ! Configuration::get( 'NEW_PRODUCTS_NBR' ) ) {
	return;
}

if ( ! ( $cache_products = Product::getPricesDrop( (int) Context::getContext()->language->id, $page, $per_page, false, $orderby, $order ) ) ) {
	return;
}

$context->controller->addCSS( _THEME_CSS_DIR_ . 'product.css' );
$context->controller->addCSS( _THEME_CSS_DIR_ . 'product_list.css' );
$context->controller->addCSS( _THEME_CSS_DIR_ . 'print.css', 'print' );
$context->controller->addJqueryPlugin( array( 'fancybox', 'idTabs', 'scrollTo', 'serialScroll', 'bxslider' ) );
$context->controller->addJS(
	array(
		_THEME_JS_DIR_ . 'tools.js', // retro compat themes 1.5
	// _THEME_JS_DIR_ . 'product.js'
	)
);

$assembler = new ProductAssembler( $context );

$presenterFactory     = new ProductPresenterFactory( $context );
$presentationSettings = $presenterFactory->getPresentationSettings();
$presenter            = new PrestaShop\PrestaShop\Core\Product\ProductListingPresenter(
	new PrestaShop\PrestaShop\Adapter\Image\ImageRetriever(
		$context->link
	),
	$context->link,
	new PrestaShop\PrestaShop\Adapter\Product\PriceFormatter(),
	new PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever(),
	$context->getTranslator()
);

$products_for_template = array();

foreach ( $cache_products as $rawProduct ) {
	$products_for_template[] = $presenter->present(
		$presentationSettings,
		$assembler->assembleProduct( $rawProduct ),
		$context->language
	);
}

if ( ! JsComposer::is_admin() ) {
	$page = Context::getContext()->controller->getTemplateVarPage();
	$context->smarty->assign(
		array(
			'page' => $page,
		)
	);
	$context->smarty->assign(
		array(
			'vc_products'   => $products_for_template,
			'vc_title'      => $title,
			'elementprefix' => 'category',
		)
	);
	// print_r($products_for_template);die();
	if ( $display_type == 'sidebar' ) {
		$output = $context->smarty->fetch( JsComposer::getTPLPath( 'blockviewed.tpl' ) );
	} else {
		$output = $context->smarty->fetch( JsComposer::getTPLPath( 'blocknewproducts.tpl' ) );
	}

	echo $output;
}
