<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Illuminate\Database\Eloquent\Builder;
class Stockroom extends Model
{
    use SoftDeletes;
    protected $fillable=['name','address'];
    public static function getData($request)
    {
        $string='?';
        $stockrooms=self::orderBy('id','DESC');
        if(inTrashed($request))
        {
            $stockrooms=$stockrooms->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $stockrooms=$stockrooms->where('name','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $stockrooms=$stockrooms->paginate(10);
        $stockrooms->withPath($string);
        return $stockrooms;
    }
    public static function add_product($request,$product_list=null,$stockroom_id=null)
    {
        DB::beginTransaction();
        try{
            $user_id=$request->user()->id;
            $stockroom_id=$stockroom_id ? $stockroom_id : $request->get('stockroom_id',0);
            $list=$product_list ? $product_list : $request->get('list');
            $time=time();
            $list=explode('@',$list);
            $type=$request->get('type','input');
            $product_count=get_stockroom_product_count($list);

            $StockroomEvent=new StockroomEvent($request->all());
            $StockroomEvent->user_id=$user_id;
            $StockroomEvent->time=$time;
            $StockroomEvent->type=$type;
            $StockroomEvent->product_count=$product_count;
            $StockroomEvent->stockroom_id=$stockroom_id;
            $StockroomEvent->save();
    
            foreach($list as $key=>$value)
            {
                if(!empty($value)){
                    $e=explode('_',$value);
                    if(sizeof($e)==2){
                       $StockroomProduct=new StockroomProduct();
                       $StockroomProduct->product_warranty_id=$e[0];
                       $StockroomProduct->product_count=$e[1];
                       $StockroomProduct->event_id=$StockroomEvent->id;
                       $StockroomProduct->stockroom_id=$stockroom_id;
                       $StockroomProduct->save();
                       if($request->get('package_id',0)>0)
                       {
                           $package_id=$request->get('package_id',0);
                           DB::table('package_products')->where(['package_id'=>$package_id,'warranty_id'=>$e[0]])
                           ->update(['real_count'=>$e[1]]);
                       }
                       self::setInventory($type,$e[0],$e[1],$stockroom_id);
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
    public static function setInventory($type,$product_warranty_id,$product_count,$stockroom_id)
    {
        if($type=='input')
        {
            $check=InventoryList::where(['product_warranty_id'=>$product_warranty_id,'stockroom_id'=>$stockroom_id])->first();
            if($check)
            {
                $check->product_count=$check->product_count+$product_count;
                $check->update();
            }
            else{
                $InventoryList=new InventoryList();
                $InventoryList->product_warranty_id=$product_warranty_id;
                $InventoryList->product_count=$product_count;
                $InventoryList->stockroom_id=$stockroom_id;
                $InventoryList->save();
            }
        }
        else{
            $check=InventoryList::where(['product_warranty_id'=>$product_warranty_id,'stockroom_id'=>$stockroom_id])->first();
            $check->product_count=$check->product_count-$product_count;
            $check->update();
        }
    }
    public static function getPorudtList($id,$type,$request)
    {
        $string=$request->get('string','');
        define('search_text',$string);
        $stockroomEvent=StockroomEvent::with(['getUser','getStockroom'])
        ->where(['type'=>$type])->where('id',$id)->firstOrFail();

        $stockroom_products=StockroomProduct::with(['getProductWarranty'=>function($query){
            $query->with(['getColor','getSeller','getWarranty','getProduct']);
        }])
        ->whereHas('getProductWarranty',function(Builder $query){
            if(!empty(search_text))
            {
                $query->whereHas('getProduct',function(Builder $query2){
                    $query2->where('title','like','%'.search_text.'%');
                });
            }
            else{
                $query->whereHas('getProduct');
            }
        })
        ->where('event_id',$id)->get();

        return [
            'stockroomEvent'=>$stockroomEvent,
            'stockroom_products'=>$stockroom_products
        ];
    }
  
}
