<?php


namespace Modules\sellers\Repository;


use App\Lib\Jdf;
use App\Repositories\EloquentBaseRepository;
use Modules\city\Models\City;
use Modules\priceVariation\Models\PriceVariation;
use Modules\products\Models\Product;
use Modules\province\Models\Province;
use Modules\sellers\Models\Commission;
use Modules\sellers\Models\Payment;
use Modules\sellers\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Modules\sellers\Models\SellerFollowers;
use Modules\sellers\Models\SellerProduct;
use DB;
use Auth;
use Modules\sellers\Models\SellerSale;

class EloquentSellerRepository extends EloquentBaseRepository implements SellerRepositoryInterface
{
    protected $model="Modules\sellers\Models\Seller";

    public function find($id)
    {
        return Seller::findOrFail($id);
    }

    public function create($request)
    {
        // TODO: Implement create() method.
    }

    public function trashCount()
    {
       return Seller::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Seller::getData($request->all());
    }

    public function update($id, $request)
    {
        $seller =$this->find($id);
        $account_status=$seller->account_status;
        $data=$request->all();
        if (!empty($request->get('password'))) {
            $data['password']= Hash::make($request->get('password'));
        } else {
            unset($data['password']);
        }
        $seller->update($data);

        if(class_exists(PriceVariation::class)){
            if($seller->account_status=='Inactive' && $request->get('account_status')!=$account_status){
                PriceVariation::where(['seller_id'=>$id,'status'=>1])->update(['status'=>2]);
                PriceVariation::where(['seller_id'=>$id])->delete();
            }
            elseif ($seller->account_status=='active' && $request->get('account_status')!=$account_status){
                PriceVariation::where(['seller_id'=>$id,'status'=>2])
                    ->withTrashed()->update(['status'=>1,'deleted_at'=>null]);
            }
        }
    }

    public function firstOrFail($id)
    {
        $relation=CompleteData('seller_global_data',[]);
        return Seller::with($relation)
            ->withCount('product')->where('id',$id)->firstOrFail();
    }

    public function products($seller_id)
    {
       return SellerProduct::with('product')
           ->whereHas('product')
           ->where('seller_id', $seller_id)
           ->paginate(10);
    }

    public function documents($seller_id)
    {
        $documents=DB::table('seller_document')->where('seller_id',$seller_id)->first();
        return $documents;
    }

    public function export()
    {
        $count=Seller::whereRaw('total_price>=total_commission+paid_commission+100000')
            ->whereNotNull('shaba')->count();
        $sum=0;
        if($count>0){
            $sum = Seller::whereRaw('total_price>=total_commission+paid_commission+100000')
                ->whereNotNull('shaba')
                ->sum(DB::raw('total_price - total_commission - paid_commission'));
        }
        return ['count'=>$count,'sum'=>$sum];
    }

    public function get_all_payment()
    {
        return  Seller::whereRaw('total_price>=total_commission+paid_commission+100000')
            ->whereNotNull('shaba')->get();
    }

    public function add_payment($data)
    {
        $time = time();
        $payment = new Payment([
            'time' => $time,
            'seller_id' => $data['instrid'],
            'price' => $data['amt'],
        ]);
        if($data->has('shenase')){
            $payment->shenase=$data['shenase'];
        }
        $payment->save();
        $price = $data['amt']/10;
        DB::table('sellers')->where('id', $data['instrid'])->increment('paid_commission',$price);
    }

    public function payments($request)
    {
        return Payment::getData($request->all());
    }

    public function sellers()
    {
       return ['' => 'انتخاب فروشنده'] + Seller::pluck('brand_name', 'id')->toArray();
    }

    public function addProduct($id,$model)
    {
        DB::table('products')->where('id',$model->id)
            ->update([
                'seller_id'=>$id,
                'status'=>'-2'
            ]);

        DB::table('seller_products')->insert([
            'seller_id'=>$id,
            'product_id'=>$model->id,
            'cat_id'=>$model->cat_id,
            'brand_id'=>$model->brand_id,
            'created_at'=>time()
        ]);
    }

    public function panel_product_list($request){
        $seller_id=Auth::guard('seller')->user()->id;
        $products_id=SellerProduct::where(['seller_id'=>$seller_id])
            ->pluck('product_id','product_id')->toArray();
        $search_text=$request->get('search_text');
        $product=Product::whereIn('id',$products_id);
        if(!empty($search_text))
        {
            $product=$product->where('title','like','%'.$search_text.'%');
        }
        $product=$product->orderBy('id','DESC')->paginate(10);
        return $product;
    }

    public function total_product($request)
    {
        $seller_id=Auth::guard('seller')->user()->id;
        $search_text=$request->get('search_text');
        $product=Product::where('status','>',-1)->where('seller_id','=!',$seller_id);
        if(!empty($search_text))
        {
            $product=$product->where('title','like','%'.$search_text.'%');
        }
        $product=$product->orderBy('id','DESC')->paginate(10);
        return $product;
    }

    public function remove_product(){
        $seller_id=get_seller_id();
        $product=Product::where(['seller_id'=>$seller_id])
            ->where('status','<',0)->first();
        if($product){
            $product->delete();
            return  [
                'redirect_url'=>url('sellers/panel/products'),
                'message'=>'حذف با موفقیت انجام شد'
            ];
        }
        else{
            return  [
                'redirect_url'=>url('sellers/panel/products'),
                'message'=>'خطا در اجرای درخواست',
                'status'=>'error'
            ];
        }
    }

    public function findProductForEdit($id){
        $seller_id=get_seller_id();
        $product=Product::where(['seller_id'=>$seller_id,'id'=>$id])
          ->first();
        if($product){
            return $product;
        }
        else{
            return  false;
        }
    }

    public function add_seller_sale($variation)
    {
        new SellerSale($variation);
    }

    public function get_seller_sale_statistics($seller_id,$year,$now_year)
    {
        $sale=[0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
        $commission=[0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
        $data=DB::table('seller_sale_statistics')->where(['seller_id'=>$seller_id,'year'=>$year])->get();
        foreach($data as $value)
        {
            if(array_key_exists($value->month,$sale))
            {
                $sale[$value->month]=$sale[$value->month]+$value->price;
            }
            if(array_key_exists($value->month,$commission))
            {
                $commission[$value->month]=$commission[$value->month]+$value->commission;
            }
        }
        $first=DB::table('seller_sale_statistics')->first();
        $year_list=array();
        if($first && $first->year!=$now_year)
        {
            $j=0;
            $a=$first->year;
            settype($a,'integer');
            for($i=$a;$i<=$now_year;$i++)
            {
                $year_list[$j]=$i;
                $j++;
            }
        }
        else{
            $year_list[0]=$now_year;
        }

        $response=array('sale'=>$sale);
        $response['commission']=$commission;
        $response['default_year']=intval($year);
        $response['year_list']=$year_list;
        return $response;
    }

    public function getProductsId($seller_id)
    {
        return SellerProduct::where('seller_id',$seller_id)
            ->pluck('product_id','product_id')->toArray();
    }

    public function brandsUsed($seller_id)
    {
        return SellerProduct::where('seller_id', $seller_id)->with('getBrand')
            ->distinct()->get(['brand_id']);
    }

    public function categoriesUsed($seller_id)
    {
        return SellerProduct::where('seller_id', $seller_id)->with('category')
            ->distinct()->get(['cat_id']);
    }

    public function checkUserFollow($seller_id)
    {
        $follow="0";
        if(Auth::check()){
            $user_id=Auth::user()->id;
            $follow=DB::table('seller_followers')->where(
                [
                    'user_id'=>$user_id,
                    'seller_id'=>$seller_id
                ],
            )->count();
        }
        return $follow;
    }

    public function follow($request)
    {
        $user=$request->user();
        $seller_id=$request->get('seller_id');
        $follow=DB::table('seller_followers')->where([
            'user_id'=>$user->id,
            'seller_id'=>$seller_id
        ])->first();
        if($follow){
            DB::table('seller_followers')->where([
                'user_id'=>$user->id,
                'seller_id'=>$seller_id
            ])->delete();
            return false;
        }
        else{
            $time=time();
            DB::table('seller_followers')->insert([
                'user_id'=>$user->id,
                'seller_id'=>$seller_id,
                'time'=>$time
            ]);
            return true;
        }
    }

    public function followers_count($seller_id)
    {
        return DB::table('seller_followers')->where([
            'seller_id'=>$seller_id
        ])->count();
    }

    public function lastProducts($seller_id){
        $seller_products=$this->getProductsId($seller_id);
        return Product::where('status',1)
            ->whereHas('FirstPriceVariation')->select(
                ['id','cat_id','product_url','price','image_url','title','discount_price']
            )
            ->whereIn('id',$seller_products)
            ->orderBy('id','DESC')->limit(15)->get();
    }

    public function getLastFollowedProduct($user_id)
    {
        $sellers=SellerFollowers::where('user_id',$user_id)->get();
        $productData=[];
        $productsId=[];
        foreach ($sellers as $value){
            $productData=$productData+SellerProduct::where('seller_id',$value->seller_id)
                    ->where('created_at','>=',$value->time)->get()->toArray();
        }

        foreach ($productData as $value){
            $productsId[$value['product_id']]=$value['product_id'];
        }

        return Product::whereIn('id',$productsId)
            ->whereHas('FirstPriceVariation')->select(
                ['id','cat_id','product_url','price','image_url','title','discount_price']
            )->orderBy('id','DESC')->take(20)->get();
    }
}
