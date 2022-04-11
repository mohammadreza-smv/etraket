@extends('cart::layouts.order')

@section('content')

    <div>
        <order-steppers>

            <template v-slot:header>
                <img src="{{ asset(config('shop-info.shop_icon')) }}" class="shop_icon">
            </template>

        </order-steppers>

        <order-products>
            @if(isset($address))
                <template v-slot:header>
                    <address-list :data="{{ json_encode($address) }}"></address-list>
                </template>
            @endif

            <template v-slot:checkout-items>

                <?php
                     $cart_price=Session::get('cart_price',0);
                     $final_price=Session::get('final_price',0);
                     $count=Session::get('product_count',0);
                ?>
                <ul style="padding:10px">
                    <li>
                        <div>
                            <span>مبلغ کل </span>
                            <span>({{ replace_number($count) }}) کالا</span>
                        </div>
                        <span class="left">{{ replace_number(number_format($cart_price)) }} تومان</span>
                    </li>

                    <li>
                        <span>هزینه ارسال</span>
                        <span class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="هزینه ارسال مرسولات می‌تواند وابسته به شهر و آدرس گیرنده متفاوت باشد. در صورتی که هر یک از مرسولات حداقل ارزشی برابر با ۱۵۰هزار تومان داشته باشد، آن مرسوله بصورت رایگان ارسال می‌شود."></span>
                        <span class="left" id="total_send_order_price">رایگان</span>
                    </li>

                    <?php
                    $checkoutItems=run_action('checkout_items',[],true);
                    ?>
                    @if(is_array($checkoutItems))
                        @foreach($checkoutItems as $item)
                            <li class="{{ $item['name'] }} {{ $item['type'] }}"  style="display: {{ $item['display'] }}">
                                <span>تخفیف</span>
                                <span class="left" id="{{ $item['name'] }}_value">
                                  {{ $item['value'] }}
                            </span>
                            </li>

                        @endforeach
                    @endif
                </ul>
                <div class="checkout_divider"></div>
                <div class="checkout_content">
                    <p style="color:red">مبلغ قابل پرداخت : </p>
                    <p id="final_price">{{ replace_number(number_format($final_price)) }} تومان</p>
                </div>

            </template>

        </order-products>
    </div>

@endsection
