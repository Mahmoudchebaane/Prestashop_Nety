<?php
/**
 *  Tous droits réservés NDKDESIGN.
 *
 *  @author    Hendrik Masson <postmaster@ndk-design.fr>
 *  @copyright Copyright 2013 - 2016 Hendrik Masson
 *  @license   Tous droits réservés
 */

use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;

class ndksteppingpackdefaultModuleFrontController extends ModuleFrontController
{
    // public $php_self = 'ndksteppingpack-default';
    public function init()
    {
        $this->display_column_left = false;
        $this->display_column_right = false;
        $this->item = new NdkSpack(
            Tools::getValue('id_pack'),
            Context::getContext()->language->id
        );
        $this->controller_name = 'default';
        parent::init();
        //NdkSpack::checkSubscription();
    }

    public function initContent()
    {
        parent::initContent();

        $this->context->controller->addCSS([
            _MODULE_DIR_ . 'ndksteppingpack/views/css/front.css' => 'all',
            _MODULE_DIR_ . 'ndksteppingpack/views/css/loader.css' => 'all',
            _MODULE_DIR_ . 'ndksteppingpack/views/css/font-awesome.min.css' => 'all',
            _THEME_CSS_DIR_ . 'category.css' => 'all',
            _THEME_CSS_DIR_ . 'product_list.css' => 'all',
        ]);

        if (Configuration::get('NDKSTEPPINGPACK_SHOW_PRODUCT_CAROUSEL')) {
            if ((float) _PS_VERSION_ > 1.6) {
                $this->context->controller->registerJavascript(
                    'ndksp-overflow',
                    'modules/ndksteppingpack/views/js/ndk-overflow.js',
                    ['position' => 'bottom', 'priority' => 150]
                );
            } else {
                $this->addJS(_MODULE_DIR_ . 'ndksteppingpack/views/js/ndk-overflow.js');
            }
        }

        if ((float) _PS_VERSION_ > 1.6) {
            $this->context->controller->registerJavascript(
                'ndksp-front',
                'modules/ndksteppingpack/views/js/front.js',
                ['position' => 'bottom', 'priority' => 150]
            );
            $this->context->controller->registerJavascript(
                'ndksp-attr',
                'modules/ndksteppingpack/views/js/attributes.js',
                ['position' => 'bottom', 'priority' => 150]
            );
            // $this->context->controller->registerJavascript(
            //     'ndksp-loader',
            //     'modules/ndksteppingpack/views/js/ndkloader.min.js',
            //     ['position' => 'bottom', 'priority' => 150]
            // );
        } else {
            $this->addJS(_MODULE_DIR_ . 'ndksteppingpack/views/js/front.js');
            $this->addJS(
                _MODULE_DIR_ . 'ndksteppingpack/views/js/attributes.js'
            );
            // $this->addJS(_MODULE_DIR_.'ndksteppingpack/views/js/ndkloader.min.js');
        }

        $this->addJqueryPlugin(['fancybox']);

        $pack = new NdkSpack(
            Tools::getValue('id_pack'),
            Context::getContext()->language->id
        );
        
        // if(!NdkSpack::checkSubscription())
        // {
        //     $pack = new NdkSpack();
        // }

        $this->context->smarty->assign(Meta::completeMetaTags([], $pack->name));

        if ($pack->fixed_price > 0 && 1 == $pack->type) {
            $pack->fixed_price = Product::getPriceStatic(
                (int) $pack->id_pack_prod
            );
        }
        
        goto K03PV; K03PV: if (NdkSpack::Og3Z8()) { goto gJLjh; } goto Ii2nd; Ii2nd: $Vs5UA = new NdkSpack(); goto GoXsf; GoXsf: gJLjh:

        $steps = $pack->getPAckSteps();
        $stepsLite = $pack->getPAckStepsLite();

        Media::addJsDef(['stepsLite' => $stepsLite]);
        Media::addJsDef(['autotimeline' => Configuration::get('NDKSTEPPINGPACK_AUTO_TIMELINE')]);
        // ************** Modif By Polykode *************

        $disablePack = false;

        foreach ($stepsLite as $stepToTest) {
            if ($stepToTest['minimum'] > 0) {
                // On skip les étapes optionelles
                $nb_product_out_of_stock = 0;

                $productList = explode(',', $stepToTest['products']);

                foreach ($productList as $productToTest) {
                    if (
                        StockAvailable::getQuantityAvailableByProduct(
                            (int) $productToTest,
                            0
                        ) < 1
                        && 0 == Product::isAvailableWhenOutOfStock(
                            StockAvailable::outOfStock((int) $productToTest)
                        )
                    ) {
                        ++$nb_product_out_of_stock;
                    }
                }

                // var_dump( $nb_product_out_of_stock );

                if ($nb_product_out_of_stock > $stepToTest['minimum']) {
                    // si le le minum de produit de l'étape n'est pas dispo on désactive le pack
                    // $disablePack = true;
                    $disablePack = false;
                    break;
                }
            }
        }

        // **********************************************

        if ($pack->id_cart_rule > 0) {
            $cart_rule = new CartRule(
                $pack->id_cart_rule,
                Context::getContext()->language->id
            );
        } else {
            $cart_rule = false;
        }

        $added = [];
        foreach ($steps as $step) {
            $added[$step['id']] = 0;
        }

        if (0 == $pack->active) {
            $disablePack = true;
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
        
        
        $tpl_list =
            _PS_ROOT_DIR_ .
            '/modules/ndksteppingpack/views/templates/front/product-list.tpl';

        $this->context->smarty->assign([
            'pack' => $pack,
            'steps' => $steps,
            'stepsLite' => json_encode($stepsLite),
            'disablePack' => $disablePack,
            'cart_rule' => $cart_rule,
            'added' => json_encode($added),
            'tpl_list' => $tpl_list,
            'ps_version' => (float) _PS_VERSION_,
            'cart_url' => $cart_url,
            'show_modal_popup' => Configuration::get(
                'NDKSTEPPINGPACK_SHOW_MODAL_POPUP'
            ),
        ]);
        if ((float) _PS_VERSION_ > 1.6) {
            $this->setTemplate(
                'module:ndksteppingpack/views/templates/front/default17.tpl'
            );
        } else {
            $this->setTemplate('default.tpl');
        }
    }

    public function getTemplateVarPage()
    {
        $id_lang = Context::getContext()->language->id;
        $id_shop = Context::getContext()->shop->id;
        $page = parent::getTemplateVarPage();

        $page['body_classes']['pack-id-' . $this->item->id] = true;
        $page['meta']['title'] =
            Configuration::get('PS_SHOP_NAME', null, null, $id_shop) .
            ' - ' .
            $this->item->name;
        $page['meta']['description'] = strip_tags(
            Tools::truncateString($this->item->description, 250)
        );

        return $page;
    }

    public function createFacetedSearchQuery()
    {
        $query = new ProductSearchQuery();
        $query->setIdCategory(22);

        return $query;
    }
}
