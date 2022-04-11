@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
        ['title'=>'مدیریت انبار ها','url'=>url('admin/stockrooms')],
        ['title'=>'لیست ورودی های انبار','url'=>url('admin/stockroom/input')],
        ['title'=>'ورودی انبار','url'=>url('admin/stockroom/input/'.$input['stockroomEvent']->id)]
        ]])
    <div class="panel">

         @php
             $Jdf=new \App\Lib\Jdf()
         @endphp
        <div class="header">
            محصولات اضافه شده به {{ $input['stockroomEvent']->getStockroom->name }} توسط {{ $input['stockroomEvent']->getUser->name }}

            <div style="margin-left:15px">
                {{ $Jdf->jdate('H:i:s',$input['stockroomEvent']->time) }} / {{ $Jdf->jdate('Y-m-d',$input['stockroomEvent']->time) }}
              <span class="fa fa-calendar"></span>
            </div>
        </div>

        <div class="panel_content">

            <form method="get" class="search_form">
                <input type="text" name="string" class="form-control" value="{{ $req->get('string','') }}" placeholder="نام محصول ..."><button class="btn btn-primary">جست و جو</button>
            </form>
            <a href="{{ url('admin/factor/'.$input['stockroomEvent']->id.'/input') }}" class="btn btn-primary" target="_blank"  style="margin-bottom:20px">نمایش فاکتور</a>
            @if(!empty($input['stockroomEvent']->tozihat))
            <div class="tozihat">
                <span>توضیحات</span>
                {{ $input['stockroomEvent']->tozihat }}
            </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>تصویر محصول</th>
                        <th>عنوان محصول</th>
                        <th>فروشنده</th>
                        <th>گارانتی</th>
                        <th>رنگ</th>
                        <th>تعداد</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($input['stockroom_products'] as $key=>$value)
                       <tr>
                           <td>{{ replace_number(++$key) }}</td>
                           <td>
                             <img src="{{ url('files/thumbnails/'.$value->getProductWarranty->getProduct->image_url) }}" class="product_pic stockroom_product">
                           </td>
                           <td>{{ $value->getProductWarranty->getProduct->title }}</td>
                           <td>{{ $value->getProductWarranty->getSeller->brand_name }}</td>
                           <td>{{ $value->getProductWarranty->getWarranty->name }}</td>
                           <td style="width:150px">
                                @if($value->getProductWarranty->getColor->id>0)
                                   @if($value->getProductWarranty->getColor->type==1)
                                       <span style="background:#{{ $value->getProductWarranty->getColor->code }}" class="color_td">
                                       <span style="color:white">{{ $value->getProductWarranty->getColor->name }}</span>
                                   </span>
                                   @else
                                       <span>سایز : {{ $value->getProductWarranty->getColor->name }}</span>
                                   @endif
                                @endif
                           </td>
                           <td>{{ replace_number($value->product_count) }}</td>
                       </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
