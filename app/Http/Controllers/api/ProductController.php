<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SellerProduct;
use App\Warranty;
use App\ProductColor;
use App\ProductWarranty;
use App\Item;
use App\ProductFilter;
use App\Product;
use DB;
use App\Seller;
use App\ProductGallery;
use App\Category;
use Validator;
class ProductController extends Controller
{
    public function remove_product(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $product=Product::where(['seller_id'=>$seller_id])->whereIn('status',[-2,-3])
        ->first();
        if($product)
        {
            $product->delete();
            $product_id=SellerProduct::where(['seller_id'=>$seller_id])
            ->pluck('product_id','product_id')->toArray();
            $product=Product::whereIn('id',$product_id)->orderBy('id','DESC')->paginate(10);
            return $product;
        }
        else{
            return 'error';
        }
    }
    public function edit_product(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $product=Product::with('getProductColor')->where(['seller_id'=>$seller_id,'id'=>$id])->first();
        if($product)
        {
            $reject_message=DB::table('reject_message')->where('product_id',$id)->orderBy('id','DESC')->get();
            return ['product'=>$product,'reject_message'=>$reject_message];
        }
        else{
            return 'redirect';
        }
    }
    public function update_product(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $product=Product::with('getProductColor')->where(['seller_id'=>$seller_id,'id'=>$id])->first();
        if($product)
        {

            $rules=[
                'title'=>'required',
                'cat_id'=>'required',
                'brand_id'=>'required',
            ];
            if($request->hasFile('pic'))
            {
                $rules['pic']='image';
            }
            $validator=Validator::make($request->all(),$rules,[],['pic'=>'تصویر محصول','title'=>'عنوان محصول',
            'brand_id'=>'برند','cat_id'=>'دسته محصول']);
            $data=$request->all();
            if($validator->fails()){
                $array=array();
                foreach($validator->errors()->all() as $key=>$value)
                {
                    $array[sizeof($array)]=$value;
                }
                return ['errors'=>$array];
            }
            else{
//                $product_color=$request->get('product_color');
//                $product_color=explode(',',$product_color);
                if($product->status>=-1)
                {
                    unset($data['title']);
                    unset($data['brand_id']);
                }
                else{
                    $product_url=get_url($request->get('title'));
                    $product->product_url=$product_url;
                }
                $product->status=-2;
                $image_url=upload_file($request,'pic','products');
                if (!empty($image_url))
                {
                    remove_file($product->image_url,'products');
                    remove_file($product->image_url,'thumbnails');
                    create_fit_pic('files/products/'.$image_url,$image_url);
                    $product->image_url=$image_url;
                }
                $product->update($data);
                create_fit_pic('files/products/'.$image_url,$image_url);
                DB::table('seller_products')->where(['product_id'=>$id,'seller_id'=>$seller_id])->update([
                    'cat_id'=>$product->cat_id,
                    'brand_id'=>$product->brand_id
                ]);
                //DB::table('product_color')->where('product_id',$product->id)->delete();
               // set_product_color($product,$product_color);
                set_cat_brand($product,null);
                return 'ok';
            }
        }
        else{
            return 'redirect';
        }
    }
    public function items(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $product=Product::where(['id'=>$id,'seller_id'=>$seller_id])->whereIn('status',[0,1])->select(['id','title','cat_id'])->first();
        if($product)
        {
            $data=Item::getProductItemWithFilter($product);
            $product_filters=ProductFilter::where('product_id',$product->id)
            ->pluck('filter_id','filter_value')->toArray();
            $filter_array=getFilterArray($data['filters']);
            $array=array();
            $array['product_items']=$data['items'];
            $array['filters']=$data['filters'];
            $array['product_filters']=$product_filters;
            $array['title']=$product->title;
            $array['filter_array']=$filter_array;
            return $array;
        }
        else{
            return 'redirect';
        }
    }
    public function add_items(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $product=Product::where(['id'=>$id,'seller_id'=>$seller_id])->whereIn('status',[0,1])->select(['id','title','cat_id'])->first();
        if($product)
        {
            $item_value=$request->get('item_value');
            $filter_value=$request->get('filter_value',array());
            DB::table('item_value')->where(['product_id'=>$id])->delete();
            foreach ($item_value as $key=>$value)
            {
                foreach ($value as $key2=>$value2)
                {
                    if(!empty($value2)){
                        DB::table('item_value')->insert([
                           'product_id'=>$id,
                           'item_id'=>$key,
                           'item_value'=>$value2
                        ]);
                    }
                }
                Item::addFilter($key,$filter_value,$id);
            }
            return 'ok';
        }
        else{
            return 'redirect';
        }
    }
    public function upload_image(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $product=Product::where(['id'=>$id,'seller_id'=>$seller_id])->whereIn('status',[0,1])->select(['id','title','cat_id'])->first();
        if($product)
        {
            $count=DB::table('product_gallery')->where('product_id',$id)->count();
            $image_url=upload_file($request,'file','gallery','image_'.$id.rand(1,100));
            if($image_url!=null){
                $count++;
                $id=DB::table('product_gallery')->insertGetId([
                    'product_id'=>$id,
                    'image_url'=>$image_url,
                    'position'=>$count
                ]);
                return [
                    'status'=>'ok',
                    'id'=>$id,
                    'image_url'=>$image_url
                ];
            }
            else{
                return 'error';
            }
        }
        else{
            return 'redirect';
        }
    }
    public function gallery(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $product=Product::where(['id'=>$id,'seller_id'=>$seller_id])->whereIn('status',[0,1])->select(['id','title','cat_id'])->first();
        if($product)
        {
            $product_gallery=ProductGallery::where('product_id',$id)->orderBy('position','ASC')->get();
            return [
                'title'=>$product->title,
                'product_gallery'=>$product_gallery
            ];
        }
        else{
            return 'redirect';
        }
    }
    public function remove_gallery_image(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $image=ProductGallery::findOrFail($id);
        $product=Product::where(['id'=>$image->product_id,'seller_id'=>$seller_id])
        ->whereIn('status',[0,1])->select(['id','title','cat_id'])->first();
        if($product)
        {
            $image_url=$image->image_url;
            $image->delete();

            if(file_exists('files/gallery/'.$image_url))
            {
                unlink('files/gallery/'.$image_url);
            }
            return ['status'=>'ok'];
        }
        else{
            return 'error';
        }
    }
    public function change_images_position(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $product=Product::where(['id'=>$id,'seller_id'=>$seller_id])->whereIn('status',[0,1])->select(['id','title','cat_id'])->first();
        if($product)
        {
            $n=1;
            $parameters=$request->get('parameters');
            $parameters=explode(',',$parameters);
            foreach ($parameters as $key=>$value)
            {
                if(!empty($value)){

                   DB::table('product_gallery')->where('id',$value)->update(['position'=>$n]);
                   $n++;
                }
            }
            return 'ok';
        }
        else{
            return 'error';
        }
    }
}
