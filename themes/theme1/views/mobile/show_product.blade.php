@extends('front-theme::layouts.mobile-app')

@section('head')
    <link href="{{ url('css/swiper.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div style="position: relative;padding-bottom: 50px">


        <div class="product_item_box margin">
            <div class="product_headline">
                <offer-time></offer-time>
                <h6 class="product_title">
                    {{ $product->title }}
                    @if(!empty($product->ename) && $product->ename!='null') <span>{{ $product->ename  }}</span> @endif
                </h6>
            </div>
            <div class="product_options">
                <div>
                    @includeIf('favourite::short-code')
                    <span class="fa fa-share-alt"></span>
                    <span class="fa fa-line-chart"></span>
                </div>
                <div style="display: flex;align-items: center">
                    <?php
                    $width=0;
                    if($product->score_count>0)
                    {
                        $width=$product->score/($product->score_count*6);
                    }
                    $width=$width*20;
                    ?>
                    <span>{{ replace_number($product->score_count) }} نفر</span>
                    <div class="score">
                        <div class="gray">
                            <div class="red" style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                @if($product->Gallery!=null && sizeof($product->Gallery)>0)
                    @includeIf('gallery::carousels')
                @else
                    <img src="{{ url('files/products/'.$product->image_url) }}" class="product_image">
                @endif

            </div>

            <div class="row">
                <ul class="list-inline product_data_ul">
                    @if($product->getBrand->brand_ename)
                        <li>
                            <span>برند : </span>
                            <a href="{{ url('brand/'.$product->getBrand->brand_ename) }}" class="router-link data_link">
                                <span>{{ $product->getBrand->brand_name }}</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <span>دسته بندی : </span>
                        <a href="{{ url('search/'.$category->url) }}" class="router-link data_link">
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="product_item_box">
            <div style="padding: 20px">
                @if($product->status==1)
                    <div>

                        @includeif('priceVariation::product.params')

                        @includeif('priceVariation::product.detail')

                        @if($product->fake==1)
                            <p class="fake_tag">
                                <v-icon color="red">mdi-alert</v-icon>
                                <span>این محصول توسط تولید کننده اصلی (برند) تولید نشده است</span>
                            </p>
                        @endif
                    </div>
                @else
                    <div class="product_unavailable">
                       <span>
                           @if($product->status==-1)
                               توقف تولید
                           @else
                               ناموجود
                           @endif
                        </span>
                        <p>
                            @if($product->status==-1)
                                متاسفانه تولید و فروش این کالا متوقف شده است. می‌توانید از طریق لیست بالای صفحه، از محصولات مشابه این کالا دیدن نمایید.
                            @else
                                متاسفانه این کالا در حال حاضر موجود نیست. می‌توانید از طریق لیست بالای صفحه، از محصولات مشابه این کالا دیدن نمایید
                                متاسفانه این کالا در حال حاضر موجود نیست. می‌توانید از طریق لیست بالای صفحه، از محصولات مشابه این کالا دیدن نمایید

                                @include('position_view',['name'=>'product_not_available',
                               'type'=>'content'])

                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="product_item_box">
            <important-item theme="mobile"></important-item>
        </div>


        @if($product->status==1)
           @includeIf('priceVariation::product.mobile-list')
        @endif

        @includeIf('themes::widgets.view',['location'=>'mobile_show_product'])

{{--        @includeIf('mobile.show_product_comments')--}}

{{--        @includeIf('mobile.show_product_questions')--}}

        <mobile-vue-chart :product_id="{{ $product->id }}"></mobile-vue-chart>

        <mobile-product-items :product_id="{{ $product->id }}"></mobile-product-items>

        @include('position_view',['name'=>'mobile_product_view','args'=>$product])

    </div>
{{--    @include('mobile.product_item_list')--}}

{{--    @includeIf('shop::share.bottom-box')--}}


@endsection

@section('seo')
    <meta name="description" content="{{ $product->description }}"/>
    <meta name="keywords" content="{{ $product->keywords }}"/>
    <meta property="og:site_name" content="{{ config('shop-info.shop_name') }}"/>
    <meta property="og:description" content="{{ $product->description }}"/>
    <meta property="og:title" content="{{ $product->title }}"/>
    <meta property="og:locale" content="fa_IR"/>
    <meta property="og:image" content="{{  url('files/products/'.$product->image_url) }}"/>
    <meta name="twitter:description" content="{{ $product->description }}"/>
    <meta name="twitter:title" content="{{ $product->title }}"/>
    <meta name="twitter:image" content="{{  url('files/products/'.$product->image_url) }}"/>
@endsection
