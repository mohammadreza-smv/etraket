<?php


namespace Modules\priceVariation\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\priceVariation\Http\Requests\PriceVariationRequest;
use Modules\priceVariation\Repository\PriceVariationRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;

class PriceVariationController extends CustomController
{
    protected $title='تنوع قیمت';

    protected $route_params='product/price_variation';

    protected $product;

    protected $query_string;

    protected $repository;

    public function __construct(Request $request,ProductRepositoryInterface $productRepository,PriceVariationRepositoryInterface $repository)
    {
        $product_id=$request->get('product_id');
        $this->product=$productRepository->find($product_id);
        config()->set('app.product',$this->product);
        $this->query_string='product_id='.$product_id;
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $price_variation=$this->repository->getList($request);
        $trash_price_variation_count=$this->repository->trashCount();

        return CView('priceVariation::panel.index',
            [
                'price_variation'=>$price_variation,
                'trash_price_variation_count'=>$trash_price_variation_count,
                'product'=>$this->product
            ]
        );
    }

    public function create()
    {
        $variationItem=$this->repository->VariationItem($this->product->cat_id);
        return CView('priceVariation::panel.create',[
            'product'=>$this->product,
            'variationItem'=>$variationItem
        ]);
    }

    public function store(PriceVariationRequest $request)
    {
        if(!$this->repository->checkInsert($request)){
            $this->repository->create($request);
            return [
                'redirect_url'=>url('admin/product/price_variation?product_id='.$this->product->id),
                'message'=>'ثبت تنوع قیمت با موفقیت انجام شد'
            ];
        }
        else{
            return  [
                'status'=>'error',
                'message'=>'تنوع قیمت با مشخصات انتخابی قبلا ثبت شده'
            ];
        }
   }

    public function edit($id)
    {
        $price_variation=$this->repository->find($id);
        $variationItem=$this->repository->VariationItem($this->product->cat_id);
        return CView('priceVariation::panel.edit',[
            'variationItem'=>$variationItem,
            'product'=>$this->product,
            'price_variation'=>$price_variation
        ]);
    }

    public function update($id,PriceVariationRequest $request){
        if(!$this->repository->checkInsert($request,$id)){
            $this->repository->update($id,$request);
            return [
                'redirect_url'=>url('admin/product/price_variation?product_id='.$this->product->id),
                'message'=>'ویرایش تنوع قیمت با موفقیت انجام شد'
            ];
        }
        else{
            return  [
                'status'=>'error',
                'message'=>'تنوع قیمت با مشخصات انتخابی قبلا ثبت شده'
            ];
        }
    }
}
