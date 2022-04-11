@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت فروشندگان','url'=>url('admin/sellers/list')],
            ['title'=>'مشخصات فروشنده','url'=>url('admin/sellers/list/'.$seller->id)]
        ]])

        <?php
            $b1=['title'=>'مشخصات فروشنده - '.$seller->brand_name];
            $b2=['title'=>'مدارک آپلود شده فروشنده'];
            $b3=['title'=>'محصولات ارائه شده توسط فروشنده'];
        ?>

        <x-panel-box :args="$b1">
            @include('sellers::seller-info')
        </x-panel-box>

        @if($document)
            <x-panel-box :args="$b2">
                @include('sellers::_document')
            </x-panel-box>
        @endif

        <x-panel-box :args="$b3">
            <?php   define('status',get_product_status()) ?>
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$products,
                'columns'=>[
                    [
                        'label'=>'تصویر محصول',
                        'attr'=>function($value){
                            $url=url('files/thumbnails/'.$value->product->image_url);
                            return '<img src="'.e($url).'" class="product_pic">';

                        },'html'=>true],
                    [
                        'label'=>'عنوان محصول',
                        'attr'=>function($value){
                            return e($value->product->title);
                        }],
                    [
                        'label'=>'وضعیت محصول',
                        'attr'=>function($value){
                            if(array_key_exists($value->product->status,status)){
                                $class=($value->product->status==1) ? 'alert-success' : 'alert-warning';
                                return ' <div class="alert '.$class.'" style="font-size:13px;padding:5px 7px;width:120px"> '.e(status[$value->product->status] ).'</div>';
                            }
                        },'html'=>true
                    ]
                ],
                'actions'=>[
                    function($model){
                        $url=get_product_url($model->product);
                        return '<a href="'.$url.'" target="_blank"><span class="fa fa-eye" ></span></a> ';
                    }
                ]
            ],true,true);
            ?>

            {{ $products->links() }}

        </x-panel-box>
    </div>

@endsection
