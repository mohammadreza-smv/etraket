<?php


namespace Modules\sellers\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\priceVariation\Http\Requests\PriceVariationRequest;
use Modules\priceVariation\Repository\PriceVariationRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;
use Modules\sellers\Models\SellerProduct;
use Auth;
class PriceVariationController extends CustomController
{
    protected $title='تنوع قیمت';

    protected $route_params='product/price_variation';

    protected $product;

    protected $query_string;

    protected $repository;

    protected $baseParam='sellers/panel';

    public function __construct(Request $request)
    {
        if(file_exists(base_path('modules/products/Repository/ProductRepositoryInterface.php')) &&
            file_exists(base_path('modules/priceVariation/Repository/PriceVariationRepositoryInterface.php')) ){

            $productRepository=app(ProductRepositoryInterface::class);
            $repository=app(PriceVariationRepositoryInterface::class);

            $product_id=$request->get('product_id');
            $this->product=$productRepository->find($product_id);
            config()->set('app.product',$this->product);
            $this->query_string='product_id='.$product_id;
            $this->repository=$repository;

            config()->set('view.build_component','add');
        }
        else{
            $response=json_encode(['content'=>'<p>افزونه مورد نیاز غیر فعال می باشد</p>']);
            exit($response);
        }

    }

    public function index(Request $request){

        $price_variation=$this->repository->getList($request);
        $trash_price_variation_count=$this->repository->trashCountWithWhere([
            'product_id'=>$this->product->id,
            'seller_id'=>get_seller_id()
        ]);

        return CView('sellers::panel.priceVariation.index',
            [
                'price_variation'=>$price_variation,
                'product'=>$this->product,
                'trash_price_variation_count'=>$trash_price_variation_count
            ]);
    }

    public function create(){
        $variationItem=$this->repository->VariationItem($this->product->cat_id);
        return  CView('sellers::panel.priceVariation.create',[
            'product'=>$this->product,
            'variationItem'=>$variationItem
        ]);
    }

    public function store(PriceVariationRequest $request){
        if(!$this->repository->checkInsert($request)){
            $seller_id=Auth::guard('seller')->user()->id;

            $this->repository->create($request);

            $data=[
                'product_id'=>$this->product->id,
                'seller_id'=>$seller_id,
                'cat_id'=>$this->product->cat_id,
                'brand_id'=>$this->product->brand_id
            ];
            $seller_product=SellerProduct::where($data)->first();
            if(!$seller_product){
                $data['created_at']=time();
                SellerProduct::create($data);
            }

            return [
                'redirect_url'=>url('sellers/panel/product/price_variation?product_id='.$this->product->id),
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
        $seller_id=get_seller_id();
        $price_variation=$this->repository->find(['id'=>$id,'seller_id'=>$seller_id]);
        $variationItem=$this->repository->VariationItem($this->product->cat_id);
        return CView('sellers::panel.priceVariation.edit',[
            'variationItem'=>$variationItem,
            'product'=>$this->product,
            'price_variation'=>$price_variation
        ]);

    }

    public function update($id,PriceVariationRequest $request){
        if(!$this->repository->checkInsert($request,$id)){

            $this->repository->update($id,$request);
            return [
                'redirect_url'=>url('sellers/panel/product/price_variation?product_id='.$this->product->id),
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
