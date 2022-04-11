@extends('front-theme::layouts.user-panel')


@section('panel-content')

    <?php $args=['title'=>'آدرس های من']; ?>

    <x-user-panel-box :args="$args">

        <div style="width:100%">

            <div class="profile_address">
                <profile-address>

                    <template v-slot:loading_box>
                        <a href="{{ url('') }}">
                            <img  src="{{ asset(config('shop-info.shop_icon')) }}" class="loading-logo">
                        </a>
                    </template>

                </profile-address>
            </div>

        </div>

    </x-user-panel-box>
@endsection

