@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'مدیریت محموله ها','url'=>url('admin/packages')]]])
    <div class="panel">

        <div class="header">
            مدیریت محموله ها

            @include('include.item_table',['count'=>$trash_packages_count,'route'=>'admin/packages','title'=>'محموله','remove_new_record'=>true])
        </div>

        @php
            $status=[-2=>'ارسال ناقص',-1=>'عدم ارسال',0=>'آماده ارسال',1=>'ارسال شده'];
        @endphp

        <div class="panel_content">

            @include('include.Alert')
            <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; ?>

            <form method="get" class="search_form package_search">
                @if(isset($_GET['trashed']) && $_GET['trashed']==true)
                    <input type="hidden" name="trashed" value="true">
                @endif
                <div class="form-group">
                    {{ Form::select('stockroom_id',$stockroom,$req->get('stockroom_id',''),['class'=>'selectpicker auto_width']) }}
               </div>
                <div class="form-group">
                    {{ Form::select('seller_id',$sellers,$req->get('seller_id',''),['class'=>'selectpicker auto_width']) }}
               </div>
               <div class="form-group">
                   <input type="text" autocomplete="off" name="send_date" class="pdate form-control" id="pcal1" value="{{ $req->get('send_date','') }}" placeholder="تاریخ ارسال محموله">
               </div>
              <button class="btn btn-primary">جست و جو</button>
            </form>
            <form method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>شناسه محموله</th>
                        <th>زمان ارسال</th>
                        <th>تعداد محصول</th>
                        <th>فروشنده</th>
                        <th>وضعیت</th>
                        <th>عمیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($packages as $key=>$value)
                        @php $i++; @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="packages_id[]" class="check_box" value="{{ $value->id }}"/>
                            </td>
                            <td>{{ replace_number($i) }}</td>
                            <td>{{ replace_number($value->send_date) }}</td>
                            <td>{{ replace_number($value->product_count) }}</td>
                            <td>{{ $value->getSeller->brand_name }}</td>
                            <td>{{ $status[$value->status] }}</td>
                            <td>
                                @if(!$value->trashed())
                                   <a href="{{ url('admin/packages/'.$value->id) }}"><span class="fa fa-eye" data-toggle="tooltip" data-placement="bottom"  title='مشاهده جزییات محموله'></span></a>
                                @endif

                                @if($value->trashed())
                                   <span  data-toggle="tooltip" data-placement="bottom"  title='بازیابی محموله' onclick="restore_row('{{ url('admin/packages/'.$value->id) }}','{{ Session::token() }}','آیا از بازیابی این محموله مطمئن هستین ؟ ')" class="fa fa-refresh"></span>
                                @endif

                                @if(!$value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom"  title='حذف محموله' onclick="del_row('{{ url('admin/packages/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این محموله مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                @else
                                <span data-toggle="tooltip" data-placement="bottom"  title='حذف محموله برای همیشه' onclick="del_row('{{ url('admin/packages/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این محموله مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                 @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($packages)==0)
                        <tr>
                            <td colspan="7">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </form>

            {{ $packages->links() }}
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
    </script>
@endsection
