<?php

namespace Modules\review\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use DB;
use Modules\products\Repository\ProductRepositoryInterface;
use Modules\review\Repository\ReViewRepositoryInterface;

class ReviewController extends CustomController
{
    protected $title='نقد و بررسی';

    protected $route_params='product/review';

    protected $productRepository;

    protected $query_string;

    protected $repository;

    protected $product;

    public function __construct(Request $request,ProductRepositoryInterface $productRepository,ReViewRepositoryInterface $reViewRepository)
    {
         $product_id=$request->get('product_id');
         $this->productRepository=$productRepository;
         $this->repository=$reViewRepository;
         $this->product=$productRepository->find($product_id);
         $this->query_string='product_id='.$product_id;
    }

    public function index(Request $request)
    {
        $review=$this->repository->getList($request);
        $trash_review_count=$this->repository->trashCount();
        $product=$this->product;
        return CView('review::panel.index',compact('review','trash_review_count','product'));
    }

    public function create()
    {
        return CView('review::panel.create',['product'=>$this->product]);
    }

    public function store(Request $request)
    {
        $this->validate($request,['title'=>'required','tozihat'=>'required'],[],[
            'title'=>'عنوان نقد و بررسی',
            'tozihat'=>'توضیحات'
        ]);
        $this->repository->setProductId($this->product->id);
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/product/review?product_id='.$this->product->id),
            'message'=>'ثبت نقد و بررسی با موفقیت انجام شد'
        ];
    }

    public function edit($id)
    {
        $review=$this->repository->find($id);
        return CView('review::panel.edit',[
            'product'=>$this->product,
            'review'=>$review
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,['title'=>'required','tozihat'=>'required'],[],[
            'title'=>'عنوان نقد و بررسی',
            'tozihat'=>'توضیحات'
        ]);
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/product/review?product_id='.$this->product->id),
            'message'=>'ویرایش نقد و بررسی با موفقیت انجام شد'
        ];
    }

    public function primary()
    {
        $primary_content=$this->repository->getPrimary($this->product->id);
        $tozihat=$primary_content ? $primary_content->tozihat : '';
        return CView('review::panel.primary',['product'=>$this->product,'tozihat'=>$tozihat]);
    }

    public function add_primary_content(Request $request)
    {
        $this->repository->addPrimary($this->product->id,$request);
        return  [
            'redirect_url'=>url('admin/product/review?product_id='.$this->product->id),
            'message'=>'ثبت توضیحات با موفقیت انجام شد'
        ];
    }


}
