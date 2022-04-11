<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        .box{
            width: 95%;
            margin: auto;
            direction: rtl;
            text-align: right;
            font-size: 16px;
            font-family: Tahoma;
        }
        .answer_box{
            width:99%;
            border:1px dashed gray;
            padding: 15px;
            background-color:#f6f6f6;
        }
    </style>
</head>
<body>
    <div class="box">

        @if($question->user)
            <h4>
                <span>{{ $question->user->first_name.' '.$question->user->last_name }} </span>
                <span>
                برای پرسش شما پاسخی ارسال شد
            </span>
            </h4>
        @endif

        <p>پاسخ ارسالی</p>
        <div class="answer_box">
            {!! $answer->question !!}
        </div>

        <p>پرسش شما </p>
        <div>
            {!! $question->question !!}
        </div>
        <br>
        @if($question->product)
                <a href="{{ url('product/dkp-'.$question->product->id.'/'.$question->product->product_url) }}">
                    {{ url('product/dkp-'.$question->product->id.'/'.$question->product->product_url)}}
                </a>
        @endif
    </div>
</body>
</html>
