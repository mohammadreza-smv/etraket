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

    <div>
        <div id="selected_filter_box"></div>
        <mobile-product-box></mobile-product-box>
    </div>

    <div class="mobile_data_box hide_box" id="filter_box">
        <div class="header">
            <span>
                @if(isset($category))
                    {{ $category->name }}
                @else
                    جست و جو
                @endif
            </span>
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
            @if(isset($category) && sizeof($category->getChild)>0)
                <div class="item_box">
                    <div class="title_box">
                        <label>دسته بندی</label>
                    </div>
                    <ul class="search_category_ul">
                        <li class="parent">
                            <a href="{{ url('search/'.$category->url) }}">{{ $category->name }}</a>
                            <ul>
                                @foreach($category->getChild as $cat)
                                    <li>
                                        <a href="{{ url('search/'.$cat->url) }}">{{ $cat->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
            @if(isset($brands) && sizeof($brands)>0)
                <div class="item_box">
                    <div class="title_box">
                        <span class="fa fa-plus-circle"></span>
                        <label>برند</label>
                    </div>
                    <div>
                        <div class="filter_box filter_brand_div">
                            <input type="text" id="brand_search" placeholder="جست و جوی نام برند ...">

                            <ul class="list-inline product_cat_ul">
                                @foreach($brands as $key=>$value)

                                    <li data="brand_param_{{ $value->brand_id }}">
                                        <span class="check_box"></span>
                                        <span class="title">{{ $value->getBrand->brand_name }}</span>
                                        <span class="ename">{{ $value->getBrand->brand_ename }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($filter))
                @foreach($filter as $key=>$value)
                    <div class="item_box">
                        <div class="title_box">
                            <span class="fa fa-plus-circle"></span>
                            <label>{{ $value->title }}</label>
                        </div>
                        <div>
                            <div class="filter_box">
                                <ul class="list-inline product_cat_ul">
                                    @foreach($value->getChild as $key2=>$value2)
                                        <?php
                                        $filter_key='attribute['.$value->id.']';
                                        ?>
                                        <li data="{{ $filter_key }}_param_{{ $value2->id }}">
                                            <span class="check_box"></span>
                                            <span class="title">{{ $value2->title }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @if(isset($colors) && sizeof($colors)>1)
                <div class="item_box">
                    <div class="title_box">
                        <span class="fa fa-plus-circle"></span>
                        <label>رنگ ها</label>
                    </div>
                    <div>
                        <div class="filter_box">
                            <ul class="list-inline product_cat_ul color_filter_ul">
                                @foreach($colors as $key=>$value)
                                    <li data="color_param_{{ $value->id }}">
                                        <div>
                                            <span class="check_box"></span>
                                            <span class="title">{{ $value->name }}</span>
                                        </div>
                                        <div style="background:#<?= $value->code ?>;@if($value->name=='سفید') border:1px solid black @endif" class="color_div"></div>
                                    </li>
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
