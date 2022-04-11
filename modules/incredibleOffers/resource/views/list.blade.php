@extends('backend-theme::layout')

@section('content')


    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
        ]])

        @include('incredibleOffers::_search_form')

        <?php
             $args=[];
             $args['title']='مدیریت پیشنهادات شگفت انگیز ';
        ?>

        <x-panel-box :args="$args">


            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$list,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->product->image_url);
                        return '<img src="'.$src.'" class="product_pic">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>function($model){
                        return e($model->product->title);
                    }],
                    ['label'=>'تاریخ شروع','attr'=>function($model){
                        return e(replace_number($model->offers_first_date));
                    }],
                    ['label'=>'تاریخ شروع','attr'=>function($model){
                        return e(replace_number($model->offers_last_date));
                    }],

                ],
                'actions'=>[
                    function($model){
                        $url=url('admin/product/price_variation/'.$model->id.'/edit?product_id='.$model->product_id);
                        return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye-outline</v-icon></a> ';
                    }
                ],
                'route_param'=>'incredible-offers',
                'tableLabel'=>'پیشنهاد شگفت انگیز'
            ],true);
            ?>
        </x-panel-box>


    </div>

@endsection
