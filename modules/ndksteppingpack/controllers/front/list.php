<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2014 Hendrik Masson
 *  @license   Tous droits réservés
 */
class ndksteppingpacklistModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        $this->display_column_left = false;
        $this->display_column_right = false;
        $this->controller_name = 'list';
        parent::init();
        NdkSpack::checkSubscription();
    }

    public function initContent()
    {
        parent::initContent();
        if ((float) _PS_VERSION_ > 1.6) {
            $smarty = $this->context->smarty;
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

        $this->addCSS([
            _MODULE_DIR_ . 'ndksteppingpack/views/css/front.css' => 'all',
            _MODULE_DIR_ .
            'ndksteppingpack/views/css/font-awesome.min.css' => 'all',
            _THEME_CSS_DIR_ . 'category.css' => 'all',
            _THEME_CSS_DIR_ . 'product_list.css' => 'all',
        ]);
        $this->addJs(_MODULE_DIR_ . 'ndksteppingpack/views/js/list.js');
        $packs_id = null;
        $id_category = null;

        if (
            Tools::getValue('id_product')
            && Tools::getValue('id_product') > 0
        ) {
            $packs_id = NdkSpack::isProductInPack(
                Tools::getValue('id_product')
            );
        }
        // $id_product = Tools::getValue('id_product');
        elseif (
            Tools::getValue('id_category')
            && Tools::getValue('id_category') > 0
        ) {
            if (!Tools::getValue('id_product')) {
                $id_product = 0;
            }
            $id_category = Tools::getValue('id_category');
        }

        $packs = NdkSpack::getPacks($packs_id, $id_category);

        $this->context->smarty->assign([
            'packs' => $packs,
            'is_https' => 1 == Configuration::get('PS_SSL_ENABLED')
                && 1 == Configuration::get('PS_SSL_ENABLED_EVERYWHERE')
                    ? true
                    : false,
            'ps_version' => (float) _PS_VERSION_,
        ]);
        if ((float) _PS_VERSION_ > 1.6) {
            $this->setTemplate(
                'module:ndksteppingpack/views/templates/front/list17.tpl'
            );
        } else {
            $this->setTemplate('list.tpl');
        }
    }
}
