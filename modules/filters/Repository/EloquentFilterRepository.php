<?php


namespace Modules\filters\Repository;


use Modules\categories\Models\Category;
use Modules\filters\Models\Filter;
use Modules\filters\Models\ProductFilter;
use DB;
class EloquentFilterRepository implements FilterRepositoryInterface
{

    public function all($cat_id)
    {
        return Filter::with('getChild')
            ->where(['category_id'=>$cat_id,'parent_id'=>0])
            ->orderBy('position','ASC')->get();
    }

    public function addFilter($filter, $child_filter, $cat_id)
    {
        Filter::addFilter($filter,$child_filter,$cat_id);
    }

    public function product_filters($product)
    {
        define('product_id',$product->id);
        $category=Category::find($product->cat_id);
        $cat_id[0]=$product->cat_id;
        if($category){
            $cat_id[1]=$category->parent_id;
        }
        $filters=Filter::with(['getChild','getValue'])
            ->where(['parent_id'=>0])
            ->whereIn('category_id',$cat_id)
            ->orderBy('position','ASC')->get();
        return $filters;
    }

    public function add_product_filters($product,$request){
        $filters=$request->get('filter');
        DB::table('filter_product')->where(['product_id'=>$product->id])->delete();
        if(is_array($filters))
        {
            foreach ($filters as $key=>$value)
            {
                if(is_array($value))
                {
                    foreach ($value as $key2=>$value2)
                    {
                        if($value2!==null){
                            ProductFilter::create([
                                'product_id'=>$product->id,
                                'filter_id'=>$key,
                                'filter_value'=>$value2
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function catFilters($relation, $where, $categories)
    {
        $filter=Filter::with($relation)->where($where)
            ->whereIn('category_id',$categories)->get();
        return $filter;
    }
}
