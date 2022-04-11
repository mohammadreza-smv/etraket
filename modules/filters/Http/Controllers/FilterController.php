<?php

namespace Modules\filters\Http\Controllers;

use App\Category;
use App\Filter;
use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\categories\Repository\CategoryRepositoryInterface;
use Modules\filters\Repository\FilterRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;

class FilterController extends Controller
{
    protected $repository=null;

    public function __construct(FilterRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function filters($cat_id,CategoryRepositoryInterface $categoryRepository)
    {
        $category=$categoryRepository->find($cat_id);
        $filters= $this->repository->all($cat_id);
        return CView('filters::index',['category'=>$category,'filters'=>$filters]);
    }

    public function add_filters($cat_id,Request $request)
    {
       $filter=$request->get('filter');
       $child_filter=$request->get('child_filter',array());
       $this->repository->addFilter($filter,$child_filter,$cat_id);
       return  [
            'redirect_url'=>url('admin/category/'.$cat_id.'/filters'),
            'message'=>'ثبت فیلتر ها با موفقیت انجام شد'
       ];
    }

    public function destroy($id)
    {
        $filter=\Modules\filters\Models\Filter::findOrFail($id);
        $filter->getChild()->delete();
        $filter->delete();
        return  [
            'redirect_url'=>url('admin/category/'.$filter->category_id.'/filters'),
            'message'=>'حذف فیلتر  با موفقیت انجام شد'
        ];
    }

    public function product_filters($id,ProductRepositoryInterface $productRepository){
        $product=$productRepository->find($id);
        $product_filters=$this->repository->product_filters($product);
        return CView('filters::product_filter',compact('product','product_filters'));
    }

    public function add_product_filters($id,Request $request,ProductRepositoryInterface $productRepository){
        $product=$productRepository->find($id);
        $this->repository->add_product_filters($product,$request);
        return  [
            'redirect_url'=>url('admin/products/'.$product->id.'/filters'),
            'message'=>'ثبت فیلتر برای محصول انجام شد'
        ];
    }
}
