
@extends('layouts.mobile')

@section('head')
    <link rel="stylesheet" href="{{ url('css/nouislider.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/toggles-full.css') }}"/>
    <script type="text/javascript" src="{{ url('js/nouislider.min.js') }}"></script>
@endsection

@section('content')

    <div class="filter_header">
        <button class="filter_btn advanced_search_box">جستجوی پیشرفته</button>
        <button class="filter_btn sort_btn">مرتب سازی</button>
    </div>

    {{-- <div class="brand_info">
        <img src="{{ url('files/upload/'.$brand->brand_icon) }}">
        <p>{{ $brand->brand_name }}</p>
        <p><a href="{{ url('brand/'.$brand->brand_ename) }}">{{ url('brand/'.$brand->brand_ename) }}</a></p>
    </div> --}}

    <div>
        <div id="selected_filter_box"></div>
        <mobile-product-box></mobile-product-box>
    </div>

    <div class="mobile_data_box hide_box" id="filter_box">
        <div class="header">
            <span>{{ $seller->brand_name }}</span>
            <a class="fa fa-close"></a>
        </div>

        <div class="content">
            <div class="filter-bar">
                <button id="remove_all_filter" class="btn btn-secondary">پاک کردن همه</button>
                <div>
                    <div class="toggle-light" id="product_status"></div>
                    <span>فقط کالاهای موجود</span>
                </div>
            </div>

            <div class="item_box">
                <div class="title_box">
                    <span class="fa fa-plus-circle"></span>
                    <label>محدوده قیمت مورد نظر</label>
                </div>
                <div>
                    <div class="filter_box">
                        <div class="range_slider_div">
                            <div id="slider" class="price_rang_slider"></div>
                        </div>
                        <ul class="filter_price_ul">
                            <li>
                                <div>از</div>
                                <div class="price" id="min_price"></div>
                                <div>تومان</div>
                            </li>
                            <li>
                                <div>تا</div>
                                <div class="price" id="max_price"></div>
                                <div>تومان</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="item_box toggle_box">
                <div class="toggle-light" id="send_status"></div>
                <span>فقط کالاهای آماده ارسال</span>
            </div>
            @if(sizeof($category)>0)
                <div class="item_box">
                    <div class="title_box">
                        <label>دسته بندی</label>
                    </div>
                    <div>
                        <div class="filter_box" style="display:block">
                        <ul class="list-inline product_cat_ul">
                           @foreach($category as $key=>$value)
                             @if($value->cat)
                               <li data="category_param_{{ $value->cat_id }}">
                                <span class="check_box"></span>
                                <span class="title">{{ $value->cat->name }}</span>
                               </li>
                             @endif
                           @endforeach
                        </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(sizeof($brands)>0)
                <div class="item_box">
                    <div class="title_box">
                        <label>برند ها</label>
                    </div>
                     <div>
                         <div class="filter_box filter_brand_div">
                            @if(sizeof($brands)>5)
                            <input type="text" id="brand_search" placeholder="جست و جوی نام برند ...">
                            @endif
                            <ul class="list-inline product_cat_ul">
                              @foreach($brands as $key=>$value)
                                 @if($value->getBrand)
                                 <li data="brand_param_{{ $value->brand_id }}">
                                  <span class="check_box"></span>
                                  <span class="title">{{ $value->getBrand->brand_name }}</span>
                                  </li>
                                @endif
                              @endforeach
                            </ul>
                         </div>
                     </div>

                </div>
            @endif

            <div style="padding-bottom:50px"></div>
        </div>

       <div id="filter_link" class="add_product_link">
           <span>جست و جوی پیشرفته</span>
       </div>
    </div>
@endsection

@section('footer')
<script type="text/javascript" src="{{ url('js/toggles.min.js') }}"></script>
<script>
  $("#product_status").toggles({
      type:'Light',
      text:{'on':'','off':''},
      width:50,
      direction:'rtl',
      on:true
  });
  $("#send_status").toggles({
       type:'Light',
       text:{'on':'','off':''},
       width:50,
       direction:'rtl',
       on:true
  });
</script>
@endsection
