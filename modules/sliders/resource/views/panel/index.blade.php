@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت اسلایدر ها','url'=>url('admin/sliders')]]])

        <?php
            $args=[];
            $args['title']='مدیریت اسلایدر ها';
            $args['route']='admin/sliders';
            $args['trashCount']=$trash_slider_count;
            $args['routeParam']='اسلایدر';
        ?>

        <x-panel-box :args="$args">

            <?php

            \App\Lib\GridView::showTable([
                'dataProvider'=>$sliders,
                'columns'=>[
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'تصویر','attr'=>function($model){
                        $src=url('files/slider/'.$model->image_url);
                        return '<img src="'.$src.'" class="slide_image" style="margin:10px 0px">';
                    },'html'=>true]
                ],
                'route_param'=>'sliders',
                'tableLabel'=>'اسلایدر'
            ]);

            ?>
            {{ $sliders->links() }}

        </x-panel-box>

    </div>

@endsection
