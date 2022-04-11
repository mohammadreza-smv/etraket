@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محموله ها','url'=>url('admin/packages')]]])


        <?php
        $b1=['title'=>'جست و جو'];
        $b2=['title'=>'مدیریت پرداخت ها'];
        ?>

        <x-panel-box :args="$b1">
            @include('sellers::payment._search')
        </x-panel-box>

        <x-panel-box :args="$b2">
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$payments,
                'columns'=>[
                    [
                        'label'=>'شناسه پرداخت',
                        'attr'=>function($value){
                            return e(replace_number($value->shebase));
                        }],
                    [
                        'label'=>'مبلغ پرداخت شده',
                        'attr'=>function($value){
                            return e(get_price($value->price/10));
                        }
                    ],
                    [
                        'label'=>'زمان ثبت',
                        'attr'=>function($value){
                            $jdf=new \App\Lib\Jdf();
                            return e($jdf->jdate('Y-n-j',$value->time) );
                        }
                    ],
                    [
                        'label'=>'فروشنده',
                        'attr'=>function($value){
                            return e($value->seller->brand_name);
                        }
                    ]
                ]
            ],true,true);

            ?>
            {{ $payments->links() }}
        </x-panel-box>
    </div>

@endsection

