<footer class="c-footer">

    <div class="row">
        <div class="col-6">
            <ul>
                <li>
                    <a href="">نحوه ثبت سفارش</a>
                </li>
                <li>
                    <a href="">رویه ارسال سفارش</a>
                </li>
                <li>
                    <a href="">شیوه های پرداخت</a>
                </li>
            </ul>
        </div>
        <div class="col-6">
            <ul>
                <li>
                    <a href="{{ url('faq') }}">پاسخ به پرسش‌های متداول</a>
                </li>
                <li>
                    <a href="">رویه‌های بازگرداندن کالا</a>
                </li>
                <li>
                    <a href="">شرایط استفاده</a>
                </li>
                <li>
                    <a href="">حریم خصوصی</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <h6>از تخفیف‌ها و جدیدترین‌های {{ config('shop-info.shop_name') }} باخبر شوید</h6>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="آدرس ایمیل خود را وارد کنید">
            <button class="btn btn-success">ارسال</button>
        </div>
    </div>
    <div class="row mojavez">
        <h6>مجوز های فروشگاه</h6>
        <div>
            <img src="{{ url('files/images/enamad.png') }}">
            <img src="{{ url('files/images/BPMLogo.png') }}">
        </div>
    </div>

    <p>
        استفاده از مطالب فروشگاه اینترنتی {{ config('shop-info.shop_name') }} فقط برای مقاصد غیرتجاری و با ذکر منبع بلامانع است. کلیه حقوق این سایت متعلق به (فروشگاه {{ config('shop-info.shop_name') }}) می‌باشد.
    </p>
</footer>
