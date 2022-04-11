@extends('front-theme::layouts.app')

@section('content')

    <desktop-filter-list cat_id="{{ isset($category) ? $category->id : 0 }}" :max_price="{{ $result['max_price'] }}">

        <template v-slot:before-filter-list>
            @if(isset($before_filter))
                @include($before_filter)
            @endif
        </template>

        <template v-slot:before-product-list>

            <div>
                @if(isset($before_products))
                    @include($before_products)
                @endif
            </div>

            <ul class="list-inline map_ul">
                <li>
                    <a class="router-link" href="{{ url('/') }}">فروشگاه</a>
                    @if(isset($category) || (isset($mapLinks) && sizeof($mapLinks)>0)) / @endif
                </li>
                @if(isset($category))
                    @if($category->getParent->getParent->name!="-")
                        <li><a class="router-link" href="{{ url('main/'.$category->getParent->getParent->url)  }}">{{ $category->getParent->getParent->name }}</a> </li>
                    @endif
                    @if($category->getParent->name!="-")
                        <li>  @if($category->getParent->getParent->name!="-")
                                /
                            @endif
                            <a class="router-link" href="{{ url('search/'.$category->getParent->url)  }}">{{ $category->getParent->name }}</a></li>
                    @endif
                    <li>
                        / <a class="router-link" href="{{ url()->current() }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endif

                @if(isset($mapLinks))
                    @foreach($mapLinks as $key=>$value)
                        <li>
                            <a class="router-link" href="{{ $value['link'] }}">{{ $value['title'] }}</a>
                            @if($key!==(sizeof($mapLinks)-1)) / @endif
                        </li>
                    @endforeach
                @endif
            </ul>

        </template>

        <template v-slot:layout="{product}">

           <product-box :product="product" product_url="{{ shop_product_url_theme() }}">
               <template v-slot:begin-search-product-box>
                   @include('position_view',['name'=>'begin_search_product_box'])
               </template>

               <template v-slot:detail>
                   @if(isset($category))
                       @includeIf('productComparison::product-list-check-box')
                   @endif
               </template>

               <template v-slot:end-search-product-box>
                   @include('position_view',['name'=>'end_search_product_box'])
               </template>

           </product-box>

        </template>

        <template v-slot:product-list>

            @foreach($result['product'] as $product)
                <div class="product_div">

                    @include('position_view',['name'=>'begin_search_product_box'])

                    <div class="image_div">
                        <a class="router-link" href="{{ shop_product_url($product) }}">
                            <img class="{{ $product['status']==-1 ? 'stop-production-img' : '' }}" src="{{ url('files/thumbnails/'.$product['image_url']) }}">
                        </a>
                    </div>

                    @if(isset($category))
                        @includeIf('productComparison::product-list-check-box')
                    @endif

                    <div class="product-info">
                        <a class="router-link" href="{{ shop_product_url($product) }}">
                            <p class="product-title">{{ $product['title'] }}</p>
                        </a>

                        @if($product['status']==1 && $product->firstProductPrice!=null)
                            <div class="price">
                                <div class="discount_div">
                                    @if($product->firstProductPrice['price1']!=$product->firstProductPrice['price2'])
                                        <del>
                                            {{ replace_number(number_format($product->firstProductPrice['price1'])) }}
                                        </del>

                                        <?php
                                        $d=getDiscountValue($product->firstProductPrice['price1'],$product->firstProductPrice['price2']);
                                        ?>
                                        <div class="discount-badge">
                                            {{ '٪'.replace_number($d) }}
                                        </div>

                                    @endif

                                </div>

                                <span>{{ replace_number(number_format($product->firstProductPrice['price2'])) }} تومان</span>
                            </div>

                        @else
                            <div class="product_status">
                                <div>
                                    <p class="line"></p>
                                    @if($product['status']==0)
                                        <span>ناموجود</span>
                                    @elseif($product['status']==-1)
                                        <span>توقف تولید</span>
                                    @else
                                        <span>ناموجود</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>

                    @include('position_view',['name'=>'end_search_product_box'])

                </div>
            @endforeach

            @if(sizeof($result['product'])===0)
                    <div class="not_fount_product_message">
                        محصولی برای نمایش یافت نشد
                    </div>
            @endif


            <div class="product-list-paginate">
                <?php
                      $links=$result['product']->links();
                      $links=str_replace('router-link','search-product',$links);
                ?>
                {!! $links !!}
            </div>

        </template>

    </desktop-filter-list>

@endsection

