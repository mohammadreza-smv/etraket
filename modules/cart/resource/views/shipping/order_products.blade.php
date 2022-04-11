<v-expansion-panel-header>
    <div class="header_box">

        <div>
            مرسوله {{ replace_number($i) }} از {{ replace_number(get_submission_count($send_order_data,$send_type)) }}
            <span>({{ replace_number(sizeof($data)) }} کالا)</span>
        </div>

        @if(array_key_exists('send_methods',$send_order_data))
            <div>
                نحوه ارسال
                <span>{{ $send_order_data['send_methods'][$sending_method]['send_type_name'] }}</span>
            </div>
        @endif

        <div>
            ارسال از
            <span>
                @if($sending_time==0)
                    آماده ارسال
                @else
                    {{ replace_number($sending_time) }} روز کاری
                @endif
             </span>
        </div>

        @if(array_key_exists('send_methods',$send_order_data))
            <div>
                هزینه ارسال
                <span>
                    @if($submission_info['price_type']==0)

                        @if($submission_info['sending_price']==0)
                            رایگان
                        @else
                            {{ replace_number(number_format($submission_info['sending_price'])).' تومان' }}
                        @endif

                    @else
                        پس کرایه
                    @endif
                </span>
            </div>
        @endif


    </div>
</v-expansion-panel-header>

<v-expansion-panel-content>
    <v-slide-group
        multiple
        show-arrows
    >

        @foreach($data as $key=>$value)
            <v-slide-item  :key="{{ $key }}">
                <div class="product_info_box swiper-slide">

                    <?php
                    $product=$send_order_data['products'][1][$value]['product'];
                    ?>

                    <img src="{{ url('files/thumbnails/'.$product->image_url) }}">

                    <p class="product_title">{{ $product->title }}</p>

                    @if($send_order_data['products'][1][$key]->price_params!=null)

                        @foreach($send_order_data['products'][1][$key]->price_params as $param_key=>$param_value)

                            <p class="product_color">
                                @if(array_key_exists('title',$param_value))
                                    {{ $param_value['title'] }} :
                                @endif
                                {{ $param_value['value'] }}
                            </p>

                        @endforeach

                    @endif

                </div>
            </v-slide-item>
        @endforeach

    </v-slide-group>
</v-expansion-panel-content>
