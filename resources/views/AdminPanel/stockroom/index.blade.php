@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'مدیریت انبار ها','url'=>url('admin/stockrooms')]]])
    <div class="panel">

        <div class="header">
            مدیریت انبار ها

            @include('include.item_table',['count'=>$trash_stockroom_count,'route'=>'admin/stockrooms','title'=>'انبار'])
        </div>

        <div class="panel_content">

            @include('include.Alert')
            <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; ?>

            <form method="get" class="search_form">
                @if(isset($_GET['trashed']) && $_GET['trashed']==true)
                    <input type="hidden" name="trashed" value="true">
                @endif
                <input type="text" name="string" class="form-control" value="{{ $req->get('string','') }}" placeholder="کلمه مورد نظر ..."><button class="btn btn-primary">جست و جو</button>
            </form>
            <form method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>نام انبار</th>
                        <th>عمیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stockrooms as $key=>$value)
                        @php $i++; @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="stockrooms_id[]" class="check_box" value="{{ $value->id }}"/>
                            </td>
                            <td>{{ replace_number($i) }}</td>
                            <td>{{ $value->name }}</td>
                            <td>
                                @if(!$value->trashed())
                                    <a href="{{ url('admin/stockrooms/'.$value->id.'/edit') }}"><span class="fa fa-edit"></span></a>
                                @endif

                                @if($value->trashed())
                                    <span  data-toggle="tooltip" data-placement="bottom"  title='بازیابی انبار' onclick="restore_row('{{ url('admin/stockrooms/'.$value->id) }}','{{ Session::token() }}','آیا از بازیابی این انبار مطمئن هستین ؟ ')" class="fa fa-refresh"></span>
                                @endif

                                <a href="{{ url('admin/stockrooms/'.$value->id) }}">
                                    <span data-toggle="tooltip" data-placement="bottom"  title='لیست محصولات موجود در انبار' class="fa fa-ambulance"></span>
                                </a>
                                @if(!$value->trashed())
                                    <span data-toggle="tooltip" data-placement="bottom"  title='حذف انبار' onclick="del_row('{{ url('admin/stockrooms/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این انبار مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                @else
                                    <span data-toggle="tooltip" data-placement="bottom"  title='حذف  انبار همیشه' onclick="del_row('{{ url('admin/stockrooms/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این انبار مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($stockrooms)==0)
                        <tr>
                            <td colspan="4">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </form>

            {{ $stockrooms->links() }}
        </div>
    </div>

@endsection
