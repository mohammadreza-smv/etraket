@extends('sellers::layouts.panel')

@section('content')

    <div>

        @include('sellers::panel.statistics.payment_search_form',['req'=>request()])

        <?php
            $args=['title'=>'مدیریت پرداخت ها'];
        ?>

        <x-seller-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$payment,
                'columns'=>[
                    ['label'=>'شناسه پرداخت','attr'=>function($model){
                          return replace_number($model->shenase);
                    }],
                    ['label'=>'مبلغ پرداخت شده','attr'=>function($model){
                        return replace_number(number_format($model->price));
                    }],
                    ['label'=>'زمان ثبت','attr'=>function($model){
                        $jdf=new \App\Lib\Jdf();
                        $time=$jdf->jdate('H:i:s',$model->time).' / '.$jdf->jdate('Y-n-j',$model->time);
                        return e($time);
                    }],
                ],
                'route_param'=>'sellers/panel/payment',
                'tableLabel'=>'پرداخت',
            ],true,true);
            ?>

            {{ $payment->links() }}

        </x-seller-panel-box>
    </div>
@endsection
