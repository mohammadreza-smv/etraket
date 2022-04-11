@extends("users::auth.layouts.$layout")

@section('content')

    <forgot-password>
        <template v-slot:before-forgot-form>
            <a href="{{ url('') }}">
                <img  src="{{ asset(config('shop-info.shop_icon')) }}" class="shop_logo">
            </a>
        </template>
    </forgot-password>

@endsection
