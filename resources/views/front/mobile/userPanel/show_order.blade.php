@extends('layouts.mobile')

@section('content')

    @php use App\Lib\Jdf;use App\Order;$Jdf=new Jdf(); $OrderStatus=Order::OrderStatus() @endphp

    <div>
        <div class="profile_item_header order_content_header">
            <div>
                <span>سفارش</span>
                <span>{{ replace_number($order->order_id) }}</span>
            </div>
            <a href="{{ url('user/profile/orders') }}">
                <span>بازگشت</span>
                <span class="fa fa-angle-left"></span>
            </a>
        </div>

        <div class="profile_item order_content">
            <div class="profile_info_row remove_border">
                <span>تحویل گیرنده :‌</span>
                <span>{{ $order->getAddress->name }}</span>
            </div>

            <div class="profile_info_row">
                <span> شماره تماس تحویل گیرنده:</span>
                <span>{{ replace_number($order->getAddress->mobile ) }}</span>
            </div>
            <div class="profile_info_row">
                <span>تعداد مرسوله:</span>
                <span>{{ replace_number(sizeof($order->getOrderInfo)) }}</span>
            </div>
            <div class="profile_info_row">
                <span> مبلغ قابل پرداخت:</span>
                <span>{{ replace_number(number_format($order->price)) }} تومان</span>
            </div>
            <div class="profile_info_row">
                <span>مبلغ کل :</span>
                <span>{{ replace_number(number_format($order->total_price)) }} تومان</span>
            </div>
            <div class="profile_info_row">
                <span>تاریخ ثبت سفارش :‌</span>
                <span>{{ $Jdf->jdate(' j F Y',$order->created_at) }}</span>
            </div>
            @if(!empty($order->gift_value) && $order->gift_value>0)
                <div class="profile_info_row">
                    <span> مبلغ کارت هدیه:</span>
                    <span>{{ replace_number(number_format($order->gift_value)) }} تومان</span>
                </div>
                <div class="profile_info_row">
                    <span>کد کارت هدیه:</span>
                    <span>{{ $order->getGiftCart->code }} </span>
                </div>
            @endif
            @if(!empty($order->discount_value) && $order->discount_value>0)
                <div class="profile_info_row">
                    <span>مبلغ کد تخفیف:</span>
                    <span>{{ replace_number(number_format($order->discount_value)) }} تومان</span>
                </div>
                <div class="profile_info_row">
                    <span>کد تخفیف:</span>
                    <span>{{ $order->discount_code }} </span>
                </div>
            @endif

            <div class="profile_info_row">
                <span> آدرس تحویل گیرنده:</span>
                <span style="max-width: 150px">{{ $order->getAddress->getProvince->name.' '. $order->getAddress->getCity->name.' '. $order->getAddress->address }}</span>

            </div>

            <div class="profile_info_row">
                <span></span>
                <span></span>
            </div>
        </div>

        @foreach($order->getOrderInfo as $key=>$value)
            <div class="profile_item">
                <div class="header">
                    {{ \App\Order::getOrderStatus($value['send_status'],$OrderStatus) }}
                </div>
                @if($value['send_status']==0 &&  $order->pay_status=='ok') @php $value['send_status']=1 @endphp @endif
                <div class="swiper-container order_steps">
                    <div class="swiper-wrapper">
                        @foreach($OrderStatus as $key=>$status)
                            @if($key>-1)
                                <div class="swiper-slide">
                                    <div class="step_div @if($value['send_status']<$key) step_inactive @endif">
                                        <img src="{{ url('files/images/step'.$key.'.svg') }}" @if($key==6)  style="width:55%" @endif/>
                                        <span>{{ $status  }}</span>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="profile_info_row">
                    <span>کد مرسوله:</span>
                    <span>{{replace_number( $value['id'] )}}</span>
                </div>
                <div class="profile_info_row">
                    <span> زمان تحویل:</span>
                    <span>{{ $value['delivery_order_interval'] }}</span>
                </div>
                <div class="profile_info_row">
                    <span>هزینه ارسال:</span>
                    <span>
                         @if($value['send_order_amount']==0)
                            رایگان
                        @else
                            @if($value['send_price_type']==1)
                                پس کرایه - حداقل هزینه
                                {{ replace_number(number_format($value['send_order_amount'])) }} تومان
                            @else
                                {{ replace_number(number_format($value['send_order_amount'])) }} تومان
                            @endif
                        @endif
                    </span>
                </div>
                <div class="profile_info_row">
                    <span> مبلغ این مرسوله:</span>
                    <span>
                         {{ replace_number(number_format($order_data['order_row_amount'][$value->id])) }} تومان
                    </span>
                </div>
                <div class="profile_info_row">
                    <span>  نحوه ارسال:</span>
                    <span style="max-width: 150px">{{ $value['send_type_name'] }}</span>
                </div>
            </div>
            <div class="product_box">
                <div class="swiper-container products" id="order_product_box">
                    <div class="swiper-wrapper">
                        @foreach($order_data['row_data'][$value->id] as $product)
                            <div class="swiper-slide product">
                                <div style="position: relative">
                                    <span class="order_product_count">{{ replace_number($product['product_count']) }}</span>
                                    <img src="{{ url('files/thumbnails/'.$product['image_url']) }}" />
                                </div>
                                <ul>
                                    <li class="title">
                                        {{ $product['title'] }}
                                    </li>
                                    @if($product['color_id']>0)
                                        <li>
                                            @if($product['color_type']==1)
                                                <span> رنگ :‌</span>
                                            @else
                                                <span> سایز :‌</span>
                                            @endif
                                            <span>{{ $product['color_name'] }}</span>
                                        </li>
                                    @endif
                                    <li>
                                        <span>گارانتی :‌ ‌</span>
                                        <span>{{ $product['warranty_name'] }}</span>
                                    </li>

                                    <li class="order_product_price">
                                        {{ replace_number(number_format($product['product_price2']*$product['product_count'])) }} تومان
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}" />
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('js/swiper.min.js') }}"></script>
    <script>
        const swiper=new Swiper('.order_steps',{
            slidesPerView:2,
            spaceBetween:0,
            navigation:{
                nextEl:'.swiper-button-next',
                prevEl:'.swiper-button-prev'
            }
        });
        const swiper2=new Swiper('.products',{
            slidesPerView:2,
            spaceBetween:10,
            navigation:{
                nextEl:'.swiper-button-next',
                prevEl:'.swiper-button-prev'
            }
        });
    </script>
@endsection
