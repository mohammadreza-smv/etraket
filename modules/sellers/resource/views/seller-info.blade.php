<div class="row order_info" style="background-color: #f6f8fa !important;">
    <div class="col-md-6">
        <ul class="seller_info">
            <li>
                <span>نام و نام خانوادگی : </span>
                <span>{{ $seller->fname.' '.$seller->lname}}</span>
            </li>
            <li>
                <span>شماره موبایل : </span>
                <span>{{ $seller->mobile }}</span>
            </li>
            <li>
                <span>ایمیل : </span>
                <span>{{ $seller->email }}</span>
            </li>
            <li>
                <span>تعداد محصول : </span>
                <span>{{ replace_number($seller->product_count) }}</span>
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <ul class="seller_info">
            <li>
                <span>استان : </span>
                <span>{{ $seller->province->name }}</span>
            </li>
            <li>
                <span>شهر : </span>
                <span>{{ $seller->city->name }}</span>
            </li>
            <li>
                @php
                    $Jdf=new \App\Lib\Jdf();
                    $e=explode(' ',$seller->created_at);
                    $e2=explode('-',$e[0]);
                @endphp
                <span>تاریخ عضویت : </span>
                <span>{{ replace_number($Jdf->gregorian_to_jalali($e2[0],$e2[1],$e2[2],'/')) }}</span>
            </li>
            <li>
                <span>درآمد کل فروشنده : </span>
                <span>
                            @php
                                $price=$seller->total_price - $seller->total_commission;
                            @endphp
                    {{ replace_number(number_format($price)) }} تومان
                        </span>
            </li>
        </ul>
    </div>
</div>
