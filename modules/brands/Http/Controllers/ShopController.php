<?php

namespace Modules\brands\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\brands\Repository\BrandRepositoryInterface;

class ShopController extends Controller
{
    public function show_products($brand_name,BrandRepositoryInterface $repository){
        config()->set('view.search_components',true);
        $result=searchProducts();
        $brand=$repository->firstOrFail(['brand_ename'=>$brand_name]);
        return CView('brands::shop.'.$this->view.'products',compact('result','brand'));
    }

    public function get_product(){
        return searchProducts();
    }
}
