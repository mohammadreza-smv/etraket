@extends('front-theme::layouts.mobile.user-panel')

@section('panel-content')

    <?php
         $panelMenu=array();
         $panelMenu[0]=['label'=>'اطلاعات شخصی','url'=>'user/profile/additional-info'];
         $panelMenu=CompleteData('user_panel_menu',$panelMenu);
         $args=['title'=>''];
    ?>

    <x-user-panel-box :args="$args">


        <div class="profile_item_list" style="margin:20px 8px">
            @foreach($panelMenu as $key=>$value)
                <a href="{{ url($value['url']) }}" class="router-link">
                    <div class="profile_item_header">
                        <span>{{ $value['label'] }}</span>
                        <v-icon>mdi-chevron-left</v-icon>
                    </div>
                </a>
            @endforeach

            <form method="post" action="{{ url('logout') }}" id="logout_form">@csrf</form>

            <div class="profile_item_header" style="border: 0px" onclick="vm.$root.$emit('send_post_request','{{ url('logout') }}',{})">
                <div>
                    <v-icon>mdi-logout</v-icon>
                    <span>خروج</span>
                </div>
            </div>

        </div>


    </x-user-panel-box>
@endsection
