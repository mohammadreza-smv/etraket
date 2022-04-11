<?php

namespace Modules\items\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use Modules\categories\Repository\CategoryRepositoryInterface;
use Modules\items\Repository\ItemRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;

class ItemController extends Controller
{
    protected $repository=null;

    public function __construct(ItemRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function items($id,CategoryRepositoryInterface $categoryRepository)
    {
        $category=$categoryRepository->find($id);
        $items=$this->repository->item($id);
        return CView('items::index',['category'=>$category,'items'=>$items]);
    }

    public function add_items($cat_id,Request $request)
    {
        $this->repository->addItem($cat_id,$request);
        return  [
            'redirect_url'=>url('admin/category/'.$cat_id.'/items'),
            'message'=>'ثبت مشخصات فنی با موفقیت انجام شد'
        ];
    }

    public function destroy($id)
    {
        $item=$this->repository->find($id);
        $this->repository->destroy($item);
        return  [
            'redirect_url'=>url('admin/category/'.$item['category_id'].'/items'),
            'message'=>'حذف مشخصات فنی با موفقیت انجام شد'
        ];
    }

    public function product_items($id,ProductRepositoryInterface $productRepository){
        $product=$productRepository->find($id);
        $product_items=$this->repository->product_items($product);
        return CView('items::panel.items',compact('product','product_items'));
    }

    public function add_product_items($id,Request $request,ProductRepositoryInterface $productRepository){
        $product=$productRepository->find($id);
        $this->repository->add_product_items($product,$request);
        return  [
            'redirect_url'=>url('admin/products/'.$product->id.'/items'),
            'message'=>'ثبت مشخصات فنی برای محصول انجام شد'
        ];
    }
}
