@extends('layouts.mobile')

@section('content')
    <div class="o-collapse">
        <?php
        $sideBarMenu=array();
        $sideBarMenu[0]=['label'=>'اطلاعات شخصی','url'=>'user/profile/personal-info'];
        $sideBarMenu=CompleteData('user_panel_menu',$sideBarMenu);
        ?>
        <div  class="profile_item profile_item_list">
            @foreach($sideBarMenu as $key=>$value)
                <a href="{{ url($value['url']) }}">
                    <div class="profile_item_header">
                        <span>{{ $value['label'] }}</span>
                        <span class="fa fa-angle-left"></span>
                    </div>
                </a>
            @endforeach

            <form method="post" action="{{ url('logout') }}" id="logout_form">@csrf</form>

            <div class="profile_item_header" style="border: 0px" onclick="$('#logout_form').submit()">
                 <span>خروج</span>
            </div>

        </div>
    </div>
@endsection
