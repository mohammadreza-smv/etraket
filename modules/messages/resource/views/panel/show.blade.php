@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت پیام ها','url'=>url('admin/messages')],
             ['title'=>'جزییات پیام','url'=>url('admin/messages/'.$message->id)],
        ]])

        <?php
             $args=[];
        ?>
        <?php use App\Lib\Jdf;$jdf=new Jdf(); ?>

        <x-panel-box :args="$args">

            <panel-message>

                <x-slot name="header">
                    <div>
                        <?php $to_type=$message->to_type; ?>

                        جزییات پیام - {{ $message->title }}
                        , ارسال شده به
                        @if($message->to)
                            @if($to_type && array_key_exists($to_type,$types))
                                <?php $attr=$types[$to_type]['attr']; ?>
                                <a href="{{ url('admin/'.$types[$to_type]['url_param'].'/'.$message->to->id) }}" class="router-link">
                            <span>
                               {{ $message->to->$attr }}
                             </span>
                                </a>
                            @endif
                        @elseif($message->to==0)
                            <span>
                        {{ config('shop-info.shop_name') }}
                    </span>
                        @endif
                    </div>
                </x-slot>

                <div class="message_content_div">
                    <div class="message_content_header">
                        <div>
                            <?php $from_type=$message->from_type; ?>
                            @if($message->from)
                                @if($to_type && array_key_exists($from_type,$types))
                                    <?php $attr=$types[$from_type]['attr']; ?>
                                    <a href="{{ url('admin/'.$types[$from_type]['url_param'].'/'.$message->from->id) }}" class="router-link">
                                   <span  @if($message->from_id==$message->user_id) class="form_link" @else class="to_link" @endif >
                                       ارسال کننده : {{ $message->from->$attr }}
                                   </span>
                                    </a>
                                @endif
                            @endif
                        </div>
                        <div>
                            {{ $jdf->jdate('H:i:s',$message->time)  }} / {{  $jdf->jdate('Y-n-j',$message->time) }}
                        </div>
                    </div>

                    <div class="content">
                        {!! strip_tags($message->content,'<br>') !!}
                        @if(!empty($message->file))
                            <div  class="attached-file">
                                <span>فایل ضمیمه شده : </span>
                                <a href="{{ url('/files/upload/'.$message->file) }}" target="_blank">
                                    {{ $message->file }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                @foreach($message->getAnswer as $answer)
                    <div class="message_content_div">
                        <div class="message_content_header">
                            <div>
                                <?php $from_type=$answer->from_type; ?>
                                @if($message->from)
                                    @if($to_type && array_key_exists($from_type,$types))
                                        <?php $attr=$types[$from_type]['attr']; ?>
                                        <a href="{{ url('admin/'.$types[$from_type]['url_param'].'/'.$answer->from->id) }}" class="router-link">
                                             <span  @if($answer->from_id==$answer->user_id) class="form_link" @else class="to_link" @endif >
                                              ارسال کننده : {{ $answer->from->$attr }}
                                             </span>
                                        </a>
                                    @endif
                                @endif
                            </div>
                            <div>
                                {{ $jdf->jdate('H:i:s',$answer->time)  }} / {{  $jdf->jdate('Y-n-j',$answer->time) }}
                            </div>
                        </div>

                        <div class="content">
                            {!! strip_tags($answer->content,'<br>') !!}
                            @if(!empty($answer->file))
                                <div  class="attached-file">
                                    <span>فایل ضمیمه شده : </span>
                                    <a href="{{ url('/files/upload/'.$answer->file) }}" target="_blank">
                                        {{ $answer->file }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach


                <div>
                    <span style="color:gray;padding-top:20px;display:block;padding-bottom:10px">ارسال پاسخ</span>

                    <?php
                         $option=['url' =>'admin/messages/addAnswer/'.$message->id];
                         $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);
                    ?>

                    {{ method_field('PUT') }}

                    <?php $form->textarea('content','پاسخ شما',['validate'=>'required','class'=>'total-width']); ?>

                    <?php $form->fileInput('pic','انتخاب فایل',['class'=>'small']); ?>

                    <?php $form->btn('ارسال پاسخ','edit'); ?>

                    {!! Form::close() !!}

                </div>

            </panel-message>

        </x-panel-box>

    </div>

@endsection
