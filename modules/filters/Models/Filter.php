<?php

namespace Modules\filters\Models;

use App\CustomModel;

class Filter extends CustomModel
{
    protected $table='filter';
    protected $guarded=[];

    public static function addFilter($filter,$child_filter,$cat_id)
    {
        $parent_position=0;
        self::where(['category_id'=>$cat_id,'parent_id'=>0])->update(['position'=>0]);
        foreach ($filter as $key=>$value)
        {
            $key=self::getItemKey($key);
            if(!empty($value))
            {
                $otherData=run_action('add_filter_data',[$key],true,true);
                $parent_position++;
                if ($key < 0) {
                    $data=['title' => $value, 'category_id' => $cat_id, 'parent_id' => 0,'position' => $parent_position]+$otherData;
                    $id = self::insertGetId($data);
                    self::add_child_filter($key,$child_filter,$id,$cat_id);
                }
                else{
                    $data=['title'=>$value,'position'=>$parent_position]+$otherData;
                    self::where('id',$key)->update($data);
                    self::add_child_filter($key,$child_filter,$key,$cat_id);
                }
            }
        }
    }
    public static function add_child_filter($key,$child_filter,$filter_id,$cat_id)
    {
        if(array_key_exists($key,$child_filter))
        {
            $child_position=0;
            self::where(['parent_id'=>$filter_id])->update(['position'=>0]);

            foreach ($child_filter[$key] as $key2=>$value2)
            {
                $key2=self::getItemKey($key2);
                if(!empty($value2))
                {
                    $child_position++;
                    if($key2<0)
                    {
                        self::insert(['title'=>$value2,'parent_id'=>$filter_id,'category_id'=>$cat_id,'position'=>$child_position]);
                    }
                    else{
                        self::where('id',$key2)->update(['title'=>$value2,'position'=>$child_position]);
                    }
                }
            }
        }
    }
    public function getChild()
    {
        return $this->hasMany(Filter::class,'parent_id','id')->orderBy('position','ASC');
    }
    public static function getProductFilter($product)
    {
        define('product_id',$product->id);
        $category=Category::find($product->cat_id);
        $cat_id[0]=$product->cat_id;
        if($category){
            $cat_id[1]=$category->parent_id;
        }
        $filters=self::with(['getChild','getValue'])->where(['parent_id'=>0])->whereIn('category_id',$cat_id)
            ->orderBy('position','ASC')->get();
        return $filters;
    }
    public function getValue()
    {
        return $this->hasMany(ProductFilter::class,'filter_id','id')
            ->where('product_id',product_id);
    }

    public static function getItemKey($key){
        $e=explode('_',$key);
        if(sizeof($e)==2){
            return $e[1];
        }
        else{
            return $key;
        }
    }
}
