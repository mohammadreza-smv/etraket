@extends('backend-theme::layout')

@section('content')

    <div>
           <?php
                $array['users']= 'مدیریت کاربران';
                $array['sellers']= 'مدیریت فروشندگان';
           ?>

           @include('backend-theme::breadcrumb',['data'=>[
                ['title'=>$array[$url_param],'url'=>url('admin/'.$url_param)],
                ['title'=>'مدیریت پیام ها','url'=>url('admin/'.$url_param.'/'.$user->id.'/messages')],
            ]])
           <?php
                $attr=$types[$type]['attr'];
                $args=[];
                $name=$user->$attr!='' ? $user->$attr : $user->mobile;
                $args['title']=' پیام های ارسالی و دریافتی از '.e($name)
            ?>

            <?php use App\Lib\Jdf;$jdf=new Jdf(); ?>
            <?php define('types',$types) ?>


           @include('messages::panel._search_form',['url'=>'admin/users/'.$user->id.'/messages'])

           <x-panel-box :args="$args">
                <panel-message>
                    <a href="{{ url('admin/'.$url_param.'/'.$user->id.'/messages/create') }}" class="router-link" >
                       <v-btn color="success" style="margin-bottom:20px">
                           <span>ارسال پیام به
                                @if($url_param=='users')
                                   کاربر
                               @else
                                   فروشنده
                               @endif
                           </span>
                       </v-btn>
                    </a>


                    <?php
                    \App\Lib\GridView::showTable([
                        'dataProvider'=>$messages,
                        'columns'=>[
                            ['label'=>'عنوان','attr'=>'title'],
                            ['label'=>'ارسال کننده','attr'=>function($model){
                                $from_type=$model->from_type;
                                if($model->from && $from_type && array_key_exists($from_type,types)){
                                    $url_param=types[$from_type]['url_param'];
                                    $url=url('admin/'.$url_param.'/'.$model->from->id);
                                    $attr=types[$from_type]['attr'];
                                    return '<a href="'.$url.'" target="_blank"><span class="form_link">'.e($model->from->$attr).'</span></a>';
                                }
                            },'html'=>true],
                            ['label'=>'دریافت کننده','attr'=>function($model){
                                $to_type=$model->to_type;
                                if($model->to && $to_type && array_key_exists($to_type,types)){
                                    $url_param=types[$to_type]['url_param'];
                                    $url=url('admin/'.$url_param.'/'.$model->to->id);
                                    $attr=types[$to_type]['attr'];
                                    return '<a href="'.$url.'" target="_blank"><span class="to_link">'.e($model->to->$attr).'</span></a>';
                                }
                            },'html'=>true],
                            ['label'=>'زمان ارسال','attr'=>function($model){
                                $jdf=new Jdf();
                                return e($jdf->jdate('H:i:s',$model->time).' / '.$jdf->jdate('Y-n-j',$model->time));
                            }]
                        ],
                        'route_param'=>'messages',
                        'tableLabel'=>'پیام',
                        'actions'=>[
                            function($model){
                                $url=url('admin/messages/'.$model->id);
                                return view('messages::panel.show_icon',['data'=>$model,'url'=>$url])->render();
                            }
                        ]
                    ],true);
                    ?>
                    {{ $messages->links() }}
                </panel-message>
            </x-panel-box>

    </div>

@endsection
