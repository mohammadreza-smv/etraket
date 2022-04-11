<?php


namespace Modules\shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\categories\Repository\CategoryRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;
use Auth;
use Modules\shop\Mail\ShareEmail;
use Modules\shop\Models\SearchProduct;
use themes\theme1\ProductList;

class SiteController extends Controller
{
    public function index()
    {
        return CView(  $this->view.'index');
    }

    public function show_product(ProductRepositoryInterface $productRepository,CategoryRepositoryInterface $categoryRepository,$product_id,$product_url=null)
    {
        $product=$productRepository->findForPage($product_id,$product_url);

        $category=$categoryRepository->firstWithRelation(['getParent.getParent'],['id'=>$product->cat_id]);

        $page_title='مشخصات، قیمت و خرید '.$product->title.'|'.config('shop-info.shop_name');
        define('page_title',$page_title);

        return CView($this->view.'show_product',[
            'product'=>$product,
            'category'=>$category,
            'viewType'=>$this->view
        ]);
    }

    public function show_child_cat_list(CategoryRepositoryInterface $categoryRepository,$cat_url){
        $category=$categoryRepository->firstWithRelation('getChild.getChild',['url'=>$cat_url]);
        if($category){
            define('cat_id',$category->id);
            define('cat_name',$category->name);
            define('widget_param',$category->id);
        }
        return CView('child_cat',compact('category'));
    }

    public function cat_product(CategoryRepositoryInterface $categoryRepository, $cat_url,Request $request){
        $category=$categoryRepository
            ->firstWithRelation(['getParent.getParent','getChild'=>function($query){
            $query->whereNull('search_url');
        }],['url'=>$cat_url]);

        $products=new SearchProduct($request,$categoryRepository);
        $products->set_product_category($category);
        $products->brands=$request->get('brand',null);
        $result=$products->getProduct();
        config()->set('view.search_components',true);
        return CView($this->view.'cat_product', compact('category','result'));
    }

    public function get_cat_product(CategoryRepositoryInterface $categoryRepository, $cat_url,Request $request){
        $category=$categoryRepository->firstWithRelation(['getChild'=>function($query){
            $query->whereNull('search_url');
        }],['url'=>$cat_url]);
        $searchProduct=new SearchProduct($request,$categoryRepository);
        $searchProduct->set_product_category($category);
        $searchProduct->brands=$request->get('brand',null);
        return $searchProduct->getProduct();
    }

    public function share_product(Request $request,ProductRepositoryInterface $productRepository){

        $email=$request->get('email');
        $product_id=$request->get('product_id');
        $user_name=(Auth::check() && !empty(Auth::user()->name)) ? Auth::user()->name :'کاربر ناشناس';
        $product=$productRepository->firstOrFail($product_id,[
            'id', 'title','price','image_url','product_url'
        ]);
        if($product)
        {
            try{
                \Mail::to( $email)->queue(new ShareEmail($user_name, $product));
                return 'ok';
            }
            catch(\Exception $e){
                return 'error';
            }
        }
        else{
            return 'error';
        }
    }

    public function search_product(Request $request,CategoryRepositoryInterface $categoryRepository)
    {
        $products=new SearchProduct($request,$categoryRepository);
        $result=$products->getProduct();
        return CView($this->view.'cat_product', compact('result'));
    }

    public function get_search_product(Request $request){
        $searchProduct=new SearchProduct($request,null);
        return $result=$searchProduct->getProduct();
    }

    public function product_list(Request $request){
        $productList=new ProductList($request->all());
        return $productList->data();
    }

    public function set_shop_cites(Request $request): array
    {
        $backUrl=url()->previous();
        $cites=$request->get('cites');
        if($cites!=''){
            $minutes=365*24*60*60;
            \Cookie::queue('selected_shop_cites',$cites,$minutes);
            config()->set('cms.selected_cites',$cites);
        }
        return [
            'reload'=>$backUrl
        ];
    }
}
