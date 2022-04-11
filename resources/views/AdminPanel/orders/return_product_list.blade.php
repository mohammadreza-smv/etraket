@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'مدیریت محصولات برگشت خورده','url'=>url('admin/orders/return-product')]]])
    <div class="panel">

        <div class="header">
            مدیریت محصولات برگشت خورده
        </div>

        <div class="panel_content">

            @include('include.Alert')
            @include('include.warring')
            <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; ?>

            <form method="get" class="search_form">
                @if(isset($_GET['trashed']) && $_GET['trashed']==true)
                    <input type="hidden" name="trashed" value="true">
                @endif
                <input type="text" name="string" class="form-control" value="{{ $req->get('string','') }}" placeholder="عنوان محصول ..."><button class="btn btn-primary">جست و جو</button>
            </form>
            <form method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>تصویر</th>
                        <th>اطلاعات محصول</th>
                        <th>قیمت فروش</th>
                        <th>عمیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($return_product_list as $key=>$value)
                        @php $i++; @endphp
                        <tr>
                            <td>{{ replace_number($i) }}</td>
                            <td>
                                <img src="{{ url('files/thumbnails/'.$value->getProduct->image_url) }}" class="product_pic">
                            </td>
                            <td>
                                <ul class="return_product_info">
                                    <li>{{ $value->getProduct->title }}</li>
                                    <li>
                                        <span>فروشنده : </span>{{ $value->getSeller->brand_name }}
                                    </li>
                                    <li>
                                      <span>گارانتی : </span>{{ $value->getWarranty->name }}
                                    </li>
                                    @if (!empty($value->getColor->name))
                                      <li>
                                        <span>رنگ : </span>{{ $value->getColor->name }}
                                      </li>
                                    @endif
                                    <li>
                                        <span>تعداد : </span>{{ replace_number($value->product_count) }}
                                    </li>
                                    @if($value->getStockroom)
                                    <li>
                                        <span>اضافه شده به </span>{{ $value->getStockroom->name }}
                                    </li>
                                    @endif
                                    @if(!empty($value->tozihat))
                                    <li>
                                      <div class="alert alert-warning">{{ $value->tozihat }}</div>
                                    </li>
                                    @endif
                                </ul>
                            </td>
                            <td>
                                {{ replace_number(number_format($value->product_price2*$value->product_count)) }} تومان
                            </td>
                            <td>
                                <a href="{{ url('admin/orders/'.$value->getOrder->id) }}" target="_blank">
                                    <span class="fa fa-eye" data-toggle="tooltip" data-placement="bottom"  title='جزییات سفارش'></span>
                                </a>
                                <span data-toggle="tooltip" data-placement="bottom" onclick="show_modal_box('{{ $value->getProduct->title }}',{{ $value->id }})"  title='حذف محصول از لیست' class="fa fa-remove"></span>

                            </td>
                        </tr>

                    @endforeach

                     @if(sizeof($return_product_list)==0)
                        <tr>
                            <td colspan="5">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                     @endif
                    </tbody>
                </table>
            </form>

            {{ $return_product_list->links() }}
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="return_product_box" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">تغییر وضعیت</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ url('admin/orders/return-product') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div id="message"></div>
                    <input type="hidden" name="id" id="product_id">
                    <input type="hidden" name="type" id="output" value="output">
                    <textarea name="tozihat" class="tozihat" placeholder="توضیحات"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">تایید</button>
                </div>
            </form>
          </div>
        </div>
      </div>
@endsection

@section('footer')
    <script>
        show_modal_box=function(title,id)
        {
            document.getElementById('product_id').value=id;
            let message="محصول "+title;
            message=message+" به عنوان محصول مرجوع شده ثبت شده با کلیک روی دکمه تایید وضعیت محصول مجددا به حالت تحویل به مشتری تغییر خواهد کرد";
            $("#message").text(message);
            $("#return_product_box").modal('show');
        }
    </script>
@endsection
