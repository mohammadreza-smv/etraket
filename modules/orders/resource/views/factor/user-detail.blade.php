@if($user)
    <div class="info-row">
        <div>
            <span>خریدار : </span>
            <span>{{ $user->first_name }} {{ $user->last_name }}</span>
        </div>

        <div>
            <span>کد ملی : </span>
            <span>{{ $user->national_identity_number }}</span>
        </div>

    </div>
@endif

@if($address)

    <div class="info-row">

        <div>
            <span>آدرس : </span>
            <span>{{ $address->address }}</span>
        </div>

        <div>
            <span>کد پستی : </span>
            <span>{{ replace_number($address->zip_code) }}</span>
        </div>

        <div>
            <span>شماره تماس : </span>
            <span>{{ replace_number($address->mobile) }}</span>
        </div>

    </div>
@endif
