<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2017 Hendrik Masson
 *  @license   Tous droits réservés
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once 'vendor/autoload.php';

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;

require_once _PS_MODULE_DIR_ . 'ndksteppingpack/models/ndkSpack.php';

require_once _PS_MODULE_DIR_ . 'ndksteppingpack/models/ndkSpackStep.php';

class Ndksteppingpack extends Module
{
    protected $config_form = false;
    /**
     * @var ServiceContainer
     */
    private $container;
    
    public function __construct()
    {
        $this->module_key = '9c9b9eb5ec0ca7d9edf9f869c60568f1';
        $this->name = 'ndksteppingpack';
        $this->tab = 'front_office_features';
        $this->version = '1.5.8';
        $this->author = 'NdkDesign';
        $this->need_instance = 1;
        $this->author_address = '0x3f68a863AC7843AF0cd6249D720625023F6E1F3a';

        // Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
        $this->bootstrap = true;
        
        parent::__construct();

        $this->displayName = $this->l('Ndk Stepping Pack');
        $this->description = $this->l(
            'Allow you customers to configure their own pack step by step'
        );

        $this->confirmUninstall = $this->l(
            'Are you sure to want uninstall this module ?'
        );
        
        
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update.
     */
    public function install()
    {
        $id_lang_fr = Language::getIdByIso('FR');
        $id_lang_en = Language::getIdByIso('EN');
        $id_tab = Tab::getIdFromClassName('AdminCatalog');
        $this->installModuleTab(
            'AdminNdkSteppingPackNo',
            [(int) $this->context->language->id => 'Manage Stepping Packs'],
            0
        );
        $id_tab = Tab::getIdFromClassName('AdminNdkSteppingPackNo');

        include dirname(__FILE__) . '/sql/install.php';
        
        /* CloudSync */
        $moduleManager = ModuleManagerBuilder::getInstance()->build();
        
        if (!$moduleManager->isInstalled("ps_eventbus")) {
            $moduleManager->install("ps_eventbus");
        } else if (!$moduleManager->isEnabled("ps_eventbus")) {
            $moduleManager->enable("ps_eventbus");
            $moduleManager->upgrade('ps_eventbus');
        } else {
            $moduleManager->upgrade('ps_eventbus');
        }
        
        return parent::install()
            && $this->registerHook('displayHeader')
            //&& $this->registerHook('displayBackOfficeHeader')
            && $this->registerHook('displayFooter')
            && $this->registerHook('moduleRoutes')
            && $this->registerHook('actionOrderStatusPostUpdate')
            && $this->registerHook('actionValidateOrder')
            && $this->registerHook('actionAfterDeleteProductInCart')
            && $this->registerHook('displayProductListReviews')
            && $this->hookStandard()
            && $this->registerHook('displayProductListFunctionalButtons')
            && Configuration::updateValue(
                'NDKSTEPPINGPACK_SHOW_CATEGORY',
                false
            )
            && Configuration::updateValue('NDKSTEPPINGPACK_PAGINATE', 12)
            && $this->installModuleTab(
                'AdminNdkSteppingPack',
                [(int) $this->context->language->id => 'Manage Stepping Packs'],
                $id_tab
            )
            /*&& $this->registerHook('displayHeader') && $this->getService('ndksteppingpack.ps_accounts_installer')->install()*/;
    }
    
    /**
     * Retrieve the service
     *
     * @param string $serviceName
     *
     * @return mixed
     */
    public function getService($serviceName)
    {
        return $this->container->getService($serviceName);
    }
    
    
    public function loadServiceContainer()
    {
        if ($this->container === null) {
            $this->container = new PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer(
                $this->name,
                $this->getLocalPath()
            );
        }
    }
    
    public function hookStandard()
    {
        if ((float) _PS_VERSION_ > 1.6) {
            return $this->registerHook('displayReassurance');
        }

        return $this->registerHook('displayRightColumnProduct');
    }

    public function uninstall()
    {
        $id_lang_fr = Language::getIdByIso('FR');
        $id_tab = Tab::getIdFromClassName('AdminNdkSteppingPackNo');

        // include(dirname(__FILE__).'/sql/uninstall.php');
        if (
            !parent::uninstall()
            || !$this->uninstallModuleTab('AdminNdkSteppingPack', $id_tab)
            || !$this->uninstallModuleTab('AdminNdkSteppingPackNo', 0)
        ) {
            return false;
        }

        return true;

        return parent::uninstall();
    }

    /**
     * Load the configuration form.
     */
    public function getContent()
    {
        // If values have been submitted in the form, process.
        if (((bool) Tools::isSubmit('submitNdksteppingpackModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);
        $this->context->smarty->assign(
            'base_url',
            Tools::getHttpHost(true) . __PS_BASE_URI__
        );
        
        
        
        //include dirname(__FILE__) . '/sql/install.php';
        
        
        /*********************
        * PrestaShop Account *
        * *******************/
        
        $this->loadServiceContainer();
        
        $moduleManager = ModuleManagerBuilder::getInstance()->build();
        
        $accountsService = null;
        
        try {
            $accountsFacade = $this->getService('ndksteppingpack.ps_accounts_facade');
            $accountsService = $accountsFacade->getPsAccountsService();
        } catch (\PrestaShop\PsAccountsInstaller\Installer\Exception\InstallerException $e) {
            $accountsInstaller = $this->getService('ndksteppingpack.ps_accounts_installer');
            $accountsInstaller->install();
            $accountsFacade = $this->getService('ndksteppingpack.ps_accounts_facade');
            $accountsService = $accountsFacade->getPsAccountsService();
        }
        
        try {
            Media::addJsDef([
                'contextPsAccounts' => $accountsFacade->getPsAccountsPresenter()
                    ->present($this->name),
            ]);
        
            // Retrieve the PrestaShop Account CDN
            $this->context->smarty->assign('urlAccountsCdn', $accountsService->getAccountsCdn());
            $this->context->smarty->assign('accountIsLinked', $accountsService->isAccountLinked());
            
        
        } catch (Exception $e) {
            $this->context->controller->errors[] = $e->getMessage();
            return '';
        }
        
        /*********************
        * PrestaShop CloudSync *
        * *******************/
        
        if ($moduleManager->isInstalled("ps_eventbus")) {
              $eventbusModule =  \Module::getInstanceByName("ps_eventbus");
              if (version_compare($eventbusModule->version, '1.9.0', '>=')) {
        
                  $eventbusPresenterService = $eventbusModule->getService('PrestaShop\Module\PsEventbus\Service\PresenterService');
        
                  $this->context->smarty->assign('urlCloudsync', "https://assets.prestashop3.com/ext/cloudsync-merchant-sync-consent/latest/cloudsync-cdc.js");
        
                  Media::addJsDef([
                      'contextPsEventbus' => $eventbusPresenterService->expose($this, ['info', 'modules', 'themes'])
                  ]);
              }
          }
        
        /**********************
         * PrestaShop Billing *
         * *******************/
        
        // Load the context for PrestaShop Billing
        $billingFacade = $this->getService('ndksteppingpack.ps_billings_facade');
        $partnerLogo = $this->getLocalPath() . 'logo.png';
        $billingService = $this->getService('ndksteppingpack.ps_billings_service');
        $currentSubscription = $billingService->getCurrentSubscription();
        //dump($currentSubscription);
        NdkSpack::checkSubscription();
       
        
        // PrestaShop Billing
        Media::addJsDef($billingFacade->present([
          'logo' => $partnerLogo,
          'tosUrl' => 'https://billing.ndk-design.fr/page_view/1',
          'privacyUrl' => 'https://billing.ndk-design.fr/page_view/1',
          'tosLink' => 'https://billing.ndk-design.fr/page_view/1',
          'privacyLink' => 'https://billing.ndk-design.fr/page_view/1',
          'emailSupport' => 'support@ndk-design.fr',
           
        ]));
        Media::addJsDef([
            'hasSubscription' =>  NdkSpack::checkSubscription()
        ]);
        
        $this->context->smarty->assign('urlBilling', "https://unpkg.com/@prestashopcorp/billing-cdc/dist/bundle.js");
        
        

        $output = $this->context->smarty->fetch(
            $this->local_path . 'views/templates/admin/configure.tpl'
        );

        return $output . $this->renderForm();
    }

    
    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookDisplayHeader()
    {
        $smarty = $this->context->smarty;
        if ((float) _PS_VERSION_ > 1.6) {
            smartyRegisterFunction(
                $smarty,
                'function',
                'toolsConvertPrice',
                'toolsConvertPrice'
            );

            smartyRegisterFunction($smarty, 'function', 'dateFormat', [
                'Tools',
                'dateFormat',
            ]);
            smartyRegisterFunction($smarty, 'function', 'convertPrice', [
                'Product',
                'convertPrice',
            ]);
            smartyRegisterFunction(
                $smarty,
                'function',
                'convertPriceWithCurrency',
                ['Product', 'convertPriceWithCurrency']
            );
            smartyRegisterFunction($smarty, 'function', 'displayWtPrice', [
                'Product',
                'displayWtPrice',
            ]);
            smartyRegisterFunction(
                $smarty,
                'function',
                'displayWtPriceWithCurrency',
                ['Product', 'displayWtPriceWithCurrency']
            );
            smartyRegisterFunction($smarty, 'function', 'displayPrice', [
                'Tools',
                'displayPriceSmarty',
            ]);
            smartyRegisterFunction(
                $smarty,
                'modifier',
                'convertAndFormatPrice',
                ['Product', 'convertAndFormatPrice']
            ); // used twice
            smartyRegisterFunction($smarty, 'function', 'addJsDef', [
                'Media',
                'addJsDef',
            ]);
            smartyRegisterFunction($smarty, 'block', 'addJsDefL', [
                'Media',
                'addJsDefL',
            ]);
        }

        Media::addJsDefL('ndkspToken', Tools::getToken(false));
        Media::addJsDefL(
            'ndksp_ajax_url',
            $this->context->link->getModuleLink('ndksteppingpack', 'ajax', [
                'ajax' => true,
                'token' => Tools::getToken(false),
            ])
        );
        $this->loadAsset('views/css/front.css');
        $this->loadAsset('views/css/loader.css');
        if (Configuration::get('NDKSTEPPINGPACK_SHOW_PRODUCT_CAROUSEL')) {
            $this->loadAsset('views/css/ndk-overflowed.css');
        }

        if (
            true == Configuration::get('NDKSTEPPINGPACK_SHOW_CATEGORY')
            && ('search' == Context::getContext()->controller->php_self
                || 'category' == Context::getContext()->controller->php_self)
        ) {
            $this->loadAsset('/views/js/front.js', 'js');
        }

        if (
            true == Configuration::get('NDKSTEPPINGPACK_SHOW_CATEGORY')
            || true == Configuration::get('NDKSTEPPINGPACK_SHOW_PLISTBUTTON')
            || true == Configuration::get('NDKSTEPPINGPACK_SHOW_PBUTTON')
        ) {
            $this->loadAsset('views/css/font-awesome.min.css');
            $this->loadAsset('views/css/global.css');
            // $this->context->controller->addJS($this->_path.'/views/js/attributes.js');
        }

        $cart_url = $this->context->link->getPageLink(
            'cart',
            null,
            $this->context->language->id,
            [
                'action' => 'show',
            ],
            false,
            null,
            true
        );

        $this->context->smarty->assign([
            'show_packs_category' => Configuration::get(
                'NDKSTEPPINGPACK_SHOW_CATEGORY'
            ),
            'ps_version' => (float) _PS_VERSION_,
            'cart_url' => $cart_url,
        ]);
        
        return $this->display(__FILE__, 'headers.tpl');
    }

    public function hookDisplayFooter()
    {
        // Place your code here.
    }

    public function hookDisplayRightColumnProduct($params)
    {
        if (true == Configuration::get('NDKSTEPPINGPACK_SHOW_PBUTTON')) {
            $product = new Product(Tools::getValue('id_product'));
            $exists_in_pack = false;
            $packs_url = '';
            $shop_url = NdkSpack::getBaseURL();
            $related_packs = NdkSpack::getRelatedPacks(
                (int) $product->id_category_default
            );
            $related_packs_url =
                $shop_url .
                'index.php?fc=module&module=ndksteppingpack&controller=list&id_category=' .
                $product->id_category_default;

            if (NdkSpack::isProductInPack(Tools::getValue('id_product'))) {
                $exists_in_pack = true;
                $packs_url =
                    $shop_url .
                    'index.php?fc=module&module=ndksteppingpack&controller=list&id_product=' .
                    $product->id .
                    '&id_category=' .
                    $product->id_category_default;
            }
            $this->context->smarty->assign([
                'exists_in_pack' => $exists_in_pack,
                'packs_url' => $packs_url,
                'related_packs' => $related_packs,
                'related_packs_url' => $related_packs_url,
                'content_only' => Tools::getIsset('content_only'),
            ]);

            return $this->display(__FILE__, 'ndksp.tpl');
        }
    }

    public function hookDisplayReassurance($params)
    {
        return $this->hookDisplayRightColumnProduct($params);
    }

    public function hookDisplayProductListFunctionalButtons($params)
    {
        if (true == Configuration::get('NDKSTEPPINGPACK_SHOW_PLISTBUTTON')) {
            $exists_in_pack = false;
            $packs_url = '';
            $shop_url = NdkSpack::getBaseURL();
            if (NdkSpack::isProductInPack($params['product']['id_product'])) {
                $exists_in_pack = true;
                $packs_url =
                    $shop_url .
                    'index.php?fc=module&module=ndksteppingpack&controller=list&id_product=' .
                    $params['product']['id_product'];
            }

            $this->context->smarty->assign([
                'exists_in_pack' => $exists_in_pack,
                'packs_url' => $packs_url,
            ]);

            return $this->display(__FILE__, 'ndksplistbutton.tpl');
        }
    }

    public function hookDisplayProductListReviews($params)
    {
        if (
            'module-ndksteppingpack-default' ==
            Context::getContext()->controller->php_self
        ) {
            $this->context->smarty->assign([
                'allow_oosp' => $params['product']['allow_oosp'],
                'id_product' => $params['product']['id_product'],
                'minimal_quantity' => $params['product']['minimal_quantity'],
                'ndksp_combinations' => $this->getProductAttributeCombinations(
                    $params['product']['id_product']
                ),
            ]);

            if ((float) _PS_VERSION_ > 1.6) {
                return $this->display(__FILE__, 'ndkspattr_17.tpl');
            }

            return $this->display(__FILE__, 'ndkspattr.tpl');
        }
    }

    public function hookAjaxCall($params)
    {
        $smarty = $this->context->smarty;
        if (Module::isEnabled('ndk_custom_product_page')) {
            $ndkccp = Module::getInstanceByName('ndk_custom_product_page');
            $ndkccp->assignStandards();
        }
        if ((float) _PS_VERSION_ > 1.6) {
            smartyRegisterFunction(
                $smarty,
                'function',
                'toolsConvertPrice',
                'toolsConvertPrice'
            );

            smartyRegisterFunction($smarty, 'function', 'dateFormat', [
                'Tools',
                'dateFormat',
            ]);
            smartyRegisterFunction($smarty, 'function', 'convertPrice', [
                'Product',
                'convertPrice',
            ]);
            smartyRegisterFunction(
                $smarty,
                'function',
                'convertPriceWithCurrency',
                ['Product', 'convertPriceWithCurrency']
            );
            smartyRegisterFunction($smarty, 'function', 'displayWtPrice', [
                'Product',
                'displayWtPrice',
            ]);
            smartyRegisterFunction(
                $smarty,
                'function',
                'displayWtPriceWithCurrency',
                ['Product', 'displayWtPriceWithCurrency']
            );
            smartyRegisterFunction($smarty, 'function', 'displayPrice', [
                'Tools',
                'displayPriceSmarty',
            ]);
            smartyRegisterFunction(
                $smarty,
                'modifier',
                'convertAndFormatPrice',
                ['Product', 'convertAndFormatPrice']
            ); // used twice
            smartyRegisterFunction($smarty, 'function', 'addJsDef', [
                'Media',
                'addJsDef',
            ]);
            smartyRegisterFunction($smarty, 'block', 'addJsDefL', [
                'Media',
                'addJsDefL',
            ]);
        }
        $this->context->smarty->assign(
            'base_url',
            Tools::getHttpHost(true) . __PS_BASE_URI__
        );

        if (isset($params['search']) && '' != $params['search']) {
            $packs = NdkSpack::getPacks(null, null, $params['search']);

            $this->context->smarty->assign([
                'packs' => $packs,
                'is_https' => 1 == Configuration::get('PS_SSL_ENABLED')
                    && 1 == Configuration::get('PS_SSL_ENABLED_EVERYWHERE')
                        ? true
                        : false,
                'ps_version' => (float) _PS_VERSION_,
            ]);

            return $this->display(__FILE__, 'search-result.tpl');
            // $res = json_encode($res);
            // var_dump($res);
        }
        if (
            isset($params['categorycontext'])
            && '' != $params['categorycontext']
        ) {
            $packs = NdkSpack::getPacks(
                null,
                (int) $params['categorycontext'],
                null
            );

            $this->context->smarty->assign([
                'packs' => $packs,
                'is_https' => 1 == Configuration::get('PS_SSL_ENABLED')
                    && 1 == Configuration::get('PS_SSL_ENABLED_EVERYWHERE')
                        ? true
                        : false,
                'ps_version' => (float) _PS_VERSION_,
            ]);

            return $this->display(__FILE__, 'search-result.tpl');
            // $res = json_encode($res);
            // var_dump($res);
        }
        if (isset($params['products']) && '' != $params['products']) {
            $products = $params['products'];
            $products_for_template = [];
            if ((float) _PS_VERSION_ > 1.6) {
                $assembler = new ProductAssembler($this->context);

                $presenterFactory = new ProductPresenterFactory($this->context);
                $presentationSettings = $presenterFactory->getPresentationSettings();
                $presenter = new ProductListingPresenter(
                    new ImageRetriever($this->context->link),
                    $this->context->link,
                    new PriceFormatter(),
                    new ProductColorsRetriever(),
                    $this->context->getTranslator()
                );

                foreach ($products as $rawProduct) {
                    $products_for_template[] = $presenter->present(
                        $presentationSettings,
                        $assembler->assembleProduct($rawProduct),
                        $this->context->language
                    );
                }
                $this->context->smarty->assign([
                    'urls' => $this->context->controller->getTemplateVarUrls(),
                    'static_token' => Tools::getToken(false),
                ]);
                $products = $products_for_template;
            }

            $p = 0;
            foreach ($products as $prod) {
                $products[$p]['cart_quantity'] =
                    $params['products'][$p]['cart_quantity'];
                ++$p;
            }
            $this->context->smarty->assign([
                'products' => $products,
                'static_token' => Tools::getToken(false),
                'link' => $this->context->link,
                'steps_nb' => $params['steps_nb'],
            ]);

            return $this->display(__FILE__, 'resume.tpl');
            // $res = json_encode($res);
            // var_dump($res);
        }
    }

    public function ajaxCall()
    {
        
        
        if (Module::isEnabled('ndk_custom_product_page')) {
            $ndkccp = Module::getInstanceByName('ndk_custom_product_page');
            $ndkccp->assignStandards();
        }
        $id_step = Tools::getValue('id_step');
        $paginate = Tools::getValue('paginate');
        if ((int) $paginate < 1) {
            $paginate = 1;
        }
        $step = new ndkSpackStep((int) $id_step);
        $products = $step->getProducts(false, (int) $paginate);

        $products_for_template = [];

        if ((float) _PS_VERSION_ > 1.6) {
            $assembler = new ProductAssembler($this->context);

            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(
                new ImageRetriever($this->context->link),
                $this->context->link,
                new PriceFormatter(),
                new ProductColorsRetriever(),
                $this->context->getTranslator()
            );
            foreach ($products as $rawProduct) {
                $products_for_template[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($rawProduct),
                    $this->context->language
                );
            }
            $this->context->smarty->assign([
                'urls' => $this->context->controller->getTemplateVarUrls(),
                'static_token' => Tools::getToken(false),
            ]);
        }
        if ((float) _PS_VERSION_ > 1.6) {
            if (
                Tools::file_exists_no_cache(
                    _PS_THEME_DIR_ . 'templates/catalog/_partials/products.tpl'
                )
            ) {
                $tpl_list =
                    _PS_THEME_DIR_ . 'templates/catalog/_partials/products.tpl';
            } else {
                $tpl_list =
                    _PS_PARENT_THEME_DIR_ .
                    'templates/catalog/_partials/products.tpl';
            }
        }

        $iqitTheme = [];
        if (Module::isInstalled('iqitthemeeditor')) {
            $iqitthemeeditor = Module::getInstanceByName('iqitthemeeditor');
            $optionsData = Configuration::get(
                $iqitthemeeditor->cfgName . 'options'
            );
            $iqitTheme = $iqitthemeeditor->getOptions($optionsData);
            $iqitTheme['pl_lazyload'] = false;
            // var_dump($iqitTheme);
        }

        $pagination = $step->getProducts(false, (int) $paginate, true);
        $this->context->smarty->assign([
            'products' => $products_for_template,
            'listing' => [
                'products' => $products_for_template,
                'pagination' => $pagination,
            ],
            'tpl_list' => $tpl_list,
            'ps_version' => (float) _PS_VERSION_,
            'page' => $this->context->controller->getTemplateVarPage(),
            'iqitTheme' => $iqitTheme,
            'link' => Context::getContext()->link,
        ]);

        if ((float) _PS_VERSION_ > 1.6) {
            // $res = $this->context->smarty->fetch(_PS_THEME_DIR_.'templates/catalog/listing/product-list.tpl', null, $this->context->controller->getLayout());
            $res = $this->display(__FILE__, 'product-list.tpl');
        } else {
            $res = $this->context->smarty->fetch(
                _PS_THEME_DIR_ . 'product-list.tpl'
            );
        }

        return $res;
    }

    public function hookAjaxPopup($params)
    {
        $this->context->smarty->assign([
            'products' => $params['products'],
            'static_token' => Tools::getToken(false),
        ]);

        return $this->display(__FILE__, 'resume-popup.tpl');
        // $res = json_encode($res);
        // var_dump($res);
    }

    public function installcleanPositions($id, $id_parent)
    {
        $result = Db::getInstance()->ExecuteS(
            '
                SELECT `id_tab`,`position`
                FROM `' .
                _DB_PREFIX_ .
                'tab`
                WHERE `id_parent` = ' .
                (int) $id_parent .
                '
                AND `id_tab` != ' .
                (int) $id .
                '
                ORDER BY `position`'
        );
        $sizeof = count($result);
        for ($i = 0; $i < $sizeof; ++$i) {
            Db::getInstance()->Execute(
                '
                    UPDATE `' .
                    _DB_PREFIX_ .
                    'tab`
                    SET `position` = ' .
                    (int) ($result[$i]['position'] + 1) .
                    '
                    WHERE `id_tab` = ' .
                    (int) $result[$i]['id_tab']
            );
        }

        Db::getInstance()->Execute(
            '
                    UPDATE `' .
                _DB_PREFIX_ .
                'tab`
                    SET `position` = 1
                    WHERE `id_tab` = ' .
                (int) $id
        );

        return true;
    }

    public function uninstallcleanPositions($id_parent)
    {
        $result = Db::getInstance()->ExecuteS(
            '
                SELECT `id_tab`
                FROM `' .
                _DB_PREFIX_ .
                'tab`
                WHERE `id_parent` = ' .
                (int) $id_parent .
                '
                ORDER BY `position`'
        );
        $sizeof = count($result);
        for ($i = 0; $i < $sizeof; ++$i) {
            Db::getInstance()->Execute(
                '
                    UPDATE `' .
                    _DB_PREFIX_ .
                    'tab`
                    SET `position` = ' .
                    ($i + 1) .
                    '
                    WHERE `id_tab` = ' .
                    (int) $result[$i]['id_tab']
            );
        }

        return true;
    }

    public function hookModuleRoutes($params)
    {
        if (!Configuration::get('PS_REWRITING_SETTINGS')) {
            return null;
        }

        $languages = Language::getLanguages(true);
        $my_link = [];

        $alias = 'pack';
        $aliasList1 = 'packs';
        $aliasList = $this->l('our_packs');
        foreach ($languages as $l) {
            $my_link['ndkspack_' . $l['id_lang']] = [
                'controller' => 'default',
                'rule' => $alias . '/{id_pack}_{rewrite}',
                'keywords' => [
                    'id_pack' => ['regexp' => '[0-9]+', 'param' => 'id_pack'],
                    'rewrite' => ['regexp' => '[_a-zA-Z0-9-\pL]*'],
                ],
                'params' => [
                    'fc' => 'module',
                    'module' => 'ndksteppingpack',
                ],
            ];

            $my_link['ndkspacklist_' . $l['id_lang']] = [
                'controller' => 'list',
                'rule' => $aliasList1 . '/' . $aliasList,
                'keywords' => [],
                'params' => [
                    'fc' => 'module',
                    'module' => 'ndksteppingpack',
                ],
            ];
        }

        return $my_link;
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
        $order = new Order((int) $params['id_order']);
        $new_os = $params['newOrderStatus'];

        // if ($new_os->shipped) {
        //     return NdkSpack::deleteTempPack((int) $order->id);
        // }

        return true;
    }

    public function hookActionAfterDeleteProductInCart($params)
    {
        if (Tools::getValue('delete') && Tools::getValue('id_product')) {
            return NdkSpack::deleteTempPackFromCart(
                (int) Tools::getValue('id_product'),
                (int) Tools::getValue('id_customization')
            );
        }
    }

    public function hookActionValidateOrder($params)
    {
        /*if (!Validate::isLoadedObject($params['order']))
                die(Tools::displayError('Missing parameters'));
            $context = Context::getContext();
            $id_lang = (int)$context->language->id;
            $id_shop = (int)$context->shop->id;
            $order = $params['order'];

            return NdkSpack::synchronizeWharehouseStock((int)$order->id);*/

        return true;
    }

    public static function getProductAttributeCombinations($id_product)
    {
        $combinations = [];
        $context = Context::getContext();
        $product = new Product($id_product, $context->language->id);
        $attributes_groups = $product->getAttributesGroups(
            $context->language->id
        );
        $att_grps = '';
        $usetax = Group::getPriceDisplayMethod(
            Group::getPriceDisplayMethod(
                $context->customer->id_default_group
            )
        );
        $usetax = PS_TAX_INC == Product::$_taxCalculationMethod;
        foreach ($attributes_groups as $k => $row) {
            $combinations[$row['id_product_attribute']]['attributes_values'][
                $row['id_attribute_group']
            ] = $row['attribute_name'];
            $combinations[$row['id_product_attribute']]['attributes_group'][
                $row['id_attribute_group']
            ] = $row['public_group_name'];

            $combinations[$row['id_product_attribute']][
                'attributes_groups'
            ] = @implode(
                ', ',
                $combinations[$row['id_product_attribute']]['attributes_group']
            );
            $att_grps =
                $combinations[$row['id_product_attribute']][
                    'attributes_groups'
                ];
            $combinations[$row['id_product_attribute']][
                'attributes_names'
            ] = @implode(
                ', ',
                $combinations[$row['id_product_attribute']]['attributes_values']
            );
            $combinations[$row['id_product_attribute']]['attributes'][] =
                (int) $row['id_attribute'];
            $price = Product::getPriceStatic(
                (int) $id_product,
                $usetax,
                $row['id_product_attribute'],
                6,
                null,
                false,
                true,
                1,
                false,
                null,
                null,
                null
            );
            if($row['price'] != 0){
                $combinations[$row['id_product_attribute']]['price'] = $price;
                $combinations[$row['id_product_attribute']]['display_price'] = Tools::displayPrice($price);
            }
            else{
                $combinations[$row['id_product_attribute']]['price'] = false;
                $combinations[$row['id_product_attribute']]['display_price'] = false;
            }
            // var_dump($row);
            $combinations[$row['id_product_attribute']]['ecotax'] =
                (float) $row['ecotax'];
            $combinations[$row['id_product_attribute']]['weight'] =
                (float) $row['weight'];
            $combinations[$row['id_product_attribute']]['quantity'] =
                (int) $row['quantity'];
            $combinations[$row['id_product_attribute']]['reference'] =
                $row['reference'];
            $combinations[$row['id_product_attribute']]['unit_impact'] =
                $row['unit_price_impact'];
            $combinations[$row['id_product_attribute']]['minimal_quantity'] =
                $row['minimal_quantity'];
            $combinations[$row['id_product_attribute']]['default_on'] =
                $row['default_on'];

            if ('0000-00-00' != $row['available_date']) {
                $combinations[$row['id_product_attribute']]['available_date'] =
                    $row['available_date'];
                $combinations[$row['id_product_attribute']][
                    'date_formatted'
                ] = Tools::displayDate($row['available_date']);
            } else {
                $combinations[$row['id_product_attribute']]['available_date'] =
                    '';
            }
            foreach ($combinations as $id_product_attribute => $comb) {
                $attribute_list = '';
                foreach ($comb['attributes'] as $id_attribute) {
                    $attribute_list .= '\'' . (int) $id_attribute . '\',';
                }
                $attribute_list = rtrim($attribute_list, ',');
                $combinations[$id_product_attribute]['list'] = $attribute_list;
            }
            $stock = (int) Product::getQuantity(
                (int) $product->id,
                (int) $row['id_product_attribute'],
                null,
                Context::getContext()->cart
            );
            if ($stock <= 0) {
                if (
                    0 == Product::isAvailableWhenOutOfStock(
                        $product->out_of_stock
                    )
                ) {
                    unset($combinations[$row['id_product_attribute']]);
                }
            }
        }

        return [
            'attribute_groups' => $att_grps,
            'values' => $combinations,
        ];
    }

    public function loadAsset($file, $type = 'css', $options = [], $name = '')
    {
        // ex : $this->loadAsset('views/js/myfile.js', 'js', array('position' => 'bottom', 'priority' => 100, 'attibutes' => 'async'), 'myfilename');
        // ex : $this->loadAsset('views/css/myfile.css');

        if (0 == sizeof($options)) {
            if ('js' == $type) {
                $options = [
                    'priority' => 100,
                    'attributes' => 'none',
                    'position' => 'bottom',
                ];
            } else {
                $options = ['media' => 'all', 'priority' => 50];
            }
        }
        if ('' == $name) {
            $prefix = '';
            $prefix_arr = explode('_', $this->name);
            foreach ($prefix_arr as $row) {
                $prefix .= substr($row, 0, 1);
            }
            $search = ['/', '.', 'views', 'js', 'css'];
            $replace = ['_', '', '', '', ''];
            $name = $prefix . str_replace($search, $replace, $file);
        }
        if (
            (float) _PS_VERSION_ < 1.7
            || strpos('Admin', Tools::getValue('controller')) < -1
        ) {
            if ('js' == $type) {
                $this->context->controller->addJS($this->_path . $file);
            } else {
                $this->context->controller->addCSS($this->_path . $file, 'all');
            }
        } else {
            if ('js' == $type) {
                $this->context->controller->registerJavascript(
                    $name,
                    '/modules/' . $this->name . '/' . $file,
                    $options
                );
            } else {
                $this->context->controller->registerStylesheet(
                    $name,
                    '/modules/' . $this->name . '/' . $file,
                    $options
                );
            }
        }
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get(
            'PS_BO_ALLOW_EMPLOYEE_FORM_LANG',
            0
        );

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitNdksteppingpackModule';
        $helper->currentIndex =
            $this->context->link->getAdminLink('AdminModules', false) .
            '&configure=' .
            $this->name .
            '&tab_module=' .
            $this->tab .
            '&module_name=' .
            $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFormValues() /* Add values for your inputs */,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$this->getConfigForm()]);
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('product pagination'),
                        'name' => 'NDKSTEPPINGPACK_PAGINATE',
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Show modal popup'),
                        'name' => 'NDKSTEPPINGPACK_SHOW_MODAL_POPUP',
                        'is_bool' => true,
                        'desc' => $this->l(
                            'Will show a prompt between each step'
                        ),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],

                    [
                        'type' => 'switch',
                        'label' => $this->l(
                            'Show pack on categories and search result'
                        ),
                        'name' => 'NDKSTEPPINGPACK_SHOW_CATEGORY',
                        'is_bool' => true,
                        'desc' => $this->l(
                            'Will show related packs on top of products list'
                        ),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],

                    [
                        'type' => 'switch',
                        'label' => $this->l('Show product list button'),
                        'name' => 'NDKSTEPPINGPACK_SHOW_PLISTBUTTON',
                        'is_bool' => true,
                        'desc' => $this->l(
                            'Will show a button on products list'
                        ),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],

                    [
                        'type' => 'switch',
                        'label' => $this->l('Show product page button'),
                        'name' => 'NDKSTEPPINGPACK_SHOW_PBUTTON',
                        'is_bool' => true,
                        'desc' => $this->l(
                            'Will show a button on products page'
                        ),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Show products into carousel'),
                        'name' => 'NDKSTEPPINGPACK_SHOW_PRODUCT_CAROUSEL',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Auto animate TimeLine'),
                        'name' => 'NDKSTEPPINGPACK_AUTO_TIMELINE',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                ],

                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return [
            'NDKSTEPPINGPACK_SHOW_CATEGORY' => Configuration::get(
                'NDKSTEPPINGPACK_SHOW_CATEGORY'
            ),
            'NDKSTEPPINGPACK_SHOW_PLISTBUTTON' => Configuration::get(
                'NDKSTEPPINGPACK_SHOW_PLISTBUTTON'
            ),
            'NDKSTEPPINGPACK_SHOW_PBUTTON' => Configuration::get(
                'NDKSTEPPINGPACK_SHOW_PBUTTON'
            ),
            'NDKSTEPPINGPACK_SHOW_MODAL_POPUP' => Configuration::get(
                'NDKSTEPPINGPACK_SHOW_MODAL_POPUP'
            ),
            'NDKSTEPPINGPACK_SHOW_PRODUCT_CAROUSEL' => Configuration::get(
                'NDKSTEPPINGPACK_SHOW_PRODUCT_CAROUSEL'
            ),
            'NDKSTEPPINGPACK_AUTO_TIMELINE' => Configuration::get(
                'NDKSTEPPINGPACK_AUTO_TIMELINE'
            ),
            'NDKSTEPPINGPACK_PAGINATE' => Configuration::get(
                'NDKSTEPPINGPACK_PAGINATE'
            ),
        ];
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    private function installModuleTab($tabClass, $tabName, $idTabParent)
    {
        $tab = new Tab();

        $langues = Language::getLanguages(false);
        foreach ($langues as $langue) {
            if (!isset($tabName[$langue['id_lang']])) {
                $tabName[$langue['id_lang']] =
                    $tabName[(int) $this->context->language->id];
            }
        }

        $tab->name = $tabName;
        $tab->class_name = $tabClass;
        $tab->module = $this->name;
        $tab->id_parent = $idTabParent;
        $id_tab = $tab->save();
        if (!$id_tab) {
            return false;
        }

        // $this->installcleanPositions($tab->id, $idTabParent);

        return true;
    }

    private function uninstallModuleTab($tabClass, $idTabParent)
    {
        $idTab = Tab::getIdFromClassName($tabClass);
        if (0 != $idTab) {
            $tab = new Tab($idTab);
            $tab->delete();
            // $this->uninstallcleanPositions($idTabParent);
            return true;
        }

        return false;
    }
}
