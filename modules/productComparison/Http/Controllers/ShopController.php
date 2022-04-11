<?php


namespace Modules\productComparison\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\productComparison\Repository\ProductComparisonRepositoryInterface;

class ShopController extends Controller
{
    protected $repository;

    public function __construct(Request $request,ProductComparisonRepositoryInterface $comparisonRepository)
    {
        $this->repository=$comparisonRepository;
        parent::__construct();
    }

    public function compare($productId1,$productId2=null,$productId3=null,$productId4=null)
    {
        $items=[];
        $products_id=get_compare_product_id(array($productId1,$productId2,$productId3,$productId4));
        $products=$this->repository->products($products_id);
        if(sizeof($products)>0)
        {
            $category=$this->repository->getCategory($products[0]->cat_id);
            $items=$this->repository->getItemsForCategory($category);
            return  CView('productComparison::compare',compact('items','products','category'));
        }
        else{
            return redirect('/');
        }
    }

    public function getCatBrand(Request $request){
        return $this->repository->getSearchBrand($request);
    }

    public function get_compare_products(Request $request){
        return $this->repository->getProductForComparison($request);
    }
}
