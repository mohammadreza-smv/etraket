@extends('layouts.mobile')

@section('content')

    <?php use App\Lib\Jdf;$jdf=new Jdf(); ?>
    <div class="order_list">
        <span class="profile_menu_title">سفارشات من</span>
        @foreach($orders as $key=>$value)
            <div class="profile_item">
                <div class="profile_item_header">
                    <div>
                        {{ replace_number($value->order_id ) }} |
                        @if($value['pay_status']=='awaiting_payemnt')
                            در انتظار پرداخت
                        @elseif($value['pay_status']=='ok')
                            پرداخت شده
                        @elseif($value['pay_status']=='canceled')
                            لغو شده
                        @else
                            خطا در اتصال به درگاه
                        @endif
                    </div>
                     <a href="{{ url('user/profile/orders/'.$value->id) }}">
                            <span class="fa fa-angle-left"></span>
                     </a>
                </div>
                <div class="profile_info_row">
                    <span>تاریخ ثبت سفارش</span>
                    <span>{{ $jdf->jdate('j F Y',$value->created_at)  }}</span>
                </div>
                <div class="profile_info_row">
                    <span>مبلغ قابل پرداخت</span>
                    <span>{{ replace_number(number_format($value->price)) }} تومان</span>
                </div>
                <div class="profile_info_row">
                    <span>مبلغ کلی</span>
                    <span>{{ replace_number(number_format($value->total_price)) }} تومان </span>
                </div>
            </div>
        @endforeach
        {{ $orders->links() }}
    </div>
@endsection
