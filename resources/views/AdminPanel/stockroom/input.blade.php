@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[
        ['title'=>'مدیریت انبار ها','url'=>url('admin/stockrooms')],
        ['title'=>'لیست ورودی های انبار','url'=>url('admin/stockroom/input')],
        ]])
    <div class="panel">

        <div class="header">
            لیست ورودی های انبار
        </div>

        <div class="panel_content">

            @include('include.Alert')
            <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; $Jdf=new \App\Lib\Jdf() ?>

            <form method="get" class="search_form">
              <div class="form-group">
                    {{ Form::select('stockroom_id',$stockroom,$req->get('stockroom_id',''),['class'=>'selectpicker auto_width']) }}
              </div>
              <button class="btn btn-primary">جست و جو</button>
            </form>
            <a href="{{ url('admin/stockroom/add/input') }}" class="btn btn-success add_btn">
              <span class="fa fa-pencil"></span>
                اضافه کردن محصول انبار
            </a>
            <form method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام انبار</th>
                        <th>اضافه شده توسط</th>
                        <th>تعداد محصول اضافه شده</th>
                        <th>زمان ثبت</th>
                        <th>عمیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stockroomEvent as $key=>$value)
                        @php $i++; @endphp
                        <tr>
                            <td>{{ replace_number($i) }}</td>
                            <td>{{ $value->getStockroom->name }}</td>
                            <td>{{ $value->getUser->name }}</td>
                            <td>{{ replace_number($value->product_count) }}</td>
                            <td>{{ $Jdf->jdate('H:i:s',$value->time) }} / {{ $Jdf->jdate('Y-m-d',$value->time) }}</td>
                            <td>
                                <a href="{{ url('admin/stockroom/input/'.$value->id) }}">
                                    <span data-toggle="tooltip" data-placement="bottom"  title='لیست محصولات موجود در انبار' class="fa fa-ambulance"></span>
                                </a>
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($stockroomEvent)==0)
                        <tr>
                            <td colspan="6">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </form>

            {{ $stockroomEvent->links() }}
        </div>
    </div>

@endsection

