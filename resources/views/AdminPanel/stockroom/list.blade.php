@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[
        ['title'=>'مدیریت انبار ها','url'=>url('admin/stockrooms')],
        ['title'=>'لیست محصولات','url'=>url('admin/stockrooms/'.$stockroom->id)]
        ]])
    <div class="panel">

         @php
             $Jdf=new \App\Lib\Jdf()
         @endphp
        <div class="header">
            لیست محصولات موجود در {{ $stockroom->name }}
        </div>

        <div class="panel_content">

            <form method="get" class="search_form search_item">
                <div class="form-group">
                    {{ Form::select('seller_id',$seller,$req->get('seller_id',''),['class'=>'selectpicker auto_width']) }}
                </div>
                <input type="text" name="search_text" class="form-control" value="{{ $req->get('search_text','') }}" placeholder="نام محصول ..."><button class="btn btn-primary">جست و جو</button>
            </form>


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
                   <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; ?>
                   @foreach ($inventory_lists as $key=>$value)
                       @php $i++; @endphp
                       <tr>
                           <td>{{ replace_number($i) }}</td>
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

                   @if(sizeof($inventory_lists)==0)
                   <tr>
                       <td colspan="7">رکوردی برای نمایش یافت نشد</td>
                   </tr>
                   @endif
                </tbody>
            </table>

            {{ $inventory_lists->links() }}

        </div>
    </div>

@endsection
