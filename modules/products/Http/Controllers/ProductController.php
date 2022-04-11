<?php

namespace Modules\products\Http\Controllers;

use App\Filter;
use App\Http\Controllers\Admin\CustomController;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use DB;
use App\RejectMessage;
use Modules\products\Repository\ProductRepositoryInterface;

class ProductController extends CustomController
{
    protected $title='محصول';

    protected $route_params='products';

    protected $repository=null;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $product=$this->repository->getList($request);
        $trash_product_count=$this->repository->trashCount();
        return CView('products::index',['product'=>$product,'trash_product_count'=>$trash_product_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('products::create');
    }
    public function store(ProductRequest $request)
    {
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/products'),
            'message'=>'ثبت محصول با موفقیت انجام شد'
        ];
    }
//    public function show($id)
//    {
//        $product=Product::findOrFail($id);
//        $totalSale=DB::table('product_sale_statistics')->where('product_id',$id)->sum('price');
//        $commission=DB::table('product_sale_statistics')->where('product_id',$id)->sum('commision');
//        return view('product.show',[
//            'totalSale'=>$totalSale,
//            'commission'=>$commission,
//            'product'=>$product
//            ]);
//    }
    public function edit($id)
    {
        $product=$this->repository->find($id);
        return CView('products::edit',compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/products'),
            'message'=>'ویرایش محصول با موفقیت انجام شد'
        ];
    }

//    public function get_sale_report(Request $request)
//    {
//        $product_id=$request->get('product_id');
//        $jdf=new \App\Lib\Jdf();
//        $y=$jdf->tr_num($jdf->jdate('Y'));
//        $y=!empty($request->get('default_year')) ?  $request->get('default_year') : $y;
//        $now=$jdf->tr_num($jdf->jdate('Y'));
//        return get_sale_report($request,$y,'product_sale_statistics',
//        ['year'=>$y,'product_id'=>$product_id],'price',$now);
//    }
}
