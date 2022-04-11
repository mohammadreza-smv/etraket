<v-expansion-panels>

    <div class="shipping_data_box  payment-products">

        <?php $i=1;  ?>

        @foreach($send_order_data['product_with_sending_type'][1][$send_type] as $key=>$value)

                @foreach($value as $key2=>$value2)

                    @if($key2=='product_key')

                        <v-expansion-panel :key="{{ $i }}">
                            @includeIf('cart::shipping.order_products',['data'=>$value2,'submission_info'=>null,'sending_time'=>$key])
                        </v-expansion-panel>
                        <?php $i++ ?>
                    @else

                        @foreach($value2 as $key3=>$value3)

                            @if($key3=='product_key')
                                <v-expansion-panel :key="{{ $i }}">
                                    @includeIf('cart::shipping.order_products',[
                                      'data'=>$value3,
                                      'submission_info'=>$value2,
                                      'sending_time'=>$key,
                                      'sending_method'=>$key2
                                  ])
                                </v-expansion-panel>
                                <?php $i++ ?>
                            @endif

                        @endforeach

                    @endif

                @endforeach

        @endforeach

    </div>
</v-expansion-panels>


