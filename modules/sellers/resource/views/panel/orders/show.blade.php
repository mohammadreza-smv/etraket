@extends('sellers::layouts.panel')


@section('content')


    <div>

        @include('sellers::panel.breadcrumb',['data'=>[
             ['title'=>'مدیریت سفارشات','url'=>url('sellers/panel/orders')],
             ['title'=>'جزییات سفارش','url'=>url('sellers/panel/orders/'.$id)],
        ]])

        <?php
              $args1=['title'=>'جزییات سفارش'];
              $orderStatus=\Modules\orders\Models\Orders::OrderStatus();
        ?>


        <x-seller-panel-box :args="$args1">

            <v-row>

                <v-col md="3" sm="5" cols="12">
                    <img style="width:90%;margin: auto;display: table" src="{{ url('files/thumbnails/'.$order->product->image_url) }}" />
                </v-col>

                <v-col md="9" sm="7"  cols="12">
                    <v-simple-table>
                        <template v-slot:default>
                            <tbody>
                                <tr>
                                     <td>عنوان مححصول</td>
                                     <td>{{ $order->product->title }}</td>
                                </tr>

                                @if($order->param1)
                                    @if($order->param_type1=='Modules\priceVariation\Models\PriceVariationItems')
                                        <tr>
                                            <td>
                                                {{ $order->param1->variation_name }}
                                            </td>
                                            <td>
                                                {{ $order->param1->variation_value }}
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>
                                                @if(property_exists($order->param1_type,'label'))
                                                    {{ $order->param1_type::$label }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $order->param1->name }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif

                                @if($order->param2)
                                    @if($order->param_type2=='Modules\priceVariation\Models\PriceVariationItems')
                                        <tr>
                                            <td>
                                                {{ $order->param2->variation_name }}
                                            </td>
                                            <td>
                                                {{ $order->param2->variation_value }}
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>
                                                @if(property_exists($order->param2_type,'label'))
                                                    {{ $order->param2_type::$label }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $order->param2->name }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif

                                <tr>
                                    <td>وضعیت سفارش</td>
                                    <td>
                                          <?php   $class=$order->send_status<=0 ? 'alert-danger' : 'alert-success'; ?>
                                           @if(array_key_exists($order->send_status,$orderStatus))
                                               <span class="{{ $class }}">{{ $orderStatus[$order->send_status] }}</span>
                                           @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>قیمت محصول</td>
                                    <td>{{ get_price($order->product_price1)  }}</td>
                                </tr>

                                <tr>
                                    <td>قیمت فروش محصول</td>
                                    <td>{{ get_price($order->product_price2)  }}</td>
                                </tr>

                                <tr>
                                    <td>تعداد فروش</td>
                                    <td>{{ replace_number($order->product_count)  }}</td>
                                </tr>

                                <tr>
                                    <td>زمان آماده سازی لازم</td>
                                    <td>{{ replace_number($order->preparation_time)  }} روز </td>
                                </tr>


                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>

            </v-row>

        </x-seller-panel-box>

    </div>

@endsection
