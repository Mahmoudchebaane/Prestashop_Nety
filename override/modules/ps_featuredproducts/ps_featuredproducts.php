<?php
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

class Ps_FeaturedProductsOverride extends Ps_FeaturedProducts

// class Ps_FeaturedProducts extends Module implements WidgetInterface
{



    protected function getProducts()
    {
 
        $category = new Category((int) Configuration::get('HOME_FEATURED_CAT'));

        $searchProvider = new CategoryProductSearchProvider(
            $this->context->getTranslator(),
            $category
        );

        $context = new ProductSearchContext($this->context);

        $query = new ProductSearchQuery();

        $nProducts = Configuration::get('HOME_FEATURED_NBR');
        if ($nProducts < 0) {
            $nProducts = 12;
        }

        $query
            ->setResultsPerPage($nProducts)
            ->setPage(1)
        ;

        if (Configuration::get('HOME_FEATURED_RANDOMIZE')) {
            $query->setSortOrder(sortOrder::random());
        } else {
            $query->setSortOrder(new SortOrder('product', 'position', 'asc'));
        }

     
        $result = $searchProvider->runQuery(
            $context,
            $query
        );

        $assembler = new ProductAssembler($this->context);
        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = $presenterFactory->getPresenter();
        $products_for_template = []; 
 
       
        foreach ($result->getProducts() as $rawProduct) {             
            // list of assoiated product  
            $product = new Product((int) $rawProduct["id_product"]);         
            // $accessories =  $product->getAccessories($this->context->language->id);    
            $accessories  =  Product::getAccessoriesStatic( $rawProduct["id_product"], null, $this->context->language->id, $this->context->shop->id, $this->context);
            // foreach ($accessories as $k => $row) {
               
            //         $accessories[$k] =  $presenter->present(
            //             $presentationSettings,
            //             $assembler->assembleProduct($row),
            //             $this->context->language
            //     );                    
            // }   
            $rawProduct['accessories'] =$accessories ; 
         
            $products_for_template[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($rawProduct),
                    $this->context->language
            ); 
                
        } 
        return $products_for_template;
    }


}