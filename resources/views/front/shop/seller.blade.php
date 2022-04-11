@extends('layouts.shop')

@section('content')

    <div class="row" id="product_box">

        <div class="col-3">

            <div class="item_box" id="filter_div" @if(sizeof($_GET)==0 || (sizeof($_GET)==1) && array_key_exists('page',$_GET)) style="display: none" @endif>
                <div class="title_box">
                    <label>فیلتر های اعمال شده</label>
                    <span id="remove_all_filter">حذف</span>
                </div>
                <div id="selected_filter_box">

                </div>
            </div>
            <div class="item_box">
                <div class="profile_box_header">
                    <div class="profile_avatar"></div>
                </div>
                <div class="profile_info">
                    <span class="brand_name">{{ $seller->brand_name }}</span>
                </div>
            </div>
            @if(sizeof($category))
                <div class="item_box">
                    <div class="title_box">
                        <label>دسته بندی</label>
                        <span class="fa fa-angle-down"></span>
                    </div>
                    <div>
                        <div class="filter_box" style="display: block">
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
                        <label>برند</label>
                        <span class="fa fa-angle-down"></span>
                    </div>
                    <div>
                        <div class="filter_box filter_brand_div" style="display: block">
                            <input type="text" id="brand_search" placeholder="جست و جوی نام برند ...">

                            <ul class="list-inline product_cat_ul">
                                @foreach($brands as $key=>$value)
                                  @if($value->getBrand)
                                     <li data="brand_param_{{ $value->brand_id }}">
                                        <span class="check_box"></span>
                                        <span class="title">{{ $value->getBrand->brand_name }}</span>
                                        <span class="ename">{{ $value->getBrand->brand_ename }}</span>
                                    </li>
                                  @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <div class="item_box">
                <div class="title_box">
                    <label>جست و جو در نتایج:</label>
                </div>
                <div>
                    <input type="text" @if(array_key_exists('string',$_GET)) value="{{ $_GET['string'] }}" @endif id="search_input" placeholder="نام محصول با نام برند مورد نظر خود را بنوسید ...">
                </div>
            </div>

            <div class="item_box toggle_box">
                <div class="toggle-light" id="product_status"></div>
                <span>فقط کالاهای موجود</span>
            </div>

            <div class="item_box toggle_box">
                <div class="toggle-light" id="send_status"></div>
                <span>فقط کالاهای آماده ارسال</span>
            </div>

            <div class="item_box">
               <div class="title_box">
                   <label>محدوده قیمت مورد نظر</label>
                   <span class="fa fa-angle-down"></span>
               </div>
               <div>
                   <div class="filter_box" style="display:block">
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
                       <button class="btn btn-primary" id="price_filter_btn">
                           <span class="fa fa-filter"></span>
                           <span>اعمال محدوده قیمت</span>
                       </button>
                   </div>
               </div>
            </div>

        </div>

        <div class="col-9" style="position:relative">
            <div style="display: flex;justify-content: space-between;align-items: center">
                <ul class="list-inline map_ul">
                    <li>
                        <a href="{{ url('seller/'.$seller->id)  }}">
                            {{ $seller->brand_name }}</a>
                    </li>

                </ul>
                <div id="product_count">
                </div>
            </div>
            <product-box  :compare="'no'" ></product-box>
        </div>

    </div>

@endsection

@section('head')
    <link rel="stylesheet" href="{{ url('css/nouislider.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/toggles-full.css') }}"/>
    <script type="text/javascript" src="{{ url('js/nouislider.min.js') }}"></script>
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
