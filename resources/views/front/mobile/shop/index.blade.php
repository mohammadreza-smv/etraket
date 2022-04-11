@extends('front-theme::layouts.mobile-app')


@section('content')

    @includeIf('sliders::mobile')

    @if(sizeof($incredible_offers)>0)
        <img class="incredible_offers_img" src="{{ url('files/images/7a0e5239.png') }}" />
        <div class="index_product_box">
            <div class="product_box">
                <div class="swiper-container products">
                    <div class="swiper-wrapper">
                        @foreach($incredible_offers as $key=>$value)
                            <div class="swiper-slide product">
                                <a href="{{ url('product/dkp-'.$value->getProduct->id.'/'.$value->getProduct->product_url) }}">
                                    <div style="position: relative">
                                        <span class="discount-badge">
                                            <?php
                                              $d=($value->price2/$value->price1)*100;
                                              $d=100-$d;
                                              $d=round($d);
                                            ?>
                                           ٪{{ replace_number($d)  }}
                                        </span>
                                        <img src="{{ url('files/thumbnails/'.$value->getProduct->image_url) }}">
                                    </div>
                                    <p class="title">
                                        @if(strlen($value->getProduct->title)>33)
                                            {{ mb_substr($value->getProduct->title,0,33).' ... ' }}
                                        @else
                                            {{ $value->getProduct->title  }}
                                        @endif
                                    </p>

                                    @if($value->product_number>0)
                                        <del class="price_tag">
                                            {{ replace_number(number_format($value->price1)).' تومان'   }}
                                        </del>
                                        <span class="price price_tag">
                                            {{ replace_number(number_format($value->price2)).' تومان'   }}
                                        </span>
                                       <div class="offers_counter">
                                           <counter second="<?= $value->offers_last_time-time() ?>"></counter>
                                       </div>
                                    @endif

                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="index_product_box">
        @include('include.horizontal_product_list2',['title'=>'جدید ترین محصولات فروشگاه','products'=>$new_products])
    </div>

    <div class="banners_div">
        <img class="banners" src="{{ url('files/images/1000007982.jpg') }}" />
    </div>

    <div class="banners_div">
        <img class="banners" src="{{ url('files/images/1000008130.jpg') }}" />
    </div>
    <div class="index_product_box">
        @include('include.horizontal_product_list2',['title'=>' پرفروش ترین محصولات فروشگاه','products'=>$best_selling_product])
    </div>
@endsection


@section('footer')
    <script>
        var product_slider=new Swiper('.products',{
            slidesPerView:2,
            spaceBetween:10
        });
    </script>
@endsection

@section('seo')
<meta name="description" content="{{ config('shop-info.description') }}"/>
<meta name="keywords" content="{{ config('shop-info.keywords') }}"/>
<meta property="og:site_name" content="{{ config('shop-info.shop_name') }}"/>
<meta property="og:description" content="{{ config('shop-info.description') }}"/>
<meta property="og:title" content="{{ config('shop-info.shop_name') }}"/>
<meta property="og:locale" content="fa_IR"/>
@endsection
