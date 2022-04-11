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

    <div class="brand_info">
        <img src="{{ url('files/upload/'.$brand->brand_icon) }}">
        <p>{{ $brand->brand_name }}</p>
        <p><a href="{{ url('brand/'.$brand->brand_ename) }}">{{ url('brand/'.$brand->brand_ename) }}</a></p>
    </div>

    <div>
        <div id="selected_filter_box"></div>
        <mobile-product-box></mobile-product-box>
    </div>

    <div class="mobile_data_box hide_box" id="filter_box">
        <div class="header">
            <span>{{ $brand->bran_name }}</span>
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
            @if(sizeof($brand->getCat)>0)
                <div class="item_box">
                    <div class="title_box">
                        <label>دسته بندی</label>
                    </div>

                    <ul class="list-inline product_cat_ul">
                        @foreach($brand->getCat as $key=>$value)

                            <li data="brand_param_{{ $value->getCategory->id }}">
                                <span class="check_box"></span>
                                <span class="title">{{ $value->getCategory->name }}</span>
                            </li>
                        @endforeach
                    </ul>
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