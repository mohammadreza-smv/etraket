@extends('front-theme::layouts.mobile.user-panel')

@section('panel-content')

    @php $jdf=new \App\Lib\Jdf();@endphp

    <div>
        <div class="profile_item_header order_content_header">
            <div>
                <span>آدرس ها</span>
            </div>
        </div>


        <input type="hidden" id="lat" value="0">
        <input type="hidden" id="lng" value="0">
        <div style="margin:10px">
            <profile-address :layout="'mobile'"></profile-address>
        </div>

    </div>
@endsection

