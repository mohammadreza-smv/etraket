@if($product->PriceVariation && sizeof($product->PriceVariation)>0)

    <?php

    $price_variation=isset($price_variation) ? $price_variation : $product->PriceVariation[0];

    $param1_id=$price_variation->param1_id;
    $param1_type=$price_variation->param1_type;

    $param2_id=$price_variation->param2_id;
    $param2_type=$price_variation->param2_type;

    ?>
    @include('position_view',['name'=>'before_shop_variation_detail','args'=>['variation'=>$price_variation]])

    <variation-detail product_id="{{ $product->id }}">

        <template v-slot:default>

            <input type="hidden" data-id="{{ $param1_type }}" id="variation_param1" value="{{ $param1_id }}">

            <input type="hidden" data-id="{{ $param2_type  }}" id="variation_param2" value="{{ $param2_id }}">

            @include('position_view',['name'=>'before_variation_detail','type'=>'content'])

            @if($param1_type)
                <?php
                $file=explode('\\',$param1_type);
                $dir=$file[1];
                $includeFile=$dir.'::variationItems';
                ?>
                @includeIf($includeFile,['num'=>1,'type'=>'item'])
            @endif

            @if($param2_type)
                <?php
                $file=explode('\\',$param2_type);
                $dir=$file[1];
                $includeFile=$dir.'::variationItems';
                ?>
                @includeIf($includeFile,['num'=>2,'type'=>'item'])
            @endif

            <?php
            $send_time=$price_variation->send_time;
            ?>
            @if($send_time>-1)
                <div class="info_item_product">

                    <div>
                        <v-icon>mdi-bus-clock</v-icon>

                        @if($send_time==0)
                            <span>آماده ارسال</span>
                        @else
                            <span>ارسال از {{ replace_number($send_time) }} روز کاری آینده </span>
                        @endif
                    </div>

                    <div>
                        <v-icon onclick="vm.$root.$emit('setSlot','senddetail',' جزئیات ارسال ');">mdi-chevron-left</v-icon>
                    </div>
                </div>
            @endif

            @include('position_view',['name'=>'after_variation_detail','type'=>'content'])

            <?php
            $product_price1=$price_variation->price1;
            $product_price2=$price_variation->price2;
            ?>

            <div class="discount_price">
                    <?php
                        $d=($product_price2/$product_price1)*100;
                        $d=100-$d;
                        $d=round($d);
                    ?>
                   @if($d>0)
                        <span class="price-discount-badge">
                          @if($d>0)
                              ٪{{ replace_number($d)  }}
                          @endif
                        </span>

                   @else
                      <span></span>
                   @endif
                <div>
                    @if($d>0)

                        <del id="product-price">
                            {{ replace_number(number_format($product_price1))  }}
                        </del>
                    @endif
                    <p class="price" id="product-final-price">
                        {{ replace_number(number_format($product_price2)).' تومان'   }}
                    </p>
                </div>

            </div>

        </template>

        <template v-slot:senddetail>

            <p style="padding:15px">
                @if($send_time==0)
                    این کالا در حال حاضر در انبار {{ config('shop-info.shop_name') }} موجود ، آماده پردازش و ارسال است
                @else
                    این کالا در انبار فروشنده موجود است، برای ارسال باید برای مدت زمان ذکر شده منتظر بمانید
                @endif
            </p>

        </template>

    </variation-detail>
@else

@endif
