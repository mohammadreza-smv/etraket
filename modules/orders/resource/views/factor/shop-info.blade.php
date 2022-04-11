<div class="info-row">

    @if(!empty(config('shop-info.seller')))
        <div>
            <span>فروشنده : </span>
            <span>{{ config('shop-info.seller') }}</span>
        </div>
    @endif

    @if(!empty(config('shop-info.NationalID')))
        <div>
            <span> شناسه ملی : </span>
            <span>{{ replace_number(config('shop-info.NationalID')) }}</span>
        </div>
    @endif

    @if(!empty(config('shop-info.registration-number')))
        <div>
            <span>شماره ثبت : </span>
            <span>{{ replace_number(config('shop-info.registration-number')) }}</span>
        </div>
    @endif

    @if(!empty(config('shop-info.economical-number')))
        <div>
            <span> شماره اقتصادی : </span>
            <span>{{ replace_number(config('shop-info.economical-number')) }}</span>
        </div>
    @endif

</div>

<div class="info-row">

    <div style="width: 50%">
        <span>نشانی شرکت : </span>
        <span>{{ config('shop-info.address') }}</span>
    </div>


    <div>
        <span>کدپستی : </span>
        <span>{{ replace_number(config('shop-info.zip-code')) }}</span>
    </div>

    <div>
        <span> تلفن و فکس : </span>
        <span>{{ replace_number(config('shop-info.phone')) }}</span>
    </div>

</div>
