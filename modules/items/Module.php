<?php


namespace Modules\items;

use App;
use App\BaseModule;
use Modules\items\Repository\ItemRepositoryInterface;
use View;
class Module extends BaseModule
{
    protected $items=[];

    public function category_index_right_click(){
        return [
            'items'=>[
                'label'=>'ثبت لیست مشخصات فنی',
                'url'=>'category/:id/items',
                'icon'=>'mdi-check'
            ]
        ];
    }

    public function products_index_right_click(){
        return [
            'items'=>[
                'label'=>'ثبت مشخصات فنی',
                'url'=>'products/:id/items',
                'icon'=>'mdi-check'
            ]
        ];
    }

    public function before_show_view($data){
        if(getRouteName()==='filter_list'){
            $repository=app(ItemRepositoryInterface::class);
            if(array_key_exists('category',$data)){
                $this->items=$repository->catItem($data['category']->id);
                $data['items']= $this->items;
            }
        }
        return $data;
    }

    public function add_filter_form(){
        echo view('items::select_item_list',['items'=>$this->items]);
    }

    public function add_filter_data($key){
        $itemValue=request()->get('item_id',array());
        $item_id=array_key_exists($key,$itemValue) ? $itemValue[$key] : 0;
        return [
            'item_id'=>$item_id
        ];
    }

    public function set_user_child_access($access){
        if(array_key_exists('category',$access)){
            $access['category']['access']['items']=['label'=>'مدیریت مشخصات فنی','routes'=>[
                'category.items','category.add_items','item.destroy'
            ]];
        }

        if(array_key_exists('products',$access)){
            $access['products']['access']['items']=['label'=>'ثبت مشخصات فنی محصول','routes'=>[
                'product.items','add.product.items'
            ]];
        }
        return $access;
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName=='show_product' || $routeName=='category_items' || $routeName=='filter_list' || $routeName=='product_items'){
            return vue_component_detail('items');
        }
    }
}
