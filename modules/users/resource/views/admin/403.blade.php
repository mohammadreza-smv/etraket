@extends('backend-theme::layout')

@section('content')




    <div>
        @include('backend-theme::breadcrumb')

        <div>
            <p style="padding-top:100px;text-align:center;font-size:50px">
                <span class="fa fa-exclamation"></span>
            </p>
            <p style="text-align:center;padding-bottom:80px">شما دسترسی لازم برای عملیات جاری را ندارید</p>
        </div>

    </div>
@endsection
