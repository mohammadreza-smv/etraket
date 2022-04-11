@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت کد های تخفیف','url'=>url('admin/discount')]]])

        @include('discount::_search_form')

        <?php
            $args=[];
            $args['title']=' مدیریت کد های تخفیف';
            $args['route']='admin/discount';
            $args['trashCount']=$trash_discount_count;
            $args['routeParam']='کد تخفیف';
        ?>


        <x-panel-box :args="$args">

            <?php

            \App\Lib\GridView::showTable([
                'dataProvider'=>$discount,
                'columns'=>[
                    ['label'=>'کد تخفیف','attr'=>'code'],
                    ['label'=>'میزان تخفیف','attr'=>function($value){
                        if(!empty($value->amount_discount)){
                            return e( replace_number(number_format($value->amount_discount))).' تومان';
                        }
                        else{
                            return e( replace_number($value->amount_percent)).' درصد';
                        }
                    }],
                    ['label'=>'تاریخ انقضا','attr'=>function($value){
                        $jdf=new \App\Lib\Jdf();
                        return e( $jdf->jdate('Y-n-j',$value->expiry_time) );
                    }]
                ],
                'route_param'=>'discount',
                'tableLabel'=>'کد تخفیف'
            ]);

            ?>

        </x-panel-box>

    </div>

@endsection
