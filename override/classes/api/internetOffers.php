<?php
class InternetOffers extends ObjectModel
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->show_toolbar = false;
        $this->table = 'InternetOffers';
        $this->lang = false;
        $this->context = Context::getContext();
    }

    public function getWebserviceObjectList($sql_join, $sql_filter, $sql_sort, $sql_limit)
    {
        $category = new Category(4, (int) (Context::getContext()->language->id));
        // $category->id ==  4  && count($category->getSubCategories($id_lang)) > 0
        $products = $category->getProducts(1, 1, 8);
        $offres = [];
        foreach ($products as $offre) {          
            $value = [
                "name" => $offre['name'],
                "reference" => $offre['reference'],
                "price" => $offre['price'],
            ];
            array_push($offres, $value);            
        }   
        echo json_encode([
            'data'=>$offres,
            'success'=>true]);    
    }
}