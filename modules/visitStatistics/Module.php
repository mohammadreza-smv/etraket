<?php

namespace Modules\visitStatistics;

use Modules\visitStatistics\Models\ProductStatistics;
use Modules\visitStatistics\Models\RouteStatistics;

class Module
{
    public function set_layout_data(){
        new RouteStatistics();
    }

    public function admin_panel_index(): array
    {
        return [
            [
                'view'=>'visitStatistics::chart.month',
                'index'=>1,
            ],
            [
                'view'=>'visitStatistics::chart.week',
                'index'=>0,
            ]
        ];
    }

    public function registerComponent(){
        $route=getRouteName();
        if($route==='admin_index' || $route==='product_visit'){
            return vue_component_detail('visitStatistics');
        }
    }

    public function before_show_view($args){
        $route_name=getRouteName();
        if($route_name==='show_product' && array_key_exists('product',$args)){
            $product_id=$args['product']->id;
            $statistics=new ProductStatistics($product_id);
            $statistics->addData();
        }
    }

    public function products_index_right_click(){
        return [
            'visit'=>[
                'label'=>'آمار بازدید',
                'url'=>'product/visit/:id',
                'icon'=>'mdi-chart-line'
            ]
        ];
    }
}
