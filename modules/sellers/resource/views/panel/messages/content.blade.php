@extends('sellers::layouts.panel')

@section('content')

    <?php $args=['title'=>'جزییات پیام - '.$message->title]; ?>
    <?php use App\Lib\Jdf;$jdf=new Jdf(); ?>

    <div>

        @include('sellers::panel.breadcrumb',['data'=>[
            ['title'=>'مدیریت پیام ها','url'=>url('sellers/panel/messages')],
            ['title'=>'جزییات پیام','url'=>url('sellers/panel/messages/'.$message->id)],
        ]])

        <x-seller-panel-box :args="$args">

            <div class="message_content_div">

                <div class="user_message_div">
                    <div class="user_message_div_header">
                        <div>
                            @if($message->from_type==$user_type)
                                @if($message->from)
                                    @if($message->from_id==$message->user_id)
                                        <span  @if($message->from_id==$message->user_id) class="form_link" @else class="to_link" @endif >
                                       ارسال کننده : {{ $message->from->brand_name }}
                                       </span>
                                    @else
                                        {{ config('shop-info.shop_name') }}
                                    @endif
                                @endif
                            @else
                                {{ config('shop-info.shop_name') }}
                            @endif
                        </div>
                        <div>
                            {{ $jdf->jdate('H:i:s',$message->time)  }} / {{  $jdf->jdate('Y-n-j',$message->time) }}
                        </div>
                    </div>

                    <div class="message_content">
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
                    <div class="user_message_div">
                        <div class="user_message_div_header">
                            <div>
                                @if($answer->from_type==$user_type)
                                    @if($answer->from)
                                        @if($answer->from_id==$answer->user_id)
                                            <span  @if($answer->from_id==$answer->user_id) class="form_link" @else class="to_link" @endif >
                                       ارسال کننده : {{ $answer->from->brand_name }}
                                       </span>
                                        @else
                                            <span class="to_link">ارسال کننده : {{ config('shop-info.shop_name') }}</span>
                                        @endif
                                    @endif
                                @else
                                    {{ config('shop-info.shop_name') }}
                                @endif
                            </div>
                            <div>
                                {{ $jdf->jdate('H:i:s',$answer->time)  }} / {{  $jdf->jdate('Y-n-j',$answer->time) }}
                            </div>
                        </div>

                        <div class="message_content">
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

            </div>

            <div class="message_form" style="padding:20px 0px">
                <?php
                $option=['url' =>  'sellers/panel/messages/addAnswer/'.$message->id];
                $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
                ?>

                {{ method_field('PUT') }}

                <?php $form->textarea('content','پاسخ شما',['validate'=>'required','class'=>'total-width']); ?>

                <?php $form->fileInput('pic','انتخاب فایل',['class'=>'small']); ?>

                <?php $form->btn('ارسال پاسخ', 'edit'); ?>

                <?php $form->close(); ?>
            </div>

        </x-seller-panel-box>


    </div>
@endsection
