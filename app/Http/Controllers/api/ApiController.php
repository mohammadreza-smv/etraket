<?php
namespace App\Http\Controllers\api;
use App\Cart;
use App\CatBrand;
use App\Category;
use App\Color;
use App\Http\Controllers\Controller;
use App\Item;
use App\ItemValue;
use App\Product;
use App\ProductWarranty;
use App\ReView;
use App\SearchProduct;
use App\Slider;
use App\User;
use Illuminate\Http\Request;
use DB;
use Log;
use Auth;
class ApiController extends Controller
{
    public function getCategory(){
        return Category::select(['id','name'])
            ->with('getChild')
            ->where('parent_id',0)->get();
    }
    public function getChildCategory($id){
        return Category::select(['id','name','img'])->where('parent_id',$id)->get();
    }
    public function category_new_product($cat_id){
        $category=Category::where('parent_id',$cat_id)->pluck('id','id')->toArray();
        return Product::where(['status'=>1])->whereIn('cat_id',$category)
            ->whereHas('getFirstProductPrice')
            ->with('getFirstProductPrice')
            ->orderBy('id','DESC')
            ->select(['id','title','price','discount_price','image_url'])
            ->limit(10)->get();
    }
    public function category_best_selling_product($cat_id){
        $category=Category::where('parent_id',$cat_id)->pluck('id','id')->toArray();
        return Product::where(['status'=>1])->whereIn('cat_id',$category)
            ->whereHas('getFirstProductPrice')
            ->with('getFirstProductPrice')
            ->orderBy('order_number','DESC')
            ->select(['id','title','price','discount_price','image_url','order_number'])
            ->limit(10)->get();
    }
    public function product_getList(Request $request){
        $searchProduct=new SearchProduct($request);
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
    public function category_getFilter($cat_id){
        $category=Category::with('getParent.getParent')
            ->with(['getChild'=>function($query){
                $query->whereNull('search_url');
            }])
            ->where('id',$cat_id)->first();
        if($category){
            $filter=Category::getCatFilter($category);
            $brands=CatBrand::with('getBrand')->where('cat_id',$category->id)->get();
            $colors=[];
            $checkHasColor=DB::table('product_color')->where('cat_id',$category->id)->first();
            if($checkHasColor){
                $colors=Color::where('type',1)->get();
            }
            return  [
               'filter'=>$filter,
               'brands'=>$brands,
               'colors'=>$colors,
               'category'=>$category
            ];
        }
        else{
            return [];
        }
    }
    public function getProduct($id,Request $request)
    {
        $array=[];
        $priceItem=[];
        $product=Product::with(['getBrand','Gallery','getProductColor.getColor','getCat'])
            ->with(['getProductWarranty'=>function ($query){
                $query->with(['getWarranty','getSeller']);
            }])->where(['id'=>$id])->firstOrFail();
        if(sizeof($product->getProductColor)==0){
            $priceItem=Product::getPriceItem($product->cat_id);
        }
        $array=$product;
        $array['priceItem']=$priceItem;
        $array['tozihat']=getProductTozihat($product['tozihat']);

        if($request->header('Authorization')) {
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                $user_id=$user->id;
                $cart=getUserCart($id,$user_id);
                if(sizeof($cart)>0){
                    $array['cart_table']=$cart;
                }
            }
        }
        return $array;
    }
    public function review($id)
    {
        $array=array();
        $review=ReView::where('product_id',$id)->get();
        foreach ($review as $key=>$value)
        {
            $array[$key]['title']=$value['title'];
            $n=explode('<p>',$value['tozihat']);
            $tozihat=$value['tozihat'];
            $j=0;
            for($i=0;$i<sizeof($n);$i++){
                $result=getBetweenTag('<p>','</p>',$tozihat);

                $img_src=getBetweenTag('src="','"',$result);
                if($img_src){
                    $array[$key]['content'][$j]='image:'.$img_src;
                    $j++;
                }
                else if($result){
                    $text=str_replace("&zwnj;"," ",$result);
                    if($text!="&nbsp;"){
                        $array[$key]['content'][$j]=strip_tags($text);
                        $j++;
                    }
                }
                $tozihat=str_replace("<p>$result</p>","",$tozihat);
            }
        }
        return $array;
    }
    public function product_items($product_id)
    {
        $product=Product::where('id',$product_id)->first();
        $product_item_count=ItemValue::where('product_id',$product_id)->count();
        if($product && $product_item_count){
            return Item::getProductItem($product);
        }
        else{
            return  [];
        }
    }
    public function relate_products($product_id){
        $product=Product::where('id',$product_id)->first();
        if($product){
            return Product::where(['cat_id'=>$product->cat_id,'brand_id'=>$product->brand_id])
                ->whereHas('getFirstProductPrice')
                ->with('getFirstProductPrice')
                ->where('id','!=',$product->id)->limit(15)->get();
        }
        else{
            return [];
        }
    }
    public function check_has_warranty(Request $request){
        $param=$request->get('param');
        $count=$request->has('count') ? $request->get('count') : 1;
        $param=explode('_',$param);
        if(sizeof($param)==5 || sizeof($param)==6){
            $warrantyId=$param[2];
            $productWarranty=ProductWarranty::find($warrantyId);
            if($productWarranty && $productWarranty->product_number>=$count){
                if($request->header('Authorization')){
                    if(Auth::guard('api')->check()){
                        $user=Auth::guard('api')->user();
                        changeProductCountOfCartTable('add',$productWarranty->id,$user->id);
                    }
                }
                return  'ok';
            }
            else{
                return 'error';
            }
        }
        else{
            return 'error';
        }
    }
    public function getCartData(Request $request)
    {
        $string=$request->get('cartData');
        $products=getApplicationCartProducts($string);
        $shippingCartProducts=new \App\ShoppingCartProducts('application',$products,1);
        if($request->header('Authorization')){
            if(Auth::guard('api')->check()){
                $user=Auth::guard('api')->user();
                $shippingCartProducts->userId=$user->id;
            }
        }
        return $shippingCartProducts->getProducts();
    }
    public function register(Request $request){
        $mobile=$request->get('mobile');
        $password=$request->get('password');
        $user=User::where('mobile',$mobile)->first();
        if($user){
            if($user->account_status=='InActive'){
                $user->forceDelete();
                return userRegister($mobile,$password);
            }
            else{
                return ['error'=>'شماره موبایل وارد شده تکراری می باشد','status'=>'error'];
            }
        }
        else{
            return userRegister($mobile,$password);
        }
    }
    public function resend(Request $request){
        $mobile=$request->get('mobile');
        $user=User::where(['mobile'=>$mobile,'account_status'=>'InActive'])->first();
        if($user){
            $active_code=rand(99999,1000000);
            $user->active_code=$active_code;
            $user->update();
            $user->notify(new \App\Notifications\SendSms($mobile,$active_code));
            return  'ok';
        }
        else{
            return 'error';
        }
    }
    public function activeCode(Request $request){
        $mobile=$request->get('mobile');
        $code=$request->get('code');
        $user=User::where(['mobile'=>$mobile,'account_status'=>'InActive','active_code'=>$code])->first();
        if($user){
            //$user->active_code='';
            $user->account_status='active';
            $user->update();
            return  'ok';
        }
        else{
            return 'error';
        }
    }
    public function sliders(){
        $sliders=Slider::orderBy('id','desc')->select(['mobile_image_url','url'])->get();
        return $sliders;
    }
    public function incredible_offers(){
        $now=get_incredible_offers_start_time();
        $incredible_offers=ProductWarranty::with('getProduct')
            ->where('offers_first_time','<=',$now)
            ->whereHas('getProduct')
            ->where(['offers'=>1])
            ->limit(9)->get()->unique('product_id');
        return $incredible_offers;
    }
}
