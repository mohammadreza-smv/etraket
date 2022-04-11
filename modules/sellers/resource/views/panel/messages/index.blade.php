@extends('sellers::layouts.panel')

@section('content')


    <?php $args=['title'=>'مدیریت پیام ها'] ?>
    <?php $args2=['title'=>'جست و جو'] ?>
    <?php use App\Lib\Jdf; ?>

    <div>

        @include('sellers::panel.breadcrumb',['data'=>[
            ['title'=>'مدیریت پیام ها','url'=>url('sellers/panel/messages')],
        ]])

        <x-seller-panel-box :args="$args2">
            @includeIf('sellers::panel.messages._searchForm')
        </x-seller-panel-box>

        <x-seller-panel-box :args="$args">

            <a href="{{ url('sellers/panel/message/create') }}" class="router-link" style="margin-bottom:20px;display: block">
                <v-btn color="success">
                    <span>ارسال پیام جدید</span>
                </v-btn>
            </a>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$messages,
                'columns'=>[
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'ارسال کننده','attr'=>function($model){
                        if($model->from_id==$model->user_id){
                            return '<span class="form_link">'. e($model->from->brand_name).'</span>';
                        }
                        else{
                            return '<span class="form_link">'.e(config('shop-info.shop_name')).'</span>';
                        }
                    },'html'=>true],
                    ['label'=>'دریافت کننده','attr'=>function($model){
                        if($model->to){
                            return '<span class="to_link">'.e($model->to->brand_name).'</span>';
                        }
                        else{
                            return '<span class="to_link">'.e(config('shop-info.shop_name')).'</span>';
                        }
                    },'html'=>true],
                    ['label'=>'زمان ارسال','attr'=>function($model){
                        $jdf=new Jdf();
                        return e($jdf->jdate('H:i:s',$model->time).' / '.$jdf->jdate('Y-n-j',$model->time));
                    }],
                ],
                'actions'=>[
                    function($model){
                        $url=url('sellers/panel/messages/'.$model->id);
                        $style=($model->status==-1) ? 'style="color:red"' : "";
                        return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye</v-icon></a> ';
                    }
                ],
                'tableCssClass'=>'message_table'
            ],true,true);
            ?>

            {{ $messages->links() }}

        </x-seller-panel-box>
    </div>

@endsection
