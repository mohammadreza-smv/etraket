@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'آمار فروش','url'=>url('report/sale')]]])

     <div class="panel">

        <div class="header">
            آمار فروش
        </div>

        <div class="panel_content">
            <sale-report></sale-report>

            <table class="table table-bordered table-striped"  style="margin-top:40px">
                <tr>
                    <td style="width:50%">میزان فروش کل</td>
                    <td>{{ replace_number(number_format($totalSale)) }} تومان</td>
                </tr>
                <tr>
                    <td>کمیسون کسر شده</td>
                    <td>{{ replace_number(number_format($commission)) }} تومان</td>
                </tr>
            </table>
        </div>

     </div>
@endsection
