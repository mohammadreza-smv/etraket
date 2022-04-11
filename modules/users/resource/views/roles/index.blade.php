@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>
           [['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')]]
       ])


        <?php
            $args=[];
            $args['title']='مدیریت نقش های کاربری';
            $args['route']='admin/userRole';
            $args['trashCount']=$trash_role_count;
            $args['routeParam']='نقش کاربری';
        ?>
        <x-panel-box :args="$args">
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$userRole,
                'columns'=>[
                    ['label'=>'نام نقش','attr'=>'name'],
                    ['label'=>'تعداد کاربر','attr'=>function($model){
                        if($model->userrole_count){
                            return replace_number($model->userrole_count);
                        }
                        else{
                            return  replace_number(0);
                        }
                    }],
                ],
                'actions'=>[
                    function($model){
                        $url=url('admin/userRole/access/'.$model->id);
                        return '<a href="'.$url.'" style="color:black" class="router-link">
                              <v-icon>mdi-lock</v-icon>
                            </a> ';
                    }
                ],
                'tableLabel'=>'نقش کاربری',
                'route_param'=>'userRole'
            ]);
            ?>

            {{ $userRole->links() }}
        </x-panel-box>
    </div>

@endsection
