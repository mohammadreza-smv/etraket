@if(isset($followed_product) && sizeof($followed_product)>0)
    <div class="product_box">

        <div class="box_title">
            <h6>جدید ترین محصولات فروشنده های دنبال شده</h6>

            <a href="{{ url('seller/followed/products') }}" class="router-link">
                مشاهده همه محصولات
            </a>
        </div>

        <v-slide-group
            multiple
            show-arrows
        >
            @foreach($followed_product as $key=>$product)
                <?php
                $price1=$product->price+$product->discount_price;
                ?>
                <v-slide-item  :key="{{ $key }}">
                    <a class="router-link" data-component="product-page-skeleton"  href="{{ shop_product_url($product) }}">
                        <div class="product">
                            <div class="product_img_div">
                                <img src="{{ url('files/thumbnails/'.$product->image_url) }}">
                            </div>

                            <p class="title">
                                @if(strlen($product->title)>40)
                                    {{ mb_substr($product->title,0,40).' ... ' }}
                                @else
                                    {{ $product->title  }}
                                @endif
                            </p>
                            <div class="discount_price">

                                @if(!empty($product->discount_price))

                                    <del >
                                        {{ replace_number(number_format($price1))  }}
                                    </del>
                                    <span class="discount-badge">
                                           <?php
                                        $d=($product->price/$price1)*100;
                                        $d=100-$d;
                                        $d=round($d);
                                        ?>
                                           ٪{{ replace_number($d)  }}
                                     </span>
                                @endif

                            </div>

                            <p class="price">
                                {{ replace_number(number_format($product->price)).' تومان'   }}
                            </p>
                        </div>
                    </a>
                </v-slide-item>
            @endforeach
        </v-slide-group>

    </div>
@endif
