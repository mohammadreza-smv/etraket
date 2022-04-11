@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
               ['title'=>'مدیریت رنگ ها','url'=>url('admin/colors')]
        ]])

        @include('colors::_search_form')

        <?php
            $args=[];
            $args['title']='مدیریت رنگ ها';
            $args['route']='admin/colors';
            $args['trashCount']=$trash_color_count;
            $args['routeParam']='رنگ';
        ?>
        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$color,
                'columns'=>[
                    ['label'=>'نام رنگ','attr'=>'name'],
                    ['label'=>'کد رنگ','attr'=>function($model){
                        $colorCode=$model->code;
                        $style=$model->name=='سفید' ? ' color:#000' :'';
                        return '<span class="color-code" style="background:#'.$colorCode.';'.$style.'" >'.$model->code
                            .'</span>';
                    },'html'=>true]
                ],
                'route_param'=>'colors',
                'tableLabel'=>'رنگ'
            ]);
            ?>

            {{ $color->links() }}

        </x-panel-box>

    </div>

@endsection
