@extends('front-theme::layouts.app')

@section('content')


    <div class="page-content">

        <ul class="list-inline map_ul" style="margin-bottom:5px !important">
            <li>
                <a class="router-link" href="{{ url('/') }}">فروشگاه</a>
                /
            </li>
            @if($category && $category->getParent->getParent->name!='-')
                <li>
                    <a class="router-link" href="{{ url('main/'.$category->getParent->getParent->url) }}">
                        {{ $category->getParent->getParent->name }}
                    </a>
                    /
                </li>
            @endif
            @if($category &&  $category->getParent->name!='-')
                <li>
                    <a class="router-link" href="{{ url('search/'.$category->getParent->url) }}">
                        {{ $category->getParent->name }}
                    </a>
                    /
                </li>
            @endif
            @if($category)
                <li>
                    <a class="router-link" href="{{ url('search/'.$category->url) }}">
                        {{ $category->name }}
                    </a>
                    /
                </li>
            @endif
            <li>
                <a href="{{ url()->current() }}" class="router-link">
                    {{ $product->title }}
                </a>
            </li>
        </ul>
        <div class="content">

            <div class="product_info">

                <div class="product_image_box">
                    <offer-time></offer-time>
                    <div>
                        <ul class="product_options">

                            <li>
                                @includeIf('favourite::short-code')
                            </li>

                            <li>
                                <desktop-share-box product_id='{{ $product->id }}'
                                                   product_url="{{  shop_product_url($product) }}"
                                                   short_product_url="{{  shop_short_product_url($product) }}"
                                >
                                </desktop-share-box>
                            </li>

                            <li>
                               @includeIf('productComparison::product-page-link')
                            </li>

                            <li>
                                <vue-chart :product_id="{{ $product->id }}"></vue-chart>
                            </li>
                        </ul>

                        <div class="default_product_pic">
                            @if(!empty($product->image_url))
                                <img class="default_pic" src="{{ url('files/products/'.$product->image_url) }}" data-zoom-img="{{ url('files/products/'.$product->image_url) }}">
                            @endif
                        </div>
                        <div class="product_gallery_box">
                            @include('include.Gallery')
                        </div>



                    </div>
                </div>
                <div class="product_data">

                    <div id="zoom_box"></div>
                    <div class="product_headline">
                        <h6 class="product_title">
                            {{ $product->title }}
                            @if(!empty($product->ename) && $product->ename!='null') <span>{{ $product->ename  }}</span> @endif
                        </h6>
                    </div>
                    <div>
                        <ul class="list-inline product_data_ul">
                            @if($product->getBrand->brand_ename)
                                <li>
                                    <span>برند : </span>
                                    <a href="{{ url('brand/'.$product->getBrand->brand_ename) }}" class="data_link">
                                        <span>{{ $product->getBrand->brand_name }}</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <span>دسته بندی : </span>
                                <a href="{{ url('search/'.$category->url) }}" class="data_link">
                                    <span>{{ $category->name }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="row">

                            <div class="col-7">

                                @if($product->status==1)
                                    @includeif('priceVariation::product.params')
                                @endif

                                <important-item></important-item>

                                @if($product->fake==1)
                                    <p class="fake_tag">
                                        <v-icon color="red">mdi-alert</v-icon>
                                        <span>این محصول توسط تولید کننده اصلی (برند) تولید نشده است</span>
                                    </p>
                                @endif

                            </div>
                            <div class="col-5">
                                @if($product->status==1)
                                    <div id="variation_box">
                                        @includeif('priceVariation::product.detail')
                                    </div>
                                @else
                                    <div class="product-unavailable">
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
                                                @include('position_view',['name'=>'product_not_available',
                                               'type'=>'content'])
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($product->status==1)
               @includeIf('priceVariation::product.list')
            @endif

            @includeIf('themes::widgets.view',['location'=>'desktop_show_product'])

            <div id="tab_div">
                @include('front-theme::include.product_page_tabs')
            </div>


            <desktop-gallery :images="{{ json_encode($product->Gallery) }}"></desktop-gallery>

        </div>
    </div>

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

