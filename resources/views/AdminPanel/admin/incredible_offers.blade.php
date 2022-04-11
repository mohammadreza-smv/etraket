@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'پیشنهاد شگفت انگیز','url'=>url('admin/incredible-offers')]]])
    <div class="panel">

        <div class="header">
            مدیریت محصولات پیشنهاد شگفت انگیز
        </div>

        <div class="panel_content">
            <incredible-offers></incredible-offers>
        </div>
    </div>
@endsection

@section('head')
    <link href="{{ asset('css/js-persian-cal.css') }}" rel="stylesheet">
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('js/js-persian-cal.min.js') }}"></script>
    <script>
       const pcal1= new AMIB.persianCalendar('pcal1');
       const pcal2= new AMIB.persianCalendar('pcal2');
    </script>
@endsection

