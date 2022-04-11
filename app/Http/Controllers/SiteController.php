<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;
use Mail;
class SiteController extends Controller
{
    public function brand_product($brand_name)
    {
        $brand=Brand::with('getCat.getCategory')->where('brand_ename',$brand_name)->firstOrFail();
        return view($this->view.'shop.brand_product',['brand'=>$brand]);
    }

    public function get_brand_product($brand_name,Request $request)
    {
        $brand=Brand::where('brand_ename',$brand_name)->firstOrFail();
        $searchProduct=new SearchProduct($request);
        $searchProduct->brands=$brand->id;
        $searchProduct->set_brand_category($request->get('category',array()));
        return $result=$searchProduct->getProduct();
    }

    public function compare($productId1,$productId2=null,$productId3=null,$productId4=null)
    {

        $products=Product::with(['getItemValue','Gallery'])->whereIn('id',$products_id)
            ->select(['id','title','cat_id','price','product_url'])->get();
        if(sizeof($products)>0)
        {
            $items=Item::getCategoryItem($products[0]->cat_id);
            $category=Category::where('id',$products[0]->cat_id)->firstOrFail();
            return view('shop.compare',[
                'items'=>$items,
                'products'=>$products,
                'category'=>$category
            ]);
        }
        else{
            return redirect('/');
        }
    }

    public function get_compare_products(Request $request)
    {



        return $products;
    }

    public function CartProductData()
    {
        $shippingCartProducts=new \App\ShoppingCartProducts('cart',[],1);
        return $shippingCartProducts->getProducts();
    }

    public function seller_product($seller_id)
    {
        $seller=Seller::where(['id'=>$seller_id,'account_status'=>'active'])->firstOrFail();
        $category=SellerProduct::getCat($seller_id);
        $brands = SellerProduct::brand($seller_id);
        return view($this->view . 'shop.seller',['seller'=> $seller, 'category'=> $category, 'brands'=> $brands]);
    }

    public function get_seller_product($seller_id,Request $request)
    {
        $seller = Seller::where(['id' => $seller_id, 'account_status' => 'active'])->firstOrFail();
        $products_id=SellerProduct::where(['seller_id'=>$seller_id])->pluck('product_id', 'product_id')->toArray();
        $searchProduct = new SearchProduct($request);
        $searchProduct->set_products_id($products_id);
        $searchProduct->category= $request->get('category', array());
        $searchProduct->brands = $request->get('brand', null);
        $searchProduct->seller_id = $seller_id;
        return $result = $searchProduct->getProduct();
    }

    public function sitemap(){
        $product_count=Product::where('status','>=',-1)->count();
        return response()->view('sitemap',['product_count'=>$product_count])
            ->header('Content-Type','text/xml');
    }

    public function sitemap_products($page){
        $offset=($page-1)*100;
        $products=Product::where('status','>=',-1)->offset($offset)->limit(100)
            ->get();
        return response()->view('sitemap-products',['products'=>$products])
            ->header('Content-Type','text/xml');
    }

    public function sitemap_category()
    {
        $category=Category::with('getChild.getChild.getChild')->where('parent_id',0)->get();
        return response()->view('sitemap-category',['category'=>$category])
            ->header('Content-Type','text/xml');
    }
}
