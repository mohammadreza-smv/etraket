@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>
                 [['title'=>'مدیریت فروشندگان','url'=>url('admin/sellers/list')]]])

        <?php
             $args=['remove_new_record'=>true];
             $args['title']='مدیریت فروشندگان';
             $args['route']='admin/sellers/list';
             $args['trashCount']=$trash_seller_count;
             $args['routeParam']='فروشنده';
             $args['items']= [
                  ['label'=>'دریافت خروجی پرداخت','url'=>url('admin/sellers/pay/export'),'icon'=>'mdi-file-excel',
                      'target'=>'_blank'],
                  ['label'=>'ثبت پرداخت ها','url'=>url('admin/sellers/pay/import'),'icon'=>'mdi-credit-card-outline']
             ];
        ?>

        <x-panel-box :args="$args">

            <?php

             \App\Lib\GridView::showTable([
                'dataProvider'=>$sellers,
                'columns'=>[
                    ['label'=>'نام فروشنده','attr'=>function($value){
                        return '<span>'.e($value->fname.' '.$value->lname).'</span>';
                    }],
                    ['label'=>'نام فروشگاه','attr'=>'brand_name'],
                    ['label'=>'شماره موبایل','attr'=>function($value){
                        return e(replace_number($value->mobile));
                    }],
                    ['label'=>'تعداد محصول','attr'=>function($value){
                        return e(replace_number($value->product_count));
                    }],
                    [
                        'label'=>'وضعیت','attr'=>function($value){
                        if ($value->account_status=='active'){
                            return '<div class="alert alert-success">فعال</div>';
                        }
                        elseif ($value->account_status=='Inactive'){
                            return  '<div class="alert alert-secondary">غیر فعال</div>';
                        }
                        elseif ($value->account_status=='reject'){
                            return  '<div class="alert alert-danger">رد شده</div>';
                        }
                        else{
                            return  '<div class="alert alert-warning">در انتظار تایید</div>';
                        }
                    },'html'=>true
                    ],
                    ['label'=>'کمیسون دریافت شده','attr'=>function($value){
                        return e(get_price($value->total_commission));
                    }],
                    ['label'=>'مبلغ قابل واریز','attr'=>function($value){
                        $price=$value->total_price - $value->total_commission - $value->paid_commission;
                        return e(get_price($price));
                    }],
                ],
                'route_param'=>'sellers/list',
                'tableLabel'=>'فروشنده',
                'actions'=>[
                    function($model){
                        $url=url('admin/sellers/list/'.$model->id);
                        return '<a style="padding-left:5px" href="'.$url.'" class="router-link"><v-icon>mdi-eye</v-icon></a>';
                    }
                ]
            ]);
            ?>

            {{ $sellers->links() }}

        </x-panel-box>

    </div>

@endsection
