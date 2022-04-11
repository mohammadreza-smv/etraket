<?php


namespace Modules\filters;

use App\BaseModule;
use Modules\filters\Models\Filter;
use Modules\filters\Models\ProductFilter;
use Modules\filters\Repository\FilterRepositoryInterface;

class Module extends BaseModule
{
    public function  category_index_right_click(){
        return [
            'filters'=>[
                'label'=>'ثبت لیست فیلتر ها',
                'url'=>'category/:id/filters',
                'icon'=>'mdi-filter'
            ]
        ];
    }

    public function  products_index_right_click(){
        return [
            'filters'=>[
                'label'=>'ثبت فیلتر ها',
                'url'=>'products/:id/filters',
                'icon'=>'mdi-filter'
            ]
        ];
    }

    public function before_show_view($data){
        if(getRouteName()==='product_items'){
            if(array_key_exists('product_items',$data) && sizeof($data['product_items'])>0){
                $category_id=$data['product_items'][0]->category_id;

                $filters=Filter::where(['parent_id'=>0,'category_id'=>$category_id])
                    ->whereNotNull('item_id')
                    ->with('getChild')->get();

                $product_filters=ProductFilter::where('product_id',$data['product']->id)
                    ->pluck('filter_id','filter_value')->toArray();

                $filter_array=getFilterArray($filters);

                $data['filters']=$filters;
                $data['product_filters']=$product_filters;
                $data['filter_array']=$filter_array;
            }
        }
        return $data;
    }

    public function add_value_input_tag(){
        return 'filters::item_filters';
    }

    public function after_created_product_items($product,$request){
        $item_value=$request->get('item_value');
        $filter_value=$request->get('filter_value',array());
        $product_id=$product->id;
        foreach ($item_value as $key=>$value){
            if(array_key_exists($key,$filter_value))
            {
                foreach ($filter_value[$key] as $k=>$v)
                {
                    $filter_id=$k;
                    ProductFilter::where(['product_id'=>$product_id,'filter_id'=>$filter_id])->delete();
                    $e=explode('@',$v);
                    foreach ($e as $k2=>$v2)
                    {
                        if(!empty($v2))
                        {
                            ProductFilter::create([
                                    'product_id'=>$product_id,
                                    'filter_id'=>$filter_id,
                                    'filter_value'=>$v2
                                ]);
                        }
                    }
                }
            }
        }
    }

    public function set_user_child_access($access){
        if(array_key_exists('category',$access)){
            $access['category']['access']['filters']=['label'=>'مدیریت فیلتر ها','routes'=>[
                'filter_list','add_filters','filters.destroy'
            ]];
        }

        if(array_key_exists('products',$access)){
            $access['products']['access']['filters']=['label'=>'ثبت فیلتر محصول','routes'=>[
                'product.filters','product.add_filters'
            ]];
        }
        return $access;
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName=='filter_list' || $routeName=='product_items' || $routeName=='product_filters'){
            return vue_component_detail('filters');
        }
    }

    public function search_filters($args){
        $filterRepository=app(FilterRepositoryInterface::class);
        if(array_key_exists('category',$args) && $args['category']->getParent){
            $category=$args['category'];
            $parent_id=$category->getParent->id;
            $categories=[$category->id,$parent_id];
            $filters=$filterRepository->catFilters('getChild',['parent_id'=>0],$categories);
            foreach ($filters as $filter){
                $items=[];
                foreach ($filter->getChild as $value){
                    $items[]=['id'=>$value->id,'title'=>$value->title];
                }
                $args['customItems'][]=[
                    'items'=>$items,
                    'title'=>$filter->title,
                    'param'=>'attribute['.$filter->id.']'
                ];
            }
        }
        return $args;
    }
}
