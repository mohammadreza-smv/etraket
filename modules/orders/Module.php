<?php

namespace Modules\orders;

use App\BaseModule;
use Modules\orders\Repository\OrdersRepositoryInterface;
use Modules\orders\Repository\SubmissionRepositoryInterface;

class Module extends BaseModule
{
    public function registerComponent($theme,$type){
        $routeName=getRouteName();
        if($routeName=="orders_show" || $routeName=="submissions_show" || $routeName=='admin_index' || config('view.orders_component')=='add'){
            return vue_component_detail('orders');
        }

    }

    public function admin_panel_index(): array
    {
        return [
          [
              'view'=>'orders::widgets.chart',
              'index'=>0,
              'footer'=>'orders::widgets.chart_js'
          ]  ,
          [
               'view'=>'orders::widgets.last_orders',
               'index'=>5,
          ]
        ];
    }

    public function before_show_view($args){
        $routeName=getRouteName();
        if($routeName==='admin_index'){
            $repository=app(OrdersRepositoryInterface::class);
            $args['orders']=$repository->getList(request());

        }
        else if($routeName==='user_profile'){
            config()->set('view.build_component','add');
            $user_id=\Auth::user()->id;
            $repository=app(OrdersRepositoryInterface::class);
            $lastOrder=$repository->userLastOrder(['user_id'=>$user_id]);
            $args['lastOrder']=$lastOrder;
        }
        return $args;
    }



    public function user_panel_menu($menus){
        $menus[]=[
            'label'=>'سفارشات من'  ,
            'icon'=>'mdi-format-list-bulleted',
            'url'=>url('user/profile/orders')
        ];
        return $menus;
    }

    public function user_panel_index(){
        return [
            [
                'view'=>'orders::widgets.user_last_order',
                'index'=>2
            ]
        ];
    }

    public function shop_setting_form(){
        return [
            'after_shop_name'=>'orders::shop_setting'
        ];
    }

    public function order_verify($args){

        $view='orders::userpanel.order-global-info';

        if($args['view']=='mobile.'){
            $view='orders::userpanel.mobile.order-global-info';
        }

        $detail=run_action('payment_verify',[],true,true);
        if(array_key_exists('order',$detail)){
            return [
                'view'=>$view,
                'order'=>$detail['order'],
                'order_link'=>url('user/profile/order/'.$detail['order']->id),
                'status'=>$detail['status'],
                'order_id'=>$detail['order']->id
            ];
        }
        else{
            return [
                'view'=>$view,
                'status'=>'error',
            ];
        }
    }

    public function set_user_access_list($access){
        $access['orders']=[
            'label'=>'سفارشات',
            'access'=>[
                'order_list'=>['label'=>'مدیریت سفارشات','routes'=>['orders.index','orders.show']],
                'change_status'=>['label'=>'تغییر وضعیت سفارش','routes'=>['order.change_status']],
                'order.destroy'=>['label'=>'حذف سفارش','routes'=>['orders.index','orders.destroy']],
                'order.restore'=>['label'=>'بازیابی سفارش','routes'=>['orders.index','orders.restore']],
                'submissions'=>['label'=>'مدیریت مرسوله ها', 'routes'=>['submissions.index','submissions.show','order.factor']],
                'submission_1_send_type'=>['label'=>'مرسوله های تایید شده', 'routes'=>['submissions_1_send_type','submissions.show','order.factor']],
                'submission_2_send_type'=>['label'=>'مرسوله های در حال آماده سازی', 'routes'=>['submissions_2_send_type','submissions.show','order.factor']],
                'submission_3_send_type'=>['label'=>'مرسوله های خارج شده از مرکز پردازش', 'routes'=>['submissions_3_send_type','submissions.show','order.factor']],
                'submission_4_send_type'=>['label'=>'مرسوله های تحویل داده شده به پست', 'routes'=>['submissions_4_send_type','submissions.show','order.factor']],
                'submission_5_send_type'=>['label'=>'مرسوله های دریافت شده امرکز مبادلات پست', 'routes'=>['submissions_5_send_type','submissions.show','order.factor']],
                'submission_6_send_type'=>['label'=>'مرسوله های تحویل داده شده به مشتری', 'routes'=>['submissions_6_send_type','submissions.show','order.factor']],
            ]
        ];

        return $access;
    }
}
