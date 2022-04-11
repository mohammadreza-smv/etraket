@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
           ['title'=>'مدیریت مرسوله های','url'=>url('admin/submission')],
           ['title'=>'ثبت کالای مرجوعی','url'=>url('admin/orders/return-product/'.$orderProduct->id)],
         ]])
    <div class="panel">

        <div class="header">
            <span>ثبت کالای مرجوعی</span>
        </div>

       <div class="panel_content">

          <form action="{{ url('admin/orders/return-product/'.$orderProduct->id) }}" method="POST">
              @csrf

              <div class="return_product_box">
                  <div class="product_data">
                      <div>
                          <img src="{{ url('files/thumbnails/'.$orderProduct->getProduct->image_url) }}" >
                      </div>
                      <div>
                          <ul>
                              <li>{{ $orderProduct->getProduct->title }}</li>
                              <li>
                                  <a href="{{ url('admin/orders/'.$orderProduct->getOrder->id) }}" target="_blank">
                                    <span>شماره سفارش : </span> {{ replace_number($orderProduct->getOrder->order_id) }}
                                  </a>
                              </li>
                              <li>
                                  <span>فروشنده : </span>{{ $orderProduct->getSeller->brand_name }}
                              </li>
                              <li>
                                <span>گارانتی : </span>{{ $orderProduct->getWarranty->name }}
                              </li>
                              @if (!empty($orderProduct->getColor->name))
                                <li>
                                  <span>رنگ : </span>{{ $orderProduct->getColor->name }}
                                </li>
                              @endif
                              <li>
                                  <span>قیمت فروش محصول : </span> {{ replace_number(number_format($orderProduct->product_price2)) }} تومان
                              </li>
                              @if($orderProduct->product_count>1)
                                   
                                  <li>
                                    <span>تعداد : </span>
                                    <select name="count">
                                        @for ($i = 1; $i <=$orderProduct->product_count; $i++)
                                            <option value="{{ $i }}">{{ replace_number($i) }}</option>
                                        @endfor
                                   </select>
                                  </li>
                              @endif
                          </ul>
                      </div>
                  </div>

                  {{ Form::select('stockroom_id',$stockroom,null,['class'=>'selectpicker','data-live-search'=>'true']) }}
                  <textarea name="tozihat" placeholder="توضیحات .."></textarea>

                  <button class="btn btn-success">ثبت </button>
              </div>
          </form>

       </div>
    </div>
@endsection
