@extends('front-theme::layouts.user-panel')

@section('panel-content')
    <?php $args=['title'=>'پیام ها']; ?>
    <?php use App\Lib\Jdf; ?>
    <x-user-panel-box :args="$args">



        <div class="row">


            <div class="messageList" style="width:100%">

                @if(Session::has('add-message'))
                    <v-alert type="success" dismissible>
                        {{ Session::get('add-message') }}
                    </v-alert>
                @endif

                @includeIf('messages::userPanel._searchForm')

                <a href="{{ url('user/profile/messages/create') }}" class="router-link" style="margin-bottom:20px;display: block">
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
                                return '<span class="form_link">'. e($model->from->name).'</span>';
                            }
                            else{
                                return '<span class="form_link">'.e(config('shop-info.shop_name')).'</span>';
                            }
                        },'html'=>true],
                        ['label'=>'دریافت کننده','attr'=>function($model){
                            if($model->to){
                                return '<span class="to_link">'.e($model->to->name).'</span>';
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
                            $url=url('user/profile/messages/'.$model->id);
                            $style=($model->status==-1) ? 'style="color:red"' : "";
                            return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye</v-icon></a> ';
                        }
                    ],
                    'tableCssClass'=>'message_table'
                ],true,true);
                ?>

                {{ $messages->links() }}

            </div>

        </div>

    </x-user-panel-box>


@endsection
