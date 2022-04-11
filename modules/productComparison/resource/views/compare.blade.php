@extends('front-theme::layouts.app')

@section('content')

    <compare-box>
        <p style="padding-top:10px">لیست مقایسه {{ $category->name }}</p>
        <div class="compare_item_list">

            <div class="compare_box">
                <div class="compare_product_gallery">
                    @foreach($products as $key=>$value)

                        <div class="gallery_box">
                            <v-carousel hide-delimiter-background height="180px">
                                @if(sizeof($value->Gallery)>0)
                                    @foreach($value->Gallery as $key2=>$value2)
                                        <v-carousel-item
                                            key="{{ $key2 }}"
                                        >
                                            <img src="{{ url('files/gallery/'.$value2->image_url) }}"  class="compare_gallery_pic">
                                        </v-carousel-item>
                                    @endforeach
                                @else
                                    <v-carousel-item
                                        key="{{ $key }}"
                                    >
                                        <img src="{{ url('files/thumbnails/'.$value->image_url) }}"  class="compare_gallery_pic">
                                    </v-carousel-item>
                                @endif
                            </v-carousel>
                            <div class="title">
                                <a onclick="vm.$root.$emit('send_get_request','{{ shop_product_url($value) }}')">
                                    {{ $value->title }}
                                </a>
                                <p class="price">{{ replace_number(number_format($value->price)) }} تومان</p>
                                <v-btn onclick="vm.$root.$emit('send_get_request','{{ shop_product_url($value) }}')"
                                       color="primary">
                                    مشاهده و خرید محصول
                                </v-btn>

                            </div>
                        </div>
                    @endforeach

                    @for($i=sizeof($products);$i<4;$i++)
                        <div class="compare_add">
                            <button class="add" onclick="vm.$root.$emit('show_compare_products')">
                                <p class="fa fa-plus-circle"></p>
                                <p>برای افزودن کالا به لیست مقایسه کلیک کنید</p>
                            </button>
                            <v-btn class="btn btn-dark"
                                    onclick="vm.$root.$emit('show_compare_products')"
                            >
                                افزودن کالا به لیست مقایسه
                            </v-btn>
                        </div>
                    @endfor
                </div>


                @foreach($items as $key=>$value)
                    <h5 class="compare_title">{{ $value->title }}</h5>
                    <ul class="compare_ul">
                        @foreach($value->getChild as $key2=>$value2)
                            <li class="title">{{ $value2->title }}</li>
                            <li class="value">
                                <div @if(sizeof($products)>0) class="left_border" @endif>
                                    {!! strip_tags( get_item_value(0,$products,$value2->id),'<br>') !!}
                                </div>
                                <div @if(sizeof($products)>1) class="left_border" @endif>
                                    {!! strip_tags( get_item_value(1,$products,$value2->id),'<br>') !!}
                                </div>
                                <div @if(sizeof($products)>2) class="left_border" @endif>
                                    {!! strip_tags( get_item_value(2,$products,$value2->id),'<br>') !!}
                                </div>
                                <div @if(sizeof($products)>3) class="left_border" @endif>
                                    {!! strip_tags( get_item_value(3,$products,$value2->id),'<br>') !!}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>

        </div>

        <compare-product-list :cat_id="{{ $category->id }}"></compare-product-list>
    </compare-box>


@endsection


