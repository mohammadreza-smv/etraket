<v-expansion-panel-header>
    <div>
        <div>
            مرسوله {{ replace_number($i) }} از {{ replace_number(get_submission_count($send_order_data,$send_type)) }}
            <span>({{ replace_number(sizeof($data)) }} کالا)</span>
        </div>
        <div class="send-type">
            @if(array_key_exists('send_methods',$send_order_data))
                <div>
                    نحوه ارسال
                    <span>{{ $send_order_data['send_methods'][$sending_method]['send_type_name'] }}</span>
                </div>
            @endif
        </div>
    </div>
</v-expansion-panel-header>

<v-expansion-panel-content>
    <v-slide-group
    >

        @foreach($data as $key=>$value)
            <v-slide-item  :key="{{ $key }}">
                <div class="product_info_box swiper-slide">

                    <?php
                    $product=$send_order_data['products'][1][$value]['product'];
                    ?>

                    <img src="{{ url('files/thumbnails/'.$product->image_url) }}">

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
