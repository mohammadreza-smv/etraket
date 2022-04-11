<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stockroom;
use App\ProductWarranty;
use App\Package;
use App\PackageProduct;
use Illuminate\Database\Eloquent\Builder;
use App\InventoryList;
class PackageController extends Controller
{
    public function stockroomList()
    {
        $stockroom=Stockroom::get();
        return $stockroom;
    }
    public function getProductWarrnty(Request $request)
    {
        $seller_id=$request->user()->id;
        $search_text=$request->get('search_text','');
        $product_warranty=ProductWarranty::with(['getProduct','getWarranty','getSeller','getColor'])->where('seller_id',$seller_id);
        if(!empty($search_text))
        {
            define('title',$search_text);
            $product_warranty=$product_warranty->whereHas('getProduct',function(Builder $query){
                $query->where('title','like','%'.title.'%');
            });
        }
        else{
            $product_warranty=$product_warranty->whereHas('getProduct');
        }
        $product_warranty=$product_warranty->paginate(5);

        return $product_warranty;
    }
    public function add_product(Request $request)
    {
        return Package::addProduct($request);
    }
    public function getPackages(Request $request)
    {
        $seller_id=$request->user()->id;
        $package_id=$request->get('package_id');
        $date=$request->get('date');
        $package_id=replace_number2($package_id);
        $packages=Package::where('seller_id',$seller_id)->orderBy('id','DESC');
        if(!empty($package_id))
        {
            $packages=$packages->where('package_id',$package_id);
        }
        if(!empty($date))
        {
            $packages=$packages->where('send_date',$date);
        }
        $packages=$packages->paginate(10);
        return $packages;
    }
    public function getPackageContent($id,Request $request)
    {
        $seller_id=$request->user()->id;
        $package=Package::where(['id'=>$id,'seller_id'=>$seller_id])->first();
        if($package)
        {
            $title=$request->get('title');
            define('title',$title);
            
            $package_product=PackageProduct::where('package_id',$id);
            $package_product=$package_product->with('getProductWarranty.getProduct')
            ->whereHas('getProductWarranty',function($query){
                if(!empty(title)){
                    $query->whereHas('getProduct',function(Builder $query2){
                        $query2->where('title','like','%'.title.'%');
                    });
                }
                else{
                    $query->whereHas('getProduct');
                }
            });
            $package_product=$package_product->paginate(10);
            return  $package_product;
        }
        else{
            return 'error';
        }
    }
    public function getStockroomProductList(Request $request)
    {
        $seller_id=$request->user()->id;  
        $stockroom_id=$request->get('stockroom_id','all');
        return InventoryList::getList($stockroom_id,$request,10,$seller_id);
    }
    public function factor($id,Request $request) 
    {
        $seller_id=$request->user()->id;
        $package=Package::where(['id'=>$id,'seller_id'=>$seller_id])->with(['getSeller','getStockroom'])->first();
        if($package)
        {            
            $package_product=PackageProduct::where('package_id',$id);
            $package_product=$package_product->with('getProductWarranty.getProduct')
            ->whereHas('getProductWarranty',function($query){
                $query->whereHas('getProduct');
            });
            $package_product=$package_product->get();
            return  [
                'package_product'=>$package_product,
                'package'=>$package
            ];
        }
        else{
            return 'error';
        }
    }
}
