@extends('front-theme::layouts.mobile.user-panel')

@section('panel-content')
    <?php $args=['title'=>'نظرات  شما']; ?>
    <x-user-panel-box :args="$args">
        @php $jdf=new \App\Lib\Jdf(); $scoreType=\Modules\comments\Models\CommentScore::getScoreTypeLabel(); @endphp


        <div class="user_comment_list">
            @foreach($comments as $comment)

                <div class="comment_box @if($comment->status==1) Accepted @else pending_approval @endif">
                    <div class="comment_header_box">
                        <div>
                            <span>
                                @if($comment->status==1)
                                    تایید شده
                                @else
                                    در انتظار تایید
                                @endif
                             </span>
                        </div>
                        <div>
                            <span>ثبت شده </span>
                            <span>در تاریخ</span>
                            <span>{{ $jdf->jdate('d F Y',$comment->time) }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="rating_ul">
                                @foreach(getScoreItem($comment->getScore,$scoreType) as $item)
                                    <li>
                                        <label>{{ $item['label'] }}</label>
                                        <div class="rating" data-rate-digit="{{ $item['type'] }}">
                                            <div class="rating-value" style="width:{{ $item['value']*25 }}%"></div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            @if($comment->order>0)
                                <div class="message_purchased">
                                    <a>
                                        <span class="fa fa-shopping-cart"></span>
                                        خریدار محصول
                                    </a>
                                </div>
                            @endif

                            <span>ثبت شده در محصول : </span>
                            <a href="{{ url('product/dkp-'.$comment->product->id.'/'.$comment->product->product_url) }}" target="_blank">
                                <p>{{ $comment->product->title }}</p>
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
    </x-user-panel-box>
@endsection
