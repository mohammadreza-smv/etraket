@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت انواع ارسال مرسوله','url'=>url('admin/setting/sending_type')]]])

        <?php
            $args=[];
            $args['title']='مدیریت انواع ارسال مرسوله';
            $args['route']='admin/setting/sending_type';
            $args['trashCount']=$trash_send_types_count;
            $args['routeParam']='نوع ارسال';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$send_types,
                'columns'=>[
                    ['label'=>'عنوان','attr'=>'type_name']
                ],
                'route_param'=>'setting/sending_type',
                'tableLabel'=>' نوع ارسال'
            ]);
            ?>
            {{ $send_types->links() }}

        </x-panel-box>


    </div>

@endsection
