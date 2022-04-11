<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class Package extends Model
{
    use SoftDeletes;
    public static function addProduct($request)
    {
        $seller_id=$request->user()->id;
        $stockroom_id=$request->get('stockroom_id',0);
        $list=$request->get('list');
        $list=explode('@',$list);
        $product_count=get_stockroom_product_count($list);
        $send_date=$request->get('date');
        $send_time=getTimestamp($send_date,'last');
        $package_id=rand(999,9999).$seller_id.rand(999,9999);

        $package=new Package();
        $package->seller_id=$seller_id;
        $package->product_count=$product_count;
        $package->send_time=$send_time;
        $package->stockroom_id=$stockroom_id;
        $package->status=0;
        $package->tozihat=$request->get('tozihat');
        $package->send_date=$send_date;
        $package->package_id=$package_id;
        DB::beginTransaction();
        try{
            $package->save();
            foreach($list as $key=>$value)
            {
                if(!empty($value)){
                    $e=explode('_',$value);
                    if(sizeof($e)==2){
                       $packageProduct=new PackageProduct();
                       $packageProduct->warranty_id=$e[0];
                       $packageProduct->product_count=$e[1];
                       $packageProduct->package_id=$package->id;
                       $packageProduct->save();
                    }
                }
            }
            DB::commit();
            return 'ok';
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return 'error';
        }
    }
    public static function getData($request)
    {
        $string='?';
        $packages=self::with('getSeller')->orderBy('id','DESC');
        if(inTrashed($request))
        {
            $packages=$packages->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('stockroom_id',$request) && !empty($request['stockroom_id']))
        {
            $packages=$packages->where('stockroom_id',$request['stockroom_id']);
            $string=create_paginate_url($string,'stockroom_id='.$request['stockroom_id']);
        }
        if(array_key_exists('seller_id',$request) && !empty($request['seller_id']))
        {
            $packages=$packages->where('seller_id',$request['seller_id']);
            $string=create_paginate_url($string,'seller_id='.$request['seller_id']);
        }
        if(array_key_exists('send_date',$request) && !empty($request['send_date']))
        {
            $send_time=getTimestamp($request['send_date'],'last');
            $packages=$packages->where('send_time',$send_time);
            $string=create_paginate_url($string,'send_date='.$request['send_date']);
        }
        
        $packages=$packages->paginate(10);
        $packages->withPath($string);
        return $packages;
    }
    public function getSeller()
    {
        return $this->hasOne(Seller::class,'id','seller_id')->select(['id','brand_name'])->withDefault(['brand_name'=>'']);
    }
    public static function getPackageProduct($id)
    {        
        $package_product=PackageProduct::where('package_id',$id);
        $package_product=$package_product->with('getProductWarranty.getProduct')
        ->whereHas('getProductWarranty',function($query){
            $query->whereHas('getProduct');
        });
        $package_product=$package_product->get();
        return $package_product;
    }
    public function getStockroom()
    {
       return $this->hasOne(Stockroom::class,'id','stockroom_id')
       ->withDefault(['name'=>'']);
    }
}
