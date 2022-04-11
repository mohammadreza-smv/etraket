@extends('layouts.mobile')

@section('content')

    <div>

        <div class="profile_item_header order_content_header">
            <div>
                <span>نقد و نظرات من</span>
            </div>
            <a href="{{ url('user/profile') }}">
                <span>بازگشت</span>
                <span class="fa fa-angle-left"></span>
            </a>
        </div>

        @php $jdf=new \App\Lib\Jdf(); @endphp

        <div class="user_comment_list">
            @foreach($comments as $comment)

                <div class="comment_div2 @if($comment->status==1) Accepted @else pending_approval @endif">
                    <div class="comment_header">
                        <div>
                            <span class="comment_title">{{ $comment->title }}</span>
                            <p>
                                <span>در تاریخ</span>
                                {{ $jdf->jdate('d F Y',$comment->time) }}
                            </p>
                        </div>
                        @if($comment->order_id>0)
                            <div class="title-buyer">خریدار</div>
                        @endif

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if($comment->status==0)
                                <div class="alert alert-danger">
                                    در انتظار تایید
                                </div>
                            @endif
                            <span style="padding-top:10px;display: block">ثبت شده در محصول : </span>
                            <a href="{{ url('product/dkp-'.$comment->getProduct->id.'/'.$comment->getProduct->product_url) }}" target="_blank">
                                <p>{{ $comment->getProduct->title }}</p>
                            </a>
                        </div>
                        <div class="col-md-6">
                            {{ $comment->title }}
                            <div class="row">
                                <div class="col-md-6">
                                    @php $advantages=$comment->advantage @endphp
                                    @if(sizeof($advantages)>1)
                                        <span class="evaluation_label">نقاط قوت</span>
                                        <ul class="evaluation_ul advantage">
                                            @foreach($advantages as $advantage)
                                                @if(!empty($advantage))
                                                    <li><span>{{ $advantage }}</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @php $disadvantages=$comment->disadvantage @endphp
                                    @if(sizeof($disadvantages)>1)
                                        <span class="evaluation_label">نقاط ضعف</span>
                                        <ul class="evaluation_ul disadvantage">
                                            @foreach($disadvantages as $disadvantage)
                                                @if(!empty($disadvantage))
                                                    <li><span>{{ $disadvantage }}</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="comment_content">{{ $comment->content }}</div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        @if(sizeof($comments)==0)
            <p style="padding-top: 30px;padding-bottom: 20px;text-align: center">رکوردی برای نمایش یافت نشد</p>
        @endif

    </div>
@endsection
