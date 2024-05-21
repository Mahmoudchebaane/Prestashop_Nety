<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
class StoresController extends StoresControllerCore
{
     
    
    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
     //   dump($this->context->link->getPageLink('stores'));die();
        Media::addJsDef([
            'testGov' =>  $this->context->link->getPageLink('stores')
        ]);

    }
     
    // /**
    //  * Assign template vars related to page content.
    //  *
    //  * @see FrontController::initContent()
    //  */
    public function initContent()
    { 
        parent::initContent();
 
      $stores = Store::getStores($this->context->language->id);
       //dump('fff', $stores ); die();
        Media::addJsDef([
            'liststores' => $stores ,  
        ]);
       
        //display Store Controller
        //  dump('sss',$stores);die();
        $this->setTemplate('cms/stores');
    }  

    public function getStoresForXml()
    {  
        // StarterTheme: Remove method when google maps v3 is done
        $distance_unit = Configuration::get('PS_DISTANCE_UNIT');
        if (!in_array($distance_unit, ['km', 'mi'])) {
            $distance_unit = 'km';   
        }
        $distance = (int) Tools::getValue('radius', 100);

        $multiplicator = ($distance_unit == 'km' ? 6371 : 3959);

        $stores = Db::getInstance()->executeS('
        SELECT s.*, cl.name country, st.iso_code state,         
        cl.id_country id_country
        FROM ' . _DB_PREFIX_ . 'store s
        ' . Shop::addSqlAssociation('store', 's') . '
        LEFT JOIN ' . _DB_PREFIX_ . 'country_lang cl ON (cl.id_country = s.id_country)
        LEFT JOIN ' . _DB_PREFIX_ . 'state st ON (st.id_state = s.id_state)
        WHERE s.active = 1 AND cl.id_lang = ' . (int) $this->context->language->id . '        
        LIMIT 0,20');     
     
        return $stores;
    }

    /**
     * Display the Xml for showing the nodes in the google map.
     */
    protected function displayAjax()
    {
        // StarterTheme: Remove method when google maps v3 is done
        $stores = $this->getStoresForXml();
        $parnode = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><markers></markers>');
        foreach ($stores as $store) {
            $other = '';
            $newnode = $parnode->addChild('marker');
            $newnode->addAttribute('name', $store['name']);
            $address = $this->processStoreAddress($store);

            //$other .= $this->renderStoreWorkingHours($store);
            $newnode->addAttribute('addressNoHtml', strip_tags(str_replace('<br />', ' ', $address)));
            $newnode->addAttribute('address', $address);
            $newnode->addAttribute('other', $other);
            $newnode->addAttribute('phone', $store['phone']);
            $newnode->addAttribute('id_store', (int) $store['id_store']);
            $newnode->addAttribute('has_store_picture', file_exists(_PS_STORE_IMG_DIR_ . (int) $store['id_store'] . '.jpg'));
            $newnode->addAttribute('lat', (float) $store['latitude']);
            $newnode->addAttribute('lng', (float) $store['longitude']);
            if (isset($store['distance'])) {
                $newnode->addAttribute('distance', (int) $store['distance']);
            }
        }

        header('Content-type: text/xml');

        $this->ajaxRender($parnode->asXML());
    }
    protected function displayAjaxGetGov(){
        $search = Tools::getValue('search');
        $gov = Tools::getValue('gov');
        $success = false;
        $Filtredlist =[];
        $stores = Store::getStores($this->context->language->id); 

        foreach ($stores as $store ){ 
            if($gov == "TOUS"){
                if (strlen($search) == 0){array_push($Filtredlist, $store);}
                    else{      
                        if(str_contains(strtoupper($store['address1']), $search ) || str_contains(strtoupper($store['name']), $search ) ||  str_contains(strtoupper($store['city']), $search) || str_contains(strtoupper($store['address2']), $search )) {
                            array_push($Filtredlist, $store);
                        }
                    } 
            }
            else{
                if(strtoupper($store['address2']) == $gov) {                         
                    if (strlen($search) == 0){array_push($Filtredlist, $store);}
                    else{      
                        if(str_contains(strtoupper($store['address1']), $search ) || str_contains(strtoupper($store['name']), $search ) ||  str_contains(strtoupper($store['city']), $search) || str_contains(strtoupper($store['address2']), $search )) {
                            array_push($Filtredlist, $store);
                        }
                    } 
                } 
            }    
        } 

        if($Filtredlist){ $success=true;}
        $this->ajaxRender(
            json_encode([
                'success'=>$success,
                'search' =>$search,
                'Filtredlist' => $Filtredlist
            ])
        );
}
}
