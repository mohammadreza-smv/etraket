<?php


namespace Modules\api\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\address\Repository\AddressRepositoryInterface;
use Modules\api\Repository\ApiRepositoryInterface;
use Modules\cart\Models\CartTable;
use Modules\cart\Models\ShoppingCart;
use Modules\catBrands\Repository\CatBrandRepositoryInterface;
use Modules\categories\Models\Category;
use Modules\categories\Repository\CategoryRepositoryInterface;
use Modules\colors\Repository\ColorRepositoryInterface;
use Modules\favourite\Repository\FavoriteRepositoryInterface;
use Modules\filters\Repository\FilterRepositoryInterface;
use Modules\orders\Models\OrdersSubmission;
use Modules\orders\Repository\OrdersRepositoryInterface;
use Modules\products\Models\Product;
use Modules\products\Repository\ProductRepositoryInterface;
use Modules\priceVariation\Repository\PriceVariationRepositoryInterface;
use Modules\shop\Models\SearchProduct;
use Modules\users\Repository\AdditionalInfoRepositoryInterface;
use Modules\users\Repository\UsersRepositoryInterface;

class AppController extends Controller
{
    protected $repository;

    public function __construct(ApiRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function product_list(Request $request){
        return $this->repository->product_list($request);
    }

    public function product(Request $request,$id,ProductRepositoryInterface $repository){
        $array=[];
        $product=$repository->firstOrFail(
            $id,['id','title','cat_id','image_url','tozihat','score_count','score','status','brand_id'],
            [
                'getBrand',
                'gallery',
                'PriceVariation'
            ]
        );

        $array=$product;
        $array['tozihat']=getProductTozihat($product['tozihat']);

        if(interface_exists(FavoriteRepositoryInterface::class) && $request->header('Authorization') && \Auth::guard('api')->check() ){

            $repository=app(FavoriteRepositoryInterface::class);
            $user_id=\Auth::guard('api')->user()->id;
            $favorite=$repository->checkSelected($user_id,$product->id);
            $array['favorite']=$favorite;
        }

        return $array;
    }

    public function check_has_price_variation(Request $request,PriceVariationRepositoryInterface $repository){
        $res='error';
        $param=$request->get('param');
        $count=$request->has('count') ? $request->get('count') : 1;
        $param=explode('_',$param);
        if(sizeof($param)==5 || sizeof($param)==6){
            $variationId=$param[2];
            $priceVariation=$repository->first(['id'=>intval($variationId)],[]);
            if($priceVariation && $priceVariation->product_number>=$count){

                if($request->header('Authorization') && \Auth::guard('api')->check()){
                    $cart=new CartTable();
                    $cart->add($priceVariation);
                }
                $res='ok';
            }
        }
        return  $res;
    }

    public function panel_data(Request $request,AdditionalInfoRepositoryInterface $additionalInfoRepository){

        $user_id=$request->user()->id;
        $name=$request->user()->name;
        $mobile=$request->user()->mobile;

        $delivered_count=OrdersSubmission::where(['user_id'=>$user_id,'send_status'=>6])
            ->distinct()->count('order_id');

        $progress_count=OrdersSubmission::where(['user_id'=>$user_id])
            ->whereIn('send_status',[1,2,3,4,5])->distinct()->count('order_id');
        $wait_for_payment_count=OrdersSubmission::where(['user_id'=>$user_id,'send_status'=>0])->distinct()->count('order_id');

        $canceled_count=OrdersSubmission::where(['user_id'=>$user_id,'send_status'=>-1])->distinct()->count('order_id');

        $userInfo=$additionalInfoRepository->find(['user_id'=>$user_id]);
        if($userInfo){
            $userInfo->mobile_phone=$mobile;
        }
        return [
            'name'=>$name,
            'mobile'=>$mobile ,
            'delivered_count'=>$delivered_count,
            'progress_count'=>$progress_count,
            'wait_for_payment_count'=>$wait_for_payment_count,
            'canceled_count'=>$canceled_count,
            'userInfo'=>$userInfo
        ];

    }


    public function check_order_register_condition(Request $request,
                                                   UsersRepositoryInterface $usersRepository,AddressRepositoryInterface $addressRepository){
        $user_id=$request->user()->id;
        $info_row=$usersRepository->get_user_register_detail($user_id);
        if(!$info_row){
            return 'add_user_info';
        }
        else{
            $address=$addressRepository->first(['user_id'=>$user_id]);
            if(!$address){
                return 'add_address';
            }
            else{
                return  $address->id;
            }
        }
    }

    public function add_register_detail(Request $request,UsersRepositoryInterface $usersRepository){

        $user=$request->user();
        $usersRepository->add_register_detail($user,$request->all());
        return 'ok';
    }

    public function getCartData($addressId,Request $request,AddressRepositoryInterface $addressRepository){

        $shoppingCart=new ShoppingCart(1);
        $shoppingCart->city_id=$addressId;
        $cart_data=$shoppingCart->getData();
        $address=$addressRepository->first(['id'=>$addressId]);
        $cart_data['address']=$address->address;
        $cart_data['username']=$address->name;
        return $cart_data;
    }

    public function categories(Request $request){
        return $this->repository->categories();
    }

    public function child_categories($catId){
        return $this->repository->child_categories($catId);
    }

    public function category_new_product($catId){
        return $this->repository->catProduct($catId,'id');
    }

    public function category_best_selling_product($catId){
        return $this->repository->catProduct($catId,'order_number');
    }

    public function relate_products($product_id){

        $product=Product::where('id',$product_id)->first();
        if($product){

            return Product::where(['cat_id'=>$product->cat_id,'brand_id'=>$product->brand_id])
                ->whereHas('PriceVariation')
                ->where('id','!=',$product->id)->limit(15)->get();
        }
        else{
            return [];
        }
    }

    public function check_discount_code(Request $request){
        $code=$request->get('code');
        $discountCode=new \Modules\discount\Models\DiscountCode($code);
        $result=$discountCode->check();
        return $result;
    }

    public function add_order(Request $request,OrdersRepositoryInterface $repository){

        run_action('before_api_add_order',[]);

        $user_id=$request->user()->id;

        $shoppingCart=new ShoppingCart(1);
        $shoppingCart=CompleteData('set_order_payment_data',$shoppingCart);
        $send_order_data=$shoppingCart->getData();

        $res=$repository->add_order($user_id,$send_order_data);

        if(is_array($res) && array_key_exists('status',$res) && $res['status']=='ok'){
             $url=url('app/payment/'.$res['order_id']);
             return ['status'=>'ok','redirect_url'=>$url];
        }
        else{
            return ['status'=>'error'];
        }
    }

    public function payment($order_id,OrdersRepositoryInterface $repository){

        $order=$repository->first([
            'id'=>$order_id,
            'pay_status'=>'awaiting_payment'
        ],['id','pay_status','price']);

        if($order->price>0){

            $args=[
                'status'=>'ok',
                'order_id'=>$order->id,
                'price'=>$order->price,
                'callBackUrl'=>url('app/order/verify')
            ];

            $gateway=str_replace('-','_',Config()->get('gateway.gateway'));
            $data=run_action($gateway.'_gateway_request',[$args],true,true);

            if(array_key_exists('view',$data) && $data['status']=='ok'){
                return CView(
                    $data['view'],
                    $data['params']
                );
            }
            else if(array_key_exists('header',$data) && $data['status']=='ok'){
                return redirect()->to($data['header']);
            }
            else{
                echo 'خطا در اتصال به درگاه مجددا تلاش نمایید';
            }
        }
    }

    public function getProductList(Request $request,CategoryRepositoryInterface $categoryRepository){

        $searchProduct=new SearchProduct($request,$categoryRepository);
        $cat_id=$request->get('cat_id',null);
        $filterString=$request->get('filterString',"");

        $searchProduct->brands=get_brand_from_string($filterString);
        $searchProduct->colors=get_color_from_string($filterString);
        $searchProduct->attribute=get_attribute_from_string($filterString);

        if($cat_id){
            $category=Category::with('getChild.getChild')
                ->where('id',$cat_id)->whereNull('search_url')->firstOrFail();
            $searchProduct->set_product_category($category);
        }

        $searchProduct->min_price=$request->get('min_price',0);
        $searchProduct->max_price=$request->get('max_price',0);

        return $result=$searchProduct->getProduct();

    }

    public function getFilters($cat_id,Request $request){

        $result=[];
        $category=Category::with('getParent.getParent')
            ->with(['getChild'=>function($query){
                $query->whereNull('search_url');
            }])
            ->where('id',$cat_id)->first();
        if($category){

            $result['category']=$category;

            if(interface_exists(FilterRepositoryInterface::class)){
                $filterRepository=app(FilterRepositoryInterface::class);
                $parent_id=$category->getParent->id;
                $categories=[$category->id,$parent_id];
                $filter=$filterRepository->catFilters('getChild',['parent_id'=>0],$categories);
                $result['filter']=$filter;
            }

            if(interface_exists(CatBrandRepositoryInterface::class)){
                $brandRepository=app(CatBrandRepositoryInterface::class);
                $brands=$brandRepository->getWithRelation('getBrand',['cat_id'=>$category->id]);
                $result['brands']=$brands;
            }

            if(interface_exists(ColorRepositoryInterface::class)){
                $colorRepository=app(ColorRepositoryInterface::class);
                $checkHasColor=$colorRepository->getColorCategory($category->id);
                if($checkHasColor){
                    $result['colors']=$colorRepository->all();
                }
            }
        }

        return $result;
    }

    public function incredible_offers(){
        return $this->repository->incredible_offers();
    }

    public function search_product(Request $request){

        $title=$request->get('title','');
        $title=trim($title);

        return Product::where('title','like','%'.$title.'%')
            ->select(['id','title'])->limit(10)->get();
    }

    public function changePassword(Request $request){

        $password=$request->get('password');
        $new_password=$request->get('new_password');

        $user=$request->user();

        $validCredentials = \Hash::check($password, $user->password);
        if($validCredentials){
            $user->password=\Hash::make($new_password);
            $user->update();
            return  'ok';
        }
        else{
            return 'error';
        }
    }
}
